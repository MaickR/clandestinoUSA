# Auditoría final transversal del Design System

Fecha: 2026-10-21. Rama: `feature/ui-section-patterns-wave-7`. Base auditada: `4c6ec256f0285c1c9b4f2e363f50c96106d73d42` (`e402167` es su padre). El SHA del cierre y su sincronización se entregan tras el commit/push; este documento no puede incorporar el hash de su propio commit.

## Alcance y auditoría inicial

Foundation, Core y Waves 1–7, sus fuentes reales, tres guías PHP renderizadas e interacciones locales. El usuario aprueba la dirección visual general; no se rediseña ni se crea otra wave. QA técnico, aprobación humana final y autorización de una operación comercial son decisiones separadas.

Preflight ejecutado: árbol limpio, rama correcta, `git fetch origin`, divergencia local/remota 0/0. `origin/develop` y merge-base en `9513e526794ad4a3205dd1d5161122fed254fabd`, con Wave 6 integrada por #12. Diff de la feature revisado; ningún cambio ajeno inicial. `production-baseline` no contiene estas guías ni módulos nuevos; ninguna página productiva se cambia. `master` no se utilizó como autoridad.

Se contrastaron AGENTS, arquitectura, estándares, UX/UI, dirección visual, Core, Section Patterns, Readiness, cobertura Wave 7 y mapa de páginas. Las comprobaciones históricas no se presentan como pruebas actuales.

## Hallazgos y decisiones

| ID / prioridad | Reproducción y causa | Corrección / archivos | Prueba y riesgo de regresión |
|---|---|---|---|
| A01 · P1 | Eliminar en mini → cerrar → colección de 8 → abrir → Undo. Error `Línea desconocida`: el controlador conservaba un ID retirado del modelo | `patterns/{estado-carrito,carrito,mini-carrito}.js`: consulta compartida `puedeRestaurar(id)` y retirada de Undo obsoleto en ambas vistas | Node: eliminado/reincorporado/colección distinta/mismo ID nuevo. Navegador: reproducción antes/después, Undo normal y reincorporación desde otra vista. Riesgo: un proveedor alternativo debe implementar la consulta nueva |
| A02 · P1 | Sustituir una línea manteniendo ID y cambiando máximo 6→2/foto→ausente: mini conserva máximo 6 y foto anterior; el carrito principal muestra 2 | `mini-carrito.js`: reconciliar máximo, src/ausencia, alt y tipo desde cada snapshot; conservar el nodo de imagen oculto para recuperarlo | Fixture temporal con módulos reales: 6→2 sin foto→3 con foto; JSON antes/después. Riesgo: cambios de media de una misma identidad; se evita reasignar src si no cambia |
| A03 · P0 de demostración | Core: Reserve a table, View the menu y Add one item parecen acciones operativas pero no ejecutan nada | `style-guide/index.php`, `assets/js/style-guide.js`: botones Try… con propósito explícito y un feedback de activación. No se simula reserva, menú ni alta de producto | Click y Enter/Space muestran feedback manteniendo foco; sin JS el texto explica que son muestras de apariencia. Riesgo bajo, limitado al laboratorio |
| A04 · P1 | Core mostraba una ventana retenida durante 10 minutos, plazas limitadas/reserva confirmada sin rótulo de ejemplo y error de disponibilidad solo como toast | Mismos dos archivos: copy inequívoco de ejemplo; aviso assertive persistente sin promesa; errores críticos y recuperación remitidos al contexto de la operación | Alertas renderizadas, tres toasts/límite, regiones polite/assertive y foco; errores persistentes de formularios/pago probados. Riesgo bajo, sin cambiar APIs Core |
| A05 · P2 corregido | html5lib detecta dos `expected-named-entity` por guía en Google Fonts | Escapar `&` como `&amp;` en `index.php`, `patterns.php`, `navigation.php`; misma URL efectiva | Tres fuentes PHP renderizadas sin errores del parser después. Sin impacto visual ni recursos nuevos |
| A06 · P2 corregido | Dos `title="Remove from cart"` duplican nombres accesibles específicos, con ayuda nativa dependiente del puntero | Retirar solo esos title en `partials/carrito-checkout-wave-7.php` | Nombre específico, activación por teclado, eliminación y Undo conservados; no se agrega Tooltip |
| O01 · P2 diferido | Tres summary audiovisuales y el disclosure de prueba de navegación miden 28.89px de alto; no alcanzan la preferencia de 44px | Conservar: controles secundarios nativos, operables y separados. No es un P0/P1 que justifique modificar Waves anteriores bajo este encargo | Medición en `structure.json`. Mejorar el target contextual al integrar esas páginas, sin declarar certificación de accesibilidad |

