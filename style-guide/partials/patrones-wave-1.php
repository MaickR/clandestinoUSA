<!-- Demostraciones estáticas: la jerarquía de títulos pertenece a esta guía. -->
<section id="patrones-seccion" aria-labelledby="patrones-seccion-titulo">
  <div class="cl-guia-seccion container">
    <h2 id="patrones-seccion-titulo">Section system</h2>
    <p>Wave 1 · Approved structural patterns. These links open existing restaurant pages.</p>
  </div>
  <section class="cl-seccion" aria-labelledby="seccion-editorial-titulo">
    <div class="container">
      <div class="cl-seccion__encabezado col-lg-8">
        <p class="cl-eyebrow">At the table</p>
        <h3 id="seccion-editorial-titulo">A taste of Spain in Mount Shasta</h3>
        <p class="cl-seccion__descripcion">Tapas to share, Spanish wines to discover, and time to enjoy them together.</p>
        <div class="cl-seccion__acciones">
          <a class="cl-boton" href="../tapas.html">Explore the tapas</a>
          <a class="cl-boton cl-boton--secundario" href="../wines.html">Discover the wines</a>
        </div>
      </div>
      <p>Start with something for the table. Let the conversation take its time.</p>
    </div>
  </section>
  <section class="cl-seccion cl-seccion--alterna cl-seccion--centrada" aria-labelledby="seccion-centrada-titulo">
    <div class="container">
      <div class="cl-seccion__encabezado col-lg-8">
        <p class="cl-eyebrow">The Clandestino USA</p>
        <h3 id="seccion-centrada-titulo">Come for the flavors. Stay for the company.</h3>
        <p class="cl-seccion__descripcion">Explore our Spanish tapas and wine selection before your visit.</p>
        <div class="cl-seccion__acciones">
          <a class="cl-boton" href="../menu.html">View the menus</a>
        </div>
      </div>
      <p>Spanish hospitality, here in Northern California.</p>
    </div>
  </section>
</section>

<section id="patrones-hero" aria-labelledby="patrones-hero-titulo">
  <div class="cl-guia-seccion container">
    <h2 id="patrones-hero-titulo">Hero</h2>
    <p>Editorial and interior compositions. Photography and content share one banner at every size.</p>
  </div>
  <section class="cl-hero" aria-labelledby="hero-editorial-titulo">
    <?php
    $hero = [
        'fuentes' => [['tipo' => 'image/avif', 'srcset' => '../assets/images/avif/bg/clandestino-usa.avif'], ['tipo' => 'image/webp', 'srcset' => '../assets/images/webp/bg/clandestino-usa.webp']],
        'imagen' => '../assets/images/bg/clandestino-usa.jpg', 'ancho' => 1880, 'alto' => 920,
        'alt' => 'Wine glasses above the bar and barrel tables at The Clandestino',
        'etiqueta' => 'h3', 'id' => 'hero-editorial-titulo', 'entrada' => 'The Clandestino · Mount Shasta',
        'titulo' => 'A little Spain. A table to share.',
        'descripcion' => 'Spanish tapas, a glass of wine, and the pleasure of good company in Northern California.',
        'acciones' => [['Explore the tapas', '../tapas.html'], ['Ask about a table', '../contact.html#contact-form']],
    ];
    require dirname(__DIR__, 2) . '/includes/hero.php';
    ?>
  </section>
  <div class="cl-guia-seccion container"><p class="cl-texto-pequeno">Interior hero · A shorter introduction for a focused page.</p></div>
  <section class="cl-hero cl-hero--interior" aria-labelledby="hero-interior-titulo">
    <?php
    $hero = [
        'fuentes' => [['tipo' => 'image/avif', 'srcset' => '../assets/images/avif/bg/the-clandestino-usa.avif'], ['tipo' => 'image/webp', 'srcset' => '../assets/images/webp/bg/the-clandestino-usa.webp']],
        'imagen' => '../assets/images/bg/the-clandestino-usa.jpg', 'ancho' => 1920, 'alto' => 1080,
        'alt' => 'Spanish wine bottles displayed inside The Clandestino',
        'etiqueta' => 'h3', 'interior' => true, 'id' => 'hero-interior-titulo', 'entrada' => 'Spanish wines',
        'titulo' => 'Discover a different side of Spain',
        'descripcion' => 'Explore the wines that accompany our table, from familiar regions to new discoveries.',
        'acciones' => [['Explore the wines', '../wines.html']],
    ];
    require dirname(__DIR__, 2) . '/includes/hero.php';
    ?>
  </section>
