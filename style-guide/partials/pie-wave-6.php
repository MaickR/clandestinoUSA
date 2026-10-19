<!-- Cuatro áreas editoriales con datos de archivo; sin servicios comerciales simulados. -->
<footer class="cl-pie" id="pie-global" aria-label="The Clandestino USA">
  <div class="container cl-pie__principal">
    <div class="row cl-pie__columnas">
      <div class="col-12 col-xl-3 cl-pie__grupo cl-pie__marca">
        <a href="<?= $escaparNavegacion($rutasNavegacion['Home']) ?>" aria-label="The Clandestino USA · Home"><img class="cl-pie__logo" src="<?= $escaparNavegacion($logoNavegacion) ?>" width="174" height="79" alt="The Clandestino USA" loading="lazy"></a>
        <p class="cl-pie__descripcion"><?= $pieCompleto ? 'A little Spain in Mount Shasta. Tapas to share, wines to discover, and time for good company.' : 'Spanish hospitality, a little closer. A longer editorial introduction to the shared table, thoughtful wines and unhurried evenings with friends in Northern California.' ?></p>
        <?php if ($pieCompleto) : ?>
        <ul class="cl-pie__redes" aria-label="Social profiles">
          <?php foreach ([['instagram', 'Instagram', 'https://www.instagram.com/theclandestinousa/'], ['facebook', 'Facebook', 'https://www.facebook.com/profile.php?id=61559740614798']] as [$icono, $nombreRed, $urlRed]) : ?>
          <li><a class="cl-pie__social" href="<?= $escaparNavegacion($urlRed) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= $escaparNavegacion($nombreRed) ?> (opens a new tab)"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-<?= $escaparNavegacion($icono) ?>"></use></svg></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
      <nav class="col-md-3 col-xl-2 cl-pie__grupo cl-pie__explorar" aria-label="Explore The Clandestino">
        <p class="cl-pie__etiqueta">Explore</p>
        <ul class="cl-pie__lista">
          <?php foreach ($rutasNavegacion as $nombre => $ruta) : ?>
          <li><a class="cl-enlace" href="<?= $escaparNavegacion($ruta) ?>"<?= $nombre !== 'Home' ? ' target="_top"' : '' ?>><?= $escaparNavegacion($nombre) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <nav class="col-md-4 col-xl-3 cl-pie__grupo cl-pie__grupo--separado" aria-label="Discover more">
        <p class="cl-pie__etiqueta">Discover more</p>
        <ul class="cl-pie__lista">
          <li><a class="cl-enlace" href="<?= $escaparNavegacion($rutasDescubrir['Wine Club']) ?>" target="_top">Spanish Wine Club</a></li>
          <li><a class="cl-enlace" href="<?= $escaparNavegacion($rutasDescubrir['Gift Cards']) ?>" target="_top">Gift Cards</a></li>
          <li><a class="cl-enlace" href="<?= $escaparNavegacion($rutasDescubrir['Events']) ?>" target="_top">Events</a></li>
          <li><a class="cl-enlace" href="<?= $escaparNavegacion($rutaExperienciaPrivada) ?>" target="_top">Private Experiences</a></li>
        </ul>
      </nav>
      <div class="col-md-5 col-xl-4 cl-pie__grupo cl-pie__grupo--separado">
        <p class="cl-pie__etiqueta">Visit &amp; contact</p>
        <address class="cl-contacto">
          <p>211 N Mt Shasta Blvd<br>Mt Shasta, CA 96067</p>
          <p><a class="cl-enlace" href="https://www.google.com/maps/place/211+N+Mt+Shasta+Blvd,+Mt+Shasta,+CA+96067,+USA" target="_blank" rel="noopener noreferrer">Find us on Google Maps<span class="visually-hidden"> (opens a new tab)</span></a></p>
          <?php if ($pieCompleto) : ?><p><a class="cl-enlace" href="tel:+14086090027">+1 408-609-0027</a></p><?php endif; ?>
          <p><a class="cl-enlace" href="mailto:ntcusa@nicolastena.com">ntcusa@nicolastena.com</a></p>
          <?php if ($pieCompleto) : ?>
          <p>Tuesday–Sunday · 4–8 PM Pacific<br>Monday · Closed</p>
          <p class="cl-pie__nota">Archive hours · please confirm before your visit.</p>
          <?php else : ?><p class="cl-pie__nota">Opening hours · awaiting confirmation in this example.</p><?php endif; ?>
        </address>
      </div>
    </div>
  </div>
  <div class="cl-pie__franja"><div class="container cl-pie__base">
    <?php if ($pieCompleto) : ?><nav class="cl-pie__legales" aria-label="Legal information"><a class="cl-enlace" href="/policies.html" target="_top">Policies</a><a class="cl-enlace" href="/terms.html" target="_top">Reservation terms</a></nav>
    <?php else : ?><p>Legal information · publication pending in this example.</p><?php endif; ?>
    <p>© <?= date('Y') ?> The Clandestino USA</p>
  </div></div>
</footer>
