# Estándares de Código — The Clandestino USA

Documento de referencia completo. `AGENTS.md` y los archivos en `.github/instructions/` resumen y aplican esto por tipo de archivo; este documento es la fuente completa cuando se necesite el detalle.

## Principios fundamentales

- **DRY**: no repitas lógica; extrae funciones, mixins o componentes reutilizables.
- **KISS**: la solución más simple que funciona correctamente es siempre la mejor.
- **SOLID**: un módulo = una responsabilidad.
- **YAGNI**: no implementes funcionalidad que aún no se necesita.
- **Fail Fast**: valida entradas al inicio; falla con mensajes claros antes de propagar errores.

## Idioma y nomenclatura

- Código, comentarios y nombres de variables/funciones/clases: **español**.
- Textos visibles al usuario final (labels, títulos, mensajes): **inglés**, español opcional.
- Librerías externas y convenciones de frameworks: se respeta su idioma original.

| Elemento | Convención | Ejemplo |
|---|---|---|
| Variables y funciones JS/PHP | camelCase | `calcularTotal()`, `nombreUsuario` |
| Clases y componentes | PascalCase | `CarritoCompras`, `ServicioAutenticacion` |
| Constantes globales | UPPER_SNAKE_CASE | `MAX_INTENTOS`, `URL_BASE` |
| Archivos y carpetas | kebab-case | `mi-componente.js`, `servicios-api/` |
| Clases CSS (BEM + prefijo de proyecto) | `cl-bloque__elemento--modificador` | `cl-tarjeta__titulo--activo` |
| Variables SCSS/CSS | kebab-case en español | `--color-primario`, `$espaciado-base` |

## Comentarios (Better Comments)

- `// *` Destacado — información importante.
- `// !` Advertencia crítica, no modificar sin entender.
- `// TODO:` tarea pendiente con descripción clara.
- `// ?` duda o punto de revisión.
- `/** JSDoc / PHPDoc */` en funciones y clases públicas.

**Regla de oro**: comenta el POR QUÉ, no el QUÉ. El código explica qué hace; el comentario explica la decisión de diseño, el caso edge o la restricción de negocio.

## Git — control de versiones

**Ramas (Git Flow simplificado)**: `main` (producción) · `develop` (integración) · `feature/nombre-descriptivo` · `fix/nombre-del-bug` · `hotfix/descripcion` · `release/v1.2.0`.

**Commits (Conventional Commits, español, máx. 77 caracteres)**:
`feat`, `fix`, `docs`, `style`, `refactor`, `perf`, `test`, `chore`, `revert`.
Ejemplo: `feat(auth): agregar autenticación con JWT y refresh token`

- `.gitignore` completo (`node_modules/`, `vendor/`, `.env`, `*.log`, `/dist`, `/build`).
- `.gitattributes` para normalizar saltos de línea (LF en todos los entornos).
- `git rebase` para limpiar historial antes de merge.
- Releases etiquetados con semantic versioning (`v1.0.0`).
- `CHANGELOG.md` en cada release, formato Keep a Changelog.

## HTML5 — semántica y accesibilidad

- Etiquetas semánticas siempre: `<header>`, `<nav>`, `<main>`, `<article>`, `<section>`, `<aside>`, `<footer>`.
- Un único `<h1>` por página; jerarquía de headings sin saltar niveles.
- WAI-ARIA solo cuando la semántica nativa no basta; nunca duplicar roles implícitos.
- Todo formulario: `<label for="id">` asociado explícitamente.
- `lang="en"` en `<html>` (o `lang="es"` según el idioma activo).

**WCAG 2.1 AA**: alt descriptivo en imágenes informativas, `alt=""` en decorativas · contraste mínimo 4.5:1 (texto normal), 3:1 (texto grande ≥18pt) · orden de tab lógico, `:focus-visible` en todo interactivo · nunca depender solo del color · videos con subtítulos, audios con transcripción.

**Rendimiento**: `defer`/`type="module"` en scripts · `<picture>` con AVIF/WebP primero, JPG/PNG de fallback · `loading="lazy"` fuera del viewport, `fetchpriority="high"` en LCP · `width`/`height` en imágenes (evitar CLS) · `preconnect` a dominios críticos.

**SEO técnico**: meta charset, viewport, description, `og:*`, `twitter:*` en todas las páginas · JSON-LD (schema.org: Restaurant, Product, Review, FAQ, Event, Breadcrumb, LocalBusiness) · `sitemap.xml` y `robots.txt` · `<link rel="canonical">`.

**Plantilla PHP base**: `layout.php` con header/nav/footer y zona de contenido intercambiable; todas las páginas internas la extienden.

## CSS3 / SCSS — arquitectura

