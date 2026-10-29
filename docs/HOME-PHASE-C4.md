# Home C4 — Hampers & Gift Cards

## Cierre técnico — aprobación visual y preparación de PR

2026-10-28. **The Gifting Atelier está APROBADA visualmente por el responsable**, incluidas la composición móvil, tablet 7/6, fotografía desktop 4:3 y Gift Cards horizontal debajo. Se congelan copy, fotografía, ornamento, paleta, botones y geometría aprobados. Este cierre no modifica fuentes de producto: únicamente registra la aprobación y repite la auditoría técnica.

### Alcance final

| Archivo | Integración |
|---|---|
| `includes/gifting.php` | Partial PHP nativo protegido contra acceso directo, sección semántica, dos invitaciones y destinos reales |
| `home-preview.php` | Una inclusión después de Spanish Wine Club |
| `assets/scss/home.scss` | Bloque BEM local `cl-home-regalos`, sin modificar reglas anteriores |
| `docs/HOME-PHASE-C4.md` | Decisiones, aprobación, QA, evidencia y pendientes comerciales |

`origin/develop` actualizado apunta a `3140b17`, la base exacta de `feature/home-gifts` antes del commit C4. La referencia local `develop` estaba atrasada; se utiliza la base remota vigente para auditar el futuro PR sin modificar esa rama. El diff completo de C4 contiene exclusivamente estos cuatro archivos: sin capturas, temporales, fixtures, secretos, outputs compilados ni cambios ajenos. Header/Hero, Discovery, Pure Soul, Private Experiences, Wine Club, Footer e `index.html` permanecen intactos. El anfitrión conserva su protección local y no se publica la Home pública.

### Auditoría de arquitectura

PHP simple, sin framework, entrada externa ni interpolaciones dinámicas nuevas: el copy y los href son literales, con entidades HTML donde corresponde; no hay datos sin escapar. El guard del partial devuelve 404 cuando se solicita directamente. La estructura mantiene un H2 y dos H3, encabezado, artículos, figura y caption. No añade backend comercial, formularios, scripts ni dependencias.

Se reutilizan Foundation/Core, Bootstrap 5.3, contenedor, botones/foco, tokens, `color.mix`, mixins Sass y retícula CSS mobile first. Las mejoras locales se activan desde `md`; no cambian patrones globales. Ambas imágenes WebP existentes tienen dimensiones reservadas, carga lazy y decoding async; Gift Cards usa contain. Los originales permanecen intactos. El arte oficial de 308594 bytes conserva como mejora futura documentada disponer de variantes menores, sin bloquear el alcance aprobado. La solución no exige procesos persistentes ni servicios adicionales para Apache/PHP/cPanel; **el hosting no se probó** y la preview permanece limitada deliberadamente al servidor PHP local.

### QA de cierre ejecutado

Entorno: PHP 8.3.14 y Chrome 156.0.8078.48 local, DPR 1, reduced motion; URL `http://127.0.0.1:8000/home-preview.php#gifting`. Se ejecutan nuevamente las herramientas disponibles, sin atribuir pruebas a otros motores, dispositivos físicos o hosting.

