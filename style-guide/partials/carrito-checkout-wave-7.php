<section class="cl-seccion" id="w7-carrito" aria-labelledby="w7-carrito-titulo" data-cl-carrito>
  <div class="container">
    <div class="cl-transaccion__cabecera"><p class="cl-eyebrow">01 · For your table · local demonstration</p><h2 id="w7-carrito-titulo">Good things, brought together.</h2><p class="cl-seccion__descripcion">A sharing board. A bottle to discover. Review the details of your example order.</p><p class="cl-transaccion__nota">All amounts are synthetic USD fixtures. Inventory, taxes and service availability are unconfirmed.</p></div>
    <div class="row cl-transaccion__rejilla">
      <div class="col-lg-8">
        <ul class="cl-carrito__lineas">
          <?php foreach ([['tabla', 'Cheese & charcuterie board', 'Sharing board · example portion', 'webp/gallery/tapas/the-clandestino-tapas-6.webp', 'Sharing board with cheese and cured meats', '$36.00', false], ['vino', 'PURE SOUL', 'Bottle · photographed label, vintage unconfirmed', 'webp/wines/PURE-SOUL.webp', 'PURE SOUL wine bottle', '$45.00', true]] as [$clave, $nombre, $variante, $imagen, $alt, $precio, $esVino]) : ?>
          <li class="cl-carrito__linea" data-cl-linea="<?= $clave ?>">
            <article aria-labelledby="w7-<?= $clave ?>-titulo"><div class="cl-carrito__producto"><img class="cl-carrito__foto<?= $esVino ? ' cl-carrito__foto--vino' : '' ?>" src="../assets/images/<?= $imagen ?>" alt="<?= $alt ?>" width="96" height="96" loading="lazy"><div><h3 class="cl-carrito__nombre" id="w7-<?= $clave ?>-titulo"><?= $nombre ?></h3><p class="cl-transaccion__nota"><?= $variante ?></p><p class="cl-carrito__precio"><?= $precio ?> <span class="cl-transaccion__nota">/ unit · example</span></p><p class="cl-transaccion__nota" data-cl-linea-estado>Availability is illustrative</p></div></div>
              <div class="cl-carrito__controles"><?php $cantidadTransaccion('w7-' . $clave . '-cantidad', $esVino ? 'Bottles' : 'Boards', 6); ?><p class="cl-carrito__precio">Line subtotal · demo <strong data-cl-linea-subtotal><?= $precio ?></strong></p><button class="cl-boton cl-boton--secundario" type="button" data-cl-quitar="<?= $clave ?>">Remove <span class="visually-hidden"><?= $nombre ?></span></button></div>
            </article>
          </li>
          <?php endforeach; ?>
        </ul>
        <div class="cl-estado-vista" data-cl-carrito-vacio hidden><h3 class="cl-estado-vista__titulo">Something delicious starts here.</h3><p class="cl-estado-vista__texto">Your example cart is empty. Add something below to explore the next step.</p></div>
        <div class="cl-transaccion__acciones"><button class="cl-boton cl-boton--secundario" type="button" data-cl-agregar="tabla">Add a board · demo</button><button class="cl-boton cl-boton--secundario" type="button" data-cl-agregar="vino">Add a bottle · demo</button><a class="cl-enlace" href="#productos-menu">Keep exploring the menu</a></div>
        <div data-cl-carrito-mensaje role="status" aria-atomic="true"></div>
      </div>
      <div class="col-lg-4">
        <aside class="cl-resumen" aria-labelledby="w7-resumen-titulo"><p class="cl-eyebrow">Your selection · demo</p><h3 id="w7-resumen-titulo">A moment to share</h3><p data-cl-carrito-conteo>2 items · demo</p><dl class="cl-resumen__importes"><div class="cl-resumen__fila"><dt>Items · example</dt><dd data-cl-carrito-total>$81.00</dd></div><div class="cl-resumen__fila"><dt>Tax</dt><dd>Not calculated</dd></div><div class="cl-resumen__fila"><dt>Discount</dt><dd>None applied</dd></div><div class="cl-resumen__fila cl-resumen__total"><dt>Example subtotal</dt><dd data-cl-carrito-total>$81.00</dd></div></dl><p class="cl-transaccion__nota">This is not a final charge. The restaurant must confirm prices, tax, inventory and fulfillment.</p><button class="cl-boton" type="button" data-cl-carrito-continuar disabled>Continue to order details</button></aside>
        <details class="cl-resumen cl-resumen--compacto mt-5"><summary>Compact cart · <span data-cl-carrito-conteo>2 items · demo</span></summary><p>Board &amp; bottle selection. Edit the full cart above.</p><p>Example subtotal: <strong data-cl-carrito-total>$81.00</strong></p><a class="cl-enlace" href="#w7-carrito-titulo">Review items</a></details>
      </div>
    </div>
    <div class="cl-transaccion__acciones"><button class="cl-boton cl-boton--secundario" type="button" data-cl-carrito-reintentar>Refresh example summary</button></div>
    <?php $escenarioTransaccion('cart', ['listo' => 'With products', 'vacio' => 'Empty', 'actualizando' => 'Updating', 'error' => 'Error', 'no-disponible' => 'Item unavailable', 'desactualizado' => 'Outdated summary']); ?>
  </div>
</section>

