# Biblioteca de patrones de sección — Wave 1

Wave 1 implementa cuatro familias de presentación sobre Foundation/Core. **Pendiente de aprobación visual humana**: QA técnico no aprueba el diseño, ni autoriza PR, merge, deploy o Wave 2. Base comprobada: `develop` / `origin/develop` en `0053822`; rama `feature/ui-section-patterns-wave-1`.

## Composición y contratos compartidos

- `assets/scss/main.scss` importa `patterns/*` después de Foundation/Core. El resultado está en `style.new.css`; sin estilos exclusivos del laboratorio.
- `/style-guide/` presenta Foundations/Core; `/style-guide/patterns.php`, Section Patterns. Solo Patterns incluye `partials/patrones-wave-1.php` con `require`/`__DIR__`. Ambas comparten un pequeño partial local de navegación con enlaces reales y `aria-current="page"`; sin tabs JS ni demos duplicadas.
- Contenedores y columnas Bootstrap: `.container`, `.row`, `.col-md-*` y `.col-lg-*`. Solo breakpoints existentes `md` y `lg`, con sus mixins. Cabeceras de demos centradas exclusivamente bajo `.cl-guia-patrones` en `_guia.scss`; Foundation/Core conserva su presentación.
- Tokens existentes para superficies, bordes, espaciado y texto. Sin modificar tokens/base, raíz, familias tipográficas ni escala; `cl-display` y `cl-titulo-1` son Foundation.
- Clases propias BEM en español; máximo tres niveles de anidación. Sin nuevas utilidades globales, dependencias, JS ni render dinámico.
- Cada sección lleva un título y `aria-labelledby` único. La página decide el nivel; la guía usa h2 para familias y h3 para ejemplos bajo su único h1.
- Navegación mediante enlaces reales: `tapas.html`, `wines.html`, `menu.html`, `contact.html#contact-form`. Consultar una mesa o evento no confirma disponibilidad ni una reserva. No hay transacciones ni promociones.

## `cl-seccion`

**Propósito:** ritmo vertical, encabezado editorial y acciones para contenido variable.

Estructura: `section.cl-seccion[aria-labelledby] > .container`, con `.cl-seccion__encabezado`, eyebrow opcional, heading nativo, `.cl-seccion__descripcion` y `.cl-seccion__acciones` opcionales; contenido después del encabezado.

Variantes: izquierda por defecto; `cl-seccion--centrada` centra texto/acciones y permite limitar el encabezado con una columna Bootstrap; `cl-seccion--alterna` usa fondo alterno. Ambas tienen un caso real en la guía. Padding vertical `--espacio-7`, y `--espacio-8` desde lg. No impone ancho editorial propio ni tamaño de título.

Reutiliza `cl-eyebrow`, `cl-boton`, headings y grid. `.cl-seccion__acciones` es el grupo compartido por las cuatro familias: flex vertical en teléfono y horizontal desde md, con gap del sistema. Su ancho máximo es 32rem (dos acciones); cada botón desde md crece proporcionalmente hasta 16rem. Son límites de composición, no nuevos tokens/escala: impiden botones desmesurados y conservan dos anchos equilibrados. En una sección centrada, el grupo tiene margen automático y un botón único queda centrado. En teléfono, botones a ancho completo del contenedor permitido. Se conserva la estética del encabezado. Descripción secundaria ≥4.5:1. Sin JS ni estados comerciales.

```html
<section class="cl-seccion" aria-labelledby="titulo-tapas">
  <div class="container">
    <div class="cl-seccion__encabezado col-lg-8">
      <p class="cl-eyebrow">At the table</p>
      <h2 id="titulo-tapas">A taste of Spain</h2>
      <p class="cl-seccion__descripcion">Tapas to share and wines to discover.</p>
      <div class="cl-seccion__acciones">
        <a class="cl-boton" href="/tapas.html">Explore the tapas</a>
      </div>
    </div>
  </div>
</section>
```

## `cl-hero`

**Propósito:** introducción fotográfica editorial principal o interior, sin slider, video, parallax ni animación.

