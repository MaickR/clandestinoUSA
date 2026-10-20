<?php
// Extensiones de transacción; selección, arte y beneficios viven en Wave 4.
$familiasTransaccion = [
    'regalo' => ['04 · A thoughtful gesture', 'The gift, ready to review.', 'Gift Card', '#gift-cards', 'Choose an amount & personalize', 'Use the Gift Card selection above', 'Preview gift transaction'],
    'club' => ['05 · A continuing discovery', 'Your next chapter in wine.', 'Wine Club', '#wine-club', 'Compare Gold & Diamond', 'Use the membership selected above', 'Preview membership request'],
    'evento' => ['06 · An evening together', 'Make time for something special.', 'Event', '#events', 'Explore the example event', 'Use the event selected above', 'Preview event registration'],
];
?>
<?php foreach ($familiasTransaccion as $familia => [$ceja, $titulo, $nombreFamilia, $origen, $enlace, $importar, $accion]) : ?>
<section class="cl-seccion<?= $familia !== 'club' ? ' cl-seccion--alterna' : '' ?>" id="w7-<?= $familia ?>" aria-labelledby="w7-<?= $familia ?>-titulo" data-cl-comercio="<?= $familia ?>">
  <div class="container"><div class="row cl-transaccion__rejilla">
    <div class="col-lg-5"><p class="cl-eyebrow"><?= $ceja ?></p><h2 class="cl-titulo-1" id="w7-<?= $familia ?>-titulo"><?= $titulo ?></h2>
      <?php if ($familia === 'regalo') : ?>
      <figure class="cl-regalo"><div class="cl-regalo__visual"><img class="cl-regalo__arte" src="../assets/images/gift-cards/gift-card.webp" width="3137" height="2030" alt="Official The Clandestino USA Gift Card front artwork" loading="lazy"></div><figcaption class="cl-regalo__pie">Official artwork · no redeemable value in this preview</figcaption></figure>
      <p>Bring your amount and personal note from the Gift Card designer into a transaction summary.</p>
      <?php elseif ($familia === 'club') : ?>
      <?php $fotoEditorial('vino', 'cl-transaccion__foto'); ?><p class="mt-4">Continue with Gold or Diamond. Membership is an ongoing relationship; its price, billing cadence and renewal terms need to be clear before enrollment.</p>
      <?php else : ?>
      <article class="cl-evento"><p class="cl-eyebrow">Hypothetical event · not announced</p><h3>A journey through Spanish wine</h3><time class="cl-evento__fecha" datetime="2028-05-18T18:00:00-07:00">May 18, 2028 · 6:00 PM PDT</time><p class="cl-transaccion__nota">America/Los_Angeles · Price on inquiry</p><?php $fotoEditorial('maridaje', 'cl-transaccion__foto'); ?></article>
      <?php endif; ?>
      <a class="cl-enlace" href="<?= $origen ?>"><?= $enlace ?></a><p class="cl-transaccion__nota">Choose in the existing Wave 4 example, then return here. Current commercial terms remain unconfirmed.</p>
    </div>
    <div class="col-lg-7"><div class="cl-transaccion__panel" data-cl-checkout="<?= $familia ?>">
      <div class="cl-transaccion__acciones"><button class="cl-boton cl-boton--secundario" type="button" data-cl-comercio-importar><?= $importar ?></button></div>
      <div data-cl-comercio-seleccion class="cl-resumen cl-resumen--compacto"><p>No <?= $nombreFamilia ?> selection imported.</p></div>
      <?php $pasosTransaccion(); ?>
      <div data-cl-checkout-entrada><h3 tabindex="-1"><?= $nombreFamilia ?> · transaction details</h3><form method="dialog" novalidate>
        <?php if ($familia === 'evento') : ?>
          <?php $cantidadTransaccion('w7-evento-cantidad', 'Attendees', 4); ?><p class="cl-transaccion__nota" data-cl-evento-cupos>4 example places · not real capacity. No place is held.</p>
        <?php endif; ?>
        <?php $campoTransaccion('w7-' . $familia . '-email', 'Example contact email', 'email', true, 'maxlength="120" placeholder="guest@example.test"'); ?>
        <?php if ($familia === 'regalo') : ?>
          <dl class="cl-transaccion__datos"><dt>Presentation &amp; delivery</dt><dd>Service not defined. No delivery address is requested.</dd><dt>Payment</dt><dd>Provider and conditions pending</dd><dt>Issuance</dt><dd>Not started · demonstration</dd></dl>
        <?php elseif ($familia === 'club') : ?>
          <dl class="cl-transaccion__datos"><dt>Price &amp; billing cadence</dt><dd>Unconfirmed · no recurring charge authorized</dd><dt>Renewal date</dt><dd>Not scheduled</dd></dl>
          <details><summary class="cl-enlace">Read the example membership conditions</summary><p>Demonstration conditions: this preview creates no membership, payment agreement or recurring charge. A real offer must first state the confirmed price, billing cadence, included benefits, renewal and cancellation terms.</p></details>
          <label class="cl-opcion" for="w7-club-terminos"><input class="cl-opcion__control" id="w7-club-terminos" type="checkbox" required aria-describedby="w7-club-terminos-error"><span>I accept the example conditions for this local preview only · required</span></label><p class="cl-mensaje-campo" id="w7-club-terminos-error" data-cl-error="w7-club-terminos" hidden></p>
        <?php else : ?>
          <p class="cl-transaccion__nota">A real registration needs confirmed availability, price and event conditions. No waitlist is offered in this example.</p>
        <?php endif; ?>
        <button class="cl-boton" type="submit" data-cl-demo-habilitar disabled>Review <?= $nombreFamilia ?> preview</button>
      </form></div>
      <?php $revisionTransaccion('Review your ' . $nombreFamilia . ' preview', $accion); $resultadoTransaccion(); ?>
      <?php $escenarioTransaccion($familia, $familia === 'evento' ? ['pendiente' => 'Registration pending', 'exito' => 'Registered · demo', 'agotado' => 'Sold out', 'error' => 'Recoverable failure'] : ['pendiente' => 'Payment / activation pending', 'exito' => 'Confirmation · demonstration only', 'error' => 'Recoverable failure']); ?>
    </div></div>
  </div></div>
</section>
<?php endforeach; ?>
