<?php
// Guía local del design system. No procesa formularios ni enlaza el CSS legacy.
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Local design system reference for The Clandestino USA. Not a public page.">
  <meta name="theme-color" content="#161412">
  <title>Design system — The Clandestino USA</title>
  <link rel="icon" href="../assets/favicon/favicon.svg" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400;0,500;1,400&family=Playfair+Display:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.new.css">
</head>
<body>
  <a class="visually-hidden-focusable" href="#contenido">Skip to content</a>

  <header class="cl-guia-seccion">
    <div class="container">
      <p class="cl-eyebrow">The Clandestino USA</p>
      <h1>Design system</h1>
      <p class="cl-texto-secundario">Dark, editorial, and built for the table. This page is a local reference. Apache denies it in production.</p>
      <nav aria-label="On this page">
        <ul class="cl-guia-indice">
          <li><a class="cl-enlace" href="#foundations">Foundations</a></li>
          <li><a class="cl-enlace" href="#colors">Colors</a></li>
          <li><a class="cl-enlace" href="#typography">Typography</a></li>
          <li><a class="cl-enlace" href="#spacing">Spacing</a></li>
          <li><a class="cl-enlace" href="#buttons">Buttons</a></li>
          <li><a class="cl-enlace" href="#links">Links</a></li>
          <li><a class="cl-enlace" href="#forms">Forms</a></li>
          <li><a class="cl-enlace" href="#cards">Cards</a></li>
          <li><a class="cl-enlace" href="#accessibility">Accessibility</a></li>
          <li><a class="cl-enlace" href="#grid">Grid</a></li>
          <li><a class="cl-enlace" href="#components">Components</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main id="contenido">
    <section class="cl-guia-seccion cl-guia-banda" id="foundations" aria-labelledby="foundations-title">
      <div class="container">
        <h2 id="foundations-title">Foundations</h2>
        <p>One dark theme. Photography stays in front; the interface stays quiet. There is no light mode and no second accent competing with champagne.</p>
        <p>Type size follows the browser. The root <code>font-size</code> is never set to 10px or 62.5%. <code>rem</code> tracks the reader’s own setting.</p>
        <p class="cl-texto-muted">Section padding is 3rem, 4rem from the large breakpoint, and 6rem only at the close of a page.</p>
      </div>
    </section>

    <section class="cl-guia-seccion" id="colors" aria-labelledby="colors-title">
      <div class="container">
        <h2 id="colors-title">Colors</h2>
        <p>Semantic tokens only. Wine is a decorative accent and the selection color, never small text on the page background.</p>
        <div class="row cl-guia-rejilla">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--fondo"><span>Background</span><span class="cl-texto-pequeno">--color-fondo</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--fondo-alterno"><span>Alternate background</span><span class="cl-texto-pequeno">--color-fondo-alterno</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--superficie"><span>Surface</span><span class="cl-texto-pequeno">--color-superficie</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--superficie-hover"><span>Surface hover</span><span class="cl-texto-pequeno">--color-superficie-hover</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--texto cl-muestra__chip--tinta"><span>Text</span><span class="cl-texto-pequeno">--color-texto</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--texto-secundario cl-muestra__chip--tinta"><span>Secondary text</span><span class="cl-texto-pequeno">--color-texto-secundario</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--texto-muted cl-muestra__chip--tinta"><span>Muted text</span><span class="cl-texto-pequeno">--color-texto-muted</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--texto-inverso"><span>Inverse text</span><span class="cl-texto-pequeno">--color-texto-inverso</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--acento cl-muestra__chip--tinta"><span>Accent</span><span class="cl-texto-pequeno">--color-acento</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--acento-hover cl-muestra__chip--tinta"><span>Accent hover</span><span class="cl-texto-pequeno">--color-acento-hover</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--acento-vino"><span>Wine accent</span><span class="cl-texto-pequeno">--color-acento-vino</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--borde"><span>Subtle border</span><span class="cl-texto-pequeno">--color-borde</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--borde-fuerte"><span>Strong border</span><span class="cl-texto-pequeno">--color-borde-fuerte</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--accion cl-muestra__chip--tinta"><span>Action</span><span class="cl-texto-pequeno">--color-accion</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--exito cl-muestra__chip--tinta"><span>Success</span><span class="cl-texto-pequeno">--color-exito</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--aviso cl-muestra__chip--tinta"><span>Warning</span><span class="cl-texto-pequeno">--color-aviso</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--error cl-muestra__chip--tinta"><span>Error</span><span class="cl-texto-pequeno">--color-error</span></div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="cl-muestra__chip cl-muestra__chip--foco cl-muestra__chip--tinta"><span>Focus</span><span class="cl-texto-pequeno">--color-foco</span></div>
          </div>
        </div>
        <div class="cl-guia-bloque">
          <h3>Contrast</h3>
          <p>Measured against the page background <code>#161412</code>, except where noted. Normal text needs 4.5:1. Control borders need 3:1.</p>
          <ul>
            <li>Primary text <code>#f3efe6</code> — 16.01:1</li>
            <li>Secondary text <code>#cfc6b8</code> — 10.87:1</li>
            <li>Muted text <code>#9c9488</code> — 6.13:1, and 5.47:1 on the surface</li>
            <li>Ink <code>#1a1612</code> on champagne <code>#dddaba</code> — 12.69:1</li>
            <li>Ink on champagne hover <code>#c9c39a</code> — 10.07:1</li>
            <li>Focus champagne on the page — 12.96:1</li>
            <li>Success, warning, and error on the page — 10.66:1, 10.99:1, and 10.36:1</li>
            <li>Cream on wine selection — 8.92:1</li>
            <li>Strong border at 40% cream — 3.33:1 on the lightest neutral used for fields</li>
          </ul>
          <p class="cl-texto-secundario">The strong border moved from 28% to 40% because 28% stayed near 2.3:1 and could not mark a field. The 12% border stays decorative. Wine text on the page background is 1.79:1 and is not used.</p>
        </div>
      </div>
    </section>

    <section class="cl-guia-seccion cl-guia-banda" id="typography" aria-labelledby="typography-title">
      <div class="container">
        <h2 id="typography-title">Typography</h2>
        <p>Libre Bodoni carries display and headings. Playfair Display is reserved for the editorial quote. Interface text uses the system sans stack, so buttons and fields stay readable.</p>
        <div class="cl-guia-bloque">
          <p class="cl-eyebrow">Eyebrow</p>
          <p class="cl-display">A table in the evening</p>
        </div>
        <div class="cl-guia-bloque">
          <p class="cl-texto-pequeno cl-texto-muted">Heading 1</p>
          <p class="cl-titulo-1">Supper, poured slowly</p>
        </div>
        <div class="cl-guia-bloque">
          <p class="cl-texto-pequeno cl-texto-muted">Heading 2 is the title of this section. Heading 3 sits below.</p>
          <h3>From the cellar</h3>
          <p>Body copy stays on the system sans. It is set near 1.0625rem with a line height of 1.7, long enough for a menu description without looking like a luxury template.</p>
          <p class="cl-texto-secundario">Secondary text carries supporting detail, such as a vintage or a seating note.</p>
          <p class="cl-texto-muted">Muted text is for meta information that still has to clear 4.5:1.</p>
          <p class="cl-texto-pequeno">Small text is for captions and helper copy.</p>
          <p class="cl-cita">“The room is quiet enough to hear the glass.”</p>
        </div>
      </div>
    </section>

    <section class="cl-guia-seccion" id="spacing" aria-labelledby="spacing-title">
      <div class="container">
        <h2 id="spacing-title">Spacing</h2>
        <p>Nine steps, in rem, so they follow the browser root. At a 16px default they match 4, 8, 12, 16, 24, 32, 48, 64, and 96px.</p>
        <div class="cl-guia-escala" aria-hidden="true">
          <div class="cl-guia-escala__fila"><span>--espacio-1</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-1"></span></div>
          <div class="cl-guia-escala__fila"><span>--espacio-2</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-2"></span></div>
          <div class="cl-guia-escala__fila"><span>--espacio-3</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-3"></span></div>
          <div class="cl-guia-escala__fila"><span>--espacio-4</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-4"></span></div>
          <div class="cl-guia-escala__fila"><span>--espacio-5</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-5"></span></div>
          <div class="cl-guia-escala__fila"><span>--espacio-6</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-6"></span></div>
          <div class="cl-guia-escala__fila"><span>--espacio-7</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-7"></span></div>
          <div class="cl-guia-escala__fila"><span>--espacio-8</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-8"></span></div>
          <div class="cl-guia-escala__fila"><span>--espacio-9</span><span class="cl-guia-escala__barra cl-guia-escala__barra--paso-9"></span></div>
        </div>
        <ul>
          <li><code>--espacio-1</code> 0.25rem</li>
          <li><code>--espacio-2</code> 0.5rem</li>
          <li><code>--espacio-3</code> 0.75rem</li>
          <li><code>--espacio-4</code> 1rem</li>
          <li><code>--espacio-5</code> 1.5rem</li>
          <li><code>--espacio-6</code> 2rem</li>
          <li><code>--espacio-7</code> 3rem</li>
          <li><code>--espacio-8</code> 4rem</li>
          <li><code>--espacio-9</code> 6rem</li>
        </ul>
      </div>
    </section>

    <section class="cl-guia-seccion cl-guia-banda" id="buttons" aria-labelledby="buttons-title">
      <div class="container">
        <h2 id="buttons-title">Buttons</h2>
        <p>Hover, focus, and active each change the fill or the border. Disabled also drops opacity and uses <code>not-allowed</code>. Tab to the buttons to see the focus ring.</p>
        <div class="cl-guia-fila">
          <button class="cl-boton" type="button">Reserve a table</button>
          <button class="cl-boton cl-boton--secundario" type="button">View the menu</button>
          <button class="cl-boton" type="button" disabled>Sold out</button>
          <button class="cl-boton cl-boton--secundario" type="button" disabled>Unavailable</button>
        </div>
      </div>
    </section>

    <section class="cl-guia-seccion" id="links" aria-labelledby="links-title">
      <div class="container">
        <h2 id="links-title">Links</h2>
        <p>Use <code>cl-enlace</code> when a content link needs the editorial underline. The native link element stays a link. Visited links shift to secondary text, which still clears 4.5:1. Hover turns them to the primary text color.</p>
        <p>Read the <a class="cl-enlace" href="#typography">typography notes</a> or return to the <a class="cl-enlace" href="#foundations">foundations</a>.</p>
      </div>
    </section>

    <section class="cl-guia-seccion cl-guia-banda" id="forms" aria-labelledby="forms-title">
      <div class="container">
        <h2 id="forms-title">Forms</h2>
        <p>These fields are not submitted. An error is a border plus a sentence, never color alone.</p>
        <div class="row cl-guia-rejilla">
          <div class="col-12 col-md-8">
            <div class="cl-campo-grupo">
              <label class="cl-etiqueta" for="nombre">Name</label>
              <input class="cl-campo" id="nombre" name="nombre" type="text" autocomplete="name" placeholder="Your name">
            </div>
            <div class="cl-campo-grupo">
              <label class="cl-etiqueta" for="nota">Note</label>
              <textarea class="cl-campo" id="nota" name="nota" placeholder="Allergies or a seating request"></textarea>
            </div>
            <div class="cl-campo-grupo">
              <label class="cl-etiqueta" for="servicio">Service</label>
              <select class="cl-campo" id="servicio" name="servicio">
                <option value="dinner">Dinner</option>
                <option value="wine">Wine club</option>
                <option value="event">Private event</option>
              </select>
            </div>
            <div class="cl-campo-grupo">
              <label class="cl-etiqueta" for="correo">Email</label>
              <input class="cl-campo cl-campo--error" id="correo" name="correo" type="email" autocomplete="email" aria-invalid="true" aria-describedby="correo-error" value="not-an-email">
              <p class="cl-mensaje-campo" id="correo-error">Enter an email address with an @ and a domain.</p>
            </div>
            <div class="cl-campo-grupo">
              <label class="cl-etiqueta" for="telefono">Phone</label>
              <input class="cl-campo" id="telefono" name="telefono" type="tel" autocomplete="tel" value="530-555-0199" disabled>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="cl-guia-seccion" id="cards" aria-labelledby="cards-title">
      <div class="container">
        <h2 id="cards-title">Cards / surfaces</h2>
        <p>A card is a surface, a hairline border, and padding. No shadow, no gradient, no media slot yet.</p>
        <div class="row cl-guia-rejilla">
          <div class="col-12 col-md-6">
            <article class="cl-tarjeta">
              <p class="cl-eyebrow">Tonight</p>
              <h3>Late seating</h3>
              <p>The last tables are held for the dining room, not for a widget.</p>
            </article>
          </div>
          <div class="col-12 col-md-6">
            <article class="cl-tarjeta">
              <p class="cl-eyebrow">Cellar</p>
              <h3>By the glass</h3>
              <p class="cl-texto-secundario">A short list, written like a menu, not like a product grid.</p>
            </article>
          </div>
        </div>
      </div>
    </section>

    <section class="cl-guia-seccion cl-guia-banda" id="accessibility" aria-labelledby="accessibility-title">
      <div class="container">
        <h2 id="accessibility-title">Accessibility states</h2>
        <p>Tab through this page. The focus ring is a 2px champagne outline, 3px outside the control, and it does not rely on the mouse focus outline.</p>
        <p>Select this sentence to see the wine highlight with cream text.</p>
        <p>When the system asks for reduced motion, transitions and animations collapse. Nothing on this foundation requires motion to be understood.</p>
        <p>The disabled phone field above cannot be edited. The sold-out button cannot be activated.</p>
        <button class="cl-boton" type="button">Focus target</button>
      </div>
    </section>

    <section class="cl-guia-seccion" id="grid" aria-labelledby="grid-title">
      <div class="container">
        <h2 id="grid-title">Bootstrap grid / containers</h2>
        <p>Containers stop at 1200px. Columns are one-up until the medium breakpoint, then the row splits. Gutters are 1.5rem.</p>
        <div class="row cl-guia-rejilla">
          <div class="col-12 col-md-4">
            <div class="cl-tarjeta"><p>Column one</p></div>
          </div>
          <div class="col-12 col-md-4">
            <div class="cl-tarjeta"><p>Column two</p></div>
          </div>
          <div class="col-12 col-md-4">
            <div class="cl-tarjeta"><p>Column three</p></div>
          </div>
        </div>
      </div>
    </section>

    <section class="cl-guia-seccion cl-guia-banda cl-guia-cierre" id="components" aria-labelledby="components-title">
      <div class="container">
        <h2 id="components-title">Component states</h2>
        <p class="cl-eyebrow">Eyebrow</p>
        <p>Uppercase, champagne, and tracked at 0.18em. The legacy 0.4em tracking is retired. No ornamental rule yet.</p>
        <hr class="cl-divisor">
        <p>The divider is a single subtle border. Pair it with a <a class="cl-enlace" href="#buttons">button</a> when the sentence is a real link.</p>
      </div>
    </section>
  </main>
</body>
</html>
