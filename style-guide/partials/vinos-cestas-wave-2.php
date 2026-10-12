<section class="cl-seccion cl-seccion--alterna" id="productos-vinos" aria-labelledby="productos-vinos-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">From bottle to table</p><h2 id="productos-vinos-titulo">Wines worth a closer look</h2><p class="cl-seccion__descripcion">Uncropped bottle photographs. No current vintage, region or stock is assumed from historical catalog data.</p></div>
    <div class="row cl-catalogo">
      <div class="col-12 col-md-6">
        <article class="cl-tarjeta cl-producto-gastronomico cl-producto-gastronomico--vino" aria-labelledby="pure-card-titulo">
          <?php fotoProducto('wines/PURE-SOUL.jpg', 'Three NTC & Sons PURE SOUL bottles with their photographed labels visible', 916, 2048, 'cl-producto-gastronomico__imagen cl-vino__imagen'); ?>
          <div class="cl-producto-gastronomico__contenido">
            <p class="cl-eyebrow">NTC &amp; Sons</p><h3 class="cl-producto-gastronomico__titulo" id="pure-card-titulo">PURE SOUL</h3>
            <p class="cl-producto-gastronomico__descripcion">The blend and ageing shown on our photographed label.</p>
            <dl class="cl-vino__ficha"><dt>Grapes (photo)</dt><dd>Grenache 85% · Vidadillo 15%</dd><dt>Ageing (photo)</dt><dd>Barrel aged</dd></dl>
            <p class="cl-producto-gastronomico__unidad">Current release and availability to be confirmed.</p>
            <div class="cl-producto-gastronomico__pie"><p class="cl-producto-gastronomico__precio">$12.00 <span class="cl-producto-gastronomico__unidad">Example / glass</span>$45.00 <span class="cl-producto-gastronomico__unidad">Example / bottle · volumes unconfirmed</span></p><div class="cl-producto-gastronomico__acciones"><a class="cl-boton-icono" href="#vino-destacado" aria-label="Explore PURE SOUL details"><?= iconoProducto('siguiente') ?></a></div></div>
          </div>
        </article>
      </div>
      <div class="col-12 col-md-6">
        <article class="cl-tarjeta cl-producto-gastronomico cl-producto-gastronomico--vino" aria-labelledby="adaro-titulo">
          <?php fotoProducto('wines/ADARO.jpeg', 'Adaro wine from the existing bottle photography collection', 1536, 2048, 'cl-producto-gastronomico__imagen cl-vino__imagen'); ?>
          <div class="cl-producto-gastronomico__contenido">
            <p class="cl-eyebrow">The bottle collection</p><h3 class="cl-producto-gastronomico__titulo" id="adaro-titulo">Adaro</h3>
            <p class="cl-producto-gastronomico__descripcion">From our existing wine collection. Vintage, region and grapes await confirmation.</p>
            <p class="cl-producto-gastronomico__dato"><?= iconoProducto('informacion') ?> Availability unconfirmed</p>
            <div class="cl-producto-gastronomico__pie"><p class="cl-producto-gastronomico__precio cl-producto-gastronomico__precio--pendiente">Price to be confirmed<span class="cl-producto-gastronomico__unidad">Glass / bottle options unconfirmed</span></p><div class="cl-producto-gastronomico__acciones"><a class="cl-boton-icono" href="#vino-destacado" aria-label="Explore the featured wine presentation"><?= iconoProducto('siguiente') ?></a></div></div>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<section class="cl-seccion" id="vino-destacado" aria-labelledby="vino-destacado-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><h2 id="vino-destacado-titulo">A wine in focus</h2></div>
    <article class="row cl-media-contenido cl-media-contenido--invertido" aria-labelledby="pure-destacado-titulo">
      <div class="col-md-6 cl-media-contenido__media"><?php fotoProducto('wines/PURE-SOUL.jpg', 'NTC & Sons PURE SOUL bottles in the restaurant', 916, 2048, 'cl-media-contenido__imagen cl-vino__imagen cl-vino__imagen--destacada'); ?></div>
      <div class="col-md-6 cl-media-contenido__contenido">
        <p class="cl-eyebrow">NTC &amp; Sons</p><h3 class="cl-titulo-1" id="pure-destacado-titulo">PURE SOUL</h3><p>A bottle, a conversation. Explore the blend shown on the label in our existing photograph.</p>
        <dl class="cl-producto-gastronomico__ficha"><dt>Blend (photo)</dt><dd>Grenache 85% · Vidadillo 15%</dd><dt>Ageing (photo)</dt><dd>Barrel aged</dd><dt>Current release</dt><dd>Pending confirmation</dd></dl>
        <div class="cl-producto-gastronomico__pie"><p class="cl-producto-gastronomico__precio cl-producto-gastronomico__precio--pendiente">Price and availability to be confirmed</p><div class="cl-producto-gastronomico__acciones"><a class="cl-enlace" href="#productos-vinos">Explore the wines <?= iconoProducto('siguiente') ?></a></div></div>
      </div>
    </article>
  </div>
