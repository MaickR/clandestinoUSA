<section class="cl-seccion cl-seccion--alterna" id="w7-reserva" aria-labelledby="w7-reserva-titulo" data-cl-reserva>
  <div class="container"><div class="row cl-transaccion__rejilla">
    <div class="col-md-5"><p class="cl-eyebrow">03 · Make room for an evening</p><h2 class="cl-titulo-1" id="w7-reserva-titulo">Your place at the table.</h2><p>Good conversation, something to share, and a little time for Spain.</p><?php $fotoEditorial('interior', 'cl-transaccion__foto'); ?><p class="cl-transaccion__nota mt-4">Restaurant photography · All dates and time slots below are examples, not live availability.</p><div class="cl-resumen"><h3>Your visit · preview</h3><p class="cl-reserva__seleccion" data-cl-reserva-resumen>Choose a date and party size to explore example times.</p><p class="cl-transaccion__nota">Restaurant local time · America/Los_Angeles.</p></div></div>
    <div class="col-md-7"><div class="cl-transaccion__panel">
      <form method="dialog" novalidate data-cl-reserva-busqueda>
        <p class="cl-eyebrow">01 · Plan your visit</p><h3>Find your evening</h3>
        <div class="row cl-transaccion__rejilla cl-reserva__criterios"><div class="col-sm-6"><div class="cl-campo-grupo"><label class="cl-etiqueta" for="w7-reserva-personas">Guests · required</label><select class="cl-campo" id="w7-reserva-personas" required aria-describedby="w7-reserva-personas-error"><?php foreach ([2, 1, 3, 4, 5, 6] as $personas) : ?><option value="<?= $personas ?>"><?= $personas ?> <?= $personas === 1 ? 'guest' : 'guests' ?></option><?php endforeach; ?></select><p id="w7-reserva-personas-error" class="cl-mensaje-campo" data-cl-error="w7-reserva-personas" hidden></p></div></div><div class="col-sm-6"><?php $campoTransaccion('w7-reserva-fecha', 'Restaurant local date', 'date', true); ?></div></div>
        <p class="cl-transaccion__nota">1–6 guests · example limits.</p><button class="cl-boton cl-boton--secundario cl-boton--con-carga" type="submit" data-cl-demo-habilitar disabled><span class="cl-boton__reposo">Find example times</span><span class="cl-boton__carga"><span class="cl-spinner" aria-hidden="true"></span>Finding example times…</span></button>
      </form>
      <div data-cl-reserva-disponibilidad role="status" aria-atomic="true" class="cl-transaccion__resultado"></div>
      <fieldset class="cl-formulario-grupo" data-cl-reserva-horarios hidden><legend class="cl-formulario-grupo__leyenda">02 · Choose a time</legend><p class="cl-transaccion__nota">Restaurant local time · no seats are held.</p><div class="cl-reserva__horas">
        <?php foreach (['17:30' => '5:30 PM', '18:00' => '6:00 PM', '18:30' => '6:30 PM', '19:00' => '7:00 PM', '19:30' => '7:30 PM', '20:00' => '8:00 PM'] as $hora => $textoHora) : ?>
          <label class="cl-opcion cl-reserva__hora"><input class="cl-opcion__control" type="radio" name="w7-horario" value="<?= $hora ?>"<?= $hora === '19:00' ? ' disabled' : '' ?>><span><?= $textoHora ?><?php if ($hora === '19:00') : ?><small class="cl-reserva__nota">Unavailable · demo</small><?php endif; ?></span></label>
        <?php endforeach; ?>
      </div></fieldset>
      <p class="cl-transaccion__nota mt-5" data-cl-reserva-contacto-ayuda>Choose an example time to add your contact details. No table is held.</p>
      <div data-cl-reserva-detalles hidden><div data-cl-checkout="reserva"><?php $pasosTransaccion(); ?>
        <div data-cl-checkout-entrada><p class="cl-eyebrow">03 · Your details</p><h3 tabindex="-1">A few details for your visit</h3><form method="dialog" novalidate>
          <div class="row cl-transaccion__rejilla"><div class="col-md-6"><?php $campoTransaccion('w7-reserva-nombre', 'Example name', 'text', true, 'maxlength="80"'); ?></div><div class="col-md-6"><?php $campoTransaccion('w7-reserva-email', 'Example email', 'email', true, 'maxlength="120" placeholder="guest@example.test"'); ?></div></div>
          <?php $campoTransaccion('w7-reserva-telefono', 'Phone for visit updates', 'tel', false, 'maxlength="40" inputmode="tel"'); ?>
          <?php $campoTransaccion('w7-reserva-notas', 'Preferences or notes', 'textarea', false); ?>
          <p class="cl-transaccion__nota">Preferences are requests. Please discuss dietary needs with the restaurant.</p><button class="cl-boton" type="submit" data-cl-demo-habilitar disabled>Review example reservation</button>
        </form></div>
        <?php $revisionTransaccion('Review your requested visit', 'Preview reservation request'); $resultadoTransaccion(); ?>
      </div>
      </div>
      <?php $escenarioTransaccion('reservation', ['disponible' => 'Example times / confirmed demo', 'sin-horas' => 'No availability', 'error' => 'Availability error', 'perdido' => 'Time lost during confirmation', 'pendiente' => 'Request pending']); ?>
    </div></div>
  </div></div>
