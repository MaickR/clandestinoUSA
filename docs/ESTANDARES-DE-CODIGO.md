# Estándares de Código — The Clandestino USA

Reglas de implementación y verificación para páginas reales. [AGENTS.md](../AGENTS.md) establece la autoridad de cada documento. Las reglas del editor aplican estos estándares y la [arquitectura vigente](ARQUITECTURA.md).

## Principios fundamentales

- **DRY**: no repitas lógica; extrae funciones, mixins o componentes reutilizables.
- **KISS**: la solución más simple que funciona es la mejor.
- **YAGNI**: no implementes lo que aún no se necesita.
- **Fail Fast**: valida entradas al inicio y falla con mensajes claros.
- **Cambios quirúrgicos**: toca solo lo que la tarea requiere.
- Un módulo = una responsabilidad.

## Idioma y nomenclatura

- Código, comentarios y nombres: **español**. Textos visibles al usuario: **inglés**.
- Librerías externas y convenciones de frameworks conservan su idioma.

| Elemento | Convención | Ejemplo |
|---|---|---|
| Variables y funciones JS/PHP | camelCase | `calcularTotal()` |
| Clases | PascalCase | `CarritoCompras` |
| Constantes globales | UPPER_SNAKE_CASE | `MAX_INTENTOS` |
| Archivos y carpetas | kebab-case | `mi-componente.js` |
| Clases CSS (BEM + prefijo) | `cl-bloque__elemento--modificador` | `cl-tarjeta__titulo--activo` |
| Variables SCSS/CSS | kebab-case en español | `--color-primario` |

## Comentarios (Better Comments)

- `// *` destacado · `// !` advertencia crítica · `// TODO:` pendiente · `// ?` duda o revisión.
- `/** JSDoc / PHPDoc */` en funciones y clases públicas.
- Comenta el **porqué**, no el qué.

## HTML5 — semántica y accesibilidad

- Etiquetas semánticas: `<header>`, `<nav>`, `<main>`, `<article>`, `<section>`, `<aside>`, `<footer>`.
- Un único `<h1>` por página; headings sin saltar niveles.
- WAI-ARIA solo cuando la semántica nativa no basta; no duplicar roles implícitos.
- Todo campo de formulario con `<label for>` asociado.
- `lang="en"` en `<html>`.

**WCAG 2.1 AA**: `alt` descriptivo en imágenes informativas y `alt=""` en decorativas · contraste 4.5:1 (texto normal) y 3:1 (grande) · orden de tab lógico y `:focus-visible` en todo interactivo · no depender solo del color · videos con subtítulos.

## SEO técnico

- Meta charset, viewport, description, `og:*`, `twitter:*` en cada página.
- JSON-LD (schema.org: Restaurant, Product, Event, FAQ, Breadcrumb, LocalBusiness) donde aplique.
- `sitemap.xml`, `robots.txt` y `<link rel="canonical">`.

## Rendimiento

- `defer` o `type="module"` en scripts.
- `<picture>` con AVIF/WebP primero y fallback JPG/PNG.
- `loading="lazy"` fuera del viewport; `fetchpriority="high"` en el LCP.
- `width`/`height` en imágenes para evitar CLS.
- `preconnect` a dominios críticos; `font-display: swap`.

## CSS / SCSS

