# Instrucciones específicas de GitHub Copilot

Lee primero `AGENTS.md` en la raíz — es la fuente de verdad cross-tool (stack, principios, convenciones). Este archivo solo añade comportamiento específico de Copilot.

## Skills y recursos

- Las skills del proyecto viven en `.agents/skills/` (formato SKILL.md, compatibles con Copilot/Claude Code/Codex/Cursor). Cárgalas solo cuando la tarea coincida con su dominio — no las leas completas si no aplican (progressive disclosure).
- Reglas específicas por tipo de archivo están en `.github/instructions/*.instructions.md` con `applyTo` — se aplican automáticamente según el archivo que estés editando, no dupliques ese contenido aquí.

## Comportamiento en modo agente

- Antes de tocar una página/sección, consulta `docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md` para confirmar que es el turno correcto según el orden de construcción pactado, y `docs/inventario-estructura-actual.md` para saber cómo está hoy esa sección.
- Si vas a instalar una dependencia o herramienta nueva, dilo explícitamente antes de hacerlo y explica por qué es necesaria — no la agregues en silencio.
- Al terminar una tarea, resume en 1-2 líneas qué se puede verificar manualmente (qué abrir, qué botón probar, qué revisar en consola).
- Si detectas que una petición implicaría reescribir el proyecto en React/Laravel, usar una plantilla de terceros, o construir algo marcado como "no ahora" en `AGENTS.md`, pregunta antes de proceder en vez de asumir que cambió el alcance.
