# Home Hero — iluminación, motion y autoplay

## Cierre final aprobado — 2026-11-02

**El responsable del proyecto aprueba visualmente el Hero definitivo en desktop, tablet y móvil, incluido el último degradado vertical. HOME HERO REFINEMENT READY FOR PR.** Esta aprobación sustituye los pendientes visuales de los registros históricos inferiores. El cierre audita y prepara un único commit/push para PR manual hacia `develop`; no autoriza crear el PR automáticamente, hacer merge, modificar `main` ni desplegar.

### Consolidación y alcance definitivo

Tras `git fetch origin`, las ramas locales `feature/home-hero-refinement` y `feature/home-hero-mobile-tablet-fix` apuntaban a `75696b06679aa7c92f711deccee2e6af1c24d6d0`, igual que `origin/develop`. Ninguna tenía commits propios. Ambas iteraciones estaban ya reunidas como cambios sin commit en el estado de trabajo de `feature/home-hero-mobile-tablet-fix`: degradado lateral aprobado y corrección vertical definitiva. No se requiere integrar ramas, cherry-pick, rebase, reset ni limpieza.

Se conserva esa versión exacta en **una sola rama de publicación: `feature/home-hero-mobile-tablet-fix`**, con el commit solicitado `style(home): perfeccionar degradado cinematográfico del hero`. La rama inicial queda en su base, sin publicarse en este cierre. El diff efectivo frente a `origin/develop` contiene únicamente `assets/scss/home.scss`, este informe y `docs/VISUAL-DIRECTION.md`.

El SCSS aprobado no se modifica durante el cierre: SHA256 `106F3C556400C37C953A26D12B667C9AD43CBE74AF10C2F2BE72791953D524C5`. Su CSS recompilado coincide byte a byte con el aprobado: `F93C7715519D33D93656A8D3A84655426DF74A975376DD2D5F3C3EEA6AD0BC91`. Frente al CSS de develop solo difieren los dos fondos del overlay local. La curva vertical 72%→58% por debajo de `lg` y el degradado lateral desde 992px quedan congelados; no cambian fotografías, encuadres, copy, CTA, indicadores, autoplay, transiciones, Header, alturas ni secciones posteriores.

`docs/HOME-FINAL-AUDIT.md` permanece sin seguimiento y fuera del commit, con SHA256 `49B97D8320715F61AC0BCAEAE196E847C56B6F397CA971B29D9CCFCE75932BCC`. La lista del staging se limita expresamente a los tres archivos del Hero. No se añaden capturas, scripts externos, outputs compilados ni dependencias.

### QA de cierre y reproducción

Se reutiliza la skill `qa-visual`. Chrome/Chromium `156.0.8078.74`, Windows, DPR 1, fuentes cargadas, build de producto y PHP local en `http://127.0.0.1:8000/home-preview.php`. Capturas de las tres escenas en **390/820/1440px**, más límites **320/360/425/768/992/1024/1200/1280/2560px**: 36 casos. Geometría, encuadres, copy, estados de escenas y secciones coinciden con la versión aprobada; cero overflow o texto recortado.

| Verificación actual | Resultado |
|---|---|
| Inspección visual y contraste | PASS: tres escenas y límites responsive. Mínimos en los 36 casos: eyebrow 5,03:1, título 5,21:1, descripción 5,05:1; CTA 12,69:1 / 16,01:1. Sin nuevas bandas, cajas o controles |
| Slider/teclado | PASS: nueve transiciones automáticas reales entre 820 y 390px, máximo un timeout; bullets, Home/End/flechas, pausa/reanudación, hover/foco, Tab por ambos CTA, reduced motion emulado y fallback sin JS. Drawer/Escape/retorno y sticky válidos |
| Consumidores compartidos | PASS: Navigation y Patterns en 390/820/1440, seis documentos. Hero editorial e interior conservan el radial compartido, sin overlay local del slider ni carga de `home.css`; sin errores de página ni HTTP ≥400. Assets exclusivos de guía compilados en memoria y servidos solo al navegador de QA, sin incorporarlos al build de producto |
| HTML/recursos | PASS estructural: 49 IDs únicos, un h1/main, cierres, alt y referencias ARIA/for correctas; 44 recursos locales HTTP 200. Sin error de consola o página en Home. Una petición de banner 768px se canceló entre cargas (`ERR_ABORTED`); todas las imágenes finales decodificaron, sin recursos ausentes |
| Comandos | PASS: `npm run lint`, `npm run build`, `php -l` en los 54 PHP seguidos, `node scripts/probar-carrito.mjs`, `node scripts/probar-cierre-comercio.mjs` y `git diff --check`; staging revisado antes del commit |

