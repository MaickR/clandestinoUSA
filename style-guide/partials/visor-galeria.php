<?php
// Una única estructura de visor para las colecciones del laboratorio.
$visorGaleria = static function (string $identificador) use ($escaparEditorial): void {
    $id = $escaparEditorial($identificador);
    ?>
    <div class="modal fade cl-modal cl-visor" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>-nombre" aria-hidden="true" data-cl-galeria-visor>
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable cl-visor__dialogo">
        <div class="modal-content cl-modal__superficie">
          <div class="cl-visor__cabecera">
            <h2 class="cl-modal__titulo" id="<?= $id ?>-nombre">Photo journal</h2>
            <button class="cl-boton-icono" type="button" data-bs-dismiss="modal" data-cl-galeria-cerrar aria-label="Close photograph viewer"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="../assets/icons/cl-iconos.svg#cl-icon-cerrar"></use></svg></button>
          </div>
          <div class="modal-body cl-visor__cuerpo">
            <figure class="cl-visor__figura">
              <div class="cl-visor__media" data-cl-galeria-media aria-busy="false">
                <img class="cl-visor__foto" alt="" data-cl-galeria-foto hidden>
                <div class="cl-visor__carga" data-cl-galeria-carga hidden><span class="cl-spinner" aria-hidden="true"></span><span>Loading photograph…</span></div>
                <div class="cl-estado-vista cl-estado-vista--error cl-visor__error" data-cl-galeria-error hidden>
                  <h3 class="cl-estado-vista__titulo">The photograph could not be loaded</h3>
                  <p class="cl-estado-vista__texto">Close the viewer to return to the collection, or choose Next photograph when available.</p>
                </div>
              </div>
              <figcaption class="cl-visor__pie">
                <h3 class="cl-visor__titulo" data-cl-galeria-titulo>Photograph</h3>
                <p class="cl-visor__descripcion" data-cl-galeria-descripcion></p>
              </figcaption>
            </figure>
            <p class="visually-hidden" role="status" aria-live="polite" aria-atomic="true" data-cl-galeria-anuncio></p>
          </div>
          <div class="cl-visor__controles">
            <button class="cl-boton-icono" type="button" data-cl-galeria-anterior aria-label="Previous photograph"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="../assets/icons/cl-iconos.svg#cl-icon-volver"></use></svg></button>
            <span class="cl-visor__contador" data-cl-galeria-contador aria-label="Photograph position">—</span>
            <button class="cl-boton-icono" type="button" data-cl-galeria-siguiente aria-label="Next photograph"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="../assets/icons/cl-iconos.svg#cl-icon-siguiente"></use></svg></button>
          </div>
        </div>
      </div>
    </div>
    <?php
};
