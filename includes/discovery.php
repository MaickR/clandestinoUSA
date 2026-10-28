<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-seccion--alterna cl-home-editorial" id="spanish-table" aria-labelledby="welcome-titulo">
  <div class="container cl-home-editorial__contenedor">
    <header class="cl-seccion__encabezado cl-seccion__encabezado--ornamentado cl-home-editorial__entrada">
      <p class="cl-eyebrow">Welcome to The Clandestino</p>
      <h2 class="cl-display" id="welcome-titulo">A little Spain. A world to discover.</h2>
      <p class="cl-seccion__descripcion">Spanish wines, authentic tapas, and thoughtful gifts. Discover the flavors and experiences waiting for you in Mount Shasta.</p>
    </header>
    <div class="cl-home-editorial__galeria">
      <article class="cl-home-editorial__pieza cl-home-editorial__pieza--vinos" aria-labelledby="discovery-vinos-titulo">
        <picture><source srcset="/assets/images/avif/wines.avif" type="image/avif"><source srcset="/assets/images/webp/wines.webp" type="image/webp"><img src="/assets/images/wines.jpeg" width="1536" height="2048" alt="A selection of Spanish red and white wine bottles at The Clandestino" loading="lazy" decoding="async"></picture>
        <div class="cl-home-editorial__relato"><h3 id="discovery-vinos-titulo">Spanish Wines</h3><p class="cl-seccion__descripcion">Discover wines with character, chosen for sharing.</p><a class="cl-boton cl-boton--secundario" href="/wines.html">Explore Wines</a></div>
      </article>
      <article class="cl-home-editorial__pieza cl-home-editorial__pieza--tapas" aria-labelledby="spanish-table-titulo">
        <picture><source srcset="/assets/images/avif/tapas.avif" type="image/avif"><source srcset="/assets/images/webp/tapas.webp" type="image/webp"><img src="/assets/images/tapas.jpeg" width="1695" height="2048" alt="Spanish cheeses, cured sausage and fresh bread on a wooden tapas board" loading="lazy" decoding="async"></picture>
        <div class="cl-home-editorial__relato"><h3 id="spanish-table-titulo">Spanish Tapas &amp; Take Away</h3><p class="cl-seccion__descripcion">Small plates to share. Ask us about Take Away.</p><a class="cl-boton cl-boton--secundario" href="/tapas.html">Explore Tapas</a></div>
      </article>
      <article class="cl-home-editorial__pieza cl-home-editorial__pieza--regalos" aria-labelledby="discovery-hampers-titulo">
        <picture><img src="/assets/images/hampers/basket-01.webp" width="1536" height="2048" alt="A gourmet gift hamper with wine and delicacies in a wicker basket" loading="lazy" decoding="async"></picture>
        <div class="cl-home-editorial__relato"><h3 id="discovery-hampers-titulo">Gourmet Hampers</h3><p class="cl-seccion__descripcion">A thoughtful selection for someone special.</p><a class="cl-boton cl-boton--secundario" href="/hampers.html">Discover Hampers</a></div>
      </article>
    </div>
  </div>
</section>