| Comprobación | Resultado del cierre |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: Gulp, Sass y esbuild; outputs existentes ignorados por Git |
| PHP lint | PASS: `includes/gifting.php` y `home-preview.php` |
| Pruebas Node existentes | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`; no existe script npm `test` |
| HTML estructural renderizado | PASS: stack de etiquetas cerrado, un H1, IDs únicos, ARIA resuelto e imágenes con alt. No equivale a certificación Nu/W3C |
| Geometría y regresión visual | PASS en 320/360/390/425/768/820/992/1024/1199/1200/1280/1440/2560: cajas, alturas y píxeles idénticos a la versión aprobada |
| Overflow / imágenes | PASS en los trece anchos, sin elementos cortados ni imágenes sin cargar |
| Teclado / foco | PASS: Wine Club → Hampers → Gift Cards → Footer; Shift+Tab y Enter comprobados; foco Core 2 px/offset 3 px y acciones ≥44 px |
| Contraste | PASS: mínimo de texto/CTA 8,47:1 sobre sus superficies; no se mide el lettering incrustado en el arte como texto HTML |
| Destinos y recursos | PASS: preview, `/hampers.html`, `/contact.html`, ambas imágenes 200; ancla de formulario existente; partial directo 404 deliberado |
| Sin JavaScript | PASS: trece anchos, misma geometría, dos enlaces nativos e imágenes cargadas |
| CLS local | 0 atribuido a C4 en las doce medidas solicitadas; total Home entre 0,000148 y 0,050656. Sin simulación de red móvil ni métricas de campo |
| Consola de Home | PASS: sin errores/warnings/recursos HTTP ≥400 durante las capturas de Home |
| Aviso legacy | Persiste una petición secundaria a `/favicon.ico` con 404 al abrir Hampers legacy; el destino y las imágenes cargan. No bloquea C4 ni se modifica fuera de alcance |
| Protección / diff | PASS: ninguna fuente de producto cambió durante el cierre; SCSS anterior idéntico a `origin/develop`, anfitrión idéntico salvo el nuevo require; `git diff --check` PASS |

Evidencia fresca fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/10/29/01a1858f-4ee6-7380-88c2-8c76d081847c/gifting-close/`. Incluye capturas y métricas aprobadas en `before/`, capturas actuales en `after/`, `verification.json`, `structure.json`, `audit.json`, comparación móvil y hashes. Reproducción: `npm run build`, reutilizar el servidor local o iniciar `php -S 127.0.0.1:8000 -t .`, abrir la URL y revisar los anchos de la tabla.

### Pendientes comerciales y publicación de rama

- Hampers: confirmar condiciones, disponibilidad, contenido, precios/impuestos y canal real de pedido.
- Gift Cards: confirmar oferta, disponibilidad, importes, proveedor, emisión, cobro, presentación/entrega, vigencia, restricciones y redención/reembolsos.
- Destinos: mantener revisión de las afirmaciones comerciales legacy y validar la recepción real de consultas. Se comprobaron enlaces y navegación; no se enviaron formularios o mensajes ni se validó recepción operativa.

La aprobación visual no declara compras, entregas o reservas confirmadas ni activa los servicios anteriores. El trabajo se prepara para un commit atómico `feat(home): integrar Hampers y Gift Cards` y push normal de `feature/home-gifts`, con `develop` como destino del futuro PR. No se crea PR, no se realiza merge/deploy y no se modifica `main`. El SHA y el estado remoto se verifican tras publicar la rama.

**HOME C4 READY FOR PR**

---

## Historial — refinamiento editorial de tablet y desktop

2026-10-28. El responsable aprobó el concepto, móvil, fotografía, copy, ornamento champagne, colores y diseño Gift Cards. Este ajuste modifica únicamente el layout local de C4 desde `md`; la disposición refinada de tablet/desktop espera aprobación visual humana. Los apartados posteriores a «Historial» describen la implementación anterior.

### Defectos observados antes de editar

- A 768/820 px, el retrato medía 357,5 × 476,7 px frente a un relato de unos 277 px de alto. El centrado de Grid tomaba como referencia fotografía más caption: el relato quedaba 21,3 px por debajo del centro de la fotografía y el conjunto tenía aire excesivo arriba y abajo.
- Desde `xl`, `"foto relato" "foto tarjeta"` extendía la imagen junto a las dos invitaciones. El relato quedaba cerca del borde superior, mientras Gift Cards cambiaba a una pieza vertical lateral. A 1440 px, el centro del relato estaba unos 198 px por encima del centro de la foto; no formaban una única invitación lateral equilibrada.

Se revisaron `gifting.php`, el anfitrión, reglas C4, patrones Sección/Media/Regalo, Foundation/Core y dirección visual. Se capturó el estado anterior en trece anchos antes de editar. Se preservaron los cuatro archivos locales pendientes y se renombró la rama existente `feature/home-gifting` a la solicitada `feature/home-gifts`, conservando HEAD y contenido. Sin commit, push, PR, merge ni deploy.

### Corrección exacta

