<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-historia cl-home-privadas" id="private-events" aria-labelledby="private-events-titulo">
  <div class="container-fluid cl-home-privadas__ancho">
    <div class="cl-home-privadas__composicion">
      <figure class="cl-historia__figura cl-home-privadas__escenario">
        <picture class="cl-experiencia__media">
          <source srcset="/assets/images/private-room-640.avif 640w, /assets/images/private-room-960.avif 960w, /assets/images/private-room-1600.avif 1600w, /assets/images/private-room-2048.avif 2048w" sizes="(min-width: 1200px) calc((100vw - 96px) * .75), (min-width: 768px) calc(100vw - 64px), 1600px" type="image/avif">
          <source srcset="/assets/images/private-room-640.webp 640w, /assets/images/private-room-960.webp 960w, /assets/images/private-room-1600.webp 1600w, /assets/images/private-room-2048.webp 2048w" sizes="(min-width: 1200px) calc((100vw - 96px) * .75), (min-width: 768px) calc(100vw - 64px), 1600px" type="image/webp">
          <img class="cl-experiencia__imagen cl-home-privadas__imagen" src="/assets/images/the-clandestino.jpg" width="2048" height="1536" alt="Wine glasses set on the wooden bar, with wine shelves and barrel tables inside The Clandestino" loading="lazy" decoding="async">
        </picture>
      </figure>
      <div class="cl-home-privadas__invitacion">
        <header>
          <p class="cl-eyebrow">Private Experiences</p>
          <h2 class="cl-historia__declaracion cl-home-privadas__titulo" id="private-events-titulo">The evening, held for you.</h2>
        </header>
        <p class="cl-seccion__descripcion cl-historia__texto cl-home-privadas__relato">Some moments deserve more than an ordinary night out. From intimate celebrations to gatherings around Spanish wines and shared plates, tell us what you have in mind. We'll help you explore the possibilities.</p>
        <div class="cl-seccion__acciones">
          <a class="cl-boton" href="/contact.html#contact-form">Plan Your Private Gathering</a>
        </div>
      </div>
    </div>
  </div>
</section>
