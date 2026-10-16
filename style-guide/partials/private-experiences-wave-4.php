<section class="cl-seccion cl-seccion--alterna" id="private-experiences" aria-labelledby="private-experiences-titulo">
  <div class="container">
    <div class="row cl-media-contenido">
      <div class="col-md-6 cl-media-contenido__media"><?php $fotoEditorial('interior', 'cl-media-contenido__imagen'); ?></div>
      <div class="col-md-6 cl-media-contenido__contenido"><p class="cl-eyebrow">Private Experiences</p><h2 id="private-experiences-titulo">Your people. Your occasion.</h2><p class="cl-seccion__descripcion">Make room for a birthday, an anniversary, a team gathering, or simply time together.</p><p>Spanish tapas, wine and the restaurant setting offer a starting point for the conversation. Tell us what you have in mind; format, group size, menu and availability need confirmation.</p><a class="cl-boton cl-boton--secundario" href="#private-form">Start a conversation · demo</a></div>
    </div>
    <ul class="cl-consulta-privada__ocasiones" aria-label="Occasions to discuss"><li>Birthdays</li><li>Anniversaries</li><li>Celebrations</li><li>Corporate gatherings</li><li>Private get-togethers</li><li>Personalized dining</li></ul>
    <div class="row cl-guia-rejilla">
      <div class="col-lg-8">
        <form class="cl-consulta-privada" id="private-demo" data-cl-comercial-demo novalidate aria-describedby="private-help">
          <h3 id="private-form">Begin with an inquiry</h3><p id="private-help">Tell us about the occasion you have in mind. A real inquiry would begin a conversation with the team; a reservation would follow only after availability and details are confirmed. Local demo: use fictional details. Nothing is sent.</p>
          <div class="row cl-guia-rejilla cl-consulta-privada__campos">
            <div class="col-md-6"><?php $campoComercial('private-name', 'Your name', 'text', true, 'maxlength="80" autocomplete="off"'); ?></div>
            <div class="col-md-6"><?php $campoComercial('private-email', 'Email', 'email', true, 'maxlength="120" autocomplete="off"'); ?></div>
            <div class="col-md-6"><?php $campoComercial('private-date', 'Preferred date · restaurant local date', 'date', true); ?></div>
            <div class="col-md-6"><?php $campoComercial('private-guests', 'Approximate number of guests', 'number', true, 'min="1" step="1"'); ?></div>
          </div>
          <div class="cl-campo-grupo">
            <label class="cl-etiqueta" for="private-occasion">Occasion (required)</label>
            <select class="cl-campo" id="private-occasion" required aria-describedby="private-occasion-error">
              <option value="">Choose an occasion</option>
              <?php foreach (['birthday' => 'Birthday', 'anniversary' => 'Anniversary', 'celebration' => 'Celebration', 'corporate' => 'Corporate gathering', 'private' => 'Private get-together', 'dining' => 'Personalized dining'] as $valorOcasion => $nombreOcasion) : ?>
              <option value="<?= $escaparComercial($valorOcasion) ?>"><?= $escaparComercial($nombreOcasion) ?></option>
              <?php endforeach; ?>
            </select>
            <p class="cl-mensaje-campo" id="private-occasion-error" hidden></p>
          </div>
          <?php $campoComercial('private-message', 'Anything else we should know? · up to 300 characters', 'textarea'); ?>
          <p class="cl-texto-pequeno">Share only what helps plan the occasion. No payment details or sensitive personal information. A preferred date is a request, not an available slot.</p>
          <div class="cl-seccion__acciones"><?php $botonComercial('Review my inquiry'); ?><button class="cl-boton cl-boton--secundario" type="reset">Clear inquiry</button></div>
          <div class="cl-guia-resultado" id="private-feedback" role="status" aria-atomic="true">Complete the required fields to try the inquiry.</div><p data-cl-demo-confirmacion hidden></p>
        </form>
      </div>
      <div class="col-lg-4"><aside class="cl-catalogo__resumen" aria-labelledby="private-next"><p class="cl-eyebrow">From an idea to an occasion</p><h3 id="private-next">A conversation comes first</h3><ol><li><strong>Initial inquiry.</strong> Share your preferred date, group size and occasion.</li><li><strong>Team conversation.</strong> Discuss the format and possibilities.</li><li><strong>Separate confirmation.</strong> Agree details only if availability is confirmed.</li></ol><p class="cl-texto-pequeno">Illustrative inquiry flow. No response time, capacity, private hire, package or booking guarantee is promised.</p><p id="private-summary" role="status">Your inquiry preview is empty.</p></aside><details class="cl-guia-demo"><summary>Private Experiences · Demo controls</summary><?php $controlesComerciales('private'); ?></details></div>
    </div>
  </div>
</section>
