<section class="cl-seccion" id="experiencias" aria-labelledby="experiencias-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado">
      <p class="cl-eyebrow">Experiences</p>
      <h2 id="experiencias-titulo">Find your way to the table</h2>
      <p class="cl-seccion__descripcion">A plate to pass around. A wine to discover. An occasion to bring people together.</p>
    </div>
    <div class="row cl-experiencias">
      <div class="col-md-6 col-lg-4">
        <article class="cl-experiencia" aria-labelledby="experiencia-tapas-titulo">
          <div class="cl-experiencia__media"><?php $fotoEditorial('maridaje', 'cl-experiencia__imagen'); ?></div>
          <div class="cl-experiencia__contenido">
            <p class="cl-eyebrow">Tapas &amp; wine</p>
            <h3 id="experiencia-tapas-titulo">A little of everything</h3>
            <p class="cl-experiencia__descripcion">Start with a sharing board, explore the wines and let the conversation find its own pace.</p>
            <a class="cl-enlace cl-experiencia__accion" href="../menu.html">Explore tapas &amp; wine</a>
          </div>
        </article>
      </div>
      <div class="col-md-6 col-lg-4">
        <article class="cl-experiencia" aria-labelledby="experiencia-club-titulo">
          <div class="cl-experiencia__media"><?php $fotoEditorial('vino', 'cl-experiencia__imagen'); ?></div>
          <div class="cl-experiencia__contenido">
            <p class="cl-eyebrow">Spanish Wine Club</p>
            <h3 id="experiencia-club-titulo">Follow your curiosity</h3>
            <p class="cl-experiencia__descripcion">Discover another side of Spanish wine. Explore the club and talk with us about the details.</p>
            <a class="cl-enlace cl-experiencia__accion" href="../swc.html">Discover the Wine Club</a>
          </div>
        </article>
      </div>
      <div class="col-md-12 col-lg-4">
        <article class="cl-experiencia cl-experiencia--sin-imagen" aria-labelledby="experiencia-sin-foto-titulo">
          <div class="cl-experiencia__contenido">
            <p class="cl-eyebrow">Gourmet experiences</p>
            <h3 id="experiencia-sin-foto-titulo">Something worth sharing</h3>
            <p class="cl-experiencia__descripcion">Explore the gourmet collection and ask us about the options for your occasion.</p>
            <p class="cl-texto-pequeno">Photography and experience details pending.</p>
            <a class="cl-enlace cl-experiencia__accion" href="../hampers.html">Explore gourmet gifts</a>
          </div>
        </article>
      </div>
    </div>
    <article class="cl-experiencia cl-experiencia--destacada" aria-labelledby="experiencia-privada-titulo">
      <div class="cl-experiencia__media"><?php $fotoEditorial('tapas', 'cl-experiencia__imagen'); ?></div>
      <div class="cl-experiencia__contenido">
        <p class="cl-eyebrow">Private gatherings</p>
        <h3 class="cl-titulo-1" id="experiencia-privada-titulo">Good company deserves a table</h3>
        <p class="cl-experiencia__descripcion">A celebration, a reunion, or simply time together. Tell us what you have in mind and we can discuss the possibilities.</p>
        <p class="cl-texto-pequeno">Dates, format and availability to be confirmed with the restaurant.</p>
        <a class="cl-enlace cl-experiencia__accion" href="../contact.html#contact-form">Ask about your gathering</a>
      </div>
    </article>
    <details class="cl-guia-demo">
      <summary>Experience states · Local examples</summary>
      <div class="row cl-guia-rejilla">
        <div class="col-md-6">
          <article class="cl-experiencia cl-experiencia--sin-imagen" aria-labelledby="experiencia-pendiente-titulo">
            <div class="cl-experiencia__contenido">
              <p class="cl-eyebrow">Information pending · example</p>
              <h3 id="experiencia-pendiente-titulo">An occasion of your own</h3>
              <p>Details are not confirmed. There is no booking action in this example.</p>
              <span class="cl-estado">Details pending</span>
            </div>
          </article>
        </div>
        <div class="col-md-6">
          <article class="cl-experiencia cl-experiencia--sin-imagen" aria-labelledby="experiencia-no-disponible-titulo">
            <div class="cl-experiencia__contenido">
              <p class="cl-eyebrow">Unavailable · simulated state</p>
              <h3 id="experiencia-no-disponible-titulo">A gathering on another day</h3>
              <p>This illustrates an unavailable experience, not the restaurant's current calendar.</p>
              <span class="cl-estado cl-estado--error">Not available · example</span>
            </div>
          </article>
        </div>
      </div>
    </details>
  </div>
</section>
