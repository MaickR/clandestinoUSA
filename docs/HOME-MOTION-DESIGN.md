# R6 — cierre final aprobado para integración

## Estado vigente — 2026-11-07

**R6 aprobada por el responsable para integración mediante PR manual hacia `develop`.** Esta aprobación comprende GSAP/ScrollTrigger, escritorio desde 1024 CSS px y Account/View cart en la parte superior del panel responsive de Preview. Sustituye los estados pendientes de revisión de los registros históricos conservados íntegramente debajo. Este cierre no añade cambios de diseño, funcionalidad ni optimizaciones.

Sobre el commit publicado `d2455c57e27c3b9031f495878f110471f0b5a89f`, se cierran exclusivamente las correcciones locales aprobadas en `feature/home-motion-design`: adaptador responsive Bootstrap a 1024, sincronización SCSS/JavaScript, gestión de foco y resize, fallback sin JS, traslado del bloque comercial compartido y scroll independiente de la lista. Los seis archivos fuente permanecen byte a byte iguales al estado aprobado al iniciar este cierre; solo se añade esta actualización documental.

Commit autorizado: `fix(nav): perfeccionar navegación responsive y accesos comerciales`. Push normal a `origin/feature/home-motion-design`. No se crea PR automáticamente, no se hace merge ni deploy, no se modifica `main` ni se activa Home pública. Los tres informes locales sin seguimiento continúan excluidos del commit.

## Verificación final

Evidencia local **F**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/final-publication-2026-11-07/`.

- `git fetch origin` confirmó HEAD y rama publicada coincidentes antes del cierre; diff limitado a navegación, sus imports SCSS y documentación. Sin cambios accidentales de GSAP, Hero, otras secciones, copy, fotografías, paquetes, formularios ni documentos anfitriones. Se verificaron 1027 hashes protegidos, el bundle GSAP compilado y los informes históricos.
- PASS: `npm run lint`, `npm run build`, PHP lint de 65 archivos, suites Node de formularios (126 casos y 27 fechas), carrito, cierre comercial y Home pública (72 contratos), HTML sin errores de parseo ni IDs duplicados y `git diff --check`. Los logs se conservan en F.
- PASS en navegador Chrome real: Preview y candidata pública a 768×560, 1023×768, 1024×708, 1200×800 y 1440×900. Drawer hasta 1023 y horizontal desde 1024; geometría de escritorio idéntica a la referencia aprobada. `chromium-qa.json` y `browser.log`.
- Preview a 768×560: Account y View cart visibles arriba, antes de la lista, incluso con Discover expandido; contador 0 conectado a la demo vacía; cierre de menú antes del único diálogo existente, Tab/Shift+Tab, foco, Escape y retorno correctos. Candidata pública sin zona comercial ni modales demostrativos por configuración PHP, sin espacio vacío reservado.
- `servidores.json` confirma el checkout y assets versionados actuales en ambos servidores, el Header compartido y las diferencias intencionales de disponibilidad. Se mantienen la protección local de Preview y la ausencia de `.home-public-enabled`.

Las evidencias visuales, matriz responsive ampliada y fallbacks de las correcciones aprobadas permanecen en los registros N y H siguientes. No se repite Lighthouse: GSAP y sus secuencias no cambian. Se conserva la penalización medida de LCP simulado, la mejora parcial de TBT tras estabilización y la ausencia de regresiones observadas de CLS; no se declaran Core Web Vitals de campo. Quedan las validaciones previamente documentadas en Safari/iOS físico y staging/hosting, y la futura integración de servicios comerciales reales V1.0. La aprobación de esta rama no activa demos públicas ni sustituye esos servicios.

---

# Registros anteriores preservados íntegramente


# R6 — corrección UX de Account y View cart en el panel responsive

## Estado — 2026-11-07

**Cambio local pendiente de revisión visual.** El responsable aprobó el breakpoint de escritorio a 1024 px y GSAP; ambos se conservan. Rama `feature/home-motion-design`, HEAD publicado `d2455c57e27c3b9031f495878f110471f0b5a89f`. Sin commit, push, PR, merge, deploy, cambio de `main` ni activación pública. Los ajustes locales anteriores y los informes históricos se preservan.

Evidencia **N**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/commerce-navigation/`. `evidencia.html` contiene las capturas completas del viewport, URL exacta, dimensiones y estado; `capturas.json` permite comprobar esos metadatos. No son screenshots aislados de elementos ni capturas de página completa redimensionadas.

## Diagnóstico reproducido antes de modificar

- `http://localhost:3000/home-preview.php`, 768×560: Account y View cart estaban en el DOM, `hidden=false`, habilitados y con `display:flex`/`visibility:visible`. La zona comercial estaba **después** de la lista y de Request a Table, dentro del scrollport de navegación (y=93…454). Con Discover cerrado, Account ocupaba y=446,5…493 y View cart y=501…547,5: estaban recortados por el ancestro aunque sus cajas geométricas quedaran dentro del viewport. Con Discover expandido pasaban a y=602…648,5 y y=656,5…703, completamente debajo de la pantalla. No era un problema de inicialización ni de listeners.
- `http://127.0.0.1:8017/`: zona comercial, botones del panel y diálogos demostrativos **no existen** en el HTML. `home.php` conserva `$mostrarAccesoNavegacion=false` y `$carritoNavegacion=[]`; no es ocultación accidental de CSS.
- Preview conserva `true` y el destino `#carrito-preview`. El atributo `hidden` inicial protege controles hasta conectar sus componentes; después de la conexión desaparece. No se eliminan esas guardas de disponibilidad.
- `diagnosis.json` y `before/*-768-*.png` registran los estados originales, con Discover cerrado y expandido. Sin la captura original del responsable no se atribuye su URL: se documenta la reproducción exacta en cada ruta.

## Distribución definitiva

El mismo bloque comercial se mueve inmediatamente después de la cabecera del panel y **antes** de `<nav>`. No se duplica. Dos columnas compactas con iconos existentes, textos Account / View cart y contador conectado al mismo estado que el Header; targets de al menos 44 px. Tokens oscuros, tipografía, bordes y foco existentes; sin nuevos componentes ni dependencias.

En el drawer, cabecera, comercio y pie no se contraen. La lista de enlaces tiene su propio scroll vertical. Request a Table queda fuera de ese scroll y permanece visible por encima del pie de contacto. A poca altura, Discover y sus enlaces se alcanzan desplazando la lista; ese desplazamiento no mueve las acciones comerciales. `fallbacks.json` verifica una rueda de scroll real a 768×560 y `*-768-expanded-scrolled.png` muestra el resultado.

El reparto del scroll se limita al modo mejorado por debajo del breakpoint **ya aprobado** mediante el mapa existente. Sin JavaScript, la lista expandida conserva su flujo normal y la zona comercial sigue oculta. A partir de 1024, la distribución horizontal y sus medidas coinciden exactamente con la referencia del ajuste anterior en 1024, 1200, 1280 y 1440 px. No se cambia el valor del breakpoint, el adaptador Bootstrap ni JavaScript.

## Funcionalidad y disponibilidad

Se reutiliza `conectarAccesoPanel` y `ejecutarAccion`: cierre completo del Offcanvas, retirada de backdrop/trap, apertura del mismo modal existente, foco interior, Escape y retorno al icono compacto válido del Header. El orden de Tab después del cierre del panel es Account → View cart → navegación. No se incorporan listeners ni modales nuevos. El contador de la demo vacía es **0**, sincronizado con el Header y su nombre accesible; no implica un carrito comercial real.

La candidata pública no genera el bloque y no reserva espacio para él. Header, documentos anfitriones, condiciones PHP y motor GSAP no cambian salvo el traslado del markup compartido. `servidores.json` confirma el mismo checkout, Preview idéntico vía BrowserSync→8018 y PHP8017, Header compartido normalizando flags/enlaces intencionales, hashes y versiones de assets equivalentes. Se conservan `no-store`, `noindex`, la protección local de Preview y la raíz legacy del backend; no se crea `.home-public-enabled`.

Para V1.0: conectar proveedor real de identidad/sesión y controlador de acceso, estados de usuario y acciones funcionales en este mismo bloque; proveedor persistente de carrito, suscripción `actualizarCarrito`, mini-carrito mediante `conectarCarrito`, pedidos y checkout con validaciones en servidor. Aportar destinos navegables para fallbacks sin JS. El anfitrión debe renderizar las acciones solo cuando los servicios estén disponibles y conectarlos mediante las APIs existentes. Cambiar una bandera o reutilizar los fixtures no habilita servicios reales ni autoriza su publicación. No se añade otra navegación.

## QA ejecutado

| Comprobación | Resultado / evidencia |
|---|---|
| Chrome real | PASS en Preview y candidata pública: 320×568, 390×844, 425×560, 768×560, 820×1180, 1023×768, 1024×708; además 1200, 1280 y 1440. 20 casos, estados cerrado/abierto, Discover, rectángulos y hit testing para detectar clipping, overflow, targets y geometría de escritorio. `chromium-qa.json`. |
| Firefox real | PASS en ambas rutas a 390×844, 768×560, 820×1180 y 1024×708: ocho casos con las mismas acciones funcionales; `firefox-qa.json`. |
| Account / View cart | PASS desde Discover expandido en los seis tamaños de drawer: controles inmediatamente visibles, contador 0 sincronizado, una sola instancia de diálogo, cierre de menú previo, foco, Tab/Shift+Tab, Escape, retorno y limpieza de scroll lock/backdrop. Capturas `preview-768-account.png` y `preview-768-cart.png`. |
| Scroll y teclado | PASS: lista desplazable con rueda, acciones inmóviles, Contact visible al recibir foco, retorno desde Discover y desde el panel. Request a Table, cabecera y pie visibles en todos los tamaños pedidos. |
| Resize / orientación / reduced motion | PASS: panel abierto 768→1024, limpieza y foco en Discover; vuelta a móvil y cambio 768×560→390×844. Misma navegación funcional con reduced motion; `fallbacks.json`. |
| Sin JS | PASS: 14 casos (siete tamaños × dos rutas), sin overflow, sin activadores modales inertes, navegación y reserva disponibles. |
| Accesibilidad / consola | PASS en los escenarios probados: axe WCAG2 A/AA y 2.1 AA sobre Header con Discover expandido en diez estados, foco visible y cero errores de consola/página/HTTP en la matriz funcional. No equivale a certificación WCAG. |
| Técnico | PASS: `npm run lint`, `npm run build`, PHP lint de 65 archivos; suites Node de formularios (126 + 27 fechas), carrito, cierre comercial y Home pública (72); HTML parseado sin errores ni IDs duplicados; `git diff --check`. |
| Protección | Hashes del resto de fuentes/paquetes, adaptador 1024, documentos anfitriones y tres informes históricos intactos. Main JS y movimiento GSAP no se modifican. Sin nuevas dependencias ni mediciones Lighthouse innecesarias. |

Esta corrección modifica únicamente `includes/header.php`, `assets/scss/patterns/_navegacion-global.scss` y este documento respecto al estado local recibido; conserva los ajustes de breakpoint anteriores. Se actualizan assets únicamente mediante build. Pendientes: revisión visual humana, Safari/iOS y dispositivos físicos. En los casos probados no quedan fallos conocidos; no se extrapola la prueba a todos los tamaños o navegadores.

Reproducción: recargar Preview, fijar 768×560, abrir menú; comprobar Account y View cart debajo del título. Abrir Discover, desplazar solo la lista, activar cada acción y cerrar con Escape. Repetir en la candidata pública para comprobar la ausencia intencional de demos y en 1024×708 para la navegación horizontal.

---

# Registro anterior preservado íntegramente


# R6 — corrección puntual del Header responsive a 1024 px

## Estado vigente — 2026-11-07

**Corrección local de Header pendiente de revisión. Motion GSAP aprobado y protegido.** La rama permanece en `feature/home-motion-design`, HEAD publicado `d2455c57e27c3b9031f495878f110471f0b5a89f`. Esta revisión no hace commit, push, PR, merge ni deploy, no modifica `main` ni activa Home pública. El cierre anterior se conserva íntegro debajo como registro histórico y no autoriza publicar esta corrección sin revisión.

Evidencia **H**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/header-responsive-1024/`. `evidencia.html` reúne capturas reales comparables, el antes/después y enlaces a resultados JSON y scripts reproducibles.

## Causa y estrategia única

La candidata publicada utilizaba tres piezas coherentes, pero con el umbral equivocado para este requisito: `@include media-breakpoint-up(xl)`, clase Bootstrap `offcanvas-xl` y `matchMedia('(min-width: 1200px)')`. A 1024 px el panel lateral era el comportamiento programado, no una caché antigua. `before/preview-1024.png` y `before/geometry.json` conservan la reproducción.

Se establece **1024 CSS px exactos** como escritorio exclusivamente para la navegación. 991, 992 y 1023 siguen siendo drawer; 1024, 1025, 1100, 1199 y 1200 son horizontales. No se mueve el breakpoint global `lg=992` ni `xl=1200`, el grid, los contenedores o las composiciones de Home.

`vendors/_offcanvas-cabecera.scss` define `$cl-cabecera-escritorio: 1024px` y añade la entrada `cabecera` a un mapa local ordenado de Bootstrap. El import original de Offcanvas se compila con ese mapa, generando la clase responsive nativa `offcanvas-cabecera`, y restaura inmediatamente `$grid-breakpoints`. Los mismos puntos de entrada `home.scss` y `main.scss` usan este adaptador. Es una excepción local a la regla habitual de breakpoints, expresamente requerida por el responsable; no se amplía el Design System ni se duplican manualmente las reglas del componente.

El Header utiliza ese mapa con el mixin Bootstrap. Expone el valor mediante `--cabecera-escritorio`; JavaScript lo lee para su `matchMedia`, utiliza `offcanvas-cabecera` y retira la misma clase al destruir. No hay un segundo umbral numérico en JS. Se conserva la mecánica oficial de Offcanvas: backdrop, Escape, scroll lock y trap. Referencia contrastada con el paquete instalado y la [documentación de Bootstrap Offcanvas](https://getbootstrap.com/docs/5.3/components/offcanvas/).

Al cambiar de modo se cierra Discover, se completa el cierre del drawer cuando corresponde y se lleva el foco a un control visible: Discover en escritorio, hamburguesa al volver a móvil si el foco estaba dentro del panel. Un cambio 1199↔1200 ya no cambia el modo ni descarta un Discover abierto.

## Resultado visual y fallbacks

A 1024 px, todos los destinos —Home, Experiences, Restaurant, Wine Shop, Discover y Request a Table— caben en una fila, también con los iconos compactos de Preview. Se mantienen tipografía, targets, logo y CTA: no fue necesario reducir texto, padding ni tamaño del logo para forzarlo. Los enlaces y Discover conservan aproximadamente 46,5 px de alto y el CTA 44 px con la raíz predeterminada. El Header conserva su altura aproximada de 83,55 px. A 1200 y 1440, su geometría, tipografía y colores coinciden con la referencia anterior en ambas variantes.

Se permite reflow de la navegación con texto al 200%, manteniendo todos los destinos y targets. No se impone una fila rígida a texto ampliado. Sin JavaScript, Discover permanece expandido en el flujo, para evitar la superposición que causaba su posicionamiento absoluto. Los controles que requieren JS siguen indisponibles y el icono de carrito con destino exclusivamente modal se oculta; un enlace a un carrito real conserva su fallback navegable.

La prueba a 1024×220 detectó que el offset de foco de las anclas de página dejaba Contact parcialmente recortado en el scroll interno de Discover. Se acota `scroll-margin-block` dentro de la navegación, preservando el offset de las secciones. Se verificó con Tab que los tres destinos quedan completamente visibles a 220 y 320 px de alto (`foco-corto.json` y `*-1024-keyboard-*.png`). No se modifica el motor de motion para resolverlo.

## Preview y candidata pública

| Documento | Estado comercial | Servidor |
|---|---|---|
| `http://localhost:3000/home-preview.php` | Demos Account y View cart; compactos en Header y acciones dentro del drawer | BrowserSync → PHP `127.0.0.1:8018`, checkout actual. |
| `http://127.0.0.1:8017/home-preview.php` | El mismo Preview, con demos y el mismo Header | PHP CLI directo con router local de QA. |
| `http://127.0.0.1:8017/` | Sin controles ni diálogos comerciales de demostración | El mismo checkout, anfitrión `home.php` y flag local de QA. |

Ambos anfitriones incluyen `includes/home-document.php` e `includes/header.php`. `home-preview.php` aporta `$mostrarAccesoNavegacion=true` y `$carritoNavegacion=['destino'=>'#carrito-preview']`; `home.php` conserva `false` y `[]`. La ausencia pública se verifica en HTML, no depende de CSS que oculte iconos. Esos archivos PHP y `main.js` permanecen byte a byte intactos. El menú Preview usa los diálogos existentes: cierra primero, transfiere foco, mantiene contador 0 y retorna al control compacto al pulsar Escape; no se fabrican sesiones ni se duplican modales.

`servidores.json` compara los documentos, SHA256 de CSS/main/chunks, `?v=`, cache headers y variantes. Los Preview coinciden al retirar el script BrowserSync; el documento público comparte main/Header/Footer al normalizar flags, aliases y destinos intencionales. Los assets coinciden entre hosts y disco. Las respuestas PHP siguen `no-store` y `noindex`; no se cambió la protección loopback de Preview ni se creó `.home-public-enabled`. El backend 8018 continúa sirviendo la raíz legacy.

Para V1.0 deberán conectarse un proveedor real de autenticación/sesión y su controlador de acceso, un proveedor de carrito persistente con validación de precios/disponibilidad en servidor, el mini-carrito mediante `conectarCarrito` y la suscripción de `actualizarCarrito`, y servicios reales de pedidos/checkout. El anfitrión solo debe renderizar los accesos cuando estén funcionalmente disponibles. Debe aportar destinos navegables reales para el fallback sin JS y conservar `conectarAccesoPanel`, cierre previo, Escape, trap y retorno del foco. No basta con cambiar flags o mostrar fixtures. No se activa ninguno de esos servicios aquí.

## QA y protección

| Comprobación | Resultado y evidencia |
|---|---|
| 17 anchos exigidos | PASS: 320/360/390/425/600/768/820/991/992/1023/1024/1025/1100/1199/1200/1280/1440 en Preview y pública (34 casos). Geometría de cada destino, centros de fila, targets, modo CSS, visibilidad, popup, foco y acciones; `qa.json`. |
| Firefox | PASS: 390/820/991/992/1023/1024/1025/1199/1200/1440 en ambas variantes, 20 casos; `firefox.json`. |
| Estados de transición | PASS: 1023 abierta→1024, 1024 Discover→1023, resize durante apertura, 1199↔1200, orientación 390×844→844×390 y alturas 320/220. Se comprueban foco real y limpieza del backdrop/scroll lock; `transiciones.json`. |
| Teclado con poca altura | PASS: Tab alcanza Wine Club, About Us y Contact y cada caja queda íntegramente dentro del scrollport; Escape y retorno; `foco-corto.json`. |
| Texto al 200% y sin JS | PASS: 102 casos en ambos documentos y los 17 anchos. Ampliación temporal de la raíz a 200% solo en el navegador de QA, sin cambios de fuente en producto; con JS y sin JS, sin overflow. Sin JS, destinos expandidos sin superposición; `zoom-nojs.json`. |
| Accesibilidad y consola | PASS en los estados probados: foco visible, Escape, Tab/Shift+Tab, nombres, controles y ausencia de errores de página/recursos; `accesibilidad.json` contiene el análisis axe específico del Header con Discover abierto. No equivale a certificación WCAG. |
| Fuentes y CSS protegidos | PASS: fuentes GSAP/Hero/media/main, tokens, PHP, paquetes e informes intactos. Bundle GSAP idéntico. Comparación AST del CSS sin cambios ajenos al Header y su nueva clase Offcanvas; geometría de Header 1200/1440 idéntica; `integridad.json`. |
| QA técnico | PASS: `npm run lint`, `npm run build`, 65 PHP, suites Node de formularios (126 + 27 fechas), carrito, cierre comercial y Home pública (72), HTML Preview/pública y `git diff --check`. Sin nuevas dependencias ni Lighthouse extensivo. |

