# Home C5 — Featured CTA Band

## Cierre definitivo — aprobación visual y publicación de rama

2026-10-31. El responsable **aprueba visualmente The Final Invitation en móvil, tablet y escritorio** y autoriza el commit `feat(home): integrar cierre editorial de visita` y un push normal de `feature/home-visit` para crear el PR manual hacia `develop`. No se autoriza PR automático, merge ni deploy. La aprobación conserva íntegros fotografía, composición responsive, centrado móvil, Foundation/Core, ubicación/horarios compartidos, CTA, teléfono y Footer. Este cierre no modifica ninguna fuente de producto; únicamente registra la decisión y repite la auditoría técnica. Los registros inferiores conservan su contexto histórico y quedan sustituidos por este estado.

### Alcance final y Git

Tras `git fetch origin`, HEAD, `develop` y `origin/develop` coinciden en `5eaa378`, merge del PR #21 de C4. El working tree inicial contiene exclusivamente los nueve archivos de C5 enumerados debajo, sin cambios ajenos. La rama remota `feature/home-visit` no existía antes de esta publicación. No se cambia de rama, no se actualiza ni modifica `main`, ni se realizan resets o merges durante el cierre.

| Archivo incluido | Responsabilidad final |
|---|---|
| `includes/visit.php` | Featured CTA Band real, H2 semántico, foto, ubicación/horarios y tres enlaces nativos |
| `assets/scss/pages/_home-visita.scss` | Adaptación local aprobada: centrado móvil, ancho práctico/CTA y anclaje de foto |
| `assets/scss/home.scss` | Imports del patrón aprobado y de sus ajustes locales |
| `home-preview.php` | Inclusión de Visit después de Gifting y antes de Footer |
| `includes/site.php` | Dirección, Maps y horario confirmado como fuente pública compartida |
| `includes/footer.php` | Consumo de datos compartidos y omisión del aviso provisional sin horario |
| `docs/UX-UI-GUIDELINES.md` | Norma contextual de centrado editorial móvil |
| `docs/ARQUITECTURA.md` | Integración, contratos y estado de aprobación |
| `docs/HOME-PHASE-C5.md` | Decisiones, aprobación, auditoría y pendientes operativos |

Se revisa el diff completo contra `develop`, incluidos los tres archivos nuevos. No contiene artefactos de QA, capturas, CSS/JS compilados, fixtures, secretos, dependencias, backend o imágenes nuevas. Header, Hero, Discovery, Pure Soul, Private Experiences, Wine Club, Gifting, sus fuentes y el patrón global permanecen intactos. `index.html`, `contact.html` y `reservation.php` también coinciden con `production-baseline` ignorando CRLF. La rama conserva la preview local y no activa la Home pública.

### QA repetido para el cierre

PHP 8.3.14, Chrome 156.0.8078.48 local, DPR 1, reduced motion y viewport de laboratorio de 1000px de alto. URL `http://127.0.0.1:8000/home-preview.php#visit`. Se usa la composición aprobada como referencia, sin nuevos ajustes artísticos.

| Comprobación | Resultado de cierre |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: Gulp, Sass/PostCSS y esbuild; outputs ignorados por Git |
| PHP lint | PASS: Visit, Site, Footer y Home Preview |
| Pruebas Node existentes | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`; sin script npm test inventado |
| HTML estructural | PASS: etiquetas cerradas, H1 único, H2 de C5, IDs únicos, referencias ARIA resueltas y alt correcto. No equivale a certificación Nu/W3C |
| Responsive y recursos | PASS en 320/360/390/425/600/768/820/992/1024/1199/1200/1280/1440/2560: sin overflow, texto visible cortado o imágenes rotas |
| Datos públicos | PASS: dirección, Maps y teléfono iguales en Visit/Footer; horario idéntico Tuesday–Sunday / 4:00 PM – 8:00 PM, hora local de Mount Shasta |
| Teclado/foco/targets | PASS: Gifting → Request → Directions → Call → Footer, Shift+Tab y Enter; foco Core 2px/offset 3px y targets ≥44px |
| Contraste | PASS: mínimo de texto HTML de C5 en reposo 9,69:1; horario/Footer incluidos |
| Enlaces | PASS: Enter llega a `clandestino-reservation-form`; Maps abre su URL compartida en pestaña nueva; teléfono usa `tel:` |
| Solicitud y recepción | Nota visible/asociada: `Table requests are subject to confirmation.`; no se presenta como reserva confirmada ni disponibilidad verificada |
| Sin JS | PASS en catorce anchos: foto, horario y tres enlaces; misma altura de C5 que con JS. El envío legacy conserva su dependencia de JS |
| Texto ampliado | PASS con raíz de 32px a 768/1440: acciones apiladas, sin overflow y targets ≥88px. No es zoom nativo certificado |
| Escape de horario | PASS: prueba PHP CLI externa con caracteres especiales temporales, escapados en ambos partials; configuración real intacta |
| CLS de laboratorio | Cero atribuido a C5; total Home observado 0–0,004433 durante este cierre. No son métricas de campo |
| Regresión y congelación | PASS: geometría de secciones protegidas idéntica a la versión aprobada en los catorce anchos; hashes de 21 fuentes de producto iguales antes/después del cierre |
| Consola Home | PASS: sin errores/warnings o respuestas HTTP ≥400 durante la matriz |
| Endpoints | Home/foto 200; partial directo 404 deliberado; GET del receptor legacy 405 |
| `git diff --check` | PASS |

Evidencia fresca fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/10/29/01a18823-347b-7b11-a716-45f81db057ae/c5-close-2026-10-31/`. Contiene matriz/capturas en `after/`, referencia aprobada en `before/`, `protected.json`, `structure.json` y `extra.json`. Las capturas y scripts no forman parte del commit.

