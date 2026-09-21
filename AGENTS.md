# AGENTS.md — The Clandestino USA

Este archivo aplica a cualquier agente de IA usado en este repositorio (GitHub Copilot Pro, Qwen Code, DeepSeek, o cualquier otra herramienta compatible con el estándar AGENTS.md). Es la fuente de verdad transversal. Detalle completo de estándares: `docs/ESTANDARES-DE-CODIGO.md`. Mapa de páginas/secciones y orden de trabajo: `docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md`.

## Qué es este proyecto

Refactorización y ampliación de theclandestinousa.com (restaurante español, Mt. Shasta, CA) **sobre el código ya existente** (HTML/CSS/JS/PHP en producción) — no se usa ninguna plantilla de terceros. Se evoluciona el sitio informativo actual hacia una plataforma de venta digital: tarjetas de regalo, reservas, Wine Shop, Wine Club, eventos, cuentas de usuario con fidelización, aplicando de forma incremental las convenciones de código ya definidas.

## Stack (no negociable por ahora)

- HTML5 semántico + SCSS (Bootstrap 5, patrón 7-1, compilado con Gulp) + JavaScript ES2026+ modular + PHP moderno en capas.
- Migrar el CSS actual a SCSS con Bootstrap real (no solo clases sueltas) — aprovechar los componentes JS nativos de Bootstrap vía atributos `data-bs-*` (modal, collapse, dropdown, carousel) en vez de reescribir esa lógica a mano.
- **NO** migrar a React/Laravel — proyecto futuro explícitamente pospuesto. No lo sugieras ni lo empieces salvo que se pida de forma explícita.
- **NO** usar plantillas de terceros (se evaluó y descartó Kaffen) — todo el trabajo es sobre el código propio existente.
- Hosting de destino: GoDaddy Web Hosting Deluxe (cPanel, shared). Nada de dependencias que requieran colas/Redis/procesos persistentes.
- Migrar todas las páginas `.html` a `.php`, extrayendo header/nav/footer a includes de PHP reutilizables (`partials/header.php`, `partials/nav.php`, `partials/footer.php`) en vez de duplicar el shell por página.
- Base del CSS: normalize.css antes de las reglas propias, dentro de `base/_reset.scss` del patrón 7-1.
- `1rem = 10px` vía `font-size: 62.5%` en `:root` (no 1px).

## Reglas no negociables (principios Karpathy)

1. **No asumas en silencio.** Si una instrucción es ambigua, dilo y propone la interpretación más razonable antes de escribir código — no rellenes huecos y sigas de largo.
2. **Simplicidad primero.** La solución más simple que cumple el objetivo es la correcta. No construyas abstracciones, capas o configuración que nadie pidió.
3. **Cambios quirúrgicos.** Toca solo lo que la tarea requiere. No reformatees, renombres ni "mejores" código o comentarios fuera del alcance pedido, aunque no los entiendas del todo.
4. **Ejecución por criterios de éxito.** Antes de dar una tarea por terminada, indica explícitamente cómo se verifica que funciona (qué probar, qué se ve en pantalla, qué comando correr) — no te des por terminado solo porque el código "parece correcto".

## Convenciones de código (resumen — detalle en docs/ESTANDARES-DE-CODIGO.md)

- Código, comentarios y documentación: **español**. Texto visible al usuario final: **inglés** por defecto (sitio bilingüe, español opcional).
- Nomenclatura: `camelCase` (JS/PHP), `PascalCase` (clases), `UPPER_SNAKE_CASE` (constantes), `kebab-case` (archivos/carpetas).
- CSS: BEM en español con prefijo de proyecto **`cl-`** → `cl-bloque__elemento--modificador` (ej. `cl-tarjeta-vino__precio--oferta`).
- PHP: PSR-12, arquitectura en capas (Controllers → Services → Repositories → Models → Views), prepared statements siempre, `htmlspecialchars()` en todo output.
- Commits: Conventional Commits en español, Git Flow (`main`/`develop`/`feature/`/`fix/`/`hotfix/`/`release/`).

## Dónde vive cada cosa

- `assets/scss/` — patrón 7-1 (abstracts, base, components, layout, pages, themes, vendors).
- `assets/js/` — un módulo ES6 por responsabilidad, named exports.
- `src/Controllers`, `src/Services`, `src/Repositories`, `src/Models` — PHP en capas.
- `.agents/skills/` — procedimientos específicos que se cargan solo cuando la tarea los necesita (no repitas aquí lo que ya vive en una skill).

## Antes de dar una tarea por terminada

1. ¿El HTML generado es semántico y accesible (labels, alt, contraste, foco visible)?
2. ¿Las clases CSS siguen `cl-` + BEM en español?
3. ¿El PHP usa prepared statements y escapa todo output?
4. ¿Hay algo tocado que no estaba en el alcance de la tarea? Si sí, revertirlo.
5. ¿Diste un criterio verificable de que esto funciona (qué revisar en el navegador, qué probar)?
