<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<?php
// Configuración pública mínima: rutas existentes y contacto ya usado por Header.
// Los horarios, correo y perfiles sociales esperan confirmación para publicación.
$escaparNavegacion = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
$rutasNavegacion = ['Home' => '/index.html', 'Experiences' => '/index.html#services', 'Restaurant' => '/menu.html', 'Wine Shop' => '/wines.html'];
$rutasDescubrir = ['Wine Club' => '/swc.html', 'About Us' => '/about.html', 'Contact' => '/contact.html'];
$destinoActivo = $destinoActivo ?? '';
$rutaReserva = '/index.html#reservation';
$atributoDestinoNavegacion = '';
$logoNavegacion = '/assets/images/clandestino-logo-ui.svg';
$enlacesPieDescubrir = $rutasDescubrir + ['Private Experiences' => '/index.html#private-events'];
$datosContacto = [
    'direccion' => [], 'mapa' => null,
    'telefono' => ['url' => 'tel:+14086090027', 'texto' => '+1 (408) 609-0027'],
    'email' => null, 'horario' => [],
];
$redesSociales = [];
$enlacesLegales = ['Policies' => '/policies.html', 'Reservation terms' => '/terms.html'];
$descripcionPie = 'A little Spain in Mount Shasta. Tapas to share, wines to discover, and time for good company.';