### Pendientes reales y alcance operativo

La aprobación visual está concedida. No queda un bloqueo técnico conocido en C5 para preparar el PR. El formulario `/index.html#reservation` y `reservation.php` siguen siendo el recorrido provisional: requieren entrega real de correo del hosting, atención del equipo y confirmación humana. No se envían formularios válidos, correos, mensajes ni llamadas durante este cierre. No se verifica disponibilidad ni se activa un motor de reservas.

Antes de activar la nueva Home pública siguen pendientes las comprobaciones operativas de recepción y el entorno Apache/GoDaddy. La preview mantiene `cli-server`/noindex; PHP tradicional y estáticos compilados no requieren Node, colas o BD en hosting. No se atribuyen pruebas a Safari/Firefox, dispositivos físicos, lector auditivo o métricas de campo. Los pendientes comerciales de otras secciones no se reabren ni se resuelven mediante esta aprobación.

**HOME C5 READY FOR PR**

---

## Registro anterior — refinamiento del 2026-10-31

El responsable **aprueba conceptualmente la composición Featured CTA** y solicita únicamente distribución responsive, centrado editorial móvil y horarios habituales confirmados. No se rediseña la banda ni se reabre la elección fotográfica provisional. Se continúa en `feature/home-visit`, conservando los cambios locales previos. La aprobación visual final del refinamiento permanece pendiente. Sin commit, push, PR, merge, reset ni deploy.

### Horario habitual: fuente única y contrato

El propietario confirmó Tuesday–Sunday, 4:00 PM – 8:00 PM, hora local de Mount Shasta, California (`America/Los_Angeles`). Se registra en `$datosContacto['horario']` de `includes/site.php` como dos líneas de texto, conservando el contrato existente. No se añaden datos sobre lunes, excepciones, disponibilidad ni un estado dinámico abierto/cerrado.

Visit consume el mismo array mediante `array_map($escaparNavegacion, ...)` e `implode('<br>', ...)`. Footer ya implementaba exactamente ese consumo: no requiere cambios en su plantilla para mostrar el horario vigente. Dirección, Maps, teléfono, rutas y escaping siguen compartidos; no se copian horarios literales en los partials. En la nueva Home solo aparece 4:00 PM – 8:00 PM en Visit y Footer, sin horarios históricos o avisos pendientes de confirmación.

### Distribución y alineación

Se conserva `cl-banda-cta--destacada`, `.row.g-0`, imagen izquierda 5/12, contenido derecho 7/12 desde md y foto superior 4:3 en móvil. Superficie, radios, fuente Foundation, botones Core, padding y centrado vertical pertenecen al patrón aprobado.

El panel usa su ancho útil para un grupo práctico de ubicación/horario y dos acciones de igual anchura. `cl-home-visita__datos` agrupa ambos datos sin convertir el horario en parte de `<address>`. Desde md, Grid crea dos columnas cuando caben dos celdas de 10rem más el gutter de 12px. Las acciones usan el mismo gutter y umbral: ubicación y horario quedan alineados con las dos acciones. Con texto ampliado o espacio insuficiente, `auto-fit/minmax` vuelve a una columna. Se retira únicamente en C5 el límite de 16rem por botón y de 32rem del grupo; no se modifica Core.

El contenido usa `align-items: stretch`; el párrafo conserva el límite de lectura de 42ch y el H2 conserva tamaño/copy. El aviso permanece inmediatamente después de las acciones; el teléfono sigue siendo complementario. No hay nuevas acciones, `!important`, posiciones absolutas de contenido, alturas de viewport ni JS.

En móvil se centran eyebrow, título, descripción, dirección, horario, aviso y teléfono. La descripción mantiene su anchura limitada y margen horizontal automático. La directriz queda registrada en `UX-UI-GUIDELINES.md` para presentaciones editoriales apiladas de futuras páginas públicas; no se aplica globalmente ni a formularios, tablas, listas o textos extensos.

