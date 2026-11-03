<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-banda-cta cl-home-reserva" id="reservation-invitation" aria-labelledby="reservation-invitation-titulo">
  <div class="container-fluid cl-home-reserva__ancho">
    <div class="row g-0 cl-banda-cta__fila cl-home-reserva__escena">
      <picture class="cl-home-reserva__media">
        <source media="(min-width: 768px)" srcset="/assets/images/avif/gallery/tapas/the-clandestino-tapas-table.avif" type="image/avif">
        <source media="(min-width: 768px)" srcset="/assets/images/webp/gallery/tapas/the-clandestino-tapas-table.webp" type="image/webp">
        <source media="(min-width: 768px)" srcset="/assets/images/gallery/tapas/the-clandestino-tapas-table.jpeg" type="image/jpeg">
        <source srcset="/assets/images/avif/gallery/tapas/the-clandestino-tapas-wines.avif" type="image/avif">
        <source srcset="/assets/images/webp/gallery/tapas/the-clandestino-tapas-wines.webp" type="image/webp">
        <img class="cl-banda-cta__imagen cl-home-reserva__imagen" src="/assets/images/gallery/tapas/the-clandestino-tapas-wines.jpeg" width="1536" height="2048" alt="Spanish cheeses, cured meats, bread, and other tapas arranged for sharing at The Clandestino" loading="lazy" decoding="async">
      </picture>
      <div class="col-12 col-md-7 col-lg-6 cl-banda-cta__contenido cl-home-reserva__contenido">
        <p class="cl-eyebrow">Your next Clandestino moment</p>
        <h2 class="cl-home-reserva__titulo" id="reservation-invitation-titulo">A table worth gathering around.</h2>
        <p class="cl-seccion__descripcion">Spanish wines, tapas to share, and moments worth celebrating. Your next evening starts at The Clandestino.</p>
        <div class="cl-seccion__acciones cl-banda-cta__acciones">
          <a class="cl-boton" href="<?= $escaparNavegacion($rutaReserva) ?>" aria-describedby="reservation-invitation-nota">Request a Table</a>
        </div>
        <p class="cl-home-reserva__nota" id="reservation-invitation-nota">Table requests are subject to confirmation.</p>
      </div>
    </div>
  </div>
</section>
