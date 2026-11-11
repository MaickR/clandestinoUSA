<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-historia cl-home-privadas" id="private-events" aria-labelledby="private-events-titulo" tabindex="-1">
  <div class="container-fluid cl-home-privadas__ancho">
    <div class="cl-home-privadas__composicion">
      <figure class="cl-historia__figura cl-home-privadas__escenario">
        <picture class="cl-experiencia__media">
          <source media="(width < 768px)" srcset="/assets/images/home-r8/private-experiences-movil-1152.avif" type="image/avif">
          <source media="(width < 768px)" srcset="/assets/images/home-r8/private-experiences-movil-1152.webp" type="image/webp">
          <source srcset="/assets/images/home-r8/private-experiences-768.avif 768w, /assets/images/home-r8/private-experiences-1152.avif 1152w, /assets/images/home-r8/private-experiences-1536.avif 1536w" sizes="(min-width: 1200px) calc((100vw - 96px) * .75), calc(100vw - 64px)" type="image/avif">
          <source srcset="/assets/images/home-r8/private-experiences-768.webp 768w, /assets/images/home-r8/private-experiences-1152.webp 1152w, /assets/images/home-r8/private-experiences-1536.webp 1536w" sizes="(min-width: 1200px) calc((100vw - 96px) * .75), calc(100vw - 64px)" type="image/webp">
          <img class="cl-experiencia__imagen cl-home-privadas__imagen" src="/assets/images/home-r8/private-experiences-1536.jpg" width="1536" height="1024" alt="A table set with a charcuterie board, wine glasses and flowers inside The Clandestino" loading="lazy" decoding="async">
        </picture>
      </figure>
      <div class="cl-home-privadas__invitacion">
        <header>
          <p class="cl-eyebrow">Private Experiences</p>
          <h2 class="cl-historia__declaracion cl-home-privadas__titulo" id="private-events-titulo">The evening, held for you.</h2>
        </header>
        <p class="cl-seccion__descripcion cl-historia__texto cl-home-privadas__relato">Bring your celebration to The Clandestino. Tell us about your occasion, group, and plans for an evening of Spanish wines and shared plates. We'll explore the possibilities with you.</p>
        <div class="cl-seccion__acciones">
          <a class="cl-boton" href="/contact.html#contact-form">Plan Your Private Gathering</a>
        </div>
      </div>
    </div>
  </div>
</section>
