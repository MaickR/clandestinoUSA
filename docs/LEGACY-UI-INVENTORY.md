# LEGACY-UI-A — Inventario visual y de componentes del sitio legacy

**Proyecto:** The Clandestino USA (sitio legacy)
**Fecha del análisis:** 26 de septiembre de 2026
**Alcance:** Inventario read-only de patrones visuales, secciones, componentes, formularios e interacciones, como referencia para la reconstrucción en React + TypeScript + Tailwind CSS + shadcn/ui + Inertia + Laravel.

> Este documento **no autoriza implementación**. Solo cataloga y clasifica.

---

## Índice

1. [Resumen de la interfaz legacy](#1-resumen-de-la-interfaz-legacy)
2. [Stack visual](#2-stack-visual)
3. [Páginas](#3-páginas)
4. [Section Patterns](#4-section-patterns)
5. [Brand Components candidatos](#5-brand-components-candidatos)
6. [Forms / Flows](#6-forms--flows)
7. [Interactions](#7-interactions)
8. [Carousels / Media](#8-carousels--media)
9. [Typography](#9-typography)
10. [Colors / Surfaces](#10-colors--surfaces)
11. [Responsive](#11-responsive)
12. [Duplicación y oportunidades de composición](#12-duplicación-y-oportunidades-de-composición)
13. [Patrones que vale la pena preservar](#13-patrones-que-vale-la-pena-preservar)
14. [Legacy que debe reinterpretarse](#14-legacy-que-debe-reinterpretarse)
15. [Matriz de migración visual](#15-matriz-de-migración-visual)
16. [Inventario maestro](#16-inventario-maestro)
17. [Archivos inspeccionados](#17-archivos-inspeccionados)
18. [Acciones realizadas](#18-acciones-realizadas)

---

## 1. Resumen de la interfaz legacy

- Sitio estático multipágina derivado de la plantilla **"Grilli"**, para un restaurante de tapas y vino español en Mount Shasta, CA. Tiene 12 vistas HTML.
- Header, footer, preloader y botón de WhatsApp están **copiados a mano en cada HTML**, sin plantillas ni includes.
- Estética: fondo casi negro (`#161616`), acento champagne en botones, eyebrows y adornos, titulares serif y fotografía a sangre con overlays oscuros.
- No hay carrito ni checkout. Pedir productos, unirse al club y preguntar por eventos se resuelve con **enlaces a WhatsApp con texto prellenado**.
- Solo hay dos formularios reales: **Reserva** (home) y **Contacto**. Ambos envían por `fetch` a `reservation.php` y `contact.php`, que responden JSON.
- Los catálogos de Tapas, Wines y Hampers **se generan desde arrays JS** embebidos en `tapas.js`, `wines.js` y `hampers.js`, con Isotope para filtrar.
- Se identificaron unos **22 patrones de sección**; varios se repiten en implementaciones casi idénticas.
- La revisión visual se hizo en **desktop (1440 px)** y **móvil (390 px)**. **Tablet no se capturó visualmente**; lo que se dice de tablet sale de los breakpoints del código.

---

## 2. Stack visual

| Capa | Qué hay | Dónde |
|---|---|---|
| CSS propio | `style.css` (~145 KB, minificado en 22 líneas, ~50 media queries distintas, 55 `!important`), `faq-styles.css`, `form-feedback.css`, `whatsapp-float.css` | Global |
| CSS inline | ~290 líneas de estilos del modal en `contact.html`; `<style>` propio en `links.html` y `offline.html`; `style=""` en el botón de WhatsApp y en fondos | Varias |
| Fuentes cargadas | Libre Bodoni (titulares) y Playfair Display (texto). `menu.html` además carga Merienda, Roboto y Oswald | Google Fonts |
| Iconos | Ionicons 5.5.2 (CDN). Font Awesome 5 solo en `menu.html` | Global |
| JS propio | `script.js` (minificado): preloader, nav, header sticky, hero slider, parallax, 3 Swipers, calendario, estimador de precio, modal de eventos y validación de contacto. También `gallery.js`, `swc-carousel.js`, `tapas.js`, `wines.js`, `hampers.js` y `form-feedback.js` | Global o por página |
| Librerías | Swiper **6.8.4**; jQuery 3.6.4; Isotope 3 + imagesLoaded; Magnific Popup 1.1; Splitting.js; jquery-paroller | Home, SWC, catálogos, menu |
| Frameworks CSS mezclados | **Bootstrap 3.4.1** en `menu.html` y **Bootstrap 5.3.3** en `contact.html` | Por página |
| Build | `package.json` con postcss, cssnano, purgecss y terser. Las páginas cargan `style.css`, no `style.min.css` | — |
| Analítica | Google Tag Manager en todas las páginas principales | Global |

---

## 3. Páginas

| Página | Propósito | Secciones principales | Interacciones |
|---|---|---|---|
| `index.html` — Home | Portada y conversión | Hero slider; categorías (Tapas/Hampers/Wines); about con imágenes superpuestas; banner SWC; "Our Strength" con 4 features; banner Private Events; video-testimonios; formulario de reserva + contacto; carrusel de eventos semanales | Slider con autoplay, parallax con el ratón, 2 Swipers, modal de evento, calendario, precio estimado, campos condicionales, diálogo de resultado |
| `menu.html` — Menu | Vista previa de los 3 catálogos | Hero interior; 3 bloques "Menu Preview" (vinos, tapas, hampers) alternando lado y fondo; CTA de reserva | Lightbox (Magnific), revelado al hacer scroll, botones de WhatsApp |
| `tapas.html` | Catálogo de tapas y productos para llevar | Hero interior; grid filtrable (All/Tapas/Take Away/Cheeses); CTA de reserva | Filtros Isotope, lightbox, pedido por WhatsApp |
| `wines.html` | Carta de vinos | Hero interior; grid filtrable (All/Red/White/Sparkling) con precio por copa y por botella; CTA hacia el Wine Club | Filtros, lightbox, igualado de alturas y re-render al redimensionar |
| `hampers.html` | Cestas de regalo | Hero interior; grid filtrable (Luxury/Gourmet/Classic/Custom); CTA | Filtros, lightbox, WhatsApp |
| `swc.html` — Spanish Wine Club | Membresías | Hero interior; carrusel "journey"; tarjetas Diamond/Gold; galería filtrable de vinos por nivel; FAQ en tarjetas | Swiper, filtros de galería, lightbox propio, WhatsApp por plan |
| `about.html` | Historia y galería | Hero interior; historia en split con lista de valores; galería filtrable de fotos y videos; estadísticas; CTA | Filtros, lightbox propio, overlay de play, revelado al hacer scroll |
| `contact.html` | Contacto y FAQ | Hero interior; tarjetas de contacto (reutilizan el patrón de estadísticas); formulario; acordeón FAQ | Validación inline, diálogo de resultado, acordeón |
| `policies.html` | Legal | Texto largo con H2 y listas | — |
| `terms.html` | Legal (términos de reserva) | 13 secciones numeradas; **sin header ni footer del sitio** | — |
| `links.html` | Link-in-bio | Logo, badge y 4 botones (web/FB/IG/WhatsApp) | Hover. Página independiente con sus propios tokens |
| `offline.html` | Fallback sin conexión | Mensaje, reintentar y datos de contacto | Recarga al volver la conexión |

---

## 4. Section Patterns

### Global Chrome — Topbar, Header, Mobile Drawer, Footer, WhatsApp Float, Preloader

- **Dónde:** todas las páginas salvo `terms`, `links` y `offline`.
- **Estructura:**
  - **Topbar:** dirección, horario, teléfono y email. Solo en desktop.
  - **Header:** logo, navegación con submenús (Menus, Contact) y CTA "Find A Table". Es fijo: transparente al inicio, sólido a partir de 50 px de scroll, y se oculta al bajar.
  - **Drawer móvil:** panel de 360 px desde la izquierda con logo, enlaces y bloque "Visit Us" (dirección, horas, booking) + overlay.
  - **Footer:** fondo fotográfico, bloque de marca (dirección, emails, booking, horas), separador triple, eslogan + CTA, lista de navegación, lista social y copyright.
  - **WhatsApp Float:** botón circular fijo abajo a la derecha, con pulso.
  - **Preloader:** logo + barra de progreso a pantalla completa.
- **Responsive:** la topbar desaparece en móvil; la navegación pasa a drawer.
- **Reutilización:** alta.
- **Candidato:** **YES — Brand Component / Layout** (el preloader: NO — legacy only).

### P1. Full-bleed Hero

- **Dónde:** Home (variante slider) y todas las páginas interiores (`hero--inner`).
- **Estructura:** imagen de fondo · overlay degradado · eyebrow con ornamento · título display en mayúsculas con subtítulo itálico dorado · texto · CTA (el CTA solo aparece en el slider).
- **Variaciones:** `slider` (3 slides, altura completa) e `inner` (alto `clamp(420px, 70vh, 760px)`, sin CTA).
- **Responsive:** contenido centrado; el título se reduce con `clamp`.
- **Interacciones:** autoplay y flechas en la variante slider.
- **Reutilización:** alta.
- **Candidato:** **YES — Section Pattern**.

### P2. Section Heading Block

- **Dónde:** prácticamente todas las secciones.
- **Estructura:** eyebrow en mayúsculas con ornamento `separator.svg` · H2 · párrafo opcional.
- **Variaciones:** centrado o alineado a la izquierda.
- **Reutilización:** alta, pero implementado **con 6 familias de clases** (ver §12).
- **Candidato:** **YES — Brand Component**.

### P3. Category Showcase Grid

- **Dónde:** Home, "Experience The Clandestino".
- **Estructura:** 3 tarjetas verticales (~285×336) con imagen, título y enlace de texto; CTA global debajo; formas decorativas animadas.
- **Variaciones:** en desktop la tarjeta central baja (desfase escalonado).
- **Responsive:** pasa a una columna.
- **Interacciones:** brillo al pasar el ratón (`hover:shine`).
- **Reutilización:** baja.
- **Candidato:** **YES — Section Pattern**.

### P4. Editorial Split

- **Dónde:** Home "About" y `about.html` (historia).
- **Estructura:** texto (eyebrow, título, párrafo, contacto o CTA) + media.
- **Variaciones:**
  - `overlap-images`: imagen grande + imagen pequeña superpuesta con parallax (Home).
  - `values-list`: texto + lista de valores con icono + imagen (About).
- **Responsive:** se apila en móvil.
- **Interacciones:** parallax con el ratón en la variante con superposición.
- **Reutilización:** media.
- **Candidato:** **YES — Section Pattern**.

### P5. Split Media Banner (`special-dish`)

- **Dónde:** Home, en los bloques SWC y Private Events.
- **Estructura:** mitad imagen a sangre · mitad panel oscuro con eyebrow, H2, texto, lista de puntos opcional y CTA.
- **Variaciones:** con badge decorativo; con bullets.
- **Responsive:** se apila (imagen arriba, contenido abajo).
- **Reutilización:** media.
- **Candidato:** **YES — Section Pattern**.

### P6. Icon Feature Grid

- **Dónde:** Home "Our Strength" (4 items). También en el FAQ de SWC, donde se reutiliza para preguntas y respuestas.
- **Estructura:** icono (PNG o ionicon) · título · texto, sobre tarjeta con degradado oscuro.
- **Responsive:** 4 → 2 → 1 columnas.
- **Reutilización:** media.
- **Candidato:** **YES — Section Pattern**.

### P7. Stats / Highlights Grid

- **Dónde:** `about` (25+, 45+, 500+, 95%) y `contact` (reutilizado para datos de contacto con "Call", "24/7" y "211" haciendo de número).
- **Estructura:** icono en círculo · número grande · nombre · subtexto; formas decorativas.
- **Responsive:** grid que pasa a una columna.
- **Reutilización:** media.
- **Candidato:** **YES — Section Pattern**, con una variante `contact-info` separada.

### P8. Video Testimonials Carousel

- **Dónde:** Home.
- **Estructura:** fondo fotográfico · heading · Swiper de 11 videos `<video controls>` · barra de progreso · contador "Client Stories 01/11".
- **Responsive:** 3 → 2 → 1 videos visibles.
- **Interacciones:** autoplay que se detiene al reproducir un video.
- **Reutilización:** única.
- **Candidato:** **YES — Section Pattern (Social Proof)**.

### P9. Reservation Section (Form + Contact Aside)

- **Dónde:** Home `#reservation`.
- **Estructura:** formulario a la izquierda y panel a la derecha con fondo de patrón (booking, email, ubicación, horario). Se superpone sobre la sección de testimonios.
- **Responsive:** se apila.
- **Reutilización:** única.
- **Candidato:** **Flow** (ver §6, F1).

### P10. Events Carousel + Detail Modal

- **Dónde:** Home.
- **Estructura:** Swiper de 8 tarjetas de evento (imagen, badge de fecha, subtítulo, título, precio). Al pulsar, un modal muestra imagen, horario, precio, descripción y CTA de WhatsApp. El contenido de los modales está en un objeto JS.
- **Responsive:** 3 → 2 → 1 tarjetas visibles.
- **Reutilización:** única.
- **Candidato:** **YES — Section Pattern**, con el modal como Flow ligero.

### P11. Booking CTA Band (`reservation--elevated`)

- **Dónde:** `menu`, `tapas`, `wines`, `hampers`, `about`.
- **Estructura:** fondo fotográfico con `<picture>` distinto en desktop y móvil · overlay + degradado · tarjeta con eyebrow, H2 con acento itálico, texto, separador de tres puntos, enlace de WhatsApp y 2 botones · orbes y formas decorativas.
- **Variaciones:** "Reserve or Join Club", "Book table", "Join Wine Club" (en `wines`).
- **Responsive:** botones apilados en móvil.
- **Reutilización:** alta.
- **Candidato:** **YES — Section Pattern**.

### P12. Menu Preview Split

- **Dónde:** `menu.html` (3 veces).
- **Estructura:** heading · 3 tarjetas de producto · imagen lateral · CTA "Explore all".
- **Variaciones:** alterna el lado de la imagen y el fondo.
- **Responsive:** pasa a una columna.
- **Reutilización:** baja.
- **Candidato:** **YES — Section Pattern**.

### P13. Filterable Product Grid

- **Dónde:** `tapas`, `wines`, `hampers`.
- **Estructura:** heading · pills de filtro (`role=tab`) · grid de 3 columnas con tarjetas generadas por JS.
- **Responsive:** pasa a 1 columna; `wines.js` cambia "glass/bottle" por "G/B" cuando el ancho es ≤768 px.
- **Interacciones:** filtros Isotope, lightbox, botón de pedido por WhatsApp.
- **Reutilización:** alta.
- **Candidato:** **YES — Section Pattern**.

### P14. Filterable Media Gallery

- **Dónde:** `about` (Tapas/Cheeses/Guests/Videos) y `swc` (Gold/Diamond wines).
- **Estructura:** heading · pills · grid de items de imagen (overlay con icono de zoom) o de video (overlay de play), con caption de título y subtítulo.
- **Interacciones:** filtro con transición, lightbox propio, overlay de play.
- **Reutilización:** media.
- **Candidato:** **YES — Section Pattern**.

### P15. Story Carousel

- **Dónde:** `swc`, "From Spanish Vineyards To Your Table".
- **Estructura:** una slide por vista con imagen, subname, nombre, texto y tipografía decorativa grande ("SWC", "DO", "VIP"), etiqueta y año.
- **Reutilización:** única.
- **Candidato:** **REVIEW**.

### P16. Membership Plans

- **Dónde:** `swc`.
- **Estructura:** 2 tarjetas. Cada una tiene un banner con icono de nivel (diamante o trofeo) y cinta ("Premium"/"Favorita"), título, tagline, precio con "/quarter", resumen, descripción, lista de beneficios con check y CTA de WhatsApp.
- **Variaciones:** Diamond destacada con borde dorado; Gold en bronce.
- **Responsive:** 2 columnas → 1.
- **Reutilización:** baja, pero estratégica.
- **Candidato:** **YES — Section Pattern**.

### P17. FAQ Accordion

- **Dónde:** `contact` (6 items). SWC tiene su FAQ en tarjetas estáticas, no en acordeón.
- **Estructura:** heading · items con barra dorada lateral al activarse · chevron que rota · CTA "Still have questions?".
- **Interacciones:** uno abierto a la vez.
- **Reutilización:** media.
- **Candidato:** **YES — Section Pattern**.

### P18. Contact Form Section

- **Dónde:** `contact`.
- **Candidato:** **Flow** (ver §6, F2).

### P19. Legal Prose

- **Dónde:** `policies` y `terms`.
- **Estructura:** H1 · fecha · bloques con H2 y listas.
- **Candidato:** **YES — Section Pattern** (prose).

### P20. Link-in-bio Page (`links`) y P21. Offline Page (`offline`)

- Páginas independientes, con sus propios tokens.
- **Candidato:** **PAGE-SPECIFIC**.

---

## 5. Brand Components candidatos

| Componente conceptual | Apariciones | Variaciones | Reutilización | Candidato nuevo |
|---|---:|---|---|---|
| Button (texto que sube al hover: `.text-1`/`.text-2`) | 60+ | primary, secondary, submit, disabled | alta | Primitive + variante de marca |
| Text Link con subrayado animado (`hover-underline`) | 40+ | nav, footer, card | alta | Primitive |
| Eyebrow + ornamento | 40+ | con/sin ornamento | alta | Brand Component |
| Section Heading | 40+ | center/left | alta | Brand Component |
| Display Title + subtítulo itálico dorado | 12 (heroes) | — | alta | Brand Component |
| Ornament Separator | 30+ | diamond, dots, triple | alta | Brand Component |
| Category Card | 3 | — | baja | Brand Component (variante de Media Card) |
| Feature Card (icono + título + texto) | 8 + 2 valores | image-icon, ionicon | media | Brand Component |
| Stat Item | 8 | stat, contact-info | media | Brand Component |
| Event Card (imagen 7:9, badge de fecha, subtítulo, título, precio) | 8 | — | media | Brand Component |
| Product Card (imagen, nombre, descripción, meta, precio, botón icono de pedido) | 3 implementaciones, ~60 items | wine (copa/botella), tapa, hamper, "Ask for price" | alta | Brand Component |
| Price Display | 5 estilos | single, glass/bottle, per-quarter, promo ("20% Off") | alta | Brand Component |
| Membership Card | 2 | featured/standard | baja | Brand Component |
| Ribbon / Badge | 3 | premium, standard, "Official" (links) | baja | Primitive (Badge) |
| Benefit List Item (check) | 8 | — | media | Primitive |
| Contact Detail (label + enlace grande) | 5 contextos (topbar, drawer, aside, footer, CTA) | inline, stacked | alta | Brand Component |
| Opening Hours / Address block | 10+ | corto, largo | alta | Brand Component (con datos centralizados) |
| Gallery Item (imagen/video + overlay + caption) | ~60 | image, video | media | Brand Component |
| Video Card con overlay de play | 11 + 5 | testimonial, gallery | media | Brand Component |
| Filter Pills / Tabs | 5 grupos | kf-filter, gallery-filter | alta | Primitive (Tabs/ToggleGroup) |
| WhatsApp CTA (flotante, botón icono, enlace con texto prellenado) | 80+ enlaces | float, icon, inline | alta | Brand Component |
| Logo | todas las páginas | header, drawer, footer, preloader | alta | Brand Component |
| Social Links list | todas las páginas | footer, links page | media | Brand Component |
| Decorative Shapes (formas animadas) | 10+ | — | media | REVIEW |

---

## 6. Forms / Flows

### F1. Reservation & Events (Home)

**Campos**
- Contacto: nombre, email, teléfono.
- Selects con icono:
  - invitados (1–10, luego rangos hasta 30);
  - hora (16:00–19:30, cada 30 min);
  - tipo de evento (9 opciones: standard, romantic, birthday, anniversary, family, holiday, tasting, corporate, custom).
- Fecha: **calendario inline propio**; el valor va en un input oculto.
- Notas (textarea).
- Aceptación de términos (checkbox).

**Agrupaciones:** 3 `fieldset` (contacto, detalles del evento, notas) con `legend` solo para lectores de pantalla.

**Campos condicionales** (al elegir "Custom"): título del evento, duración (horas), preferencia de vino (select), 4 checkboxes dietéticos (vegetarian, vegan, gluten-free, dairy-free) y presupuesto estimado.

**Resumen en vivo**
- Caja **"Estimated Investment"**: total + desglose (base por persona según tipo de evento, ajuste de fin de semana, ajuste de tarde, extras por tipo, 10% de servicio e impuestos).
- Caja **"Availability"**: estado ok/conflict con sugerencia de otra franja.

**Estados**
- Submit deshabilitado hasta que el formulario sea válido y se acepten los términos.
- `data-sending` mientras envía; timeout de 25 s.
- El resultado se muestra en el diálogo F3.
- Anti-spam: honeypot + timestamp + lista de palabras prohibidas.

**Layout responsive:** dos columnas en desktop (formulario + aside); se apila en móvil.

**Problemas respaldados por evidencia**
- Hay **dos handlers de submit**. El inline de la página corre en fase de captura y hace `stopImmediatePropagation`, así que el flujo de `script.js` que abría WhatsApp nunca se ejecuta.
- La "disponibilidad" es **simulada**: franjas bloqueadas hardcodeadas más `localStorage`.
- Los mensajes de disponibilidad están en **español** ("Seleccione fecha y hora.") mientras el resto de la UI está en inglés.
- El calendario solo bloquea fechas con menos de 48 h de antelación; **no bloquea el lunes cerrado**.
- Los honeypots aparecen en el árbol de accesibilidad ("Leave this field empty").

**Componentes reutilizables candidatos:** `DatePicker`, `SelectWithIcon`, `ConditionalFieldGroup`, `CheckboxGroup`, `EstimateSummary`, `AvailabilityStatus`, `TermsCheckbox`.

### F2. Contact (`contact.html`)

**Campos:** nombre, email, teléfono, asunto (select de 7 opciones: Table Reservation, Wine Club Membership, Private Event, Catering Services, Product Information, General Question, Other) y mensaje a ancho completo. Todos con label visible e icono.

**Estados**
- Error inline por campo (`clx-error`, `aria-invalid`).
- Clases de éxito y error en el grupo.
- Submit deshabilitado hasta completar.
- Loading "Sending...".
- Barra de estado inline + diálogo de resultado.

**Validación visual:** longitud, patrón, emails desechables, spam y links.

**Layout responsive:** grid de 2 columnas que pasa a 1.

**Problemas respaldados por evidencia**
- **Tres capas de handlers** que se solapan: dos módulos en `script.js` y uno inline en captura.
- Hay un modal Bootstrap 5 completo más su CSS inline, que **queda sin uso** porque `showModal` delega en `ClandestinoFeedback` cuando existe.

**Componentes reutilizables candidatos:** `FormField` (label + icono + control + error), `FormStatus`, `SubmitButton` con estados.

### F3. Result Dialog (`form-feedback.js`)

- Tarjeta centrada con icono SVG animado (check o X), título, texto, "Closing in 8s" y botón Close.
- Se cierra con Esc, clic en el fondo o la X; se cierra solo a los 8 s.
- Compartido por F1 y F2.
- **Candidato:** Flow / Brand Component.

### F4. Event Detail Modal

- Modal con focus trap, Esc y clic fuera.
- El CTA de WhatsApp se genera dinámicamente con el nombre del evento.
- **Candidato:** Flow ligero.

### F5. WhatsApp Inquiry pattern

- Pedidos, membresías, eventos y reservas rápidas usan deep links `wa.me` con mensajes prellenados.
- Los mensajes están redactados a mano y **mezclan inglés y español** (p. ej. "Buenas noches!…" en `menu.html`).
- **Candidato:** patrón de conversión; los mensajes deberían venir de datos.

### F6. Newsletter del footer

- Comentado; es un resto de la plantilla.
- **Candidato:** Discard.

---

## 7. Interactions

| Interacción | Implementación | Dónde | Objetivo | ¿Patrón futuro? |
|---|---|---|---|---|
| Hero slider | JS propio, cambia `.active` cada 7 s, flechas, pausa al pasar por los botones | Home | Storytelling de 3 propuestas | Sí (carrusel de hero) |
| Carruseles | Swiper 6.8.4 | Home ×2, SWC | Testimonios, eventos, historia | Sí como patrón; la librería se decide aparte |
| Modal de evento | JS propio + `onclick` inline | Home | Detalle de evento | Sí (Dialog) |
| Diálogo de resultado | `form-feedback.js` | Home, Contact | Feedback de envío | Sí |
| Modal de cierre temporal con cuenta atrás | Código en `script.js` (fecha 2025-10-30), **sin markup en ningún HTML** | — | — | No (código muerto) |
| Acordeón FAQ | JS inline, uno abierto a la vez | Contact | FAQ | Sí |
| Tabs / filtros | Isotope + jQuery (catálogos); JS propio (galerías) | tapas, wines, hampers, about, swc | Filtrar | Sí (Tabs/ToggleGroup) |
| Lightbox | Magnific Popup (catálogos, menu) y lightbox propio `clx-lightbox` (galerías) | 6 páginas | Ampliar imagen | Sí, con una sola implementación |
| Overlay de play de video | `gallery.js` | about, home | Iniciar video | Sí |
| Menú móvil | Drawer lateral + overlay; `aria-expanded` **no se actualiza** (verificado) | Global | Navegación | Sí (Sheet) |
| Submenú | Dropdown al pasar el ratón en desktop, toggle por clic en ≤1024 px, Esc para cerrar | Global | Navegación | Sí |
| Header sticky y auto-oculto | JS al hacer scroll | Global | Navegación | Sí |
| Topbar | CSS, solo desktop | Global | Datos de contacto | Opcional |
| Parallax con el ratón | JS propio (`data-parallax-speed`) | Home about | Decoración | Review |
| Parallax de fondo con el scroll | jquery-paroller y `.js-parallax` | menu, wines | Decoración | Review |
| Revelado al hacer scroll | IntersectionObserver (`scroll-animate`, `animate-active`) | about, swc, menu, CTA | Entrada animada | Sí (respetando reduced-motion) |
| Animaciones CSS | 18 keyframes (formas que flotan, pulso del badge, orbes, entrada del slider, pulso del WhatsApp…) | Global | Decoración | Seleccionar |
| Hover | Brillo en tarjetas, texto que sube en botones, subrayado animado, elevación de tarjetas | Global | Feedback | Sí |
| Preloader | Logo + barra de progreso; espera a `load` o 10 s; texto en español | Todas las principales | — | No (observado tapando la página varios segundos en SWC) |
| Calendario | JS propio dentro de `script.js` | Home | Elegir fecha | Sí (DatePicker) |
| Totales dinámicos | Estimador en `script.js` | Home | Precio orientativo | Review (depende del negocio) |
| Campos condicionales | Toggle `.hidden` | Home | Evento custom | Sí |
| Igualado de alturas y re-render al redimensionar | `wines.js` | wines | Grid parejo | No |
| Splitting.js | Se carga y se llama `Splitting()` | catálogos | Animación de texto | Review (no se vio uso visible) |

---

## 8. Carousels / Media

### Carruseles

| Carrusel | Contenido | Visibles | Controles | Autoplay | Loop | Indicadores | Swipe | Librería | Clasificación |
|---|---|---|---|---|---|---|---|---|---|
| Hero (Home) | 3 slides de imagen + copy + CTA | 1 | Flechas en losange | 7 s, pausa al pasar por las flechas | Sí | No | No | JS propio | Hero Carousel |
| Testimonios (Home) | 11 videos | 1 / 2 / 2 / 3 (a 0 / 768 / 1024 / 1200 px) | Ninguno (drag) | 6 s; se detiene al reproducir un video; respeta reduced-motion | Sí | Barra de progreso + contador "01/11" | Sí; se bloquea mientras suena un video | Swiper 6 (cargado dinámicamente) | Testimonials / Media Carousel |
| Eventos (Home) | 8 event cards | 1 / 2 / 3 (a 0 / 640 / 992 px) | Flechas + bullets clicables + teclado | No | No | Bullets | Sí | Swiper 6 | Experiences Carousel |
| Historia SWC | 4 slides de story | 1 centrada | Flechas, bullets, teclado | 6.2–6.5 s | Sí | Bullets | Sí | Swiper 6, **inicializado dos veces** (`script.js` + `swc-carousel.js`) | Story Carousel |

### Media

- **Proporciones recurrentes:**
  - Hero: 1880×950 (≈2:1) en Home y 1880×700 en páginas interiores.
  - Category card: 285×336 (≈5:6).
  - Event card: 350×450 (7:9).
  - About: 570×570 (1:1) más 285×285 superpuesta.
  - Split banner: 940×900.
  - Galería: 400×250 (16:10).
  - Aspect ratios en CSS: 16/10, 4/5, 11/9, 4/3, 1.
- **Formatos:** `<picture>` con AVIF, WebP y JPG en la mayoría de los casos (carpetas espejo `avif/` y `webp/`). Los hampers solo tienen WebP.
- **Fondos:** `background-image` inline en testimonios, footer, `form-right` (patrón) y las imágenes laterales de menu. El footer usa `image-set()` en algunas páginas y en otras no.
- **Overlays:** `--gradient-1` (de negro 0.9 a transparente) en heroes; overlay + degradado en la CTA band; overlays de zoom y de play en la galería.
- **Video:** MP4 locales con `controls` (testimonios, galería), con póster en la galería.
- **Iconos:** Ionicons (outline) como sistema principal; PNG para los iconos de features; SVG inline para WhatsApp y redes.
- **Decorativos:** `separator.svg` (ornamento de diamante), `shape-1/2/8.png` (ilustraciones de hojas y aceitunas), `badge-1.png`, `form-pattern.png` (patrón geométrico dorado), orbes CSS.

---

## 9. Typography

### Familias

- **Libre Bodoni** (`--fontFamily-headings`): display, headlines y títulos.
- **Playfair Display** (`--fontFamily-text`): cuerpo.
- En el CSS hay 23 usos de `--fontFamily-forum`, `--fontFamily-dm_sans` y `--fontFamily-oswald`, **variables que no están definidas** (restos de la plantilla, que usaba Forum y DM Sans). Esas reglas acaban heredando la fuente del padre.

### Base

`html { font-size: 10px }`. La escala es fluida con `clamp()`.

### Jerarquía

| Rol conceptual | Legacy | Rasgos |
|---|---|---|
| Display | `display-1` (3–7 rem) | Mayúsculas, line-height 1; subtítulo en itálica dorada (`hero-subtitle`) |
| Heading | `headline-1` (2.5–4.5 rem), `headline-2` | Serif, peso regular |
| Title | `title-1…4` | Títulos de tarjeta; nombres de producto en mayúsculas en los catálogos |
| Body | `body-1…4` (body-4 es el base, 1–1.6 rem) | line-height 1.85em; secundario en `--quick-silver` |
| Label / Eyebrow | `label-2` en mayúsculas, bold, `letter-spacing: 0.4em`, dorado + ornamento | Muy característico |
| Button | `label-2` en mayúsculas, bold, `letter-spacing: 3px` | — |
| Caption | `small-note`, `subtle-note`, captions de galería | Pequeño, gris |

### Observaciones

- Jerarquía semántica irregular: nombres de producto en `h5`, títulos de sección en `h3` (`kf-title`) y `h4` en captions de galería.
- Hay 20+ tamaños literales (`1.4rem`, `18px`, `.75rem`…) fuera de la escala.

---

## 10. Colors / Surfaces

**Lenguaje general:** dark, cálido y lujoso. Negros casi puros con matices cálidos, acento champagne y fotografía de tonos vino y madera.

### Tokens principales

| Rol | Token / valor |
|---|---|
| Fondo base | `--clandestino-bg: #161616` |
| Fondo alterno | `bg-black-10` = `--smoky-black-2` (≈`#0d0c0c`) |
| Superficies de tarjeta | `--eerie-black-1…4` (9–13% de luminosidad), a menudo con degradado de 135° |
| Acento / CTA | `--gold-crayola: hsl(55 34% 80%)` ≈ `#dddaba` (champagne) |
| Texto | blanco |
| Texto secundario | `--quick-silver` (65% gris) |
| Bordes | `white-alpha-10` / `white-alpha-20` |
| Overlays | negro 70–90% en heroes; blur de 10 px en el backdrop del modal |

`style-guide.md` documenta otro valor para el acento (`hsl(38,61%,73%)`, un dorado más cálido), así que **la documentación no coincide con el código**.

### Colores fuera de los tokens

- `#c9a227` y `#d4af37`: dorado saturado, en el modal de contacto y en `links.html`.
- `#cd7f32`: bronce, en la tarjeta Gold.
- `#f4e085`, `#e0a15d`.
- Rojos de error `#e74c3c` y `#ff6b6b`.
- Verde de WhatsApp `#25d366`.

### CTA

Fondo champagne con texto negro. Primary y secondary son visualmente casi iguales.

---

## 11. Responsive

- **Breakpoints:** la base es 480 / 575 / 640 / 768 / 992 / 1200 / 1400, pero hay **unos 50 media queries distintos**. Incluye valores sueltos (340, 380, 420, 520, 560, 600, 680, 820, 900, 920, 1080, 1100, 1280, 1440) y mezcla `767`/`768` y `991`/`992`. Swiper añade 520/640/768/992/1024/1200 y el JS usa 1024 para el submenú.
- **Navegación:** menú en línea en desktop, drawer lateral en móvil; la topbar se oculta en móvil.
- **Stacking:** los splits (about, special-dish, menu preview, reserva) pasan a una columna; los grids de 3–4 columnas pasan a 1.
- **Tipografía:** fluida con `clamp`, más overrides puntuales en `:root` dentro de media queries.
- **Carruseles:** pasan de 3 a 1 tarjeta visible; los testimonios se centran por debajo de 480 px.
- **Formularios:** grids de 2 columnas que pasan a 1.

### Problemas respaldados por evidencia

- En móvil, el fondo del hero interior mide 419 px sobre un viewport de 390 px (lo recorta `overflow:hidden`; no genera scroll horizontal).
- `wines.js` reconstruye todo el grid en cada resize para cambiar el texto del precio.
- El preloader bloquea la vista hasta `load` (máximo 10 s).

**Tablet:** no capturada visualmente; solo analizada en código.

---

## 12. Duplicación y oportunidades de composición

1. **Section Heading con 6 implementaciones:** `section-subtitle/section-title`, `kf-subtitle/kf-title`, `clandestino-gallery-subtitle/title`, `clandestino-stats-subtitle/title`, `clx-contact-subtitle/title` y `clandestino-subtitle/title`. Es un solo componente con variante de alineación.
2. **Product Card con 3 implementaciones:** `clandestino-menu-item-card` (HTML en `menu.html`) y `kf-menu-item`, que se genera en 3 JS casi idénticos (`tapas.js`, `wines.js`, `hampers.js`) con lógica duplicada de picture, lightbox, filtros y WhatsApp. Se resuelve con un `ProductCard` y variantes wine/tapa/hamper.
3. **Filterable Grid:** catálogos (Isotope) y galerías (JS propio) son el mismo patrón, "pills + grid filtrado", implementado dos veces.
4. **Lightbox:** Magnific Popup y `clx-lightbox` propio conviven.
5. **Hero:** slider e interior comparten markup (`slider-item`, `hero-content`); es un solo patrón con variante.
6. **Imagen + contenido + CTA:** `special-dish` (SWC, Private Events), Editorial Split (about home, about story) y Menu Preview Split son un mismo patrón de split con variantes (overlap, bullets, lista de items).
7. **Grids de tarjetas con icono:** Feature Grid, Stats Grid, contact highlights y SWC FAQ reutilizan clases de otros patrones para contenido distinto. La composición legítima sería un grid de "icon + title + text" con un slot opcional para métrica.
8. **Booking CTA Band:** copiada en 5 páginas con cambios de texto y de enlaces (`contact.html#book` y `wines.html#club` apuntan a anclas que no existen en esas páginas).
9. **Chrome global:** header, footer y drawer copiados en cada HTML con **datos divergentes**: emails `ntcusa@` o `info@`, copyright "ByteForge" o "The Clandestino USA", `alt="grilli home"`, mensajes de WhatsApp distintos por página.
10. **Validación y submit:** 2 handlers en reserva y 3 en contacto. Un solo sistema de formularios evitaría esa duplicación.
11. **Datos de negocio repetidos** (horario, dirección, teléfono) en unos 10 lugares por página. Además, `README.md` describe otro horario (miércoles a domingo desde las 13:00) distinto del que muestra la web (martes a domingo, 16–20 h).

---

## 13. Patrones que vale la pena preservar

- **Jerarquía "eyebrow dorado espaciado + ornamento + serif grande":** es la firma visual más consistente del sitio.
- **Hero con título display en mayúsculas + subtítulo itálico dorado:** identidad clara aplicada en todas las páginas.
- **Fotografía real y cálida** (bodega, barricas, tablas de embutido, clientes, el dueño Nicolás) a sangre con overlay oscuro. La foto del dueño superpuesta en el about aporta autenticidad.
- **Ritmo alterno de secciones** (fondo base / fondo más oscuro) y splits imagen/texto que alternan de lado.
- **Wine Club como producto estrella:** niveles Diamond/Gold con icono, cinta, precio trimestral, beneficios y vinos por nivel.
- **Eventos semanales** con fecha, gancho y precio en tarjetas verticales, y un modal con el detalle.
- **Private gatherings** como propuesta diferenciada ("The evening, held for you").
- **Video-testimonios reales** como social proof.
- **Conversión conversacional por WhatsApp:** el negocio opera así; conviene conservar la intención aunque cambie la implementación.
- **CTA doble "Reserve / Join the Club"** al final de cada página.
- **Estimación y resumen en vivo en la reserva:** la intención de dar transparencia al usuario tiene valor, aunque la lógica deba revisarse.

---

## 14. Legacy que debe reinterpretarse

| Elemento | Razón técnica |
|---|---|
| Mezcla de Bootstrap 3 y Bootstrap 5 por página + CSS propio | Conflictos de reset y utilidades; ambas versiones cargan completas para un uso marginal (el modal de Bootstrap 5 queda anulado por `form-feedback.js`) |
| jQuery + Isotope + imagesLoaded + Magnific + Splitting + paroller | Dependencias antiguas, solo para filtrar, abrir lightbox y hacer parallax; duplican funcionalidad propia |
| Swiper 6.8.4, cargado dinámicamente e inicializado dos veces en SWC | Versión antigua; doble instancia sobre el mismo contenedor |
| `style.css` minificado como fuente, 55 `!important`, ~50 breakpoints | Imposible de mantener; los breakpoints no forman un sistema |
| Variables inexistentes (`--fontFamily-forum`, `--fontFamily-dm_sans`, `--fontFamily-oswald`, `--fontSize-3/4/5`, `--cubic-out`) | Las reglas afectadas caen al valor heredado; el diseño real no es el que el CSS pretende |
| `style-guide.md` desalineado con el color real | La documentación no refleja los tokens reales |
| Catálogos como arrays JS con HTML en template strings | El contenido queda acoplado a la presentación; debería venir de datos o backend |
| Disponibilidad simulada (franjas hardcodeadas + `localStorage`) y calendario que no bloquea el lunes | Da al usuario información falsa |
| Múltiples handlers de submit en reserva y contacto | Flujo opaco; la ruta a WhatsApp de `script.js` es inalcanzable |
| Textos de UI en español dentro de una web en inglés (disponibilidad, preloader, "Favorita", mensajes de WhatsApp) | Inconsistencia de idioma |
| Chrome copiado en cada HTML con datos divergentes | Fuente de inconsistencias (emails, copyright, `alt="grilli home"`) |
| Código muerto: modal de cierre con cuenta atrás de 2025, newsletter comentado, `script.legacy.backup.js`, JS vacíos (`preloader.js`, `reservation.js`, `utils.js`), `old-clandestino.zip` (331 MB) en la raíz | Ruido |
| Semántica y accesibilidad: `role="tabpanel"` sin tabs en el hero, `h5` en productos, enlaces de lightbox sin nombre accesible (aparecen como "Eye"), honeypots visibles para lectores de pantalla, `aria-expanded` del menú sin actualizar, clones de loop de Swiper expuestos | Verificado en el árbol de accesibilidad del navegador |
| Preloader que bloquea hasta `load` o 10 s | Retrasa el contenido (observado en SWC) |
| Stats de contacto con "números" falsos ("Call", "211") | Se reutiliza un patrón fuera de su semántica |
| `terms.html` sin header ni footer; `links.html` y `offline.html` con tokens propios | Visual inconsistente respecto al resto del sitio |

---

## 15. Matriz de migración visual

| Legacy | Tipo | Reutilización | Nuevo Design System | Prioridad |
|---|---|---|---|---|
| Header + nav + submenús | Layout | alta | Brand Component | Core |
| Drawer móvil | Layout / Flow | alta | Brand Component (sobre Sheet) | Core |
| Topbar | Layout | alta | Brand Component | Optional |
| Footer | Layout | alta | Brand Component | Core |
| WhatsApp float | UI | alta | Brand Component | Core |
| Preloader | UI | alta | Discard/Legacy | Legacy only |
| Button primary/secondary | UI | alta | Primitive (variante de marca) | Core |
| Eyebrow + ornamento / Section Heading | UI | alta | Brand Component | Core |
| Hero slider / hero interior | Sección | alta | Section Pattern | Core |
| Category Showcase | Sección | baja | Section Pattern | Useful |
| Editorial Split | Sección | media | Section Pattern | Core |
| Split Media Banner | Sección | media | Section Pattern | Core |
| Icon Feature Grid | Sección | media | Section Pattern | Useful |
| Stats Grid | Sección | media | Section Pattern | Useful |
| Contact highlights (stats reutilizado) | Sección | baja | Review (pasar a Contact Info Grid) | Useful |
| Video Testimonials Carousel | Sección | única | Section Pattern | Useful |
| Events Carousel + modal | Sección / Flow | única | Section Pattern + Flow | Core |
| Booking CTA Band | Sección | alta | Section Pattern | Core |
| Menu Preview Split | Sección | baja | Section Pattern | Useful |
| Filterable Product Grid | Sección | alta | Section Pattern | Core |
| Product Card (3 implementaciones) | UI | alta | Brand Component | Core |
| Filterable Media Gallery + lightbox | Sección | media | Section Pattern | Useful |
| SWC Story Carousel | Sección | única | Review | Optional |
| Membership Plans / Card | Sección | baja | Section Pattern + Brand Component | Core |
| FAQ Accordion | Sección | media | Section Pattern | Useful |
| FAQ en tarjetas (SWC) | Sección | única | Discard (unificar en acordeón) | Legacy only |
| Reservation form | Flow | única | Flow | Core |
| Estimador de precio | Flow | única | Review | Optional |
| Disponibilidad simulada | Flow | única | Discard/Legacy | Legacy only |
| Contact form | Flow | media | Flow | Core |
| Result dialog | Flow | media | Flow / Brand Component | Core |
| WhatsApp deep links | Patrón | alta | Brand Component (datos centralizados) | Core |
| Legal prose | Sección | media | Section Pattern | Useful |
| Links page | Página | única | Page-specific | Optional |
| Offline page | Página | única | Page-specific | Optional |
| Formas decorativas / orbes | Decorativo | media | Review | Optional |
| Parallax con el ratón | Interacción | baja | Review | Optional |
| Modal de cierre con cuenta atrás, newsletter comentado | Código muerto | — | Discard/Legacy | Legacy only |

---

## 16. Inventario maestro

### Foundations

1. Paleta dark (base, alterno, superficies eerie-black)
2. Acento champagne único (unificar gold, `#c9a227`, `#d4af37`)
3. Color de tier Diamond (champagne) y de tier Gold (bronce)
4. Colores de estado (success/error/info) y verde de WhatsApp
5. Tipografía: serif de titulares + serif de cuerpo
6. Escala tipográfica fluida (Display, Headline, Title, Body, Label, Caption)
7. Estilo de eyebrow (mayúsculas, tracking amplio, dorado)
8. Espaciado de sección (70–100 px) y ancho de contenedor
9. Radios (8 / 12 / 16 / 24 px, círculo)
10. Sombras y overlays (degradado de hero, backdrop con blur)
11. Motion (duraciones 250 / 500 / 1000 ms, reveal, reduced-motion)
12. Breakpoints unificados (sm, md, lg, xl)
13. Iconografía (set outline único)
14. Proporciones de imagen (2:1 hero, 5:6 categoría, 7:9 evento, 16:10 galería, 1:1)
15. Ornamentos de marca (diamante, tres puntos, patrón geométrico)

### Primitives

16. Button (primary, secondary/outline, icon, loading, disabled)
17. Link con subrayado animado
18. Badge / Ribbon
19. Tabs / ToggleGroup (filtros)
20. Input, Select, Textarea, Checkbox
21. DatePicker
22. Dialog
23. Sheet (drawer)
24. Accordion
25. Carousel (base)
26. Lightbox / Image viewer
27. Separator (ornamental)
28. Status message (FormStatus)

### Brand Components

29. Logo
30. Section Heading (eyebrow + título + texto)
31. Display Title con acento itálico
32. Contact Detail (label + valor)
33. Opening Hours / Address block
34. WhatsApp CTA (float, botón icono, enlace con mensaje)
35. Social Links
36. Category Card
37. Feature Card
38. Stat Item / Contact Info Item
39. Event Card
40. Product Card (wine, tapa, hamper)
41. Price Display (single, glass/bottle, per-quarter, promo)
42. Membership Card
43. Benefit List Item
44. Gallery Item (image/video)
45. Video Card con overlay de play
46. Header / Nav con submenú
47. Mobile Nav Drawer
48. Topbar
49. Footer
50. Form Field (label + icono + control + error)
51. Result Dialog

### Section Patterns

52. Full-bleed Hero (slider / interior)
53. Category Showcase Grid
54. Editorial Split (overlap-images / values-list)
55. Split Media Banner (con o sin bullets)
56. Icon Feature Grid
57. Stats Grid
58. Contact Info Grid
59. Video Testimonials Carousel
60. Events Carousel
61. Booking CTA Band
62. Menu Preview Split
63. Filterable Product Grid
64. Filterable Media Gallery
65. Membership Plans
66. FAQ Accordion
67. Contact Form Section
68. Reservation Section (formulario + aside)
69. Legal Prose
70. Story Carousel (Review)

### Flows

71. Reservation & Events (fecha, hora, tipo, campos condicionales, resumen, términos, envío, resultado)
72. Contact (validación inline, envío, estado, resultado)
73. Event Detail (modal + CTA)
74. Product / Membership inquiry via WhatsApp
75. Filter + Lightbox browsing
76. Mobile navigation

### Page-specific

77. Home composition
78. Menu composition (3 previews)
79. SWC composition (story, plans, wines by tier, FAQ)
80. About composition (story, gallery, stats)
81. Link-in-bio page
82. Offline page

---

## 17. Archivos inspeccionados

- **HTML:** `index.html`, `menu.html`, `tapas.html`, `wines.html`, `hampers.html`, `swc.html`, `about.html`, `contact.html`, `policies.html`, `terms.html`, `links.html`, `offline.html`. Se leyeron las secciones relevantes; el `<head>`/SEO solo en parte.
- **CSS:** `assets/css/style.css` (variables, reglas clave, media queries, colores, tamaños y keyframes extraídos por script) y `faq-styles.css`; `form-feedback.css` y `whatsapp-float.css` solo por referencia.
- **JS:** `script.js`, `gallery.js`, `swc-carousel.js`, `tapas.js`, `wines.js`, `hampers.js`, `form-feedback.js`, y los scripts inline de `index.html` y `contact.html`.
- **Documentación / config:** `README.md`, `style-guide.md`, `package.json`, estructura de `assets/images` (carpetas avif/webp/gallery/videos).
- **No analizados en profundidad:** `reservation.php` y `contact.php`. Según el JS, son endpoints que devuelven JSON y no generan markup.
- **Revisión visual:** servidor PHP local en `localhost:8080`, capturas en 1440 px y 390 px, más inspección del árbol de accesibilidad y de estilos computados vía DevTools. Tablet no capturada. Las capturas quedaron en la carpeta temporal de Cursor, fuera del proyecto.

---

## 18. Acciones realizadas

Durante la fase de análisis:

- No se modificaron archivos del proyecto.
- No se instalaron dependencias.
- No se hizo commit.
- No se hizo push.
- No se migró código ni se generó React, Tailwind o shadcn.

Notas:

- El directorio no es un repositorio git (`git status` falla), así que no se pudo usar git para verificar que el árbol sigue intacto.
- El único efecto colateral fue arrancar con el PHP ya instalado el mismo comando que figuraba en un terminal previo (`php -S localhost:8080`), que estaba caído, y detenerlo al terminar.
- Este archivo (`LEGACY-UI-INVENTORY.md`) se creó después, a petición expresa del usuario, como entregable del análisis. Es el único archivo añadido al proyecto.