Evidencia actual fuera de Git: `C:/Users/Mike/.codex/visualizations/2026/11/02/01a19e81-7088-74b0-800a-9c60ea029fa1/hero-close/`. Láminas `escenas-{390,820,1440}.png`, capturas `after-*`, pruebas `shared-*`, manifiesto `cierre.json`, `shared.json`, `funcional-{390,820}.json` y `estructura.json`. Las evidencias anteriores de comparación se conservan en las carpetas hermanas. Reproducir con build, PHP local y recorrido de los tres bullets en esos tamaños.

El tratamiento cinematográfico aprobado queda disponible como referencia editorial en Visual Direction; su implementación sigue limitada a Home y no se aplica automáticamente a otras páginas. No quedan bloqueantes técnicos ni aprobación visual pendiente del Hero dentro de este alcance. Continúan los límites de prueba: Safari/Firefox, dispositivo táctil físico, lector auditivo, zoom real 200%, preferencia reduced motion real del SO y contraste de todos los frames no verificados. Las dependencias comerciales y de publicación de Home son tareas externas; no se activan mediante este cierre.

## Corrección mobile/tablet — 2026-11-02

Rama `feature/home-hero-mobile-tablet-fix`. **Desktop aprobado por el responsable y conservado exactamente. Mobile/tablet pendiente de aprobación visual humana.** Esta revisión sustituye la valoración interna anterior que no detectó correctamente las bandas del tratamiento vertical. Los registros inferiores conservan su contexto histórico; no autorizan commit, push ni publicación en esta tarea.

### Causa y cambio mínimo

Se verificaron estado local y `git fetch origin`: la rama anterior `feature/home-hero-refinement`, `develop` y `origin/develop` parten de `75696b0`, sin divergencia. Los tres archivos modificados del refinamiento anterior seguían sin commit. Se creó la nueva rama sobre esa base conservando el trabajo, incluido el desktop aprobado. `docs/HOME-FINAL-AUDIT.md` sigue sin seguimiento e intacto, SHA256 `49B97D8320715F61AC0BCAEAE196E847C56B6F397CA971B29D9CCFCE75932BCC`.

La causa es tonal: el overlay vertical anterior pasaba de 20% de opacidad arriba a 77% al 30% de altura y regresaba a transparencia en la base, con varios cambios de pendiente. Esa acumulación central y la recuperación rápida de luz en ambos extremos hacían perceptibles zonas horizontales separadas. **No era una máscara incompleta ni un fallo de altura, overflow o stacking**: Hero, media e imagen ya tenían las mismas cajas en las tres escenas (390: 479,52px de altura; 820: 518,69px), y `::after` conserva `inset: 0`. El radial compartido continúa anulado en Home.

Se reemplaza únicamente el fondo vertical local por `linear-gradient(to bottom, rgba($neutral-950, 0.72), rgba($neutral-950, 0.58))`: una sola interpolación continua de altura completa, sin picos centrales, transparencia final, paradas intermedias, cajas o capas nuevas. La lectura permanece protegida y el detalle de la fotografía atraviesa toda la superficie. Solo cambian una declaración `background` y su comentario respecto al estado recibido.

**Alcance efectivo: anchos menores de 992px**, mediante la cascada mobile first ya existente. No se agrega ningún breakpoint. El bloque `media-breakpoint-up(lg)` y su fondo lateral conservan exactamente el texto SCSS previo; desde 992px el valor computado es idéntico. No cambian composición, encuadres, fuentes, altura, copy, CTA, Header, assets, partial compartido, JS, autoplay, controles ni transiciones.

### QA de la corrección

Chrome/Chromium `156.0.8078.74`, Windows, DPR 1, fuentes cargadas y PHP local. Matriz de **30 casos antes/después**: las tres escenas en **320, 360, 390, 425, 768, 820, 992, 1024, 1280 y 1440px**. Misma altura de viewport antes/después: 1000px en teléfono y 1100px desde tablet. Se aplica la skill local `qa-visual`; las tomas estáticas usan reduced motion emulado y las pruebas de autoplay movimiento habilitado.