No queda P0/P1 frontend conocido en el alcance comprobado. A03 es una acción engañosa de laboratorio según la clasificación del encargo; no hubo reserva, envío ni incidente comercial real.

## Inventario verificable

Rutas abreviadas: SCSS=`assets/scss/`; JS=`assets/js/modules/`; PHP=`style-guide/partials/`. Variantes menores comparten fila. Todas las filas describen código existente, no familias propuestas.

En las familias aplicables se reutilizan semántica nativa, nombres/labels, foco Foundation, grid Bootstrap y feedback Core. La comprobación estructural actual cubre un h1/main por guía, IDs únicos, labels, alt y referencias ARIA resueltas. Los diez anchos prueban geometría de documentos; las capturas revisadas de 390/768/1280 son representativas, no cada combinación de variante/estado. Las limitaciones generales posteriores también se aplican a este inventario.

| Capa / componente y uso | Fuentes concretas | Variantes / estados / interacción | Accesibilidad, responsive y evidencia actual | Clasificación e integración futura |
|---|---|---|---|---|
| Foundation: lenguaje visual y estructura | SCSS `abstracts/_tokens.scss`, `base/*`, `main.scss`; `/style-guide/` | Colores/tipos/espacios/grid/superficies; no requiere estados de operación | Tokens/foco/reduced motion inspeccionados; contraste sólido y diez anchos | PASS CON LIMITACIÓN: zoom/forced colors/contraste fotográfico completo no recertificados |
| Core Button/Icon/Link/State/Breadcrumb | SCSS `components/_{button,boton-icono,icon,estado,migas}.scss`; `index.php` | Default/hover/focus/active/disabled; etiquetas estáticas; enlaces y activación de muestras | Nombres, foco y Enter/Space; hover/active inspeccionados en SCSS, sin medir pulsación sostenida | PASS tras A03; destinos y datos confiables del anfitrión |
| Core Forms/Quantity/Loading | SCSS `components/_{form,cantidad,spinner,skeleton}.scss`; JS `core/{cantidad,boton-carga}.js` | Required/optional/readonly/disabled/error; min/max/step, espera y bloqueo de activación | Labels y errores; uso real en Wave 2/checkout/reserva; suites Node y navegador | PASS CON LIMITACIÓN: formulario Core es muestra de campos, no un servicio; validación final servidor |
| Core Alert/Toast/Empty/Error | SCSS `components/_{alerta,notificacion,estado-vista}.scss`; JS `core/{alerta,notificacion}.js` | Información/éxito/aviso/error; persistente/cierre; recuperación contextual | Tres toasts, límite/foco y regiones independientes; HTML sin live anidados; autocierre de 8s inspeccionado, no cronometrado | PASS CON LIMITACIÓN tras A04; no reemplazar errores críticos por toast |
| Core Modal/Disclosure | SCSS `components/_{modal,acordeon}.scss`; JS `core/{modal,acordeon}.js` | Abierto/cerrado, confirmación segura, disclosure independiente | Trap Tab/Shift+Tab, Escape, retorno y Keep item; esperas hasta shown/hidden | PASS; Bootstrap modular, un overlay por contexto |
| Wave 1: Section/Hero/Media/CTA | SCSS `patterns/_{seccion,hero,media-contenido,banda-cta}.scss`; PHP `patrones-wave-1.php`, `bandas-cta-destacadas.php` | Principal/interior, inversión, CTA fotográfica; enlaces reales, sin operaciones | Treinta capturas transversales incluyen Hero; diez anchos; imágenes/copy preservados | PASS CON LIMITACIÓN: reevaluar recorte/contraste cuando se cambie foto o contenido |
| Wave 2: producto, menú, vino, cesta y catálogo | SCSS `patterns/_{producto-gastronomico,item-menu,vino,catalogo}.scss`; PHP `*wave-2.php`; JS `guia/productos.js` | Precio/foto ausentes, agotado/restringido/pendiente; cantidad y selección local; vacío/carga/error/retry | Cantidad 3→$108; fallback/alt y contain inspeccionados; capturas y geometría | PASS CON LIMITACIÓN: demo Wave 2 independiente del carrito Wave 7; catálogo/filtros/stock de página futuros |
| Wave 3: experiencias/historia/comunidad/valores | SCSS `patterns/_{experiencia,historia,valores}.scss`; PHP `*wave-3.php` | Principal/secundaria/sin foto, texto largo y ausencia; acciones editoriales | Composición conservada y geometría; sin opiniones o identidades atribuidas | PASS CON LIMITACIÓN: copy/medios definitivos y permisos de página |
| Wave 3: galería/visor | SCSS `patterns/_{galeria-editorial,visor-galeria}.scss`; JS `patterns/galeria.js`; PHP `galeria-media-wave-3.php`, `visor-galeria.php` | Múltiple/única/vacía, carga/error; ampliar, flechas, siguiente, cerrar | 2/6, error real de decodificación con HTTP 200→foto 2/2, Escape/retorno; 390×568 y capturas | PASS; Bootstrap/Core; recursos locales del anfitrión |
| Waves 3/5: vídeo y alternativa | SCSS `patterns/_media-video.scss`; PHP `galeria-media-wave-3.php`, `carrusel-videos-wave-5.php`; JS `patterns/carrusel-media.js` | Horizontal/vertical/pendiente/no disponible/error; contrato video inerte | Cero reproductores activos; controles y estados de alternativa legibles | AUSENCIA JUSTIFICADA de reproducción real; DEPENDENCIA FUTURA: film autorizado, poster, captions/transcripción; no se prueba playback ficticio |
| Wave 4: Gold/Diamond/Gift/Event/Private | SCSS `patterns/_{membresia,regalo,evento,consulta-privada}.scss`; PHP `*wave-4.php`; JS `guia/comercial.js` | Selección, arte/caras, error/espera/reset; cuatro formularios y 29 estados | Diamond/$100/dedicatoria/evento; consulta vacía→primer error→fallo→éxito demo; 29 estados recorridos | PASS CON LIMITACIÓN: no se reindujeron todos los fallos de arte ni todas las combinaciones de cuatro formularios; contenido/recepción futura |
| Wave 5: reseña/testimonio/reputación/listado/formulario | SCSS `patterns/_{resena,testimonio,reputacion,resena-formulario}.scss`; PHP `*wave-5.php`; JS `guia/resenas.js` | Valoración 1–5, procedencia/fecha ausentes, vacío/carga/error; filtro/orden/revelado, borrador/validación/fallo/reset | Primer radio inválido, Space/flecha, envío sintético y edición→Draft updated; filtro 5→1/6; estructura/capturas | PASS CON LIMITACIÓN: datos ficticios explícitos; moderación, fuentes/permisos y servicio futuros |
| Wave 5: carruseles | SCSS `patterns/_carrusel.scss`; JS `patterns/{carrusel,carrusel-media}.js`; PHP `carrusel-*-wave-5.php` | Colección/vacío/única; scroll nativo, prev/next, Home/End, sin autoplay | Geometría/estructura y código de teclado/limpieza inspeccionados; regresión de navegación registrada al final | PASS CON LIMITACIÓN: no reproducción de vídeo ni desmontaje dinámico completo en navegador |
| Wave 6: Header/Discover/Drawer/sticky/skip | SCSS `patterns/_navegacion-global.scss`; JS `patterns/navegacion-global.js`; PHP `cabecera-wave-6.php` | Desktop/móvil, activo, carrito optativo, abierto/cerrado; sin JS conserva enlaces | Diez anchos cerrado; tres ciclos de menú, Discover cierra primero, Escape y retorno; viewport corto | PASS; configuración PHP confiable, destinos publicados y proveedor de carrito explícito |
| Wave 6: Footer/Contact/Topbar/Breadcrumb | SCSS `patterns/_{pie-global,topbar}.scss`; PHP `{pie,topbar,configuracion}-wave-6.php`; `navigation.php` | Completo/mínimo, datos opcionales, largo; Topbar optativa, enlaces contextuales | Footer en tres capturas; links/tel/mailto/mapa/legales revisados contra repo y HTTP local | PASS CON LIMITACIÓN: perfiles/datos comerciales no certificados como vigentes; configuración demo no es configuración productiva |
| Wave 6: Auth Modal Demo | SCSS `patterns/_acceso.scss`; JS `patterns/acceso.js`; PHP `acceso-wave-6.php` | Readonly sintético, Show/Hide, invalid/loading/error/complete, reset al cerrar | Foco email, Tab/Shift+Tab, Escape, password oculto y body/backdrops limpios tras hidden; 390×360 | PASS CON LIMITACIÓN: sin autenticación; DEPENDENCIA FUTURA de identidad/sesiones/autorización |
| Wave 7: Cart/Mini/Quantity/Variants/Pagination/Promo | SCSS `patterns/_carrito.scss`; JS `patterns/{estado-carrito,carrito,mini-carrito,paginacion-carrito,promocion}.js`; PHP `carrito-checkout-wave-7.php` | Vacío/invalid/loading/error/stale/disponibilidad; editar/quitar/Undo, diez líneas/página y tres mini; códigos/resultados | A01/A02 corregidos; 40 líneas/120 unidades/99+ en diez anchos; seis acciones promo y cuatro importes iguales; suites Node | PASS; snapshot único, sin catálogo completo ni descuentos autoritativos |
| Wave 7: Checkout/Take Away/Order Ahead/Payment | SCSS `patterns/_transaccion.scss`; JS `patterns/{checkout,transaccion,horario-formulario}.js`; `guia/transacciones.js`; PHP `carrito-checkout-wave-7.php` | Datos/revisión/volver/espera/resultado; pickup/mesa; siete outcomes de pago y consulta | Datos conservados, cuatro subtotales $117, cambio de carrito bloquea pago; siete resultados/recuperación | PASS; proveedor real, total y aceptación de cocina FUTURE; sin PAN/CVV/cobro |
| Wave 7: Reserva/grupo/gestión | SCSS `patterns/_reserva.scss`; JS `patterns/{reserva,horario-servicio}.js`; PHP `reservas-wave-7.php` | Búsqueda/cerrado/slot/perdido/pendiente/confirmado demo, >10 consulta; cambiar/cancelar/conservar | Lunes cerrado, jueves 18:00, revisión/confirmación demo, 15 invitados pendientes, cancelación pendiente; Node DST/excepciones | PASS; capacidad/concurrencia/autorización/políticas FUTURE; no se modifica Booking-app-php |
| Wave 7: Gift/Club/Event/estados/Account preview | PHP `{comercio,operaciones}-wave-7.php`; JS `guia/{transacciones,transacciones-fixtures}.js`; reutiliza Checkout/Core | Importación explícita, condiciones, asistentes; 59 estados/7 dominios; historial/vacío/error/no autorizado | Tres importaciones→revisión→pendiente; 59 mensajes/siguientes pasos/destinos; estado de cuenta en registro final | PASS CON LIMITACIÓN: fixtures/orquestación exclusivos de guía; identidad/operaciones reales FUTURE |

