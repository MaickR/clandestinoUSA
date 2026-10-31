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
        <img class="cl-banda-cta__imagen" src="/assets/images/inside-clandestino.jpg" width="1440" height="1440" alt="Wine barrels, metal chairs, and Spanish and U.S. flags inside The Clandestino USA" loading="lazy" decoding="async">
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