| Comprobación | Resultado actual |
|---|---|
| 390/425/768/820 y extremos 320/360 | PASS interno: tres escenas inspeccionadas; fotografía continua, sin máximos horizontales de sombra, cajas o bandas añadidas por el overlay; texto integrado y CTA intactos |
| Geometría/overflow | PASS: cero cambios de cajas, encuadres, fuentes de imagen, copy, CTA o secciones posteriores en los 30 casos; sin overflow de documento ni texto recortado por ancestros |
| Desktop | PASS: bloque SCSS desde `lg` idéntico; comparación controlada de antes/después en el mismo documento e imagen decodificada, tres escenas a 992/1024/1280/1440: **cero canales de píxel distintos**. 1440 también coincide exactamente entre las dos sesiones independientes de la matriz |
| Alcance CSS y Header | PASS: solo una declaración compilada difiere respecto al estado recibido, el fondo vertical local. Los 60 recortes independientes de Header/comienzo de sección siguiente coinciden; estilos ajenos e interiores intactos |
| Slider y accesibilidad funcional | PASS: autoplay real a 820 y 390; dos vueltas y una vuelta respectivamente, máximo un timeout. Bullets, Home/End/flechas, pausa/reanudación, hover/foco, `inert`/`aria-hidden`, transición y estado final válidos. Reduced motion emulado sin timers/animación y navegación manual operativa; primera escena y acciones disponibles sin JS. Drawer/Escape/retorno y sticky conservados |
| HTML/recursos/consola | PASS: cierres equilibrados, 49 IDs únicos, un h1/main, alt y referencias ARIA/for; 44 recursos locales HTTP 200. Sin errores de página, consola ni HTTP ≥400 en la matriz final |
| Comandos | PASS: `npm run lint`, `npm run build`, `php -l` sobre los 54 PHP seguidos, ambas suites Node existentes (`probar-carrito.mjs`, `probar-cierre-comercio.mjs`) y `git diff --check` |

Contraste mínimo **mobile/tablet** entre los seis anchos menores de 992px, con captura del fondo y máscara de glifos interiores, luminancia sRGB; método y límites descritos en el registro anterior:

| Escena | Eyebrow | Título | Descripción | CTA primario / secundario |
|---|---:|---:|---:|---:|
| Spanish Gastronomy | 5,60:1 | 5,54:1 | 5,14:1 | 12,69:1 / 16,01:1 |
| Social Experience | 5,22:1 | 5,76:1 | 6,59:1 | 12,69:1 / 16,01:1 |
| Pure Soul | 5,03:1 | 5,47:1 | 5,05:1 | 12,69:1 / 16,01:1 |

### Evidencia y límites

Carpeta externa `C:/Users/Mike/.codex/visualizations/2026/11/02/01a19e81-7088-74b0-800a-9c60ea029fa1/mobile-tablet-fix/`. Comparativas `comparativa-{390,820,1440}.png`: fila superior estado recibido, inferior corrección, columnas escenas 1/2/3. Fuentes `before/after-{ancho}-{escena}.png`; láminas incluyen 425 y 768; `desktop-before/after-*` acredita la comparación controlada. Informes `comparacion.json`, `desktop.json`, `regresion.json`, `funcional-{390,820}.json`, `estructura.json`; scripts de QA y respaldo del estado recibido fuera del repositorio.

Dos capturas independientes de escena 2 a 992/1024 presentaron variaciones de rasterización de hasta 2/255 y 1/255 respectivamente; se conservaron y se comprobó el mismo documento alternando las hojas antes/después con la foto ya decodificada: diferencia cero en los 12 casos desktop. El primer ensayo de teclado enviaba Escape mientras Bootstrap aún abría el drawer; se corrigió la espera del laboratorio hasta finalizar `showing`, sin tocar JS del producto.

Reproducir: `npm run build`, reutilizar PHP en `127.0.0.1:8000` y abrir `http://127.0.0.1:8000/home-preview.php` recargando el CSS; revisar las tres escenas primero en 390/425/768/820 y comprobar desktop a 1440. Se mantienen los límites de navegador, dispositivo táctil físico, lector de pantalla, zoom real 200% y contraste de cada frame de animación. HTML estructural no equivale a validación W3C ni se certifica WCAG integral.

Pendiente real: aprobación visual humana de **mobile/tablet**; desktop no se reabre. Sin commit, staging, push, PR, merge ni deploy. No se modificaron dependencias comerciales o de publicación de Home.

**HOME HERO MOBILE/TABLET OVERLAY FIX — WAITING FOR VISUAL APPROVAL**

## Refinamiento cinematográfico — 2026-11-02

Rama `feature/home-hero-refinement`. **HOME HERO CINEMATIC REFINEMENT — WAITING FOR VISUAL APPROVAL**. Este registro describe el estado actual; los apartados inferiores conservan la iluminación, pruebas y autorizaciones históricas de octubre. No se heredan sus permisos de commit/push ni su aprobación estética para este nuevo tratamiento.

### Base, protección y diagnóstico