## Estados globales, ayudas, formularios y acciones

| Responsabilidad | Estados obligatorios cubiertos / criterio |
|---|---|
| Controles interactivos | Default/hover/focus/active; selected en opciones; disabled y explicación contextual. Loading bloquea la acción mientras conserva su nombre. Etiquetas/fotos estáticas no necesitan todos esos estados |
| Colección y recursos | Loading/empty/error/retry, foto/precio ausentes, recurso fallido; conservar texto y salida. Vídeo no autorizado permanece inerte |
| Operación | Error/warning/success/pending/completed/cancelled/unavailable/expired según dominio; referencia y siguiente paso. Confirmación demo separada de prestación/emisión/activación |
| Consistencia transaccional | Stale invalida revisión/pago; retry explícito, nunca cobro automático; unknown result exige consulta. No se inventa un estado de negocio para cada control |
| Feedback | Alert estática sin live automático; una región por operación. Toast para aviso accesorio, sin robar foco; los errores de corrección permanecen junto al formulario/pago. Sin modales triviales ni segundo sistema |
| Ayuda contextual / tooltips | Iconos cuentan con nombres específicos; disponibilidad, precio, condiciones, horario, campos y vino tienen texto/disclosure visible o accesible por teclado. No hay información crítica solo en hover ni necesidad demostrada de otro Tooltip. AUSENCIA JUSTIFICADA de tooltips adicionales |

