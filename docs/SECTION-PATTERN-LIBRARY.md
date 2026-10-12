# Biblioteca de patrones de sección — UI-PATTERNS-02

Wave 1 implementa cuatro familias de presentación sobre Foundation/Core. **Pendiente de aprobación visual humana**: QA técnico no aprueba el diseño, ni autoriza PR, merge, deploy o Wave 2. Base comprobada: `develop` / `origin/develop` en `0053822`; rama `feature/ui-section-patterns-wave-1`.

## Composición y contratos compartidos

- `assets/scss/main.scss` importa `patterns/*` después de Foundation/Core. El resultado está en `style.new.css`; sin estilos exclusivos del laboratorio.
- Las demostraciones viven solo en `style-guide/partials/patrones-wave-1.php`, incluido con `require` y `__DIR__`. Se añaden cuatro enlaces de navegación en la guía.
- Contenedores y columnas: Bootstrap `.container`, `.row`, `.col-lg-*`. Solo breakpoint `lg` (992px), mediante mixin existente; botones Core cambian a ancho automático desde `md`.
- Tokens existentes para superficies, bordes, espaciado y texto. Sin modificar tokens/base, raíz, familias tipográficas ni escala; `cl-display` y `cl-titulo-1` son Foundation.
- Clases propias BEM en español; máximo tres niveles de anidación. Sin nuevas utilidades globales, dependencias, JS ni render dinámico.
- Cada sección lleva un título y `aria-labelledby` único. La página decide el nivel; la guía usa h2 para familias y h3 para ejemplos bajo su único h1.
- Navegación mediante enlaces reales: `tapas.html`, `wines.html`, `menu.html`, `contact.html#contact-form`. Consultar una mesa o evento no confirma disponibilidad ni una reserva. No hay transacciones ni promociones.

## `cl-seccion`

**Propósito:** ritmo vertical, encabezado editorial y acciones para contenido variable.

Estructura: `section.cl-seccion[aria-labelledby] > .container`, con `.cl-seccion__encabezado`, eyebrow opcional, heading nativo, `.cl-seccion__descripcion` y `.cl-seccion__acciones` opcionales; contenido después del encabezado.

Variantes: izquierda por defecto; `cl-seccion--centrada` centra texto/acciones y permite limitar el encabezado con una columna Bootstrap; `cl-seccion--alterna` usa fondo alterno. Ambas tienen un caso real en la guía. Padding vertical `--espacio-7`, y `--espacio-8` desde lg. No impone ancho editorial propio ni tamaño de título.

Reutiliza `cl-eyebrow`, `cl-boton`, headings y grid. `.cl-seccion__acciones` es el grupo compartido por las cuatro familias: flex con wrap y gap del sistema; un botón por fila en móvil por el contrato Core. Descripción secundaria ≥4.5:1. No necesita imágenes, JS ni estados comerciales. No añade cierre especial ni variantes sin demostración.

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

Estructura: `section.cl-hero[aria-labelledby]`, `picture.cl-hero__media > img.cl-hero__imagen`, y `.container.cl-hero__estructura > .row > .cl-hero__contenido.col-lg-6`. Dentro del panel: eyebrow, título elegido por la página, descripción y grupo de acciones compartidos.

Variantes: editorial por defecto con `cl-display`; `cl-hero--interior` reduce únicamente padding/margen del panel desde lg, y la demo utiliza `cl-titulo-1`. No exige h1 ni limita cantidad de texto. Un CTA interior y dos editoriales.

Móvil/tablet: fotografía 16:9 sobre el panel. Desde lg, imagen y contenedor comparten celda de grid; la imagen absoluta rellena esa celda y el contenido en flujo determina toda la altura, sin altura rígida. El panel opaco con `--color-fondo-alterno` conserva contraste independientemente del recorte. Las fotografías originales ya están oscuras: no reciben filtros ni overlays adicionales.

Imagen editorial: `bg/clandestino-usa.jpg`, foco central en barra/copas. Interior: `bg/the-clandestino-usa.jpg`, foco central en botellas. `object-fit: cover` no deforma; `--hero-foco` local opcional permite adaptar el punto focal a otra foto sin CSS por página. No es un token nuevo del sistema. Verificar el recorte cada vez que cambie la foto. Alt informativo en estos ejemplos; `alt=""` cuando una imagen futura sea puramente decorativa.

Accesibilidad: panel sin transparencia, foco Core sin clipping, DOM imagen → narrativa → enlaces. Rendimiento: dimensión física explícita, reserva de espacio móvil y altura estable por contenido en escritorio; no depende de JS. Las demos están después de Core y usan lazy loading. En una página futura donde el Hero sea LCP, **quitar `loading="lazy"`**, usar carga normal/eager y evaluar `fetchpriority="high"` en condiciones reales. No trasladar automáticamente el contrato de carga del laboratorio.

## `cl-media-contenido`