`git fetch origin` confirmó el merge de PR #24 en `origin/develop`: `75696b06679aa7c92f711deccee2e6af1c24d6d0`, con `8654aee` como segundo padre. Se actualizó `develop` por fast-forward desde `34e80a6` y se creó la rama solicitada. Único archivo ajeno al comenzar: `docs/HOME-FINAL-AUDIT.md`, sin seguimiento. Se inspeccionó y conservó byte a byte: SHA256 `49B97D8320715F61AC0BCAEAE196E847C56B6F397CA971B29D9CCFCE75932BCC`. Sus observaciones de integración son históricas; no se sobrescribe el informe. `index.html` y `reservation.php` coinciden funcionalmente con `production-baseline` al ignorar CRLF/LF; allí no existen este anfitrión PHP ni el slider nuevo.

Se revisaron AGENTS, Visual Direction, UX/UI, Section Pattern Library, este informe, C7, reglas SCSS, entrada Home, patrones Hero/Core, partial compartido y sus consumidores (Home, Navigation y Patterns), `main.js` y `escenas-hero.js`. No se modificó código antes de revisar la composición de las tres escenas y capturar el estado previo.

El efecto gris no procedía de un panel separado, filtro ni del radial de Wave 1: `.cl-hero--slider .cl-hero__contenido::before` ya lo anulaba con `content: none`. Lo producía `cl-hero__media::after`: fondo uniforme cálido del 14% más degradado con meseta del 61%, equivalente a **66,46%** de opacidad combinada. Esa meseta ocupaba el 12–70% de la altura en móvil/tablet y el 0–40% del ancho desde `lg`; la base uniforme mantenía un velo incluso fuera de la lectura. La extensión casi constante de densidad generaba la percepción de una zona mate separada.

Stacking conservado: raíz y escenas Grid con `isolation`; escenas en la misma celda, activa con `z-index: 1`; foto absoluta dentro de media relativo/aislado y pseudo-elemento de protección `z-index: 1`. La estructura de lectura es otro grid item, posterior al media y con `z-index: 1`; el contenido mantiene su propio aislamiento. Indicadores y pausa permanecen a niveles 3 y 4. La foto y su protección siguen fundiéndose juntas durante 720ms, con relato independiente de 520ms. No hay nueva capa sobre los textos.

### Solución y responsive

Solo se sustituyen las dos declaraciones `background` de ese pseudo-elemento en `assets/scss/home.scss`, usando `$neutral-950` y el breakpoint Bootstrap existente. Sin nuevos tokens, dependencias, reglas globales, marcado, JS, controles o filtros. `_hero.scss`, PHP compartido, interiores, C7 y módulos de comportamiento conservan sus fuentes.

- **Teléfono/tablet, por debajo de 992px:** un degradado vertical sin velo adicional. Opacidad 20% arriba, 68% al 12%, 77% al 30%, 75% al 52%, 62% al 72%, 28% al 88% y transparencia en la base. Protege el relato centrado sin la meseta anterior y recupera iluminación en los extremos. El texto permanece dentro de la foto.
- **Desde 992px:** degradado lateral de 94% a la izquierda, 86% al 18%, 72% al 34%, 58% al 50%, 26% al 68%, 6% al 84% y transparencia a la derecha. La transición continua adapta el principio de C7 a la composición del Hero. El refuerzo central final mejora el margen de la descripción a 992px y del título de Pure Soul a 2560px sin extender una oscuridad uniforme.
- **Tres escenas:** la misma curva en cada formato; sin excepciones por imagen. Encuadres conservados: mesa `51% center`, encuentro `right center` en teléfono y `center` desde md, vino `62% center`. No cambian altura, contenedor, alineaciones, copy, destinos, padding, botones ni bullets.

El criterio queda registrado en Visual Direction para futuros banners; no se aplica a ninguna otra sección ni se crea una abstracción global sin otro consumidor real.

### QA actual

Chrome/Chromium `156.0.8078.74`, headless, Windows, DPR 1, fuentes cargadas, servidor PHP local y build de producto. Capturas estáticas con reduced motion emulado; autoplay y transiciones se probaron además con movimiento habilitado. Anchos **320, 360, 390, 425, 768, 820, 992, 1024, 1200, 1280, 1440 y 2560px**, las tres escenas en cada uno: **36 casos antes/después**. Altura de viewport 1000px en teléfonos, 1100px en tablet/escritorio y 1200px a 2560.