- Se conserva desde `md` una única retícula asimétrica 7/6: fotografía y relato arriba, Gift Cards horizontal debajo ocupando ambas columnas. Se elimina la variante lateral de `xl`.
- El umbral lateral permanece en 768 px: sus 696 px útiles admiten fotografía de 357,5 px, gutter de 32 px y relato de 306,5 px. El contenedor inferior de 516 px no permite esos anchos de lectura. El breakpoint se mantiene por esa capacidad real, no por cambiar de dispositivo nominal.
- Foto cuadrada en `md`, 4:3 desde `lg`, sin alturas rígidas ni flex que la estire a través de dos invitaciones. El archivo y el foco `center 48%` se mantienen; cambian únicamente las ventanas de recorte de tablet/desktop. El recorte móvil no cambia.
- Desde `lg`, el gutter horizontal usa `--espacio-7` (48 px). El ancho de lectura queda limitado localmente a 16ch para el titular y 42ch para la descripción, sin cambiar tipografía, tamaño ni copy.
- El relato conserva `align-self: center` y recibe únicamente desde `md` un margen inferior de `--espacio-6` (32 px) para compensar ópticamente el caption vecino. Los cuatro elementos del relato se desplazan juntos; la distancia descripción/CTA sigue siendo la de Core (24 px). El centro del grupo queda a unos 5,3 px del centro de la foto en todos los anchos laterales.
- Gift Cards conserva arte, color, borde, tipografía, padding y disposición horizontal de tablet, ahora también en desktop. Se elimina su override vertical de `xl` y se explicita `object-fit: contain`; el frontal completo mantiene su proporción. En móvil este cambio de fit no altera el render, ya que la altura de la imagen continúa siendo automática.

La revisión visual antes/después comprueba el grupo editorial completo, CTA próximo, lectura lateral y jerarquía entre ambas propuestas. La reducción de altura de la fotografía tablet retira espacio residual; en desktop, el traslado de Gift Cards debajo permite centrar el relato respecto a una única foto. La altura desktop aumenta ligeramente porque la alternativa comercial pasa a una banda inferior; no se presenta como una reducción general de scroll.

### Responsive y protección móvil

| Ancho | Foto final (px) | Altura C4 antes → después (px) | Resultado |
|---|---|---|---|
| 320 | 296 × 222 | 1412,4 → 1412,4 | PASS: geometría y píxeles idénticos |
| 360 | 336 × 252 | 1405,6 → 1405,6 | PASS: geometría y píxeles idénticos |
| 390 | 366 × 274,5 | 1428,1 → 1428,1 | PASS: geometría y píxeles idénticos |
| 425 | 401 × 300,8 | 1425,5 → 1425,5 | PASS: geometría y píxeles idénticos |
| 768 | 357,5 × 357,5 | 1096,2 → 977,0 | PASS |
| 820 | 357,5 × 357,5 | 1097,3 → 978,1 | PASS |
| 992 | 478,1 × 358,6 | 1143,5 → 1015,3 | PASS |
| 1024 | 478,1 × 358,6 | 1144,1 → 1016,0 | PASS |
| 1199 | 478,1 × 358,6 | 1147,8 → 1019,6 | PASS |
| 1200 | 575,1 × 431,3 | 1030,8 → 1092,4 | PASS |
| 1280 | 575,1 × 431,3 | 1032,4 → 1094,0 | PASS |
| 1440 | 607,4 × 455,5 | 1070,0 → 1120,8 | PASS |
| 2560 | 607,4 × 455,5 | 1070,0 → 1120,8 | PASS |

Las cuatro verificaciones móviles comparan las cajas de **todos** los descendientes de C4, la altura de sección y la diferencia de píxeles entre capturas frescas: cero diferencia. Conservan encabezado centrado, ornamento, fotografía/encuadre, caption, relato/CTA y Gift Card, con tamaños, espaciados y jerarquía intactos.

### QA ejecutado sobre el refinamiento

URL: `http://127.0.0.1:8000/home-preview.php#gifting`. PHP 8.3.14, Chrome 156.0.8078.48, DPR 1 y reduced motion. Viewports de layout de 1000 px de alto; capturas de sección con altura ampliada para evitar que la cabecera sticky tape el encabezado. Sin instalaciones ni scripts nuevos de producto.

