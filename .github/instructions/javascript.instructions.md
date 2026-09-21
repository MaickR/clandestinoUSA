---
applyTo: "assets/js/**"
---

# JavaScript ES2026+ — reglas obligatorias

- Un archivo = una responsabilidad. Named exports sobre default exports. `import()` dinámico para código no crítico. Barrel file (`index.js`) por feature.
- Librerías externas de terceros: siempre por CDN, en su propio archivo, nunca mezcladas con código propio.
- Funciones puras cuando sea posible; inmutabilidad (`const`, spread, `map`/`filter`/`reduce` sobre mutación directa).
- `async/await` con `try/catch` siempre — nunca `.then()` encadenado sin manejo de error, nunca `catch` vacío (mínimo `console.error()` con contexto).
- Errores específicos (`TypeError`, `RangeError`, clases de error propias). Mensaje técnico para consola, mensaje amigable para el usuario final.
- Nunca `innerHTML` con datos no sanitizados — usar `textContent` o DOMPurify. Escapar todo output insertado en el DOM.
- Delegación de eventos en listas/tablas dinámicas. `throttle` en scroll/resize, `debounce` en inputs de búsqueda.
- Código y comentarios en español; JSDoc (`@param`, `@returns`, `@throws`, `@example`) en funciones públicas.
- Nomenclatura: `camelCase` en funciones/variables, `PascalCase` en clases/componentes, `UPPER_SNAKE_CASE` en constantes.
