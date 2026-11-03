# Home C8 — Reservation Invitation

Actualización 2026-11-02, America/Bogota. Rama `feature/home-reservation-invitation`. **C8 aprobada visualmente por el responsable del proyecto en móvil, tablet y escritorio.** La aprobación comprende fotografía provisional, degradado, copy, CTA, dimensiones, breakpoints y posición. Se conservan exactamente; este cierre solo audita, documenta y autoriza commit y push para un PR manual hacia `develop`. Sin PR automático, merge, deploy ni cambios en `main`.

## Cierre definitivo aprobado

Commit autorizado: `feat(home): integrar invitación editorial a reservas`. Publicación normal a `origin/feature/home-reservation-invitation`, sin force push. La auditoría final no requirió modificar código, imágenes ni diseño. Se revisaron el diff completo contra `origin/develop` y los tres archivos nuevos de C8; el alcance comprende exclusivamente los seis archivos enumerados al final.

Tras `git fetch origin`, HEAD, develop, origin/develop y merge-base coinciden en `82a6049984a982aecacccf3be657b209a6300914`, integración del Hero definitivo por PR #25. La rama remota de C8 no existía al comenzar este cierre. `docs/HOME-FINAL-AUDIT.md` se excluye expresamente del staging y del commit; su hash original permanece intacto. No se incluyen capturas, scripts temporales ni otros cambios.

### QA de cierre

| Comprobación | Resultado |
|---|---|
| Lint, build, PHP, HTML y Node | PASS: ESLint/Stylelint, build de producción, PHP lint de anfitrión y partial, parser HTML5 sin errores y ambas pruebas Node existentes |
| Responsive y composición | PASS: 390/820/1440 y controles adicionales 768/1280; sin overflow, textos cortados ni fotografías deformadas. Las capturas de C8 en 390/820/1440 son idénticas píxel a píxel a las aprobadas |
| Diseño congelado | PASS: hashes idénticos de PHP/SCSS, configuración, partials protegidos y los seis recursos fotográficos usados; solo se actualiza documentación durante el cierre |
| Contraste | PASS: mínimo 4,68:1 reproducido en la descripción sobre el fallback WebP a 768px, el caso más próximo al umbral. AVIF en los cinco anchos de cierre y JPEG/WebP en 768 también pasan; sin ajustes del degradado |
| Teclado, foco y CTA | PASS en 390/820/1440: Tab/Shift+Tab entre Guest Stories, Request a Table y Explore Diamond; foco champagne 2px/offset 3px, target de 256×44px y Enter hacia `/index.html#reservation` |
| Sin JavaScript | PASS para la sección y su enlace en los tres anchos: fotografía, contenido, aviso y navegación al formulario real. El submit legacy continúa deshabilitado sin JS; no se acredita entrega operativa |
| CLS atribuible a C8 | PASS: 0 en 390/820/1440. Con fuentes y demás imágenes estabilizadas, se retuvo la fotografía de C8 y se liberó su carga: Layout Instability no registró desplazamientos y la geometría de C8, Wine Club y Visit no cambió. Es una medición local controlada, no una certificación de CLS global ni del percentil 75 en producción |
| Regresiones | PASS: Guest Stories, Wine Club y Visit coinciden en geometría y estilos con la base sin C8 en los tres anchos, normalizando el estado del carrusel. CSS ajeno a las 17 reglas locales de C8 idéntico al de la base |
| Semántica, consola y red | PASS: un h1, IDs únicos, orden correcto de secciones, aviso asociado al CTA; cero errores/warnings y respuestas fallidas en el recorrido de cierre |
| Alcance y formato | PASS: `git diff --check`; solo los seis archivos de C8, sin staging del archivo de auditoría local |

Evidencia externa de cierre: `C:/Users/Mike/.codex/visualizations/2026/11/03/01a19ef4-9a1e-7ff0-9693-d7d3f02ead16/c8-close/`. Contiene capturas de sección/foco/sin JS, `close-review.jpg`, `audit.json` (responsive, teclado, destino, regresiones, CLS y sin JS), `contrast.json`, `html-validation.json`, `css-regression.json`, `approved-source-hashes.json`, `frozen-source-check.json` y `approved-screenshot-comparison.json`. No se añade instrumentación al producto.

## Objetivo y posición

Convertir el interés acumulado en una solicitud de mesa: Guest Stories → Reservation Invitation → Wine Club. Una sola acción, `Request a Table`, con el copy solicitado y el aviso visible `Table requests are subject to confirmation.` Visit conserva ubicación, horario, indicaciones y contacto; Private Experiences conserva su consulta de encuentros privados.

