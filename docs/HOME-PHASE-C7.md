# Home C7 — Private Experiences · The evening, held for you.

Actualización 2026-11-02, America/Bogota. Rama `feature/home-private-redesign`. **C7 aprobada visualmente por el responsable en móvil, tablet y escritorio.** La aprobación comprende composición cinematográfica, degradados, titular, fotografía provisional, copy, CTA y responsive. Se conservan íntegramente; este cierre solo audita, documenta y prepara commit/push para un PR manual hacia develop. No activa la Home pública.

## Cierre definitivo aprobado

Se autoriza el commit `feat(home): rediseñar experiencias privadas` y push normal a `origin/feature/home-private-redesign`. Sin PR automático, merge, deploy ni cambios en main. La revisión completa no encontró bloqueantes técnicos y no requirió modificar PHP/SCSS aprobados.

Tras `git fetch origin`, HEAD, develop y origin/develop coincidían en `34e80a6219132d5687da7edd1d8c9f71efd736d1`, integración de C6 mediante PR #23; su commit `d496291` es ancestro del remoto. La rama remota de C7 no existía al comenzar el cierre. Se revisaron íntegramente diff y archivos nuevos. Se incluyen exactamente `includes/private-experiences.php`, `assets/scss/home.scss`, `assets/scss/pages/_home-privadas.scss`, `docs/ARQUITECTURA.md` y este informe. Los originales, derivados, dependencias, componentes globales y secciones protegidas no presentan diferencias contra develop.

`docs/HOME-FINAL-AUDIT.md` permanece sin seguimiento, fuera del staging/commit y con su hash original. Por ello el estado global no se considera vacío aunque los archivos de C7 queden comprometidos y sincronizados. La aprobación visual no acredita recepción de consultas ni validación del hosting.

## Refinamiento responsive final

La primera implementación separaba fotografía y relato por debajo de xl: dos bloques en teléfono y panorama más dos columnas inferiores en tablet. Esa adaptación perdía el lenguaje cinematográfico aprobado de escritorio. Se sustituye por capas Grid en una misma celda, con fotografía, degradado intermedio y relato en flujo natural. El contenido determina la altura; no se posicionan textos con coordenadas absolutas.

En móvil, la protección vertical se vincula al comienzo real de la lectura mediante `--privadas-aire`, local y limitada a teléfonos. Pasa progresivamente de transparencia a una opacidad de 0,94 al empezar el eyebrow y aumenta suavemente hacia la base. Así el contraste no depende de que la fotografía sea oscura ni de la cantidad de líneas. La fotografía se amplía proporcionalmente dentro de la figura con cover, altura relativa del 145 % y alineación inferior: se recorta la franja alta de estanterías para conservar botella central y copa junto al texto. El foco horizontal al 60 % se limita a teléfonos. No se deforma ni se modifica el original.

En tablet se adopta una única composición lateral integrada: relato de hasta 30rem incluidos sus paddings, con titular, descripción y CTA en una columna; degradado horizontal que libera progresivamente la fotografía hacia la derecha. Desde xl se conservan las mismas declaraciones visuales efectivas, retícula, encuadre, tipografía, color, espaciados, botón y degradado aprobados.

Solo cambian en este refinamiento el SCSS local, el `sizes` móvil del partial y esta documentación, más la frase responsive de Arquitectura para evitar una descripción contradictoria. El copy y el destino son idénticos y la semántica HTML se conserva; `home.scss`, los componentes globales y todas las secciones protegidas conservan sus bytes previos. No se añaden animaciones, tokens globales, fotografías ni dependencias. El `sizes` móvil solicita el derivado existente de 1600px porque el cover ampliado necesita aproximadamente 1300–1400px de fotografía renderizada con DPR 1; indicar solo el ancho del teléfono seleccionaba un recurso insuficiente. La carga móvil nueva seleccionó `private-room-1600.avif` (223.415 B), todavía lazy. El `sizes` de tablet/escritorio conserva exactamente su contrato anterior.

## Base y alcance

