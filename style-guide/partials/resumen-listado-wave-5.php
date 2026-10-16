<?php
$distribucionDemo = array_fill(1, 5, 0);
foreach ($resenasDemo as $resena) {
    $distribucionDemo[$resena['puntuacion']]++;
}
$promedioDemo = number_format(array_sum(array_column($resenasDemo, 'puntuacion')) / count($resenasDemo), 1);
?>
<section class="cl-seccion cl-seccion--alterna" id="reputation" aria-labelledby="reputation-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Reputation · fictional dataset</p><h2 id="reputation-titulo">A rating with its context</h2><p class="cl-seccion__descripcion">One source at a time. The distribution keeps every rating in view, including critical feedback.</p></div>
    <div class="row cl-reputacion">
      <div class="col-md-5"><p class="cl-eyebrow">Internal · fictional demo</p><p class="cl-reputacion__promedio"><?= $promedioDemo ?><span class="cl-texto-pequeno"> / 5</span></p><p>6 fictional reviews · not restaurant ratings</p><p class="cl-texto-pequeno cl-texto-secundario">Example snapshot: <time datetime="2026-10-16">October 16, 2026</time><br>No platform scores are combined.</p><a class="cl-enlace" href="#review-listing">Inspect the six example entries</a></div>
      <div class="col-md-7"><ul class="cl-reputacion__distribucion" aria-label="Fictional rating distribution">
        <?php for ($estrellas = 5; $estrellas >= 1; $estrellas--) : ?>
        <li class="cl-reputacion__fila"><span><?= $estrellas ?> <?= $estrellas === 1 ? 'star' : 'stars' ?></span><progress class="cl-reputacion__barra" value="<?= $distribucionDemo[$estrellas] ?>" max="6" aria-label="<?= $estrellas ?> stars: <?= $distribucionDemo[$estrellas] ?> of 6 fictional reviews"><?= $distribucionDemo[$estrellas] ?> / 6</progress><span aria-hidden="true"><?= $distribucionDemo[$estrellas] ?></span></li>
        <?php endfor; ?>
      </ul></div>
    </div>
    <details class="cl-guia-demo"><summary>Reputation states &amp; source boundaries</summary>
      <div data-cl-resenas-estado class="cl-catalogo__resumen">
        <label class="cl-etiqueta" for="reputacion-estado">Demo controls · reputation state</label>
        <select class="cl-campo" id="reputacion-estado" disabled>
          <option value="empty">No data</option><option value="partial">Incomplete data</option><option value="source">Source unavailable</option><option value="loading">Loading · static example</option><option value="error">Error</option>
        </select>
        <div class="cl-estado-vista" data-cl-resenas-vista role="status"><h3 class="cl-estado-vista__titulo">No ratings yet</h3><p class="cl-estado-vista__texto">No average or stars are shown until published ratings are available.</p></div>
        <div data-cl-resenas-skeleton hidden aria-hidden="true"><span class="cl-skeleton"></span><span class="cl-skeleton cl-skeleton--corto"></span></div>
        <button class="cl-boton cl-boton--secundario" type="button" data-cl-resenas-reintentar hidden>Retry example</button>
      </div>
      <div class="row cl-guia-rejilla">
        <?php foreach (['Internal' => 'Restaurant review records, subject to authorship checks and moderation.', 'Google' => 'No Google rating or review is reproduced. A verified review URL, date and permitted use are pending.', 'Facebook' => 'No Facebook rating or recommendation is reproduced. Its native rating model must be preserved.'] as $fuente => $nota) : ?>
        <div class="col-lg-4"><article class="cl-catalogo__resumen"><p class="cl-eyebrow">Source boundary</p><h3><?= $escaparResena($fuente) ?></h3><p><?= $escaparResena($nota) ?></p><span class="cl-estado">Source data pending</span></article></div>
        <?php endforeach; ?>
      </div>
    </details>
  </div>
</section>

<section class="cl-seccion" id="review-listing" aria-labelledby="review-listing-titulo">
  <div class="container" data-cl-resenas-listado>
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Review Listing · internal fictional collection</p><h2 id="review-listing-titulo">Read every perspective</h2><p class="cl-seccion__descripcion">Filter the six fictional entries by rating, or change their order. These controls operate only on this local demonstration.</p></div>
    <div class="row cl-catalogo">
      <div class="col-sm-6 col-lg-4"><label class="cl-etiqueta" for="resenas-filtro">Rating</label><select class="cl-campo" id="resenas-filtro" data-cl-resenas-filtro disabled><option value="all">All ratings</option><?php for ($i = 5; $i >= 1; $i--) : ?><option value="<?= $i ?>"><?= $i ?> <?= $i === 1 ? 'star' : 'stars' ?></option><?php endfor; ?><option value="unrated">Without a rating · empty example</option></select></div>
      <div class="col-sm-6 col-lg-4"><label class="cl-etiqueta" for="resenas-orden">Sort by</label><select class="cl-campo" id="resenas-orden" data-cl-resenas-orden disabled><option value="newest">Newest first · undated last</option><option value="oldest">Oldest first · undated last</option><option value="highest">Highest rating</option><option value="lowest">Lowest rating</option></select></div>
      <div class="col-lg-4"><div class="cl-campo-grupo"><p class="cl-etiqueta">Collection controls</p><button class="cl-boton cl-boton--secundario" type="button" data-cl-resenas-reset disabled>Reset filters</button></div></div>
    </div>
    <p class="cl-media-video__contexto" data-cl-resenas-contador role="status" aria-atomic="true">6 fictional reviews. All entries are shown without JavaScript.</p>
    <ul class="row cl-resenas-lista" data-cl-resenas-items>
      <?php foreach ($resenasDemo as $resena) : ?>
      <li class="col-md-6 col-xl-4" data-cl-resena-puntuacion="<?= $resena['puntuacion'] ?>" data-cl-resena-fecha="<?= $escaparResena($resena['fecha'] ?? '') ?>"><?php $tarjetaResena($resena); ?></li>
      <?php endforeach; ?>
    </ul>
    <div class="cl-estado-vista" data-cl-resenas-vacio hidden><h3 class="cl-estado-vista__titulo">No matching example reviews</h3><p class="cl-estado-vista__texto">Choose another rating or reset the filters.</p></div>
    <button class="cl-boton cl-boton--secundario" type="button" data-cl-resenas-mas hidden>Show more examples</button>
    <details class="cl-guia-demo"><summary>Demo controls · listing availability</summary><label class="cl-etiqueta" for="resenas-disponibilidad">Collection state</label><select class="cl-campo" id="resenas-disponibilidad" data-cl-resenas-disponibilidad disabled><option value="ready">Ready</option><option value="loading">Loading · static example</option><option value="error">Error</option></select></details>
    <div class="cl-estado-vista" data-cl-resenas-error hidden><h3 class="cl-estado-vista__titulo">Reviews could not be loaded</h3><p class="cl-estado-vista__texto">Demonstration error. Your filter selection is retained.</p><button class="cl-boton cl-boton--secundario" type="button" data-cl-resenas-recuperar>Retry collection · demo</button></div>
    <div data-cl-resenas-carga hidden><p role="status">Loading example reviews · static demonstration, no request is running.</p><div aria-hidden="true"><span class="cl-skeleton"></span><span class="cl-skeleton cl-skeleton--corto"></span></div></div>
    <noscript><p class="cl-alerta">JavaScript is required for local filtering and sorting. All six fictional reviews remain readable.</p></noscript>
  </div>
</section>
