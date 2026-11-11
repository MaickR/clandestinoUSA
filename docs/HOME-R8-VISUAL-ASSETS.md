# Home R8 — integración fotográfica

2026-11-10 · America/Bogota. Rama `feature/home-r8-visual-assets` desde `develop` en `705cbc5`, merge del PR #33. El responsable del proyecto aprobó visualmente la integración de las seis fotografías y autorizó el cierre para PR manual hacia `develop`.

## Originales y mapeo

La carpeta entregada estaba en `assets/images/r8-input/`. Las dimensiones y los SHA256 de los seis PNG coinciden con `README-SOURCES.txt`. Los PNG se conservan como fuentes de trabajo locales.

| Original | Dimensiones | Bytes | Destino |
|---|---:|---:|---|
| `hero-mobile-01-tapas.png` | 1086×1448 | 2.197.775 | Hero, escena 1 vertical |
| `hero-mobile-02-brindis.png` | 1086×1448 | 2.543.890 | Hero, escena 2 vertical |
| `hero-mobile-03-pure-soul.png` | 1086×1448 | 2.245.177 | Hero, escena 3 vertical |
| `private-experiences-master.png` | 1536×1024 | 2.391.060 | Private Experiences, incluidas las variantes móviles del mismo original |
| `reservations-master.png` | 2164×727 | 2.826.350 | Reservation Invitation desde 768 px |
| `visit-master.png` | 1254×1254 | 3.200.228 | Visit en todos los tamaños |

## Producción de imágenes

Pillow 12.3.0 ya disponible en el equipo. Los originales son RGB sin perfil incrustado ni EXIF. Se trataron como sRGB, con redimensionado Lanczos, AVIF de calidad 62–65 en 4:4:4, WebP 85–86 y JPEG progresivo 86 para los fallbacks de las tres secciones. Se compararon las versiones decodificadas con los PNG. Los derivados conservan el color y la geometría de la fuente. No se aplicaron filtros, reencuadre generativo ni ampliación de píxeles. En la panorámica de Reservations, las alturas de los candidatos se redondean al píxel entero más cercano.

Los 41 archivos de `assets/images/home-r8/` suman 7.256.855 B. La extensión de cada columna completa el nombre exacto. Los valores son bytes de archivo.

| Nombre base | Dimensiones | `.avif` | `.webp` | `.jpg` |
|---|---:|---:|---:|---:|
| `hero-tapas-vertical-480` | 480×640 | 44.981 | 70.786 | — |
| `hero-tapas-vertical-768` | 768×1024 | 82.427 | 135.800 | — |
| `hero-tapas-vertical-1086` | 1086×1448 | 123.893 | 210.402 | — |
| `hero-brindis-vertical-480` | 480×640 | 58.615 | 85.072 | — |
| `hero-brindis-vertical-768` | 768×1024 | 114.478 | 176.006 | — |
| `hero-brindis-vertical-1086` | 1086×1448 | 178.582 | 284.130 | — |
| `hero-pure-soul-vertical-480` | 480×640 | 50.367 | 74.860 | — |
| `hero-pure-soul-vertical-768` | 768×1024 | 94.760 | 147.378 | — |
| `hero-pure-soul-vertical-1086` | 1086×1448 | 144.890 | 232.222 | — |
| `private-experiences-768` | 768×512 | 61.824 | 95.574 | — |
| `private-experiences-1152` | 1152×768 | 108.326 | 173.350 | — |
| `private-experiences-1536` | 1536×1024 | 157.054 | 254.948 | 442.252 |
| `reservations-1082` | 1082×364 | 78.136 | 127.186 | — |
| `reservations-1623` | 1623×545 | 142.884 | 235.750 | — |
| `reservations-2164` | 2164×727 | 207.738 | 355.894 | 536.677 |
| `visit-480` | 480×480 | 47.161 | 72.982 | — |
| `visit-816` | 816×816 | 121.347 | 198.654 | — |
| `visit-1254` | 1254×1254 | 234.408 | 404.520 | 562.384 |
| `private-experiences-movil-1152` | 1152×768 | 126.089 | 202.068 | — |

[Rutas, dimensiones y SHA256 de cada derivado](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/derivados.json).

## Selección por viewport

