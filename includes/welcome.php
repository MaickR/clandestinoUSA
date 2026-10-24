<?php
// Las plantillas se incluyen desde un documento, nunca como páginas independientes.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}
?>
<section class="cl-seccion cl-seccion--centrada" aria-labelledby="welcome-titulo">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 cl-home__bienvenida">
        <p class="cl-eyebrow">Welcome to The Clandestino</p>
        <h2 id="welcome-titulo">Spanish hospitality. A Mount Shasta address.</h2>
        <p class="cl-seccion__descripcion">Small plates, Spanish wines, and a place to slow down together.</p>
        <div class="cl-seccion__acciones"><a class="cl-boton" href="/about.html">Our Story</a></div>
      </div>
    </div>
  </div>
</section>