<section class="cl-seccion cl-seccion--alterna" id="w7-checkout" aria-labelledby="w7-checkout-titulo" data-cl-pedido-checkout>
  <div class="container"><div class="cl-transaccion__cabecera"><p class="cl-eyebrow">02 · Take Away &amp; Order Ahead</p><h2 id="w7-checkout-titulo">The details make it yours.</h2><p class="cl-seccion__descripcion">Pick it up, or tell us about your table. A preference begins the conversation; it does not guarantee a service time.</p></div>
    <div class="row cl-transaccion__rejilla"><div class="col-lg-8"><div class="cl-transaccion__panel" data-cl-checkout="pedido">
      <?php $pasosTransaccion(); ?>
      <div data-cl-checkout-entrada><h3 tabindex="-1">Your order preferences</h3>
        <form method="dialog" novalidate>
          <fieldset class="cl-formulario-grupo"><legend class="cl-formulario-grupo__leyenda">How would you like to enjoy it?</legend><label class="cl-opcion"><input class="cl-opcion__control" type="radio" name="w7-modalidad" value="pickup" checked><span>Pickup · demo</span></label><label class="cl-opcion"><input class="cl-opcion__control" type="radio" name="w7-modalidad" value="mesa"><span>Order ahead / at table · demo</span></label></fieldset>
          <div data-cl-pedido-pickup><div class="row cl-transaccion__rejilla"><div class="col-md-6"><?php $campoTransaccion('w7-pedido-fecha', 'Preferred pickup date', 'date', true, 'data-cl-pedido-fecha'); ?></div><div class="col-md-6"><?php $campoTransaccion('w7-pedido-hora', 'Preferred pickup time', 'time', true); ?></div></div><p class="cl-transaccion__nota">Restaurant local time · America/Los_Angeles. A requested time is not a confirmed collection window.</p></div>
          <div data-cl-pedido-mesa hidden><?php $campoTransaccion('w7-pedido-referencia', 'Table or reservation context', 'text', true, 'maxlength="100" disabled'); ?><p class="cl-transaccion__nota">Use a fictional reference. No table or kitchen system is connected.</p></div>
          <div class="row cl-transaccion__rejilla"><div class="col-md-6"><?php $campoTransaccion('w7-pedido-nombre', 'Example name', 'text', true, 'maxlength="80"'); ?></div><div class="col-md-6"><?php $campoTransaccion('w7-pedido-email', 'Example email', 'email', true, 'maxlength="120" placeholder="guest@example.test"'); ?></div></div>
          <?php $campoTransaccion('w7-pedido-notas', 'Special instructions & dietary considerations', 'textarea', false); ?>
          <p class="cl-transaccion__nota">Use sample text only. Dietary requests require a conversation with the restaurant and cannot be guaranteed by this preview.</p>
          <button class="cl-boton" type="submit" data-cl-demo-habilitar disabled>Review example order</button>
        </form>
      </div>
      <?php $revisionTransaccion('Review your example order', 'Preview order request'); $resultadoTransaccion(); ?>
      <?php $escenarioTransaccion('order', ['pendiente' => 'Request pending', 'exito' => 'Received · demo', 'error' => 'Recoverable failure']); ?>
    </div></div><div class="col-lg-4"><aside class="cl-resumen"><h3>At a glance</h3><ul data-cl-pedido-lineas></ul><dl class="cl-resumen__importes"><div class="cl-resumen__fila"><dt>Example subtotal</dt><dd data-cl-pedido-total>$81.00</dd></div><div class="cl-resumen__fila"><dt>Tax / final total</dt><dd>Awaiting confirmation</dd></div><div class="cl-resumen__fila"><dt>Service availability</dt><dd>Unconfirmed</dd></div></dl><a class="cl-enlace" href="#w7-carrito">Edit your selection</a></aside><p class="cl-transaccion__nota mt-4">Your details stay in this page while you go back and review. Reloading clears the demonstration.</p></div></div>
  </div>
</section>

<section class="cl-seccion" id="w7-pago" aria-labelledby="w7-pago-titulo" data-cl-pago>
  <div class="container"><div class="row cl-transaccion__rejilla"><div class="col-md-5"><p class="cl-eyebrow">Payment · an intentional pause</p><h2 id="w7-pago-titulo">Clarity before commitment.</h2><p>Review the amount and the outcome before taking another step. A payment result belongs to its own operation.</p><p class="cl-transaccion__nota">No payment provider is connected. There are no card fields or saved payment methods.</p></div><div class="col-md-7"><div class="cl-transaccion__panel">
    <h3>Example payment review</h3><dl class="cl-resumen__importes"><div class="cl-resumen__fila"><dt>Fixture items</dt><dd>$81.00</dd></div><div class="cl-resumen__fila"><dt>Fixture tax amount</dt><dd>$0.00 · test data, not a rate</dd></div><div class="cl-resumen__fila"><dt>Fixture discount</dt><dd>$0.00</dd></div><div class="cl-resumen__fila cl-resumen__total"><dt>Demo total</dt><dd>$81.00 USD</dd></div></dl>
    <div class="cl-transaccion__proveedor"><p><strong>Payment service · to be selected</strong></p><p class="cl-transaccion__nota">A future hosted checkout or provider-secured elements will appear here. Do not enter financial details into this demonstration.</p></div>
    <?php $escenarioTransaccion('payment', ['pendiente' => 'Pending', 'exito' => 'Approved · demo', 'rechazado' => 'Declined', 'desconocido' => 'Unknown result', 'expirado' => 'Expired session', 'error' => 'Recoverable error']); ?>
    <div class="cl-transaccion__acciones"><?php $botonTransaccion('Preview payment outcome', 'data-cl-pago-simular'); ?><button class="cl-boton cl-boton--secundario" type="button" data-cl-pago-consultar hidden>Check example result</button><button class="cl-boton cl-boton--secundario" type="button" data-cl-pago-reiniciar>Reset payment demo</button></div>
    <div role="status" aria-atomic="true" tabindex="-1" data-cl-pago-resultado><p class="cl-transaccion__nota">Reference DEMO-PAY-001 · not a receipt. No charge has been made.</p></div>
  </div></div></div></div>
</section>
