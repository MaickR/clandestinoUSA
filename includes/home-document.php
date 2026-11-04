<?php
if (!isset($esVistaPreviaHome) || realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
// Documento único de Home: los anfitriones solo aportan contexto y metadatos.
// Derivado de entrega exclusivo de Home; las demás páginas conservan su logo.
$logoNavegacion = '/assets/images/clandestino-logo-home.svg';
$fotografias = [
    ['archivo' => 'banner-the_clandestino_1', 'encuadre' => 'mesa', 'titulo' => 'Spanish Wine & Tapas in Mount Shasta', 'descripcion' => 'A taste of Spain. A table to share. Make yourself at home.', 'alt' => 'Spanish tapas and red wine on a candlelit table at The Clandestino'],
    ['archivo' => 'banner-the_clandestino_2', 'encuadre' => 'encuentro', 'titulo' => 'Gather, Sip & Celebrate', 'descripcion' => 'Good wine, shared plates, and the pleasure of being together.', 'alt' => 'Three guests raising glasses of red wine around a shared tapas table'],
    ['archivo' => 'banner-the_clandestino_3', 'encuadre' => 'vino', 'titulo' => 'Pure Soul & Spanish Wines', 'descripcion' => 'Explore Spanish wines with character, from the first glass to the last.', 'alt' => 'A bottle of Pure Soul red wine with two glasses and Spanish tapas'],
];
$accionesEscenas = [
    [['Request a Table', $rutaReserva], ['Explore Wines', '/wines.html']],
    [['Private Experiences', $esVistaPreviaHome ? '/index.html#private-events' : '/#private-events'], ['Explore the Wine Club', '/swc.html']],
    [['Explore Wines', '/wines.html'], ['Discover Pure Soul', $esVistaPreviaHome ? '/index.html#pure-soul' : '/#spanish-wines']],
];
$entradasEscenas = ['A taste of Spain', 'Food · Fiesta · Friends', 'Wines with character'];
?>
<!DOCTYPE html>
<html lang="<?= $escaparNavegacion($datosSitio['idioma']) ?>">
<head>
  <?php require __DIR__ . '/home-head.php'; ?>
</head>
<body class="cl-estructura cl-home-preview" data-cl-site<?= $esVistaPreviaHome ? '' : ' id="top" data-cl-home-publica data-cl-reserva-legacy="' . $escaparNavegacion($rutaReserva) . '"' ?>>
  <a class="cl-saltar" href="#contenido">Skip to main content</a>
  <?php if ($esVistaPreviaHome) : ?>
  <?php require __DIR__ . '/access.php'; ?>
  <div class="modal fade cl-modal" id="carrito-preview" tabindex="-1" aria-labelledby="carrito-preview-titulo" aria-describedby="carrito-preview-nota" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content cl-modal__superficie">
      <div class="modal-header cl-modal__cabecera">
        <h2 class="cl-modal__titulo" id="carrito-preview-titulo">Your order</h2>
        <button class="cl-boton-icono" type="button" data-bs-dismiss="modal" aria-label="Close cart preview"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-cerrar"></use></svg></button>
      </div>
      <div class="modal-body"><p>Your cart is empty.</p><p id="carrito-preview-nota">Preview only. No cart or checkout service is connected.</p><a class="cl-enlace" href="/menu.html">Explore the menu</a></div>
    </div></div>
  </div>
  <?php endif; ?>
  <?php require __DIR__ . '/header.php'; ?>
  <main id="contenido" tabindex="-1">
    <h1 class="visually-hidden">Spanish Wine &amp; Tapas in Mount Shasta · The Clandestino</h1>
    <?php if (!$esVistaPreviaHome) : ?><span class="visually-hidden" id="home" aria-hidden="true"></span><?php endif; ?>
    <section class="cl-hero cl-hero--slider" aria-label="The Clandestino. Spanish hospitality in Mount Shasta." aria-roledescription="carousel" data-cl-escenas>
      <button class="cl-boton cl-hero__pausa visually-hidden-focusable" type="button" data-cl-escenas-pausa hidden>Pause automatic slides</button>
      <div class="cl-hero__controles" data-cl-escenas-controles hidden>
        <div class="cl-hero__indicadores" role="group" aria-label="Choose a photograph">
          <?php foreach ($fotografias as $indice => $fotografia) : ?>
          <button class="cl-hero__indicador" type="button" aria-label="Go to slide <?= $indice + 1 ?> of 3" aria-description="Selecting a scene stops automatic rotation." aria-controls="home-fotografias" data-cl-escenas-indice="<?= $indice ?>"<?= $indice === 0 ? ' aria-current="true"' : '' ?>></button>
          <?php endforeach; ?>
        </div>
        <span class="visually-hidden" aria-live="polite" aria-atomic="true" data-cl-escenas-posicion></span>
      </div>
      <div class="cl-hero__pista" id="home-fotografias" role="group" aria-label="Restaurant scenes" data-cl-escenas-pista>
        <?php foreach ($fotografias as $indice => $fotografia) : ?>
        <div class="cl-hero cl-hero__diapositiva cl-hero__diapositiva--<?= $escaparNavegacion($fotografia['encuadre']) ?><?= $indice === 0 ? ' cl-hero__diapositiva--activa' : '' ?>" role="group" aria-label="<?= $indice + 1 ?> of 3" aria-roledescription="slide"<?= $indice === 0 ? '' : ' aria-hidden="true" inert' ?>>
          <?php
          $hero = [
              // Cover necesita más anchura que el viewport cuando la fotografía es verticalmente recortada.
              'fuentes' => [
                  ['tipo' => 'image/avif', 'srcset' => '/assets/images/' . $fotografia['archivo'] . '-1024.avif 1024w, /assets/images/' . $fotografia['archivo'] . '-1672.avif 1672w', 'sizes' => '(min-width: 992px) 100vw, max(100vw, 960px)'],
                  ['tipo' => 'image/webp', 'srcset' => '/assets/images/' . $fotografia['archivo'] . '-768.webp 768w, /assets/images/' . $fotografia['archivo'] . '-1672.webp 1672w', 'sizes' => '(min-width: 992px) 100vw, max(100vw, 960px)'],
              ],
              'imagen' => '/assets/images/' . $fotografia['archivo'] . '-768.webp',
              'ancho' => 1672, 'alto' => 941, 'alt' => $fotografia['alt'],
              'carga' => $indice === 0 ? 'eager' : 'lazy', 'prioridad' => $indice === 0 ? 'high' : 'low', 'diferida' => $indice !== 0,
              'entrada' => $entradasEscenas[$indice], 'titulo' => $fotografia['titulo'], 'descripcion' => $fotografia['descripcion'],
              'acciones' => $accionesEscenas[$indice],
          ];
          require __DIR__ . '/hero.php';
          ?>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <?php if (!$esVistaPreviaHome) : ?><span class="visually-hidden" id="services" aria-hidden="true"></span><?php endif; ?>
    <?php if (!$esVistaPreviaHome) : ?><span class="visually-hidden" id="about" aria-hidden="true"></span><?php endif; ?>
    <?php require __DIR__ . '/discovery.php'; ?>
    <?php if (!$esVistaPreviaHome) : ?><span class="visually-hidden" id="pure-soul" aria-hidden="true"></span><?php endif; ?>
    <?php require __DIR__ . '/wines.php'; ?>
    <?php require __DIR__ . '/private-experiences.php'; ?>
    <?php require __DIR__ . '/guest-stories.php'; ?>
    <?php if (!$esVistaPreviaHome) : ?><span class="visually-hidden" id="reservation" aria-hidden="true"></span><?php endif; ?>
    <?php require __DIR__ . '/reservation-cta.php'; ?>
    <?php if (!$esVistaPreviaHome) : ?><span class="visually-hidden" id="special" aria-hidden="true"></span><?php endif; ?>
    <?php require __DIR__ . '/wine-club.php'; ?>
    <?php require __DIR__ . '/gifting.php'; ?>
    <?php require __DIR__ . '/visit.php'; ?>
  </main>
  <?php require __DIR__ . '/footer.php'; ?>
</body>
</html>
