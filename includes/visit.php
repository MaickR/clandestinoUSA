<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-banda-cta cl-banda-cta--destacada cl-home-visita" id="visit" aria-labelledby="visit-titulo">
  <div class="container">
    <div class="row g-0 cl-banda-cta__fila">
      <div class="col-md-5 cl-banda-cta__media">
        <picture>
          <source srcset="/assets/images/home-r8/visit-480.avif 480w, /assets/images/home-r8/visit-816.avif 816w, /assets/images/home-r8/visit-1254.avif 1254w" sizes="(min-width: 768px) 530px, calc(100vw - 24px)" type="image/avif">
          <source srcset="/assets/images/home-r8/visit-480.webp 480w, /assets/images/home-r8/visit-816.webp 816w, /assets/images/home-r8/visit-1254.webp 1254w" sizes="(min-width: 768px) 530px, calc(100vw - 24px)" type="image/webp">
          <img class="cl-banda-cta__imagen" src="/assets/images/home-r8/visit-1254.jpg" width="1254" height="1254" alt="The Clandestino wine bar with chairs, barrel tables, flowers, and Spanish and U.S. flags" loading="lazy" decoding="async">
        </picture>
      </div>
      <div class="col-md-7 cl-banda-cta__contenido">
        <p class="cl-eyebrow">Visit The Clandestino</p>
        <h2 class="cl-home-visita__titulo" id="visit-titulo">Your next Spanish evening starts here.</h2>
        <p class="cl-seccion__descripcion">Spanish wines, shared plates, and the pleasure of good company. Find us in Mount Shasta.</p>
        <div class="cl-home-visita__datos">
          <address class="cl-contacto cl-home-visita__direccion">
            <p><?php foreach ($datosContacto['direccion'] as $indice => $linea) : ?><?= $indice ? '<br>' : '' ?><?= $escaparNavegacion($linea) ?><?php endforeach; ?></p>
          </address>
          <?php if ($datosContacto['horario']) : ?>
          <div class="cl-contacto cl-home-visita__horario">
            <p><?= implode('<br>', array_map($escaparNavegacion, $datosContacto['horario'])) ?></p>
          </div>
          <?php endif; ?>
        </div>
        <div class="cl-seccion__acciones cl-banda-cta__acciones">
          <a class="cl-boton" href="<?= $escaparNavegacion($rutaReserva) ?>" aria-describedby="visit-solicitud">Request a Table</a>
          <a class="cl-boton cl-boton--secundario" href="<?= $escaparNavegacion($datosContacto['mapa']) ?>" target="_blank" rel="noopener noreferrer">Get Directions<span class="visually-hidden"> (opens Google Maps in a new tab)</span></a>
        </div>
        <p class="cl-home-visita__confirmacion" id="visit-solicitud">Table requests are subject to confirmation.</p>
        <a class="cl-enlace cl-home-visita__telefono" href="<?= $escaparNavegacion($datosContacto['telefono']['url']) ?>">Call Us <span><?= $escaparNavegacion($datosContacto['telefono']['texto']) ?></span></a>
      </div>
    </div>
  </div>
</section>
