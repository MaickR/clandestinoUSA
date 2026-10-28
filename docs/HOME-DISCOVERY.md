# Home Discovery — Apertura editorial

## Cierre aprobado — 2026-10-28

El responsable aprobó expresamente la versión visual y responsive final. Su composición queda congelada. Este cierre audita y publica `feature/home-discovery` para un PR manual hacia `develop`; no autoriza merge ni deploy. Los registros inferiores documentan iteraciones anteriores y sus restricciones históricas, sustituidas por esta decisión.

### Contrato integrado

`home-preview.php` incluye `includes/discovery.php` después del Hero y antes de Pure Soul, sustituyendo las inclusiones activas de Welcome y Spanish Table. Los partials originales permanecen en el repositorio. La Home pública `index.html` y Header/Hero/Pure Soul/Private Experiences/Footer no cambian.

Bienvenida y ornamento centrados, superficie oscura cálida, botánicos periféricos desde md, fotografías reales 3:4, una columna móvil y tres desde 768px; imagen central desplazada 24px desde md. Fotos móviles limitadas con `clamp(12rem, 60vw, 15rem)`; gutter desktop original desde lg. Títulos, descripciones y botones Core secundarios centrados y uniformes. Únicas rutas: `/wines.html`, `/tapas.html`, `/hampers.html`. Take Away se comunica como consulta.

No se añaden imágenes, derivados, dependencias, JavaScript, servicios comerciales ni tokens. Vinos y tapas consumen AVIF/WebP con fallback original; Hampers usa WebP. Las imágenes reservan dimensiones, proporción CSS, carga lazy y decoding async. El pequeño recorte lateral de tapas conserva el encuadre aprobado.

### Auditoría técnica del cierre

- PHP nativo: include con ruta literal basada en `__DIR__`; acceso directo al partial responde 404. El partial no acepta entrada de usuario ni construye rutas dinámicas; su contenido y URLs son literales, por lo que no existe interpolación externa que escapar.
- HTML: sección nombrada, h2 de bienvenida y h3 de categorías bajo el h1 de Home, artículos con nombres ARIA válidos, alt descriptivos y una única acción por propuesta.
- SCSS: bloque local aditivo; no cambia estilos de otras secciones. Bootstrap 5.3 aporta contenedor/mixins; Foundation/Core mantienen tipografía, botones, foco y tokens. Grid/subgrid coordinan alineaciones, sin alturas fijas de texto ni `!important`.
- Ornamento: `cl-seccion__encabezado--ornamentado` existe solo en la hoja Home, usa el SVG y acento existentes mediante pseudoelemento vacío. No introduce imports ni modifica los patrones/Core aprobados. Su contrato de uso selectivo consta en SECTION-PATTERN-LIBRARY.md.
- Compatibilidad: el código PHP no requiere servicios persistentes, base de datos ni cambios de Apache. Home Preview conserva deliberadamente su guard CLI-server: este PR prepara integración, no activa la Home pública en GoDaddy. `subgrid`, máscaras, clamp, aspect-ratio y overflow:clip requieren navegadores modernos; se comprueban en Chromium local, sin atribuir pruebas a Safari/Firefox o al hosting remoto.

### Verificaciones del cierre

Verificados en este cierre: npm run lint, npm run build, PHP lint de los dos archivos PHP afectados y git diff --check correctos. HTML estructural sin errores, 51 rutas/recursos válidos y 22 archivos protegidos idénticos a HEAD. Renderizado de 320, 360, 390, 425, 600, 768, 820, 992, 1024, 1280, 1440 y 2560px sin overflow; targets mínimos de 44px, foco Core de 2px, contraste mínimo de 11.39:1 y CLS local móvil 0. Fotos cargadas y navegación operativa sin JavaScript. Los hashes de SCSS, partial y Home Preview coinciden con el inicio de la auditoría. Se reutilizan las herramientas de QA externas al repositorio: no se incluyen prototipos, capturas ni scripts temporales en el commit.

No existe suite Node declarada ni archivos test/spec en el repositorio. Se comprueban main.js y generar-iconos.mjs con `node --check`, además de compilar con esbuild; esto no se presenta como una suite de tests.

Pendientes reales: crear el PR manual hacia develop y realizar las comprobaciones del entorno remoto antes de cualquier despliegue. La aprobación artística ya está concedida y no queda reabierta por esta auditoría. Los registros de laboratorio e iteraciones inferiores conservan su contexto histórico.


## Registro previo — coherencia editorial responsive, 2026-10-28

Esta corrección sustituye la adaptación responsive rechazada. Se conserva el concepto aprobado de Discovery; la implementación final sigue pendiente de revisión humana. Se eliminan el recorte cuadrado de vinos, las imágenes secundarias de 8rem y los layouts horizontales móviles/tablet. Fotografía, título, descripción y botón Core vuelven a ser una misma estructura en las tres propuestas, en orden vinos → tapas → hampers.

Móvil hasta 767.98px: una columna centrada. Las tres imágenes mantienen 3:4, con `max-inline-size: clamp(12rem, 60vw, 15rem)`: 192 × 256px a 320, 216 × 288 a 360, 234 × 312 a 390 y máximo 240 × 320. La imagen no ocupa automáticamente todo el teléfono. Se preservan fotografías, textos, Core y encuadres aprobados; tapas mantiene su ajuste lateral 48%. Se acepta el mayor recorrido respecto a la variante rechazada para conservar la presencia gastronómica de las tres categorías.

Tablet desde 768px: tres columnas con gap semántico de 16px, retratos de aproximadamente 221 × 295px en 768/820 y botones de 44px. La revisión de capturas confirma fotografía reconocible, título de tapas en dos líneas, descripciones sin truncamiento y botones con anchura suficiente. El breakpoint md se mantiene después de comprobar el contenido, no por obligación. `subgrid` coordina título, descripción y acción; tapas conserva el desplazamiento de 24px.

Desktop desde 992px: solo crece el gutter al valor aprobado de 48px. Las geometrías, estilos y encuadres medidos coinciden con el estado anterior en 992/1024/1280/1440/2560. No cambia el encabezado, ornamento champagne, botánicos, tipografía o superficie.

### Alturas y proporciones reales