| Comprobación | Resultado real |
|---|---|
| Composición/responsive | PASS: geometría de foto, contenido, títulos, descripciones, acciones, Header y todas las secciones idéntica antes/después en los 36 casos; mismas fuentes/encuadres; sin overflow de documento ni glifos cortados por ancestros. Se distingue el desborde tipográfico visible de Bodoni de un recorte real |
| Inspección visual | PASS interna: tres escenas comparadas en 390/820/1440 y revisadas además en los otros nueve anchos; sin franjas, rectángulos nuevos, vacíos o discontinuidades espaciales. Se conserva el cambio de alineación aprobado en `lg` |
| CSS y regresiones | PASS: comparación de declaraciones compiladas encuentra únicamente los dos fondos del overlay. Header y comienzo de la sección siguiente: 72 recortes antes/después, cero canales de píxel distintos. C7 y demás estilos coinciden; ninguna regla compartida modificada |
| Autoplay/interacción | PASS: seis transiciones automáticas reales, dos vueltas, intervalos posteriores ~6,5s y máximo un timeout. Carga diferida de escenas 2/3 conservada; hover/foco pausan y se recuperan; selección manual pausa; Resume, bullets, Home/End/flechas válidos; `inert`/`aria-hidden` coherentes en las tres escenas |
| Movimiento | PASS: fundido y entrada existentes, estado final opacity 1/transform none; reduced motion emulado deja cero timers, animation none y navegación manual válida. Swipe mediante PointerEvents sintéticos, sin prueba física táctil |
| Teclado/Header/foco | PASS: pausa existente aparece al foco, anillo 2px; navegación del slider por teclado. Drawer abre con Enter, Escape cierra y devuelve foco; Discover y sticky comprobados, sin backdrop residual. Sin JS: primera escena y sus dos acciones disponibles, indicadores ocultos |
| HTML/recursos/consola | PASS estructural: cierres equilibrados, 49 IDs únicos, referencias ARIA/for resueltas, un h1/main y alt en imágenes; 44 recursos locales responden 200. Sin pageerror, error de consola ni HTTP ≥400. La matriz registró una petición de banner de 768px cancelada (`ERR_ABORTED`) entre cargas; todas las imágenes finales decodificaron correctamente. No se presenta esa cancelación como un 404 ni como recurso ausente |
| Comandos | PASS: `npm run lint`, `npm run build`, `php -l` en los 54 PHP seguidos, `node scripts/probar-carrito.mjs`, `node scripts/probar-cierre-comercio.mjs` y `git diff --check` |

Contraste actual mínimo de los 12 anchos por escena, muestreado sobre captura del fondo sin texto y máscara blanca de glifos interiores (canales ≥230), con colores computados y luminancia sRGB; incluye rangos tipográficos que sobresalen de su caja sin estar recortados. Son muestras en reposo, no una certificación WCAG integral ni contraste de cada frame de entrada.

| Escena | Eyebrow | Título | Descripción | CTA primario / secundario |
|---|---:|---:|---:|---:|
| 1 · Spanish Gastronomy | 6,14:1 | 7,07:1 | 5,45:1 | 12,69:1 / 16,01:1 |
| 2 · Social Experience | 5,76:1 | 6,83:1 | 7,65:1 | 12,69:1 / 16,01:1 |
| 3 · Pure Soul | 5,60:1 | 5,21:1 | 6,02:1 | 12,69:1 / 16,01:1 |

### Evidencia, reproducción y pendientes

Evidencia externa, sin temporales ni capturas añadidas a Git: `C:/Users/Mike/.codex/visualizations/2026/11/02/01a19e81-7088-74b0-800a-9c60ea029fa1/hero-refinement/`. `comparativa-{390,820,1440}.png`: fila superior antes, inferior después, columnas escenas 1/2/3. Originales `before/after-{ancho}-{escena}.png`; láminas `qa-telefonos`, `qa-intermedios`, `qa-escritorio`; `referencia-c7.png`; JSON `before-matrix`, `after-matrix`, `comparacion`, `regresion`, `funcional` y `estructura`. Scripts externos reproducibles `matriz.cjs`, `comparar.cjs`, `regresion.cjs`, `funcional.cjs` y `estructura.py`.

Para revisar: `npm run build`; reutilizar PHP en `127.0.0.1:8000` o iniciar `php -S 127.0.0.1:8000 -t .`; abrir `http://127.0.0.1:8000/home-preview.php`, recorrer los tres bullets primero en 390/820/1440 y después la matriz indicada. El anfitrión sigue siendo local/noindex. Solo cambian Home SCSS, este informe y Visual Direction. Sin commit, staging, push, PR, merge de publicación ni deploy.

