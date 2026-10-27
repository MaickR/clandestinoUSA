<?php
// Vista local: no cambia el documento público ni requiere reglas del hosting.
if (PHP_SAPI !== 'cli-server') {
    http_response_code(404);
    exit;
}
header('X-Robots-Tag: noindex, nofollow');

require __DIR__ . '/includes/site.php';
// Contexto local explícito; las rutas públicas no dependen de esta vista.
$rutasNavegacion['Home'] = '/home-preview.php';
$destinoActivo = 'Home';
$carritoNavegacion = ['destino' => '#carrito-preview'];
$fotografias = [
    ['archivo' => 'banner-the_clandestino_1', 'encuadre' => 'mesa', 'titulo' => 'Spanish Wine & Tapas in Mount Shasta', 'descripcion' => 'A taste of Spain. A table to share. Make yourself at home.', 'alt' => 'Spanish tapas and red wine on a candlelit table at The Clandestino'],
    ['archivo' => 'banner-the_clandestino_2', 'encuadre' => 'encuentro', 'titulo' => 'Gather, Sip & Celebrate', 'descripcion' => 'Good wine, shared plates, and the pleasure of being together.', 'alt' => 'Three guests raising glasses of red wine around a shared tapas table'],
    ['archivo' => 'banner-the_clandestino_3', 'encuadre' => 'vino', 'titulo' => 'Discover Pure Soul & Our Wine Selection', 'descripcion' => 'Explore Spanish wines with character, from the first glass to the last.', 'alt' => 'A bottle of Pure Soul red wine with two glasses and Spanish tapas'],
];
$accionesEscenas = [
    [['Reserve a Table', $rutaReserva], ['Explore Wines', '/wines.html']],
    [['Private Experiences', '/index.html#private-events'], ['Explore the Wine Club', '/swc.html']],
    [['Explore Wines', '/wines.html'], ['Discover Pure Soul', '/index.html#pure-soul']],
];
$entradasEscenas = ['A taste of Spain', 'Food · Fiesta · Friends', 'Wines with character'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>Home preview · The Clandestino USA</title>
  <meta name="description" content="Spanish tapas, thoughtful wines, and a warm welcome in Mount Shasta, California.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400;0,500;1,400&amp;display=swap" rel="stylesheet">
  <link rel="icon" href="/assets/favicon/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="/assets/css/home.css">
  <script type="module" blocking="render" src="/assets/js/dist/main.js"></script>
</head>
<body class="cl-estructura cl-home-preview" data-cl-site>
  <a class="cl-saltar" href="#contenido">Skip to main content</a>
  <?php require __DIR__ . '/includes/access.php'; ?>
  <div class="modal fade cl-modal" id="carrito-preview" tabindex="-1" aria-labelledby="carrito-preview-titulo" aria-describedby="carrito-preview-nota" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content cl-modal__superficie">
      <div class="modal-header cl-modal__cabecera">
        <h2 class="cl-modal__titulo" id="carrito-preview-titulo">Your order</h2>
        <button class="cl-boton-icono" type="button" data-bs-dismiss="modal" aria-label="Close cart preview"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-cerrar"></use></svg></button>
      </div>
      <div class="modal-body"><p>Your cart is empty.</p><p id="carrito-preview-nota">Preview only. No cart or checkout service is connected.</p><a class="cl-enlace" href="/menu.html">Explore the menu</a></div>
    </div></div>
  </div>
  <?php require __DIR__ . '/includes/header.php'; ?>
  <main id="contenido" tabindex="-1">
    <h1 class="visually-hidden">Spanish Wine &amp; Tapas in Mount Shasta · The Clandestino</h1>
    <section class="cl-hero cl-hero--slider" aria-label="The Clandestino. Spanish hospitality in Mount Shasta." aria-roledescription="carousel" data-cl-escenas>
      <button class="cl-boton cl-hero__pausa visually-hidden-focusable" type="button" data-cl-escenas-pausa>Pause automatic slides</button>
      <div class="cl-hero__controles" data-cl-escenas-controles hidden>
        <div class="cl-hero__indicadores" role="group" aria-label="Choose a photograph">
          <?php foreach ($fotografias as $indice => $fotografia) : ?>
          <button class="cl-hero__indicador" type="button" aria-label="Go to slide <?= $indice + 1 ?> of 3" aria-description="Selecting a scene stops automatic rotation." aria-controls="home-fotografias" data-cl-escenas-indice="<?= $indice ?>"<?= $indice === 0 ? ' aria-current="true"' : '' ?>></button>
          <?php endforeach; ?>
        </div>
        <span class="visually-hidden" aria-live="polite" aria-atomic="true" data-cl-escenas-posicion></span>
      </div>
      <div class="cl-hero__pista" id="home-fotografias" role="group" aria-label="Restaurant scenes. Use the arrow keys to explore." tabindex="0" data-cl-escenas-pista>
        <?php foreach ($fotografias as $indice => $fotografia) : ?>
        <div class="cl-hero cl-hero__diapositiva cl-hero__diapositiva--<?= $escaparNavegacion($fotografia['encuadre']) ?><?= $indice === 0 ? ' cl-hero__diapositiva--activa' : '' ?>" role="group" aria-label="<?= $indice + 1 ?> of 3" aria-roledescription="slide"<?= $indice === 0 ? '' : ' aria-hidden="true" inert' ?>>
          <?php
          $hero = [
              'fuentes' => [['tipo' => 'image/webp', 'srcset' => '/assets/images/' . $fotografia['archivo'] . '-768.webp 768w, /assets/images/' . $fotografia['archivo'] . '-1672.webp 1672w', 'sizes' => '100vw']],
              'imagen' => '/assets/images/' . $fotografia['archivo'] . '-768.webp',
              'ancho' => 1672, 'alto' => 941, 'alt' => $fotografia['alt'],
              'carga' => $indice === 0 ? 'eager' : 'lazy', 'prioridad' => $indice === 0 ? 'high' : 'low', 'diferida' => $indice !== 0,
              'entrada' => $entradasEscenas[$indice], 'titulo' => $fotografia['titulo'], 'descripcion' => $fotografia['descripcion'],
              'acciones' => $accionesEscenas[$indice],
          ];
          require __DIR__ . '/includes/hero.php';
          ?>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <?php require __DIR__ . '/includes/welcome.php'; ?>
    <?php require __DIR__ . '/includes/spanish-table.php'; ?>
    <?php require __DIR__ . '/includes/wines.php'; ?>
    <?php require __DIR__ . '/includes/private-experiences.php'; ?>
  </main>
  <?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
