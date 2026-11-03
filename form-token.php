<?php

/** Token de sesión para los documentos HTML estáticos existentes. */
declare(strict_types=1);

require_once __DIR__ . '/includes/formularios.php';

ini_set('display_errors', '0');
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, private, max-age=0');
header('X-Content-Type-Options: nosniff');
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    header('Allow: GET');
    responderFormulario(405, ['success' => false, 'errorMessage' => 'Method not allowed']);
}
if (!origenFormularioValido()) {
    responderFormulario(403, ['success' => false, 'errorMessage' => 'Invalid form origin.']);
}
iniciarSesionFormulario();
try {
    responderFormulario(200, ['success' => true, 'token' => tokenFormulario()]);
} catch (Throwable $error) {
    error_log('[formularios] token_unavailable');
    responderFormulario(503, ['success' => false, 'errorMessage' => 'Form unavailable. Please call +1 408-609-0027.']);
}
