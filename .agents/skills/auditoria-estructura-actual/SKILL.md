---
name: auditoria-estructura-actual
description: Inventaría todas las páginas, secciones y convenciones de código del proyecto actual de The Clandestino USA (HTML/CSS/JS/PHP en producción) antes de empezar a refactorizar. Usar como primer paso obligatorio antes de tocar cualquier página, o cuando se pida "auditar la estructura", "qué tiene el proyecto" o "inventario de páginas".
---

# Auditoría de estructura actual — páginas, secciones y convenciones

Esta skill se corre **antes** de tocar cualquier código de refactorización. Complementa a `auditoria-assets-marca` (que ya cubrió colores/tipografías/imágenes en `docs/inventario-assets-actual.md`) — esta se enfoca en páginas, secciones y calidad/convenciones del código existente.

## 1. ROL

Actúas como auditor de arquitectura frontend/backend. Solo lees e inventarías — no modificas nada en esta skill.

## 2. CONTEXTO

El proyecto tiene páginas HTML/PHP ya en producción (según el inventario de assets ya se detectaron al menos: `index`, `about`, `contact` + `contact.php`, `menu`, `hampers`, `policies`, `swc`, `tapas`, `wines`, `links`). Antes de refactorizar hacia las convenciones de `docs/ESTANDARES-DE-CODIGO.md`, hay que saber exactamente qué hay hoy: qué secciones tiene cada página, qué tan cerca o lejos está el código actual de BEM/Bootstrap real/PSR-12, y qué lógica PHP ya existe (ej. el sistema de reservas).

## 3. PROBLEMA / OBJETIVO

Producir un inventario de: todas las páginas del sitio con sus secciones internas en orden, componentes repetidos entre páginas, uso actual de Bootstrap (¿grid real o solo clases sueltas?, ¿usa `data-bs-*` para componentes JS o hay JS propio duplicando esa función?), estructura de las clases CSS actuales (¿hay algo de BEM ya, o son nombres sueltos?), y qué archivos/lógica PHP existen más allá de `contact.php` (especialmente el sistema de reservas mencionado).

## 4. DIAGNÓSTICO OBLIGATORIO

- Lista cada archivo `.html`/`.php` de nivel superior y, para cada uno, las secciones que contiene en orden (usa los headings y los comentarios/IDs existentes como guía).
- Identifica qué páginas comparten header/nav/footer y si están duplicados por página o incluidos desde un solo lugar (`include`/`require` en PHP).
- Revisa si el proyecto ya usa el JS de Bootstrap (busca `data-bs-toggle`, `data-bs-target`, etc.) o si hay JS propio reimplementando modal/dropdown/carousel a mano.
- Revisa la nomenclatura de clases CSS actuales (cita ejemplos reales) y compárala contra el patrón BEM + prefijo `cl-` objetivo.
- Busca toda la lógica PHP existente más allá de `contact.php` — en particular el motor de reservas que ya existe — y describe qué hace, qué inputs recibe, dónde guarda los datos (¿archivo, base de datos, email?).
- Señala qué tan lejos está el CSS actual de SCSS con patrón 7-1 (¿es un solo archivo? ¿está minificado? ¿usa `:root` con variables ya, como se vio en el inventario de assets?).

## 5. ACCIÓN REQUERIDA

Genera `docs/inventario-estructura-actual.md` con:
1. Tabla de páginas (archivo, secciones internas en orden, comparte header/nav/footer con las demás sí/no).
2. Lista de componentes repetidos entre páginas (nav, hero, cards, forms, footer) con su clase actual.
3. Estado del uso de Bootstrap: ¿grid real?, ¿componentes JS vía `data-bs-*`?, ejemplos citados con archivo/línea.
4. Estado de la nomenclatura CSS actual vs. el objetivo BEM + `cl-`.
5. Inventario de lógica PHP existente (especialmente el sistema de reservas): qué archivos, qué hace, qué tan reutilizable es tal cual.
6. Sección "Brecha con el objetivo": lista concreta de lo que falta para llegar al patrón 7-1 SCSS + PSR-12 + capas.

## 6. RESTRICCIONES

- No modifiques ningún archivo en esta skill — es de solo lectura y reporte.
- No asumas contenido de un archivo que no puedas leer completo — repórtalo como "pendiente de revisar" en vez de inventar.

## 7. VALIDACIÓN OBLIGATORIA

Cada sección y componente citado debe venir de un archivo real del repo (cita archivo/línea). El inventario de páginas debe coincidir con los archivos `.html`/`.php` que realmente existen en la raíz del proyecto.

## 8. CRITERIO DE ACEPTACIÓN + ENTREGA FINAL

- `docs/inventario-estructura-actual.md` existe, cada afirmación es trazable a un archivo real, ningún archivo de código fue modificado.
- Entrega final: ruta del archivo generado + resumen de 3-5 líneas con los hallazgos que más van a afectar el orden de refactorización (ej. "el sistema de reservas ya funciona con envío por email, se puede adaptar sin rehacer la lógica" o "el header está duplicado en las 9 páginas, conviene unificarlo en un include antes de tocar el nav").
