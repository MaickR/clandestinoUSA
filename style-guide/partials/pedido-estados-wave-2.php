<section class="cl-seccion" id="productos-pedido" aria-labelledby="productos-pedido-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Take Away · Local demo</p><h2 id="productos-pedido-titulo">A taste to take with you</h2><p class="cl-seccion__descripcion">Try quantity, waiting, success and failure. No order is sent; the selection disappears when you reload.</p></div>
    <div class="row cl-catalogo">
      <div class="col-12">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="pedido-tabla-titulo">
          <div class="row cl-media-contenido cl-producto-gastronomico__presentacion">
            <div class="col-md-5 cl-media-contenido__media">
              <?php fotoProducto('gallery/tapas/the-clandestino-tapas-6.jpeg', 'A cheese and charcuterie sharing board used for the local order demonstration', 2048, 1536, 'cl-producto-gastronomico__imagen cl-producto-gastronomico__imagen--pedido'); ?>
            </div>
            <div class="col-md-7 cl-producto-gastronomico__contenido">
              <p class="cl-eyebrow">For sharing · Take Away demo</p>
              <h3 class="cl-titulo-1" id="pedido-tabla-titulo">Cheese &amp; charcuterie board</h3>
              <p class="cl-producto-gastronomico__descripcion">Cheeses and cured meats for the table. Serves 2 as an example portion; contents and collection details need confirmation.</p>
              <p><span class="cl-estado cl-estado--exito"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('exito') ?> Available · demo</span></span></p>
              <p class="cl-producto-gastronomico__precio">$36.00<span class="cl-producto-gastronomico__unidad">Example unit price / board</span></p>
              <form id="pedido-demo" data-cl-precio-ejemplo="3600" novalidate>
                <div id="pedido-cantidad">
                  <div class="cl-producto-gastronomico__seleccion">
                    <div class="cl-campo-grupo"><label class="cl-etiqueta" for="pedido-unidades">Quantity of boards</label>
                      <div class="cl-cantidad">
                        <button class="cl-boton-icono" type="button" data-cl-cantidad="restar" aria-label="Decrease boards"><?= iconoProducto('restar') ?></button>
                        <input class="cl-campo cl-cantidad__campo" id="pedido-unidades" type="number" min="1" max="6" step="1" value="1" required aria-describedby="pedido-ayuda pedido-error">
                        <button class="cl-boton-icono" type="button" data-cl-cantidad="sumar" aria-label="Increase boards"><?= iconoProducto('sumar') ?></button>
                      </div>
                    </div>
                    <div class="cl-campo-grupo"><span class="cl-etiqueta" id="subtotal-etiqueta">Example subtotal</span><output class="cl-producto-gastronomico__subtotal" id="pedido-subtotal" for="pedido-unidades" aria-labelledby="subtotal-etiqueta">$36.00</output></div>
                  </div>
                  <p class="cl-mensaje-campo cl-mensaje-campo--ayuda" id="pedido-ayuda">1–6 boards · demo limit. Subtotal excludes taxes and is not a final charge.</p>
                  <div class="cl-producto-gastronomico__acciones">
                    <button class="cl-boton cl-boton--con-carga" id="pedido-agregar" type="submit"><span class="cl-boton__reposo"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('pedido') ?> Add to Order · demo</span></span><span class="cl-boton__carga"><span class="cl-spinner" aria-hidden="true"></span>Adding · demo…</span></button>
                  </div>
                  <p class="cl-mensaje-campo cl-cantidad__mensaje cl-guia-resultado" id="pedido-error" role="status"></p>
                </div>
              </form>
              <div id="pedido-feedback" class="cl-guia-resultado cl-guia-resultado--producto" role="status" aria-atomic="true"><div class="cl-alerta"><div class="cl-alerta__contenido"><p class="cl-alerta__mensaje">Choose a quantity, then try the local order demonstration.</p></div></div></div>
            </div>
          </div>
        </article>
      </div>
      <div class="col-12 col-md-6">
        <aside class="cl-catalogo__resumen" aria-labelledby="seleccion-titulo">
          <p class="cl-eyebrow">Your selection · Local demo</p><h3 id="seleccion-titulo">For your table</h3><p id="pedido-seleccion" role="status">Your demonstration selection is empty.</p>
          <dl class="cl-catalogo__datos" id="pedido-seleccion-datos" hidden><dt>Product</dt><dd>Cheese &amp; charcuterie board</dd><dt>Quantity</dt><dd id="seleccion-unidades">—</dd><dt>Example unit price</dt><dd>$36.00 / board</dd><dt>Example subtotal</dt><dd id="seleccion-subtotal">—</dd></dl>
          <p class="cl-texto-pequeno">Only the last successful selection is shown. Nothing is ordered or charged.</p><button class="cl-boton cl-boton--secundario" id="pedido-limpiar" type="button" disabled><span class="cl-producto-gastronomico__dato"><?= iconoProducto('cerrar') ?> Clear demo selection</span></button>
        </aside>
      </div>
      <div class="col-12 col-md-6">
        <fieldset class="cl-guia-controles-demo"><legend>Demo controls</legend><p class="cl-texto-pequeno">Style Guide testing only. Choose the result of the next local action, then use Add to Order above.</p><div class="cl-campo-grupo"><label class="cl-etiqueta" for="pedido-resultado-demo">Simulated outcome</label><select class="cl-campo" id="pedido-resultado-demo"><option value="exito">Success</option><option value="error">Failure</option></select></div></fieldset>
      </div>
      <div class="col-12">
        <article class="cl-item-menu" aria-labelledby="pedido-agotado-titulo">
          <div class="cl-item-menu__cabecera"><div class="cl-item-menu__contenido"><h3 class="cl-item-menu__titulo" id="pedido-agotado-titulo">Chorizo plate</h3><p class="cl-item-menu__descripcion">Unavailable in this simulated state. Current stock is unconfirmed.</p><span class="cl-estado cl-estado--error"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('error') ?> Sold out · demo</span></span></div></div>
          <div class="cl-item-menu__comercial"><p class="cl-item-menu__precio cl-producto-gastronomico__precio">$12.00<span class="cl-producto-gastronomico__unidad">Example / plate</span></p><button class="cl-boton" type="button" disabled><span class="cl-producto-gastronomico__dato"><?= iconoProducto('restringido') ?> Sold out · demo</span></button></div>
        </article>
      </div>
    </div>
  </div>
