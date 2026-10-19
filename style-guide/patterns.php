<?php
// Referencia local: las interacciones de la guía no realizan operaciones comerciales.
$paginaGuia = 'patrones';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Local reference for The Clandestino USA section patterns. Visual approval pending.">
  <meta name="theme-color" content="#161412">
  <title>Section Patterns — The Clandestino USA</title>
  <link rel="icon" href="../assets/favicon/favicon.svg" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400;0,500;1,400&family=Playfair+Display:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.new.css">
  <link rel="stylesheet" href="../assets/css/style-guide.css">
</head>
<body class="cl-guia-patrones">
  <a class="visually-hidden-focusable" href="#contenido">Skip to content</a>
  <header class="cl-guia-seccion">
    <div class="container">
      <p class="cl-eyebrow">The Clandestino USA</p>
      <h1>Section Patterns</h1>
      <p class="cl-texto-secundario">Warm, editorial compositions for our table. Explore Waves 1–6; global navigation awaits human visual review.</p>
      <?php require __DIR__ . '/partials/navegacion-guia.php'; ?>
      <nav aria-label="On this page">
        <ul class="cl-guia-indice">
          <li><a class="cl-enlace" href="#patrones-seccion">Section system</a></li>
          <li><a class="cl-enlace" href="#patrones-hero">Hero</a></li>
          <li><a class="cl-enlace" href="#patrones-media">Media + content</a></li>
          <li><a class="cl-enlace" href="#patrones-cta">CTA band</a></li>
          <li><a class="cl-enlace" href="#wave-2">Wave 2 overview</a></li>
          <li><a class="cl-enlace" href="#productos-tapas">Tapas &amp; cheese</a></li>
          <li><a class="cl-enlace" href="#productos-menu">Menu rows</a></li>
          <li><a class="cl-enlace" href="#productos-destacado">Featured food</a></li>
          <li><a class="cl-enlace" href="#productos-vinos">Wines</a></li>
          <li><a class="cl-enlace" href="#vino-destacado">Featured wine</a></li>
          <li><a class="cl-enlace" href="#productos-cestas">Gourmet baskets</a></li>
          <li><a class="cl-enlace" href="#productos-pedido">Take Away demo</a></li>
          <li><a class="cl-enlace" href="#productos-estados">Catalog states</a></li>
          <li><a class="cl-enlace" href="#wave-3">Wave 3 overview</a></li>
          <li><a class="cl-enlace" href="#experiencias">Experiences</a></li>
          <li><a class="cl-enlace" href="#historias">Storytelling</a></li>
          <li><a class="cl-enlace" href="#galeria-editorial">Gallery</a></li>
          <li><a class="cl-enlace" href="#video-editorial">Video</a></li>
          <li><a class="cl-enlace" href="#comunidad">Community</a></li>
          <li><a class="cl-enlace" href="#valores">Values</a></li>
          <li><a class="cl-enlace" href="#wave-4">Wave 4 overview</a></li>
          <li><a class="cl-enlace" href="#wine-club">Wine Club</a></li>
          <li><a class="cl-enlace" href="#gift-cards">Gift Cards</a></li>
          <li><a class="cl-enlace" href="#events">Events</a></li>
          <li><a class="cl-enlace" href="#private-experiences">Private Experiences</a></li>
          <li><a class="cl-enlace" href="#wave-4-states">Wave 4 states</a></li>
          <li><a class="cl-enlace" href="#wave-5">Wave 5 · Reviews &amp; reputation</a></li>
          <li><a class="cl-enlace" href="#wave-6">Wave 6 · Global navigation</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <main id="contenido">
    <?php require __DIR__ . '/partials/patrones-wave-1.php'; ?>
    <?php require __DIR__ . '/partials/productos-wave-2.php'; ?>
    <?php require __DIR__ . '/partials/editorial-wave-3.php'; ?>
    <?php require __DIR__ . '/partials/comercial-wave-4.php'; ?>
    <?php require __DIR__ . '/partials/reputacion-wave-5.php'; ?>
    <?php require __DIR__ . '/partials/navegacion-wave-6.php'; ?>
  </main>
  <script type="module" src="../assets/js/dist/style-guide.js"></script>
</body>
</html>
