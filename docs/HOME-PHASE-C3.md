# Home C3 — Cierre aprobado y auditoría técnica

2026-10-28. El responsable aprueba expresamente la composición final completa: Diamond protagonista, Gold editorial, superficie vino, Foundation/Core, encabezado/ornamento, desktop, tablet 7/5 con foto inferior y móvil. **La aprobación visual está concedida y no se reabre.** Los registros inferiores conservan iteraciones anteriores y sus restricciones históricas, sustituidas por este cierre.

## Integración y protección

Rama verificada: `feature/home-wine-club`. Árbol inicial con cuatro archivos del encargo y sin cambios ajenos. Tras `git fetch origin`, `develop` y `origin/develop` siguen en `63c172f`, merge del PR #19 de Discovery, base de la feature. Se inspecciona el diff completo y los dos archivos nuevos; no se hace merge de ninguna rama ni se modifica main. Este cierre autoriza un commit `feat(home): integrar Spanish Wine Club` y push normal de la feature para crear el PR manual hacia develop; no autoriza PR automático, merge o deploy. SHA y sincronización se entregan tras ejecutar esas operaciones, sin intentar insertar el hash del commit dentro de sí mismo.

Alcance final: `includes/wine-club.php`, una inclusión en `home-preview.php`, import de membresía y bloque local C3 en `assets/scss/home.scss`, y este documento. No se agregan recursos, dependencias o JS. Header, Hero, Discovery, Pure Soul, Private Experiences, Footer, index y SWC mantienen sus fuentes frente a develop. Los hashes iniciales/finales del partial, anfitrión y SCSS aprobado coinciden; el único cambio de este cierre es documental.

## Auditoría de implementación

- PHP nativo: include con ruta literal y `__DIR__`, guard de acceso directo 404 y contenido/URLs estáticos. No hay entrada externa, interpolación dinámica que escapar, formularios, consultas o estado comercial. No se incorpora lógica demostrativa del Style Guide.
- HTML: sección nombrada `wine-club`, H2 editorial, H3 Diamond/Gold y artículos nombrados con ARIA. DOM coherente con lectura y teclado; dos enlaces de exploración reales, alt descriptivo, fuentes y dimensiones reservadas. En el documento renderizado hay un H1 y 30 IDs únicos.
- SCSS: BEM `cl-home-club*`, especificidad local proporcional, anidación dentro del límite del proyecto y ausencia de nuevos `!important` o posiciones absolutas para el layout. Foundation/Core y patrones de sección, historia, vino y membresía mantienen sus responsabilidades. No se cambian los patrones globales ni tokens.
- Bootstrap instalado 5.3.8; entrada Home reducida, container/Grid y mixins `up`/`between`. Mobile First: una columna base, tablet desde md cuando hay anchura real para Gold y Diamond, desktop desde xl. Sass usa variables semánticas, `minmax`/`clamp` y mezcla local `color.mix`; no hay otra escala global.
- Foto original y AVIF/WebP existentes intactos: un tamaño 2048w por formato, `sizes` de 288/696/936/623/658 px según el contenedor real, carga lazy, decoding async y caja reservada. Tablet 3:2 con recorte revisado; móvil/desktop 4:3 íntegro. No se atribuye elección entre resoluciones inexistentes.
- Compatibilidad prevista: PHP tradicional e imagen/CSS/JS estáticos compilados, sin procesos Node o servicios comerciales en hosting. Home Preview conserva deliberadamente su guard `cli-server`, `noindex` y 404 fuera del servidor local; no activa la Home pública en Apache. La ejecución real en GoDaddy/cPanel no se ha probado ni se declara validada.

## Verificación del cierre

Ejecutada de nuevo sobre las fuentes aprobadas, en PHP 8.3.14 y Chromium 149.0.7827.55, DPR 1, viewport de 1000 px de alto y reduced motion:

| Comprobación | Resultado actual |
|---|---|
| `npm run lint` / `npm run build` | PASS: ESLint, Stylelint, Sass/Gulp/esbuild, sin instalaciones |
| PHP lint | PASS: Home Preview y los once includes |
| HTML estructural | PASS: stack de etiquetas y lxml, H1/H2/H3, 30 IDs únicos, ARIA, alt, rutas, dimensiones y dos CTA. No certificación Nu/W3C |
| Pruebas existentes | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`. package.json no declara script test; no se inventa una suite |
| Responsive | PASS: 320/360/390/425/600/767/768/820/992/1024/1199/1200/1280/1440/2560, sin overflow ni nombres partidos |
| Límites | Renderizados e inspeccionados 767/768 y 1199/1200, sin texto o controles recortados; composición aprobada conservada |
| Sin JavaScript | PASS: navegador con JS deshabilitado en los quince anchos; fotos y ambos enlaces nativos operativos |
| Teclado y foco | PASS: Private Experiences → Diamond → Gold → Footer, retorno con Shift+Tab, Enter para ambos destinos; 60 comprobaciones del foco Core de 2 px y offset 3 px |
| Targets y contraste | PASS: CTA ≥44 px; texto mínimo 8,12:1, CTA principal 12,69:1 y secundario 16,79:1 |
| Consola y recursos | PASS: Home sin errores/warnings observados ni recursos fallidos; fotos/SWC HTTP 200, partial directo 404 deliberado |
| CLS local | 0 atribuido a C3; total Home hasta 0,05066. Recorrido de laboratorio, no datos de campo ni simulación de red móvil |
| Integridad | PASS: fuentes aprobadas byte a byte, 18 fuentes protegidas frente a HEAD, fotografía original y secciones anteriores intactas |
| `git diff --check` | PASS; se comprueba también el diff preparado antes del commit |

Evidencia nueva de cierre fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/10/28/01a18463-8b24-7d33-b497-3fbea0ac05a7/wine-club-closure/`. Incluye capturas de los quince anchos, continuidad, `qa.json`, `structure.json` y hashes aprobados. Reproducción: servidor PHP local existente, `http://127.0.0.1:8000/home-preview.php#wine-club`; si no está activo, `php -S 127.0.0.1:8000 -t .`. No iniciar un segundo servidor en el mismo puerto.