</section>

<section class="cl-seccion cl-seccion--alterna" id="productos-estados" aria-labelledby="productos-estados-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Catalog states · Local examples</p><h2 id="productos-estados-titulo">Clear at every step</h2><p class="cl-seccion__descripcion">Representative states using Core. These examples never check a live catalog.</p></div>
    <div class="row cl-catalogo">
      <div class="col-12 col-md-6 col-lg-4">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="imagen-ausente-titulo"><div class="cl-producto-gastronomico__media"><p class="cl-producto-gastronomico__nota"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('informacion') ?> Image unavailable · demo</span></p></div><div class="cl-producto-gastronomico__contenido"><p class="cl-eyebrow">Cheese collection</p><h3 class="cl-producto-gastronomico__titulo" id="imagen-ausente-titulo">Manchego</h3><p class="cl-producto-gastronomico__descripcion">Product information remains readable without a photograph.</p><div class="cl-producto-gastronomico__pie"><p class="cl-producto-gastronomico__precio cl-producto-gastronomico__precio--pendiente">Price unavailable<span class="cl-producto-gastronomico__unidad">Wedge · awaiting confirmation</span></p></div></div></article>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="cl-tarjeta cl-producto-gastronomico" aria-busy="true" aria-labelledby="catalogo-carga-titulo"><div class="cl-producto-gastronomico__media" aria-hidden="true"><span class="cl-skeleton cl-skeleton--superficie"></span></div><div class="cl-producto-gastronomico__contenido"><h3 id="catalogo-carga-titulo">Loading products · demo</h3><p><span class="cl-spinner" aria-hidden="true"></span> Waiting for the catalog.</p><div aria-hidden="true"><span class="cl-skeleton"></span><span class="cl-skeleton cl-skeleton--corto"></span></div><p class="cl-texto-pequeno">Static loading example. No request is running.</p></div></div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="cl-estado-vista"><h3 class="cl-estado-vista__titulo">No matching products</h3><p class="cl-estado-vista__texto">Empty catalog example. Try another category when a real catalog is available.</p><a class="cl-boton cl-boton--secundario" href="#productos-tapas">Back to the examples</a></div>
      </div>
      <div class="col-12">
        <div class="cl-estado-vista cl-estado-vista--error"><h3 class="cl-estado-vista__titulo">The catalog couldn't be loaded</h3><p class="cl-estado-vista__texto">Demonstration error. Product details remain unconfirmed.</p><button class="cl-boton cl-boton--secundario" type="button" id="catalogo-reintentar"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('reintentar') ?> Try again · demo</span></button><p class="cl-guia-resultado" id="catalogo-reintento" role="status"></p></div>
      </div>
    </div>
  </div>
</section>
