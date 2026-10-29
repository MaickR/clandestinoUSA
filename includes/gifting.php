<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-home-regalos" id="gifting" aria-labelledby="gifting-titulo">
  <div class="container">
    <header class="cl-seccion__encabezado cl-seccion__encabezado--ornamentado cl-home-regalos__cabecera">
      <p class="cl-eyebrow">Gifts &amp; Gourmet Hampers</p>
      <h2 class="cl-display cl-home-regalos__titulo" id="gifting-titulo">A taste of Spain, <em>ready to give.</em></h2>
      <p class="cl-seccion__descripcion">Thoughtfully curated hampers and gift cards for celebrations, thank-yous, and meaningful moments.</p>
    </header>
    <div class="cl-home-regalos__composicion">
      <figure class="cl-home-regalos__seleccion">
        <img class="cl-home-regalos__imagen" src="/assets/images/hampers/basket-05.webp" width="1536" height="2048" alt="A wicker hamper filled with Spanish wines, gourmet delicacies and red flowers on a wooden table" loading="lazy" decoding="async">
        <figcaption class="cl-home-regalos__firma">Selected with care. Given with love.</figcaption>
      </figure>
      <article class="cl-home-regalos__hampers" aria-labelledby="gifting-hampers-titulo">
        <p class="cl-eyebrow">The Gifting Atelier</p>
        <h3 class="cl-home-regalos__subtitulo" id="gifting-hampers-titulo">The art of <em>giving well.</em></h3>
        <p class="cl-seccion__descripcion">Carefully curated gourmet hampers, bringing Spanish flavours together for the people and moments that matter.</p>
        <div class="cl-seccion__acciones">
          <a class="cl-boton" href="/hampers.html">Explore Hampers</a>
        </div>
      </article>
      <article class="cl-home-regalos__tarjeta" aria-labelledby="gifting-card-titulo">
        <img class="cl-home-regalos__arte" src="/assets/images/gift-cards/gift-card.webp" width="3137" height="2030" alt="The Clandestino USA Gift Card, with gold lettering and wine illustrations on a dark background" loading="lazy" decoding="async">
        <div class="cl-home-regalos__invitacion">
          <h3 id="gifting-card-titulo">A Clandestino moment, <em>their way.</em></h3>
          <p class="cl-seccion__descripcion">Thinking of a Gift Card? Let’s explore a thoughtful way to give The Clandestino.</p>
          <div class="cl-seccion__acciones">
            <a class="cl-boton cl-boton--secundario" href="/contact.html#contact-form">Ask About Gift Cards</a>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>
