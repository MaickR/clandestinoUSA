<?php

/** Casos deterministas de calendario civil del restaurante; no realiza envíos. */
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once dirname(__DIR__) . '/includes/formularios.php';

$casos = [
    ['2027-02-31', '16:00', '2027-02-01T00:00:00Z', false],
    ['2027-02-29', '16:00', '2027-02-01T00:00:00Z', false],
    ['2028-02-29', '16:00', '2027-02-01T00:00:00Z', true],
    ['0000-01-01', '16:00', '2027-02-01T00:00:00Z', false],
    ['2027-02-00', '16:00', '2027-02-01T00:00:00Z', false],
    ['2027-13-01', '16:00', '2027-02-01T00:00:00Z', false],
    ['2027-02-01suffix', '16:00', '2027-02-01T00:00:00Z', false],
    [' 2027-02-01', '16:00', '2027-02-01T00:00:00Z', false],
    ['2027-2-01', '16:00', '2027-02-01T00:00:00Z', false],
    ['2027-02-01', '24:00', '2027-02-01T00:00:00Z', false],
    // Medianoche UTC todavía es el día anterior en Mount Shasta.
    ['2026-11-03', '16:00', '2026-11-04T00:30:00Z', true],
    ['2026-11-02', '16:00', '2026-11-04T00:30:00Z', false],
    ['2026-11-03', '16:00', '2026-11-04T07:59:59Z', true],
    ['2026-11-03', '16:00', '2026-11-04T08:00:00Z', false],
    ['2026-11-04', '16:00', '2026-11-04T08:00:00Z', true],
    // El salto primaveral no puede normalizar 02:30 a 03:30 silenciosamente.
    ['2027-03-14', '02:30', '2027-03-14T08:00:00Z', false],
    ['2027-03-14', '16:00', '2027-03-14T08:00:00Z', true],
    ['2027-11-07', '16:00', '2027-11-07T07:00:00Z', true],
    ['2027-11-07', '16:00', '2027-11-08T07:59:59Z', true],
    ['2027-11-07', '16:00', '2027-11-08T08:00:00Z', false],
];
foreach ($casos as [$fecha, $hora, $ahora, $esperado]) {
    $resultado = fechaSolicitudReserva($fecha, $hora, new DateTimeImmutable($ahora));
    if (($resultado !== null) !== $esperado) {
        throw new RuntimeException('Fecha inesperada: ' . json_encode([$fecha, $hora, $ahora]));
    }
}
foreach (['2027-03-14' => '-07:00', '2027-11-07' => '-08:00'] as $fecha => $offset) {
    $resultado = fechaSolicitudReserva($fecha, '16:00', new DateTimeImmutable('2027-01-01T00:00:00Z'));
    if ($resultado->format('P') !== $offset) {
        throw new RuntimeException('Offset DST incorrecto');
    }
}
// PHP CLI no habilita la excepción HTTP local aunque se falsifiquen Host o cabeceras de proxy.
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['HTTP_X_FORWARDED_PROTO'] = 'http';
$_SERVER['HTTP_CF_VISITOR'] = '{"scheme":"http"}';
iniciarSesionFormulario();
$cookie = session_get_cookie_params();
foreach ([$cookie['secure'], $cookie['httponly'], $cookie['samesite'] === 'Lax', ini_get('session.use_strict_mode') === '1', $cookie['domain'] === ''] as $seguro) {
    if (!$seguro) {
        throw new RuntimeException('Configuración de sesión insegura');
    }
}
session_destroy();
echo 'PASS: 27 comprobaciones de calendario, medianoche, DST y sesión segura.' . PHP_EOL;
