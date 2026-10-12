<?php
// Referencia local estática: sin operaciones ni JavaScript de demostración.
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
      <p class="cl-texto-secundario">Warm, editorial compositions for our table. Wave 1 is awaiting human visual approval.</p>
      <?php require __DIR__ . '/partials/navegacion-guia.php'; ?>
      <nav aria-label="On this page">
        <ul class="cl-guia-indice">
          <li><a class="cl-enlace" href="#patrones-seccion">Section system</a></li>
          <li><a class="cl-enlace" href="#patrones-hero">Hero</a></li>
          <li><a class="cl-enlace" href="#patrones-media">Media + content</a></li>
          <li><a class="cl-enlace" href="#patrones-cta">CTA band</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <main id="contenido">
    <?php require __DIR__ . '/partials/patrones-wave-1.php'; ?>
  </main>
</body>
</html>