### Fotografía y comparación

`inside-clandestino.jpg` permanece idéntico: 1440 × 1440, JPEG progresivo, 217793 bytes, alt y dimensiones explícitas. Se conserva `object-fit: cover`, `object-position: center` y el anclaje local `inset: 0`. El recorte 4:3 móvil es editorial, no una deformación del original. Desde md la media acompaña la altura natural del contenido; no existe una altura de pantalla fija. No se añade `<picture>`, `srcset` o `sizes` con fuentes inexistentes: solo hay un recurso de esta fotografía, sin nuevos derivados.

| Ancho | Alto de C5 antes → después | Acciones principales antes → después |
|---|---|---|
| 390 | 920,95 → 984,95 px | 318/318 px, apiladas; se añaden 64px de contenido real para horario y separación |
| 768 | 626 → 570 px | 256/256 px apiladas → 173/173 px en fila, ocupando 358px útiles |
| 820 | 627,88 → 571,88 px | 256/256 px apiladas → 173/173 px en fila |
| 992 | 642,06 → 642,06 px | 219/219 px; dirección y horario comparten la fila práctica |
| 1024 | 643,22 → 643,22 px | 219/219 px; misma identidad y anchura útil |
| 1440 | 654,38 → 654,38 px | 250/250 → 289/289 px, cubriendo los 590px útiles con gutter de 12px |

En tablet la foto pasa de 290×530 a 290×474px a 768, y de 290×531,88 a 290×475,88px a 820: el nuevo reparto de acciones reduce 56px de altura sin reducir letra. Esto amplía el contenido horizontal visible del recorte. Móvil conserva foto 366×274,5px a 390; desktop conserva 490×526,38px a 1440/2560. Se revisan barriles, sillas, estanterías y banderas dentro del encuadre, sin sustitución ni alteración del archivo.

### QA del refinamiento

Entorno: PHP 8.3.14, Chrome 156.0.8078.48 local, DPR 1, reduced motion y viewport de laboratorio de 1000px de alto. URL: `http://127.0.0.1:8000/home-preview.php#visit`. Capturas anteriores y posteriores a 390/768/820/992/1024/1440; control adicional de la skill a 1280.

| Comprobación | Resultado |
|---|---|
| `npm run lint` / `npm run build` | PASS: ESLint, Stylelint, Gulp, Sass/PostCSS y esbuild; repetidos tras alinear el gutter práctico con las acciones |
| PHP lint | PASS: Visit, Site, Footer y Home Preview |
| Pruebas Node existentes | PASS: `probar-carrito.mjs` y `probar-cierre-comercio.mjs`; no se inventa script npm test |
| HTML estructural | PASS: etiquetas cerradas, un H1, H2 de C5, IDs únicos, ARIA resuelto, alt y dimensiones; no certificación Nu/W3C |
| Responsive | PASS en 320/360/390/425/600/768/820/992/1024/1199/1200/1280/1440/2560, sin overflow, texto visible cortado o imágenes rotas |
| Centrado móvil | PASS: todos los textos/acciones de C5 computan centrados por debajo de md; contenido editorial a la izquierda desde md |
| Información y controles | PASS: ubicación/horario agrupados, dos CTA iguales, alineados y de ancho completo; targets ≥44px |
| Teclado/foco/rutas | PASS: Gifting → Request → Directions → Call → Footer, Shift+Tab y Enter al formulario legacy; foco Core 2px/offset 3px |
| Contraste | PASS: mínimo de texto HTML en reposo 9,69:1, incluyendo horario en C5/Footer |
| Horarios y datos | PASS: horario idéntico en Visit/Footer; dirección y enlaces compartidos; sin lunes/excepciones ni indicador dinámico |
| Escape | PASS: prueba PHP CLI externa con `<`, comillas y `&` en un horario temporal del proceso; ambas salidas escapadas. La configuración real no se altera |
| Sin JavaScript | PASS en catorce anchos: foto cargada, tres enlaces nativos, horario visible y misma altura de C5 |
| Texto ampliado | PASS con raíz de 32px a 768/1440: botones de 28px, acciones apiladas, targets ≥88px y sin overflow; no equivale a zoom nativo |
| CLS local | Cero atribuido a C5 en los catorce anchos; total Home observado 0–0,027329, con fuentes registradas en Hero/Gifting |
| Regresión protegida | PASS: cajas y descendientes de Header, Hero, Discovery, Pure Soul, Private Experiences, Wine Club y Gifting con delta cero antes/después; fuentes protegidas idénticas |
| Consola/recursos | PASS: sin errores/warnings o HTTP ≥400 durante la matriz de Home |
| `git diff --check` | PASS |

