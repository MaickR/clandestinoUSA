<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-historia cl-home-vinos" id="spanish-wines" aria-labelledby="spanish-wines-titulo">
  <div class="container">
    <div class="cl-home-vinos__composicion">
      <header class="cl-home-vinos__cabecera">
        <p class="cl-eyebrow">Our Flagship Wine</p>
        <div class="cl-home-vinos__identidad">
          <h2 class="cl-display" id="spanish-wines-titulo">Pure Soul</h2>
          <p class="cl-home-vinos__firma">NTC &amp; Sons</p>
        </div>
      </header>
      <figure class="cl-home-vinos__protagonista">
        <picture class="cl-home-vinos__retrato">
          <source srcset="/assets/images/avif/pure-soul-poster.avif" type="image/avif">
          <source srcset="/assets/images/webp/pure-soul-poster.webp" type="image/webp">
          <img class="cl-vino__imagen cl-home-vinos__botella" src="/assets/images/pure-soul-poster.jpg" width="768" height="1024" alt="Pure Soul by NTC &amp; Sons, shown in the existing promotional artwork with a complete bottle and grapes" loading="lazy" decoding="async">
        </picture>
      </figure>
      <div class="cl-home-vinos__relato">
        <p class="cl-historia__declaracion cl-home-vinos__entrada">Spanish roots.<br>A soul of its own.</p>
        <p class="cl-seccion__descripcion">Discover Pure Soul, a Spanish red with a character of its own. Made for slow evenings and shared plates, it opens the door to our wider selection of Spanish wines.</p>
        <div class="cl-seccion__acciones">
          <a class="cl-boton" href="/wines.html">Explore the Wine Shop</a>
        </div>
      </div>
    </div>
  </div>
</section>
