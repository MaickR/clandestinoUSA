# Preparación del Design System para construir páginas

## Cierre transversal — 2026-10-21

Registro vigente: [FINAL-DESIGN-SYSTEM-AUDIT.md](FINAL-DESIGN-SYSTEM-AUDIT.md). El usuario aprueba la dirección visual general; este cierre verifica defectos e integración frontend, sin aprobar automáticamente las páginas reales ni su publicación. Los estados pendientes de las waves que siguen son registros históricos.

Se corrigieron Undo obsoleto entre vistas, límites/media desactualizados del mini carrito, acciones sin función en las muestras Core y mensajes que podían confundirse con disponibilidad real. El proveedor de mini carrito debe aportar `puedeRestaurar(id)` además de `suscribir`: la recuperación se invalida al restaurar la línea o sustituir su colección. Mantener una identidad no autoriza conservar límites o fotografías anteriores.

**DESIGN SYSTEM READY — WAITING FOR FINAL HUMAN APPROVAL**, dentro del frontend demostrativo probado y con las limitaciones de QA enumeradas en el informe. No significa que pagos, reservas, contenido comercial, cuenta ni rutas productivas estén habilitados. Sin Wave 8, backend o migraciones productivas.

Referencia práctica tras Wave 7, 2026-10-20. El sistema permite componer el frontend de las páginas previstas. La aprobación visual humana, los datos comerciales y las integraciones siguen siendo puertas distintas. Ninguna página productiva fue migrada durante Wave 7.

## Inventario y ubicación

| Capa | Disponible / cuándo usar | Fuentes y ejemplos |
|---|---|---|
| Foundation | Tema oscuro, tipografía, tokens, espacios, grid, botones, superficies y foco | `assets/scss/abstracts/`, `base/`, `components/`; `/style-guide/`; `docs/VISUAL-DIRECTION.md` y `docs/UX-UI-GUIDELINES.md` |
| Core | Formularios, opciones, cantidad, carga, alertas, estados, vacío/error, toast, modal, disclosure, iconos y breadcrumb | `assets/scss/components/`, `assets/js/modules/core/`; `docs/CORE-COMPONENT-LIBRARY.md` |
| Wave 1 | Hero, media + contenido, CTA y estructura editorial | `assets/scss/patterns/_{hero,seccion,media-contenido,banda-cta}.scss`; `style-guide/partials/patrones-wave-1.php` |
| Wave 2 | Producto gastronómico, menú, vino, cesta y catálogo; selección de producto | `assets/scss/patterns/_{producto-gastronomico,item-menu,vino,catalogo}.scss`; `style-guide/partials/*wave-2.php`; `assets/js/modules/guia/productos.js` contiene solo demos |
| Wave 3 | Experiencias, historias, galería, visor, vídeo, comunidad y valores | `assets/scss/patterns/`; `assets/js/modules/patterns/galeria.js`; `style-guide/partials/*wave-3.php` |
| Wave 4 | Gold/Diamond, diseñador Gift Card, evento/agenda y consulta privada | `assets/scss/patterns/_{membresia,regalo,evento,consulta-privada}.scss`; `style-guide/partials/*wave-4.php`; orquestación demo `modules/guia/comercial.js` |
| Wave 5 | Reseña, testimonio, reputación, listado/filtros, formulario, carrusel y vídeo testimonial | `assets/scss/patterns/_{resena,testimonio,reputacion,resena-formulario,carrusel,media-video}.scss`; `modules/patterns/carrusel*.js`; `style-guide/partials/*wave-5.php` |
| Wave 6 | Header sticky, drawer, Discover, Footer/contacto, acceso sintético y enlaces contextuales | `assets/scss/patterns/_{navegacion-global,pie-global,topbar,acceso}.scss`; `modules/patterns/{navegacion-global,acceso}.js`; `style-guide/partials/*wave-6.php`; `/style-guide/navigation.php` |
| Wave 7 | Carrito/resumen, checkout compartido, pickup/mesa, pago/recuperación, reserva/gestión, transacciones de regalo/club/evento, estados privados e historial mínimo | `assets/scss/patterns/_{transaccion,carrito,reserva}.scss`; `modules/patterns/{transaccion,estado-carrito,carrito,promocion,checkout,reserva}.js`; `style-guide/partials/*wave-7.php` y `transacciones-componentes.php` |

El inventario detallado, contratos y evolución viven en `SECTION-PATTERN-LIBRARY.md`; la matriz inicial y pruebas de Wave 7 en `WAVE-7-COVERAGE.md`. Esta referencia no los sustituye.