Pendiente real del encargo: **aprobación visual humana del nuevo tratamiento en las tres escenas**. Límites: no Safari/Firefox, dispositivos táctiles físicos, lector de pantalla auditivo, zoom real 200%, preferencia reduced motion del SO ni contraste de todos los frames de animación. HTMLParser no equivale al validador W3C; las pruebas locales no validan Apache/GoDaddy ni servicios comerciales. Las dependencias externas de publicación de Home permanecen fuera de este refinamiento; no se activa ninguna función.

---

2026-10-23. Rama feature/home-header-hero. **Diseño considerado satisfactorio por el usuario; entrega técnica preparada para revisión hacia develop.** La solicitud «HOME HEADER + HERO FINAL DELIVERY» autoriza commit y push de esta vista previa, sin crear PR automáticamente, fusionar ni desplegar. El registro de iluminación y motion siguiente conserva la evidencia del refinamiento anterior; el cierre de integración figura al final. Fuentes anteriores respaldadas fuera del repositorio en lighting-motion/antes.json.

## Iluminación

La versión anterior combinaba 24% global y 56% direccional: 66,56% efectivo donde se superponían. Se compararon las tres escenas a 425/768/1440 con referencia, intermedia (16% + 54%) y ligera (12% + 46%). Intermedia: mínimo 3,83:1; ligera: 2,81:1. Se descartan por contraste insuficiente.

Elegida adaptación: global **14%**, refuerzo máximo **61%**, efectivo **66,46%** solo en una zona más concentrada. Móvil/tablet: 12% de refuerzo arriba, máximo entre 12–70% de altura, transparente al final; antes el máximo llegaba al 78% y el borde inferior mantenía 16%. Desktop: máximo hasta 40% de ancho (antes 48%), 28% al 64%, transparente desde 92%. La región de lectura conserva protección y el resto de la fotografía recupera luz. Sin radial, caja, nuevo color ni cambio de encuadre. Promedio RGB de las capturas completas aumenta 5,2–10,2%; es una comparación de píxeles, no una medida física de exposición.

Contraste mínimo en reposo, muestreo de fondo bajo glifos renderizados; tres escenas en 390/425/768/1024/1280/1440/2560, Chromium DPR 1:

| Escena | Eyebrow | Título | Descripción |
|---|---:|---:|---:|
| 1 · Spanish Gastronomy | 4,59:1 | 5,55:1 | 5,48:1 |
| 2 · Social Experience | 4,60:1 | 5,55:1 | 6,01:1 |
| 3 · Pure Soul | 4,64:1 | 4,98:1 | 5,56:1 |

CTA: 12,69:1 primario y 16,01:1 secundario entre texto/fondo Core, sin cambios. Indicadores: 13,59:1 entre champagne y oscuro; anillo bicolor con límite calculado ≥3,69:1 de al menos uno de sus tonos contra cualquier luminancia de fondo. Ese límite es teórico, separado del muestreo fotográfico; target 44px y activo por forma, además de color. No se certifica WCAG global.

## Motion

Foto entrante: fundido de 720ms sobre la foto saliente opaca, sin fundir ambas contra negro. Fondo local de escena transparente para permitir ese cruce; geometría y encuadre intactos. El contenido saliente se oculta inmediatamente para no mezclar mensajes. Eyebrow/título/descripción/CTA entran con opacidad y 8px verticales durante 520ms; delays 0/40/90/120ms. Finaliza en transform:none y opacity:1, sin capa transformada permanente. Reduced motion elimina animaciones/desplazamiento y el cambio de visibilidad retardado.

## Pausas: causa y corrección

Reproducido con el módulo anterior respaldado, sin ejecutar dos controladores: focusin fijaba intencion=false; salir no lo restablecía. Cualquier pointerdown en la pista también lo fijaba permanentemente, incluso un tap o click sin navegación. Ambos seguían en paused tras esperar más de un intervalo.

Se sustituye el booleano ambiguo por un Set de causas independientes. Estados diagnósticos: running, loading, paused-hover, paused-focus, paused-hidden-document, paused-out-of-view, paused-user, disabled-reduced-motion, paused-image-error y destroyed. El atributo de causas conserva las simultáneas. Hover/foco/visibilidad/intersección son temporales; se reanuda solo cuando no queda ninguna. Un evento repetido sin cambio de causa no reinicia el intervalo.

Bullet, teclado o swipe reconocible siguen siendo interacción manual deliberada y pausan hasta Resume. Un tap/click vacío ya no deja una pausa permanente. El control de pausa existente permanece disponible a lector de pantalla y visible al foco, anillo de 2px. Reduced motion bloquea autoplay y permite navegación manual. Anuncio solo manual/error, no en cada cambio automático.