Valores en px, viewport de 900px de alto. La distancia a Pure Soul cambia con la altura de Discovery, sin alterar esa sección.

| Ancho | Altura anterior | Altura nueva | Cada fotografía nueva |
|---|---:|---:|---|
| 320 | 1660.4 | 1782.3 | 192.0 × 256.0 |
| 360 | 1283.3 | 1781.3 | 216.0 × 288.0 |
| 390 | 1244.5 | 1824.4 | 234.0 × 312.0 |
| 425 | 1269.9 | 1848.4 | 240.0 × 320.0 |
| 600 | 1360.9 | 1823.7 | 240.0 × 320.0 |
| 768 | 1325.2 | 906.4 | 221.3 × 295.1 |
| 820 | 1328.5 | 909.7 | 221.3 × 295.1 |
| 992 | 974.3 | 974.3 | 280.0 × 373.3 |
| 1024 | 975.3 | 975.3 | 280.0 × 373.3 |
| 1280 | 1073.9 | 1073.9 | 340.0 × 453.3 |
| 1440 | 1110.7 | 1110.7 | 360.0 × 480.0 |
| 2560 | 1120.8 | 1120.8 | 360.0 × 480.0 |

### QA de esta corrección

| Punto | Estado | Evidencia |
|---|---|---|
| Doce anchuras solicitadas | PASS | Capturas antes/después, proporciones 3:4 comunes y orden coherente |
| Teclado y foco | PASS | Vinos → tapas → hampers, foco Core visible de 2px |
| Targets y contraste | PASS | Altura mínima 44px, contraste mínimo 11.39:1 |
| Overflow y accesibilidad | PASS | Sin overflow; HTML estructural sin errores, un h1, alt/dimensiones y referencias ARIA correctos |
| Recursos y consola | PASS | 51 rutas/recursos válidos, sin errores ni warnings de consola |
| Sin JavaScript | PASS | Cero scripts, mismas geometrías y fotografías cargadas en las doce anchuras |
| CLS local móvil | PASS | 0 en el recorrido de laboratorio; no equivale a dato de campo |
| Integridad | PASS | 22 archivos protegidos iguales a HEAD; partial, home-preview y SCSS exterior iguales a la copia inicial |
| Herramientas | PASS | Lint, build, PHP lint, comprobación sintáctica Node y diff check correctos |

No hay suite Node declarada ni test/spec en el repositorio. No cambia JavaScript: se verifica sintaxis de main.js y generar-iconos.mjs con Node, sin llamarlo suite de pruebas. Se modifican únicamente estilos locales de Discovery y esta documentación, sin tokens, componentes, fotos, copy o procesos comerciales nuevos. Reutilización: Grid/subgrid, mixins Bootstrap md/lg, clamp y tokens de espaciado.

Limitaciones: fotografías provisionales, comprobación local en Chromium y servidor PHP; sin verificación de hosting remoto ni medición de campo. Capturas y comparativas por ancho archivadas fuera del producto en `discovery-coherent` dentro del directorio de visualizaciones de la conversación. Sin commit, push, PR, merge ni deploy.


## Registro rechazado — adaptación responsive, 2026-10-28

Se conserva el concepto aprobado. Este encargo cambia exclusivamente los estilos responsive de Discovery y esta documentación; `includes/discovery.php` y `home-preview.php` mantienen sus bytes iniciales. También se verificó la integridad exacta del SCSS anterior y posterior a Discovery. El trabajo local previo permanece preservado en `feature/home-discovery`.

### Auditoría y decisiones

La secuencia anterior repetía tres retratos de 256 × 341 px en teléfono, con una sección de unos 1960 px a 390/425. En 768/820, la invitación de Hampers se limitaba a 576 px dentro de una galería de 688 px; su fotografía de 176 px perdía presencia. En 992, las tres columnas disponen de 280 px por imagen y conservan lectura y targets suficientes. Por eso se mantiene el paso desktop en `lg` (992 px), después de contrastarlo con el contenido real.

Móvil: vinos conserva la primera posición, título/relato/CTA centrados y una foto de hasta 18rem. Se probó 4:3, pero cortaba cápsulas y etiquetas; se eligió 1:1 con `object-position: center 55%`, retirando fondo superior y base sin perder la identificación de las cuatro botellas. La imagen resultante tiene hasta 288px de alto, frente a los 341px anteriores. No se cambian recursos, formatos, copy ni acciones.

Tapas y Hampers pasan a parejas horizontales desde 360px (`22.5rem`), con proporción de columnas 1 / 1.65, gap semántico, alineación de texto inicial y CTA Core próximo. A 359px y por debajo se apilan: las imágenes secundarias se limitan a 8rem, el texto permanece centrado y el CTA tiene espacio completo. Ese umbral se comprobó en 359/360, además de 320/390/425; no procede de un breakpoint Bootstrap añadido.

Tablet, entre `md` y `lg`: vinos y tapas permanecen en dos columnas con retratos amplios. Hampers ocupa toda la fila, en proporción 1 / 2 y con texto alineado al inicio. Su imagen crece a unos 221 × 295px. La sección gana unos 68px respecto al estado anterior: se acepta para evitar una tercera imagen diminuta y un bloque lateral descolgado. No hay altura fija.

Desktop desde 992px: se conservan las tres imágenes iguales 3:4, desplazamiento central de 24px, subgrid, encabezado, acciones, botánicos y espacios aprobados. Las coordenadas relativas, dimensiones y estilos medidos de todos los elementos de Discovery coinciden con la captura previa en 992/1024/1280/1440/2560. Se revisaron además las capturas antes/después; las diferencias residuales de raster en dos JPEG son inferiores al 0.22% de píxeles con tolerancia 8/255, sin cambio de geometría o encuadre.

### Medición del recorrido

Altura de Discovery, a viewport de 900px de alto y raíz de 16px. La distancia al comienzo de Pure Soul se reduce en la misma cantidad porque las secciones permanecen en flujo. Los valores negativos corresponden al espacio recuperado para la fotografía de Hampers en tablet.

