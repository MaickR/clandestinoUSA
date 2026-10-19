<section class="cl-seccion" id="reviews" aria-labelledby="reviews-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Reviews · fictional examples</p><h2 id="reviews-titulo">The detail behind a rating</h2><p class="cl-seccion__descripcion">A short note or a fuller reflection, with room for context and a considered reply.</p></div>
    <div class="row cl-catalogo">
      <div class="col-lg-7"><?php $tarjetaResena($resenasDemo[1]); ?></div>
      <div class="col-lg-5"><?php $tarjetaResena($resenasDemo[0], true); ?></div>
    </div>
    <details class="cl-guia-demo" id="review-sources"><summary>Review context · partial information &amp; source formats</summary><div class="row cl-guia-rejilla">
      <div class="col-md-6"><article class="cl-resena"><h3>Review details pending</h3><p>Rating, date and author are unavailable. No stars or substitute identity are shown.</p><ul class="cl-resena__meta" aria-label="Review context"><li><span class="cl-resena__fuente">Source: Internal</span> · example</li><li>Not verified</li></ul><p class="cl-texto-pequeno">Incomplete record · not eligible for the public listing.</p></article></div>
      <div class="col-md-6"><div class="cl-estado-vista"><h3 class="cl-estado-vista__titulo">Review unavailable</h3><p class="cl-estado-vista__texto">This example has no public review content. Private or removed text is not repeated.</p><a class="cl-enlace" href="#review-listing">Explore the example collection</a></div></div>
    </div>
    <p class="cl-media-video__contexto">Source formats · metadata placeholders only. No external review, rating, author or original link is represented.</p>
    <div class="row cl-guia-rejilla">
      <?php foreach (['Internal' => 'Restaurant authorship checks and moderation are required before publication.', 'Google' => 'Reproduction permission and a verified original review are pending.', 'Facebook' => 'Reproduction permission is pending. Preserve the original recommendation or rating model.'] as $fuente => $nota) : ?>
      <div class="col-lg-4"><article class="cl-resena cl-resena--compacta"><h3><?= $escaparResena($fuente) ?> · source format</h3><p class="cl-resena__texto"><?= $escaparResena($nota) ?></p><ul class="cl-resena__meta" aria-label="Example source context"><li><span class="cl-resena__fuente">Source: <?= $escaparResena($fuente) ?></span></li><li>Original date pending</li><li>Original URL pending validation</li></ul></article></div>
      <?php endforeach; ?>
    </div></details>
  </div>
</section>

<?php require __DIR__ . '/carrusel-resenas-wave-5.php'; ?>

<section class="cl-seccion cl-seccion--alterna" id="featured-testimonials" aria-labelledby="featured-testimonials-titulo">
  <div class="container">
    <div class="row cl-testimonio">
      <div class="col-md-5"><figure class="cl-media-video__figura"><?php $fotoEditorial('mesa', 'cl-testimonio__imagen'); ?><figcaption class="cl-media-video__contexto cl-texto-pequeno">Restaurant archive · a table setting, not a guest photograph or endorsement.</figcaption></figure></div>
      <div class="col-md-7 col-lg-6 offset-lg-1">
        <p class="cl-eyebrow">Featured testimonial · layout example</p><h2 id="featured-testimonials-titulo">In a guest's own words</h2>
        <figure class="cl-media-video__figura">
          <blockquote class="cl-testimonio__cita">An approved guest quotation will have space to breathe here.</blockquote>
          <figcaption class="cl-testimonio__firma">
            <p class="cl-testimonio__autor">Authorized guest name · placeholder</p>
            <ul class="cl-resena__meta" aria-label="Featured testimonial context"><li><span class="cl-resena__fuente">Source:</span> pending verification</li><li>Date pending · optional</li><li>Rating not provided · optional</li></ul>
            <p class="cl-testimonio__nota">Placeholder copy · not a customer quotation. Reproduction permission pending.</p>
          </figcaption>
        </figure>
        <p>An approved guest perspective will retain its original context.</p>
        <a class="cl-boton cl-boton--secundario" href="#review-listing">Explore the review examples</a>
      </div>
    </div>
  </div>
</section>

<section class="cl-seccion" id="video-testimonials" aria-labelledby="video-testimonials-titulo">
  <div class="container cl-media-video">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Video Testimonials · content pending</p><h2 id="video-testimonials-titulo">A voice, a moment, a story</h2><p class="cl-seccion__descripcion">Space for an authorized guest film, with captions and a complete text alternative. No guest video is available for this demonstration.</p></div>
    <?php require __DIR__ . '/carrusel-videos-wave-5.php'; ?>
    <details class="cl-guia-demo"><summary>Playback error &amp; native player contract</summary>
    <div class="cl-estado-vista cl-estado-vista--error"><h3 class="cl-estado-vista__titulo">Video could not be played</h3><p class="cl-estado-vista__texto">Static error example. An approved transcript remains outside the player so it can be read even if playback fails.</p></div>
    <p id="video-testimonial-alternativa" class="cl-media-video__contexto">Transcript pending · No approved guest film or matching poster is available. No customer statement is reproduced.</p>
    <!-- Contrato inerte: solo activar con permisos, source, poster y track reales.
         Play/pausa/subtítulos pertenecen al reproductor nativo, sin autoplay. -->
    <template id="contrato-video-testimonio"><video class="cl-media-video__pantalla" controls playsinline preload="none" width="1920" height="1080" aria-label="Authorized guest testimonial" aria-describedby="video-testimonial-alternativa"><p>Video unavailable. Read the adjacent text alternative.</p></video></template>
    </details>
  </div>
</section>
