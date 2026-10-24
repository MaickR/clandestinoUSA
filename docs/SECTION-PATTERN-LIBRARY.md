# Biblioteca de patrones de sección

## Auditoría transversal vigente — 2026-10-21

Inventario contrastado con fuentes, decisiones, defectos corregidos y evidencia actual en [FINAL-DESIGN-SYSTEM-AUDIT.md](FINAL-DESIGN-SYSTEM-AUDIT.md). La aprobación de la dirección visual general expresada en este encargo sustituye los pendientes históricos de dirección; el cierre completo sigue esperando aprobación humana final. Los registros de QA inferiores conservan su fecha y alcance originales.

Contrato añadido de Cart/Mini Cart: `crearEstadoCarrito` y el proveedor `inicializarCarrito` exponen `puedeRestaurar(id) → boolean`. Solo una línea retirada de la colección vigente admite Undo; reemplazarla o restaurarla desde otra vista invalida esa acción. Mini Cart consulta este contrato en cada notificación, sin conservar un historial paralelo. También actualiza el límite nativo, fotografía/ausencia, alt y tipo aunque el ID permanezca estable. El adaptador de otra página debe conservar estos contratos.

Core conserva sus APIs y estilos. Las muestras de botones anuncian su función demostrativa y ofrecen feedback; alertas/estados/avisos no afirman stock, reservas o ventanas retenidas. Los errores que requieren corrección permanecen en contexto junto a la operación. Se retiraron dos `title` redundantes de Remove: su nombre accesible específico y Undo bastan; no se introduce otra biblioteca de Tooltip.

**DESIGN SYSTEM READY — WAITING FOR FINAL HUMAN APPROVAL**, con las limitaciones de pruebas del informe; sin autorización de publicación o venta.

## Wave 6 — Cierre final de biblioteca — 2026-10-19

Estado vigente sobre `bc93e59`, misma feature y base `develop` `a88845e`. Preflight limpio, fetch y sincronización 0/0; sin cambios ajenos. Se preservan los diseños aprobados de Header, Discover, drawer, acceso, breadcrumbs y Footer móvil. Este registro actualiza los contratos/QA del refinamiento histórico inferior; no autoriza PR, merge ni deploy.

### Ajustes finales y Topbar

- Footer md+: gutter local de 32px mediante `--bs-gutter-x`, padding de columnas uniforme y separadores en los límites de la retícula; sin cambiar Bootstrap global. Encabezados en una misma línea editorial; links y dirección comparten padding de lectura de 8px, corrigiendo el desnivel de la primera línea.
- Desktop conserva proporciones Bootstrap 3/2/3/4, comprobadas con el contenido real. Tablet conserva tres columnas legibles 3/4/5; la marca superior usa flex wrap para alinear logo, descripción y redes sin el espacio vertical anterior. Móvil conserva exactamente la composición/espaciado aprobados. Los datos de archivo no se presentan como horario actual: se muestra pendiente de confirmación.
- `_topbar.scss` y `topbar-wave-6.php`: variante de ubicación/Maps y teléfono opcional. Altura medida 45px, targets de 44px, superficie/tipo Foundation; fuera del Header sticky. Visible solo desde xl/1200px cuando el anfitrión la incluye; omitida por defecto y oculta en móvil/tablet. Sin JavaScript, animación ni nuevo request de recurso.
- **Topbar optional — activation deferred until real-page integration.** Comparación en `navigation.php?topbar=on` y `navigation.php`; mismo Header. Header mide 83.55px antes/después de scroll; Topbar sale naturalmente y Header queda en top 0, sin gap añadido.

### Contrato PHP mínimo compartido

`configuracion-wave-6.php` es **fixture local**, incluido explícitamente por navigation.php, nunca por los partials ni por páginas productivas. Se retiraron rutas de Style Guide del Header y datos comerciales repetidos de Header/Footer. El anfitrión real aportará una configuración central confiable; no se crea una aplicación PHP ni se migra HTML legacy.

| Entrada compartida | Contrato |
|---|---|
| `$rutasNavegacion`, `$rutasDescubrir`, `$destinoActivo` | URLs publicadas y página activa. Experiences será Home + ancla; hija activa marca Discover y su enlace |
| `$rutaReserva`, `$enlacesPieDescubrir` | Reserva futura y selección contextual del Footer; URLs reutilizadas desde mapas, sin generar slugs ni enlaces inexistentes |
| `$logoNavegacion`, `$descripcionPie` | Recurso oficial UI y texto editorial; logo con dimensiones reservadas |
| `$datosContacto` | direccion como lista de líneas; mapa/ubicacionBreve; telefono `{texto,url}` o null; email o null; horario como lista confirmada o vacía |
| `$redesSociales`, `$enlacesLegales` | Listas de perfiles canónicos `{icono,nombre,url}` y mapa legal publicado; vacías si faltan |
| `$escaparNavegacion`, `$atributoDestinoNavegacion` | Escape HTML compartido y atributo de target controlado por plantilla: `_top` exclusivamente para la guía embebida; vacío en integración ordinaria, nunca HTML procedente de petición |
| `$mostrarTopbar` | Decisión del anfitrión: include condicional anterior al testigo/Header; false por defecto |

Orden mínimo de integración posterior: cargar configuración → skip link → Core Modal compartido → Topbar opcional → Header → main → Footer → inicialización de módulos sobre sus contenedores. Un ejemplar por documento y IDs únicos. Datos opcionales se omiten por valor, no por un modo global de negocio; `$pieCompleto` solo construye los fixtures completos/mínimos. El modo mínimo ahora omite también email y teléfono del drawer/Topbar, sin valores manuales de reemplazo. No se incluyen horarios legacy: `$datosContacto['horario']` está vacío hasta confirmar vigencia.

El modal continúa usando Core y fixtures readonly; no envía/almacena credenciales ni crea sesiones/cookies. Cuenta/reserva se conectarán a PHP/MySQL únicamente al existir servicio real, con autorización/roles en servidor; no se modifican los contratos de seguridad anteriores. Los mapas del laboratorio no representan rutas publicadas ni se importarán a producción.

### QA de este cierre (no heredado)

| Comprobación | Resultado actual |
|---|---|
| 320/360/390/425/768/820/992/1024/1280/1440 | PASS: cerrado, Discover y modal; drawer por debajo de xl, Topbar visible solo en desktop; sin overflow |
| Footer completo/mínimo, texto largo, interiores | PASS: mínimo 320/768/1280, título interior largo/hija activa, breadcrumbs anidados largos a 320; capturas 390/768/1280 revisadas |
| Drawer y sticky | PASS: click, Enter/Space, X, Escape, backdrop, Tab/Shift+Tab, tres ciclos, selección/ancla, orientación 390×820 ↔ 820×390, resize a desktop y viewport 390×360; retorno de foco y body/backdrops limpios al terminar el ciclo |
| Modal acceso | PASS: foco email, Show/Hide/reset, invalid/loading/error/complete sintéticos, Tab/Shift+Tab, Escape/backdrop y retorno; viewport corto con scroll interno |
| Contraste | PASS: 31 muestras sólidas de Header/Footer/Topbar, mínimo 6.13:1; fuentes y colores Foundation intactos |
| HTML/recursos | PASS: seis vistas renderizadas, cierres, un h1, IDs únicos, ARIA, alt, anclas y símbolos SVG; 68 URLs locales HTTP 200; no es certificación W3C |
| Core y Waves representativas | PASS: Core Modal (abrir/Escape/foco), select Forms, Accordion/Collapse, Quantity=2; Hero grid, boards=2, Gallery abrir/Escape/foco, Gold, gift 100, evento seleccionado, validación de consulta privada, filtro reviews=5 y carruseles End (reviews 374/375px por redondeo; vídeo 562/562px) |
| Consola | Sin errores/warnings de página en muestras revisadas; BrowserSync emitió warning de dependencia Node `util._extend` deprecada en terminal, sin fallo del build |
| Comandos | npm run lint/build, php -l en cinco PHP afectados, git diff --check: PASS; npm run dev reiniciado para revisión |
| Pruebas no ejecutadas | Zoom real 200%, touch físico, lector de pantalla, forced colors, Safari/Firefox y reduced motion del sistema; CSS de reducción de movimiento inspeccionado, sin declarar emulación. Sin métrica CLS ni waterfall de red: se midió estabilidad geométrica sticky y referencias de recursos |

Evidencia actual fuera del repo en `C:/Users/Mike/.codex/visualizations/2026/10/19/01a1547e-0df7-7222-8161-191d7900264d/wave-6-closure/`: capturas finales, JSON responsive/mínimo/contraste/HTML/recursos/peso. El navegador estuvo disponible en este cierre; el bloqueo de reapertura del registro anterior no se extrapola a estas pruebas.

### Performance antes/después del cierre

| Recurso | Antes raw / gzip (bytes) | Después raw / gzip (bytes) |
|---|---:|---:|
| CSS minificado | 105258 / 17319 | 106024 / 17432 |
| JS productivo minificado | 0 / 20 | 0 / 20 |
| JS guía dev sin sourcemap | 119537 / 27650 | 119537 / 27650 |
| JS guía minificado, medición en memoria | 64565 / 20093 | 64565 / 20093 |
| Logo UI | 285557 / 201119 | 285557 / 201119 |

Gzip Node por defecto, Sass/PostCSS/esbuild ES2020 comparables. CSS +113 bytes gzip; ningún JS nuevo. Build excluye guía. Diez referencias únicas de recursos en HTML renderizado antes/después, idénticas (incluyen alternativas picture, no diez descargas simultáneas); la Topbar no agrega recursos. Requests locales comprobados por HTTP; cantidad/tiempos efectivos con caché del navegador no medidos. Logo original, sprite, dependencies y Waves anteriores intactos.

### Auditoría final de completitud

| Familia | Clasificación / dependencia |
|---|---|
| Header; Sticky; Discover; Mobile Drawer; Hamburger/X | COMPLETA |
| Authentication Entry; Auth Modal Demo | COMPLETA CON DEPENDENCIA FUTURA DOCUMENTADA: autenticación/autorización real |
| Optional Topbar | COMPLETA CON DEPENDENCIA FUTURA DOCUMENTADA: activación por página |
| Footer Desktop; Footer Tablet; Footer Mobile | COMPLETA |
| Contact; Social Links | COMPLETA CON DEPENDENCIA FUTURA DOCUMENTADA: vigencia comercial/horarios y perfiles TikTok/YouTube sin URL confirmada |
| Legal Links | COMPLETA: documentos existentes; revisión comercial antes de publicación |
| Breadcrumbs; Contextual Navigation; Skip Link; Navigation Active States | COMPLETA |
| Responsive; Accessibility | COMPLETA en cobertura frontend probada; PRUEBA NO EJECUTADA para las condiciones manuales enumeradas arriba |
| Shared PHP Contracts | COMPLETA CON DEPENDENCIA FUTURA DOCUMENTADA: configuración central real y migración de páginas |
| Performance | COMPLETA para bundles/recursos; PRUEBA NO EJECUTADA para CWV/CLS y waterfall de red |
| Backend, cuentas reales, reservas, pagos, migración, publicación | FUERA DE ALCANCE |

Sin DEFECTO BLOQUEANTE conocido. Pendientes reales: aprobación visual final, comprobaciones manuales enumeradas, datos comerciales confirmados y posterior integración funcional. URLs: `/style-guide/navigation.php`, `?topbar=on`, `?footer=minimal&topbar=on`, `?layout=interior&active=club`; Core `/style-guide/`, Patterns `/style-guide/patterns.php`, bajo `http://localhost:3000`.

## Wave 6 — Refinamiento final — 2026-10-19

Esta sección describe el estado vigente y sustituye las decisiones de interacción/composición del registro inicial de Wave 6 conservado más abajo. Misma rama `feature/ui-section-patterns-wave-6`, base `develop` en `a88845e`, inicio del refinamiento `c5b1be5`. Preflight: árbol limpio, fetch y sincronización 0/0 con origin, diff contra develop revisado; sin cambios ajenos. Arquitectura general, Discover, reservas, breadcrumbs y navegación contextual aprobados en primera revisión humana. Este refinamiento requiere nueva aprobación visual.

### Cobertura y criterio visual

Se inspeccionaron las tres referencias adjuntas de AKLE (desktop, móvil y tablet: archivos `codex-clipboard-66e28fbd…`, `1ee97f78…` y `b6370626…`). Se adoptan organización editorial, separadores, círculos sociales y franja inferior; no identidad, contenidos, pagos ni garantías. Foundation, Core y Waves 1–5 se reutilizan: no hay biblioteca paralela, fuentes, iconos ni dependencias nuevas. VISUAL-DIRECTION permanece intacto.

| Necesidad | Resolución vigente |
|---|---|
| Header / tipografía | Extender `cl-cabecera`; fuente explícita `var(--fuente-cuerpo)`, peso 500, 0.9375rem, interlineado 1.5 y tracking 0.015em; sin cambiar escala global |
| Sticky / Hero / skip / breadcrumbs / contexto | Reutilizar; superficie sólida, altura estable, observers y offsets locales; Hero Wave 1 intacto |
| Móvil/tablet | Sustituir únicamente Collapse del panel principal por Offcanvas oficial; Discover conserva Collapse |
| Cuenta | Crear composición de acceso con icono Core y Core Modal/campos/carga/alertas; exclusivamente sintética |
| Footer | Rediseñar composición `cl-pie` y reutilizar `cl-contacto`, grid, enlaces y sprite Core |
| Backend, cuentas, reservas, pagos | Diferir a fase funcional; no se implementan endpoints, tablas, sesiones ni permisos |
| TikTok / YouTube | Diferir: sin URL canónica verificable en repositorio; no generar enlaces |
| Back to Top | Omitir: no se justifica otro control flotante/sistema global en este laboratorio; reconsiderar al construir páginas largas reales |

### Header, Discover y drawer

Desktop desde xl/1200px: logo → Home / Experiences / Restaurant / Wine Shop → Discover → Reserve a Table → icono Sign in. Se preservan aire, targets de al menos 44px y subrayado activo. Discover contiene únicamente Gift Cards, Wine Club y Events; si una hija es actual, el padre tiene indicador visual y descripción accesible, y la hija `aria-current="page"`. No es un megamenú ni depende de hover.

Por debajo de xl se usa una sola estructura DOM de navegación en `offcanvas-xl offcanvas-end`, ancho `min(25rem, calc(100vw - var(--espacio-5)))`: 296px a 320px y máximo 400px. Panel derecho oscuro, grupos claros, CTA y contacto compacto, scroll interno; transición transform de 260ms, sin blur. El mismo botón hamburguesa se traslada al encabezado del drawer y se convierte en X: no se duplica un cierre. Sus nombres son Open/Close main navigation; estado y aria-expanded siguen el ciclo oficial. Se bloquean dobles activaciones durante transición y se atiende cierre pendiente al finalizar la apertura.

`inicializarNavegacion(contenedor, { raizScroll = null })` mantiene API explícita, WeakMap e inicialización idempotente. Imports individuales Offcanvas y Collapse; Bootstrap aporta backdrop, Escape, focus trap, bloqueo/restauración de body y cierre responsive al pasar a desktop. No hay segundo trap ni listener de resize propio. Escape cierra Discover antes que el drawer; selección cierra y enfoca anclas locales al terminar. Cierre normal retorna al activador; resize a desktop retorna a Discover. `destruir()` devuelve una Promise cacheada, espera transiciones, aborta listeners, desconecta observers, dispone instancias y restaura markup. Limpieza revisada en código; montaje/desmontaje dinámico no probado en navegador.

Sticky conserva alto aproximado de 84px; solo cambian superficie/borde. IntersectionObserver y ResizeObserver mantienen estado y `--navegacion-offset`; scroll-margin local evita anclas/foco ocultos. No se altera historial ni scroll global. Sin JS, las listas permanecen visibles y los controles de mejora ocultos; alternativa revisada en markup. Foundation/reduced-motion y reglas Bootstrap reducen transiciones; se inspeccionó CSS compilado, sin emular preferencia del sistema.

### Acceso demostrativo y contrato futuro

El único icono de persona, después de reservas en desktop y disponible junto al logo en móvil, abre `acceso-wave-6.php`. `inicializarAcceso(contenedor, activador)` reutiliza Core Modal y sus mecanismos de foco, Escape, backdrop, scroll y retorno. Título Welcome back, labels visibles, email/password, Show/Hide con aria-pressed, foco inicial en email, carga/errores/feedback y cierre. Recuperación y creación de cuenta son slots textuales sin rutas falsas.

Los campos son **readonly**, sin atributos name, con fixtures `guest@example.invalid` / `sample-only`; password oculto inicialmente y al cerrar. Autocomplete username/current-password prepara el contrato. El submit se cancela siempre: validación sintética y temporizador de interfaz de 900ms, seguido de aviso explícito de servicio no conectado. Selector de laboratorio separado ofrece ready, invalid, loading, error y complete; complete declara que no hubo autenticación ni sesión. No hay fetch, endpoints, cookies, persistencia, registro de credenciales ni falso acceso exitoso. El HTML sin JS mantiene submit deshabilitado.

Integración posterior PHP/MySQL (Wave 7/backend): un único acceso para clientes y administradores; servidor determina rol, autorización y destino permitido en cada petición. No mostrar Admin como categoría comercial. Reemplazar fixtures/readonly y conectar servicio solo al existir funcionalidad real: validación servidor, CSRF, consultas preparadas, password_hash/password_verify, errores genéricos y limitación de intentos; sesiones con cookies Secure/HttpOnly/SameSite y redirects permitidos. No se crean esquema, rutas ni infraestructura en esta wave. La autorización nunca dependerá del control visual ni de un rol enviado por cliente.

### Footer editorial y datos

Desktop: cuatro áreas Brand / Explore / Discover more / Visit & contact, separadas con gutters y líneas discretas. Tablet: marca superior y tres columnas legibles. Móvil: logo/descripción/redes centrados, grupos verticales con separadores; sin acordeones innecesarios. Franja inferior independiente con copyright PHP dinámico y legales reales. Altura observada con datos completos: aproximadamente 1282px a 390, 744px a 768 y 543px a 1280; sin overflow ni huecos artificiales.

Explore contiene Restaurant, Wine Shop y Experiences; Discover more agrupa Spanish Wine Club, Gift Cards, Events y Private Experiences (ancla existente de guía configurable mediante `$rutaExperienciaPrivada`). Logo Home usa la configuración de navegación. Datos contrastados con index/contact legacy: 211 N Mt Shasta Blvd, Mt Shasta, CA 96067; `tel:+14086090027`; `mailto:ntcusa@nicolastena.com`; Maps hacia esa dirección. Horario archivado Tue–Sun 4–8 PM Pacific / Monday Closed aparece con aviso de reconfirmación, no como promesa de vigencia comercial. Confirmar teléfono, email y horario antes de publicación real.

Instagram `https://www.instagram.com/theclandestinousa/` y Facebook `https://www.facebook.com/profile.php?id=61559740614798`: iconos del sprite, círculos 44px, nombres accesibles y rel de seguridad al abrir fuera. No se habilitan TikTok/YouTube sin URL verificada. Legales `/policies.html` y `/terms.html` existen; sin políticas inventadas, logos de pago ni afirmaciones de seguridad comercial. Fixture `?footer=minimal` prueba datos opcionales ausentes y descripción larga con el mismo partial, sin enlaces vacíos.

### Configuración de rutas y composición

Se conservan `$rutasNavegacion`, `$rutasDescubrir`, `$destinoActivo`, `$rutaReserva`; se añaden `$logoNavegacion` (derivado UI por defecto) y `$rutaExperienciaPrivada`. Valores desde configuración interna confiable, escapados; no construir URLs desde labels ni petición. Nueve destinos de producto representados: Experiences es ancla de Home; Reserve conserva destino demostrativo válido/aviso; My Account se expresa mediante Sign in sintético, futura ruta autorizada por servidor. Booking-app-php permanece sin cambios ni integración.

El sitemap legacy no es contrato futuro: menu/tapas corresponden a contenido Restaurant; wines a Wine Shop; swc a Wine Club; hampers a catálogo contextual; about al relato Restaurant; contact a contacto/footer; terms/policies a legales. links es utilidad legacy, no nueva categoría primaria. No se modifica sitemap ni se publican rutas nuevas.

`navigation.php?layout=interior&active=club` demuestra página sin Hero, título largo, sección clara/campo Core, breadcrumbs y estado de hija activa. La composición por defecto conserva Hero fotográfico, contenido oscuro y anclas. Query fixtures con valores allowlisted, sin interpolación de entrada. Iframe de Patterns conserva aislamiento y navegación propia; no hay segunda versión productiva del Header ni import de demostraciones en main.js.

### Logo y performance

El SVG original (435399 bytes) contiene dos PNG embebidos. Se creó `assets/images/clandestino-logo-ui.svg` (285557 bytes): PNG → WebP lossless exact, igualdad RGBA decodificada comprobada en ambos recursos, eliminación solo de metadata/namedview no renderizable; geometría, máscaras, proporciones y original intactos. Render revisado en navegador. `?logo=original` permite comparar. No se afirma igualdad píxel a píxel de capturas ni compatibilidad entre navegadores no probados.

Mediciones comparables Node gzip por defecto, CSS de build y esbuild ES2020 en memoria para guía:

| Recurso | Antes bytes / gzip | Después bytes / gzip |
|---|---:|---:|
| CSS productivo | 90329 / 15797 | 105258 / 17319 |
| JS guía sin minificar, sin sourcemap | 108592 / 24998 | 119537 / 27650 |
| JS guía minificado (solo medición) | 58622 / 18506 | 64565 / 20093 |
| JS productivo | 0 / 20 | 0 / 20 |
| Sprite Core | 11536 / 3920 | 11536 / 3920 |
| Logo original → derivado UI | 435399 / 304595 | 285557 / 201119 |

Incremento CSS gzip 1522 bytes y guía minificada gzip 1587 bytes incluye mecánica Offcanvas y acceso. Ahorro logo gzip 103476 bytes (34.0%). Build excluye style-guide.js; producción sigue sin activación JS. Sin bundle Bootstrap completo, Popper, dependencias ni imágenes nuevas. Fuente original intacta; derivado no sustituye assets legacy.

### QA ejecutado y límites

- `npm run lint`, `npm run build`, php -l en los 32 PHP de guía y `git diff --check`: correctos. Validación HTML renderizado de lab completo/mínimo/interior, Patterns y Core: cierres, IDs únicos, referencias ARIA/anclas, alt y sprite; 66 URLs locales únicas respondieron 200. No equivale a certificación W3C.
- Navegador IAB real en 320, 360, 390, 425, 768, 820, 992, 1024, 1280 y 1440: cerrado, drawer/Discover y modal abiertos, sin overflow horizontal. Texto largo a 320/768/1280, viewport corto 390×360 y cambio de orientación/resize probados.
- Drawer: click, Enter/Space, X, Escape, backdrop, selección/ancla, Tab/Shift+Tab circular, tres ciclos, scroll interno y resize abierto a desktop. Sin backdrop residual ni body bloqueado; foco restaurado. Modal: foco inicial, Tab/Shift+Tab, Escape/backdrop/cierre, Show/Hide y reset, estados sintéticos/validación/carga, sin autenticación.
- Footer completo/mínimo, tablet/móvil/desktop; interiores claros/oscuros, Hero y sin Hero; activos/breadcrumbs/offsets y separación de la guía revisados. Contraste calculado de 37 textos sólidos Header/Footer/modal: mínimo 5.47:1, ninguno inferior a 4.5:1. Consola sin errores/warnings en las muestras revisadas.
- Regresiones representativas ejecutadas: Core Modal, Accordion, Collapse, formulario/select y Quantity; Waves 1–5: Hero, cantidad/subtotal, Gallery (abrir/cerrar/foco), elección de plan, filtro/rating, Reviews Carousel y Video Carousel (recorrido hasta final). Iframe conserva overlays/foco propios. No se probó reproducción de vídeo ni se modificaron módulos anteriores.
- Pendiente manual: zoom real 200%, touch físico, lector de pantalla, forced colors, reduced motion a nivel sistema, Safari/Firefox. Sin emulación fiable disponible para esas condiciones, no se declara PASS. Revisar teclado completo, orientación, ambas preferencias de movimiento y logo en esos navegadores antes de publicación.

| Comprobación qa-visual ejecutada | Resultado |
|---|---|
| 390 / 768 / 1280 y otros siete anchos | PASS: composición y capturas revisadas |
| Teclado y foco | PASS: controles, overlays, retorno y secuencia probados |
| Contraste de textos sólidos | PASS: mínimo 5.47:1 |
| Semántica, labels, alt, IDs y ARIA | PASS: HTML renderizado inspeccionado |
| Consola y recursos locales revisados | PASS: sin errores/warnings, enlaces locales 200 |
| Overflow y texto largo | PASS: sin desbordamiento horizontal |
| Safari/Firefox, zoom 200%, touch físico, lector y movimiento del sistema | PENDIENTE manual, no PASS |

Evidencia local fuera del repositorio: carpeta `C:/Users/Mike/.codex/visualizations/2026/10/19/01a1547e-0df7-7222-8161-191d7900264d/wave-6-refinement/` con JSON antes/después/responsive/estrés/contraste y capturas finales 390/768/1280, drawer, modal e interiores. `npm run dev` sirve `http://localhost:3000/style-guide/navigation.php`, variantes anteriores y `/style-guide/patterns.php` / `/style-guide/` (Core) para revisión. Tras el build final se reinició dev correctamente; la reapertura final del navegador fue rechazada por su política de seguridad de URL, sin intentar evasión. Los resultados anteriores corresponden a pruebas reales ya ejecutadas; no se afirma una nueva sesión de navegador después de ese bloqueo. Aprobación visual humana pendiente; sin PR, merge ni deploy.

## Wave 6 — Navegación global y estructura — 2026-10-19

**Registro histórico inicial:** las decisiones sustituidas por el refinamiento vigente de arriba (Collapse móvil, cuenta estática, composición Footer y logo sin derivado) se conservan como trazabilidad, no como contrato actual.

