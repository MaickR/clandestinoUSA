# Home C6 — Guest Stories · The stories behind the table

## Cierre técnico aprobado — preparación de PR manual, 2026-11-01

El responsable **aprueba expresamente la composición visual completa de Guest Stories**, incluido el ajuste final de tarjetas. Se conservan íntegros relato editorial lateral, storytelling, carrusel audiovisual Wave 5, títulos/duraciones, navegación accesible y distribuciones móvil/tablet/escritorio. Este cierre no rediseña la sección ni modifica sus fuentes visuales. La aprobación de composición **no aprueba los vídeos para producción**.

Se autoriza el commit `feat(home): integrar testimonios audiovisuales` y push normal de `feature/home-guest-stories` para posterior PR manual hacia `develop`. No se crea PR, no se hace merge ni deploy y no se modifica main. Los registros inferiores son históricos y sus mensajes de aprobación pendiente quedan sustituidos por este cierre visual; sus bloqueos audiovisuales siguen vigentes.

### Base Git y alcance exacto

Antes de actualizar referencias se comprobó `git status --short --branch`. Tras `git fetch origin`, HEAD, develop y origin/develop coinciden en `bbd19b2c343d00ec290de2e8f2a37968404f76b9`, merge #22 de Home Visit. La rama remota de C6 no existía al comenzar. Se revisaron el diff completo contra develop, los archivos nuevos y los contratos de Wave 5. C6 aún no está integrada en develop: este cierre publica únicamente su rama para el PR manual posterior.

| Archivo | Responsabilidad incluida |
|---|---|
| `includes/guest-stories.php` | Cuatro clips, posters, contextos accesibles breves, títulos/duraciones y guard local estricto |
| `assets/scss/pages/_home-historias.scss` | Composición local aprobada, pies compactos y reserva de controles |
| `assets/images/guest-stories/conversacion.webp` | Poster de Client-1, 36.854 B |
| `assets/images/guest-stories/juntos.webp` | Poster de Cliente-2, 49.816 B |
| `assets/images/guest-stories/encuentro.webp` | Poster de clandetino-user, 35.836 B |
| `assets/images/guest-stories/momento.webp` | Poster de clandestino-experience, 33.990 B |
| `assets/images/guest-stories/.htaccess` | Denegación de acceso directo a los posters en Apache |
| `assets/js/main.js` | Imports dinámicos condicionales e inicialización de los dos módulos existentes |
| `assets/scss/home.scss` | Tres imports: carrusel, media-video y ajuste local |
| `home-preview.php` | Un require entre Private Experiences y Wine Club |
| `docs/ARQUITECTURA.md` | Integración, aprobación visual y controles de publicación |
| `docs/HOME-PHASE-C6.md` | Este cierre, QA y requisitos audiovisuales pendientes |

`docs/HOME-FINAL-AUDIT.md` es trabajo local de otra fase: se preserva byte a byte y **queda fuera del commit**. No se incluye en staging ni se oculta mediante ignore/stash. Por ello el trabajo C6 puede quedar limpio y sincronizado mientras el estado global sigue mostrando ese único archivo sin seguimiento. No se afirma un working tree global vacío en esas condiciones.

No se incluyen capturas, scripts de QA, depuración, audio extraído, outputs compilados, dependencias nuevas ni copias de los MP4. No cambian módulos Wave 5, tokens, patrones compartidos, otras secciones aprobadas, index, backend ni analítica. El index conserva equivalencia con production-baseline al ignorar CRLF.

### Arquitectura y protección de publicación

La sección reutiliza `cl-carrusel--video`, Media Video, Foundation/Core y los módulos `carrusel.js` / `carrusel-media.js` sin modificarlos. Scroll Snap conserva exploración nativa; la mejora JS gestiona navegación, exclusión y pausas. Los imports solo se solicitan si existe `[data-cl-carrusel-media]`. No hay player propio, autoplay de vídeo, servicio comercial, fixtures ni librería nueva.

Controles comprobados:

1. Home Preview exige `PHP_SAPI === 'cli-server'` y emite `X-Robots-Tag: noindex, nofollow` y meta robots equivalente. PHP-CGI devuelve 404 sin contenido; no se retira el guard.
2. El partial C6 exige CLI server **y** `REMOTE_ADDR` loopback (`127.0.0.1`/`::1`), y rechaza acceso directo. Una inclusión simulada con dirección no local devuelve 404 y cero bytes; PHP-CGI también devuelve 404 y cero contenido. No hay parámetro, feature flag o bypass para habilitarlo públicamente.
3. Se detectó un riesgo nuevo concreto: el guard PHP no protegía las URLs estáticas de los posters. El `.htaccess` local de su directorio añade denegación en Apache, con la misma selección `mod_authz_core`/compatibilidad que la configuración raíz. El servidor PHP de revisión ignora `.htaccess` y permite conservar la composición local. No se modifica el `.htaccess` raíz ni una ruta legacy.
4. La denegación Apache se revisó en fuente; **no se ejecutó Apache/GoDaddy en este entorno**. Antes de cualquier despliegue debe comprobarse que AllowOverride aplica y las cuatro URLs directas devuelven 403. No desplegar este directorio en un servidor que ignore esa regla. Esta comprobación pendiente no se presenta como un ensayo remoto superado.

Los cuatro MP4 ya pertenecen al árbol remoto y al recorrido legacy; C6 no añade copias ni endpoints públicos nuevos para ellos. No se modifica esa exposición histórica fuera de alcance ni se la declara autorizada retroactivamente. Los guards impiden que una futura Home PHP pública incluya accidentalmente C6: retirar estos bloqueos requiere una tarea explícita de publicación y los criterios siguientes. No se debe «resolver» el 404 quitando la protección antes de aprobar el contenido.