El Footer añade únicamente las dos líneas del horario a través de su contrato vigente; su altura crece naturalmente y conserva marca, navegación, Maps, teléfono y legales. La revisión de continuidad Gifting → Visit → Footer incluye este cambio visible. El QA técnico y esta revisión interna no conceden la aprobación artística final.

Los registros de CLS no se presentan como métricas de campo ni como CLS global cero. Las fuentes y geometría final de Hero/Gifting permanecen iguales; no se amplía este refinamiento a sus comportamientos de carga. Maps abre la URL compartida en una pestaña nueva; Home y la fotografía responden 200, el partial directo 404 deliberado y GET del endpoint legacy 405 (`extra.json`).

Limitaciones: Chromium local, sin otros motores, dispositivo físico, lector auditivo o Apache/GoDaddy real. La ampliación de texto de laboratorio no se presenta como zoom nativo certificado. El horario comunicado no valida disponibilidad de mesas: Request a Table sigue siendo una solicitud dependiente del formulario legacy, su correo y confirmación humana. No se envían solicitudes, mensajes o llamadas ni se modifica el backend. Continúan pendientes la aprobación visual final y la validación operativa de recepción.

### Archivos y evidencia

Cambios de esta iteración: `includes/site.php`, `includes/visit.php`, `assets/scss/pages/_home-visita.scss`, `docs/UX-UI-GUIDELINES.md`, este documento y la referencia en `ARQUITECTURA.md`. `footer.php` y los demás cambios locales del trabajo C5 previo se preservan. No se toca `_banda-cta.scss`, Core, tokens, páginas públicas, originales multimedia, JS, analítica ni dependencias.

Evidencia externa: `C:/Users/Mike/.codex/visualizations/2026/10/29/01a18823-347b-7b11-a716-45f81db057ae/final-refinement-2026-10-31/`. `before/` y `after/` contienen capturas y matrices `qa.json`; `comparison-*.png` compara los seis anchos principales. `after/sequence-{390,820,1440}.png` muestra el cierre completo. `structure.json`, `extra.json`, `protected.json` y `escape.php` documentan las comprobaciones. No hay evidencia temporal dentro del repo.

Reproducir con `npm run build`, el servidor PHP local disponible o `php -S 127.0.0.1:8000 -t .` si el puerto está libre, y la URL/ancho de la tabla. No requiere un proceso Node en el hosting. La preview conserva su guard local y no se activa producción.

**HOME C5 FINAL REFINEMENT — WAITING FOR VISUAL APPROVAL**

---

## Registro anterior — Featured CTA, 2026-10-30

La composición tipográfica anterior fue **RECHAZADA visualmente** por el responsable. Este registro la sustituye por la integración del patrón aprobado `cl-banda-cta cl-banda-cta--destacada`; los apartados históricos inferiores no describen el diseño vigente. La nueva integración espera aprobación visual humana. Se continúa en `feature/home-visit` sobre `5eaa378`, preservando todos los cambios locales de configuración, Footer y anfitrión. Sin commit, push, PR, merge, reset ni deploy.

## Patrón exacto y render previo

Se inspeccionaron antes de editar: `assets/scss/patterns/_banda-cta.scss`, `style-guide/partials/bandas-cta-destacadas.php`, su inclusión en `patrones-wave-1.php` y el inventario de `FINAL-DESIGN-SYSTEM-AUDIT.md`. Se renderizó `/style-guide/patterns.php#patrones-cta`, capturando `#banda-club` a 390/820/1440. También se capturó la C5 tipográfica antes de sustituirla. No se modifican estas fuentes aprobadas ni se importan fixtures en Home.

`home.scss` importa ahora `patterns/banda-cta`. `includes/visit.php` usa la estructura original: `.container`, `.row.g-0.cl-banda-cta__fila`, `.col-md-5.cl-banda-cta__media`, `.cl-banda-cta__imagen`, `.col-md-7.cl-banda-cta__contenido`, `.cl-seccion__acciones.cl-banda-cta__acciones` y botones Core. La retícula, superficie cálida, radios, padding, proporción y tratamiento fotográfico proceden directamente del patrón, sin segunda implementación.

El título es H2 dentro de Home, no el H3 del laboratorio. La única adaptación tipográfica local conserva exactamente la escala y margen del título de la banda. Se elimina la cabecera display separada, la fila inferior de contacto y sus estilos. El copy nuevo y el orden de acciones siguen el encargo: Request a Table principal, Get Directions secundario y Call Us complementario.

## Fotografía y responsive

Se inspeccionó visualmente `assets/images/inside-clandestino.jpg`: JPEG progresivo, 1440 × 1440, 217793 bytes, interior auténtico con barriles, sillas, vinos y banderas española/estadounidense. No existen AVIF/WebP de este archivo. Se reutiliza el original sin modificarlo ni generar derivados: su peso no justifica ampliar el alcance en esta integración provisional. Incluye alt descriptivo, dimensiones explícitas, carga lazy y decoding async. La selección definitiva queda pendiente de la auditoría artística final.