## Restricción comercial y pendientes reales

La aprobación visual no autoriza publicación comercial definitiva. No se publican precios o periodicidades en C3. Deben confirmarse precios/moneda/impuestos, periodicidad de cobro frente a selección/entrega, beneficios, cantidades, logística/costes, disponibilidad, elegibilidad y condiciones de renovación/cancelación/reembolso.

`swc.html` contiene afirmaciones históricas, incluidos precios, cadencias, beneficios y entregas en copy, metadatos, datos estructurados, FAQ y WhatsApp. Se conserva sin modificar y debe revisarse comercialmente antes de producción. Los botones actuales son enlaces de exploración, no altas, pagos ni suscripciones completadas.

Pendientes técnicos: pruebas en motores/dispositivos no ejecutados, lector de pantalla, zoom nativo y entorno Apache/GoDaddy al efectuar el cutover autorizado. No se afirma certificación WCAG global o validación remota. No quedan errores bloqueantes conocidos en el alcance auditado. PR manual contra develop y revisión de integración pendientes; aprobación artística ya concedida.

**HOME C3 READY FOR PR**

---

## Registro previo — corrección final de tablet

2026-10-28. Estado vigente: concepto aceptado, móvil y desktop congelados; adaptación tablet corregida y pendiente de aprobación visual humana. Este apartado sustituye únicamente las conclusiones responsive de los registros inferiores.

## Causa y solución tablet

Entre 768 y 1199 px, el apilado de ambos planes, la foto limitada a 480 px y el contenedor de 48rem en lg dejaban espacio sin aprovechar y reducían la relación entre fotografía y membresías.

Se aplica exclusivamente `media-breakpoint-between(md, xl)` (768–1199,98 px): encabezado a todo el ancho, Diamond y Gold en columnas 7/5 y fotografía debajo abarcando ambas. El gutter entre planes es 24 px; la separación de la fotografía es 32 px. Diamond conserva superficie vino, mayor nombre y acción champagne. Gold conserva su presentación abierta, texto y botón, centrado verticalmente respecto a Diamond sin estirarlo como otra tarjeta equivalente.

El contenido justifica md: a 768/820, los 696 px útiles permiten Diamond de 392 px y Gold de 280 px; ambos nombres y CTA caben cómodamente. En 600 solo hay 516 px útiles: esa misma división dejaría unos 205 px a Gold, insuficientes para su cabecera actual. Por ello 600 conserva íntegra la composición móvil. En 992/1024 se elimina el límite local de 48rem para recuperar los 936 px útiles de Bootstrap: Diamond ocupa 532 px y Gold 380 px. Desde 1200 se mantiene exactamente la composición desktop aprobada.

## Fotografía y encuadre

Mismo JPEG y mismos AVIF/WebP, sin nuevos recursos. En tablet la imagen ocupa 696 × 464 px en 768/820 y 936 × 624 px en 992/1024: proporción 3:2, `cover` y posición central. El recorte leve retira ambiente superior e inferior de la barra; se inspeccionan botellas, cápsulas y etiquetas en las cuatro capturas completas y se conservan los elementos esenciales visibles del original. No se estira ni se convierte en fondo del texto.

Los atributos `sizes` declaran ahora 696/936 px para tablet; conservan los valores móviles y desktop. `srcset`, originales, alt, lazy loading, decoding y dimensiones HTML permanecen intactos. El aspect-ratio CSS reserva la nueva caja antes de cargar el recurso. Fuera de tablet siguen 4:3 y contain.

| Ancho | Altura anterior / actual de sección | Fotografía actual |
|---|---|---|
| 768 | 1379,8 / 1230,2 px | 696 × 464 px |
| 820 | 1383,6 / 1234,0 px | 696 × 464 px |
| 992 | 1460,2 / 1470,7 px | 936 × 624 px |
| 1024 | 1462,6 / 1473,0 px | 936 × 624 px |

La altura se reduce unos 150 px en md. En lg crece unos 10 px porque se recupera una fotografía de ancho completo; ese incremento corresponde a contenido reconocible, sin rellenos o alturas fijas. Ambos CTA aparecen antes de la fotografía.

## Verificación actual

Pruebas ejecutadas en PHP 8.3.14 y Chromium 149.0.7827.55, DPR 1, viewport de 1000 px de alto y reduced motion. URL: `http://127.0.0.1:8000/home-preview.php#wine-club`.

| Punto | Resultado |
|---|---|
| Revisión artística antes/después | Capturas completas comparadas a 768/820/992/1024; foto alineada a los bordes del conjunto, Diamond dominante y Gold con lectura/acción propias |
| Continuidad | Revisada junto a Private Experiences en la captura tablet, con Pure Soul también incluido |
| Responsive | PASS: doce anchos habituales más 1199/1200; también 600, sin overflow ni nombres partidos |
| Sin JS | PASS: los catorce anchos con JavaScript deshabilitado, recursos cargados y enlaces funcionales |
| Teclado/foco/targets | PASS: Tab/Shift+Tab, Enter para ambos destinos reales, 56 comprobaciones de foco Core de 2 px/offset 3 px, CTA ≥44 px |
| Contraste | PASS: mínimo de texto 8,12:1, CTA principal 12,69:1 y secundario 16,79:1 |
| CLS y consola | C3: 0; Home total hasta 0,05066 en laboratorio. Sin errores/warnings observados o recursos fallidos en Home |
| HTML estructural/recursos | PASS: stack de etiquetas y lxml, 30 IDs únicos, H1/H2/H3/ARIA/alt/dimensiones; SWC y fotos HTTP 200, partial directo 404 previsto. No certificación Nu/W3C |
| Herramientas | PASS: lint, build, PHP lint de partial/anfitrión, `probar-carrito.mjs`, `probar-cierre-comercio.mjs` y diff check. Sin nueva suite |
| Congelación | Todos los rectángulos DOM de C3 idénticos antes/después en 320/360/390/425/600/1280/1440/2560; geometrías de 1200 idénticas en ambos modos JS frente al registro aprobado |
| Protección | 18 fuentes protegidas iguales a HEAD; anfitrión intacto y partial idéntico salvo `sizes`. Tipografías y colores aprobados conservados |