### Pendientes audiovisuales y criterios para desbloquear

**Publicación audiovisual bloqueada. No se declaran resueltos:**

- Autorizaciones documentadas de personas, grabación, reutilización y música para cada pieza elegida.
- Escucha editorial íntegra, inteligibilidad, idioma, música/voz, contexto y selección definitiva. Reproducir vídeo en el navegador no equivale a escuchar ni aprobar sus opiniones.
- Subtítulos sincronizados revisados de habla y sonidos relevantes cuando correspondan; actualmente no hay tracks en estos cuatro vídeos.
- Transcripción y alternativa integral de la información relevante; las cuatro descripciones visuales breves no las sustituyen. Para WCAG 2.2 AA, valorar audiodescripción cuando la pista de audio no comunique la información visual importante.
- Pruebas de reproducción, seek/Range, carga y acceso en navegadores/dispositivos y hosting de destino; confirmar protección efectiva de los recursos antes de desplegar.

Para desbloquear: asociar permisos y materiales finales a cada clip; revisar y aprobar contenido completo y accesibilidad; validar compatibilidad/hosting; obtener autorización explícita de publicación; solo entonces revisar los guards y la denegación de posters en una tarea separada. Ni este commit, ni el push, ni el posterior merge habilitan contenido en producción.

### QA final ejecutado en este cierre

Skill: `.agents/skills/qa-visual/SKILL.md`. PHP 8.3.14, Chromium integrado 156 sobre Windows, DPR 1. Home real: `http://127.0.0.1:8000/home-preview.php#guest-stories`; instrumentos externos al repositorio en rutas locales del mismo servidor. Sin instalaciones, mensajes, formularios ni llamadas.