Formularios inventariados: campos Core, pedido Wave 2, Club/Gift/Event/Private Wave 4, reseña Wave 5, acceso Wave 6, promo, pedido, búsqueda/contacto reserva y tres transacciones Wave 7. Labels, required/optional, grupos, tipos y errores asociados revisados; autocomplete explícito en contacto cuando procede y off en muestras. Volver conserva datos; reset es explícito donde existe. Recargar borra el estado de laboratorio.

Todas las acciones comerciales visibles son previews o destinos de ejemplos/documentos existentes. No hay `href="#"` vacío en los tres DOM inspeccionados. Sin JS: enlaces/contenido permanecen y las operaciones de formulario se renderizan disabled o se explican como no disponibles mediante noscript; esto es inspección del HTML inicial, **no** una prueba actual con scripting desactivado. Las validaciones del cliente no garantizan seguridad ni autoridad comercial.

## Gap analysis por página y contratos PHP

| Página / recorrido | Composición disponible / decisión útil | Dependencia antes de publicar |
|---|---|---|
| Home: descubrir→explorar/reservar | Header/Hero/CTA/productos/experiencias/reseñas/Footer; destinos configurables | Copy/medios reales y rutas publicadas. Slider del Hero se decidirá en Home con el contrato histórico; el Hero estático ya permite el recorrido, no bloquea el DS |
| Restaurant: menú→selección→pedido | Wave 2 + carrito/checkout/horario, ayuda dietaria y contacto | Menú/precio/impuestos/stock, operación de cocina y elegibilidad |
| Wine Shop: explorar→filtrar→presentación | Catálogo/vino, selects/disclosure Core y estados de lista | Adaptador de filtros de la página y catálogo normalizado; licencias/modalidades/edad. No falta una familia visual nueva |
| Gift Cards: personalizar→revisar | Diseñador existente + revisión/pago/emisión separados | Oferta, presentación/entrega/redención/condiciones y proveedor |
| Wine Club: comparar→condiciones→revisión | Gold/Diamond + formulario y estados recurrentes | Beneficios/precio/cadencia/renovación/cancelación actuales y proveedor |
| Events: detalle→asistentes→solicitud | Evento/agenda/detalle, quantity/revisión y consulta privada | Evento real, cupos/precio/horario/condiciones y registro autoritativo |
| Reservations: fecha→slot→contacto→revisión/gestión | Horario compartido, selección, error/recuperación, consulta grande y cancelación considerada | Motor PHP auditado en otra tarea, capacidad/bloqueo/transacciones, zona/UTC/DST y autorización |
| Take Away: seleccionar→pickup/mesa→revisión | Carrito, ayuda de modalidad, horario, contacto y estados | Servicio/ventanas/cocina reales; order ahead no reserva mesa |
| Cart/Checkout: editar→volver→pago/resultado | Cuatro vistas coherentes, descuento, stale, retry/unknown y salida por navegación | Totales/estado servidor, idempotencia, proveedor y conciliación |
| Contact: consultar→canal | Footer/contacto, enlaces Core, campos y consulta privada | Decidir página propia y canal/recepción; no crear endpoint ficticio |
| Account FUTURE: consultar historial o denegación | Acceso sintético y operaciones mínimas con vacío/error/no autorizado | Identidad/sesión/autorización y privacidad. FUERA DE ALCANCE construir área privada completa |

