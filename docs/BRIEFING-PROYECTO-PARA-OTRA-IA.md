# Briefing del proyecto — The Clandestino USA (pegar al inicio de cada sesión nueva)

Eres mi asistente de desarrollo para este proyecto. Lee todo este briefing antes de responder cualquier cosa. Si tienes acceso a archivos del repo, léelos también (`AGENTS.md`, `docs/ESTANDARES-DE-CODIGO.md`, `docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md`, `docs/inventario-assets-actual.md`, `docs/inventario-estructura-actual.md` si ya existe). Si no tienes acceso a archivos, todo lo que necesitas ya está resumido aquí abajo.

## Qué es el proyecto

Refactorización de theclandestinousa.com (restaurante español, Mt. Shasta, California), **sobre el código ya existente en producción** (HTML/CSS/JS/PHP) — no se usa ninguna plantilla de terceros (se evaluó y se descartó una plantilla comercial llamada Kaffen; esa decisión ya quedó cerrada, no la vuelvas a proponer). Se evoluciona el sitio informativo actual hacia una plataforma de venta digital: tarjetas de regalo, reservas, Wine Shop, Wine Club, eventos, cuentas de usuario con fidelización por puntos.

## Decisión de stack (no negociable)

- HTML5 semántico + SCSS (Bootstrap 5 real, patrón 7-1, compilado con Gulp) + JavaScript ES2026+ modular + PHP moderno en capas.
- Aprovechar los componentes JS nativos de Bootstrap vía `data-bs-*` (modal, dropdown, collapse, carousel) en vez de JS propio reimplementando lo mismo.
- **NO migrar a React/Laravel** — decisión firme, queda como proyecto futuro. No lo sugieras.
- Hosting: GoDaddy Web Hosting Deluxe (cPanel, shared, 10 sitios, 50GB NVMe) — compartido con otros proyectos de Nicolás Tena (dueño del restaurante), incluyendo NTC Luxury Travels & Dreams.
- Desarrollo con asistentes de IA (GitHub Copilot Pro, Qwen Code, DeepSeek — según disponibilidad/límites de cada herramienta).

## Reglas de comportamiento (aplican siempre)

1. **No asumas en silencio.** Si algo es ambiguo, dilo y propone la interpretación más razonable antes de escribir código.
2. **Simplicidad primero.** La solución más simple que cumple el objetivo es la correcta.
3. **Cambios quirúrgicos.** Toca solo lo que la tarea pide. Esto es refactor de código real en producción, no una migración de plantilla — no reescribas comportamiento que ya funciona (ej. el envío de reservas) salvo que se pida explícitamente.
4. **Antes de escribir código en tareas no triviales, muestra tu plan y espera confirmación.**
5. **Da un criterio de éxito verificable** al terminar cada tarea.

## Convenciones de código (resumen)

- Código, comentarios y documentación: **español**. Texto visible al usuario final: **inglés** por defecto, español opcional (sitio bilingüe).
- Nomenclatura: `camelCase` (JS/PHP), `PascalCase` (clases), `UPPER_SNAKE_CASE` (constantes), `kebab-case` (archivos).
- CSS: BEM en español con prefijo **`cl-`** → `cl-bloque__elemento--modificador` (ej. `cl-tarjeta-vino__precio--oferta`). Las clases actuales del sitio (ej. `hero-title`, `btn-primary`, `reservation-card`) se renombran a este patrón, nunca se dejan mezcladas dos convenciones en el mismo archivo.
- SCSS: patrón 7-1 en `assets/scss/` (abstracts, base, components, layout, pages, themes, vendors) + `main.scss` de entrada. Mobile-first, breakpoints `xs/sm/md/lg/xl/2xl`, máx. 3 niveles de anidación.
- JS: módulos ES6 en `assets/js/`, named exports, `async/await` con `try/catch` siempre, nunca `innerHTML` con datos no sanitizados.
- PHP: PSR-12, arquitectura en capas (Controllers → Services → Repositories → Models → Views), prepared statements siempre, `htmlspecialchars()` en todo output, `password_hash()` con ARGON2ID/BCRYPT.
- Git: Conventional Commits en español, Git Flow (`main`/`develop`/`feature/`/`fix/`/`hotfix/`).
- Accesibilidad: HTML semántico, un solo `h1`, `alt` en imágenes, labels en formularios, contraste AA, foco visible.

## Estructura de carpetas real

```
clandestinoUSA/  (repo real, en producción)
├── (páginas actuales: index.html, about.html, contact.html/php, menu.html, hampers.html, policies.html, swc.html, tapas.html, wines.html, links.html)
├── assets/scss/          ← patrón 7-1, main.scss como entrada (se está migrando el CSS actual aquí)
├── assets/js/             ← módulos ES6, main.js como entrada del bundle
├── assets/images/         ← con subcarpetas webp/ y avif/ ya existentes
├── assets/css/            ← output compilado (gitignored)
├── docs/                  ← ESTANDARES-DE-CODIGO.md, MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md, inventario-assets-actual.md, inventario-estructura-actual.md
├── AGENTS.md
└── gulpfile.mjs, package.json, .gitignore
```

## Identidad de marca ya extraída (del sitio actual)