## Reutilización al construir una página

1. Contrastar la página con `production-baseline`, inventariar contenido y aprobar el alcance de su cutover. No usar `master` como autoridad productiva.
2. Componer `container` / `row` / columnas, `cl-seccion`, Core y patrones existentes. Extraer datos de los ejemplos; no copiar sus fixtures ni sus referencias `DEMO-*` a producción.
3. Pasar rutas/contacto confiables a los partials Wave 6. Preparar documentos legales y canales reales antes de enlazarlos. El acceso Wave 6 es una interfaz sintética, no autenticación.
4. Conectar el snapshot de `estado-carrito.js` a las vistas y al contador optativo de Header; todas las cantidades/importes de la operación proceden de esa fuente. Usar `cl-resumen` para datos de operación; `cl-cantidad` para cantidades; `inicializarCheckout` para pasos de datos/revisión con callbacks del anfitrión. Cada dominio aporta su semántica y resultado.
5. Conectar solo los módulos necesarios desde la entrada de esa página al hacer su integración autorizada. `style-guide.js` y `modules/guia/**` nunca son dependencias productivas. `main.js` sigue vacío.
6. Validar la página real en navegador, con teclado y datos extremos. El QA del laboratorio no aprueba automáticamente su layout ni el motor comercial.

## Readiness por página

| Página | Composición disponible | Dependencia real antes de publicar |
|---|---|---|
| Home | Header/Footer, Hero/CTA, experiencias, teasers de producto, club, regalo, eventos y testimonios | Copy final, navegación y destinos publicados; reseñas con permiso y procedencia; decisión de vídeo |
| Restaurant | Menú/producto, editorial, CTA reserva y order ahead; carrito/checkout Wave 7 | Menú/precios/porciones, disponibilidad, impuestos y operación de cocina/recogida/mesa |
| Wines | Tarjeta/ficha vino, catálogo, cesta, Core select/disclosure y estados de lista | Datos normalizados, filtros reales por catálogo y política de venta; añada/volumen/precio confirmados |
| Gift Cards | Diseñador Wave 4 + revisión Wave 7, pago/emisión diferenciados | Importes/oferta vigente, presentación/entrega/redención/expiración y proveedor |
| Wine Club | Gold/Diamond, beneficios históricos identificados, selección/condiciones/revisión y ciclo de suscripción | Beneficios actuales, precio/cadencia/renovación/cancelación y proveedor recurrente |
| Events | Listado/evento, asistentes/resumen, estados cupos/registro; consulta privada y seguimiento | Eventos publicados, fechas/cupos/precios/condiciones; capacidad y autorización servidor |
| Reservations | Fecha/comensales, slots, contacto, revisión y gestión | Motor existente auditado/adaptado en una tarea futura, capacidad/concurrencia, políticas y autorización |
| Contact | Footer/contacto, enlaces contextuales y campos Core; consulta privada cuando corresponda | Decidir página propia o solo footer; datos/horarios/canal y recepción real |
| Take Away | Producto, carrito, resumen, pickup o mesa, checkout, estados y recuperación | Fulfillment disponible, ventanas de servicio, inventario, total servidor, cobro y notificación |
| Account FUTURE | Modal visual existente, historial compacto de cuatro dominios, vacío/error/no autorizado | Identidad, sesiones, autorización por operación y privacidad. No se habilita un área privada completa |

## Hallazgos y carencias de integración

| Necesidad / página | Solución existente / pieza necesaria | Prioridad / justificación |
|---|---|---|
| Filtros de Wine Shop | Core select/disclosure + catálogo Wave 2; falta el adaptador de filtros y su contrato de datos en la página real | P1 al construir Wines: sin catálogo normalizado no hay filtros fiables; no falta una nueva familia visual |
| Calendario con disponibilidad real / Reservations | Fecha nativa y slots Wave 7; falta adaptar el motor PHP y disponibilidad autoritativa | P0 antes de reservas públicas: evita dobles reservas y horas ambiguas |
| Pago / Take Away, Gift, Club, Events | Contenedor de proveedor y estados Wave 7; falta proveedor hospedado o elementos seguros | P0 antes de cobrar: la UI no determina cargos ni conciliación |
| Contacto y ayuda contextual | Footer Wave 6 y enlaces Core; falta decidir destinos/contactos verificados | P1 antes de publicar: no crear enlaces de soporte ficticios |
| Historial privado / Account | `cl-resumen`, estado e historial Wave 7; falta autorización servidor | FUTURE: no justifica dashboard, roles, fidelización ni infraestructura nueva |

