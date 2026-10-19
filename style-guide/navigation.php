<?php
// Laboratorio aislado. No es una página productiva ni un motor de reservas.
$pieCompleto = ($_GET['footer'] ?? '') !== 'minimal';
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
  <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400;0,500;1,400&family=Playfair+Display:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.new.css">
</head>
<body class="cl-estructura" data-cl-navegacion>
  <a class="cl-saltar" href="#contenido-global">Skip to main content</a>
  <?php require __DIR__ . '/partials/cabecera-wave-6.php'; ?>
  <main id="contenido-global" tabindex="-1">
    <section class="cl-hero" id="inicio-global" tabindex="-1" aria-labelledby="inicio-global-titulo">
      <picture class="cl-hero__media">
        <source srcset="/assets/images/avif/bg/clandestino-usa.avif" type="image/avif">
        <source srcset="/assets/images/webp/bg/clandestino-usa.webp" type="image/webp">
        <img class="cl-hero__imagen" src="/assets/images/bg/clandestino-usa.jpg" width="1880" height="920" alt="Wine glasses above the bar and barrel tables at The Clandestino">
      </picture>
      <div class="container cl-hero__estructura"><div class="row"><div class="cl-hero__contenido col-12 col-md-10 col-lg-7">
        <p class="cl-eyebrow">The Clandestino · Mount Shasta</p>
        <h1 class="cl-display" id="inicio-global-titulo">A little Spain. A table to share.</h1>
        <p class="cl-seccion__descripcion">Spanish tapas, a glass of wine, and the pleasure of good company in Northern California.</p>
        <div class="cl-seccion__acciones"><a class="cl-boton" href="<?= $escaparNavegacion($rutaReserva) ?>">Reserve a Table</a><a class="cl-boton cl-boton--secundario" href="/style-guide/patterns.php#productos-vinos" target="_top">Explore Wines</a></div>
      </div></div></div>
    </section>
    <section class="cl-seccion" aria-labelledby="estructura-titulo">
      <div class="container">
        <p class="cl-eyebrow">Wave 6 · Navigation laboratory</p>
        <h2 id="estructura-titulo">An invitation, from every page.</h2>
        <p>This is an isolated design system preview. Navigation opens existing examples in the guide. My Account is a future destination; reservations are not available here.</p>
        <p><a class="cl-enlace" href="/style-guide/patterns.php#wave-6" target="_top">Back to Section Patterns</a></p>
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