</section>

<section class="cl-seccion" id="patrones-media" aria-labelledby="patrones-media-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado">
      <h2 id="patrones-media-titulo">Media + content</h2>
      <p class="cl-seccion__descripcion">One structure, two orientations. Both return to image then narrative on small screens.</p>
    </div>
    <section class="row cl-media-contenido" aria-labelledby="media-tapas-titulo">
      <div class="col-md-6 cl-media-contenido__media">
        <picture>
          <source srcset="../assets/images/avif/bg/clandestino-tapas.avif" type="image/avif">
          <source srcset="../assets/images/webp/bg/clandestino-tapas.webp" type="image/webp">
          <img class="cl-media-contenido__imagen" src="../assets/images/bg/clandestino-tapas.jpg" width="1920" height="1080" alt="A sharing platter with cured meats, cheeses, olives, walnuts, and colorful crisps" loading="lazy" decoding="async">
        </picture>
      </div>
      <div class="col-md-6 cl-media-contenido__contenido">
        <p class="cl-eyebrow">Made for sharing</p>
        <h3 id="media-tapas-titulo">Let the table tell the story</h3>
        <p>Tapas invite you to slow down and share. Explore the flavors of Spain, one small plate at a time.</p>
        <ul>
          <li>Spanish cheeses and cured meats</li>
          <li>Small plates to enjoy together</li>
          <li>Wines to accompany the conversation</li>
        </ul>
        <div class="cl-seccion__acciones">
          <a class="cl-boton" href="../tapas.html">View the tapas menu</a>
        </div>
      </div>
    </section>
  </div>
</section>
<section class="cl-seccion cl-seccion--alterna" aria-labelledby="media-vinos-titulo">
  <div class="container">
    <div class="row cl-media-contenido cl-media-contenido--invertido">
      <div class="col-md-6 cl-media-contenido__media">
        <picture>
          <source srcset="../assets/images/avif/bg/the-clandestino-usa.avif" type="image/avif">
          <source srcset="../assets/images/webp/bg/the-clandestino-usa.webp" type="image/webp">
          <img class="cl-media-contenido__imagen" src="../assets/images/bg/the-clandestino-usa.jpg" width="1920" height="1080" alt="A selection of Spanish wine bottles on a table in the restaurant" loading="lazy" decoding="async">
        </picture>
      </div>
      <div class="col-md-6 cl-media-contenido__contenido">
        <p class="cl-eyebrow">From Spain to your glass</p>
        <h3 id="media-vinos-titulo">Every bottle begins a conversation</h3>
        <p>Our Spanish wine selection is part of the experience. Browse the wine menu and find something to explore on your next visit.</p>
        <p class="cl-seccion__descripcion">Good food, good wine, and a table worth lingering over.</p>
      </div>
    </div>
  </div>
</section>

<section id="patrones-cta" aria-labelledby="patrones-cta-titulo">
  <div class="cl-guia-seccion container">
    <h2 id="patrones-cta-titulo">CTA band</h2>
    <p>Featured invitations with photography. Inquiries start a conversation; they do not confirm a booking.</p>
  </div>
  <?php require __DIR__ . '/bandas-cta-destacadas.php'; ?>
</section>
