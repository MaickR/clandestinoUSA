<section class="cl-seccion" id="productos-pedido" aria-labelledby="productos-pedido-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Take Away · Local demo</p><h2 id="productos-pedido-titulo">A taste to take with you</h2><p class="cl-seccion__descripcion">Try quantity, waiting, success and failure. No order is sent; the selection disappears when you reload.</p></div>
    <div class="row cl-catalogo">
      <div class="col-12 col-md-6 col-lg-7">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="pedido-tabla-titulo">
          <?php fotoProducto('gallery/tapas/the-clandestino-tapas-6.jpeg', 'A cheese and charcuterie sharing board used for the local order demonstration', 2048, 1536); ?>
          <div class="cl-producto-gastronomico__contenido">
            <p><span class="cl-estado cl-estado--exito">Available · demo</span></p>
            <h3 class="cl-producto-gastronomico__titulo" id="pedido-tabla-titulo">Cheese &amp; charcuterie board</h3>
            <p class="cl-producto-gastronomico__descripcion">An example selection for collection. No stock or pickup window is checked.</p>
            <p class="cl-producto-gastronomico__precio">$36.00<span class="cl-producto-gastronomico__unidad">Example price / board · serves 2 (demo portion)</span></p>
            <form id="pedido-demo" novalidate>
              <div id="pedido-cantidad" class="cl-campo-grupo">
                <label class="cl-etiqueta" for="pedido-unidades">Quantity of boards</label>
                <div class="cl-cantidad">
                  <button class="cl-boton-icono" type="button" data-cl-cantidad="restar" aria-label="Decrease boards">−</button>
                  <input class="cl-campo cl-cantidad__campo" id="pedido-unidades" type="number" min="1" max="6" step="1" value="1" required aria-describedby="pedido-ayuda pedido-error">
                  <button class="cl-boton-icono" type="button" data-cl-cantidad="sumar" aria-label="Increase boards">+</button>
                </div>
                <p class="cl-mensaje-campo cl-mensaje-campo--ayuda" id="pedido-ayuda">1–6 boards · demo limit, not inventory.</p>
                <p class="cl-mensaje-campo cl-cantidad__mensaje cl-guia-resultado cl-guia-resultado--cantidad" id="pedido-error" role="status"></p>
              </div>
              <div class="cl-campo-grupo"><label class="cl-etiqueta" for="pedido-resultado-demo">Simulated outcome</label><select class="cl-campo" id="pedido-resultado-demo"><option value="exito">Success</option><option value="error">Failure</option></select></div>
              <div class="cl-producto-gastronomico__acciones">
                <button class="cl-boton cl-boton--con-carga" id="pedido-agregar" type="submit"><span class="cl-boton__reposo">Add to Order · demo</span><span class="cl-boton__carga"><span class="cl-spinner" aria-hidden="true"></span>Adding · demo…</span></button>
              </div>
            </form>
            <div id="pedido-feedback" class="cl-guia-resultado cl-guia-resultado--producto" role="status" aria-atomic="true"></div>
          </div>
        </article>
      </div>
      <div class="col-12 col-md-6 col-lg-5">
        <aside class="cl-catalogo__resumen" aria-labelledby="seleccion-titulo">
          <p class="cl-eyebrow">Demo selection</p><h3 id="seleccion-titulo">For your table</h3><p id="pedido-seleccion" role="status">Your demonstration selection is empty.</p><p class="cl-texto-pequeno">Only the last successful selection is shown. No running cart, totals, payment or reservation.</p><button class="cl-boton cl-boton--secundario" id="pedido-limpiar" type="button" disabled>Clear demo selection</button>
        </aside>
        <article class="cl-item-menu" aria-labelledby="pedido-agotado-titulo"><div class="cl-item-menu__contenido"><p><span class="cl-estado cl-estado--error">Sold out · demo</span></p><h3 class="cl-item-menu__titulo" id="pedido-agotado-titulo">Chorizo plate</h3><p class="cl-item-menu__descripcion">Unavailable in this simulated state. Current availability has not been checked.</p><p class="cl-producto-gastronomico__precio">$12.00<span class="cl-producto-gastronomico__unidad">Example / plate</span></p><button class="cl-boton" type="button" disabled>Sold out · demo</button></div></article>
      </div>
    </div>
  </div>
</section>

<section class="cl-seccion cl-seccion--alterna" id="productos-estados" aria-labelledby="productos-estados-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Catalog states · Local examples</p><h2 id="productos-estados-titulo">Clear at every step</h2><p class="cl-seccion__descripcion">Representative states using Core. These examples never check a live catalog.</p></div>
    <div class="row cl-catalogo">
      <div class="col-12 col-md-6 col-lg-4">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="imagen-ausente-titulo"><div class="cl-producto-gastronomico__media"><p class="cl-producto-gastronomico__nota">Image unavailable · demo</p></div><div class="cl-producto-gastronomico__contenido"><p class="cl-eyebrow">Cheese collection</p><h3 class="cl-producto-gastronomico__titulo" id="imagen-ausente-titulo">Manchego</h3><p class="cl-producto-gastronomico__descripcion">Product information remains readable without a photograph.</p><p class="cl-producto-gastronomico__precio">Price unavailable<span class="cl-producto-gastronomico__unidad">Wedge · awaiting confirmation</span></p></div></article>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="cl-tarjeta cl-producto-gastronomico" aria-busy="true" aria-labelledby="catalogo-carga-titulo"><div class="cl-producto-gastronomico__media" aria-hidden="true"><span class="cl-skeleton cl-skeleton--superficie"></span></div><div class="cl-producto-gastronomico__contenido"><h3 id="catalogo-carga-titulo">Loading products · demo</h3><p><span class="cl-spinner" aria-hidden="true"></span> Waiting for the catalog.</p><div aria-hidden="true"><span class="cl-skeleton"></span><span class="cl-skeleton cl-skeleton--corto"></span></div><p class="cl-texto-pequeno">Static loading example. No request is running.</p></div></div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="cl-estado-vista"><h3 class="cl-estado-vista__titulo">No matching products</h3><p class="cl-estado-vista__texto">Empty catalog example. Try another category when a real catalog is available.</p><a class="cl-boton cl-boton--secundario" href="#productos-tapas">Back to the examples</a></div>
      </div>
      <div class="col-12">
        <div class="cl-estado-vista cl-estado-vista--error"><h3 class="cl-estado-vista__titulo">The catalog couldn't be loaded</h3><p class="cl-estado-vista__texto">Demonstration error. Product details remain unconfirmed.</p><button class="cl-boton cl-boton--secundario" type="button" id="catalogo-reintentar">Try again · demo</button><p class="cl-guia-resultado" id="catalogo-reintento" role="status"></p></div>
      </div>
    </div>
  </div>
</section>