Estas son comprobaciones actuales de navegador, parser y comandos; no se atribuyen pruebas a otros motores, zoom nativo, lector de pantalla, tacto físico o hosting remoto. La inspección visual del agente no concede aprobación artística humana.

## Archivos, evidencia y pendientes

Solo cambian layout/encuadre locales de `home.scss`, los dos `sizes` del partial y este informe. No cambia copy, datos, CTA, foto fuente, tipografía, colores, JS, dependencias ni las secciones protegidas. Continúa `feature/home-wine-club`, con el trabajo local preservado; sin commit, push, PR, merge o deploy.

Evidencia externa: `C:/Users/Mike/.codex/visualizations/2026/10/28/01a18463-8b24-7d33-b497-3fbea0ac05a7/wine-club-tablet/`. `compare-768/820/992/1024.png` contiene cada comparación completa; `tablet-board.png` reúne los cuatro resultados. `antes/` guarda fuentes/capturas previas. `freeze.json`, `qa.json` y `structure.json` registran congelación, medidas y QA; `continuity-820.png` muestra las secciones contiguas.

Pendientes reales: revisión visual tablet del responsable, condiciones comerciales actuales y revisión histórica de SWC antes de producción, más validación fuera del entorno local descrito. Móvil y desktop no se reabren artísticamente por esta corrección.

**HOME WINE CLUB TABLET READY — WAITING FOR VISUAL APPROVAL**

---

## Historial: corrección de composición · Diamond First

2026-10-28. Estado vigente: composición corregida y comprobada localmente, pendiente de aprobación visual humana. La versión anterior de The Private Cellar fue rechazada por su retícula; se conservan como base aprobada la superficie vino de Diamond, su tipografía/botón, el tratamiento editorial de Gold, el ornamento y los textos comerciales prudentes. Los apartados inferiores son historial, no describen el estado vigente.

## Causa y corrección

La retícula anterior hacía que Diamond ocupara dos filas, mientras Gold y una fotografía limitada a 224 px compartían la columna secundaria. Esto subordinaba la fotografía a un hueco residual y separaba los dos niveles comerciales. El offset de Gold reforzaba esa desconexión.

La nueva retícula desktop tiene dos áreas: Diamond y Gold apilados a la izquierda, y fotografía a la derecha abarcando las dos filas comerciales. Las columnas son 5/7, con 48 px de separación. La fotografía se centra verticalmente respecto al conjunto de ambos planes, sin estirar filas ni ocultar una parte del original. El encabezado ocupa el ancho superior y queda a 32 px del contenido comercial, sin el margen adicional anterior.

A 1440 px, Diamond y Gold tienen 470 px de ancho y la fotografía mide 658 × 493,5 px. Diamond conserva su superficie, borde, tipografía, descripción y CTA champagne; Gold comparte su anchura/alineación y mantiene descripción y botón propios inmediatamente debajo. La foto vuelve a ser una presencia editorial comparable al conjunto, sin ocupar el fondo del copy.

## Responsive y fotografía

La composición de dos áreas comienza en `xl` (1200 px). Por debajo se mantiene un único orden: encabezado → Diamond → Gold → fotografía. Se comprobaron expresamente 1199 y 1200 px, además de los doce anchos pedidos.

| Rango | Composición y medidas reales |
|---|---|
| 320/360/390/425 | Una columna; foto limitada a 288 × 216 px después de ambos CTA. Se conserva el tratamiento móvil anterior de planes y tipografía |
| 600 | Una columna; planes de 516 px y foto compacta de 288 × 216 px |
| 768/820 | Una columna; ambos planes de 696 px y fotografía de 480 × 360 px |
| 992/1024 | Misma columna con límite local de lectura: planes de 744 px y foto de 480 × 360 px |
| 1199/1200 | Transición comprobada de apilado a dos áreas. A 1200, planes de 445 px y foto de 623 × 467,25 px |
| 1280/1440/2560 | Dos áreas; planes de 445–470 px y foto de 623–658 px de ancho |

No hay un tercer sistema de presentación para tablet. El límite de 48rem aplicado solo en `lg` evita inflar el panel apilado hasta 936 px mientras aún no hay espacio para la retícula desktop. Las alturas siguen determinadas por el contenido. La foto conserva 4:3 y `object-fit: contain`: sin recortes, filtros, deformación o alturas de viewport.

Se conserva `the-clandestino-wines-6.jpeg` y sus AVIF/WebP existentes, con originales intactos. Solo se actualiza `sizes` para declarar las nuevas anchuras: 288/480/623/658 px. Dimensiones reservadas, alt, carga lazy y decoding async permanecen intactos.

## Alcance de esta corrección

Se modifican únicamente el bloque de layout local C3 de `assets/scss/home.scss`, los dos atributos `sizes` de `includes/wine-club.php` y este informe. El resto del partial coincide con la copia inicial. No cambia la inclusión de `home-preview.php` ni se añaden archivos al producto.

Se reutilizan CSS Grid, Flexbox, mixins Bootstrap `media-breakpoint-only(lg)` y `media-breakpoint-up(md/lg/xl)`, espaciados semánticos y los patrones/componentes existentes. Se eliminan las asignaciones de áreas y offsets responsables del layout rechazado; no se duplican reglas. Se verifican sin cambios la mezcla vino de Diamond, los tamaños de letra de ambos niveles y del encabezado, el ornamento y el sistema Core. No se añade posición absoluta, `!important`, JS, dependencias o estilos globales.

Los CTA siguen siendo “Explore Diamond” y “Explore Gold”, ambos hacia `/swc.html`. La comprobación actual confirma que no existen IDs específicos de los planes; se mantienen los destinos exploratorios reales permitidos. No cambia SWC ni se trasladan precios o condiciones históricas a Home.

## QA de esta corrección

Entorno real de laboratorio: PHP 8.3.14, Chromium 149.0.7827.55, DPR 1, viewport de 1000 px de alto y reduced motion. URL: `http://127.0.0.1:8000/home-preview.php#wine-club`.

