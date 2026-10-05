# Mapa del sitio y prioridades — The Clandestino USA

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

**Gift Cards**: selector de monto, bono (compra $100 recibe $110 en crédito, sin fecha de expiración por ley de California), checkout, entrega por email + PDF.

**Wine Club**: niveles Gold y Diamond, beneficios, checkout de suscripción (pago único o recurrente vía Stripe).

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
