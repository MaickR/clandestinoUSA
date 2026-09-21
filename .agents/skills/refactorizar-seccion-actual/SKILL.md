---
name: refactorizar-seccion-actual
description: Toma una sección o página ya existente del sitio actual de The Clandestino USA y la refactoriza a los estándares del proyecto (BEM en español con prefijo cl-, migración a SCSS patrón 7-1, uso de componentes JS de Bootstrap vía data-bs-*, accesibilidad, PHP en capas donde aplique) sin cambiar su comportamiento salvo que se indique lo contrario. Usar cuando se pida "refactoriza esta sección", "migra esto a SCSS/BEM" o similar.
---

# Refactorizar una sección/página existente

Requiere haber corrido antes `auditoria-assets-marca` (`docs/inventario-assets-actual.md`) y `auditoria-estructura-actual` (`docs/inventario-estructura-actual.md`), y tener a mano `docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md` para saber en qué orden se está trabajando.

## Pasos

1. **Ubicar la sección** en `docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md` — confirmar que es el turno correcto según el orden de construcción pactado. Si se pide adelantar algo fuera de orden, preguntar antes de proceder.
2. **Renombrar clases**: la clase actual (ej. `hero-title`, `btn-primary`, `reservation-card`) pasa a BEM en español con prefijo `cl-` (`cl-hero__titulo`, `cl-boton--primario`, `cl-reserva__tarjeta`), siguiendo `.github/instructions/scss.instructions.md`.
3. **Migrar el CSS de esa sección a SCSS** dentro del patrón 7-1 (`assets/scss/components/` o `layout/` según corresponda) — no dejar la sección mitad en el CSS viejo, mitad en SCSS nuevo.
4. **Aprovechar Bootstrap real**: si la sección tiene un modal, dropdown, carousel o collapse hecho con JS propio, reemplazarlo por el componente nativo de Bootstrap vía `data-bs-toggle`/`data-bs-target` en vez de mantener JS duplicado — salvo que la lógica propia haga algo que Bootstrap no cubre, en cuyo caso se documenta por qué se mantiene.
5. **No inventar contenido nuevo**: esta skill preserva el copy/contenido real que ya existe, salvo que la tarea pida explícitamente cambiarlo (a diferencia de una migración de plantilla, aquí el contenido ya es el real de Nicolás).
6. **Accesibilidad**: revisar y corregir en lo tocado — un solo `<h1>` por página, `alt` descriptivo, labels en formularios, contraste AA, foco visible.
7. **PHP**: si la sección tiene lógica de servidor asociada (ej. el formulario de reservas), no reescribirla desde cero — moverla hacia la arquitectura en capas (`Controllers/Services/Repositories/Models`) preservando su comportamiento actual, con prepared statements y `htmlspecialchars()` donde falten.

## Restricciones

- No tocar ninguna otra sección/página fuera de la que se pidió en esta pasada.
- No agregar ningún framework de JS.
- No cambiar el comportamiento funcional de algo que ya funciona (ej. el envío de reservas) salvo que se pida explícitamente — esto es refactor, no reescritura.
- Máximo 3 niveles de anidación en SCSS.

## Criterio de aceptación

- Cero clases de nomenclatura vieja restantes en el archivo tocado (verificar con grep contra los nombres de clase documentados en `docs/inventario-estructura-actual.md` para esa sección).
- El CSS de la sección vive en SCSS dentro del patrón 7-1, no en el archivo CSS viejo.
- Si había JS propio duplicando un componente de Bootstrap, ahora usa `data-bs-*` (o se documentó por qué no).
- Se indica qué probar manualmente (qué abrir, en qué viewport, qué funcionalidad confirmar que sigue funcionando igual que antes).