No se identificó un patrón frontend fundamental ausente que cumpla los cuatro criterios del encargo y obligue a crear otra familia. Cabecera/pie reciben mapas de rutas y contacto confiables; horarios reciben configuración por servicio/excepción. Catálogo/precios/estados vienen del anfitrión, no del DOM como autoridad. Carrito exige IDs de línea estables y versionado, unidades menores e importe común. Pago/reserva/cuenta requieren referencias y autorización de servidor.

Acoplamientos explícitos que no se deben copiar a producción: `modules/guia/**`, IDs `w7-*` de la orquestación, fixtures `DEMO-*`, rutas/anclas de laboratorio y `configuracion-wave-6.php`. Los módulos de patrones reciben raíces/callbacks/proveedores; Auth mantiene IDs de campos de su partial y exige una sola instancia por documento. Los partials compartidos viven aún bajo `style-guide/partials`: incluir solo la plantilla necesaria con configuración del anfitrión, nunca la página del laboratorio ni sus fixtures. `main.js` continúa sin imports; la inicialización productiva será parte de cada integración autorizada.

El servidor futuro validará/autorizará recursos, escapará salida, recalculará importes y aplicará CSRF, consultas preparadas, transacciones/concurrencia, idempotencia y webhooks verificados cuando proceda. No se define esquema definitivo ni backend ahora. No hubo persistencia de datos personales, endpoints, compras, reservas o envíos reales. Búsqueda de sinks en JS nuevo: sin innerHTML, storage, cookies ni requests comerciales. Riesgos reales pendientes: configuración confiable de URLs, términos/contenidos, permiso de media, disponibilidad y autoridad servidor.

