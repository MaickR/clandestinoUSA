<section class="cl-seccion" id="reviews-carousel" aria-labelledby="reviews-carousel-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Review Carousel · fictional selection</p><h2 id="reviews-carousel-titulo">A few perspectives, side by side</h2><p class="cl-seccion__descripcion">An editorial selection, separate from the complete review listing. Every entry here is a fictional design example.</p></div>
    <p class="cl-texto-pequeno cl-texto-secundario" id="reviews-carousel-ayuda">Swipe or scroll horizontally. With the collection focused, use Left/Right or Home/End. All review text remains available.</p>
    <div class="cl-carrusel" data-cl-carrusel role="region" aria-roledescription="carousel" aria-labelledby="reviews-carousel-titulo">
      <?php $controlesCarrusel('reviews-carousel-pista', 'review'); ?>
      <ul class="cl-carrusel__pista" data-cl-carrusel-pista id="reviews-carousel-pista" tabindex="0" aria-label="Fictional review selection" aria-describedby="reviews-carousel-ayuda">
        <?php foreach ([0, 1, 4, 3] as $posicionResena => $indiceResena) : ?>
        <li class="cl-carrusel__item" aria-label="Example review <?= $posicionResena + 1 ?> of 4"><?php $tarjetaResena($resenasDemo[$indiceResena]); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <p class="cl-media-video__contexto"><a class="cl-enlace" href="#review-listing">Explore, filter and sort the full example collection</a></p>
    <noscript><p class="cl-texto-pequeno">Scroll horizontally to read every example. Navigation buttons require JavaScript; the collection does not.</p></noscript>
    <details class="cl-guia-demo"><summary>Review Carousel · single &amp; empty states</summary>
      <div class="row cl-guia-rejilla">
        <div class="col-md-7"><div class="cl-carrusel" data-cl-carrusel role="region" aria-label="Single fictional review" aria-roledescription="carousel"><ul class="cl-carrusel__pista" data-cl-carrusel-pista id="reviews-single-pista" tabindex="0" aria-label="One fictional review"><li class="cl-carrusel__item"><?php $tarjetaResena($resenasDemo[4]); ?></li></ul><?php $controlesCarrusel('reviews-single-pista', 'single review'); ?></div></div>
        <div class="col-md-5"><div class="cl-carrusel" data-cl-carrusel role="region" aria-label="Empty review example"><ul class="cl-carrusel__pista" data-cl-carrusel-pista id="reviews-empty-pista" aria-label="Empty review collection" hidden></ul><?php $controlesCarrusel('reviews-empty-pista', 'empty review'); ?><div class="cl-estado-vista"><h3 class="cl-estado-vista__titulo">Guest perspectives to come</h3><p class="cl-estado-vista__texto">Empty example. No rating or navigation appears until publishable reviews are available.</p></div></div></div>
      </div>
    </details>
    <details class="cl-guia-demo" id="select-states"><summary>Shared select spacing · state examples</summary>
      <div class="row cl-guia-rejilla">
        <div class="col-md-6"><label class="cl-etiqueta" for="select-spacing-long">Long option · native select</label><select class="cl-campo" id="select-spacing-long"><option>One source at a time · a long option to inspect indicator spacing</option><option>Short option</option></select></div>
        <div class="col-md-6"><label class="cl-etiqueta" for="select-spacing-disabled">Source unavailable · disabled example</label><select class="cl-campo" id="select-spacing-disabled" disabled><option>Source verification pending</option></select></div>
        <div class="col-md-6"><label class="cl-etiqueta" for="select-spacing-error">Required source · error example</label><select class="cl-campo cl-campo--error" id="select-spacing-error" required aria-invalid="true" aria-describedby="select-spacing-error-help"><option value="">Choose a source</option><option>Internal · example</option></select><p class="cl-mensaje-campo" id="select-spacing-error-help">Static example: choose a source before continuing.</p></div>
      </div>
    </details>
  </div>
</section>