Los cambios quedan limitados a `assets/js/modules/patterns/navegacion-global.js`, `assets/scss/patterns/_navegacion-global.scss`, el nuevo `assets/scss/vendors/_offcanvas-cabecera.scss`, sus imports en `assets/scss/home.scss` y `assets/scss/main.scss`, y este informe. GSAP, ScrollTrigger, Hero, imágenes, Pure Soul, las demás secciones, copy R5, formularios, SEO y rutas públicas se conservan. Los tres informes locales históricos siguen sin seguimiento y con los hashes originales. El historial publicado y `main` permanecen intactos.

Pendiente: revisión visual humana de este ajuste, Safari/iOS y dispositivos físicos. En los escenarios comprobados no quedan defectos funcionales conocidos. No se extrapola la muestra a todos los navegadores ni a todas las combinaciones de ampliación y altura. Se conservan las limitaciones de rendimiento y hosting ya documentadas para R6; esta corrección no reabre ni optimiza el motion aprobado.

---

# Registro histórico íntegro — ajuste actual del Header en el bloque superior

# Home R6 — cierre definitivo de motion y navegación responsive

## Estado vigente — 2026-11-07

**R6 APROBADA VISUALMENTE POR EL RESPONSABLE — READY FOR PR MANUAL HACIA DEVELOP.** La navegación responsive se considera funcionalmente aprobada por el responsable. Esta autorización sustituye los pendientes de aprobación visual de los registros históricos inferiores. Se conserva definitivamente GSAP 3.15.1 + ScrollTrigger y la implementación estabilizada, sin nuevos ajustes creativos, funcionales ni optimizaciones en este cierre.

Trabajo exclusivamente en `feature/home-motion-design`, desde `d6f9e46b4f1c482fb783804c594e9a210bdc86ba`. `git fetch origin` confirmó la misma base en `origin/develop` antes de publicar. Se autoriza un commit con el mensaje `feat(home): integrar motion premium y navegación responsive` y push normal a `origin/feature/home-motion-design`. El responsable creará manualmente el PR. Sin creación automática de PR, merge, deploy, modificación de `main` ni activación de Home pública.

## Alcance final revisado

- GSAP y ScrollTrigger mediante NPM y el esbuild existente; carga exclusiva de la nueva Home, sin CDN ni motor de revelado paralelo con Web Animations API.
- 44 agrupaciones editoriales y preparación progresiva fuera de pantalla. Un observador anticipa la preparación; ScrollTrigger conserva el disparo y GSAP las timelines. Los grupos ya visibles, el foco y los saltos rápidos priorizan lectura inmediata. Una sola entrada; los estados COMPLETE no se rearman.
- Secuencias aprobadas de Discovery, Pure Soul, Private Experiences, Guest Stories, Reservation Invitation, Wine Club, Gifting y Visit. Se mantienen duraciones, easing, fotografías, póster, encuadres, composiciones y copy R5.
- Account y View cart del panel Preview conectan los mismos componentes que los iconos compactos, con contador, cierre, Escape, trap y retorno del foco. El Header público omite demos por disponibilidad funcional.
- Las únicas modificaciones de `escenas-hero.js` y `carrusel-media.js` son las guardas ante ausencia de IntersectionObserver y su limpieza. No cambian keyframes, transiciones, selección de escenas ni comportamiento normal de los carruseles. Formularios, rutas públicas y archivos de media permanecen intactos.

Los doce archivos del commit son `assets/js/main.js`, `assets/js/modules/patterns/{movimiento-home,navegacion-global,escenas-hero,carrusel-media}.js`, `assets/scss/home.scss`, `assets/scss/patterns/_navegacion-global.scss`, `assets/scss/pages/_home-movimiento.scss`, `includes/header.php`, `package.json`, `package-lock.json` y este informe. Los outputs compilados son ignorados. Los tres informes históricos locales continúan sin seguimiento y fuera del commit, con sus hashes originales.

## QA de cierre

Evidencia local del cierre **C**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/closure-2026-11-07/`. Se aplicó `.agents/skills/qa-visual/SKILL.md`. No se repite Lighthouse: no cambió el código medido ni el lockfile respecto a la estabilización aprobada.

| Verificación | Resultado |
|---|---|
| Instalación limpia | PASS: copia aislada del HEAD con las fuentes R6, `npm ci` desde el lockfile, lint y build; GSAP 3.15.1. Sin alterar node_modules del checkout. |
| Reproducibilidad | PASS: outputs minificados del checkout, instalación limpia y build estabilizado coinciden. Fuentes aprobadas e informes protegidos conservan SHA256. |
| Lint / build | PASS: `npm run lint` y `npm run build`, también desde la instalación limpia. |
| PHP / Node | PASS: 65 PHP; suites de formularios (126 casos + 27 de calendario PHP), carrito, cierre comercial y Home pública (72 contratos). Correo nativo deshabilitado en los fixtures. |
| Motion | PASS: Chrome 320/390/425/768/820/1024/1280/1440, una sola activación por grupo, ida/vuelta sin repetición, restauración intermedia, resize, 24 hashes, teclado, reduced motion inicial/dinámico, sin JS y carga GSAP bloqueada/retrasada. Bundle minificado comprobado, incluida ausencia de IntersectionObserver. |
| Visibilidad | PASS: contenido visible por defecto y fallbacks; estados finales completos, sin overflow. Los hashes del bundle conservan la validez de los vídeos y muestras temporales aprobados, que verifican preparación fuera de pantalla y ausencia de flash o retroceso. |
| Navegación | PASS: Preview en BrowserSync y PHP directo, panel a 390/425/768/820, Account/cart, contador 0, cierre antes del diálogo, Escape, scroll lock, Tab/Shift+Tab y retorno de foco. Candidata pública sin controles ni diálogos demo. |
| Compatibilidad | PASS: Chrome y Firefox a 390/768/820/1280/1440, imágenes y recursos cargados, sin errores de consola ni overflow; axe en Chrome sin violaciones reportadas en la muestra. Controles de Hero y Guest Stories comprobados. |
| HTML / Git | PASS: parser HTML sin errores en Preview/pública, IDs y referencias, h1/main, alt, destinos y sitemap; `git diff --check` y revisión del staging limitado a R6. |

`npm ci` reportó seis alertas de dependencias **de desarrollo** (cinco moderadas y una alta), en el árbol de ESLint y tooling de red. Las versiones afectadas ya están en `origin/develop` y no son introducidas por GSAP. `npm audit --omit=dev` reportó **cero** vulnerabilidades. `C/npm-audit*.json` conserva el detalle. Su actualización queda como mantenimiento separado; no se aplicó `audit fix` ni se cambió el lockfile fuera de GSAP.

## Rendimiento aceptado y límites

GSAP + ScrollTrigger permanecen como motor aprobado. La estabilización reduce preparación inicial, pero **no elimina la penalización medida de LCP simulado**. Se conservan las 27 pasadas y sus rangos en el registro siguiente; no se declara una mejora general de LCP ni puntuaciones perfectas.

| Ancho | LCP nativa | LCP GSAP estabilizada | TBT GSAP anterior → estabilizada |
|---:|---:|---:|---:|
| 390 | 6,053 s | 6,543 s | 473 → 464 ms |
| 820 | 7,332 s | 8,080 s | 687 → 602 ms |
| 1440 | 6,474 s | 7,080 s | 786 → 690 ms |

El coste residual de LCP es aproximadamente 0,49–0,75 s. El TBT mejoró parcialmente; el hilo principal no mejora en todos los anchos. No se observaron regresiones de CLS atribuibles a R6 en los escenarios probados: medianas 0 / 0 / 0,000255, con rangos completos conservados. Son mediciones de laboratorio y muestras locales, no Core Web Vitals de campo. El JS total minificado es 169.829 B / 63.898 B gzip; se mantiene una solicitud adicional frente a nativa. El transporte PHP local no reproduce compresión, TLS, caché ni latencia de GoDaddy.

Validar el rendimiento real en staging/hosting: recursos críticos y LCP, compresión y caché de assets, fuentes, layout, errores y respuesta de controles. Comprobar Safari/iOS y dispositivos físicos, reduced motion, restauración, reproducción y menú. No se modifica el comportamiento para mejorar artificialmente una puntuación.

## Activación comercial futura V1.0

R6 no implementa autenticación, sesiones, pedidos ni checkout reales. Antes de habilitar sus accesos públicos se requiere:

1. Proveedor real de cuenta/autenticación en servidor, sesiones y estados de acceso/errores comprobados. Sustituir el adaptador demostrativo sin crear otro modal ni otra navegación.
2. Servicio real de carrito con cantidades, precios, disponibilidad y persistencia validados en servidor; conectar el mini-carrito y su suscripción al contador mediante los puntos existentes (`conectarCarrito`, `actualizarCarrito`, acciones de panel).
3. Módulos reales de pedidos y checkout, con confirmación y cobro coherentes con el servicio disponible; no publicar controles de compra basados solo en iconos o fixtures.
4. Renderizar Account/cart públicos únicamente cuando la disponibilidad funcional del anfitrión sea real. Conservar el mismo cierre, trap, Escape, foco y retorno en móvil/tablet/desktop. Validar integración, errores y seguridad en staging antes de activar.

## Cómo verificar esta entrega

Preview: `http://localhost:3000/home-preview.php`. La candidata pública local de QA es `http://127.0.0.1:8017/`; ambas mantienen noindex y no activan producción. Las diferencias intencionales de flags y rutas están documentadas y verificadas. Para repetir motion, cargar desde arriba, sin hash y con movimiento normal. Para verificar fallback, usar reduced motion o deshabilitar JavaScript. Para el menú, revisar Account/cart en 390/425/768/820 y su ausencia en la candidata pública.

Los vídeos, capturas y trazas de la estabilización siguen en `../stabilization/`; no se generan nuevas propuestas creativas en el cierre. Los apartados inferiores se conservan íntegros como historia y sus antiguos estados de pendiente no sustituyen la aprobación vigente.

---

# Registro histórico íntegro — aprobación vigente en el cierre superior

# Home R6 — estabilización de GSAP y navegación responsive

**Implementación local en `feature/home-motion-design`, pendiente de revisión técnica y visual humana.** Trabajo del 2026-11-04 al 2026-11-05, America/Bogota. Se conserva la dirección creativa provisional de GSAP. El trabajo se limita a la preparación de las entradas y la comprobación del menú. Sin commit, push, PR, merge, deploy, cambios en `main` ni activación pública.

Evidencia **E**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/stabilization/`. Abrir `E/evidencia.html` para capturas comparables, vídeos a 1×, fotogramas y trazas. El informe R6 anterior se conserva íntegro a continuación; sus estados y métricas corresponden a las iteraciones históricas.

## Servidores y decisión de navegación

| URL | Proceso / contexto comprobado | Resultado |
|---|---|---|
| `http://localhost:3000/home-preview.php` | BrowserSync → PHP `127.0.0.1:8018`, watcher del checkout actual | Preview: demos y script de BrowserSync. |
| `http://127.0.0.1:8018/home-preview.php` | PHP directo, backend del proxy | Mismo Preview sin script de BrowserSync. `/` en ese backend continúa sirviendo `index.html` legacy. |
| `http://127.0.0.1:8017/home-preview.php` | Otro PHP CLI de loopback con el router de QA y mismo checkout | Mismo Preview y mismas demos; sin BrowserSync. |
| `http://127.0.0.1:8017/` | Router PHP con `CL_HOME_PUBLIC_REVIEW=1`, solo QA | Candidata pública de QA: sin demos. Conserva hamburguesa y rutas públicas. |

Los cuatro documentos responden `Cache-Control: no-store, max-age=0` y `X-Robots-Tag: noindex, nofollow`. Se cotejan `ETag`, `Last-Modified`, `Age`, `Content-Encoding`, bytes y SHA256 en `servidores.json`; los recursos estáticos de PHP local no simulan la caché ni la compresión de producción. `?v=` de CSS y `main.js` coincide con los primeros 16 dígitos del SHA256; los chunks de motion, Hero y carrusel también coinciden entre hosts y disco. Los tres HTML de Preview son estructuralmente iguales al retirar el script del proxy. El `main`, Header y Footer públicos coinciden al normalizar aliases, destinos intencionales y controles demo. En la candidata pública se conservan sus metadatos SEO de QA, anclas de compatibilidad, enlaces públicos y ausencia de las demos. No se encontró divergencia accidental de HTML compartido ni de build.

En 390, 425, 768 y 820 px, Preview presenta **Account** y **View cart** bajo Request a Table, con separador, iconos, contador 0, encabezado y pie intactos. Los iconos compactos permanecen en el Header. El panel cierra antes de abrir el único diálogo existente de acceso o carrito vacío. Escape, scroll lock, trap Tab/Shift+Tab y retorno a los controles compactos pasan. No se crea sesión ni proveedor comercial. Los puntos de integración existentes quedan disponibles para servicios reales. La candidata pública omite ambos controles y ambos diálogos deliberadamente.

**Sin cambios de navegación ni de CSS.** Una primera prueba de foco se adelantaba al paint del botón: `visibility:hidden` al llamar `focus()` pese a que el panel ya había emitido `shown`. Al esperar visibilidad real se validó la interacción de teclado; la comprobación de foco temprano con el candidato anterior también pasa 5/5 (`foco-apertura.json`). Se retiró el ajuste provisional y se repitieron los doce casos de menú con el código original, confirmado por hash. Las capturas finales `menu-{preview,php-preview,public}-{390,425,768,820}.png` son del panel abierto real, no una maqueta.

La pestaña del navegador integrado mostró `ERR_CONNECTION_REFUSED` y su política bloqueó el acceso a la página de error. HTTP y Chrome/Firefox locales de QA sí verificaron ambos servicios. No se abrió Preview a la red ni se cambiaron las reglas de protección. Esa comprobación no sustituye la revisión visual humana.

## Diagnóstico y cambio de motion

La comparación incluye última R6 nativa (`8026`), GSAP anterior congelada (`8027`, copia del build medido en R6) y GSAP estabilizada (`8017`), todas por la ruta pública local de QA y con build de producción minificado. No se compara BrowserSync con PHP para sacar conclusiones de rendimiento. Los números originales de R6 (nativa → GSAP: 6,025→6,554 s / 7,299→8,007 s / 6,504→7,086 s) permanecen en el registro previo. La serie nueva reproduce la penalización en su propio entorno.

Antes se registraban las 44 agrupaciones y se preparaba casi toda Home en un solo tramo síncrono: contextos, `fromTo(...immediateRender: true)`, medidas y `ScrollTrigger.create`. El Hero ya había solicitado y recibido su recurso cuando se pedía el chunk de 124.263 B. Eso no garantiza que el Hero ya se haya pintado. En los perfiles instrumentados previos, la inicialización se ejecutó entre la descarga y el LCP de imagen; estilos y layout consumieron 25–52 ms del intervalo. El perfil distingue esos tiempos de CPU, la espera de importación y la transferencia. En las trazas de Lighthouse, el render delay es observado y no se debe sumar al LCP simulado. Hay variación de fuentes, red y CPU; no se atribuye toda la diferencia de LCP a un único callback.

Se conserva el mismo import dinámico después de decodificar el Hero y sus dos frames, sin cambiar prioridad, ruta crítica ni reglas en función de Lighthouse. Se registran los grupos sin modificar la presentación. Se preparan primero las unidades cercanas y, para las restantes, un único `IntersectionObserver` anticipa **la preparación** una altura de viewport antes. ScrollTrigger sigue siendo el único disparador de las entradas y GSAP el motor. Se realizan las lecturas de visibilidad del lote antes de escribir sus estados. Se reutiliza la altura de Header hasta un cambio real de tamaño, limitando lecturas y el conjunto de triggers activos durante refresh.

Cada unidad deja de observarse al prepararse o completarse. Un salto rápido o un resize que ya alcance un grupo prioriza dejarlo visible y omite esa entrada. Hash, foco, reduced motion y fallos conservan sus rutas de salida. Sin IntersectionObserver disponible, se mantiene el HTML visible sin motion. La destrucción desconecta el observador de preparación además de revertir contextos y triggers. No hay otro motor, listener de scroll propio ni temporizador artificial.

Perfiles, opacidades, distancias, duraciones, orden y actores conservados. Discovery, Pure Soul, Private Experiences, Guest Stories, Reservation Invitation, Wine Club, Gifting y Visit tienen las mismas secuencias. Hero, Header, Footer y carruseles mantienen sus transiciones y controles. No se modifica ninguna fotografía, copy, layout ni geometría.

## Rendimiento medido

### Perfil del arranque

Perfiles Chrome del build minificado con CPU ×4 en viewport de escritorio emulado (DPR1), mismo método antes/después. `perfilar*.cjs` añade marcas al inicio y fin de la llamada de inicialización sin cambiar tiempos del producto; no se usa esa instrumentación en Lighthouse. `perfil-{antes,despues}.json` y sus trazas contienen descarga, inicialización y LCP de imagen. Las cifras son perfiles puntuales, no medianas de navegación.

| Ancho | Timelines READY antes → después | Inicializador ms | Layout + estilos dentro del inicializador, ms |
|---:|---:|---:|---:|
| 390 | 42 → 4 | 135,7 → 45,2 | 50,6 → 6,6 |
| 820 | 39 → 13 | 156,0 → 50,0 | 51,9 → 17,4 |
| 1440 | 42 → 11 | 78,5 → 31,5 | 25,3 → 3,1 |

Cronología en milisegundos desde navegación. El intervalo fin de descarga → inicio incluye entrega de la importación, evaluación y planificación; no equivale a parseo puro. El evento `v8.compileModule` atribuido al chunk a 390 px ocupó 36 µs antes y 40 µs después en estas trazas. Es una muestra de un evento, no de toda la compilación V8. El trabajo que se pudo aislar y reducir fue la preparación síncrona y el layout; no se dividió el SDK por intuición.

| Ancho | Fase | Hero fin de descarga | SDK solicitud → fin | Init inicio → fin | LCP imagen observado |
|---:|---|---:|---:|---:|---:|
| 390 | GSAP anterior | 440,1 | 1.619,0 → 1.919,6 | 1.957,4 → 2.093,1 | 2.168 |
| 390 | GSAP estabilizada | 121,3 | 1.671,6 → 1.826,2 | 1.860,9 → 1.906,1 | 2.216 |
| 820 | GSAP anterior | 69,9 | 1.292,9 → 1.346,4 | 1.395,5 → 1.551,5 | 1.904 |
| 820 | GSAP estabilizada | 103,9 | 820,2 → 957,3 | 976,3 → 1.026,3 | 1.588 |
| 1440 | GSAP anterior | 91,4 | 1.025,9 → 1.153,7 | 1.185,2 → 1.263,7 | 1.676 |
| 1440 | GSAP estabilizada | 152,1 | 992,3 → 1.230,2 | 1.293,7 → 1.325,2 | 1.688 |