| Comprobación ejecutada | Resultado |
|---|---|
| Primera revisión artística | Capturas completas inspeccionadas a 390, 820 y 1440; membresías en secuencia, fotografía reconocible, encuadre completo y relación visible entre áreas |
| Continuidad | Renderizado y revisión junto a Private Experiences, con Pure Soul también incluido en las capturas de contexto |
| Responsive y overflow | PASS en 320, 360, 390, 425, 600, 768, 820, 992, 1024, 1280, 1440 y 2560; comprobaciones adicionales 1199/1200 |
| Sin JavaScript | PASS en los catorce anchos: mismos tamaños/orden y ambos enlaces operativos |
| Teclado/foco/targets | PASS: Private Experiences → Diamond → Gold → Footer; retorno con Shift+Tab, Enter probado para cada destino; 56 comprobaciones de foco Core de 2 px con offset 3 px, CTA ≥44 px |
| Contraste | PASS: mínimo de texto 8,12:1; CTA principal 12,69:1 y secundario 16,79:1 |
| HTML estructural | PASS: stack de etiquetas y lxml, 30 IDs únicos, H1 global único, H2/H3/ARIA, alt/dimensiones y recursos; no certificación Nu/W3C |
| Recursos/consola | PASS: fuentes fotográficas y SWC responden 200, partial directo 404 previsto; Home sin errores/warnings observados |
| CLS local | 0 atribuido a C3. Total Home 0,00015–0,05066 en el recorrido local; no datos de campo ni prueba con red móvil |
| Lint/build/PHP | PASS: `npm run lint`, `npm run build`, lint PHP de partial y anfitrión |
| Pruebas Node existentes | PASS: `scripts/probar-carrito.mjs` y `scripts/probar-cierre-comercio.mjs`; sin nueva suite ni script test declarado |
| Protección | PASS: 18 fuentes protegidas iguales a HEAD, Home Preview idéntico a la copia inicial, SCSS previo preservado y original fotográfico idéntico byte a byte |
| `git diff --check` | PASS |

Las medidas, rutas, foco, contraste y CLS anteriores se obtuvieron del navegador actual. La inspección artística detallada se hizo sobre las capturas indicadas; generar una captura o medir ausencia de overflow no equivale a aprobación estética. No se infieren pruebas de Safari/Firefox, lector de pantalla, tacto físico, zoom nativo o Apache/GoDaddy.

## Evidencia y pendientes

Capturas y resultados fuera del producto:

`C:/Users/Mike/.codex/visualizations/2026/10/28/01a18463-8b24-7d33-b497-3fbea0ac05a7/wine-club-composition/`

`review-board.png` reúne 390/820/1440; `review-{ancho}.png` contiene los doce anchos. `continuity-390.png`, `continuity-820.png` y `continuity-1440.png` muestran las secciones contiguas. `qa.json` y `structure.json` contienen la evidencia técnica; `antes/` conserva las fuentes iniciales. La primera revisión y el resultado final mantienen la misma geometría: no se identificó otro defecto que exigiera cambiar los estilos aprobados de los planes.

Pendientes reales: aprobación visual del responsable, validación de condiciones comerciales y del contenido histórico de SWC antes de producción, y comprobaciones fuera del entorno local descritas arriba. No se incorporan precios, beneficios, periodicidades o disponibilidad no confirmados. Continúa `feature/home-wine-club`, con los cambios locales conservados; sin reset, commit, push, PR, merge o deploy.

**HOME WINE CLUB COMPOSITION READY — WAITING FOR VISUAL APPROVAL**

---

## Historial: The Private Cellar · Diamond First — retícula rechazada

2026-10-28. Estado vigente: rediseño implementado y verificado localmente, pendiente de aprobación artística humana. Este apartado sustituye el dictamen anterior: **The Cellar Invitation fue rechazado artísticamente**, aunque sus pruebas técnicas pasaran. El informe original se conserva al final como historial y no describe la implementación actual.

## Dirección y jerarquía

Se implementa una sola dirección: Diamond protagoniza la elección mediante una superficie vino oscuro, borde champagne del patrón destacado, nombre Bodoni de 48–80 px y botón Core principal. La descripción conserva el alcance exploratorio autorizado: “Explore our signature Wine Club tier and discover what makes it special.” No se añaden beneficios, cantidades, precios o promesas de exclusividad.

Gold es una propuesta independiente, con H3 propio de 36 px, descripción completa y CTA secundario de al menos 44 px. Su composición abierta y la línea editorial lo distinguen de Diamond sin tratarlo como una opción deshabilitada. Cada plan reúne nombre, contexto y acción.

El encabezado centrado conserva eyebrow y ornamento existentes e introduce el H2 “Discover more of Spain, one wine at a time.” y la descripción aprobada. Su tipo se limita localmente a 40–56 px para que Diamond tenga mayor peso comercial. Membership se expresa como una segunda voz tipográfica en cursiva, sin iconos o distintivos inventados.

Los principios de referencia aplicados son asimetría, contraste de escala/superficie, información escalonada y fotografía de contexto. No había imágenes externas de Inscapes adjuntas accesibles en este mensaje; se sigue su dirección descrita por el responsable, sin afirmar una comparación visual con originales no disponibles ni copiar elementos externos.

## Retícula y adaptación

DOM único: encabezado → artículo Diamond → artículo Gold → fotografía. Dos H3 bajo el H2, artículos nombrados mediante ARIA y dos enlaces nativos. No hay tabla, selección de plan, radios, formulario, carrusel ni JavaScript añadido.

