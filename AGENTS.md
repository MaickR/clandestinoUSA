# AGENTS.md — The Clandestino USA

Refactor incremental del sitio de un restaurante español en Mount Shasta, CA. Priorizamos recorridos que ayudan a descubrir y contratar experiencias. Home R1–R9 está aprobada localmente e integrada en `develop`. La publicación tiene su propia autorización y pendientes.

## Qué documento rige cada decisión

| Autoridad | Consultar |
|---|---|
| Instrucciones vigentes | Este archivo, [estándares de código](docs/ESTANDARES-DE-CODIGO.md) y [flujo Git](docs/GIT-WORKFLOW.md). Las reglas de editor y skills aplican dentro de este marco. |
| Arquitectura actual | [Arquitectura](docs/ARQUITECTURA.md). |
| Decisiones visuales expresamente aprobadas | [Dirección visual](docs/VISUAL-DIRECTION.md) y evidencia aprobada para la composición concreta. |
| Contratos de componentes | [Core](docs/CORE-COMPONENT-LIBRARY.md), [patrones](docs/SECTION-PATTERN-LIBRARY.md) y sus fuentes vigentes en `develop`. |
| Documentos históricos | [Aceptación de Home R9](docs/HOME-FINAL-ACCEPTANCE.md), inventarios y registros fechados. Acreditan decisiones y pruebas dentro de su alcance original. |
| Propuestas futuras | [Mapa del sitio](docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md). Requieren aprobación antes de entrar en el alcance de una feature. |

Ante una contradicción, identifica los textos y la decisión vigente por ámbito, contrástala con `develop` y registra la resolución en su fuente. Si falta una decisión o la fuente contradice un contrato aprobado, explicita la diferencia y eleva la decisión al responsable.

## Reglas transversales

- PHP 8 con plantillas compartidas, SCSS BEM `cl-`, Bootstrap 5 selectivo desde Sass, ES Modules, Gulp y esbuild. GSAP/ScrollTrigger en usos aprobados. Compatible con GoDaddy/cPanel. Sin React, Laravel, Tailwind, plantillas de terceros, bibliotecas ni pipelines paralelos.
- Reutilizar Foundation, Core y Waves 1–7. Aplicar DRY, KISS, YAGNI, Fail Fast y cambios quirúrgicos. Conservar tokens y contratos salvo necesidad demostrada. El Header compartido tiene una [excepción responsive propia](docs/ESTANDARES-DE-CODIGO.md#css--scss).
- Código, comentarios y documentación en español. Texto visible al visitante en inglés. Secretos por entorno y fuera de Git.
- Definir contenido, destino funcional y objetivo comercial antes de diseñar o programar. Los patrones y las demos se reutilizan según su contrato. La habilitación de servicios depende de datos, operación y validación propios.
- Declarar alcance y consumidores compartidos. Proteger las páginas aprobadas y contrastar cambios de página con `production-baseline`. Comparar con `develop` y aplicar el [contrato de regresión](docs/ESTANDARES-DE-CODIGO.md#protección-de-páginas-aprobadas) cuando se toque el runtime. La aprobación visual corresponde al responsable.
- Las features parten de `develop`. `main` es producción estable, `production-baseline` es la referencia histórica de producción y `master` está congelada. Trabajar en la rama de la feature. El responsable crea y fusiona los PR manualmente. Publicar desde `main` o un tag requiere autorización propia.
- Registrar cómo se verificó el alcance y qué queda pendiente. Actualizar la documentación afectada junto al cambio, con Conventional Commits en español cuando corresponda.
