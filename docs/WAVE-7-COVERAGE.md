# Wave 7 — matriz de cobertura y verificación

Base: `9513e52` (PR #12, Wave 6 integrada en develop). Preflight limpio, fetch y fast-forward ejecutados el 2026-10-19. Rama exclusiva `feature/ui-section-patterns-wave-7`. Este registro se inicia antes de implementar; el cierre y la evidencia se incorporan tras las pruebas.

## Auditoría inicial

Actor común: visitante; cuenta futura: titular autorizado. Todos los ejemplos son sintéticos y se identifican en pantalla. Ninguna selección confirma servicios, disponibilidad o precios vigentes.

| Necesidad / caso de uso | Decisión / reutilización | Pieza faltante y estados | Interacción / datos | Backend pendiente | Riesgo accesible / seguridad | Aceptación frontend |
|---|---|---|---|---|---|---|
| Carrito / revisar productos | CREAR composición; Core cantidad, producto Wave 2 | Líneas y resumen compacto/página/lateral/móvil; vacío, actualizando, error, retirado, no disponible, inválido, desactualizado | Añadir, editar, eliminar, reintentar; centavos enteros, moneda, variante | Reprecio, impuestos, inventario | Foco al eliminar; importes manipulables | Resumen consistente, CTA bloqueado si inválido o desactualizado |
| Pickup / order ahead | EXTENDER composición, Core Forms | Modalidad y preferencias; pendiente, recibido, preparación, listo, completado, cancelado, rechazado, error, disponibilidad pendiente | Fecha/hora solicitada, mesa/referencia, notas alimentarias | Cocina, servicio y disponibilidad | Labels condicionales; no prometer horario | Modalidad coherente sin delivery |
| Checkout / revisar y continuar | CREAR composición compartida | Datos y revisión; validación, espera, fallo, recuperación | Volver conserva datos, confirmación única | Orden y autoridad de totales | Foco de paso; doble confirmación | Dos pasos reales, datos conservados |
| Pago / consultar resultado | REUTILIZAR Core Alert/Estado/Loading | Presentación de proveedor futuro; procesando, aprobado demo, rechazado, pendiente, expirado, error, desconocido | Simular resultado y consultar antes de repetir | Proveedor, idempotencia, conciliación | Anuncios; cargos duplicados | Sin tarjeta/CVV ni reintento automático |
| Reserva / solicitar mesa | CREAR selector horario, Core Forms | Inicial, búsqueda, slots demo, sin slots, seleccionado, perdido, error, pendiente, confirmado demo | Fecha local, comensales, slot, contacto, notas | Inventario/concurrencia, zona IANA y DST | Radios/errores; fecha desplazada | Invalidar slot al cambiar criterios, hora restaurante explícita |
| Gestión reserva / titular | EXTENDER resumen/estado compartidos | Consulta, cambio, cancelación, modificada, cancelada, restricción, no-show | Revisar solicitud/cancelar demo, referencia sintética | Autorización, políticas | Confirmación clara; exposición de titular | No cambios reales ni políticas inventadas |
| Gift Card / completar selección | REUTILIZAR diseñador Wave 4; CREAR revisión transaccional | Pago, emisión pendiente, emitida demo, error | Importar importe/dedicatoria, revisar | Proveedor, entrega, condiciones | Datos faltantes; código/redención falsos | Sin duplicar diseñador ni generar código/saldo |
| Wine Club / suscripción | REUTILIZAR Gold/Diamond Wave 4; EXTENDER revisión | Términos pendientes, pago pendiente, activación demo, renovación pendiente, fallo, actualización, cancelación programada, finalizada | Importar plan, aceptación explícita de condiciones de ejemplo | Precio/cadencia/términos y proveedor | Checkbox obligatorio; renovación inventada | Sin promoción vigente ni periodicidad inventada |
| Evento / asistentes | REUTILIZAR evento Wave 4; EXTENDER transacción | Cupos demo, agotado, pendiente, registrado demo, cancelado/reprogramado, error | Importar evento, cantidad Core | Capacidad, precio, registro autorizado | Límites y feedback; cupo falso | Cantidad válida, sin ticket ni waitlist no ofrecida |
| Consulta privada / seguimiento | REUTILIZAR formulario Wave 4 y estado compartido | Recibida, revisión, más información, propuesta, confirmada demo, no disponible, cerrada | Explorar estados con siguiente acción contextual | Evaluación y propuesta del equipo | No confundir consulta y reserva | Vistas diferenciadas y explicación de siguiente paso |
| Confirmación / recuperación | CREAR composición sobre Core | Iniciada, revisión, procesando, confirmada, pendiente, rechazada, cancelada, expirada, error, desconocida, recuperación | Referencia y siguiente paso por dominio | Estado autoritativo | Live duplicado; repetición de pago | Copy específico por dominio, confirmación etiquetada demo |
| Cuenta / operaciones futuras | CREAR historial mínimo sobre resumen | Operaciones, vacío, error, no autorizado | Acciones contextuales locales | Autorización y privacidad servidor | Foco, exposición de datos | No mostrar filas sin autorización demostrativa |

**DIFERIR:** datos comerciales pendientes, proveedor, delivery de Gift Cards, precio/cadencia/renovación, políticas y publicación de páginas. **FUERA DE ALCANCE:** backend, BD, cuentas reales, admin, pagos, emails, reservas, persistencia, Booking-app-php, producción y Wave 8.

## Cierre técnico — 2026-10-20

Las doce familias anteriores quedan **COMPLETAS EN FRONTEND CON DEPENDENCIA BACKEND**. El recorrido local no crea compras, cargos, reservas, membresías, tarjetas, tickets ni cuentas. Las responsabilidades nuevas y contratos se documentan en la sección Wave 7 de `SECTION-PATTERN-LIBRARY.md`. No hay bloqueantes frontend conocidos tras el QA ejecutado; continúa pendiente la aprobación visual humana.

### QA ejecutado

Skill `.agents/skills/qa-visual/SKILL.md`; Chromium del navegador integrado. Evidencia local fuera del repositorio en `C:/Users/Mike/.codex/visualizations/2026/10/19/01a15601-3a20-7b21-a875-71755abbaabb/wave-7/`. Registros: `funcional.json`, `estados.json`, `responsive.json`, `accesibilidad.json`, `html-estructura.json`, `antes.json`, `despues.json`; capturas representativas de móvil/tablet/escritorio. Las capturas preliminares pueden corresponder a una posición de scroll anterior: para revisión usar `reserva-1280.png`, `reserva-768.png`, `reserva-formulario-390.png`, `checkout-1280.png`, `pago-1280.png`, `club-1280.png` y `evento-1280.png`.

| Comprobación | Resultado / evidencia |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint finales, sin cambios de reglas |
| `npm run build` | PASS: CSS minificado, sprite y JS productivo; solo `main.js` en dist, sin CSS/JS/mapas de guía ni selectores cl-guia/cl-muestra |
| PHP lint | PASS: `patterns.php` y los seis partials nuevos, siete archivos |
| HTML renderizado | PASS para estructura nueva: html5lib, IDs únicos, un h1; dos errores de entidad preexistentes de Google Fonts también presentes antes. No se afirma certificación W3C sin avisos |
| Diez anchos | PASS: 320/360/390/425/768/820/992/1024/1280/1440; medición final real de innerWidth, sin elementos visibles fuera del viewport ni overflow de documento. El drawer cerrado fuera de pantalla se excluye por visibility:hidden |
| Controles / fotos | PASS: acciones/inputs/select/summary nuevos ≥44px; imágenes Wave 7 cargadas, SVG decorativo y botellas contain; sin imágenes originales nuevas o alteradas |
| Labels / ARIA / semántica | PASS: campos etiquetados, fieldset/legend, errores asociados, disabled reales; sin referencias aria-controls/describedby/labelledby rotas en Wave 7. Se incluyó acceso Wave 6 existente para resolver el destino de su botón |
| Contraste | PASS: 281 textos visibles medidos con fondos efectivos; mínimo 6.13:1, sin fallos contra 4.5 normal / 3 grande. Controles disabled excluidos del requisito de texto |
| Teclado / foco | PASS: Enter, Tab/Shift+Tab, validación al primer campo inválido, pasos con foco, retorno al volver; anillo champagne 2px observado. Drawer: Escape cierra primero Discover, después el panel; modal: Tab y Escape con retorno al activador tras sus transiciones |
| Carrito | PASS: 2 boards + botella = $117, cero inválido bloquea, blur restaura; retirar ambas líneas → vacío, añadir recupera; error/desactualizado/actualizando/no disponible bloquean; error conserva cantidad 2, refresh recupera $117 |
| Checkout / modalidades | PASS: pickup fecha/hora y mesa con contexto; revisión correcta, volver conserva campos, fallo permite recuperación y éxito bloquea duplicado. Espacios solos en nombre obligatorio rechazados |
| Pago | PASS: seis resultados y procesando; consulta disponible en pendiente/desconocido/expirado/error; recuperación muestra resultado ficticio sin repetir cargo; reset claramente demostrativo |
| Reservas | PASS: búsqueda, selección 18:00, resumen/contacto/revisión, confirmada demo; cambiar 2→4 comensales borra slot y conserva contacto; sin horarios/error/pérdida del horario durante confirmación con recuperación |
| Gestión | PASS: conservar reserva/volver, cambio pendiente, cancelación pendiente con textos distintos, restricción/fallo y éxito; cancelada actualiza etiqueta y deshabilita acciones |
| Gift / Club / Event | PASS: selección ausente no se asume; importación de monto100/dedicatoria, Gold/Diamond y evento desde Wave 4; correo inválido bloquea; club exige condiciones; evento max4 y agotado bloquea; resultados locales por dominio |
| Estados / cuenta | PASS: 58 estados en siete dominios con siguiente paso no vacío; cuenta cuatro filas ficticias, vacío/error/no autorizado cero filas en DOM y reintentar restaura |
| Estrés / viewport corto | PASS: nombre largo y notas extensas en revisión a 320×568 sin overflow; vuelta conserva valores; campos fecha/hora y totales se ajustan. Límites demo mayores (6 boards + 6 bottles = $486) y formato de moneda entero cubren el total permitido |
| Fecha / importe | PASS: siete assertions Node: USD117/0, rechazo fracción/entero inseguro, fecha civil LA al cruzar medianoche y al finalizar DST, presentación May18 sin cambio de día |
| HTTP / iconos / consola | PASS: 51 recursos locales únicos del markup devuelven200; 19 símbolos usados existen; sin errores/warnings de página observados. BrowserSync muestra DEP0060 preexistente en Node |
| Regresiones | PASS de humo: Foundation/Core carga, cantidad6, accordion por Enter y Modal; Wave1 visible y markup/fuentes sin modificar; Wave2 cantidad3→$108; Wave3 visor2/6 y Escape; Wave4 selección/importaciones; Wave5 filtro5estrellas→1 reseña y carrusel; Wave6 Header/drawer/Footer/modal reutilizados. No es una nueva certificación exhaustiva de las seis waves |
| Protección | PASS: diff de alcance; JS productivo vacío e idéntico, sin dependencias nuevas, sin cambios a Foundation/Core/partials anteriores, producción, hosting, BD, legacy, originales ni Booking-app-php |
| Dev / watch | PASS: PHP8000 + BrowserSync3000 y watcher, reiniciados tras medir build; URL local disponible |

Correcciones surgidas del QA: gutters móviles de24px para evitar salida de la row; target44px del summary de condiciones; heading de revisión sin salto de nivel; carga de búsqueda; preservación del carrito en escenarios; rechazo de espacios solos; distinción de pendientes y etiqueta de cancelación; relación accesible del acceso reutilizado. Cambios limitados a las piezas nuevas y sus entradas.

**Limitaciones expresas:** zoom real200% intentado sin cambio de escala verificable; no se declara ejecutado. Reduced motion: regla Foundation/Core existente revisada (animaciones/transiciones0.01ms, scroll auto); no se emuló preferencia del SO. Sin Firefox/Safari, dispositivo físico, lector de pantalla auditivo ni Apache/GoDaddy. No hay HAR, medición de CLS/Web Vitals o red de producción: performance no está disponible en el scope de inspección del navegador. La geometría y los conteos HTTP/markup no sustituyen esas mediciones.

### Performance comparable

Antes sobre base9513e52 y después sobre fuentes finales. CSS: mismo `npm run build`; JS guía: esbuild en memoria con bundle/esm/es2020, sin sourcemap; gzip Node zlib por defecto en ambos. El bundle minificado de guía solo se mide en memoria, no se publica.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Diferencia gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto |106024|110386|17432|17944|+512 (+2.94%)|
| JS producto |0|0|20|20|0|
| JS guía DEV |119537|165087|27650|38612|+10962 (+39.65%)|
| JS guía minificado, medición |64565|96775|20093|29593|+9500 (+47.28%)|

El CSS crece por líneas/resumen, composición de pasos/datos/acciones y horarios. El JS de guía crece por las interacciones de doce familias y los58 estados/copy; no entra al producto. SHA256 del JS productivo vacío: `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`.

Markup renderizado, contando solo img con src no vacío:39→48 instancias,17→20 URLs únicas normalizadas. Los nueve usos nuevos reutilizan fotografía/arte/logo existentes; no aumentan el peso de los archivos originales. Recursos locales únicos declarados (incluidos formatos alternativos, scripts, CSS, iframe y sprite):50→51; único recurso agregado al documento padre: logo UI ya usado en el iframe Wave6. No equivalen al total de requests de red: lazy loading, caché, fuentes externas, alternativas picture y el iframe alteran los requests efectivos. Sin archivos de imagen/dependencias nuevos, sin PurgeCSS ni cambios de pipeline.

### Revisión de dirección artística

Se revisaron composiciones representativas a390/768/1280 y la geometría de todas las familias en los diez anchos. Oscuros/champagne, Libre Bodoni, fotografía del restaurante y arte oficial conservan la dirección Foundation. Los paneles y resúmenes tienen jerarquía consistente, las acciones de revisión preceden a la simulación y el resultado indica cómo recuperarse.

| Flujo | Lectura / jerarquía / recuperación / proporciones |
|---|---|
| Carrito y pickup | Producto/foto/cantidad/importe identificables, resumen lateral que se apila, modalidades claramente distintas y datos preservados |
| Checkout y pago | Preferencias y revisión separadas, monto/referencia visibles, espera explícita y consulta antes de repetir; proveedor pendiente sin campos financieros falsos |
| Reserva y gestión | Invitación editorial + formulario de visita, fotografía de interior, resumen útil; slot perdido y cancelación explicados; safe action conserva la reserva |
| Gift | Arte original sin deformación, selección heredada, importe/dedicatoria y emisión diferenciados |
| Club | Vino y relación recurrente claros, Gold/Diamond importados, condiciones legibles; activación no equivale a pago |
| Evento y privado | Fecha/asistentes/cupos en contexto, foto apropiada; consulta mantiene evaluación/propuesta/confirmación separadas |
| Estados y cuenta | Referencia y siguiente paso por dominio, historial compacto y sin registros al no autorizado; sin dashboard desproporcionado |

No se detectaron espacios vacíos accidentales, truncamiento ni necesidad de reconstruir visualmente estas piezas para conectarlas a su contrato futuro. La integración real aún debe adaptar datos, estados y política de cada página. Esta autoevaluación no sustituye la aprobación humana.

### Informe de entrega (31 puntos)

| # | Área | Resultado verificable |
|---|---|---|
|1|Rama/base|`feature/ui-section-patterns-wave-7`, base `9513e526794ad4a3205dd1d5161122fed254fabd`|
|2|Commits/sincronización|Commits Conventional Commits en español, push normal de esta feature; SHA y0/0 se entregan en el mensaje final|
|3|Auditoría inicial|Matriz de doce familias al inicio de este archivo, anterior a implementar|
|4|Creados|Tres SCSS, cuatro módulos reutilizables, orquestación/fixtures guía y seis partials PHP|
|5|Reutilizados|Foundation/Core, producto/editorial, Gold/Diamond/regalo/evento/privado, Header/Footer/acceso/sprite|
|6|Cart|Líneas/cantidad/retirada/resúmenes/estado/recuperación, importes enteros|
|7|Take Away|Pickup o mesa con preferencias e instrucciones; sin delivery|
|8|Checkout|Datos/revisión/volver/carga/error/confirmación local única|
|9|Payment|Resultado separado de prestación, desconocido y consulta sin cargo|
|10|Reservations|Fecha restaurante/comensales/slots/revisión e invalidación segura|
|11|Booking management|Resumen/cambio/cancelación/política y estados separados|
|12|Gift|Selección Wave4→revisión→pago/emisión; sin código real|
|13|Club|Plan/condiciones/revisión y ciclo recurrente conceptual|
|14|Event|Asistentes/resumen/cupos/registro/agotado y estados posteriores|
|15|Private|Siete estados de conversación, propuesta y confirmación posterior|
|16|Account|Historial mínimo y vacío/error/no autorizado, FUTURE|
|17|Transaction States|Familia compartida sobre Core, contexto/referencia/acción|
|18|PHP/MySQL|Nueve contratos por dominio y requisitos servidor en SECTION-PATTERN-LIBRARY|
|19|Estados|58 estados compactos más estados interactivos locales; siete dominios|
|20|Accesibilidad|Labels/ARIA/semántica/foco/teclado/contraste verificados; limitaciones arriba|
|21|Responsive|Diez anchos PASS, viewport corto y contenido largo; zoom real sin verificar|
|22|QA funcional|Recorridos y matriz en tabla QA y registros externos|
|23|Regresiones|Humo Foundation/Core y Waves1–6; fuentes previas preservadas|
|24|Performance|CSS+512B gzip; JS productivo idéntico; guía+10962B gzip DEV; sin nuevas imágenes/deps|
|25|Auditoría global|Inventario Foundation/Core/Waves1–7 en DESIGN-SYSTEM-READINESS|
|26|Readiness|Composición frontend disponible para las diez páginas; integración y aprobación pendientes|
|27|Comercial|Precios/impuestos/ventanas/cupos/condiciones/beneficios/entrega/legales/canales por confirmar|
|28|Backend|Autoridad de totales/estados, proveedor, concurrencia, identidad/autorización y recepción de solicitudes|
|29|Archivos|Fuentes Wave7 y entradas indicadas en SECTION-PATTERN-LIBRARY; cuatro documentos actualizados/creados|
|30|URLs|`http://localhost:3000/style-guide/patterns.php#wave-7`; anclas w7-carrito/checkout/pago/reserva/gestion/regalo/club/evento/estados/cuenta; `/style-guide/` y `/style-guide/navigation.php`|
|31|Aprobación|Técnicamente listo para revisión humana; sin PR/merge/force/deploy. No implica autorización de venta ni aprobación visual|

WAVE 7 TECHNICALLY READY — WAITING FOR VISUAL APPROVAL

## Refinamiento final — auditoría previa (2026-10-20)

Preflight: `feature/ui-section-patterns-wave-7`, HEAD `c0b21c8`, limpio, fetch y sincronización0/0. Wave6 integrada en base9513e52; diff contra develop limitado a los22 archivos Wave7 conocidos. Sin cambios ajenos. `production-baseline` no contiene estas guías/SCSS/módulos.

| Hallazgo comprobado | Clasificación / decisión |
|---|---|
| Payment usa USD81 fijo y el carrito cambia cantidades | CORREGIR: un snapshot de líneas/importes/versionado para Cart→Checkout→Payment; invalidar revisión/esperas al cambiar |
| Carrito exige HTML por cada producto y restaura mediante dos botones específicos | CORREGIR: plantilla de línea, identidad estable, API de sustitución/actualización y Undo local; fixtures numerosos solo bajo demanda |
| Precio, cantidad y Remove compiten con escasa jerarquía | REFINAR: subtotal de línea protagonista, unidad secundaria, distribución responsive y papelera accesible Core |
| Resumen tiene CTA de ancho natural y no distingue cargos | REFINAR: CTA contextual completo, importes y pendientes explícitos |
| No existe patrón de promo | CORREGIR: disclosure y validación demo recuperable; descuento entero validado por el anfitrión, sin motor comercial |
| Header carece de acceso al carrito | CORREGIR: extensión optativa autorizada Wave6, enlace y contador de unidades sin acoplamiento a fixtures; laboratorio independiente sin cantidad falsa |
| Sprite curado no contiene papelera | CORREGIR: añadir exclusivamente el símbolo trash del paquete Bootstrap Icons ya instalado al manifiesto Core; sin dependencia ni sistema nuevo |
| Pickup no muestra dirección; contexto mesa requerido aunque puede no existir | REFINAR: dirección proporcionada, contacto teléfono opcional y contexto mesa opcional; separar solicitud y reserva |
| Reserva muestra contacto antes de elegir horario y empieza por fecha | REFINAR: comensales→fecha→búsqueda→horario→contacto; preservar datos cuando se pierde el slot |
| Fechas/slots son civiles LA; disponibilidad no autoritativa | CONSERVAR y DOCUMENTAR PARA BACKEND: min actualizada al revisar, DST/instantes/capacidad/bloqueo/transacción a cargo del motor futuro |
| No hay patrones contextuales de restricción de vino/modalidad | REFINAR: avisos/estado restringido demo, sin inventar verificación legal ni elegibilidad real |
| Gold/Diamond, Gift, Event y58 estados ya están cubiertos | CONSERVAR: comprobar coherencia, corregir copias de importe desconectado y regresiones |
| Backend, promociones reales, pagos, identidad y publicación | FUERA DE ALCANCE; contratos de autorización/idempotencia/concurrencia y decisiones comerciales permanecen documentales |

La auditoría se cierra con implementación y pruebas dentro de este refinamiento; no abre otra wave ni una nueva feature.

### Cierre del refinamiento final — 2026-10-20

Este registro sustituye, donde difiere, el comportamiento y QA del cierre original `c0b21c8`; conserva su auditoría histórica. Cobertura actual: **COMPLETO CON DEPENDENCIA FUTURA** para operaciones comerciales; sin defecto frontend bloqueante conocido tras las pruebas ejecutadas. No se publica un porcentaje de completitud ni se crea otra wave.

Evidencia local: `C:/Users/Mike/.codex/visualizations/2026/10/20/01a15601-3a20-7b21-a875-71755abbaabb/wave-7-refinement/`. Registros: `funcional.json`, `estados.json`, `responsive-stress.json`, `responsive-reserva.json`, `accesibilidad.json`, `html-recursos.json`, `antes.json`, `despues.json`. Capturas representativas: `carrito-1280.png`, `carrito-768.png`, `carrito-320.png`, `summary-390.png`, `reserva-1280.png`, `reserva-768.png`, `reserva-390.png`, `payment-1280.png`. Las capturas de estrés y escenarios son evidencia local, no assets nuevos del sitio.

| # | Área | Resultado del refinamiento / verificación |
|---|---|---|
|1|Git|Misma feature, base de refinamiento `c0b21c8ca4fc453545ea3ce9619bfab9f298f809`; fetch/preflight0/0 y sin cambios ajenos. Sin tocar main/develop|
|2|Commits|Cambio coherente con fuentes, contratos, QA y regresión automatizada en español; SHA/push/sincronización final se informan al entregar|
|3|Hallazgos|Matriz previa en este archivo: Payment fijo, líneas estáticas, precios/Remove/CTA, promo ausente, Header sin carrito, flujo de reserva y contacto|
|4|Carrito|Plantilla y nodos estables, foto/producto/variante/unidad/cantidad/subtotal/papelera; conserva composición general y grid|
|5|Precios|Unidad secundaria y subtotal de línea champagne, números tabulares; todo cálculo en `estado-carrito.js`. $81→$71 con DEMO10; cantidad vino3→$161 y cambio a copa→$62, iguales en cuatro resúmenes|
|6|Eliminar/restaurar|Papelera Core con nombre específico y44px; feedback y Undo, sin modal obligatorio. Restaurar conserva cantidad/variante y devuelve foco al control de línea|
|7|Muchos productos|1/2/8/20/40 líneas sintéticas bajo demanda;50 combinaciones con diez anchos, sin overflow.40 líneas suman120 unidades; sin paginación ni carga de catálogo|
|8|Resumen|CTA ocupa301/301px útiles en390px y centra texto/ícono. Subtotal/descuento/ajustado separados de impuestos/cargos/final null; compacto y lateral sincronizados|
|9|Promos demo|Sin código, introducido, validando, aplicado, inválido, expirado, no elegible, ya aplicado, error y retirado. Un descuento fijo1000 centavos con mínimo5000; no se duplica. Cambio que deja de cumplir lo retira con aviso; validación tardía se aborta. Enter conserva foco readonly durante espera|
|10|Coherencia|Snapshot versionado Cart→Order→Review→Payment. Cambiar cantidad/variante/descuento invalida Review y Payment, conserva contacto y exige nueva revisión; respuesta pendiente cancelada no aparece sobre nueva selección|
|11|Header Cart|Extensión mínima autorizada: ruta PHP optativa + API `actualizarCarrito`. Bolsa Core entre Reserve y Account en desktop, visible con logo/cuenta/menú en320px. Sticky/Discover/Drawer y Footer conservados|
|12|Contador|Suma de unidades, vacío0, vista99+ sobre99 y nombre accesible completo120. Sin live announcements por cada incremento. Laboratorio Wave6 independiente: cero enlaces/contadores falsos y sin overflow a320|
|13|Take Away|Dirección211 N Mt Shasta Blvd, Mt Shasta, CA96067; fecha/hora solicitadas, producto/contacto/teléfono opcional/notas y revisión. Ventana/aceptación no se garantizan|
|14|Order Ahead|Referencia opcional, campos pickup ocultos deshabilitados y valores conservados al alternar; resumen aclara que no reserva mesa ni avisa cocina|
|15|Reservas|Comensales→fecha→búsqueda→horario→contacto→revisión. Radios con Selected textual/disabled; contacto progresivo y teléfono opcional. Se corrigió estrechez de slots tablet y alineación de campos; selección se invalida por fecha/comensales y contacto se conserva|
|16|Booking Management|Conservar/cambiar/cancelar, pendiente/restricción/error y confirmada demo. Cancelar deshabilita acciones; cambiar escenario limpia resultado anterior para evitar etiqueta contradictoria|
|17|Payment|Método hospedado futuro explícitamente no disponible, sin logos/PAN/CVV. Procesando y seis resultados probados; consulta en pendiente/desconocido/expirado/error y reset local sin cobro. Monto sincronizado y final no autorizado|
|18|Gift Cards|Diseñador Wave4 intacto; importación de100/dedicatoria, validación/revisión/pago pendiente; emisión separada y sin código comercial. Cambiar escenario invalida Review/espera|
|19|Wine Club|Gold/Diamond importados; condiciones obligatorias verificadas y precio/cadencia/renovación pendientes. No promoción histórica vigente ni activación real|
|20|Events|Selección existente, asistentes4, agotado bloquea, registro demo y estados posteriores preservados; sin ticket/waitlist. Private inquiry mantiene sus siete estados y confirmación posterior|
|21|Estados|58 estados recorridos en siete dominios; todos con próximo paso no vacío. Cuenta conserva cuatro filas y retira todas del DOM en vacío/error/no autorizado|
|22|Validación|Vacíos/espacios/email/teléfono sintáctico/cantidad/límites/selección/condiciones; foco en primer error. Fecha civil LA y min refrescada antes de validar; assertions de medianoche/DST y presentación civil sin desplazamiento|
|23|Accesibilidad|PASS:328 textos, mínimo6.13:1, sin fallos de contraste, labels/ARIA correctos, un h1 e IDs únicos; targets≥44px. Tab/Shift+Tab/Enter/Space/Escape, trap y retorno de foco probados tras terminar transiciones. Contador sin live, precio sin anuncios repetidos|
|24|Responsive|PASS:50 casos carrito y diez de reserva,320/360/390/425/768/820/992/1024/1280/1440. Nombre largo, foto ausente, precio$1,234,567.89, estados y viewport320×568; sin truncar información crítica. Zoom200% no verificable|
|25|Performance|Tabla comparable abajo. JS productivo idéntico; sin dependencias ni fotos nuevas. Estrés generado solo al solicitarlo|
|26|Seguridad|DOM mediante plantilla/textContent/createElement; identidad única e importes/variantes/rangos validados, imagen local sin traversal, snapshots aislados. AbortController y temporizadores cancelados, inicialización idempotente, sin red/persistencia/sesiones/credenciales ni operación comercial. Backend sigue siendo autoridad|
|27|Regresiones|PASS de humo: Foundation/Wave1 renderizan sin cambiar fuentes; Core cantidad6/accordion/modal/trap; Wave2 cantidad3→$108; galería2/6 y retorno; Gift/Club/Event anteriores; filtro5estrellas→1 reseña; Review/Video Carousel avanzan; Header/Drawer/Discover/acceso/Footer y laboratorio independiente. No equivale a recertificación exhaustiva de todas las waves|
|28|Cobertura|Inventario original conservado y hallazgos corregidos. Frontend preparado para Restaurant/Wines/Cart/Take Away/Order Ahead/Checkout/Gift/Club/Events/Reservations/Status/Account FUTURE, con integración posterior|
|29|Documentación|Contratos actualizados en SECTION-PATTERN-LIBRARY; índice práctico en DESIGN-SYSTEM-READINESS; este cierre y arquitectura coherentes. Sin reescribir Foundation/Core/Waves previas|
|30|Archivos|23 archivos:3 nuevos (`patterns/estado-carrito.js`, `patterns/promocion.js`, `scripts/probar-carrito.mjs`),20 modificados de Wave7, Header autorizado, manifiesto y cuatro docs. Inventario exacto abajo|
|31|Pendientes reales|Proveedor, totales/impuestos/cargos, vigencia/eligibilidad/uso de promociones, disponibilidad/capacidad/duración/bloqueo, aceptación cocina, obligatoriedad de teléfono, entrega/condiciones y autorización. Vino: validar licencias/modalidades, edad/identificación y procedimiento legal; sin checkbox que finja verificación|
|32|URLs|`http://localhost:3000/style-guide/patterns.php#w7-carrito`, `#w7-checkout`, `#w7-pago`, `#w7-reserva`; Foundation/Core `/style-guide/` y Wave6 aislada `/style-guide/navigation.php`; dev/watch activo al entregar|
|33|Aprobación|Revisión renderizada realizada y problemas detectados corregidos; aprobación visual humana final pendiente. No hay PR, merge, force push ni deploy|

Comandos finales ejecutados: `npm run lint` PASS; `node scripts/probar-carrito.mjs` PASS; `npm run build` PASS; PHP lint de9 documentos/partials PASS; `git diff --check` PASS. Tras el último ajuste de separación de resúmenes se repitieron Stylelint y PHP del partial afectado, PASS. Se verificaron build sin CSS/JS de guía/mapas/selectores de laboratorio y arranque posterior de dev.

HTML renderizado por PHP: mismos dos avisos preexistentes de entidad en Google Fonts, cero errores estructurales nuevos. DOM dinámico completo: IDs únicos, un h1 y parseo sin errores de aplicación tras excluir únicamente el div vacío `codex-browser-sidebar-comments-root` que la herramienta añade después de body; se conserva evidencia cruda y filtrada. No se declara certificación W3C sin avisos.51 URLs locales declaradas devuelven200;27 símbolos del sprite y20 usados en Patterns, ninguno ausente. Consola de página sin errores/warnings relevantes; Node/BrowserSync mantiene DEP0060 preexistente.

Pruebas no ejecutadas o no verificables: zoom real200% (atajo no produjo cambio de innerWidth/devicePixelRatio), emulación de prefers-reduced-motion del SO, Firefox/Safari, dispositivo físico, lector auditivo, HAR/requests efectivos/CLS/LCP/INP y Apache/GoDaddy. Reduced motion se revisó en la cascada Foundation/Core vigente (0.01ms y scroll auto); no se incorporan nuevas animaciones. El scope del navegador no expone performance. No se sustituye zoom por viewport ni un conteo de markup por red real.

#### Performance del refinamiento

Base `c0b21c8`; mismo pipeline/gzip Node por defecto. El JS anterior se empaquetó con esbuild/onLoad leyendo fuentes Git de esa base con los mismos paths; después usa fuentes finales. En ambos: bundle/ESM/es2020, sin sourcemap y write:false; minificado de guía únicamente en memoria. CSS/sprite medidos tras build.

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Cambio gzip |
|---|---:|---:|---:|---:|---:|
|CSS producto|110386|113763|17944|18450|+506 (+2.82%)|
|JS producto|0|0|20|20|0|
|JS guía DEV|165087|191795|38612|44818|+6206 (+16.07%)|
|JS guía minificado, medición|96775|113046|29593|34763|+5170 (+17.47%)|
|Sprite compartido|11536|12028|3920|4038|+118 (+3.01%)|

CSS crece por jerarquía comercial, CTA/disclosure, contador y horarios. JS de guía añade estado validado, plantilla dinámica, promo abortable e invalidación conectada; no entra en producto. El símbolo papelera procede del paquete ya instalado; no se sustituye el sprite ni se instala una librería. JS productivo conserva SHA256 `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`.

Imágenes reales de la muestra principal:48→48 instancias DOM con src y20 URLs únicas; cero archivos originales añadidos/modificados. El PHP fuente pasa48→47 img con src al sustituir dos líneas por una plantilla inerte; ese número no describe las líneas renderizadas ni requests. Recursos locales únicos declarados:51→51, mismos paths; trash es un símbolo del mismo recurso SVG. Alternativas picture, lazy loading, caché e iframe impiden inferir requests efectivos de este inventario. No se fabrican Web Vitals ni medidas de memoria/latencia de40 líneas.

#### Inventario exacto y evaluación visual

Nuevos: `assets/js/modules/patterns/estado-carrito.js`, `promocion.js`; `scripts/probar-carrito.mjs`.

Modificados: `assets/js/modules/patterns/{carrito,checkout,reserva,transaccion,navegacion-global}.js`; `assets/js/modules/guia/transacciones.js`, `transacciones-fixtures.js`; `assets/scss/patterns/_{carrito,navegacion-global,reserva}.scss`; `style-guide/partials/{carrito-checkout,reservas,transacciones}-wave-7.php`, `transacciones-componentes.php`, `cabecera-wave-6.php`; `scripts/iconos.json`; `docs/{WAVE-7-COVERAGE,DESIGN-SYSTEM-READINESS,SECTION-PATTERN-LIBRARY,ARQUITECTURA}.md`. El listado Git de entrega es la autoridad exacta sobre archivos modificados.

Inspección artística: fotografía auténtica, tipografía Foundation y superficies cálidas; precios escaneables con prioridad contextual, subtotal no confundido con cargo final, papelera discreta y CTA evidente. Resumen móvil y tablet legibles; reserva con pasos naturales, slots claros y menos notas técnicas repetidas. Se corrigieron horarios estrechos en tablet y separación de resúmenes tras revisar capturas. Pickup/mesa/reserva y pago/aceptación/emisión/activación conservan significados distintos. No hay rediseño de Gift/Club/Event ni Footer, ni pantallas que aparenten cobrar o reservar sin servicio.

WAVE 7 REFINED — WAITING FOR FINAL VISUAL APPROVAL


## Cierre de comercio — 2026-10-21

Este cierre parte de `567cf7d`, en `feature/ui-section-patterns-wave-7`, con árbol limpio, fetch y sincronización 0/0 con origin. `origin/develop` y la integración de Wave6 (`9513e52`) son ancestros. `production-baseline` no contiene este laboratorio; no se modifican páginas desplegadas. Se conserva la composición aprobada, Foundation/Core y Waves1–6. Sin rama nueva, PR, merge, force push o deploy.

### Auditoría y resolución

| Hallazgo comprobado | Resolución |
|---|---|
| Agregar dependía de un ID que podía confundir producto y línea | `productoId` + `varianteId` definen equivalencia; `id` identifica la línea. Coexisten Bottle/Glass y Board for Two/Four |
| Header solo llevaba al ancla | Mini-cart Bootstrap Offcanvas conectado al mismo proveedor observable; sin IDs del laboratorio en Header |
| Colección extensa sin páginas | Proyección local de diez líneas, independiente del modelo global; páginas1/2/4 para8/20/40 |
| Horarios de reserva estáticos y pickup libre | Configuración compartida inyectada, reloj civil de Los Ángeles, selectores derivados y revalidación en revisión/confirmación |
| Fixture de hasta seis invitados | Opciones1–10 y consulta de grupo mayor de10, con cantidad entera y confirmación manual pendiente |
| Apply contextual estrecho y teléfono próximo a la fila anterior | Apply ocupa100% y centra texto; ritmo mediante el token de espacio5, sin alterar Core |

### Contratos frontend vigentes

- `estado-carrito.js`: `id` estable por línea, `productoId`, `varianteId`, cantidad y precio entero de variante. Cambiar presentación conserva la línea y no modifica otra. `agregar` fusiona solo producto/variante equivalentes con precio/límite coherentes; si un ID quedó ocupado por otra presentación crea otro ID local. Un reprecio inconsistente falla antes de fusionar. Undo conserva orden/cantidad/variante. No hay motor de modificadores: su incorporación futura deberá extender explícitamente la equivalencia.
- Elegibilidad local: `modalidades` en producto o variante, `modalidad('pickup'|'mesa'|null)`, `elegible` y `cantidadValida` por línea. Glass es exclusivamente mesa en la fixture; Bottle admite ambas modalidades solo para explorar el frontend. No se verifica normativa, edad ni autorización real de alcohol. Board for Four describe la presentación; cantidad2 son dos tablas de esa presentación. Precios y tamaños de ejemplo no son oferta vigente.
- `carrito.js`: extiende API con `suscribir(callback) → retirar`, `cantidad`, `variante`, `eliminar`, `restaurar`, `modalidad` y `continuar`. Todas las vistas consumen snapshots, no precios del DOM. Las etiquetas Quantity permanecen asociadas y visualmente ocultas; los nombres accesibles incluyen producto/presentación y se actualizan al cambiar variante.
- `paginarCarrito(total,pagina)` devuelve límites de una proyección de diez líneas. El modelo nunca pierde productos fuera de página; subtotal, descuentos y unidades siempre son globales. Navegar no cambia la versión comercial ni invalida Review. Se acota la última página al eliminar; Undo lleva a la página de la línea restaurada y enfoca su cantidad. Previous/Next semánticos con disabled en extremos, lista enfocada y un anuncio por navegación.
- Header: extensión compatible `conectarCarrito(proveedor,panel)` o parámetros iniciales `proveedorCarrito`/`panelCarrito`. `actualizarCarrito` sigue disponible. Sin conexión conserva el enlace neutral; sin ruta no aparece carrito. Badge99+ mantiene el número completo en el nombre accesible.
- `mini-carrito.js`: Offcanvas derecho de28rem como máximo, adaptado al viewport; cabecera/cierre, cuerpo desplazable y pie sin superposición. Primeras tres líneas con imagen opcional, presentación, cantidad Core, subtotal de línea, disponibilidad, eliminar y Undo. Importes globales, View Cart y Continue to Checkout. Click es el único disparador de apertura: evita aperturas accidentales por hover y conserva un único recorrido táctil/teclado. Bootstrap aporta trap/backdrop/Escape/scroll lock. Un guard en captura espera el cierre del overlay anterior antes de abrir carrito, navegación o acceso; los destinos reciben foco después de hidden. `destruir()` espera el cierre, aborta eventos, retira suscripción y dispone Bootstrap; Header conserva limpieza de observers.
- Promoción: un código activo por pedido; el mismo no se acumula y otro requiere retirar el anterior. DEMO10 mantiene la regla1000 centavos con mínimo5000. DEMO-REDEEMED añade redención histórica sintética; DEMO-EXPIRED/INELIGIBLE/ERROR y cualquier código inválido conservan la selección y descuentos previos. Respuestas tardías se abortan/rechazan por versión. Apply es contextual, no un cambio global de botón.
- Horario: `horario-servicio.js` es lógica pura; `horario-formulario.js` adapta fecha/select nativos. Configuración con `version`, `zona`, `semana`, `excepciones` por fecha y `servicios` habilitados, intervalo, anticipación, duración y última hora. Se valida fecha civil real/pasada, reloj del restaurante, cierre exclusivo, corte, duración y hora anterior al momento local. No convierte una fecha civil según timezone del dispositivo. La autoridad de instantes UTC, ambigüedad DST, concurrencia/capacidad y disponibilidad es del servidor.
- Fixture única `horarioEjemplo`: America/Los_Angeles; lunes/martes cerrados; miércoles–domingo14:00–20:00. Solo la referencia solicitada para DEMO. Reglas sintéticas: pasos30min; pickup/mesa/reserva anticipación30min; última recogida19:30; mesa/reserva duración60min y última entrada19:00. Evento hipotético existente de18:00–20:00 utiliza duración120min. Excepciones exclusivamente sintéticas activables:18mayo2028 cerrado y19mayo16:00–18:00; nunca se presentan como eventos o cierres publicados. El cierre exclusivo evita ofrecer18:00 para recogida en esa jornada especial. Sin duplicación de cálculo por formulario; Header/Footer no publican horas demo.
- Pickup: cambiar fecha limpia hora, informa cierre o ventanas derivadas y conserva contacto. Revisión y confirmación recalculan opciones vigentes; un cambio de configuración invalida la selección y Payment. Teléfono opcional, tipos/autocomplete de contacto y espaciado contextual. No se captura/envía/almacena información personal mediante servicios.
- Order Ahead: fecha/hora contextual según servicio mesa y referencia opcional de visita acordada; no crea reserva, asigna mesa ni implica aceptación de cocina. Una copa demo no puede pasar a pickup. Los campos inactivos permanecen deshabilitados y conservan sus valores.
- Reserva: configuración común, radios de horas generadas y revalidación; cambio de fecha, comensales o configuración invalida selección y Review, preservando contacto. Opciones1–10 son una fixture, no capacidad verificada. Large group solicita entero mayor de10 y contacto/preferencias mediante el mismo checkout: siempre Inquiry pending, incluso si el escenario normal dice confirmed demo. No hay horario ni mesa reservados para el grupo. Booking-app-php permanece intacto.
- Payment: revisar carrito → datos/modalidad → revisión → método habilitado por proveedor → autorización segura → procesamiento → resultado → confirmación de servicio independiente. La demo no tiene método activo ni captura PAN/CVV. Muestra productos/presentaciones/cantidades, descuento, referencia sintética y tax/cargos/total sin confirmar. Cambios comerciales invalidan contexto/timer; procesamiento y duplicados bloqueados. Conserva pending/approved demo/declined/unknown/expired/error/recuperación y añade reconciliation required. Reset cambia solo la simulación, nunca reintenta un cobro.
- Gift/Wine Club mantienen selección/importación/revisión, sin descuentos generales heredados. La revisión de Events comprueba fecha/hora explícita contra la configuración común: una excepción de cierre bloquea la revisión si no existe apertura especial autorizada. Private Experiences sigue siendo consulta, no reserva. Los58 estados previos permanecen; el explorador tiene59 por la incorporación justificada de conciliación. Empty/loading/inválido/no disponible/cantidad/eliminación/Undo/resumen no disponible y listo se exploran en el mismo drawer; paginación, cierre y grupo grande se prueban en sus recorridos, sin inflar el catálogo.

### Dependencias comerciales y backend

| Dominio | Pendiente real antes de publicar |
|---|---|
| Catálogo/cart | Presentaciones, precios/versiones, moneda, inventario, elegibilidad por modalidad y alcohol, repricing e importes autoritativos |
| Promociones | Campaña/código/configuración de elegibilidad; límites por pedido y cliente verificado; historial de redenciones y estado de pago; reserva/canje/reversión en cancelación; concurrencia y verificación atómica. No todos los códigos son de un uso. Guest checkout necesita política de identidad definida; email no verificado, cookies/localStorage no acreditan al cliente |
| Horarios | Propietario confirma horario vigente, excepciones y reglas por servicio. Servidor entrega configuración/versionado, recalcula fecha/hora/zona/instante, lead time, duración, corte y disponibilidad; frontend disabled no autoriza una operación. Eventos extraordinarios requieren programación y autorización explícitas |
| Pedido/Order Ahead | Validar visita/referencia cuando corresponda, stock/preparación/recogida, contacto mínimo, aceptación y notificación; no confundir recepción con aceptación/listo |
| Reserva/grupo grande | Adaptar motor, capacidad y concurrencia; duración y último inicio autorizados; evaluación manual para grupos. Identidad/autorización de gestión y políticas de cambio/cancelación |
| Payment | Seleccionar proveedor; lista de métodos habilitados `{id,etiqueta,habilitado,motivo}` y sesión hospedada/elementos seguros. Backend calcula total final e importe/moneda, idempotencia, resultado/conciliación y webhooks verificados. Timeout no prueba fallo; consultar la operación existente antes de repetir. Pago no implica pedido aceptado, recogida lista, reserva confirmada, Gift emitida o club activo |
| Gift / Club / Events / Private | Términos/emisión/redención/entrega; precio/cadencia/renovación; evento/cupos/registro; evaluación/propuesta/acuerdo, respectivamente. Autorización por titular, CSRF en futuras mutaciones, escaping, prepared statements y transacciones cuando exista backend |

No hay backend, esquema MySQL, APIs comerciales, cookies de usuario, persistencia, pago, reserva, mensajes ni solicitudes reales. No se añadieron dependencias, imágenes originales ni iconos. Fixtures aisladas en guía; `main.js` sigue vacío. DOM seguro mediante plantilla/createElement/textContent, validación de identidades/recursos locales, snapshots copiados e importes enteros seguros. Inicializadores idempotentes y limpieza de módulos compartidos; la orquestación y timers de demo pertenecen exclusivamente al laboratorio.

### Pruebas ejecutadas en este cierre

Skill qa-visual; Chromium integrado. Evidencia fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/10/21/01a15601-3a20-7b21-a875-71755abbaabb/wave-7-closure/`. JSON funcional/responsive/accessibility/estados/recursos, HTML y capturas. Algunas capturas muestran parte de la sección anterior por el scroll; las capturas finales de drawer son la referencia para su aprobación.

| Verificación | Resultado |
|---|---|
| `npm run lint`, `npm run build`, PHP lint y `git diff --check` | PASS; dev restablecido para revisión local |
| `node scripts/probar-carrito.mjs` | PASS: invariantes, cantidad/variante/importes, descuento, datos inválidos atómicos, snapshots, colecciones y59 estados |
| `node scripts/probar-cierre-comercio.mjs` | PASS: líneas simultáneas/equivalencia/reprecio/Undo/modalidad, un código activo, páginas globales y extremos; lunes/martes cerrados, miércoles/domingo abiertos, hora fuera de apertura/cierre/pasada, fecha pasada/inexistente, excepción/cambio, reloj LA y cambios DST de marzo/noviembre2028; grupos1/6/10/11/15 e inválidos |
| Responsive carrito | PASS:70 combinaciones de1/2/8/10/11/20/40 líneas ×320/360/390/425/768/820/992/1024/1280/1440px, hasta diez líneas visibles, sin overflow horizontal |
| Mini-cart / grupo grande | PASS: diez anchos cada uno; mini320×568 con scroll interno y pie accesible; targets comprobados ≥44px; primerastres de40, badge99+ y nombre completo120 |
| Paginación / sincronización | PASS: página intermedia y última, eliminar última línea de página2 con11, página válida, Undo vuelve a página2 y enfoca cantidad; cambio de cantidad en mini actualiza todas las vistas; variantes simultáneas y copa bloqueada en pickup |
| Promoción | PASS: aplicado, duplicado, inválido, expirado, ineligible, fallo y redeemed sintético; descuentos previos preservados; Apply100% y centrado a320/390/768/1280 |
| Horario / pedido / reserva | PASS: lunes y martes cerrados sin horas; pickup/mesa revisados con fecha abierta; excepción invalida ambas selecciones, conserva contacto y bloquea evento;10 invitados con confirmación sintética y15 con consulta pendiente; cantidad10 inválida en opción grande |
| Payment | PASS: contexto del pedido, importes, siete resultados seleccionables, procesamiento y cambio de carrito invalidan resultado/contexto y conservan contacto; no método activo ni cobro |
| Teclado / foco / overlays | PASS: ciclo Tab/Shift+Tab en mini, Escape/backdrop, View Cart enfoca ancla y Checkout enfoca encabezado; Discover cierra con Escape y conserva drawer principal; cierre de drawer/modal devuelve foco; un overlay visible en recorridos probados y sin backdrops/scroll lock residuales |
| Accesibilidad | PASS: un h1, sin IDs duplicados/labels visibles ausentes/referencias ARIA rotas;363 textos visibles, mínimo6.13:1 y ningún fallo; foco sólido2px; drawer dialog/aria-modal de Bootstrap, sin regiones live anidadas |
| HTML / consola / recursos | PASS: DOM de aplicación parseado sin errores con doctype restituido (outerHTML lo omite); se excluye únicamente el div vacío externo de la herramienta colocado después de body. Fuente PHP mantiene dos avisos preexistentes de ampersands en Google Fonts; no nuevos. Consola de página sin errores/warnings;51 recursos locales declarados consultados con HTTP200 |
| Regresión Foundation/Core/Waves1–7 | PASS de humo: Core Quantity6, Accordion Enter, Modal Escape/retorno; Wave2 cantidad3→$108; Wave3 visor2/6 y retorno; Wave4 Gift100/dedicatoria, Diamond/términos y evento; Wave5 filtro5estrellas→1, carruseles con desplazamiento; Wave6 independiente320 sin acceso carrito, Footer/drawer conservados; Header/Discover/acceso Wave7. No es una recertificación exhaustiva de todas las waves |

### Performance antes/después de567cf7d

Misma configuración local, Node gzip por defecto; CSS de build minificado, JS guía empaquetado esbuild ESM/es2020 sin sourcemap, minificación en memoria como comparación adicional. JS productivo y sprite medidos en build; build deja solo main.js, sin guía ni maps. Después se vuelve a dev.

| Artefacto | Bytes antes → después | Gzip antes → después | Cambio gzip |
|---|---:|---:|---:|
| CSS producto |113763 →115904 |18450 →18726 |+276B (+1.50%) |
| JS productivo |0 →0 |20 →20 |0 |
| JS guía desarrollo |191795 →219670 |44818 →51512 |+6694B (+14.94%) |
| JS guía minificado en memoria |113046 →130104 |34763 →39850 |+5087B (+14.63%) |
| Sprite |12028 →12028 |4038 →4038 |0 |

SHA256 main.js: `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. No nuevas imágenes, derivados, fuentes ni librerías. Comparación de HTML PHP renderizado del commit base y actual:51→51 URLs locales declaradas únicas; imágenes declaradas50→51 (incluidas plantillas inertes), URLs de img20→21 por la referencia de vino del template nuevo, recurso ya usado dinámicamente por el carrito anterior. Los duplicados del drawer reutilizan los mismos archivos; no se afirma una reducción de requests efectivos. Cantidad de recursos declarados y consultas HTTP de QA no equivalen a un HAR, transferencia real del navegador, memoria ni Core Web Vitals.

### Pruebas no ejecutadas y límites

No se certificó zoom real200%, preferencia reduced-motion del SO, lector de pantalla auditivo, Firefox/Safari, dispositivo físico o Apache/GoDaddy. Foundation/Bootstrap ya contienen tratamiento de reduced motion; no se añade un sistema de animación. No se midieron HAR/requests efectivos antes-después, LCP/CLS/INP, latencia real, capacidad ni concurrencia de servidor. No se hizo consulta comercial, cobro, reserva, envío ni prueba de backend. Los intentos de automatización antes de terminar transiciones Bootstrap se repitieron esperando foco/shown; los resultados registrados corresponden al recorrido completado.

Revisión: `/style-guide/patterns.php#w7-carrito`, icono del Header, `#w7-checkout`, `#w7-pago` y `#w7-reserva`; controles compactos de colección, promoción y configuración compartida. Quedan aprobación visual humana, datos comerciales y backend/proveedor. No hay bloqueantes frontend conocidos tras las pruebas aquí ejecutadas; no se declara autorización de integración o publicación.