- Móvil: foto 4:3 arriba; debajo se centran eyebrow, H2, descripción, dirección y contacto. Botones apilados de 44 px o más, dentro de la misma superficie. Sin altura rígida ni dos columnas.
- Tablet: retícula original 5/7 desde md. A 768/820 las acciones se apilan mediante la regla existente del patrón; a 992/1024 caben en fila. Se conserva texto de cuerpo, sin reducirlo para hacer sitio.
- Desktop: foto izquierda 5/12 y contenido derecha 7/12, centrado vertical original, sin panel separado, Hero, carrusel o formulario añadido.

`pages/_home-visita.scss` queda limitado al H2 semántico, márgenes/color de dirección y confirmación, target del teléfono, centrado móvil y un anclaje local de foto. No redefine retícula, superficie, radios ni padding del patrón. Variables semánticas, `clamp()` y mixin Bootstrap `media-breakpoint-down(md)`; sin tokens, fuentes, dependencias o JS nuevos.

### Defecto objetivo corregido

Al centrar el texto móvil, la posición estática de la imagen absoluta heredó ese centrado y desplazó la foto fuera del contenedor (x=195 en vez de 12 a 390px). Se corrigió exclusivamente con `.cl-home-visita .cl-banda-cta__imagen { inset: 0; }`. La regla global permanece intacta. Las evidencias `defect-photo-390.png`, `photo-fix-390.png` y `defect-qa.json` registran el antes; la matriz final elimina el overflow sin cambiar tamaños, recorte o composición del patrón.

## Datos públicos y acciones

Se conservan sin modificaciones adicionales `site.php` y `footer.php`: dirección, Maps y teléfono salen de `$datosContacto`, y `$rutaReserva` sigue apuntando a `/index.html#reservation`. No hay valores comerciales duplicados en `visit.php`. Se comprobó igualdad de dirección y enlaces entre C5/Footer. Horarios, correo y redes siguen vacíos, sin información ficticia ni reaparición del aviso provisional.

Request a Table incluye `aria-describedby="visit-solicitud"` y la nota visible `Table requests are subject to confirmation.`. Enter llega al formulario legacy `clandestino-reservation-form`; su JS hace POST a `reservation.php`, dependiente de `mail()` y de la atención del equipo. La sección no confirma disponibilidad o reservas. Maps conserva la URL existente, abre una pestaña anunciada con `noopener noreferrer`; Call Us conserva `tel:+14086090027`. No se modifica el backend ni se envían solicitudes válidas, mensajes o llamadas durante QA. Recepción y respuesta operativas continúan pendientes.

## QA de esta integración

PHP 8.3.14, Chrome 156.0.8078.48, DPR 1, viewport de laboratorio 1000 px de alto y reduced motion. URL: `http://127.0.0.1:8000/home-preview.php#visit`.

| Comprobación | Resultado vigente |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint, repetidos tras corregir el anclaje |
| `npm run build` | PASS: Gulp/Sass/PostCSS/esbuild tras la corrección |
| PHP lint | PASS: Visit, Home Preview, Site y Footer |
| Node declarado en documentación | PASS: `probar-carrito.mjs` y `probar-cierre-comercio.mjs`; no existe script npm test |
| HTML estructural | PASS: anidamiento cerrado, un H1, H2 de C5, IDs únicos, referencias ARIA resueltas, alt y dimensiones; no certificación Nu/W3C |
| Responsive y overflow | PASS en 320/360/390/425/600/768/820/992/1024/1200/1280/1440/2560; sin texto visible cortado ni imágenes rotas |
| Teclado/foco/targets | PASS: Gifting → Request → Directions → Call → Footer; Shift+Tab, Enter al formulario; anillo 2px/offset 3px y targets ≥44px |
| Contraste | PASS: mínimo de texto HTML de C5 en reposo 9,69:1 sobre superficie sólida; la foto no lleva texto superpuesto |
| Sin JS | PASS en trece anchos: fotografía cargada, enlaces nativos, sin overflow y misma altura de C5. El envío legacy conserva su dependencia de JS |
| CLS local | Cero atribuido a C5 en los trece anchos. Total Home 0–0,178529 en la matriz; control móvil antes/después idéntico en 0,004433, atribuido al H2 del Hero. Detalle inferior |
| Consola/recursos de Home | PASS: sin errores, warnings ni respuestas HTTP ≥400 durante la matriz |
| Rutas/datos | PASS: Enter al formulario existente, Maps y tel correctos; C5/Footer comparten dirección y enlaces |
| Regresión anterior a C5 | PASS: todas las cajas y descendientes de Header, Hero, Discovery, Pure Soul, Private Experiences, Wine Club y Gifting con delta cero en los trece anchos frente a la captura previa |
| Protección de fuentes | PASS: hashes de diecisiete fuentes protegidas iguales; incluye patrón, ejemplos, tokens, original JPEG, configuración y Footer |
| `git diff --check` | PASS |

