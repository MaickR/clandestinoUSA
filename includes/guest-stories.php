<?php
// Revisión local exclusivamente: permisos, subtítulos y alternativa integral pendientes.
if (PHP_SAPI !== 'cli-server' || !in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true) || realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    return;
}
$historiasInvitados = [
    ['archivo' => 'Client-1', 'poster' => 'conversacion', 'titulo' => 'A glass of red', 'duracion' => '0:51', 'descripcion' => 'A seated guest holds a glass of red wine at a table inside The Clandestino.'],
    ['archivo' => 'Cliente-2', 'poster' => 'juntos', 'titulo' => 'Tapas & company', 'duracion' => '1:31', 'descripcion' => 'The camera moves from cheese and cured meats to two guests at the bar, with wine bottles in front of them.'],
    ['archivo' => 'clandetino-user', 'poster' => 'encuentro', 'titulo' => 'By the window', 'duracion' => '1:18', 'descripcion' => 'The camera moves from a wine bottle to a seated guest by the window; another guest is visible nearby.'],
    ['archivo' => 'clandestino-experience', 'poster' => 'momento', 'titulo' => 'A sip of tradition', 'duracion' => '0:06', 'descripcion' => 'A guest drinks from a leather wineskin beside a board of tapas, then lowers it as the camera returns to the food.'],
];
$escaparHistoria = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
?>
<section class="cl-seccion cl-home-historias" id="guest-stories" aria-labelledby="guest-stories-titulo">
  <div class="container cl-home-historias__composicion">
    <header class="cl-home-historias__editorial cl-seccion__encabezado--ornamentado">
      <p class="cl-eyebrow">Guest Stories</p>
      <h2 class="cl-display" id="guest-stories-titulo">More than wine. Memories.</h2>
      <div class="cl-home-historias__relato">
        <p class="cl-seccion__descripcion">Some come for the wine. Others for the food. What brings us together is everything in between.</p>
        <p class="cl-seccion__descripcion">Meet the people and shared moments that make The Clandestino feel like home.</p>
      </div>
    </header>
    <div class="cl-carrusel cl-carrusel--video cl-home-historias__coleccion" data-cl-carrusel data-cl-carrusel-media role="region" aria-roledescription="carousel" aria-label="The stories behind the table">
      <div class="cl-carrusel__controles" data-cl-carrusel-controles hidden>
        <p class="cl-carrusel__posicion visually-hidden" aria-live="polite" aria-atomic="true" data-cl-carrusel-posicion></p>
        <button class="cl-boton-icono" type="button" aria-label="Previous guest story" aria-controls="guest-stories-pista" data-cl-carrusel-anterior><svg class="cl-icon cl-carrusel__flecha-anterior" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-siguiente"></use></svg></button>
        <button class="cl-boton-icono" type="button" aria-label="Next guest story" aria-controls="guest-stories-pista" data-cl-carrusel-siguiente><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-siguiente"></use></svg></button>
      </div>
      <p class="visually-hidden" id="guest-stories-ayuda">Scroll horizontally to explore all four films. With the collection focused, use Left and Right, Home or End. Playback starts only when you choose Play.</p>
      <ul class="cl-carrusel__pista" id="guest-stories-pista" data-cl-carrusel-pista tabindex="0" aria-label="Guest films" aria-describedby="guest-stories-ayuda">
        <?php foreach ($historiasInvitados as $indice => $historia) : ?>
        <li class="cl-carrusel__item">
          <figure class="cl-media-video__figura">
            <video class="cl-media-video__pantalla cl-media-video__pantalla--vertical" controls playsinline preload="none" width="478" height="850" poster="/assets/images/guest-stories/<?= $escaparHistoria($historia['poster']) ?>.webp" aria-labelledby="guest-story-<?= $indice ?>-titulo" aria-describedby="guest-story-<?= $indice ?>-contexto">
              <source src="/assets/images/gallery/videos/<?= $escaparHistoria($historia['archivo']) ?>.mp4" type="video/mp4">
              Your browser does not support HTML5 video.
            </video>
            <figcaption class="cl-carrusel__contexto">
              <h3 id="guest-story-<?= $indice ?>-titulo"><?= $escaparHistoria($historia['titulo']) ?></h3>
              <span class="cl-home-historias__duracion"><?= $escaparHistoria($historia['duracion']) ?></span>
              <p class="visually-hidden" id="guest-story-<?= $indice ?>-contexto"><?= $escaparHistoria($historia['descripcion']) ?></p>
            </figcaption>
          </figure>
        </li>
        <?php endforeach; ?>
      </ul>
      <noscript><p class="cl-texto-pequeno">Scroll to explore all four stories. Pause the current film before starting another.</p></noscript>
    </div>
  </div>
</section>
