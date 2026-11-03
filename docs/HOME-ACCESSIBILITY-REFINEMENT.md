# Home R2 — Accesibilidad y Guest Stories

2026-11-03 · America/Bogota. Cierre técnico para publicar la rama y preparar PR manual hacia `develop`. No autoriza publicación comercial ni declara conformidad WCAG completa.

## Cierre final y aprobación técnica — 2026-11-03

**R2 aprobada técnicamente para PR dentro del alcance comprobado. No se detectaron defectos bloqueantes de esta fase.** La revisión final no requiere modificar los seis archivos de implementación: sus SHA256 coinciden con los registrados al iniciar el cierre. Solo se actualiza este informe. La fecha objetivo comercial comunicada es el 15 de noviembre de 2026; no convierte los pendientes audiovisuales o de publicación en requisitos resueltos.

Tras `git fetch origin`, HEAD, merge-base y `origin/develop` coinciden en `709cad801e95f9f03c7596adf7db886faaa16724`; R1 (`d8ffe5e`, PR #27) es ancestro. La rama es `feature/home-accessibility-refinement`. Se inspeccionó todo el diff y este archivo nuevo. El alcance del commit se limita a los siete archivos de la tabla inferior, sin `index.html`, imágenes, MP4, dependencias, outputs compilados ni informes locales ajenos.

La autorización de cierre sustituye el límite inicial de no commit/no push exclusivamente para un commit `fix(home): mejorar accesibilidad y navegación responsive` y push normal a `origin/feature/home-accessibility-refinement`. El PR se creará manualmente contra `develop`. Sin PR automático, merge, cambios en `main` ni deploy. La aprobación técnica no atribuye aprobación comercial, audiovisual o conformidad WCAG AA completa.

### QA ejecutado nuevamente en el cierre

| Comprobación | Resultado final y evidencia |
|---|---|
| Lint / build | PASS: `npm run lint` y `npm run build`, sin dependencias nuevas |
| PHP | PASS: lint de los 60 PHP rastreados; prueba directa `php scripts/probar-fechas-formularios.php` |
| Node | PASS: `probar-carrito.mjs`, `probar-cierre-comercio.mjs` y `probar-formularios.mjs`; 126 casos de formularios y 27 comprobaciones de fechas/sesión, con correo nativo deshabilitado |
| HTML | PASS: html5lib sin errores, 52 IDs únicos, un H1/main, referencias ARIA/for resueltas, imágenes con alt y cuatro vídeos. Cero tracks, limitación audiovisual conservada |
| Responsive / reflow | PASS: 320/360/390/425/600/768/820/992/1024/1280/1440/2560px con JS y documento con cero scripts; overflow 0 |
| Texto 200% | PASS: 320/360/390/425/768/820/1024/1440px, con y sin scripts; overflow 0. En el caso 320 con JS, logo y controles siguen dentro del viewport; sin scripts, el Header puede salir de él |
| Header / ARIA | PASS: Enter/Space, Discover, Escape en submenú y drawer, `aria-expanded`, diálogo nombrado, trap Tab/Shift+Tab y retorno del foco. En escritorio se retira el nombre del contenedor genérico |
| Hero | PASS: Home/End, escenas inactivas inert/aria-hidden, pausa/reanudación con Enter/Space y estado inicial sin controles inoperantes en el fallback. Diseño y máquina de escenas conservados |
| Guest Stories | PASS: Home/End y extremos de flechas; los cuatro vídeos alcanzan readyState 4, exclusión, pausa al navegar y pausa nativa comprobada de reproducción a pausa. El clip corto también se reproduce hasta su final |
| Recorrido de foco | PASS: 85 pasos Tab alcanzan los cuatro vídeos y Footer, sin entrar en escenas inert; foco Core de 2px en controles revisados |
| axe / consola | Cero infracciones automáticas en 390/768/1280 y cero errores en la carga final observada. Persisten revisiones manuales de fotografía, captions y referencia del carrito a modal oculto; no son una certificación global |
| Compatibilidad visual | PASS: comparación de anchura/altura de Header, secciones y Footer con la R2 revisada en doce anchos: cero diferencias. Se conservan cuatro vídeos, posters, proporciones, duración, controles y los títulos sustentados en la evidencia visual |
| Contraste / límites | Se conserva la evidencia de contraste de R2 descrita abajo, sin cambios de color, overlay o tipografía durante este cierre. No se presenta como una nueva medición completa de otras escenas o formatos |
| Git / integridad | PASS: `git diff --check`, seis fuentes intactas y los tres informes locales anteriores byte a byte; staging explícito de siete archivos |

Evidencia del cierre fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/11/03/01a1a2e9-eac1-73c0-a558-cae8d4bbc1af/home-r2-close/`. Se conservan logs de lint/build/PHP/Node, `validar-html.py`, `comprobar-resultados.py`, `html-validation.json`, `responsive.json`, `compatibilidad.json`, `interaccion.json`, `teclado.json`, `media.json`, `axe.json`, capturas y manifiestos de integridad. El router y las pruebas reproducibles de la implementación siguen disponibles en la carpeta `home-r2/` citada abajo. No se incorporan herramientas de QA al producto.

**Impacto sobre el diseño:** nulo durante el cierre final. R2 conserva únicamente los cambios mínimos justificados de Header bajo ampliación/fallback y los textos de Guest Stories. Se confirma nuevamente en los fotogramas del cuarto clip la bota de cuero; no se inventan opiniones ni se afirma haber escuchado el audio. Permanecen pospuestos escucha editorial completa, subtítulos sincronizados, alternativa equivalente y evaluación de audiodescripción; también zoom nativo efectivo, lector de pantalla y matriz de dispositivos/hosting pendiente. Son requisitos reales antes de publicación comercial, fuera de la autorización de este push.

## Registro de implementación — base, alcance y preservación

R1 está integrada en `origin/develop`: `709cad801e95f9f03c7596adf7db886faaa16724`, merge del PR #27; `d8ffe5e` es ancestro. Se ejecutaron `git fetch origin`, `git switch develop`, `git merge --ff-only origin/develop` y `git switch -c feature/home-accessibility-refinement`. El fast-forward solicitado es la única actualización de integración; no se crea un merge de feature, commit, push, PR ni deploy.

Los tres informes locales sin seguimiento —`HOME-FINAL-AUDIT`, `HOME-TECHNICAL-AUDIT` y `HOME-VISUAL-ASSET-PLAN`— se preservan byte a byte. Sus hashes anteriores están en `informes-previos.json`, fuera del repositorio. No se reescriben informes anteriores ni se usa stash, clean o cambios de ignore para ocultarlos.

Se leyeron AGENTS, reglas PHP/JS/SCSS, estándares, arquitectura, dirección visual, UX/UI, readiness y contratos relevantes de Foundation/Core/Patterns, cierres vigentes de Home y auditoría técnica. El backlog de esta intervención es H11 y la parte editorial de H02, más defectos accesibles confirmados durante sus pruebas. No se repite una auditoría general de seguridad, SEO, rendimiento o negocio.

`production-baseline` no contiene el anfitrión ni los partials de la nueva Home. El contraste histórico confirma que es una vista local adicional. `index.html` ya difiere del baseline por R1; R2 no añade diferencias sobre ese archivo. Se conservan los guards de preview/C6, los MP4, posters, imágenes, overlays, copy comercial ajeno a Guest Stories y la Home pública.

## Hallazgos intervenidos

| ID | Evidencia previa reproducida | Solución mínima | Verificación |
|---|---|---|---|
| R2-01 / H11 | Viewport 320, raíz de laboratorio 32px: `clientWidth=305`, `scrollWidth=360`, overflow 55px. Logo de ancho 0 y menú x=272–360 | Retirar `nowrap` del adaptador con carrito. Reservar tres controles y gaps en el cálculo de `flex-basis` del logo, limitado entre 2,75 y 8rem. El flex existente permite envolver cuando hace falta | Overflow 0; logo 88px y controles 88px bajo el mismo stress. Distribución normal conservada; sin ocultación global de overflow, reducción de targets ni `!important` nuevo |
| R2-02 | Sin scripts, la pausa del Hero recibía foco y decía “Pause automatic slides”, aunque no existía rotación; la pista anunciaba atajos no disponibles | Pausa inicialmente `hidden`; tabindex y ayuda de teclado solo al inicializar. El teardown retira ambos y oculta la pausa | Documento con cero scripts: primera escena y CTA nativos conservados, sin pausa inoperante ni anuncio de atajos. Con JS vuelve exactamente el control existente |
| R2-03 | axe marca revisión de `aria-labelledby` sobre `#navegacion-global` como div genérico en escritorio | El partial no etiqueta el wrapper genérico. El módulo lo vincula al ID del título al abrir el diálogo y retira la relación al cerrar | Diálogo móvil nombrado “Explore The Clandestino”; Escape y retorno del foco. Escritorio sin el atributo inaplicable; no se añade un role artificial |
| R2-04 | Cero scripts + texto 200% + 320px: Header expandido de 1655,875px frente a viewport de 1000px; sticky mantiene su superficie delante del contenido | Sticky pasa al modificador de mejora JS `cl-cabecera--mejorada`. Sin drawer, el Header puede salir del viewport al desplazar la página; el teardown elimina el modificador | Repetir el caso extremo y abrir `#guest-stories`: el Header deja de cubrir el contenido. Con JS mantiene sticky, composición y controles aprobados |
| R2-05 / H02 editorial | El cuarto clip muestra una bota de vino flexible de cuero, no un porrón. Los textos de los clips 1 y 3 afirmaban habla sin escucha verificada | Títulos descriptivos breves y contextos accesibles basados en fotogramas confirmados. Se conserva “By the window” por ser preciso | Cuatro nombres mediante `aria-labelledby`, contextos mediante `aria-describedby`, duraciones y controles nativos intactos |

Los cambios del anfitrión `home-preview.php` se justifican exclusivamente por R2-02. No se altera autoplay, intervalo, pausas, imágenes, transiciones, indicadores, composición ni acciones del Hero inicializado. No se añaden controles visuales.

## Guest Stories: propuesta editorial y evidencia

La sesión no dispone de escucha o transcripción fiable de estos archivos. Se inspeccionaron seis fotogramas distribuidos por cada original mediante FFmpeg local, además de su reproducción nativa. **No se verificó qué experiencia relata el audio ni si contiene una opinión testimonial explícita.** No se atribuyen diálogos, elogios, idioma, música, nombres, relación personal o recomendaciones.

Los títulos son finales para esta propuesta de R2, pero **provisionales respecto al contenido hablado**, pendientes de escucha editorial humana. No se añade una descripción editorial visible: repetiría información visual y aumentaría el pie de las tarjetas.

| Original / duración conservada | Título propuesto | Contenido visual confirmado y fuente |
|---|---|---|
| `Client-1.mp4` / 0:51 | **A glass of red** | Invitado sentado con una copa de vino tinto, mesa e interior. Fotogramas 1,5 / 9,2 / 18,4 / 28,1 / 38,2 / 47,4s; `Client-1-frames.jpg` |
| `Cliente-2.mp4` / 1:31 | **Tapas & company** | El plano pasa de queso y embutidos a dos invitados tras botellas en la barra; aparecen sonrisas. Fotogramas 2,7 / 16,4 / 32,8 / 50,1 / 68,2 / 84,6s; `Cliente-2-frames.jpg` |
| `clandetino-user.mp4` / 1:18 | **By the window** | Botella en primer plano; invitada sentada junto a la ventana, gestos y sonrisas; otra invitada visible cerca al inicio. Fotogramas 2,3 / 14,0 / 28,1 / 42,9 / 58,5 / 72,5s; `clandetino-user-frames.jpg` |
| `clandestino-experience.mp4` / 0:06 | **A sip of tradition** | Invitado alza una bota de cuero y bebe; después la baja y el plano vuelve a la tabla de tapas. Fotogramas 0,2 / 1,1 / 2,2 / 3,3 / 4,5 / 5,6s; `clandestino-experience-frames.jpg` |

Lectura editorial, sin atribuir opiniones: el primero muestra el momento de una copa; el segundo, comida y compañía; el tercero, un encuentro cercano junto a la ventana; el cuarto, un gesto tradicional español. Las sonrisas son visibles; satisfacción con la comida, elogios al servicio o relatos personales no se deducen de ellas.

Contextos accesibles implementados, en inglés:

1. “A seated guest holds a glass of red wine at a table inside The Clandestino.”
2. “The camera moves from cheese and cured meats to two guests at the bar, with wine bottles in front of them.”
3. “The camera moves from a wine bottle to a seated guest by the window; another guest is visible nearby.”
4. “A guest drinks from a leather wineskin beside a board of tapas, then lowers it as the camera returns to the food.”

`video` no admite `alt`; conserva su nombre y contexto accesibles existentes. El poster no es un elemento `img` independiente al que añadir un alt redundante. Estos resúmenes no sustituyen subtítulos, transcripción o alternativa audiovisual integral.

## Contrato visual y capturas

Evidencia externa al repositorio:

`C:/Users/Mike/.codex/visualizations/2026/11/03/01a1a2e9-eac1-73c0-a558-cae8d4bbc1af/home-r2/`

- `before-{ancho}.jpg` / `after-{ancho}.jpg`: referencias de los doce anchos; página completa en 390/768/1280.
- `before-header-320-text200.jpg` / `after-header-320-text200.jpg` y `header-comparison.jpg`: corrección visual necesaria de ampliación.
- `before-nojs-dead-pause.jpg` / `after-nojs-no-dead-pause.jpg`: retirada del control inoperante del fallback.
- `before-nojs-text200-sticky.jpg` / `after-nojs-text200-static.jpg`: contenido accesible tras desplazar el Header sin scripts.
- `before-guest-{390,768,1280}.jpg` / `after-guest-{390,768,1280}.jpg`: revisión editorial conservando tarjetas, media, proporción, controles y duración.
- `geometry-before.json`, `geometry-after.json` y `geometry-comparison.json`: dimensiones de Header, secciones y Footer. En tamaño normal solo cambia la altura de Guest Stories a 360px, que se reduce una línea (31,1875px) por los títulos breves. Las restantes alturas/anchuras coinciden; no se considera una diferencia artística ajena al texto autorizado.

Las diferencias de posición de secciones posteriores a Guest Stories se deben únicamente a ese cambio natural de altura. No se aplican alturas fijas ni truncamiento para forzar coincidencias. Se conserva la dirección visual aprobada; las correcciones de ampliación/fallback requieren revisión humana funcional, sin reabrir el diseño.

## QA y reproducción

Entorno: PHP 8.3.14, Chromium integrado 156 en Windows, DPR 1 y viewport de 1000px de alto. Producto: `http://127.0.0.1:8000/home-preview.php`. Si no existe un servidor local: `php -S 127.0.0.1:8000 -t .`; comprobar el puerto antes de iniciar otro.

Se usa `.agents/skills/qa-visual/SKILL.md`. Instrumentación y axe-core 4.10.3 viven fuera del repo, servidos exclusivamente por el router loopback de QA en 8001. No se añaden dependencias del proyecto ni herramientas al bundle. La simulación de tamaño de texto modifica solo la raíz del documento de laboratorio, nunca el CSS del producto.

| Control | Resultado y alcance |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: Sass/PostCSS/Gulp/esbuild y sprite; outputs generados ignorados, sin edición manual |
| PHP lint | PASS: 60 PHP rastreados; `git ls-files '*.php'` y `php -l` por archivo |
| Suites existentes | PASS: `node scripts/probar-carrito.mjs`, `node scripts/probar-cierre-comercio.mjs`, `node scripts/probar-formularios.mjs`; esta última cubre 126 casos con correo nativo deshabilitado y 27 comprobaciones de fechas/sesión. También se ejecutó directamente `php scripts/probar-fechas-formularios.php` |
| HTML | PASS estructural: html5lib sin errores de parseo, 52 IDs únicos, un H1/main, referencias ARIA/for resueltas y todas las imágenes con alt. No se presenta como certificación Nu/W3C |
| Responsive base | PASS: 320/360/390/425/600/768/820/992/1024/1280/1440/2560px; overflow de documento 0 |
| Texto 200% | PASS de reflow en 320/360/390/425/768/820/1024/1440px: overflow 0, logo y controles presentes. No equivale a zoom nativo |
| Fallback sin scripts | Doce anchos con cero etiquetas script y ocho anchos adicionales con texto 200%: overflow 0 y Header desplazable. Navegación expandida y enlaces, cuatro vídeos con controles nativos, primera escena y CTA conservados. Sin controles JS inoperantes. Es un documento sin scripts, no desactivación del motor desde los ajustes del navegador |
| Teclado | Recorrido final de 85 pasos Tab por Home, incluidos los cuatro vídeos y Footer, sin foco en escenas inert. Skip → main; Tab/Shift+Tab; Enter/Space de menú y Discover; Escape de submenú/drawer/modales, trap y retorno del foco; Hero Home/End/flechas y pausa; Guest Home/End y límites de flechas; controles nativos de los cuatro clips |
| Estados y foco | Diálogo móvil nombrado, estados expanded/closed y current/inert coherentes; anillo Core 2px/offset 3px en los recorridos comprobados. No se añaden roles a enlaces, listas o botones nativos |
| Consumidor compartido | Navigation Lab en 390 y 1280: diálogo nombrado con el ID del título, Escape/retorno, retirada del atributo al cerrar y contenedor de escritorio sin role/etiquetado artificial. Assets de guía compilados exclusivamente fuera del repo |
| Medios | Los cuatro clips alcanzan readyState 4; reproducción por Space, pausa nativa, exclusión y pausa al navegar. El scroll de enfoque a una tarjeta fuera de vista pausa la reproducción conforme al adaptador existente; se comprueba reproducción con el foco estabilizado |
| axe | Cero infracciones automáticas en 390/768/1280; revisión manual pendiente de fotografía, captions y referencia de carrito a modal oculto. Esta última relación existe y se comprobó al abrir/cerrar el modal; no se elimina para silenciar la herramienta |
| Contraste | Axe comprueba superficies/textos evaluables, incluido Footer. Muestreo fotográfico adicional con texto oculto solo en el laboratorio y cajas DOM alineadas a la escala de captura: Hero escena 1 en 390/768/1280 y C8 en 390/768, 25 grupos; mínimo 4,77:1. No acredita todas las escenas, formatos o frames |
| Reduced motion | PASS sintético: Hero `disabled-reduced-motion`, sin autoplay; animaciones reducidas y scroll auto. No es prueba de la preferencia real del SO |
| Zoom nativo | PENDIENTE: Ctrl+0 y cinco Ctrl++ no cambiaron `innerWidth=1280` ni DPR=1 en el integrado. No se declara zoom real 200% |
| Consola / recursos | Carga final normal sin errores observados. Las solicitudes durante `gulp clean` se excluyen del resultado y se repiten tras terminar el build |
| `git diff --check` | PASS; alcance e integridad de informes revisados |

Reflow reproducible: `http://127.0.0.1:8001/qa/home?texto=200` a 320px. Fallback extremo: `?sinjs=1&texto=200#guest-stories`; navegación con Enter/Space y scroll. El router, scripts e instrumentos se conservan en la carpeta externa indicada. La Home normal no expone parámetros de prueba.

No se usa el primer muestreo exploratorio de contraste de capturas completas para dictaminar defectos: la rasterización de la captura y los rectángulos no estaban alineados. La evidencia válida es `contrast-viewports.json` / `contrast-viewport-results.json`, con escala de captura y scroll explícitos. No se cambia el diseño para responder a un falso positivo del instrumento.

## Archivos modificados

| Archivo | Responsabilidad de R2 |
|---|---|
| `assets/scss/patterns/_navegacion-global.scss` | Envoltura y reserva del logo; sticky solo con mejora JS |
| `assets/js/modules/patterns/navegacion-global.js` | Ciclo del modificador sticky y nombre del diálogo abierto |
| `includes/header.php` | Retirar etiquetado del wrapper genérico |
| `home-preview.php` | Estado inicial accesible de pausa/pista sin scripts |
| `assets/js/modules/patterns/escenas-hero.js` | Activación/retirada de pausa y atajos; máquina de escenas intacta |
| `includes/guest-stories.php` | Tres títulos refinados, uno conservado y cuatro contextos visuales verificados |
| `docs/HOME-ACCESSIBILITY-REFINEMENT.md` | Este registro de evidencia, QA y límites |

## Límites y riesgos pendientes de publicación

- H02 permanece abierto para accesibilidad audiovisual: cero tracks de subtítulos en los cuatro clips. No se crearon VTT/SRT ni transcripciones. Falta escucha editorial completa, subtítulos sincronizados de habla/sonidos relevantes, alternativa equivalente y evaluación de audiodescripción por clip. Los permisos/audio ya confirmados por el responsable según la auditoría vigente no se reabren.
- No se afirma conformidad WCAG 2.1 AA completa. Ver [captions pregrabados](https://www.w3.org/WAI/WCAG21/Understanding/captions-prerecorded.html), [ampliación de texto](https://www.w3.org/WAI/WCAG21/Understanding/resize-text.html) y [reflow](https://www.w3.org/WAI/WCAG21/Understanding/reflow.html).
- Falta lector de pantalla auditivo, zoom nativo efectivo, alto contraste del SO, dispositivos táctiles físicos, Safari/Firefox y pruebas Apache/GoDaddy. Controles nativos conservados no equivalen a certificación de todas sus variantes.
- El contraste nuevo cubre los casos declarados. La evidencia de aprobaciones anteriores conserva su valor histórico, pero no se presenta como nueva medición de otras escenas/formatos/frames.
- Cuenta/carrito siguen siendo demostraciones de preview, sin operación comercial. El carrito sin scripts conserva su limitación de demo; su retirada del anfitrión público corresponde a H09. No se inventan servicios para justificar controles.
- Continúan los requisitos externos a R2 de anfitrión/rutas públicas, contenido comercial/Pure Soul, SEO, entrega/caché/chunks y recepción real de solicitudes. R1 ya está integrada; estas pruebas no envían correos ni reservas reales. No se retiran guards ni se activa la Home pública.

**HOME R2 READY FOR PR**
