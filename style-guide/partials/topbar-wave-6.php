<?php
// Variante opcional; fuera del Header sticky y sin horarios no confirmados.
if (!$datosContacto['mapa'] && !$datosContacto['telefono']) return;
?>
<aside class="cl-topbar" aria-label="Location and contact">
  <div class="container cl-topbar__contenido">
    <?php if ($datosContacto['mapa']) : ?><a class="cl-enlace" href="<?= $escaparNavegacion($datosContacto['mapa']) ?>" target="_blank" rel="noopener noreferrer"><?= $escaparNavegacion($datosContacto['ubicacionBreve']) ?><span class="visually-hidden"> · Google Maps (opens a new tab)</span></a><?php endif; ?>
    <?php if ($datosContacto['telefono']) : ?><a class="cl-enlace" href="<?= $escaparNavegacion($datosContacto['telefono']['url']) ?>"><?= $escaparNavegacion($datosContacto['telefono']['texto']) ?></a><?php endif; ?>
  </div>
</aside>