- **Hero.** `<picture>` elige AVIF o WebP de una sola composición. En vertical por debajo de 768 px usa las tres tomas nuevas. En tablet vertical de 768 a menos de 992 px, mesa y brindis usan las nuevas tomas, y Pure Soul usa la horizontal, que conserva mejor la botella y las copas en la banda ancha. En horizontal y desde 992 px se mantienen las fuentes de R4. Para la fuente vertical, `max(100vw, 360px)` cubre el ancho que necesita el encuadre 3:4 en la banda de unos 480 px de alto en teléfono. El foco se ajusta por escena, sin estirar la foto. Primera escena `eager` y `high`. Escenas 2 y 3 en `template` hasta seleccionarlas, con decodificación antes de la transición. La banda reserva su altura mediante el contenido existente.
- **Private Experiences.** Un master de 3:2, con recorte móvil 3:2 de 1152×768 en las coordenadas (384,256)–(1536,1024). En móvil la imagen al 125% de alto, anclada abajo y con foco al 56%, muestra la mesa en la parte de arriba. Desde 768 px se usa el cuadro completo con el foco de C7. Se mantienen la composición, el degradado y los dos movimientos existentes del marco y de la foto.
- **Reservations.** Nueva panorámica desde 768 px. En tablet el foco al 68% centra la atención en la tabla y desde 1200 px el foco queda centrado. Por debajo de 768 px se mantiene `the-clandestino-tapas-wines` en AVIF/WebP/JPEG como decisión final aprobada. En 390 y 425 px el recorte de la panorámica perdía contexto de mesa y cortaba la tabla.
- **Visit.** Un master cuadrado con tres anchos en AVIF y WebP y fallback JPEG. Foco centrado con `cover`, tanto en el cuadro 4:3 móvil como en la columna más alta de tablet. Texto alternativo actualizado según el interior, las mesas, flores y banderas visibles.

Se revisaron las fotografías protegidas y la navegación contra R7. Se modificaron `includes/home-document.php`, `includes/hero.php`, `includes/private-experiences.php`, `includes/reservation-cta.php` e `includes/visit.php`. Los ajustes de foco y escala están en `assets/scss/home.scss`, `assets/scss/pages/_home-privadas.scss` y `assets/scss/pages/_home-reserva.scss`. Se añadieron los 41 derivados y este informe. Los bundles JS de producción y el sprite tienen los mismos hashes que R7. `index.html` y la activación de la nueva Home siguen el estado de `develop`.

## Verificación y evidencia

| Comprobación | Resultado |
|---|---|
| Navegador | PASS en 320×568, 375×667, 390×844, 425×560, 667×375, 768×560, 768×1024, 820×1180, 844×390, 1024×708, 1180×820, 1280×800, 1440×900, 1920×1080 y 2560×1440. Se recorrieron Preview y candidata de QA, con ambas orientaciones en móvil y tablet. |
| Recortes, texto y carga | Las seis fotografías se revisaron dentro de la Home. Sin overflow horizontal ni 404 durante el recorrido. Una solicitud inicial de Hero y tres en total tras visitar sus tres escenas. Una solicitud por sección para Private Experiences, Reservations y Visit. |
| Teclado, foco y movimiento | PASS. Skip link y foco visible, Hero Home/End, apertura/cierre y retorno del menú por teclado, reduced motion y finalización de un grupo GSAP en Private Experiences. |
| Contraste | PASS en 96 muestras de cajas de glifos sobre el fondo renderizado a 390, 768, 820 y 1280 px. Mínimo 5,014:1 para texto normal y 5,235:1 para texto grande. La prueba ocultó temporalmente el color de los glifos en el navegador. |
| Formatos alternativos | PASS al simular falta de AVIF en teléfono y falta de AVIF/WebP en las fuentes de escritorio. Hero conserva el fallback WebP de R4. |
| Build y suites | PASS en `npm ci`, `npm run lint`, `npm run build`, PHP lint de 66 archivos, carrito, cierre de comercio, formularios (126 casos y 27 fechas), Home pública (72 contratos), HTML y `git diff --check`. npm conserva los seis avisos de tooling registrados en R6/R7. |
| Apache local | PASS en 211 comprobaciones Apache/TLS/FastCGI, incluidas 41 de MIME, longitud y caché de los derivados, 83 rutas de medios de Home y dos 404 de maestros esperados. La copia de ensayo retiró su marcador al cerrar. |

