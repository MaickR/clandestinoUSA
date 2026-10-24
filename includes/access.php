<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<!-- Solo credenciales sintéticas readonly. No existe endpoint ni envío de autenticación. -->
<div class="modal fade cl-modal cl-acceso" id="acceso-global" data-cl-acceso tabindex="-1" aria-labelledby="acceso-global-titulo" aria-describedby="acceso-global-nota" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"><div class="modal-content cl-modal__superficie">
    <div class="modal-header cl-modal__cabecera">
      <p class="cl-eyebrow">The Clandestino USA</p>
      <button class="cl-boton-icono" type="button" data-bs-dismiss="modal" aria-label="Close sign in"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-cerrar"></use></svg></button>
    </div>
    <div class="modal-body cl-acceso__contenido">
      <h2 class="cl-acceso__titulo" id="acceso-global-titulo">Welcome back</h2>
      <p class="cl-texto-secundario">A familiar place. A little closer.</p>
      <p class="cl-texto-pequeno" id="acceso-global-nota">Design preview only. Sample fields are read-only. Nothing is sent or stored; no account session is created.</p>
      <form data-cl-acceso-formulario novalidate>
        <div class="cl-campo-grupo"><label class="cl-etiqueta" for="acceso-email">Email</label><input class="cl-campo" id="acceso-email" type="email" autocomplete="username" value="guest@example.invalid" readonly aria-describedby="acceso-email-error"><p class="cl-mensaje-campo" id="acceso-email-error" hidden>Enter a valid email address.</p></div>
        <div class="cl-campo-grupo"><label class="cl-etiqueta" for="acceso-clave">Password</label><div class="cl-acceso__clave"><input class="cl-campo" id="acceso-clave" type="password" autocomplete="current-password" value="sample-only" readonly aria-describedby="acceso-clave-error"><button class="cl-boton cl-boton--secundario cl-acceso__mostrar" type="button" data-cl-acceso-mostrar aria-label="Show password" aria-pressed="false" aria-controls="acceso-clave" hidden>Show</button></div><p class="cl-mensaje-campo" id="acceso-clave-error" hidden>Use at least 8 characters in this sample.</p></div>
        <button class="cl-boton cl-boton--con-carga cl-acceso__enviar" data-cl-acceso-enviar type="submit" disabled><span class="cl-boton__reposo">Sign in</span><span class="cl-boton__carga"><span class="cl-spinner" aria-hidden="true"></span>Checking sample…</span></button>
      </form>
      <div class="cl-acceso__feedback" data-cl-acceso-feedback role="status" aria-atomic="true"></div>
      <div class="cl-acceso__futuro"><p>Password recovery · future</p><p>Account registration · future</p></div>
      <details class="cl-acceso__laboratorio"><summary>Preview states · sample data only</summary><label class="cl-etiqueta" for="acceso-estado">Interface state</label><select class="cl-campo" id="acceso-estado" data-cl-acceso-estado disabled><option value="ready">Ready sample</option><option value="invalid">Invalid sample · try Sign in</option><option value="loading">Loading preview</option><option value="error">Access error preview</option><option value="complete">Completion preview · no session</option></select></details>
    </div>
  </div></div>
</div>
