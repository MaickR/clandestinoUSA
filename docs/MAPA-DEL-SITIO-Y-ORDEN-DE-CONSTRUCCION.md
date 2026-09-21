# Mapa del sitio y orden de construcción — The Clandestino USA (refactor sobre el código actual)

Este documento es el inventario definitivo de todo lo que tendrá la app y el orden en que se construye. Pégalo o dáselo a Qwen (o a cualquier otra IA) junto con `BRIEFING-PROYECTO-PARA-OTRA-IA.md` al empezar sesión, para que entienda qué está pactado antes de tocar código.

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
| 9 | Mi Cuenta | Área privada (requiere login) |

## Home — secciones en orden vertical (esto se construye primero, de arriba hacia abajo)

1. **Header + Nav** — logo actual de The Clandestino (verificar si necesita optimización — ver inventario), los 9 items de arriba, sticky al hacer scroll, hamburguesa en móvil.
2. **Hero** — video/imagen de fondo (brindis, flamenco, tapas — placeholder con `TODO` hasta que Nicolás dé el material real), headline "Escape to Spain without leaving California", subtítulo, CTAs "Reserve a Table" (primario) / "Explore Wines" (secundario).
3. **Experiencias** — 6 tarjetas: Spanish Tapas, Spanish Wines, Private Events, Wine Club, Gift Cards, Wine Tastings. Cada una enlaza a su página correspondiente.
4. **Eventos** — próximos eventos (fecha, cupo, precio), botón "Reserve Now" por evento.
5. **Wine Club** — venta directa (no explica, vende): beneficios, descuentos, eventos exclusivos, botón "Join Today".
6. **Gift Cards** — montos 50/100/200/300/400/500 USD, compra en un clic.
7. **Restaurant** — teaser del menú + botón reservar + order ahead.
8. **Wine Shop** — teaser del catálogo con acceso a filtros completos en su página propia.
9. **Testimonios** — reseñas de Google y Facebook.
10. **Footer** — medios de pago, redes sociales, políticas/T&C, enlaces a todas las páginas, horario, contacto.

> Decisión pendiente de tu parte: si quieres una página/sección de Contacto separada además del footer (el sitio viejo la tiene) — no está en los 9 items de nav, así que hay que decidir si vive en el footer únicamente o si se agrega una página `/contact`.

## Páginas internas — qué tiene cada una

**Restaurante**: menú de tapas (dinámico, editable desde el panel admin), botón reservar mesa, order ahead (pedir para recoger o que lo alisten para servir en mesa).

**Wine Shop**: catálogo completo de vinos con filtros (país, tipo — tinto/blanco/rosado/espumoso —, precio, cuerpo, maridaje sugerido), packs/combos (wine+cheese, wine+jamón, wine+dessert).

**Gift Cards**: selector de monto, opción de bono (compra $100 recibe $110 en crédito, sin fecha de expiración por ley de California), checkout, entrega por email + versión PDF.

**Wine Club**: niveles Gold y Diamond, beneficios de cada uno, checkout de suscripción (pago único o recurrente vía Stripe).

**Eventos**: listado de eventos con fecha/cupo/precio de entrada, degustaciones, reserva de cupo; además experiencias personalizadas (cumpleaños, empresas, aniversarios, bodas, catas privadas, alquiler del restaurante) como formulario de solicitud.

**Reservar**: reserva de mesa real con calendario/disponibilidad (adaptando tu proyecto PHP de reservas ya hecho), opción de apartar mesa para grupos.

**Mi Cuenta** (requiere login):
- Login / Registro
- Resumen: puntos actuales, próxima reserva
- Historial: pedidos, facturas, reservas, eventos, gift cards, Wine Club — todo en un solo lugar, con "volver a pedir" y descarga de factura en PDF
- Wishlist (ícono de corazón en productos)
- Cupones: activos, vencidos, usados
- Perfil: nombre, cumpleaños (no fecha de nacimiento completa), preferencias, alergias, vinos/tapas favoritos, idioma preferido, canal de notificación preferido (email/WhatsApp/SMS)

## Fuera del sitio público — Panel administrativo

Sobre plantilla AdminLTE 4 o CoreUI Free. Secciones: Dashboard (ventas, clientes, reservas, eventos, pedidos), Productos (nombre/precio/fotos/stock/descripción), Reservas (calendario), Eventos (crear/capacidad/precio), Wine Club (miembros/pagos/renovaciones), Cupones (crear/expiran/límite), Gift Cards (crear/activar/desactivar/saldo), Usuarios y roles.

## Lo que NO va (recordatorio, ya decidido)

Cursos online, merchandising, Chef's Table/private dinner como módulo aparte, roles de Kitchen/Wine Club Manager/Marketing/Restaurant Manager, email marketing propio, Apple/Google Wallet, login social, PWA/tiempo real, migración a React/Laravel.

---

## Orden de construcción (de arriba hacia abajo, tal como lo pediste)

**Ahora — Home, sección por sección, en este orden exacto:**

1. Ajustar anclas del menú (los 9 items, apuntando a los ids/páginas correctos).
2. Verificar/optimizar el logo actual de The Clandestino (ya lo tienes — solo confirmar que esté bien enlazado y optimizado en SVG).
3. Hero (copy + placeholder de video/imagen).
4. Experiencias (6 tarjetas).
5. Eventos.
6. Wine Club (bloque de venta en home).
7. Gift Cards (bloque de venta en home).
8. Restaurant (teaser).
9. Wine Shop (teaser).
10. Testimonios.
11. Footer completo.

**Después — páginas internas, en orden de menor a mayor complejidad:**

12. Reservar (adaptar el motor PHP ya existente).
13. Restaurante (página completa con menú dinámico).
14. Wine Club (página completa con checkout).
15. Gift Cards (página completa con checkout).
16. Eventos (página completa + experiencias personalizadas).
17. Wine Shop (catálogo con filtros).

**Al final — lo que requiere cuentas de usuario y backend más pesado:**

18. Mi Cuenta (login, historial, wishlist, puntos, cupones, perfil).
19. Panel administrativo.

No saltes de la sección 3 a la 5 sin terminar la 4 — cada una se cierra (renombrado de clases, copy real, accesibilidad verificada) antes de pasar a la siguiente, igual que hicimos con header/nav/hero.
