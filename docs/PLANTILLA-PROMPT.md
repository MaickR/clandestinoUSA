# Plantilla de prompts — The Clandestino USA

Esta es tu propia estructura de 8 bloques (guardada como estándar personal), adaptada para Copilot Pro en modo agente sobre este proyecto específico. Como `AGENTS.md` ya se lee automáticamente en cada mensaje, **no repitas rol/stack/convenciones generales** — esos bloques solo llevan contenido cuando hay algo específico de la tarea que decir.

## Plantilla corta (tareas normales — la mayoría)

```
CONTEXTO
Archivos: @file:<ruta1> @file:<ruta2>   (solo lectura: @file:<ruta3>)

OBJETIVO
<una frase, qué debe quedar resuelto>

DIAGNÓSTICO OBLIGATORIO
Antes de escribir código, muéstrame tu plan paso a paso y espera mi confirmación.

ACCIÓN REQUERIDA
1. ...
2. ...

RESTRICCIONES (solo lo específico de esta tarea — lo general ya está en AGENTS.md)
- No toques: <archivo/sección fuera de alcance>
- No instales dependencias nuevas sin decírmelo primero

CRITERIO DE ACEPTACIÓN
Se considera terminado cuando: <qué abrir, qué probar, qué se debe ver>
```

## Plantilla completa (features nuevas y complejas — úsala con `/speckit.specify` de Spec Kit)

Agrega **ROL** (solo si la tarea exige una postura muy específica que AGENTS.md no cubre) y **PROBLEMA/OBJETIVO** desarrollado en vez de una frase, cuando el alcance es grande (ej. todo el sistema de gift cards, no un ajuste puntual).

## Cómo usarla en VS Code

- `@workspace` solo si de verdad necesitas que evalúe dependencias de todo el proyecto — para la mayoría de tareas de este proyecto, archivos puntuales con `@file` bastan y es más barato en tokens.
- Si el plan que muestra antes de escribir código se ve mal encaminado, cancela ahí mismo — no dejes que termine y corrijas después.

---

## Ejemplo 1 — confirmar que el pipeline de build compila limpio

```
CONTEXTO
Archivos: @file:gulpfile.mjs @file:package.json @file:assets/scss/main.scss (solo lectura: @file:docs/inventario-assets-actual.md)

OBJETIVO
Confirmar que `npm run dev` compila SCSS a CSS sin errores y que los colores/tipografías de _variables.scss llegan al CSS final.

DIAGNÓSTICO OBLIGATORIO
Antes de correr nada, dime qué esperas ver en assets/css/style.min.css y qué harás si falla la compilación.

ACCIÓN REQUERIDA
1. Correr `npm install` y reportar si falta alguna dependencia.
2. Correr `npm run dev` y compartir el resultado (éxito o el error exacto).
3. Si compila, abrir assets/css/style.min.css y confirmar que $cl-color-brand-gold y $cl-font-headings aparecen con los valores reales del inventario.

RESTRICCIONES
- No modifiques el gulpfile ni el package.json en esta tarea — solo diagnostica y reporta.

CRITERIO DE ACEPTACIÓN
Terminado cuando el build corre sin errores y confirmas, citando la línea del CSS generado, que los tokens de marca están aplicados.
```

## Ejemplo 2 — refactorizar Header + Nav + Hero del Home (código actual, no plantilla)

```
CONTEXTO
Archivos: @file:index.html @file:docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md (solo lectura: @file:docs/inventario-estructura-actual.md @file:docs/inventario-assets-actual.md)

OBJETIVO
Refactorizar el header, la navegación y el hero del Home actual: nueva estructura de menú (Inicio, Experiencias, Restaurante, Wine Shop, Gift Cards, Wine Club, Eventos, Reservar, Mi Cuenta), clases renombradas a BEM con prefijo cl-, y copy real en inglés ("Escape to Spain without leaving California", CTAs "Reserve a Table" / "Explore Wines").

DIAGNÓSTICO OBLIGATORIO
Usa la skill refactorizar-seccion-actual. Antes de tocar el HTML, muéstrame este plan y ESPERA MI CONFIRMACIÓN — no escribas código todavía:
a) Tabla de clases actuales → nuevo nombre cl-* (clase original, nombre nuevo, bloque BEM al que pertenece).
b) Dónde va cada link del nuevo menú.
c) Qué imagen/video real ya existe para el hero (revisar inventario-assets-actual.md) o qué placeholder con TODO se usará mientras Nicolás da el material.

ACCIÓN REQUERIDA (solo tras mi confirmación del plan)
1. Renombrar clases del header/nav/hero según la tabla del plan.
2. Reestructurar los links de navegación según el nuevo menú.
3. Reemplazar el copy del hero por el definido en el objetivo.
4. Verificar accesibilidad básica (labels, alt, foco visible) en lo tocado.

RESTRICCIONES
- No toques ninguna otra sección de la home en esta pasada.
- No agregues ningún framework de JS.
- No cambies ningún comportamiento funcional que ya exista (ej. si el nav tiene JS de scroll o submenu funcionando, se preserva su comportamiento).

CRITERIO DE ACEPTACIÓN
Terminado cuando: un grep de las clases viejas listadas en el plan sobre el archivo tocado devuelve 0 resultados, el menú coincide exactamente con el listado del objetivo, y me dices qué revisar en el navegador (viewport 375px, 768px, 1280px).
```