- **320–767 px:** una columna, encabezado centrado, Diamond primero y Gold inmediatamente después. Los botones permanecen dentro de cada propuesta. La foto aparece después de ambas acciones y mide como máximo 288 × 216 px. Las alturas proceden del contenido: a 390 px Diamond mide 366 × 341 px y no hay una pantalla de fotografía antes de la elección.
- **768/820 px:** Grid 7/5 con gap semántico de 24 px. Diamond ocupa la columna principal y las dos filas del conjunto; Gold comienza 32 px más abajo en la columna secundaria y su fotografía queda al pie. Diamond mide 392 × 446 px; Gold conserva 280 px de lectura y su nombre/tipo caben sin comprimirlos.
- **992/1024 px:** columnas 6/5 con separación de 48 px; Diamond mide 484 × 454 px. La cabecera de Gold pasa a una sola línea editorial y la foto acompaña al final de su columna.
- **Desktop amplio:** Diamond llega a 615 × 454 px en el contenedor máximo. La foto secundaria permanece en 224 × 168 px, alineada al extremo de la columna de Gold. La composición se escalona sin estirar la imagen ni añadir alturas fijas.

La superficie dominante pertenece al plan, a diferencia de Pure Soul, donde domina el retrato, y de Private Experiences, donde la invitación cruza la foto. Aquí se lee una elección de pertenencia, con fotografía posterior de apoyo. No se reproduce el diseño anterior con otra paleta ni se crean dos paneles equivalentes.

## Fotografía y destinos

Se conserva `assets/images/gallery/wines/the-clandestino-wines-6.jpeg` (2048 × 1536) con sus AVIF/WebP existentes. La imagen sigue aportando contexto real de vinos, copas y restaurante, pero deja de determinar el tamaño de la composición. Se mantiene íntegra mediante contain, proporción 4:3, dimensiones reservadas, carga lazy y decoding async. `sizes` se actualiza a 288 px en móvil y 224 px desde md. No se retocan originales, no se aplican filtros ni se generan imágenes o derivados.

Se vuelve a inspeccionar `swc.html`: no tiene IDs específicos de Gold o Diamond. `#plans` es común y está duplicado entre sección y H2; no se adopta como destino estable de un plan. Ambos CTA conducen a `/swc.html`, con nombres “Explore Diamond” y “Explore Gold”. Se verifica Enter para cada uno y HTTP 200. Los recorridos se distinguen por el plan presentado y su llamada a explorar, sin fingir destinos de detalle, inscripción o compra que no existen.

## Reutilización y alcance

Se reutilizan `cl-seccion`, `cl-seccion__descripcion`, `cl-seccion__acciones`, `cl-historia`, `cl-historia__imagen`, `cl-vino__imagen`, `cl-membresia`, `cl-membresia--destacada`, `cl-membresia__nombre`, `cl-membresia__enfoque` y `cl-membresia__grupo`. Core aporta botón principal/secundario, eyebrow, tipografía y foco. El ornamento es la regla existente de Home con `separator.svg`, sin copia.

La composición usa container Bootstrap, CSS Grid, Flexbox y mixins `media-breakpoint-up(md/lg)`. `color.mix($wine-700, $neutral-800, 45%)` crea solo la superficie contextual de Diamond; no cambia ningún token. Los ajustes de tamaño, padding y disposición son locales a `cl-home-club*`; `_membresia.scss` permanece intacto. No entran CSS legacy, fixtures ni demostraciones del Style Guide.

Archivos modificados en este rediseño:

1. `includes/wine-club.php`: copy, dos artículos/CTA y fotografía secundaria.
2. `assets/scss/home.scss`: sustitución exclusiva del bloque local C3; se conserva el import de membresía y todo el SCSS anterior.
3. `docs/HOME-PHASE-C3.md`: estado vigente, decisiones, QA y pendientes; historial previo preservado.

La inclusión existente de `home-preview.php` no se modifica en esta iteración. Se conserva `feature/home-wine-club` y todo el trabajo local anterior, con copia de las fuentes iniciales en la evidencia externa. No se hace reset, commit, push, PR, merge ni deploy.

## Revisión artística y correcciones

El primer render del rediseño ya mostraba dos propuestas, pero la fotografía secundaria y la cabecera de Gold alargaban la columna derecha y estiraban Diamond hasta unos 648 px en desktop, con excesivo vacío. Se corrigió ese problema concreto: fotografía de apoyo limitada a 224 × 168 px, cabecera Gold compacta desde md y proporción desktop 6/5. Diamond queda en unos 454 px de alto; el contenido conserva su tamaño cómodo y no se añade relleno artificial para ocupar el panel.

Se inspeccionan las capturas finales de 390/820/1440 y la continuidad Pure Soul → Private Experiences → C3. Diamond es el primer plan, tiene el nombre mayor, superficie propia y acción principal; Gold mantiene título/contexto/acción completos; la imagen ocupa una fracción menor del conjunto. También se inspeccionan 320, 768, 992 y 1024, sin nombres partidos ni columnas de texto comprimidas. Esta revisión del agente no concede aprobación artística en nombre del responsable.

## QA actual

Entorno: PHP 8.3.14 y Chromium 149.0.7827.55, DPR 1, viewport de 1000 px de alto y reduced motion. URL: `http://127.0.0.1:8000/home-preview.php#wine-club`. Las comprobaciones siguientes corresponden al rediseño actual, no se heredan del informe anterior.

| Punto | Resultado |
|---|---|
| 320, 360, 390, 425, 600 px | PASS: misma jerarquía, lectura natural y fotografía después de ambas acciones |
| 768, 820, 992, 1024 px | PASS: planes próximos, nombres sin partirse y acciones asociadas |
| 1280, 1440, 2560 px | PASS: Diamond dominante, Gold legible y foto secundaria |
| Sin JS | PASS: contexto con JavaScript deshabilitado en los doce anchos; mismas geometrías y dos enlaces operativos |
| Teclado y foco | PASS: Private Experiences → Diamond → Gold → Footer; Shift+Tab vuelve a Gold; 48 comprobaciones de foco en ambos modos, 2 px champagne y offset 3 px |
| Targets | PASS: ambos CTA ≥44 px en los doce anchos |
| Contraste | PASS: mínimo de texto 8,12:1 en Diamond; CTA principal 12,69:1 y secundario 16,79:1 |
| HTML y ARIA | PASS: stack de etiquetas y lxml, 30 IDs únicos, un H1 global, un H2 en C3, dos H3, artículos nombrados y recursos existentes. Validación estructural local, sin certificación Nu/W3C |
| Imágenes y overflow | PASS: fuente cargada, 4:3 íntegro, tamaños reservados y cero scroll horizontal en los dos modos |
| CLS local | 0 atribuido a Wine Club en los doce anchos. Home completa: 0,00015–0,05066 en el recorrido local; no es medición de campo ni simulación de red móvil |
| Consola y recursos | PASS: Home sin errores/warnings observados y sin recursos HTTP ≥400; las tres fuentes fotográficas y SWC responden 200; acceso directo al partial devuelve el 404 previsto |
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: Gulp/Sass/esbuild |
| PHP lint | PASS: partial y Home Preview |
| Pruebas Node existentes | PASS: `scripts/probar-carrito.mjs` y `scripts/probar-cierre-comercio.mjs`; package.json no añade ni declara un script test |
| Protección | PASS: 18 archivos protegidos idénticos a HEAD, Home Preview idéntico a la copia inicial y SCSS anterior a C3 preservado; fotografía original idéntica byte a byte |
| `git diff --check` | PASS |