El CTA consume `$rutaReserva` y el escape de `includes/site.php`, sin duplicar la configuración. Navega a `/index.html#reservation`, donde existe el formulario legacy; no confirma disponibilidad ni reserva. El enlace funciona sin JavaScript. El envío del formulario de destino sí depende del JS legacy; no se crea otro formulario ni se cambia `reservation.php`. Se contrastaron el anclaje y el flujo con `production-baseline`, que no contiene Home Preview.

## Base y protección

`git fetch origin` confirmó el refinamiento definitivo del Hero integrado por PR #25: `82a6049`, con `498327b` como ancestro. `develop` se actualizó por fast-forward desde `75696b0`; la rama solicitada nace de esa base. Ningún archivo rastreado tenía cambios al comenzar.

`docs/HOME-FINAL-AUDIT.md` permanece sin seguimiento y byte a byte intacto: SHA256 `49B97D8320715F61AC0BCAEAE196E847C56B6F397CA971B29D9CCFCE75932BCC`. Excluido del staging y del commit. No cambian páginas públicas, secciones aprobadas, originales fotográficos, backend, dependencias ni JavaScript.

## Decisión visual y reutilización

Una única banda panorámica, con fotografía completa y relato integrado a la derecha desde `md`; en teléfono, relato y CTA centrados sobre la fotografía. La orientación inversa y la menor altura la distinguen de C7. No se repite su composición ni se añade ornamentación. Márgenes exteriores de 16px, 32px desde `md` y 48px desde `xl`, coherentes con C7. El contenido permanece en flujo; no hay altura fija, recortes de texto ni animación nueva.

Reutiliza Banda CTA (`cl-banda-cta`, contenido, imagen y acciones), Grid Bootstrap 5.3, descripción/acciones de Sección, eyebrow y botón Core. Foundation aporta tipografía, color, espaciado, radio y foco. El split de `cl-banda-cta--destacada` no se aplica porque separa foto y texto; la superposición autorizada se resuelve exclusivamente en `pages/_home-reserva.scss`, sin otra variante o componente genérico. La prosa se limita a 54ch en pantallas amplias.

El degradado usa el neutro cálido Foundation sobre la fotografía: vertical en teléfono y lateral desde `md`, sin caja opaca. En móvil alcanza la protección de lectura al comenzar el texto, vinculada al mismo espaciado superior, para conservar contraste cuando aumentan las líneas.

## Fotografía provisional

Todos los recursos ya existían; no se modifican ni generan derivados.

| Uso | Original bajo `assets/images/gallery/tapas/` | Dimensiones | AVIF / WebP |
|---|---|---|---|
| Tablet y escritorio | `the-clandestino-tapas-table.jpeg` | 1998 × 628 | 124.724 / 140.428 B |
| Teléfono | `the-clandestino-tapas-wines.jpeg` | 1536 × 2048 | 47.301 / 81.462 B |

El panorama muestra una tabla compartida, sin personas identificables, distinta de C7. La dirección de arte móvil usa vino y tapas para conservar contexto en el recorte vertical. `picture` ofrece AVIF, WebP y JPEG reales; el `img` reserva las dimensiones de su fallback, con carga lazy, decodificación async y descripción accesible. La fotografía ocupa una capa absoluta y el contenido determina la altura.

Recomendación para la selección final: una fotografía real horizontal de una mesa preparada, copas de vino, tapas y asientos disponibles en el restaurante, con luz cálida y espacio de lectura a la derecha; idealmente 2400–3200px de ancho y un encuadre vertical complementario. La imagen actual está aprobada para esta composición y se conserva sin cambios. Cuando se sustituya, será obligatoria una nueva revisión de contraste sobre cada recorte y formato reales, especialmente la descripción próxima al mínimo actual de 4,68:1.

## Responsive

Mediciones finales en Chromium local, DPR 1 y preferencia de movimiento reducido. Altura de la banda fotográfica, sin el espaciado exterior; todos los casos sin overflow horizontal ni elementos de C8 fuera del viewport. CTA de 44px de alto, ancho 240px a 320 y 256px en el resto.

| Viewport | Altura aproximada | Resultado |
|---|---|---|
| 320 | 544px | PASS, contenido completo; eyebrow y aviso admiten dos líneas |
| 360 | 465px | PASS |
| 390 / 425 | 436px | PASS |
| 600 | 407px | PASS, fotografía integrada y lectura centrada |
| 768 / 820 | 372 / 373px | PASS, composición lateral integrada |
| 992 / 1024 | 377 / 377px | PASS |
| 1199 / 1200 | 353 / 353px | PASS, transición de márgenes sin salto de contenido |
| 1280 / 1440 | 355 / 359px | PASS |
| 2560 | 372px | PASS, límite de lectura conservado |

