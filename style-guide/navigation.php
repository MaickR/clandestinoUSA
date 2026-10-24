<?php
// Laboratorio aislado. No es una página productiva ni un motor de reservas.
$pieCompleto = ($_GET['footer'] ?? '') !== 'minimal';
$logoNavegacion = ($_GET['logo'] ?? '') === 'original' ? '/assets/images/clandestino-logo.svg' : '/assets/images/clandestino-logo-ui.svg';
$paginaInterior = ($_GET['layout'] ?? '') === 'interior';
$destinoActivo = ($_GET['active'] ?? '') === 'club' ? 'Wine Club' : 'Home';
$mostrarTopbar = ($_GET['topbar'] ?? '') === 'on';
require __DIR__ . '/partials/configuracion-wave-6.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Local laboratory for global navigation. Demonstration destinations only.">
  <title>Global Navigation Lab — The Clandestino USA</title>
  <link rel="icon" href="/assets/favicon/favicon.svg" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400;0,500;1,400&amp;family=Playfair+Display:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.new.css">
  <link rel="stylesheet" href="/assets/css/style-guide.css">
</head>
<body class="cl-estructura" data-cl-navegacion>
  <a class="cl-saltar" href="#contenido-global">Skip to main content</a>
  <?php require __DIR__ . '/partials/acceso-wave-6.php'; ?>
  <?php if ($mostrarTopbar) require __DIR__ . '/partials/topbar-wave-6.php'; ?>
  <?php require __DIR__ . '/partials/cabecera-wave-6.php'; ?>
  <main id="contenido-global" tabindex="-1">
    <?php if (!$paginaInterior) : ?>
    <section class="cl-hero" id="inicio-global" tabindex="-1" aria-labelledby="inicio-global-titulo">
      <?php
      $hero = [
          'fuentes' => [['tipo' => 'image/avif', 'srcset' => '/assets/images/avif/bg/clandestino-usa.avif'], ['tipo' => 'image/webp', 'srcset' => '/assets/images/webp/bg/clandestino-usa.webp']],
          'imagen' => '/assets/images/bg/clandestino-usa.jpg', 'ancho' => 1880, 'alto' => 920,
          'alt' => 'Wine glasses above the bar and barrel tables at The Clandestino', 'carga' => 'eager',
          'etiqueta' => 'h1', 'id' => 'inicio-global-titulo', 'entrada' => 'The Clandestino · Mount Shasta',
          'titulo' => 'A little Spain. A table to share.',
          'descripcion' => 'Spanish tapas, a glass of wine, and the pleasure of good company in Northern California.',
          'acciones' => [['Reserve a Table', $rutaReserva], ['Explore Wines', '/style-guide/patterns.php#productos-vinos', '_top']],
      ];
      require __DIR__ . '/partials/hero-editorial-wave-1.php';
      ?>
    </section>
    <?php else : ?>
    <section class="cl-seccion" id="inicio-global" tabindex="-1" aria-labelledby="interior-titulo"><div class="container"><p class="cl-eyebrow">Interior composition · design laboratory</p><h1 id="interior-titulo">An unhurried evening of Spanish hospitality, from the first welcome to the last glass</h1><p>A long title without a photographic hero. The same header, breadcrumbs, form controls and footer remain in place.</p></div></section>
    <section class="cl-seccion cl-guia-estructura-clara" aria-labelledby="interior-form-titulo"><div class="container"><h2 id="interior-form-titulo">A lighter content surface</h2><p>Contrast and anchor test only; this is not a product theme or a live enquiry form.</p><label class="cl-etiqueta" for="interior-sample">Example enquiry</label><input class="cl-campo" id="interior-sample" value="A table for an evening together · sample only" readonly></div></section>
    <?php endif; ?>
    <section class="cl-seccion" aria-labelledby="estructura-titulo">
      <div class="container">
        <p class="cl-eyebrow">Wave 6 · Navigation laboratory</p>
        <h2 id="estructura-titulo">An invitation, from every page.</h2>
        <p>This is an isolated design system preview. Navigation opens existing examples in the guide. Sign in opens a sample interface; accounts and reservations are not available here.</p>
        <p><a class="cl-enlace" href="/style-guide/patterns.php#wave-6" target="_top">Back to Section Patterns</a></p>
        <p><a class="cl-enlace" href="navigation.php<?= $mostrarTopbar ? '' : '?topbar=on' ?>" target="_top"><?= $mostrarTopbar ? 'Compare header without Topbar' : 'Compare optional desktop Topbar' ?></a></p>
        <nav class="cl-ruta" aria-label="Breadcrumb">
          <ol class="cl-migas"><li class="cl-migas__item"><a class="cl-enlace" href="#inicio-global">Home</a></li><li class="cl-migas__item"><span class="cl-migas__separador" aria-hidden="true">/</span><span aria-current="page">Navigation laboratory</span></li></ol>
        </nav>
        <details>
          <summary class="cl-enlace">Nested route &amp; long content states</summary>
          <nav class="cl-ruta" aria-label="Breadcrumb · nested example"><ol class="cl-migas">
            <li class="cl-migas__item"><a class="cl-enlace" href="#inicio-global">Home</a></li>
            <li class="cl-migas__item"><span class="cl-migas__separador" aria-hidden="true">/</span><a class="cl-enlace" href="/style-guide/patterns.php#experiencias" target="_top">Experiences</a></li>
            <li class="cl-migas__item"><span class="cl-migas__separador" aria-hidden="true">/</span><span aria-current="page">A long editorial destination for shared evenings and Spanish wine discoveries · future route example</span></li>
          </ol></nav>
          <p class="cl-texto-pequeno">Example hierarchy only. The current destination is plain text; no unpublished URL is created.</p>
          <address class="cl-contacto"><p>211 N Mt Shasta Blvd, Mt Shasta, CA 96067</p><p><a class="cl-enlace" href="mailto:ntcusa@nicolastena.com">ntcusa@nicolastena.com</a></p></address>
          <p class="cl-texto-pequeno">Optional data example: phone, social profiles and opening hours omitted. Hours awaiting confirmation. Legal policy slot awaiting a published document — no link.</p>
          <p><a class="cl-enlace" href="navigation.php?footer=minimal#pie-global" target="_top">Preview the same footer with optional data absent and a longer description</a></p>
          <p><a class="cl-enlace" href="navigation.php?layout=interior&amp;active=club" target="_top">Preview an interior page, form controls and Discover active</a></p>
        </details>
        <nav class="cl-contexto" aria-label="Related destinations">
          <a class="cl-enlace" href="/style-guide/patterns.php#experiencias" target="_top"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-volver"></use></svg>Back to Experiences</a>
          <a class="cl-enlace" href="/style-guide/patterns.php#productos-vinos" target="_top">Explore Spanish wines</a>
          <a class="cl-enlace" href="/style-guide/patterns.php#events" target="_top">Related · Events</a>
        </nav>
      </div>
    </section>
    <section class="cl-seccion cl-seccion--alterna" id="reserva-global" tabindex="-1" aria-labelledby="reserva-global-titulo">
      <div class="container">
        <p class="cl-eyebrow">Reserve a Table · Preview destination</p>
        <h2 id="reserva-global-titulo">Your next evening at The Clandestino</h2>
        <p>The reservation service is a future integration. This preview cannot check availability or make a booking.</p>
        <a class="cl-enlace" href="tel:+14086090027">For a real enquiry, call +1 408-609-0027</a>
      </div>
    </section>
  </main>
  <?php require __DIR__ . '/partials/pie-wave-6.php'; ?>
  <script type="module" src="/assets/js/dist/style-guide.js"></script>
</body>
</html>