No se instalan dependencias ni se modifica JavaScript, Header, Hero, Discovery, Pure Soul, Private Experiences, Footer, navegación, SWC, backend o analítica. Las fuentes compartidas de membresía, sección, botón, foco y tokens conservan sus bytes normalizados frente a HEAD.

## Capturas y verificación manual

Evidencia fuera del producto:

`C:/Users/Mike/.codex/visualizations/2026/10/28/01a18463-8b24-7d33-b497-3fbea0ac05a7/wine-club-redesign/`

- `review-board.png`: móvil 390, tablet 820 y desktop 1440; `review-{ancho}.png`: los doce anchos.
- `continuity-390.png`, `continuity-820.png`, `continuity-1440.png`: recorrido con Pure Soul y Private Experiences.
- `qa.json` y `structure.json`: medidas, contraste, foco, rutas, estructura y archivos protegidos.
- `initial/`: primer render antes de compactar el conjunto; `antes/`: fuentes conservadas al comenzar.

Abrir la URL indicada con el servidor local existente; para iniciarlo cuando no esté activo: `php -S 127.0.0.1:8000 -t .`. El build actual genera `home.css`. Revisar Diamond → Gold, sus dos CTA, el orden móvil y la continuidad de las secciones. No iniciar un segundo servidor en el mismo puerto.

## Pendientes comerciales y aceptación

Home no publica precios, periodicidades, cantidades, envíos, descuentos, popularidad ni beneficios sin confirmar. Siguen pendientes las condiciones actuales de ambos planes: precio/moneda/impuestos, cadencia de cobro frente a selección/entrega, contenido y beneficios, disponibilidad, elegibilidad, logística/costes, renovación/cancelación/reembolso y proceso real de consulta/alta. La preferencia editorial por Diamond está autorizada por este encargo y no supone evidencia de ventas o popularidad.

Antes de producción debe validarse el contenido histórico de `swc.html`, incluidos metadatos, datos estructurados, FAQ y WhatsApp; su funcionamiento como destino no confirma sus condiciones. Esa página no se modifica. No se crean checkout, pagos, suscripciones automáticas ni formularios.

Pendientes técnicos fuera del laboratorio: otros motores, dispositivos/tacto físico, zoom nativo y lector de pantalla, además del cutover y validación en Apache/GoDaddy. No se declara certificación WCAG global ni aprobación visual humana. El cambio queda disponible para revisión artística del responsable.

**HOME WINE CLUB REDESIGN — WAITING FOR VISUAL APPROVAL**

---

## Historial: The Cellar Invitation — rechazado artísticamente

El siguiente registro conserva el alcance y QA de la primera implementación. Su composición y su dictamen no son vigentes.

2026-10-28. Rama local `feature/home-wine-club`. Implementación y QA técnico terminados; aprobación visual humana pendiente. No activa servicios comerciales ni la Home pública.

## Base verificada y alcance

Árbol limpio al comenzar en `feature/home-discovery`. `git fetch origin` confirmó `63c172f`, merge del PR #19 de Discovery hacia `origin/develop`; `f2b4870` es ancestro de esa base. Se actualizó `develop` por fast-forward y se creó la rama solicitada desde `63c172f`. No se hicieron commits, push, PR, merge de la feature ni deploy.

Fuentes revisadas: AGENTS, estándares, Git Workflow, arquitectura, dirección visual, UX/UI, biblioteca de patrones, auditoría final del Design System, mapa del sitio, inventario legacy e informes aprobados de Home A, B, C1, C2 y Discovery. Se inspeccionaron Home Preview, sus includes, `home.scss`, patrones de sección/membresía/historia/vino/CTA, Foundation, tokens, funciones Sass y mixins Bootstrap. Las advertencias históricas de los informes no se toman como condiciones comerciales vigentes ni pruebas actuales.

Contraste con `production-baseline`: no existe Home Preview en esa referencia. La Home histórica presenta el club en `#special`, con imagen `swc.jpeg` y CTA a `swc.html`; sus promesas de periodicidad, privilegios y disponibilidad no se trasladan. La navegación compartida, el Hero y el Footer actuales apuntan a `/swc.html`; no hay un destino previo `#wine-club` en el anfitrión. Se adopta `wine-club`, coherente con `spanish-wines` y `private-events`, sin cambiar rutas ni navegación.

## Invitación y composición

Una única superficie cálida reúne identidad, fotografía y acceso a las membresías. El eyebrow usa el texto aprobado, con mayúsculas mediante CSS. El H2 conserva exactamente “A little more Spain, in every discovery.” y la descripción solicitada, sin saltos manuales. Libre Bodoni aporta la voz editorial; el cuerpo usa Foundation.

La pertenencia se expresa como una invitación a seguir descubriendo el vino español: un lugar propio dentro del club, dos nombres reconocibles y una acción para informarse. No se presenta como una compra individual ni se atribuyen prestaciones no confirmadas.

