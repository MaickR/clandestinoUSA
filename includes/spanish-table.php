<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-seccion--alterna" id="spanish-table" aria-labelledby="spanish-table-titulo">
  <div class="container">
    <div class="row cl-media-contenido">
      <div class="col-md-6 cl-media-contenido__media">
        <picture>
          <source srcset="/assets/images/avif/gallery/tapas/the-clandestino-tapas-table-1.avif" type="image/avif">
          <source srcset="/assets/images/webp/gallery/tapas/the-clandestino-tapas-table-1.webp" type="image/webp">
          <img class="cl-media-contenido__imagen cl-home__mesa" src="/assets/images/gallery/tapas/the-clandestino-tapas-table-1.jpeg" width="2048" height="1536" alt="A Spanish sharing board with cured meats, cheeses, olives, crisps and walnuts" loading="lazy" decoding="async">
        </picture>
      </div>
      <div class="col-md-6 cl-media-contenido__contenido">
        <p class="cl-eyebrow">The Spanish Table</p>
        <h2 id="spanish-table-titulo">The Spanish table, made for sharing.</h2>
        <p class="cl-seccion__descripcion">Start with tapas, pass a board around, and let the conversation find its own pace.</p>
        <div class="cl-seccion__acciones">
          <a class="cl-boton" href="/tapas.html">Explore the Tapas</a>
          <a class="cl-boton cl-boton--secundario" href="<?= $escaparNavegacion($rutaReserva) ?>">Reserve a Table</a>
        </div>
      </div>
    </div>
  </div>
</section>