Perfil adicional con marcas en el `import()` real y al entrar/salir del módulo (mismo build y CPU ×4). No se usa para Lighthouse. Incluye evaluación de GSAP, CSSPlugin y ScrollTrigger empaquetados, separada de la inicialización de grupos.

| Ancho | Fase | Invocación de import() ms | Evaluación módulo ms | Inicializador ms |
|---:|---|---:|---:|---:|
| 390 | GSAP anterior | 1.152,3 | 8,5 | 43,8 |
| 820 | GSAP anterior | 1.153,5 | 9,9 | 119,0 |
| 1440 | GSAP anterior | 1.266,0 | 14,7 | 109,6 |
| 390 | GSAP estabilizada | 1.225,7 | 8,4 | 76,1 |
| 820 | GSAP estabilizada | 1.351,3 | 14,0 | 75,3 |
| 1440 | GSAP estabilizada | 1.198,8 | 11,3 | 61,2 |

La segunda toma de 390 px tuvo una inicialización más lenta que su referencia puntual. Los perfiles no representan una garantía de duración; la reducción de grupos preparados y de lecturas forzadas se verifica en las trazas, y se contrasta con las medianas y rangos de navegación completos.

### Bundle real

| Fase | JS minificado | JS gzip | CSS minificado | CSS gzip | Requests JS |
|---|---:|---:|---:|---:|---:|
| Nativa | 50.955 B | 17.025 B | 98.413 B | 16.790 B | 4 |
| GSAP anterior | 169.178 B | 63.683 B | 98.413 B | 16.790 B | 5 |
| GSAP estabilizada | 169.829 B | 63.898 B | 98.413 B | 16.790 B | 5 |

El adaptador añade **651 B minificados / 215 B gzip** al JS total de la R6 GSAP anterior; ninguna solicitud nueva respecto a ella. El chunk nuevo de motion pesa 124.914 B / 48.628 B gzip. GSAP continúa siendo una solicitud adicional frente a nativa. CSS y chunks Hero/Guest Stories coinciden por hash. Gzip se calcula sobre bytes recibidos; PHP de QA entrega sin compresión. El beneficio consiste en hacer menos trabajo al inicio, no en reducir el peso de GSAP.

### Lighthouse y fluidez