Desktop desde `lg`: la cabecera comparte las dos columnas inferiores mediante subgrid; título y fotografía se alinean a la izquierda, descripción e invitación a la derecha. La foto 4:3 completa domina la zona inferior. No hay paneles superpuestos, marcos desplazados, carrusel ni tarjetas de precios.

Tablet `md`: cabecera centrada a todo el ancho, seguida de fotografía e invitación en columnas cómodas 7/5. En 768/820 la imagen mide 387 × 290 px; el nombre Diamond permanece en una línea. Desde 992/1024 cambia a 7/4, con imagen de 555 × 416 px. La acción permanece junto a sus nombres y contexto.

Móvil: eyebrow, H2 y descripción centrados; después fotografía completa, Gold/Diamond en una fila y CTA próximo. Las columnas 2/3 conceden a Diamond la anchura que requiere su nombre. No se reduce su tipografía para hacerlo caber, ni se fijan alturas de texto o de sección. La proporción fotográfica reserva espacio sin recortar el contenido.

Gold y Diamond son H3 dentro de una lista semántica de niveles. Se reutilizan los nombres y líneas de `cl-membresia`, sin radios, selección, precios, comparativa, badges o acciones por plan. Un único enlace Core “Explore the Wine Club” abre `/swc.html`; no confirma ninguna inscripción.

La composición se diferencia de Pure Soul mediante la cabecera horizontal y la fotografía de selección amplia, sin retrato ni marco. Se diferencia de Private Experiences al mantener todo en flujo sin panel sobre foto. Se diferencia de Discovery al reunir una sola imagen con los dos niveles, sin mosaico ni botánicos. Reutiliza moderadamente el ornamento champagne de Discovery: misma regla existente y mismo `separator.svg`, sin copia de estilos ni archivo SVG adicional.

## Fotografía

Recurso: `assets/images/gallery/wines/the-clandestino-wines-6.jpeg`, 2048 × 1536, 550647 bytes. La selección se hizo tras revisar recursos SWC, Gold/Diamond y galería de vinos. La imagen muestra botellas tintas y blancas sobre la barra de madera, copas al lado y el ambiente del local; aporta variedad y contexto de descubrimiento sin recurrir a personas identificables. No es la imagen protagonista de Discovery ni de Pure Soul.

Se conservan los originales y se usan los derivados existentes: AVIF 229994 bytes y WebP 286810 bytes, con JPEG de respaldo. No se genera ningún derivado. Los dos `srcset` declaran el ancho existente 2048w y `sizes` reproduce las anchuras reales de la retícula. Solo existe un tamaño por formato: no se atribuye selección entre resoluciones que no están disponibles. El AVIF evita transferir el JPEG original en el navegador comprobado.

`width`/`height`, proporción 4:3, `object-fit: contain`, `loading="lazy"` y `decoding="async"` conservan el encuadre y reservan el espacio. El alt describe botellas, barra y copas. La fotografía documenta una selección del restaurante; no representa una cantidad, entrega o contenido garantizado de una membresía.

Sustitución artística futura ideal: fotografía horizontal 4:3 de una selección representativa preparada para compartir, con botellas y dos copas completas, luz cálida controlada y menos objetos de barra. Conservar márgenes en bordes y evitar reclamos comerciales impresos. La fotografía actual permite completar y revisar esta implementación.

## Reutilización y archivos

- `cl-seccion`, `container`, `cl-seccion__descripcion` y `cl-seccion__acciones`: ritmo, retícula y acción contextual.
- `cl-historia` / `cl-historia__imagen`: narrativa, media fluida y radio Foundation.
- `cl-vino__imagen`: conservación íntegra mediante contain; ajuste local de proporción y padding.
- `cl-membresia__grupo` / `cl-membresia__nombre`: líneas y jerarquía de niveles. Se importa el patrón real en la entrada Home, sin copiar lógica ni el partial demostrativo.
- `cl-eyebrow`, `cl-display`, `cl-boton` y foco Foundation: tipografía, acción y accesibilidad existentes.
- Mixins Bootstrap `media-breakpoint-up(md/lg)`, Grid/subgrid, Flexbox de acciones, `minmax`, variables semánticas y `color.mix` de Sass para una mezcla local de champagne del 3 % sobre neutral-800. No cambian tokens.

Archivos del cambio:

1. `includes/wine-club.php`: nuevo partial estático, sección nombrada y guard de acceso directo 404.
2. `home-preview.php`: una única inclusión después de Private Experiences y antes del Footer.
3. `assets/scss/home.scss`: import del patrón membresía y estilos locales `cl-home-club*` añadidos al final.
4. `docs/HOME-PHASE-C3.md`: este informe y sus pendientes.

Mapeo respecto al legacy: `special-dish` → `cl-seccion cl-historia cl-home-club`; `special-dish-banner` → `cl-home-club__seleccion`; `special-dish-content` → cabecera e invitación en la misma retícula; `btn-primary` → `cl-boton`. No se conserva ninguna clase legacy ni se modifica el original.

No hay JavaScript nuevo, dependencias, fixtures, imports de guía, CSS legacy, datos personales, backend, pagos, cuentas o suscripciones. La vista conserva su guard `cli-server`, `noindex` y salida local; el partial usa PHP nativo compatible con el destino tradicional, pero este trabajo no efectúa el cutover a Apache/GoDaddy.

## Defectos encontrados y corregidos

- El primer render usaba spans para los niveles: se sustituyeron por H3 del patrón, recuperando su tipografía Bodoni y una jerarquía semántica explícita.
- A 320 px dos columnas iguales partían Diamond. Se corrigió únicamente la proporción móvil a 2/3; ambos nombres mantienen 36 px y una sola línea en todos los anchos probados.
- Stylelint pidió `place-items` al combinar las dos propiedades de alineación; corregido antes del cierre.
- El capturador de página recortaba la parte inferior de secciones largas fuera del viewport. Las capturas de revisión se ensamblan desde vistas nativas consecutivas, sin modificar el diseño ni sus dimensiones; se inspeccionan completas. Este era un defecto de evidencia, no un recorte del contenido del navegador.

## QA ejecutado

