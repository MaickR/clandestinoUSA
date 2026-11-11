# Git Workflow — The Clandestino USA

## Ramas

| Rama | Rol |
|---|---|
| `master` | Legacy congelado. No es autoridad sobre producción. No se hace merge de ella; solo se consulta con `git show origin/master:<ruta>`. |
| `production-baseline` | Snapshot histórico: autoridad sobre el comportamiento desplegado al iniciar el refactor. No se modifica. |
| `main` | Producción estable. Solo recibe PRs desde `develop`, `release/*` o `hotfix/*`. |
| `develop` | Integración. Base de las features. |
| `feature/*` | Nueva funcionalidad. Nace de `develop` y se propone hacia `develop`. |
| `docs/*` | Cambios documentales. Nace de `develop` y se propone hacia `develop`. |
| `fix/*` | Corrección no urgente. Nace de `develop`; PR hacia `develop`. |
| `hotfix/*` | Corrección urgente de producción. Nace de `main`; PR hacia `main` y luego se integra en `develop`. |
| `release/*` | **Opcional**. Solo si se necesita estabilizar un lanzamiento. |

El trabajo se realiza en la rama de la feature. `develop` se actualiza mediante fast-forward o integración revisada. Las demás ramas protegidas conservan el papel indicado en la tabla.

## Flujo de una feature

Antes de comenzar, revisar `git status`, preservar el trabajo y los archivos locales, ejecutar `git fetch origin` y sincronizar `develop` por fast-forward. Si diverge, registrar la diferencia antes de actuar. Crear la rama de trabajo desde la base verificada.

| Fase | Resultado esperado |
|---|---|
| A — Strategy & Content | [Definición comercial](MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md#definición-comercial-de-cada-página), secciones justificadas, CTA funcional, contenido y datos confirmados. |
| B — Art Direction | Referencias, layout, selección y encuadres de fotos y composición responsive según [dirección visual](VISUAL-DIRECTION.md). |
| C — Technical Design | Archivos permitidos, componentes reutilizados y consumidores, contratos, dependencias, riesgos y criterios de verificación. |
| D — Implementation | Código y pruebas que correspondan al alcance autorizado. Actualización de las fuentes documentales afectadas. |
| E — Acceptance | QA técnico, [regresión de Home cuando cambia el runtime](ESTANDARES-DE-CODIGO.md#regresión-mínima-de-home), corrección de defectos demostrados y revisión visual humana cuando aplica. Registrar cada resultado por separado. |
| F — Delivery | Commit y push autorizados. El asistente estratégico redacta el título y la descripción específicos a partir de los cambios reales. El propietario crea y fusiona el PR manualmente. |

Una feature coherente puede cubrir las seis fases en la misma rama y PR. Registrar las decisiones en sus fuentes vigentes o en la descripción de la feature. Usar la [plantilla de PR](../.github/PULL_REQUEST_TEMPLATE.md) como estructura de revisión para la descripción específica.

## Estrategia de merge de PRs

- PR con commits atómicos y limpios → preferir **Rebase and merge**.
- Rama con historial ruidoso o intermedio → **Squash and merge** cuando aporte claridad.
- Nunca reescribir `main`, `develop` ni `production-baseline`.
- No crear merge commits innecesarios en features normales.

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
- `.gitattributes` está activo: los archivos de texto se normalizan a LF; `.bat`, `.cmd` y `.ps1` usan CRLF.
- Al comparar equivalencia funcional contra `production-baseline` o `master`, usar `--ignore-cr-at-eol`.

## Limpieza segura de ramas fusionadas

Ejecutar solo con el alcance de limpieza autorizado. Actualizar las referencias remotas y comprobar el PR fusionado en su rama destino. Para un merge normal, confirmar que el tip de la rama es ancestro del destino actualizado. Para squash o rebase, comprobar en el PR qué cambios se integraron y que la rama carece de commits posteriores o trabajo exclusivo. Si hay duda, conservarla.

Confirmar que la rama no está activa en ningún worktree y que no tiene PR abierto ni consumidores pendientes. Proteger siempre `develop`, `main`, `master` y `production-baseline`. Usar `git branch -d` para la eliminación local cuando Git pueda verificar la integración. Si Git no la puede acreditar tras squash o rebase, dejar la rama para revisión explícita. La eliminación remota es una acción separada y solo se ejecuta si está autorizada.
