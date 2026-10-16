<?php
require __DIR__ . '/visor-galeria.php';
$figuraGaleria = static function (string $nombre, string $titulo, string $descripcion, string $clase = '') use ($fotosEditoriales, $fotoEditorial, $escaparEditorial): void {
    $ruta = $fotosEditoriales[$nombre][0];
    $alt = $fotosEditoriales[$nombre][4];
    ?>
    <figure class="cl-galeria-editorial__figura <?= $escaparEditorial($clase) ?>">
      <a class="cl-galeria-editorial__abrir" href="../assets/images/avif/<?= $escaparEditorial($ruta) ?>.avif" data-cl-galeria-abrir data-cl-galeria-titulo="<?= $escaparEditorial($titulo) ?>" data-cl-galeria-descripcion="<?= $escaparEditorial($descripcion) ?>" data-cl-galeria-alt="<?= $escaparEditorial($alt) ?>" aria-label="<?= $escaparEditorial('Enlarge photograph: ' . $titulo) ?>">
        <?php $fotoEditorial($nombre, 'cl-galeria-editorial__imagen'); ?>
        <span class="cl-galeria-editorial__indicacion" aria-hidden="true">View <svg class="cl-icon" focusable="false"><use href="../assets/icons/cl-iconos.svg#cl-icon-sumar"></use></svg></span>
      </a>
      <figcaption class="cl-galeria-editorial__pie"><?= $escaparEditorial($titulo) ?></figcaption>
    </figure>
    <?php
};
?>
<section class="cl-seccion" id="galeria-editorial" aria-labelledby="galeria-editorial-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado">
      <p class="cl-eyebrow">Editorial gallery · The photo journal</p>
      <h2 id="galeria-editorial-titulo">A closer look at the table</h2>
      <p class="cl-seccion__descripcion">Textures, colors and details worth lingering over. Open a photograph to explore the whole frame, then follow the collection at your own pace.</p>
      <p class="cl-texto-pequeno">From the restaurant archive · Current dishes may differ.</p>
    </div>
    <div data-cl-galeria>
      <?php $visorGaleria('visor-editorial'); ?>
      <div class="cl-galeria-editorial">
        <?php $figuraGaleria('mesa', 'A table full of flavor', 'Cheeses, cured meats, olives and small bites. A board from our restaurant archive.', 'cl-galeria-editorial__figura--principal'); ?>
        <?php $figuraGaleria('maridaje', 'Where tapas meet wine', 'A sharing board, a bottle and glasses. Flavors to explore together.'); ?>
        <?php $figuraGaleria('arroz', 'From the kitchen archive', 'Rice, prawns and mussels, photographed for the restaurant collection. Not a current menu announcement.'); ?>
        <?php $figuraGaleria('bocadillo', 'A closer look', 'Toasted bread and a generous filling, served on a wooden board.'); ?>
        <?php $figuraGaleria('vino', 'At the barrel table', 'A wine bottle, carafe and glasses on one of the restaurant tables.'); ?>
        <?php $figuraGaleria('panorama', 'Room to share', 'The whole sharing board, with cheeses, cured meats, almonds and bocadillos.', 'cl-galeria-editorial__figura--panorama'); ?>
      </div>
    </div>
    <details class="cl-guia-demo">
      <summary>Gallery states · Missing, single, error &amp; empty</summary>
      <div class="row cl-guia-rejilla">
        <div class="col-md-6">
          <figure class="cl-galeria-editorial__figura">
            <div class="cl-galeria-editorial__ausente"><p>Photograph unavailable · example</p></div>
            <figcaption class="cl-galeria-editorial__pie">The caption remains readable. An absent photograph has no enlargement control and is not counted.</figcaption>
          </figure>
        </div>
        <div class="col-md-6" data-cl-galeria>
          <?php $visorGaleria('visor-foto-unica'); ?>
          <div class="cl-estado-vista">
            <h3 class="cl-estado-vista__titulo">One photograph, the whole story</h3>
            <p class="cl-estado-vista__texto">Single-photo example. Previous and Next are disabled; close remains available.</p>
            <a class="cl-boton cl-boton--secundario" href="../assets/images/avif/gallery/wines/the-clandestino-wines-table.avif" data-cl-galeria-abrir data-cl-galeria-titulo="At the barrel table" data-cl-galeria-descripcion="One photograph from the restaurant archive." data-cl-galeria-alt="A wine bottle, carafe and glasses on a wooden barrel table" data-cl-galeria-ancho="1536" data-cl-galeria-alto="2048">Open single-photo viewer</a>
          </div>
        </div>
        <div class="col-md-6" data-cl-galeria>
          <?php $visorGaleria('visor-error-foto'); ?>
          <div class="cl-estado-vista cl-estado-vista--error">
            <h3 class="cl-estado-vista__titulo">A photograph fails to load</h3>
            <p class="cl-estado-vista__texto">Local decoding-error example. Open the viewer, then use Next to recover with a valid photograph.</p>
            <!-- Un recurso de texto local responde 200 pero no decodifica como imagen. -->
            <a class="cl-boton cl-boton--secundario" href="../assets/icons/LICENCIA-bootstrap-icons.txt" data-cl-galeria-abrir data-cl-galeria-titulo="Photograph unavailable · example" data-cl-galeria-descripcion="This deliberately tests image decoding failure, without a missing URL.">Open image error example</a>
            <a class="cl-enlace cl-experiencia__accion" href="../assets/images/avif/gallery/tapas/the-clandestino-tapas-6.avif" data-cl-galeria-abrir data-cl-galeria-titulo="Back at the table" data-cl-galeria-descripcion="A valid photograph for recovering from the preceding example." data-cl-galeria-alt="Cheeses and cured meats on a sharing board" data-cl-galeria-ancho="2048" data-cl-galeria-alto="1536">Open recovery photograph</a>
          </div>
        </div>
        <div class="col-md-6" data-cl-galeria>
          <div class="cl-estado-vista">
            <h3 class="cl-estado-vista__titulo">More photographs to come</h3>
            <p class="cl-estado-vista__texto">Empty collection example. There is no viewer to open until photographs are available.</p>
          </div>
        </div>
      </div>
    </details>
  </div>
