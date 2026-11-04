<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/home-public.php';
header('Cache-Control: no-store, max-age=0');
header('X-Robots-Tag: noindex, nofollow');
if (!homePublicaHabilitada() && !revisionLocalHomePublica()) {
    http_response_code(404);
    exit;
}
if (parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) === '/home.php') {
    header('Location: /', true, 301);
    exit;
}
if (parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) !== '/') {
    http_response_code(404);
    exit;
}

$esVistaPreviaHome = false;
require __DIR__ . '/includes/site.php';
$rutasNavegacion['Home'] = '/';
$rutasNavegacion['Experiences'] = '/#private-events';
$enlacesPieDescubrir['Private Experiences'] = '/#private-events';
// La query evita reutilizar antiguos 301 de /index.html guardados por clientes.
$rutaReserva = '/index.html?legacy=1#reservation';
$mostrarAccesoNavegacion = false;
$carritoNavegacion = [];
$destinoActivo = 'Home';
try {
    $cssHome = recursoHomeVersionado('/assets/css/home.css');
    $jsHome = recursoHomeVersionado('/assets/js/dist/main.js');
    $jsonHome = json_encode(
        datosEstructuradosHome($datosSitio, $datosContacto),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP
        | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR
    );
} catch (Throwable $error) {
    error_log('[home] public_document_unavailable');
    http_response_code(503);
    echo '<p>Page unavailable. Please try again later.</p>';
    exit;
}
$robotsHome = homePublicaIndexable($datosSitio['origen']) ? 'index, follow, max-image-preview:large' : 'noindex, nofollow';
header('X-Robots-Tag: ' . $robotsHome);
header('Content-Type: text/html; charset=utf-8');
require __DIR__ . '/includes/home-document.php';