- **BEM con prefijo `cl-`**; nesting SCSS máximo 3 niveles.
- **7-1 pragmático**: se crean carpetas/partials solo cuando tienen contenido (`abstracts`, `base`, `components`, `layout`, `pages`, `vendors`). `themes/` no es obligatorio.
- **Bootstrap 5 selectivo compilado desde Sass**, con **Reboot** como reset. No se usa normalize.css independiente.
- **No sobrescribir el `font-size` raíz**: se respeta la configuración predeterminada del navegador/usuario y se usa `rem` sobre esa base, de modo que `rem` respeta las preferencias del usuario. `62.5%` está prohibido y no se hardcodea `16px` en `html`.
- **Dark-first**.
- **Breakpoints globales de Bootstrap** (`sm` 576 · `md` 768 · `lg` 992 · `xl` 1200 · `xxl` 1400). Diseñar mobile-first según contenido y espacio. Cuando la presentación cambia el modo de interacción, CSS y JavaScript deben coincidir.
- Variables CSS en `:root` con nombres semánticos. Los primitivos se quedan en SCSS (`abstracts/_tokens.scss`).
- **Tipografía vigente**: display y headings en Libre Bodoni (fallback Palatino / serif); cita editorial en Playfair Display (`.cl-cita`); cuerpo y UI (párrafos, botones, labels, campos, mensajes) en `system-ui, -apple-system, "BlinkMacSystemFont", "Segoe UI", sans-serif`. Sin fuente nueva y sin usar Playfair como sans de interfaz.
- **Escala**: display `clamp(2.5rem, 1.5rem + 3vw, 4.5rem)`; h1 `clamp(2rem, 1.3rem + 2vw, 3.25rem)`; h2 `clamp(1.75rem, 1.2rem + 1vw, 2.5rem)`; h3–h6 `1.5rem`; cuerpo `1.0625rem`; small `0.875rem`; eyebrow `0.75rem` en mayúsculas con `--tracking-eyebrow: 0.18em`.
- **Espaciado**: `--espacio-1`…`--espacio-9` = 0.25, 0.5, 0.75, 1, 1.5, 2, 3, 4 y 6rem. `$spacers` de Bootstrap usa la misma escala. `.cl-seccion` reutiliza 3rem y 4rem desde `lg`; la guía mantiene 6rem en su cierre. Contratos estructurales: `docs/SECTION-PATTERN-LIBRARY.md`.
- **Radio**: `--radio-sm` 0.125rem (campos), `--radio-md` 0.25rem (botón y card). Sin pills por defecto. Reservar `--sombra-elevada` a los overlays que la usan por contrato.
- **Accesibilidad de la foundation**: `:focus-visible` con anillo `--color-foco` de 2px y offset 3px; `:focus` de ratón sin anillo porque el anillo de teclado lo sustituye; `prefers-reduced-motion` anula transición y animación; `::selection` en vino con texto cream. Texto normal ≥ 4.5:1, borde de control ≥ 3:1. El error de formulario lleva mensaje visible. Botón y campo: alto mínimo 2.75rem (44px con la raíz por defecto).
- PurgeCSS **diferido**: se evalúa cuando exista el CSS nuevo en producción.
- Nunca editar CSS compilado a mano.

La guía viva local se divide en `style-guide/index.php` (Foundations/Core) y `style-guide/patterns.php` (Section Patterns). El `style-guide.md` de la raíz es la plantilla legacy y no describe estos tokens.

### Excepción del Header compartido

El Header pasa a navegación horizontal a partir de **1024 CSS px**. Por debajo usa el drawer cuando JavaScript está disponible y conserva la navegación expandida como fallback. El adaptador Sass de Offcanvas genera `.offcanvas-cabecera` con un mapa local y restaura el mapa global. El SCSS del Header usa el mismo umbral y lo expone en `--cabecera-escritorio`, que JavaScript lee para `matchMedia`. Mantener coordinados presentación, Offcanvas, estado y foco al cruzar el umbral. El grid y los breakpoints globales permanecen intactos. Las demás secciones eligen sus transiciones según su contenido.

Criterios prácticos de experiencia, mobile first, interacciones, formularios, rendimiento e identidad: [Guía UX/UI](UX-UI-GUIDELINES.md). Complementa los contratos técnicos sin duplicar tokens ni imponer prohibiciones dogmáticas.

## JavaScript

- ES Modules, bundling con esbuild; `assets/js/dist/**` es output generado.
- Named exports cuando aporten claridad; barrels no obligatorios.
- Funciones puras cuando sea posible; `const`, spread, `map`/`filter`/`reduce`.
- `try/catch` solo donde el error se maneje o enriquezca; nunca `catch` vacío.
- Event delegation en contenido dinámico; `throttle` en scroll/resize, `debounce` en búsqueda.
- DOM seguro: `textContent`; nunca `innerHTML` con datos no sanitizados.
- Preferir `data-bs-*` cuando Bootstrap cubra el caso.
- Usar las dependencias del stack vigente. Una necesidad real que exceda ese stack se justifica y se propone como decisión de arquitectura antes de incorporar otra dependencia.
- **ESLint** (`eslint.config.mjs`) aplica solo al JS nuevo (`assets/js/main.js`, `assets/js/style-guide.js`, `assets/js/modules/**`) y a los `.mjs` de tooling. **Stylelint** (`.stylelintrc.json`, `stylelint-config-standard-scss`) aplica solo a `assets/scss/**`. Ambos con `npm run lint`.
- El JS y CSS legacy no se lintean: se migra incrementalmente y entra en el lint al refactorizarse.

## Bootstrap 5

- Personalizar con variables Sass **antes** de importar; importar solo los módulos necesarios.
- No sobrescribir CSS compilado ni usar `!important` sobre sus clases.
- Grid de Bootstrap para layout; componentes propios con BEM.
- No duplicar ARIA que Bootstrap ya incluye. Usar `.visually-hidden` para lectores de pantalla.

## PHP

- **PSR-12** en código nuevo o refactorizado; el legacy no se reformatea fuera de alcance.
- **Arquitectura proporcional**: PHP simple primero; sin capas artificiales. Extraer includes/funciones/clases cuando la complejidad lo justifique.
- Composer/PSR-4 **no son obligatorios** todavía.
- Sin Redis ni procesos persistentes (GoDaddy shared).