Estructura: `section.cl-hero[aria-labelledby]`, `picture.cl-hero__media > img.cl-hero__imagen`, y `.container.cl-hero__estructura > .row > .cl-hero__contenido.col-12.col-md-10.col-lg-7`. Dentro: eyebrow, título elegido por la página, descripción y acciones compartidas.

Variantes: editorial por defecto con `cl-display`; `cl-hero--interior` reduce padding y jerarquía del título con `cl-titulo-1`. El editorial aplica localmente `clamp(2.25rem, 1.6rem + 2.4vw, 4rem)` y ancho 14ch; el interior `clamp(1.875rem, 1.4rem + 1.6vw, 3rem)` y 20ch. Ajustes contextuales pedidos para el banner; no se cambia Foundation. Sin `<br>` rígido ni exigencia de h1. Un CTA interior y dos editoriales.

En **todos los tamaños**, fotografía y estructura comparten celda de grid `1 / 1`. La imagen absoluta rellena la altura reservada por el contenido en flujo; nunca se apilan como filas independientes ni se fija una altura que corte texto. Móvil: contenido centrado; tablet: columna de 10/12 centrada con mayor aire vertical; desde lg: 7/12 editorial a la izquierda. En teléfonos de poca altura, el documento puede requerir scroll vertical normal para recorrer el banner y sus acciones.

El contenido tiene fondo transparente. Un pseudo-elemento elíptico local se extiende `--espacio-8` alrededor de la copia, con opacidad 55% → 45% al 75% del radio → transparente; desde lg su centro horizontal pasa al 35%. Así protege también el inicio de las líneas sin un rectángulo ni un filtro oscuro global. Usa el neutro existente; no introduce una paleta. El resto de la fotografía conserva su luz. La descripción usa texto principal y el CTA secundario tiene su propia superficie/borde legibles. `overflow: clip` limita únicamente la extensión tonal del banner; padding conserva los anillos de foco dentro de sus bordes, verificados con teclado.

Imagen editorial: `bg/clandestino-usa.jpg`, foco central en barra/copas. Interior: `bg/the-clandestino-usa.jpg`, foco central en botellas. `object-fit: cover` no deforma; `--hero-foco` local opcional permite adaptar el punto focal a otra foto sin CSS por página. No es un token nuevo del sistema. Verificar el recorte cada vez que cambie la foto. Alt informativo en estos ejemplos; `alt=""` cuando una imagen futura sea puramente decorativa.

Accesibilidad: comprobar contraste contra el recorte real y cada formato, foco visible sin clipping, DOM imagen → narrativa → enlaces. `--hero-proteccion-posicion` es un ajuste local del patrón, no un token global. Rendimiento: dimensiones explícitas y altura reservada por contenido antes de cargar la foto; sin JS. Las demos siguen bajo el primer viewport y usan lazy loading. Si el Hero futuro es LCP, **quitar `loading="lazy"`** y evaluar carga normal/eager y `fetchpriority="high"` en la página real.

## `cl-media-contenido`

**Propósito:** narrativa con foto gastronómica/restaurante, párrafos, lista semántica breve y CTA opcionales.

Estructura: `.row.cl-media-contenido`, `.col-md-6.cl-media-contenido__media > picture > img.cl-media-contenido__imagen` y `.col-md-6.cl-media-contenido__contenido`. Envolver en una sección identificada y `cl-seccion` para ritmo/superficie. La imagen permanece primero en el DOM.

Variantes: foto izquierda por defecto; `cl-media-contenido--invertido` cambia solo `order` desde md, junto con las columnas. Teléfonos apilan; **desde 768px son dos columnas**. Gutter horizontal `--espacio-6` desde md, copy de 1rem/1.65 contextual en tablet y 1.0625rem desde lg. Imagen cuadrada en tablet, 4:3 en teléfono/escritorio; redondeo `--radio-md`. Alineación vertical centrada y CTA con límite compartido. El orden accesible sigue imagen → texto y enlaces en su orden lógico; las fotos no son controles. No invertir si controles futuros producen un orden visual/teclado incoherente.

