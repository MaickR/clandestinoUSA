<?php

/** Conserva /contact.html e inserta únicamente el token para navegación sin JavaScript. */
declare(strict_types=1);

if (parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) !== '/contact.html') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/includes/formularios.php';

iniciarSesionFormulario();
header('Content-Type: text/html; charset=utf-8');
try {
    $documento = file_get_contents(__DIR__ . '/contact.html');
    $campo = '<input type="hidden" name="csrf_token" id="clx-csrf-token" value="" />';
    if ($documento === false || substr_count($documento, $campo) !== 1) {
        throw new RuntimeException('Marcador del formulario ausente');
    }
    echo str_replace($campo, str_replace('value=""', 'value="' . tokenFormulario() . '"', $campo), $documento);
} catch (Throwable $error) {
    error_log('[formularios] contact_document_unavailable');
    http_response_code(503);
    echo '<p>Form unavailable. Please call +1 408-609-0027.</p>';
}
