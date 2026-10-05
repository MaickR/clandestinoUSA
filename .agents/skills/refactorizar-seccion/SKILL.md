---
name: refactorizar-seccion
description: Refactoriza una sección o página existente de The Clandestino USA hacia los estándares del proyecto (BEM con prefijo cl-, SCSS, componentes data-bs-*, accesibilidad) preservando el comportamiento legacy. Usar cuando se pida "refactoriza esta sección", "migra esto a BEM/SCSS" o similar.
---

# Refactorizar una sección existente

## Pasos

1. **Inspeccionar solo el scope pedido** (sección/página indicada). No explorar ni tocar otras.
2. **Identificar el comportamiento legacy**: markup, CSS, JS y PHP actuales; contrastar con `production-baseline` si hay duda. Consultar `docs/LEGACY-UI-INVENTORY.md` para las clases y componentes existentes.
3. **Mapear clases legacy → BEM `cl-*`** (`cl-bloque__elemento--modificador`). Dejar el mapeo explícito en la respuesta.
4. **Preservar el comportamiento** (copy, flujos, formularios) salvo indicación contraria. Es refactor, no reescritura.
5. **Modificar únicamente el scope pedido.** Si surge algo fuera de alcance, anotarlo, no arreglarlo.
6. **Usar Bootstrap** (`data-bs-*`) donde reemplace JS propio equivalente; si se mantiene lógica propia, documentar por qué.
7. **Verificar responsive y accesibilidad** con la skill `qa-visual`.
8. **Cutover de CSS legacy** solo cuando la estrategia de migración de la página lo permita (ver `docs/ARQUITECTURA.md`): no cargar `style.css` y `style.new.css` indiscriminadamente juntos, ni dejar la página a medias.

## Restricciones

- Sin frameworks JS nuevos ni dependencias sin justificar.
- PHP: no reescribir desde cero; si se toca, aplicar `.cursor/rules/php-security.mdc` y estructura proporcional.
- Máximo 3 niveles de nesting en SCSS.

## Criterio de aceptación

- Ninguna clase legacy restante en el markup refactorizado, salvo las que el cutover aún requiera (listadas).
- Comportamiento idéntico al de `production-baseline` en 390, 768 y 1280 px.
- `qa-visual` ejecutada con resultado explícito.
- Se indica qué abrir y qué comprobar manualmente.