Se inspeccionaron los recortes, la jerarquía y la continuidad completa Guest Stories → C8 → Wine Club en 390/820/1440. Visit sigue siendo un cierre informativo con dirección y horario; C8 concentra la invitación emocional en una sola acción.

## QA técnico y accesibilidad

| Comprobación | Resultado |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: bundle reducido de Home, producto y sprite |
| PHP lint | PASS: `home-preview.php` e `includes/reservation-cta.php` |
| HTML estructural | PASS: parser HTML5 sin errores; un h1, IDs únicos, h2 asociado a la sección, alt y dimensiones, una acción y cero formularios nuevos |
| Pruebas Node | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs` |
| Contraste | PASS: 14 anchos AVIF y respaldos WebP/JPEG en 320/768/1440; mínimo 4,68:1 en las cajas de glifos sobre el fondo renderizado; botón 12,69:1 |
| Teclado y foco | PASS: último video de Guest Stories → CTA → Explore Diamond; retorno con Shift+Tab; anillo champagne 2px, offset 3px; Enter abre el destino real |
| Sin JavaScript | PASS para C8: navegación al formulario existente; envío legacy deshabilitado sin JS, limitación documentada |
| Reflow | PASS en los 14 anchos. Con texto al 200% a 320px, C8 crece sin recortar ni desbordar; existe overflow global ajeno a C8 que persiste al retirarla del DOM. No equivale a verificar zoom real del navegador |
| Consola y red | PASS en el recorrido final de Home: cero errores/warnings y cero respuestas HTTP fallidas; el 404 intencional del partial directo se prueba aparte |
| Protección local | PASS: Home Preview mantiene `noindex, nofollow`; acceso directo al nuevo partial devuelve 404 |
| Regresiones | PASS: Header, Hero, Discovery, Pure Soul, C7, Guest Stories, Wine Club, Gifting, Visit y Footer sin diferencias de geometría/estilos en 390/820/1440 contra la base controlada, con imágenes y fuentes estabilizadas |
| CSS ajeno a C8 | PASS: idéntico al compilado desde HEAD al excluir las 17 reglas locales nuevas |
| `git diff --check` | PASS; cambios limitados a los seis archivos enumerados debajo |

El contraste se calcula con texto oculto temporalmente en el navegador de QA y los colores computados, muestreando cada caja de carácter sobre la fotografía y el overlay reales; no añade instrumentación al producto. No se certifican Safari/Firefox, dispositivos físicos, lector de pantalla auditivo ni WCAG integral.

## Evidencia y reproducción

Ejecutar `npm run build`; iniciar `php -S 127.0.0.1:8000 -t .` si no está activo. Abrir `http://127.0.0.1:8000/home-preview.php#reservation-invitation` y revisar especialmente 390, 820 y 1440px.

Capturas completas: [móvil 390](C:/Users/Mike/.codex/visualizations/2026/11/03/01a19ef4-9a1e-7ff0-9693-d7d3f02ead16/c8/full-390.png), [tablet 820](C:/Users/Mike/.codex/visualizations/2026/11/03/01a19ef4-9a1e-7ff0-9693-d7d3f02ead16/c8/full-820.png), [escritorio 1440](C:/Users/Mike/.codex/visualizations/2026/11/03/01a19ef4-9a1e-7ff0-9693-d7d3f02ead16/c8/full-1440.png).

La misma carpeta externa contiene `section-{ancho}.png`, `continuity-{390,820,1440}.png`, `responsive-sheet.jpg`, `responsive.json`, `all-formats.json`, `contrast.json`, `keyboard.json`, `no-js.json`, `semantics.json`, `html-validation.json`, `http.json`, `text-200.json`, `regression.json` y `css-regression.json`. Las capturas completas miden respectivamente 390×10602, 820×7470 y 1440×7794px. No se incorporan binarios de QA al repositorio.

## Archivos y pendientes

Cambios: `home-preview.php`, `includes/reservation-cta.php`, `assets/scss/home.scss`, `assets/scss/pages/_home-reserva.scss`, `docs/ARQUITECTURA.md` y este informe.

Pendientes comerciales y de producción: fotografía definitiva; recepción operativa de solicitudes mediante una prueba autorizada; nueva revisión de contraste al cambiar la imagen; validación final en Apache/GoDaddy del futuro anfitrión público, assets compilados, rutas y restricciones de publicación. No se envió ninguna solicitud durante el QA; HTTP 200 y la llegada al formulario no acreditan entrega. La dependencia JS del formulario legacy, el overflow global con texto al 200% y las condiciones de publicación de C6 pertenecen a sus alcances respectivos. La aprobación visual de C8 está completa; este commit/push no activa comercio ni sustituye el sistema de reservas.

HOME C8 READY FOR PR
