<?php

declare(strict_types=1);

// Revisión local: el servidor embebido y el loopback se comprueban en el servidor.
// La cabecera Host no basta, y este anfitrión no usa la autorización pública de Home.
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store, max-age=0');
if (
    PHP_SAPI !== 'cli-server'
    || !in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)
    || !preg_match('/^(?:localhost|127\.0\.0\.1|\[::1\])(?::[0-9]+)?$/iD', $_SERVER['HTTP_HOST'] ?? '')
) {
    http_response_code(404);
    exit;
}

require __DIR__ . '/includes/site.php';
$mostrarAccesoNavegacion = false;
$carritoNavegacion = [];
$destinoActivo = 'Experiences';
$rutaReserva = '/index.html?legacy=1#reservation';
// Destino local de esta página. La navegación compartida sigue en site.php.
$rutasNavegacion['Experiences'] = '/experiences.php';
$hero = [
    'interior' => true,
    'etiqueta' => 'h1',
    'id' => 'experiences-titulo',
    'entrada' => 'Experiences',
    'titulo' => 'Make an evening of it.',
    'descripcion' => 'Spanish tapas, distinctive wines, and a warm welcome in the heart of Mount Shasta.',
    'fuentes' => [
        [
            'tipo' => 'image/avif',
            'srcset' => '/assets/images/home-r8/private-experiences-768.avif 768w, /assets/images/home-r8/private-experiences-1152.avif 1152w, /assets/images/home-r8/private-experiences-1536.avif 1536w',
            'sizes' => '100vw',
        ],
        [
            'tipo' => 'image/webp',
            'srcset' => '/assets/images/home-r8/private-experiences-768.webp 768w, /assets/images/home-r8/private-experiences-1152.webp 1152w, /assets/images/home-r8/private-experiences-1536.webp 1536w',
            'sizes' => '100vw',
        ],
    ],
    'imagen' => '/assets/images/home-r8/private-experiences-1536.webp',
    'ancho' => 1536,
    'alto' => 1024,
    'alt' => 'A table set for sharing with tapas, wine glasses and flowers.',
    'carga' => 'eager',
    'prioridad' => 'high',
    'acciones' => [],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>Experiences | The Clandestino USA</title>
  <meta name="description" content="Spanish tapas, distinctive wines, and a warm welcome in the heart of Mount Shasta.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400;0,500;1,400&amp;display=swap" rel="stylesheet">
  <link rel="icon" href="/assets/favicon/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="/assets/css/experiences.css">
  <script type="module" blocking="render" src="/assets/js/dist/main.js"></script>
</head>
<body class="cl-estructura" data-cl-site>
  <a class="cl-saltar" href="#contenido">Skip to main content</a>
  <?php require __DIR__ . '/includes/header.php'; ?>
  <main class="cl-experiences" id="contenido" tabindex="-1">
    <section class="cl-hero cl-hero--interior cl-experiences__hero" aria-labelledby="experiences-titulo">
      <?php require __DIR__ . '/includes/hero.php'; ?>
    </section>
    <section class="cl-seccion cl-experiences__introduccion" aria-labelledby="experiences-introduccion-titulo">
      <div class="container">
        <div class="row cl-experiences__composicion">
          <header class="col-12 col-lg-5 cl-experiences__relato">
            <p class="cl-eyebrow">The Clandestino Experience</p>
            <h2 class="cl-titulo-1" id="experiences-introduccion-titulo">More than a table. <em>A moment to remember.</em></h2>
            <p class="cl-seccion__descripcion">Step inside and discover a little Spanish warmth in Northern California. An intimate setting, thoughtful details, and the pleasure of feeling right at home.</p>
          </header>
          <div class="col-12 col-lg-7">
            <div class="cl-experiences__fotografias">
              <img class="cl-experiences__salon" src="/assets/images/inside-clandestino-2.jpg" width="855" height="1024" alt="Wine shelves, oak barrels and Spanish and American flags inside The Clandestino." loading="lazy" decoding="async">
              <picture class="cl-experiences__tapas">
                <source type="image/avif" srcset="/assets/images/avif/tapas.avif">
                <img src="/assets/images/webp/tapas.webp" width="1695" height="2048" alt="Spanish cheeses, cured sausage and fresh bread on a wooden board." loading="lazy" decoding="async">
              </picture>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="cl-seccion cl-experiences__mesa" id="spanish-table" aria-labelledby="spanish-table-titulo">
      <div class="container">
        <div class="row cl-experiences__mesa-interior">
          <div class="col-12 col-lg-7">
            <picture class="cl-experiences__mesa-foto">
              <source srcset="/assets/images/avif/gallery/tapas/the-clandestino-tapas-table-1.avif" type="image/avif">
              <img src="/assets/images/webp/gallery/tapas/the-clandestino-tapas-table-1.webp" width="2048" height="1536" alt="Spanish tapas with cured meats, cheeses and bread laid out to share." loading="lazy" decoding="async">
            </picture>
          </div>
          <div class="col-12 col-lg-5 cl-experiences__mesa-relato">
            <p class="cl-eyebrow">The Spanish Table</p>
            <h2 class="cl-titulo-1" id="spanish-table-titulo">Good food is meant to be shared.</h2>
            <p class="cl-seccion__descripcion">From Spanish cheeses to savory tapas, every plate brings another flavor to share around the table.</p>
            <div class="cl-seccion__acciones">
              <a class="cl-boton" href="/menu.html">Explore the Menu</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="cl-seccion cl-seccion--alterna cl-experiences__privadas" id="private-gatherings" aria-labelledby="private-gatherings-titulo">
      <div class="container">
        <div class="row cl-experiences__privadas-composicion">
          <div class="col-12 col-lg-5 cl-experiences__privadas-relato">
            <p class="cl-eyebrow">Private Gatherings</p>
            <h2 class="cl-titulo-1" id="private-gatherings-titulo">Some evenings are worth making special.</h2>
            <p class="cl-seccion__descripcion">Have an occasion in mind? Tell us what you’re planning and who you’d like to bring together. We’ll explore the possibilities with you.</p>
            <div class="cl-seccion__acciones">
              <a class="cl-boton" href="/contact.html#contact-form">Plan Your Private Gathering</a>
            </div>
          </div>
          <div class="col-12 col-lg-7">
            <div class="cl-experiences__privadas-fotos">
              <picture class="cl-experiences__privadas-escena">
                <source type="image/avif" srcset="/assets/images/home-r8/visit-480.avif 480w, /assets/images/home-r8/visit-816.avif 816w, /assets/images/home-r8/visit-1254.avif 1254w" sizes="(min-width: 768px) 500px, calc(100vw - 24px)">
                <img src="/assets/images/home-r8/visit-816.webp" width="816" height="816" alt="Armchairs, barrel tables and flowers in the dining room at The Clandestino." loading="lazy" decoding="async">
              </picture>
              <picture class="cl-experiences__privadas-detalle">
                <source type="image/avif" srcset="/assets/images/avif/gallery/tapas/the-clandestino-tapas-table-3.avif">
                <img src="/assets/images/webp/gallery/tapas/the-clandestino-tapas-table-3.webp" width="2048" height="1536" alt="Cheese, toasted bread and nuts on a wooden board." loading="lazy" decoding="async">
              </picture>
              <picture class="cl-experiences__privadas-detalle">
                <source type="image/avif" srcset="/assets/images/avif/gallery/wines/the-clandestino-wines-table.avif">
                <img src="/assets/images/webp/gallery/wines/the-clandestino-wines-table.webp" width="1536" height="2048" alt="A wine carafe and glasses on colorful woven coasters." loading="lazy" decoding="async">
              </picture>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="cl-banda-cta cl-banda-cta--destacada cl-banda-cta--invertida cl-experiences__invitacion" id="final-invitation" aria-labelledby="final-invitation-titulo">
      <div class="container">
        <div class="row g-0 cl-banda-cta__fila">
          <div class="col-md-5 cl-banda-cta__media">
            <picture>
              <source srcset="/assets/images/private-room-640.avif 640w, /assets/images/private-room-960.avif 960w, /assets/images/private-room-1600.avif 1600w" sizes="(min-width: 768px) 550px, calc(100vw - 24px)" type="image/avif">
              <img class="cl-banda-cta__imagen" src="/assets/images/private-room-960.webp" srcset="/assets/images/private-room-640.webp 640w, /assets/images/private-room-960.webp 960w, /assets/images/private-room-1600.webp 1600w" sizes="(min-width: 768px) 550px, calc(100vw - 24px)" width="960" height="720" alt="Wine glasses and Spanish bottles set out on the bar at The Clandestino." loading="lazy" decoding="async">
            </picture>
          </div>
          <div class="col-md-7 cl-banda-cta__contenido">
            <p class="cl-eyebrow">Your Evening Awaits</p>
            <h2 class="cl-titulo-1" id="final-invitation-titulo">Make your next evening a little more memorable.</h2>
            <p class="cl-seccion__descripcion">Come discover what makes The Clandestino a place to linger. Your next visit starts with a simple request.</p>
            <p class="cl-banda-cta__nota" id="final-invitation-nota">Table requests are subject to confirmation.</p>
            <div class="cl-seccion__acciones cl-banda-cta__acciones">
              <a class="cl-boton" href="<?= $escaparNavegacion($rutaReserva) ?>" aria-describedby="final-invitation-nota">Request a Table</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
