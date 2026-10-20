<?php require __DIR__ . '/transacciones-componentes.php'; ?>
<div class="cl-transaccion cl-estructura" data-cl-wave-7 data-cl-navegacion>
  <section class="cl-seccion cl-seccion--alterna" id="wave-7" aria-labelledby="wave-7-titulo">
    <div class="container">
      <div class="row cl-media-contenido">
        <div class="col-md-7 cl-media-contenido__contenido"><p class="cl-eyebrow">Wave 7 · From an invitation to a plan</p><h2 class="cl-titulo-1" id="wave-7-titulo">A little closer to your table.</h2><p class="cl-seccion__descripcion">Choose something to share. Make time for an evening. Give someone a taste of Spain.</p><p>Transactional design previews for The Clandestino. Every amount, time slot, status and reference is a demonstration. Nothing here can be purchased, booked or activated.</p><a class="cl-boton" href="#w7-carrito">Explore the order experience</a></div>
        <div class="col-md-5 cl-media-contenido__media"><?php $fotoEditorial('mesa', 'cl-media-contenido__imagen'); ?></div>
      </div>
      <nav aria-label="Wave 7 families"><ul class="cl-guia-indice">
        <?php foreach (['carrito' => 'Cart & summary', 'checkout' => 'Pickup & checkout', 'pago' => 'Payment & recovery', 'reserva' => 'Reservations', 'gestion' => 'Booking management', 'regalo' => 'Gift Card checkout', 'club' => 'Membership checkout', 'evento' => 'Event registration', 'estados' => 'Transaction & inquiry states', 'cuenta' => 'Account preview'] as $ancla => $etiqueta) : ?>
          <li><a class="cl-enlace" href="#w7-<?= $ancla ?>"><?= $etiqueta ?></a></li>
        <?php endforeach; ?>
      </ul></nav>
      <noscript><p class="cl-alerta">JavaScript is required for local previews. No transaction service is connected.</p></noscript>
    </div>
  </section>
  <?php
  // Los partials aprobados reciben únicamente rutas locales de demostración.
  $escaparNavegacion = $escaparTransaccion;
  $atributoDestinoNavegacion = '';
  $rutasNavegacion = ['Home' => '#wave-7', 'Experiences' => '#experiencias', 'Restaurant' => '#productos-menu', 'Wine Shop' => '#productos-vinos'];
  $rutasDescubrir = ['Gift Cards' => '#w7-regalo', 'Wine Club' => '#w7-club', 'Events' => '#w7-evento'];
  $enlacesPieDescubrir = $rutasDescubrir + ['Private Experiences' => '#private-experiences'];
  $rutaReserva = '#w7-reserva';
  $carritoNavegacion = ['destino' => '#w7-carrito'];
  $destinoActivo = '';
  $logoNavegacion = '/assets/images/clandestino-logo-ui.svg';
  $datosContacto = ['direccion' => ['Mount Shasta, California'], 'mapa' => null, 'telefono' => null, 'email' => null, 'horario' => []];
  $redesSociales = [];
  $enlacesLegales = [];
  $descripcionPie = 'Spanish hospitality, from the first invitation to the details of your visit. Local demonstration only.';
  require __DIR__ . '/acceso-wave-6.php';
  require __DIR__ . '/cabecera-wave-6.php';
  require __DIR__ . '/carrito-checkout-wave-7.php';
  require __DIR__ . '/reservas-wave-7.php';
  require __DIR__ . '/comercio-wave-7.php';
  require __DIR__ . '/operaciones-wave-7.php';
  require __DIR__ . '/pie-wave-6.php';
  ?>
</div>
