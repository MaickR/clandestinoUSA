<?php
// Inventario cerrado de fotografía local. Los originales y sus derivados no cambian.
$fotosEditoriales = [
    'tapas' => ['gallery/tapas/the-clandestino-tapas-6', 'jpeg', 2048, 1536, 'Cheese, cured meats and crisps arranged on a wooden sharing board'],
    'mesa' => ['gallery/tapas/the-clandestino-tapas-table-1', 'jpeg', 2048, 1536, 'An overhead view of cheeses, cured meats, olives and small bites'],
    'panorama' => ['gallery/tapas/the-clandestino-tapas-table', 'jpeg', 1998, 628, 'A long sharing board with cheeses, cured meats, almonds and bocadillos'],
    'vino' => ['gallery/wines/the-clandestino-wines-table', 'jpeg', 1536, 2048, 'A wine bottle, carafe and glasses on a wooden barrel table'],
    'maridaje' => ['gallery/tapas/the-clandestino-tapas-wines', 'jpeg', 1536, 2048, 'A sharing board with olives, cheeses and cured meats beside wine glasses and a bottle'],
    'interior' => ['bg/clandestino-usa', 'jpg', 1880, 920, 'Barrel tables and hanging wine glasses inside The Clandestino in Mount Shasta'],
    'bocadillo' => ['gallery/tapas/the-clandestino-bocadillo', 'jpeg', 1200, 1600, 'A toasted bocadillo on a wooden board'],
    'arroz' => ['gallery/tapas/the-clandestino-paella', 'jpeg', 2048, 1536, 'Rice with prawns and mussels from the restaurant photography collection'],
];
$escaparEditorial = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
$fotoEditorial = static function (string $nombre, string $clase) use ($fotosEditoriales, $escaparEditorial): void {
    [$ruta, $extension, $ancho, $alto, $alt] = $fotosEditoriales[$nombre];
    ?>
    <picture>
      <source srcset="../assets/images/avif/<?= $escaparEditorial($ruta) ?>.avif" type="image/avif">
      <source srcset="../assets/images/webp/<?= $escaparEditorial($ruta) ?>.webp" type="image/webp">
      <img class="<?= $escaparEditorial($clase) ?>" src="../assets/images/<?= $escaparEditorial($ruta . '.' . $extension) ?>" width="<?= $ancho ?>" height="<?= $alto ?>" alt="<?= $escaparEditorial($alt) ?>" loading="lazy" decoding="async">
    </picture>
    <?php
};
?>
<section class="cl-seccion cl-seccion--alterna" id="wave-3" aria-labelledby="wave-3-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado">
      <p class="cl-eyebrow">Wave 3 · Experiences &amp; stories</p>
      <h2 id="wave-3-titulo">The pleasure of being here</h2>
      <p class="cl-seccion__descripcion">Spanish flavors, wine and the warmth of a shared table. A collection of editorial compositions, ready to make your own.</p>
    </div>
    <p class="cl-texto-pequeno">Local design reference · Photography comes from the restaurant archive. These examples do not confirm current menus, dates or availability. Wave 3 awaits visual approval.</p>
    <nav aria-label="Wave 3 families">
      <ul class="cl-guia-indice">
        <li><a class="cl-enlace" href="#experiencias">Experiences</a></li>
        <li><a class="cl-enlace" href="#historias">Storytelling</a></li>
        <li><a class="cl-enlace" href="#galeria-editorial">Gallery</a></li>
        <li><a class="cl-enlace" href="#video-editorial">Video</a></li>
        <li><a class="cl-enlace" href="#comunidad">Community</a></li>
        <li><a class="cl-enlace" href="#valores">Values</a></li>
      </ul>
    </nav>
  </div>
</section>
<?php require __DIR__ . '/experiencias-wave-3.php'; ?>
<?php require __DIR__ . '/historias-wave-3.php'; ?>
<?php require __DIR__ . '/galeria-media-wave-3.php'; ?>
<?php require __DIR__ . '/comunidad-valores-wave-3.php'; ?>
