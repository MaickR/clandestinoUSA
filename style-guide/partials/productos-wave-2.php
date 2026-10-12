<?php
// Helpers exclusivos de la guía: datos estáticos, nunca catálogo comercial.
function escaparProducto(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function fotoProducto(string $ruta, string $alt, int $ancho, int $alto, string $clase = 'cl-producto-gastronomico__imagen', bool $formatos = true): void
{
    $raiz = '../assets/images/';
    $base = preg_replace('/\.(jpe?g|webp)$/i', '', $ruta);
    ?>
    <picture>
      <?php if ($formatos): ?>
      <source srcset="<?= escaparProducto($raiz . 'avif/' . $base . '.avif') ?>" type="image/avif">
      <source srcset="<?= escaparProducto($raiz . 'webp/' . $base . '.webp') ?>" type="image/webp">
      <?php endif; ?>
      <img class="<?= escaparProducto($clase) ?>" src="<?= escaparProducto($raiz . $ruta) ?>" width="<?= $ancho ?>" height="<?= $alto ?>" alt="<?= escaparProducto($alt) ?>" loading="lazy" decoding="async">
    </picture>
    <?php
}
?>
<section class="cl-seccion cl-seccion--alterna" id="wave-2" aria-labelledby="wave-2-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado">
      <p class="cl-eyebrow">Wave 2 · Food &amp; products</p>
      <h2 id="wave-2-titulo">From our table to yours</h2>
      <p class="cl-seccion__descripcion">A visual library for tapas, wines and gifts. Photography is from our existing collection; commercial details still need confirmation.</p>
    </div>
    <div class="cl-alerta cl-alerta--aviso"><div class="cl-alerta__contenido"><p class="cl-alerta__titulo">Local demonstration only.</p><p class="cl-alerta__mensaje">Every numeric price and availability state below is an example. Nothing here places an order or confirms stock. Photos show existing products, not a promise of today's offering.</p></div></div>
  </div>
</section>

<section class="cl-seccion" id="productos-tapas" aria-labelledby="productos-tapas-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado">
      <p class="cl-eyebrow">Tapas · Cheese · Specialties</p>
      <h2 id="productos-tapas-titulo">Something good to share</h2>
      <p class="cl-seccion__descripcion">One card, different flavors. Descriptions identify the photographed products; portions and prices are examples.</p>
    </div>
    <nav class="cl-catalogo__categorias" aria-label="Product categories">
      <a class="cl-boton cl-boton--secundario" href="#productos-tapas">Tapas &amp; cheese</a>
      <a class="cl-boton cl-boton--secundario" href="#productos-vinos">Wines</a>
      <a class="cl-boton cl-boton--secundario" href="#productos-cestas">Gourmet gifts</a>
    </nav>
    <div class="row cl-catalogo">
      <div class="col-12 col-md-6 col-lg-4">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="tabla-titulo">
          <?php fotoProducto('gallery/tapas/the-clandestino-tapas-6.jpeg', 'A wooden board with sliced cheeses, cured meats, crisps and nuts', 2048, 1536); ?>
          <div class="cl-producto-gastronomico__contenido">
            <p class="cl-eyebrow">For the table</p>
            <h3 class="cl-producto-gastronomico__titulo" id="tabla-titulo">Cheese &amp; charcuterie board</h3>
            <p class="cl-producto-gastronomico__descripcion">A little of this, a little of that. A board of cheeses and cured meats, made for conversation.</p>
            <p class="cl-producto-gastronomico__precio">$36.00 <span class="cl-producto-gastronomico__unidad">Example price / sharing board · serves 2 (demo portion)</span></p>
            <div class="cl-producto-gastronomico__acciones"><a class="cl-enlace" href="#productos-destacado">Discover the sharing board</a></div>
          </div>
        </article>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="manchego-titulo">
          <?php fotoProducto('gallery/quesos/manchego.jpg', 'Manchego cheese from the existing restaurant collection', 1024, 683); ?>
          <div class="cl-producto-gastronomico__contenido">
            <p class="cl-eyebrow">Spanish cheese</p>
            <h3 class="cl-producto-gastronomico__titulo" id="manchego-titulo">Manchego</h3>
            <p class="cl-producto-gastronomico__descripcion">A Spanish cheese to enjoy on its own or alongside the rest of the table.</p>
            <p class="cl-producto-gastronomico__precio">Price to be confirmed <span class="cl-producto-gastronomico__unidad">Wedge · weight and availability to be confirmed</span></p>
            <div class="cl-producto-gastronomico__acciones"><a class="cl-enlace" href="#productos-menu">See the menu presentation</a></div>
          </div>
        </article>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="chorizo-titulo">
          <?php fotoProducto('gallery/tapas/the-clandestino-chorizo.jpeg', 'Spanish chorizo photographed for the restaurant tapas collection', 1536, 2048); ?>
          <div class="cl-producto-gastronomico__contenido">
            <p class="cl-eyebrow">Cured specialties</p>
            <h3 class="cl-producto-gastronomico__titulo" id="chorizo-titulo">Chorizo</h3>
            <p class="cl-producto-gastronomico__descripcion">Spanish cured sausage from our product photography collection.</p>
            <p class="cl-producto-gastronomico__precio">$12.00 <span class="cl-producto-gastronomico__unidad">Example price / plate · demo portion</span></p>
            <p><span class="cl-estado cl-estado--aviso">Limited availability · demo</span></p>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>

<section class="cl-seccion cl-seccion--alterna" id="productos-menu" aria-labelledby="productos-menu-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">At a glance</p><h2 id="productos-menu-titulo">The menu, simply presented</h2><p class="cl-seccion__descripcion">Readable rows for a menu with or without photography. All amounts are examples.</p></div>
    <ul class="cl-catalogo__lista">
      <li class="cl-item-menu"><div class="cl-item-menu__contenido"><h3 class="cl-item-menu__titulo">Cheese &amp; charcuterie board</h3><p class="cl-item-menu__descripcion">Cheeses, cured meats, and something to share.</p><span class="cl-texto-pequeno">Sharing board · serves 2 (demo portion)</span></div><p class="cl-item-menu__precio">$36.00<span class="cl-producto-gastronomico__unidad">Example / board</span></p></li>
      <li class="cl-item-menu"><div class="cl-item-menu__contenido"><h3 class="cl-item-menu__titulo">Manchego cheese</h3><p class="cl-item-menu__descripcion">Spanish cheese. Ask about the current selection and serving size.</p><span class="cl-texto-pequeno">Wedge · weight pending confirmation</span></div><p class="cl-item-menu__precio">Price unavailable<span class="cl-producto-gastronomico__unidad">Pending commercial confirmation</span></p></li>
      <li class="cl-item-menu"><div class="cl-item-menu__contenido"><h3 class="cl-item-menu__titulo">Chorizo</h3><p class="cl-item-menu__descripcion">A Spanish cured specialty for the table.</p><span class="cl-texto-pequeno">Plate · demo portion</span></div><p class="cl-item-menu__precio">$12.00<span class="cl-producto-gastronomico__unidad">Example / plate</span></p></li>
    </ul>
  </div>
</section>

<section class="cl-seccion" id="productos-destacado" aria-labelledby="productos-destacado-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><h2 id="productos-destacado-titulo">A product with a story</h2></div>
    <article class="row cl-media-contenido" aria-labelledby="tabla-destacada-titulo">
      <div class="col-md-6 cl-media-contenido__media"><?php fotoProducto('gallery/tapas/the-clandestino-tapas-6.jpeg', 'Cheeses and charcuterie arranged on a sharing board', 2048, 1536, 'cl-media-contenido__imagen'); ?></div>
      <div class="col-md-6 cl-media-contenido__contenido"><p class="cl-eyebrow">Made for sharing</p><h3 id="tabla-destacada-titulo">Start with the board. Let the evening unfold.</h3><p>Cheeses, cured meats, and a table of friends. The photograph shows one of our existing sharing boards; the current selection and portions need confirmation.</p><p class="cl-producto-gastronomico__precio">$36.00<span class="cl-producto-gastronomico__unidad">Example price / sharing board · serves 2 (demo)</span></p><div class="cl-seccion__acciones"><a class="cl-boton" href="#productos-pedido">Explore the order demo</a></div></div>
    </article>
  </div>
</section>

<?php require __DIR__ . '/vinos-cestas-wave-2.php'; ?>
<?php require __DIR__ . '/pedido-estados-wave-2.php'; ?>