`git fetch origin` confirmó C6 integrada mediante [PR #23](https://github.com/MaickR/clandestinoUSA/pull/23), merge `34e80a6`, sobre `origin/develop`. Se revisó su cierre en `HOME-PHASE-C6.md`, se actualizó develop por fast-forward desde `bbd19b2` y se creó la rama solicitada. La descripción remota del PR confirma permisos/audio y mantiene pendientes captions y alternativas; C7 no modifica esos contratos ni autoriza publicación.

El único archivo previo sin seguimiento era `docs/HOME-FINAL-AUDIT.md`. Se conserva byte a byte, SHA256 `49B97D8320715F61AC0BCAEAE196E847C56B6F397CA971B29D9CCFCE75932BCC`. Su fotografía recomendada y su estado de integración son históricos: el encargo C7 y el remoto verificado tienen prioridad. No se edita ni se añade al staging.

Se contrastaron los anclajes y recorridos legacy con `production-baseline`; allí no existen Home Preview ni este partial. Se modifica exclusivamente la invitación local existente, sin añadir ni mover secciones. Orden: Pure Soul → Private Experiences → Guest Stories → Wine Club. Visit conserva ubicación, horario, indicaciones, reserva habitual y aviso de confirmación. Las fases de implementación/refinamiento transcurrieron sin commit ni push; el cierre definitivo superior autoriza ahora su publicación como feature. `index.html`, `reservation.php`, backend, dependencias y tokens intactos.

## Dirección y reutilización

Una sola banda amplia sustituye foto más panel solapado. Del referente descrito se toman amplitud horizontal, fotografía protagonista, jerarquía editorial y acción próxima al relato. La captura de referencia no estaba adjunta en esta sesión; se interpreta exclusivamente su descripción, sin atribuir una comparación visual directa con ella. Se mantienen tipografía, champagne, superficies cálidas y radios Foundation. Sin marco desplazado, ornamento nuevo, iconos o caja opaca sobre la fotografía.

Se conservan `cl-home-privadas` y sus elementos `__composicion`, `__escenario`, `__imagen`, `__invitacion`, `__titulo`, `__relato`; se añade únicamente `__ancho` para el contenedor fluido. No había clases legacy que migrar. Se reutilizan:

- `cl-seccion` y `cl-seccion__{descripcion,acciones}` para ritmo, prosa y acciones.
- `cl-historia__{figura,declaracion,texto}` y `cl-experiencia__{media,imagen}` para semántica editorial y fotografía.
- `cl-eyebrow`, `cl-boton`, tipografía, espaciado, radio y foco Foundation/Core.
- `container-fluid`, CSS Grid y `media-breakpoint-up(md/xl)`; `clamp()` limita la escala local y la altura panorámica.

Se estudió la densidad/acción de Banda CTA, sin aplicar `cl-banda-cta--destacada`, cuyo contrato lateral repetiría Visit. No se duplican sus estilos ni se altera ningún patrón compartido. Los ajustes anteriores de Private se trasladan desde `home.scss` al partial local `pages/_home-privadas.scss`, eliminando la definición anterior. La mejora de entrada CSS existente se conserva con sus mismos keyframes, alcance y condición reduced motion; no se agrega movimiento ni JS.

## Fotografía y responsive

Selección **provisional**: `assets/images/the-clandestino.jpg`, 2048×1536, interior real con copas, botellas y profundidad del local, sin personas identificables visibles. Se revisaron interiores, mesas, brindis, vino y celebraciones de la galería. Las fotografías de comunidad con rostros no se reutilizan sin permiso confirmado. Las vistas centradas en sillas resultaron menos adecuadas a esta invitación.

Se reutilizan sin regenerar los ocho `private-room-{640,960,1600,2048}.{avif,webp}`; originales y etiquetas intactos. `picture` conserva AVIF/WebP y fallback JPEG, `srcset`, `sizes` actualizado al ancho real de la media, dimensiones, lazy loading, decoding async, cover y foco al 58 %. El texto alternativo describe lo visible sin atribuir un evento confirmado.

| Rango | Composición |
|---|---|
| 320–767 | Fotografía y contenido en la misma celda; relato inferior centrado y degradado vertical anclado al comienzo del texto, sin panel opaco |
| 768–1199 | Foto de fondo amplia, relato/CTA en una columna lateral integrada y degradado horizontal progresivo |
| Desde 1200 | Grid superpuesto: fotografía en las nueve columnas derechas, contenido en las seis izquierdas; transición lineal del borde de la foto a transparencia, sin filtro sobre su zona protagonista |

Márgenes exteriores de 16/32/48 px mediante tokens; no se fuerza `100vw` en el layout. La altura desktop de la banda queda entre 34 y 40rem y crece si el contenido lo exige. La imagen se posiciona dentro de su figura para evitar que su tamaño intrínseco imponga la altura; el relato permanece en flujo Grid en todos los tamaños. La única excepción de encuadre es móvil; tablet/escritorio conservan foco `center 58%`.

## Consulta y conversión

Eyebrow y titular aprobados, descripción propuesta en inglés estadounidense y CTA **Plan Your Private Gathering** hacia `/contact.html#contact-form`. `contact.html` contiene `subject=Private Event`; `contact.php` admite exactamente ese valor. La persona debe seleccionarlo: no hay parámetros que prometan preselección. Se verificó navegación real con Enter hasta el formulario, sin enviarlo.

No se añade Request a Table aquí: Visit ya resuelve esa decisión mediante `$rutaReserva`, `/index.html#reservation`, y conserva “Table requests are subject to confirmation.” No se prometen exclusividad, capacidad, precio, disponibilidad ni una reserva confirmada. La mejora de conversión es una hipótesis de claridad/jerarquía; no se atribuye un incremento medido de consultas.

## QA ejecutado

Skill `.agents/skills/qa-visual/SKILL.md`. PHP 8.3.14 y Chromium integrado en Windows; DPR 1. Home real: `http://127.0.0.1:8000/home-preview.php#private-events`. Instrumentación externa al repo en `:8002`, con observador, posicionamiento de captura y variante CSP que bloquea scripts; no cambia la composición. Sin instalaciones, envío de formularios ni llamadas comerciales. El cierre repite lint/build, PHP lint, suites Node, HTML, diff, consola, teclado, contraste, recursos, fallback sin JS y capturas en 390/768/820/1024/1200/1280/1440. Los registros de la matriz anterior y CLS se identifican como evidencia del refinamiento, no como pruebas repetidas en este cierre.

| Comprobación | Resultado |
|---|---|
| Revisión visual de cierre: 390/768/820/1024/1200/1280/1440 | PASS: captura posicionada dentro de Private, anchos efectivos verificados, foto/relato/CTA completos y sin overflow ni deformación. La aprobación humana de todos los formatos ya consta arriba |
| Matriz del refinamiento: 320/360/425/600/768/992/1024/1199/1200/1280/2560 | PASS previo preservado: sin overflow, cortes ni solapamientos; no se repitió íntegra en este cierre |
| `npm run lint`, `npm run build` | PASS; ESLint, Stylelint y pipeline existente |
| PHP lint | PASS: partial Private, Home Preview y `includes/site.php`; markup estático sin entradas de petición ni nuevas salidas dinámicas que requieran escaping. Guard de acceso directo conservado |
| Suites Node existentes | PASS: `scripts/probar-carrito.mjs` y `scripts/probar-cierre-comercio.mjs` |
| HTML estructural | PASS: html5lib sin errores; un H1/main, IDs únicos y referencias ARIA resueltas |
| Teclado/foco/targets | PASS: Pure Soul → CTA privado → Next guest story; foco Core 2px con offset 3px; CTA de 44px de alto en los 14 anchos |
| Contraste | PASS: cota conservadora sobre blanco puro tras el gradiente en las cajas reales de eyebrow/titular/descripción. Cierre: mínimo 7,13:1 en los siete anchos; matriz previa: mínimo 6,90:1. Botón 12,69:1. Supera umbrales AA |
| Estabilidad del refinamiento | Sin shifts atribuidos a C7. CLS de página: 0 en 390/1024/1440; 0,00776 en una pasada 820, con fuente `wine-club`. Hallazgo externo preservado; no se afirma CLS global siempre cero. La carga móvil final con AVIF 1600 dio 0. No se volvió a medir CLS en el cierre ni es medición de campo |
| Recursos/consola | PASS de cierre: contacto, original y ocho derivados (10 URLs) devolvieron 200; imagen cargada en los siete anchos; consola normal sin errores/warnings. Las infracciones CSP intencionales pertenecen solo al ensayo sin scripts |
| Sin scripts | PASS local: CSP `script-src 'none'`, foto/copy/CTA visibles y Enter navega al contacto; no equivale a probar todos los flujos legacy sin JS |
| Reduced motion | Condiciones CSS existentes preservadas e inspeccionadas; sin animaciones nuevas. Preferencia real del SO no emulada |
| Preservación de escritorio | PASS: todos los nodos de Private conservan ancho/alto/posición relativa en 1200/1280/1440/2560. Altura total de sección idéntica: 672/672/675,1875/768px. Las cajas y el copy coinciden; la comparación JPEG a 1440 solo presenta diferencias mínimas de captura en la fotografía, media RGB menor de 0,124/255, sin cambio geométrico perceptible |
| Regresiones | PASS: geometría de Header/Hero/Discovery/Pure Soul/Guest Stories/Club/Gifting/Visit/Footer igual en comparación controlada 390/820/1024/1440; CSS ajeno a Private idéntico tras excluir sus reglas/keyframes |
| `git diff --check` y alcance | PASS; solo partial, entrada SCSS, nuevo partial SCSS y documentación C7/arquitectura |

Se descartaron capturas nativas transitorias cuyo ancho aún pertenecía al viewport anterior. Las finales se repitieron comprobando dimensiones del JPEG frente al ancho efectivo. La toma completa a 2560 se obtuvo mediante un recorte explícito del documento porque la superficie nativa limitaba el ancho; no es un mockup. `regression.json` registra cero diferencias en secciones protegidas. Ctrl+plus se intentó cinco veces, sin cambiar `innerWidth` ni DPR: **zoom real al 200 % no verificable con este control**, no se declara ejecutado. Reduced motion se inspeccionó en la condición CSS conservada, sin emular la preferencia real del SO.

Evidencia actual externa: `C:/Users/Mike/.codex/visualizations/2026/11/02/01a19a71-6937-73d2-8037-3d910babb78b/c7-responsive-final/`. Comparativas `comparison-{390,820,1024,1440}.jpg`, fuentes `before/after-*`, `matrix-*`, `responsive.json`, `contrast.json`, `cls.json`, `final-mobile.json`, `focus.json`, `keyboard.json`, `desktop.json`, `regression.json`, `css-regression.json`, `technical.json` y `zoom-attempt.json`. La evidencia inicial permanece en la carpeta hermana `c7/`.

Evidencia nueva de cierre en la carpeta hermana `c7-close/`: `qa-{390,768,820,1024,1200,1280,1440}.jpg`, `qa-sheet.jpg`, `responsive.json`, `html-resources.json`, `contrast.json`, `focus.json`, `no-js.json`, `approved-source-hashes.json` y `css-regression.json`. Las primeras capturas con scroll relativo se descartaron porque no quedaban posicionadas en la sección; se repitieron con el atajo de posicionamiento del laboratorio externo. El CSS ajeno a Private coincide con el anterior; los hashes confirman que el código aprobado no cambia durante el cierre.

## Pendientes externos

La aprobación visual de C7 es completa y no se reabre. La fotografía provisional también está aceptada para esta composición; una selección definitiva de medios de Home pertenece a otra tarea. Comprobar recepción real de consultas y funcionamiento comercial de la categoría Private Event mediante una prueba autorizada; HTTP 200 no acredita entrega. Validar Apache/GoDaddy, carga de assets y el futuro anfitrión público: Home Preview mantiene CLI-server/noindex y no se activa mediante este push. El partial usa PHP nativo estático y assets compilados, sin nuevos procesos o servicios requeridos en hosting. Antes del lanzamiento siguen pendientes las dependencias externas de Home/C6 ya registradas. No se probaron dispositivos táctiles físicos, Safari/Firefox, lector de pantalla auditivo, preferencia reduced motion real ni zoom efectivo; no se afirma certificación WCAG integral. Estos límites no bloquean el PR de C7 ni se declaran resueltos.

Reproducir: `npm run build`; reutilizar PHP local en `127.0.0.1:8000` o iniciar `php -S 127.0.0.1:8000 -t .`; abrir `/home-preview.php#private-events` y revisar primero 390, 820 y 1440 px. El QA técnico y la revisión interna no autorizan publicar.

**HOME C7 READY FOR PR**