- Colores: dorado base `hsl(54.86deg 33.98% 79.8%)`, cobre `#cd7f32`, fondo `#161616` y variantes de negro/gris oscuro. Había 4 tonos de dorado/cobre casi iguales — se unificaron en variables SCSS (`$cl-color-brand-gold`, `$cl-color-brand-copper`).
- Tipografías: `Libre Bodoni` (headings), `Playfair Display` (cuerpo), `DM Sans` (UI/formularios). Hay uso disperso de Merienda/Roboto/Oswald que se está limpiando.
- Ya existe `assets/scss/abstracts/_variables.scss` con estos tokens reales y overrides de Bootstrap ($primary, $font-family-base, etc.) antes del import de Bootstrap.

## Alcance del proyecto — qué SÍ y qué NO (Fase 1)

**Sí incluye**: panel Super Admin para editar todo dinámicamente, tarjetas de regalo digitales (50-500 USD) vía Stripe, reservas de mesa reales (adaptando el proyecto PHP de reservas ya existente, sin rehacerlo desde cero), notificaciones automáticas por email/WhatsApp, cuentas de cliente con historial, catálogo de vinos/tapas/hampers con "order ahead", venta de membresías Wine Club, home vendiendo "experiencia" no productos, wishlist, programa de puntos (1 USD = 1 punto), cupones de un solo uso, sección cruzada con NTC Luxury Travels.

**NO incluye por ahora**: cursos online, merchandising, Chef's Table/private dinner como módulo aparte, roles de Kitchen/Wine Club Manager/Marketing/Restaurant Manager, email marketing propio, Apple/Google Wallet para gift cards, login social, PWA/tiempo real, migración a React/Laravel, cualquier plantilla de terceros.

## Roles del sistema

Super Admin (desarrollador) y Owner (Nicolás, dueño) con acceso casi total — Owner sin acceso a configuración técnica sensible (claves API, servidor). Waiter: entrega pedidos comprados por la web, ve notas/alergias, marca hora de entrega, no ve detalle de pago. Cliente registrado e invitado (guest checkout).

## Consideraciones legales (California) — obligatorias en el diseño

- Ley de tarjetas de regalo de CA: nunca fecha de expiración; saldos menores a $15 deben poder canjearse en efectivo.
- Puntos de fidelización: sí pueden expirar (excepción legal para programas promocionales), pero recolectar datos personales (cumpleaños, alergias, preferencias) a cambio de beneficios activa CCPA como "programa de incentivo financiero" — requiere aviso claro y consentimiento opt-in explícito.
- Licencia ABC para vender vino embotellado para llevar — pendiente de confirmar con Nicolás el tipo exacto.
- Calcular sales tax de California correctamente en el checkout.

## Pagos

Stripe como motor principal (cubre tarjeta + Apple Pay + Google Pay + PayPal en un solo Payment Link) + PayPal Checkout directo como alternativa. QR de pago = generar un QR apuntando al link de checkout hospedado.

## Panel administrativo

Sobre plantilla open-source (AdminLTE 4 o CoreUI Free — Bootstrap 5, MIT), no construido desde cero.

## Mapa de páginas y secciones — ver docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md

Resumen: 9 items de navegación (Inicio, Experiencias, Restaurante, Wine Shop, Gift Cards, Wine Club, Eventos, Reservar, Mi Cuenta). El Home tiene 10 secciones en orden (header/nav, hero, experiencias, eventos, wine club, gift cards, restaurant teaser, wine shop teaser, testimonios, footer). El orden de construcción va de arriba hacia abajo en el Home primero, luego páginas internas de menor a mayor complejidad, y al final lo que requiere cuentas/backend (Mi Cuenta, panel admin).

## Estado actual del proyecto (última actualización)

- [x] Auditoría de assets del sitio (colores/tipografías/imágenes) en `docs/inventario-assets-actual.md`.
- [x] Estructura SCSS 7-1 creada con tokens de marca reales en `_variables.scss` (hecha originalmente pensando en una plantilla que ya se descartó — sigue siendo válida, son solo variables).
- [x] `gulpfile.mjs`/`package.json` corregidos (bug de esbuild `outfile`+`outdir` ya resuelto) y confirmados compilando SCSS limpio.
- [x] `assets/js/main.js` creado como entry point mínimo.
- [ ] **Pendiente inmediato**: correr la skill `auditoria-estructura-actual` sobre el repo real para inventariar páginas/secciones/convenciones actuales antes de refactorizar nada — esto reemplaza el trabajo que se había hecho para adaptar Kaffen, que ya no aplica.
- [ ] Después: refactorizar Header + Nav + Hero del Home (mismo objetivo de siempre: 9 items de menú, copy "Escape to Spain without leaving California"), pero sobre el HTML/CSS real existente, no sobre una plantilla.
- [ ] Luego, en orden: Experiencias, Eventos, Wine Club, Gift Cards, Restaurant teaser, Wine Shop teaser, Testimonios, Footer — y después las páginas internas y lo que requiere backend.

## Cómo darme instrucciones (usa esta estructura siempre)

```
CONTEXTO
Archivos involucrados: <rutas exactas>

OBJETIVO
<una frase clara>

DIAGNÓSTICO OBLIGATORIO
Antes de escribir código, muéstrame tu plan paso a paso y ESPERA mi confirmación explícita — no sigas de largo narrando el plan y escribiendo código en el mismo turno.

ACCIÓN REQUERIDA
1. ...
2. ...

RESTRICCIONES
- No toques: <fuera de alcance>
- No instales dependencias nuevas sin decirlo primero

CRITERIO DE ACEPTACIÓN
Terminado cuando: <qué revisar para confirmar que funciona, con un método de verificación concreto (ej. un comando grep, no solo "revisar visualmente")>
```
