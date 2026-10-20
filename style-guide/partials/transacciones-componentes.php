<?php
// Helpers de markup de referencia; no leen peticiones ni realizan operaciones.
$escaparTransaccion = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
$campoTransaccion = static function (string $id, string $etiqueta, string $tipo = 'text', bool $obligatorio = true, string $atributos = '') use ($escaparTransaccion): void {
    ?>
    <div class="cl-campo-grupo">
      <label class="cl-etiqueta" for="<?= $escaparTransaccion($id) ?>"><?= $escaparTransaccion($etiqueta) ?><?= $obligatorio ? ' · required' : ' · optional' ?></label>
      <?php if ($tipo === 'textarea') : ?>
        <textarea class="cl-campo" id="<?= $escaparTransaccion($id) ?>" maxlength="300" rows="3" aria-describedby="<?= $escaparTransaccion($id) ?>-error"<?= $obligatorio ? ' required' : '' ?> <?= $atributos ?>></textarea>
      <?php else : ?>
        <input class="cl-campo" id="<?= $escaparTransaccion($id) ?>" type="<?= $escaparTransaccion($tipo) ?>" autocomplete="off" aria-describedby="<?= $escaparTransaccion($id) ?>-error"<?= $obligatorio ? ' required' : '' ?> <?= $atributos ?>>
      <?php endif; ?>
      <p class="cl-mensaje-campo" id="<?= $escaparTransaccion($id) ?>-error" data-cl-error="<?= $escaparTransaccion($id) ?>" hidden></p>
    </div>
    <?php
};
$cantidadTransaccion = static function (string $id, string $etiqueta, int $maximo) use ($escaparTransaccion): void {
    ?>
    <div data-cl-control-cantidad>
      <label class="cl-etiqueta" for="<?= $escaparTransaccion($id) ?>"><?= $escaparTransaccion($etiqueta) ?></label>
      <div class="cl-cantidad">
        <button class="cl-boton-icono" type="button" data-cl-cantidad="restar" aria-label="Decrease <?= $escaparTransaccion($etiqueta) ?>"><?= iconoProducto('restar') ?></button>
        <input class="cl-campo cl-cantidad__campo" id="<?= $escaparTransaccion($id) ?>" type="number" min="1" max="<?= $maximo ?>" step="1" value="1" required aria-describedby="<?= $escaparTransaccion($id) ?>-error">
        <button class="cl-boton-icono" type="button" data-cl-cantidad="sumar" aria-label="Increase <?= $escaparTransaccion($etiqueta) ?>"><?= iconoProducto('sumar') ?></button>
      </div>
      <p class="cl-mensaje-campo cl-cantidad__mensaje" id="<?= $escaparTransaccion($id) ?>-error" data-cl-error="<?= $escaparTransaccion($id) ?>" role="status"></p>
    </div>
    <?php
};
$botonTransaccion = static function (string $texto, string $atributos = '') use ($escaparTransaccion): void {
    ?>
    <button class="cl-boton cl-boton--con-carga" type="button" <?= $atributos ?>><span class="cl-boton__reposo"><?= $escaparTransaccion($texto) ?></span><span class="cl-boton__carga"><span class="cl-spinner" aria-hidden="true"></span>Processing demo…</span></button>
    <?php
};
$resultadoTransaccion = static function (): void {
    ?>
    <div class="cl-transaccion__resultado" data-cl-checkout-resultado role="status" aria-atomic="true" tabindex="-1"><p class="cl-texto-pequeno">Local demonstration. Use fictional details only. Nothing is sent or saved.</p></div>
    <?php
};
$pasosTransaccion = static function (): void {
    ?>
    <ol class="cl-transaccion__pasos" aria-label="Preview progress"><li data-cl-checkout-paso="datos" aria-current="step">Your details</li><li data-cl-checkout-paso="revision">Review &amp; preview</li></ol>
    <?php
};
$revisionTransaccion = static function (string $titulo, string $accion) use ($botonTransaccion, $escaparTransaccion): void {
    ?>
    <div data-cl-checkout-revision hidden>
      <h3 tabindex="-1"><?= $escaparTransaccion($titulo) ?></h3>
      <dl class="cl-transaccion__datos" data-cl-checkout-datos></dl>
      <p class="cl-transaccion__nota">Demonstration only. No commercial operation will take place.</p>
      <div class="cl-transaccion__acciones"><?php $botonTransaccion($accion, 'data-cl-checkout-confirmar'); ?><button class="cl-boton cl-boton--secundario" type="button" data-cl-checkout-volver>Back to details</button></div>
    </div>
    <?php
};
$escenarioTransaccion = static function (string $id, array $opciones) use ($escaparTransaccion): void {
    ?>
    <details class="cl-guia-demo"><summary>Demo controls · <?= $escaparTransaccion($id) ?></summary>
      <label class="cl-etiqueta" for="w7-<?= $escaparTransaccion($id) ?>-escenario">Simulated outcome</label>
      <select class="cl-campo" id="w7-<?= $escaparTransaccion($id) ?>-escenario" data-cl-escenario>
        <?php foreach ($opciones as $valor => $texto) : ?><option value="<?= $escaparTransaccion($valor) ?>"><?= $escaparTransaccion($texto) ?></option><?php endforeach; ?>
      </select>
    </details>
    <?php
};
