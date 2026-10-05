# Git Workflow — The Clandestino USA

## Ramas

| Rama | Rol |
|---|---|
| `master` | Legacy congelado. No es autoridad sobre producción. No se hace merge de ella; solo se consulta con `git show origin/master:<ruta>`. |
| `production-baseline` | Snapshot histórico: autoridad sobre el comportamiento desplegado al iniciar el refactor. No se modifica. |
| `main` | Producción estable. Solo recibe PRs desde `develop`, `release/*` o `hotfix/*`. |
| `develop` | Integración. Base de las features. |
| `feature/*` | Nueva funcionalidad o documentación. Nace de `develop`; PR hacia `develop`. |
| `fix/*` | Corrección no urgente. Nace de `develop`; PR hacia `develop`. |
| `hotfix/*` | Corrección urgente de producción. Nace de `main`; PR hacia `main` y luego se integra en `develop`. |
| `release/*` | **Opcional**. Solo si se necesita estabilizar un lanzamiento. |

Nunca se trabaja directamente sobre `main`, `develop`, `master` ni `production-baseline`.

## Flujo de una feature

1. `git status` limpio → `git fetch origin`.
2. `git switch develop` → `git merge --ff-only origin/develop`.
3. `git switch -c feature/nombre-descriptivo`.
4. Commits atómicos; push de la rama con upstream.
5. PR hacia `develop` y revisión.

## Commits

- **Atómicos**: un cambio lógico por commit.
- **Conventional Commits en español**, máx. ~77 caracteres: `tipo(alcance): descripción`.
- Tipos: `feat`, `fix`, `docs`, `style`, `refactor`, `perf`, `test`, `chore`, `revert`.
- Ejemplo: `docs(git): documentar workflow de ramas`.
- **Sin trailers automáticos** `Co-authored-by` ni firmas de herramientas/IA; verificar el mensaje tras cada commit.

## Tags y releases

- Tag histórico: `baseline-production-2026-10-03`.
- Releases con semantic versioning (`v1.0.0`) sobre `main`, y `CHANGELOG.md` actualizado.

## Deploy (futuro)

Se hará únicamente desde `main` o desde un tag. Nunca desde ramas de feature.

## Reglas de seguridad del historial

- No force push, salvo recuperación explícita y acordada.
- No reescribir historial de `main`, `develop` ni `production-baseline`.
- Normalización de saltos de línea (`.gitattributes`) es una tarea separada.
