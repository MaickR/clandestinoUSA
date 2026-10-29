<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-historia cl-home-club" id="wine-club" aria-labelledby="wine-club-titulo">
  <div class="container cl-home-club__composicion">
    <header class="cl-seccion__encabezado cl-seccion__encabezado--ornamentado cl-home-club__cabecera">
      <p class="cl-eyebrow">The Spanish Wine Club</p>
      <h2 class="cl-display cl-home-club__titulo" id="wine-club-titulo">Discover more of Spain, one wine at a time.</h2>
      <p class="cl-seccion__descripcion cl-home-club__descripcion">Two ways to explore Spanish wine, thoughtfully brought together by The Clandestino.</p>
    </header>
    <article class="cl-membresia cl-membresia--destacada cl-home-club__diamante" aria-labelledby="wine-club-diamond-titulo">
      <p class="cl-eyebrow">The signature tier</p>
      <h3 class="cl-membresia__nombre" id="wine-club-diamond-titulo">Diamond <span class="cl-home-club__tipo">Membership</span></h3>
      <p class="cl-seccion__descripcion cl-membresia__enfoque">Explore our signature Wine Club tier and discover what makes it special.</p>
      <div class="cl-seccion__acciones">
        <a class="cl-boton" href="/swc.html">Explore Diamond</a>
      </div>
    </article>
    <article class="cl-membresia__grupo cl-home-club__oro" aria-labelledby="wine-club-gold-titulo">
      <h3 class="cl-membresia__nombre" id="wine-club-gold-titulo">Gold <span class="cl-home-club__tipo">Membership</span></h3>
      <p class="cl-seccion__descripcion cl-membresia__enfoque">Discover the Gold membership and find your place in the club.</p>
      <div class="cl-seccion__acciones">
        <a class="cl-boton cl-boton--secundario" href="/swc.html">Explore Gold</a>
      </div>
    </article>
    <figure class="cl-home-club__seleccion">
      <picture>
        <source srcset="/assets/images/avif/gallery/wines/the-clandestino-wines-6.avif 2048w" sizes="(min-width: 1400px) 658px, (min-width: 1200px) 623px, (min-width: 992px) 936px, (min-width: 768px) 696px, 288px" type="image/avif">
        <source srcset="/assets/images/webp/gallery/wines/the-clandestino-wines-6.webp 2048w" sizes="(min-width: 1400px) 658px, (min-width: 1200px) 623px, (min-width: 992px) 936px, (min-width: 768px) 696px, 288px" type="image/webp">
        <img class="cl-historia__imagen cl-vino__imagen cl-home-club__imagen" src="/assets/images/gallery/wines/the-clandestino-wines-6.jpeg" width="2048" height="1536" alt="Red and white wine bottles arranged across the wooden bar at The Clandestino, with tasting glasses alongside" loading="lazy" decoding="async">
      </picture>
    </figure>
  </div>
</section>
