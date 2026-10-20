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