**Paquete R7 regenerado.** 885 archivos y 354.643.732 B. El manifiesto de la entrega limpia tiene SHA256 `5c624080475dc55615a8fae427460d79f4a52d406bf2b525ea4feb88fb1aa57d`. Se verificaron todos los hashes, la correspondencia entre el listado y el document root y la exclusión de los originales, archivos privados, archivos de desarrollo y marcador de activación. [Manifiesto](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/entrega-r8/manifest.json) · [Ensayo Apache](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/ensayo-apache-r8/resultados.json) · [SHA256 del Apache portable](https://www.apachelounge.com/download/VS18/binaries/httpd-2.4.70-261106-Win64-VS18.zip).

La evidencia reúne la comparación visual de los PNG, AVIF y WebP, capturas por viewport y URL seleccionadas por el navegador. [Galería](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/evidencia.html) · [Comparación de derivados](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/comparacion-original-derivados.jpg) · [Selección y peticiones](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/qa-responsive.json) · [Contraste](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/contraste-resultados.json).

Revisión local en [Home Preview](http://localhost:3000/home-preview.php) y [candidata de QA](http://127.0.0.1:8088/), servidas desde la copia aislada. Los tres informes históricos conservan sus SHA256 previos y siguen fuera del índice.

## Rendimiento comparativo

Chromium en Windows con dos builds de producción aislados y la misma candidata pública de QA. Tres navegaciones en frío por variante y tamaño, alternadas. CDP aplicó 150 ms de latencia, 204.800 B/s de descarga, 96.000 B/s de subida y CPU ×4. Los servicios de terceros se bloquearon por igual en ambas variantes. Se visitaron las tres escenas y las secciones hasta Footer. Los bytes del recorrido suman los cuerpos HTTP de imágenes, iconos y pósteres solicitados. Los vídeos quedaron en pausa.

| Viewport (DPR) | Hero inicial, ancho y bytes R7 → R8 | Descarga Hero, mediana | Medios del recorrido | Peticiones medios / total | LCP mediano | CLS inicial / recorrido |
|---|---|---:|---:|---:|---:|---:|
| 390×844 (3) | 1672 px / 267.182 B → 1086 px / 123.893 B | 3654 → 2097 ms | 2.184.813 → 1.748.861 B (−20,0%) | 20 / 28 en ambos | 4088 → 2756 ms | 0 / 0,000013 en ambos |
| 820×1180 (2) | 1672 px / 267.182 B → 1086 px / 123.893 B | 4509 → 2127 ms | 2.184.856 → 2.006.328 B (−8,2%) | 22 / 30 en ambos | 4888 → 2800 ms | 0 / 0,000003 en ambos |
| 1440×900 (1) | 1672 px / 267.182 B en ambos | 4124 → 4188 ms | 2.184.856 → 1.991.481 B (−8,9%) | 22 / 30 en ambos | 4476 → 4652 ms | 0 / 0,000002 en ambos |

A 390 y 820 px, el registro final de LCP de R8 no contenía URL de imagen. La duración de la solicitud del primer Hero se mide por separado. En escritorio se sirve el mismo archivo en ambas variantes. Los rangos de LCP se solapan (4468–4568 ms en R7 y 4004–4676 ms en R8). El laboratorio conserva los resultados de cada pasada y el tiempo de cada recurso. [Mediciones por navegación](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/rendimiento.json) · [Medianas y rangos](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/rendimiento-resumen.json).

## Cierre visual

El responsable aprobó los encuadres del Hero y su superposición con titulares y CTA, la toma vertical de Reservations en teléfonos y las composiciones de Private Experiences y Visit. Wine Club conserva la fotografía existente. R8 queda lista para PR manual. La publicación integral mantiene los requisitos de hosting, correo, rollback y contenido audiovisual documentados en R7 y Guest Stories.

En el cierre se volvieron a ejecutar lint, build, PHP lint, suites Node, validación HTML y la matriz de 15 tamaños y orientaciones. Los `alt` corresponden a las escenas y los 41 derivados se decodificaron y cotejaron por tamaño, formato y SHA256. Las capturas de 390, 768 y 1280 px confirman los titulares y CTA legibles con los encuadres aprobados. La verificación local confirmó la raíz legacy, el anfitrión público desactivado y las fuentes de trabajo excluidas. [Capturas del Hero](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/cierre-r8/hero-cierre.jpg) · [Selección y carga diferida](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/cierre-r8/qa-responsive.json)

Se regeneró el paquete en la copia aislada y se verificaron los 885 archivos. El manifiesto y todos los archivos servidos corresponden a los del ensayo previo de 211 comprobaciones Apache. Las modificaciones del cierre se limitan a este informe. [Integridad del paquete de cierre](C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b689-df05-75d3-8dd6-48c8cd3c2669/home-r8/cierre-r8/integridad-paquete.json)
