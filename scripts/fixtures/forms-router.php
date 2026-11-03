<?php

/** Router exclusivo de QA local. mail() nativo DEBE estar deshabilitado al arrancar. */
declare(strict_types=1);

if (PHP_SAPI !== 'cli-server' || !in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    http_response_code(404);
    exit;
}

$directorio = getenv('CLX_FORMS_TEST_DIR');
if (!$directorio || !is_dir($directorio) || function_exists('mail')) {
    http_response_code(503);
    exit('QA requires disabled native mail and an isolated temporary directory.');
}

if (!function_exists('mail')) {
    function mail(string $destino, string $asunto, string $cuerpo, $cabeceras = '', string $parametros = ''): bool
    {
        $directorio = getenv('CLX_FORMS_TEST_DIR');
        $modo = trim(file_get_contents($directorio . '/modo.txt'));
        $principal = $destino === MAIL_TO_PRIMARY;
        $html = str_contains($cabeceras, 'text/html');
        $aceptado = match ($modo) {
            'total-failure' => false,
            'primary-failure' => !$principal,
            'copy-failure' => $destino !== MAIL_TO_COPY,
            'copies-failure' => $principal,
            'fallback' => !$html,
            default => true,
        };
        file_put_contents($directorio . '/correo.jsonl', json_encode([
            'role' => $principal ? 'primary' : ($destino === MAIL_TO_COPY ? 'copy' : 'internal'),
            'html' => $html, 'subject' => $asunto, 'body' => $cuerpo,
            'headers' => $cabeceras, 'accepted' => $aceptado,
        ], JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX);
        return $aceptado;
    }
}

$ruta = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($ruta === '/contact.html') {
    require dirname(__DIR__, 2) . '/contact-page.php';
    return true;
}
$modo = trim(file_get_contents($directorio . '/modo.txt'));
if ($ruta === '/assets/js/forms-security.js' && $modo === 'helper-failure') {
    header('Cache-Control: no-store');
    http_response_code(404);
    return true;
}
if ($ruta === '/form-token.php' && $modo === 'token-failure') {
    header('Content-Type: application/json');
    http_response_code(503);
    echo '{"success":false,"errorMessage":"QA: token unavailable"}';
    return true;
}
if (in_array($ruta, ['/contact.php', '/reservation.php'], true) && $modo === 'invalid-json') {
    // Simula una respuesta rota después de la aceptación sin invocar transporte real.
    ob_start(static fn (string $contenido): string => 'QA: invalid JSON response');
}
if (in_array($ruta, ['/contact.php', '/reservation.php'], true) && $modo === 'invalid-contract') {
    ob_start(static fn (string $contenido): string => '{"success":"false","message":"QA: invalid contract"}');
}
if (in_array($ruta, ['/contact.php', '/reservation.php', '/form-token.php'], true)) {
    require dirname(__DIR__, 2) . $ruta;
    return true;
}
return false;
