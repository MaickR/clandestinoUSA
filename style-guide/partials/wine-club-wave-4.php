<section class="cl-seccion" id="wine-club" aria-labelledby="wine-club-titulo">
  <div class="container">
    <div class="row cl-media-contenido cl-membresia__introduccion">
      <div class="col-md-5 cl-media-contenido__media"><?php $fotoEditorial('vino', 'cl-media-contenido__imagen cl-membresia__imagen'); ?></div>
      <div class="col-md-7 cl-media-contenido__contenido">
        <p class="cl-eyebrow">Spanish Wine Club · The Clandestino</p>
        <h2 class="cl-titulo-1" id="wine-club-titulo">Go beyond a single bottle</h2>
        <p class="cl-seccion__descripcion">For the pleasure of knowing a wine a little better. Its place, its character, and the food you want to share with it.</p>
        <p>The Spanish Wine Club is an invitation to an ongoing relationship with Spanish wine. Explore two membership profiles from our archive: a regional introduction through Gold, or a broader Spanish collection through Diamond.</p>
        <p class="cl-texto-pequeno">Membership is a different commitment from a one-off bottle purchase. Current selections, services and billing cadence need confirmation before joining.</p>
        <div class="cl-seccion__acciones"><a class="cl-boton" href="#club-comparison">Find your membership</a><a class="cl-enlace" href="#club-faq">Before you join</a></div>
      </div>
    </div>
    <form id="club-demo" data-cl-comercial-demo novalidate aria-describedby="club-nota">
      <fieldset class="cl-formulario-grupo" id="club-comparison">
        <legend class="cl-formulario-grupo__leyenda">Two ways into Spanish wine · comparison demo</legend>
        <p id="club-nota" class="cl-texto-pequeno">Archive-based examples, not current offers. Every benefit and price below needs reconfirmation. No promotion or enrollment availability is confirmed.</p>
        <div class="row cl-guia-rejilla">
          <div class="col-md-5"><article class="cl-membresia" data-cl-plan="gold" aria-labelledby="club-gold">
            <p class="cl-eyebrow">01 · Regional discovery</p><h3 class="cl-membresia__nombre" id="club-gold">Gold</h3>
            <p class="cl-membresia__enfoque">An introduction to the character of Aragón.</p>
            <p class="cl-membresia__precio"><span data-cl-plan-precio>$99 <span class="cl-membresia__moneda">USD</span></span><span class="cl-membresia__nota">Historical reference · not a current price</span></p>
            <p class="cl-texto-pequeno">Billing cadence: <span data-cl-plan-periodicidad>to be confirmed</span></p>
            <div class="cl-membresia__grupo"><h4 class="cl-membresia__subtitulo">The wine selection · archive</h4><ul class="cl-membresia__beneficios"><li>Focus on Aragón</li><li>Four bottles per selection</li></ul></div>
            <div class="cl-membresia__grupo"><h4 class="cl-membresia__subtitulo">Alongside the wine · archive</h4><p>Tasting notes and food pairings.</p></div>
            <label class="cl-opcion cl-membresia__eleccion" for="club-gold-select"><input class="cl-opcion__control" id="club-gold-select" type="radio" name="club-plan-demo" value="gold" required aria-describedby="club-plan-error club-nota"><span class="cl-opcion__texto">Choose Gold</span><span class="cl-membresia__indicador" aria-hidden="true"><svg class="cl-icon" focusable="false"><use href="../assets/icons/cl-iconos.svg#cl-icon-exito"></use></svg></span></label>
          </article></div>
          <div class="col-md-7"><article class="cl-membresia cl-membresia--destacada" data-cl-plan="diamond" aria-labelledby="club-diamond">
            <p class="cl-eyebrow">02 · The upper tier · archive</p><h3 class="cl-membresia__nombre" id="club-diamond">Diamond</h3>
            <p class="cl-membresia__enfoque">A wider perspective on Spain. More of its regions, with a different place at the table.</p>
            <p class="cl-membresia__precio"><span data-cl-plan-precio>$199 <span class="cl-membresia__moneda">USD</span></span><span class="cl-membresia__nota">Historical reference · not a current price</span></p>
            <p class="cl-texto-pequeno">Billing cadence: <span data-cl-plan-periodicidad>to be confirmed</span><br>Past promotional reference: $149 USD. No current promotion.</p>
            <div class="cl-membresia__grupo"><h4 class="cl-membresia__subtitulo">The wine selection · archive</h4><ul class="cl-membresia__beneficios"><li>Selection across Spanish regions, beyond a single regional focus</li><li>Four premium bottles per selection</li><li>Tasting notes and pairings</li></ul></div>
            <div class="cl-membresia__grupo"><h4 class="cl-membresia__subtitulo">Additional privileges · archive, unconfirmed</h4><ul class="cl-membresia__beneficios"><li>Members-only private events</li><li>Priority restaurant reservations</li></ul></div>
            <label class="cl-opcion cl-membresia__eleccion" for="club-diamond-select"><input class="cl-opcion__control" id="club-diamond-select" type="radio" name="club-plan-demo" value="diamond" required aria-describedby="club-plan-error club-nota"><span class="cl-opcion__texto">Choose Diamond</span><span class="cl-membresia__indicador" aria-hidden="true"><svg class="cl-icon" focusable="false"><use href="../assets/icons/cl-iconos.svg#cl-icon-exito"></use></svg></span></label>
          </article></div>
        </div>
        <p class="cl-mensaje-campo" id="club-plan-error" hidden></p>
      </fieldset>
      <aside class="cl-catalogo__resumen" aria-labelledby="club-summary-title">
        <div class="row cl-guia-rejilla">
          <div class="col-md-7"><p class="cl-eyebrow">Your membership · local preview</p><h3 id="club-summary-title">The next chapter is yours</h3><p id="club-summary" role="status">No level selected. Choose the profile you would like to explore.</p><dl class="cl-catalogo__datos" id="club-summary-details" hidden><dt>Historical price</dt><dd id="club-summary-price">—</dd><dt>Billing cadence</dt><dd id="club-summary-cadence">—</dd></dl></div>
          <div class="col-md-5"><p class="cl-texto-pequeno">Current price, included benefits, delivery, renewal and cancellation terms must be confirmed before joining.</p><div class="cl-seccion__acciones"><?php $botonComercial('Explore this membership'); ?><button class="cl-boton cl-boton--secundario" type="reset">Clear selection</button></div></div>
        </div>
        <div class="cl-guia-resultado" id="club-feedback" role="status" aria-atomic="true">Choose a level, then explore the next step in this local demo.</div><p data-cl-demo-confirmacion hidden></p>
      </aside>
    </form>
    <div class="cl-seccion__encabezado"><h3>Before your next discovery</h3></div>
    <div class="cl-acordeon" id="club-faq">
      <?php foreach ([['included', 'What distinguishes the two levels?', 'The archive presents Gold as a regional Aragón selection and Diamond as a broader premium selection with additional privileges. These are historical profiles; current bottles, quantities and benefits must be confirmed.'], ['billing', 'What will membership cost, and how often?', 'Gold $99 and Diamond $199 are historical references. Diamond also has a past $149 promotional reference. None is a current offer. Billing cadence is unconfirmed; the archived selection schedule does not establish a current billing agreement.'], ['terms', 'What should I confirm before joining?', 'Ask about current selections, eligibility, delivery, price and billing cadence, renewal and cancellation terms. Choosing a profile here creates no membership or payment agreement.']] as [$clave, $pregunta, $respuesta]) : ?>
      <div class="cl-acordeon__item"><h4 class="cl-acordeon__titulo"><button class="cl-acordeon__control" type="button" data-bs-toggle="collapse" data-bs-target="#club-faq-<?= $clave ?>" aria-expanded="false" aria-controls="club-faq-<?= $clave ?>"><?= $escaparComercial($pregunta) ?> <span aria-hidden="true">+</span></button></h4><div class="collapse" id="club-faq-<?= $clave ?>"><div class="cl-acordeon__contenido"><?= $escaparComercial($respuesta) ?></div></div></div>
      <?php endforeach; ?>
    </div>
    <details class="cl-guia-demo"><summary>Wine Club · Demo controls</summary><?php $controlesComerciales('club'); ?></details>
  </div>
</section>