Capturas principales primero en 390/820/1440 y revisión posterior del resto, especialmente 768/992/1024. Se compararon patrón original, composición rechazada y nueva C5, además de la secuencia completa Gifting → Visit → Footer. La foto se mantiene reconocible y sin distorsión; la banda conserva un único fondo y relación directa entre imagen/contenido. Esta evaluación interna no concede aprobación artística humana.

La primera carga de 390px registró CLS total Home 0,178529, sin fuentes de nodo conservadas para ese salto y sin aportación de C5. Un control adicional con contextos nuevos, mismas condiciones y la respuesta/CSS anterior capturados produjo 0,004433 tanto antes como después: el nodo registrado es el H2 del Hero al cambiar la anchura de sus glifos. No se reproduce el pico inicial ni se demuestra una regresión de C5. Se conserva toda la evidencia en `qa.json` y `cold-load.json`; no se afirma CLS global cero y no se altera el Hero aprobado. La medición de campo/carga real de la Home sigue pendiente.

La foto responde 200, el partial directo 404 deliberado y Get Directions abre efectivamente la URL Maps configurada en una pestaña nueva (`cold-load.json`).

Limitaciones: laboratorio Chromium, sin Safari/Firefox, dispositivos físicos, lector auditivo, zoom nativo, red móvil simulada, métricas de campo o Apache/GoDaddy real. La preview conserva su guard local `cli-server`; no se activa producción. La recepción real de solicitudes y la selección fotográfica definitiva siguen pendientes, sin convertir la integración frontend en servicio comercial confirmado.

## Evidencia y archivos

Carpeta externa: `C:/Users/Mike/.codex/visualizations/2026/10/29/01a18823-347b-7b11-a716-45f81db057ae/featured-cta/`.

- `original-{390,820,1440}.png`, `rejected-*.png`, `visit-*.png` y `comparison-*.png`: tres estados reales comparables.
- `sequence-{390,820,1440}.png`: Gifting, Visit y Footer completos, capturados por franjas contiguas del viewport para evitar artefactos del capturador largo.
- `photo-fix-390.png`: defecto móvil antes/después; `qa.json`, `structure.json`, `protected.json` y `before/` documentan mediciones y preservación.

Esta iteración modifica únicamente `includes/visit.php`, el import de `assets/scss/home.scss`, `assets/scss/pages/_home-visita.scss` y los registros de este documento/`ARQUITECTURA.md`. Los cambios locales previos de Site, Footer y Home Preview se preservan. Sin fixtures, temporales o capturas dentro del repositorio.

Para revisar: `npm run build`; reutilizar el PHP local o ejecutar `php -S 127.0.0.1:8000 -t .` si el puerto está libre. Abrir la URL Home y los anchos de la tabla. La guía requiere sus outputs dev; se regeneraron mediante las herramientas existentes para inspeccionarla en `/style-guide/patterns.php#patrones-cta`, sin modificar sus fuentes.

**HOME C5 FEATURED CTA READY — WAITING FOR VISUAL APPROVAL**

---

## Registro histórico — The Final Invitation tipográfica, rechazada

2026-10-29. Rama `feature/home-visit`. Implementación local pendiente de aprobación visual humana. Sin commit, push, PR, merge de la feature ni deploy.

## Base y alcance

`git fetch origin` confirmó `5eaa378`, merge del PR #21 de C4 (`5a91cbc` es ancestro de `origin/develop`). Árbol inicial limpio. `develop` se actualizó por fast-forward desde `63c172f`; la feature nació desde `5eaa378`. No se usaron reset, stash, operaciones destructivas ni ramas de producción para implementar.

Se añade `includes/visit.php` después de Gifting y antes del Footer en `home-preview.php`, con ID estable `visit`. La preview conserva su guard `cli-server`, `noindex` y separación respecto a `index.html`. No se modifican páginas públicas legacy, backend, dependencias, fotografías, tokens globales ni composiciones anteriores.

## Dirección editorial y recorrido comercial

Una invitación tipográfica cierra la secuencia fotográfica. Libre Bodoni, énfasis cursivo champagne y una superficie neutra cálida dan protagonismo al titular. Dos líneas agrupan información útil: restaurante/dirección y siguientes acciones. No hay foto, mapa incrustado, ornamentos nuevos, animación ni JavaScript añadido.

El encabezado permanece centrado. En teléfonos la dirección precede a las acciones apiladas; desde `md` los dos botones comparten fila. En tablet el conjunto sigue centrado, sin partir la dirección y los botones en columnas estrechas. Desde `lg`, los 936 px útiles permiten una retícula 5/7 para ubicación y acciones. La anchura del cierre se limita a 68rem, el titular a 20ch y la descripción a 48ch. Altura determinada por contenido, sin saltos `<br>` en el titular ni alturas rígidas.

