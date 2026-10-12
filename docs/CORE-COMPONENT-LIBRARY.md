# Core Component Library — UI-CORE-02

Biblioteca genérica entre Foundation y Pattern Library. No migra páginas, procesa reservas ni implementa carrito, cuenta o pagos. La aprobación visual humana permanece pendiente; compilar y pasar las verificaciones no autoriza un merge.

## Base y alcance

Rama `feature/ui-core-components`, desde `develop` en `b21b9d5e00f6ca08ca990f1f16fc47200305c205`, que contiene la foundation aprobada. Se conservan tokens, tipografía, superficies, grid y accesibilidad base.

| Componente | Contrato y estados |
|---|---|
| `cl-icon` | SVG local, `currentColor`, decorativo con `aria-hidden="true"` y `focusable="false"` |
| `cl-boton-icono` | Botón para acción, enlace para navegación; nombre en el control; 2.75rem; hover, foco, active y disabled nativo |
| `cl-alerta` | Información, éxito, aviso y error; mensaje textual, sin live role automático |
| `cl-estado` | Texto estático: Available, Sold out, Limited, Members only, New; sin roles interactivos |
| `cl-notificacion` | Bootstrap Toast; rutina polite, urgencia assertive; cierre accesible |
| `cl-modal` | Bootstrap Modal; normal/confirmación; nombre, Esc, backdrop, trap, scroll lock y retorno de foco |
| `cl-acordeon` | Bootstrap Collapse; botón, IDs, aria-expanded; cerrado/abierto |
| Formularios | Required, ayuda, error, éxito comprobado, readonly, disabled, checkbox, radio, fieldset/legend y espera |
| `cl-boton--con-carga` | Etiquetas superpuestas para reservar tamaño; `--cargando`, aria-busy y bloqueo efectivo de activaciones |
| `cl-cantidad` | Number input nativo, min/max/step y botones; validez, límites y restauración de entrada inválida |
| `cl-spinner` / `cl-skeleton` | Espera con dimensiones reservadas; skeleton decorativo y sin shimmer |
| `cl-estado-vista` | Vacío/error: heading, explicación y acción opcional |
| `cl-migas` | Nav nombrado, lista ordenada, aria-current y separadores decorativos; wrap móvil |

No se fabrican hover/focus/loading para etiquetas estáticas. Success/error de una operación se comunican en contexto mediante feedback, no con estados decorativos adicionales del botón.

## Iconografía y artefactos

`bootstrap-icons@1.13.1`, consultado en npm e instalado como devDependency exacta. La licencia MIT se conserva en `assets/icons/LICENCIA-bootstrap-icons.txt`.

`scripts/iconos.json` es una lista de 25 mapas `nombre`/`archivo`. Una lista permite detectar nombres duplicados, a diferencia de un objeto JSON con claves repetidas. Solo se aceptan identificadores simples; no rutas externas.

`scripts/generar-iconos.mjs` exporta `generarIconos`, `validarManifiesto` y `crearSimbolo`; también funciona como CLI con `npm run icons`. Lee exclusivamente `node_modules/bootstrap-icons/icons/*.svg`, conserva viewBox y geometría, omite las clases bi y produce `assets/icons/cl-iconos.svg` con IDs `cl-icon-*`. Orden ASCII estable, LF y sin timestamps.

La transformación valida el formato concreto de los SVG seleccionados. No es un parser ni un sanitizador de SVG de terceros. Si el paquete cambia de estructura, el generador debe fallar y revisarse antes de actualizarlo.

El sprite es output ignorado por Git. Tanto dev como build lo generan siempre antes de compilar. **Todo futuro paquete de release deberá incluir el sprite generado**, junto al CSS/JS de producto. Aquí no se define deployment.

```html
<button class="cl-boton-icono" type="button" aria-label="Close notification">
  <svg class="cl-icon" aria-hidden="true" focusable="false">
    <use href="/assets/icons/cl-iconos.svg#cl-icon-cerrar"></use>
  </svg>
</button>
```

## CSS y JavaScript

`main.scss` importa la mecánica Sass `transitions`, `modal`, `toasts` y los componentes BEM propios. No importa componentes visuales Bootstrap adicionales. `style-guide.scss` conserva la presentación de demos como única hoja separada; `main.scss` no importa `_guia.scss`.

`assets/js/main.js` permanece sin imports Core. Su output productivo no aumenta. `assets/js/style-guide.js` importa demos y los seis módulos reutilizables de `modules/core/`:

- `modal.js`: `inicializarModal(elemento, { focoInicial })` → `abrir(activador)`, `cerrar()`.
- `notificacion.js`: `inicializarNotificaciones(contenedor, { regionRutina, regionUrgente })` → `mostrar(opciones)`.
- `acordeon.js`: `inicializarAcordeon(panel)` → instancia Collapse, sin toggle inicial.
- `alerta.js`: `crearAlerta({ mensaje, titulo, variante })` → elemento estático.
- `boton-carga.js`: `inicializarBotonCarga(boton)` → `establecerCarga(boolean)`.
- `cantidad.js`: `inicializarCantidad(elemento)` → `actualizar()` para cambios externos de disabled/límites.

