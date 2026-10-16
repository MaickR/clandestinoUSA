# Biblioteca de patrones de sección

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