| Ancho (px) | Antes (px) | Después (px) | Ahorro (px) | Reducción |
|---|---:|---:|---:|---:|
| 320 | 2086.3 | 1643.6 | 442.7 | 21.2% |
| 390 | 1960.4 | 1244.5 | 715.9 | 36.5% |
| 425 | 1960.4 | 1269.9 | 690.5 | 35.2% |
| 768 | 1257.7 | 1325.2 | -67.5 | -5.4% |
| 820 | 1260.9 | 1328.5 | -67.5 | -5.4% |
| 992 | 974.3 | 974.3 | 0.0 | 0.0% |
| 1024 | 975.3 | 975.3 | 0.0 | 0.0% |
| 1280 | 1073.9 | 1073.9 | 0.0 | 0.0% |
| 1440 | 1110.7 | 1110.7 | 0.0 | 0.0% |
| 2560 | 1120.8 | 1120.8 | 0.0 | 0.0% |

### QA vigente

| Comprobación | Resultado |
|---|---|
| Antes/después | Capturas reales a los diez anchos solicitados, incluyendo Hero y comienzo de Pure Soul |
| Responsive | Sin overflow, texto truncado ni imágenes rotas; transiciones comprobadas también en 359/360/767/991 |
| Teclado y foco | Vinos → tapas → hampers; contorno Core visible de 2px |
| Targets | Altura mínima 44px en todos los tamaños, con anchura suficiente para cada acción |
| Contraste | Mínimo medido 11.39:1; estilos y estados Core conservados |
| HTML y recursos | Validación estructural local sin errores; un h1, referencias ARIA y alt/dimensiones correctos; 51 rutas/recursos válidos |
| Sin JavaScript | Cero scripts en la vista de prueba: mismas geometrías e imágenes cargadas en los diez anchos |
| Consola y CLS | Sin errores/advertencias; CLS 0 en medición local móvil del recorrido |
| Integridad | 22 archivos protegidos iguales a HEAD; verificación local de partial, home-preview y SCSS exterior exacta |
| Herramientas | npm run lint, npm run build, PHP lint, node --check y git diff --check correctos |

No hay suite Node declarada ni archivos test/spec en el repositorio; no se añaden tests que reproduzcan CSS. Se comprueba la sintaxis de main.js y generar-iconos.mjs con Node. No se añade JS, librería, derivado fotográfico, token ni función comercial. Se reutilizan los mixins `media-breakpoint-up/down/only`, Grid/subgrid y `--espacio-4/5/6/7`, `--radio-md` y Core.

Evidencia y comparativas por ancho fuera del repositorio, en `discovery-responsive` dentro del directorio de visualizaciones de esta conversación. QA de laboratorio local, no certificación externa W3C ni medición de campo. Fotografías provisionales y hosting remoto sin verificar. La aprobación artística final corresponde al responsable. Sin commit, push, PR, merge ni deploy.


## Registro anterior — refinamiento de la galería editorial, 2026-10-27

El responsable aprueba expresamente el concepto de Discovery Editorial. Este refinamiento conserva la composición y queda pendiente de su revisión visual final; no atribuye aprobación a sus medidas ni compatibilidad remota verificada.

Las tres fotografías comparten ancho y proporción 3:4 en escritorio: 360 × 480 px a 1440 y 2560, 340 × 453.33 a 1280 y 280 × 373.33 a 1024. Las imágenes permanecen en Grid; la pieza central se desplaza 24 px sin alterar su tamaño. Se reserva espacio inferior para ese desplazamiento. Vinos y hampers conservan su encuadre completo; tapas recorta ligeramente los laterales, con `object-position: 48% center`. No se deforman originales.

`subgrid` coordina título, descripción y acción entre columnas. Las tres acciones usan exclusivamente `cl-boton cl-boton--secundario`, sin iconos ni presentación propia: ancho máximo 16rem, altura mínima Core de 44px, con sus estados existentes. Hay una única acción por producto, con los mismos destinos reales.

Móvil: una columna con imágenes de hasta 16rem, proporción 3:4 y relato centrado debajo. Tablet: vinos y tapas amplios en dos columnas; hampers horizontal debajo. Se preservan bienvenida, Libre Bodoni/sans, colores, botánicos y continuidad con las secciones vecinas. Los botánicos mantienen su recorte periférico y desaparecen en móvil.