**Seguridad (obligatorio):**

- Validar todo input en servidor.
- Escapar output con `htmlspecialchars($valor, ENT_QUOTES, 'UTF-8')`.
- Token CSRF en todo POST nuevo.
- Prepared statements (PDO).
- Importes recalculados en servidor; nunca confiar en el cliente.
- Secretos por entorno; nunca en el repo.
- `password_hash()` (BCRYPT/ARGON2ID) si hay contraseñas; cookies de sesión `HttpOnly`, `Secure`, `SameSite`.
- Validar MIME real en uploads y guardarlos fuera del webroot.
- Sin stack traces en producción.

## SQL / Base de datos

No se define esquema ahora. Se diseñará (convenciones, migraciones, índices) cuando una feature real requiera MySQL. Regla permanente: nunca credenciales en el repo y usuario de BD con mínimo privilegio.

## Git

Ver [flujo Git](GIT-WORKFLOW.md).

## Protección de páginas aprobadas

- Conservar las páginas aprobadas salvo cambio explícitamente autorizado o defecto demostrado. Registrar la evidencia del defecto y acotar su corrección.
- Antes de implementar, declarar la lista de archivos permitidos e identificar componentes compartidos, sus contratos y consumidores. Aislar estilos de página en bloques BEM y partials locales. Reutilizar el Design System y justificar cualquier impacto global.
- Identificar el SHA de `develop` usado como base. Comparar alcance y comportamiento antes y después bajo las mismas condiciones. En migraciones de páginas existentes, contrastar también con `production-baseline`. Si se modifica un componente compartido, verificar todos sus consumidores identificados, incluidas las páginas y muestras de guía que lo usan.

### Regresión mínima de Home

Para una feature que cambia runtime, revisar `/home-preview.php` en local sobre el SHA de `develop` y sobre la candidata. Capturar la vista inicial y la página completa en ambos estados a **390, 820, 1024 y 1440 CSS px**. Mantener la misma altura por ancho, navegador, zoom, datos y escena inicial. Fijar la primera escena de forma reproducible para las capturas y ejecutar por separado las pruebas de movimiento con preferencias normales. Guardar capturas y resultados como artefactos de QA fuera del producto y enlazarlos una sola vez desde el PR. Incorporar capturas pesadas al repositorio solo por necesidad justificada.

| Cobertura | Comprobación mínima |
|---|---|
| Composición y recursos | Header, Hero y recorrido hasta Footer en los cuatro anchos. Sin solapes, cortes, overflow horizontal, fotografías fallidas ni errores relevantes de consola o red. Comparar recorte, contraste de texto y controles sobre la foto y foco visible. |
| Navegación | Drawer a 390 y 820, navegación horizontal a 1024 y 1440. Comprobar Discover, teclado, Escape, retorno de foco y cambio de modo con panel abierto al cruzar 1023/1024. Confirmar el fallback de navegación sin JavaScript. |
| Hero y medios | Verificar las tres escenas de Home, sus controles y CTA, pausa al interactuar y ausencia de autoplay con movimiento reducido. Verificar la primera escena sin JS y que los vídeos de Guest Stories esperan una acción. Cuando se afecten animaciones, verificar sus estados finales con y sin movimiento reducido. |
| Destinos y operación | Recorrer CTA principales y anclas, en especial la solicitud de reserva y las consultas. Validar el contrato afectado sin enviar solicitudes reales. Si se tocan anfitrión público, rutas o despliegue, probar también candidata local, raíz legacy y guardas de publicación. |

La matriz es específica de Home. La página nueva también requiere QA según su contenido y, si aplica, `qa-visual`. El [informe R9](HOME-FINAL-ACCEPTANCE.md) conserva su evidencia original y los comandos de revisión local. QA técnico y aprobación visual del responsable se registran por separado.

Para cambios exclusivamente documentales, comprobar coherencia, enlaces internos, alcance y `git diff --check`. Build, Lighthouse y baterías de navegador corresponden a cambios que los requieran.

## Documentación

- Una fuente vigente por decisión. Actualizarla antes de crear otro documento y enlazarla desde los índices, reglas del editor o guías que la consumen.
- Conservar informes y decisiones anteriores como historial. Identificar brevemente el estado obsoleto y enlazar su sucesor sin reescribir la evidencia original. Registrar qué contradicción se resolvió y dónde rige la decisión.
- Mantener cada conjunto de pruebas en su informe o artefacto original. Referenciar la evidencia desde el PR y reutilizarla por enlace cuando proceda.
- Retirar documentación solo tras comprobar su valor histórico y sus consumidores, incluidos enlaces, reglas y procesos.
- Actualizar la documentación afectada en el mismo commit que el código. [`.editorconfig`](../.editorconfig) define el formato base.