## Evidencia y QA ejecutado

Skill: `.agents/skills/qa-visual/SKILL.md`. Chromium integrado. Evidencia externa al repo: `C:/Users/Mike/.codex/visualizations/2026/10/21/01a15d9e-fe1c-7013-8a52-d51287574370/final-audit/`.

| Comprobación actual | Resultado y registro |
|---|---|
| `npm run lint` | PASS, ESLint + Stylelint; reglas/dependencias intactas |
| `npm run build` | PASS; dist solo main.js, sin CSS/JS/mapas de guía ni selectores cl-guia/cl-muestra. `build.json`; dev restablecido después |
| `php -l` / `git diff --check` | PASS: 40 PHP de guía; diff sin errores de whitespace |
| Dos suites Node | PASS: `node scripts/probar-carrito.mjs`, `node scripts/probar-cierre-comercio.mjs`; nueva regresión Undo más invariantes/importes/descuento/colecciones/paginación/horarios/DST/grupos existentes |
| HTML renderizado | html5lib: tres documentos fuente sin errores tras A05. DOM: h1/main, IDs, ARIA/labels/alt y enlaces vacíos; `structure.json`, HTML y `html-source-after.json`. No es certificación Nu/W3C |
| Responsive | `responsive.json`: tres guías × 320/360/390/425/768/820/992/1024/1280/1440, ancho efectivo comprobado, sin overflow de documento. `cart40-responsive.json`: diez anchos con 40 líneas/120 unidades, diez visibles/página |
| Visual | 30 capturas finales y tres hojas `sheet-*`; Core, Hero, pedido, galería, regalo, reseña, carrito, reserva y Footer a 390/768/1280. `visual-records.json` verifica llegada al ancla. No se evaluaron todas las variantes en cada viewport |
| Mini/viewport corto | `mini-responsive.json`, `mini-short-keyboard.json`: diez anchos con 40 líneas, tres visibles y body/pie con scroll. A 320×360, Tab/Shift+Tab desplazan el pie y muestran CTA completo (top 273.97/bottom 317.97). Requiere scroll interno; no se confunde recorte inicial con control inaccesible |
| Estados y acciones | `states.json`: 59 estados con mensaje/siguiente paso/destino; `wave4-states.json`: 29 opciones; `functional.json`, `payment.json`, `promo.json`, `undo-*.json`, `mini-replacement-*.json`; muestras/locales, no operaciones reales |
| Formularios/comercio | Primer error, consulta privada fallo→recuperación, reseña/borrador/filtro, pedido volver/datos/revisión, siete outcomes de pago y cambio de carrito, fecha cerrada/slot/reserva/grupo, gestión y Gift/Club/Event→pendiente. No es prueba de cada combinación ni de concurrencia real |
| Overlays/teclado | `core-keyboard.json`, `overlays.json`, `gallery.json`: trap/confirmación/Escape/retorno; tres ciclos Nav/Discover; Auth Show/Hide y reset al cerrar; visor 2/6 y error→recuperación. Comprobar limpieza después de hidden, no solo al retirar .show |
| Contraste/foco | `contrast.json`: 276/1196/55 elementos con texto sobre superficies sólidas en Core/Patterns/Nav; mínimos 4.58/6.13/6.13:1, sin fallo de umbral. Excluidos disabled, opacidad y Hero fotográfico. Outline Foundation 2px/3px e interacción de teclado inspeccionados |
| Recursos/consola | `resources.json`: 68 URLs locales inventariadas, todas 200; no equivale a 68 descargas de navegador. Consola de carga limpia sin errores/warnings en las vistas probadas; error A01 previo archivado aparte |
| Listeners/ciclo de vida | WeakMap/getOrCreateInstance, AbortController, observers/timers y destruir inspeccionados en módulos aplicables; reaperturas sin overlays residuales. No se afirma medición de heap ni desmontaje dinámico de todos los módulos |