| Comprobación actual | Resultado y límites |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: Gulp, Sass/PostCSS/esbuild, sprite y chunks; no se incluyen outputs ignorados en Git |
| PHP lint | PASS: anfitrión y 14 includes |
| Node | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`; no existe script npm test |
| HTML estructural | PASS: html5lib sin errores, un H1/main, IDs únicos y referencias ARIA resueltas; cuatro vídeos y cero tracks. No es certificación WCAG |
| Responsive | PASS en 390/768/1280: overflow de documento 0, proporciones verticales conservadas, títulos y duraciones intactos; capturas de viewport y medidas externas |
| Reproducción manual | PASS: los cuatro clips alcanzan readyState 4 y currentTime avanza al pulsar Espacio; no se revisa contenido hablado |
| Exclusión y navegación | PASS: iniciar segundo pausa primero; iniciar tercero/cuarto pausa el anterior; Next pausa todos los vídeos |
| Teclado/foco | PASS: End alcanza 532/532px en desktop; Home regresa al inicio; Tab/Shift+Tab pasan pista/vídeo; anillo Core sólido de 2px observado |
| Reduced motion | PASS de rama JS **sintética** con el módulo fuente existente: End/Home usan `behavior: auto`, sin smooth. Regla CSS Foundation inspeccionada. Preferencia real del SO no emulada ni certificada |
| Sin scripts | PASS: documento de laboratorio con cero scripts, cuatro vídeos, controles JS ocultos, scrollbar auto y overflow 0 a 390px; reproducción nativa del primer clip hasta completar 50,73s. No equivale a desactivar el motor JS desde ajustes |
| Rendimiento inicial | PASS local: cuatro vídeos pausados readyState 0, cero entradas MP4 iniciales y cero layout shifts en la ventana de observación; los cuatro posters sí se cargan, 156.496 B totales |
| Métrica de laboratorio | Una muestra móvil 390px, PHP loopback, sin throttling ni limpieza de caché; último candidato LCP 2004ms. Monitor externo desde head hasta 3s después de load. No es rendimiento de campo ni medición válida de INP |
| Consola | PASS: sin errores/warnings en el recorrido normal comprobado. Los 404 de pruebas de seguridad son deliberados |
| Regresión contra develop | PASS: ancho y alto de Header, Hero, Discovery, Pure Soul, Private Experiences, Club, Gifting, Visit y Footer idénticos en 390/768/1280. El desplazamiento vertical posterior a C6 es el esperado por inserción de sección |
| Fuentes protegidas | PASS: patrones Wave 5, secciones previas, originales, dependencias, index y configuración raíz sin cambios. El PHP y SCSS de C6 aprobados conservan sus huellas |
| Guard/noindex | PASS: HTTP local 200 con noindex; partial directo y dirección simulada externa 404/cero bytes; Home/partial en CGI 404 sin contenido. Apache de posters pendiente de validación de destino |
| `git diff --check` | PASS; repetir también sobre el staging completo antes del commit |

En las primeras comparaciones geométricas aparecieron hasta 8px de diferencia en hijos del Hero por capturar distintas fases de su animación aprobada; los contenedores no cambiaron. También se detectó 1px en nodos de cabecera con caja 0×0, ocultos. No son cambios de fuente ni una modificación del diseño. La repetición estabilizada, comprobando ancho efectivo 768px en ambos documentos, registra delta 0 también en todos los descendientes con caja visible de las nueve secciones. El informe no presenta nodos sin caja como contenido desbordado ni afirma igualdad de fotogramas animados.

No ejecutado en este cierre: escucha humana, captions/transcripción, lector de pantalla auditivo, preferencia real del SO, Safari/Firefox, tacto físico, red móvil controlada, métricas de campo, Apache/GoDaddy ni certificación WCAG. Siguen siendo requisitos de publicación según corresponda, no afirmaciones técnicas heredadas como PASS.

Evidencia nueva externa: `C:/Users/Mike/.codex/visualizations/2026/11/02/01a19a13-8ab8-7bd2-9b75-d70c52219f8f/c6-close/`. Incluye `responsive.json`, `regression.json`, `functional.json`, `reduced-motion.json`, `no-scripts.json`, `initial-performance.json`, `security-structure.json`, capturas de viewport y huellas de protección. Herramientas y fuentes temporales permanecen fuera del commit. Los intentos de captura fullPage no disponibles se sustituyeron por capturas de viewport; no se presentan como capturas completas.

Reproducir con `npm run build`, iniciar `php -S 127.0.0.1:8000 -t .` si no existe servidor y abrir la URL real. Revisar 390/768/1280, Play de dos clips sucesivos, Next, Home/End, Tab/Shift+Tab y salida de la sección. La composición aprobada se mantiene; los bloqueos de publicación se retiran únicamente mediante la tarea futura indicada.

**HOME C6 READY FOR PR — VÍDEOS NO AUTORIZADOS PARA PRODUCCIÓN**

## Registro anterior — ajuste final del pie, 2026-11-01

El responsable aprueba visualmente la composición de C6 y solicita únicamente retirar las etiquetas decorativas Guest Story 01–04. El pie ahora alinea el H3 editorial existente y su duración verificada en una retícula de dos columnas, con título flexible y duración sin salto. No cambia ningún título, fuente audiovisual, poster, proporción, navegación, composición lateral ni token global. La posición accesible permanece en el estado del carrusel Wave 5, visualmente oculto; no se modifica su lógica.

Alcance de este ajuste: `includes/guest-stories.php`, `assets/scss/pages/_home-historias.scss` y este documento. Se conservan todos los cambios locales anteriores en `feature/home-guest-stories`. Sin commit, push, PR, merge ni deploy.

Verificación final con `qa-visual` en Home Preview: 390, 820 y 1440 px, más 320, 360, 425, 768, 992, 1024, 1280 y 2560 px. PASS: cero overflow de documento y de pies; cero etiquetas numeradas visibles; títulos y duraciones intactos. El pie mide 63,19 px en los tres anchos principales y 94,38 px en 320/360 al envolver el título. Las capturas incluyen los límites 320/2560 y los tamaños adicionales de la skill 768/1280. Consola sin errores ni warnings en la matriz; contenido audiovisual y foco Core conservados. No se afirma una nueva auditoría audiovisual ni aprobación humana posterior a este ajuste.

PASS: `npm run lint`, `npm run build`, `php -l includes/guest-stories.php`, las dos suites Node existentes y `git diff --check`. HTML estructural comprobado sin errores, IDs únicos y referencias ARIA resueltas.

Capturas reales en `C:/Users/Mike/.codex/visualizations/2026/11/01/01a19885-a6de-7b12-9de7-ed294b7d23b3/final-cards/`: `tarjetas-{390,820,1440}.jpg` y recortes `pie-*`, además de límites responsive, coordenadas y `responsive.json`. Los recortes muestran el final del vídeo y el pie, sin cambiar su contenido.

**Bloqueos de publicación intactos:** autorizaciones de personas, grabación y música; revisión editorial y auditiva completa; subtítulos sincronizados y alternativa textual integral. Las descripciones accesibles breves no sustituyen esos materiales. La protección de revisión local por CLI server y loopback permanece activa. Los registros inferiores conservan el historial; sus etiquetas decorativas ya no describen la UI vigente.

**HOME C6 EDITORIAL READY — WAITING FOR FINAL APPROVAL**

## Estado vigente — refinamiento editorial, 2026-11-01

La dirección conceptual está aprobada expresamente por el responsable. Este refinamiento conserva la composición; la revisión artística final del resultado sigue pendiente. **Publicación bloqueada** por escucha editorial completa, autorizaciones de personas/grabación/música, captions sincronizados y alternativa textual integral revisada. Los resúmenes accesibles actuales solo describen información visual; no sustituyen esos materiales. Retirar avisos de la UI no cierra ninguno de estos pendientes.

### Cambios de esta revisión

- Nuevo copy solicitado, en dos párrafos: vino/comida como punto de encuentro y personas/momentos que hacen sentir el lugar como casa. Eyebrow y titular intactos.
- Se retiran aviso Local preview, disclosures, información de permisos/transcripciones, enlaces a originales y descripciones visibles redundantes. Las tarjetas no contienen enlaces ni acciones comerciales.
- Pie reducido a Guest Story 01–04, duración confirmada y título neutral: A glass at the table; Together at the bar; By the window; Sharing the porron. No son declaraciones atribuidas a clientes.
- Descripción visual breve asociada mediante `aria-describedby`, fuera de la presentación visual. No se fabrica transcripción ni se afirma accesibilidad audiovisual completa.
- Flechas Core a la derecha, con estado de posición visualmente oculto y disponible mediante región polite/atomic. Se conserva el mismo motor Wave 5, Scroll Snap, import dinámico y reproducción nativa manual.
- Barra visual oculta únicamente cuando los controles JS están disponibles, mediante selector local `:has`. Sin scripts conserva la barra nativa y todos los vídeos. No hay transforms ni motor nuevo.
- El partial ahora exige también dirección remota loopback (`127.0.0.1`/`::1`), además de CLI server y bloqueo de acceso directo. La revisión sigue privada/local; no habilita Apache ni Home pública.

Solo se modifican en este refinamiento `includes/guest-stories.php`, `assets/scss/pages/_home-historias.scss` y este documento. Se preservan los cambios locales previos de C6. Rama `feature/home-guest-stories`; sin commit, push, PR, merge ni deploy. No se alteran módulos del carrusel, tokens, posters, originales ni otras secciones.

### Reanálisis audiovisual y límites

Se revisa nuevamente la relación entre fotogramas originales, posters y reproducción nativa. Se mantienen las referencias exactas del inventario inferior:

| Archivo | Clasificación provisional basada en imagen | Opinión explícita / publicación |
|---|---|---|
| `Client-1.mp4` | Conversación a cámara / interacción social con copa | Opinión hablada no verificada; pendiente |
| `Cliente-2.mp4` | Experiencia gastronómica y dos personas en el mostrador | Opinión hablada no verificada; pendiente |
| `clandetino-user.mp4` | Interacción social junto a la ventana | Opinión hablada no verificada; pendiente |
| `clandestino-experience.mp4` | Experiencia gastronómica con porrón y tabla de comida | No se presenta como testimonio verbal; pendiente |

No hay un clip puramente ambiental identificado entre estos cuatro: aparecen personas y acciones. La sesión no permite escuchar el audio; no se infiere su contenido por movimientos de boca, gestos o nombres de archivo. No se certifican inteligibilidad, idioma, música, fidelidad de una opinión ni selección narrativa definitiva. Duraciones, códecs, pesos y autorizaciones siguen en el inventario histórico inferior. Ningún original se modifica.

### QA de este refinamiento

| Comprobación | Resultado |
|---|---|
| `npm run lint`, `npm run build`, PHP lint, ambas suites Node existentes y `git diff --check` | PASS |
| HTML estructural, html5lib | PASS: sin errores, un H1, IDs únicos y referencias ARIA resueltas |
| Responsive final | PASS: 320, 360, 390, 425, 768, 820, 992, 1024, 1280, 1440 y 2560 px; overflow de documento cero |
| Composición/altura | PASS interno: pie 95,58 px salvo 320 px (126,77 por título en dos líneas). Sección 390: 1219→1139,56 px; 820: 1236,92→1128,52; 1440: 981,80→847,41. Vídeos sin cambio de proporción ni recorte |
| Contraste | PASS: 13 muestras de texto sobre superficies sólidas, mínimo 11.40:1; excluye disabled y controles internos del reproductor |
| Teclado/foco | PASS: Home/End hasta extremos; pista con anillo champagne de 2 px; navegación y controles nativos preservados |
| Play/exclusión/pausa | PASS: reproducción manual readyState 4; iniciar segundo pausa primero; navegar pausa todos |
| Scroll horizontal | PASS con entrada horizontal de laboratorio: 0→563 px y vídeo pausado; no equivale a touch físico |
| Fallo de vídeo | PASS: fuente deliberadamente inexistente produce código 4; título/contexto accesible permanecen; sin enlace MP4 añadido a la UI |
| Sin scripts | PASS: documento con cero scripts, controles ocultos, barra `auto`, overflow cero y último vídeo reproducible. No equivale a desactivar el motor JS desde ajustes |
| Ocultación de pestaña | PASS sintético: evento visibilitychange y document.hidden=true pausa los cuatro; ocultación real no verificable con esta herramienta |
| Reduced motion | PASS de rama JS sintética: End llega a 564/564; regla Foundation preservada. Preferencia CSS/OS real no emulada |
| Red y CLS inicial | PASS local en 390/820/1440: cero entradas MP4 antes de interacción, vídeos pausados readyState 0 y cero layout shifts. Sin throttling; no son métricas de campo ni garantía para otros navegadores |
| Consola | PASS en Home normal; sin warnings/errores en la revisión final. El 404 de ensayo queda limitado al laboratorio |

Se detectó y corrigió un defecto real: las descripciones visualmente ocultas tenían un bloque contenedor fuera de la pista y contribuían al overflow del documento. El posicionamiento relativo local de tarjeta/controles mantiene esas descripciones dentro de sus áreas. La matriz final anterior se ejecutó después de corregirlo.

Las capturas finales muestran composición completa con vídeo pausado, reproducción activa, pista desplazada y continuidad Private Experiences → Guest Stories → Wine Club en 390/820/1440. Se inspeccionó además la matriz responsive. Son revisión técnica/visual interna, no aprobación artística humana ni certificación WCAG. No se probaron dispositivos físicos, otros motores, lector de pantalla auditivo, ocultación real, preferencia reduced motion real ni hosting GoDaddy.

### Capturas y evidencia de esta revisión

Directorio externo al repo: `C:/Users/Mike/.codex/visualizations/2026/11/01/01a19885-a6de-7b12-9de7-ed294b7d23b3/refinement/`.

`comparacion-{390,820,1440}.jpg` muestra antes/después con escala horizontal equivalente y alturas naturales. El antes procede de `antes-final-*` de la entrega previa. `completa-*`, `active-*`, `desplazada-*` y `continuidad-*` cubren los estados solicitados; originales por tramos en `capturas.json`. `matriz-final.json`, `funcional.json`, `rendimiento.json`, `sin-scripts.json`, `error-visibilidad.json`, `gesto.json`, `reducido.json`, `contraste.json` y `html.html` conservan resultados. No se unen fotogramas en movimiento; la captura activa es un único viewport.

Revisar en `http://127.0.0.1:8000/home-preview.php#guest-stories`, primero 390, 820 y 1440 px. Antes de publicar, cerrar todos los bloqueos audiovisuales enumerados y validar en dispositivos/hosting de destino. La información de producción permanece interna y la protección local sigue activa.