Los inicializadores son idempotentes mediante WeakMap o `getOrCreateInstance`. Los módulos Core reciben elementos del DOM; no conocen IDs ni rutas de la guía. No hay barrel ni módulos JS para componentes CSS-only.

Imports individuales probados con Bootstrap 5.3.8 y esbuild:

```js
import Modal from "bootstrap/js/src/modal.js";
import Toast from "bootstrap/js/src/toast.js";
import Collapse from "bootstrap/js/src/collapse.js";
```

No se importa Bootstrap completo, Popper o jQuery. Las utilidades internas de Bootstrap se comparten dentro del bundle de la guía.

Gulp genera `dist/main.js` siempre y `dist/style-guide.js` únicamente en dev. Build limpia los assets previos de guía y no los vuelve a generar. Watch cubre entradas JS, módulos, PHP de guía, manifiesto y generador. El generador se recarga al cambiar su fuente. ESLint cubre la nueva entrada; Stylelint mantiene sus reglas.

## Contratos de interacción y seguridad

Mensajes y títulos son strings; variantes cerradas: informacion, exito, aviso, error. Las APIs no admiten HTML, SVG, selectores o URLs arbitrarios. Se utiliza textContent/createElement. La API actual de notificación no incorpora acciones de negocio ni URLs.

Toast recibe opcionalmente `urgente`, `persistente` y `activador` existente. Rutina breve: ocho segundos, con pausa de Bootstrap durante hover/foco. Urgencia e información persistente: cierre manual. Regiones live preexistentes y separadas de los toasts visuales evitan anunciar también los controles de cierre. Una notificación no roba foco; si se cierra desde su control, lo devuelve al activador conectado. La guía limita tres simultáneas mediante un guard y aria-disabled efectivo, sin expulsiones ni cola.

Los errores de operaciones reales deberán tener también feedback persistente en contexto. Toast no sustituye validación ni recuperación transaccional.

Modal conserva la mecánica de Bootstrap. La apertura programática recibe el activador; al cerrar se devuelve foco si sigue conectado y visible. El foco inicial pertenece al modal; en confirmación se elige Keep item. No hay modales anidados. En la guía los modales preceden al contenido principal, con controles enfocables antes/después: esto permite que el focus trap de Bootstrap intercepte el recorrido circular incluso en los extremos del documento, sin handlers de teclado propios. Las páginas futuras deberán verificar el mismo recorrido.

Accordion utiliza botones y data-bs-*. Tab/Shift+Tab recorren controles; Enter/Space operan. No implementa navegación opcional con flechas, Home/End. Readonly solo se aplica a inputs/textarea que lo soportan. Checkbox/radio son nativos; required combina atributo y texto visible. Mensajes se asocian con aria-describedby; error utiliza aria-invalid.

Cantidad usa stepUp/stepDown y checkValidity, incluido un input clonado para comprobar si existe un paso válido. Durante una entrada inválida deshabilita los botones y muestra error; al confirmar el cambio restaura el último valor válido. No hace aritmética decimal propia, cálculos de precio ni requests.

Loading conserva el foco y utiliza aria-disabled con bloqueo en captura del evento click; teclado nativo sigue generando el click que se bloquea. Un estado repetido no reinicia la carga. El consumidor conserva la responsabilidad de terminar la operación y actualizar el feedback. Las demos simulan espera local de 2.2 segundos y no hacen fetch ni POST.

## Accesibilidad y revisión

Texto normal ≥4.5:1, elementos esenciales de controles y foco ≥3:1; icono/color acompañan texto. La foundation conserva foco de 2px con offset y reducción de movimiento. Reduced motion cancela transiciones y deja una sola vuelta de spinner de 0.01ms; texto de espera permanece. Skeleton no tiene animación.

La guía presenta 21 secciones, desde Foundations hasta Accessibility states, en el orden acordado. Todos los ejemplos visibles están en inglés y tienen contexto gastronómico. La ruta sigue bloqueada en Apache por `.htaccess`; PHP local permite su revisión.

Verificación técnica: `npm run icons`, `npm run lint`, `npm run build`, `php -l style-guide/index.php`, `npm run dev`. Revisión manual en `http://localhost:3000/style-guide/`, a 390, 768 y 1280 px, con teclado y capturas mediante la skill qa-visual.

### Registro técnico

Verificado el 2026-10-05. La aprobación visual humana sigue pendiente y no se autoriza merge, PR ni deploy con este registro.

