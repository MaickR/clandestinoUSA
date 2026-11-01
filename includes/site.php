<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<?php
// Configuración pública: rutas y contacto contrastados con el legacy y production-baseline.
// Correo y perfiles sociales esperan confirmación para publicación.
$escaparNavegacion = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
$rutasNavegacion = ['Home' => '/index.html', 'Experiences' => '/index.html#services', 'Restaurant' => '/menu.html', 'Wine Shop' => '/wines.html'];
$rutasDescubrir = ['Wine Club' => '/swc.html', 'About Us' => '/about.html', 'Contact' => '/contact.html'];
$destinoActivo = $destinoActivo ?? '';
$rutaReserva = '/index.html#reservation';
$atributoDestinoNavegacion = '';
$logoNavegacion = '/assets/images/clandestino-logo-ui.svg';
$enlacesPieDescubrir = $rutasDescubrir + ['Private Experiences' => '/index.html#private-events'];
$datosContacto = [
    'direccion' => ['211 N Mt Shasta Blvd', 'Mount Shasta, CA 96067'],
    'mapa' => 'https://www.google.com/maps/place/211+N+Mt+Shasta+Blvd,+Mt+Shasta,+CA+96067,+USA',
    'telefono' => ['url' => 'tel:+14086090027', 'texto' => '+1 (408) 609-0027'],
    'email' => null,
    // Horario habitual confirmado por el propietario el 2026-10-31; hora local de Mount Shasta (America/Los_Angeles).
    'horario' => ['Tuesday–Sunday', '4:00 PM – 8:00 PM'],
];
$redesSociales = [];
$enlacesLegales = ['Policies' => '/policies.html', 'Reservation terms' => '/terms.html'];
$descripcionPie = 'A little Spain in Mount Shasta. Tapas to share, wines to discover, and time for good company.';
