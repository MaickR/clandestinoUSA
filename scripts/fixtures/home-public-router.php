<?php

/** Fixture de HTTP local: comprueba PHP, no interpreta reglas de Apache. */
declare(strict_types=1);

if (PHP_SAPI !== 'cli-server' || !in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    http_response_code(404);
    exit;
}

$raiz = dirname(__DIR__, 2);
$ruta = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
if (preg_match('~^/(?:includes|docs|scripts)(?:/|$)|^/\.home-public-enabled$~', $ruta)) {
    http_response_code(403);
    return true;
}
if ($ruta === '/') {
    if (is_file($raiz . '/.home-public-enabled') || getenv('CL_HOME_PUBLIC_REVIEW') === '1') {
        require $raiz . '/home.php';
    } else {
        readfile($raiz . '/index.html');
    }
    return true;
}
if ($ruta === '/index.html') {
    if (is_file($raiz . '/.home-public-enabled')) {
        header('X-Robots-Tag: noindex, follow');
    }
    readfile($raiz . '/index.html');
    return true;
}
if ($ruta === '/contact.html') {
    require $raiz . '/contact-page.php';
    return true;
}
return false;