**Patrón 7-1**: `abstracts/` (variables, mixins, funciones, placeholders) · `base/` (reset, tipografía) · `components/` · `layout/` (nav, header, footer, grid) · `pages/` · `themes/` (claro/oscuro) · `vendors/` (`_bootstrap.scss` overrides) · `main.scss` (solo `@use`/`@forward`).

- Variables CSS en `:root`, nombres semánticos en español, separadas por categoría (colores, tipografía, espaciado, bordes, sombras, transiciones). `prefers-color-scheme` para theming.
- BEM con prefijo `cl-`: bloque (`cl-tarjeta`), elemento (`cl-tarjeta__imagen`), modificador (`cl-tarjeta--destacada`). Anidación SCSS máx. 3 niveles.
- Breakpoints (mobile-first): `xs` 0px · `sm` 480px · `md` 768px · `lg` 1024px · `xl` 1280px · `2xl` 1536px. Mixin centralizado `@include responder(md) { ... }`.
- `1rem = 10px` vía `font-size: 62.5%` en `:root`. `rem` para tamaños/espaciado, `em` relativo al componente. `font-display: swap` + `preconnect` en fuentes web.

## JavaScript ES2026+

- Módulos ES6, un archivo = una responsabilidad. Named exports sobre default exports. `import()` dinámico para no crítico. Barrel files (`index.js`) por feature.
- Funciones puras cuando sea posible. Inmutabilidad (`const`, spread, `map`/`filter`/`reduce`). `async/await` con `try/catch` siempre.
- Errores específicos (`TypeError`, `RangeError`, personalizados). Nunca `catch` vacío. Mensajes técnicos para devs, amigables para el usuario.
- Delegación de eventos en listas/tablas dinámicas. `throttle` en scroll/resize, `debounce` en inputs de búsqueda. Nunca `innerHTML` con datos no sanitizados — `textContent` o DOMPurify.
- ESLint + Prettier, Husky + lint-staged en pre-commit.

## Bootstrap 5

- Personalizar vía variables SCSS (`$primary`, etc.) **antes** de importar Bootstrap; nunca sobrescribir CSS compilado ni usar `!important` sobre sus clases.
- Importar solo los módulos SCSS necesarios (tree-shaking). Grid de Bootstrap solo para layout; componentes propios con BEM.
- No duplicar ARIA en componentes de Bootstrap que ya lo incluyen (modal, collapse, dropdown). Usar `.visually-hidden` para lectores de pantalla.

## PHP — backend

**Capas**: `Controllers/` (recibe request, llama Service, sin lógica de negocio) → `Services/` (lógica de negocio) → `Repositories/` (acceso a datos, prepared statements) → `Models/` (entidades, validación) → `Views/` (solo presentación) → `Config/` (`.env`, sin hardcodear).

**Seguridad — checklist obligatorio**: prepared statements/PDO siempre · `htmlspecialchars($valor, ENT_QUOTES, 'UTF-8')` en todo output · token CSRF en formularios POST/PUT/DELETE · `password_hash()` con BCRYPT o ARGON2ID (nunca MD5/SHA1) · cookies de sesión con `HttpOnly`, `Secure`, `SameSite=Strict` · validar MIME real en uploads (`finfo_file`), guardar fuera del webroot · headers `Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`.

PSR-12 (estilo) + PSR-4 (autoloading Composer). PHPDoc en funciones/clases públicas. Nunca exponer stack traces en producción. Opcache habilitado.

## SQL / Base de datos

| Elemento | Convención | Ejemplo |
|---|---|---|
| Tablas | snake_case, plural | `usuarios`, `ordenes_detalle` |
| Columnas | snake_case, singular | `nombre_completo`, `fecha_creacion` |
| Primary key | `id` | — |
| Foreign key | `tabla_id` | `usuario_id` |
| Índices | `idx_tabla_columna` | `idx_usuarios_email` |

Seleccionar solo columnas necesarias, prepared statements desde el repositorio, índices en `WHERE`/`JOIN`/`ORDER BY`, transacciones para operaciones atómicas, soft delete (`eliminado_en`) donde se necesite auditoría, columnas `creado_en`/`actualizado_en`/`creado_por` en tablas críticas. Migraciones con timestamp, nunca modificar una ya ejecutada en producción, seeds separados, rollback (`down()`) siempre. Nunca contraseñas en texto plano ni credenciales en el repo — `.env` + mínimo privilegio del usuario de BD.

## Documentación obligatoria en el repo

`README.md` · `CHANGELOG.md` (Keep a Changelog) · `.env.example` · `.editorconfig` · `docs/arquitectura.md`. La documentación vive junto al código: si el código cambia, la documentación cambia en el mismo commit.
