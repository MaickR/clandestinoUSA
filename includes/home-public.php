<?php

declare(strict_types=1);

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}

/** El marcador se crea solo durante un release autorizado; nunca por una petición. */
function homePublicaHabilitada(): bool
{
    return is_file(dirname(__DIR__) . '/.home-public-enabled');
}

/** Ensayo local explícito, sin abrir el anfitrión en Apache ni crear el marcador. */
function revisionLocalHomePublica(): bool
{
    return PHP_SAPI === 'cli-server'
        && getenv('CL_HOME_PUBLIC_REVIEW') === '1'
        && in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
}

/** Una URL canónica fija evita derivar metadatos de Host o parámetros no confiables. */
function homePublicaIndexable(string $origen): bool
{
    $host = strtolower($_SERVER['HTTP_HOST'] ?? '');
    $https = ($_SERVER['HTTPS'] ?? '') === 'on'
        || strtolower($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';

    return homePublicaHabilitada() && $host === parse_url($origen, PHP_URL_HOST) && $https;
}

/** Versiona únicamente las entradas reales del build; falla si el paquete está incompleto. */
function recursoHomeVersionado(string $ruta): string
{
    if (!in_array($ruta, ['/assets/css/home.css', '/assets/js/dist/main.js'], true)) {
        throw new InvalidArgumentException('Recurso de Home no admitido.');
    }
    $archivo = dirname(__DIR__) . $ruta;
    if (!is_file($archivo) || !is_readable($archivo)) {
        throw new RuntimeException('El paquete de Home está incompleto.');
    }
    $version = hash_file('sha256', $archivo);
    if ($version === false) {
        throw new RuntimeException('No se pudo versionar el recurso de Home.');
    }

    return $ruta . '?v=' . substr($version, 0, 16);
}

/** Restaurant utiliza exclusivamente los datos compartidos y visibles del negocio. */
function datosEstructuradosHome(array $sitio, array $contacto): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Restaurant',
        '@id' => $sitio['origen'] . '/#restaurant',
        'name' => $sitio['nombre'],
        'url' => $sitio['origen'] . '/',
        'image' => $sitio['origen'] . '/assets/images/banner-the_clandestino_1.png',
        'telephone' => substr($contacto['telefono']['url'], 4),
        'address' => $contacto['direccionPostal'],
        'openingHoursSpecification' => [$contacto['horarioEstructurado']],
        'servesCuisine' => 'Spanish',
        'hasMenu' => $sitio['origen'] . '/menu.html',
    ];
}