| Comprobación | Resultado |
|---|---|
| npm run icons | PASS: 25 símbolos locales |
| Determinismo | PASS: dos ejecuciones, mismos bytes |
| Casos inválidos | PASS: duplicado, manifiesto no-lista, nombre no-string, ruta inválida, SVG inesperado y archivo inexistente; fixture restaurado |
| npm run lint | PASS: cero errores, sin relajar reglas |
| npm run build | PASS: sprite, CSS Core y main.js; sin CSS/JS de guía |
| php -l style-guide/index.php | PASS |
| npm run dev | PASS: PHP, BrowserSync y watch en localhost:3000 |
| HTTP local | PASS: guía, CSS producto/guía, JS guía y sprite responden 200 |
| 390 / 768 / 1280 px | PASS: capturas completas y de componentes; sin overflow ni controles fuera del viewport |
| Teclado/foco | PASS: Tab, Shift+Tab, Enter, Space y Esc según componente; anillo visible |
| Modal | PASS: nombre, foco inicial, ciclo de foco, Esc, backdrop, scroll lock y retorno; confirmación programática operable |
| Accordion | PASS: Enter/Space, Tab/Shift+Tab, aria-expanded coherente |
| Quantity | PASS: botones, edición nativa, máximo y restauración del último valor válido |
| Formularios | PASS: readonly/disabled diferenciados; checkbox con Space y radio con flechas; labels asociados |
| Loading | PASS: botón móvil mantiene 351 × 44 px; aria-busy y bloqueo de activaciones duplicadas |
| Toast | PASS: polite/assertive, persistencia, límite de guía y cierre accesible; mostrar no mueve foco |
| Contraste | PASS: 56 elementos/combinaciones resueltos; mínimo observado 6.13:1, sin fallos de texto |
| Reduced motion | PASS en CSS compilado: duración 0.01ms, una iteración y transiciones reducidas; skeleton estático |
| Semántica | PASS: un h1, 21 secciones, labels completos, SVG decorativos y breadcrumb actual |
| Consola navegador | PASS: sin errores/warnings relevantes observados |
| Protección legacy | PASS: sin cambios en CSS/JS legacy, HTML/PHP productivo, sitemap, imágenes ni .htaccess |

SHA-256 del sprite: `0f857ab676235793ea38903cbad5a7c314e53ed611618310779ba5cd4fa682d1`.

| Artefacto | Bytes gzip | KiB gzip |
|---|---:|---:|
| Foundation CSS antes | 7162 | 6.99 |
| CSS producto completo después | 9707 | 9.48 |
| Incremento CSS Core | 2545 | 2.49 |
| Sprite | 3761 | 3.67 |
| JS guía DEV servido | 14142 | 13.81 |
| JS guía minificado en memoria, solo medición | 9934 | 9.70 |

Main.js productivo: cero bytes antes/después; comparación byte a byte idéntica, incremento Core = 0. Se verificó el metafile de esbuild: Modal, Toast y Collapse individuales, sin Popper ni jQuery. El bundle de guía minificado se midió sin escribirlo como artefacto de build.

Evidencias locales fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/10/05/01a10df6-95eb-7b73-b3d3-29e39a913538/core-*` (capturas completas 390/768/1280 y vistas de modal, toast, loading, feedback y formularios).

Límites de la revisión: el navegador integrado no expone emulación de prefers-reduced-motion; se verificó su cascada compilada, sin cambiar preferencias del sistema. Se revisó el árbol accesible, sin prueba auditiva con lector de pantalla. QA realizada en el navegador Chromium integrado; Firefox/Safari no se ejecutaron en esta sesión. El servidor de desarrollo emite una advertencia de dependencia BrowserSync sobre util._extend en Node 24; no afecta a la guía ni al build.

### Inventario exacto de archivos

Crear:

```text
assets/icons/LICENCIA-bootstrap-icons.txt
assets/js/style-guide.js
assets/js/modules/core/alerta.js
assets/js/modules/core/acordeon.js
assets/js/modules/core/boton-carga.js
assets/js/modules/core/cantidad.js
assets/js/modules/core/modal.js
assets/js/modules/core/notificacion.js
assets/scss/components/_icon.scss
assets/scss/components/_boton-icono.scss
assets/scss/components/_alerta.scss
assets/scss/components/_estado.scss
assets/scss/components/_notificacion.scss
assets/scss/components/_modal.scss
assets/scss/components/_acordeon.scss
assets/scss/components/_cantidad.scss
assets/scss/components/_spinner.scss
assets/scss/components/_skeleton.scss
assets/scss/components/_estado-vista.scss
assets/scss/components/_migas.scss
scripts/iconos.json
scripts/generar-iconos.mjs
docs/CORE-COMPONENT-LIBRARY.md
```

Modificar:

```text
.gitignore
README.md
assets/scss/main.scss
assets/scss/components/_button.scss
assets/scss/components/_form.scss
assets/scss/components/_guia.scss
docs/ARQUITECTURA.md
docs/ESTANDARES-DE-CODIGO.md
eslint.config.mjs
gulpfile.mjs
package.json
package-lock.json
style-guide/index.php
```

Eliminar: ninguno. Tokens/base, main.js fuente, style-guide.scss y CHANGELOG.md se conservan. CHANGELOG no tenía sección Unreleased; no se declara release productiva.
