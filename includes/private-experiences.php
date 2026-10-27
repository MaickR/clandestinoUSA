<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-historia cl-home-privadas" id="private-events" aria-labelledby="private-events-titulo">
  <div class="container cl-home-privadas__composicion">
    <figure class="cl-historia__figura cl-home-privadas__escenario">
      <picture class="cl-experiencia__media">
        <source srcset="/assets/images/private-room-640.avif 640w, /assets/images/private-room-960.avif 960w, /assets/images/private-room-1600.avif 1600w, /assets/images/private-room-2048.avif 2048w" sizes="(min-width: 1400px) 1176px, (min-width: 1200px) 1116px, (min-width: 992px) 936px, (min-width: 768px) 696px, (min-width: 576px) 516px, calc(100vw - 24px)" type="image/avif">
        <source srcset="/assets/images/private-room-640.webp 640w, /assets/images/private-room-960.webp 960w, /assets/images/private-room-1600.webp 1600w, /assets/images/private-room-2048.webp 2048w" sizes="(min-width: 1400px) 1176px, (min-width: 1200px) 1116px, (min-width: 992px) 936px, (min-width: 768px) 696px, (min-width: 576px) 516px, calc(100vw - 24px)" type="image/webp">
        <img class="cl-experiencia__imagen cl-home-privadas__imagen" src="/assets/images/the-clandestino.jpg" width="2048" height="1536" alt="Wine glasses set on the wooden bar, with wine shelves and barrel tables inside The Clandestino" loading="lazy" decoding="async">
      </picture>
    </figure>
    <div class="cl-home-privadas__invitacion">
      <header>
        <p class="cl-eyebrow">Private Experiences</p>
        <h2 class="cl-historia__declaracion cl-home-privadas__titulo" id="private-events-titulo">The evening, held for you.</h2>
      </header>
      <p class="cl-seccion__descripcion cl-historia__texto cl-home-privadas__relato">A birthday toast. An anniversary dinner. An evening with the people who matter. Tell us what you have in mind, and let's explore the possibilities at The Clandestino.</p>
      <div class="cl-seccion__acciones">
        <a class="cl-boton" href="/contact.html#contact-form">Tell Us About Your Occasion</a>
      </div>
    </div>
  </div>
</section>