Un solo timeout de 6500ms; se limpia al cambiar estado/navegar/destruir. Decode está protegido por generación y revisión de pausas: una petición antigua no cambia escena tras una pausa o destrucción. Error conserva escena legible y permite reintentar por control existente. Se mantienen API e idempotencia WeakMap, sin modificar carrusel.js ni main.js.

## QA ejecutado

- npm run lint, npm run build, php -l home-preview.php, HTML estructural (cierres, IDs únicos, H1, alt) y git diff --check: PASS. Se corrigieron espaciado de keyframes y especificidad de reduced motion antes del cierre. Assets de guía restaurados tras build.
- 16 transiciones consecutivas reales, varias vueltas; intervalos posteriores al primero ~6,5s. Instrumentación del timeout real: máximo uno activo, sin acelerar el reloj.
- Hover y foco entrar/salir repetidos, causas simultáneas, click vacío, pausa manual durante >6,5s/reanudación y recuperación efectiva de escena: PASS.
- Visibility API emulada: cero timers al ocultar; recupera running al volver. IntersectionObserver nativo con espacio añadido solo al DOM de QA para poder desplazar totalmente el Hero fuera de vista: pausa y recuperación correctas.
- Resize durante transición, móvil↔desktop, entrada de contenido y final transform:none: PASS. Reduced motion: animation:none, transform:none, cero timers y navegación manual válida.
- Idempotencia, destruir/reinicializar y destruir con decode pendiente: PASS; 0 timers tras destruir, 1 tras reiniciar, petición tardía no activa otra escena.
- Geometría final de foto/contenido/título/descripción/CTA idéntica a la referencia en 15 casos de los cinco anchos obligatorios; adicionales 390/1280, sin overflow horizontal. Capturas de tres escenas por ancho y variantes inspeccionadas.
- Style Guide smoke: Reviews y vídeo End/Home hasta extremos, galería abrir/Escape/retorno; sin errores de página observados. Home: sin pageerror ni HTTP ≥400 en sesión revisada. No se certifica toda la matriz histórica.

Recursos: CSS 62906 B / 11547 B gzip; JS 38378 B / 12155 B gzip. Laboratorio local sin throttling: LCP inicial 425px 1312ms, 1440px 1268ms; CLS 0 en ambas muestras. Solo primer banner solicitado al inicio. No equivalen a Core Web Vitals de campo.

Código editado: assets/scss/home.scss y assets/js/modules/patterns/escenas-hero.js. Documentación: este registro y notas Home en ARQUITECTURA.md / SECTION-PATTERN-LIBRARY.md. Home PHP, main.js, carrusel de colecciones, Wave 1 global, Header/nav/drawer y index.html idénticos al inicio. Sin nuevas dependencias, imágenes, rutas ni controles.

Evidencia: C:/Users/Mike/.codex/visualizations/2026/10/21/01a15f31-e70b-75b1-a2ca-76cd17ea7ffc/lighting-motion/. comparativa-{425,768,1024,1440,2560}.png: arriba anterior, debajo final, columnas escenas 1/2/3. variantes-{425,1440}.png; entrada-100.png / entrada-final.png. JSON: contraste-por-escena, contraste-controles, geometria-comparada, reproduccion-anterior, estabilidad, ciclo-vida, regresiones, rendimiento, html y proteccion.

Limitaciones reales: cambiar de pestaña en este Chromium headless no cambió document.hidden; no se afirma prueba nativa de pestaña oculta. Se probó su política mediante Visibility API emulada. Sin Safari/Firefox, táctil físico, lector auditivo ni zoom real 200%. Revisión: http://localhost:3000/home-preview.php.

## Entrega final de integración — 2026-10-23

Base local y origin/develop verificadas mediante fetch: 433622d26b1a5d94a67dbc085fef1dac89003304. La aprobación visual procede de la declaración del usuario de que el refinamiento resulta satisfactorio; no equivale a activación comercial ni autorización de merge/deploy.