</section>

<section class="cl-seccion cl-seccion--alterna" id="video-editorial" aria-labelledby="video-editorial-titulo">
  <div class="container cl-media-video">
    <div class="cl-seccion__encabezado">
      <p class="cl-eyebrow">Video &amp; media</p>
      <h2 id="video-editorial-titulo">A glimpse of The Clandestino</h2>
      <p class="cl-seccion__descripcion">A place, a table, an atmosphere. This still photograph represents an editorial film feature awaiting a suitable video.</p>
    </div>
    <div class="row cl-valores">
      <div class="col-lg-8">
        <figure class="cl-media-video__figura">
          <?php $fotoEditorial('interior', 'cl-media-video__pantalla'); ?>
          <figcaption class="cl-media-video__contexto">Still photograph of the restaurant · Video preview unavailable. This image is not a playable film.</figcaption>
        </figure>
      </div>
      <div class="col-lg-4 cl-valores__introduccion">
        <p class="cl-eyebrow">An invitation inside</p>
        <h3>From the bar to the table</h3>
        <p>Wooden tables, hanging glasses and the restaurant interior, seen in our existing photography.</p>
        <div class="cl-alerta cl-alerta--aviso">
          <div class="cl-alerta__contenido">
            <p class="cl-alerta__titulo">Video pending</p>
            <p class="cl-alerta__mensaje">A suitable film, matching poster and media permissions still need confirmation. Captions and a text alternative are required where applicable.</p>
          </div>
        </div>
        <a class="cl-enlace cl-experiencia__accion" href="#galeria-editorial">Explore the photo gallery</a>
      </div>
    </div>
    <details class="cl-guia-demo">
      <summary>Video states &amp; native player contract</summary>
      <div class="row cl-guia-rejilla">
        <div class="col-md-6">
          <div class="cl-estado-vista cl-estado-vista--error">
            <h3 class="cl-estado-vista__titulo">The film could not be played</h3>
            <p class="cl-estado-vista__texto">Playback error · static example. You can still explore the photographs.</p>
            <a class="cl-enlace cl-experiencia__accion" href="#galeria-editorial">Return to the gallery</a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="cl-alerta cl-alerta--aviso">
            <div class="cl-alerta__contenido">
              <h3 class="cl-alerta__titulo">Captions pending · publication on hold</h3>
              <p class="cl-alerta__mensaje">No caption files were found in the repository. Films requiring captions must remain unpublished until reviewed captions and a text alternative are ready.</p>
            </div>
          </div>
        </div>
      </div>
      <p class="cl-media-video__contexto">For approved media, use a native video with controls, a matching poster, explicit dimensions, playsinline and preload="none". Playback and pause belong to the browser. Portrait media uses its original ratio. No automatic playback.</p>
      <figure class="cl-media-video__figura">
        <?php $fotoEditorial('vino', 'cl-media-video__pantalla cl-media-video__pantalla--vertical'); ?>
        <figcaption class="cl-media-video__contexto">Portrait media layout · Still photograph only. A film and its matching poster remain pending; the photograph is contained without distortion.</figcaption>
      </figure>
      <!-- Contrato inerte: no src ficticio, request de video ni controles engañosos.
           Al publicar: sustituir este template por video con source/poster reales,
           track revisado si corresponde y alternativa textual adyacente.
           El error nativo conserva un enlace externo al reproductor para recuperar. -->
      <template id="contrato-video-editorial">
        <video class="cl-media-video__pantalla" controls playsinline preload="none" width="1920" height="1080" aria-label="Restaurant film" aria-describedby="video-alternativa">
          <p>Your browser cannot play this film. Explore the photographs instead.</p>
        </video>
      </template>
      <p id="video-alternativa">Text alternative: the still image shows the restaurant's wooden barrel tables, bar and hanging wine glasses. It does not describe an unreviewed film.</p>
    </details>
  </div>
</section>
