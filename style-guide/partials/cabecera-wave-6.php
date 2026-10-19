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
$logoNavegacion ??= '/assets/images/clandestino-logo-ui.svg';
$discoverActivo = array_key_exists($destinoActivo, $rutasDescubrir);
$rutaExperienciaPrivada ??= '/style-guide/patterns.php#private-experiences';
?>
<div class="cl-cabecera-testigo" data-cl-cabecera-testigo aria-hidden="true"></div>
<header class="cl-cabecera" data-cl-cabecera>
  <div class="container cl-cabecera__fila">
    <a class="cl-cabecera__marca" href="<?= $escaparNavegacion($rutasNavegacion['Home']) ?>" data-cl-nav-marca aria-label="The Clandestino USA · Home">
      <img class="cl-cabecera__logo" src="<?= $escaparNavegacion($logoNavegacion) ?>" width="174" height="79" alt="The Clandestino USA">
    </a>
    <div class="cl-cabecera__panel" id="navegacion-global" data-cl-nav-panel tabindex="-1" aria-labelledby="navegacion-global-titulo">
      <div class="cl-cabecera__panel-cabecera" data-cl-nav-cabecera hidden>
        <p class="cl-eyebrow" id="navegacion-global-titulo">Explore The Clandestino</p>
        <span class="cl-cabecera__cierre-slot" data-cl-nav-cierre></span>
      </div>
      <nav class="cl-cabecera__nav" aria-label="Main navigation">
      <ul class="cl-cabecera__lista">
        <?php foreach ($rutasNavegacion as $nombre => $ruta) : ?>
          <li><a class="cl-cabecera__enlace" href="<?= $escaparNavegacion($ruta) ?>"<?= $nombre === $destinoActivo ? ' aria-current="page"' : '' ?><?= $nombre !== 'Home' ? ' target="_top"' : '' ?>><?= $escaparNavegacion($nombre) ?></a></li>
        <?php endforeach; ?>
        <li class="cl-cabecera__grupo">
          <button class="cl-cabecera__expandir<?= $discoverActivo ? ' cl-cabecera__expandir--activo' : '' ?>" type="button" data-cl-nav-expandir data-bs-toggle="collapse" data-bs-target="#descubrir-global" aria-controls="descubrir-global" aria-expanded="true"<?= $discoverActivo ? ' aria-describedby="descubrir-actual"' : '' ?> hidden>Discover <svg class="cl-icon cl-cabecera__indicador" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-expandir"></use></svg></button>
          <?php if ($discoverActivo) : ?><span class="visually-hidden" id="descubrir-actual">Contains the current page</span><?php endif; ?>
          <ul class="cl-cabecera__sublista" id="descubrir-global" data-cl-nav-subpanel>
            <?php foreach ($rutasDescubrir as $nombre => $ruta) : ?>
              <li><a class="cl-cabecera__enlace" href="<?= $escaparNavegacion($ruta) ?>" target="_top"<?= $nombre === $destinoActivo ? ' aria-current="page"' : '' ?>><?= $escaparNavegacion($nombre) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
      </ul>
      <a class="cl-boton cl-cabecera__reserva" href="<?= $escaparNavegacion($rutaReserva) ?>">Reserve a Table</a>
      </nav>
      <div class="cl-cabecera__panel-pie" data-cl-nav-pie hidden><p class="cl-texto-pequeno">Spanish hospitality in Mount Shasta</p><a class="cl-enlace" href="tel:+14086090027">+1 408-609-0027</a></div>
    </div>
    <button class="cl-boton-icono cl-cabecera__cuenta" type="button" data-cl-acceso-abrir aria-label="Sign in" aria-controls="acceso-global" hidden><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-cuenta"></use></svg></button>
    <span class="cl-cabecera__origen" data-cl-nav-origen>
      <button class="cl-boton-icono cl-cabecera__control" type="button" data-cl-nav-control aria-controls="navegacion-global" aria-expanded="false" aria-label="Open main navigation" hidden>
        <svg class="cl-icon cl-cabecera__hamburguesa" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-menu"></use></svg>
        <svg class="cl-icon cl-cabecera__equis" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-cerrar"></use></svg>
      </button>
    </span>
  </div>
</header>