**HOME C6 EDITORIAL REFINEMENT — WAITING FOR VISUAL APPROVAL**

## Registro histórico de la implementación inicial

El contenido inferior conserva el inventario y la evidencia anteriores. Sus descripciones de avisos visibles, disclosures y enlaces de recuperación han sido sustituidas por el refinamiento vigente descrito arriba; no son instrucciones para reintroducirlos.

Implementación local del 2026-11-01. Funcional en Home Preview; selección audiovisual provisional y publicación bloqueada por permisos, revisión auditiva y accesibilidad pendientes. No se considera una aprobación artística humana ni una autorización comercial.

## Git y alcance

Se verificó [PR #22](https://github.com/MaickR/clandestinoUSA/pull/22): fusionado hacia `develop`, commit de integración `bbd19b2c343d00ec290de2e8f2a37968404f76b9`. El árbol estaba limpio en `feature/home-visit`. Se ejecutaron `git fetch origin`, cambio a `develop`, `git merge --ff-only origin/develop` y creación de `feature/home-guest-stories` desde ese commit. Sin commit, push, PR nuevo, merge de publicación ni deploy. `main` no se modificó.

Se revisaron AGENTS, dirección visual, UX/UI, contratos de patrones, auditoría final, arquitectura, estándares, reglas SCSS/JS/PHP, Home actual, Customer Feedback legacy y el patrón audiovisual Wave 5. `index.html` conserva equivalencia con `production-baseline`, ignorando CRLF. Las fuentes de Header, Hero, Discovery, Pure Soul, Private Experiences, Wine Club, Gifting, Visit y Footer permanecen intactas, al igual que tokens, backend y analítica.

## Inspección de los once candidatos

Los once nombres proceden de las referencias reales de `index.html`, no de un inventario supuesto. Se inspeccionaron metadatos y seis fotogramas distribuidos por clip; FFmpeg decodificó por completo las once pistas audiovisuales sin error. No se modificó ningún original. Los otros nueve MP4 del directorio quedan fuera de los once candidatos de esta sección.

Todos son verticales, 478 × 850 px, H.264 High (`avc1`, `yuv420p`, progresivo), aproximadamente 30 fps, con AAC-LC estéreo. `Client-1` usa audio a 44,1 kHz; los restantes, 48 kHz. Los cuatro seleccionados se reprodujeron realmente en el navegador integrado, Chromium 156 sobre Windows. La decodificación de archivo no acredita compatibilidad en Safari, Firefox, iOS o Android; no se probaron esos entornos.

MB decimales. Cada fila hereda la resolución, orientación y códecs comunes indicados arriba.

| Archivo original | Duración | Bytes | MB | Audio: media / pico dBFS |
|---|---:|---:|---:|---:|
| `Client-1.mp4` | 50,73 s | 10 510 798 | 10,51 | −25,7 / −0,6 |
| `Cliente-2.mp4` | 90,88 s | 20 290 264 | 20,29 | −19,7 / −0,4 |
| `Cliente-4.mp4` | 66,20 s | 14 762 320 | 14,76 | −18,4 / −0,3 |
| `Cliente-5.mp4` | 26,56 s | 5 904 022 | 5,90 | −20,4 / −0,3 |
| `Cliente-7.mp4` | 31,83 s | 7 092 471 | 7,09 | −19,7 / −0,4 |
| `clandestino-experience.mp4` | 6,06 s | 1 316 107 | 1,32 | −19,6 / −4,8 |
| `clandetino-user.mp4` | 78,08 s | 17 432 868 | 17,43 | −20,4 / −0,3 |
| `clandestino-user-5.mp4` | 124,00 s | 27 686 048 | 27,69 | −21,4 / −0,3 |
| `clandestino-user-6.mp4` | 154,18 s | 34 275 209 | 34,28 | −20,9 / −0,2 |
| `clandestino-user-7.mp4` | 99,14 s | 22 124 416 | 22,12 | −25,2 / −0,4 |
| `clandestino-user-1.mp4` | 10,43 s | 2 329 621 | 2,33 | −17,1 / −0,3 |

### Contenido y calidad observable

La interfaz de esta sesión no admite escucha de audio. Se extrajeron pistas locales e intentó su inspección, pero no se obtuvo escucha ni transcripción fiable. Los niveles anteriores demuestran señal decodificable, no inteligibilidad, ausencia de ruido, idioma, equilibrio de música/voz ni calidad narrativa hablada. La revisión auditiva completa de **cada candidato** está pendiente; no se ha verificado una opinión explícita en ninguno. No se inventan transcripciones, citas, nombres, procedencia de invitados ni recomendaciones.

| Archivo | Contenido visual observado y calidad | Clasificación para esta revisión |
|---|---|---|
| `Client-1` | Persona sentada con copa de vino, conversación a cámara y gesto de brindis. Encuadre estable; luz interior cálida, cierta suavidad de imagen | Formato de entrevista visual; opinión explícita pendiente de escucha |
| `Cliente-2` | Comida, dos personas al mostrador y botellas en primer plano. Rostros legibles; las botellas ocupan buena parte del encuadre | Formato de entrevista con introducción gastronómica; opinión pendiente |
| `Cliente-4` | Persona con camiseta amarilla junto a botellas y bandera; conversación a cámara. Interior algo tenue y fondo ocupado | Formato de entrevista visual; opinión pendiente |
| `Cliente-5` | Montaje de platos, persona con gorra y otra persona sentada. Cambios de plano y escalas; repite visualmente parte del entorno de `Cliente-4` | Montaje de visita; no se acredita una opinión hablada |
| `Cliente-7` | Persona con copa y botella en exterior. Luz natural más clara; fondo distinto al comedor | Conversación a cámara; opinión y relación exacta con la visita pendientes |
| `clandestino-experience` | Persona usando un porrón junto a una tabla de comida. Movimiento breve, acción y comida reconocibles | Escena de experiencia; **no se presenta como testimonio hablado** |
| `clandetino-user` | Botella, invitados junto a la ventana y conversación a cámara. Expresión visible; contraluz de ventana y cámara móvil | Formato de entrevista visual; opinión pendiente |
| `clandestino-user-5` | Invitados alrededor de una mesa barril, botellas y comida. Cambios de interlocutor; imagen más suave y poca luz | Conversación de mesa extensa; opinión pendiente |
| `clandestino-user-6` | Dos personas con copa en planos sucesivos. Rostros legibles y fondo de botellas; clip más largo y pesado | Formato de entrevista visual; opinión pendiente |
| `clandestino-user-7` | Persona sentada con copa junto a banderas y botellas. Plano relativamente estable y contexto visible | Formato de entrevista visual; opinión pendiente; nivel medio bajo que requiere escucha |
| `clandestino-user-1` | Servicio de vino en barra y persona probándolo. Montaje corto y cercano | Escena de servicio/degustación; no se acredita una opinión hablada |

Para **cada uno de los once**: autorización de personas, grabación, reutilización, música y nueva publicación **no documentada / pendiente**. No se encontraron VTT/SRT asociados a esos nombres. La necesidad exacta de captions de habla/sonido, transcripción y descripción de información visual exige revisar el audio completo; antes de publicar se deben aportar subtítulos sincronizados cuando corresponda y una alternativa textual completa revisada. Un resumen de seis fotogramas no sustituye esa alternativa.

### Selección provisional para composición local

1. `Client-1`: retrato individual estable, copa y gesto final; abre la colección con una persona reconocible en lugar de una ficha comercial.
2. `Cliente-2`: pareja en el mostrador, comida y botellas; introduce una experiencia compartida diferente al primer retrato.
3. `clandetino-user`: encuentro junto a la ventana, otra luz y otra disposición de invitados; diversifica visualmente el relato.
4. `clandestino-experience`: gesto breve con el porrón y tabla de comida; aporta una escena de experiencia claramente diferenciada de las entrevistas.

Todos tienen la misma resolución: no se seleccionaron por número de píxeles. La diversidad de escenas, legibilidad visual y variedad de duraciones justifican esta **preselección**, pero la confianza narrativa y claridad del habla siguen pendientes de escucha humana. No se afirma que esta sea la selección editorial definitiva. Se evitó añadir siete piezas más y sus mayores pesos sin necesidad demostrada. Los títulos son contexto editorial de marca, nunca citas atribuidas.

## Dirección artística y adaptación

Se analizó en navegador el bloque `rts-tour-area rts-section-gapBottom pt--60 body-bg-one` de [Touriza](https://html.themewant.com/touriza/index-eight.html): introducción estable, tarjetas dominantes, pista independiente y siguiente pieza parcialmente visible. [Recode](https://html.rometheme.net/recode/bootcamp_detail.html) se consultó como referencia complementaria de relación entre introducción y media. No se adjuntaron las capturas del responsable a este mensaje; la inspección directa del sitio y los principios escritos del encargo guiaron la adaptación.

No se copiaron código, fotografías, librerías, amarillo, precios, descuentos ni composición de producto turístico. C6 usa una superficie oscura, fotografías auténticas, Libre Bodoni, champagne y el ornamento editorial ya existente. El relato permanece en el flujo vertical y no tiene sticky. No repite marco desplazado, tarjetas Diamond/Gold ni composición de Gifting.

Reutilización: `cl-seccion`, `cl-display`, `cl-eyebrow`, `cl-seccion__descripcion`, `cl-boton-icono`, sprite `cl-icon-siguiente`, foco Foundation, `cl-carrusel--video`, pista/item/contexto Wave 5, `cl-media-video__figura` y pantalla vertical. Solo se añade composición local bajo `cl-home-historias`. Los módulos `carrusel.js` y `carrusel-media.js` permanecen intactos.

## Responsive y reproducción

- 320–425 px: entrada centrada, una tarjeta protagonista y fragmento siguiente. En 320 px el vídeo mide aproximadamente 226 px de ancho; en 390 px, 286 px. La altura natural conserva el retrato completo.
- 600 px: entrada centrada y tarjeta limitada a 19 rem, con acceso horizontal al resto.
- 768, 820, 992 y 1024 px: relato arriba, pista debajo. Dos tarjetas y fragmento; anchuras de vídeo aproximadas de 286 px en 768/820 y 393 px en 992/1024. La columna audiovisual nunca queda comprimida junto al texto.
- Desde `xl` (1200 px): áreas laterales 4:7 con gutter Foundation; relato a la izquierda y dos tarjetas más fragmento a la derecha. Vídeos de 285–302 px en los tamaños de escritorio revisados. El contenedor Bootstrap limita el crecimiento en 2560 px.

CSS Grid y Scroll Snap conservan scroll horizontal nativo, incluido el acceso sin scripts. La navegación usa geometría y teclas del patrón existente; no hay autoplay ni reproducción al avanzar. Los cuatro reproductores son HTML5 nativos, con `controls`, `playsinline`, `preload="none"`, atributos 478/850, proporción reservada y `object-fit: contain`.

El adaptador existente pausa al iniciar otro vídeo, navegar o cambiar el rango visible, salir la colección del viewport, ocultarse el documento y destruir el componente. La navegación no introduce otra implementación de pausas. La fila de controles reserva su altura antes de cargar el módulo dinámico, evitando que desplace la pista al inicializar.

Los botones dependen de JS y parten de `hidden`. El fallback conserva los cuatro vídeos, textos, enlaces a originales y scroll CSS; `<noscript>` indica que se pause manualmente un vídeo antes de iniciar otro. La exclusión y las pausas automáticas necesitan JS. Los resúmenes y enlaces de recuperación quedan fuera de `<video>` y siguen accesibles si falla la reproducción.

## Rendimiento

`main.js` solicita ambos módulos mediante `import()` únicamente al encontrar `[data-cl-carrusel-media]`. Prueba del documento sin C6: cero solicitudes de chunks de carrusel. No se importan fixtures ni JS/CSS de Style Guide; el build no contiene Swiper ni dependencias nuevas.

Solo cuatro URLs MP4 forman parte del HTML de C6; los originales seleccionados suman 49 550 037 bytes, descargables a demanda. Los posters WebP auténticos pesan 36 854, 49 816, 35 836 y 33 990 bytes: **156 496 bytes en total**. Proceden de los instantes 27,9 s, 18,2 s, 42,9 s y 2,3 s respectivamente, sin recorte ni modificación de originales. C6 carga esos cuatro posters; no se afirma carga diferida de posters.

En la Home integrada observada a 390, 820 y 1440 px: cero entradas MP4 en Resource Timing antes de interacción, cuatro reproductores pausados con `readyState=0` y cero layout shifts registrados en la muestra inicial. El registro HTTP del laboratorio confirma la primera petición de `Client-1.mp4` después de Play. Resource Timing puede no registrar una petición de media hasta terminarla; no se equipara ausencia de una entrada durante reproducción con cero bytes descargados. PHP local, caché y sin throttling; esto no garantiza cero bytes en otros navegadores ni constituye rendimiento de campo. Apache/GoDaddy y respuestas Range quedan pendientes de validación.

## QA ejecutado

Skill aplicada: `.agents/skills/qa-visual/SKILL.md`. PHP 8.3.14, Chromium 156/Windows, navegador integrado; URL real `http://127.0.0.1:8000/home-preview.php#guest-stories`. Laboratorio externo al repositorio en `:8001`; no forma parte de la entrega de producto.

| Comprobación | Resultado y límite |
|---|---|
| Lint y build | PASS: `npm run lint` y `npm run build`; sin cambios de dependencias |
| PHP lint | PASS: `includes/guest-stories.php`, `home-preview.php` |
| Node existente | PASS: `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`; no hay script npm test |
| HTML estructural | PASS: html5lib sin errores, un H1/main, IDs únicos, referencias ARIA resueltas, imágenes con alt y cuatro vídeos. No es certificación Nu/W3C |
| Responsive/overflow | PASS: 320, 360, 390, 425, 600, 768, 820, 992, 1024, 1200, 1280, 1440 y 2560 px; ancho efectivo comprobado; overflow de documento cero |
| Revisión visual | PASS interno en matriz; primero 390/820/1440, además 768/1280 requeridos por la skill. Retratos completos, siguiente tarjeta visible y jerarquía legible. Aprobación humana pendiente |
| Relato estable | PASS con clic directo a coordenadas observadas en 390/820/1440: scroll vertical y posición del relato iguales antes/después; solo cambia scroll horizontal |
| Play manual y exclusión | PASS: cuatro originales alcanzaron `readyState=4`; iniciar el segundo pausa el primero. También comprobado en Home con el entrypoint compilado |
| Navegación y scroll | PASS: flechas, Home/End, foco de pista y scroll horizontal real. Gesto horizontal de laboratorio desplaza 0→519 px y pausa el vídeo; no es swipe en dispositivo físico |
| Teclado/foco | PASS: Tab atraviesa controles nativos y summaries sin trampa; pista, video exterior y summary muestran anillo Core 2 px / offset 3 px. Los subcontroles del reproductor usan foco nativo del navegador; no se certificaron otros motores |
| Targets | PASS: flechas 44 × 44 px en la matriz; summary con mínimo 44 px. No se sustituye ni redimensiona la UI nativa de vídeo |
| Contraste | PASS: 28 muestras de texto HTML sobre superficies sólidas, mínimo 9,69:1. Excluye disabled y controles internos del reproductor; no se certifica contraste sobre todos los fotogramas |
| Salida de pantalla/destrucción | PASS: reproducción activa se pausa tras salir del viewport; `destruir()` pausa y oculta controles; reinicialización con los módulos fuente existentes |
| Ocultar pestaña | PASS sintético del listener `visibilitychange` con `document.hidden=true` en laboratorio. El navegador integrado mantuvo `visible` al consultar otra pestaña: ocultación real no verificada |
| Reduced motion | PASS de rama JS con MediaQueryList reducido suministrado en laboratorio: Home=0, End=máximo. CSS Foundation revisado; no se emuló la preferencia del SO ni se afirma prueba real de media query CSS |
| Sin scripts | PASS en 390 y 1280: respuesta sin etiquetas script, cuatro vídeos y controles JS ocultos; Play nativo y acceso al último clip por foco/scroll. Es documento sin scripts, no motor JS deshabilitado desde ajustes; `<noscript>` inspeccionado en fuente |
| Error de vídeo | PASS: fuente inexistente en laboratorio produce `MEDIA_ERR_SRC_NOT_SUPPORTED` (4); contexto, resumen y enlace al original siguen disponibles |
| Recursos/CLS | PASS en las condiciones locales descritas: cero MP4 iniciales y CLS inicial 0 en 390/820/1440; import condicional comprobado sin C6 |
| Consola | PASS en Home normal: sin errores/warnings relevantes en el registro revisado. El 404 deliberado pertenece al caso de error del laboratorio |
| Protección | PASS: fuentes protegidas y módulos Wave 5 intactos; `index.html` equivalente a `production-baseline` ignorando CRLF; originales MP4 intactos |
| Whitespace | PASS: `git diff --check` |

Las primeras acciones de localizador desplazaban verticalmente el documento al llevar el control al foco. Se repitió la prueba mediante clic directo de coordenadas de captura: el producto conserva la posición vertical. Algunos intentos de inspección capturaron antes de estabilizar scroll; la evidencia final usa lectura posterior a estado estable. El ensayo previo de ciclo de vida también registró shifts del laboratorio; la medición final independiente de Home integrada, con la fila de controles reservada, presenta cero inicial. No se alteró el producto para ocultar la cabecera ni para producir capturas.

No ejecutado: escucha humana, valoración semántica del habla, subtítulos sincronizados, lector de pantalla auditivo, dispositivos táctiles físicos, Safari/Firefox, preferencia reduced motion del SO, desactivación del motor JS, validación Apache/GoDaddy, red móvil, métricas de campo o certificación WCAG. Estos límites no se presentan como pruebas superadas.

## Evidencia y reproducción

Directorio local externo al repo:

`C:/Users/Mike/.codex/visualizations/2026/11/01/01a19885-a6de-7b12-9de7-ed294b7d23b3/`

- `inventario.json`, once hojas `*.mp4.jpg` y audio extraído local; script `inspeccionar.py`.
- `c6-{ancho}.jpg` para los trece tamaños; originales por segmentos y `capturas.json`.
- `antes-final-{390,820,1440}.jpg`, `despues-{390,820,1440}.jpg` y `active-{390,820,1440}.jpg`.
- `continuidad-{390,820,1440}.jpg`: Private Experiences → Guest Stories → Wine Club.
- `clic-directo-{390,820,1440}.json`, `gesto-horizontal.json`, `teclado-390.json`, `contraste.json`, `structure.json`.
- `funcional.json`, `sin-scripts.json`, `sin-scripts-390.json`, `sin-componente.json`, `recursos-finales.json`, `recursos-tras-play.json`, `requests.jsonl`.
- `router.php`, `harness.js`, `monitor.js`: instrumentos locales, externos a producto. El harness de ciclo de vida inicializa una única instancia desde fuentes; el monitor integrado solo observa el entrypoint compilado.

Las capturas de sección completa y continuidad se componen de tramos reales sin cabecera superpuesta; los segmentos originales y coordenadas se conservan. Se normalizó el escalado de las imágenes devueltas por IAB a las coordenadas CSS antes de unirlas. Las capturas de reproducción son un único frame de viewport, sin unir escenas en movimiento.

Reproducir: `npm run build`; reutilizar PHP activo en `127.0.0.1:8000` o iniciar `php -S 127.0.0.1:8000 -t .`; abrir `/home-preview.php#guest-stories`. Comprobar primero 390, 820 y 1440 px, navegar con flechas/teclado, reproducir dos clips sucesivos, salir de la sección y volver. No iniciar otro servidor sobre el mismo puerto.

## Archivos de producto y documentación

1. `includes/guest-stories.php`: partial local con cuatro clips, contextos, controles y avisos de acceso.
2. `home-preview.php`: require entre Private Experiences y Wine Club.
3. `assets/scss/pages/_home-historias.scss`: composición local y reserva de navegación.
4. `assets/scss/home.scss`: imports de los dos patrones existentes y del ajuste local.
5. `assets/js/main.js`: imports dinámicos condicionales e inicialización de los módulos existentes.
6. `assets/images/guest-stories/{conversacion,juntos,encuentro,momento}.webp`: cuatro posters derivados autorizados para revisión local.
7. `docs/HOME-PHASE-C6.md` y `docs/ARQUITECTURA.md`: contrato, inventario, QA y pendientes.

## Antes de publicación

La vista previa y el partial están restringidos al servidor CLI local. No activar este contenido en una Home pública mientras no se cierre lo siguiente:

1. Escuchar íntegramente los once candidatos, verificar opiniones explícitas y decidir la selección narrativa final; comprobar claridad, música/voz y ausencia de contenido fuera de contexto.
2. Documentar autorización de personas y derechos de grabación, música y reutilización para la nueva publicación.
3. Crear y revisar captions sincronizados apropiados, transcripción y alternativa de información visual según cada film. Los resúmenes actuales no son alternativa completa ni sustituyen captions.
4. Obtener aprobación visual humana de C6 y validar reproducción, carga y acceso en los navegadores/dispositivos y hosting de destino.
5. Solo en una tarea de publicación explícita: resolver el bloqueo local del partial y retirar el aviso provisional cuando la documentación anterior lo permita.

**HOME C6 GUEST STORIES READY — WAITING FOR VISUAL APPROVAL**