Rama `feature/ui-section-patterns-wave-6`, desde `develop` en `a88845e` (merge de Wave 5, PR #11). Preflight: árbol limpio en la feature Wave 5, divergencia 0/0, fetch ejecutado y HEAD de Wave 5 comprobado como ancestro de origin/develop. Develop se actualizó por fast-forward antes de crear esta feature. Sin PR, merge ni deploy de Wave 6. La aprobación visual humana permanece pendiente.

### Auditoría inicial y cierre de cobertura

Se consultaron AGENTS, VISUAL-DIRECTION, UX/UI, Core, arquitectura, estándares, mapa del sitio, flujo Git y contratos de Waves 1–5. Se contrastaron Header/Footer con `production-baseline:index.html`, el HTML legacy actual, contacto, logo y sprite. No se trasladan sus roles menubar/menuitem, enlaces históricos como arquitectura nueva, scroll lock ni scripts legacy.

| Necesidad | Clasificación inicial → resultado |
|---|---|
| Botones, enlaces, iconos y estados | REUTILIZAR → Core intacto, sin segunda biblioteca |
| Header, logo, CTA, navegación primaria y active | CREAR → `cl-cabecera`, una sola estructura responsive; logo SVG oficial y `cl-boton` |
| Sticky y offsets | CREAR → superficie inicial sólida, estado fijado sin cambio de altura, observer y margen local para anclas/foco |
| Apertura/cierre móvil y subnavegación | EXTENDER mecánica existente → Bootstrap Collapse individual; sin otro accordion, dropdown, focus trap u overlay |
| Footer, contacto y redes | CREAR composición → `cl-pie` / `cl-contacto`, grid, Core y datos presentes en el repo |
| Breadcrumbs | REUTILIZAR / EXTENDER en contexto → `cl-migas` intacto dentro de `cl-ruta`, dos/tres niveles y texto largo |
| Navegación contextual | REUTILIZAR → enlaces Core agrupados en `cl-contexto`, Back / Explore / Related |
| Skip link | CREAR presentación reutilizable → `cl-saltar`, un solo enlace antes de Header hacia main |
| Cuenta, ruta de reserva y destinos productivos nuevos | DIFERIR → cuenta sin enlace; reservas con aviso explícito y contrato futuro, resto abre muestras existentes |
| TikTok / YouTube | DIFERIR → no se encontró perfil canónico en HTML/PHP/docs del repo; se omiten, sin URLs inventadas |
| Mega menú, Offcanvas, Header transparente o sin CTA | DIFERIR → no hay necesidad demostrada: grupo Discover y disclosure móvil resuelven los nueve destinos; CTA de reservas es global |
| Páginas productivas, backend, Booking-app-php, pagos, cuenta, hosting | FUERA DE ALCANCE → sin cambios |

### Arquitectura, rutas y PHP

Destinos del producto conservados: Home, Experiences, Restaurant, Wine Shop, Gift Cards, Wine Club, Events, Reserve y My Account (FUTURE). En desktop: Home / Experiences / Restaurant / Wine Shop, control Discover para Gift Cards / Wine Club / Events y el estado de cuenta; Reserve a Table es la acción destacada contigua. La agrupación reduce densidad sin eliminar destinos. Discover es un control de grupo, no una página ni un enlace con doble función. Home conserva enlace textual y logo como regreso convencional.

Experiences sigue siendo **ancla de Home** en el contrato futuro. La muestra abre la sección existente de experiencias de la guía; no crea página propia. Reserve será página/motor PHP futuro. No se enlaza a un motor ficticio ni al repositorio de referencia `MaickR/Booking-app-php`, que no se modifica ni integra.

Los partials PHP son markup de referencia reutilizable dentro del laboratorio. `cabecera-wave-6.php` acepta configuración PHP interna antes del include, mediante defaults `??=`:

| Configuración | Contrato |
|---|---|
| `$rutasNavegacion` | Mapa ordenado nombre → URL publicada para Home / Experiences / Restaurant / Wine Shop |
| `$rutasDescubrir` | Mapa ordenado para Gift Cards / Wine Club / Events |
| `$destinoActivo` | Nombre exacto de un destino; emitir un solo `aria-current="page"` en su enlace. La muestra usa Home |
| `$rutaReserva` | Único destino compartido por Header, Hero de muestra y Footer; hoy `#reserva-global` |

La futura página proporcionará mapas desde configuración confiable del servidor, nunca desde parámetros de petición. Mantener nombres/orden documentados; validar rutas publicadas y escapar atributos/textos. Las anclas deben existir en el documento de destino; usar `tabindex="-1"` en destinos de foco que no sean enfocables de forma nativa. Experiences resolverá URL de Home + ID real. No deducir slugs desde labels ni suponer que menu.html/wines.html/swc.html son la arquitectura definitiva. Los enlaces de la muestra a otras familias usan `/style-guide/patterns.php#…` y `target="_top"` para salir del iframe; al integrar PHP real, revisar ese target según contexto.

My Account permanece texto estático con “Future · unavailable”, sin href, tabindex, botón inerte ni login simulado. En producción, un destino aún no publicado se omite o se representa como estado textual explicado; no se fabrica una URL. El slot futuro de cuenta se activará solo al existir una función pública autorizada.

`$pieCompleto` es exclusivamente selector de fixtures de la guía: `navigation.php?footer=minimal#pie-global` muestra el **mismo partial** sin teléfono, email secundario, redes, horario ni enlaces legales, con texto largo y notas explícitas de muestra. En integración real cada dato opcional se omitirá individualmente si falta; no trasladar este parámetro demo a negocio.

### Header, responsive y estados

- Logo oficial con alto automático y ancho contextual 8rem; sin deformación, recoloración ni derivado. Header cerrado de aproximadamente 84px, con padding del sistema. Fondo sólido desde el inicio protege lectura sobre fotografía o una superficie clara; el sistema no tiene variante de tema claro ni transparencia nueva.
- Desktop desde **xl (1200px Bootstrap)**: logo, navegación y CTA en una fila; lista capaz de envolver nombres largos, Discover alineado al borde derecho de su control. Dropdown acotado al viewport vertical y con scroll interno cuando haga falta. No aparece por hover.
- Por debajo de xl: botón hamburguesa de 44px, logo, panel en flujo y grupos jerarquizados con CTA al final. Panel limitado por `100dvh` y alto cerrado calculado; scroll interno en poca altura. No bloqueo de body, backdrop ni Offcanvas. El menú puede ocupar casi toda la altura disponible al abrirse; el activador permanece accesible.
- Header `position: sticky; top: 0` dentro de su contenedor. Un testigo anterior y IntersectionObserver aplican `cl-cabecera--fijada` al quedar por encima del viewport; cambia superficie/borde, **no tamaño**. Sin listener de scroll ni contracción que provoque saltos.
- ResizeObserver mantiene `--navegacion-offset` local. `.cl-estructura [id]` y `:focus` reservan ese alto + espacio-4; no se modifica scroll global. La prueba de Tab detectó un enlace sin ID tapado al cerrar: se corrigió extendiendo el margen al foco y se revalidó (enlace a 106.6px, Header hasta 83.5px).
- Active usa subrayado de 2px además de color; hover/focus conservan nombre legible, subrayado y anillo Foundation. Dentro del panel con scroll, offset de foco -3px mantiene el anillo completo sin recortar sus laterales; grosor/color Foundation intactos y captura de teclado revalidada. Con/sin CTA no son implementaciones distintas: esta wave mantiene la reserva como acción global justificada.
- Body/raíz `cl-estructura` contiene Header, main y Footer. Un solo skip link al main con `tabindex="-1"`; no añadir otro si la página ya lo tiene. La guía principal conserva el suyo: el iframe tiene documento, landmarks e IDs propios.

### Módulo de navegación y accesibilidad

`assets/js/modules/patterns/navegacion-global.js` exporta `inicializarNavegacion(contenedor, { raizScroll = null })`. Valida nodos al iniciar y reutiliza control mediante WeakMap. El contenedor explícito aporta cabecera/testigo, marca/fila, activador/panel móvil y activador/subpanel Discover. Bootstrap Collapse se importa individualmente y gestiona transiciones, clases y aria-expanded a través de data-bs-toggle/target; no se importa Bootstrap completo, Popper ni otra dependencia.

- `aria-controls` resuelve IDs únicos; `<nav>` y listas nativas, sin roles de aplicación/menu/menuitem. Nombre accesible estable del activador: Toggle main navigation; su estado expandido comunica apertura/cierre.
- Enter/Space abren controles nativos; Tab/Shift+Tab recorren enlaces en orden DOM. No trap. Escape local a Header cierra Discover primero y devuelve foco a su botón; un segundo Escape cierra el panel móvil y devuelve foco al activador.
- Seleccionar enlace cierra lo correspondiente. En anclas del mismo documento se enfoca el destino al terminar el cierre; mantiene visibles ancla/foco con offset. Al tabular fuera del Header móvil se cierra sin atrapar ni ocultar el foco de main. Discover cierra al salir el foco del Header o hacer clic fuera de él.
- Panel cerrado con display:none queda fuera del orden de tabulación. No se capturan teclas globalmente ni se cambia history. Sin JS, el HTML inicial deja enlaces/listas visibles y los dos controles de mejora ocultos; esta alternativa se inspeccionó en markup, no en navegador con JS desactivado.
- `destruir()` devuelve Promise: aborta listeners y desconecta observers, espera transiciones activas de Bootstrap antes de dispose, restaura listas visibles/controles ocultos y retira el registro. Invocar y esperar antes de desmontar. Idempotencia/limpieza revisadas en código; no se declara prueba de montaje dinámico en navegador.
- No añade animaciones ni configura scroll suave: conserva el comportamiento nativo y el smooth existente en Foundation para no-preference. Foundation anula scroll suave y reduce transiciones Bootstrap con prefers-reduced-motion. CSS compilado inspeccionado; preferencia de sistema no emulada.

La activación pertenece únicamente a `style-guide.js` durante esta wave. `main.js` sigue sin imports. Al construir páginas reales, importar el mismo módulo y llamarlo sobre su contenedor; no copiar el inicializador de la guía ni sus fixtures.

### Footer, contacto, redes y rutas legales

Footer editorial en superficie alterna: invitación comercial compacta, logo/propuesta, seis enlaces de exploración y bloque de contacto. Grid Bootstrap: columnas desde md, contacto ancho completo en tablet y tercera columna desde lg; móvil en flujo con separaciones del sistema. Sin newsletter, feed, imagen de fondo nueva, iconos ornamentales ni lista duplicada completa de Header. Propuesta larga conserva wrap, sin truncar; copyright con año PHP.

Datos contrastados en `index.html` y `contact.html` del repo:

| Dato | Valor / tratamiento |
|---|---|
| Dirección / mapa | 211 N Mt Shasta Blvd, Mt Shasta, CA 96067; URL Google Maps existente para esa dirección |
| Teléfono | +1 408-609-0027 → `tel:+14086090027` |
| Email preferido | ntcusa@nicolastena.com → mailto |
| Email secundario | info@theclandestinousa.com → mailto |
| Horario registrado | Tuesday–Sunday · 4–8 PM Pacific; Monday · Closed. Fuente: ambos documentos legacy; reconfirmar vigencia al publicar páginas reales |
| Instagram | `https://www.instagram.com/theclandestinousa/` |
| Facebook | `https://www.facebook.com/profile.php?id=61559740614798` (identidad canónica sin locale de presentación) |
| Legal existente | `/policies.html`, `/terms.html`; se enlazan documentos reales sin reescribir ni afirmar nuevas condiciones |

Redes usan los símbolos Core Instagram/Facebook, nombres visibles, `target="_blank"`, `rel="noopener noreferrer"` y aviso accesible de nueva pestaña. Verificación de identidad/URL contra repositorio; no se certifica disponibilidad externa de perfiles en esta sesión. TikTok/YouTube requieren URL canónica confirmada antes de renderizar enlace/icono. No se agregan dependencias o símbolos para plataformas sin destino.

Datos opcionales ausentes no crean tel/mailto vacíos. Si falta una política, omitir enlace o mostrar slot textual explícito de laboratorio; nunca href vacío, “#” genérico ni declaración legal inventada. No se muestran medios de pago sin confirmación. `cl-contacto` conserva dirección semántica y targets de enlace de al menos 44px.

### Breadcrumbs y navegación contextual

Reutiliza `<nav aria-label="Breadcrumb"><ol class="cl-migas">…</ol></nav>` de Core, actual sin enlace con aria-current, separadores `aria-hidden="true"`. La muestra anidada usa nombre único de nav para distinguir ejemplos. `cl-ruta` permite envolver el item largo sin que un flex inline impida partir palabras; no modifica `_migas.scss`. Dos niveles por defecto y tres en disclosure de estados. No añade otro título de página ni enlaces a páginas inexistentes.

`cl-contexto` agrupa Back to Experiences / Explore Spanish wines / Related · Events con enlaces Core; el icono volver comunica dirección. No SPA, historial global, enrutador ni JS para estos dos patrones.

### Demostración y QA ejecutado

`/style-guide/patterns.php#wave-6` incluye `partials/navegacion-wave-6.php`. Un iframe lazy con título y altura contenida carga `/style-guide/navigation.php`: laboratorio de estructura, sin CSS de presentación de guía dentro. Se puede abrir a viewport completo. Header/Hero comparten la composición Wave 1 real, sin editar su SCSS ni partial original. Cada documento conserva un h1, un main y su skip link; sus IDs no colisionan. No hay dos versiones de Header.

| Comprobación | Resultado actual |
|---|---|
| ESLint / Stylelint / build / php -l / diff --check | PASS; 31 PHP de guía verificados. Build sin CSS/JS de guía ni selectores cl-guia/cl-muestra en producto |
| HTML renderizado | PASS con HTMLParser: cierres balanceados, IDs únicos (9 lab / 253 Patterns / 97 Core), h1 único, referencias ARIA y anclas válidas. No certificación Nu/W3C |
| Recursos / URLs | PASS: 65 URLs locales únicas con HTTP 200, incluidos documentos/fragmentos/SVG. Símbolos referenciados resueltos, imágenes activas cargadas. Sin HAR completo ni certificación de servicios externos |
| 320 / 360 / 390 / 425 / 768 / 820 / 992 / 1024 / 1280 / 1440 | PASS de geometría: cerrado, móvil abierto y Discover abierto; sin overflow de documento/Footer/panel. Capturas revisadas 390/768/1280 |
| Nombres largos / palabra sin espacios | PASS en 320/768/1280 con fixture temporal de labels, luego restaurado con hash idéntico; sin overflow. Breadcrumb largo y Footer largo disponibles permanentemente en estados de guía |
| Poca altura | PASS 390×360: panel client 260px / scroll 515px; activador visible y enlaces accesibles mediante scroll/foco. Desktop submenu también acotado por altura disponible |
| Teclado / foco / skip | PASS: Tab, Space, Enter, Escape en dos niveles; retorno, exclusión de controles cerrados, salida hacia main, foco visible. Skip aparece primero y enfoca main |
| CTA / sticky / anclas | PASS: cierre tras seleccionar, foco en reserva-global, destino a 99.8px con Header hasta 83.5px; superficie fijada sin cambiar alto. Sin scroll lock residual |
| Demo contenida | PASS en 390/1280: mismo menú dentro de iframe, Escape/retorno y ausencia de overflow; navegación de la guía conservada |
| Footer / breadcrumbs | PASS: datos completos, datos opcionales ausentes, texto largo, tel/mailto reales, enlaces legales existentes y rutas locales resueltas |
| Contraste | PASS calculado para 48 textos sobre superficies sólidas: mínimo 6.13:1, sin fallos bajo 4.5:1. Hero reutilizado sin alterar su protección fotográfica |
| Consola | PASS: sin errores/warnings observados en lab, Patterns y Core. Terminal dev conserva aviso BrowserSync DEP0060 por util._extend |
| Regresiones representativas | PASS: Hero en grid; cantidad Wave 2 y subtotal $72; Gold y FAQ Wave 4; visor Wave 3/Escape/retorno y body desbloqueado; filtro/Show more/rating con Space y carrusel End hasta extremo Wave 5; Quantity/Collapse/Modal/Escape/retorno Core. Se esperó estabilización de transiciones; no nueva certificación exhaustiva de todos los flujos |

Límites: Chromium integrado exclusivamente. Sin prueba auditiva de lector de pantalla, touch físico, forced colors ni Safari/Firefox. Zoom real 200% no disponible mediante el atajo probado (innerWidth y devicePixelRatio permanecen iguales); no se sustituye por cambiar font-size ni se declara PASS. Reduced motion se comprueba en cascada CSS, sin emular preferencia. Checklist manual: repetir 200%, swipe/targets en teléfono, lectura/landmarks con lector y navegadores reales antes del cutover. Estos límites no se presentan como defectos resueltos o compatibilidad certificada.

Evidencia fuera del repo: `C:/Users/Mike/.codex/visualizations/2026/10/19/01a1547e-0df7-7222-8161-191d7900264d/wave-6/` (capturas desktop/tablet/móvil, menú/submenu, Footer opcional, breadcrumbs, iframe, JSON responsive/estrés/contraste/performance y scripts HTML/recursos). Skill aplicada: `.agents/skills/qa-visual/SKILL.md`.

### Performance, alcance y pendientes reales

Medido antes desde develop y después con el mismo pipeline build; JS guía generado en memoria por esbuild, sin sourcemaps; gzip Node nivel 6:

| Artefacto | Bytes antes → después | Gzip antes → después | Delta gzip |
|---|---:|---:|---:|
| CSS producto | 84671 → 90329 | 14899 → 15797 | +898 (+6.03%) |
| JS producto | 0 → 0 | 20 → 20 | 0; solo cabecera gzip vacía |
| JS guía DEV | 102269 → 108592 | 23668 → 24998 | +1330 (+5.62%) |
| JS guía minificado, medición | 55087 → 58622 | 17554 → 18506 | +952 (+5.42%) |
| Sprite | 11536 → 11536 | 3920 → 3920 | 0 |

Recursos locales de assets, mismo parser para HTML de develop renderizado por PHP y Patterns actual con iframe: **50 → 51** URLs únicas; única nueva es el logo oficial, ya existente en el repo (**435399 bytes / 304595 gzip**). Es un coste real relevante del original; no se optimiza ni genera derivado dentro de este encargo. Header/Footer comparten URL y caché, Hero reutiliza fotografía/fuentes existentes. El iframe añade un documento de laboratorio lazy y reutiliza CSS/JS/sprite, sin recursos de negocio, feeds, APIs, videos nuevos o dependencias. No se atribuyen Core Web Vitals de usuarios reales a esta medición local.

Fuentes creadas: dos SCSS (`_navegacion-global.scss`, `_pie-global.scss`), módulo `navegacion-global.js`, laboratorio `navigation.php` y tres partials (`cabecera-wave-6.php`, `pie-wave-6.php`, `navegacion-wave-6.php`). Entradas ampliadas: main.scss, style-guide.js, presentación `_guia.scss` y patterns.php; documentación: esta biblioteca y referencia de arquitectura. Outputs ignorados, ninguna modificación a main.js, Core, Waves 1–5, legacy, backend, multimedia, sitemap, robots o .htaccess.

Auditoría final: cobertura frontend cerrada para Header, sticky, móvil/subnav, estados activos/futuros, reserva conectable, Footer/datos opcionales, contacto/redes verificadas en repo, breadcrumbs, contextual y skip. Pendiente de producto: rutas publicadas definitivas, reserva PHP real, My Account, URLs oficiales TikTok/YouTube y vigencia comercial antes de publicación. Pendiente de aceptación: revisión visual humana integral y modos/dispositivos indicados. No migrar páginas ni hacer PR/merge/deploy con este cierre técnico.

URLs locales: `http://localhost:3000/style-guide/patterns.php#wave-6`, `http://localhost:3000/style-guide/navigation.php`, `http://localhost:3000/style-guide/navigation.php?footer=minimal#pie-global` y Core `http://localhost:3000/style-guide/`. Watcher dev disponible para revisión.

## Refinamiento final Wave 5 — 2026-10-19

Base `255815f0f7f976ed0c2049ebbf2229eb7ce0be95`, rama `feature/ui-section-patterns-wave-5`. Preflight: árbol limpio, fetch y sincronización 0/0 con origin. Esta pasada sustituye el bloqueo de QA del 18 de octubre: el navegador integrado ya permite probar el origen local. La aprobación visual humana de los nuevos cambios sigue pendiente; no hay PR, merge ni deploy.

### Auditoría y decisiones de alcance

| Necesidad | Decisión / resultado |
|---|---|
| Reviews completas frente a compactas | EXTENDER la base existente: superficie transparente, separación editorial superior/inferior y mismo contenido completo. Se conserva `--compacta`, autor, valoración textual, fuente legible, fecha/avatar opcionales y respuesta independiente; sin tercer componente |
| Selección editorial de reseñas | CREAR `cl-carrusel`, separado del listado filtrable y del Featured Testimonial. Cuatro registros ficticios existentes; controles antes de la pista para no obligar a recorrer una reseña larga para navegar |
| Colección audiovisual | REUTILIZAR la misma navegación y las proporciones/estados de Wave 3. Tres ejemplos: horizontal pendiente, vertical pendiente y no disponible. Se elimina la fotografía ambiental de la antigua muestra de video para que no parezca un poster de cliente |
| Featured, estrellas, formulario, reputación y lifecycle | PRESERVAR los diseños expresamente aprobados por el usuario. Sus fuentes específicas y lógica permanecen intactas; la superficie compartida de reseña sí se refleja en el listado |
| Flecha de select demasiado próxima al borde | EXTENDER exclusivamente `select.cl-campo` simple: SVG champagne integrado, separación derecha 16px y reserva de texto 48px mediante tokens. Estados nativos conservados; sin simular apertura con focus ni rotación |
| Media auténtica, verificación externa y moderación | CONTENIDO / BACKEND FUTURO. Sin integración, publicación, almacenamiento, permisos ficticios ni acciones de administración |

Se consultaron dirección visual, UX/UI, Core, estándares, reglas y contratos existentes; también el comportamiento del carrusel audiovisual legacy de Home como referencia. No se copia su implementación. Sin cambios a VISUAL-DIRECTION ni nuevas decisiones visuales atribuidas al usuario.

### Contrato de los carruseles

Corrección vigente de Home (2026-10-23): Hero editorial compartido entre Patterns, Navigation y Home mediante hero-editorial-wave-1.php, con superposición, tipo, espaciados y botones Wave 1. Home retira el pseudo-elemento radial del copy; el ajuste posterior autorizado oscurece el media completo con base cálida del 14% y refuerzo suave más concentrado vertical/lateral, sin alterar Wave 1 global. Contraste fotográfico muestreado: título 4,98:1, descripción 5,48:1 y eyebrow 4,59:1 mínimos; diseño considerado satisfactorio por el usuario en la entrega final, pendiente de revisión de integración hacia develop. Se eliminan las acciones añadidas al drawer; Cart/Account conservan los controles originales, bloqueados por el overlay mientras el drawer está abierto. Sin nueva composición, panel sustituto, flechas o librerías. El pulido de motion conserva encuadres: foto 720ms, relato 520ms/8px y sin movimiento con reduced motion. Autoplay separa causas temporales de pausa intencional; pruebas de 16 transiciones reales e idempotencia/destrucción documentadas. Comparación con contenido idéntico preserva los píxeles de la guía a 425/1440. Evidencia, excepciones y límites en HOME-HEADER-HERO-REWORK.md.

- `inicializarCarrusel(contenedor)` recibe un HTMLElement explícito, valida pista/controles y es idempotente mediante WeakMap. Markup: raíz `data-cl-carrusel`, lista `data-cl-carrusel-pista` con ID único y elementos directos, controles con `anterior`, `siguiente` y `posicion` bajo el prefijo `data-cl-carrusel-*`. Los botones nativos tienen nombres accesibles y `aria-controls`. No hay framework ni dependencias nuevas.
- CSS Grid + Scroll Snap conserva scroll nativo, texto íntegro, wrap de palabras y alturas naturales. Una columna parcial móvil invita a explorar; dos columnas en tablet; tres de texto/dos audiovisuales en desktop. Las alturas pueden variar según contenido; no se recortan reseñas para igualarlas. No autoplay ni transforms para mover tarjetas.
- Anterior/siguiente y Left/Right/Home/End calculan posiciones desde geometría real y limitan el desplazamiento. Las teclas solo se capturan con foco en la pista; no interfieren con radios, selects o reproductores. Los extremos se deshabilitan y la posición cuenta elementos realmente visibles, incluidos parciales. No es una región live: evita anuncios en cada frame de scroll.
- Si se deshabilita el botón enfocado en un extremo, el foco pasa a la pista; el resto de movimientos lo conserva. Un control dentro de una tarjeta fuera de vista la desplaza a una posición accesible al recibir foco. No hay contenido ocultado a lectores mediante aria-hidden ni paradas artificiales en cada tarjeta.
- Una entrada no tiene controles y no añade una parada en la pista; cero entradas muestra Core Empty sin valoración o navegación. Sin JS, listas y scroll permanecen; controles ocultos desde PHP. La alternativa sin JS se comprobó estructuralmente en el HTML inicial, no mediante un navegador con scripting desactivado.
- La API devuelve `destruir()`: aborta listeners, desconecta ResizeObserver y emite `cl:carrusel-destruir`; invocarla antes de retirar el componente. Eventos locales `cl:carrusel-cambio` (rango visible) y `cl:carrusel-navegar` permiten pausar media sin mezclar reproducción con navegación. La colección se proporciona al inicializar: para sustituir sus registros, destruir y reinicializar. No se implementan mutaciones/paginación remota.
- Solo `style-guide.js` inicializa los dos módulos durante esta wave. `main.js` productivo no incorpora carruseles; las páginas reales decidirán su inicialización cuando los utilicen.

### Media, fuentes y moderación

`inicializarMediaCarrusel(contenedor)` es un adaptador idempotente de video nativo. Escucha play para pausar los demás videos de esa colección; pausa al navegar/cambiar el rango, al salir del viewport, al ocultarse el documento y al destruirse. La integración debe llamar `destruir()` antes de desmontar. No carga fuentes, reproduce automáticamente ni sustituye controles nativos.

Activación futura: video autorizado con `controls playsinline preload="none"`, dimensiones/orientación originales, poster que corresponda al film, autor/fuente/fecha verificables cuando existan, subtítulos WebVTT revisados (`track kind="captions"`, idioma y etiqueta) y transcripción/alternativa visual fuera del reproductor. La URL, permisos de persona/media/reproducción externa y vigencia deben validarse antes de servir source/poster/track. No hay archivos de video activos, posters genéricos, Play vacío ni nuevas descargas de media. **Play/pausa, exclusividad, subtítulos y fallos reales de decodificación no están probados: falta un film aprobado y funcional.** El contrato inerte y estados de disponibilidad no se presentan como reproducción probada.

Flujo futuro: cliente envía → pendiente → administración aprueba/rechaza → servidor entrega solo contenido publicable. Listado y carrusel deben recibir exclusivamente la revisión aprobada/publicada y media permitida. No enviar texto privado/rechazado/retirado al DOM para ocultarlo con CSS o JS; una edición pendiente no reemplaza automáticamente una versión aprobada. El cliente nunca autoriza publicación. Lifecycle conserva su separación entre moderación interna, publicación y visibilidad.

Se conservan los contratos de ID/autor/fuente/referencia externa/puntuación/texto/fecha/estados/respuesta/permisos/URL/media de la matriz original. PHP futuro podrá proporcionar selección editorial o registros paginados con total, cursor/página, filtro y orden efectivos. Google/Facebook siguen como formatos de procedencia sin autores, ratings, logos o URLs originales inventadas; solo se reproducirá material permitido y comprobado, sin promedios combinados.

### QA ejecutado y límites

| Verificación actual | Resultado |
|---|---|
| `npm run lint`, `npm run build` | PASS completos; sin dependencias/tooling nuevos. El build excluye JS/CSS exclusivos de guía |
| `php -l`, `git diff --check` | PASS en los siete partials Wave 5 y diff |
| HTML renderizado / recursos | PASS estructural HTMLParser/lxml: cierres equilibrados, 251 IDs únicos, un h1, ARIA/anclas resueltas, grupos de rating y cuatro colecciones correctos. 51 recursos locales HTTP 200; símbolos SVG resueltos. No certificación Nu/W3C ni HAR completo |
| Responsive | PASS de geometría en 320, 360, 390, 425, 768, 820, 992, 1024, 1280 y 1440px: sin overflow de página ni texto de tarjeta. Capturas revisadas en 390/768/1280. Scroll horizontal intencional confinado a pistas; texto largo sin truncamiento, con/sin avatar/fecha y respuesta |
| Estrés / poca altura | PASS: procedencia temporal extensa con palabra sin espacios en 320/390/768/1280/1440, restaurada después; sin overflow. Viewport 390×360: controles accesibles, navegación efectiva; targets de 44×44 |
| Carruseles | PASS en navegador: botones, Home/End y flechas locales, scroll real, snap calculado, extremos, contador, foco tras deshabilitar botón, entrada única/vacía, acceso al disclosure de tarjeta audiovisual inicialmente fuera de vista. Sin animación automática |
| Selects | PASS renderizado Core y Waves 2–5: inset 16px/reserva 48px. Activo, hover/foco visible, error, disabled, opción larga y cambio nativo por teclado; disabled omitido al tabular. Sin microinteracción de apertura: el navegador no ofrece un estado interoperable fiable. Forced colors conserva flecha nativa por CSS; pendiente prueba en ese modo |
| Formulario aprobado | PASS: valores 1–5 con 1–5 rellenos visibles, flechas nativas, texto de valor, reset, campos incompletos, texto de 1.001 caracteres, loading, éxito simulado, edición a Draft updated, error con entradas retenidas. Ninguna publicación/persistencia |
| Listing / reputación | PASS: cuatro órdenes con fecha ausente al final en órdenes de fecha, filtro sin resultados, Show more y foco al título revelado, reset, carga, error/retry y contador coherente. Resumen conserva promedio 3.2/5 y seis datos ficticios de una sola fuente |
| Regresiones | PASS: Quantity incrementa; Core modal abre/cierra; accordion abre por teclado; visor Wave 3 abre, Escape cierra y devuelve foco al activador una vez completada su transición. Validación de las cuatro demos comerciales y cambio de estado de membresía ejecutados. No se declara una nueva prueba exhaustiva de todos sus flujos |
| Contraste / consola | PASS calculado sobre 81 textos renderizados de Reviews/carruseles: mínimo 9.7:1. Consola sin errores/warnings en la sesión y fotografías activas cargadas; imágenes inertes de visores sin src no son fallos |
| Pendiente de dispositivo/modo | Swipe táctil físico, zoom real 200%, lector de pantalla, forced colors y Safari/Firefox no ejecutados. Reduced motion inspeccionado en la rama matchMedia que elimina scroll suave; no emulado. Capturas del navegador presentan suavizado, por lo que no certifican nitidez tipográfica final |

Evidencia local fuera del repo: `C:/Users/Mike/.codex/visualizations/2026/10/16/01a146a9-6634-73b2-b882-7a42ccd1f604/final-2026-10-19/` (capturas, responsive, estrés de metadatos, rating, contraste, HTML/HTTP y mediciones). Skill utilizada: `.agents/skills/qa-visual/SKILL.md`. Los límites anteriores se distinguen de los checks ejecutados, sin extrapolar build a aprobación visual.

### Performance y revisión

Mismo pipeline de producto y esbuild en memoria para guía, gzip Node nivel 6, sin sourcemaps:

| Artefacto | Bytes antes → después | Gzip antes → después | Delta gzip |
|---|---:|---:|---:|
| CSS producto | 82271 → 84671 | 14268 → 14899 | +631 (+4.42%) |
| JS producto | 0 → 0 | 20 → 20 | 0 (cabecera gzip vacía) |
| JS guía DEV | 95514 → 102269 | 22057 → 23668 | +1611 (+7.30%) |
| JS guía minificado, medición | 51377 → 55087 | 16318 → 17554 | +1236 (+7.57%) |

Sin nuevos recursos fotográficos, videos, fuentes, iconos o dependencias. SVG de select inline sin request; 51 URLs locales de assets antes/después. Doce archivos del repo: entrada JS de guía, dos módulos nuevos, cuatro SCSS (incluido el único ajuste Core autorizado), cuatro PHP (dos nuevos) y esta biblioteca. Producción, legacy, backend, assets originales y fuentes de Waves 1–4 intactos.

Watcher `npm run dev` activo. Revisar `/style-guide/patterns.php#reviews`, `#reviews-carousel`, `#video-testimonials`, `#select-states`, `#review-listing`, `#write-review` y Core en `/style-guide/` desde `http://localhost:3000`. Los estados único/vacío y select están en disclosures compactos. Cobertura frontend cerrada sin variantes redundantes; pendientes contenido/URL/permisos auténticos, validación audiovisual real, modos/dispositivos indicados y aprobación visual de estos nuevos cambios.

## Refinamiento Wave 5 — 2026-10-18 — QA renderizado pendiente

Rama `feature/ui-section-patterns-wave-5`, base de esta pasada `1ed29dbc7e4a99537bef3df24775e8fbcc845602`. Preflight: rama correcta, árbol limpio, fetch ejecutado y divergencia 0/0 con origin; Wave 5 y su base intactas. Sin nueva rama ni cambios a develop/main. Este apartado describe el refinamiento vigente; las verificaciones del 16 de octubre que siguen son históricas y no certifican estos cambios. **WAVE 5 NOT READY: falta QA visual/funcional actual en navegador.**

### Auditoría previa y decisiones

Se revisaron AGENTS, VISUAL-DIRECTION, UX/UI, Core, estándares, arquitectura, esta biblioteca, los cuatro SCSS, el módulo JS, los cinco PHP y los contratos reales Foundation/Waves 1–4. Las capturas locales del 16 de octubre se consultaron como referencia de la misma base sin cambios, no como render actual del refinamiento.

| Observación | Clasificación y evidencia | Decisión |
|---|---|---|
| Selector con estrella rellena y número iguales en cinco opciones | Mejora UX/UI justificada: markup/CSS y captura de la base; la selección no se expresa de forma progresiva | Conservar radios y sustituir presentación por cinco estrellas vacías/rellenas progresivamente, valor numérico textual y foco de teclado |
| Metadatos de reseña en una sola línea de texto | Mejora UX/UI justificada: fuente/fecha/verificación concatenadas, sin elementos independientes | Separar una lista semántica con wrap; autor y puntuación conservados, texto antes del contexto, fecha legible y respuesta independiente |
| Destacado con firma genérica | Mejora UX/UI justificada: figcaption original no tenía espacios individuales para autor/fuente/fecha/valoración | Mantener foto/cita/CTA y columnas; autor y contexto como placeholders explícitos, fecha/valoración opcionales sin fabricar cifras |
| Procedencias Google/Facebook | Pendiente de contenido real; mejora de su muestra frontend justificada | Reubicar las tres muestras existentes junto a Reviews, usando los mismos metadatos. Sin copiar reseñas, estrellas, logos o enlaces falsos |
| Éxito anterior permanece tras editar | Defecto confirmado en flujo de código: input actualizaba contador/validación y change solo validación; ninguno invalidaba el resultado anterior | Un aviso Draft updated al volver a editar puntuación/texto/aviso después de éxito o fallo; no repetirlo por pulsación |
| Orden, fechas ausentes, Show more y foco | Comportamiento ya correcto por inspección; comparadores ejecutados como funciones aisladas | No reescribir. Mantener foco en filtro/orden, y título de primera entrada revelada al desaparecer Show more. El contador deriva el total de entradas, sin literal 6 |
| Vacío/loading/error/retry, reputación, video y lifecycle | Responsabilidad ya correctamente representada en el código; prueba interactiva actual pendiente | Conservar estados. Solo corregir singular accesible «1 star». Sin cambiar promedio, distribución, media o reglas de moderación |
| Paginación, verificación externa, autoría y publicación | Funcionalidad futura | Conservar contratos conceptuales; sin API, almacenamiento ni panel administrativo |

No se declara reproducción en navegador de estas observaciones: el acceso fue rechazado antes de observar la página. Los cambios de presentación se basan en código y capturas históricas de la base; la autoevaluación del render nuevo sigue pendiente. No se modifican tokens ni VISUAL-DIRECTION, ni se atribuye una aprobación estética nueva.

### Resultado y contratos conservados

- `cl-resena` y `--compacta` conservan superficie, radio md, avatar opcional, autor, puntuación textual, cuerpo completo y respuesta. `cl-resena__meta` ahora es una lista de fuente, fecha opcional y verificación que envuelve cada dato por separado; `__fuente` aporta énfasis textual sin badge. La fecha usa `time` ISO y etiqueta legible. Sin fecha no aparece un valor sustituto.
- Los tres formatos de procedencia están en `#review-sources`, dentro del disclosure de contexto. Internal, Google y Facebook llevan nombres legibles, estado de fecha/URL pendientes y contexto de permisos; no contienen citas ni ratings. Solo se añadirá un enlace original al validar una URL auténtica y su uso permitido.
- `cl-testimonio` mantiene la composición editorial y fotografía ambiental existente. La firma presenta nombre autorizado pendiente, fuente pendiente, fecha opcional y valoración no proporcionada, todos explícitamente placeholders. No hay estrellas sin datos. Una integración real omitirá los datos opcionales ausentes y conservará autoría/permisos comprobados.
- El formulario mantiene cinco radios nativos, un nombre/grupo, required, flechas/Space del navegador y labels accesibles 1–5. CSS `:has(:checked)` rellena la estrella elegida y anteriores; hover solo destaca el target, sin cambiar la puntuación. `:has(:focus-visible)` dibuja foco de teclado. Mínimos CSS de 2.75rem, gap existente y wrap; pendientes medidas renderizadas. La cifra visible «N out of 5 stars selected» complementa forma/color; es texto normal, sin otra región live que duplique el anuncio del radio. Sin JS se oculta ese texto dinámico para evitar un valor obsoleto; radios/selección CSS y nombres nativos permanecen.
- Tras terminar una simulación, la primera edición vuelve al borrador con Core Alert informativa. Las siguientes pulsaciones no recrean el aviso; un nuevo resultado de simulación permite otro aviso al volver a editar. Espera, bloqueo, validación, conservación tras fallo, éxito inequívoco sin publicación y reset permanecen. Reset limpia el valor textual además del contador/errores. No hay requests ni persistencia.
- El listado conserva filtros, cuatro órdenes, contador `role=status` atómico, Show more, vacío, loading/error y recuperación. Los controles de filtro/orden no reciben un traslado automático de foco. El título revelado por Show more recibe `tabindex=-1`, sin añadir una parada permanente de Tab. Sin JS, seis entradas completas y controles demo deshabilitados en el HTML. Estos son contratos/código inspeccionados, no pruebas actuales de teclado/lector de pantalla.
- PHP futuro podrá proporcionar registros paginados, total autoritativo, página/cursor y filtro/orden efectivos. La demo opera sobre una colección local completa; su contador de DOM no es el total global de una colección paginada. El adaptador futuro deberá resolver filtro/orden de toda la colección en servidor cuando corresponda. Sin diseñar ahora un protocolo o paginador.
- Reputación conserva 3.2/5 y distribución 1/2/1/1/1 sobre seis datos ficticios internos; nunca mezcla plataformas ni muestra ausencia como cero. Video conserva contrato nativo inerte, horizontal/vertical, error y alternativa externa: sin film nuevo, autoplay, poster falso ni permisos supuestos. Lifecycle conserva moderación interna, publicación, cuerpo público/retirado y revisión pendiente separados; ningún texto rechazado/retirado entra en la colección.

### QA actual y límites

Skill aplicada: `.agents/skills/qa-visual/SKILL.md`. El navegador integrado rechazó la adquisición de acceso a la URL local por su política interna, antes de observar contenido, pese al protocolo HTTP solicitado. La autorización del usuario para trabajar en local está confirmada. No se cambió de origen, navegador, motor de renderizado ni canal para eludir el rechazo. Las comprobaciones de código/HTML/HTTP siguientes no son sustitutos de navegador.

| Comprobación ejecutada | Resultado |
|---|---|
| npm run lint / npm run build | PASS: ESLint/Stylelint y build completos; sin cambiar reglas, dependencias o tooling |
| php -l / git diff --check | PASS: los 25 PHP de guía y diff; se repiten los PHP tocados tras el último ajuste de copy |
| HTML generado localmente | PASS estructural HTMLParser/lxml: cierres equilibrados, un h1, 238 IDs únicos, ARIA/anclas resueltas; no certificación Nu/W3C |
| Radios y alternativa sin JS | PASS estructural: valores 1/2/3/4/5, un nombre/fieldset, cinco labels y required, seis entradas sin hidden; acciones/selects deshabilitados en HTML inicial. No se declara recorrido real de teclado ni navegador sin JS |
| Funciones de puntuación/borrador | PASS aislado Node: seis etiquetas (vacío y 1–5), cambio a borrador una sola vez, sin aviso durante espera o edición inicial; bindings revisados. Sin DOM ni simulador de navegador |
| Cuatro comparadores reales | PASS aislado sobre los seis datos PHP: newest/oldest dejan fecha ausente al final; highest/lowest correctos. No demuestra UI de filtros, Show more o recuperación |
| Procedencia, featured y video | PASS estructural: tres muestras sin cita/rating/enlace, metadatos explícitos del destacado y cero videos activos |
| Recursos | PASS HTTP: 51 recursos locales responden 200 y usos SVG resueltos. No es Network/HAR de navegador ni decodificación visual |
| Contraste / reduced motion | PASS matemático de 12 pares de tokens compilados, mínimo 8.65:1; selectores progresivos/foco y regla reduce presentes. No se declara contraste renderizado, hover o emulación del SO |
| npm run dev | PASS: PHP/BrowserSync/watch en localhost:3000, con aviso Node DEP0060 preexistente |
| Diez anchos: 320/360/390/425/768/820/992/1024/1280/1440 | PENDIENTE: nuevas capturas, medidas de overflow, metadatos/texto sin espacios, targets y proporción tablet/desktop |
| Teclado/foco/lector, selección 1–5, formulario y estados | PENDIENTE en navegador: no se extrapolan pruebas del 16 de octubre. Zoom real 200%, viewport corto y anuncios también pendientes |
| Regresiones Core/Waves 1–4 y consola | Fuentes intactas y build correcto; PENDIENTE ejecución actual de modal/galería, Quantity, Accordion y demos comerciales, consola y Network |

Evidencia local fuera del repo: `C:/Users/Mike/.codex/visualizations/2026/10/16/01a146a9-6634-73b2-b882-7a42ccd1f604/refinement-2026-10-18/`, con `before.json`, `after.json`, `logic-checks.json`, `html-checks.json`, `token-contrast.json` y HTML. No hay capturas nuevas ni se presentan las históricas como evidencia del refinamiento.

### Performance, cobertura y entrega

Mismo pipeline y Node gzip nivel 6; guía medida en memoria con esbuild, sin sourcemaps. El build no deja CSS/JS de guía; main.js fuente y output productivo permanecen idénticos.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Cambio gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 81515 | 82271 | 14161 | 14268 | +107 (+0.76%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |
| JS guía DEV | 94499 | 95514 | 21843 | 22057 | +214 (+0.98%) |
| JS guía minificado, medición | 50905 | 51377 | 16191 | 16318 | +127 (+0.78%) |

Nueve archivos modificados: tres SCSS (`_resena`, `_testimonio`, `_resena-formulario`), `modules/guia/resenas.js`, cuatro PHP (`reputacion-wave-5`, `resenas-testimonios-wave-5`, `escribir-resena-wave-5`, `resumen-listado-wave-5`) y esta biblioteca. Sin nuevos archivos del repo, componentes, fotos, videos, iconos, fuentes o dependencias. `_reputacion.scss`, lifecycle, Foundation/Core/Waves 1–4, entradas, producción, legacy, backend/BD, Booking-app-php y hosting intactos.

La matriz original conserva sus siete familias y contratos futuros: reseñas internas, procedencias externas verificadas, destacado autorizado, video autorizado, reputación por fuente, listado, formulario y estados de moderación tienen estructura frontend. El refinamiento resuelve las carencias de presentación/borrador detectadas sin ampliar backend ni variantes redundantes. **Cobertura de código cerrada; aceptación visual/funcional actual abierta.**

Revisión local: `http://localhost:3000/style-guide/patterns.php#wave-5`, `#reviews`, `#review-sources`, `#featured-testimonials`, `#write-review`, `#review-listing`, `#reputation`; Core en `/style-guide/`. Abrir el disclosure de procedencia; recorrer puntuación 1→5 con flechas/Space, enviar, editar puntuación/texto y comprobar Draft updated, forzar fallo y recuperar, resetear. Probar cuatro órdenes, filtro sin resultados, Show more, retry y fechas ausentes; repetir diez anchos, texto largo/metadatos extensos, poca altura, zoom real 200% y regresiones. Sin PR, merge, force push ni deploy. Contenido auténtico, permisos, verificación y backend siguen pendientes independientes del QA bloqueado.

## Wave 5 — Reviews, Testimonials & Reputation — 2026-10-16

Rama `feature/ui-section-patterns-wave-5`, base `develop@9e6d0b475f6f663ea65fc05f6af4bdac44a5851f`. Preflight limpio: fetch, switch develop y fast-forward ejecutados; Wave 4 verificada como ancestro e integrada por merge #10. Sin PR, merge ni deploy de esta feature. Dirección visual existente conservada, sin decisiones nuevas atribuidas al usuario. **Aprobación visual humana pendiente.**

### Auditoría inicial y final de cobertura

Se consultaron AGENTS, dirección visual, UX/UI, Core, esta biblioteca, arquitectura, estándares, mapa de producto, Git workflow y reglas SCSS/JS/PHP. Se inspeccionaron módulos Core, galería/media Wave 3, formularios/estados Wave 4 y testimonios de `index.html`. El legacy usa un carrusel de videos de clientes; su presencia no demuestra permisos, subtítulos ni derecho a reproducir opiniones. Las URLs legacy de Google Maps y Facebook identifican ubicación/perfil, no una reseña original validada. No se copian cifras, citas, identidades ni ese carrusel.

| Necesidad inicial | Clasificación | Cierre frontend |
|---|---|---|
| Grid, secciones, acciones, campos, alerts, estados, skeleton y carga | REUTILIZAR Foundation/Core y Waves 1–4 | Sin cambios a sus fuentes; misma entrada de guía |
| Reseña, puntuación y respuesta opcional | CREAR `cl-resena` / `cl-valoracion` | Normal, compacta, composición editorial, corta/larga, avatar abstracto opcional, sin fecha, información parcial y no disponible |
| Testimonio destacado | CREAR `cl-testimonio`, REUTILIZAR fotografía/helper Wave 3 | Composición editorial asimétrica; placeholder rotulado, sin puntuación ni autor inventado |
| Video horizontal/vertical, error, alternativa | REUTILIZAR `cl-media-video` / Core | Estados honestos de contenido pendiente; contrato nativo inerte, sin play ficticio |
| Resumen de reputación y distribución | CREAR `cl-reputacion`, REUTILIZAR estados Core | Una única fuente ficticia; promedio/distribución consistentes con el listado |
| Listado, filtro, orden y revelado incremental | EXTENDER composición `cl-catalogo` con `cl-resenas-lista` | Seis registros locales; filtro real, orden real, tres entradas iniciales y tres adicionales |
| Escribir reseña | EXTENDER controles nativos/Core con `cl-resena-formulario` | Radios, contador, validación, espera, fallo/recuperación, éxito simulado y reset |
| Moderación y visibilidad | REUTILIZAR `cl-estado` | Seis referencias estáticas; sin acciones de moderador ni contenido privado |
| Autoría, permisos, origen verificado, publicación y edición | BACKEND FUTURO | Contratos de UI descritos abajo; sin endpoints, BD, cuentas o almacenamiento |
| Google/Facebook | BACKEND FUTURO para integración; frontend cubierto | Procedencias diferenciadas sin rating, logos, badges ni reseñas externas ficticias |
| Panel de administración, scraping, pagos y reservas | FUERA DE ALCANCE | No implementados |

No se duplican cards, modales, galerías, sistemas de validación genéricos ni reproductores. Cuatro SCSS resuelven responsabilidades visuales diferentes; los estados secundarios viven en disclosures compactos. El helper PHP es exclusivo de la guía, no un motor de plantillas. El CSS compartido puede reutilizarse en páginas futuras con markup y datos de servidor escapados.

### Componentes, variantes y estados

| Familia | Variantes/estados | Interacción / datos |
|---|---|---|
| Reviews | `cl-resena`, `--compacta`; editorial en columna dominante; texto completo, corto, largo, sin avatar, sin fecha y respuesta | Una única estructura; sin truncar ni fijar altura. Avatar D1 abstracto, nunca foto de cliente. Puntuación textual 1–5, estrellas decorativas aria-hidden. Parcial sin estrellas; no disponible sin cuerpo privado |
| Featured Testimonials | Foto de mesa real, cita protagonista, firma/contexto y CTA | Copy de estructura explícitamente placeholder; no es testimonio. Autor, fuente, fecha y permiso pendientes. Rejilla lateral desde md, offset desde lg |
| Video Testimonials | Horizontal 16:9, vertical 478:850, pendiente, no disponible y error estático | Fotografía de archivo identificada como imagen, no poster de cliente. Sin video activo ni MP4/track con URL inventada. Transcripción pendiente rotulada fuera del contrato del reproductor |
| Reputation | Promedio 3.2/5, seis reseñas ficticias; distribución 5→1: 1/2/1/1/1 | Calculado en PHP sobre la misma colección. Fecha de snapshot ficticio explícita. No se mezcla con Google/Facebook; sin premios ni ranking |
| Estados de reputación | Sin datos, incompletos, fuente no disponible, loading estático y error | Selector de laboratorio cambia una sola vista; error/fuente permiten retry local a sin datos, sin fingir consulta a una plataforma |
| Review Listing | Encabezado, contador, grid, filtro 1–5, sin puntuación/vacío, orden, loading, error | Filtra seis registros renderizados; newest/oldest dejan fechas ausentes al final; highest/lowest ordenan realmente. Reset restaura selección y límite. Show more revela hasta seis y enfoca el primer título nuevo |
| Write a Review | Sin puntuación/seleccionada, hover/foco, incompleto, demasiado largo, espera, fallo y éxito/pendiente | Radios 1–5 nativos con leyenda y nombre; teclado con flechas. Texto 20–1.000 puntos de código tras trim; sin maxlength para conservar y corregir texto largo. Contador, ayuda y errores asociados |
| Lifecycle | Pending review, Published, Rejected, Reported, Hidden/removed, Edited | `cl-estado` con texto; moderación interna y visibilidad pública separadas. No son controles, no alteran el listado |

Todos los registros tienen nombres `Demo entry NN`, texto ficticio inequívoco, origen interno ficticio y `Not verified`. Las fechas son datos de ejemplo, no visitas confirmadas. La variante sin fecha omite el dato; no muestra una fecha actual sustitutoria. No existe una variante Verified sin evidencia.

El formulario se conecta solo con JS de guía. El botón está disabled sin JS y no hay endpoint. Espera local 1.2s; Core bloquea duplicados y mantiene foco, y los campos/reset/outcome quedan bloqueados. Fallo conserva puntuación/texto/aviso; éxito explica **no enviado, guardado ni publicado**, con estado conceptual Pending moderation. No se añade la entrada al listado. Reset limpia errores, contador y feedback, devolviendo foco al primer radio. El aviso obligatorio reconoce la demo; no representa aceptación de una política legal ni permiso de publicación. No se solicita identidad ni media.

Sin JS, las seis reseñas siguen legibles; filtros y acciones de demo permanecen deshabilitados. Los controles de prueba están identificados como Demo controls, separados del contenido público futuro. Los ejemplos de carga del listado/resumen son estáticos y lo dicen; solo el envío ejecuta una espera local real.

### Contratos conceptuales para PHP/MySQL futuro

No son un esquema SQL ni una API definitiva. El adaptador futuro debe entregar valores ya validados y escapar strings al renderizar; no debe enviar registros privados al DOM para ocultarlos después con CSS/JS.

| Campo conceptual | Responsabilidad de la interfaz y del servidor futuro |
|---|---|
| `id`, `idAutor` | Identificadores estables; autoría y relación con usuario comprobadas en servidor, no por el nombre mostrado |
| `fuente`, `idReferenciaExterna?`, `urlOriginal?` | Interna/Google/Facebook explícitas; referencia y enlace original comprobables, URL segura y procedencia conservada. Enlace Core contextual solo cuando exista y se verifique |
| `puntuacion?`, `escalaOrigen` | Entero 1–5 para reseñas internas. No transformar recomendaciones Facebook en estrellas ni normalizar plataformas sin una política aprobada |
| `texto`, `fecha?`, `editadaEn?` | Texto plano y fechas reales; omitir información ausente. Límite frontend ilustrativo; servidor valida longitud/normalización y determina política final |
| `estadoModeracion`, `estadoPublicacion` | Decisiones separadas. Pendiente/rechazada/oculta/retirada no publica el cuerpo. Reported es una señal interna, no aprobación o retirada automática |
| `respuestaNegocio?` | Texto, autor empresarial autorizado, fecha y estado de publicación independientes; no fabricar una respuesta |
| `verificacion?`, `permisoReproduccion?` | Método/fuente/evidencia auditables antes de mostrar una insignia o reproducir una opinión externa. Ser usuario registrado no equivale a compra/visita verificada ni publicación automática |
| `consentimientoMedia?`, `video?`, `poster?`, `subtitulos?`, `alternativaTextual?` | Permiso documentado con alcance/referencia, autorización de personas/audio y archivos revisados. La retirada del permiso debe impedir futuras publicaciones de esa media |
| Resumen y colección | Por fuente: promedio, total, distribución, fecha/período y enlace original; colección y siguiente página/cursor autoritativos del servidor. No agregar plataformas automáticamente |

Una edición no sustituye automáticamente la versión aprobada; mostrar solo revisión permitida y etiqueta Edited cuando corresponda. El backend deberá validar autoría, relaciones, permisos, puntuación, contenido, moderación y visibilidad; definir prevención de abuso, CSRF/autorización y política de publicación al implementar el servicio. Nada de ello se simula como operación real en esta wave.

Para Google y Facebook quedan pendientes condiciones de uso vigentes, permisos de reproducción, modelo nativo, autor mostrado permitido, fecha, ID/enlace original y política de actualización/retirada. Los rótulos de fuente de la guía no implican acceso API ni verificación externa. No hay scraping, conectores ni logos nuevos.

Antes de activar el contrato `<video>`: revisar clip completo/audio y autorización, añadir source/poster correspondientes, dimensiones originales, `<track kind="captions" srclang="en" label="English">` con VTT revisado cuando corresponda y transcripción/alternativa visual adyacente. Usar `controls playsinline preload="none"`, sin autoplay. Reproducción, pausa y subtítulos serán nativos. El error debe conservar alternativa/recuperación fuera del video; probar codecs, teclado, captions y fallo real al conectar material apto. La presencia de MP4 legacy no acredita esta preparación.

### Responsive, accesibilidad y QA ejecutado

Skill aplicada: `.agents/skills/qa-visual/SKILL.md`. Navegador Chromium integrado, URL `http://localhost:3000/style-guide/patterns.php#wave-5`. La primera apertura ocurrió antes de iniciar PHP y devolvió connection refused; al iniciar `npm run dev`, la misma URL quedó accesible. El intento de seleccionar aquella pestaña de error data: fue rechazado por política; no se accedió a ese documento. No hubo bloqueo de la URL local activa ni cambio de origen para eludir una restricción.

| Prueba actual | Resultado |
|---|---|
| npm run lint / npm run build | PASS finales: ESLint/Stylelint y build; sin modificar configuración/reglas/dependencias |
| php -l | PASS: los 25 PHP de Style Guide, incluidos patterns.php y cinco partials Wave 5 |
| HTML renderizado | PASS estructural: HTMLParser/lxml, pila equilibrada, un h1, 237 IDs únicos, anclas/ARIA resueltas. No es certificación Nu/W3C |
| Recursos locales / iconos | PASS: 51 URLs de assets HTTP 200, todos los símbolos SVG usados existen; fotografías Wave 5 cargadas. Son comprobaciones HTTP/DOM, no un HAR de Network |
| 320/360/390/425/768/820/992/1024/1280/1440 | PASS geometría final con disclosures abiertos y seis entradas: sin overflow; selector 44×44px por opción en los diez anchos. Composiciones revisadas en móvil/tablet/desktop |
| Texto largo / información ausente | PASS: palabra extensa, texto completo, respuesta, sin avatar/fecha y seis entradas; no se recorta contenido ni se fuerza altura uniforme |
| Selector / teclado / foco | PASS: Space/flecha derecha seleccionan 1→2; foco champagne 2px/offset 3px en label, errores llevan al primer control inválido y reset vuelve al primer radio |
| Formulario | PASS: incompleto, 1.001 caracteres retenidos/rechazados, espera aria-busy, bloqueo de edición, fallo conservando texto, éxito explícito sin publicación y reset con contador 0. Se corrigió el orden del contador durante reset |
| Listado | PASS: filtro 4→dos entradas; sin puntuación→vacío; reset; lowest + Show more→1/2/3/4/4/5; contador coherente y foco al primer título revelado; loading/error/retry con filtros conservados |
| Reputación | PASS: cinco estados compactos, skeleton solo en loading, retry sin cifras inventadas. Distribución y promedio derivados de los seis ejemplos |
| Contraste | PASS: 179 textos/combinaciones medidos, mínimo 9.69:1, ningún fallo del umbral correspondiente; texto fuera de las fotos. Disabled excluido de requisitos de contraste |
| Viewport corto | PASS geométrico a 320×480; scroll natural y controles accesibles, sin overlay propio que atrape contenido |
| Reduced motion | PASS en CSS compilado: regla reduce global conservada, sin animación nueva ni carrusel. No se declara emulación de preferencia del SO |
| Consola | PASS en las vistas observadas: sin errores/warnings de página. BrowserSync emite DEP0060 de Node preexistente; no falla dev |
| Regresión modal/galería | PASS: Core abre con teclado, ocho Tab permanecen dentro, Escape cierra; galería abre, cambia 1→2, Escape devuelve foco al enlace original |
| Regresión Quantity/Accordion/Toast | PASS: Quantity 1→2 y entrada real por teclado 99→2 restaurada; Accordion Enter/Space; notificación de pedido anunciada en región Core |
| Regresión Wave 4 | PASS: Gold selección/resumen y éxito demo, Gift Card 100 y éxito demo, selección de evento y acción de preview; inquiry inválida marca cinco campos y válida completa la demo. No se certifica toda la matriz comercial histórica |
| Protección de alcance | PASS: solo diez fuentes nuevas de Wave 5, tres entradas de integración y esta documentación. Sin páginas/legacy/backend/BD/Booking-app-php/hosting/assets originales/dependencias/Core/Waves anteriores modificados |

Autoevaluación visual: se retiró height:100% de reseñas para evitar superficies vacías; la composición destacada pasa a columnas desde md para controlar el tamaño de la fotografía en tablet. Se revisaron fuente champagne/Libre Bodoni, jerarquía, radios md, densidad, encuadres y contraste. No constituye aprobación estética del usuario.

Evidencia fuera del repo: `C:/Users/Mike/.codex/visualizations/2026/10/16/01a146a9-6634-73b2-b882-7a42ccd1f604/`: `final-*`, `wave5-responsive-final.json`, `wave5-contrast.json`, `wave5-html-assets.json` y mediciones before/after. Las capturas preliminares con prefijo `wave5-` de familias tomadas durante scroll/restauración no acreditan composición final; se usan las `final-*` revisadas. No se declara zoom real 200%: la API disponible no ofrece control documentado de zoom. Pendientes lector de pantalla auditivo, Firefox/Safari, dispositivos físicos y hosting Apache/GoDaddy. Video play/pausa/captions reales no aplican a un contrato inerte; deberán probarse con material autorizado.

### Performance y archivos

Mismo pipeline minificado de producto; gzip Node nivel 6. Guía medida con esbuild en memoria, sin minificar/minificada, sin sourcemap. No se escriben bundles de guía en build.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Cambio gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 77387 | 81515 | 13611 | 14161 | +550 (+4.04%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |
| JS guía DEV, sin sourcemap | 85499 | 94499 | 19886 | 21843 | +1957 (+9.84%) |
| JS guía minificado, solo medición | 45555 | 50905 | 14654 | 16191 | +1537 (+10.49%) |

CSS crece por cuatro responsabilidades nuevas y sus elementos; JS crece solo por las demos de filtros/formulario/estados. Main.js fuente sigue intacto y su output vacío; build no contiene guía ni selectores cl-guia/cl-muestra. Cero nuevas dependencias, fotos, iconos, fuentes, videos o derivados. Dos instancias fotográficas adicionales reutilizan mesa/interior ya presentes; no añaden URLs de media únicas. Cero videos activos por contrato de markup. No se reportan Web Vitals productivos a partir de este laboratorio.

Nuevos: `assets/scss/patterns/_resena.scss`, `_testimonio.scss`, `_reputacion.scss`, `_resena-formulario.scss`; `assets/js/modules/guia/resenas.js`; cinco PHP: `reputacion-wave-5.php`, `resenas-testimonios-wave-5.php`, `resumen-listado-wave-5.php`, `escribir-resena-wave-5.php`, `ciclo-resenas-wave-5.php`. Modificados: `assets/scss/main.scss`, `assets/js/style-guide.js`, `style-guide/patterns.php` y este documento. Sin eliminaciones.

Revisión humana: `/style-guide/patterns.php#wave-5`, con navegación a `#reviews`, `#featured-testimonials`, `#video-testimonials`, `#reputation`, `#review-listing`, `#write-review`, `#review-lifecycle`. Core permanece en `/style-guide/`. Abrir disclosures, filtrar/ordenar, Show more y Reset; enviar sin completar, probar >1.000 caracteres, elegir Failure y recuperar a Success. Probar 390/768/1280px y zoom 200% manual. El servidor `npm run dev` ofrece recarga de PHP/JS y CSS en vivo.

Pendientes reales: aprobación visual humana, contenido auténtico con procedencia/permisos, autoría/verificación, políticas comerciales/editoriales de publicación y moderación, media autorizada/poster/captions/transcripción, fuentes externas verificadas y futura implementación PHP/MySQL. No bloquean la cobertura frontend demostrativa, pero impiden publicar esos ejemplos como reputación real.

## Cierre QA Wave 4 — 2026-10-16 — parcialmente bloqueado

Preflight de esta pasada: rama `feature/ui-section-patterns-wave-4`, HEAD `96f4d613eeb48a5d5b241b07cc8ac2ce19c74cc0`, árbol limpio; fetch correcto y divergencia con origin 0/0. Se consultaron AGENTS, dirección visual, UX/UI, Core y esta biblioteca. Skill aplicada: `.agents/skills/qa-visual/SKILL.md`. Sin rediseño, nuevas variantes, dependencias ni cambios de componentes/assets. No se encontraron defectos reproducibles en las comprobaciones ejecutables; esto no acredita ausencia de defectos visuales o interactivos.

El único intento de apertura del navegador integrado volvió a rechazar `http://localhost:3000` por permiso guardado/política administrada. No se usó otro origen, navegador, renderizador ni vía indirecta. El servidor local sí inició correctamente y queda disponible para revisión humana. Las comprobaciones de archivos/HTML y de la función pura de fecha que siguen no simulan navegación ni sustituyen las pruebas bloqueadas.

### Resultados actuales

| Verificación ejecutada | Resultado |
|---|---|
| npm run lint | PASS: ESLint y Stylelint |
| npm run build | PASS: sprite/CSS/JS productivos; sin JS/CSS de guía en build |
| php -l | PASS: patterns.php y los seis partials Wave 4 |
| git diff --check | PASS; se repite antes del commit documental |
| HTML renderizado por PHP | PASS estructural con HTMLParser/lxml: cierres válidos, pila equilibrada, IDs únicos, un h1, labels asociados, figcaption válido y anclas internas existentes. No es validación completa Nu/W3C ni prueba de accesibilidad renderizada |
| Selector de ocasión | PASS estructural: siete opciones, valores vacío/birthday/anniversary/celebration/corporate/private/dining, etiquetas correctas, required y ayuda asociada. No se declara selección por teclado probada |
| Contratos estáticos | PASS: 101 referencias ARIA resuelven; 51 usos SVG apuntan al sprite; cuatro formularios con acción inicialmente disabled y reset; 29 opciones de ciclo de vida |
| Siete WebP | PASS: decodificación completa, RGBA/WEBP, dimensiones 3137×2030, pesos esperados y hashes registrados; los siete PNG originales conservan sus hashes anteriores |
| Fecha del restaurante | PASS unitario de la función real extraída del módulo: seis instantes con Date controlada e Intl America/Los_Angeles; medianoche 2026-10-17 06:59Z→2026-10-16 / 07:00Z→2026-10-17 y ambos lados de los cambios DST de marzo/noviembre. No prueba el campo date del navegador |
| Reduced motion | PASS de presencia de regla compilada con duración .01ms; pendiente emulación y resultado visual |
| npm run dev | PASS: PHP/BrowserSync/watch en localhost:3000; sin ejecutar solicitudes desde otro cliente para eludir el bloqueo |

Evidencia nueva fuera del repo, en `C:/Users/Mike/.codex/visualizations/2026/10/16/01a14453-b06d-7011-8bb2-85fcf74ed185/`: `qa-closure-estructura-assets.py`, `qa-closure-estructura-assets.json`, `qa-closure-metrics-date.json`; además se regeneraron `refine-after.html` y `refinement-html-validation.json` desde HEAD. Este último conserva una comparación histórica before identificada como tal; solo after corresponde al HTML actual. Sin capturas nuevas ni resultados visuales reciclados.

Performance actual medida nuevamente con el mismo pipeline/gzip nivel 6: CSS **77387 bytes / 13611 gzip**, JS productivo **0 / 20 gzip**, JS guía DEV **85499 / 19886 gzip**. Son iguales a la entrega `96f4d61`: delta de esta pasada **0 bytes**. Los siete WebP siguen sumando **1497458 bytes**; 41 instancias img en Patterns. No se midieron peticiones reales, Web Vitals o CLS. Regresiones: las fuentes de Core/Waves 1–3 y producción permanecen intactas; la ejecución de Quantity, modal/galería, Accordion y feedback continúa pendiente.

| Familia | Estado real de cierre |
|---|---|
| Wine Club | Markup/slots revisados; precios y beneficios de archivo siguen advertidos, sin periodicidad vigente ni promo activa. Presentación Gold/Diamond, radios/resumen, error/éxito y FAQ requieren prueba manual |
| Gift Cards | Siete archivos decodificados e íntegros; render de frente/seis reversos, sincronía, cambio de cara, carga/error/retry, reset, teclado y transición requieren prueba manual |
| Events | Estructura/CTAs de detalles e interés y ejemplos hipotéticos conservados; agenda, disponibilidad, detalle y demo requieren prueba manual |
| Private Experiences | Selector reparado y función de fecha comprobados; campos, validación nativa/custom, foco, feedback, reset y confirmación requieren prueba manual |

### Checklist local obligatoria — pendiente, no PASS

Mantener `npm run dev`. Abrir las URLs siguientes en el navegador del usuario con DevTools Console/Network. Usar datos ficticios, sin información personal. Registrar viewport, pasos, resultado y captura real por fallo; un fallo bloqueante debe corregirse y repetirse antes de aprobación.

1. **Matriz común:** recorrer las cuatro familias en **320, 360, 390, 425, 768, 820, 992, 1024, 1280 y 1440px**, esperando la carga y el fin del desplazamiento a cada ancla. Verificar sin scroll horizontal, solapes, texto truncado, controles tapados o imágenes deformadas. Revisar especialmente comparación y formulario de regalo en tablet. Repetir a 320×480 y zoom real 200%; deben seguir accesibles acciones, avisos y feedback. Comprobar targets ≥44px.
2. **Wine Club:** `http://localhost:3000/style-guide/patterns.php#wine-club`. Enviar sin radio: error y foco en Gold. Seleccionar Gold y Diamond con flechas/Espacio; comprobar radio, contorno y resumen del nivel/precio histórico/cadencia pendiente. Diamond debe distinguirse visualmente conservando el contexto de archivo. En Demo controls elegir Failure y accionar Explore this membership: carga y bloqueo de duplicados, error y selección conservada; cambiar a Success y repetir: confirmación demo sin inscripción. Clear selection debe vaciar resumen y devolver foco. Abrir/cerrar las tres FAQ con Enter/Espacio; comprobar aria-expanded y lectura completa.
3. **Gift Cards:** `http://localhost:3000/style-guide/patterns.php#gift-cards`. Inicialmente frente oficial, sin importe y Amount side disabled. Enviar vacío: error asociado. Seleccionar sucesivamente **50/100/200/300/400/500**: cada reverso, alt, importe visible, caption y resumen deben coincidir. Cambiar rápido entre importes; nunca debe quedar un reverso antiguo junto al nuevo importe. Probar Front/Amount side y aria-pressed; editar nombre/mensaje no debe cambiar la cara elegida. Probar nombre de 60 caracteres y dedicatoria de 300 con saltos de línea, además de dedicatoria vacía: sin overflow ni interpretación de HTML. Ejecutar Failure→Success; entradas conservadas y confirmación no comercial. Clear gift debe restaurar frente, campos vacíos, resumen vacío y Amount side disabled; recargar no conserva datos.
4. **Arte ausente y recuperación:** en DevTools activar Disable cache y Request blocking para `*gift-card-reves-300.webp`; recargar y elegir $300. Deben aparecer fallback y Retry card artwork, conservando importe/dedicatoria. Desbloquear la URL y pulsar Retry: debe cargar el reverso correcto y retirar error/skeleton/aria-busy. Repetir con el frente bloqueado al recargar; los controles deben seguir disponibles. Retirar bloqueos antes del QA final; los errores de red inducidos pertenecen solo a esta prueba, no se consideran fallos de la pasada limpia.
5. **Movimiento:** emular `prefers-reduced-motion: reduce` en DevTools y cambiar importes/caras; verificar duración efectiva y ausencia de animación perceptible. Restaurar no-preference y comprobar transición breve sin parpadeos ni saltos de tamaño. Verificar imagen completa, sin recortar diseño/logotipo.
6. **Events:** `http://localhost:3000/style-guide/patterns.php#events`. Comprobar foto, agenda cronológica, fecha/hora/PDT, lugar y disponibilidad etiquetada como simulada. Explore event details debe llevar al detalle; abrirlo con teclado y leer agenda/avisos. Su enlace debe llevar a la selección. Enviar vacío, seleccionar evento, ejecutar Failure→Success y reset. No debe prometerse plaza, ticket ni reserva; la acción de agotado permanece disabled.
7. **Private Experiences:** `http://localhost:3000/style-guide/patterns.php#private-experiences`. Enviar vacío: errores y foco en primer campo. Probar nombre en espacios, email `guest@`, invitados 0 y 1.5, fecha anterior al día actual de **Mount Shasta**, y ocasión vacía. Corregir con `Example Guest`, `guest@example.com`, 6 invitados, fecha futura y Birthday. Recorrer las siete opciones mediante flechas y confirmar cada etiqueta/value; el resumen debe reflejar la selección. Ejecutar Failure→Success: datos conservados, carga y confirmación de consulta demo sin reserva. Clear inquiry limpia campos/errores/resumen y devuelve foco. Si la fecha del dispositivo difiere de California, el mínimo debe seguir California.
8. **Estados:** `http://localhost:3000/style-guide/patterns.php#wave-4-states`. Recorrer las 29 opciones de las cuatro fichas; verificar texto, variante, skeleton y acciones aplicables. Error de Events debe permitir retry hacia disponible simulado; vacío debe permitir volver a agenda y estados no disponibles deben mantener su acción disabled. No inventar fechas, saldos, cobros o promociones.
9. **Accesibilidad común:** recorrer todo con Tab/Shift+Tab, Enter/Espacio y flechas en radios/selects. Foco visible sin recortes, orden lógico y sin trampas; errores asociados y feedback legible/anunciado. Medir contraste real sobre fondo renderizado: texto normal ≥4.5:1 y grande ≥3:1, controles/foco esenciales ≥3:1. Verificar contenido largo y datos ausentes mediante cambios temporales en DevTools únicamente, sin guardar: nombre/beneficios extensos en membresía y precio eliminado; la tarjeta debe crecer sin ocultar el dato pendiente.
10. **Consola/Network y regresiones:** retirar bloqueos, limpiar registros y recargar. Recorrer cuatro demos y siete imágenes; sin errores de página ni recursos fallidos, sin requests de negocio. Guardar conteo real de solicitudes separando carga inicial/interacción y caché. Core: `http://localhost:3000/style-guide/#modals` (abrir/cerrar con Escape, trap/retorno), `#disclosure` (Accordion), `#forms` (campos/feedback; usar navegación de la guía si cambia el ancla). Patterns: revisar hero/media/bandas de Wave 1 desde su navegación; `patterns.php#productos-pedido` (Quantity, límites, subtotal y feedback), `#galeria-editorial` (abrir, navegar, Escape y retorno), `#experiencias` (composición Wave 3). Comprobar que ninguna interacción previa dejó de funcionar.

**Próximo paso:** completar esta checklist en el navegador del usuario o habilitar la política del navegador integrado y repetir el QA allí. Solo después de corregir y repetir cualquier fallo se podrá solicitar aprobación visual humana integral. Estado actual: **WAVE 4 QA PARTIALLY BLOCKED — MANUAL REVIEW REQUIRED**.

## Refinamiento comercial Wave 4 — 2026-10-16 — revisión bloqueada

Base publicada verificada tras fetch: `232d670be61347dc7d4da0104c3aae0192d37a74`, coincidente con origin, árbol inicialmente limpio y rama `feature/ui-section-patterns-wave-4`. Este apartado sustituye las descripciones de Wine Club/Gift Cards y el estado de QA de la implementación inicial que sigue como historial. **WAVE 4 NOT READY: el refinamiento aún no tiene QA renderizado ni aprobación visual humana.** Los resultados visuales anteriores no validan estos cambios.

### Auditoría y decisiones de refinamiento

| Familia / necesidad | Decisión y cobertura implementada | Cierre |
|---|---|---|
| Wine Club: valor y comparación | Extender `cl-membresia`, conservar `cl-media-contenido`, radios y Accordion Core | Implementado; revisión visual/funcional pendiente |
| Gold/Diamond | Gold cálido con foco regional; Diamond ocupa 7/12 desde md frente a 5/12, superficie cálida, borde champagne, nombre/precio mayores y selector acentuado | Jerarquía propuesta, pendiente de aprobación |
| Gift Cards: recorrido y arte | Extender `cl-regalo`; seis radios Core, datos opcionales, arte oficial sustituible, resumen y continuación demo | Implementado; revisión visual/funcional pendiente |
| Events | Ajustes quirúrgicos de copy/CTA, sin reconstruir destacado, tarjetas, agenda ni detalle | Implementado; regresión interactiva pendiente |
| Private Experiences | Conservar composición y campos Core; aclarar consulta/conversación/confirmación y corregir selector | HTML generado comprobado; teclado/validación en navegador pendientes |
| Laboratorio | Reubicar Demo controls en disclosures nativos cerrados, después del recorrido; conservar cuatro ciclos y 29 estados futuros | Sin duplicar sistemas; recorrido interactivo pendiente |
| Precios, ventajas, entrega y políticas | Referencias históricas etiquetadas y espacios pendientes | Pendiente comercial |
| Reservas, cobros, emisión y cuenta | No implementar | Reservado para backend; cuenta Wave 7 |

Wine Club sigue introducción → comparación/selección → resumen → FAQ → laboratorio. El nuevo relato invita a conocer el origen, carácter y contexto gastronómico del vino, diferenciando una relación de membresía de una compra individual. Gold y Diamond presentan perfiles **de archivo**, sin checks de ventajas vigentes ni distintivos de popularidad. Los $99/$199 USD son referencias históricas explícitas, no precios actuales; los $149 se mencionan como antecedente promocional sin oferta activa. La periodicidad de cobro permanece pendiente. Los grupos separan selección de vino, acompañamiento y privilegios adicionales históricos de Diamond. No se promete más cantidad: ambos antecedentes hablan de cuatro botellas por selección. Ningún dato histórico se convierte en política vigente.

La selección conserva radios nativos, contorno champagne y un icono Core de confirmación únicamente cuando el radio está marcado. El resumen lee nombre, precio histórico y periodicidad de los slots del bloque seleccionado, sin segunda tabla en JS. Diamond se diferencia mediante composición y tokens existentes; no añade colores, fuentes, efectos ni componentes globales.

Gift Cards organiza un solo formulario en cuatro pasos: **01 importe → 02 destinatario/dedicatoria → 03 vista previa → 04 revisión y acción demo**. Datos y arte comparten columnas desde md; el resumen ocupa el ancho inferior. Los importes siguen exclusivamente $50/$100/$200/$300/$400/$500. Destinatario opcional de 60 caracteres y mensaje opcional de 300; sin dirección ni correo de entrega. La dedicatoria aparece al lado del arte y nunca se dibuja encima del diseño oficial. El aviso de políticas permanece visible fuera del laboratorio. Las presentaciones físicas/digitales solo aparecen como conceptos futuros en Demo controls.

Al cambiar importe se solicita su reverso oficial; los botones Front/Amount side permiten inspeccionar ambas caras. Editar el texto conserva la cara elegida; limpiar vuelve al frente. El importe anterior se oculta durante la carga para no mostrar un reverso contradictorio. Skeleton/error/retry reutilizan Core; el fallback conserva importe y dedicatoria como texto. La imagen tiene proporción y dimensiones reservadas, `object-fit: contain`, sin recorte. Se propone una aparición de opacidad de 180ms y respuesta de selector de 150ms; Foundation conserva su regla global de reduced motion (0.01ms/una iteración). No se ha emulado esa preferencia en este refinamiento.

### Recursos gráficos oficiales

Se utilizaron las siete imágenes adjuntas del propietario, disponibles en `C:/Users/Mike/Pictures/gift-card/Gift-Card-the-clandestino-USA/`: `gift-card.png` y los seis `gift-card-reves-{importe}.png`. Se preservaron originales, logotipo, proporciones y diseño. Los nuevos WebP en `assets/images/gift-cards/` mantienen **3137×2030**, transparencia y resolución, mediante conversión Pillow calidad 90; sin recorte, redimensionado ni generación de una marca alternativa. Se inspeccionaron directamente el frente convertido y el reverso de $50; los siete derivados se comprobaron por dimensiones/peso. No faltan imágenes oficiales; queda pendiente la revisión visual de las siete en navegador.

El texto impreso de redención pertenece al arte aportado. No confirma condiciones comerciales actuales: la interfaz lo advierte y mantiene pendientes redención, expiración, reembolso, presentación y entrega. No existe código canjeable, QR, saldo, activación, PDF ni wallet.

### Estados, interacciones y contratos

Se conservan las cuatro demos locales: inicial, selección/edición, inválido, espera de 1.6s, error con entradas conservadas, recuperación, confirmación explícitamente demo y reset. Las 29 opciones de ciclo de vida mantienen su estructura anterior. En Gift Cards se añaden carga/error/reintento del arte y selección de cara; Amount side está disabled sin importe. Son estados implementados en código, **no comprobados funcionalmente en navegador en esta pasada**. No se afirman transacciones ni envíos. Las alertas siguen Core; las actualizaciones textuales usan `textContent`, sin HTML dinámico ni persistencia.

Events distingue **Explore event details** de **Explore a seat inquiry · demo**. La acción final previsualiza interés; no retiene una plaza. Se conservan los eventos hipotéticos de 2028, zona horaria, agenda, disponibilidad y detalle. Private Experiences dice **Review my inquiry** y explica consulta inicial → conversación → confirmación separada solo tras disponibilidad y acuerdo. La confirmación local indica expresamente que nada se envió ni reservó.

El selector `private-occasion` reemplaza el cierre mal formado `</option value="birthday">` por opciones renderizadas desde un mapa explícito y escapado. Valores/etiquetas: vacío/Choose an occasion, birthday/Birthday, anniversary/Anniversary, celebration/Celebration, corporate/Corporate gathering, private/Private get-together y dining/Personalized dining. Se preservan required, label y mensaje asociado; no se alteran los demás controles Core.

Los contratos conceptuales previos permanecen: ID/nombre de plan, precio/moneda nullable, periodicidad, beneficios, estado y promoción verificada; producto/importe/presentación/arte/políticas del regalo; evento/fecha-zona/disponibilidad; consulta/ocasión/fecha/invitados/contacto. `data-cl-plan`, `data-cl-plan-precio`, `data-cl-plan-periodicidad` y `data-cl-regalo-arte` separan presentación y datos; no son esquema MySQL ni autoridad comercial. Una referencia futura de reserva/consulta será un dato del servidor y no se inventa ahora. El backend validará precios, promociones, permisos, capacidad, emisión y transacciones.

### Reserva centralizada: referencia futura, sin integración

`MaickR/Booking-app-php` se registra únicamente como referencia propuesta para una evaluación backend posterior: no se inspecciona, modifica, copia ni integra en esta wave. Se podría estudiar una aplicación centralizada con CTAs contextuales desde Restaurante, Events, Wine Tastings y Private Experiences. Son flujos distintos: mesa requiere comensales/fecha-hora/mesas/disponibilidad; evento requiere evento/cupos/fecha/participantes; privado comienza por consulta/propuesta y confirma después. No se crea un motor único que suponga procesos idénticos.

Los destinos son conceptuales: futura reserva de mesa, detalle/inscripción de evento y consulta privada. Ahora solo se usan anclas existentes de Style Guide; sin endpoints inventados ni redirección a GitHub. Cuando proceda una banda de navegación se reutilizará `cl-banda-cta--destacada` con Core; no se crea otra. Antes de reutilizar la app antigua será necesaria una auditoría de seguridad, integridad de datos, autorización, concurrencia y adaptación al dominio gastronómico. Esa auditoría no se realiza aquí.

### Verificación actual y limitaciones

| Comprobación | Resultado de este refinamiento |
|---|---|
| npm run lint | PASS: ESLint y Stylelint, sin modificar reglas |
| npm run build | PASS: producto/sprite; JS productivo vacío, sin nueva dependencia |
| PHP lint | PASS: patterns.php y seis partials Wave 4 |
| HTML generado | PASS estructural: PHP renderizado, Python HTMLParser y lxml; cero cierres mal formados/errores de pila, IDs únicos, siete opciones correctas, labels, anclas locales y siete rutas de arte existentes; figcaption en posición válida. No es certificación Nu/W3C |
| npm run dev | PASS: PHP/BrowserSync/watch inicia en localhost:3000 |
| Navegador integrado | BLOQUEADO: la política de permisos rechaza el origen localhost:3000 incluso después de autorización en chat y aviso del usuario de permiso actualizado. No se elude por otro origen/herramienta |
| 320/360/390/425/768/820/992/1024/1280/1440 | PENDIENTE de QA renderizado de los nuevos layouts; SCSS mobile first con breakpoints existentes, no resultado visual declarado |
| Teclado, foco, targets, contraste, zoom 200%, viewport corto | PENDIENTE de prueba actual; no se extrapola el QA de la implementación inicial |
| Cuatro demos, seis reversos, validación/recuperación y ausencia de imagen | PENDIENTE de ejercicio en navegador; código revisado y lint aprobado |
| Consola y Network | PENDIENTE; no se declara cero errores/404 ni requests reales medidos |
| Regresiones | Fuentes Foundation/Core/Waves 1–3, Quantity, modal/galería y Accordion intactos; ejecución interactiva pendiente. `_guia.scss` solo cambia reserva de feedback acotada a Wave 4 |

Evidencia local: `C:/Users/Mike/.codex/visualizations/2026/10/16/01a14453-b06d-7011-8bb2-85fcf74ed185/refinement-html-validation.json`, `refinement-assets.json` y HTML before/after. Las capturas `verified-*` pertenecen a la implementación inicial y no acreditan el refinamiento. No hay capturas nuevas: la herramienta rechazó la apertura. Tampoco se declara QA en Safari/Firefox, lector de pantalla, dispositivos físicos ni hosting real.

### Performance del refinamiento

Mismo pipeline de build y Node gzip nivel 6; bundle guía en memoria con esbuild, sin minificar ni sourcemap, como la base medida antes de editar.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Cambio gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 75393 | 77387 | 13282 | 13611 | +329 (+2.48%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |
| JS guía DEV | 82328 | 85499 | 19189 | 19886 | +697 (+3.63%) |

El crecimiento CSS corresponde a las extensiones de membresía/regalo; JS solo a la guía y control del arte/resúmenes. Markup conserva 41 instancias img: la vista previa sustituye la fotografía anterior por el frente oficial. Se añaden siete recursos WebP, pero solo una cara se solicita inicialmente y las demás por interacción; no se precargan los seis importes. Frente: 308594 bytes. Reversos: 193576–201862 bytes por imagen. Total de siete derivados: **1497458 bytes**, frente a **19339190 bytes** de PNG fuente. Son inventarios/pesos, no un HAR ni mediciones de solicitudes reales. No se alteran fotografías originales ni se añaden requests comerciales.

### Archivos, revisión y pendientes

Modificados: `_membresia.scss`, `_regalo.scss`, `_guia.scss` (regla Wave 4), `comercial.js`, cuatro partials de familia y esta biblioteca. Nuevos: siete WebP oficiales derivados en `assets/images/gift-cards/`. `_evento.scss`, `_consulta-privada.scss`, el catálogo compacto de estados y las entradas/tooling se conservan. Sin cambios a VISUAL-DIRECTION ni nuevas decisiones comerciales confirmadas.

URLs locales preparadas: `http://localhost:3000/style-guide/patterns.php#wine-club`, `#gift-cards`, `#events`, `#private-experiences`, `#wave-4-states`; Foundation/Core en `/style-guide/`. Abrir Demo controls para elegir Failure/Success. Antes de cerrar la wave se requiere revisar estas rutas en los diez anchos, ejecutar los cuatro flujos y sus errores, comprobar selección por teclado del selector corregido, arte ausente/retry, consola, recursos y regresiones.

Pendiente de Nicolás: beneficios actuales y diferencias de nivel, precios/periodicidad/promociones, elegibilidad/entrega/renovación/cancelación; presentación y políticas de Gift Card; eventos reales/cupos/precios; posibilidades y capacidad privadas. Backend conserva autoridad y responsabilidad por reservas/cobros/emisión/comunicaciones/persistencia. **Bloqueo de entrega: QA visual y funcional actual sin ejecutar por permisos del navegador. Aprobación visual humana pendiente.**

## Wave 4 — Wine Club, Gift Cards, Events y Private Experiences — 2026-10-16

Rama `feature/ui-section-patterns-wave-4`, base `develop@cd009fd0bae46d1accffd16f74760a2b32b7674a`. Preflight limpio, fetch ejecutado, develop actualizado por fast-forward y Wave 3 verificada como ancestro (`4e6d4b0`, merge #9). No se modifica el comportamiento de páginas productivas. Dirección existente conservada; **aprobación visual humana de Wave 4 pendiente**.

### Auditoría inicial y cierre de cobertura

Se leyeron AGENTS, VISUAL-DIRECTION, UX-UI-GUIDELINES, Core, esta biblioteca, estándares, arquitectura, mapa de producto y Git workflow; se inspeccionaron las reglas SCSS/JS/PHP y la guía real Waves 1–3. Se revisaron `swc.html`, el formulario de `contact.html` y las referencias del mapa. El inventario no contiene una página dedicada de eventos ni una implementación comercial de Gift Cards. No se deduce una política vigente del legacy.

| Necesidad inventariada | Decisión | Resultado final |
|---|---|---|
| Introducciones, grid, acciones y resumen | Reutilizar `cl-seccion`, `cl-media-contenido`, `cl-seccion__acciones`, `cl-catalogo__resumen` | Completo; sin variantes estructurales de Waves anteriores |
| Botones, campos, radios, selects, mensajes y feedback | Reutilizar Core | Completo; sin nueva biblioteca de formularios o notificaciones |
| Comparativa y elección de membresía | Crear `cl-membresia`; extender composición de radio Core | Completo: Gold, Diamond, destacada, selección y resumen |
| Regalo y personalización | Crear `cl-regalo`, `cl-regalo-importes`; extender radio Core | Completo: seis importes, dedicatoria, vista previa y resumen |
| Evento y agenda | Crear `cl-evento`, `cl-eventos-agenda`; reutilizar Collapse Core | Completo: destacado con foto, fila sin foto, agenda, detalle, selección y no disponible |
| Consulta privada | Crear `cl-consulta-privada`; reutilizar formulario Core | Completo: ocasión, fecha, invitados, contacto mínimo, mensaje y feedback |
| FAQ y detalle expandible | Reutilizar Accordion Core | Completo; Enter/Space, sin segundo sistema disclosure/modal |
| Estados de operación y ciclo de vida | Reutilizar Alert/State/Skeleton y botón con carga Core | Completo: cuatro demos + 29 estados compactos seleccionables |
| Cantidad Gift Card / entrega | No crear una compra múltiple ni campos de entrega sin contrato | Pendiente comercial: una pieza por vista previa, sin selector de cantidad artificial |
| Precios, periodicidad, promociones y condiciones | Slots con información pendiente o ejemplo etiquetado | Pendiente comercial; ninguna promoción publicada |
| Cobro, membresía, emisión, inventario y reservas | Fuera del alcance funcional | Reservado para backend |
| Dashboard / cuenta | No crear | Reservado para Wave 7 |

La auditoría final cubre las cuatro familias, variantes justificadas, estados, interacciones, Core, assets, datos futuros y aceptación. No quedan defectos de frontend bloqueantes identificados en el entorno probado. Los pendientes comerciales no se convierten en ofertas simuladas sin etiqueta.

### Componentes, composición y variantes

**Wine Club:** introducción con fotografía auténtica y relato; comparativa editorial de dos niveles con beneficios y selección nativa. `cl-membresia--destacada` distingue Diamond sin una insignia de popularidad ni descuento. La selección dibuja un contorno de champagne además del radio nativo. Resumen separado, acción demostrativa y tres preguntas en Accordion Core. `swc.html` conserva referencias históricas Gold $99 y Diamond $149; el encargo también advierte Diamond $199. Se muestra Gold $99 como histórico y Diamond con precio por confirmar y ambos antecedentes. Aunque el archivo describe selecciones trimestrales, **no se atribuye una periodicidad de cobro vigente**. Beneficios y cantidades están bajo la advertencia histórica del fieldset; no son compromisos actuales.

**Gift Cards:** fotografía panorámica conservada completa, marca tipográfica, dedicatoria y valor con jerarquía propia. `cl-regalo__importe--pendiente` presenta la selección vacía sin inflar el texto; se reserva el espacio del importe. `cl-regalo-importes` contiene exclusivamente $50/$100/$200/$300/$400/$500 USD, según el mapa. Radios nativos, destinatario opcional (60 caracteres), mensaje opcional (300), resumen y enlace a la vista previa. Dos columnas desde md; importes en dos columnas hasta lg, tres desde lg. Las opciones Digital/Printed son controles del laboratorio para un texto de concepto futuro; no cambian la operación ni afirman que existan ambos productos. Sin dirección, email de entrega, cantidad comercial, código, QR, saldo, PDF ni tarjeta emitible.

**Events:** fecha local protagonista, categoría, lugar e información para decidir. `cl-evento--destacado` integra foto de archivo y relato; desde md la foto acompaña la altura determinada por el contenido, sin imponer una tarjeta gastronómica. `cl-eventos-agenda` es una lista cronológica con dos entradas hipotéticas de mayo de 2028, no anuncios reales. La segunda omite media y deshabilita su acción por agotado simulado. El ejemplo principal muestra precio por consultar; el segundo, gratuito de ejemplo. El detalle expandible contiene descripción, lugar, fechas/horas, agenda hipotética y avisos. Los atributos `datetime` incorporan offset -07:00 y el texto identifica PDT / America/Los_Angeles. Sin filtros innecesarios ni calendario interactivo.

**Private Experiences:** split editorial de restaurante + invitación, seis ocasiones y consulta breve. `cl-consulta-privada` agrupa campos Core y sus acciones reutilizan Wave 1. Nombre/email, fecha preferida, invitados aproximados y ocasión obligatorios; mensaje opcional. No se exige teléfono ni otros datos personales. Se valida fecha de hoy o futura en America/Los_Angeles, recalculada al validar; invitados enteros >=1, sin afirmar capacidad máxima. El flujo aclara consulta → conversación → confirmación separada. Ninguna confirmación demo equivale a reserva.

Radios `--radio-md`, tokens, tipos y colores existentes; ninguna fuente, efecto, dependencia o foto nueva. No se modifica VISUAL-DIRECTION ni se le atribuye aprobación nueva. No se necesita otra banda CTA, cantidad, modal o `cl-producto-gastronomico` para resolver estas responsabilidades.

### Matriz de estados e interacción

| Familia | Estados implementados y comprobables |
|---|---|
| Wine Club | Sin nivel, Gold/Diamond seleccionado, disponible simulado, carga local, error, recuperación y selección completada demo. Ficha futura: activa, próxima renovación sin fecha inventada, pago pendiente, cancelación programada, cancelada, expirada |
| Gift Cards | Sin importe/formulario vacío, importe seleccionado, inválido por importe ausente, vista previa con texto opcional, carga, error conservando entradas, recuperación y solicitud simulada completada. Ficha futura: presentación pendiente, emitida, pendiente de entrega, enviada, canjeada, expirada; siempre no canjeable y sin política de expiración inferida |
| Events | Próximamente, disponible, limitado, agotado, finalizado, cancelado, reprogramado con fecha pendiente, por anunciar, sin eventos, skeleton de carga y error recuperable. Selección vacía/pendiente/completada/fallida en demo independiente; sin asiento reservado |
| Private Experiences | Inicial, campos incompletos, nombre en blanco, email inválido, fecha pasada, invitados cero/fraccionarios, validación corregida, loading, error, recuperación, solicitud recibida demo. Ficha futura: pendiente de respuesta, cancelada y cerrada |

Los cuatro formularios previenen submit; los botones de continuación se renderizan disabled y solo se habilitan al conectar su demo. Sin JS no se ofrece una operación falsa. El laboratorio permite Success/Failure fuera del formulario comercial. Cada acción válida bloquea campos, reset y selector de desenlace, conserva foco en el botón con Core, publica espera y termina en 1.6s. Un guard impide activaciones duplicadas. Error conserva las entradas y explica cómo reintentar; éxito muestra confirmación explícitamente demostrativa. Editar oculta la confirmación anterior; reset limpia mensajes/selección y devuelve foco al botón. Recargar elimina todo el estado local.

Radios actualizan resúmenes por input y se operan con flechas/Espacio. El resumen del club deriva nombre y precio del markup seleccionado; no mantiene otra tabla de precios en JS. La vista previa del regalo usa `textContent`, soporta saltos de línea y texto largo; nunca interpreta HTML. Fecha y campos inválidos llevan mensaje asociado, `aria-invalid`, borde y foco en el primer campo erróneo al enviar. El feedback usa regiones status preexistentes. Las 29 opciones de ciclo de vida actualizan una ficha Core por familia; no se duplican 29 pantallas. La agenda vacía ofrece retorno a los ejemplos, loading muestra Skeleton y error ofrece retry local hacia disponible simulado. Los estados sin acción tienen disabled explícito. Promoción se omite por falta de verificación.

### Arquitectura y contratos conceptuales de UI

Cuatro SCSS de producto compartido en `assets/scss/patterns/`: `_membresia.scss`, `_regalo.scss`, `_evento.scss`, `_consulta-privada.scss`, importados al final de `main.scss`. No contienen presentación de guía. Ritmo de demo/feedback en `_guia.scss`, bajo `.cl-guia-comercial`. Seis partials PHP nuevos: entrada `comercial-wave-4.php`, una familia por archivo y `estados-wave-4.php`. La entrada usa los helpers de fotografía ya presentes en la guía Wave 3; los originales y las composiciones anteriores no cambian. Los helpers de campos, botón y desenlace son locales de guía, con parámetros de código confiables y output textual escapado, no un motor comercial ni un esquema de BD.

`assets/js/modules/guia/comercial.js` conecta únicamente las demos Wave 4 y se importa desde `style-guide.js`. Reutiliza Core Alert, Button Loading y Accordion. Selección nativa y CSS no necesitan otro runtime de producto. `main.js` permanece intacto. Las futuras páginas pueden renderizar los mismos bloques y conectar sus datos/operaciones propias sin reconstruir el HTML visual.

| Familia | Datos conceptuales y slots visuales |
|---|---|
| Wine Club | ID de plan, nombre, precio nullable, moneda, periodicidad nullable, beneficios, estado y promoción solo verificada. Nombre/precio/periodicidad en cabecera, beneficios en lista, estado junto al contexto y radio/CTA según elegibilidad; si faltan datos, texto pendiente |
| Gift Cards | ID de producto, importe de la lista permitida, moneda, presentación nullable, estado, datos de entrega y políticas nullable. Identidad/importe/dedicatoria en preview; resumen/avisos separados. No solicitar entrega hasta definirla |
| Events | ID, título, inicio/fin con zona horaria IANA y offset, lugar, imagen opcional con alt/dimensiones, precio/tipo de precio nullable, capacidad/disponibilidad nullable, estado. Fecha en time, media opcional, datos y acción contextual. Reprogramado deberá conservar fecha anterior y sustitución verificada; sin sustitución, mostrar pendiente |
| Private Experiences | Tipo/ocasión, fecha preferida local, invitados aproximados, nombre y canal de contacto, mensaje opcional, estado de consulta. No representar el estado de solicitud como estado de reserva |

Contratos de UI, no esquema definitivo MySQL. En servidor deberán validarse importes, moneda, permisos/elegibilidad, inventario/capacidad, emisión/redención de regalos, cobros, renovaciones y reservas. Los strings futuros se escapan al renderizar. No existen endpoints, POST, pagos, registro, correos, cookies, localStorage ni persistencia de compras. Se usan únicamente detalles ficticios en QA. Cuenta e historial corresponden a Wave 7; checkout, transacciones y disponibilidad real se difieren a las fases de producto/backend pertinentes. No se asigna artificialmente su responsabilidad a Wave 5/6 sin contrato aprobado; no faltan dependencias Core para reutilizar Wave 4.

### QA técnico y visual

Skill aplicada: `.agents/skills/qa-visual/SKILL.md`. Chromium integrado; URL `http://localhost:3000/style-guide/patterns.php#wave-4`. Evidencia local fuera del repo en `C:/Users/Mike/.codex/visualizations/2026/10/16/01a14453-b06d-7011-8bb2-85fcf74ed185/`.

| Prueba ejecutada | Resultado |
|---|---|
| Lint / build | PASS: ESLint y Stylelint, sin relajar reglas; build producto/sprite sin assets guía ni selectores cl-guia/cl-muestra |
| PHP | PASS: patterns.php y los seis partials Wave 4 |
| Dev | PASS: PHP, BrowserSync y watch; guía disponible para revisión humana |
| Responsive | PASS: geometría en 320/360/390/425/768/820/992/1024/1280/1440; sin overflow ni textos recortados. El scrollbar ocupa 15px del ancho solicitado |
| Evidencia visual | 40 capturas `verified-{familia}-{ancho}.png`, con posición de ancla comprobada antes de guardar. Revisión visual de composiciones representativas móvil/tablet/desktop, más geometría en todos los anchos. Capturas preliminares final-* y otras sin prefijo verified pueden mostrar scroll en tránsito; no son evidencia final |
| Controles / interacción | PASS: cuatro selecciones/formularios; inicial, requerido, carga, bloqueo de duplicados, éxito, error y recuperación; estados compactos recorridos, retry de agenda comprobado |
| Validación privada | PASS: vacío, espacios, email incorrecto, fecha pasada e invitados cero/decimales; corrección y mantenimiento de entradas tras fallo |
| Contenido largo / viewport corto | PASS: 320px y 640px de alto, nombre de regalo 60 caracteres, mensaje cercano a 300 y saltos de línea; sin overflow. Las vistas sin precio/foto/datos y selecciones vacías mantienen contexto |
| Teclado / foco | PASS: radios con flechas/Espacio, acciones con Enter/Espacio, Tab/Shift+Tab, Accordion Core y retorno desde reset; foco champagne 2px con offset 3px, sin recorte. Targets medidos >=44px |
| Contraste | PASS: 213 combinaciones de texto visible medidas sobre fondos resueltos, mínimo 9.69:1; disabled excluido del requisito. Bordes/foco conservan tokens Core. Sin texto superpuesto a fotografía |
| Semántica / media | PASS: un h1, jerarquía local sin saltos, IDs únicos, campos con labels asociados, alt/dimensiones, cuatro fotos cargadas, sprite de ubicación existente y decorativo |
| HTTP / consola | PASS: 50 recursos locales únicos del inventario responden 200; sin errores/warnings de página observados. No se afirma un HAR ni un conteo de requests reales de red |
| Regresiones | PASS: fuentes Foundation/Core/Waves 1–3 intactos; estilos de guía nuevos acotados. Cantidad Wave 2 aumenta 1→2 / $72; visor Wave 3 abre imagen completa y cierra por Escape. JS de producto y originales sin cambios |
| Reduced motion | Regla Foundation compilada preservada: transición/animación 0.01ms, una iteración; Skeleton estático. Sin emulación de preferencia en este navegador |

Limitaciones explícitas: zoom real 200% no expuesto por el control disponible, sin prueba declarada; tampoco Firefox/Safari, lector auditivo, dispositivos táctiles físicos o Apache/GoDaddy. No se miden Web Vitals de producción ni CLS de campo. Se reservan proporciones de fotos, altura de importe y feedback para reducir desplazamientos; mensajes largos expanden el contenido sin truncarlo. Warning Node DEP0060 de BrowserSync preexistente, sin fallo de build. El primer build sandbox no pudo leer un directorio ascendente de esbuild; el build final pasó con permisos de ejecución suficientes y sin tocar tooling.

### Performance antes / después

Mismo pipeline: CSS minificado por npm run build; JS guía bundle en memoria sin sourcemap, minify=false como dev; Node gzip nivel 6. Base medida antes de editar Wave 4.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Cambio gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 71394 | 75393 | 12796 | 13282 | +486 (+3.80%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |
| JS guía DEV | 71901 | 82328 | 16646 | 19189 | +2543 (+15.28%) |

El JS productivo vacío conserva SHA-256 `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. El coste nuevo de guía corresponde al ciclo de cuatro demos, validación, preview y laboratorio de estados; no se añaden librerías. El CSS productivo solo añade presentación de las cuatro familias.

HTML renderizado base/final: 37→41 instancias img; 50→50 URLs únicas de assets locales y 44→44 alternativas fotográficas. Cero URLs nuevas de media. Las cuatro fotos reutilizadas suman 313826 bytes en AVIF preferido, 417686 WebP alternativo o 936851 originales/fallbacks; son alternativas, no descargas acumulables. Todas estaban ya referenciadas por Waves anteriores y reutilizan caché. No se alteran originales ni se generan derivados. Inventario de recursos no equivale a solicitudes efectivas: lazy loading, caché y negociación de formato dependen del navegador. No se añade ningún request de negocio; los cuatro flujos son locales.

### Revisión, archivos y pendientes

Crear 11 fuentes: cuatro SCSS, módulo JS de guía y seis partials PHP. Modificar seis: entradas Sass/JS, `_guia.scss`, `patterns.php`, esta biblioteca y arquitectura. Sin eliminaciones, dependencias, tooling o archivos de producción modificados. Outputs ignorados y evidencias fuera del repo.

Revisión integral: `patterns.php#wine-club`, `#gift-cards`, `#events`, `#private-experiences`, `#wave-4-states`; Core en `/style-guide/`. Elegir una selección, usar Success/Failure en Demo controls y ejecutar la acción para probar recuperación. Revisar móvil/tablet/escritorio; feedback nunca acredita una operación comercial.

Pendiente comercial: precios/frecuencia y beneficios actuales del club; promociones verificadas; renovación/cancelación/entrega/elegibilidad; presentación y entrega Gift Card, redención/expiración/reembolso; eventos reales, precios/capacidad/condiciones; alcance, capacidad y formatos privados. Reservado backend: checkout/cobros, emisión/redención, reservas/inventario, comunicaciones, persistencia, permisos y cuenta. **Aprobación visual humana de Wave 4 pendiente; sin autorización de PR, merge o deploy.**

## Refinamiento integral Wave 3 — 2026-10-16

Base publicada `7d672fa` / `ae8c0ea`; misma rama `feature/ui-section-patterns-wave-3`, limpia y sincronizada tras fetch. Este apartado actualiza los contratos vigentes; los registros de Wave 3 inicial que siguen quedan como historial. Criterio estético consolidado: [VISUAL-DIRECTION.md](VISUAL-DIRECTION.md). Pendiente de aprobación visual humana integral.

### Dirección y composiciones

Experiencias usa una invitación gastronómica dominante y dos piezas de apoyo: Wine Club lateral y gourmet sin foto compacto. En md, la principal se distribuye en foto/copy laterales; en lg ocupa una columna frente al grupo secundario compacto, centrado verticalmente. Móvil conserva el descubrimiento secundario lateral. Se mantiene el HTML y la geometría de `cl-experiencia--destacada`, los disclosures `cl-guia-demo` y los estados iniciales. Solo se normaliza el radio de sus fotos a `--radio-md`, corrigiendo la herencia interrumpida por picture; no se rediseña la destacada.

Storytelling conserva fotografía, relato, manifiesto y split Wave 1. La bajada cambia 5/6 + offset a 5/7, con gutter intencional, alineación vertical y título contextual balanceado; se retira el br rígido del titular. El manifiesto mantiene sus tres ideas y saltos editoriales deliberados. No cambia Foundation.

Comunidad se separa de la galería mediante `cl-comunidad`: una invitación clara al encuentro, interior protagonista y detalle panorámico de mesa en dos figuras relacionadas; CTA Core para conversar sobre un grupo. DOM texto→media; desde md la media no interactiva queda a la izquierda y la acción conserva su orden. No son testimonios ni evidencia de clientes. Valores mantiene introducción/lista, con titular champagne, primer atributo de mayor jerarquía, dos atributos intermedios y cierre de ancho completo desde lg; sin cuatro tarjetas ni estadísticas. Video permanece intacto.

### Galería visual e interacción

`cl-galeria-editorial`: dos columnas móvil con principal/panorama completos, tres miniaturas por fila en md, cuatro en lg con principal 2×2 y panorama al cierre. Los seis controles y captions mantienen el orden DOM. Slots consistentes, recortes cover revisados y radios `--radio-md`; el visor usa exclusivamente contain. Las seis fotos y sus derivados ya existían. Sin generación de miniaturas, dependencias, autoplay ni precarga vecina.

Cada figura tiene un enlace `a[data-cl-galeria-abrir]` a su archivo real, un picture lazy, caption breve e indicación mediante ojo Bootstrap (`ver`/`eye`), sin fondo ni borde. Un contorno de sombra mínimo mantiene legible el símbolo sobre la fotografía. Tooltip nativo «View image» sobre el indicador, sin JavaScript adicional; el nombre accesible «Enlarge photograph: …» y foco del enlace siguen resolviendo teclado/lector de pantalla. Sin JavaScript el enlace sigue abriendo la imagen; con JS el visor presenta foto completa, título, descripción, contador derivado de las entradas y controles. No se incluye un control para fotografía conocida como ausente.

**API:** `inicializarGaleria(contenedor)` en `assets/js/modules/patterns/galeria.js`, con HTMLElement explícito. Cada raíz `[data-cl-galeria]` contiene sus enlaces y un `[data-cl-galeria-visor]` con la estructura mostrada en `partials/visor-galeria.php`. El módulo no conoce IDs de guía ni datos de productos. WeakMap garantiza inicialización idempotente. Devuelve `{ abrir(indice = 0, origen), cerrar() }`; abrir fuera del rango lanza RangeError. Una colección sin entradas devuelve abrir=false, sin modal ni listeners.

Markup de cada enlace: `href` local real, `data-cl-galeria-titulo`, descripción/alt opcionales en `data-cl-galeria-descripcion` / `data-cl-galeria-alt`. La miniatura aporta width/height reales; sin miniatura, usar `data-cl-galeria-ancho` y `data-cl-galeria-alto` para reservar su proporción antes de cargar (fallback 4:3). Se aceptan únicamente http(s) del mismo origen y se omiten enlaces con aria-disabled="true" o pertenecientes a una raíz anidada. Datos estáticos controlados y escapados en PHP; JS usa textContent y atributos de imagen, sin HTML arbitrario. El inventario es una instantánea estática al inicializar. Páginas con sustitución dinámica del DOM deberán definir primero su ciclo de vida; no se añade destroy/dispose sin necesidad en estas páginas PHP estáticas.

**Core:** `inicializarModal` sin modificaciones. Bootstrap mantiene backdrop, Escape, scroll lock y trap; el adaptador conserva foco inicial en cierre y retorno al enlace activador. El módulo solo controla fotografías. Anterior/siguiente circulares con ≥2 entradas; ambas acciones disabled nativas con una foto. Flechas izquierda/derecha solo dentro del visor abierto, sin modificadores y fuera de campos editables. Contador `01 / 06`, captions y región polite se actualizan sin mover foco.

**Carga/error:** nuevo Image insertado en el mismo slot; fuente seleccionada currentSrc del picture o href. Solo se solicita la foto elegida, que puede venir de caché si su miniatura ya cargó el mismo AVIF. Sin segunda descarga por preloader y sin precargar el resto. Spinner Core tras 150ms para no destellar en caché; aria-busy limitado a la media. Una revisión invalida callbacks antiguos al navegar/cerrar. Error Core persistente conserva cierre, contador y navegación; Next permite recuperar cuando está disponible. Al ocultarse se retira src. Slot de ancho completo y proporción reservada antes de cargar, con altura máxima 54dvh/38rem; foto centrada contain. Cuerpo de modal scrollable y controles fuera de él.

**Estados demostrados:** colección real de seis fotos; fotografía ausente sin control; una foto (01/01, navegación disabled); error real de decodificación seguido de una foto válida; vacío sin visor. El error demo carga un archivo de texto local existente que responde 200: no inventa una URL 404 ni afecta al catálogo principal. Sus dos fuentes son un caso de fallo/recuperación, no dos fotos comerciales. Varias raíces independientes comparten la estructura del visor, con IDs únicos aportados por el consumidor. No modales anidados.

**Integración:** `style-guide.js` inicializa las raíces explícitamente. `main.js` no importa la galería. Nuevo CSS de producto en `_visor-galeria.scss` y `_comunidad.scss`, además de los patrones refinados; sin CSS específico de laboratorio en producto. Los helpers PHP evitan repetir visor/figuras en la guía; no son una aplicación ni backend nuevos. Foundation/Core/Waves 1/2 y archivos de video no se rediseñan. QA y mediciones finales se registran después de su ejecución.

### Matriz vigente del refinamiento

| Familia | Variantes y estados conservados/comprobados | Interacción y límites |
|---|---|---|
| Experiences | Invitación dominante, descubrimiento lateral, textual sin fotografía; destacada aprobada; pendiente, no disponible, contenido largo | Acciones Core, hover/active/focus existentes; sin reserva ficticia ni loading artificial |
| Storytelling | Bajada 5/7, fotografía dominante, manifiesto y split Wave 1; texto largo | Estático; sin estados dinámicos inventados |
| Gallery | Colección real, ausente sin control, una foto, vacío; carga diferida, error y recuperación | Hover/active de miniatura, foco, apertura/cierre, anterior/siguiente, contador/caption; disabled nativo con una foto; variantes de orientación |
| Video | Contrato y estados pendientes/ausencia/error previos, intactos | Sin archivo apto ni player falso; subtítulos pendientes, sin autoplay ni descarga de MP4 |
| Community | Interior y mesa de archivo, invitación contextual, texto largo | Consulta real, sin opiniones, nombres o permisos supuestos |
| Values | Introducción y lista con primer atributo dominante, dos intermedios y cierre; texto largo | Enlace Core; estático, sin métricas ni loading |

### QA final y autoevaluación — 2026-10-16

- `npm run lint`, `npm run build` y `php -l` en los cinco partials nuevos/modificados: correctos. Dev arranca en localhost:3000; aviso conocido Node DEP0060 de BrowserSync, sin error de aplicación.
- Inspección real de las seis familias en 320, 360, 390, 425, 768, 820, 992, 1024, 1280 y 1440px: 60 vistas, sin overflow ni fotos fallidas. Radios renderizados 4px. Se corrigieron gutters que desbordaban 4px en 992px y un vacío excesivo entre invitaciones secundarias.
- Visor revisado en esos diez anchos y 390×568: dentro del viewport, contain, controles 44×44 y caption fuera de la foto. Se corrigieron márgenes laterales de tablet, espacio vertical excesivo en móvil y centrado de la foto al alcanzar la altura máxima. Texto deliberadamente largo y palabra sin espacios: sin overflow en 320/768/1280.
- Pruebas reales: primera/intermedia/última (01/06, 04/06, 06/06), anterior/siguiente circular, flechas, Enter/Space, cierre por botón/Escape/backdrop, retorno al activador, Tab/Shift+Tab con trap Bootstrap, una foto con navegación disabled y vacío sin controles. Cuatro raíces independientes; tres reaperturas sin duplicación. Inicialización repetida devuelve la misma instancia; flechas no interceptan un campo editable ni el documento con visor cerrado.
- Fallo real de decodificación HTTP 200 conserva cierre y navegación; siguiente recupera la fotografía. Fixture temporal con demora de 2,2s verifica spinner/aria-busy, navegación durante carga sin sobrescritura tardía y cierre durante carga con limpieza de src. Fixtures retirados del repositorio tras guardar evidencia externa; no añade endpoints productivos.
- Regresión Core: modal informativo, trap, Escape/retorno de foco, confirmación con foco inicial en Keep item, cancelación, accordion y quantity funcionan. Adaptador y estilos Core sin cambios. Consola del navegador sin errores/warnings de aplicación. Los 50 recursos locales referenciados (incluidos derivados y sprite) responden HTTP 200.
- Semántica: un h1, ningún ID duplicado ni fotografía activa sin alt. 113 muestras de texto editorial sobre superficies sólidas: contraste mínimo 9,25:1. Foco de teclado 2px champagne/offset 3px. Reduced motion auditado en la regla Foundation existente; no se emuló la preferencia del sistema. El comando de zoom nativo no alteró el viewport: 200% queda sin verificar, sin presentarlo como prueba ejecutada. No se realizó auditoría con lector de pantalla.
- Autoevaluación creativa: experiencias diferencia invitación principal y descubrimientos compactos; historia recupera relación título/prosa; colección fotográfica conserva ritmo y alineación; comunidad explica encuentro/contexto/acción; valores distribuye pesos sin cajas repetidas. Video conserva su honestidad editorial. Aprobación estética exclusivamente pendiente del usuario.

### Performance del refinamiento

Medición gzip nivel 6, base publicada 7d672fa frente al refinamiento. Compilación de entrada de guía antes/después en las mismas condiciones, sin sourcemap; producto medido tras build, antes de restaurar dev.

| Recurso | Antes | Después |
|---|---:|---:|
| CSS de producto, bytes / gzip | 65.074 / 12.017 | 71.414 / 12.767 |
| JS de producto, bytes / gzip | 0 / 20 | 0 / 20 |
| JS de guía sin minificar, bytes / gzip | 65.663 / 15.122 | 71.911 / 16.649 |
| Fotos únicas / peso AVIF preferido de toda la guía | 16 / 1.477.410 B | 16 / 1.477.410 B |
| Elementos img con fuente / solicitudes de media | 34 / 16 | 34 / 16 |
| Recursos de guía tras cargar todas las fotos, sin documento/BrowserSync/favicon | 22 | 22 |

La galería principal contiene seis fotografías existentes: mesa, maridaje, arroz, bocadillo, vino y panorama; comunidad reutiliza interior/panorama. No se modifica ningún original ni se genera media. Las nuevas referencias reutilizan recursos en caché. Error demo solicita texto únicamente al abrirlo; sin 404 deliberado. Sin recursos de video activos. Build excluye CSS/JS de guía; main.js sigue intacto. La nueva galería vive solo en la entrada dev. Incrementos gzip: CSS +750 B, guía +1.527 B, producto JS +0 B. Estas son mediciones locales de recursos, no LCP/INP/CLS productivos. La altura reservada durante la carga lenta se comprobó estable; al cambiar de orientación puede reajustarse intencionalmente el slot.

Pendientes reales: aprobación visual integral, zoom 200% verificable, prueba de lector de pantalla; video autorizado/poster/subtítulos y permisos de fotografía identificable antes de publicar ese contenido. Inventario técnico y evidencia detallada conservados fuera del árbol productivo. Ninguna página productiva, archivo legacy, dependencia, original multimedia ni configuración de hosting cambia.

## Wave 3 — Experiencias y storytelling editorial

Base verificada el 2026-10-15: `develop` / `origin/develop` en `cb1edde`, merge de Wave 2 (#8); árbol limpio tras fetch y fast-forward. Rama `feature/ui-section-patterns-wave-3`. El encargo actual confirma Foundation/Core/Waves 1 y 2 como sistema aprobado; los registros anteriores se conservan como historial. Wave 3 espera una sola aprobación visual humana integral.

### Matriz de estados y decisiones previas

Matriz definida antes de construir las composiciones. Los enlaces reutilizan hover/active de `cl-enlace`, foco Foundation y targets de 44px; las fotos no son controles. N/A significa que no hay una operación que justifique ese estado.

| Familia | Default y variantes | Hover / focus / active | Disabled / disponibilidad | Media ausente | Loading / empty / error | Contenido largo / insuficiente | Vertical / horizontal |
|---|---|---|---|---|---|---|---|
| Experiences | Vertical, destacada horizontal y sin foto; grid mixto con Bootstrap | Solo enlaces Core | Sin CTA si falta confirmar; no disponible explícito solo como ejemplo simulado, sin inventar cupos | Se retira media y usa `--sin-imagen`, mensaje contextual | Loading N/A; colección vacía/error futuro usa Core, no nueva demo dinámica | Altura natural, wrap; omitir eyebrow/CTA opcionales, no inventar descripción | Vertical 3:4 y destacada 4:3; revisar foco por foto |
| Storytelling | Foto dominante y bajada, manifiesto no atribuido; split existente Wave 1 | Solo enlaces Core | N/A | Retirar figura, conservar narrativa; reutilizar fallback de galería si la foto necesita explicación | N/A: narrativa estática | Sin truncado; no publicar historia sin hechos comprobados | Foto natural; split existente verifica recorte |
| Gallery | Mosaico, principal mayor, panorama completo, captions opcionales | N/A, sin lightbox | N/A | Slot estable, texto y caption; sin URL rota | Loading N/A; vacío Core demostrado; error de foto usa slot ausente | Caption fluye; una sola foto puede ser principal, no rellenar con duplicados | Dimensiones reales; imágenes completas, sin crop ni deformación |
| Video | Poster/estado pendiente; contrato nativo inerte preparado | Controles nativos cuando exista clip apto; enlaces Core de recuperación | No mostrar play falso si falta material | Imagen estática o Core sin poster; sin video apto demostrado | Sin loading inventado; error de reproducción estático Core; sin subtítulos requerido = publicación pendiente | Título/contexto fuera del reproductor; no inventar transcripción | 16:9 y `--vertical` con relación 478:850; contain |
| Community | Dos fotos y contexto editorial, reutiliza galería/historia | Solo enlace Core | N/A, no reseñas ni estados de moderación | Retirar figura o usar mismo slot de galería | N/A: archivo estático | Alturas naturales; omitir nombres/citas no verificados | Proporción original, sin personas identificables |
| Values | Introducción dominante + lista editorial con separadores | Solo enlace Core | N/A | No necesita foto | N/A | Lista variable, sin cajas de altura fija; no fabricar atributos para completar cuatro | N/A |

Reproducción/pausa son estados nativos del contrato, no simulados con fotos. Al no disponer de un clip revisado y autorizable, no se presenta un reproductor activo: el alcance permite explícitamente un estado representativo honesto. No hay pruebas de reproducción/pausa sobre la entrega final; serán necesarias al conectar un clip apto. No se añade loading a contenido editorial estático ni disabled a enlaces. Core sigue resolviendo alertas y vacío/error.

### Composición, variantes y reutilización

- `cl-experiencia`: fotografía protagonista separada del contenido con línea editorial, sin precio/pie de catálogo. `--destacada` 3:2 desde md, apilada antes; `--sin-imagen` elimina la media y conserva una invitación tipográfica. Grid Bootstrap 1 columna, 2 desde md, 3 desde lg; el caso sin imagen ocupa el ancho de tablet. No hay otra tarjeta para cada página.
- `cl-historia`: foto panorámica sin recorte, bajada de título y prosa, manifiesto con Libre Bodoni y sin `blockquote`/atribución inventada. La historia de varias imágenes continúa con **el mismo** `cl-media-contenido` de Wave 1. Identidad española, tapas/vino y Mount Shasta están respaldados por `about.html`, `menu.html`, `index.html` y `swc.html`. No se afirman fechas de fundación, premios, origen personal ni nombres/citas de clientes.
- `cl-galeria-editorial`: CSS Grid mobile-first, 1/2/3 columnas en base/md/lg; principal ocupa 2 desde md, panorama ocupa todas. DOM y orden visual coinciden; sin dense, masonry, carrusel, JS ni lightbox. Comunidad usa `--encuentro`, dos proporciones 3:2 desde md y fotos completas con captions; no es un componente de testimonios.
- `cl-media-video`: pantalla contain, contexto y fallback Core. Caption/título fuera de la imagen para conservar contraste. Contrato `<template>` inerte con `<video controls playsinline preload="none">`; no inicia descargas ni produce controles inutilizables. No se clona por JS. Añadir source/poster reales, dimensiones, `track` revisado cuando corresponda y alternativa textual antes de usarlo. Reutiliza el mismo patrón para horizontal/vertical, sin player propio.
- `cl-valores`: introducción de mayor peso + lista semántica de atributos respaldados por el contenido existente. Sin iconos de relleno, estadísticas ni premios. Sus gutters también componen bajadas editoriales; no cambia tipografía/superficies Foundation.

Cinco SCSS bajo `patterns/`, importados después de Wave 2: `_experiencia.scss`, `_historia.scss`, `_galeria-editorial.scss`, `_media-video.scss`, `_valores.scss`. Sin cambios en Foundation/Core/Waves 1/2 ni arquitectura nueva. La guía incluye `editorial-wave-3.php` como entrada, más cuatro partials por composición: experiencias, historias, galería/media, comunidad/valores. El helper local de fotos evita repetir `<picture>`; inventario cerrado y strings escapados, no motor de plantillas ni backend.

### Contratos de media, permisos y contenido

Fotografía local auténtica: `assets/images/`, originales intactos. Derivados AVIF/WebP existentes; no se generan alternativas ni se añaden fotos externas. Cada imagen declara dimensiones reales, `loading="lazy"` y `decoding="async"` porque la wave está bajo el primer viewport. Un futuro Hero LCP debe usar carga oportuna evaluada en su página, sin lazy automático.

| Foto bajo assets/images | Dimensiones | Composición |
|---|---:|---|
| `gallery/tapas/the-clandestino-tapas-6.jpeg` | 2048×1536 | Experiencia destacada, comunidad |
| `gallery/tapas/the-clandestino-tapas-table-1.jpeg` | 2048×1536 | Foto principal de galería |
| `gallery/tapas/the-clandestino-tapas-table.jpeg` | 1998×628 | Historia dominante y panorama sin crop |
| `gallery/wines/the-clandestino-wines-table.jpeg` | 1536×2048 | Wine Club y galería |
| `gallery/tapas/the-clandestino-tapas-wines.jpeg` | 1536×2048 | Tapas & wine y galería |
| `bg/clandestino-usa.jpg` | 1880×920 | Historia, comunidad y still audiovisual |
| `gallery/tapas/the-clandestino-bocadillo.jpeg` | 1200×1600 | Galería |
| `gallery/tapas/the-clandestino-paella.jpeg` | 2048×1536 | Archivo gastronómico, sin oferta actual implícita |

Fotos revisadas visualmente: alimentos, vino y ambiente sin personas identificables. `gallery/clandestino-swc.jpg` se descartó por mostrar invitados sin consentimiento documentado. El uso contextual de los assets propios existentes respalda las demos; no acredita permisos de personas ni licencia audiovisual. Copy creativo se identifica como editorial; no se presenta como cita factual. No se promete carta actual, formatos de evento, disponibilidad/cupos ni degustación programada.

Para reutilizar: aportar título y nivel apropiado, copy verificable, URL existente/CTA opcional, foto con dimensiones/alt/foco y permiso aplicable. Si no hay foto, renderizar fallback **en servidor** sin `src` roto; si falla durante la transferencia, las dimensiones mantienen espacio y el alt sigue disponible. El slot 4:3 de demo es un ejemplo: reservar la proporción de la foto sustituida en la integración real. No forzar todas las fotografías a una orientación. Captions no necesitan repetir el alt.

### Auditoría audiovisual y tratamiento

Inventario: 20 MP4 locales en `assets/images/gallery/videos/`, sin archivos VTT/SRT encontrados bajo assets. Legacy `index.html` contiene videos de clientes con `preload="metadata"`; `about.html` contiene promos con `preload="none"` y posters a menudo genéricos. No se importan esos scripts ni se asume que esos posters correspondan al clip.

Se inspeccionaron en navegador `clandestino-experience.mp4` (1,316,107 bytes; 478×850; 6.059s): personas identificables, descartado; y `clandestino-wine-promo.mp4` (7,554,540 bytes; 478×850; 35.4s): montaje de botellas con efectos, sin texto de subtítulos asociado. No se certificó todo su audio, permisos ni adecuación del montaje/poster. Los otros clips no se consideran autorizados por el solo hecho de estar en el repo. Testimonios se reservan a Wave 5.

Por ello la entrega usa una **foto estática explícitamente rotulada**, estado Video pending, ejemplo de error y alerta Captions pending. Cero URLs MP4/source activas, descargas iniciales de video = 0 por contrato de markup. Sin botón play decorativo ni afirmación de que existen subtítulos. La alternativa textual describe la foto y declara que no describe un film sin revisar.

Antes de conectar video: revisar todas las escenas/audio, autorización de personas/música, poster correspondiente, captions si hay habla/sonido informativo, descripción o alternativa de información visual, y comprobar teclado/play/pausa/error real. Conservar enlace de recuperación fuera de `<video>`: su fallback interno no se muestra necesariamente ante un error de red/codec. `preload="none"`, sin autoplay, sin bibliotecas; metadata solo si una necesidad medida justifica esa descarga.

### Accesibilidad, responsive y verificación

Semántica: h2 por familia, h3 para ejemplos, un solo h1 de página, figuras/captions, listas nativas y secciones nombradas. Texto sobre superficies sólidas, nunca sobre foto nueva. Sans del sistema y Libre Bodoni existentes; sin segunda tipografía. Foco/reduced motion de Foundation intactos; no hay nueva animación. Texto sin ellipsis/line clamp, columnas `minmax(0, …)` y wrap para contenido largo. Tab/Shift+Tab y Enter/Space en enlaces/disclosures nativos, sin trampas ni scripts nuevos.

Revisión integral: `http://localhost:3000/style-guide/patterns.php#wave-3`; navegación Experiences / Storytelling / Gallery / Video / Community / Values. Abrir los disclosures de estados en experiencias, galería y video. Foundation/Core permanece en `/style-guide/`. Validar 320/360/390/425/768/820/992/1024/1280/1440px, zoom 200% si la herramienta lo permite, consola, fotos, teclado y foco. Comandos: `npm run lint`, `npm run build`, `php -l` en los seis PHP nuevos/modificados, `npm run dev`. El registro final de mediciones/QA se añade tras ejecutar.

Pendientes de contenido reales: material audiovisual apto y derechos/captions/poster; consentimiento para futuros invitados identificables; fechas, formatos y disponibilidad de experiencias; historia ampliada con evidencia. Estos pendientes no se sustituyen por datos ficticios. La biblioteca editorial permanece reutilizable entre páginas futuras; no migra páginas productivas ni crea negocio.

### Registro técnico — 2026-10-15

Skill `qa-visual`, Chromium integrado; las pruebas de viewport se hicieron en una pestaña dedicada y se comprobó el ancho efectivo, incluyendo el scrollbar nativo. Se descartaron capturas preliminares con scroll suave en tránsito. Un fixture PHP temporal conservó el mismo HTML/CSS y desactivó únicamente el scroll suave para capturas estables; instrumentó Resource Timing/Layout Instability y permitió cargar todas las fotos. Los fixtures se retiraron del repositorio antes de la entrega. No se añadió código de medición al producto ni a la guía definitiva.

| Comprobación | Resultado |
|---|---|
| Preflight | PASS: fetch, develop ff-only, Wave 2 como ancestro y base `cb1edde`; feature desde árbol limpio |
| `npm run lint` | PASS final, ESLint/Stylelint sin cambios de reglas |
| `npm run build` | PASS final: producto/sprite; sin CSS/JS guía, sourcemaps ni selectores cl-guia/cl-muestra en CSS productivo |
| PHP | PASS: patterns.php y los cinco partials nuevos |
| Dev/watch | PASS: PHP + BrowserSync en localhost:3000, recompilación y reload observados |
| 320 / 360 / 390 / 425 / 768 / 820 / 992 / 1024 / 1280 / 1440px | PASS: 60 capturas por familia, inspección de seis hojas de contacto y vistas detalladas; sin overflow horizontal ni elementos fuera del viewport |
| Media | PASS: dimensiones de originales y 16 derivados Wave 3 verificadas; imágenes cargadas, sin distorsión; galería natural sin crop; slot vertical contain verificado en los diez anchos |
| Estados abiertos | PASS: pendientes/no disponible simulado, imagen ausente, colección vacía, video pendiente/error/captions pendientes; geometría en los diez anchos y capturas detalladas 320/768/1280 |
| Teclado | PASS: Tab por doce enlaces/disclosures de Wave 3, Shift+Tab de retorno, navegación local por Enter; disclosures nativos por Enter/Space, sin traps |
| Foco / targets | PASS: anillo champagne 2px/offset 3px, visible con aire dentro del viewport; mínimo observado 44.89px en acciones nuevas; summaries ≥52.89px |
| Contraste | PASS: 108 textos/combinaciones medidos, mínimo 9.25:1, sin fallos; texto sobre superficies sólidas, incluido feedback Core |
| Semántica | PASS: un h1, IDs únicos, sin saltos de headings, alt/dimensiones completos, listas/figuras nativas y secciones nombradas |
| Contenido largo | PASS: título extendido y palabra sin espacios, descripción/caption largos y valor extenso a 320/768/1280; sin overflow ni truncamiento. Fixture retirado; contenido insuficiente representado por fallback y datos pendientes |
| HTTP / consola | PASS: 69 URLs locales de atributos/destinos comprobadas con HTTP 200; todas las fotos de la guía cargadas; cero errores/warnings de página observados |
| Reduced motion | Foundation intacta, sin animación/transición nueva; cascada existente conservada. No se emuló otra preferencia del sistema |
| Zoom 200% | PENDIENTE: Ctrl+Equal no modificó viewport/escala del navegador integrado; no se declara probado ni se sustituye por reducir ancho |
| Video play/pause | NO APLICA a la entrega estática: cero videos activos. Se inspeccionaron dos archivos de archivo, sin certificar su publicación; probar el contrato nativo al conectar material apto |
| Protección | PASS: solo patrones nuevos, imports, presentación exclusiva de guía, PHP de guía y este documento. Ninguna página/PHP/CSS/JS legacy, imagen/video original, sitemap, robots, .htaccess, dependencias ni tooling modificados |

Limitaciones: no se ejecutaron Safari/Firefox, lector de pantalla auditivo, dispositivos físicos ni Apache/GoDaddy. El servidor dev conserva el aviso preexistente Node `DEP0060` (`util._extend`); build/lint no fallan. Los intentos sandbox de build/dev fallaron por lectura ascendente de esbuild; las ejecuciones finales con acceso necesario pasaron sin modificar el pipeline. QA técnico no constituye aprobación visual humana.

### Performance medida

Mismo `npm run build`, Node `gzipSync` nivel 6, sin mezclar CSS dev con CSS minificado. JS de guía medido en dev con el mismo pipeline; sus fuentes son idénticas a la base y no incorpora Wave 3.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Diferencia gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 61050 | 65074 | 11476 | 12017 | +541 (+4.71%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |
| JS guía DEV | 65693 | 65693 | 15145 | 15145 | 0 |

El flujo gzip vacío mide 20 bytes; no contiene JavaScript productivo. SHA-256 de `dist/main.js` antes/después: `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. El crecimiento CSS corresponde a las cinco composiciones; las reglas de los disclosures quedan exclusivamente en `_guia.scss`. Cero paquetes, JS nuevo, fuentes nuevas, iconos nuevos o imágenes generadas.

| Media Wave 3 | Original bytes | AVIF bytes | WebP bytes |
|---|---:|---:|---:|
| Tapas 6 | 242225 | 64977 | 97166 |
| Table 1 | 554353 | 244824 | 296066 |
| Table panorámica | 251080 | 124724 | 140428 |
| Wines table | 333116 | 100031 | 138878 |
| Tapas wines | 213748 | 47301 | 81462 |
| Interior | 138907 | 41770 | 56918 |
| Bocadillo | 180195 | 44655 | 73856 |
| Paella de archivo | 406969 | 140784 | 193066 |
| **8 fotos únicas Wave 3** | **2320593** | **809066** | **1077840** |

Estos son payloads alternativos, no acumulados; el navegador selecciona una fuente por picture. Wave 3 usa quince instancias de esas ocho fotos; cinco fotos ya estaban en Waves 1/2. Patterns completo pasa de 19 a 34 imágenes y de 13 a 16 fotografías únicas. Las tres incorporaciones a la guía (Table 1, Tapas wines, Paella) suman **432909 bytes AVIF**; no son archivos nuevos del repositorio. Todas son lazy por estar bajo el primer viewport.

Resource Timing en viewport 1280×1000, guía base y final con todas las fotos solicitadas mediante el mismo fixture, caché compartida sin throttling: **19→22 recursos** excluyendo BrowserSync/favicon y sin contar el documento. Son 13→16 requests de imagen y los mismos seis recursos de estilos/JS/fuente/sprite; el tooling de BrowserSync produce polling variable y se registra aparte en los JSON. Peso de fotografías preferidas de la página completa: **1044501→1477410 bytes**, +432909. No es una prueba de descarga fría ni un presupuesto de primera pantalla. Las 69 URLs comprobadas por HTTP incluyen formatos alternativos, destinos y fragmentos de sprite; no equivalen a 69 requests de render.

Video: **0→0 requests y bytes** en la guía, incluso tras cargar todas las imágenes y abrir estados. El template inerte no contiene source/poster ficticios. Los MP4 inspeccionados solo se abrieron en una pestaña independiente de auditoría que se cerró.

Estabilidad local: observador Layout Instability (ventanas estándar, excluye interacción reciente) registró **0→0** en el fixture de carga, con dimensiones/proporciones reservadas y sin saltos visibles durante la inspección. No son valores LCP/INP/CLS productivos ni una auditoría de usuarios reales. No se midieron LCP/INP de producción.

### Archivos, entrega y revisión humana

Nuevos: cinco SCSS `patterns/` citados arriba; `style-guide/partials/editorial-wave-3.php`, `experiencias-wave-3.php`, `historias-wave-3.php`, `galeria-media-wave-3.php`, `comunidad-valores-wave-3.php`. Modificados: `assets/scss/main.scss`, `assets/scss/components/_guia.scss`, `style-guide/patterns.php`, este documento. No se elimina ningún fuente. Los fixtures temporales no se publican. No existe una decisión arquitectónica nueva que requiera duplicar esta información en ARQUITECTURA.

Evidencia local fuera del repo: `C:/Users/Mike/.codex/visualizations/2026/10/16/01a142de-ae6e-7192-8ba5-4b09bcdaf63a/`; `wave3-*`, `sheet-*`, `states-*`, `final-states-*`, `stress-*`, `responsive.json`, `states-final.json`, `portrait.json`, `keyboard.json`, `accessibility.json`, `http.json`, `performance-before.json`, `performance-after.json`, `bundles.json`. El registro usa la fecha local del usuario (2026-10-15).

Publicación autorizada: dos commits coherentes, normal push solo a `feature/ui-section-patterns-wave-3`; sin PR, merge, force ni deploy. Abrir `http://localhost:3000/style-guide/patterns.php#wave-3`, recorrer las seis familias y desplegar sus estados. **Wave 3 técnicamente lista; aprobación visual integral del usuario pendiente.**

## Wave 1 — Patrones estructurales

Wave 1 implementa cuatro familias de presentación sobre Foundation/Core. **Aprobada visualmente por el usuario en UI-PATTERNS-05, sujeta a la validación final de retirada de las bandas antiguas**. El QA técnico verifica este cierre; no autoriza crear PR, merge, deploy ni iniciar Wave 2. Base comprobada: `develop` / `origin/develop` en `0053822`; rama `feature/ui-section-patterns-wave-1`.

## Composición y contratos compartidos

- `assets/scss/main.scss` importa `patterns/*` después de Foundation/Core. El resultado está en `style.new.css`; sin estilos exclusivos del laboratorio.
- `/style-guide/` presenta Foundations/Core; `/style-guide/patterns.php`, Section Patterns. Solo Patterns incluye `partials/patrones-wave-1.php` con `require`/`__DIR__`. Ambas comparten un pequeño partial local de navegación con enlaces reales y `aria-current="page"`; sin tabs JS ni demos duplicadas.
- Contenedores y columnas Bootstrap: `.container`, `.row`, `.col-md-*` y `.col-lg-*`. Solo breakpoints existentes `md` y `lg`, con sus mixins. Cabeceras de demos centradas exclusivamente bajo `.cl-guia-patrones` en `_guia.scss`; Foundation/Core conserva su presentación.
- Tokens existentes para superficies, bordes, espaciado y texto. Sin modificar tokens/base, raíz, familias tipográficas ni escala; `cl-display` y `cl-titulo-1` son Foundation.
- Clases propias BEM en español; máximo tres niveles de anidación. Sin nuevas utilidades globales, dependencias, JS ni render dinámico.
- Cada sección lleva un título y `aria-labelledby` único. La página decide el nivel; la guía usa h2 para familias y h3 para ejemplos bajo su único h1.
- Navegación mediante enlaces reales: `tapas.html`, `wines.html`, `menu.html`, `contact.html#contact-form`. Consultar una mesa o evento no confirma disponibilidad ni una reserva. No hay transacciones ni descuentos ficticios; las invitaciones destacadas enlazan a información o consultas reales.

## `cl-seccion`

**Propósito:** ritmo vertical, encabezado editorial y acciones para contenido variable.

Estructura: `section.cl-seccion[aria-labelledby] > .container`, con `.cl-seccion__encabezado`, eyebrow opcional, heading nativo, `.cl-seccion__descripcion` y `.cl-seccion__acciones` opcionales; contenido después del encabezado.

Variantes: izquierda por defecto; `cl-seccion--centrada` centra texto/acciones y permite limitar el encabezado con una columna Bootstrap; `cl-seccion--alterna` usa fondo alterno. Ambas tienen un caso real en la guía. Padding vertical `--espacio-7`, y `--espacio-8` desde lg. No impone ancho editorial propio ni tamaño de título.

Reutiliza `cl-eyebrow`, `cl-boton`, headings y grid. `.cl-seccion__acciones` es el grupo compartido por las cuatro familias: flex vertical en teléfono y horizontal desde md, con gap del sistema. Su ancho máximo es 32rem (dos acciones); cada botón desde md crece proporcionalmente hasta 16rem. Son límites de composición, no nuevos tokens/escala: impiden botones desmesurados y conservan dos anchos equilibrados. En una sección centrada, el grupo tiene margen automático y un botón único queda centrado. En teléfono, botones a ancho completo del contenedor permitido. Se conserva la estética del encabezado. Descripción secundaria ≥4.5:1. Sin JS ni estados comerciales.

```html
<section class="cl-seccion" aria-labelledby="titulo-tapas">
  <div class="container">
    <div class="cl-seccion__encabezado col-lg-8">
      <p class="cl-eyebrow">At the table</p>
      <h2 id="titulo-tapas">A taste of Spain</h2>
      <p class="cl-seccion__descripcion">Tapas to share and wines to discover.</p>
      <div class="cl-seccion__acciones">
        <a class="cl-boton" href="/tapas.html">Explore the tapas</a>
      </div>
    </div>
  </div>
</section>
```

## `cl-hero`

**Propósito:** introducción fotográfica editorial principal o interior, sin slider, video, parallax ni animación.

Estructura: `section.cl-hero[aria-labelledby]`, `picture.cl-hero__media > img.cl-hero__imagen`, y `.container.cl-hero__estructura > .row > .cl-hero__contenido.col-12.col-md-10.col-lg-7`. Dentro: eyebrow, título elegido por la página, descripción y acciones compartidas.

Variantes: editorial por defecto con `cl-display`; `cl-hero--interior` reduce padding y jerarquía del título con `cl-titulo-1`. El editorial aplica localmente `clamp(2.25rem, 1.6rem + 2.4vw, 4rem)` y ancho 14ch; el interior `clamp(1.875rem, 1.4rem + 1.6vw, 3rem)` y 20ch. Ajustes contextuales pedidos para el banner; no se cambia Foundation. Sin `<br>` rígido ni exigencia de h1. Un CTA interior y dos editoriales.

En **todos los tamaños**, fotografía y estructura comparten celda de grid `1 / 1`. La imagen absoluta rellena la altura reservada por el contenido en flujo; nunca se apilan como filas independientes ni se fija una altura que corte texto. Móvil: contenido centrado; tablet: columna de 10/12 centrada con mayor aire vertical; desde lg: 7/12 editorial a la izquierda. En teléfonos de poca altura, el documento puede requerir scroll vertical normal para recorrer el banner y sus acciones.

El contenido tiene fondo transparente. Un pseudo-elemento elíptico local se extiende `--espacio-8` alrededor de la copia, con opacidad 55% → 45% al 75% del radio → transparente; desde lg su centro horizontal pasa al 35%. Así protege también el inicio de las líneas sin un rectángulo ni un filtro oscuro global. Usa el neutro existente; no introduce una paleta. El resto de la fotografía conserva su luz. La descripción usa texto principal y el CTA secundario tiene su propia superficie/borde legibles. `overflow: clip` limita únicamente la extensión tonal del banner; padding conserva los anillos de foco dentro de sus bordes, verificados con teclado.

Imagen editorial: `bg/clandestino-usa.jpg`, foco central en barra/copas. Interior: `bg/the-clandestino-usa.jpg`, foco central en botellas. `object-fit: cover` no deforma; `--hero-foco` local opcional permite adaptar el punto focal a otra foto sin CSS por página. No es un token nuevo del sistema. Verificar el recorte cada vez que cambie la foto. Alt informativo en estos ejemplos; `alt=""` cuando una imagen futura sea puramente decorativa.

Accesibilidad: comprobar contraste contra el recorte real y cada formato, foco visible sin clipping, DOM imagen → narrativa → enlaces. `--hero-proteccion-posicion` es un ajuste local del patrón, no un token global. Rendimiento: dimensiones explícitas y altura reservada por contenido antes de cargar la foto; sin JS. Las demos siguen bajo el primer viewport y usan lazy loading. Si el Hero futuro es LCP, **quitar `loading="lazy"`** y evaluar carga normal/eager y `fetchpriority="high"` en la página real.

## `cl-media-contenido`

**Propósito:** narrativa con foto gastronómica/restaurante, párrafos, lista semántica breve y CTA opcionales.

Estructura: `.row.cl-media-contenido`, `.col-md-6.cl-media-contenido__media > picture > img.cl-media-contenido__imagen` y `.col-md-6.cl-media-contenido__contenido`. Envolver en una sección identificada y `cl-seccion` para ritmo/superficie. La imagen permanece primero en el DOM.

Variantes: foto izquierda por defecto; `cl-media-contenido--invertido` cambia solo `order` desde md, junto con las columnas. Teléfonos apilan; **desde 768px son dos columnas**. Gutter horizontal `--espacio-6` desde md, copy de 1rem/1.65 contextual en tablet y 1.0625rem desde lg. Imagen cuadrada en tablet, 4:3 en teléfono/escritorio; redondeo `--radio-md`. Alineación vertical centrada y CTA con límite compartido. El orden accesible sigue imagen → texto y enlaces en su orden lógico; las fotos no son controles. No invertir si controles futuros producen un orden visual/teclado incoherente.

Reutiliza grid, eyebrow, headings nativos y acciones/botón Core. Lista `<ul><li>` nativa, sin componente nuevo. La demo izquierda incluye lista y CTA; derecha presenta narrativa sin CTA/lista.

Fotos sin personas: tapas (`bg/clandestino-tapas.jpg`) y vinos (`bg/the-clandestino-usa.jpg`). Cover sin deformación y foco central; `--media-foco` permite ajuste local por foto. Width/height reales, ancho 100% y proporción reservada; lazy loading fuera del viewport. Sin fuentes responsive ficticias ni variantes de foto.

## `cl-banda-cta`

**Propósito:** invitación compacta a explorar o consultar, sin prometer operaciones completadas.

El patrón vigente es exclusivamente fotográfico: `cl-banda-cta cl-banda-cta--destacada`, con orientación normal o `cl-banda-cta--invertida`. Las dos bandas centradas sin fotografía se retiraron de la guía y del contrato de uso. Se conservan padding, tipografía contextual y reglas compartidas necesarias; se eliminan solo declaraciones antiguas sobrescritas por la destacada.

**`cl-banda-cta--destacada`** sirve para una historia comercial que merece contexto fotográfico: Wine Club, encuentros privados o comida para llevar. Mantiene título, descripción y uno/dos enlaces; añade `.cl-banda-cta__media`, `.cl-banda-cta__imagen`, `.cl-banda-cta__contenido` y `.cl-banda-cta__nota` opcional. Estructura: `.container > .row.g-0.cl-banda-cta__fila > .col-md-5.cl-banda-cta__media + .col-md-7.cl-banda-cta__contenido`. El contenido agrupa eyebrow, heading elegido por la página, descripción, nota contextual y acciones compartidas. No es una tarjeta Core duplicada: su responsabilidad es componer media y llamada a la acción; usa la misma superficie/radio y botones/eyebrow existentes.

Teléfono: foto 4:3 arriba, texto a la izquierda con padding 2rem/1.5rem, botones apilados. Desde md: split 5/12–7/12; altura determinada por el contenido en flujo, imagen absoluta cover sin deformación. En tablet md, acciones siguen verticales para conservar etiquetas cómodas; desde lg vuelven al grupo horizontal equilibrado y el padding pasa a 3rem. Se usa la tipografía de la banda existente. Sin altura rígida, overlays, sombras ni iconos añadidos: la riqueza viene de fotografía auténtica, ritmo y una nota útil separada por borde sutil. El radio md se aplica a superficie y esquinas externas de la foto sin recortar el foco.

**`cl-banda-cta--invertida`**, combinada con destacada, mueve únicamente media a la derecha desde md y ajusta sus esquinas. En móvil siempre foto primero. DOM imagen informativa → narrativa → enlaces; la fotografía no es interactiva. Una única implementación; no hay variante compacta ni estilos por página.

Guía: se muestran únicamente tres destacadas estáticas mediante `partials/bandas-cta-destacadas.php`, requerido dentro del bloque CTA de `patrones-wave-1.php`. Wine Club con dos enlaces, Private Events invertida con uno, Take Away con dos. Destinos existentes: `swc.html`, `wines.html`, `contact.html#contact-form`, `menu.html#tapas-title`. No formulario, suscripción inmediata, disponibilidad garantizada ni checkout. La nota pide contexto o invita a consultar detalles.

Fotos verificadas, sin personas, con fuentes AVIF/WebP reales, dimensiones explícitas y lazy/async por estar bajo el primer viewport:

| Foto (ruta bajo assets/images) | Dimensiones | JPEG bytes | WebP bytes | AVIF bytes |
|---|---:|---:|---:|---:|
| gallery/wines/the-clandestino-wines-table.jpeg | 1536×2048 | 333116 | 138878 | 100031 |
| gallery/tapas/the-clandestino-tapas-table.jpeg | 1998×628 | 251080 | 140428 | 124724 |
| gallery/tapas/the-clandestino-bocadillo.jpeg | 1200×1600 | 180195 | 73856 | 44655 |

Fuentes alternativas bajo `webp/gallery/…` y `avif/gallery/…`, mismo nombre/dimensiones y extensión correspondiente. Foco central: copas/botella, tabla compartida y bocadillo. La tabla panorámica se recorta deliberadamente al plato central en el split; no usar esta composición cuando sea imprescindible mostrar todos los productos. No se alteran originales. Revisar cada nueva foto y texto antes de reutilizar. Texto sobre superficie sólida, alt informativo, h3 subordinado en guía y foco Core; targets ≥44px. Sin JS. **Diseño aprobado visualmente por el usuario; cierre UI-PATTERNS-05 sujeto a su última validación técnica.**

## Decisión futura — carrusel editorial de Home

Solo la futura Home migrada tendrá carrusel por defecto; Heroes interiores seguirán estáticos. Reutilizar el Hero editorial aprobado, pocos slides con contenido realmente distinto, controles claros, navegación de teclado y pausa de reproducción cuando corresponda. Respetar `prefers-reduced-motion`, evitar movimiento automático distractor, primera imagen optimizada como posible LCP y altura estable entre slides. Evaluar imports selectivos de Bootstrap Carousel antes de escribir uno propio. Implementar en una feature separada al abordar Home; UI-PATTERNS-03 no añade carrusel ni JS.

## Inventario físico de fotografía

Verificado con `getimagesize`, MIME, tamaño de archivo e inspección visual de originales. Todas las fuentes de cada picture comparten dimensiones; no hay `srcset` de anchos ficticios. Se prefieren los WebP en `webp/bg/`, más ligeros que los duplicados en `bg/`.

| Ruta bajo `assets/images/` | Dimensiones | Bytes | Uso |
|---|---:|---:|---|
| `bg/clandestino-usa.jpg` | 1880 × 920 | 138907 | Hero editorial, fallback |
| `webp/bg/clandestino-usa.webp` | 1880 × 920 | 56918 | Alternativa WebP |
| `avif/bg/clandestino-usa.avif` | 1880 × 920 | 41770 | Fuente preferida |
| `bg/the-clandestino-usa.jpg` | 1920 × 1080 | 223663 | Hero interior y media vinos, fallback |
| `webp/bg/the-clandestino-usa.webp` | 1920 × 1080 | 99786 | Alternativa WebP |
| `avif/bg/the-clandestino-usa.avif` | 1920 × 1080 | 78844 | Fuente preferida |
| `bg/clandestino-tapas.jpg` | 1920 × 1080 | 219192 | Media tapas, fallback |
| `webp/bg/clandestino-tapas.webp` | 1920 × 1080 | 97256 | Alternativa WebP |
| `avif/bg/clandestino-tapas.avif` | 1920 × 1080 | 77033 | Fuente preferida |

También existen `bg/clandestino-usa.webp` (78508 bytes) y `bg/clandestino-tapas.webp` (140844 bytes), verificados pero no utilizados. No se modifica ni genera fotografía.

## Verificación y rendimiento

Abrir `/style-guide/` y `/style-guide/patterns.php` en `http://localhost:3000` con `npm run dev`. Recorrer Section system, Hero, Media + content y CTA band a 320, 360, 390, 425, 768, 820, 992, 1024, 1280 y 1440px; comprobar poca altura, zoom 200%, Tab/Shift+Tab y foco. El bloqueo Apache `^style-guide(/|$)` cubre nueva ruta y partials sin modificar `.htaccess`; PHP local lo ignora.

Comandos: `npm run lint`, `npm run build`, `php -l` para `style-guide/index.php`, `patterns.php` y ambos partials. Build limpia CSS/JS de guía y sourcemaps; comprobar antes de reiniciar dev. Comprobar cuatro familias en CSS producto y ausencia de `cl-guia`/`cl-muestra`.

Medición histórica de UI-PATTERNS-02, mismo build minificado con `node:zlib.gzipSync`:

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Diferencia gzip |
|---|---:|---:|---:|---:|---:|
| `style.new.css` | 49168 | 51345 | 9707 | 10089 | +382 (+3.94%) |
| JS productivo `dist/main.js` | 0 | 0 | 20 | 20 | 0 |

El gzip de 20 bytes es solo la cabecera de un flujo vacío, no JS incorporado. SHA-256 de main idéntico: `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. CSS crece 2177 bytes sin comprimir por layout responsive y cuatro familias; no hay duplicación de componentes Core. No se mide CSS dev con sourcemaps como si fuera producción.

Recursos añadidos a la guía: cuatro elementos picture/img y **tres URLs de imagen únicas** en el navegador compatible; la foto de vinos se reutiliza desde caché. Cero scripts, hojas enlazadas, fuentes o recursos decorativos adicionales. Payload fotográfico seleccionado: AVIF 197647 bytes; WebP 253960; JPG 581762 (totales alternativos, no acumulados). El navegador elige una fuente por picture. El partial se incluye en servidor y no añade request.

No se declara LCP/CLS de producción desde esta guía. Las metas se medirán al migrar páginas con condiciones comparables. La revisión de CLS aquí es observacional, junto a dimensiones/proporciones reservadas.

### Registro histórico de QA — UI-PATTERNS-02

Verificado el 2026-10-12 en Chromium integrado, antes del refinamiento siguiente. Este registro no representa el diseño final de UI-PATTERNS-03; aprobación visual humana pendiente.

| Comprobación | Resultado |
|---|---|
| Preflight | PASS: limpio; fetch y fast-forward; Foundation/Core en `0053822` |
| Lint | PASS: ESLint/Stylelint sin errores ni reglas relajadas |
| Build | PASS: cuatro patrones, sin `cl-guia`/`cl-muestra`, sin CSS/JS de demostración ni sourcemaps |
| PHP | PASS: index y partial sin errores de sintaxis |
| Servidor/watch | PASS: `npm run dev`, PHP y BrowserSync en localhost:3000 |
| Advertencia dev | Node emite `DEP0060`: `util._extend` obsoleto en el proceso del servidor. No bloquea compilación, guía ni watch; sin cambiar dependencias/tooling |
| 390 / 768 / 1280px | PASS: capturas de familias, sin overflow horizontal, texto cortado ni CTAs superpuestos; recortes razonables |
| Zoom 200% | PENDIENTE: el navegador integrado no expone control de zoom; `ctrl+plus` no cambió escala ni ancho CSS; no se registra como probado |
| Teclado/foco | PASS: diez CTAs con Tab, retorno Shift+Tab, sin trampas; outline champagne 2px/offset 3px, también comprobado en móvil |
| Semántica | PASS: un h1, familias h2 y demos h3; IDs únicos, secciones nombradas e imágenes con alt/dimensiones reales |
| Contraste | PASS: 48 elementos con colores/superficies resueltos; mínimo 9.70:1, sin texto sobre fotografía |
| Carga/HTTP | PASS: cuatro imágenes cargadas con AVIF; guía, CSS/JS, nueve fuentes fotográficas y cuatro destinos HTTP 200 |
| Consola | PASS: sin errores ni warnings relevantes en la pestaña revisada |
| CLS observado | Sin salto evidente; proporciones/dimensiones reservadas. No es una medición de Web Vitals productivos |
| Legacy | PASS: diff contra base sin modificaciones de páginas/PHP productivos, CSS/JS legacy, imágenes, sitemap, robots ni `.htaccess`; sin enlace nuevo a `style.new.css` en producción |
| Foundation/tooling | PASS: tokens, base, fuentes, package files, Gulp y fuentes JS intactos; JS build idéntico |

Las ejecuciones iniciales dentro del sandbox bloquearon `.git/FETCH_HEAD` y lecturas ascendentes de esbuild; se completaron con los permisos necesarios, sin cambiar infraestructura. El primer lint señaló el selector `.container` dentro de Hero; se corrigió usando `cl-hero__estructura`, sin excepciones de lint. Los resultados PASS corresponden a las ejecuciones finales.

Evidencias locales fuera del repo: `C:/Users/Mike/.codex/visualizations/2026/10/12/01a12ee8-6679-7ae3-a5eb-c895d147987a/wave1-*` (capturas de Section system, Hero, Media y CTA a los tres anchos; foco; informe de contraste). Pruebas realizadas mediante la skill `qa-visual` del repo. No se ejecutaron Firefox, Safari, Apache/GoDaddy ni lector de pantalla auditivo. La escala 200% y la aprobación estética quedan para revisión humana local.

### Archivos y entrega

Nuevos: los cuatro SCSS en `assets/scss/patterns/`, `style-guide/partials/patrones-wave-1.php` y este documento. Modificados: `assets/scss/main.scss`, `style-guide/index.php`, y referencias vigentes en `docs/ARQUITECTURA.md` / `docs/ESTANDARES-DE-CODIGO.md`. Los outputs permanecen ignorados. El commit de implementación contiene patrones, demos y documentación; un segundo commit documental registra la advertencia dev observada después. Publicación normal exclusivamente de la feature. Sin PR, merge, force push ni deploy.

### Refinamiento — UI-PATTERNS-03

Rama conservada, preflight limpio y sincronizado en `a0fa613`; sin reescribir commits publicados. Verificación del 2026-10-12 en Chromium integrado mediante `qa-visual`. **Refinamiento técnicamente implementado; aprobación visual humana pendiente.** No iniciar Wave 2.

| Comprobación | Resultado |
|---|---|
| Lint / build | PASS: ejecuciones finales sin errores; sin relajar reglas ni cambiar tooling |
| PHP | PASS: index, patterns y ambos partials sin errores de sintaxis |
| Ambas rutas / CSS | PASS: HTTP 200; navegación real entre páginas, también con Enter, un destino activo por página |
| 320 / 390 / 425 / 768 / 820 / 992 / 1024 / 1280px | PASS: revisión en navegador y geometría de las cuatro familias, sin overflow ni contenido truncado |
| 360 / 1440px adicionales | PASS: mismos contratos y superposición del Hero |
| Hero | PASS: imagen/contenido coinciden en altura/celda en los diez anchos; contenido transparente, títulos sin br rígido, CTAs dentro del banner |
| Teléfono 320 × 568 | PASS: scroll vertical normal permite alcanzar CTA; Tab/foco visible, sin overflow ni recorte del control |
| Section / CTA | PASS: botones de dos acciones con anchos iguales; único CTA centrado en contexto centrado; targets ≥44px, composición limitada a 32rem |
| Media tablet | PASS: dos columnas desde md, inversión desde md; imagen cuadrada y copy proporcionada, radios discretos |
| Contraste sólido | PASS: 41 elementos del laboratorio/patrones fuera del Hero, mínimo 9.70:1 |
| Contraste Hero | PASS estimado: 180 combinaciones de texto, ancho y formato; mínimo conservador 6.25:1, incluidas fuentes AVIF/WebP/JPG |
| Foco / teclado | PASS: diez CTAs con Tab, retorno Shift+Tab, outline 2px/offset 3px; comprobación móvil sin clipping |
| Semántica | PASS: un h1 por página, títulos subordinados, IDs únicos, alt/dimensiones conservados; Patterns sin script module de demostración |
| Foundations/Core | PASS: sin patrones duplicados, alineación original, sin overflow en los ocho anchos obligatorios; fuentes JS/Core intactas |
| Consola | Sin errores/warnings relevantes observados antes de detener temporalmente dev para medir build |
| Zoom 200% | PENDIENTE: solo viewport/visibilidad están expuestos; cinco atajos ctrl+plus no cambiaron ancho CSS ni DPR; no se registra como probado |
| CLS observado | Sin salto evidente por imágenes; banner mantiene altura antes de decodificar la foto. No es una medición productiva de Web Vitals |
| Protección | PASS: diff contra `a0fa613` sin cambios en tokens, base, Core, Bootstrap config, tooling, JS/HTML/PHP productivos, CSS/JS legacy, originales, sitemap, robots o .htaccess |

El contraste fotográfico se estima desde las cajas de líneas leídas en el navegador, el recorte cover/foco central y la composición radial final. Se muestrean las fuentes originales con un máximo conservador de píxeles vecinos antes de calcular luminancia; no se sustituye la fotografía por un fondo sólido ni se cuenta una sombra tipográfica. La primera distribución tonal dejaba insuficiente protección en bordes del Hero interior de escritorio; se corrigieron extensión y centro reduciendo la opacidad central. Para otra fotografía/contenido, volver a medir y revisar el recorte. Los tres formatos se analizaron como fuentes, sin afirmar pruebas de render en Firefox/Safari.

Evidencias locales: `C:/Users/Mike/.codex/visualizations/2026/10/12/01a12ee8-6679-7ae3-a5eb-c895d147987a/refinado-*`: capturas completas iniciales, capturas finales de viewport con sufijo `-final`, geometría de diez anchos, informes de contraste y recorrido de teclado. No se ejecutaron Firefox, Safari, lector de pantalla auditivo ni Apache/GoDaddy. La revisión manual de zoom 200% sigue pendiente. Dev conserva la advertencia Node `DEP0060` ya registrada, sin fallos de funcionamiento.

#### Performance del refinamiento

Mismo pipeline minificado y `gzipSync`, medido antes de cambiar `a0fa613` y después del refinamiento:

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Diferencia gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 51345 | 53423 | 10089 | 10452 | +363 (+3.60%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |

Incremento CSS bruto 2078 bytes: superposición y protección tonal, tipografía contextual, acciones equilibradas y composición tablet/CTA. No se añade CSS de guía al producto. El hash JS productivo continúa idéntico al histórico; los 20 bytes gzip representan un flujo vacío.

Fotografías y pesos sin cambios: cuatro instancias, tres URLs únicas; AVIF 197647 bytes totales, WebP 253960, JPG 581762 como alternativas, no suma de descargas. Recursos de markup: antes la guía única tenía cuatro imágenes y un script module Core; ahora Foundations/Core tiene cero imágenes de patrones y conserva ese module, mientras Patterns tiene las cuatro imágenes y cero modules propios. Ambas usan las dos hojas existentes y las fuentes existentes. Hay un documento HTML adicional al navegar entre páginas; los includes PHP no añaden requests. BrowserSync solo inyecta su cliente de desarrollo.

Nuevos archivos locales de guía: `patterns.php` y `partials/navegacion-guia.php`; se reutiliza el partial de demos. Cambios de presentación exclusivos en `_guia.scss`, de producto en los cuatro patrones; contratos/arquitectura/estándares actualizados. Guía UX/UI general en `docs/UX-UI-GUIDELINES.md`. Sin dependencias, JS nuevo, carrusel, migración productiva ni cambios en develop/main.

Próximo paso: abrir ambas rutas locales, probar zoom 200% en el navegador del usuario y confirmar la composición visual. No hay PR, merge, force push o deploy automático.


### CTA premium — UI-PATTERNS-04

Preflight del 2026-10-12: rama esperada limpia y sincronizada con origin en `cde0425`. Se conservan Hero, Section System, Media + Content y la banda simple. Solo se amplía CTA con destacada/invertida, demos y documentación. **Pendiente de aprobación visual humana**, sin Wave 2, PR, merge ni deploy.

| QA final (Chromium integrado) | Resultado |
|---|---|
| 320 / 390 / 425 / 768 / 820 / 992 / 1024 / 1280px | PASS: cinco bandas, sin overflow horizontal ni texto truncado; revisión de capturas y geometría |
| Responsive | PASS: foto 4:3 y acciones completas en teléfono; split desde md, inversión solo desde md; alturas según contenido |
| Acciones | PASS: targets 44px, pares de ancho igual; grupo ocupa el ancho permitido y mantiene máximo 32rem |
| Teclado y foco | PASS: Tab/Shift+Tab por los enlaces destacados, orden lógico y outline 2px/offset 3px sin recorte |
| Contraste | PASS: 26 elementos sobre superficie sólida, mínimo 9.70:1; ningún texto sobre fotografía |
| Semántica | PASS: h3 subordinados al h2 CTA/un único h1, imágenes informativas con alt y dimensiones, enlaces reales |
| Consola / recursos | Sin errores/warnings relevantes de navegador; HTTP 200 en ambas páginas, CSS, destinos y nueve fuentes de foto |
| Lint / build / PHP | PASS: lint/build finales; index, patterns, patrones-wave-1 y bandas-cta-destacadas sin errores PHP |
| Protección | Diff limitado a cinco archivos permitidos; Foundation/Core, tooling, JS, otras familias, producción y originales intactos |

Evidencias fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/10/12/01a12ee8-6679-7ae3-a5eb-c895d147987a/cta-premium-*`, geometría, contraste, teclado y capturas completas finales de los ocho anchos. Se revisaron recortes derivados de esas capturas; las capturas iniciales de viewport pueden mostrar scroll de ancla en tránsito. No se ejecutaron Firefox/Safari ni lector de pantalla. Zoom 200% continúa pendiente de la revisión anterior; no es prueba declarada de este refinamiento. Dev conserva el aviso Node DEP0060 preexistente, sin fallo operativo.

Comparación con build minificado base, usando **PHP gzencode nivel 6 en ambos lados** (su tamaño puede diferir del gzipSync histórico): CSS 53423 → 55019 bytes, gzip 10440 → 10640 (**+200 bytes, +1.92%**). El incremento corresponde a layout split, media/radios, nota y orientación; cero selectores exclusivos de guía en producto. JS producto 0 → 0 bytes, gzip 20 → 20, SHA-256 idéntico `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. Build no emite assets de guía; dev genera las dos hojas habituales.

Patterns incorpora tres instancias/URLs nuevas de imágenes: pasa de cuatro pictures/tres fotos únicas a siete/seis. Nuevas fuentes: total AVIF 269410, WebP 353162, JPEG 764391 bytes; alternativas, no suma de descargas. Las fotos lazy solo se solicitan al acercarse a su sección; ningún JS, icono, fuente o stylesheet adicional. El partial PHP no añade requests. Los originales quedan intactos. No se deducen Web Vitals de producción del laboratorio.

Revisión local: `/style-guide/patterns.php#patrones-cta` para la familia completa y `/style-guide/patterns.php#banda-club` para la variante principal. La guía Core sigue en `/style-guide/`. Próximo paso: confirmar visualmente las nuevas bandas en el navegador del usuario.

### Cierre definitivo — UI-PATTERNS-05

El usuario aprobó visualmente Wave 1 y solicitó retirar únicamente las dos bandas CTA antiguas sin fotografía. La última validación de este cierre queda **completada**; Wave 1 está lista para preparar una PR cuando se solicite. No se crea PR, merge, deploy ni otra wave en esta tarea.

- Preflight limpio y sincronizado en `270e42a`, misma feature.
- Retiradas las demos «Something good to share» y «Bring your people to the table», junto con su etiqueta de dos acciones. Se conservan sin cambios el partial de Wine Club, Private Events invertida y Take Away, fotografías, contenido y enlaces.
- Eliminadas siete declaraciones SCSS de la banda simple que la destacada ya sobrescribía: borde/superficie/alineación base, gap/alineación de fila y centrado/margen automático de acciones. Se conservan todos los selectores compartidos y modificadores vigentes, con casos reales en las tres demos; sin selectores huérfanos ni cambios visuales del patrón aprobado.
- Lint/build/PHP del partial modificado: PASS. Dev local disponible. En Chromium integrado, 390/768/1280px: tres bandas, sin overflow ni truncamiento, fotos cargadas, dimensiones de media/contenido y acciones iguales a la evidencia de UI-PATTERNS-04. Se comparó después de estabilizar la navegación; posiciones verticales cambian por retirar las demos anteriores.
- Foco visible y Tab: PASS; las acciones conservan targets de 44px. Colores y superficies idénticos al diseño anterior; no cambia su contraste. Consola sin errores relevantes; guía, CSS y nueve fuentes de imagen HTTP 200.
- Hero, Section System y Media + Content conservan código y markup previo al bloque CTA. Diff limitado a SCSS CTA, partial Wave 1 y este documento; intactos Foundation/Core, JS/CSS legacy, PHP/HTML productivo, imágenes y tooling.

Evidencias de cierre: `C:/Users/Mike/.codex/visualizations/2026/10/12/01a12ee8-6679-7ae3-a5eb-c895d147987a/cierre-wave-1-*`. La aprobación humana expresa sustituye los estados pendientes históricos registrados arriba; las comprobaciones anteriores se mantienen como historial, no como estado vigente. Este cierre no afirma nuevas pruebas de Firefox/Safari, lector de pantalla o zoom 200%.


## Wave 2 — Gastronomía y productos

**Estado actual:** dirección visual general aprobada por el usuario; refinamiento integral solicitado. El contrato y QA vigentes del refinamiento están al final de este documento. Los registros anteriores describen la base publicada de Wave 2 y se conservan como historial.

Base: `develop` en `a8328cf`, Wave 1 integrada; rama `feature/ui-section-patterns-wave-2`. Sin migración de páginas ni operaciones comerciales. Aprobación visual humana pendiente.

### Matriz previa a SCSS

| Familia | Estados aplicables | Representación |
|---|---|---|
| Tarjeta gastronómica / quesos / especiales | Default, imagen ausente, precio ausente; disponible, agotado y limitado solo si se confirma | Fotografía y texto; `cl-estado` textual; placeholder sin request roto |
| Fila de menú | Default, precio/porción ausentes | Lista semántica, metadatos textuales; sin hover artificial |
| Destacado gastronómico | Default; precio ausente | Reutiliza `cl-media-contenido`; sin estado interactivo de la fotografía |
| Vino | Default, precio por copa/botella o ausente, imagen ausente | Tarjeta compartida con media contain; ficha `dl`; variedades solo con evidencia |
| Cesta gourmet | Default, precio ausente, personalización pendiente | Tarjeta compartida; CTA contextual; no promesa de contenido/disponibilidad |
| Take Away demo | Default, hover/focus/active en controles, disabled nativo, disponible, agotado, limitado, cantidad inválida, acción en curso/completada/fallida | `cl-cantidad`, botón de carga, `cl-spinner`, `cl-alerta`, `cl-estado`; selección en memoria, sin totales/pagos |
| Catálogo | Default, loading, empty, error | Bootstrap Grid; `cl-skeleton` y `cl-estado-vista`; navegación por categorías sin filtro dinámico |

Loading/error no se imponen a fotografías ni tarjetas estáticas. `cl-modal`/`cl-notificacion` siguen disponibles en Core: no se necesitan para esta selección local con feedback persistente al lado del control. Los estados comerciales de la guía siempre son simulados y llevan texto explícito. No hay precios reales actuales verificados; los importes numéricos son ejemplos, nunca una oferta.

### Decisiones y límites

Una estructura `cl-producto-gastronomico` reutiliza la superficie Foundation `cl-tarjeta` para tapas, quesos, especiales y cestas. Vino aporta únicamente media contain y ficha semántica; no duplica una tarjeta. Destacados reutilizan el split Wave 1. Fila de menú y composición de catálogo resuelven necesidades distintas. No se crean partials de cesta/destacado cuando solo cambia contenido.

Implementación y QA completados el 2026-10-12. Aprobación visual humana de Wave 2 pendiente.

### Inventario, composición y reutilización

| Patrón | Variantes / ejemplo | Contrato |
|---|---|---|
| `cl-producto-gastronomico` + `cl-tarjeta` | Tabla compartida, Manchego, Chorizo, cesta clásica y personalizada; imagen/precio ausentes | Media 4:3, contenido flexible, precio y unidad explícitos, acción opcional; solo acciones tienen hover/focus/active Core |
| `cl-item-menu` | Tres productos, porción de ejemplo y precio pendiente; agotado Take Away | `ul/li` para menú, texto sin truncamiento; precio separado desde md |
| `cl-media-contenido` | Tabla destacada y vino destacado invertido | Split Wave 1 desde md, imagen antes del contenido en teléfono; no se crea otro patrón de destacado |
| `cl-vino__imagen`, `cl-vino__ficha` | PURE SOUL y Adaro; foto cuadrada contain; ficha `dl/dt/dd` | Fotografía completa, sin convertir botellas en fondos; destacado conserva media cuadrada contain |
| `cl-catalogo` | Grid gastronómico, categorías navegables, lista de menú, resumen demo | Bootstrap Grid: 1 columna móvil, 2 desde md, 3 desde lg para gastronomía/estados; vinos/cestas 2 desde md |
| Core sin duplicación | Etiquetas, cantidad, botón con carga, spinner/skeleton, alerta y vacío/error | Ningún alert/modal/toast/spinner alternativo; no se necesita modal/toast para confirmar una demo local |

SCSS nuevo: `_producto-gastronomico.scss`, `_item-menu.scss`, `_vino.scss`, `_catalogo.scss`; imports después de Wave 1. No existen partials vacíos de cesta o destacado. `_guia.scss` solo reserva el espacio de mensajes demo, no añade estilos de documentación al producto. Sin tokens nuevos, dependencias, filtros JS ni lógica legacy importada.

### Assets comprobados y datos comerciales

Rutas relativas a `assets/images/`. Dimensiones/formato verificados con `getimagesize`; contenido fotográfico revisado localmente y en navegador. Las cinco fotos JPEG tienen derivados AVIF/WebP existentes con las mismas dimensiones. Las dos cestas solo utilizan su WebP existente.

| Fuente original | Dimensiones | Bytes original | Bytes AVIF / WebP |
|---|---:|---:|---:|
| `gallery/tapas/the-clandestino-tapas-6.jpeg` | 2048 × 1536 | 242225 | 64977 / 97166 |
| `gallery/tapas/the-clandestino-chorizo.jpeg` | 1536 × 2048 | 286112 | 69712 / 111680 |
| `gallery/quesos/manchego.jpg` | 1024 × 683 | 124583 | 56715 / 69582 |
| `wines/PURE-SOUL.jpg` | 916 × 2048 | 182591 | 101549 / 125896 |
| `wines/ADARO.jpeg` | 1536 × 2048 | 243994 | 58395 / 87084 |
| `hampers/basket-01.webp` | 1536 × 2048 | 69928 | — / 69928 (original) |
| `hampers/basket-13.webp` | 1536 × 2048 | 156168 | — / 156168 (original) |

Evidencia de nombres/productos: `assets/js/tapas.js`, `assets/js/wines.js`, `assets/js/hampers.js`, `menu.html` y metadatos/secciones de tapas/wines/hampers. Se inspeccionaron selectivamente; no se cargan sus scripts en la guía. La foto de PURE SOUL muestra NTC & Sons, Grenache 85%, Vidadillo 15% y Barrel Aged: la ficha los identifica como información **de la etiqueta fotografiada**. No se extrapolan a una añada actual. Región, denominación, añada, alcohol y variedades de Adaro se omiten porque el catálogo histórico no confirma la oferta vigente.

Todos los precios y disponibilidad requieren confirmación: tabla, Chorizo, Manchego, PURE SOUL, Adaro, Classic Basket y Custom Hamper. Porciones/pesos/volúmenes, composición de cestas, personalización y ventanas de recogida también están pendientes. $36 / board, $12 / plate y $12 glass / $45 bottle se muestran exclusivamente como **Example price**, con unidad; no se declara precio real vigente. No se muestran descuentos, reseñas, promociones ni urgencia histórica. `Limited availability`, `Available` y `Sold out` incluyen `demo` visible.

### Interacciones y seguridad de la demo

`assets/js/modules/guia/productos.js` entra únicamente por `style-guide.js`. La entrada conecta ejemplos de Core solo cuando existe su contenedor y productos solo cuando existe `pedido-demo`; los módulos Core no cambian.

- Cantidad Core: enteros 1–6, botones en los límites, `aria-invalid`, mensaje asociado y restauración del último valor válido al confirmar. Un flag local conserva el aviso en el primer submit después de una entrada inválida restaurada, evitando que ese submit actualice la selección.
- Add to Order: submit local prevenido, espera de 1.6s, Core carga con `aria-busy` y bloqueo de activaciones repetidas; cantidad/desenlace/limpieza deshabilitados durante la espera. Conserva foco en el botón.
- Resultado Success/Failure elegido con `select` nativo. Éxito reemplaza la última selección; error conserva la selección anterior. Feedback Core persistente en una región `role=status` con texto inequívoco de demo. No hay suma de unidades ni cálculo de precios.
- Clear demo selection devuelve a vacío y foco al botón de pedido; disabled real cuando no hay selección. Reload borra la selección. Retry de catálogo solo muestra texto; el ejemplo estático de error permanece.
- Sin `fetch`, endpoints de negocio, POST, `innerHTML`, localStorage, sessionStorage, cookies de carrito, pagos, cuentas ni inventario. Los únicos datos son estáticos controlados y la cantidad local. PHP solo compone partials con `require`/`__DIR__` y escapa strings de helpers con `htmlspecialchars`.

`cl-guia-resultado--cantidad` reserva tres líneas; `--producto` reserva 13rem móvil y 9rem desde md. A 320px el feedback mantiene 208px durante carga y fallo; el botón conserva 44px. Imágenes tienen dimensiones, proporción y lazy loading. No se declara una medición de CLS/Core Web Vitals de producción.

### Registro técnico y responsive — 2026-10-12

Skill utilizada: `.agents/skills/qa-visual/SKILL.md`, ampliada a los nueve anchos pedidos. Navegador Chromium integrado, viewport CSS (no dispositivos físicos).

| Verificación | Resultado |
|---|---|
| Preflight | PASS: limpio, fetch, develop actualizado por ff-only a `a8328cf`; Wave 1 confirmada como ancestro, feature desde esa base |
| `npm run lint` | PASS final: ESLint y Stylelint, sin relajar reglas |
| `npm run build` | PASS final: CSS/JS producto y sprite; sin CSS/JS guía ni sourcemaps |
| `php -l` | PASS: patterns.php, patrones-wave-1.php y los tres partials nuevos de Wave 2 |
| `npm run dev` / watch | PASS: PHP y BrowserSync localhost:3000; recompilación/reload observados |
| 320 / 390 / 425 / 768 / 820 / 992 / 1024 / 1280 / 1440 px | PASS: geometría de todos los patrones, capturas por productos/familias y revisión de vistas representativas; sin overflow horizontal ni truncamiento |
| Fotografías / botellas | PASS: proporciones reservadas, fotos existentes cargadas; los tres usos de vino resuelven object-fit: contain en los nueve anchos |
| Take Away | PASS: cantidad, máximos, entrada inválida real con teclado/restauración, envío inválido bloqueado, Enter/Space, espera, éxito, fallo, limpieza y retry demo |
| Loading | PASS: botón 44px estable, foco retenido, aria-busy, campos bloqueados y activaciones repetidas ignoradas |
| Teclado/foco | PASS: Tab/Shift+Tab, botones/campo/select nativos, anillo champagne 2px y offset 3px; sin trampas. Targets de acciones de producto y controles ≥44px |
| Semántica | PASS: un h1, sin saltos de nivel, IDs únicos, labels asociados, alt y dimensiones; disponibilidad descrita con texto |
| Contraste Wave 2 | PASS: 138 textos/combinaciones sobre superficies resueltas, mínimo 9.51:1; controles disabled excluidos del requisito de texto WCAG; ningún texto superpuesto a fotografías |
| Consola / HTTP | PASS: sin errores/warnings observados en las dos guías; 41 URLs locales únicas (guías, CSS/JS, sprite, favicon y fuentes de imágenes) HTTP 200 |
| Core | PASS: nueve anchos sin overflow; modal por Enter, foco inicial, Escape y retorno; toast por Space; cantidad por ArrowUp; sin cambio de API/fuentes Core |
| Wave 1 / Foundation | PASS: geometría sin overflow junto a Wave 2; SCSS de las cuatro familias y tokens/base intactos; revisión de vistas existentes, solo se actualiza la nota obsoleta de aprobación en su demo |
| Protección productiva | PASS: sin cambios en HTML/PHP productivo, CSS/JS legacy, imágenes originales, sitemap, robots, .htaccess, dependencias ni tooling |

No se ejecutaron Firefox, Safari, lector de pantalla auditivo, Apache/GoDaddy ni zoom 200%. Reduced motion conserva la regla Foundation/Core existente; no se emuló la preferencia del sistema. Hover/active de acciones reutilizan las reglas Core intactas; la prueba funcional con teclado no sustituye una revisión táctil física. BrowserSync emite el aviso Node DEP0060 `util._extend` preexistente; no afecta al build ni a la consola de la página.

La primera captura full-page sobrepasó el límite del navegador y un lote largo agotó el tiempo de la herramienta. Se completó QA por vistas de productos/familias y geometría. Algunas capturas iniciales reflejan el scroll suave en tránsito; no se usan como prueba de composición final. Evidencias finales locales fuera del repo: `C:/Users/Mike/.codex/visualizations/2026/10/12/01a131d5-3c57-7d23-abc8-fbc9a3f422fc/`, con `review-*`, `confirmed-*`, `final-invalid-320.png`, `final-loading-320.png`, `final-error-320.png`, `wave2-responsive-final.json`, `wave2-contrast.json` y recorrido de teclado. El primer build sandbox falló por lectura ascendente de esbuild; el build final pasó con los permisos necesarios, sin cambiar herramientas.

### Performance antes / después

CSS producto minificado del mismo pipeline, gzip PHP `gzencode` nivel 6. JS guía medido con esbuild en memoria y Node gzip nivel 6, sin crear outputs de producción.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Incremento gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 54838 | 57640 | 10624 | 11062 | +438 (+4.12%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |
| JS guía DEV | 61583 | 64679 | 14118 | 14893 | +775 (+5.49%) |
| JS guía minificado, solo medición | 31008 | 32858 | 9934 | 10504 | +570 (+5.74%) |

CSS aumenta por cuatro patrones de presentación, media contain, ficha, acciones y catálogo; ninguna clase exclusiva de guía en producto. JS productivo conserva SHA-256 `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855` (20 bytes gzip representan el flujo vacío). Solo la guía añade la interacción necesaria, sin librerías nuevas.

Wave 2 añade diez instancias fotográficas / siete URLs únicas. Descarga preferida de esas siete fuentes: 577444 bytes (cinco AVIF y dos WebP); alternativa WebP: 717504; originales/fallbacks: 1305601. Son alternativas, no suma de requests; la misma tabla/PURE SOUL se reutiliza con la misma URL y caché. No se crean ni sobrescriben fotos. Las fuentes de hasta 2048px son las existentes y se cargan lazy; pueden evaluarse derivados menores en una futura migración productiva, fuera de este encargo. No se instala optimizador ni se recorre todo el directorio de assets.

### Archivos y revisión integral

Nuevos (8): los cuatro SCSS listados, `assets/js/modules/guia/productos.js`, `style-guide/partials/productos-wave-2.php`, `vinos-cestas-wave-2.php` y `pedido-estados-wave-2.php`. Modificados (7): `assets/scss/main.scss`, `assets/scss/components/_guia.scss`, `assets/js/style-guide.js`, `style-guide/patterns.php`, la nota de `partials/patrones-wave-1.php`, `docs/ARQUITECTURA.md` y este documento. Outputs ignorados, sin eliminaciones.

Revisión humana integral: `http://localhost:3000/style-guide/patterns.php#wave-2`, navegación interna a tapas/menu/destacados/vinos/cestas/Take Away/estados. Core: `http://localhost:3000/style-guide/`. Probar móvil/tablet/desktop; en Take Away, editar cantidad y elegir Success/Failure antes de Add to Order. Validación técnica completa; **aprobación visual humana pendiente**. Publicación normal solo a la feature, sin PR, merge, force push ni deploy. Precios, disponibilidad y demás pendientes comerciales no convierten estas demostraciones en ofertas reales.

### Refinamiento integral UX/UI — 2026-10-12

Se conserva `feature/ui-section-patterns-wave-2`; preflight limpio y sincronizado tras fetch en `c282798`, con los dos commits originales publicados. Base histórica de la feature: `develop@a8328cf`. No se actualiza develop ni se crea otra rama. La dirección visual general cuenta con aprobación del usuario; **el refinamiento permanece pendiente de aprobación visual humana**.

Se adaptaron las tres composiciones descritas por el usuario: tarjeta vertical con pie comercial, presentación lateral editorial y filas horizontales. No se copiaron paletas claras, promociones, reseñas ni controles ficticios. Foundation, Core, Wave 1, fuentes y tokens permanecen intactos.

#### Composición y jerarquía comercial vigentes

| Familia / estructura | Refinamiento |
|---|---|
| Tarjeta compartida | Foto, categoría compacta, título, descripción breve y dato/estado. `cl-producto-gastronomico__pie` agrupa precio/unidad y acción con separador sutil; wrap móvil, precio protagonista y texto de precio pendiente de menor jerarquía. Sin truncamiento ni altura fija del contenido |
| Acciones de producto | Core `cl-boton-icono` para enlaces reales a detalles/composiciones existentes; 44px y nombre accesible. El icono de pedido enlaza al laboratorio local, no ejecuta una compra |
| Menú | `cl-item-menu__cabecera` agrupa foto opcional y copy; `__comercial`, precio y acción. Foto 72px móvil/96px desde md, sin encogimiento del picture ni cuadro vacío al omitirla. Precio/acción debajo en móvil y columna derecha desde md |
| Estados de filas | Disponible, limitado y agotado con `cl-estado`, texto e icono; no-confirmado con información textual. Disabled nativo para acción agotada. Se conserva la variante sin precio y sin foto |
| Vinos | `cl-producto-gastronomico--vino` reutiliza la tarjeta, con altura natural independiente por ficha. Vertical hasta md; fotografía lateral desde lg. Media contain, centrada en toda su celda, sin recortar botellas. Adaro no hereda la altura de PURE SOUL ni añade relleno informativo |
| Destacados | Mantienen `cl-media-contenido` y la orientación aprobada. Nombre del producto como titular, copy breve, ficha `dl`, precio/dato comercial y acción agrupados. No se crean un nuevo destacado ni formularios comerciales |
| Cestas | Mismo patrón, fotografía existente, contexto de regalo y pie con consulta/exploración. Sin inventar contenido, personalización confirmada ni importe |
| Take Away | Tarjeta editorial con Bootstrap/Wave 1: fotografía lateral desde md y datos/selección a la derecha. Precio unitario, cantidad Core, subtotal ilustrativo y acción principal; feedback visible al lado del control |
| Catálogo | Estados previos conservados: imagen/precio ausentes, skeleton/spinner de carga, vacío y error recuperable demo. No hay filtros dinámicos ni copias masivas de tarjetas |

La altura igual de tarjetas gastronómicas/cestas conserva pies alineados; la variante de vino usa altura natural porque su información es desigual. No se compensa con texto inventado, min-height excesivo o overflow:hidden. Los valores contextuales de fotografía/controles reutilizan spacing/radius actuales; no se crean tokens globales.

#### Iconografía Core

32 usos de SVG sobre el sprite existente, con 13 símbolos: `personas`, `siguiente`, `informacion`, `aviso`, `pedido`, `exito`, `error`, `restringido`, `regalo`, `restar`, `sumar`, `cerrar`, `reintentar`. Todos verificados como IDs existentes. `iconoProducto()` es un helper exclusivo de estos partials: SVG decorativo con `aria-hidden`/`focusable=false`, currentColor y nombre escapado. El nombre accesible pertenece al enlace/botón; estados y datos conservan texto visible. Sin favoritos, ratings ni nuevos iconos/dependencias.

#### Take Away y subtotal ilustrativo

`Simulated outcome` se mueve a un fieldset **Demo controls**, fuera de la presentación del producto. Es una herramienta del laboratorio para elegir Success/Failure, nunca un control comercial. Permanece conectado por su ID y se bloquea durante la acción local.

`data-cl-precio-ejemplo="3600"` proporciona únicamente el importe estático de demostración en centavos. El JS de guía valida que sea un entero seguro no negativo y usa `Intl.NumberFormat` para mostrar **Example subtotal** según 1–6 unidades válidas. El subtotal excluye impuestos y no representa un cobro ni importe final. Cantidad inválida muestra `—`; al restaurar Core el último valor válido, el subtotal vuelve a ese ejemplo. Se conserva el guard que impide enviar el primer valor inválido restaurado.

Éxito actualiza la última selección mediante un `dl`: producto, cantidad, precio de ejemplo por unidad y subtotal de ejemplo. Error conserva cantidad/subtotal del resultado exitoso anterior aunque la vista previa haya cambiado. Clear oculta el `dl` y devuelve foco al botón; no borra la cantidad de trabajo. Reload devuelve cantidad inicial y selección vacía. No hay acumulación de carrito, pagos, impuestos calculados, almacenamiento ni requests de negocio.

Los mensajes se acortan y el feedback inicial contiene una indicación útil. Su reserva baja de 13rem móvil/9rem md a 8rem/6.5rem; carga, éxito y error mantienen el espacio. El aviso de cantidad se coloca después de la acción para que no desplace cantidad/subtotal/CTA al aparecer. Se retira la reserva de tres líneas entre cantidad y acción. El mensaje más largo se expande cuando lo necesita, sin recortar texto. La tarjeta crece según contenido; su foto cover acompaña la altura desde md y los vinos siguen contain.

#### Contrato para integración futura

La estructura visual distingue media, categoría/título/descripcion, ficha opcional, estado, precio/unidad y acciones. No hay selectores ligados al nombre del producto ni al importe. PHP futuro podrá omitir foto/ficha/acción, renderizar precio confirmado o ausente, y proporcionar disponibilidad textual junto a la variante Core. Los strings se deberán escapar al renderizar; estos helpers no son un sistema de plantillas universal.

El atributo de precio y el cálculo local pertenecen exclusivamente al laboratorio. Una futura operación deberá recibir importes/disponibilidad autoritativos del servidor, validar unidades y gestionar idempotencia/concurrencia allí. No se implementan endpoints, BD, autenticación, inventario ni seguridad transaccional en esta pasada.

#### QA técnico del refinamiento

Skill `.agents/skills/qa-visual/SKILL.md`, Chromium integrado. Evidencia local en `C:/Users/Mike/.codex/visualizations/2026/10/12/01a131d5-3c57-7d23-abc8-fbc9a3f422fc/`, con prefijos `refine-`, `refinement-` y registros JSON de responsive/contraste/teclado/stress. Se usó una pestaña de QA independiente para evitar capturas atrasadas del tab inicial; las capturas preliminares `refined-*` no son evidencia final.

| Comprobación | Resultado |
|---|---|
| npm run lint | PASS: ejecución final ESLint/Stylelint, sin cambiar reglas |
| npm run build | PASS: producto/sprite; sin CSS/JS guía, sourcemaps ni selectores cl-guia/cl-muestra en producto |
| PHP lint | PASS: los tres partials modificados |
| npm run dev / watch | PASS: PHP, BrowserSync y recompilación/reload; localhost:3000 disponible para revisión |
| 320 / 360 / 390 / 425 / 768 / 820 / 992 / 1024 / 1280 / 1440px | PASS: geometría de todos los patrones, 60 vistas de familias y revisión visual de composiciones representativas; sin overflow ni textos cortados |
| Miniaturas de menú | PASS final: primer render de 320px reveló encogimiento del picture y solape con título; se añadió su elemento BEM sin flex-shrink. Separación final medida 16px en 320/768/1280 |
| Vinos | PASS: los tres usos de botella contain en los diez anchos; altura independiente de PURE SOUL/Adaro, sin etiquetas recortadas |
| Estrés | PASS: título y descripción extensos en la tarjeta sin foto/precio, a 320/768/1280; sin overflow de documento ni contenido. Fixture temporal restaurado; no se publica contenido de prueba comercial |
| Subtotal | PASS: 2→$72, 3→$108, 6→$216; máximo deshabilita sumar; inválido→`—` y restauración al último valor válido; envío inválido bloqueado |
| Acción/feedback | PASS: Enter/Space, bloqueo de duplicados, espera, éxito, fallo conservando selección anterior, limpieza y retorno de foco. Botón 44px; feedback móvil 128px estable en carga/fallo |
| Teclado/foco/hover | PASS: controles nativos y enlaces operables; Tab/Shift+Tab, foco champagne 2px/offset 3px sin recorte; hover de cantidad observado sobre superficie-hover. Active conserva la regla Core intacta; no se midió una pulsación sostenida |
| Targets | PASS: mínimo 44px en acciones de tarjetas/filas y controles de pedido, en los diez anchos |
| Contraste | PASS: 158 textos/combinaciones sobre fondos resueltos, mínimo 9.51:1; disabled excluido del requisito de texto WCAG; ningún texto sobre fotografía |
| Semántica | PASS: un h1, sin saltos de heading, IDs únicos, labels asociados, output de subtotal nombrado, SVG decorativos, fotos con alt/dimensiones y estados textuales |
| HTTP / SVG / consola | PASS: 42 URLs locales HTTP 200, 13 símbolos usados existentes y cero imágenes/SVG faltantes; sin errores/warnings de página observados |
| Protección | PASS: diff limitado a los diez archivos de alcance; Foundation/Core/Wave 1, producción, originales, deps, tooling y JS productivo intactos |

Zoom 200% no se pudo ejecutar mediante el control del navegador integrado: el intento de atajo falló antes de confirmar un cambio de escala. No se sustituye por reducir el viewport ni se declara probado. Firefox/Safari, dispositivos táctiles físicos, lector de pantalla auditivo y Apache/GoDaddy no se ejecutaron. Reduced motion conserva Foundation/Core sin emulación nueva. BrowserSync mantiene el aviso Node DEP0060 preexistente, sin fallo operativo. La aprobación visual humana final continúa pendiente.

#### Performance del refinamiento

CSS minificado con el mismo build y PHP gzencode nivel 6. JS guía comparado en memoria con esbuild/Node gzip nivel 6, reemplazando solo el módulo de demo por su versión `c282798` para la medida anterior; sin escribir bundles de guía productivos.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Cambio gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 57640 | 60558 | 11062 | 11413 | +351 (+3.17%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |
| JS guía DEV | 64679 | 65653 | 14893 | 15120 | +227 (+1.52%) |
| JS guía minificado, solo medición | 32858 | 33411 | 10504 | 10688 | +184 (+1.75%) |

CSS crece por pie comercial, filas con media/acciones, variante reutilizable de vino y selección/resumen; los estilos del fieldset demo/feedback siguen en la hoja exclusiva de guía. JS crece solo por subtotal y resumen local. Hash del JS productivo vacío permanece `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. Sin dependencias, PurgeCSS ni librerías de iconos.

Imágenes: 17→19 instancias en Patterns por reutilizar dos fotos en filas; las siete fotos Wave 2 / trece fotos totales y las 35 URLs de formatos alternativos siguen iguales. Pesos de fotos sin cambios; descarga preferida de Wave 2 conserva 577444 bytes. El sprite compartido añade un recurso local cacheable: inventario de guías/recursos locales 41→42 URLs únicas; 32 usos de SVG no son 32 archivos. Estos conteos de markup/HTTP distinguen formatos alternativos de peticiones efectivas, sin afirmar un HAR de red ni Web Vitals de producción.

#### Archivos y entrega del refinamiento

Modificados: `assets/scss/patterns/_producto-gastronomico.scss`, `_item-menu.scss`, `_vino.scss`, `_catalogo.scss`; `assets/scss/components/_guia.scss`; los tres partials PHP Wave 2; `assets/js/modules/guia/productos.js`; este documento. Sin archivos fuente nuevos ni eliminados. Se mantiene la entrada de JS y todos los imports/tooling existentes.

Revisión integral: `/style-guide/patterns.php#wave-2`, filas en `#productos-menu`, vinos en `#productos-vinos`, cestas en `#productos-cestas`, selección en `#productos-pedido`. Foundation/Core conserva `/style-guide/`. Probar cantidad y subtotal; en Demo controls, elegir Failure y luego ejecutar Add to Order para ver recuperación. Precios/porciones/stock/añadas/cestas siguen pendientes de confirmación comercial; nada constituye una compra real. Publicación normal únicamente a la feature; sin PR, merge, force ni deploy.

### Contraste con las tres referencias adjuntas — 2026-10-12

Preflight limpio y sincronizado tras fetch en `060c564`, misma feature. Se revisaron las imágenes reales A (tarjeta vertical), B (presentación comercial lateral) y C (filas). A y C ya están cubiertas por el refinamiento anterior: fotografía, pie precio/acción y filas con media opcional/estados. Se conserva ese trabajo. No se copian HOT, favoritos, descuentos, estrellas, garantía ni colores de las referencias.

La referencia B concreta una mejora: el subtotal y la acción se agrupan en una franja inferior con separador, mediante el mismo `cl-producto-gastronomico__pie` y el modificador contextual `--pedido`. El CTA ocupa todo el ancho móvil y se alinea a la derecha cuando hay espacio. Cantidad/ayuda permanecen encima; feedback debajo y Demo controls fuera del producto. IDs, labels, output, APIs Core y comportamiento JS no cambian.

`cl-producto-gastronomico__precios` permite agrupar más de un precio/unidad y se reutiliza tanto en ese pie como en PURE SOUL. Copa y botella se muestran en paralelo cuando caben, con wrap natural; los volúmenes pendientes se comunican junto a la disponibilidad. A 768px la tarjeta PURE SOUL pasa de 844.61 a 756.22px y a 1440px de 570.31 a 505.72px, sin recortar contenido ni añadir información comercial. Adaro conserva altura natural y datos pendientes; cestas, menú y destacados se mantienen.

| Verificación actual | Resultado |
|---|---|
| Lint / build / PHP | PASS: lint/build finales y ambos partials modificados; build excluye assets de guía |
| Dev | PASS: PHP/BrowserSync/watch; localhost:3000 activo |
| Diez anchos requeridos | PASS: 320/360/390/425/768/820/992/1024/1280/1440, sin overflow; controls ≥44px y los tres usos de vino contain; 20 capturas de las composiciones ajustadas |
| Mobile CTA | PASS: a 390px, botón y pie miden 301px; subtotal/acción apilados sin compresión |
| Estados / interacción | PASS: cantidad 2→$72, carga por Enter, fallo por Space conserva $72, inválido→`—`/envío bloqueado, limpieza y retorno de foco. Matriz restante y casos de estrés del refinamiento anterior preservados |
| Accesibilidad | PASS: 159 textos/combinaciones, mínimo 9.51:1; un h1, IDs únicos, labels completos, Tab/Shift+Tab y foco 2px; sin texto recortado ni foto/ícono faltante |
| HTTP / consola | PASS: mismas 42 URLs locales HTTP 200; consola sin errores/warnings de página observados |
| Protección | PASS: solo SCSS compartido de producto, PHP Take Away/vinos-cestas y este registro; Foundation/Core/Wave 1, menú, fotografía, JS, tooling y producción intactos |

Las limitaciones anteriores siguen explícitas: zoom 200%, Firefox/Safari, lector auditivo, dispositivos físicos y Apache/GoDaddy no se declaran probados; active conserva Core sin medición de pulsación sostenida. Se mantiene el aviso dev Node DEP0060 preexistente. Evidencias nuevas: `references-*` en el directorio local de QA ya documentado. Las capturas de la acción muestran loading intencionadamente; no son pedidos reales.

Performance medida con el mismo pipeline/gzip: CSS producto 60558→61050 bytes, gzip 11413→11464 (**+51 bytes, +0.45%**). JS producto idéntico y vacío (gzip 20); JS guía conserva 65653 bytes/15120 gzip en dev y 33411/10688 minificado en memoria. No cambia ningún fuente JS. Imágenes/peticiones conservan 19 instancias, trece fotografías únicas, 35 alternativas y 42 recursos locales; cero fotos, iconos o dependencias nuevas. El incremento CSS corresponde exclusivamente a agrupación de precios y ajuste responsive del pie.

Se integra como un ajuste coherente sobre el refinamiento publicado, sin reconstruir Wave 2 ni crear otra rama. El contrato de backend futuro y todos los pendientes comerciales se mantienen. **Pendiente de aprobación visual humana.**

## Wave 7 — experiencias transaccionales frontend (2026-10-20)

Base `9513e526794ad4a3205dd1d5161122fed254fabd`, Wave 6 integrada en develop mediante PR #12. Rama `feature/ui-section-patterns-wave-7`. La auditoría inicial, decisiones CREAR/EXTENDER/REUTILIZAR/DIFERIR, estados, riesgos y criterios de aceptación se registraron antes de implementar en `WAVE-7-COVERAGE.md`. No se reconstruyen Waves 1–6 ni se abre Wave 8.

### Cobertura y responsabilidad

Todas las familias obligatorias tienen cobertura frontend completa, con dependencia backend para cualquier operación real. Una confirmación de laboratorio lleva identificación explícita de simulación. Los precios de prueba, límites, fechas, referencias y cupos no son información comercial vigente.

| Familia / ancla | Resultado implementado | Límite de autoridad |
|---|---|---|
| Cart / `#w7-carrito` | Líneas por plantilla, variantes, cantidad, papelera/Undo, subtotales y promo demo en centavos enteros; resumen lateral/compacto/móvil; vacío, inválido, actualización, fallo, no disponible, desactualizado y recuperación | Reprecio, impuestos, descuentos, stock y fulfillment pertenecen al servidor; el subtotal demo no es un cargo |
| Take Away / `#w7-checkout` | Pickup o order ahead/mesa; fecha/hora restaurante, contexto de mesa, notas, contacto, selección y revisión; los campos de modalidad inactiva se deshabilitan | Una preferencia no garantiza ventana de recogida ni avisa a cocina. Sin delivery |
| Checkout compartido | Datos → revisión → resultado; volver conserva datos; validación y primer error con foco; carga y bloqueo de confirmación duplicada | Callbacks del anfitrión aportan contexto y resultados; no hay envío comercial |
| Payment / `#w7-pago` | Importe/referencia, contenedor de proveedor futuro, procesando/aprobado demo/rechazado/pendiente/expirado/fallo/desconocido y consulta de recuperación | Snapshot compartido con el carrito, revisión de pedido obligatoria y consulta del resultado ficticio; reset solo reinicia el outcome local. Impuestos/cargos/total final sin confirmar; sin PAN/CVV/método guardado |
| Reservations / `#w7-reserva` | Comensales/fecha, búsqueda con carga, radios de horario con selección/disabled textual, contacto progresivo y teléfono opcional, revisión, pendiente/confirmada demo/pérdida del slot | Sin calendario de disponibilidad real ni bloqueo de mesa; cambiar fecha/comensales invalida el slot, conserva contacto |
| Booking management / `#w7-gestion` | Referencia/visita/comensales/política pendiente, solicitud de cambio y confirmación de cancelación, conservar/volver, pendiente/fallo/restricción/modificada/cancelada | Registro sintético independiente. Cambio es solicitud textual; el motor futuro deberá ofrecer fechas y condiciones válidas. Cancelada demo deshabilita nuevas acciones |
| Gift transaction / `#w7-regalo` | Importa monto/dedicatoria del diseñador Wave 4, correo, resumen, pago pendiente/emisión demo/fallo; estados compactos de emisión pendiente | No vuelve a crear el diseñador; sin código, saldo, redención, PDF, dirección ni canal de entrega inventado |
| Club transaction / `#w7-club` | Importa Gold/Diamond Wave 4, resumen de perfil histórico, precio/cadencia pendientes, condiciones explícitas de ejemplo obligatorias; pago/activación demo y ciclo de suscripción | No presenta $149 como promoción disponible ni inventa periodicidad/renovación/beneficios actuales |
| Event / `#w7-evento` | Importa evento Wave 4, asistentes 1–4 fixture, correo/revisión, cupos demo/agotado, pendiente/registro demo/error; cancelación/reprogramación compactas | Fecha hipotética; precio por consulta, sin tickets ni waitlist |
| Private inquiry / `#w7-estados` | Recibida, revisión, información adicional, propuesta, confirmación posterior demo, no disponible/cerrada; enlace al formulario Wave 4 | Consulta → evaluación → propuesta → confirmación separada. No hay administración de cotizaciones |
| Confirmation/recovery / `#w7-estados` | 58 estados específicos en siete dominios; mensaje/contexto/referencia/siguiente paso/enlace contextual; Core Alert/Estado | El frontend nunca determina éxito comercial; pagos, prestación, emisión y activación se comprueban por separado |
| Account FUTURE / `#w7-cuenta` | Cuatro operaciones ficticias (pedido/reserva/club/regalo), enlaces contextuales, sin operaciones, fallo/reintentar, no autorizado | Las filas se retiran del DOM en estado no autorizado; no hay dashboard, login nuevo, roles, facturas ni sesión |

### Piezas creadas y reutilización

Nuevas responsabilidades visuales: `cl-transaccion` compone panel/pasos/datos/acciones/resultado; `cl-carrito` representa líneas; `cl-resumen` representa un resumen o importes de operación (variante compacta); `cl-reserva` compone horarios y selección. La retícula sigue Bootstrap y los colores/tipografía/espacios/bordes siguen tokens. Botellas usan contain; fotografía editorial cover; el arte oficial Gift Card conserva sus proporciones.

Se reutilizan `cl-seccion`, `cl-media-contenido`, la familia de producto y sus datos/selecciones de Waves 2/4, `cl-membresia`, Gift Cards, Events y Private Experiences, Core Forms/opciones/cantidad/alertas/estados/vacío/error/loading/spinner, Header/Footer/acceso Modal de Wave 6 y el sprite existente. Bandas CTA, breadcrumbs y Skeleton siguen disponibles donde su responsabilidad lo requiere; no se insertan artificialmente en cada flujo. Los estados no crean un sistema nuevo de notificaciones.

SCSS nuevo: `assets/scss/patterns/_{transaccion,carrito,reserva}.scss`, importado al final de `main.scss`. JS reutilizable: `assets/js/modules/patterns/{transaccion,carrito,checkout,reserva}.js`. Entrada demo: `assets/js/style-guide.js` → `modules/guia/transacciones.js` + `transacciones-fixtures.js`. `main.js`, dependencias y tooling intactos. PHP: `style-guide/partials/{transacciones,carrito-checkout,reservas,comercio,operaciones}-wave-7.php` y helpers `transacciones-componentes.php`; inclusión única en `patterns.php`.

### Contratos de los módulos

- `crearEstadoCarrito(productos)` en `patterns/estado-carrito.js` es la única fuente de cantidades, variantes, disponibilidad e importes locales. Un snapshot aporta `version`, líneas con `subtotalLinea`, `unidades`, `subtotal`, `descuento`, `codigo`, `subtotalAjustado`, `impuestos`, `cargos`, `total`, `valido` y motivo de promoción. Los tres importes finales permanecen null sin autoridad servidor. Las unidades suman cantidades, no líneas.
- `inicializarCarrito(raiz, productos, {consultarCodigo})` recibe una raíz con id y una plantilla inerte `data-cl-carrito-plantilla`; crea nodos seguros y estables, reutiliza Core Cantidad y devuelve `resumen()`, `reemplazarLineas(lista)`, `agregar(producto)`, `disponibilidad(id, bool)`, `establecerEstado(valor)`, `destruir()`. `cl:carrito` y `cl:carrito-continuar` transportan el snapshot. Los productos no se limitan a dos registros ni requieren HTML específico por cada línea.
- Cada línea tiene `id` estable y único (independiente de `productoId`), nombre, descripción/variante, precio entero, cantidad1…maximo y disponibilidad; puede aportar imagen local confiable/alt/tipo, `restringido` y variantes `{id,nombre,precio}` con `varianteId`. Un cambio de variante conserva la identidad de línea. El servidor futuro define consolidación de líneas iguales y elegibilidad comercial; no se descarga un catálogo al carrito.
- `inicializarPromocion(raiz, {consultar,resumen,aplicar,quitar})` controla disclosure/validación/feedback; `actualizar(snapshot)` reconcilia cambios y `destruir()` aborta su consulta. El callback recibe código, snapshot y AbortSignal. Solo el estado de carrito aplica/descuenta/reconcilia; una respuesta tardía nunca altera una versión distinta. Enter mantiene el foco en el campo readonly durante la espera.
- Regla sintética: DEMO10 resta1000 centavos de un subtotal válido de al menos5000; un solo código, sin acumulación. Bajada de subtotal que deja de cumplir retira el descuento con feedback. Códigos DEMO-EXPIRED/DEMO-INELIGIBLE/DEMO-ERROR exploran fallos, cualquier otro es inválido. No son promociones vigentes.
- `pintarImportes(raiz,snapshot)` presenta importes en Cart/compacto/Order/Payment sin recalcular ni leer precios del DOM. `version` permite invalidar revisión, contexto y temporizadores de pago al cambiar selección, variante, disponibilidad o descuento.
- `inicializarCheckout(raiz, {revisar,resultado,prepararValidacion,alCompletar,alInvalidar})` conserva los dos pasos y Core. `prepararValidacion` refresca criterios antes de validar; `alCompletar` conecta la revisión de pedido con Payment y `alInvalidar` cancela su contexto. `invalidar()` no roba el foco a una cantidad externa; `destruir()` cancela temporizador/listeners. La confirmación verifica de nuevo el formulario y el contexto.
- `inicializarReserva(raiz, {escenario,alInvalidar,alSeleccionar})` conserva `seleccion()`, `perderHorario()`, `destruir()`; el anfitrión muestra contacto al elegir horario y conserva valores al invalidar. Fecha mínima y selección civil se revisan en America/Los_Angeles; no se resuelve disponibilidad ni DST autoritativo en el cliente.
- Header Wave6 admite configuración optativa PHP `carritoNavegacion['destino']` y `actualizarCarrito({unidades})` en su controlador existente. `actualizarCarrito(null)` oculta contador y deja nombre genérico; sin ruta no se dibuja acceso ni cantidad falsa. La vista muestra99+ sobre99 y el nombre accesible mantiene el valor completo. No usa live region. Orden desktop: Reserve→Cart→Account; móvil conserva logo, Cart, Account y menú a320px. Drawer/Discover/Footer y breakpoints se conservan.

Inicialización idempotente, datos mediante textContent/createElement/plantilla, IDs derivados de identidad validada, imágenes locales sin traversal y callbacks explícitos. Eventos reutilizables con AbortController; cantidades antiguas desaparecen con sus nodos al sustituir colección. Solo `modules/guia/` contiene fixtures, códigos de prueba, retardos y controles de estrés1/2/8/20/40 generados bajo demanda. Sin fetch/XHR/POST de negocio, storage, sesiones ni dependencias. `main.js` conserva su entrada vacía. La navegación comparte únicamente una extensión autorizada y el sprite curado incorpora trash como `papelera` desde Bootstrap Icons ya instalado.

### Contratos conceptuales PHP/MySQL futuros

No son endpoints implementados ni un esquema definitivo. Toda salida comercial debe proceder del servicio autorizado. Las referencias deben ser opacas; un ID no sustituye autorización.

| Dominio | Entrada esperada | Salida esperada / invariantes |
|---|---|---|
| Cart | IDs de item/variante, cantidad, contexto, versión de catálogo | Líneas repriciadas, disponibilidad/motivo, moneda, subtotal/impuestos/descuentos/cargos/total en unidades menores, versión y vencimiento; no confiar en importe del DOM |
| Order | Snapshot validado, modalidad pickup/mesa, fecha/hora local/zona, referencia de contexto, instrucciones/contacto | ID/referencia opaca, líneas/totales congelados, estado, ventana confirmada o pendiente; distinguir recibido/preparación/listo/completado/cancelado/rechazado |
| Payment | Referencia de operación, importe autorizado servidor, moneda, idempotency key y sesión segura del proveedor | Referencia del proveedor, importe/moneda, estado/resultado seguro y estado de conciliación; timeout desconocido requiere consulta antes de otro intento |
| Reservation | Fecha civil, horario/slot y versión, comensales, zona IANA, titular/contacto autorizado y preferencias | Disponibilidad/expiración, instante UTC y representación local consistentes, referencia/estado; conflicto invalida slot; cambios/cancelaciones autorizados y bajo política confirmada |
| Gift Card | Importe/moneda permitidos, presentación/dedicatoria, entrega y términos confirmados | Referencia, pago y emisión/entrega separados; cualquier código/saldo solo por canal autorizado; no exponerlo en listado público |
| Membership | Plan/versionado, precio/cadencia/beneficios/términos vigentes aceptados y referencia de proveedor | Estado de pago/suscripción, activación, renovación/fin efectivos y condiciones confirmadas; gestión de pago por proveedor seguro |
| Event | Evento/versionado, asistentes, identidad/contexto y precio confirmado | Cupos/disponibilidad verificados, referencia/estado, fecha/cancelación/reprogramación y resultado de registro; capacidad protegida por concurrencia |
| Private inquiry | Datos mínimos del formulario existente, referencia y titular autorizado | Estado de evaluación, información solicitada/propuesta y confirmación posterior separada; sin reserva implícita |
| Account | Usuario autorizado, referencia de operación, alcance/paginación | Solo registros visibles para ese titular; estado y acciones permitidas por operación; denegación sin datos personales ni existencia revelada |

El backend futuro debe aplicar validación servidor, autorización por recurso, CSRF en mutaciones, escaping contextual contra XSS, prepared statements y transacciones de BD. Debe prevenir doble reserva y exceso de cupos con concurrencia real, mantener integridad de transiciones y auditabilidad, manejar errores sin filtrar datos, hacer cobros idempotentes y verificar firma/duplicados/orden de webhooks si el proveedor los utiliza. No se implementan estas responsabilidades en Wave 7 ni se modifica `Booking-app-php`.

### Auditoría global y próxima construcción

`DESIGN-SYSTEM-READINESS.md` es el índice práctico Foundation/Core/Waves 1–7 y el mapa Home/Restaurant/Wines/Gift Cards/Wine Club/Events/Reservations/Contact/Take Away/Account FUTURE. Se puede componer el frontend con los patrones existentes; adaptar filtros de vinos, motor de reservas, proveedor y canales/condiciones corresponde a integrar cada página. La autorización humana del aspecto visual sigue pendiente; no se declara que el sitio comercial esté listo para vender.

El registro final de comandos, accesibilidad, responsive, regresiones, performance y limitaciones se encuentra en el cierre de `WAVE-7-COVERAGE.md`.

### Refinamiento final de Wave7 — criterios de integración

El recorrido conectado es Cart→Order Details→Review→Payment Preview→Outcome. Payment muestra el mismo subtotal/descuento que la selección revisada, exige revisión actual y cancela esperas/resultados al cambiar versión. Reiniciar un outcome no repite cobros; pendiente/desconocido/expirado/error ofrecen consulta antes de otro intento. Pago y aceptación del pedido siguen separados.

Pickup muestra dirección211 N Mt Shasta Blvd, Mt Shasta, CA96067, fecha/hora solicitadas y contacto. Mesa admite referencia opcional y explica que order ahead no reserva una mesa. Teléfono de pedido/reserva es opcional en la demo y valida solo sintaxis básica; obligatoriedad, país y normalización corresponden a política/servidor. No se inventan ventanas de cocina ni delivery.

Para vino, la UI ofrece información contextual de elegibilidad/identificación pendientes y escenarios sintéticos de producto restringido o modalidad no disponible. No se solicita documento ni se presenta checkbox como verificación de edad. Licencias, modalidades permitidas y requisitos legales concretos deben validarse comercialmente antes de vender.

Contrato servidor ampliado: líneas/variantes con identidad estable, versión de selección/precio, todos los importes en unidades menores y moneda uniforme; promociones verificadas por existencia/vigencia/uso/identidad/compatibilidad/límites, repricio e impuestos/cargos autoritativos. Reserva requiere fecha/hora civil y zonaIANA, conversión UTC/DST explícita, comensales/duración/capacidad/restricciones/expiración de bloqueo y confirmación transaccional. Pago requiere importe autorizado servidor, checkout hospedado/componentes seguros, idempotencia, conciliación y webhooks firmados/verificados cuando procedan. Ninguna de estas responsabilidades se implementa aquí.

Auditoría previa, pruebas ejecutadas/no ejecutadas, performance, archivos y aprobación final del refinamiento: cierre actualizado de `WAVE-7-COVERAGE.md`. La cobertura de58 estados se conserva sin inflar el catálogo; no se crea Wave8 ni se migran páginas productivas.


### Cierre de comercio Wave7 — 2026-10-21

Este contrato amplía el refinamiento anterior: `id` es la línea transaccional estable; `productoId` y `varianteId` definen la equivalencia de agregación, con verificación de precio/límite. Cambiar variante conserva ID y otras líneas. `modalidades` permite elegibilidad por producto/presentación; no constituye autorización comercial. Quantity queda visualmente oculto como label, manteniendo asociación y contexto accesible. La proyección `paginarCarrito(total,pagina)` presenta máximo diez líneas; importes/unidades/descuentos siempre abarcan todo el modelo. Undo mantiene orden y recupera página/foco.

`inicializarCarrito` incorpora `suscribir(callback) → retirar`, mutadores `cantidad/variante/eliminar/restaurar/modalidad` y `continuar`. Header admite `conectarCarrito(proveedor,panel)` o `proveedorCarrito/panelCarrito` iniciales; sin conexión sigue neutral. El panel `cl-mini-carrito` usa `inicializarMiniCarrito`: Bootstrap Offcanvas, máximo28rem, primeras tres líneas, cantidad/eliminar/Undo, resumen global y destinos aportados por el anfitrión. Click, Escape, backdrop, trap y retorno de foco; se espera hidden antes de cambiar de overlay o enfocar destino. No hover accidental ni precios/modelo paralelos. Desmontar retira suscripción/eventos y dispone overlay; no hay IDs de Style Guide dentro del Header.

`horario-servicio.js` expone reloj civil/ventanas/validación/hora legible desde configuración inyectada; `horario-formulario.js` adapta fecha/select nativos con `validar`, `actualizarConfiguracion`, `destruir`. Configuración: versión, zona, semana, excepciones por fecha, servicios con habilitación/intervalo/anticipación/duración/última hora. Cierre exclusivo, revalidación en Review/confirmación, ningún cálculo según timezone del dispositivo. El anfitrión invalida selecciones al cambiar configuración. `inicializarReserva` recibe `configuracion()`, ofrece API `actualizarConfiguracion`, tamaños1–10 o entero mayor de10 mediante consulta manual pendiente, conservando contacto. El backend resolverá capacidad, instantes/DST y concurrencia.

Un código por pedido; Apply100% contextual; DEMO-REDEEMED representa redención histórica sin consultar clientes. Campaña/límites/identidad guest/canje y reversión atómicos pertenecen al servidor. Métodos Payment serán habilitados por proveedor real y sesión segura; ninguno activo ahora. Mantener conciliación e independencia entre pago y prestación/emisión/activación. Los58 estados previos permanecen y el explorador suma únicamente conciliación (59). La revisión del evento respeta la configuración común; una apertura especial necesita autorización explícita. Gift/Wine Club y Private Inquiry preservan sus contratos.

Matriz completa de APIs/datos demo, reglas y excepciones sintéticas, seguridad, dependencias por dominio, QA/performance y límites: `WAVE-7-COVERAGE.md`, cierre2026-10-21. No hay pagos/reservas/envíos reales ni páginas migradas; revisión visual humana pendiente.
