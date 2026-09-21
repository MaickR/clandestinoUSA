---
applyTo: "assets/scss/**"
---

# SCSS/CSS — reglas obligatorias

- Patrón 7-1: `abstracts/ base/ components/ layout/ pages/ themes/ vendors/` + `main.scss` (solo `@use`/`@forward`, sin reglas propias).
- BEM en español con prefijo de proyecto `cl-`: `cl-bloque__elemento--modificador`. Ninguna clase nueva sin este prefijo.
- Variables CSS en `:root`, nombres semánticos en español, agrupadas por categoría (colores, tipografía, espaciado, bordes, sombras, transiciones). Variables SCSS (`$variable`) solo para lógica de compilación.
- Personalizar Bootstrap sobrescribiendo variables SCSS (`$primary`, etc.) **antes** del `@import`/`@use` de Bootstrap. Nunca `!important` sobre clases de Bootstrap, nunca tocar `node_modules`.
- Breakpoints centralizados en un mixin `responder($breakpoint)`: `xs` 0 · `sm` 480px · `md` 768px · `lg` 1024px · `xl` 1280px · `2xl` 1536px. Mobile-first siempre (min-width, no max-width).
- Anidación SCSS máximo 3 niveles.
- `1rem = 10px` (`font-size: 62.5%` en `:root`); `rem` para tamaños/espaciado, `em` relativo al componente.
- Compilar con Gulp; no dejar CSS compilado editado a mano.
