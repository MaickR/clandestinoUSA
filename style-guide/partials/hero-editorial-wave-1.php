<?php
// Marcado editorial único de Wave 1; el anfitrión aporta datos, semántica y carga.
$escaparHero = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
$etiquetaHero = $hero['etiqueta'] ?? 'h2';
if (!in_array($etiquetaHero, ['h1', 'h2', 'h3'], true)) {
    throw new InvalidArgumentException('Jerarquía de Hero no admitida.');
}
?>
<?php if ($hero['diferida'] ?? false) : ?><template data-cl-escenas-imagen><?php endif; ?>
<picture class="cl-hero__media">
  <?php foreach ($hero['fuentes'] as $fuente) : ?>
  <source type="<?= $escaparHero($fuente['tipo']) ?>" srcset="<?= $escaparHero($fuente['srcset']) ?>"<?= isset($fuente['sizes']) ? ' sizes="' . $escaparHero($fuente['sizes']) . '"' : '' ?>>
  <?php endforeach; ?>
  <img class="cl-hero__imagen" src="<?= $escaparHero($hero['imagen']) ?>" width="<?= (int) $hero['ancho'] ?>" height="<?= (int) $hero['alto'] ?>" alt="<?= $escaparHero($hero['alt']) ?>" loading="<?= $escaparHero($hero['carga'] ?? 'lazy') ?>"<?= isset($hero['prioridad']) ? ' fetchpriority="' . $escaparHero($hero['prioridad']) . '"' : '' ?> decoding="async">
</picture>
<?php if ($hero['diferida'] ?? false) : ?></template><?php endif; ?>
<div class="container cl-hero__estructura">
  <div class="row">
    <div class="cl-hero__contenido col-12 col-md-10 col-lg-7">
      <p class="cl-eyebrow"><?= $escaparHero($hero['entrada']) ?></p>
      <<?= $etiquetaHero ?> class="cl-display"<?= isset($hero['id']) ? ' id="' . $escaparHero($hero['id']) . '"' : '' ?>><?= $escaparHero($hero['titulo']) ?></<?= $etiquetaHero ?>>
      <p class="cl-seccion__descripcion"><?= $escaparHero($hero['descripcion']) ?></p>
      <div class="cl-seccion__acciones">
        <?php foreach ($hero['acciones'] as $numeroAccion => $accion) : ?>
        <a class="cl-boton<?= $numeroAccion === 0 ? '' : ' cl-boton--secundario' ?>" href="<?= $escaparHero($accion[1]) ?>"<?= isset($accion[2]) ? ' target="' . $escaparHero($accion[2]) . '"' : '' ?>><?= $escaparHero($accion[0]) ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
