<?php
// Contrato de muestra: sustituir este mapa por rutas publicadas al integrar páginas reales.
$rutasNavegacion ??= [
    'Home' => '#inicio-global',
    'Experiences' => '/style-guide/patterns.php#experiencias',
    'Restaurant' => '/style-guide/patterns.php#productos-menu',
    'Wine Shop' => '/style-guide/patterns.php#productos-vinos',
];
$rutasDescubrir ??= [
    'Gift Cards' => '/style-guide/patterns.php#gift-cards',
    'Wine Club' => '/style-guide/patterns.php#wine-club',
    'Events' => '/style-guide/patterns.php#events',
];
$escaparNavegacion = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
$rutaReserva ??= '#reserva-global';
$destinoActivo ??= 'Home';
?>
<div class="cl-cabecera-testigo" data-cl-cabecera-testigo aria-hidden="true"></div>
<header class="cl-cabecera" data-cl-cabecera>
  <div class="container cl-cabecera__fila">
    <a class="cl-cabecera__marca" href="#inicio-global" data-cl-nav-marca aria-label="The Clandestino USA · Home">
      <img class="cl-cabecera__logo" src="/assets/images/clandestino-logo.svg" width="174" height="79" alt="The Clandestino USA">
    </a>
    <button class="cl-boton-icono cl-cabecera__control" type="button" data-cl-nav-control data-bs-toggle="collapse" data-bs-target="#navegacion-global" aria-controls="navegacion-global" aria-expanded="false" aria-label="Toggle main navigation" hidden>
      <svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-menu"></use></svg>
    </button>
    <nav class="cl-cabecera__nav" id="navegacion-global" data-cl-nav-panel aria-label="Main navigation">
      <ul class="cl-cabecera__lista">
        <?php foreach ($rutasNavegacion as $nombre => $ruta) : ?>
          <li><a class="cl-cabecera__enlace" href="<?= $escaparNavegacion($ruta) ?>"<?= $nombre === $destinoActivo ? ' aria-current="page"' : '' ?><?= $nombre !== 'Home' ? ' target="_top"' : '' ?>><?= $escaparNavegacion($nombre) ?></a></li>
        <?php endforeach; ?>
        <li class="cl-cabecera__grupo">
          <button class="cl-cabecera__expandir" type="button" data-cl-nav-expandir data-bs-toggle="collapse" data-bs-target="#descubrir-global" aria-controls="descubrir-global" aria-expanded="true" hidden>Discover <svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-expandir"></use></svg></button>
          <ul class="cl-cabecera__sublista" id="descubrir-global" data-cl-nav-subpanel>
            <?php foreach ($rutasDescubrir as $nombre => $ruta) : ?>
              <li><a class="cl-cabecera__enlace" href="<?= $escaparNavegacion($ruta) ?>" target="_top"<?= $nombre === $destinoActivo ? ' aria-current="page"' : '' ?>><?= $escaparNavegacion($nombre) ?></a></li>
            <?php endforeach; ?>
            <li><span class="cl-cabecera__futuro">My Account <span class="cl-estado">Future · unavailable</span></span></li>
          </ul>
        </li>
      </ul>
      <a class="cl-boton cl-cabecera__reserva" href="<?= $escaparNavegacion($rutaReserva) ?>">Reserve a Table</a>
    </nav>
  </div>
</header>
