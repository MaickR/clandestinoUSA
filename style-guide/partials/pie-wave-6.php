<!-- Datos contrastados con index.html y contact.html; los opcionales se omiten si faltan. -->
<footer class="cl-pie" id="pie-global" aria-label="The Clandestino USA">
  <div class="container">
    <div class="cl-pie__invitacion">
      <p class="cl-pie__titulo">Spain, a little closer.<br>A table, a little longer.</p>
      <a class="cl-boton cl-boton--secundario" href="<?= $escaparNavegacion($rutaReserva) ?>">Reserve a Table</a>
    </div>
    <div class="row cl-pie__columnas">
      <div class="col-md-6 col-lg-4">
        <a href="#inicio-global" aria-label="The Clandestino USA · Home"><img class="cl-pie__logo" src="/assets/images/clandestino-logo.svg" width="174" height="79" alt="The Clandestino USA" loading="lazy"></a>
        <p class="cl-pie__descripcion"><?= $pieCompleto ? 'Spanish tapas. Thoughtful wines. The warmth of a shared table in Mount Shasta.' : 'A longer editorial introduction: discover Spanish tapas, thoughtful wines and the warmth of a shared table, from a quiet evening together to a gathering with friends in Northern California.' ?></p>
        <?php if ($pieCompleto) : ?>
        <ul class="cl-pie__lista" aria-label="Social profiles">
          <li><a class="cl-enlace" href="https://www.instagram.com/theclandestinousa/" target="_blank" rel="noopener noreferrer"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-instagram"></use></svg>Instagram<span class="visually-hidden"> (opens a new tab)</span></a></li>
          <li><a class="cl-enlace" href="https://www.facebook.com/profile.php?id=61559740614798" target="_blank" rel="noopener noreferrer"><svg class="cl-icon" aria-hidden="true" focusable="false"><use href="/assets/icons/cl-iconos.svg#cl-icon-facebook"></use></svg>Facebook<span class="visually-hidden"> (opens a new tab)</span></a></li>
        </ul>
        <?php endif; ?>
      </div>
      <nav class="col-md-6 col-lg-3" aria-label="Explore The Clandestino">
        <p class="cl-pie__etiqueta">Stay a little curious</p>
        <ul class="cl-pie__lista">
          <?php foreach (array_merge(array_slice($rutasNavegacion, 1), $rutasDescubrir) as $nombre => $ruta) : ?>
            <li><a class="cl-enlace" href="<?= $escaparNavegacion($ruta) ?>" target="_top"><?= $escaparNavegacion($nombre) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <div class="col-lg-5">
        <p class="cl-pie__etiqueta">Find us in Mount Shasta</p>
        <address class="cl-contacto">
          <p>211 N Mt Shasta Blvd<br>Mt Shasta, CA 96067</p>
          <p><a class="cl-enlace" href="https://www.google.com/maps/place/211+N+Mt+Shasta+Blvd,+Mt+Shasta,+CA+96067,+USA" target="_blank" rel="noopener noreferrer">Open in Google Maps<span class="visually-hidden"> (opens a new tab)</span></a></p>
          <?php if ($pieCompleto) : ?><p><a class="cl-enlace" href="tel:+14086090027">+1 408-609-0027</a></p><?php endif; ?>
          <p><a class="cl-enlace" href="mailto:ntcusa@nicolastena.com">ntcusa@nicolastena.com</a><br><span class="cl-texto-secundario">Preferred inbox</span></p>
          <?php if ($pieCompleto) : ?>
          <p><a class="cl-enlace" href="mailto:info@theclandestinousa.com">info@theclandestinousa.com</a></p>
          <p>Tuesday–Sunday · 4–8 PM Pacific<br>Monday · Closed</p>
          <?php else : ?><p>Opening hours · awaiting confirmation in this example</p><?php endif; ?>
        </address>
      </div>
    </div>
    <div class="cl-pie__base">
      <p>© <?= date('Y') ?> The Clandestino USA</p>
      <?php if ($pieCompleto) : ?><nav class="cl-pie__legales" aria-label="Legal information">
        <a class="cl-enlace" href="/policies.html" target="_top">Policies</a>
        <a class="cl-enlace" href="/terms.html" target="_top">Reservation terms</a>
      </nav><?php else : ?><p>Legal information · publication pending in this example</p><?php endif; ?>
    </div>
  </div>
</footer>