Metodología: se descartaron capturas tomadas durante scroll y se aislaron los clientes de BrowserSync antes de las finales: su sincronización entre pestañas interfería con la posición. Primeros intentos de acciones antes de shown/hidden o con selector de resultado incorrecto se repitieron sobre estado estable; esos timeouts no se presentan como defectos corregidos. Fixture A02 y bundle temporal retirados del workspace; fuente de prueba conservada en la evidencia, no como componente nuevo.

## Performance y limitaciones

Misma base `4c6ec25`; CSS de build minificado, gzip Node por defecto. Guía ESM/es2020 sin sourcemap empaquetada en memoria, misma configuración antes/después; los fuentes anteriores se leen con git show, sin checkout alternativo.

| Artefacto | Bytes antes → después | Gzip antes → después |
|---|---:|---:|
| CSS producto | 115904 → 115904 | 18726 → 18726 |
| JS producto | 0 → 0 | 20 → 20 (flujo vacío) |
| JS guía, sin sourcemap | 219670 → 220854 | 51512 → 51746 (+234 B) |
| Sprite | 12028 → 12028 | 4038 → 4038 |

`performance.json` y `build.json`. SHA256 productivo vacío: `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. Cero imágenes/dependencias/fuentes nuevas. Medios de archivo pueden ser grandes: el mayor fallback inventariado es JPEG de 554353 B; Gift front 308594 B y logo UI 285557 B. No se optimizan originales en este alcance. Lazy y dimensiones/proporciones presentes; prioridad LCP/carga/CLS se evaluarán en cada página real.

**No ejecutado/no verificable:** zoom real 200% y reflow por zoom 400% (Ctrl+= no cambió innerWidth ni DPR; no equivale a probar 200%), texto aumentado por preferencia del navegador, forced colors, emulación de reduced motion del SO, lector de pantalla auditivo, Firefox/Safari, touch físico y Apache/GoDaddy. Reduced motion se inspeccionó en la cascada, no se emuló. Tampoco HAR/requests efectivos, red fría, heap, LCP/INP/CLS de campo, carga/concurrencia servidor o integraciones comerciales. El scope de evaluación no expone performance; no se inventan métricas. BrowserSync emite DEP0060 en terminal; lint/build pasan. Estas limitaciones son pruebas pendientes antes del cutover correspondiente, no defectos frontend declarados resueltos.

## Archivos, revisión y dictamen

Cambios de cierre: `assets/js/modules/patterns/{estado-carrito,carrito,mini-carrito}.js`, `assets/js/style-guide.js`, `scripts/probar-cierre-comercio.mjs`, `style-guide/{index,patterns,navigation}.php`, `style-guide/partials/carrito-checkout-wave-7.php`; documentación: este informe, `CORE-COMPONENT-LIBRARY.md`, `SECTION-PATTERN-LIBRARY.md`, `DESIGN-SYSTEM-READINESS.md` y `WAVE-7-COVERAGE.md`. Catorce archivos, sin eliminación de fuentes de producto.

Excepción autorizada sobre Core: solo copy/acciones de muestras para A03/A04; API/SCSS/tokens intactos. No cambia ninguna página productiva, CSS/JS legacy, original multimedia, backend/BD, Booking-app-php, hosting, htaccess, robots, sitemap o dependencias. Commit coherente en español y push normal de la misma feature; sin PR, merge, force push o deploy. El SHA y árbol limpio se verifican en la entrega.

Revisión con `npm run dev`: `http://localhost:3000/style-guide/` (Buttons/Alerts/Toast), `/style-guide/patterns.php#w7-carrito`, `#w7-checkout`, `#w7-pago`, `#w7-reserva`, y `/style-guide/navigation.php`. Usar solo datos ficticios. Aprobar el cierre no autoriza activar servicios ni evita el QA de la página integrada.

**DESIGN SYSTEM READY — WAITING FOR FINAL HUMAN APPROVAL**

Dictamen limitado al frontend y los recorridos comprobados. Dependencias comerciales y backend descritas arriba; no queda un P0/P1 frontend conocido que requiera otra wave. Las pruebas no ejecutadas permanecen explícitas y no se afirma certificación WCAG ni disponibilidad comercial.
