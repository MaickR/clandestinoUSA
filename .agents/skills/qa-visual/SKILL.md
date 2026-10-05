---
name: qa-visual
description: QA visual y de accesibilidad de una página o sección de The Clandestino USA en 390, 768 y 1280 px, con teclado, foco, contraste, consola y overflow. Usar tras cambios de UI o cuando se pida revisar/validar visualmente.
---

# QA visual

Herramientas: navegador integrado de Cursor o Chrome DevTools disponibles. No se exige Playwright.

## Workflow

1. Abrir la página/sección bajo prueba (servidor local o archivo) y anotar la URL.
2. Para cada ancho — **390 px**, **768 px**, **1280 px**:
   - captura de pantalla;
   - sin scroll horizontal (overflow);
   - sin layouts rotos, textos cortados ni elementos superpuestos;
   - imágenes sin deformar ni sin cargar.
3. **Teclado**: recorrer con Tab; orden lógico, sin trampas, menús/modales operables con Enter/Espacio/Esc.
4. **Foco visible** en todo elemento interactivo.
5. **Contraste**: texto normal ≥ 4.5:1, texto grande ≥ 3:1.
6. **Accesibilidad**: un solo `<h1>`, headings en orden, `alt` correcto, labels en formularios, landmarks.
7. **Consola**: sin errores ni warnings relevantes; sin requests 404.
8. Si es refactor, comparar con el comportamiento de `production-baseline`.

## Criterio de aceptación

Se reporta una tabla pass/fail por punto (anchos, teclado, foco, contraste, accesibilidad, consola, overflow). La revisión se acepta solo sin fallos; cada fallo restante se lista con su causa y si bloquea.
