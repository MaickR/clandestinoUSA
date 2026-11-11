# Mapa del sitio y prioridades — The Clandestino USA

The Clandestino vende experiencias. Cada página ayuda al visitante a entender la oferta y dar un siguiente paso que el restaurante pueda atender.

## Navegación y rutas existentes

| Contexto | Navegación y destinos |
|---|---|
| Sitio público de referencia | [Home legacy](../index.html). Header con Home, Menus (General Menu, Tapas, Wines, Hampers), About Us, SWC y Contact (Contact Form y FAQ). La reserva enlaza a [la solicitud de mesa](../index.html#reservation). |
| Home Preview local | [Anfitrión](../home-preview.php) y [configuración compartida](../includes/site.php). Home, Experiences (ancla `/index.html#services`), Restaurant, Wine Shop y Discover (Wine Club, About Us, Contact), más Request a Table. |
| Home candidata, aún sin publicar | [Anfitrión](../home.php). Home apunta a la raíz, Experiences a `/#private-events` y Request a Table al formulario legacy `/index.html?legacy=1#reservation`. Cuenta y carrito demo quedan fuera de la candidata. |

Home R1–R9 está aprobada localmente y fusionada en `develop` mediante PR #35. Su aceptación y los bloqueantes de publicación constan en [R9](HOME-FINAL-ACCEPTANCE.md). Menú, tapas, vinos, hampers, Wine Club, About Us y Contact ya tienen páginas legacy. Su existencia permite explorar o consultar según el destino. La reserva y el contacto son solicitudes gestionadas por el equipo.

## Objetivos futuros y alcance pendiente

El Design System y la integración local de Home ya se completaron. El siguiente bloque es definir y aprobar páginas interiores, priorizando el valor comercial, el contenido disponible y la operación que pueda sostener el CTA. El orden histórico al pie conserva el planteamiento original. La prioridad y el alcance de cada página se deciden con el responsable.

| Iniciativa | Estado |
|---|---|
| Restaurant / Take Away | Menú y tapas legacy existentes. La página renovada y la integración transaccional están pendientes. |
| Wine Shop y Hampers | Destinos legacy existentes. Pendientes catálogo renovado, datos, reglas de venta y compra. |
| Gift Cards | La Home candidata dirige a una consulta. Pendientes oferta confirmada, página transaccional, pago, emisión y redención. |
| Wine Club | Página legacy existente. Pendientes renovación, condiciones vigentes y operación de alta/cobro. |
| Reservations | Solicitud legacy existente. Pendientes página o recorrido renovado, disponibilidad real y confirmación. |
| Events / Private Experiences | Hay información o vías de consulta. Pendientes alcance de las páginas y cualquier agenda, contratación o pago. |
| Experiences | Propuesta editorial pendiente de aprobación. La navegación existente conserva sus destinos. |
| Mi Cuenta, administración y fidelización | Iniciativas futuras. Autenticación, cuenta, carrito persistente, pedidos y checkout requieren integración real antes de aparecer como servicios. |

## Definición comercial de cada página

Completar en la fase Strategy & Content del [flujo de una feature](GIT-WORKFLOW.md#flujo-de-una-feature):

- Objetivo comercial, público, necesidad o motivación del visitante y propuesta de valor.
- Recorrido desde descubrimiento hasta acción. Función concreta de cada sección y contenido real disponible para sostenerla.
- CTA, destino funcional, siguiente paso y expectativas de respuesta. Evidencia de confianza verificable y necesidades fotográficas, incluidos encuadres y permisos aplicables.

Distinguir el contenido editorial que explica la experiencia, el catálogo que describe una oferta verificada y la operación que acepta, procesa o confirma la acción. Justificar cada sección por lo que aporta a la decisión y conservar la información necesaria para comprender la oferta. Omitir afirmaciones sin confirmar sobre precios, beneficios, inventario, testimonios, disponibilidad, eventos o condiciones. Las demos de cuenta, carrito y checkout son ejemplos de interfaz.

## Experiences — PROPUESTA PENDIENTE DE APROBACIÓN

Hipótesis comercial para evaluar con el responsable:

1. Hero estático.
2. Explore Our Experiences.
3. The Spanish Table.
4. Private Gatherings.
5. Wine Tastings & Special Moments.
6. Final Invitation.

Antes de programar, validar la función de cada sección, las experiencias que pueden describirse con evidencia, el contenido real y el CTA. El responsable aporta o selecciona referencias visuales y aprueba el contenido, la fotografía y el alcance. La propuesta carece de ruta pública asignada y deja intacta la navegación existente.

<details>
<summary>Mapa y orden originales · registro histórico</summary>

Los destinos, nombres de menú, cifras, beneficios y secuencia de abajo pertenecen a la planificación original. Su aplicación requiere validación actual de producto y operación.

Inventario de lo pactado para el sitio y el orden general de trabajo (revenue-first). Es un refactor incremental sobre el código actual.

## Navegación principal (9 items, en este orden)

| # | Item de menú | Destino |
|---|---|---|
| 1 | Inicio | Home (`index.html`) |
| 2 | Experiencias | Ancla a la sección "Experiencias" del Home (no es página aparte) |
| 3 | Restaurante | Página propia — menú de tapas, reservar mesa, order ahead |
| 4 | Wine Shop | Página propia — catálogo de vinos con filtros |
| 5 | Gift Cards | Página propia — selector de monto y checkout |
| 6 | Wine Club | Página propia — beneficios, niveles, checkout |
| 7 | Eventos | Página propia — listado de eventos + experiencias personalizadas |
| 8 | Reservar | Página propia — reserva de mesa (motor PHP existente adaptado) |
| 9 | Mi Cuenta | **FUTURE** — área privada (requiere login) |

## Home — secciones en orden vertical

1. **Header + Nav** — logo actual, los 9 items, sticky al hacer scroll, hamburguesa en móvil.
2. **Hero** — video/imagen de fondo, headline "Escape to Spain without leaving California", subtítulo, CTAs "Reserve a Table" (primario) / "Explore Wines" (secundario).
3. **Experiencias** — 6 tarjetas: Spanish Tapas, Spanish Wines, Private Events, Wine Club, Gift Cards, Wine Tastings. Cada una enlaza a su página.
4. **Eventos** — próximos eventos (fecha, cupo, precio), botón "Reserve Now".
5. **Wine Club** — venta directa: beneficios, descuentos, eventos exclusivos, "Join Today".
6. **Gift Cards** — montos 50/100/200/300/400/500 USD, compra en un clic.
7. **Restaurant** — teaser del menú + reservar + order ahead.
8. **Wine Shop** — teaser del catálogo con acceso a filtros en su página.
9. **Testimonios** — reseñas de Google y Facebook.
10. **Footer** — medios de pago, redes, políticas/T&C, enlaces a todas las páginas, horario, contacto.

> Decisión pendiente: si Contacto vive solo en el footer o como página `/contact` (el sitio actual la tiene y no está en los 9 items).

## Páginas internas

**Restaurante**: menú de tapas, reservar mesa, order ahead (pedir para recoger o dejarlo listo para servir en mesa).

**Wine Shop**: catálogo con filtros (país, tipo — tinto/blanco/rosado/espumoso —, precio, cuerpo, maridaje) y packs/combos (wine+cheese, wine+jamón, wine+dessert).

**Gift Cards**: selector de monto ($50, $100, $200, $300, $400, $500) y checkout. **PENDIENTE de confirmar**: si habrá bonus/promoción, política de expiración conforme a la normativa aplicable, método de redención, proveedor de checkout y entrega digital/PDF definitiva.

**Wine Club**: niveles Gold y Diamond, beneficios, checkout de membresía/suscripción; proveedor de pagos pendiente de decisión comercial/técnica.

**Eventos**: listado con fecha/cupo/precio, degustaciones y reserva de cupo; además experiencias personalizadas (cumpleaños, empresas, aniversarios, bodas, catas privadas, alquiler del restaurante) como formulario de solicitud.

**Reservar**: reserva de mesa con calendario/disponibilidad (adaptando el motor PHP existente) y opción de apartar mesa para grupos.

## FUTURE

Fuera del alcance inmediato; se planifica solo cuando las anteriores estén en producción.

**Mi Cuenta** (requiere login): login/registro · resumen (puntos, próxima reserva) · historial de pedidos, facturas, reservas, eventos, gift cards y Wine Club con "volver a pedir" y PDF · wishlist · cupones · perfil (cumpleaños, preferencias, alergias, idioma, canal de notificación).

**Panel administrativo**: dashboard, productos, reservas, eventos, Wine Club, cupones, gift cards, usuarios y roles. La herramienta se decidirá cuando llegue el momento.

**Puntos / fidelización**: acumulación y canje de puntos ligados a Mi Cuenta.

## Fuera de alcance (ya decidido)

Cursos online, merchandising, Chef's Table/private dinner como módulo aparte, roles de Kitchen/Wine Club Manager/Marketing/Restaurant Manager, email marketing propio, Apple/Google Wallet, login social, PWA/tiempo real, migración a React/Laravel.

## Orden general (revenue-first)

1. Foundation (reglas, documentación, flujo de trabajo).
2. SCSS + Style Guide.
3. Take Away / checkout.
4. Gift Cards.
5. Wine Club.
6. Reservas.
7. Eventos.
8. Mejoras posteriores: Wine Shop y Home.

Cada paso se cierra (clases renombradas, copy real, accesibilidad verificada con `qa-visual`) antes de pasar al siguiente. Mi Cuenta, panel admin y puntos quedan como FUTURE.

</details>