| Comprobación | Resultado |
|---|---|
| `npm run lint` | PASS final: ESLint/Stylelint; corregida una línea vacía requerida por Stylelint antes del comentario local |
| `npm run build` | PASS final: Gulp/Sass/esbuild |
| PHP lint | PASS: `includes/gifting.php` y `home-preview.php` |
| Pruebas Node existentes | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`, declaradas en la documentación vigente. `package.json` no declara `test`; no se añade suite |
| HTML estructural renderizado | PASS: stack de etiquetas cerrado, un H1, IDs únicos, referencias ARIA resueltas, imágenes con alt; C4 conserva H2 y dos H3. No equivale a validación Nu/W3C |
| Teclado / foco / destinos | PASS: Wine Club → Hampers → Gift Cards → marca Footer; Shift+Tab y Enter comprobados. Foco Core visible de 2 px con offset de 3 px tras estabilizar el render; targets ≥44 px |
| Contraste | PASS: texto y CTA, mínimo 8,47:1; colores intactos. No se evalúa como texto HTML el lettering incrustado en el arte oficial |
| Responsive / overflow / imágenes | PASS en los trece anchos: sin overflow, texto cortado o imágenes sin cargar; arte Gift Card íntegro |
| Sin JavaScript | PASS en los trece anchos: mismas alturas de C4, dos enlaces nativos, imágenes cargadas y sin overflow |
| CLS local | PASS: 0 atribuido a C4 en las doce medidas solicitadas, en contextos nuevos de 1000 px de alto, cargando fuentes y recorriendo secciones. Total Home entre 0,000148 y 0,050656. No son métricas de campo ni red móvil simulada |
| Consola Home | PASS: sin errores/warnings/HTTP ≥400 en la captura de Home de los trece anchos |
| Navegación legacy | AVISO no bloqueante para este layout: `/hampers.html` abre correctamente, pero Chrome solicita además `/favicon.ico` y recibe 404. Reproducido en comprobación aislada; no aparece en Home ni altera las imágenes de C4. Se documenta sin cambiar la página pública |
| Continuidad Wine Club → Gifting → Footer | PASS: inspección visual de capturas a 390/820/1440; fuentes y componentes vecinos intactos |
| Alcance | PASS: hashes de 980 archivos comparados con el inicio; solo cambian adicionalmente `assets/scss/home.scss` y este informe. `gifting.php`, `home-preview.php` y todos los cambios locales previos se preservan |
| `git diff --check` | PASS |

Pendientes: aprobación visual del refinamiento; condiciones comerciales ya enumeradas en el historial; favicon secundario del destino legacy para una tarea propia. Se mantienen los límites del laboratorio: otros motores, dispositivos físicos, lector de pantalla, zoom nativo, métricas de campo y hosting Apache/GoDaddy no se certifican aquí.

### Capturas antes/después y reproducción

Evidencia fuera del repositorio:

`C:/Users/Mike/.codex/visualizations/2026/10/29/01a1858f-4ee6-7380-88c2-8c76d081847c/gifting-refinement/`

- `comparison-390.png`, `comparison-768.png`, `comparison-820.png`, `comparison-1024.png`, `comparison-1440.png`: pares antes/después inspeccionados.
- `before/gifting-{ancho}.png` y `after/gifting-{ancho}.png`: capturas completas de los trece anchos; los pares móviles conservan píxeles idénticos.
- `before/continuity-{ancho}.png` y `after/continuity-{ancho}.png`: contexto 390/820/1440.
- `before/metrics.json`, `after/metrics.json`, `mobile-comparison.json`, `verification.json`, `structure.json`, `protection.json`, `focus.json`, `navigation-issues.json`: medidas y resultados reales. `focus-hampers.png` y `focus-gift.png` muestran los anillos renderizados.
- Copias iniciales, hashes, HTML renderizado y scripts de laboratorio permanecen fuera del producto.

Reproducir con `npm run build`, reutilizar el servidor PHP en 8000 o iniciar `php -S 127.0.0.1:8000 -t .`, y abrir la URL indicada. Esta fase solo afecta a `home.scss` y este informe; el estado Git previo de la primera implementación continúa sin commit.

**HOME C4 EDITORIAL REFINEMENT — WAITING FOR VISUAL APPROVAL**

---

## Historial — implementación inicial, anterior al refinamiento

2026-10-28. Implementación local de **The Gifting Atelier**, pendiente de aprobación visual humana. Integrada después de Spanish Wine Club exclusivamente en `home-preview.php`; no activa servicios comerciales.

## Decisión editorial

Hampers protagoniza la sección con una fotografía auténtica, un relato breve y su CTA. Gift Cards acompaña sobre una superficie vino, con arte oficial, contexto y consulta propios. El encabezado conserva el eyebrow ornamentado aprobado, Libre Bodoni, champagne y el ritmo Foundation. Los botones, foco y contenedor pertenecen a Core/Bootstrap; no se crean componentes globales.

- Móvil: encabezado → fotografía y firma → relato/CTA de Hampers → Gift Card/consulta. Todo el texto y las acciones quedan centrados. Fotografía 4:3 para contener el recorrido; sin alturas rígidas.
- Tablet `md`: foto 3:4 y relato en columnas 7/6; Gift Cards ocupa una banda inferior con arte y contenido laterales. La imagen conserva presencia propia.
- Tablet `lg`: fotografía cuadrada para evitar un retrato de casi 650 px de alto y espacio residual junto al relato.
- Desktop `xl`: retícula editorial 7/5, fotografía a la izquierda abarcando las dos áreas derechas: Hampers arriba y Gift Cards debajo. El contenedor Bootstrap limita el ancho en pantallas grandes; las piezas no se convierten en tarjetas equivalentes.

La firma “Selected with care. Given with love.” es copy editorial, no un testimonio. La fotografía ilustra la propuesta; no confirma el contenido de una cesta disponible.

## Inspección de assets

Se revisaron visualmente las 13 fotografías `assets/images/hampers/basket-01.webp` a `basket-13.webp`, el fondo `bg/hampers.jpg` y el frontal oficial de Gift Card. Se inventariaron también los reversos con importes; se excluyen para no sugerir denominaciones comerciales validadas.

| Recurso elegido | Dimensiones / peso | Motivo |
|---|---|---|
| `hampers/basket-05.webp` | 1536 × 2048 / 107668 bytes | Madera, flores rojas, vino y delicatessen coherentes con la paleta cálida. Ofrece una escena distinta de `basket-01`, ya usado en Discovery |
| `gift-cards/gift-card.webp` | 3137 × 2030 / 308594 bytes | Arte oficial, sin importe ni reverso. Proporción completa, sin deformación |

No se modifican originales ni se generan nuevos assets de producto. Ambas imágenes reservan dimensiones y usan `loading="lazy"` y `decoding="async"`; unos 407 KiB de archivos existentes en total, fuera del primer viewport. No hay JavaScript, fuentes ni dependencias nuevas.

El hamper usa `object-fit: cover`: el recorte móvil muestra un detalle gastronómico y el retrato tablet conserva el conjunto vertical; desktop usa una ventana cuadrada. No se presenta como fotografía íntegra de catálogo. Reemplazo futuro recomendado: fotografía editorial propia de un hamper completo, con luz cálida controlada y composición que admita recortes horizontal y vertical sin cortar las botellas. Preparar también variantes optimizadas del frontal Gift Card para sus 200–240 px de presentación, previa autorización de nuevos derivados.

## Destinos y límites comerciales

- **Explore Hampers** → `/hampers.html`, página real existente, comprobada con HTTP 200 y navegación mediante Enter.
- **Ask About Gift Cards** → `/contact.html#contact-form`, sección real de contacto, comprobada con HTTP 200 y navegación mediante Enter. Invita a consultar; no confirma compra, emisión o disponibilidad.
- No se añaden importes, checkout, formularios, selección de producto, promesas de entrega o condiciones de redención.

