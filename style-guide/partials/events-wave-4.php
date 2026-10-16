<section class="cl-seccion" id="events" aria-labelledby="events-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Events · Demonstration agenda</p><h2 id="events-titulo">An evening worth making time for</h2><p class="cl-seccion__descripcion">Discover the experience, find the details, choose your next step.</p><p class="cl-texto-pequeno">All event names, dates, hours, prices and availability below are hypothetical. No real event is announced.</p></div>
    <article class="cl-evento cl-evento--destacado" aria-labelledby="event-featured-title">
      <div class="row cl-media-contenido">
        <div class="col-md-5"><div class="cl-evento__media"><?php $fotoEditorial('maridaje', 'cl-evento__imagen'); ?></div></div>
        <div class="col-md-7">
          <p class="cl-eyebrow">Featured · Wine tasting · example</p>
          <time class="cl-evento__fecha" datetime="2028-05-18T18:00:00-07:00"><span class="cl-evento__dia">18 May</span>2028 · 6:00–8:00 PM PDT · America/Los_Angeles</time>
          <h3 id="event-featured-title">A journey through Spanish wine</h3><p>Explore a tasting-led evening around the Spanish table. An example of how a public experience could be presented.</p>
          <div class="cl-evento__datos"><span class="cl-evento__dato"><?= iconoProducto('ubicacion') ?> The Clandestino · Mount Shasta</span><span>Price on inquiry · example</span></div>
          <span class="cl-estado cl-estado--aviso">Limited places · simulated</span><p class="cl-texto-pequeno">Capacity not confirmed. An inquiry would be required; this demo cannot reserve a seat.</p>
          <a class="cl-boton cl-boton--secundario" href="#event-details">Explore this evening</a>
        </div>
      </div>
    </article>
    <div class="cl-acordeon" id="event-details"><div class="cl-acordeon__item"><h3 class="cl-acordeon__titulo"><button class="cl-acordeon__control" type="button" data-bs-toggle="collapse" data-bs-target="#event-detail-panel" aria-expanded="false" aria-controls="event-detail-panel">The evening, in detail · example <span aria-hidden="true">+</span></button></h3><div class="collapse" id="event-detail-panel"><div class="cl-acordeon__contenido">
      <p>Demonstration event · May 18, 2028, 6:00–8:00 PM PDT (America/Los_Angeles). The Clandestino, Mount Shasta. This restaurant photograph is illustrative, not event coverage.</p>
      <h4>A possible rhythm</h4><ol><li>6:00 PM · Welcome and introduction</li><li>6:30 PM · Guided wine discovery</li><li>7:30 PM · Conversation at the table</li></ol>
      <p>Example agenda only. Wines, food, dietary arrangements, accessibility accommodations, capacity, price and booking conditions require confirmation before a real event is published. No seat is held by this demo.</p>
      <a class="cl-enlace" href="#event-selection">Try the event selection</a>
    </div></div></div></div>
    <h3>May 2028 · Example agenda</h3>
    <ol class="cl-eventos-agenda" aria-label="Hypothetical upcoming events in chronological order">
      <li><article class="cl-evento"><div class="row cl-guia-rejilla"><div class="col-md-2"><time class="cl-evento__fecha" datetime="2028-05-18T18:00:00-07:00"><span class="cl-evento__dia">18</span>May 2028</time></div><div class="col-md-7"><p class="cl-eyebrow">Wine tasting · example</p><h4>A journey through Spanish wine</h4><p>Discover Spanish regions around the table.</p><p class="cl-texto-pequeno">6:00–8:00 PM PDT · America/Los_Angeles<br>The Clandestino, Mount Shasta · Price on inquiry</p><span class="cl-estado cl-estado--aviso">Limited places · simulated</span></div><div class="col-md-3"><a class="cl-boton cl-boton--secundario" href="#event-details">View details</a></div></div></article></li>
      <li><article class="cl-evento"><div class="row cl-guia-rejilla"><div class="col-md-2"><time class="cl-evento__fecha" datetime="2028-05-25T17:00:00-07:00"><span class="cl-evento__dia">25</span>May 2028</time></div><div class="col-md-7"><p class="cl-eyebrow">At the table · example</p><h4>Spanish flavors, shared</h4><p>A hypothetical gathering with tapas and conversation. Photography pending.</p><p class="cl-texto-pequeno">5:00–7:00 PM PDT · America/Los_Angeles<br>The Clandestino, Mount Shasta · Free · example</p><span class="cl-estado cl-estado--error">Sold out · simulated</span></div><div class="col-md-3"><button class="cl-boton" type="button" disabled>Sold out · demo</button></div></div></article></li>
    </ol>
    <form id="event-demo" data-cl-comercial-demo novalidate>
      <div class="cl-catalogo__resumen" id="event-selection"><h3>Explore an event · local demo</h3><p>Select the example to see pending, completed and failed selection feedback. No reservation is made.</p>
        <fieldset class="cl-formulario-grupo"><legend class="cl-formulario-grupo__leyenda">Event (required)</legend><label class="cl-opcion" for="event-choice"><input class="cl-opcion__control" id="event-choice" name="event-choice-demo" type="radio" value="wine-evening-example" required aria-describedby="event-choice-error"><span class="cl-opcion__texto">A journey through Spanish wine · May 18, 2028 · example</span></label><p class="cl-mensaje-campo" id="event-choice-error" hidden></p></fieldset>
        <p id="event-summary" role="status">No event selected.</p><div class="cl-seccion__acciones"><?php $botonComercial('Select this evening'); ?><button class="cl-boton cl-boton--secundario" type="reset">Clear event</button></div>
        <div class="cl-guia-resultado" id="event-feedback" role="status" aria-atomic="true">Select the hypothetical event to begin.</div><p data-cl-demo-confirmacion hidden></p>
      </div>
    </form>
    <?php $controlesComerciales('event'); ?>
  </div>
</section>