- Header y acceso: partials Wave 6 existentes. Hero: partial editorial compartido por Home, Patterns y Navigation, estilos Wave 1 y botones Core. Entrada SCSS selectiva y main.js condicionado al anfitrión Home; sin CSS legacy, scripts de guía, fixtures comerciales, mini-cart ni nuevas dependencias en el bundle Home. La fábrica de mini-cart se inyecta exclusivamente en el laboratorio transaccional.
- Se retiran dos restos sin consumidores de la primera implementación: indicadores opcionales de carrusel.js y variables de opacidad del radial base. Ambos archivos quedan idénticos a develop; Home mantiene su tratamiento fotográfico aprobado. No se cambian diseño, textos, encuadres ni controles.
- Vacío conocido: badge 0 y modal neutral explícitamente demostrativo. Account conserva el acceso demostrativo aprobado. No existe proveedor comercial, autenticación, checkout ni nueva integración de reservas. El drawer conserva solo Wave 6; debe cerrarse antes de usar los iconos originales Cart/Account.
- Destinos provisionales comprobados con HTTP 200 y anclas existentes: reserva /index.html#reservation, experiencias /index.html#services, Private Experiences /index.html#private-events, Pure Soul /index.html#pure-soul, vinos /wines.html, club /swc.html; navegación adicional /menu.html, /about.html y /contact.html. Se reutilizan páginas legacy; no se valida ni activa su backend. Las futuras páginas reales sustituirán estas rutas mediante los datos del anfitrión.
- Vista local exclusiva de PHP cli-server, noindex y 404 en otros SAPIs. npm run dev sirve http://localhost:3000/home-preview.php. index.html conserva su SHA-256 0e8e79cf732c4080b58d8aa66968ca2e60fa6acf4b181e69986219ec927e1652 y no presenta diferencias funcionales frente a production-baseline. PNG originales conservados; seis WebP en 768/1672px, 81702–327932 B. Fuentes originales 1672×941: no se promete detalle nativo 4K.

QA de cierre ejecutado sobre el build: lint JS/SCSS, build, cuatro PHP lint, validación estructural del HTML renderizado (cierres, IDs, un H1, alt, href y type) y git diff --check. Scripts Node existentes probar-carrito.mjs y probar-cierre-comercio.mjs: PASS. La comprobación HTML es estructural, no certificación W3C.

Navegador Chromium, DPR 1: tres escenas a 390/425/768/1024/1280/1440/2560 (21 casos), fuentes cargadas, copy y CTA dentro del media, inactivos inert/aria-hidden y sin overflow. Capturas inspeccionadas; no flechas ni control de rotación visible en reposo. Autoplay: 18 transiciones reales, loop y máximo un timeout. Hover/foco recuperables, pausa manual persistente, teclado Home/End, reduced motion sin animación y navegación manual, Visibility API emulada e IntersectionObserver nativo: PASS. Destruir deja cero timers, reiniciar deja uno; decode tardío no activa otra escena. Drawer/Discover, Escape, foco visible y retorno de foco de Cart/Account sin backdrops ni scroll lock residuales: PASS. Sticky comprobado con espacio añadido solo al DOM de QA para permitir scroll completo.

Contraste revalidado con máscara de glifos interiores y captura del fondo fotográfico en los 21 casos: mínimos globales eyebrow 4,59:1, título 4,98:1, descripción 5,48:1. Por escena (eyebrow/título/descripción): 1: 5,13/5,55/5,48; 2: 4,67/5,56/6,20; 3: 4,59/4,98/5,61. El muestreo del refinamiento anterior, más amplio en bordes de glifos, se conserva arriba. CTA Core sin cambios: 12,69:1 y 16,01:1. No se certifica accesibilidad global.

Regresiones smoke: galería abrir/Escape/retorno, carruseles Reviews/vídeo Home/End hasta extremos (tolerancia de redondeo 1px), mini-cart abrir/foco/cerrar, cantidad/eliminar/Undo y badge 2→3→1→3→0→2: PASS. Sin errores de página observados en guía; sin errores de consola ni HTTP ≥400 en las sesiones Home revisadas. No se afirma cobertura exhaustiva de todas las Waves.

Mediciones locales nuevas, sin throttling: home.css 62847 B / 11534 B gzip; main.js 38378 B / 12155 B gzip. LCP 425px 1192ms y 1440px 1144ms; CLS 0 en ambas muestras. Siete recursos iniciales observados y solo el primer banner (768/1672 según viewport); los otros se materializan al navegar. No son Core Web Vitals de campo.

Evidencia local fuera del repositorio: C:/Users/Mike/.codex/visualizations/2026/10/21/01a15f31-e70b-75b1-a2ca-76cd17ea7ffc/final-delivery/. Capturas home-{ancho}-{escena}.png y láminas escenas-{ancho}.png; geometria.json, funcional.json, autoplay.json, ciclo-vida.json, contraste.json, regresiones.json, rutas.json y rendimiento.json. No se incluyen capturas ni temporales en Git. Continúan las limitaciones de navegador/dispositivo/lector/zoom descritas arriba; revisión de código mediante PR y futuras integraciones comerciales siguen pendientes.