Tres pasadas por fase y ancho, alternando nativa → GSAP anterior → estabilizada (27 navegaciones). Chrome 156 / Lighthouse 13.4.1, 390×844 DPR3, 820×1180 DPR2 y 1440×1000 DPR1. Se reutiliza la metodología R4: RTT 150 ms, 1638,4 Kbps y CPU ×4, también en escritorio. Las series se hicieron sin builds, grabaciones ni otros navegadores de QA en paralelo. Véase [simulación en Lighthouse](https://github.com/GoogleChrome/lighthouse/blob/main/docs/throttling.md). Los valores del hilo principal son los de la traza observada; no se escalan manualmente. No hay medidas de campo.

| Ancho | Fase | LCP s | TBT ms | CLS | Score | Hilo principal ms | CPU JS ms | Requests |
|---:|---|---:|---:|---:|---:|---:|---:|---:|
| 390 | Nativa | 6,053 | 548,0 | 0,00000 | 60 | 2.738 | 148 | 19 |
| 390 | GSAP anterior | 6,600 | 473,0 | 0,00000 | 60 | 3.315 | 431 | 20 |
| 390 | GSAP estabilizada | 6,543 | 464,0 | 0,00000 | 60 | 2.612 | 276 | 20 |
| 820 | Nativa | 7,332 | 734,0 | 0,00000 | 53 | 3.272 | 160 | 26 |
| 820 | GSAP anterior | 8,014 | 687,0 | 0,00000 | 49 | 3.756 | 522 | 27 |
| 820 | GSAP estabilizada | 8,080 | 601,5 | 0,00000 | 54 | 4.074 | 329 | 27 |
| 1440 | Nativa | 6,474 | 532,0 | 0,00026 | 38 | 2.805 | 124 | 25 |
| 1440 | GSAP anterior | 7,099 | 786,0 | 0,00026 | 33 | 4.510 | 456 | 26 |
| 1440 | GSAP estabilizada | 7,080 | 690,0 | 0,00026 | 34 | 4.472 | 373 | 26 |

Rangos completos y desglose observado (medianas en ms):

| Ancho | Fase | LCP simulado min–max s | TBT min–max ms | CLS máx. | LCP observado | Retraso de solicitud | Retraso de render |
|---:|---|---:|---:|---:|---:|---:|---:|
| 390 | Nativa | 5,952–6,183 | 0,0–557,5 | 0,00637 | 1.477 | 104,2 | 1.247,4 |
| 390 | GSAP anterior | 6,464–6,657 | 442,8–617,0 | 0,00000 | 1.308 | 72,0 | 1.190,2 |
| 390 | GSAP estabilizada | 6,163–6,544 | 332,6–560,5 | 0,00637 | 1.273 | 48,6 | 1.141,6 |
| 820 | Nativa | 7,309–7,465 | 686,0–757,2 | 0,00000 | 1.341 | 23,2 | 1.268,9 |
| 820 | GSAP anterior | 5,533–8,123 | 595,5–926,0 | 0,00323 | 3.250 | 24,9 | 1.069,5 |
| 820 | GSAP estabilizada | 7,791–8,138 | 580,5–823,0 | 0,00000 | 1.441 | 68,2 | 1.291,6 |
| 1440 | Nativa | 6,473–6,605 | 527,0–572,0 | 0,00026 | 1.230 | 28,6 | 1.111,1 |
| 1440 | GSAP anterior | 7,072–7,160 | 608,3–947,5 | 0,00026 | 1.349 | 39,8 | 1.246,1 |
| 1440 | GSAP estabilizada | 6,906–7,841 | 506,0–2.681,2 | 0,00026 | 3.880 | 23,9 | 1.190,1 |

Orden de anchos 390 / 820 / 1440. Frente a GSAP anterior: LCP **−58, +66, −19 ms**, TBT **−9, −86, −96 ms** e hilo principal **−703, +318, −39 ms**. Frente a la nativa, queda un coste de LCP de **+490, +748, +606 ms**. El ahorro de inicialización está medido por perfil; la dispersión de Lighthouse no permite atribuir cada cambio de LCP, TBT o score al mismo mecanismo. La transferencia del SDK y su evaluación permanecen, y no se promete recuperar todo el coste sin sacrificar la secuencia. Los resultados completos están en `performance.json`, LHR y trazas antes/después. No se bloquean fuentes ni se retrasa la carga para modificar resultados.

Fluidez de scroll: 300 intervalos requestAnimationFrame por fase/ancho, recorrido sintético de ida/vuelta, fuentes e imágenes decodificadas. No certifica fluidez de dispositivos físicos.

| Ancho | Fase | p50 ms | p95 ms | Frames >50 ms | Long tasks |
|---:|---|---:|---:|---:|---:|
| 390 | Nativa | 16,7 | 18,8 | 3 | 0 |
| 390 | GSAP anterior | 16,7 | 18,3 | 1 | 0 |
| 390 | GSAP estabilizada | 16,7 | 17,7 | 0 | 0 |
| 820 | Nativa | 16,7 | 18,1 | 0 | 0 |
| 820 | GSAP anterior | 16,7 | 18,7 | 0 | 0 |
| 820 | GSAP estabilizada | 16,7 | 18,0 | 0 | 0 |
| 1440 | Nativa | 16,7 | 18,5 | 0 | 0 |
| 1440 | GSAP anterior | 16,7 | 18,0 | 0 | 0 |
| 1440 | GSAP estabilizada | 16,8 | 19,2 | 0 | 0 |


## QA y evidencia

| Punto | Resultado |
|---|---|
| Menú responsive | PASS: 12 casos (tres rutas × 390/425/768/820), orden, iconos, CTA, 0, captura, ausencia pública de demos, scroll lock, Escape, Tab/Shift+Tab, retorno. Resize con modal y accesos desktop también pasan. |
| Motion normal y rápido | PASS: Chrome 320/390/425/768/820/1024/1280/1440, Firefox 390/820/1440, primera carga, ida/vuelta, restauración, resize y sin overflow. |
| Hashes y alternativas | PASS: 24 hashes; foco de teclado; reduced inicial/dinámico; sin JS; SDK bloqueado o retrasado; fallos parciales; documento oculto y ausencia de IntersectionObserver. |
| Interacción | PASS: CTA estable durante pulsación de 250 ms, navegación, Guest Stories al reproducir, controles y estados de Hero/carrusel. |
| Apariencia | PASS: geometría y estilos finales idénticos en 253/253/252 nodos (390/820/1440) frente a la referencia nativa que ya coincidía con GSAP anterior. Sin cambios en las recetas. Chrome/Firefox: 390/768/820/1280/1440 sin desbordamiento ni errores de recursos en la pasada de compatibilidad; axe en Chrome sin violaciones en las rutas probadas. |
| QA técnico | PASS: `npm run lint`, `npm run build`, 65 PHP, suites Node de formularios (126 + 27 fechas), carrito, cierre comercial y Home pública (72), parser HTML y `git diff --check`. Build minificado probado. |

`recorrido-mobile.webm` y `recorrido-desktop.webm` son recorridos continuos a velocidad normal. En cada uno se registran **42 entradas de una sola reproducción y 64 actores preparados fuera de pantalla**; los grupos ya visibles al inicio mantienen su estilo final. El muestreo verifica inicio dentro del viewport bajo Header, ausencia de retroceso de opacidad y ninguna repetición en la segunda pasada. `video-*.json` conserva cronología; los PNG y los vídeos muestran Discovery, Wine Club, Private Experiences y el resto del recorrido. Las marcas de la grabación se inyectan solo en el navegador de QA, no en el bundle.

## Archivos, reproducción y pendientes

En esta estabilización se modifica únicamente `assets/js/modules/patterns/movimiento-home.js` y este informe. Se conservan los cambios R6 anteriores del checkout y los tres informes sin seguimiento. `before-hashes.json` y `servidores.json` guardan la comprobación. `main.js`, Header, navegación JS/SCSS, Hero, media y los paquetes se conservan. No existe `.home-public-enabled`.

Abrir `http://localhost:3000/home-preview.php` en el navegador local. Para revisar motion, recargar al principio sin hash y con movimiento normal, y bajar con scroll natural. Para el panel, abrir la hamburguesa a 390, 425, 768 u 820 px. Comparar con `http://127.0.0.1:8017/` si se desea verificar la variante sin demos. El watcher sirve el build de desarrollo; `E/build-final/` conserva el minificado que se midió, para reproducir la comparación sin el proxy.

Pendientes: revisión creativa humana, Safari y dispositivos físicos, mediciones de campo y aceptación del coste residual del motor. No se publica ni se activan servicios comerciales.

---

# Registros históricos íntegros — ver arriba la estabilización vigente

# Home R6 — GSAP + ScrollTrigger

## Estado vigente: implementación pendiente de aprobación visual humana

Sustitución del 2026-11-04 en `feature/home-motion-design`, HEAD `d6f9e46`. La instrucción completa del responsable autoriza y exige GSAP; sustituye la decisión de motor del registro histórico. No se declara aprobada ni cerrada R6. Sin commit, push, PR, merge, deploy ni activación pública.

Evidencia vigente **G**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/gsap-required/`. `evidencia.html` reúne los cinco vídeos y fotogramas; scripts y JSON permiten repetir las pruebas. `before/`, `report-before-implementation.md`, los tres informes locales y todos los registros anteriores se preservan. Los encabezados antiguos que aparecen más abajo son históricos.

## Diagnóstico y sustitución efectiva

La primera R6 solo incorporaba respuestas cromáticas de 180 ms. V2/V3 añadieron entradas demasiado discretas y después más largas, pero V3 construía sus keyframes cuando el contenido llevaba un tiempo visible: el registro previo documenta Discovery visible a 1.972 ms y retrocediendo al inicio a 3.364 ms. La última candidata nativa corrigió ese ciclo con preparación fuera de pantalla, pero seguía moviendo agrupaciones amplias con opacidad completa; fue rechazada creativamente. Esta entrega reemplaza ese motor, no vuelve a ajustar sus parámetros.

`movimiento-home.js` ya no usa IntersectionObserver ni Web Animations API para revelados. Solo GSAP controla estas entradas. Los observadores y animaciones propios de los componentes existentes conservan su función. Header, Hero, carrusel, vídeos, textos, fotografías, tipografía, colores, proporciones, overlays y breakpoints no se rediseñan.

Durante QA se reprodujo otro caso concreto en Firefox: el párrafo introductorio de Wine Club quedaba READY a 506 px dentro de un viewport de 844 px tras un cambio de geometría por carga diferida. El guard de posición rechazaba un onEnter calculado con coordenadas anteriores; `once:true` retiraba prematuramente el trigger. Se eliminó ese cierre anticipado. Ahora el estado COMPLETE retira el trigger, y cada refresh reconcilia los READY con su posición real. La reproducción vuelve a pasar en Firefox 390/820/1440. No se disimula el caso con delays.

## Arquitectura NPM y build

- GSAP **3.15.1** fijado en `package.json` y lockfile. Importaciones específicas de `gsap/gsap-core`, `gsap/CSSPlugin` y `gsap/ScrollTrigger`; sin paquete completo de plugins ni otro motor.
- El esbuild existente resuelve y divide el import dinámico. No se cambió Gulp ni se editó output generado a mano.
- `main.js` conserva inicializaciones de navegación, Account, carrito, Hero y Guest Stories. Solicita el módulo de motion únicamente en la nueva Home y con movimiento permitido, después de decodificar la primera imagen Hero y dos frames. Un error de decodificación también permite el fallback.
- Sin CDN. El Hero y sus recursos no importan GSAP. Legacy y la carga inicial con reduced motion no solicitan el chunk de motion; comprobado por red.
- `gsap.context()` por agrupación, timeline pausada con estados iniciales preparados y `gsap.matchMedia()` para preferencias. La salida revierte los estilos propios, mata triggers y desconecta ResizeObserver/eventos. El WeakMap evita reinicializar.
- Se conservan las transiciones cromáticas R6 de 180 ms del SCSS existente; no son el motor de entrada ni se añade CSS de ocultación.

Referencias primarias contrastadas: [context y revert](https://gsap.com/docs/v3/GSAP/gsap.context()/), [matchMedia](https://gsap.com/docs/v3/GSAP/gsap.matchMedia()/), [ScrollTrigger](https://gsap.com/docs/v3/Plugins/ScrollTrigger/) y [licencia estándar enlazada por el paquete](https://gsap.com/standard-license/). La incorporación se limita a la web del restaurante y está autorizada expresamente por el responsable.

## Ciclo de visibilidad y sincronización

| Estado | Contrato |
|---|---|
| UNINITIALIZED | HTML/CSS visibles por defecto. Ausencia de atributos antes del módulo equivale a este estado. |
| READY | Solo actores todavía fuera del viewport, con margen de seguridad de hasta 48 px. Timeline ya preparada y pausada; no se crea al entrar en pantalla. |
| ENTERING | Se reproduce esa misma instancia con su secuencia local, únicamente tras comprobar la posición real del ancla. |
| COMPLETE | Se retira el trigger y se revierte el contexto al CSS aprobado. No se rearma al subir, bajar ni redimensionar. |

Los elementos ya visibles, recorridos o pertenecientes al hash de entrada pasan directamente de UNINITIALIZED a COMPLETE. Se clasifican con lecturas de geometría agrupadas y se vuelven a comprobar justo antes de preparar cada timeline. No se usa una clase global de ocultación, `inert`, `visibility:hidden` ni bloqueo de puntero. Solo GSAP operativo modifica temporalmente opacidad/translate de actores todavía fuera de pantalla. CTA, datos útiles, superficies de tarjetas y colección audiovisual mantienen siempre opacidad 1.

La línea de lectura es `Header + 16px + 0,84 × espacio restante del viewport`. Cada trigger usa una unidad editorial pequeña: eyebrow/título, párrafo, fotografía o colección. No se espera que entre una sección de varias pantallas. El guard verifica de nuevo la posición real antes de reproducir; si la geometría cambió, programa un único refresh y reconcilia. Si el usuario ya saltó por encima de la cabecera, se completa sin obligarlo a ver una entrada atrasada.

Los elementos de una misma fila solo se coordinan si ya están realmente visibles, dentro de 64 px de la línea de lectura. Stagger de 160 ms, hasta 320 ms, sin activar tarjetas que continúan lejos del viewport móvil. ResizeObserver observa cambios reales de altura de main/Header y agrupa refresh en requestAnimationFrame. No hay listeners propios permanentes de scroll; ScrollTrigger administra los suyos. No hay pin, scrub, marcadores ni reconstrucción de timelines en resize.

## Lenguaje y secuencias

44 timelines locales, 67 actores. En las grabaciones completas, dos grupos ya visibles se conservan sin entrada; los 42 restantes se reproducen una vez. Las maestras Discovery y Wine Club se construyeron y capturaron primero en `pilot-*`; después se extendió el patrón con variaciones por composición. La evidencia válida de entrega es `recorrido-*`, no los pilotos.

| Perfil | Duración | Traslado Y | Opacidad inicial |
|---|---:|---:|---:|
| Eyebrow | 800 ms | 16 px | 0 |
| Título principal | 1.120 ms | 32 px | 0 |
| Título secundario corto | 1.000 ms | 22 px | 0 |
| Texto | 1.000 ms | 22 px | 0 |
| Texto corto | 950 ms | 18 px | 0 |
| Fotografía base | 1.250 ms | 34 px | 0,20 |
| Acción | 800 ms | 10 px | **1** |
| Superficie Diamond | 1.180 ms | 18 px | **1** |
| Colección audiovisual | 1.150 ms | 26 px | **1** |
| Datos Visit | 900 ms | 10 px | **1** |

Easing central `power2.out`. Título a +140 ms respecto al eyebrow; CTA a +200 ms respecto a su párrafo. Las timelines principales de título duran 1.260 ms; las de texto/CTA, 1.000 ms. No son esperas globales. Se anima `translate` independiente para conservar transforms CSS ya existentes; sin escalas, rotaciones, rebotes ni animaciones por palabra.

| Sección | Secuencia aplicada y preservación |
|---|---|
| Discovery | Introducción editorial; las tres fotografías entran por contenedor picture; títulos y párrafos/CTA tienen unidades propias. Stagger entre pares de la misma fila; en móvil cada composición espera su llegada real. |
| Pure Soul | Eyebrow, título y firma coordinados; póster y marco se trasladan juntos 22 px / 1.300 ms, opacidad 0,40; declaración y relato/CTA independientes. Fotografía y encuadre intactos. |
| Private Experiences | Marco visual 24 px / 1.300 ms, opacidad 0,45; la animación CSS fotográfica interior se conserva. Eyebrow, título y relato/CTA tienen su propia secuencia. |
| Guest Stories | Encabezado y párrafos por unidades; colección como conjunto, opacidad 1. No se animan vídeos individualmente. Al reproducir, se completa su entrada para conservar la interacción. |
| Reservation Invitation | Mensaje y relato/CTA coordinados; nota de confirmación y fotografía de fondo sin nuevo efecto. CTA siempre visible. |
| Wine Club | Introducción; Diamond con superficie suave, eyebrow y título principal; relato/CTA propio. Gold entra como título secundario y relato, sin exagerar jerarquía; fotografía de selección 26 px / opacidad 0,35. |
| Gifting | Introducción; hamper 30 px / 1.200 ms, firma 12 px / 850 ms, relato/CTA; arte de Gift Card 18 px / 1.100 ms / opacidad 0,35 y editorial corta propia. Sin deformación. |
| Visit | Fotografía 28 px / 1.180 ms / opacidad 0,35; editorial corta y CTA; datos 10 px con opacidad completa. Teléfono y confirmación conservan disponibilidad inmediata. |
| Header, Hero, Footer | Sin nuevos revelados. Se conservan movimientos y controles aprobados. |

## Accesibilidad y navegación comercial conservada

Sin JavaScript, import bloqueado o fallo de GSAP: contenido legible por CSS. Las excepciones después de preparar parcialmente o crear triggers revierten también los contextos ya creados. Con movimiento reducido inicial no se descarga el módulo; si cambia durante la sesión se completa y destruye. No se rearma al volver a movimiento normal. Ocultar la página destruye la mejora; perder foco completa entradas en curso.

Hashes y restauración conservan visibles los destinos. El foco de teclado dentro de main completa su sección visible; si el auto-scroll todavía no la alcanzó, completa todas las entradas para priorizar el recorrido funcional. El foco de Header/modales no cancela la película de la Home. Pointerdown pausa la timeline propietaria mientras se mantiene pulsado un CTA; pointerup/cancel continúa. Se verificaron 250 ms de pulsación sin desplazamiento del destino y navegación real.

Se preservan sin modificación las fuentes de navegación de la fase anterior. Account y View cart del panel Preview abren los mismos componentes, cierran menú, transfieren foco, mantienen contador 0, Escape y retorno al botón válido del Header. No se crean modales/listeners paralelos. Candidata pública sin controles ni modales comerciales ficticios. La futura integración real debe proporcionar disponibilidad, proveedor de cuenta/sesión y servicio de carrito/pedidos/checkout, conectar los puntos existentes y actualizar contador/estado; no basta con renderizar iconos. Nada de ello se activa aquí.

## Evidencia visual y QA

`evidencia.html` contiene vídeos continuos reales de Chrome de QA a 1×, sin cortes ni aceleración:

- `recorrido-mobile.webm`, 390×844: Home completa, menú Account/cart y segunda pasada.
- `recorrido-desktop.webm`, 1440×1000: Home completa y segunda pasada.
- `recorrido-discovery.webm`: fotografías, títulos y CTA.
- `recorrido-wine-club.webm`: introducción, Diamond, Gold y selección visual.
- `recorrido-private-experiences.webm`: fotografía, editorial y CTA.

Los detalles incluyen una aproximación por scroll rápido y después scroll normal dentro de la sección. Es velocidad real de navegación, no vídeo acelerado. Cada secuencia tiene PNG antes/inicio/mitad/final y JSON con preparación, primer instante visible, comienzo exacto, muestras por frame y COMPLETE. “Mitad” se programa al 50% de la timeline; el coste de captura/scroll puede desplazar algunos milisegundos el fotograma efectivo. No se presenta como medida de frame exacto de GPU.

La instrumentación de la grabación añade únicamente lecturas de diagnóstico en la respuesta del navegador; no se entrega en el bundle. Se verifican preparaciones fuera de pantalla, comienzos dentro del viewport bajo Header, opacidad monotónica sin flash de estado final previo, una entrada por grupo y estado final completo. El registro no sustituye los vídeos ni la inspección de los fotogramas.

La herramienta de revisión interactiva de Windows bloqueó el acceso al navegador porque no pudo verificar su URL con suficiente confianza. No se realizaron más acciones nativas. Se completaron los vídeos de navegador de QA y la inspección visual de PNG; queda pendiente la valoración creativa humana en localhost. No se declara revisión manual interactiva completa ni aprobación.

| Prueba | Resultado / evidencia |
|---|---|
| 320, 390, 768, 820, 1024, 1280 y 1440 px | PASS: carga, entradas, scroll ida/vuelta, resize y overflow 0; `qa.json`. |
| Firefox normal 390/820/1440 | PASS después de corregir retiro prematuro; `firefox-motion.json`. |
| Chrome y Firefox 390/768/820/1280/1440 | PASS imágenes, layout, consola y recursos; Chrome axe sin violaciones reportadas; `compatibilidad.json`. No equivale a certificación WCAG. |
| Hashes | PASS 24 destinos, ocho por 390/820/1440; visibilidad inmediata. |
| Teclado, foco y modales | PASS Tab/Shift+Tab, Escape, transferencia/retorno, resize con modal, desktop; `qa.json`, `nav-*.json`. |
| Fallos y preferencias | PASS sin JS, reduced inicial/dinámico, módulo bloqueado/retrasado, fallo parcial, fallo de triggers, documento oculto. |
| CTA y vídeo durante entrada | PASS pulsación 250 ms, navegación nativa, vídeo completa entrada; `interaccion.json`. |
| Hero y Guest Stories | PASS controles, teclado y reproducción; `controles.json`. |
| Geometría final | PASS 253/253/252 nodos en 390/820/1440: cajas, tipografía, colores, fondos, opacity, transform/translate, object-fit/position idénticos a la referencia nativa; `geometry.json`. |
| HTML | PASS Preview/candidata pública: parser sin errores, IDs/referencias, un h1/main, alt y destinos; `html-routes.json`. |

## Coste y rendimiento medidos

Build minificado con `npm run build`, copia congelada en `G/build-final`. Los bytes son respuestas realmente solicitadas por Home, no la suma de todos los bundles del proyecto. Gzip se calcula con zlib: el servidor PHP local no habilita compresión HTTP; no confundir estimación gzip con transferencia real del laboratorio.

| Versión | JS minificado | JS gzip | CSS minificado | CSS gzip | Peticiones JS |
|---|---:|---:|---:|---:|---:|
| r5 | 43.238 B | 14.786 B | 97.397 B | 16.619 B | 4 |
| native | 50.955 B | 17.025 B | 98.413 B | 16.790 B | 4 |
| gsap | 169.178 B | 63.683 B | 98.413 B | 16.790 B | 5 |

Frente a R6 nativa: **+118.223 B JS minificado / +46.658 B gzip**, **0 B CSS**, **una petición adicional**. Chunk Home con SDK y adaptador: 124.263 B / 48.414 B gzip. La sonda aislada del SDK fue 115.728 B / 45.575 B gzip; no sustituye el coste del paquete final. Hero y carruseles conservan exactamente sus chunks anteriores.

Cobertura V8, fuente UTF-8 de scripts propios con rangos ejecutados, navegador 390 px, carga inicial y recorrido: no son instrucciones CPU ni transferencia. Los intervalos anidados se resuelven por el rango más específico. coverage.cjs y coverage.json contienen la metodología y resultados.

| Versión | Fuente recorrida en carga | Fuente recorrida durante carga + tour |
|---|---:|---:|
| r5 | 15.340 B | 16.019 B |
| native | 19.965 B | 21.747 B |
| gsap | 58.077 B | 90.975 B |

### Lighthouse comparable a R4

27 pasadas: tres por fase y ancho, alternando R5 → nativa → GSAP. Lighthouse 13.4.1 / Chrome 156, red simulada RTT 150 ms, 1638,4 Kbps y CPU ×4 también en desktop; 390×844 DPR3, 820×1180 DPR2, 1440×1000 DPR1. Candidatas públicas aisladas sin BrowserSync ni controles demo: R5 `8025` desde `../baseline-site`, última nativa `8026` desde `G/native-site`, GSAP `8017` desde checkout. Sin reduced motion, sin ocultar LCP ni bloquear fuentes. Sin builds, grabaciones ni otros navegadores de QA simultáneos. Se conservan todos los LHR y trazas de la primera pasada.

Medianas, no mejores resultados:

| px | Versión | Score | LCP s | TBT ms | CLS | JS CPU ms | Hilo principal ms | Solicitudes |
|---:|---|---:|---:|---:|---:|---:|---:|---:|
| 390 | r5 | 64 | 5,972 | 394,0 | 0,00000 | 66 | 2218 | 19 |
| 390 | native | 64 | 6,025 | 360,0 | 0,00000 | 112 | 2283 | 19 |
| 390 | gsap | 59 | 6,554 | 514,1 | 0,00000 | 483 | 3207 | 20 |
| 820 | r5 | 57 | 7,305 | 409,0 | 0,00000 | 105 | 3708 | 26 |
| 820 | native | 57 | 7,299 | 568,0 | 0,00000 | 133 | 3262 | 26 |
| 820 | gsap | 53 | 8,007 | 686,0 | 0,00000 | 519 | 4064 | 27 |
| 1440 | r5 | 38 | 6,402 | 505,0 | 0,00026 | 98 | 3319 | 25 |
| 1440 | native | 37 | 6,504 | 604,0 | 0,00026 | 154 | 3163 | 25 |
| 1440 | gsap | 34 | 7,086 | 679,0 | 0,00026 | 567 | 4468 | 26 |

Rangos completos de laboratorio:

| px | Versión | LCP min–max s | TBT min–max ms | CLS min–max |
|---:|---|---:|---:|---:|
| 390 | r5 | 5,945–5,985 | 364,0–626,0 | 0,00000–0,00000 |
| 390 | native | 5,813–6,027 | 40,0–476,0 | 0,00000–0,00637 |
| 390 | gsap | 6,545–6,690 | 483,5–583,8 | 0,00000–0,00000 |
| 820 | r5 | 7,297–7,331 | 393,0–594,0 | 0,00000–0,00000 |
| 820 | native | 7,298–7,301 | 491,0–623,0 | 0,00000–0,00000 |
| 820 | gsap | 7,983–8,056 | 638,0–906,0 | 0,00000–0,00000 |
| 1440 | r5 | 6,338–6,572 | 415,0–517,0 | 0,00026–0,00026 |
| 1440 | native | 6,481–6,546 | 593,0–914,2 | 0,00026–0,00026 |
| 1440 | gsap | 7,000–7,142 | 678,0–765,5 | 0,00026–0,00026 |

El coste de GSAP **sí produce regresiones de laboratorio**. Frente a nativa, LCP mediano cambia 390 px: +529 ms; 820 px: +707 ms; 1440 px: +582 ms. No se atribuye ninguna mejora a variaciones del score o TBT. El Hero no se oculta ni espera al motor para mostrarse, pero descarga/parseo/ejecución y el grafo de simulación tienen coste real; no se afirma que la espera de dos frames haga gratuito el SDK. El cambio de motor se conserva por el encargo creativo explícito, con este coste pendiente de aceptación. LCP de laboratorio sigue por encima de 2,5 s; no hay métricas de campo/RUM ni prueba de mejora de conversiones.

### Fluidez

Recorrido determinista de 300 frames por fase/ancho, ida y vuelta, fuentes e imágenes decodificadas, sin vídeo ni cobertura V8 activos. Este muestreo sintético no certifica dispositivos físicos. `scroll.json` conserva intervalos, tareas y grupos activos.

| px | Versión | p50 ms | p95 ms | Frames >50 ms | Long tasks |
|---:|---|---:|---:|---:|---:|
| 390 | r5 | 16,7 | 17,8 | 4 | 0 |
| 390 | native | 16,7 | 17,4 | 0 | 0 |
| 390 | gsap | 16,7 | 17,6 | 1 | 0 |
| 820 | r5 | 16,7 | 17,6 | 0 | 0 |
| 820 | native | 16,7 | 17,3 | 0 | 0 |
| 820 | gsap | 16,7 | 17,6 | 0 | 0 |
| 1440 | r5 | 16,7 | 17,4 | 0 | 0 |
| 1440 | native | 16,7 | 17,3 | 0 | 0 |
| 1440 | gsap | 16,7 | 17,8 | 0 | 0 |

### Registro temporal de las secuencias representativas

Tiempos respecto a navegación, primera pasada desktop. Duración efectiva entre ENTERING y primer frame COMPLETE, incluye stagger y precisión de muestreo. La tabla de perfiles anterior contiene el traslado/timing configurado. JSON y vídeos mantienen la cronología completa del primer instante visible, desarrollo y segunda pasada.

| Grupo | Inicio ms | Posición top / viewport | Duración efectiva ms |
|---|---:|---:|---:|
| discovery-foto-0 | 2700 | 843 / 1000 px | 1274 |
| discovery-relato-0-titulo | 7264 | 817 / 1000 px | 1288 |
| discovery-relato-0-texto-0 | 7265 | 850 / 1000 px | 1019 |
| club-diamond-titulo | 27.620 | 850 / 1000 px | 1270 |
| club-diamond-texto-0 | 30.061 | 828 / 1000 px | 1004 |
| club-fotografia | 28.156 | 838 / 1000 px | 1244 |
| private-fotografia | 14.072 | 831 / 1000 px | 1315 |
| private-titulo | 15.677 | 828 / 1000 px | 1271 |
| private-texto-0 | 18.170 | 827 / 1000 px | 1020 |

QA técnico final: `npm run lint`, `npm run build`, PHP lint **65 archivos**, suites Node de formularios (**126 casos + 27 fechas PHP**), carrito, cierre comercial y Home pública (**72 contratos**), validación HTML Preview/pública, smoke del build minificado y `git diff --check`: PASS. `min-smoke.json` verifica el bundle minificado además del QA completo de las fuentes de desarrollo.


## Archivos y protección

Esta sustitución modifica `assets/js/main.js`, reemplaza `assets/js/modules/patterns/movimiento-home.js`, incorpora GSAP en `package.json` / `package-lock.json` y actualiza este informe. No añade CSS respecto a la última candidata nativa.

El diff completo de la rama también contiene trabajo R6 previo aprobado en Header, navegación JS/SCSS, Hero, media y el archivo SCSS de microinteracciones; se conserva. `protected-hashes.json` y la verificación final comprueban las fuentes protegidas y los tres informes originales. No se editan fotografías, PHP ni documentos históricos en esta sustitución. El marcador de Home pública sigue ausente y la raíz local legacy no cambia.

## Cómo revisar y límites

Abrir `http://localhost:3000/home-preview.php`, confirmar movimiento normal del sistema y recargar al inicio sin hash. Desplazarse de forma natural; las entradas son de una sola reproducción. Para repetir una sección, recargar desde arriba y volver a ella. Un hash directo, restauración intermedia, teclado o movimiento reducido priorizan visibilidad y pueden omitir la animación deliberadamente. No son demostraciones del recorrido cinematográfico inicial.

3000 es BrowserSync → PHP 8018 del checkout actual; no se presupone equivalencia con 8017. Se contrastan respuestas y hashes con los assets del build. 8017 sirve la candidata pública aislada para QA/performance con noindex; no activa producción. El watcher queda disponible al terminar. `npm run build` produce el paquete minificado; los vídeos y el watcher de revisión usan el build de desarrollo de las mismas fuentes.

Pendiente: aprobación visual humana, revisión en dispositivos físicos y Safari, métricas de campo/RUM, activación e integración comercial real. No se atribuye una mejora de conversión a las animaciones. Los vídeos no constituyen aprobación creativa. Los resultados de laboratorio se reportan con sus regresiones y variación.

---

# Registros históricos íntegros — no representan la arquitectura vigente

# Home R6 — sustitución obligatoria por GSAP + ScrollTrigger

## Estado vigente: preparación, encargo recibido incompleto

El responsable rechaza visualmente la candidata nativa y autoriza expresamente GSAP 3 + ScrollTrigger. Esta instrucción sustituye la selección de motor documentada anteriormente. La navegación responsive de cuenta/carrito se conserva. No se declara implementada ni aprobada la nueva arquitectura.

Se confirmó feature/home-motion-design y el servidor 3000 → PHP 8018. Se guardaron fuentes, navegación e informe anteriores en `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/gsap-required/before/`. GSAP 3.15.1 quedó instalado y fijado en package.json/package-lock.json. La prueba aislada de esbuild con importaciones de gsap-core, CSSPlugin y ScrollTrigger compila: 115.728 B minificados / 45.575 B gzip, antes del adaptador de Home. Son pesos de prueba, no métricas de la Home final. Resultado y script en bundling.json y probar-bundling.mjs del mismo directorio.

El mensaje termina literalmente en «Mantener intactas las transiciones existentes del He». Se solicitó la continuación antes de definir las secuencias creativas faltantes. El motor servido todavía es el nativo anterior: no se ha activado GSAP ni se han superpuesto motores. La sustitución, QA visual/temporal y mediciones de la nueva propuesta están pendientes.

Sin commit, push, PR, merge, deploy ni activación de Home pública. Los informes históricos y el código previo se preservan.

---

## Registro anterior íntegro — candidata rechazada, no vigente

# Home R6 — Motion Engine & Responsive Navigation

## Estado vigente: pendiente de revisión visual humana

Corrección del 2026-11-04 en `feature/home-motion-design`, HEAD `d6f9e46`. No se declara aprobada ni cerrada R6. Sin commit, push, PR, merge, deploy ni activación pública. Los registros R6 inicial, V2 y V3 se conservan íntegros al final; sus antiguos encabezados de estado son históricos.

Evidencia actual **EN**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/engine-navigation/`. Se aplicó `.agents/skills/qa-visual/SKILL.md`; se leyeron las normas, Design System, Visual Direction, R2–R6 y componentes afectados. Se contrastó la raíz legacy de `production-baseline`; no se altera.

## Causa raíz reproducida en localhost:3000

`diagnostico.json` y el vídeo de `diagnostico/` reproducen V3: la primera pieza Discovery está visible a los 1.972 ms, opacidad 1, `translate: none`, estado `pendiente`. A los 3.364 ms se crea `Element.animate()` desde opacidad 0,24 y 48 px. El bloque ya llevaba aproximadamente 1,4 s visible cuando retrocedía al inicio. No era un retraso de inicialización: el módulo ya había registrado el elemento. Tampoco era una copia vieja de CSS: la respuesta cargaba los assets actuales del checkout.

V3 observaba una región situada al 52% del espacio bajo Header y **creaba** los keyframes al alcanzar esa región. Mantener visible el estilo subyacente y después aplicar un keyframe inicial distinto causaba el doble efecto. Aumentar duración o delay no lo resuelve.

3000 es BrowserSync → PHP 8018 del checkout actual. La candidata pública aislada usa 8017 y la referencia V3 congelada usa 8023. No se presupone equivalencia entre puertos: se comparan respuestas y hashes con disco. `servidor-final.json` documenta la comprobación final. `gsap-evaluated/` conserva la candidata experimental; recorrido-*, timeline-*, chronology.json, native-build-final/ y la última performance.json identifican la evidencia final válida. Las grabaciones bajo `superseded-*` no representan la entrega.

## Motor seleccionado y evaluación de GSAP

**Web Animations API + un IntersectionObserver compartido**, sin dependencias nuevas ni solicitudes adicionales. La implementación anterior de revelados fue sustituida; no hay dos motores de entrada compitiendo.

Se instaló y compiló GSAP 3.15.1 + ScrollTrigger de forma local y modular para Home. Es compatible con el bundler ES Modules/esbuild; se verificó la [licencia estándar sin coste](https://gsap.com/community/standard-license/) y la [API oficial de ScrollTrigger](https://gsap.com/docs/v3/Plugins/ScrollTrigger/). El uso previsto es una web de restaurante, dentro del uso permitido descrito por esa licencia.

La candidata GSAP añadió **117.682 B de JS minificado / 46.176 B gzip** respecto a V3 y una solicitud. Dos series comparables de 18 navegaciones, incluida una carga posterior al primer frame del Hero, conservaron un aumento repetido de LCP simulado de aproximadamente 0,4–0,7 s y más trabajo de hilo principal. No se interpreta una oscilación de TBT o puntuación como mejora.

También se reprodujo un cambio de altura de 216 px durante la carga diferida en móvil: ScrollTrigger necesitaba refrescar sus posiciones cacheadas. La alternativa nativa usa directamente la geometría actual del observador. Las pruebas temporales, los fallos deliberados, los 17 movimientos reales y las mediciones finales justifican elegirla para este alcance. GSAP se desinstaló; `package.json` y `package-lock.json` coinciden con HEAD. No queda GSAP, ScrollTrigger ni anime.js en el bundle servido. La evaluación, versiones, builds y 36 resultados GSAP se preservan en `before-lcp-scheduling/` y `gsap-evaluated/`.

## Ciclo de vida inequívoco

| Estado | Comportamiento |
|---|---|
| UNINITIALIZED | HTML/CSS legibles por defecto; sin clase global de ocultación. Ausencia del atributo antes de inicializar equivale a este estado. |
| READY | Solo bloques todavía fuera de pantalla. Se crea una animación propia pausada, `currentTime=0`, `fill: both`; opacidad completa. El primer frame visible ya tiene el traslado preparado. |
| ENTERING | Se reproduce **la misma instancia**, con stagger local en milisegundos. No se construyen keyframes al entrar en pantalla. |
| COMPLETE | Se cancela el efecto propio y se deja el estilo aprobado subyacente; se retira la observación. No se rearma al subir/bajar. |

Incluso READY es visible, legible e interactivo: no se usa opacidad inicial baja, `visibility:hidden`, `inert` ni bloqueo de puntero. Una inicialización parcial cancela también una animación creada justo antes de lanzar una excepción, identificada como `cl-home-entrada`; no cancela animaciones ajenas. Esta es una diferencia funcional respecto a V3, aunque reutilice las APIs nativas.

La inicialización espera la decodificación del primer recurso Hero y dos frames, para priorizar su pintura. Un fallo de decodificación sigue el mismo fallback. No espera un evento de scroll ni oculta contenido. Los bloques ya visibles al inicializar, restaurar o abrir un hash conservan directamente el estado final. No se promete pintura mientras el `blocking="render"` preexistente de `main.js` esté pendiente; ese contrato de R4 se conserva.

Foco de teclado completa su grupo inmediatamente. Una pulsación congela el movimiento hasta pointerup/cancel para estabilizar el target. Reproducir un vídeo completa la entrada de su colección. Ocultar la página o activar reduced motion cancela todos los efectos. Al volver a movimiento normal no se reproducen de nuevo entradas terminadas. Sin JS, sin IO/WAAPI, con IO fallido o inicialización interrumpida, permanece el contenido en su diseño final.

## Activación y parámetros

La región empieza en la altura real del Header +16 px y termina al **82% del espacio restante**. `threshold:0` se refiere al contacto con esa región interna; no exige que un porcentaje de un contenedor enorme entre en pantalla. Se observan imágenes, eyebrows o encabezados reales según el bloque. Un salto rápido que supera la zona completa el elemento. No hay listeners propios de scroll ni timers globales de reproducción.

Un ResizeObserver del Header y el resize de ventana actualizan únicamente el margen del observador, limpiando el anterior. Los efectos no se reconstruyen. Los cambios de altura del contenido son atendidos por las intersecciones reales, sin cachear posiciones ni ejecutar refresh de scroll. Una cohorte solo incluye compañeros del mismo grupo ya visibles hasta 64 px de la línea de lectura, limitada además por el viewport. El orden central mantiene Diamond antes de Gold cuando comparten fila. En móvil cada bloque lejano espera a su propia entrada.

Easing único: `cubic-bezier(0.45, 0, 0.55, 1)`. Stagger: 170 ms, únicamente entre vecinos visibles; máximo 340 ms. Las duraciones siguientes excluyen ese stagger. Opacidad 1 durante todo el ciclo.

| Sección / elemento | Duración | Traslado |
|---|---:|---:|
| Discovery, tres piezas | 1.150 ms | 48 px |
| Pure Soul, cabecera / relato | 1.100 / 1.150 ms | 40 / 44 px |
| Private Experiences, invitación textual | 1.100 ms | 38 px |
| Guest Stories, editorial / colección completa | 1.100 / 1.050 ms | 42 / 36 px |
| Reservation Invitation, mensaje y CTA | 1.100 ms | 40 px |
| Wine Club, introducción / Diamond / Gold | 1.100 / 1.200 / 1.050 ms | 40 / 50 / 38 px |
| Gifting, selección / hampers / Gift Card | 1.150 / 1.150 / 1.100 ms | 44 / 44 / 38 px |
| Visit, fotografía / información | 1.100 / 1.050 ms | 42 / 36 px |

Se conservan Hero, Header, Footer, microinteracciones cromáticas R6 de 180 ms y la animación fotográfica CSS existente de Private Experiences. No se anima el encabezado general de Discovery, el póster/marco Pure Soul, la selección fotográfica del Club ni los vídeos por separado. Sin zoom, rotación, parallax nuevo ni cambios de tipografía, copy, encuadre, imagen, spacing o proporción. Header y vídeo solo reciben guardas para que la ausencia de IO no interrumpa sus controles; sus transiciones normales no cambian.

## Navegación comercial responsive

Account y View cart se integran después de Request a Table, dentro del mismo nav y antes del footer del panel. Reutilizan tipografía, tokens, iconos y targets existentes. El Header conserva sus accesos y geometría; no hay segundo árbol de navegación. Los accesos del panel se ocultan en escritorio mediante el breakpoint Bootstrap xl (1.200 px).

El anfitrión conecta cada acción solo cuando existe su componente funcional. `conectarAccesoPanel()` revela el control; `ejecutarAccion()` espera `hidden.bs.offcanvas` antes de abrir el modal existente. No se añaden modales, proveedores, toggles Bootstrap ni listeners duplicados sobre un mismo activador. Cuenta reutiliza `inicializarAcceso()` y carrito el único modal `carrito-preview`. `actualizarCarrito()` alimenta tanto Header como panel: Preview muestra 0 y declara que no hay servicio conectado.

El foco pasa al campo/cierre del modal. Escape conserva Bootstrap y devuelve el foco al icono correspondiente del Header: ese destino sigue visible al cambiar de móvil a escritorio. Discover conserva su Escape propio y el drawer mantiene Tab/Shift+Tab. Las pruebas incluyen resize con el modal abierto.

La candidata pública mantiene `$mostrarAccesoNavegacion=false` y carrito no disponible: no renderiza estos accesos ni modales demostrativos. Para servicios reales, el anfitrión deberá aportar disponibilidad comprobada, un único panel de cuenta y el proveedor/panel reales de carrito, conectar el control del panel a esa misma instancia y completar sus referencias ARIA. `conectarCarrito(proveedor,panel,crearMiniCarrito)` conserva la suscripción común y el contador. Cuenta, pedidos y checkout requieren sus módulos reales y validación propia antes de habilitar esas variables; esta entrega no los activa.

## Evidencia temporal y visual

Vídeos continuos 1×, sin cortes ni aceleración, de navegador real con viewports responsive emulados (no hardware móvil):

- [Recorrido móvil 390 px](C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/engine-navigation/recorrido-390.webm): incluye menú, cuenta, carrito, recorrido completo, subida y segunda pasada.
- [Recorrido desktop 1440 px](C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/engine-navigation/recorrido-1440.webm): recorrido completo y segunda pasada.
- [Galería de vídeos y fotogramas](C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/engine-navigation/evidencia.html).

`timeline-390.json` y `timeline-1440.json` registran creación antes de visibilidad, primer instante visible, primer movimiento real, finalización y segunda pasada. Se exige que los **17 grupos se muevan físicamente**, no solo que cambien un atributo. La captura comprueba opacidad 1, traslado monótono hacia cero y ninguna segunda activación. Los logs complementan los vídeos; no los sustituyen.

| Secuencia | Primer instante visible en vídeo | ENTERING | Duración efectiva | COMPLETE |
|---|---:|---:|---:|---:|
| 390 / discovery | 6.239 s, READY, 0px 48px | 6.606 s | 1157 ms | 7.763 s, sin translate |
| 390 / diamond | 21.309 s, READY, 0px 50px | 21.859 s | 1206 ms | 23.065 s, sin translate |
| 1440 / discovery | 2.075 s, READY, 0px 48px | 2.827 s | 1155 ms | 3.982 s, sin translate |
| 1440 / diamond | 14.769 s, READY, 0px 50px | 15.671 s | 1206 ms | 16.877 s, sin translate |

Discovery desktop registra comienzos físicos separados aproximadamente 167/332 ms respecto al primero (objetivo 170/340 ms, resolución por frames). Cada bloque móvil empieza al llegar, sin retraso heredado de otros bloques lejanos. Los tiempos de vídeo se correlacionan mediante reloj de grabación; tolerancia de un frame de captura.

Para Discovery y Diamond se capturan `before`, `first-visible`, `start`, `half` y `final` en ambos anchos. Los PNG corresponden al recorrido grabado; no se modifican fotografías ni se simulan frames. `chronology.json` resume los tiempos. Los dos clips y los 20 PNG válidos están en EN; las variantes descartadas están identificadas aparte.

## Rendimiento final

Metodología R4: Chrome 156 / Lighthouse 13.4.1, build minificado, PHP local sin BrowserSync; 390×844 DPR3, 820×1180 DPR2 y 1440×1000 DPR1; RTT150 ms, 1.638,4 kbps y CPU×4, también en desktop. Tres pasadas alternadas por variante/ancho. Los datos siguientes usan únicamente la última serie comparable V3/nativa; no se mezclan medianas de distintas series.

| Ancho | LCP V3 → final (s) | CLS V3 → final | TBT V3 → final (ms) | Hilo principal V3 → final (ms) | Solicitudes |
|---|---:|---:|---:|---:|---:|
| 390 | 6.107 → 6.092 | 0.000000 → 0.000000 | 341 → 354 | 1731 → 1930 | 19 → 19 |
| 820 | 7.379 → 7.367 | 0.000000 → 0.000000 | 407 → 430 | 2195 → 2198 | 26 → 26 |
| 1440 | 6.472 → 6.463 | 0.000255 → 0.000255 | 380 → 434 | 2163 → 2174 | 25 → 25 |

LCP y CLS permanecen comparables. TBT aumenta 13/23/54 ms en las medianas de esta serie; los rangos se solapan en tablet/desktop. Se registra ese coste y la dispersión, sin atribuir una mejora causal a puntuaciones o diferencias pequeñas. No se reproduce el aumento de LCP de la candidata GSAP.

| Payload Home minificado | V3 | Final | Diferencia |
|---|---:|---:|---:|
| JS total solicitado | 49013 B | 50955 B | +1942 B |
| JS gzip de referencia | 16611 B | 17025 B | +414 B |
| CSS Home | 97861 B | 98413 B | +552 B |

**Cero dependencias y cero peticiones nuevas.** El JS nativo permanece en main.js, como en V3; la ejecución se limita a Home. CSS gzip añade 78 B. Gzip es una referencia de compresión del contenido, no una afirmación sobre la configuración del hosting. Los minificados medidos se conservan en native-build-final/; 3000 se restaura con assets dev y watcher para revisión visual de la misma fuente.

Frente a R5 y R6 inicial (43.238 B JS), el total final es 50.955 B: +7.717 B para toda R6 y esta corrección de navegación. CSS pasa de 97.397 B en R5 a 98.413 B (+1.016 B), y desde 97.861 B de R6 inicial a 98.413 B (+552 B). Estas cifras de payload son comparables; las mediciones Lighthouse actuales contrastan exclusivamente V3 y la candidata final. El coste final se contrasta además con esa base mediante `bytes-historicos.json`. No se alteran las optimizaciones AVIF/WebP, precarga ni prioridad LCP. No se atribuyen mejoras de conversión ni de rendimiento de campo a oscilaciones de laboratorio.

| Ancho | p95 frame V3 → final (ms) | Frames >50 ms V3 → final |
|---|---:|---:|
| 390 | 17.8 → 17.6 | 1 → 0 |
| 820 | 17.7 → 17.5 | 0 → 0 |
| 1440 | 17.6 → 17.7 | 0 → 0 |

Stress de 300 frames por variante/ancho, imágenes decodificadas antes de medir, sin otros navegadores de QA ni builds concurrentes. No se interpreta una diferencia de décimas como ganancia de fluidez. Los vídeos naturales complementan esta prueba sintética.

Los JSON Lighthouse, trazas y datos de fluidez están en EN. Se conserva la dispersión y los resultados descartados de GSAP; una puntuación más alta aislada no se presenta como mejora causal. No hay RUM/CrUX ni medición de INP de campo.

## QA técnico, responsive y accesible

| Prueba | Resultado / evidencia |
|---|---|
| 320, 390, 768, 820, 1024, 1280, 1440 | PASS: entradas, scroll rápido, vuelta sin repetición, restauración y resize; overflow 0 (`qa.json`). |
| Hashes | PASS: ocho secciones × 390/820/1440; contenido de destino completo inmediatamente. |
| Fallbacks | PASS: sin JS, reducido, sin IO, sin WAAPI, IO fallido, JS bloqueado/retrasado y fallo después de crear un efecto (`fallbacks.json`). |
| Reduced motion durante sesión | PASS: cancela todos los efectos; no rearma al desactivarlo. |
| Teclado / interacción | PASS: Tab/Shift+Tab, Escape, foco visible, pulsación estable de 250 ms y navegación real de CTA (`interaccion.json`). |
| Preview | PASS: cuenta, carrito, contador 0, un modal, cierre del drawer, foco y retorno; 390/820 y resto de anchos móviles. |
| Resize del modal | PASS: 390→1440 mantiene destino de retorno válido (`nav-resize.json`). |
| Candidata pública | PASS: cero controles/modales comerciales ficticios. |
| Hero / Guest Stories | PASS: Home/End, escenas inert, flechas, scroll snap, reproducción y pausa al navegar; iniciar vídeo completa su entrada (`controles.json`, `play.cjs`). |
| Comparación visual | PASS: geometría final idéntica a V3 en 390/820/1440; 253/253/252 elementos comparados (`geometry.json`). |
| Chrome / Firefox (layout y reduced motion) | PASS: 390/768/820/1280/1440; consola y recursos normales sin errores (`compatibilidad.json`). |
| Movimiento Firefox | PASS: entradas, reverse scroll, restauración y resize en 390/1440 (`firefox-motion.json`). |
| axe | PASS: Chrome, cinco anchos, incluida navegación abierta en móvil/tablet; cero infracciones automáticas. No equivale a certificación WCAG. |
| npm lint / build | PASS: ESLint, Stylelint y Gulp/esbuild/Sass. |
| PHP | PASS: lint de 65 archivos; 27 pruebas de fechas/DST/sesión. |
| Suites Node | PASS: formularios (126), carrito, cierre comercial y Home pública (72). Correo nativo deshabilitado en fixtures. |
| HTML | PASS: html5lib, IDs/ARIA/labels/alt, un H1/main; 48 IDs públicos y 52 Preview; sitemap parseado (`html-routes.json`). |
| Git | PASS: diff check, rama correcta, índice sin staging y HEAD sin cambios. |

## Archivos y protección

| Archivo | Alcance |
|---|---|
| `assets/js/main.js` | Inicialización tras portada y conexión de accesos Preview al mismo modal. |
| `assets/js/modules/patterns/movimiento-home.js` | Sistema nativo compartido, preparación, estados, cohortes y fallbacks. |
| `assets/js/modules/patterns/navegacion-global.js` | Acciones del panel, cierre coordinado, contador compartido y guarda sin IO. |
| `assets/js/modules/patterns/escenas-hero.js` | Guarda sin IO; conserva selección manual, sin autoplay fuera de pantalla. |
| `assets/js/modules/patterns/carrusel-media.js` | Guarda sin IO; mantiene exclusión de reproducción y pausa por navegación/visibilidad. |
| `assets/scss/home.scss` | Importación local R6 preservada. |
| `assets/scss/pages/_home-movimiento.scss` | Microinteracciones R6 iniciales preservadas. |
| `assets/scss/patterns/_navegacion-global.scss` | Zona comercial del drawer con tokens existentes y xl. |
| `includes/header.php` | Activadores por disponibilidad, sin nuevos modales. |
| `docs/HOME-MOTION-DESIGN.md` | Informe vigente y preservación del registro anterior. |

CSS/JS compilados son outputs ignorados y no se editan manualmente. No se modifican imágenes, vídeos originales, hosts Home, legacy, `.htaccess`, main ni documentos históricos ajenos. Los tres informes locales iniciales conservan sus SHA256 originales, comprobados de nuevo; `informes-previos.json` conserva el inventario. `.home-public-enabled` sigue ausente.

## Revisión y límites pendientes

Abrir [Home Preview](http://localhost:3000/home-preview.php) en pestaña nueva, sin hash y con preferencia de movimiento normal. Desplazarse a velocidad habitual hasta Discovery, Club, Gifting y Visit. Las entradas se reproducen una vez; para repetir, usar una navegación nueva desde arriba. Hashes, restauración, foco, reduced motion y fallos deliberados pueden mostrar el contenido directamente terminado: es el fallback previsto.

El servidor final y watcher permanecen activos en 3000 → 8018, desde este checkout, con ghost mode local desactivado. El launcher ignorado existente de `node_modules/.cache/clandestino-local-r6/gulpfile.mjs` conserva esta configuración. La raíz pública no se activa.

Pendientes: aprobación creativa humana, Safari/iOS y dispositivos físicos, métricas de campo e integración de servicios comerciales reales. No se declara certificación global ni aprobación de conversión/producción. No se generan título ni descripción de PR.

---

## Registro histórico íntegro anterior — sustituido por el estado vigente superior



# Home R6 — movimiento y microinteracciones

## Estado vigente — Motion V3, pendiente de aprobación visual

**Las dos versiones anteriores fueron rechazadas visualmente por el responsable.** R6 inicial solo suavizaba controles; R6 correctiva/V2 añadió revelados, pero sus 600 ms, 14 px y activación al primer contacto con el viewport resultaron demasiado discretos durante la navegación real. V3 revisa presencia, activación y coordinación local. No se declara aprobada ni cerrada R6. Sin commit, push, PR, merge, deploy o activación pública.

Los registros V2 e inicial se conservan íntegros más abajo. Copia del informe previo y baseline V2 independiente en la evidencia **EV3**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/v3/`.

### Diagnóstico y prueba creativa previa

`diagnostico-previo.json` confirma el checkout servido por 3000 → PHP 8018, assets idénticos a disco y a 8017, Hero de 720 ms preservado y reduced motion desactivado en la sesión de prueba. No era una variante antigua de CSS/JS. Se leyeron AGENTS, Core, normas SCSS/JS, UX/UI, Visual Direction y los componentes afectados; se aplica de nuevo `qa-visual`.

Se implementaron primero **solo Discovery e introducción/Diamond/Gold de Wine Club**. La comparación con V2 se grabó a velocidad normal. La primera curva V3 todavía resolvía demasiado pronto el recorrido; se ajustó a `cubic-bezier(0.25, 0.4, 0.45, 1)`. También se corrigió la coordinación de la fila Discovery: el desplazamiento editorial preexistente de Tapas no debe dejarla fuera del stagger de sus compañeras.

Los vídeos piloto válidos son `pilot-final-discovery-1440.webm` y `pilot-final-club-1440.webm`, con sus JSON. Discovery registra 1.150 ms, 48 px y 0/170/340 ms; Wine Club registra introducción 1.100/40, Diamond 1.200/50 y Gold 1.050/38, disparados cuando llega cada bloque. Solo después de esta comprobación se extendieron los perfiles al resto. Es revisión creativa interna de una propuesta, **no aprobación humana**.

Se detectó que el ghost mode predeterminado de BrowserSync replicaba scroll entre clientes automatizados. Se desactivó exclusivamente en el lanzador local ignorado de `node_modules/.cache/clandestino-local-r6/`; `gulpfile.mjs` del proyecto sigue intacto. `ghost-check.json` verifica dos clientes con posiciones independientes. Las grabaciones afectadas se preservan bajo `superseded-ghost-mode/` y se excluyen de la evidencia final. El watcher y la recarga automática continúan activos.

### Activación en zona de lectura

- Una configuración central en `movimiento-home.js` contiene perfiles, anclas, duración, distancia, opacidad, easing, stagger y posición de disparo. Se retiran los tres tokens CSS anteriores para evitar dos fuentes de ajuste. Se conservan las microinteracciones cromáticas de 180 ms.
- Un único IntersectionObserver observa **anclas reales del contenido**, no necesariamente el borde del contenedor. Private Experiences observa su header textual después del espacio fotográfico; Reservation/Visit observan el eyebrow; Discovery observa el comienzo de la imagen. Esto evita consumir el efecto en un padding todavía alejado del relato.
- La zona comienza bajo la altura real del Header más 16 px; su borde inferior está al **52% del espacio de viewport restante**. Se calcula rootMargin en píxeles desde esas medidas, sin breakpoint rígido ni porcentaje mínimo de altura del elemento. `threshold: 0` se refiere al contacto con esa zona interna, no al borde inferior de pantalla. Funciona con bloques mayores que el viewport.
- Resize de ventana y ResizeObserver del Header actualizan la zona cuando cambia su geometría. No hay listener permanente de scroll. Si apenas queda espacio útil bajo Header, se omite el movimiento y el contenido permanece estático.
- Los elementos que entran juntos forman una cohorte local. Solo se añaden compañeros visibles a un máximo de `min(64px, 8% del espacio libre)` del borde de lectura. Así se coordinan las tres tarjetas Discovery de escritorio sin activar otras filas a varias pantallas de distancia. En móvil, cada bloque lejano espera a su propia entrada y empieza sin una demora heredada de su índice.
- Si un salto rápido deja el ancla por encima del área de lectura, se finaliza sin reproducir una entrada tardía. Primera carga, hash, restauración y cambios de tamaño protegen lo ya visible. Cada grupo se reproduce una sola vez por visita.

### Secuencias y parámetros V3

| Sección / grupo | Ancla | Duración | Traslado | Opacidad inicial |
|---|---|---:|---:|---:|
| Discovery, tres piezas | Imagen de cada pieza | 1.150 ms | 48 px | 0,24 |
| Pure Soul, cabecera / relato | Eyebrow / declaración editorial | 1.100 / 1.150 ms | 40 / 44 px | 0,30 / 0,28 |
| Private Experiences, invitación | Header textual | 1.100 ms | 38 px | 0,40 |
| Guest Stories, editorial / colección | Eyebrow / pista audiovisual | 1.100 / 1.050 ms | 42 / 36 px | 0,30 / 0,50 |
| Reservation Invitation | Eyebrow del contenido | 1.100 ms | 40 px | **1** |
| Wine Club, introducción | Eyebrow editorial | 1.100 ms | 40 px | 0,30 |
| Wine Club, Diamond | Eyebrow de la tarjeta | 1.200 ms | 50 px | 0,22 |
| Wine Club, Gold | H3 | 1.050 ms | 38 px | 0,35 |
| Gifting, foto / hampers / Gift Card | Imagen / eyebrow / arte | 1.150 / 1.150 / 1.100 ms | 44 / 44 / 38 px | 0,28 / 0,30 / 0,40 |
| Visit, imagen / información | Imagen / eyebrow | 1.100 / 1.050 ms | 42 / 36 px | 0,28 / **1** |

Diecisiete targets en ocho secciones; stagger **170 ms** solo dentro de la cohorte visible. `translate` independiente preserva el transform editorial existente de Tapas. Sin escala, rotación, parallax o cambios de layout. Póster/marco Pure Soul, fotografía/timeline Private Experiences, Header, Hero y Footer quedan fuera de los nuevos efectos.

### Accesibilidad y funcionamiento

El estado CSS subyacente es visible. No se añaden estados pending ocultos, inert, tabindex o roles. WAAPI tiene `fill: backwards` durante la breve demora de la cohorte y no forwards; al acabar se recuperan los estilos aprobados incluso sin callback JS. Nunca se usa opacidad cero. Reserva y datos Visit conservan opacidad completa también durante su entrada.

Reduced motion desactiva la mejora; cambiar a reduce cancela observaciones y efectos. Hash/posición restaurada muestran el destino directamente. El foco de teclado finaliza el grupo. Una pulsación de ratón/tacto pausa temporalmente el movimiento del control para conservar su hit target hasta completar el click; pointerup/cancel lo reanuda. Blur finaliza efectos activos y pérdida de visibilidad finaliza todo. Vídeos ya en reproducción omiten el revelado de su contenedor. No se anima cada vídeo ni se altera el carrusel.

Sin JS, sin APIs necesarias o ante un fallo, sigue el contenido nativo. Permanece documentada la limitación **previa** del Header cuando se elimina completamente IO; no se atribuye a V3 ni se declara funcionamiento global de ese sistema en un navegador sin IO.

### Evidencia final, QA y rendimiento


Vídeos finales originales, **sin aceleración, cortes ni cambio de timestamps**:

- `v3-full-390.webm`: recorrido móvil completo, 17/17 revelados iniciados y finalizados.
- `v3-full-1440.webm`: recorrido desktop completo, 17/17 revelados iniciados y finalizados.
- `v3-discovery-1440.webm` y `v3-club-1440.webm`: detalles; se continúa el scroll hasta mostrar el bloque final completo.

Se usa rueda nativa a pasos pequeños y pausas de observación; no se pausa, termina o acelera WAAPI en los vídeos. Se esperan fuentes y decodificación de imágenes para revisar motion; esa preparación de laboratorio **no** se aplica a Lighthouse. Los JSON homónimos registran elemento, entrada física al viewport, activación, ancla, duración nominal, demora local, distancia y callback de finalización con estado final. En el piloto final se observaron aproximadamente 1.170/1.337/1.520 ms desde creación hasta fin en la cohorte Discovery de 1.150 ms + 0/170/340 ms; esa diferencia incluye cuantización de frames y entrega del evento.

`motion-manifest.json` reúne los 41 registros de los cuatro vídeos finales con entrada, disparo, duración observada descontando demora, distancia, stagger y estado final. Los 41 terminan con opacidad 1 y translate none; no se trata el evento cancel emitido por la limpieza posterior como fallo de una animación ya finalizada.

`final-{discovery,club}-{390,820,1440}-{before,start,half,end}-exact.png` proporciona **24 fotogramas** adicionales. Antes del disparo el elemento está visible y pendiente; inicio y 50% se inspeccionan fijando únicamente la timeline nativa del elemento principal en una sesión **separada de la grabación**. Los vídeos nunca se congelan para obtener esos fotogramas. `final-frames-exact.json` guarda los tiempos exactos; `frames-v3.png` reúne los ocho de escritorio. Las capturas aproximadas de los primeros ensayos no sustituyen esta evidencia exacta.

| QA focalizado V3 | Resultado |
|---|---|
| 320/390/768/820/1024/1280/1440 | PASS: entrada retrasada hasta lectura, sin overflow; siete comparaciones de geometría final con V2 idénticas |
| Primera carga / scroll lento, rápido y vuelta | PASS; vídeos naturales y prueba rápida; una entrada por target, contenido inicial visible |
| Restauración y hashes | PASS: refresh intermedio y 24 aperturas directas de ocho secciones en 390/820/1440 |
| Teclado / reduced motion | PASS: foco de teclado cancela la entrada; modo reducido inicial y cambio dinámico muestran el estado final |
| Ratón/tacto y CTA | PASS de puntero virtual en 390/820/1440: el target se mantiene estable durante una pulsación de 250 ms y el click nativo alcanza el destino interceptado por QA |
| Sin JS / errores de mejora | PASS de lectura: cinco anchos con JS deshabilitado; IO ausente/fallido, animate ausente/fallido y script retrasado. La prueba de retraso espera DOM parseado, no un timeout fijo de aparición |
| Orientación / altura corta | PASS en 844×390 y 1024×425 y al rotar sus dimensiones; sin estados invisibles o overflow |
| Header / Hero / Guest Stories | PASS en 390/820/1440: skip, menú y retorno, Home/End, inert, carrusel y reproducción/pausa nativa |
| Chrome / Firefox | PASS de efecto nativo en Chrome 156 y Firefox 151; siete anchos de QA Chrome, tres tamaños de smoke Firefox |
| Axe / contraste final | Cero infracciones automáticas en 390/768/1280; quedan revisiones manuales previas de fotografía/captions. Colores y tipografía finales intactos; no es certificación WCAG integral |
| Comandos | PASS lint, build, 65 PHP, cuatro suites Node, PHP fechas, HTML pública/preview y `git diff --check` |

Datos/logs: `qa.json`, `interaccion.json`, `compatibilidad.json`, `controles.json`, `ghost-check.json`, `php-lint.json`, `html-routes.json`, `lint-final.log`, `build.log`, `probar-*.log`, `php-fechas.log`. No se añaden herramientas de QA al producto.

Tamaños de producción: CSS Home **97.978→97.861 B** (−117 B; gzip −36 B); main **38.139→40.998 B** (+2.859 B; gzip +823 B). Los tres chunks siguen en 8.015 B con los mismos hashes. Sin dependencias ni recursos nuevos. `bundles.json` contiene los hashes completos y `build-final/` conserva el build minificado. El watcher usa después outputs de desarrollo, por lo que no se comparan sus pesos con los minificados.

La medición final alterna V2/V3 tres veces por tamaño: 18 navegaciones, Chrome 156/Lighthouse 13.4.1, 390×844 DPR3 y 820×1180 DPR2 mobile, 1440×1000 DPR1 desktop; simulación RTT150 ms, 1.638,4 Kbps y CPU×4, también desktop. Ambas variantes públicas reales se sirven por PHP loopback; sin reduced motion, ocultación de LCP, bloqueo de terceros, watcher, grabación u otro QA automatizado concurrente. No reproduce GoDaddy, TLS/HTTP2/CDN ni métricas de campo.

Medianas de tres pasadas; resultados completos sin redondear en `performance-summary.json`.

| Ancho | Variante | LCP ms | CLS | TBT ms | Hilo principal ms | Peticiones |
|---|---|---:|---:|---:|---:|---:|
| 390 | V2 | 6088 | 0.000000 | 515 | 2155 | 19 |
| 390 | V3 | 6019 | 0.000000 | 301 | 1731 | 19 |
| 820 | V2 | 7368 | 0.000000 | 448 | 2769 | 26 |
| 820 | V3 | 7297 | 0.000000 | 523 | 2568 | 26 |
| 1440 | V2 | 6407 | 0.000255 | 374 | 2203 | 25 |
| 1440 | V3 | 6470 | 0.000255 | 401 | 2213 | 25 |

| Ancho | Variante | Rango LCP ms | Rango TBT ms |
|---|---|---|---|
| 390 | V2 | 6015–6106 | 328–521 |
| 390 | V3 | 5941–6020 | 294–331 |
| 820 | V2 | 7298–7486 | 362–641 |
| 820 | V3 | 7297–7369 | 354–1278 |
| 1440 | V2 | 6403–6486 | 348–436 |
| 1440 | V3 | 6467–6475 | 360–479 |



Las medianas LCP cambian −69/−71/+62 ms en móvil/tablet/desktop; las medianas CLS permanecen 0/0/0,000255. Se conserva la única pasada tablet V3 de CLS 0,000210, patrón ya observado en R4/V2. Las solicitudes continúan en 19/26/25. No se cambia descubrimiento/prioridad/formato de la imagen LCP ni se le añade una animación nueva.

TBT mediano cambia 515→301 / 448→523 / 374→401 ms. No se presenta V3 como mejora de rendimiento: la mediana tablet sube 75 ms y desktop 27 ms. La pasada tablet V3 de **1.278 ms** se mantiene en los resultados; en los otros dos pares tablet V3 registra 523 frente a 641 y 354 frente a 448 ms. No se demuestra un deterioro grave sostenido en las tres pasadas, pero se comunica la dispersión y se conserva el trabajo principal/rangos para revisión. Los objetivos de campo y LCP ≤2,5 s siguen sin quedar acreditados por este laboratorio local.

Scroll medido por separado, con recursos ya decodificados y sin otros grabadores: 300 intervalos por variante/ancho. P95 V2→V3: **17,5→17,0 / 17,0→16,9 / 17,2→17,0 ms** en 390/820/1440. V3 registra cero intervalos >50 ms en los tres recorridos. Es una muestra local a 60 Hz, no una garantía universal ni INP. `scroll.json` conserva muestras y long tasks; no se ocultan los cuatro intervalos lentos del arranque de la primera pasada V2 móvil.

La geometría final exacta, ausencia de listeners de scroll y el recorrido natural a 1× respaldan la propuesta técnica. La aprobación de presencia, ritmo y carácter premium sigue siendo del responsable. No se usan puntuaciones Lighthouse ni automatización para dar por aprobada la dirección creativa.

### Reproducción y límites

Abrir `http://localhost:3000/home-preview.php`, volver arriba y recargar sin fragmento. Desplazarse a velocidad normal y detenerse brevemente ante cada bloque. El contenido ya visible al cargar se conserva estático; al regresar hacia arriba no se repiten entradas. Un hash o refresh intermedio presenta inmediatamente el destino. Con reduced motion, la ausencia de movimiento decorativo es el comportamiento esperado.

Watcher restaurado en 3000 → PHP 8018, sin espejo de scroll. `servidor-final.json` vuelve a comprobar 3000 y 8017: CSS/JS servidos iguales a disco, **17 activaciones nativas en cada URL**, sin nuevas activaciones al regresar hacia arriba, y Discover operable por teclado. La evidencia creativa usa desarrollo; `build-final/` preserva los archivos minificados usados en las mediciones.

Archivos modificados por V3: `assets/js/modules/patterns/movimiento-home.js`, `assets/scss/pages/_home-movimiento.scss` y este informe. Se conservan las integraciones R6 previas en `assets/js/main.js` y `assets/scss/home.scss`. El cambio local de ghost mode solo está en el lanzador ignorado, no en `gulpfile.mjs` del proyecto.

Cierre de integridad: rama `feature/home-motion-design`, HEAD `d6f9e46`, índice vacío, `.home-public-enabled` ausente y los tres informes locales históricos idénticos por SHA256 (`integridad-final.json`). Sin diferencias nuevas en includes, imágenes originales/derivados, Hero, Header, carrusel, dependencias, hosting o páginas legacy. `git diff --check` y formato de los nuevos archivos pasan. No se publica ni se da por aprobada R6.

La percepción cinematográfica y el ritmo definitivo requieren revisión del responsable. No se infiere mejora de conversiones de una animación más visible. Continúan los límites previos de accesibilidad audiovisual, Safari/dispositivos físicos y validación de hosting; no se abre otra auditoría general.

---

## Registro histórico — R6 correctiva / V2, rechazada visualmente

**R6 inicial no fue aprobada creativamente.** Solo añadió transiciones cromáticas de 180 ms. La corrección incorpora los revelados al entrar en viewport solicitados por el responsable, conservando la composición final. Pendiente de revisión visual humana, sin commit/push/PR/merge/deploy ni activación pública. Rama `feature/home-motion-design`, HEAD `d6f9e46`.

La sección **Registro histórico — R6 inicial**, más abajo, describe exclusivamente la primera implementación. Sus afirmaciones de cero JS y ausencia deliberada de revelados no describen esta corrección. Se conserva además una copia completa previa en la evidencia externa `refined/R6-inicial-informe.md`.

### Diagnóstico de localhost:3000

Antes de editar se comprobaron tres URLs: `http://localhost:3000/home-preview.php`, el upstream directo `http://127.0.0.1:8018/home-preview.php` y la candidata pública local `http://127.0.0.1:8017/`.

- BrowserSync 3000 hacía proxy a PHP 8018, iniciado desde `C:/Users/Mike/Documents/Development/clandestinoUSA-baseline`. Su launcher temporal se encuentra bajo `node_modules/.cache/clandestino-local-r6/`, sin cambios en `gulpfile.mjs`. Se cambió el puerto únicamente en esa copia porque 8000 estaba ocupado.
- Las tres URLs entregaban exactamente el CSS/JS local del build **de desarrollo**, no el minificado usado en las mediciones iniciales: CSS 120.821 B, SHA256 `4adc405bbe5f609c…`; main 69.747 B, SHA256 `cba3c26b9ba81a79…`. Las respuestas HTTP se compararon byte a byte con disco.
- Los anfitriones versionan sus assets mediante el hash de contenido. Las respuestas examinadas fueron 200; la inspección no encontró una variante antigua servida desde caché. `home-preview.php` mantiene no-store/noindex; BrowserSync añade únicamente su cliente de desarrollo.
- Los estilos calculados mostraban el Hero original de 720 ms y las nuevas transiciones de color de 180 ms. Discovery no tenía animaciones activas ni código de revelado. La falta de movimiento durante el recorrido correspondía a la implementación insuficiente, no a una discrepancia demostrada entre servidores.

Datos completos y cabeceras: `refined/diagnostico-previo.json`. Preview incluye cuenta/carrito de demostración; la candidata pública no. No se equiparan esas diferencias de anfitrión con diferencias de motion.

### Revelados incorporados por sección

| Bloque | R6 correctiva | Elementos conservados |
|---|---|---|
| Discovery | Tres piezas; entrada independiente al alcanzar el viewport y stagger 0/80/160 ms cuando entran juntas | Composición editorial, fotografías y desplazamiento estático de la pieza Tapas |
| Pure Soul | Cabecera y relato editorial, desfase de 80 ms | Póster, marco y proporciones completamente fuera de los targets |
| Private Experiences | Entrada de la invitación textual | Timeline fotográfica `view()`, escala y overlays originales |
| Guest Stories | Entrada conjunta de su composición | Pista, snap, flechas, vídeos, exclusión y controles nativos |
| Reservation Invitation | Entrada del contenido | Foto, nota y destino real del CTA; el foco cancela inmediatamente el movimiento |
| Spanish Wine Club | Diamond y Gold coordinados, Gold 80 ms después cuando coincide su entrada | Protagonismo de Diamond definido por el diseño, no por escalado |
| Gifting | Selección, relato Hampers y Gift Card, desfases 0/80/160 ms | Imágenes sin zoom, deformación ni cambio de encuadre |
| Visit | Imagen y contenido, 80 ms de desfase | Dirección, horario y teléfono con opacidad 1 incluso durante el revelado del contenido |
| Hero, Header y Footer | Sin revelados añadidos | Animaciones, comportamiento y semántica anteriores |

Son **15 targets en ocho secciones**. Duración 600 ms, traslado vertical relativo 14 px, easing `cubic-bezier(0.22, 0.61, 0.36, 1)`. Opacidad 0,4→1 durante la entrada, salvo contenido Visit, que se mantiene en 1. No existe un estado inicial con opacidad cero.

### Arquitectura y fallbacks

- Módulo ES nativo `movimiento-home.js`, incluido estáticamente en el bundle existente y ejecutado solo en el anfitrión Home. Una instancia compartida de IntersectionObserver observa los targets todavía no recorridos y deja de observar cada uno al entrar. Sin listeners de scroll, timers de revelado, librerías o peticiones nuevas.
- Se evaluó `animation-timeline: view()`: la fotografía de Private Experiences ya lo usa y se conserva. Para los nuevos relatos se elige IO + Web Animations por su control explícito de una sola entrada, foco, hashes, restauración y cancelación, con comportamiento consistente en los navegadores modernos que soportan las APIs requeridas. No se añade una segunda estrategia que repita los efectos al invertir el scroll.
- El CSS subyacente **siempre es visible**. La animación se crea al entrar; no hay clase CSS que mantenga texto oculto esperando IO. Incluso durante el breve stagger el fotograma inicial es parcialmente visible. Se usa `fill: backwards`, sin forwards: al acabar la timeline nativa se recupera el estilo aprobado, incluso si no llegara a ejecutarse el callback de limpieza.
- Se anima `translate` independiente de `transform`. QA detectó la traslación editorial de Tapas en tablet/escritorio; sustituir `transform` habría producido un salto al terminar. La implementación final conserva ese estilo y añade únicamente 14 px relativos. Se comprueba soporte de `translate` antes de habilitar la mejora.
- Primera carga omite los targets ya visibles o recorridos. Hash y pageshow finalizan los targets del destino y los que ya están visibles. El foco en cualquier enlace/CTA cancela inmediatamente la animación de su contenedor. No se mueve el foco ni se cambia tabindex, inert, roles o ARIA.
- Reduced motion inicial, ausencia de IO o Web Animations y falta de soporte de translate dejan todo estático. Al cambiar a reduce se cancelan animaciones y observaciones. Al volver a no-preference no se repite un contenido ya presentado.
- Excepciones al construir IO o al animar destruyen la mejora y recuperan el estado subyacente. Al ocultar el documento se finaliza el trabajo pendiente; no quedan efectos suspendidos al volver. No se depende de cargar una imagen para habilitar la lectura.

### Evidencia temporal y verificación

Evidencia correctiva **EC**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/refined/`.

`qa.cjs` comprueba la activación nativa por IO antes de capturar Discovery, Pure Soul, Wine Club y Gifting en 390/820/1440. Los nombres son `{discovery,pure-soul,wine-club,gifting}-{ancho}-{initial,middle,final}.png`. Para capturar exactamente inicio y mitad se pausa **la animación nativa que acaba de activar IO** y se fija su currentTime en 0/300 ms, respetando el delay. Después se reanuda y se comprueba su finalización/retirada. No se recrea el efecto con estilos de laboratorio.

`motion-live.webm` registra adicionalmente el recorrido **sin pausar ni modificar timelines**. `live.json` muestrea los estados calculados en cada frame, y `qa.json` registra activación, keyframes, tiempos, opacidad y estado final. La grabación distingue el efecto ejecutándose de una comparación de capturas estáticas.

### QA correctivo

| Prueba | Resultado |
|---|---|
| Responsive y geometría final | PASS en 320/390/768/820/1024/1280/1440, sin overflow. Geometría completa de Header, main, Footer, secciones, texto, controles y medios idéntica a R6 inicial en estado final/reducido |
| Entrada real y recorrido | Activación por IO verificada; recorrido rápido abajo/arriba, primera carga y refresh intermedio sin contenido atrapado en un estado invisible. No se repite el efecto al volver a una pieza ya presentada |
| Evidencia temporal | 36 fotogramas nativos: cuatro secciones × tres anchos × tres momentos. `motion-frames.png` reúne los doce de escritorio; `motion-live.webm` añade movimiento continuo |
| Hash | PASS: ocho secciones × 390/820/1440 = 24 aperturas; destino visible y sin revelado pendiente sobre él |
| Foco y preferencia dinámica | PASS en 390/820/1440: enfocar el CTA durante el efecto lo cancela; Tab/Shift+Tab conserva anillo visible; cambiar a reduce cancela todos los targets |
| Sin JavaScript | PASS con scripts deshabilitados realmente en 320/390/820/1024/1440; estado subyacente visible |
| Fallos de mejora | PASS de lectura con IO ausente, constructor IO fallido, Web Animations ausente, animate fallido y JS retrasado. Los fallos inyectados se separan de los errores del recorrido normal |
| Header, Hero, Guest Stories | PASS de controles en 390/820/1440: skip, menú Enter/Escape/trap/retorno, Hero Home/End/inert, carrusel Home/End y pausa de vídeo al navegar. No se modifica su código |
| Navegadores | Chrome 156 y Firefox 151: revelado nativo, keyframes, finalización y overflow comprobados en móvil/tablet/escritorio. Safari y dispositivos físicos pendientes |
| Axe y contraste final | Cero infracciones automáticas en 390/768/1280. Persisten revisiones manuales sobre fotografía y captions. Colores/overlays/fuentes finales no cambian; no se presenta como certificación WCAG global |
| Lint / build / suites | PASS ESLint, Stylelint, Gulp/Sass/esbuild y las cuatro suites Node. HTML pública/preview sin errores de parseo, IDs/ARIA/alt correctos. Sin PHP modificado |

Logs/datos: `qa.json`, `controles.json`, `compatibilidad.json`, `html-routes.json`, `lint-final.log` y `probar-*.log` en EC. Las capturas inicial/intermedia son evidencia del efecto temporal autorizado, no del contraste final ni de una nueva geometría estática.

### Rendimiento correctivo y protección de la ruta crítica

La primera serie de medición detectó un coste evitable de layout: se leían posiciones mientras se escribían estados, y los tokens se consultaban antes de inicializar la navegación. En una pasada de 820 px, la traza atribuía 68 ms a la consulta de estilos y 176 ms a las posiciones del nuevo módulo. Se corrigió agrupando primero todas las lecturas y después las escrituras; los tokens se leen en el frame de preparación y el módulo se inicializa **después** del Header y de solicitar los módulos del Hero/carrusel. Sin listeners de scroll, cambios de recurso LCP ni preload decorativo. La serie exploratoria se conserva en `before-layout-fix/`, separada de las mediciones finales.

| Recurso minificado | R5 | R6 inicial | R6 correctiva |
|---|---:|---:|---:|
| CSS Home | 97.397 B | 97.861 B | 97.978 B |
| CSS Home gzip local nivel 9 | 16.519 B | 16.615 B | 16.651 B |
| Main JS | 35.223 B | 35.223 B | 38.139 B |
| Main JS gzip local nivel 9 | 11.081 B | 11.081 B | 12.080 B |
| Tres chunks existentes | 8.015 B | 8.015 B | 8.015 B; hashes intactos |

Frente a R6 inicial: **+117 B CSS (+36 B gzip)** y **+2.916 B JS (+999 B gzip)**. Frente a R5: +581 B CSS (+132 B gzip), mismo delta JS. Se conserva un solo main y los tres chunks anteriores: cero solicitudes nuevas. `bundles.json` registra hashes y tamaños; `build-final/` preserva los archivos minificados medidos antes de volver al watcher de desarrollo. Gzip es referencia local, no una afirmación sobre compresión efectiva de GoDaddy.

La serie final repite el protocolo R4 en **27 navegaciones**, alternando R5 → R6 inicial → R6 correctiva, tres veces por tamaño: 390×844 DPR 3, 820×1180 DPR 2 y 1440×1000 DPR 1. Lighthouse 13.4.1/Chrome 156, simulación RTT 150 ms, 1.638,4 Kbps, CPU ×4 en los tres formatos; mobile en los dos primeros. Builds minificados, Google Fonts real, sin bloqueo de terceros/reduced motion, sin QA, watcher o builds concurrentes. Los archivos `r5-*`, `initial-*`, `refined-*` y `performance.json` de EC son la serie final; `before-layout-fix/` conserva las 27 navegaciones exploratorias anteriores. No se mezclan sus medianas ni se eligen las mejores pasadas.

Medianas de tres pasadas por variante/ancho; no son datos de campo.

| Ancho | Variante | LCP ms | CLS | TBT ms | Hilo principal ms | Peticiones |
|---|---|---:|---:|---:|---:|---:|
| 390 | R5 | 6030 | 0.000000 | 418 | 1821 | 19 |
| 390 | R6 inicial | 5946 | 0.000000 | 336 | 1842 | 19 |
| 390 | R6 correctiva | 6015 | 0.000000 | 305 | 1760 | 19 |
| 820 | R5 | 7305 | 0.000000 | 426 | 2249 | 26 |
| 820 | R6 inicial | 7312 | 0.000000 | 449 | 2371 | 26 |
| 820 | R6 correctiva | 7296 | 0.000210 | 386 | 2393 | 26 |
| 1440 | R5 | 6326 | 0.000255 | 396 | 2346 | 25 |
| 1440 | R6 inicial | 6246 | 0.000255 | 401 | 2133 | 25 |
| 1440 | R6 correctiva | 6394 | 0.000255 | 362 | 2463 | 25 |

| Ancho | Variante | Rango LCP ms | Rango TBT ms |
|---|---|---|---|
| 390 | r5 | 5952–6048 | 341–446 |
| 390 | initial | 5874–5949 | 336–342 |
| 390 | refined | 5942–6017 | 300–321 |
| 820 | r5 | 7304–7306 | 387–537 |
| 820 | initial | 7297–7331 | 395–511 |
| 820 | refined | 7288–7308 | 359–392 |
| 1440 | r5 | 6260–6335 | 386–417 |
| 1440 | initial | 6097–6333 | 0–419 |
| 1440 | refined | 6390–8391 | 0–389 |



Fluidez, 300 intervalos de frame por variante/ancho, durante scroll abajo/arriba con imágenes previamente decodificadas y revelados en ejecución: p95 R5/inicial/correctiva **17,8/17,8/17,6 ms** en 390; **17,7/17,7/17,5 ms** en 820; **17,6/17,6/17,7 ms** en 1440. La candidata registra cero intervalos >50 ms en los tres recorridos. Es un laboratorio local a 60 Hz, sin throttling durante el scroll, no INP ni rendimiento de un móvil físico. `scroll.json` conserva todos los intervalos lentos/long tasks y cuántos frames coincidieron con revelados activos; no se presenta como garantía universal de 60 fps.

**Lectura de las mediciones finales:** frente a R5, LCP mediano cambia −15/−8/+68 ms en 390/820/1440; frente a R6 inicial cambia +69/−15/+148 ms. Se registra ese coste en escritorio, sin atribuir cada diferencia a la animación ni afirmar impacto cero. TBT mediano correctivo es 305/386/362 ms. Las peticiones siguen en 19/26/25 y no se altera la prioridad, descubrimiento ni carga eager del Hero LCP. No se aplica al LCP ninguna animación nueva.

CLS permanece en cero en 390 y en 0,000255 en 1440. En 820, la mediana pasa de 0 a 0,000210; el mismo valor ya aparece en una pasada R5 y en la evidencia R4. El registro de layout shift señala `#welcome-titulo`, fuera de los quince targets animados. Se comunica esta variación en vez de afirmar igualdad exacta de medianas. La geometría estática final sí es idéntica en los siete anchos.

La última pasada correctiva de escritorio dio **8.391 ms de LCP**, frente a 6.390/6.394 en las otras dos; se conserva y forma parte del rango. También hay una pasada con TBT 0 tanto en la variante inicial como en la correctiva: no se excluyen selectivamente. Esto es evidencia de laboratorio con dispersión, no rendimiento de campo aprobado. Las cifras siguen por encima del objetivo LCP de 2,5 s de R4; INP y hosting no se certifican aquí. El problema comprobado de lecturas/escrituras intercaladas se corrigió; no se elimina contenido ni se altera la fotografía para mejorar la puntuación.

### Límites y archivos de la corrección

- La ausencia completa de IO sigue provocando el error preexistente del Header documentado en R6 inicial. El contenido de Home permanece visible y el módulo de revelados no añade un estado oculto. No se declara funcionamiento íntegro del sistema anterior en ese entorno.
- El `blocking="render"` de main se conserva según R4. La prueba de JS retrasado verifica lectura/estilos DOM sin un gate nuevo; no promete paint mientras el recurso bloqueante original esté pendiente.
- Los saltos de layout fotográficos y la accesibilidad audiovisual no se reauditan aquí. Continúan los límites previos de captions/alternativas, aprobación comercial, Safari, hardware real, lector de pantalla y hosting. La opacidad temporal de los fotogramas no es un cambio de color final ni una certificación de contraste durante cada milisegundo.
- Cambios de la entrega completa R6: `assets/scss/home.scss` (import inicial), `assets/scss/pages/_home-movimiento.scss` (microinteracciones y tres tokens), `assets/js/main.js` (import e inicialización tras Core), `assets/js/modules/patterns/movimiento-home.js` (revelados compartidos) y este informe. Sin PHP, contenido, imágenes, dependencias, SEO, Header, Hero o carrusel modificados.

### Cómo revisar el movimiento

Abrir **`http://localhost:3000/home-preview.php`** desde arriba, sin fragmento, y recargar para iniciar una visita nueva. Desplazarse hacia Discovery, Pure Soul, Private Experiences, Guest Stories, Reservation Invitation, Wine Club, Gifting y Visit. Los targets que ya estaban dentro del viewport al cargar se conservan estáticos; los siguientes se revelan al entrar. Una pieza ya presentada no se vuelve a animar al regresar hacia arriba. Para repetir el recorrido completo, volver arriba y recargar.

Con reduced motion activo debe verse la página estática: es el resultado accesible esperado. No se modifica la preferencia del sistema para forzar una demostración. Una apertura por hash o una recarga a mitad de página debe mostrar inmediatamente el destino restaurado. El Hero conserva sus propias escenas; los revelados correctivos se buscan después del Hero.

Las capturas y el vídeo sirven para revisar el efecto sin cambiar preferencias o posición de lectura. La grabación continua recorre las ocho secciones; los fotogramas permiten inspeccionar opacidad, desplazamiento y regreso al estado aprobado. La revisión técnica no sustituye la aprobación creativa del responsable.

**Cierre local verificado:** watcher restaurado en 3000, proxy PHP 8018; candidata pública de revisión conservada en 8017. `servidor-final.json` verifica ambas URLs contra los CSS/JS actuales de disco, registra **quince llamadas nativas de revelado en cada una**, y confirma que el recorrido de regreso no crea otras animaciones. Discover también abre/cierra por teclado. Esta comprobación usa el build de desarrollo actual; los tamaños y Lighthouse anteriores corresponden al build minificado preservado en EC.

Se conserva HEAD `d6f9e46`, índice vacío y marcador público ausente. `integridad-final.json` confirma los SHA256 originales de los tres informes locales anteriores. `git diff --check` pasa; originales, includes, dependencias, páginas legacy, configuración de hosting y documentos históricos externos a este informe permanecen intactos. Sin commit, push, PR, merge o deploy.

Los resultados históricos inferiores pertenecen únicamente a R6 inicial. El cierre de rendimiento y la verificación del servidor corresponden al bloque correctivo actual.

---

## Registro histórico — R6 inicial

Trabajo local del 2026-11-04, America/Bogota. Rama `feature/home-motion-design`. **Pendiente de revisión humana**. Sin commit, push, PR, integración de la feature, deploy ni activación pública.

## Diagnóstico y alcance

La Home ya tiene un vocabulario suficiente para sus escenas, navegación y colección audiovisual. No falta una animación de entrada en cada sección: fotografía, alternancia de superficies y composición editorial ya orientan la lectura. La oportunidad concreta es que los controles Core cambian de estado cromático de forma instantánea, aunque la navegación que los rodea sí tiene transiciones discretas.

Se suaviza exclusivamente esa respuesta de los controles del contenido de Home. Se conservan los estados visuales existentes y sus valores finales. No se añade un sistema de revelados, una dependencia de scroll, opacidad reducida de lectura ni una inicialización adicional.

### Base y protección

- `git fetch origin` confirmó R5, `496a1a1`, integrada mediante PR #31 en `origin/develop`, `d6f9e46`. `git merge-base --is-ancestor 496a1a1 origin/develop` terminó correctamente.
- Se actualizó `develop` con `git merge --ff-only origin/develop` y se creó exactamente `feature/home-motion-design` desde `d6f9e46`. Esa actualización fast-forward es la única integración solicitada; no se integra la feature.
- Se consultaron AGENTS, normas SCSS/JS/PHP, estándares, arquitectura, Design System, UX/UI, Visual Direction, R2, R4, R5, Header, Hero y todos los partials activos de Home. Se aplicó `.agents/skills/qa-visual/SKILL.md`.
- `production-baseline` no contiene los anfitriones ni partials de esta nueva Home. El contraste histórico confirma que se trabaja sobre una candidata adicional; no se modifica `index.html`, páginas legacy, `main` ni autoridades históricas.
- Los informes locales HOME-FINAL-AUDIT, HOME-TECHNICAL-AUDIT y HOME-VISUAL-ASSET-PLAN se preservan sin seguimiento, sin staging y byte a byte. No se usa stash, clean ni modificación de ignore.
- La candidata pública se sirve únicamente en loopback con el router de pruebas existente y `CL_HOME_PUBLIC_REVIEW=1`. No se crea `.home-public-enabled`. El servidor PHP de QA tiene `mail` deshabilitado.

## Inventario previo, en orden real

| Bloque | Movimiento existente | Decisión R6 |
|---|---|---|
| Header y menú | Offcanvas de 260 ms con `cubic-bezier(0.22, 0.61, 0.36, 1)`; iconos de apertura 180 ms; indicador Discover 180 ms; Collapse nativo Bootstrap | Conservar íntegramente, incluidos foco, Escape, retorno y menú responsive. Fuera del selector nuevo |
| Hero | Fundido de fotografía 720 ms `ease-out`; relato 520 ms con el easing del menú; desfases de 40/90/120 ms; escena saliente conserva su transición de visibility. Rotación de 6.500 ms con pausas y decode previo | No añadir, duplicar ni cambiar estas animaciones. Tampoco se modifica el botón del Hero |
| Discovery | Galería editorial estática; estados Core de sus tres CTA | Suavizar únicamente color/fondo/borde de los CTA. Sin escalado de fotos ni falsa superficie clicable |
| Pure Soul | Imagen y marco estáticos; CTA Core | Misma microinteracción del CTA; conservar íntegramente imagen, marco y relato |
| Private Experiences | Escala fotográfica existente `1.015 → 1`, asociada a `view()` durante `entry 0% → 100%`, solo con soporte y no-preference. Su duración nominal de 1 ms corresponde a una timeline de scroll | Preservar ese movimiento y sus fallbacks. Solo se suaviza la respuesta del CTA; no se anima el texto |
| Guest Stories | Scroll Snap nativo; desplazamiento `smooth` al navegar, `auto` con reduced motion o al enfocar tarjetas; pausa/exclusión de vídeo por el adaptador existente | Conservar pista, recorrido, duración nativa y lógica audiovisual. Añadir únicamente transición cromática a las flechas; el cambio a disabled sigue siendo inmediato |
| Reservation Invitation | Composición estática, CTA Core | Solo respuesta cromática del CTA; sin animación fotográfica ni entrada del texto |
| Spanish Wine Club | Diamond y Gold estáticos, acciones Core | Misma transición en ambos CTA; sin simular que toda la membresía es clicable |
| Gifting | Foto, Gift Card y artículos estáticos, acciones Core | Solo CTA. Sin inclinar, elevar o escalar el arte; sin cambios de oferta ni destino |
| Visit | Foto, dirección, horario, acciones y teléfono estáticos | Misma transición de CTA y enlace de teléfono. Datos inmediatamente legibles |
| Footer | Enlaces y estructura existentes | Conservar íntegramente; fuera del selector nuevo |

Los nombres de clases y el anfitrión público conservan el nombre histórico `cl-home-preview`; esta clase ya se usa en ambas variantes. No se crea un flag de producto ni una nueva variante visual.

## Mejora implementada

`pages/_home-movimiento.scss` se importa solo desde `home.scss`. El selector requiere el anfitrión Home, `main`, una sección existente (`cl-seccion` o `cl-banda-cta`) y un control real Core (`cl-boton`, `cl-boton-icono` o `cl-enlace`). No modifica Core global, Style Guide ni las demás páginas.

| Estado | Duración y easing | Motivo |
|---|---|---|
| Hover y salida de hover | 180 ms, `cubic-bezier(0.22, 0.61, 0.36, 1)` | Continuidad con el vocabulario del menú; respuesta corta y discreta |
| Propiedades | Exclusivamente `color`, `background-color`, `border-color` | Conservar geometría, targets, tipografía y layout. Sin `transition: all` |
| `:focus-visible` | 0 s; anillo Core de 2 px sin transición | Identificación inmediata al recorrer con Tab/Shift+Tab |
| `:active` | 0 s | Confirmación inmediata de pulsación |
| `:disabled` y `aria-disabled="true"` | 0 s | No prolongar visualmente un estado disponible |
| Reduced motion | No se aplica la regla R6 | Permanece el contrato reducido de Foundation y de los módulos actuales |

Las transiciones cromáticas producen repintado local del control durante la interacción; no se presentan como operaciones gratuitas de compositor. No se anima tamaño, posición, margen, padding, sombra ni otra propiedad de layout. No se añade `will-change`, temporizador, listener, observer, recurso ni petición.

### Elementos deliberadamente estáticos

Se conservan siempre visibles títulos, párrafos, CTA, fotografías y datos de visita. No hay fade-in al scroll, stagger de tarjetas, parallax, zoom de hover, desplazamiento de iconos, nuevos subrayados, seguimiento del puntero ni movimiento perpetuo. El ritmo editorial pertenece a la composición aprobada y a los movimientos ya existentes. La ausencia de animación adicional es una decisión de alcance y legibilidad.

## Accesibilidad y mejora progresiva

R6 consiste enteramente en CSS, bajo `prefers-reduced-motion: no-preference`. Funciona con JavaScript deshabilitado y no requiere IntersectionObserver, clases de inicialización, hidratación, carga de imagen ni eventos de scroll. No introduce `opacity`, `visibility`, `display`, `inert`, `tabindex`, roles o atributos ARIA. El CSS esencial y las imágenes conservan el mismo orden y prioridad de carga.

La preferencia reduce desactiva la regla nueva, incluso si cambia durante la sesión. Foundation conserva su reducción global y el Hero mantiene su estado `disabled-reduced-motion`; no se altera ese contrato previo. Las limitaciones preexistentes de accesibilidad audiovisual descritas en R2/R3 siguen vigentes: este trabajo no crea subtítulos ni certifica conformidad WCAG integral.

## Evidencia y reproducción

Evidencia externa **E**:

`C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a576-2a20-7210-bca0-5884301a5373/home-r6/`

La copia `E/baseline-site` procede de `git archive d6f9e46`, con los outputs reales del build previo añadidos después. No contiene los tres informes locales ni depende de archivos de la candidata modificada para servir CSS/JS. La base usa `http://127.0.0.1:8016/`; la candidata, `http://127.0.0.1:8017/`. Ambas sirven la variante pública real con noindex/no-store. El preview se comprueba adicionalmente mediante validación HTML.

Para abrir la candidata después de terminar esta sesión, comprobar primero que 8017 esté libre y ejecutar desde la raíz:

```powershell
$env:CL_HOME_PUBLIC_REVIEW = '1'
php -d disable_functions=mail -S 127.0.0.1:8017 -t . scripts/fixtures/home-public-router.php
```

Herramientas de laboratorio existentes en caché, sin instalación ni cambio de dependencias: Chrome 156, Playwright 1.62 alpha, Lighthouse 13.4.1, axe-core, sharp y html5lib. Los scripts externos contienen las rutas concretas; deben adaptarse al repetir en otro equipo. No son dependencias del producto ni se empaquetan para hosting.

### Resultado visual

- `baseline-{ancho}-full.png` y `final-{ancho}-full.png`, además de capturas de tres escenas y siete secciones, cubren 390, 768, 820, 1280 y 1440 px. `visual-comparison.png` pone Discovery antes/después en 390/820/1440; `hover-{390,820,1440}.png` documenta un estado interactivo.
- Los arrays `geometry` de `baseline-visual.json` y `final-visual.json` coinciden exactamente en los cinco anchos: cajas de Header, main, Footer, secciones, headings, párrafos, enlaces, botones, imágenes y vídeos; también fuente, color, fondo, `object-fit` y `object-position`. No se toma la URL de servidor distinta como una diferencia de diseño.
- Una segunda secuencia por sección en 390/820/1440 está en `stable-{baseline,final}-{ancho}-{id}.png`. `stable-visual.json` confirma las mismas fuentes de imagen seleccionadas y dimensiones naturales/renderizadas antes y después.
- La referencia para posición sticky y ausencia de solapamientos es `viewport-{baseline,final}-{390,820,1440}-{id}.png`: 48 capturas del viewport real, sin expansión para capturar un elemento alto. `viewport.json` confirma que el skip link queda fuera de pantalla sin foco. Algunas capturas de elemento alto anteriores muestran contenido fijo desplazado por la captura; no representan ese estado del viewport ni una regresión del producto.
- Las capturas no son idénticas píxel a píxel: existen diferencias de rasterizado de fotografías y controles nativos entre navegaciones. Se conservan los resultados sin atribuirlos a una mejora artística ni afirmar identidad binaria de screenshots. Las cajas y los recursos seleccionados sí coinciden; no se cambia el producto para forzar una igualdad de capturas.
- La inspección visual conserva composición, saltos editoriales, proporciones, fotografías y encuadres. La única diferencia intencional durante interacción es la interpolación cromática de 180 ms. La aprobación estética humana queda pendiente.

### QA técnico y accesible

| Comprobación | Resultado y alcance |
|---|---|
| `npm.cmd run lint` | PASS: ESLint y Stylelint |
| `npm.cmd run build` | PASS: Gulp, Sass/PostCSS, sprite y esbuild; sin dependencias nuevas |
| PHP lint | PASS: los 65 PHP rastreados, sin errores |
| Suites Node | PASS: `probar-carrito.mjs`, `probar-cierre-comercio.mjs`, `probar-formularios.mjs` y `probar-home-publica.mjs`; 126 casos de formularios y 72 contratos de Home pública |
| Fechas y sesión | PASS: 27 comprobaciones; también ejecución directa de `php scripts/probar-fechas-formularios.php` |
| HTML | PASS: html5lib sin errores de parseo en pública y preview, IDs únicos, un H1/main, referencias ARIA/for resueltas e imágenes con alt. Es validación estructural, no certificación Nu/W3C |
| Responsive normal | PASS: 320/360/390/425/768/820/1024/1280/1440/2560 × 1000 px, sin overflow horizontal, secciones visibles y fotografías cargadas |
| Altura corta y horizontal | PASS: 844×390, 1024×425 y 2560×1080; sin overflow, incluidos menú abierto/cerrado donde corresponde |
| Primera carga, scroll y refresh | PASS: recorrido instantáneo abajo/arriba, carga inicial y recarga después de llegar a Gifting; ninguna sección depende de una clase de entrada |
| Hash | PASS: ocho secciones × 390/820/1440 = 24 aperturas directas, tras cargar fuentes. Ningún heading/CTA se oculta esperando scroll |
| Teclado y foco | PASS en 390/820/1440: skip link, Tab/Shift+Tab, menú con Enter/Escape/trap/retorno, Hero Home/End e inert, carrusel Home/End y recorrido hasta Footer. Anillo Core de 2 px presente; foco instantáneo |
| Vídeo | PASS en 390/820/1440: reproducción nativa manual, avance del tiempo y pausa al navegar a otra tarjeta. Sin cambios de controles ni exclusión existentes |
| Hover/focus/active | PASS: 12 muestras entre Discovery, Pure Soul, flechas y teléfono, en 390/820/1440. Se observa un estado intermedio real, duración de 180 ms y dimensiones idénticas. Foco y pulsación pasan a 0 s |
| Reduced motion | PASS: capturas desde carga reducida y cambio dinámico de preferencia en 390/820/1440. Regla R6 ausente; transición residual global `0.01ms`; Hero `disabled-reduced-motion` |
| Sin JavaScript | PASS: motor de scripts deshabilitado mediante contexto de navegador en los diez anchos; menú expandido, cuatro vídeos nativos, secciones y CTA visibles |
| Fallo/retraso de recursos | PASS de lectura: scripts retrasados, scripts bloqueados, imagen Pure Soul fallida e IO ausente. No se añade ocultación al contenido. Ver límites de inicialización preexistentes debajo |
| Axe | Cero infracciones automáticas en 390/768/820/1280/1440. Persisten revisiones manuales `color-contrast` sobre fotografía y `video-caption`; no se silencian ni se presenta como conformidad integral |
| Contraste | Se conservan colores/estados Core, fondos y overlays. Axe no detecta nuevas infracciones evaluables. El muestreo fotográfico de R2/R4 conserva su valor histórico; no se declara otra auditoría completa de cada escena o fotograma |
| Consola / red | Cero errores o warnings en el recorrido normal observado; los fallos de recurso provocados deliberadamente se registran por separado |
| `git diff --check` | PASS; alcance limitado a los tres archivos de esta entrega |

La primera prueba de hash reutilizaba un documento después de una recarga con posición restaurada y devolvió una posición inconsistente. Se conservó `hash-debug.cjs`: aperturas independientes y cambios de hash pasan tanto en baseline como en candidata. La matriz final fuerza un documento nuevo mediante una query inerte de laboratorio por destino y espera fuentes; no se añade un manejador de hash al producto para corregir la instrumentación.

Resultados completos: `motion-qa.json`, `axe-scroll.json`, `html-routes.json`, `php-lint.json` y logs `probar-*.log`/`php-fechas.log`. Las herramientas y capturas están únicamente en E.

## Rendimiento

### Peso y peticiones

| Output real de build | Base | R6 | Delta |
|---|---:|---:|---:|
| `home.css` | 97.397 B | 97.861 B | **+464 B / +0,48%** |
| `home.css`, gzip nivel 9 local | 16.519 B | 16.615 B | **+96 B** |
| `main.js` | 35.223 B | 35.223 B | **0 B; mismo SHA256** |
| Tres chunks dinámicos | 8.015 B | 8.015 B | **0 B; mismos SHA256** |
| `style.new.css` | 116.196 B | 116.196 B | **0 B; mismo SHA256** |
| JS, imágenes, fuentes o dependencias añadidas | 0 | 0 | **0** |

Gzip es una medida de compresión local, no transferencia real del servidor PHP ni del hosting. No se añade ninguna petición. El incremento exacto del archivo CSS es 464 B; los bytes HTTP agregados también incluyen pequeñas variaciones de cabeceras/respuestas entre navegaciones.

### Protocolo comparable con R4

Se reutiliza `medir.mjs` del laboratorio R4, ajustando únicamente puertos, carpeta de salida y puerto remoto de Chrome. Tres navegaciones por tamaño y fase: **18 pasadas iniciales**, conservadas completas. Base actual R5 frente a R6, builds minificados, mismo Chrome 156 y Lighthouse 13.4.1, sin QA de navegador, builds ni codificación concurrentes durante estas mediciones. No se comparan directamente los tiempos absolutos antiguos de R4 con otra sesión de Windows como si las condiciones del equipo fueran idénticas.

- 390×844 DPR 3 y 820×1180 DPR 2 con `formFactor=mobile`; 1440×1000 DPR 1 con `formFactor=desktop`.
- `throttlingMethod=simulate`, RTT 150 ms, 1.638,4 Kbps y CPU ×4 en los tres tamaños, también escritorio. Perfiles DevTools: 562,5 ms / 1.474,56 Kbps descarga / 675 Kbps subida; no se confunden con el modelo simulado usado.
- Chrome limpio, limpieza de almacenamiento de Lighthouse, Google Fonts real, sin bloqueo de terceros, calentamiento deliberado, reduced motion ni manipulación del contenido LCP.
- PHP integrado por loopback, sin compresión HTTP estática ni representación de TLS/HTTP2/CDN/GoDaddy. El trabajo de hilo principal es observado por Lighthouse, sin multiplicarlo de nuevo por cuatro.

Medianas iniciales; tiempos en ms. No se seleccionan las mejores pasadas:

| Ancho | LCP base → R6 | CLS base → R6 | TBT base → R6 | Hilo principal base → R6 | Solicitudes base → R6 |
|---|---|---|---|---|---|
| 390 | 6.039 → 5.980 | 0 → 0 | 672 → 533 | 2.885 → 2.566 | 19 → 19 |
| 820 | 7.345 → 7.257 | 0 → 0 | 551 → 533 | 3.924 → 3.112 | 26 → 26 |
| 1440 | 6.475 → 6.361 | 0,000255 → 0,000255 | 569 → 484 | 3.152 → 4.027 | 25 → 25 |

| Ancho | Rango LCP base / R6 | Rango TBT base / R6 | Rango hilo principal base / R6 |
|---|---|---|---|
| 390 | 5.948–6.161 / 5.945–6.024 | 664–690 / 465–540 | 2.882–3.199 / 2.523–2.580 |
| 820 | 7.253–7.386 / 7.228–7.260 | 533–607 / 450–563 | 3.108–4.318 / 2.995–3.623 |
| 1440 | 6.428–6.560 / 5.025–7.014 | 547–1.243 / 469–504 | 2.967–4.172 / 2.430–4.968 |

Transferencia de navegación, medianas: 1.174.624→1.175.436 B en 390; 1.379.487→1.379.951 B en 820; 1.254.616→1.255.080 B en 1440. Performance: 57→60, 57→58 y 37→40. Estas fluctuaciones no se atribuyen a una mejora del CSS: no se ha optimizado la ruta crítica ni reducido JavaScript. LCP sigue por encima de 2,5 s en este laboratorio.

La subida inicial de la mediana de hilo principal en escritorio (+27,8%) motivó una comprobación adicional, alternando base y candidata bajo el mismo protocolo. Se conserva la serie inicial y se documenta la comprobación, sin reemplazarla por las mejores pasadas. Archivos: `desktop-check-{baseline,final}-{1,2,3}.lhr.json` y `desktop-check.json`.

| Comprobación alternada 1440 px, 3+3 navegaciones | Base | R6 |
|---|---:|---:|
| Mediana LCP | 6.433 ms | 6.358 ms |
| Mediana CLS | 0,000255 | 0,000255 |
| Mediana TBT | 728 ms | 599 ms |
| Mediana hilo principal | 3.683 ms | 3.016 ms |
| Rango hilo principal | 3.427–4.591 ms | 2.781–4.524 ms |

La subida de hilo principal no se reproduce como una regresión sostenida al alternar las variantes; tampoco se atribuye la bajada posterior a R6. Ambas series contienen dispersión de `Style & Layout` y `Other`. El CSS nuevo no anima geometría, el JS es idéntico y no hay tareas nuevas de scroll. Se conserva la microinteracción: no se demuestra un deterioro repetible de LCP/CLS/TBT o fluidez que justifique retirarla. Son **24 navegaciones Lighthouse en total**, con incertidumbre del equipo local y sin equivalencia con métricas de campo.

### Fluidez del scroll

Smoke de 240 frames de `requestAnimationFrame` por fase/tamaño, con recorrido abajo/arriba y fotografías ya decodificadas. P50 de 16,7 ms en todos los casos; p95 base→R6: **17,9→18,0 ms / 18,0→17,8 ms / 17,9→17,4 ms** en 390/820/1440. Cero intervalos de más de 50 ms y cero long tasks registradas durante esos recorridos.

Es una muestra local a aproximadamente 60 Hz, sin throttling. Coincidió con capturas de QA en otro proceso; se usa como smoke de continuidad y no como benchmark aislado de GPU, INP o dispositivo físico. No demuestra que todos los frames de todos los dispositivos cumplan ese tiempo.

Los JSON Lighthouse completos, primeras trazas/devtools por tamaño, resúmenes y rangos están en E. `performance-comparison.json` conserva los valores sin redondear; `comparison.json`/`comparar.cjs` registran pesos, hashes y comparación de geometría/capturas.

## Límites restantes

- Al eliminar IntersectionObserver del navegador, el módulo previo de navegación registra `ReferenceError: IntersectionObserver is not defined`. El contenido de las ocho secciones sigue visible. R6 no incorpora IO, no modifica ese módulo y no presenta ese escenario como inicialización completa de navegación/carruseles. La dependencia previa sigue pendiente de una intervención funcional específica si se exige soportar ese entorno.
- La comprobación independiente de `viewport.json` reproduce ese mismo error de IO tanto en baseline como en candidata; no se atribuye a R6. Los archivos JS conservan sus hashes.
- La comprobación de scripts retrasados verifica DOM, estilos calculados y cajas de contenido. Se conserva el `blocking="render"` existente de `main.js`, cuya retirada ya produjo un salto de Header documentado en R4. No se promete primer paint mientras un recurso bloqueante siga pendiente ni se atribuye a R6 un nuevo gate de inicialización.
- No se repite la auditoría general cerrada de R2/R4. Siguen pendientes sus límites de subtítulos/alternativa audiovisual, validación comercial, zoom nativo efectivo, lector de pantalla auditivo, Safari/Firefox en esta fase, dispositivos físicos y hosting Apache/GoDaddy.
- La interpolación de color es una microinteracción local; no se promete un incremento medido de conversiones. INP de campo, percentiles reales y comportamiento térmico de un móvil físico no están disponibles en este laboratorio.
- No se activa ninguna función comercial, no se envían solicitudes reales y no se toca la selección editorial. La revisión humana de R6 sigue pendiente.

## Archivos de la entrega

| Archivo | Cambio |
|---|---|
| `assets/scss/home.scss` | Una importación del partial local |
| `assets/scss/pages/_home-movimiento.scss` | Transiciones cromáticas y respuesta inmediata de foco/pulsación/disabled |
| `docs/HOME-MOTION-DESIGN.md` | Inventario, decisiones, mediciones y QA de R6 |

Los outputs CSS son generados por Gulp e ignorados; no se editan manualmente ni se añaden a Git. No se modifica ningún documento histórico.

La verificación final mantiene HEAD en `d6f9e46`, índice vacío y los tres informes anteriores con sus SHA256 originales (`integridad-informes-final.json`). Se verificó ausencia de diferencias en includes, JS, imágenes, dependencias, páginas legacy, anfitriones y `.htaccess`; el marcador público sigue ausente. La candidata local responde HTTP 200/noindex en 8017. No se interrumpe el servidor preexistente de 8000.