URL: `http://127.0.0.1:8000/home-preview.php#wine-club`. Servidor PHP 8.3.14 local, Chromium 149.0.7827.55, DPR 1, alto de viewport 1000 px y reduced motion. Primera inspección visual a 390, 820 y 1440; después comprobación de los doce anchos, incluyendo 768/820/992/1024.

| Ancho | Fotografía (px) | Altura de sección (px) | Con/sin JS, overflow y niveles |
|---|---|---|---|
| 320 | 296 × 222 | 958,8 | PASS |
| 360 | 336 × 252 | 960,0 | PASS |
| 390 | 366 × 274,5 | 940,5 | PASS |
| 425 | 401 × 300,8 | 966,7 | PASS |
| 600 | 516 × 387 | 1028,3 | PASS |
| 768 | 387,3 × 290,5 | 728,5 | PASS |
| 820 | 387,3 × 290,5 | 731,8 | PASS |
| 992 | 554,9 × 416,2 | 773,9 | PASS |
| 1024 | 554,9 × 416,2 | 775,9 | PASS |
| 1280 | 669,5 × 502,1 | 877,9 | PASS |
| 1440 | 707,6 × 530,7 | 916,6 | PASS |
| 2560 | 707,6 × 530,7 | 926,7 | PASS |

| Comprobación | Resultado actual |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint, sin avisos finales |
| `npm run build` | PASS: Gulp, Sass, esbuild; no instalaciones |
| PHP lint | PASS: Home Preview y nuevo partial |
| Pruebas existentes | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`. `package.json` no declara script test; no se presenta como una suite adicional |
| HTML estructural | PASS: stack estricto de etiquetas y parseo lxml, 28 IDs únicos, un H1, H2/H3 correctos, referencias ARIA resueltas, alt/dimensiones/srcsets y un CTA. No equivale a certificación Nu/W3C |
| Orden DOM | PASS: cabecera → foto → niveles/contexto → enlace |
| Teclado | PASS: Pure Soul → Private Experiences → Wine Club → Footer; retorno con Shift+Tab y Enter abre `/swc.html` |
| Foco y target | PASS: foco Core champagne sólido de 2 px, offset 3 px; CTA ≥44 px de alto en los doce anchos |
| Contraste renderizado | PASS: cuerpo 9,14:1; H2 13,46:1; niveles/eyebrow 10,90:1; CTA 12,69:1 |
| Fotos y responsive | PASS: fuente cargada, 4:3 íntegro, sin distorsión, overflow ni nombres partidos |
| Sin JavaScript | PASS: contexto del navegador con JavaScript deshabilitado en los doce anchos; misma geometría, imagen y acción nativa |
| Consola/recursos | PASS: sin errores ni warnings observados en Home, sin HTTP ≥400; AVIF/WebP/JPEG y SWC responden 200, partial directo 404 deliberado |
| CLS local | 0 atribuido a Wine Club en las doce medidas; total de Home entre 0,00015 y 0,05066. Incluye carga de fuentes y recorrido por las secciones, sin simular red móvil. No es medición de campo |
| Protección | PASS: 16 archivos protegidos idénticos a HEAD al normalizar CRLF; original fotográfico idéntico byte a byte. SCSS previo idéntico salvo import y anfitrión idéntico salvo una inclusión |
| `git diff --check` | PASS |

Las pruebas de estructura comprueban rutas reales y ausencia de formularios, controles de selección, scripts y precios en el nuevo partial. Header, Hero, Discovery, Pure Soul, Private Experiences, Footer, index, SWC, tokens, patrones compartidos, JS, package y lockfile conservan sus fuentes.

## Capturas y reproducción

Evidencia externa al producto:

`C:/Users/Mike/.codex/visualizations/2026/10/28/01a18463-8b24-7d33-b497-3fbea0ac05a7/wine-club/`

- `review-board.png`: móvil 390, tablet 820 y desktop 1440.
- `review-{ancho}.png`: las doce capturas completas de revisión.
- `continuity-390.png`, `continuity-820.png`, `continuity-1440.png`: Pure Soul → Private Experiences → Wine Club.
- `qa.json`, `structure.json`: medidas, contraste, teclado, estado de recursos y protección.
- Scripts de laboratorio y HTML renderizado permanecen fuera del repositorio.

Para revisar: iniciar `php -S 127.0.0.1:8000 -t .` desde el proyecto y abrir la URL indicada con el build actual. Si ese servidor ya está abierto, reutilizarlo. Alternativa habitual: `npm run dev` con puertos 8000/3000 libres y URL `http://localhost:3000/home-preview.php#wine-club`. Revisar lectura, encuadre, membresías, foco y continuidad a los anchos indicados; el responsable decide la aprobación visual final.

## Pendientes antes de producción

La información histórica de `swc.html` presenta Gold $99 y Diamond $149 como importes trimestrales, mientras otros antecedentes usan condiciones distintas. No hay una política comercial vigente validada en este encargo. Home omite precios, cobro, cantidades, envíos, descuentos, exclusividad, disponibilidad, popularidad y ofertas.

Antes de publicar deben aprobarse precios/moneda/impuestos, periodicidad de cobro frente a selección o entrega, cantidades y contenido, beneficios de cada nivel, disponibilidad y elegibilidad, entrega/recogida y costes, renovación/cancelación/reembolso, y canal real de consulta/alta. Debe revisarse también el destino legacy `swc.html`, incluidos metadatos, datos estructurados, FAQ y mensajes WhatsApp: el enlace funciona, pero este trabajo no valida ni corrige sus afirmaciones históricas. La fotografía no garantiza los vinos mostrados ni una selección concreta de Gold o Diamond.

Pendientes de validación técnica más allá del laboratorio: otros motores y dispositivos físicos, zoom nativo y preferencias tipográficas, lector de pantalla y hosting Apache/GoDaddy. No se afirma auditoría WCAG integral, métricas de usuarios reales ni integración comercial. No quedan defectos visuales o funcionales bloqueantes conocidos dentro del entorno y alcance comprobados; el render correcto no sustituye la aprobación artística del responsable.

**HOME WINE CLUB READY — WAITING FOR VISUAL APPROVAL**