El separador pasa al modificador `cl-seccion__encabezado--ornamentado`: pseudoelemento vacío del eyebrow, máscara SVG existente y acento semántico. Disponible actualmente en `home.css`; contrato y límites de extracción en [SECTION-PATTERN-LIBRARY.md](SECTION-PATTERN-LIBRARY.md#encabezado-ornamentado). No se modifica el SCSS de patrones aprobados ni se aplica a otras secciones.

### QA de este refinamiento

| Comprobación | Resultado |
|---|---|
| Comparativa antes/después | 390, 768 y 1440 px, recorrido Hero → Discovery → Pure Soul |
| Responsive | También 320, 425, 1024, 1280 y 2560 px; sin overflow ni imágenes rotas |
| Geometría | Las tres imágenes son iguales en cada anchura desktop; offset central 24px |
| Acciones | 256 × 44 px medidas en los ocho tamaños; orden lógico de teclado y foco Core de 2px |
| Contraste | Mínimo 11.39:1; botones secundarios conservan estados Core |
| HTML y recursos | Validación estructural local correcta; 51 rutas/recursos válidos; include aislado 404 |
| JavaScript y consola | Recorrido sin scripts funcional; sin errores ni advertencias de consola |
| CLS | 0 en medición local móvil; no es un dato de campo |
| Integridad | 22 archivos protegidos idénticos a HEAD; home-preview y SCSS ajeno a Discovery iguales a la copia inicial |
| Herramientas | Lint, build, PHP lint, comprobación sintáctica Node y diff check correctos |

No existe una suite Node dedicada a Discovery y no cambia su JavaScript. Se verifican main.js y generar-iconos.mjs con Node; no se presenta esa comprobación como una suite de pruebas. PHP/Apache en GoDaddy no se han verificado remotamente. Las fotografías y el fondo magenta de la cesta continúan provisionales. Sin nuevas dependencias, recursos, JS ni modificaciones comerciales. Sin commit, push, PR, merge ni deploy.


## Registro anterior — galería editorial contrastada con la captura, 2026-10-27

Se inspeccionó directamente la captura aportada por el responsable: bienvenida centrada, separador champagne, fotografías verticales, pieza central desplazada y botánicos periféricos. Se comparó con las capturas del prototipo aislado rechazado y con la nueva implementación. La composición conserva ese carácter e incorpora jerarquía comercial: vinos primero y de mayor tamaño, tapas en el centro y hampers con menor peso. No se atribuye aprobación artística a esta entrega.

La bienvenida usa el contenido solicitado. Las imágenes ahora forman una galería vertical escalonada, con títulos y pies centrados desde tablet. Se retiran los eyebrows redundantes de cada producto. Cada invitación conserva un único enlace Core hacia `/wines.html`, `/tapas.html` o `/hampers.html`. Take Away se presenta como consulta. No hay cuarto CTA ni superficies clicables adicionales.

Recursos existentes: `wines.jpeg` (1536 × 2048), `tapas.jpeg` (1695 × 2048, la fotografía de la referencia) y `hampers/basket-01.webp` (1536 × 2048). Vinos y tapas usan sus derivados AVIF/WebP existentes; no se generaron derivados ni se modificaron originales. `separator.svg`, `webp/shape-1.webp` y `webp/shape-2.webp` aportan el ornamento y los botánicos. Estos últimos se omiten en móvil para proteger el espacio del texto.

Desktop presenta tres proporciones diferentes con tapas desplazada hacia abajo. Tablet conserva vinos y tapas amplios en dos columnas y hampers horizontal debajo. Móvil mantiene el orden DOM vinos → tapas → hampers con fotografías laterales y relatos próximos. Se reutilizan `cl-seccion`, Foundation, Libre Bodoni/sans, enlaces y foco Core, tokens semánticos, `container`, `media-breakpoint-up(md/lg)` y Grid local. Sin dependencias, JavaScript ni CSS legacy.

### QA vigente

| Comprobación | Resultado |
|---|---|
| 320, 390, 425, 768, 1024, 1280, 1440 y 2560 px | Sin overflow; imágenes cargadas, revisión visual de proporciones y lectura |
| Teclado y foco | Orden vinos → tapas → hampers; contorno Core visible de 2 px |
| Contraste | Mínimo medido 11.39:1 sobre la superficie oscura |
| HTML estructural | Sin errores de cierre, IDs duplicados, referencias ARIA ausentes ni imágenes sin alt/dimensiones |
| Recursos y rutas | 51 enlaces/recursos locales válidos; include independiente responde 404 |
| Consola | Sin errores ni advertencias durante el recorrido |
| Sin JavaScript | Cero scripts en la vista de prueba; tres imágenes y enlaces operativos |
| CLS | 0 en la medición local móvil del recorrido; no es una medición de campo |
| Integridad | 22 archivos protegidos idénticos a HEAD; `home-preview.php` y SCSS ajeno a Discovery iguales a la copia de inicio |
| Herramientas | `npm run lint`, `npm run build`, PHP lint y `git diff --check` correctos; comprobación sintáctica con Node de main.js y generar-iconos.mjs |

El repositorio no declara una suite Node dedicada a Discovery; no se añaden tests que reproduzcan CSS o markup. La validación HTML es estructural local, no certificación externa W3C. Las fotografías son provisionales; la cesta conserva un fondo magenta que requerirá valoración en la revisión fotográfica final. Las capturas finales del recorrido Hero → Discovery → Pure Soul y los informes están fuera del repositorio en `editorial-reference` dentro del directorio de visualizaciones de esta conversación.

Solo se ajustan el partial, los estilos de Discovery y esta documentación. Se preserva el trabajo local previo; no commit, push, PR, merge ni deploy.

## Registro histórico — refinamiento comercial rechazado, 2026-10-27

Se continúa en `feature/home-discovery`, con todos los cambios locales anteriores preservados. La primera implementación B **no fue aprobada visualmente**. La instrucción actual selecciona una única evolución, The Clandestino Collection; este registro sustituye la composición y el QA vigentes descritos en el registro histórico inferior. La implementación refinada sigue pendiente de aprobación visual humana. Sin commit, push, PR, merge ni deploy.

### Jerarquía y composición

La bienvenida se reduce a `Welcome to our table`, `The Clandestino Collection` y una invitación breve que identifica vinos, tapas y regalos en Mount Shasta. No tiene acciones propias. Desde md, dos áreas sin tarjetas ni paneles comerciales comparten una retícula asimétrica 7/5: Spanish Wines con mayor escala tipográfica, acento champagne y panorámica dominante; Spanish Tapas con la línea editorial `& Take Away`, una fotografía gastronómica cercana y acción secundaria. Un tercer artículo compacto introduce Gourmet Hampers, con fotografía menor y enlace junto al texto.

Título, narrativa y CTA permanecen juntos antes de cada fotografía protagonista. El cambio de proporción y peso de las imágenes aporta jerarquía sin repetir el retrato enmarcado de Pure Soul ni la invitación de Private Experiences. La primera revisión detectó espacio sobrante bajo la panorámica y un enlace de hampers demasiado separado; el regalo pasó a una fila compacta dentro de la misma composición y su enlace se agrupó con el relato. No es una sección nueva de navegación.

Móvil utiliza una secuencia DOM única: apertura → vinos → tapas/Take Away → hampers → Pure Soul. Las dos imágenes principales pasan a anchura completa, con proporciones 16:9 y 3:2; el regalo conserva imagen lateral. No se comprime la composición desktop en columnas estrechas. Tablet mantiene dos áreas con imágenes útiles y textos fluidos; el regalo agrupa imagen, título y enlace sin dispersar sus acciones. No hay reordenamientos CSS, controles falsos, carrusel ni animaciones nuevas.

Discovery tiene exactamente tres enlaces. Se retiran de este partial Our Story, la reserva redundante, Wine Club y Private Experiences; sus destinos y accesos en otros componentes permanecen intactos.

| Jerarquía | Acción | Destino |
|---|---|---|
| Primaria, botón Core sólido | Explore Spanish Wines | `/wines.html` |
| Secundaria, botón Core con borde | Explore Tapas | `/tapas.html` |
| Terciaria, enlace editorial | Discover Gourmet Hampers | `/hampers.html` |

### Veracidad de los recorridos

Se inspeccionaron las tres páginas reales en navegador y sus scripts existentes, sin enviar consultas. Wines presenta categorías All/Red/White/Sparkling y enlaces de consulta por WhatsApp que piden confirmar disponibilidad y siguientes pasos. Tapas identifica `Spanish Tapas & Take Away`, ofrece el filtro Take Away y productos de esa categoría; sus acciones también abren WhatsApp para confirmar disponibilidad y detalles. Hampers presenta categorías y enlaces de consulta por WhatsApp, sin checkout integrado.

Por ello no se usa `Order Take Away`, `Buy Now` ni lenguaje de pedido completado. El contexto gastronómico dice `Explore the menu and ask about Take Away.` No se trasladan precios, disponibilidad, promociones o condiciones del legacy a Discovery. Se comprobó la existencia y activación de destinos; no la respuesta del negocio, pagos, stock o entrega de mensajes. Los procesos comerciales y sus archivos no se modifican.

### Recursos y reutilización

Se conservan Foundation, botones/enlaces Core, foco, `cl-seccion--alterna`, `cl-titulo-1`, headings, eyebrow, descripción, texto pequeño, tratamiento de imagen de `cl-media-contenido__imagen`, `container`/`row`/columnas Bootstrap, `media-breakpoint-up(md/lg)`, espaciados y radio semánticos. Grid organiza el regalo y Flexbox su enlace; no se crean tokens, componentes globales, imports legacy, dependencias o JavaScript. No hay `!important`. Se sustituyen solo las reglas locales `cl-home-descubrimiento*`; el SCSS anterior y posterior a ese bloque coincide con la copia previa a este refinamiento.

| Uso | Recurso existente bajo `assets/images/` | Tratamiento |
|---|---|---|
| Vinos | `bg/clandestno-wines.webp`, 1920 × 1080 | Panorámica completa 16:9, estanterías reales, sin marco ni superposición |
| Gastronomía | `gallery/tapas/the-clandestino-tapas-table-3.jpeg`, 2048 × 1536, con sus AVIF/WebP existentes | Ventana 3:2; se conservan queso, embutidos, pan y nueces reconocibles |
| Regalo | `hampers/basket-01.webp`, 1536 × 2048 | Cesta completa 3:4 con contain, de menor tamaño |

Los tres usan `picture`, dimensiones explícitas, lazy loading, decoding async y alt descriptivo. La panorámica y la cesta ya son WebP; no se inventa una fuente AVIF ni se necesita otro derivado en esta fase. No se retocan originales ni se repite la imagen de Pure Soul. El nombre `clandestno-wines.webp` se conserva tal como existe en el repositorio.

Para la revisión fotográfica final: sustituir la panorámica de estanterías por una toma horizontal más íntima de una selección corta de botellas españolas, con etiquetas legibles y ambiente cálido del local; conservar una escena gastronómica 3:2 con suficiente contexto de mesa y alimentos; preparar una cesta con fondo más neutro y luz coherente con la gastronomía. Son sugerencias para fotografías futuras, no cambios pendientes que bloqueen este layout ni confirmación de stock del contenido fotografiado.

### Comparación visual y responsive

Se guardó la B implementada antes de editar, incluyendo HTML, CSS compilado y copia de los archivos locales. Se comparó en navegador con Collection a 390/768/1440 px, revisando la conexión Hero → Discovery → Pure Soul, jerarquía, recortes, proximidad de acciones y equilibrio. Después se comprobaron 320/425/1024/1280/2560. No se volvió al Welcome antiguo ni se desarrollaron otras alternativas.

| Ancho CSS | Altura de B anterior → Collection | Responsive |
|---|---:|---|
| 320 | 1555,81 → 1415,94 px | PASS |
| 390 | 1562,47 → 1375,83 px | PASS |
| 425 | 1626,06 → 1406,31 px | PASS |
| 768 | 904,70 → 881,69 px | PASS |
| 1024 | 899,05 → 928,98 px | PASS |
| 1280 | 997,25 → 993,94 px | PASS |
| 1440 | 1035,67 → 1017,30 px | PASS |
| 2560 | 1129,66 → 1020,06 px | PASS |

Sin overflow, textos cortados, solapamientos o imágenes sin cargar en los ocho anchos. La prioridad de vinos es deliberada: en 390, su CTA aparece aproximadamente en y=944 frente a y=1657 en B, mientras tapas pasa a ser la segunda invitación, con CTA aproximadamente en y=1400. Pure Soul entra unos 187 px antes que en B móvil. En 1440, el CTA de vinos se adelanta aproximadamente 115 px. Son coordenadas de laboratorio, no tasas de conversión.

No se afirma equivalencia visual con B: el cambio de jerarquía, composición, copy e imágenes es intencional. Se compararon por separado geometría y estilos de Header, Hero, Pure Soul, Private Experiences y Footer contra B: cero diferencias registradas en las muestras de los ocho anchos. No equivale a identidad binaria de píxeles ni a una auditoría completa de todas sus interacciones.

### QA del refinamiento

| Comprobación | Resultado |
|---|---|
| `npm run lint`, ESLint y Stylelint | PASS, ejecución final |
| `npm run build`, Sass/PostCSS, esbuild y sprite | PASS, ejecución final |
| PHP lint de Discovery y Home Preview | PASS |
| `probar-carrito.mjs`, `probar-cierre-comercio.mjs` | PASS |
| `git diff --check` | PASS |
| HTML estructural renderizado | PASS: anidamiento explícito, un H1, IDs únicos, ARIA presente, alt/dimensiones, labels; no certificación Nu/W3C |
| Recursos y rutas | PASS: 49 referencias locales HTTP 200, fragmentos presentes; acceso directo al partial 404 |
| Teclado y foco, 390/768/1440 | PASS: vinos → tapas → hampers → Wine Shop de Pure Soul; anillo sólido de 2 px con offset de 3 px |
| Contraste sólido | PASS: 13 muestras; mínimo 11,40:1; no hay texto sobre las fotos de Collection |
| Consola | Sin errores/warnings observados en Home implementada |
| Sin JavaScript, 390/768/1440 | PASS: anfitrión externo con scripts eliminados y CSP `script-src 'none'`; cero scripts, imágenes y tres rutas disponibles, geometría/estilos locales sin diferencias |
| Estabilidad local, 390/768/1440 | Altura reservada idéntica antes/después de cargar fotos; CLS observado 0 en las tres muestras |
| Integridad | PASS: 22 archivos protegidos cotejados con HEAD; Home Preview previo intacto y reglas SCSS ajenas a Discovery intactas |

CLS se mide con `PerformanceObserver` solamente en el anfitrión externo de QA, sin throttling y con caché disponible. No se incorpora medición, GTM ni GA4 al producto. Header conserva su fallback expandido sin JS; la igualdad geométrica sin scripts corresponde a Collection, no a la altura total de Home.

### Coste y alcance

CSS Home minificado: 77 870 → 77 965 B; gzip Node: 13 804 → 13 865 B, incremento de **61 B gzip** frente a Discovery B. Fotografías solicitables en los formatos preferentes: 365 401 → 265 861 B, reducción de 99 540 B (aproximadamente 97 KiB). Se comparan tamaños de archivos, no una captura de transferencia de red. No se añaden archivos multimedia, fuentes, dependencias o JavaScript.

Este refinamiento cambia `includes/discovery.php`, su bloque local en `assets/scss/home.scss`, este informe y la referencia de `docs/ARQUITECTURA.md`. `home-preview.php` conserva la integración local previa sin nuevas modificaciones. Welcome/Spanish Table originales, `index.html`, Header, Hero, Pure Soul, Private Experiences, Footer, páginas comerciales, backend, analítica y tokens quedan intactos. Se permanece en la misma feature sin operaciones de publicación.

### Revisión y límites

Abrir `http://127.0.0.1:8766/home-preview.php#spanish-table`, o `npm run dev` y `http://localhost:3000/home-preview.php`. El build utiliza PHP tradicional y assets compilados; no requiere Node ni procesos persistentes en GoDaddy/cPanel. La protección local `cli-server` y noindex de Home Preview no cambia.

Evidencia externa: `C:/Users/Mike/.codex/visualizations/2026/10/27/01a17ee9-2567-7ab0-add5-ee066ed94c1c/collection-refined/`. `antes/` preserva fuentes/CSS previos; `comparacion-{390,768,1440}.jpg` y `collection-responsive.jpg` muestran el recorrido desde Hero hasta Pure Soul. Las capturas completas incluyen el resto de Home. JSON de responsive, regresión, teclado, contraste, estabilidad, estructura/recursos/integridad y peso acompaña las imágenes. El estado anterior navegable vive en `/collection/before.html` del servidor externo de referencia en 8765.

Limitaciones: Chromium integrado; sin Safari/Firefox, dispositivos físicos, zoom nativo 200%, lector auditivo, forced colors, throttling, métricas de campo o pruebas de Apache/cPanel remoto. Las páginas comerciales conservan sus dependencias y limitaciones legacy; no se certifican su checkout, pagos, stock o recepción de consultas. Fotografía provisional pendiente de la revisión artística conjunta posterior. QA técnico y revisión visual interna no sustituyen la aprobación artística humana final.

**HOME DISCOVERY REFINED — WAITING FOR VISUAL APPROVAL**

## Registro anterior — Discovery B, sustituido y no aprobado visualmente

El contenido restante documenta la primera implementación y sus verificaciones históricas; no describe la composición vigente de Collection.

2026-10-27. Rama `feature/home-discovery`. Dirección B seleccionada expresamente por el responsable; implementación pendiente de aprobación visual final. Sin activación comercial ni publicación.

## Base y protección del alcance

Preflight con árbol limpio y `git fetch origin`. Los PR #15 (Header/Hero), #16 (base PHP/primeras secciones), #17 (Pure Soul) y #18 (Private Experiences) están integrados en `origin/develop`. Los commits de las cuatro features son ancestros de esa referencia; el último merge es `b05b6816bebab88d4bcd081ad0cc20072bad1940`.

El `develop` local avanzó de `8e790e7` a `b05b681` mediante `git merge --ff-only origin/develop`, avance rápido autorizado, sin crear commit de merge. Divergencia comprobada 0/0. `feature/home-discovery` nace de ese `develop` actualizado. No se creó ningún commit, push, PR, merge de feature ni deploy.

`index.html` permanece equivalente a `production-baseline` al ignorar CRLF. Header, Hero, Pure Soul, Private Experiences, Footer, Welcome, Spanish Table, tokens globales, JavaScript fuente y fotografías originales/derivados utilizados no cambian. Verificación de integridad contra HEAD de 18 archivos representativos, además del diff completo. No se eliminan componentes anteriores.

## Composición implementada

Se integra `includes/discovery.php` inmediatamente después del Hero de `home-preview.php`. Reemplaza las inclusiones de `welcome.php` y `spanish-table.php`, sin repetirlas debajo. Después continúan los mismos `wines.php`, `private-experiences.php` y `footer.php`.

La apertura conserva el prototipo B del comparador externo: bienvenida editorial a la izquierda y contexto/acciones a la derecha desde md; una fotografía gastronómica dominante ocupa siete columnas y dos invitaciones visuales complementarias ocupan cinco. La mesa tiene pie narrativo; vinos y hamper muestran fotografía vertical íntegra junto a texto breve y enlace. Club y Private Experiences tienen accesos compactos al contenido existente; no se repiten sus relatos.

En móvil, el orden DOM es bienvenida → contexto/CTA gastronómico → foto y relato de la mesa → vinos → hampers → accesos complementarios. La foto principal conserva 4:3, sin alturas de pantalla ni recortes adicionales. Las invitaciones secundarias mantienen imagen lateral, evitando una fila de tarjetas estrechas. En tablet, siguen existiendo dos columnas con texto fluido y controles capaces de crecer si necesitan dos líneas. Desktop utiliza la misma asimetría del prototipo, con gutters semánticos.

El salto deliberado tras `A little Spain.` pertenece al manifiesto seleccionado del prototipo. No se introducen saltos adicionales ni una escala tipográfica nueva. El ancho de lectura depende de las columnas; la prosa de la mesa se limita a 49ch. No hay otro Hero, slider, animación de entrada, filtro, tabs o controles simulados.

## Reutilización y clases

| Base existente | Uso |
|---|---|
| `cl-seccion`, `cl-seccion--alterna` | Espaciado responsive y superficie de la apertura |
| `container`, `row`, `col-md-7`, `col-md-5` | Retícula Bootstrap 5.3 |
| `cl-display`, headings y cuerpo Foundation | Tipografía editorial y lectura |
| `cl-eyebrow`, `cl-seccion__descripcion` | Jerarquía y prosa |
| `cl-boton`, variante secundaria, `cl-seccion__acciones` | Acciones de tapas y reserva |
| `cl-enlace`, foco Foundation | Enlaces editoriales, hover/visited y foco |
| `cl-media-contenido__imagen`, `cl-home__mesa` | Fotografía de la mesa, radio y proporción existente |
| Tokens `--espacio-*`, `--radio-md`, `--color-borde` | Ritmo, tratamiento fotográfico y separación |
| `media-breakpoint-up(md/lg)` | Cambios de contexto y gutter con los mixins ya importados |
| CSS Grid / Flexbox | Invitaciones laterales, alineación de texto y enlaces |

No se fuerza el split completo `cl-media-contenido` en esta composición con tres invitaciones. Se reutiliza su tratamiento de imagen; el conjunto es un adaptador local de Home. No se usa una ficha de catálogo con precio/compra para representar una categoría editorial.

Mapeo del laboratorio a producto: `cl-revision-b__*` → `cl-home-descubrimiento__*`; `cl-revision__enlace` → `cl-home-descubrimiento__enlace`. La superficie usa la variante existente `cl-seccion--alterna` y se elimina la declaración redundante de tamaño de `.cl-display`, ya resuelta por Foundation. Todas las reglas nuevas viven en `home.scss`; no se cambia ningún patrón compartido ni token y no hay `!important`.

## Contrato PHP y destinos

El partial rechaza el acceso HTTP directo con 404, igual que los otros includes. Recibe del anfitrión `$rutaReserva` y `$escaparNavegacion`; la URL de reserva se escapa como en la sección anterior. El resto de las rutas/copy es estático y controlado. No importa fixtures, recibe rutas del usuario, incorpora formularios ni necesita base de datos.

| Acción | Destino real |
|---|---|
| Our Story | `/about.html` |
| Explore the Tapas | `/tapas.html` |
| Reserve a Table | `/index.html#reservation` |
| Explore Wines | `/wines.html` |
| Discover Hampers | `/hampers.html` |
| Explore the Wine Club | `/swc.html` |
| Discover Private Experiences | `#private-events` |

`spanish-table`, `welcome-titulo` y `spanish-table-titulo` se conservan como identificadores únicos. El último pasa a H3 de la mesa bajo el H2 de Discovery. Los otros dos artículos tienen H3 y sus propias etiquetas ARIA.

La diferencia de texto frente al prototipo es `Explore Hampers` → `Discover Hampers`, solicitada expresamente. No se añaden precios, stock, descuentos, urgencia, estadísticas, compra, checkout, confirmación de reserva o disponibilidad. Los destinos conservan sus funciones legacy. No se enviaron formularios ni se validó entrega de solicitudes.

## Fotografía provisional

| Uso | Original y derivados existentes | Dimensiones |
|---|---|---|
| Mesa dominante | `gallery/tapas/the-clandestino-tapas-table-1.jpeg`; AVIF/WebP equivalentes | 2048 × 1536 |
| Vinos | `wines.jpeg`; `avif/wines.avif`, `webp/wines.webp` | 1536 × 2048 |
| Hamper | `hampers/basket-01.webp` | 1536 × 2048 |

Todos bajo `assets/images/`. Son los recursos del prototipo B. Se usan `picture`, AVIF/WebP donde ya existen, fallback original, dimensiones explícitas, `loading="lazy"` y `decoding="async"`. La cesta ya es WebP; no necesita un derivado adicional para esta fase. Las fotos secundarias conservan 3:4 con `contain`, botella/cesta completas, sin alterar originales ni generar multimedia. Texto alternativo descriptivo en las tres.

El contenido de archivo no garantiza stock actual de cada botella o artículo fotografiado. La revisión fotográfica final de toda la Home sigue siendo una etapa posterior; sustituir el recurso no requiere reconstruir el layout.

## Comparación comprobada con B

Se abrieron en navegador el estado anterior, el prototipo B conservado y la implementación. Las capturas se tomaron con la primera escena del Hero seleccionada, fotografías cargadas y altura CSS de viewport 844 px.

Comparación de 52 elementos de Discovery en cada uno de los ocho anchos: geometría, tipografía, color, fondo, padding, radio, `object-fit` y proporción. La altura de la apertura coincide con B en los ocho. Solo aparecen dos diferencias geométricas por ancho: el enlace de hampers es 7,19 px más ancho y su flecha se desplaza en consecuencia por el texto solicitado `Discover`.

Las capturas desktop, tablet y móvil fueron inspeccionadas visualmente: composición, jerarquía, encuadres, proporciones, CTA y continuidad con Pure Soul coinciden con la dirección seleccionada. No se afirma identidad binaria de píxeles ni equivalencia funcional de servicios comerciales.

| Ancho CSS | Altura Discovery, B / implementación | Resultado |
|---|---:|---|
| 320 | 1555,81 / 1555,81 px | PASS |
| 390 | 1562,47 / 1562,47 px | PASS |
| 425 | 1626,06 / 1626,06 px | PASS |
| 768 | 904,70 / 904,70 px | PASS |
| 1024 | 899,05 / 899,05 px | PASS |
| 1280 | 997,25 / 997,25 px | PASS |
| 1440 | 1035,67 / 1035,67 px | PASS |
| 2560 | 1129,66 / 1129,66 px | PASS |

Sin overflow horizontal, textos recortados, solapamientos o imágenes fallidas en los ocho anchos. No se altera la escala de pantalla ancha del prototipo ni se compacta su móvil como una nueva exploración.

Frente a Welcome + Spanish Table, el comienzo del CTA de tapas pasa de aproximadamente 1411 a 950 px en móvil 390 y de 1257 a 868 px en desktop 1280. Se hace visible la oferta de vinos y hampers como categorías, sin depender solo del menú. Se conserva el coste de longitud elegido con B: Pure Soul empieza unos 568 px más abajo en móvil y 167 px en desktop. Estas posiciones son evidencia de composición, no una medición de conversión.

Se contrastaron también los elementos de los cinco bloques preservados con el estado anterior: sin diferencias en el contenido visible medido. La comparación bruta detecta cinco diferencias de 15 px en tres muestras móviles, todas en la altura y descendientes del drawer cerrado y oculto, fuera de pantalla (`visibility:hidden`). No hay cambios de fuente de Header. Apertura, Escape y retorno de foco del drawer se comprobaron aparte, esperando el final de sus transiciones; sin backdrop residual.

## QA técnico y accesibilidad

| Comprobación | Resultado |
|---|---|
| `npm run lint` | PASS: ESLint y Stylelint |
| `npm run build` | PASS: sprite, Sass/PostCSS y esbuild; sin CSS/JS legacy en Home |
| PHP lint | PASS: `home-preview.php` y los diez includes |
| `node scripts/probar-carrito.mjs` | PASS |
| `node scripts/probar-cierre-comercio.mjs` | PASS |
| `git diff --check` | PASS |
| HTML estructural renderizado | PASS: pila de etiquetas explícitas, un H1, IDs únicos, referencias ARIA presentes, alt/dimensiones y labels; no certificación Nu/W3C |
| Recursos/rutas | PASS: 52 referencias locales, incluidos `srcset`, HTTP 200 y fragmentos existentes; include directo 404 |
| Teclado en 390/768/1280 | PASS: Our Story → tapas → reserva → vinos → hampers → club → experiencias → Wine Shop de Pure Soul, sin trampa |
| Foco | PASS: anillo sólido de 2 px, offset de 3 px, Core conservado |
| Contraste sólido | PASS: 19 muestras, mínimo 11,40:1 en Discovery; no hay texto sobre sus fotos |
| Consola | Sin errores/warnings observados en la Home implementada |
| Sin JavaScript en 390/768/1280 | PASS: anfitrión externo elimina scripts y aplica CSP `script-src 'none'`; cero scripts, mismas 52 geometrías/estilos locales, imágenes cargadas y navegación de hampers comprobada |
| Estabilidad en 390/768/1280 | PASS: altura reservada antes/después idéntica; CLS observado 0 tras recorrer la página y cargar imágenes diferidas |
| Integridad | PASS: 18 archivos protegidos cotejados contra HEAD; diff limitado a los cinco archivos del alcance |

La medición de CLS usa `PerformanceObserver` en un anfitrión de QA externo, con ventanas de sesión y exclusión de entradas con interacción reciente. No se incorpora código de medición al producto ni se añade GTM/GA4. Son muestras locales sin throttling y con caché del navegador disponible; no son Core Web Vitals de campo.

Sin JS, Discovery conserva íntegramente su composición y acciones; Header utiliza su fallback expandido preexistente. La comparación sin JS se refiere a Discovery, no a igualdad de la altura total de Home.

## Peso y compatibilidad

CSS Home compilado de forma comparable con Sass + Autoprefixer + cssnano: 75 881 → 77 870 bytes; gzip Node: 13 589 → 13 804 bytes, incremento de 215 bytes gzip. No cambia JavaScript fuente ni se añaden módulos o dependencias.

La mesa ya se descargaba en Spanish Table. Se añaden las dos fotografías del prototipo: vinos AVIF 50 649 B y cesta WebP 69 928 B, total 120 577 B (aproximadamente 118 KiB). Son tamaños de archivos, no transferencia medida; se cargan de forma diferida. El fallback WebP de vinos pesa 81 058 B. No se generan derivados ni se duplican fotos en el documento.

El paquete futuro utiliza PHP tradicional y archivos CSS/JS compilados. No necesita Node, Redis, colas, procesos persistentes ni dependencias nuevas en GoDaddy/cPanel. No se modifican Apache, backend comercial o analítica. Home Preview conserva su protección `cli-server`, `noindex` y 404 fuera del entorno local; no se activa como Home pública.

## Archivos del cambio

- `includes/discovery.php`: nuevo partial editorial.
- `home-preview.php`: sustituye exclusivamente los dos includes activos.
- `assets/scss/home.scss`: 89 líneas de composición local; Foundation y patrones intactos.
- `docs/ARQUITECTURA.md`: registro breve de integración.
- `docs/HOME-DISCOVERY.md`: contrato, evidencias y límites.

Los outputs compilados siguen ignorados por Git. `welcome.php` y `spanish-table.php` se conservan sin cambios para evaluar sus otros usos más adelante.

## Cómo revisar

Servidor de esta revisión: `http://127.0.0.1:8766/home-preview.php#spanish-table`. Comprobar bienvenida/CTA, mesa, invitaciones de vino/cesta y transición a Pure Soul a 390, 768 y 1280; ampliar a los otros cinco anchos de la matriz. Tab recorre las siete acciones; Enter abre los destinos reales.

Con el pipeline habitual: `npm run dev` → `http://localhost:3000/home-preview.php`. Para servir solo el build ya generado desde el repo: `php -S 127.0.0.1:8766`.

Contrato anterior conservado: `http://127.0.0.1:8765/propuesta-b.php`; estado anterior: `http://127.0.0.1:8765/home-preview.php`. Son copias externas, no documentos productivos.

Evidencia fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/10/27/01a17ee9-2567-7ab0-add5-ee066ed94c1c/home-discovery/`. `comparacion-{390,768,1280}.jpg` muestra anterior / prototipo / implementación, a igual escala por anchura, desde el Hero hasta Pure Soul. Las capturas completas `implementacion-{ancho}.jpg` incluyen el resto de Home; las de 2560 se conservan a resolución nativa. JSON de responsive, comparación geométrica, teclado, contraste, estabilidad, estructura/recursos/integridad y peso acompaña las imágenes. Router y scripts auxiliares de QA permanecen fuera del repo.

Limitaciones: navegador integrado Chromium, sin Safari/Firefox ni dispositivos físicos; sin zoom nativo 200%, lector de pantalla auditivo, forced colors, throttling, métricas de campo o validación en Apache/cPanel remoto. El contraste fotográfico del Hero y las interacciones históricas no reciben una auditoría completa nueva. No se enviaron formularios ni se validaron pagos, stock, correo o condiciones comerciales. Pendiente la aprobación visual humana del conjunto y la revisión fotográfica final acordada.

**HOME DISCOVERY READY — WAITING FOR VISUAL APPROVAL**
