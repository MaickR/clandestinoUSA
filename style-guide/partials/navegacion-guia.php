<!-- $paginaGuia identifica la página que incluye esta navegación local. -->
<nav class="cl-guia-navegacion" aria-label="Design system pages">
  <a class="cl-enlace" href="./"<?= $paginaGuia === 'fundamentos' ? ' aria-current="page"' : '' ?>>Foundations &amp; Core</a>
  <a class="cl-enlace" href="patterns.php"<?= $paginaGuia === 'patrones' ? ' aria-current="page"' : '' ?>>Section Patterns</a>
</nav>
