# AGENTS.md — The Clandestino USA

Reglas globales para cualquier agente de IA o colaborador. El detalle vive en `docs/`; aquí solo lo transversal.

## Qué es este proyecto

The Clandestino USA (theclandestinousa.com) es un restaurante español en Mt. Shasta, CA. Se hace un **refactor incremental del sitio actual** (HTML/CSS/JS/PHP en producción) hacia una plataforma de venta digital. Enfoque **revenue-first**: primero lo que genera ingresos (Take Away, Gift Cards, Wine Club, Reservas, Eventos).

## Stack y restricciones

- HTML5 semántico, CSS legacy hoy; SCSS + Bootstrap 5 (Sass) + JS con esbuild + Gulp como objetivo.
- PHP simple primero; MySQL solo cuando una feature real lo requiera.
- Hosting: GoDaddy shared (cPanel). Sin Redis, colas ni procesos persistentes.
- **NO** Laravel, **NO** React, **NO** plantillas de terceros.
- Dependencias nuevas solo con justificación explícita.

## Autoridad de ramas

- `production-baseline`: autoridad histórica sobre el comportamiento desplegado al iniciar el refactor.
- `master`: **legacy congelado**; no es autoridad sobre producción. No se hace merge de `master`.
- `main`: producción estable. `develop`: integración. Las features nacen desde `develop`.
- Nunca trabajar directamente en `main`, `master` ni `production-baseline`.
- Detalle: `docs/GIT-WORKFLOW.md`.

## Principios de ingeniería

- **DRY**, **KISS**, **YAGNI**, **Fail Fast**.
- **No asumas en silencio**: si algo es ambiguo, dilo y propone la interpretación más razonable.
- **Cambios quirúrgicos**: toca solo lo que la tarea requiere; sin reformatear ni renombrar fuera de alcance.
- No sobre-ingenierizar: sin capas ni abstracciones que nadie pidió.

## Idioma

- Código, comentarios y documentación: **español**.
- Texto visible al usuario final: **inglés**.

## Protección de producción

- No modificar comportamiento en producción sin pedirlo explícitamente.
- No commitear secretos ni `.env`; los secretos van por entorno.
- Antes de cambiar una página, contrastar con `production-baseline`.
- Deploy solo desde `main`/tag (futuro); nunca desde una feature.

## Git (resumen)

- Commits atómicos con Conventional Commits en español.
- Sin `Co-authored-by` ni firmas de herramientas/IA; el autor es el usuario del repo.
- Sin force push salvo recuperación explícita.

## Definición de terminado

Una tarea está terminada solo si:

1. Se indicó cómo se verifica (qué abrir, en qué viewport, qué comando correr) y se verificó.
2. HTML semántico y accesible (labels, `alt`, contraste, foco visible).
3. No se tocó nada fuera del alcance (si ocurrió, se revierte).
4. La documentación afectada se actualizó en el mismo commit.

## Referencias

- `docs/ESTANDARES-DE-CODIGO.md` — estándares de código.
- `docs/ARQUITECTURA.md` — arquitectura vigente y objetivo inmediato.
- `docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md` — producto y prioridades.
- `docs/GIT-WORKFLOW.md` — ramas, commits y releases.
- `docs/LEGACY-UI-INVENTORY.md` — inventario de UI legacy.
- `.cursor/rules/` y `.agents/skills/` — reglas por tipo de archivo y procedimientos.