Reutiliza grid, eyebrow, headings nativos y acciones/botón Core. Lista `<ul><li>` nativa, sin componente nuevo. La demo izquierda incluye lista y CTA; derecha presenta narrativa sin CTA/lista.

Fotos sin personas: tapas (`bg/clandestino-tapas.jpg`) y vinos (`bg/the-clandestino-usa.jpg`). Cover sin deformación y foco central; `--media-foco` permite ajuste local por foto. Width/height reales, ancho 100% y proporción reservada; lazy loading fuera del viewport. Sin fuentes responsive ficticias ni variantes de foto.

## `cl-banda-cta`

**Propósito:** invitación compacta a explorar o consultar, sin prometer operaciones completadas.

Estructura: `section.cl-banda-cta[aria-labelledby] > .container > .row.cl-banda-cta__fila`, columna de heading/descripción opcional y columna de `.cl-seccion__acciones.cl-banda-cta__acciones` con enlaces Core. Título obligatorio; uno o dos CTAs como en las demos, con nombres claros.

Las dos demostraciones usan la misma composición **centrada y vertical**: texto y acciones en columnas 12/12 y 8/12 desde lg. Eyebrow Core aporta identidad; heading local `clamp(1.75rem, 1.25rem + 1.5vw, 2.5rem)`, descripción y acciones centradas. Padding 3rem/4rem desde lg, superficie y bordes semánticos para separar secciones. Uno o dos CTAs con el grupo compartido; no hay modificadores artificiales por cantidad, paleta nueva, gradientes decorativos, imágenes ni JS. No trunca nombres ni fija altura; foco Core.

## Decisión futura — carrusel editorial de Home

Solo la futura Home migrada tendrá carrusel por defecto; Heroes interiores seguirán estáticos. Reutilizar el Hero editorial aprobado, pocos slides con contenido realmente distinto, controles claros, navegación de teclado y pausa de reproducción cuando corresponda. Respetar `prefers-reduced-motion`, evitar movimiento automático distractor, primera imagen optimizada como posible LCP y altura estable entre slides. Evaluar imports selectivos de Bootstrap Carousel antes de escribir uno propio. Implementar en una feature separada al abordar Home; UI-PATTERNS-03 no añade carrusel ni JS.

## Inventario físico de fotografía

Verificado con `getimagesize`, MIME, tamaño de archivo e inspección visual de originales. Todas las fuentes de cada picture comparten dimensiones; no hay `srcset` de anchos ficticios. Se prefieren los WebP en `webp/bg/`, más ligeros que los duplicados en `bg/`.

| Ruta bajo `assets/images/` | Dimensiones | Bytes | Uso |
|---|---:|---:|---|
| `bg/clandestino-usa.jpg` | 1880 × 920 | 138907 | Hero editorial, fallback |
| `webp/bg/clandestino-usa.webp` | 1880 × 920 | 56918 | Alternativa WebP |
| `avif/bg/clandestino-usa.avif` | 1880 × 920 | 41770 | Fuente preferida |
| `bg/the-clandestino-usa.jpg` | 1920 × 1080 | 223663 | Hero interior y media vinos, fallback |
| `webp/bg/the-clandestino-usa.webp` | 1920 × 1080 | 99786 | Alternativa WebP |
| `avif/bg/the-clandestino-usa.avif` | 1920 × 1080 | 78844 | Fuente preferida |
| `bg/clandestino-tapas.jpg` | 1920 × 1080 | 219192 | Media tapas, fallback |
| `webp/bg/clandestino-tapas.webp` | 1920 × 1080 | 97256 | Alternativa WebP |
| `avif/bg/clandestino-tapas.avif` | 1920 × 1080 | 77033 | Fuente preferida |

También existen `bg/clandestino-usa.webp` (78508 bytes) y `bg/clandestino-tapas.webp` (140844 bytes), verificados pero no utilizados. No se modifica ni genera fotografía.

## Verificación y rendimiento

