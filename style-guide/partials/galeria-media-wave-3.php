<section class="cl-seccion" id="galeria-editorial" aria-labelledby="galeria-editorial-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado">
      <p class="cl-eyebrow">Editorial gallery</p>
      <h2 id="galeria-editorial-titulo">A closer look at the table</h2>
      <p class="cl-seccion__descripcion">Textures, colors and the small details that make you want to stay. Photographs from our collection; current dishes may differ.</p>
    </div>
    <div class="cl-galeria-editorial">
      <figure class="cl-galeria-editorial__figura cl-galeria-editorial__figura--principal">
        <?php $fotoEditorial('mesa', 'cl-galeria-editorial__imagen'); ?>
        <figcaption class="cl-galeria-editorial__pie">For the center of the table · A board full of textures and flavors.</figcaption>
      </figure>
      <figure class="cl-galeria-editorial__figura">
        <?php $fotoEditorial('maridaje', 'cl-galeria-editorial__imagen'); ?>
        <figcaption class="cl-galeria-editorial__pie">Tapas meet wine · An invitation to explore them together.</figcaption>
      </figure>
      <figure class="cl-galeria-editorial__figura">
        <?php $fotoEditorial('arroz', 'cl-galeria-editorial__imagen'); ?>
        <figcaption class="cl-galeria-editorial__pie">From the archive · Rice, prawns and mussels.</figcaption>
      </figure>
      <figure class="cl-galeria-editorial__figura">
        <?php $fotoEditorial('bocadillo', 'cl-galeria-editorial__imagen'); ?>
        <figcaption class="cl-galeria-editorial__pie">A closer look · Toasted bread and a generous filling.</figcaption>
      </figure>
      <figure class="cl-galeria-editorial__figura">
        <?php $fotoEditorial('vino', 'cl-galeria-editorial__imagen'); ?>
        <figcaption class="cl-galeria-editorial__pie">At the barrel table · A bottle and glasses ready for conversation.</figcaption>
      </figure>
      <figure class="cl-galeria-editorial__figura cl-galeria-editorial__figura--panorama">
        <?php $fotoEditorial('panorama', 'cl-galeria-editorial__imagen'); ?>
        <figcaption class="cl-galeria-editorial__pie">Room to share · The whole board, without a crop.</figcaption>
      </figure>
    </div>
    <details class="cl-guia-demo">
      <summary>Gallery fallback · Local example</summary>
      <div class="row cl-guia-rejilla">
        <div class="col-md-6">
          <figure class="cl-galeria-editorial__figura">
            <div class="cl-galeria-editorial__ausente"><p>Photograph unavailable · example</p></div>
            <figcaption class="cl-galeria-editorial__pie">The caption remains available when the photograph cannot be shown. No broken image is requested.</figcaption>
          </figure>
        </div>
        <div class="col-md-6">
          <div class="cl-estado-vista">
            <h3 class="cl-estado-vista__titulo">More photographs to come</h3>
            <p class="cl-estado-vista__texto">Empty collection example. Publish a gallery once suitable photographs are available.</p>
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
