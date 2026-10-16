<?php
// Matrices compactas: cada opción modifica una ficha real, sin pantallas duplicadas.
$estadosComerciales = [
    'membership' => ['Membership lifecycle', 'Gold · example membership', [
        ['available', 'Available', 'exito', 'Enrollment available in this simulated state. Current enrollment is unconfirmed.'],
        ['active', 'Active membership', 'exito', 'Membership active · future visual example. No account or membership exists.'],
        ['renewal', 'Upcoming renewal', 'aviso', 'Renewal date and amount await confirmed account data. No renewal is scheduled.'],
        ['payment', 'Payment pending', 'aviso', 'A future payment status. No charge was attempted; payment recovery belongs to the backend.'],
        ['scheduled', 'Cancellation scheduled', 'aviso', 'Effective date and terms await confirmation. No cancellation action is performed.'],
        ['cancelled', 'Cancelled membership', 'error', 'Future account status only. No access rights are changed.'],
        ['expired', 'Expired membership', 'error', 'Future account status. Renewal eligibility and terms are unconfirmed.'],
    ]],
    'gift-card' => ['Gift Card lifecycle', 'Gift Card · non-redeemable example', [
        ['pending', 'Presentation pending', 'informacion', 'Physical or digital presentation, delivery and policies await confirmation.'],
        ['issued', 'Issued', 'exito', 'Future visual example only. No redeemable card, code or balance exists.'],
        ['delivery', 'Pending delivery', 'aviso', 'Future delivery status. Method, recipient details and timing require confirmation.'],
        ['sent', 'Sent', 'exito', 'Future visual status; no email or physical gift has been sent.'],
        ['redeemed', 'Redeemed', 'informacion', 'Future visual status. No redemption or balance calculation is implemented.'],
        ['expired', 'Expired', 'error', 'Future visual state only, not an expiry policy. Applicable terms await commercial confirmation.'],
    ]],
    'event-state' => ['Event availability', 'A journey through Spanish wine · hypothetical event', [
        ['soon', 'Coming soon', 'informacion', 'Example announcement. Booking details are not yet published.'],
        ['available', 'Available', 'exito', 'Simulated availability only. No seats or inventory have been checked.'],
        ['limited', 'Limited places', 'aviso', 'Simulated limited availability. No capacity or remaining count is asserted.'],
        ['sold', 'Sold out', 'error', 'No selection action is available in this simulated state.'],
        ['ended', 'Ended', 'informacion', 'Past-event visual example. No booking action.'],
        ['cancelled', 'Cancelled', 'error', 'Example cancellation. Refund and contact instructions require verified event data.'],
        ['rescheduled', 'Rescheduled', 'aviso', 'New date pending confirmation. A real notice must retain the previous date and clearly state the verified replacement.'],
        ['tba', 'To be announced', 'informacion', 'Date, time, location and price pending. No placeholder date is presented as confirmed.'],
        ['empty', 'No upcoming events', 'informacion', 'Empty agenda example. Return to the demonstration agenda to explore the layouts.'],
        ['loading', 'Loading events', 'informacion', 'Static loading example. No request is running.'],
        ['error', 'Events could not be loaded', 'error', 'Demo failure. Retry below to restore the simulated available state.'],
    ]],
    'inquiry' => ['Private inquiry lifecycle', 'Private occasion · example inquiry', [
        ['initial', 'Inquiry not submitted', 'informacion', 'Start with an occasion, preferred date and approximate group size.'],
        ['received', 'Inquiry received', 'exito', 'Demonstration only. This status represents a request, never a confirmed reservation.'],
        ['pending', 'Awaiting a response', 'aviso', 'Future inquiry status. No response time or booking confirmation is promised.'],
        ['cancelled', 'Inquiry cancelled', 'informacion', 'Future visual state. No real inquiry or reservation is cancelled.'],
        ['closed', 'Inquiry closed', 'informacion', 'Future visual state. Closing a conversation is not a reservation outcome.'],
    ]],
];
?>
<section class="cl-seccion" id="wave-4-states" aria-labelledby="wave-4-states-title">
  <div class="container"><div class="cl-seccion__encabezado"><p class="cl-eyebrow">State laboratory · examples only</p><h2 id="wave-4-states-title">Clarity beyond the invitation</h2><p class="cl-seccion__descripcion">Explore the lifecycle of each family. These compact examples never change a real account, gift, event or inquiry.</p><p class="cl-texto-pequeno">Initial selection, validation, waiting, failure and successful recovery are interactive in the four family demos above. Promotions are omitted because none is verified.</p></div>
    <div class="row cl-guia-rejilla">
      <?php foreach ($estadosComerciales as $id => [$titulo, $objeto, $opciones]) : ?>
      <div class="col-md-6"><article class="cl-catalogo__resumen" data-cl-estado-comercial aria-labelledby="<?= $id ?>-title">
        <h3 id="<?= $id ?>-title"><?= $escaparComercial($titulo) ?></h3>
        <div class="cl-guia-controles-demo"><label class="cl-etiqueta" for="<?= $id ?>-demo-state">Simulated state · <?= $escaparComercial($titulo) ?></label><select class="cl-campo" id="<?= $id ?>-demo-state">
          <?php foreach ($opciones as [$valor, $nombre, $variante, $mensaje]) : ?>
          <option value="<?= $escaparComercial($valor) ?>" data-cl-variante="<?= $escaparComercial($variante) ?>" data-cl-mensaje="<?= $escaparComercial($mensaje) ?>"><?= $escaparComercial($nombre) ?></option>
          <?php endforeach; ?>
        </select></div>
        <p class="cl-eyebrow">Future visual example</p><h4><?= $escaparComercial($objeto) ?></h4>
        <div data-cl-estado-feedback role="status" aria-atomic="true"><p class="cl-estado"><?= $escaparComercial($opciones[0][1]) ?> · example</p><p><?= $escaparComercial($opciones[0][3]) ?></p></div>
        <div data-cl-estado-skeleton hidden aria-hidden="true"><span class="cl-skeleton"></span><span class="cl-skeleton cl-skeleton--corto"></span></div>
        <?php if ($id === 'event-state') : ?>
        <button class="cl-boton cl-boton--secundario" type="button" data-cl-estado-reintentar hidden>Retry events · demo</button>
        <a class="cl-enlace" href="#events" data-cl-estado-volver hidden>Explore the example agenda</a>
        <button class="cl-boton" type="button" data-cl-estado-no-disponible disabled hidden>No selection available · demo</button>
        <?php endif; ?>
      </article></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