| Acción | Destino y alcance |
|---|---|
| Get Directions | URL Google Maps exacta ya utilizada en el legacy; nueva pestaña anunciada y `noopener noreferrer` |
| Request a Table | `$rutaReserva`, existente: `/index.html#reservation`. Solicitud provisional mediante formulario legacy; nunca confirmación de mesa |
| Call Us | Teléfono compartido `tel:+14086090027`, visible como `+1 (408) 609-0027` |

La nota visible y asociada al CTA dice `Table requests are subject to confirmation.`. No se inventan disponibilidad, horarios, urgencia ni motor de reservas.

## Datos compartidos y Footer

La dirección `211 N Mt Shasta Blvd` / `Mount Shasta, CA 96067`, Google Maps y teléfono se contrastaron con `index.html`, `contact.html` y `production-baseline`. Fuentes concretas: JSON-LD de dirección en `index.html`, dirección legible de `contact.html`, enlaces Maps de ambos documentos y teléfono del Header/legacy. La verificación acredita coherencia con los archivos del establecimiento; no equivale a una confirmación operativa externa actual.

`includes/site.php` centraliza las dos líneas y la URL Maps existente. C5 y Footer consumen el mismo array y helper de escape. Se conservan el teléfono y `$rutaReserva` existentes. Horarios, correo y redes continúan vacíos; no se publica información histórica sin confirmar.

El Footer muestra ahora dirección y Maps desde la configuración compartida. Se elimina únicamente el fallback visible `Opening hours · awaiting confirmation.` cuando no hay horario. Conserva su marcado restante, columnas, estilos y patrones. Este cambio también omite el aviso en consumidores de guía con horario vacío; los fixtures de guía siguen independientes y no alimentan Home. Capturas específicas de Footer en 390/820/1440 y revisión de continuidad Gifting → Visit → Footer registran el cambio visible.

## Reutilización y arquitectura

- Foundation: tipografía `cl-display`, fuentes y colores existentes, escala semántica de espacios, foco y reduced motion.
- Core: `cl-boton`, variante `--secundario`, `cl-enlace` y `cl-eyebrow`.
- Patrones: `cl-seccion`, `cl-seccion__encabezado`, `cl-seccion__descripcion`, `cl-seccion__acciones` y `cl-contacto`.
- Bootstrap 5.3: `.container`, `visually-hidden`, mixins Sass `media-breakpoint-up(md/lg)`. Grid y Flexbox locales; `color.mix` usa los primitivos ya importados, sin nueva escala.
- Estilos C5 aislados en `assets/scss/pages/_home-visita.scss`, importados por `home.scss`; no hay copias de CSS legacy ni fixtures de Style Guide.

El partial rechaza acceso HTTP directo con 404. Las inclusiones usan rutas literales basadas en `__DIR__`; dirección, mapa, teléfono y ruta se escapan mediante `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`. No hay entrada externa ni POST nuevo. PHP tradicional y archivos estáticos compilados son compatibles con la arquitectura prevista de cPanel; no se requieren Node, BD, colas ni procesos persistentes en hosting. No se probó Apache/GoDaddy y no se activa la preview allí.

## QA ejecutado

Entorno: PHP 8.3.14, Chrome 156.0.8078.48, DPR 1, reduced motion, servidor PHP local y herramientas existentes; sin instalaciones. URL: `http://127.0.0.1:8000/home-preview.php#visit`.