No se identifica una familia visual fundamental ausente para la composición prevista. Las piezas de integración anteriores se resuelven al construir cada página, sin abrir Wave 8 ni reconstruir Waves 1–6. Esta conclusión es técnica; continúa pendiente la aprobación visual humana.

## Contratos y pendientes

El servidor futuro debe validar y autorizar, recalcular importes en unidades menores, aplicar CSRF/XSS/prepared statements, mantener integridad de estados y concurrencia con transacciones, auditar, gestionar errores seguros e idempotencia, y verificar webhooks cuando proceda. Contratos por dominio en la sección Wave 7 de `SECTION-PATTERN-LIBRARY.md`; no hay esquema MySQL definitivo ni backend construido.

Pendientes comerciales transversales: catálogo vigente, horarios/ventanas, impuestos y cargos, disponibilidad, términos legales, cancelaciones/reembolsos, canales de contacto y datos publicados. La promoción histórica de $149 y los beneficios antiguos no son una oferta actual. Una petición, un pago y la prestación/emisión/activación son estados separados.

## Revisión local

Ejecutar `npm run dev` y abrir `http://localhost:3000/style-guide/patterns.php#wave-7`; Foundation/Core en `/style-guide/`, navegación aislada en `/style-guide/navigation.php`. Verificar `npm run lint`, `npm run build`, PHP lint y `git diff --check` antes del cierre de cada cambio. El build productivo excluye los bundles de guía; revisar el navegador de nuevo tras cada integración.

## Actualización tras el refinamiento final de Wave7

Carrito y checkout incorporan líneas dinámicas por plantilla, variantes, papelera/Undo, subtotal destacado, CTA de ancho completo, promo demo y snapshot común hasta Payment. El Header recibe destino confiable y suma de unidades desde su anfitrión; la muestra independiente Wave6 permanece sin cantidad ficticia. Las colecciones1/2/8/20/40 son estrés bajo demanda, no catálogo ni paginación.

Para integrar una página: adaptar datos servidor al contrato documentado, usar versionado para invalidar revisiones y cobrar únicamente importes autorizados; no importar `modules/guia/`. El descuento cliente DEMO10 nunca autoriza un descuento real. Contacto telefónico es opcional en la muestra; política final pendiente. Vino/alcohol requiere validar elegibilidad, licencias y modalidad antes de publicar, con procedimiento de edad/identificación aún por decidir.

Reservas presenta comensales→fecha→búsqueda→horario→contacto→revisión. Los radios señalan selección/indisponibilidad con texto, y el contacto se conserva ante pérdida del horario. Mantener esta distinción al conectar el motor existente; no confundir pickup ni order ahead con reserva.

Regresión local de invariantes: `node scripts/probar-carrito.mjs`. QA y performance del refinamiento, incluidas limitaciones y aprobación humana pendiente: `WAVE-7-COVERAGE.md`. El frontend está preparado para composición e integración; proveedores, términos, disponibilidad, recepción y permisos siguen siendo dependencias futuras.


## Cierre de comercio de Wave7 — 2026-10-21

El carrito distingue producto/variante/línea, admite presentaciones simultáneas, paginas de diez líneas y un mini-cart Offcanvas conectado al Header mediante proveedor observable. Cantidades/importes/descuentos se comparten con Order/Payment. Quantity conserva su etiqueta accesible; Apply100% es contextual. El Header independiente sin carrito conserva su contrato Wave6.

Pickup, Order Ahead, reservas y revisión de Events comparten configuración de horarios inyectada con excepciones y reglas por servicio. La referencia DEMO es miércoles–domingo14:00–20:00, lunes/martes cerrados, America/Los_Angeles; el propietario debe confirmar datos y cortes antes de publicar. Reserva ofrece1–10 y consulta mayor de10 sin asumir capacidad. Payment conserva método no disponible y resultados separados del servicio, con conciliación explícita. Gift/Club no heredan cupones de carrito; redención por cliente necesita identidad y canje atómico en backend.

Contratos detallados y límites, pruebas ejecutadas/no ejecutadas, performance y capturas: `WAVE-7-COVERAGE.md`, cierre2026-10-21. Lógica local comprobable con `node scripts/probar-carrito.mjs` y `node scripts/probar-cierre-comercio.mjs`. Sin backend ni publicación; aprobación visual final pendiente.
