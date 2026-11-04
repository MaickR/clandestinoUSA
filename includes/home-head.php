<?php
if (!isset($esVistaPreviaHome) || realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
$tituloHome = $esVistaPreviaHome
    ? 'Home preview · The Clandestino USA'
    : 'Spanish Tapas & Wine in Mount Shasta | The Clandestino USA';
$descripcionHome = $esVistaPreviaHome
    ? 'Spanish tapas, thoughtful wines, and a warm welcome in Mount Shasta, California.'
    : 'Discover Spanish tapas and wines at The Clandestino USA in Mount Shasta. Explore our wines, plan an evening with friends, or request a table.';
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="<?= $escaparNavegacion($robotsHome) ?>">
  <title><?= $escaparNavegacion($tituloHome) ?></title>
  <meta name="description" content="<?= $escaparNavegacion($descripcionHome) ?>">
  <?php if (!$esVistaPreviaHome) : ?>
  <link rel="canonical" href="<?= $escaparNavegacion($datosSitio['origen']) ?>/">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?= $escaparNavegacion($datosSitio['nombre']) ?>">
  <meta property="og:locale" content="<?= $escaparNavegacion($datosSitio['locale']) ?>">
  <meta property="og:url" content="<?= $escaparNavegacion($datosSitio['origen']) ?>/">
  <meta property="og:title" content="<?= $escaparNavegacion($tituloHome) ?>">
  <meta property="og:description" content="<?= $escaparNavegacion($descripcionHome) ?>">
  <meta property="og:image" content="<?= $escaparNavegacion($datosSitio['origen']) ?>/assets/images/banner-the_clandestino_1.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1672">
  <meta property="og:image:height" content="941">
  <meta property="og:image:alt" content="Spanish tapas and red wine on a candlelit table at The Clandestino">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= $escaparNavegacion($tituloHome) ?>">
  <meta name="twitter:description" content="<?= $escaparNavegacion($descripcionHome) ?>">
  <meta name="twitter:image" content="<?= $escaparNavegacion($datosSitio['origen']) ?>/assets/images/banner-the_clandestino_1.png">
  <meta name="twitter:image:alt" content="Spanish tapas and red wine on a candlelit table at The Clandestino">
  <script type="application/ld+json"><?= $jsonHome ?></script>
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400;0,500;1,400&amp;display=swap" rel="stylesheet">
  <link rel="icon" href="/assets/favicon/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="<?= $escaparNavegacion($cssHome) ?>">
  <script type="module" blocking="render" src="<?= $escaparNavegacion($jsHome) ?>"></script>
