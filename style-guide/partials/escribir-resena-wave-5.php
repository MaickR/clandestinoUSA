<section class="cl-seccion cl-seccion--alterna" id="write-review" aria-labelledby="write-review-titulo">
  <div class="container">
    <div class="row cl-catalogo">
      <div class="col-lg-4"><p class="cl-eyebrow">Write a Review · local demonstration</p><h2 id="write-review-titulo">Tell us about your table</h2><p>Your perspective deserves time and care. Choose a rating and share the details that matter to you.</p><p class="cl-texto-pequeno cl-texto-secundario">This example does not collect your identity. Use sample text only. Nothing is sent, saved or added to the review listing.</p></div>
      <div class="col-lg-7 offset-lg-1">
        <form class="cl-resena-formulario" data-cl-resena-formulario novalidate aria-labelledby="write-review-titulo">
          <fieldset class="cl-resena-formulario__puntuacion" aria-describedby="resena-puntuacion-ayuda resena-puntuacion-error">
            <legend class="cl-etiqueta">Your rating · required</legend>
            <div class="cl-resena-formulario__opciones">
              <?php for ($i = 1; $i <= 5; $i++) : ?>
              <label class="cl-resena-formulario__opcion" for="resena-estrella-<?= $i ?>"><input class="visually-hidden" type="radio" name="puntuacion" id="resena-estrella-<?= $i ?>" value="<?= $i ?>" required aria-describedby="resena-puntuacion-ayuda resena-puntuacion-error"><span><span aria-hidden="true" class="cl-resena-formulario__estrella">★ </span><?= $i ?><span class="visually-hidden"> <?= $i === 1 ? 'star' : 'stars' ?></span></span></label>
              <?php endfor; ?>
            </div>
            <p class="cl-mensaje-campo cl-mensaje-campo--ayuda" id="resena-puntuacion-ayuda">1 = poor · 5 = excellent. Use arrow keys within the rating group.</p>
            <p class="cl-mensaje-campo" id="resena-puntuacion-error" hidden>Choose a rating from 1 to 5.</p>
          </fieldset>
          <div class="cl-campo-grupo"><label class="cl-etiqueta" for="resena-texto">Your review · required</label><textarea class="cl-campo" id="resena-texto" name="texto" rows="6" required minlength="20" aria-describedby="resena-texto-ayuda resena-contador resena-texto-error"></textarea><p class="cl-mensaje-campo cl-mensaje-campo--ayuda" id="resena-texto-ayuda">20–1,000 characters. Please avoid private information. Longer text is retained for correction, but cannot be submitted.</p><p class="cl-texto-pequeno" id="resena-contador" data-cl-resena-contador>0 / 1,000 characters</p><p class="cl-mensaje-campo" id="resena-texto-error" hidden>Write between 20 and 1,000 characters.</p></div>
          <div class="cl-campo-grupo"><label class="cl-opcion" for="resena-aviso"><input class="cl-opcion__control" id="resena-aviso" name="aviso" type="checkbox" required aria-describedby="resena-aviso-ayuda resena-aviso-error"><span class="cl-opcion__texto">I understand this is a demonstration · required</span></label><p class="cl-mensaje-campo cl-mensaje-campo--ayuda" id="resena-aviso-ayuda">No publication or media consent is collected. A real service will explain its privacy and moderation policy before submission.</p><p class="cl-mensaje-campo" id="resena-aviso-error" hidden>Confirm that you understand the demonstration.</p></div>
          <div class="cl-resena-formulario__pie"><button class="cl-boton cl-boton--con-carga" type="submit" disabled><span class="cl-boton__reposo">Submit example review</span><span class="cl-boton__carga"><span class="cl-spinner" aria-hidden="true"></span>Simulating…</span></button><button class="cl-boton cl-boton--secundario" type="reset" disabled>Clear example</button></div>
          <div class="cl-resena-formulario__feedback" data-cl-resena-feedback role="status" aria-atomic="true"><p>Demonstration only. No review has been submitted.</p></div>
          <details class="cl-guia-demo"><summary>Demo controls · simulated submission</summary><label class="cl-etiqueta" for="resena-resultado-demo">Simulated outcome</label><select class="cl-campo" id="resena-resultado-demo" data-cl-resena-resultado disabled><option value="success">Success · pending moderation</option><option value="error">Failure · retain text</option></select></details>
          <noscript><p>Submission is unavailable without JavaScript. This demonstration has no server endpoint.</p></noscript>
        </form>
      </div>
    </div>
  </div>
</section>
