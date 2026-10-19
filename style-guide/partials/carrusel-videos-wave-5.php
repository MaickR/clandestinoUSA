<p class="cl-texto-pequeno cl-texto-secundario" id="videos-carousel-ayuda">Three layout examples, no guest films. Swipe or scroll horizontally; use Left/Right or Home/End when the collection is focused.</p>
<div class="cl-carrusel cl-carrusel--video" data-cl-carrusel data-cl-carrusel-media role="region" aria-roledescription="carousel" aria-labelledby="video-testimonials-titulo">
  <?php $controlesCarrusel('videos-carousel-pista', 'guest film layout'); ?>
  <ul class="cl-carrusel__pista" data-cl-carrusel-pista id="videos-carousel-pista" tabindex="0" aria-label="Pending guest film layouts" aria-describedby="videos-carousel-ayuda">
    <li class="cl-carrusel__item" aria-label="Horizontal layout · example 1 of 3">
      <div class="cl-media-video__pantalla cl-carrusel__media-pendiente"><span class="cl-estado">Video pending · no poster</span></div>
      <div class="cl-carrusel__contexto"><p class="cl-eyebrow">Horizontal · layout example</p><h3>A guest film, in context</h3><p>Video, matching poster, guest authorization and source are pending. No customer statement is represented.</p><details><summary>Text alternative status</summary><p class="cl-media-video__contexto">No film is published. A reviewed transcript and any required visual description must accompany approved media.</p></details></div>
    </li>
    <li class="cl-carrusel__item" aria-label="Portrait layout · example 2 of 3">
      <div class="cl-media-video__pantalla cl-media-video__pantalla--vertical cl-carrusel__media-pendiente cl-carrusel__media-pendiente--vertical"><span class="cl-estado">Portrait film pending</span></div>
      <div class="cl-carrusel__contexto"><p class="cl-eyebrow">Portrait · layout example</p><h3>A different frame, the same care</h3><p>Original orientation retained. Author, poster, permissions and captions remain unconfirmed.</p><details><summary>Text alternative status</summary><p class="cl-media-video__contexto">No guest speech or image is available for reproduction. Transcript pending.</p></details></div>
    </li>
    <li class="cl-carrusel__item" aria-label="Unavailable film · example 3 of 3">
      <div class="cl-carrusel__contexto"><p class="cl-eyebrow">Availability · static example</p><div class="cl-estado-vista cl-estado-vista--error"><h3 class="cl-estado-vista__titulo">Guest film unavailable</h3><p class="cl-estado-vista__texto">The context and text alternative remain outside the player if a future film fails.</p></div><p class="cl-media-video__contexto">No playable media is attached to this example. No Play button or guest poster is shown.</p><details><summary>Text alternative status</summary><p class="cl-media-video__contexto">Transcript pending. In a published collection, approved text would remain readable during a playback error.</p></details></div>
    </li>
  </ul>
</div>
<noscript><p class="cl-texto-pequeno">All layouts remain available by horizontal scrolling without JavaScript. There are no active videos.</p></noscript>
