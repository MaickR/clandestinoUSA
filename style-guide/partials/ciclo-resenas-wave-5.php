<?php
$cicloResenas = [
    ['Pending review', 'aviso', 'Awaiting moderation', 'Not public', 'No review body is exposed.'],
    ['Published', 'exito', 'Approved for publication', 'Public', 'Only approved content and permitted media are shown.'],
    ['Rejected', 'error', 'Rejected by moderation', 'Not public', 'Rejected text is never included in the public collection.'],
    ['Reported', 'aviso', 'Flagged for assessment', 'Depends on publication status', 'A report alone is not a publication decision. Keep the internal flag private.'],
    ['Hidden / removed', 'error', 'Hidden or withdrawn', 'Not public', 'The body, identity and media are excluded from the public view.'],
    ['Edited', 'destacado', 'Revision awaiting review', 'Approved revision only', 'A changed draft cannot replace an approved version automatically. An approved edit may display an Edited label.'],
];
?>
<section class="cl-seccion" id="review-lifecycle" aria-labelledby="review-lifecycle-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Lifecycle States · internal design reference</p><h2 id="review-lifecycle-titulo">Care before publication</h2><p class="cl-seccion__descripcion">Internal moderation and public visibility are separate decisions. These static examples do not moderate reviews or change the collection above.</p></div>
    <div class="row cl-catalogo">
      <?php foreach ($cicloResenas as [$nombre, $variante, $interno, $publico, $nota]) : ?>
      <div class="col-md-6 col-xl-4"><article class="cl-catalogo__resumen"><h3><?= $escaparResena($nombre) ?></h3><p><span class="cl-estado cl-estado--<?= $escaparResena($variante) ?>"><?= $escaparResena($nombre) ?> · example</span></p><dl><dt>Internal moderation</dt><dd><?= $escaparResena($interno) ?></dd><dt>Public visibility</dt><dd><?= $escaparResena($publico) ?></dd></dl><p class="cl-texto-pequeno"><?= $escaparResena($nota) ?></p></article></div>
      <?php endforeach; ?>
    </div>
    <p class="cl-texto-pequeno cl-texto-secundario">There are no moderator actions here. Authorship checks, abuse reporting, appeals, permissions and publication decisions belong to a future service.</p>
  </div>
</section>
