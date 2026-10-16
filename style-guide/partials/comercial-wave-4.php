<?php
// Helpers exclusivos de la guía; no son un motor de formularios comercial.
$escaparComercial = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
$campoComercial = static function (string $id, string $etiqueta, string $tipo = 'text', bool $obligatorio = false, string $atributos = '') use ($escaparComercial): void {
    $id = $escaparComercial($id);
    ?>
    <div class="cl-campo-grupo">
      <label class="cl-etiqueta" for="<?= $id ?>"><?= $escaparComercial($etiqueta) ?> <?= $obligatorio ? '(required)' : '(optional)' ?></label>
      <?php if ($tipo === 'textarea') : ?>
        <textarea class="cl-campo" id="<?= $id ?>" maxlength="300" aria-describedby="<?= $id ?>-error"></textarea>
      <?php else : ?>
        <input class="cl-campo" id="<?= $id ?>" type="<?= $escaparComercial($tipo) ?>" <?= $obligatorio ? 'required' : '' ?> <?= $atributos ?> aria-describedby="<?= $id ?>-error">
      <?php endif; ?>
      <p class="cl-mensaje-campo" id="<?= $id ?>-error" hidden></p>
    </div>
    <?php
};
$botonComercial = static function (string $texto): void { ?>
  <button class="cl-boton cl-boton--con-carga" type="submit" data-cl-demo-enviar disabled><span class="cl-boton__reposo"><?= htmlspecialchars($texto, ENT_QUOTES, 'UTF-8') ?> · demo</span><span class="cl-boton__carga"><span class="cl-spinner" aria-hidden="true"></span>Working · demo…</span></button>
<?php };
$controlesComerciales = static function (string $id) use ($escaparComercial): void { ?>
  <fieldset class="cl-guia-controles-demo"><legend>Demo controls</legend><label class="cl-etiqueta" for="<?= $escaparComercial($id) ?>-outcome">Simulated outcome</label><select class="cl-campo" id="<?= $escaparComercial($id) ?>-outcome"><option value="exito">Success</option><option value="error">Failure</option></select><p class="cl-texto-pequeno">Local test controls. Use the action above to see waiting and feedback. Nothing is sent or stored.</p></fieldset>
<?php };
?>
<div class="cl-guia-comercial">
<section class="cl-seccion cl-seccion--alterna" id="wave-4" aria-labelledby="wave-4-titulo">
  <div class="container">
    <p class="cl-eyebrow">Wave 4 · Invitations &amp; occasions</p>
    <h2 id="wave-4-titulo">More ways to come together</h2>
    <p class="cl-seccion__descripcion">A wine discovery. A thoughtful gift. An evening to remember. Four families for the next chapter of The Clandestino.</p>
    <div class="cl-alerta"><div class="cl-alerta__contenido"><p class="cl-alerta__mensaje">Design demonstration only. Prices, benefits, dates and availability are examples, not current offers. Use fictional details. No payment, booking, delivery or membership is created. Reload to clear the demos. Visual approval pending.</p></div></div>
    <noscript><p class="cl-alerta">Enable JavaScript to try local selections and feedback. Demonstration actions are disabled without it.</p></noscript>
    <nav aria-label="Wave 4 families"><ul class="cl-guia-indice">
      <li><a class="cl-enlace" href="#wine-club">Wine Club</a></li>
      <li><a class="cl-enlace" href="#gift-cards">Gift Cards</a></li>
      <li><a class="cl-enlace" href="#events">Events</a></li>
      <li><a class="cl-enlace" href="#private-experiences">Private Experiences</a></li>
      <li><a class="cl-enlace" href="#wave-4-states">States</a></li>
    </ul></nav>
  </div>
</section>
<?php require __DIR__ . '/wine-club-wave-4.php'; ?>
<?php require __DIR__ . '/gift-cards-wave-4.php'; ?>
<?php require __DIR__ . '/events-wave-4.php'; ?>
<?php require __DIR__ . '/private-experiences-wave-4.php'; ?>
<?php require __DIR__ . '/estados-wave-4.php'; ?>
</div>
