<?php
// Helpers exclusivos de la guía: datos estáticos, nunca catálogo comercial.
function escaparProducto(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function iconoProducto(string $nombre): string
{
    return '<svg class="cl-icon" aria-hidden="true" focusable="false"><use href="../assets/icons/cl-iconos.svg#cl-icon-'
        . escaparProducto($nombre) . '"></use></svg>';
}

function fotoProducto(
    string $ruta,
    string $alt,
    int $ancho,
    int $alto,
    string $clase = 'cl-producto-gastronomico__imagen',
    bool $formatos = true,
    string $claseMarco = 'cl-producto-gastronomico__visual'
): void {
    $raiz = '../assets/images/';
    $base = preg_replace('/\.(jpe?g|webp)$/i', '', $ruta);
    ?>
    <picture class="<?= escaparProducto($claseMarco) ?>">
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
            <p class="cl-producto-gastronomico__descripcion">Cheeses, cured meats, and a board made for conversation.</p>
            <p class="cl-producto-gastronomico__dato"><?= iconoProducto('personas') ?> For sharing · serves 2 (demo)</p>
            <div class="cl-producto-gastronomico__pie">
              <p class="cl-producto-gastronomico__precio">$36.00<span class="cl-producto-gastronomico__unidad">Example price / board</span></p>
              <div class="cl-producto-gastronomico__acciones"><a class="cl-boton-icono" href="#productos-destacado" aria-label="Explore the sharing board"><?= iconoProducto('siguiente') ?></a></div>
            </div>
          </div>
        </article>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <article class="cl-tarjeta cl-producto-gastronomico" aria-labelledby="manchego-titulo">
          <?php fotoProducto('gallery/quesos/manchego.jpg', 'Manchego cheese from the existing restaurant collection', 1024, 683); ?>
          <div class="cl-producto-gastronomico__contenido">
            <p class="cl-eyebrow">Spanish cheese</p>
            <h3 class="cl-producto-gastronomico__titulo" id="manchego-titulo">Manchego</h3>
            <p class="cl-producto-gastronomico__descripcion">Spanish cheese to enjoy on its own or alongside the rest of the table.</p>
            <p class="cl-producto-gastronomico__dato"><?= iconoProducto('informacion') ?> Availability to be confirmed</p>
            <div class="cl-producto-gastronomico__pie">
              <p class="cl-producto-gastronomico__precio cl-producto-gastronomico__precio--pendiente">Price to be confirmed<span class="cl-producto-gastronomico__unidad">Per wedge · weight unconfirmed</span></p>
              <div class="cl-producto-gastronomico__acciones"><a class="cl-boton-icono" href="#productos-menu" aria-label="Explore the cheese menu"><?= iconoProducto('siguiente') ?></a></div>
            </div>
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
            <p><span class="cl-estado cl-estado--aviso"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('aviso') ?> Limited availability · demo</span></span></p>
            <div class="cl-producto-gastronomico__pie">
              <p class="cl-producto-gastronomico__precio">$12.00<span class="cl-producto-gastronomico__unidad">Example price / plate</span></p>
              <div class="cl-producto-gastronomico__acciones"><a class="cl-boton-icono" href="#productos-pedido" aria-label="Explore the Take Away demo"><?= iconoProducto('pedido') ?></a></div>
            </div>
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
      <li class="cl-item-menu">
        <div class="cl-item-menu__cabecera">
          <?php fotoProducto('gallery/tapas/the-clandestino-tapas-6.jpeg', 'Cheese and charcuterie sharing board', 2048, 1536, 'cl-item-menu__imagen', true, 'cl-item-menu__media'); ?>
          <div class="cl-item-menu__contenido"><h3 class="cl-item-menu__titulo">Cheese &amp; charcuterie board</h3><p class="cl-item-menu__descripcion">Cheeses, cured meats, and something to share.</p><p class="cl-texto-pequeno">Board · serves 2 (demo portion)</p><span class="cl-estado cl-estado--exito"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('exito') ?> Available · demo</span></span></div>
        </div>
        <div class="cl-item-menu__comercial"><p class="cl-item-menu__precio cl-producto-gastronomico__precio">$36.00<span class="cl-producto-gastronomico__unidad">Example / board</span></p><a class="cl-boton-icono" href="#productos-destacado" aria-label="View sharing board details"><?= iconoProducto('siguiente') ?></a></div>
      </li>
      <li class="cl-item-menu">
        <div class="cl-item-menu__cabecera"><div class="cl-item-menu__contenido"><h3 class="cl-item-menu__titulo">Manchego cheese</h3><p class="cl-item-menu__descripcion">Spanish cheese. Ask about the current selection and serving size.</p><p class="cl-texto-pequeno">Wedge · weight pending confirmation</p><span class="cl-producto-gastronomico__dato"><?= iconoProducto('informacion') ?> Availability unconfirmed</span></div></div>
        <div class="cl-item-menu__comercial"><p class="cl-item-menu__precio cl-producto-gastronomico__precio--pendiente">Price unavailable<span class="cl-producto-gastronomico__unidad">Pending confirmation</span></p><a class="cl-boton-icono" href="#manchego-titulo" aria-label="View Manchego presentation"><?= iconoProducto('informacion') ?></a></div>
      </li>
      <li class="cl-item-menu">
        <div class="cl-item-menu__cabecera">
          <?php fotoProducto('gallery/tapas/the-clandestino-chorizo.jpeg', 'Spanish chorizo from the existing product collection', 1536, 2048, 'cl-item-menu__imagen', true, 'cl-item-menu__media'); ?>
          <div class="cl-item-menu__contenido"><h3 class="cl-item-menu__titulo">Chorizo</h3><p class="cl-item-menu__descripcion">A Spanish cured specialty for the table.</p><p class="cl-texto-pequeno">Plate · demo portion</p><span class="cl-estado cl-estado--aviso"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('aviso') ?> Limited availability · demo</span></span></div>
        </div>
        <div class="cl-item-menu__comercial"><p class="cl-item-menu__precio cl-producto-gastronomico__precio">$12.00<span class="cl-producto-gastronomico__unidad">Example / plate</span></p><a class="cl-boton-icono" href="#productos-pedido" aria-label="Explore the local order demonstration"><?= iconoProducto('pedido') ?></a></div>
      </li>
      <li class="cl-item-menu">
        <div class="cl-item-menu__cabecera"><div class="cl-item-menu__contenido"><h3 class="cl-item-menu__titulo">Chorizo plate · unavailable example</h3><p class="cl-item-menu__descripcion">A sold-out presentation with no order action available.</p><span class="cl-estado cl-estado--error"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('error') ?> Sold out · demo</span></span></div></div>
        <div class="cl-item-menu__comercial"><p class="cl-item-menu__precio cl-producto-gastronomico__precio">$12.00<span class="cl-producto-gastronomico__unidad">Example / plate</span></p><button class="cl-boton-icono" type="button" disabled aria-label="Chorizo plate unavailable in this demo"><?= iconoProducto('restringido') ?></button></div>
      </li>
    </ul>
  </div>
</section>

<section class="cl-seccion" id="productos-destacado" aria-labelledby="productos-destacado-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><h2 id="productos-destacado-titulo">A product with a story</h2></div>
    <article class="row cl-media-contenido" aria-labelledby="tabla-destacada-titulo">
      <div class="col-md-6 cl-media-contenido__media"><?php fotoProducto('gallery/tapas/the-clandestino-tapas-6.jpeg', 'Cheeses and charcuterie arranged on a sharing board', 2048, 1536, 'cl-media-contenido__imagen'); ?></div>
      <div class="col-md-6 cl-media-contenido__contenido">
        <p class="cl-eyebrow">Made for sharing</p><h3 class="cl-titulo-1" id="tabla-destacada-titulo">Cheese &amp; charcuterie board</h3><p>Start with the board. Let the evening unfold. The photograph shows a board from our existing collection.</p>
        <dl class="cl-producto-gastronomico__ficha"><dt>For the table</dt><dd>Serves 2 · example portion</dd><dt>Selection</dt><dd>Current contents to be confirmed</dd></dl>
        <div class="cl-producto-gastronomico__pie"><p class="cl-producto-gastronomico__precio">$36.00<span class="cl-producto-gastronomico__unidad">Example price / board</span></p><div class="cl-producto-gastronomico__acciones"><a class="cl-boton" href="#productos-pedido"><span class="cl-producto-gastronomico__dato"><?= iconoProducto('pedido') ?> Try the order demo</span></a></div></div>
      </div>
    </article>
  </div>
</section>

<?php require __DIR__ . '/vinos-cestas-wave-2.php'; ?>
<?php require __DIR__ . '/pedido-estados-wave-2.php'; ?>