Antes de producción: confirmar oferta y disponibilidad actuales de hampers, contenido/precios/impuestos, personalización y canal de pedido; Gift Cards necesita confirmación de disponibilidad, importes, proveedor, cobro/emisión, presentación/entrega, redención, vigencia, restricciones y reembolsos. Validar operativamente la recepción de consultas. No se enviaron mensajes ni formularios durante QA. El funcionamiento del enlace no valida las afirmaciones históricas ni los servicios de las páginas legacy.

## Alcance y protección

Archivos de producto/documentación: `includes/gifting.php` nuevo, una inclusión en `home-preview.php`, bloque BEM local `cl-home-regalos` añadido al final de `assets/scss/home.scss` e informe `docs/HOME-PHASE-C4.md`. `home.css` se regenera mediante el pipeline existente y permanece ignorado por Git.

Se contrastó `production-baseline:index.html`: Hampers utilizaba la tarjeta de servicios con `basket-01` y enlace a `hampers.html`; no había un flujo Gift Card equivalente. Se conserva ese destino real sin copiar su composición. `index.html` permanece intacto.

El SCSS anterior coincide con HEAD al normalizar CRLF; la única diferencia del anfitrión es el nuevo require. Los partials de Header/Hero, Discovery, Pure Soul, Private Experiences, Spanish Wine Club y Footer, tokens, patrones compartidos, assets, JS y dependencias permanecen intactos. No hay commit, push ni publicación en esta fase.

