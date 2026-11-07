<?php

/** Transporte exclusivo de QA FastCGI; no se empaqueta ni envía correo real. */
declare(strict_types=1);

$directorioEnsayo = getenv('CLX_APACHE_TEST_DIR');
if (
    PHP_SAPI !== 'cgi-fcgi' || function_exists('mail') || !$directorioEnsayo
    || !is_dir($directorioEnsayo)
    || !in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)
) {
    http_response_code(503);
    exit('Isolated QA transport unavailable.');
}

if (!function_exists('mail')) {
    function mail(string $destino, string $asunto, string $cuerpo, $cabeceras = '', string $parametros = ''): bool
    {
        $directorio = getenv('CLX_APACHE_TEST_DIR');
        $modo = trim(file_get_contents($directorio . '/modo.txt'));
        $principal = $destino === MAIL_TO_PRIMARY;
        $aceptado = match ($modo) {
            'total-failure' => false,
            'copies-failure' => $principal,
            default => true,
        };
        // Sin destinatarios, cuerpos, cabeceras, tokens ni datos del visitante.
        file_put_contents($directorio . '/correo.jsonl', json_encode([
            'principal' => $principal, 'aceptado' => $aceptado,
        ]) . "\n", FILE_APPEND | LOCK_EX);
        return $aceptado;
    }
}
