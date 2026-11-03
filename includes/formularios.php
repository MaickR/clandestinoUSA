<?php

/** Utilidades compartidas exclusivamente por los dos formularios legacy. */
declare(strict_types=1);

function responderFormulario(int $codigo, array $datos): void
{
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function origenesFormulario(): array
{
    $origenes = ['https://theclandestinousa.com', 'https://www.theclandestinousa.com'];
    // La excepción HTTP solo existe en el servidor PHP local, nunca en Apache.
    if (PHP_SAPI === 'cli-server' && in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
        $puerto = (int) ($_SERVER['SERVER_PORT'] ?? 0);
        $sufijo = $puerto === 80 ? '' : ':' . $puerto;
        $origenes[] = 'http://127.0.0.1' . $sufijo;
        $origenes[] = 'http://localhost' . $sufijo;
        // Puerto fijo de BrowserSync en gulpfile.mjs; no se toma de Host ni del proxy.
        $origenes[] = 'http://127.0.0.1:3000';
        $origenes[] = 'http://localhost:3000';
    }
    return $origenes;
}

function origenFormularioValido(): bool
{
    if (($_SERVER['HTTP_SEC_FETCH_SITE'] ?? '') === 'cross-site') {
        return false;
    }
    foreach (['HTTP_ORIGIN', 'HTTP_REFERER'] as $cabecera) {
        if (!isset($_SERVER[$cabecera])) {
            continue;
        }
        $valor = $_SERVER[$cabecera];
        $partes = parse_url($valor);
        if (
            !is_array($partes) || !isset($partes['scheme'], $partes['host'])
            || isset($partes['user']) || isset($partes['pass'])
            || preg_match('/[\x00-\x20\x7f\\\\]/', $valor)
        ) {
            return false;
        }
        $esquema = strtolower($partes['scheme']);
        $puerto = $partes['port'] ?? ($esquema === 'https' ? 443 : 80);
        $sufijo = ($esquema === 'https' && $puerto === 443) || ($esquema === 'http' && $puerto === 80)
            ? '' : ':' . $puerto;
        $origen = $esquema . '://' . strtolower($partes['host']) . $sufijo;
        if (!in_array($origen, origenesFormulario(), true)) {
            return false;
        }
        if ($cabecera === 'HTTP_ORIGIN' && (isset($partes['path']) || isset($partes['query']) || isset($partes['fragment']))) {
            return false;
        }
    }
    // Navegadores que omiten ambas cabeceras siguen necesitando el token de sesión.
    return true;
}

function iniciarSesionFormulario(): void
{
    ini_set('display_errors', '0');
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, private, max-age=0');
    header('X-Content-Type-Options: nosniff');
    header('Vary: Cookie');
    $esLocal = PHP_SAPI === 'cli-server'
        && in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
    // Secure en hosting incluso con TLS terminado en Cloudflare; no se confía en X-Forwarded-*.
    session_name('clx_forms');
    if (!session_start([
        'use_strict_mode' => 1,
        'use_only_cookies' => 1,
        'use_trans_sid' => 0,
        'cookie_httponly' => true,
        'cookie_secure' => !$esLocal,
        'cookie_samesite' => 'Lax',
        'cookie_path' => '/',
        'cookie_domain' => '',
    ])) {
        error_log('[formularios] session_unavailable');
        responderFormulario(503, ['success' => false, 'errorMessage' => 'Form unavailable. Please call +1 408-609-0027.']);
    }
}

function tokenFormulario(): string
{
    if (!isset($_SESSION['csrf_formularios'])) {
        $_SESSION['csrf_formularios'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_formularios'];
}

function verificarSolicitudFormulario(): void
{
    $token = $_POST['csrf_token'] ?? null;
    if (
        !origenFormularioValido() || !is_string($token)
        || !isset($_SESSION['csrf_formularios'])
        || !hash_equals($_SESSION['csrf_formularios'], $token)
    ) {
        responderFormulario(403, [
            'success' => false,
            'error' => 'security',
            'errorMessage' => 'Your form session could not be verified. Refresh the page and try again.',
        ]);
    }
    foreach ($_POST as $campo => $valor) {
        $valores = $campo === 'diet' && is_array($valor) ? $valor : [$valor];
        foreach ($valores as $texto) {
            if (!is_string($texto) || !mb_check_encoding($texto, 'UTF-8') || preg_match('/[\x00-\x08\x0b\x0c\x0e-\x1f\x7f]/', $texto)) {
                responderFormulario(422, ['success' => false, 'error' => 'validation', 'errorMessage' => 'Invalid form data.']);
            }
        }
    }
}

function escaparCorreo(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function fechaSolicitudReserva(string $fecha, string $hora, ?DateTimeImmutable $ahora = null): ?DateTimeImmutable
{
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/D', $fecha) || !preg_match('/^\d{2}:\d{2}$/D', $hora)) {
        return null;
    }
    $zona = new DateTimeZone('America/Los_Angeles');
    $solicitud = DateTimeImmutable::createFromFormat('!Y-m-d H:i', $fecha . ' ' . $hora, $zona);
    $errores = DateTimeImmutable::getLastErrors();
    if (
        !$solicitud || ($errores !== false && ($errores['warning_count'] || $errores['error_count']))
        || $solicitud->format('Y-m-d H:i') !== $fecha . ' ' . $hora
        || substr($fecha, 0, 4) === '0000'
    ) {
        return null;
    }
    $hoy = ($ahora ?? new DateTimeImmutable('now', $zona))->setTimezone($zona)->setTime(0, 0);
    // Hoy sigue permitido: es una solicitud pendiente, no disponibilidad ni confirmación.
    return $solicitud < $hoy ? null : $solicitud;
}

function enviarNotificacionesFormulario(string $formulario, string $asunto, string $html, string $plano, string $respuesta): bool
{
    $id = bin2hex(random_bytes(8));
    $asunto = mb_encode_mimeheader(str_replace(["\r", "\n"], ' ', $asunto), 'UTF-8', 'B', "\r\n");
    $respuesta = str_replace(["\r", "\n"], '', $respuesta);
    $destinatarios = ['primary' => MAIL_TO_PRIMARY, 'copy' => MAIL_TO_COPY, 'internal' => MAIL_TO_BCC];
    foreach ($destinatarios as $rol => $direccion) {
        $cabeceras = implode("\r\n", [
            'From: ' . mb_encode_mimeheader(MAIL_FROM_NAME, 'UTF-8', 'B') . ' <' . MAIL_FROM . '>',
            'Reply-To: ' . $respuesta,
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
            'X-Mailer: ClandestinoUSA/R1',
        ]);
        $aceptado = @mail($direccion, $asunto, $html, $cabeceras, '-f' . MAIL_FROM);
        $alternativa = !$aceptado;
        if (!$aceptado) {
            $cabeceras = 'From: ' . MAIL_FROM . "\r\nReply-To: " . $respuesta
                . "\r\nMIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8"
                . "\r\nContent-Transfer-Encoding: 8bit";
            $aceptado = @mail($direccion, $asunto, $plano, $cabeceras);
        }
        // Solo correlación, formulario, rol y resultado; sin direcciones ni contenido personal.
        error_log('[formularios] ' . json_encode([
            'id' => $id, 'form' => $formulario, 'role' => $rol,
            'accepted' => $aceptado, 'plain_fallback' => $alternativa,
        ]));
        // Si falla el principal no se procesan copias: un error no oculta una copia ya aceptada.
        if ($rol === 'primary' && !$aceptado) {
            return false;
        }
    }
    return true;
}