</section>

<section class="cl-seccion" id="w7-gestion" aria-labelledby="w7-gestion-titulo" data-cl-gestion>
  <div class="container"><div class="row cl-transaccion__rejilla"><div class="col-md-5"><p class="cl-eyebrow">Booking management · future</p><h2 id="w7-gestion-titulo">Plans can change.</h2><p>A clear summary, a considered next step. A future service will verify the booking holder before showing or changing a reservation.</p><p class="cl-transaccion__nota">This fictional record is independent of the reservation form. No account is required to view the component.</p></div><div class="col-md-7"><article class="cl-resumen"><h3>Example reservation</h3><p class="cl-estado">Confirmed · simulation only</p><dl class="cl-transaccion__datos"><dt>Reference</dt><dd>DEMO-BOOK-001</dd><dt>Visit</dt><dd>May 18, 2028 · 6:00 PM PDT<br>America/Los_Angeles</dd><dt>Guests</dt><dd>2 · fixture</dd><dt>Cancellation / change policy</dt><dd>Awaiting commercial confirmation</dd></dl>
    <div class="cl-transaccion__acciones"><button class="cl-boton cl-boton--secundario" type="button" data-cl-gestion-cambio>Explore a change</button><button class="cl-boton cl-boton--secundario" type="button" data-cl-gestion-cancelar>Explore cancellation</button></div>
    <div data-cl-gestion-confirmacion hidden><p><strong>Preview a cancellation request?</strong></p><p>This affects only the example. Real eligibility and any conditions must be checked before a cancellation.</p><div class="cl-transaccion__acciones"><button class="cl-boton" type="button" data-cl-gestion-confirmar>Confirm cancellation · demo</button><button class="cl-boton cl-boton--secundario" type="button" data-cl-gestion-conservar>Keep example booking</button></div></div>
    <div data-cl-gestion-modificacion hidden><label class="cl-etiqueta" for="w7-gestion-notas">Proposed change · fictional details</label><textarea class="cl-campo" id="w7-gestion-notas" maxlength="300"></textarea><div class="cl-transaccion__acciones"><button class="cl-boton" type="button" data-cl-gestion-enviar>Preview change request</button><button class="cl-boton cl-boton--secundario" type="button" data-cl-gestion-atras>Back to booking</button></div></div>
    <div data-cl-gestion-resultado role="status" tabindex="-1" aria-atomic="true"></div>
    <?php $escenarioTransaccion('management', ['pendiente' => 'Request pending', 'exito' => 'Change / cancellation confirmed · demo', 'politica' => 'Policy review required', 'error' => 'Recoverable error']); ?>
  </article></div></div></div>
</section>
