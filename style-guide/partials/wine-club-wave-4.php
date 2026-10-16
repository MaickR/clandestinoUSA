<section class="cl-seccion" id="wine-club" aria-labelledby="wine-club-titulo">
  <div class="container">
    <div class="row cl-media-contenido">
      <div class="col-md-5 cl-media-contenido__media"><?php $fotoEditorial('vino', 'cl-media-contenido__imagen'); ?></div>
      <div class="col-md-7 cl-media-contenido__contenido">
        <p class="cl-eyebrow">Spanish Wine Club</p><h2 id="wine-club-titulo">Spain, one discovery at a time</h2>
        <p class="cl-seccion__descripcion">Let a bottle introduce you to a place. Explore the stories, regions and flavors that make Spanish wine worth sharing.</p>
        <ul class="cl-membresia__beneficios"><li>A regional point of view</li><li>Wine at the heart of the table</li><li>A reason to keep discovering</li></ul>
        <p class="cl-texto-pequeno">An editorial invitation. The membership examples below come from the archive; included benefits need reconfirmation.</p>
        <a class="cl-boton cl-boton--secundario" href="#club-comparison">Explore the two levels</a>
      </div>
    </div>
    <form id="club-demo" data-cl-comercial-demo novalidate aria-describedby="club-nota">
      <fieldset class="cl-formulario-grupo" id="club-comparison"><legend class="cl-formulario-grupo__leyenda">Choose a membership · local example</legend>
        <p id="club-nota">Historical comparison only. Current prices, billing frequency, benefits and enrollment availability need confirmation. No promotion is advertised.</p>
        <div class="row cl-guia-rejilla">
          <div class="col-md-6"><article class="cl-membresia" data-cl-plan="gold" aria-labelledby="club-gold">
            <p class="cl-eyebrow">A regional introduction · example</p><h3 class="cl-membresia__nombre" id="club-gold">Gold</h3>
            <p>Begin with the character of Aragón.</p>
            <p class="cl-membresia__precio">$99 <span class="cl-membresia__nota">Historical amount · USD<br>Billing frequency unconfirmed</span></p>
            <ul class="cl-membresia__beneficios"><li>Aragón selection</li><li>Four bottles per selection</li><li>Tasting notes &amp; pairings</li></ul>
            <label class="cl-opcion cl-membresia__eleccion" for="club-gold-select"><input class="cl-opcion__control" id="club-gold-select" type="radio" name="club-plan-demo" value="gold" required aria-describedby="club-plan-error"><span class="cl-opcion__texto">Select Gold · demo</span></label>
          </article></div>
          <div class="col-md-6"><article class="cl-membresia cl-membresia--destacada" data-cl-plan="diamond" aria-labelledby="club-diamond">
            <p class="cl-eyebrow">Featured level · example</p><h3 class="cl-membresia__nombre" id="club-diamond">Diamond</h3>
            <p>A wider journey through Spanish bodegas.</p>
            <p class="cl-membresia__precio">Price to confirm<span class="cl-membresia__nota">Historical amounts differ: $199 / $149 USD<br>Billing frequency unconfirmed</span></p>
            <ul class="cl-membresia__beneficios"><li>Selection across Spanish regions</li><li>Four premium bottles</li><li>Private events &amp; priority reservations</li></ul>
            <label class="cl-opcion cl-membresia__eleccion" for="club-diamond-select"><input class="cl-opcion__control" id="club-diamond-select" type="radio" name="club-plan-demo" value="diamond" required aria-describedby="club-plan-error"><span class="cl-opcion__texto">Select Diamond · demo</span></label>
          </article></div>
        </div>
        <p class="cl-mensaje-campo" id="club-plan-error" hidden></p>
      </fieldset>
      <div class="row cl-guia-rejilla">
        <div class="col-md-7"><aside class="cl-catalogo__resumen" aria-labelledby="club-summary-title"><p class="cl-eyebrow">Your membership · demo</p><h3 id="club-summary-title">The next discovery</h3><p id="club-summary" role="status">No membership selected.</p><p class="cl-texto-pequeno">Price, billing schedule, benefits, renewal and cancellation terms must be confirmed before joining.</p><div class="cl-seccion__acciones"><?php $botonComercial('Explore joining'); ?><button class="cl-boton cl-boton--secundario" type="reset">Clear selection</button></div></aside></div>
        <div class="col-md-5"><div class="cl-guia-resultado" id="club-feedback" role="status" aria-atomic="true">Select a level to try the demonstration.</div><p data-cl-demo-confirmacion hidden></p></div>
      </div>
    </form>
    <?php $controlesComerciales('club'); ?>
    <div class="cl-seccion__encabezado"><h3>Before your next discovery</h3></div>
    <div class="cl-acordeon" id="club-faq">
      <?php foreach ([['included', 'What is included?', 'The historical comparison illustrates regional selections and membership benefits. Current bottles, quantities and benefits must be confirmed with the restaurant.'], ['billing', 'How does billing work?', 'Current prices and billing frequency are not confirmed. The archive describes quarterly selections; a selection schedule is not confirmation of a billing agreement.'], ['terms', 'What about renewal and cancellation?', 'Renewal, payment, delivery, eligibility and cancellation terms are awaiting confirmation. This demo does not enroll you or accept any terms.']] as [$clave, $pregunta, $respuesta]) : ?>
      <div class="cl-acordeon__item"><h4 class="cl-acordeon__titulo"><button class="cl-acordeon__control" type="button" data-bs-toggle="collapse" data-bs-target="#club-faq-<?= $clave ?>" aria-expanded="false" aria-controls="club-faq-<?= $clave ?>"><?= $escaparComercial($pregunta) ?> <span aria-hidden="true">+</span></button></h4><div class="collapse" id="club-faq-<?= $clave ?>"><div class="cl-acordeon__contenido"><?= $escaparComercial($respuesta) ?></div></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
