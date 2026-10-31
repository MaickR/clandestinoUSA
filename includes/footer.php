<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<!-- Cuatro áreas editoriales con datos de archivo; sin servicios comerciales simulados. -->
<footer class="cl-pie" id="pie-global" aria-label="The Clandestino USA">
  <div class="container cl-pie__principal">
    <div class="row cl-pie__columnas">
      <div class="col-12 col-xl-3 cl-pie__grupo cl-pie__marca">
        <a href="<?= $escaparNavegacion($rutasNavegacion['Home']) ?>" aria-label="The Clandestino USA · Home"><img class="cl-pie__logo" src="<?= $escaparNavegacion($logoNavegacion) ?>" width="174" height="79" alt="The Clandestino USA" loading="lazy"></a>
        <p class="cl-pie__descripcion"><?= $escaparNavegacion($descripcionPie) ?></p>
        <?php if ($redesSociales) : ?>
        <ul class="cl-pie__redes" aria-label="Social profiles">
          <?php foreach ($redesSociales as $red) : ?>
          <li><a class="cl-pie__social" href="<?= $escaparNavegacion($red['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= $escaparNavegacion($red['nombre']) ?> (opens a new tab)"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-<?= $escaparNavegacion($red['icono']) ?>"></use></svg></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
      <nav class="col-md-3 col-xl-2 cl-pie__grupo cl-pie__explorar" aria-label="Explore The Clandestino">
        <p class="cl-pie__etiqueta">Explore</p>
        <ul class="cl-pie__lista">
          <?php foreach ($rutasNavegacion as $nombre => $ruta) : ?>
          <li><a class="cl-enlace" href="<?= $escaparNavegacion($ruta) ?>"<?= $nombre !== 'Home' ? $atributoDestinoNavegacion : '' ?>><?= $escaparNavegacion($nombre) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <nav class="col-md-4 col-xl-3 cl-pie__grupo cl-pie__grupo--separado" aria-label="Discover more">
        <p class="cl-pie__etiqueta">Discover more</p>
        <ul class="cl-pie__lista">
          <?php foreach ($enlacesPieDescubrir as $nombre => $ruta) : ?>
          <li><a class="cl-enlace" href="<?= $escaparNavegacion($ruta) ?>"<?= $atributoDestinoNavegacion ?>><?= $escaparNavegacion($nombre) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <div class="col-md-5 col-xl-4 cl-pie__grupo cl-pie__grupo--separado">
        <p class="cl-pie__etiqueta">Visit &amp; contact</p>
        <address class="cl-contacto">
          <?php if ($datosContacto['direccion']) : ?><p class="cl-contacto__direccion"><?php foreach ($datosContacto['direccion'] as $indice => $linea) : ?><?= $indice ? '<br>' : '' ?><?= $escaparNavegacion($linea) ?><?php endforeach; ?></p><?php endif; ?>
          <?php if ($datosContacto['mapa']) : ?><p><a class="cl-enlace" href="<?= $escaparNavegacion($datosContacto['mapa']) ?>" target="_blank" rel="noopener noreferrer">Find us on Google Maps<span class="visually-hidden"> (opens a new tab)</span></a></p><?php endif; ?>
          <?php if ($datosContacto['telefono']) : ?><p><a class="cl-enlace" href="<?= $escaparNavegacion($datosContacto['telefono']['url']) ?>"><?= $escaparNavegacion($datosContacto['telefono']['texto']) ?></a></p><?php endif; ?>
          <?php if ($datosContacto['email']) : ?><p><a class="cl-enlace" href="mailto:<?= $escaparNavegacion($datosContacto['email']) ?>"><?= $escaparNavegacion($datosContacto['email']) ?></a></p><?php endif; ?>
          <?php if ($datosContacto['horario']) : ?><p><?= implode('<br>', array_map($escaparNavegacion, $datosContacto['horario'])) ?></p><?php endif; ?>
        </address>
      </div>
    </div>
  </div>
  <div class="cl-pie__franja"><div class="container cl-pie__base">
    <?php if ($enlacesLegales) : ?><nav class="cl-pie__legales" aria-label="Legal information"><?php foreach ($enlacesLegales as $nombre => $ruta) : ?><a class="cl-enlace" href="<?= $escaparNavegacion($ruta) ?>"<?= $atributoDestinoNavegacion ?>><?= $escaparNavegacion($nombre) ?></a><?php endforeach; ?></nav>
    <?php else : ?><p>Legal information · publication pending in this example.</p><?php endif; ?>
    <p>© <?= date('Y') ?> The Clandestino USA</p>
  </div></div>
</footer>
