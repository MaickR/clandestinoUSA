<section class="cl-seccion cl-seccion--alterna" id="gift-cards" aria-labelledby="gift-cards-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">The Clandestino USA · Gift Cards</p><h2 class="cl-titulo-1" id="gift-cards-titulo">Give a little Spain</h2><p class="cl-seccion__descripcion">For the friend who loves a good wine. For the couple who always makes time for tapas. Give them an invitation to their own Clandestino moment.</p></div>
    <form id="gift-demo" data-cl-comercial-demo novalidate aria-describedby="gift-help">
      <p class="cl-texto-pequeno" id="gift-help">Choose an amount, add a personal note and review your gift. This is a local preview: no purchase or card issuance takes place. Use fictional details.</p>
      <div class="row cl-guia-rejilla">
        <div class="col-md-6">
          <fieldset class="cl-formulario-grupo"><legend class="cl-formulario-grupo__leyenda">01 · Choose the amount · USD (required)</legend><div class="cl-regalo-importes">
            <?php foreach ([50, 100, 200, 300, 400, 500] as $importe) : ?>
            <label class="cl-opcion cl-regalo-importes__opcion" for="gift-amount-<?= $importe ?>"><input class="cl-opcion__control" id="gift-amount-<?= $importe ?>" type="radio" name="gift-amount-demo" value="<?= $importe ?>" data-cl-regalo-arte="../assets/images/gift-cards/gift-card-reves-<?= $importe ?>.webp" required aria-describedby="gift-amount-error"><span class="cl-opcion__texto">$<?= $importe ?></span></label>
            <?php endforeach; ?>
          </div><p class="cl-mensaje-campo" id="gift-amount-error" hidden></p></fieldset>
          <fieldset class="cl-formulario-grupo"><legend class="cl-formulario-grupo__leyenda">02 · Make it personal</legend>
            <?php $campoComercial('gift-recipient', 'Recipient name', 'text', false, 'maxlength="60" autocomplete="off"'); ?>
            <?php $campoComercial('gift-message', 'Personal message · up to 300 characters', 'textarea'); ?>
            <p class="cl-texto-pequeno">A name and a note are optional. Your dedication appears beside the card; the official artwork stays intact.</p>
            <a class="cl-enlace" href="#gift-preview-title">See your gift preview</a>
          </fieldset>
        </div>
        <div class="col-md-6">
          <figure class="cl-regalo" aria-labelledby="gift-preview-title">
            <p class="cl-regalo__paso">03 · Your gift, taking shape</p><h3 id="gift-preview-title">An invitation with their name on it</h3>
            <div class="cl-regalo__visual" id="gift-art-frame">
              <img class="cl-regalo__arte" id="gift-preview-art" src="../assets/images/gift-cards/gift-card.webp" width="3137" height="2030" alt="Official The Clandestino USA Gift Card front design" loading="lazy" decoding="async">
              <div class="cl-regalo__espera" id="gift-art-loading" hidden aria-hidden="true"><span class="cl-skeleton cl-skeleton--superficie"></span></div>
              <div class="cl-estado-vista cl-regalo__fallo" id="gift-art-error" hidden><p class="cl-estado-vista__texto">Card artwork unavailable. Your amount and dedication remain readable below.</p><button class="cl-boton cl-boton--secundario" id="gift-art-retry" type="button">Retry card artwork</button></div>
            </div>
            <div class="cl-regalo__controles" role="group" aria-label="Gift Card artwork views"><button class="cl-boton cl-boton--secundario" id="gift-view-front" type="button" aria-pressed="true">Front</button><button class="cl-boton cl-boton--secundario" id="gift-view-amount" type="button" aria-pressed="false" disabled>Amount side</button></div>
            <p class="cl-regalo__importe" id="gift-preview-amount">Choose an amount to see its card design</p>
            <div class="cl-regalo__dedicatoria"><p>For <strong id="gift-preview-name">someone special</strong></p><p class="cl-regalo__mensaje" id="gift-preview-message">A little Spain. A moment to share.</p></div>
            <p class="cl-regalo__pie">Personal note preview · Not printed onto the official artwork.</p>
            <figcaption class="cl-regalo__pie" id="gift-art-caption" role="status">Official artwork · Front · Non-redeemable preview</figcaption>
          </figure>
        </div>
      </div>
      <aside class="cl-catalogo__resumen cl-regalo__resumen" aria-labelledby="gift-summary-title">
        <div class="row cl-guia-rejilla"><div class="col-md-7"><p class="cl-regalo__paso">04 · Review your gift</p><h3 id="gift-summary-title">A thoughtful gesture, ready to explore</h3><p id="gift-summary" role="status">No amount selected.</p><p class="cl-texto-pequeno">One Gift Card preview. Presentation and delivery are not yet defined; no delivery information is requested.</p></div><div class="col-md-5"><div class="cl-seccion__acciones"><?php $botonComercial('Continue with this gift'); ?><button class="cl-boton cl-boton--secundario" type="reset">Clear gift</button></div><p class="cl-texto-pequeno">This action demonstrates a request preview. It does not buy or activate a Gift Card.</p></div></div>
        <div class="cl-guia-resultado" id="gift-feedback" role="status" aria-atomic="true">Your selection will appear here as you build your gift.</div><p data-cl-demo-confirmacion hidden></p>
      </aside>
    </form>
    <aside aria-labelledby="gift-policies-title"><h3 id="gift-policies-title">Before gifting</h3><p class="cl-texto-pequeno">Official artwork is supplied by the owner. Printed wording is part of that artwork; current redemption, expiry, refund, presentation and delivery terms still need confirmation. This preview carries no redeemable code or balance.</p></aside>
    <details class="cl-guia-demo"><summary>Gift Cards · Demo controls &amp; future presentation</summary>
      <?php $controlesComerciales('gift'); ?>
      <div class="cl-guia-controles-demo"><label class="cl-etiqueta" for="gift-format-demo">Future presentation · visual concepts only</label><select class="cl-campo" id="gift-format-demo"><option value="pending">Presentation unconfirmed</option><option value="digital">Digital concept · not deliverable</option><option value="printed">Printed concept · not issuable</option></select><p class="cl-texto-pequeno" id="gift-preview-format">Design preview · Presentation to be confirmed</p></div>
    </details>
  </div>
</section>