Abrir `/style-guide/` y `/style-guide/patterns.php` en `http://localhost:3000` con `npm run dev`. Recorrer Section system, Hero, Media + content y CTA band a 320, 360, 390, 425, 768, 820, 992, 1024, 1280 y 1440px; comprobar poca altura, zoom 200%, Tab/Shift+Tab y foco. El bloqueo Apache `^style-guide(/|$)` cubre nueva ruta y partials sin modificar `.htaccess`; PHP local lo ignora.

Comandos: `npm run lint`, `npm run build`, `php -l` para `style-guide/index.php`, `patterns.php` y ambos partials. Build limpia CSS/JS de guía y sourcemaps; comprobar antes de reiniciar dev. Comprobar cuatro familias en CSS producto y ausencia de `cl-guia`/`cl-muestra`.

Medición histórica de UI-PATTERNS-02, mismo build minificado con `node:zlib.gzipSync`:

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Diferencia gzip |
|---|---:|---:|---:|---:|---:|
| `style.new.css` | 49168 | 51345 | 9707 | 10089 | +382 (+3.94%) |
| JS productivo `dist/main.js` | 0 | 0 | 20 | 20 | 0 |

El gzip de 20 bytes es solo la cabecera de un flujo vacío, no JS incorporado. SHA-256 de main idéntico: `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. CSS crece 2177 bytes sin comprimir por layout responsive y cuatro familias; no hay duplicación de componentes Core. No se mide CSS dev con sourcemaps como si fuera producción.

Recursos añadidos a la guía: cuatro elementos picture/img y **tres URLs de imagen únicas** en el navegador compatible; la foto de vinos se reutiliza desde caché. Cero scripts, hojas enlazadas, fuentes o recursos decorativos adicionales. Payload fotográfico seleccionado: AVIF 197647 bytes; WebP 253960; JPG 581762 (totales alternativos, no acumulados). El navegador elige una fuente por picture. El partial se incluye en servidor y no añade request.

No se declara LCP/CLS de producción desde esta guía. Las metas se medirán al migrar páginas con condiciones comparables. La revisión de CLS aquí es observacional, junto a dimensiones/proporciones reservadas.

### Registro histórico de QA — UI-PATTERNS-02

Verificado el 2026-10-12 en Chromium integrado, antes del refinamiento siguiente. Este registro no representa el diseño final de UI-PATTERNS-03; aprobación visual humana pendiente.

| Comprobación | Resultado |
|---|---|
| Preflight | PASS: limpio; fetch y fast-forward; Foundation/Core en `0053822` |
| Lint | PASS: ESLint/Stylelint sin errores ni reglas relajadas |
| Build | PASS: cuatro patrones, sin `cl-guia`/`cl-muestra`, sin CSS/JS de demostración ni sourcemaps |
| PHP | PASS: index y partial sin errores de sintaxis |
| Servidor/watch | PASS: `npm run dev`, PHP y BrowserSync en localhost:3000 |
| Advertencia dev | Node emite `DEP0060`: `util._extend` obsoleto en el proceso del servidor. No bloquea compilación, guía ni watch; sin cambiar dependencias/tooling |
| 390 / 768 / 1280px | PASS: capturas de familias, sin overflow horizontal, texto cortado ni CTAs superpuestos; recortes razonables |
| Zoom 200% | PENDIENTE: el navegador integrado no expone control de zoom; `ctrl+plus` no cambió escala ni ancho CSS; no se registra como probado |
| Teclado/foco | PASS: diez CTAs con Tab, retorno Shift+Tab, sin trampas; outline champagne 2px/offset 3px, también comprobado en móvil |
| Semántica | PASS: un h1, familias h2 y demos h3; IDs únicos, secciones nombradas e imágenes con alt/dimensiones reales |
| Contraste | PASS: 48 elementos con colores/superficies resueltos; mínimo 9.70:1, sin texto sobre fotografía |
| Carga/HTTP | PASS: cuatro imágenes cargadas con AVIF; guía, CSS/JS, nueve fuentes fotográficas y cuatro destinos HTTP 200 |
| Consola | PASS: sin errores ni warnings relevantes en la pestaña revisada |
| CLS observado | Sin salto evidente; proporciones/dimensiones reservadas. No es una medición de Web Vitals productivos |
| Legacy | PASS: diff contra base sin modificaciones de páginas/PHP productivos, CSS/JS legacy, imágenes, sitemap, robots ni `.htaccess`; sin enlace nuevo a `style.new.css` en producción |
| Foundation/tooling | PASS: tokens, base, fuentes, package files, Gulp y fuentes JS intactos; JS build idéntico |

Las ejecuciones iniciales dentro del sandbox bloquearon `.git/FETCH_HEAD` y lecturas ascendentes de esbuild; se completaron con los permisos necesarios, sin cambiar infraestructura. El primer lint señaló el selector `.container` dentro de Hero; se corrigió usando `cl-hero__estructura`, sin excepciones de lint. Los resultados PASS corresponden a las ejecuciones finales.

Evidencias locales fuera del repo: `C:/Users/Mike/.codex/visualizations/2026/10/12/01a12ee8-6679-7ae3-a5eb-c895d147987a/wave1-*` (capturas de Section system, Hero, Media y CTA a los tres anchos; foco; informe de contraste). Pruebas realizadas mediante la skill `qa-visual` del repo. No se ejecutaron Firefox, Safari, Apache/GoDaddy ni lector de pantalla auditivo. La escala 200% y la aprobación estética quedan para revisión humana local.

### Archivos y entrega

Nuevos: los cuatro SCSS en `assets/scss/patterns/`, `style-guide/partials/patrones-wave-1.php` y este documento. Modificados: `assets/scss/main.scss`, `style-guide/index.php`, y referencias vigentes en `docs/ARQUITECTURA.md` / `docs/ESTANDARES-DE-CODIGO.md`. Los outputs permanecen ignorados. El commit de implementación contiene patrones, demos y documentación; un segundo commit documental registra la advertencia dev observada después. Publicación normal exclusivamente de la feature. Sin PR, merge, force push ni deploy.

### Refinamiento — UI-PATTERNS-03

Rama conservada, preflight limpio y sincronizado en `a0fa613`; sin reescribir commits publicados. Verificación del 2026-10-12 en Chromium integrado mediante `qa-visual`. **Refinamiento técnicamente implementado; aprobación visual humana pendiente.** No iniciar Wave 2.

| Comprobación | Resultado |
|---|---|
| Lint / build | PASS: ejecuciones finales sin errores; sin relajar reglas ni cambiar tooling |
| PHP | PASS: index, patterns y ambos partials sin errores de sintaxis |
| Ambas rutas / CSS | PASS: HTTP 200; navegación real entre páginas, también con Enter, un destino activo por página |
| 320 / 390 / 425 / 768 / 820 / 992 / 1024 / 1280px | PASS: revisión en navegador y geometría de las cuatro familias, sin overflow ni contenido truncado |
| 360 / 1440px adicionales | PASS: mismos contratos y superposición del Hero |
| Hero | PASS: imagen/contenido coinciden en altura/celda en los diez anchos; contenido transparente, títulos sin br rígido, CTAs dentro del banner |
| Teléfono 320 × 568 | PASS: scroll vertical normal permite alcanzar CTA; Tab/foco visible, sin overflow ni recorte del control |
| Section / CTA | PASS: botones de dos acciones con anchos iguales; único CTA centrado en contexto centrado; targets ≥44px, composición limitada a 32rem |
| Media tablet | PASS: dos columnas desde md, inversión desde md; imagen cuadrada y copy proporcionada, radios discretos |
| Contraste sólido | PASS: 41 elementos del laboratorio/patrones fuera del Hero, mínimo 9.70:1 |
| Contraste Hero | PASS estimado: 180 combinaciones de texto, ancho y formato; mínimo conservador 6.25:1, incluidas fuentes AVIF/WebP/JPG |
| Foco / teclado | PASS: diez CTAs con Tab, retorno Shift+Tab, outline 2px/offset 3px; comprobación móvil sin clipping |
| Semántica | PASS: un h1 por página, títulos subordinados, IDs únicos, alt/dimensiones conservados; Patterns sin script module de demostración |
| Foundations/Core | PASS: sin patrones duplicados, alineación original, sin overflow en los ocho anchos obligatorios; fuentes JS/Core intactas |
| Consola | Sin errores/warnings relevantes observados antes de detener temporalmente dev para medir build |
| Zoom 200% | PENDIENTE: solo viewport/visibilidad están expuestos; cinco atajos ctrl+plus no cambiaron ancho CSS ni DPR; no se registra como probado |
| CLS observado | Sin salto evidente por imágenes; banner mantiene altura antes de decodificar la foto. No es una medición productiva de Web Vitals |
| Protección | PASS: diff contra `a0fa613` sin cambios en tokens, base, Core, Bootstrap config, tooling, JS/HTML/PHP productivos, CSS/JS legacy, originales, sitemap, robots o .htaccess |

El contraste fotográfico se estima desde las cajas de líneas leídas en el navegador, el recorte cover/foco central y la composición radial final. Se muestrean las fuentes originales con un máximo conservador de píxeles vecinos antes de calcular luminancia; no se sustituye la fotografía por un fondo sólido ni se cuenta una sombra tipográfica. La primera distribución tonal dejaba insuficiente protección en bordes del Hero interior de escritorio; se corrigieron extensión y centro reduciendo la opacidad central. Para otra fotografía/contenido, volver a medir y revisar el recorte. Los tres formatos se analizaron como fuentes, sin afirmar pruebas de render en Firefox/Safari.

Evidencias locales: `C:/Users/Mike/.codex/visualizations/2026/10/12/01a12ee8-6679-7ae3-a5eb-c895d147987a/refinado-*`: capturas completas iniciales, capturas finales de viewport con sufijo `-final`, geometría de diez anchos, informes de contraste y recorrido de teclado. No se ejecutaron Firefox, Safari, lector de pantalla auditivo ni Apache/GoDaddy. La revisión manual de zoom 200% sigue pendiente. Dev conserva la advertencia Node `DEP0060` ya registrada, sin fallos de funcionamiento.

#### Performance del refinamiento

Mismo pipeline minificado y `gzipSync`, medido antes de cambiar `a0fa613` y después del refinamiento:

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Diferencia gzip |
|---|---:|---:|---:|---:|---:|
| CSS producto | 51345 | 53423 | 10089 | 10452 | +363 (+3.60%) |
| JS producto | 0 | 0 | 20 | 20 | 0 |

Incremento CSS bruto 2078 bytes: superposición y protección tonal, tipografía contextual, acciones equilibradas y composición tablet/CTA. No se añade CSS de guía al producto. El hash JS productivo continúa idéntico al histórico; los 20 bytes gzip representan un flujo vacío.

Fotografías y pesos sin cambios: cuatro instancias, tres URLs únicas; AVIF 197647 bytes totales, WebP 253960, JPG 581762 como alternativas, no suma de descargas. Recursos de markup: antes la guía única tenía cuatro imágenes y un script module Core; ahora Foundations/Core tiene cero imágenes de patrones y conserva ese module, mientras Patterns tiene las cuatro imágenes y cero modules propios. Ambas usan las dos hojas existentes y las fuentes existentes. Hay un documento HTML adicional al navegar entre páginas; los includes PHP no añaden requests. BrowserSync solo inyecta su cliente de desarrollo.

Nuevos archivos locales de guía: `patterns.php` y `partials/navegacion-guia.php`; se reutiliza el partial de demos. Cambios de presentación exclusivos en `_guia.scss`, de producto en los cuatro patrones; contratos/arquitectura/estándares actualizados. Guía UX/UI general en `docs/UX-UI-GUIDELINES.md`. Sin dependencias, JS nuevo, carrusel, migración productiva ni cambios en develop/main.

Próximo paso: abrir ambas rutas locales, probar zoom 200% en el navegador del usuario y confirmar la composición visual. No hay PR, merge, force push o deploy automático.