| Comprobación | Resultado |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: Gulp, Sass, PostCSS y esbuild |
| PHP lint | PASS: `visit.php`, `site.php`, `footer.php`, `home-preview.php` |
| Pruebas Node declaradas en documentación | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`; no existe script npm `test` |
| HTML estructural | PASS: anidamiento cerrado, un H1/main, IDs únicos, referencias ARIA resueltas, imágenes con alt. H2/H3 de C5 coherentes; comprobación local, no certificación Nu/W3C |
| Responsive | PASS en 320, 360, 390, 425, 600, 768, 820, 992, 1024, 1200, 1280, 1440 y 2560 px: sin overflow de documento ni imágenes rotas |
| Dirección y enlaces compartidos | PASS: dirección, Maps y teléfono coinciden entre C5 y Footer |
| Teclado | PASS: Gift Cards → Get Directions → Request a Table → Call Us → marca Footer; Shift+Tab; Enter llega al formulario legacy |
| Foco | PASS en 390/820/1440: anillo Core champagne de 2 px con offset de 3 px tras estabilizar el render |
| Targets | PASS: tres acciones de 44 px de alto o más en los trece anchos |
| Contraste | PASS: mínimo de texto HTML C5 en reposo 10,58:1; CTA primario en hover 10,07:1; acciones Core conservadas |
| Sin JavaScript | PASS: trece anchos, contenido y tres enlaces nativos presentes, sin overflow. El envío del formulario legacy sigue dependiendo de su JS existente |
| CLS de laboratorio | Cero atribuido a C5 en los trece anchos; total Home entre 0 y 0,002042 durante la muestra, sin throttling ni métricas de campo |
| Texto al 200% | PASS a 320 px sin overflow de documento/C5; aumento de raíz en laboratorio, no zoom nativo certificado |
| Consola y recursos Home | PASS: sin errores, warnings o HTTP ≥400 durante la matriz de capturas |
| Endpoints | Preview, index y contact 200; partials directos 404 deliberado; GET `reservation.php` 405; POST vacío 400 `No data received`, sin envío comercial |
| Protección | `index.html`, `contact.html` y `reservation.php` siguen idénticos a `production-baseline` ignorando CRLF; fuentes de secciones anteriores intactas |
| Regresión de geometría | PASS en los trece anchos: cajas de Header, Hero, Discovery, Pure Soul, Private Experiences, Wine Club y Gifting, incluidos sus descendientes, sin diferencias frente a HEAD |
| Regresión funcional | PASS: menú móvil abre/cierra con Escape y devuelve el foco; indicador del Hero cambia a escena 2 y ArrowRight a escena 3 tras su decode; Maps abre la URL compartida en una pestaña nueva |
| `git diff --check` | PASS |

Las capturas se revisaron primero en 390, 820 y 1440: jerarquía, lectura de dirección, proximidad de acciones y continuidad con Gifting/Footer. La revisión interna no concede aprobación artística humana.

La comparación geométrica reconstruye la hoja Home de HEAD con el mismo pipeline Sass/PostCSS/Autoprefixer/cssnano y elimina C5 de una respuesta interceptada solo en laboratorio. La primera comparación con Sass sin minificar produjo diferencias por normalización del CSS; la comparación final con el pipeline equivalente registra delta máximo cero (`final-review.json`). El detector inicial de texto desbordado incluía la etiqueta `visually-hidden` de la nueva pestaña, cuyo recorte es deliberado: no existe texto visible cortado. Capturas de continuidad tomadas con scroll en origen evitan artefactos del capturador sobre Header sticky; no se cambió el producto para generar evidencia.

## Recepción legacy y pendientes reales

`index.html#reservation` contiene `clandestino-reservation-form`. Su manejador envía `FormData` por POST a `reservation.php`, maneja error/timeout y presenta el envío como solicitud pendiente de confirmación. El endpoint valida campos y emplea `mail()` del hosting hacia los destinatarios configurados en el legacy, con copia y mecanismos anti-spam existentes. Esas configuraciones no se modificaron ni se publican en C5.

No se enviaron formularios válidos, correos, mensajes ni llamadas durante QA. El rechazo vacío verifica el endpoint, pero no acredita entrega, bandeja de entrada ni seguimiento del equipo. Antes del uso operativo se deben confirmar recepción real, configuración de correo del hosting, canal atendido y proceso humano de respuesta. El formulario legacy incluye opciones/afirmaciones históricas que no constituyen disponibilidad verificada; su revisión comercial queda pendiente y fuera de esta implementación.

Pendientes: aprobación visual final de C5, prueba operativa de recepción y confirmación, validación en hosting y otros motores/dispositivos reales. No se declara certificación integral WCAG, rendimiento de campo ni disponibilidad comercial. No hay cambios de compra, reservas confirmadas o publicación autorizados por este cierre.

## Archivos y evidencia

1. `includes/visit.php` — sección nativa.
2. `assets/scss/pages/_home-visita.scss` — composición local.
3. `assets/scss/home.scss` — un import.
4. `home-preview.php` — un require.
5. `includes/site.php` — dirección y Maps.
6. `includes/footer.php` — omisión del aviso provisional de horario.
7. `docs/HOME-PHASE-C5.md` — contrato, QA y pendientes.
8. `docs/ARQUITECTURA.md` — registro de integración.

Evidencia fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/10/29/01a18823-347b-7b11-a716-45f81db057ae/`. `visit-{390,820,1440}.png`, controles adicionales en 768/1280, `footer-{390,820,1440}.png`, `continuity-*.png`, `before.json`, `after.json`, `checks.json`, `structure.json`, `final-review.json` y `smoke.json`; scripts de laboratorio en la misma carpeta.

Reproducir: `npm run build`, reutilizar el servidor activo o iniciar `php -S 127.0.0.1:8000 -t .`; abrir la URL de revisión y comprobar los anchos de la tabla. No iniciar otro servidor sobre el mismo puerto.

**HOME C5 READY — WAITING FOR VISUAL APPROVAL**