</section>
<section class="cl-seccion cl-seccion--alterna" id="productos-cestas" aria-labelledby="productos-cestas-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">A gift to gather around</p><h2 id="productos-cestas-titulo">Gourmet baskets</h2><p class="cl-seccion__descripcion">Existing basket photographs and historical names. Contents, prices and customization options must be confirmed before sale.</p></div>
    <div class="row cl-catalogo">
      <div class="col-12 col-md-6">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="cesta-clasica-titulo">
          <?php fotoProducto('hampers/basket-01.webp', 'Classic Basket from the existing gourmet hamper collection', 1536, 2048, 'cl-producto-gastronomico__imagen', false); ?>
          <div class="cl-producto-gastronomico__contenido"><p class="cl-eyebrow">Gourmet gifts</p><h3 class="cl-producto-gastronomico__titulo" id="cesta-clasica-titulo">Classic Basket</h3><p class="cl-producto-gastronomico__descripcion">A gift from our existing Spanish basket collection. Final contents need confirmation.</p><p class="cl-producto-gastronomico__dato"><?= iconoProducto('regalo') ?> Contents and availability unconfirmed</p><div class="cl-producto-gastronomico__pie"><p class="cl-producto-gastronomico__precio cl-producto-gastronomico__precio--pendiente">Price to be confirmed<span class="cl-producto-gastronomico__unidad">Per basket</span></p><div class="cl-producto-gastronomico__acciones"><a class="cl-boton-icono" href="#cesta-detalles" aria-label="Explore gourmet gift options"><?= iconoProducto('siguiente') ?></a></div></div></div>
        </article>
      </div>
      <div class="col-12 col-md-6">
        <article class="cl-tarjeta cl-producto-gastronomico" id="cesta-detalles" aria-labelledby="cesta-personalizada-titulo">
          <?php fotoProducto('hampers/basket-13.webp', 'A collage of gourmet baskets from the existing custom hamper collection', 1536, 2048, 'cl-producto-gastronomico__imagen', false); ?>
          <div class="cl-producto-gastronomico__contenido"><p class="cl-eyebrow">Gourmet gifts</p><h3 class="cl-producto-gastronomico__titulo" id="cesta-personalizada-titulo">Custom Hamper</h3><p class="cl-producto-gastronomico__descripcion">An existing reference for a personalized gift. Options and contents need confirmation.</p><p class="cl-producto-gastronomico__dato"><?= iconoProducto('regalo') ?> Customization unconfirmed</p><div class="cl-producto-gastronomico__pie"><p class="cl-producto-gastronomico__precio cl-producto-gastronomico__precio--pendiente">Price to be confirmed<span class="cl-producto-gastronomico__unidad">No quotation available in this demo</span></p><div class="cl-producto-gastronomico__acciones"><a class="cl-boton-icono" href="#productos-cestas" aria-label="Compare gourmet gift presentations"><?= iconoProducto('siguiente') ?></a></div></div></div>
        </article>
      </div>
    </div>
  </div>
</section>
