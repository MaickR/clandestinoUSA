<?php
// Colección ficticia local: ninguna entrada representa a una persona o plataforma.
$escaparResena = static fn (string $valor): string => htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
$resenasDemo = [
    ['id' => 'demo-01', 'puntuacion' => 4, 'fecha' => '2026-10-06', 'texto' => 'Fictional review for layout testing. This short entry demonstrates a rating and a clear source.', 'avatar' => true],
    ['id' => 'demo-02', 'puntuacion' => 3, 'fecha' => '2026-10-09', 'texto' => 'Fictional review for layout testing. A longer comment can describe several parts of a visit, offer a suggestion and explain what could be improved. The full text remains available without a forced line limit. This example checks how a thoughtful, detailed contribution reads alongside shorter entries, including a deliberately long word: exceptionallylongdemonstrationwordforresponsivetesting.', 'respuesta' => true],
    ['id' => 'demo-03', 'puntuacion' => 5, 'fecha' => '2026-10-02', 'texto' => 'Fictional rating example. This is interface sample text, not a guest recommendation.'],
    ['id' => 'demo-04', 'puntuacion' => 2, 'fecha' => '2026-10-11', 'texto' => 'Fictional lower-rating example. Critical feedback receives the same space and legibility.'],
    ['id' => 'demo-05', 'puntuacion' => 4, 'fecha' => null, 'texto' => 'Fictional example with no date or avatar. Missing optional information is omitted rather than invented.'],
    ['id' => 'demo-06', 'puntuacion' => 1, 'fecha' => '2026-10-01', 'texto' => 'Fictional one-star example. Ratings do not change the presentation or visibility rules.'],
];
$valoracionResena = static function (int $puntuacion) use ($escaparResena): void {
    ?>
    <div class="cl-valoracion"><span class="cl-valoracion__estrellas" aria-hidden="true"><?= $escaparResena(str_repeat('★', $puntuacion) . str_repeat('☆', 5 - $puntuacion)) ?></span><span><?= $puntuacion ?> out of 5</span></div>
    <?php
};
$tarjetaResena = static function (array $resena, bool $compacta = false) use ($escaparResena, $valoracionResena): void {
    ?>
    <article class="cl-resena<?= $compacta ? ' cl-resena--compacta' : '' ?>">
      <header class="cl-resena__cabecera">
        <?php if (!empty($resena['avatar'])) : ?><span class="cl-resena__avatar" aria-hidden="true">D1</span><?php endif; ?>
        <h3 class="cl-resena__autor"><?= $escaparResena('Demo entry ' . substr($resena['id'], -2)) ?></h3>
      </header>
      <?php $valoracionResena($resena['puntuacion']); ?>
      <p class="cl-resena__texto"><?= $escaparResena($resena['texto']) ?></p>
      <ul class="cl-resena__meta" aria-label="Review context">
        <li><span class="cl-resena__fuente">Source: Internal</span> · fictional demo</li>
        <?php if ($resena['fecha']) : ?>
        <li><time datetime="<?= $escaparResena($resena['fecha']) ?>"><?= $escaparResena((new DateTimeImmutable($resena['fecha']))->format('M j, Y')) ?></time></li>
        <?php endif; ?>
        <li>Not verified</li>
      </ul>
      <?php if (!empty($resena['respuesta'])) : ?>
      <aside class="cl-resena__respuesta" aria-label="Example business response"><p><strong>Business response · fictional example</strong></p><p>A response to this comment would appear here. No real conversation is represented.</p></aside>
      <?php endif; ?>
    </article>
    <?php
};
?>
<section class="cl-seccion cl-seccion--alterna" id="wave-5" aria-labelledby="wave-5-titulo">
  <div class="container">
    <div class="cl-seccion__encabezado"><p class="cl-eyebrow">Wave 5 · Reviews &amp; reputation</p><h2 id="wave-5-titulo">A place for every voice</h2><p class="cl-seccion__descripcion">Considered ways to share a guest's perspective, hear feedback and keep its source clear.</p></div>
    <div class="cl-alerta cl-alerta--aviso"><div class="cl-alerta__contenido"><p class="cl-alerta__titulo">Design demonstration · no real guest reviews</p><p class="cl-alerta__mensaje">All ratings, dates and review text in Wave 5 are fictional examples. No guest identities, endorsements, verified badges or platform ratings are represented. Nothing submitted here is sent, stored or published.</p></div></div>
    <nav aria-label="Wave 5 families"><ul class="cl-guia-indice">
      <?php foreach (['reviews' => 'Reviews', 'featured-testimonials' => 'Featured Testimonials', 'video-testimonials' => 'Video Testimonials', 'reputation' => 'Reputation', 'review-listing' => 'Review Listing', 'write-review' => 'Write a Review', 'review-lifecycle' => 'Lifecycle States'] as $ancla => $nombre) : ?>
      <li><a class="cl-enlace" href="#<?= $escaparResena($ancla) ?>"><?= $escaparResena($nombre) ?></a></li>
      <?php endforeach; ?>
    </ul></nav>
  </div>
</section>
<?php require __DIR__ . '/resenas-testimonios-wave-5.php'; ?>
<?php require __DIR__ . '/resumen-listado-wave-5.php'; ?>
<?php require __DIR__ . '/escribir-resena-wave-5.php'; ?>
<?php require __DIR__ . '/ciclo-resenas-wave-5.php'; ?>
