<?php

// La revisión local no activa la Home pública ni permite acceso remoto al preview.
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store, max-age=0');
if (PHP_SAPI !== 'cli-server' || !in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    http_response_code(404);
    exit;
}
require __DIR__ . '/includes/site.php';
require_once __DIR__ . '/includes/home-public.php';
$esVistaPreviaHome = true;
$rutasNavegacion['Home'] = '/home-preview.php';
$destinoActivo = 'Home';
$carritoNavegacion = ['destino' => '#carrito-preview'];
$mostrarAccesoNavegacion = true;
$robotsHome = 'noindex, nofollow';
try {
    $cssHome = recursoHomeVersionado('/assets/css/home.css');
    $jsHome = recursoHomeVersionado('/assets/js/dist/main.js');
} catch (Throwable $error) {
    error_log('[home] preview_document_unavailable');
    http_response_code(503);
    echo '<p>Page unavailable. Please try again later.</p>';
    exit;
}
require __DIR__ . '/includes/home-document.php';