**Propósito:** narrativa con foto gastronómica/restaurante, párrafos, lista semántica breve y CTA opcionales.

Estructura: `.row.cl-media-contenido`, `.col-lg-6.cl-media-contenido__media > picture > img.cl-media-contenido__imagen` y `.col-lg-6.cl-media-contenido__contenido`. Se puede envolver en una sección identificada y `cl-seccion` para ritmo/superficie. La imagen permanece primero en el DOM.

Variantes: foto izquierda por defecto; `cl-media-contenido--invertido` cambia solo `order` de las columnas desde lg. Móvil/tablet apila foto y contenido en ambas. El orden accesible sigue imagen → texto, y los enlaces siguen en el mismo orden lógico; las fotos no son controles. No usar esta inversión si un contenido futuro introduce controles cuyo orden visual y de tabulación diverja.

Reutiliza grid, eyebrow, headings nativos y acciones/botón Core. Lista `<ul><li>` nativa, sin componente nuevo. La demo izquierda incluye lista y CTA; derecha presenta narrativa sin CTA/lista.

Fotos sin personas: tapas (`bg/clandestino-tapas.jpg`) y vinos (`bg/the-clandestino-usa.jpg`). Proporción visual 4:3 con cover y foco central; `--media-foco` es ajuste local opcional por foto. Width/height reales en HTML, ancho 100% y reserva de proporción antes de cargar. Lazy loading fuera del viewport. No fabrica fuentes responsive ni variantes de foto.

## `cl-banda-cta`

**Propósito:** invitación compacta a explorar o consultar, sin prometer operaciones completadas.

Estructura: `section.cl-banda-cta[aria-labelledby] > .container > .row.cl-banda-cta__fila`, columna de heading/descripción opcional y columna de `.cl-seccion__acciones.cl-banda-cta__acciones` con enlaces Core. Título obligatorio; uno o dos CTAs como en las demos, con nombres claros.

Las dos demostraciones usan el mismo patrón: tapas (un CTA; columnas 8/4) y encuentros (dos; 7/5). No se inventan modificadores para contar botones ni una paleta nueva. Superficie/borde semánticos existentes; padding 2rem/3rem desde lg. En móvil/tablet las columnas se apilan; acciones flexibles con wrap en escritorio, alineadas a la derecha. No trunca nombres ni fija altura. Sin imágenes ni JS adicional. El contraste y el foco proceden de Foundation/Core.

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

Abrir `http://localhost:3000/style-guide/#patrones-seccion` con `npm run dev`; recorrer Section system, Hero, Media + content y CTA band. Probar 390, 768 y 1280px, zoom 200%, Tab/Shift+Tab y foco. La protección Apache existente cubre guía y partials; PHP local ignora `.htaccess`. No se ejecutó Apache/GoDaddy localmente.

Comandos: `npm run lint`, `npm run build`, `php -l style-guide/index.php`, `php -l style-guide/partials/patrones-wave-1.php`. Build limpia CSS/JS de guía y sourcemaps; comprobar antes de reiniciar dev. Comprobar las cuatro familias en CSS producto y ausencia de `cl-guia`/`cl-muestra`.

Medición del mismo build minificado, con `node:zlib.gzipSync`, antes/después:

| Artefacto | Antes bytes | Después bytes | Antes gzip | Después gzip | Diferencia gzip |
|---|---:|---:|---:|---:|---:|
| `style.new.css` | 49168 | 51345 | 9707 | 10089 | +382 (+3.94%) |
| JS productivo `dist/main.js` | 0 | 0 | 20 | 20 | 0 |

El gzip de 20 bytes es solo la cabecera de un flujo vacío, no JS incorporado. SHA-256 de main idéntico: `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`. CSS crece 2177 bytes sin comprimir por layout responsive y cuatro familias; no hay duplicación de componentes Core. No se mide CSS dev con sourcemaps como si fuera producción.

Recursos añadidos a la guía: cuatro elementos picture/img y **tres URLs de imagen únicas** en el navegador compatible; la foto de vinos se reutiliza desde caché. Cero scripts, hojas enlazadas, fuentes o recursos decorativos adicionales. Payload fotográfico seleccionado: AVIF 197647 bytes; WebP 253960; JPG 581762 (totales alternativos, no acumulados). El navegador elige una fuente por picture. El partial se incluye en servidor y no añade request.

No se declara LCP/CLS de producción desde esta guía. Las metas se medirán al migrar páginas con condiciones comparables. La revisión de CLS aquí es observacional, junto a dimensiones/proporciones reservadas.

### Registro de QA

Verificado el 2026-10-12 en Chromium integrado. Wave 1 técnicamente implementada; **pendiente de aprobación visual humana**.

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

La guía debe permanecer disponible cuando sea práctico. Próximo paso: el usuario abre la guía local, verifica zoom 200% en su navegador y confirma el diseño. No iniciar Wave 2 automáticamente.
