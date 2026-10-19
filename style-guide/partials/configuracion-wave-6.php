<?php
// Fixtures locales: las páginas reales aportarán estos datos desde configuración del sitio.
// No incluir este archivo desde producción ni inferir rutas comerciales de sus anclas.
$rutasNavegacion = [
    'Home' => '#inicio-global',
    'Experiences' => '/style-guide/patterns.php#experiencias',
    'Restaurant' => '/style-guide/patterns.php#productos-menu',
    'Wine Shop' => '/style-guide/patterns.php#productos-vinos',
];
$rutasDescubrir = [
    'Gift Cards' => '/style-guide/patterns.php#gift-cards',
    'Wine Club' => '/style-guide/patterns.php#wine-club',
    'Events' => '/style-guide/patterns.php#events',
];
$rutaReserva = '#reserva-global';
$enlacesPieDescubrir = [
    'Spanish Wine Club' => $rutasDescubrir['Wine Club'],
    'Gift Cards' => $rutasDescubrir['Gift Cards'],
    'Events' => $rutasDescubrir['Events'],
    'Private Experiences' => '/style-guide/patterns.php#private-experiences',
];
$datosContacto = [
    'direccion' => ['211 N Mt Shasta Blvd', 'Mt Shasta, CA 96067'],
    'mapa' => 'https://www.google.com/maps/place/211+N+Mt+Shasta+Blvd,+Mt+Shasta,+CA+96067,+USA',
    'ubicacionBreve' => 'Mount Shasta, California',
    'telefono' => $pieCompleto ? ['texto' => '+1 408-609-0027', 'url' => 'tel:+14086090027'] : null,
    'email' => $pieCompleto ? 'ntcusa@nicolastena.com' : null,
    // Solo incorporar horario cuando esté confirmado para publicación; no heredar legacy.
    'horario' => [],
];
$redesSociales = $pieCompleto ? [
    ['icono' => 'instagram', 'nombre' => 'Instagram', 'url' => 'https://www.instagram.com/theclandestinousa/'],
    ['icono' => 'facebook', 'nombre' => 'Facebook', 'url' => 'https://www.facebook.com/profile.php?id=61559740614798'],
] : [];
$enlacesLegales = $pieCompleto ? ['Policies' => '/policies.html', 'Reservation terms' => '/terms.html'] : [];
$descripcionPie = $pieCompleto
    ? 'A little Spain in Mount Shasta. Tapas to share, wines to discover, and time for good company.'
    : 'Spanish hospitality, a little closer. A longer editorial introduction to the shared table, thoughtful wines and unhurried evenings with friends in Northern California.';
$escaparNavegacion = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
// Solo el laboratorio embebido necesita salir al documento superior.
$atributoDestinoNavegacion = ' target="_top"';
