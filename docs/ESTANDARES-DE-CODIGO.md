# Estándares de Código — The Clandestino USA

Referencia completa. `AGENTS.md` resume lo global y `.cursor/rules/` aplica lo específico por tipo de archivo. Muchas reglas de SCSS/JS/PHP describen la **arquitectura objetivo**; ver `docs/ARQUITECTURA.md` para lo vigente.

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

## CSS / SCSS (arquitectura objetivo)

- **BEM con prefijo `cl-`**; nesting SCSS máximo 3 niveles.
- **7-1 pragmático**: se crean carpetas/partials solo cuando tienen contenido (`abstracts`, `base`, `components`, `layout`, `pages`, `vendors`). `themes/` no es obligatorio.
- **Bootstrap 5 compilado desde Sass**, con **Reboot** como reset. No se usa normalize.css independiente.
- **No sobrescribir el `font-size` raíz**: se respeta la configuración predeterminada del navegador/usuario y se usa `rem` sobre esa base, de modo que `rem` respeta las preferencias del usuario. `62.5%` está prohibido y no se hardcodea `16px` en `html`.
- **Dark-first**.
- **Breakpoints de Bootstrap** como fuente de verdad (`sm` 576 · `md` 768 · `lg` 992 · `xl` 1200 · `xxl` 1400); mobile-first, sin breakpoints propios.
- Variables CSS en `:root` con nombres semánticos.
- PurgeCSS **diferido**: se evalúa cuando exista el CSS nuevo en producción.
- Nunca editar CSS compilado a mano.

## JavaScript (arquitectura objetivo)

- ES Modules, bundling con esbuild; `assets/js/dist/**` es output generado.
- Named exports cuando aporten claridad; barrels no obligatorios.
- Funciones puras cuando sea posible; `const`, spread, `map`/`filter`/`reduce`.
- `try/catch` solo donde el error se maneje o enriquezca; nunca `catch` vacío.
- Event delegation en contenido dinámico; `throttle` en scroll/resize, `debounce` en búsqueda.
- DOM seguro: `textContent`; nunca `innerHTML` con datos no sanitizados.
- Preferir `data-bs-*` cuando Bootstrap cubra el caso.
- Dependencias nuevas solo con justificación. Prettier y Husky **no son obligatorios** por ahora.
- **ESLint** (`eslint.config.mjs`) aplica solo al JS nuevo (`assets/js/main.js`, `assets/js/modules/**`) y a los `.mjs` de tooling. **Stylelint** (`.stylelintrc.json`, `stylelint-config-standard-scss`) aplica solo a `assets/scss/**`. Ambos con `npm run lint`.
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

Ver `docs/GIT-WORKFLOW.md`.

## Documentación

`README.md`, `CHANGELOG.md` y `docs/` viven junto al código: si el código cambia, la documentación afectada cambia en el mismo commit. `.editorconfig` define el formato base (UTF-8, LF, 2 espacios).
