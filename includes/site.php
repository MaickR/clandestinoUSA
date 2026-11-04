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
$datosSitio = [
    'nombre' => 'The Clandestino USA',
    'origen' => 'https://theclandestinousa.com',
    'idioma' => 'en',
    'locale' => 'en_US',
    'zonaHoraria' => 'America/Los_Angeles',
];
$rutasNavegacion = ['Home' => '/index.html', 'Experiences' => '/index.html#services', 'Restaurant' => '/menu.html', 'Wine Shop' => '/wines.html'];
$rutasDescubrir = ['Wine Club' => '/swc.html', 'About Us' => '/about.html', 'Contact' => '/contact.html'];
$destinoActivo = $destinoActivo ?? '';
$rutaReserva = '/index.html#reservation';
$atributoDestinoNavegacion = '';
$logoNavegacion = '/assets/images/clandestino-logo-ui.svg';
$enlacesPieDescubrir = $rutasDescubrir + ['Private Experiences' => '/index.html#private-events'];
$direccionPostal = [
    '@type' => 'PostalAddress',
    'streetAddress' => '211 N Mt Shasta Blvd',
    'addressLocality' => 'Mount Shasta',
    'addressRegion' => 'CA',
    'postalCode' => '96067',
    'addressCountry' => 'US',
];
// Horario comunicado por el propietario; horas civiles de America/Los_Angeles.
$horarioNegocio = [
    '@type' => 'OpeningHoursSpecification',
    'dayOfWeek' => ['Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
    'opens' => '16:00',
    'closes' => '20:00',
];
$formatearHoraNegocio = static fn (string $hora): string =>
    DateTimeImmutable::createFromFormat('!H:i', $hora, new DateTimeZone($datosSitio['zonaHoraria']))->format('g:i A');
$telefonoNegocio = '+1 (408) 609-0027';
$datosContacto = [
    'direccionPostal' => $direccionPostal,
    'horarioEstructurado' => $horarioNegocio,
    'direccion' => [
        $direccionPostal['streetAddress'],
        $direccionPostal['addressLocality'] . ', ' . $direccionPostal['addressRegion'] . ' ' . $direccionPostal['postalCode'],
    ],
    'mapa' => 'https://www.google.com/maps/place/211+N+Mt+Shasta+Blvd,+Mt+Shasta,+CA+96067,+USA',
    'telefono' => ['url' => 'tel:+' . preg_replace('/\D/', '', $telefonoNegocio), 'texto' => $telefonoNegocio],
    'email' => null,
    'horario' => [
        $horarioNegocio['dayOfWeek'][0] . '–' . $horarioNegocio['dayOfWeek'][5],
        $formatearHoraNegocio($horarioNegocio['opens']) . ' – ' . $formatearHoraNegocio($horarioNegocio['closes']),
    ],
];
$redesSociales = [];
$enlacesLegales = ['Policies' => '/policies.html', 'Reservation terms' => '/terms.html'];
$descripcionPie = 'A little Spain in Mount Shasta. Tapas to share, wines to discover, and time for good company.';
