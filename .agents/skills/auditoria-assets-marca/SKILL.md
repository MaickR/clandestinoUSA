---
name: auditoria-assets-marca
description: Extrae e inventaría colores, tipografías, imágenes y estilos del sitio actual de The Clandestino USA para poder centralizarlos en variables SCSS durante el refactor. Usar antes de tocar cualquier página, o cuando se pida "auditar assets", "extraer estilos" o "inventario de marca".
---

# Auditoría de assets de marca — sitio actual

Esta skill se invoca en modo agente sobre el repositorio actual (`MaickR/clandestinoUSA`, HTML/CSS/JS/PHP), **antes** de empezar el refactor hacia SCSS/BEM/Bootstrap real. El resultado alimenta las variables de `assets/scss/abstracts/_variables.scss`.

## 1. ROL

Actúas como auditor de front-end especializado en extracción de design tokens. No modificas ningún archivo en esta skill — solo lees, inventarías y reportas.

## 2. CONTEXTO

El repo actual es el sitio en producción de theclandestinousa.com. Tiene HTML, CSS y JS con estilos ya definidos (colores de marca, tipografías, botones, tarjetas, imágenes del restaurante). Vamos a refactorizar ese mismo código hacia SCSS/BEM/Bootstrap real, y esos assets de marca deben sobrevivir o mejorarse (unificar tonos casi iguales, optimizar imágenes pesadas), nunca perderse ni reemplazarse por algo genérico.

## 3. PROBLEMA / OBJETIVO

Producir un inventario completo y verificable de: paleta de colores en uso, tipografías (familia, pesos, tamaños), botones y sus estados, tarjetas/componentes repetidos, imágenes y su formato/peso actual, iconografía, y cualquier animación o transición ya presente.

## 4. DIAGNÓSTICO OBLIGATORIO (investigar antes de tocar nada)

- Recorre todos los archivos `.css`/`.scss` del repo y lista cada valor de color (hex/rgb/hsl) con la cantidad de veces que aparece y en qué selector.
- Recorre el HTML y extrae qué fuentes están cargadas (`@font-face`, Google Fonts, etc.) y en qué elementos se usan.
- Lista todas las imágenes en `/assets` o carpeta equivalente: nombre, formato actual (jpg/png/webp), peso en KB, dimensiones, y en qué página/sección se usan.
- Identifica los componentes visuales que se repiten (botones, tarjetas de producto, badges, íconos) y describe sus estilos actuales (bordes, sombras, radios, espaciado).
- Señala inconsistencias: colores casi iguales pero no idénticos, mismo componente con estilos ligeramente distintos en páginas diferentes.

## 5. ACCIÓN REQUERIDA

Genera un archivo `docs/inventario-assets-actual.md` con:
1. Tabla de paleta de colores (valor hex, nombre semántico sugerido en español, dónde se usa).
2. Tabla de tipografías (familia, pesos disponibles, tamaños en uso, dónde se usa).
3. Tabla de imágenes (archivo, formato, peso, dimensiones, ubicación, candidata a convertir a WebP/AVIF sí/no).
4. Lista de componentes repetidos con su estilo actual resumido.
5. Sección "Inconsistencias detectadas".
6. Sección "Recomendación de variables SCSS": para cada color/tipografía/componente, sugerir con qué variable SCSS de `abstracts/_variables.scss` se debería representar.

## 6. RESTRICCIONES

- No modifiques ningún archivo de código fuente en esta skill — es de solo lectura y reporte.
- No inventes valores: si un color o fuente no se puede determinar con certeza desde el código, repórtalo como "no determinado" en vez de asumir uno.
- Esta skill es solo sobre el sitio actual — no propongas todavía cómo quedará cada sección refactorizada, eso lo hace refactorizar-seccion-actual.

## 7. VALIDACIÓN OBLIGATORIA

Antes de entregar el reporte, verifica que cada color y fuente listada aparece literalmente en al menos un archivo del repo (cita el archivo y la línea), y que el conteo de imágenes coincide con lo que hay en el directorio de assets.

## 8. CRITERIO DE ACEPTACIÓN + ENTREGA FINAL

- `docs/inventario-assets-actual.md` existe y cada valor reportado es trazable a un archivo/línea real.
- Ningún archivo de código fue modificado.
- Entrega final: ruta del archivo generado + resumen de 3-5 líneas con los hallazgos más relevantes (ej. "hay 4 tonos de rojo casi idénticos que deberían unificarse en una sola variable").
