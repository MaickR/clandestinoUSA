<section class="cl-seccion cl-seccion--alterna" id="gift-cards" aria-labelledby="gift-cards-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Gift Cards</p><h2 id="gift-cards-titulo">Give them a reason to gather</h2><p class="cl-seccion__descripcion">A thoughtful invitation to Spanish flavors, good conversation and a little time together.</p></div>
    <div class="row cl-guia-rejilla">
      <div class="col-md-6">
        <figure><?php $fotoEditorial('panorama', 'cl-regalo__ambiente'); ?><figcaption class="cl-texto-pequeno">From our table · Restaurant archive, not a gift package.</figcaption></figure>
        <article class="cl-regalo" aria-labelledby="gift-preview-title">
          <p class="cl-regalo__marca">The Clandestino USA</p><div><p class="cl-eyebrow">A gift of good company</p><h3 id="gift-preview-title">Your invitation to the table</h3></div>
          <p class="cl-regalo__importe cl-regalo__importe--pendiente" id="gift-preview-amount">Choose an amount</p>
          <div class="cl-regalo__dedicatoria"><p>For <strong id="gift-preview-name">someone special</strong></p><p class="cl-regalo__mensaje" id="gift-preview-message">A little Spain. A moment to share.</p></div>
          <p class="cl-regalo__pie" id="gift-preview-format">Design preview · Presentation to be confirmed</p><p class="cl-regalo__pie">Non-redeemable visual example · No card number or balance.</p>
        </article>
      </div>
      <div class="col-md-6">
        <form id="gift-demo" data-cl-comercial-demo novalidate aria-describedby="gift-help">
          <h3>Make it personal</h3><p id="gift-help">One gift in this preview. Use fictional details; no request is sent. Delivery method and physical / digital availability are not confirmed.</p>
          <fieldset class="cl-formulario-grupo"><legend class="cl-formulario-grupo__leyenda">Gift amount · USD (required)</legend><div class="cl-regalo-importes">
            <?php foreach ([50, 100, 200, 300, 400, 500] as $importe) : ?>
            <label class="cl-opcion cl-regalo-importes__opcion" for="gift-amount-<?= $importe ?>"><input class="cl-opcion__control" id="gift-amount-<?= $importe ?>" type="radio" name="gift-amount-demo" value="<?= $importe ?>" required aria-describedby="gift-amount-error"><span class="cl-opcion__texto">$<?= $importe ?></span></label>
            <?php endforeach; ?>
          </div><p class="cl-mensaje-campo" id="gift-amount-error" hidden></p></fieldset>
          <?php $campoComercial('gift-recipient', 'Recipient name', 'text', false, 'maxlength="60" autocomplete="off"'); ?>
          <?php $campoComercial('gift-message', 'Personal message · up to 300 characters', 'textarea'); ?>
          <aside class="cl-catalogo__resumen" aria-labelledby="gift-summary-title"><p class="cl-eyebrow">Your gift · demo</p><h4 id="gift-summary-title">A gesture, made yours</h4><p id="gift-summary" role="status">No amount selected.</p><p class="cl-texto-pequeno">Delivery, redemption, expiry and refund policies await confirmation. This preview is not a purchase or an issued card.</p><div class="cl-seccion__acciones"><?php $botonComercial('Continue with this gift'); ?><button class="cl-boton cl-boton--secundario" type="reset">Clear gift</button></div><a class="cl-enlace" href="#gift-preview-title">View gift preview</a></aside>
          <div class="cl-guia-resultado" id="gift-feedback" role="status" aria-atomic="true">Choose an amount to preview a gift.</div><p data-cl-demo-confirmacion hidden></p>
        </form>
        <?php $controlesComerciales('gift'); ?>
        <div class="cl-guia-controles-demo"><label class="cl-etiqueta" for="gift-format-demo">Future presentation · visual concepts only</label><select class="cl-campo" id="gift-format-demo"><option value="pending">Presentation unconfirmed</option><option value="digital">Digital concept · not deliverable</option><option value="printed">Printed concept · not issuable</option></select></div>
      </div>
    </div>
  </div>
</section>