## QA real

URL: `http://127.0.0.1:8000/home-preview.php#gifting`. PHP 8.3.14, Google Chrome 156.0.8078.48 mediante Playwright del runtime disponible, DPR 1, viewport de prueba de 1100 px de alto y reduced motion. No se instalaron herramientas. Se inspeccionaron capturas completas; para capturar sin que el header sticky cubra el encabezado se amplía únicamente la altura del viewport. El ancho y la composición permanecen iguales.

| Ancho | Fotografía (px) | Altura de sección (px) | Layout / overflow / texto / imágenes |
|---|---|---|---|
| 320 | 296 × 222 | 1412,4 | PASS |
| 390 | 366 × 274,5 | 1428,1 | PASS |
| 425 | 401 × 300,8 | 1425,5 | PASS |
| 768 | 357,5 × 476,7 | 1096,2 | PASS |
| 820 | 357,5 × 476,7 | 1097,3 | PASS |
| 992 | 486,8 × 486,8 | 1143,5 | PASS |
| 1024 | 486,8 × 486,8 | 1144,1 | PASS |
| 1199 | 486,8 × 486,8 | 1147,8 | PASS |
| 1200 | 623 × 623 | 1030,8 | PASS |
| 1280 | 623 × 623 | 1032,4 | PASS |
| 1440 | 658 × 658 | 1070,0 | PASS |
| 2560 | 658 × 658 | 1070,0 | PASS |

| Comprobación | Resultado |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: Gulp, Sass, esbuild |
| `php -l includes/gifting.php` / `php -l home-preview.php` | PASS |
| `git diff --check` | PASS |
| Teclado | PASS: último CTA de Wine Club → Hampers → Gift Cards → marca del Footer; Shift+Tab vuelve; Enter abre ambos destinos |
| Foco y targets | PASS: foco visible Core y acciones de al menos 44 px de alto en todos los anchos |
| Contraste de texto renderizado | PASS: mínimo 8,47:1 sobre las superficies reales, incluidos ambos CTA. No es medición del texto incrustado en el arte oficial |
| Texto móvil | PASS: todos los textos y enlaces nuevos computan `text-align: center` |
| Semántica | PASS: un H1 en Home, H2 de sección y dos H3; IDs únicos, referencias `aria-labelledby` resueltas; alt y dimensiones en ambas imágenes |
| Sin JavaScript | PASS en los diez anchos solicitados: misma altura, dos enlaces nativos y sin overflow |
| Texto ampliado | PASS: cuerpo al 200% a 320 px, sin overflow ni cajas que corten texto. No equivale a zoom nativo integral |
| Consola y recursos | PASS: sin errores/warnings observados en Home ni en la navegación comprobada; imágenes y destinos responden 200. Acceso directo al partial devuelve 404 deliberadamente |
| Protección del alcance | PASS: fuentes anteriores intactas; solo los cuatro archivos declarados |

No quedan defectos bloqueantes conocidos en el entorno comprobado. Pendientes fuera de este laboratorio: otros motores/dispositivos físicos, lector de pantalla, zoom nativo, métricas de campo y hosting Apache/GoDaddy. No se afirma certificación WCAG integral ni validación comercial.

## Evidencia y reproducción

Evidencia de laboratorio fuera del repositorio:

`C:/Users/Mike/.codex/visualizations/2026/10/29/01a1858f-4ee6-7380-88c2-8c76d081847c/gifting/`

- `review-390.png`, `review-820.png`, `review-1440.png`: capturas completas para aprobación.
- `review-board.png`: comparación de los tres tamaños principales.
- `review-{ancho}.png`: doce anchos comprobados; `qa-tablet-desktop.png`: control de transiciones.
- `assets-review.jpg`: inventario visual de selección.
- `qa.json`, `checks.json`: medidas, estructura, contraste, teclado, endpoints y protección; scripts de laboratorio `qa.mjs` y `checks.mjs`.

Reproducir con `npm run build` y `php -S 127.0.0.1:8000 -t .` desde el proyecto; reutilizar el servidor si ya está escuchando. Abrir la URL indicada y revisar los anchos de la tabla. La aprobación visual humana sigue siendo necesaria antes de integrar/publicar.

**HOME C4 READY — WAITING FOR VISUAL APPROVAL**
