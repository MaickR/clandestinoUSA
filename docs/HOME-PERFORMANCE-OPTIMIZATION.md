# Home R4 — rendimiento y preparación técnica

Trabajo local del 2026-11-03 al 2026-11-04, America/Bogota. Estado: **R4 APROBADA TÉCNICAMENTE — READY FOR PR**. El responsable del proyecto aprobó el cierre y autorizó el commit y push normal de `feature/home-performance` para un PR manual hacia `develop`. Home pública desactivada; sin creación automática de PR, merge ni deploy. Los estados de revisión siguientes se conservan como registro histórico.

## Resultado y alcance

La carga visual era el principal coste demostrado: Hero LCP, raster sobredimensionado dentro del logo y cuatro posters solicitados antes de llegar a Guest Stories. Se optimiza su entrega y la Gift Card conservando fotografía, selección editorial, SVG vectorial, encuadres, composición, copy y comportamiento. La mediana de LCP baja **24,5% / 17,8% / 21,5%** en 390 / 820 / 1440 px. La transferencia durante la navegación medida baja **24,8% / 14,3% / 15,5%**. CLS permanece igual.

Los LCP finales de este laboratorio siguen por encima de 2,5 s. Esto no declara aprobado el rendimiento de producción, la publicación, los servicios comerciales ni una conformidad WCAG completa. No hay RUM/CrUX de esta candidata: **INP y percentiles de campo no verificables**. TBT es exclusivamente un indicador de laboratorio.

## Base y protección del trabajo anterior

- `git fetch origin` confirmó R3 (`ca9046a`) integrada por PR #29 en `origin/develop`, merge `d143a1cfae8d82f6390f64528f537d7998c2c1bf`.
- `develop` avanzó mediante `git merge --ff-only origin/develop`; `feature/home-performance` nace de ese commit. No se hizo otro merge ni se modificó `main`.
- Se contrastó la raíz histórica de `production-baseline` con la arquitectura nueva. `index.html`, páginas legacy, formularios y autoridades históricas permanecen intactos. No se usa `master` como autoridad.
- Se leyeron AGENTS, arquitectura, estándares, UX/UI, Visual Direction, auditoría técnica, plan visual, R3, Gulp, Home y módulos compartidos. Se aplicó `.agents/skills/qa-visual/SKILL.md`.
- Los informes anteriores siguen sin seguimiento y con sus SHA256 originales:

| Informe preservado | SHA256 |
|---|---|
| `HOME-FINAL-AUDIT.md` | `49b97d8320715f61ac0bcaeae196e847c56b6f397ca971b29d9ccfce75932bcc` |
| `HOME-TECHNICAL-AUDIT.md` | `f7a3a637c4f9fb672af3f8edaeacf6f70a0d3f5aabd83cdd1c875c3edde79d68` |
| `HOME-VISUAL-ASSET-PLAN.md` | `68201e6cd72b41bd3365ddf3d31980f67b4f8ba2de2c2b396c372d2ee90e8690` |

Se verificó por hash que **todos los archivos originales de `assets/images`** coinciden con la copia inicial; esto incluye Pure Soul, sus derivados, originales del Hero y vídeos. El marcador `.home-public-enabled` no existe.

## Metodología reproducible

Evidencia externa **E**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a4d8-3b7a-7b13-a3cb-9e75c05022d6/home-r4/`. No forma parte del paquete para hosting. Contiene herramientas, copia inicial, informes JSON sin resumir, trazas, capturas y resultados de QA.

| Herramienta | Versión / uso |
|---|---|
| PHP | 8.3.14, servidor integrado, correo deshabilitado |
| Node | 24.11.1 |
| Lighthouse | 13.4.1, API Node, categoría Performance |
| Navegador | Chrome instalado, `HeadlessChrome/156.0.0.0`, Windows |
| Playwright | `1.62.0-alpha-1783623505000`, automatización y capturas |
| Build | Gulp 5.0.1, Sass 1.105.1, esbuild 0.28.2, cssnano 8.0.10 |
| Imágenes | sharp 0.35.4, libvips 8.18.6, libheif 1.23.2, libwebp 1.6.0; versiones completas en `derivatives.json` |
| HTML | Python + html5lib: parser, semántica, IDs, referencias y destinos |

Se reutilizaron las herramientas ya disponibles en caché local. No se instalaron dependencias ni se cambiaron `package.json` o el lockfile. `medir.mjs`, `visual.cjs`, `qa.cjs`, `contraste.cjs`, `diagnosticar-bloqueo.cjs` y `derivados.cjs` en E contienen los comandos y rutas exactas usados; sus rutas de herramientas deben adaptarse al repetir en otro equipo.

1. Se ejecutó `npm.cmd run build` antes de medir. Se copió el HEAD inicial y sus outputs reales a `E/baseline-site`; no se incluyen los tres informes locales en esa copia ni se altera el checkout original para servirla.
2. Se sirvió la candidata pública real `/` con `scripts/fixtures/home-public-router.php`, `CL_HOME_PUBLIC_REVIEW=1`, loopback y sin marcador: baseline `http://127.0.0.1:8014/`, final `http://127.0.0.1:8015/`. Ambas responden noindex y `Cache-Control: no-store, max-age=0`.
3. Lighthouse hizo **tres navegaciones por tamaño y fase: 18 pasadas válidas**. Se conservan todas; tablas con mediana y rangos, sin escoger la pasada más rápida. Sin reduced motion, ocultación de contenido, bloqueo de terceros, eliminación de funcionalidad ni calentamiento deliberado de caché.
4. Viewports: **390×844 DPR 3**, **820×1180 DPR 2**, **1440×1000 DPR 1**. `formFactor=mobile` en los dos primeros y `desktop` en el último. Misma red limitada en los tres, también en desktop: `throttlingMethod=simulate`, RTT 150 ms, 1638,4 Kbps y CPU ×4. Los parámetros de DevTools del perfil son 562,5 ms / 1474,56 Kbps descarga / 675 Kbps subida; en estas mediciones se utiliza simulación. No es el perfil desktop rápido predeterminado.
5. Chrome limpio administrado por Playwright; Lighthouse limpia almacenamiento según su configuración predeterminada. Google Fonts se solicita realmente. No se ejecutan builds, codificación de imágenes u otros navegadores de QA simultáneamente con las mediciones.
6. JSON completos: `{baseline,final}-{390,820,1440}-{1,2,3}.lhr.json`. Primera pasada por tamaño: `.trace.json` y `.devtools.json`. Resúmenes: `{baseline,final}-summary.json` y `comparison-metrics.json`.

La simulación y sus diferencias con DevTools se describen en la [documentación oficial de Lighthouse](https://github.com/GoogleChrome/lighthouse/blob/main/docs/throttling.md). La dispersión observada se comunica conforme a sus [límites de variabilidad](https://github.com/GoogleChrome/lighthouse/blob/main/docs/variability.md).

### Límites del entorno

PHP integrado no interpreta `.htaccess`, no reproduce TLS/HTTP2/CDN, compresión Apache ni los tiempos de GoDaddy. Los assets compilados son de producción, pero el transporte estático local está sin comprimir. Solo como referencia de tamaño, `home.css` final tiene 97.397 B y comprime a 16.554 B con gzip nivel 9; `main.js` tiene 35.223 B y comprime a 11.134 B. Estos tamaños comprimidos **no son mediciones de transferencia del hosting** ni sustituyen las tablas.

Google Fonts, el planificador de Windows y la carga del equipo introducen variación. `mainthread-work-breakdown` procede de la traza observada; no se presenta como tiempo real de un móvil físico ni se multiplica por cuatro para fabricar una métrica nueva. El rendimiento de campo y la caché caliente real quedan sin medir.

## Hallazgos y decisiones

| Prioridad | Evidencia | Decisión |
|---|---|---|
| P1 · LCP | Las 18 pasadas identifican la primera fotografía del Hero como LCP. WebP 1672 pesa 327.932 B | AVIF del mismo original; mantener eager/high, decode y escenas diferidas |
| P1 · logo | 285.557 B, dos raster embebidos de 1563 px para marca de 128–160 px CSS | Nuevo SVG exclusivo de Home; mismos trazados, máscaras, viewBox y transformaciones, raster internos a 768 px |
| P1 · posters | Cuatro posters, 156.496 B de contenido, se solicitan al inicio en baseline | `loading="lazy"` nativo en vídeo, conservando `preload="none"`, poster y controles |
| P1 · Gift Card | 3137 px para 240 px CSS máximos; 308.594 B | Derivado de 720 px; preservar proporción del arte y caja aprobada |
| P2 · selección Hero | `100vw` subestima la anchura necesaria para `cover` bajo lg | Slot mínimo de 960 px bajo lg y candidato AVIF 1024; mismo recorte y foco |
| Bloqueantes | Lighthouse identifica CSS Home, CSS Google Fonts y main con `blocking="render"` | Conservar: quitar bloqueo JS causa salto demostrado del Header; CSS/fuentes requieren el mismo aspecto y estados |
| CSS/JS sin usar | Cobertura inicial marca parte de Bootstrap/componentes | Registrar, sin purga automática ni nuevas dependencias; cobertura de carga no prueba que menús, media, fallback o preview no los usen |

La carga diferida nativa está descrita en [Chrome](https://developer.chrome.com/docs/modern-web-guidance/guides/performance/lazy-load-video-and-audio) y en el [contrato HTML de vídeo](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/video). Se confirmó `'loading' in HTMLVideoElement.prototype` en el navegador probado. Los navegadores sin soporte ignoran el atributo y conservan el comportamiento anterior; el ahorro de posters no se garantiza en ellos. Sin JS, poster y vídeo nativos siguen disponibles. No se añade un cargador alternativo.

### Cambios de entrega y efectos secundarios

| Recurso | Antes | Después | Diferencia |
|---|---:|---:|---:|
| Hero 1, 1672 px | 327.932 B WebP | 267.182 B AVIF | −60.750 B / −18,5% |
| Hero 2, 1672 px | 303.850 B WebP | 247.089 B AVIF | −56.761 B / −18,7% |
| Hero 3, 1672 px | 222.408 B WebP | 180.483 B AVIF | −41.925 B / −18,9% |
| Logo UI Home | 285.557 B | 115.881 B | −169.676 B / −59,4% |
| Gift Card | 308.594 B | 60.332 B | −248.262 B / −80,4% |

- Hero AVIF 1024: 147.074 / 137.203 / 101.657 B. Generados de PNG originales a calidad 70, esfuerzo 6, crominancia 4:4:4; sin crop, retoque o sustitución editorial. Los WebP y el fallback existentes siguen disponibles. En DPR 1 móvil se entrega más resolución para sostener `cover`; ese candidato puede pesar más que el antiguo WebP 768 subdimensionado. No se afirma ahorro por formato en cada combinación de navegador/DPR.
- Los 960 px representan el ancho ampliado de la fotografía bajo lg en composición normal, no una resolución extra del original. En 320–2560 px se comprueba la selección. Texto al 200% y pantallas extremas pueden superar la resolución nativa, igual que el original; no se fabrica detalle para 2560 px.
- La Gift Card se redimensiona con WebP calidad 95, alfa 100 y esfuerzo 6. Su caja conserva `aspect-ratio: 3137 / 2030`: evita una variación de 0,03 px por redondear el derivado a 720×466. Sin cambio de encuadre o arte.
- Logo: raster internos redimensionados a 768×768 y recodificados sin pérdida adicional, manteniendo la estructura SVG exactamente igual fuera de los datos embebidos. Se preservan original de marca y antiguo derivado UI. Home y preview consumen el nuevo; otras páginas conservan su configuración.
- El Hero ya tenía escenas 2/3 en `<template>`. Se mantiene: no se solicitan al inicio; se decodifican antes de activarse. No se añade preload redundante, precarga de las tres fotos ni lazy sobre LCP. La prioridad de la foto principal ya pasaba los checks de descubrimiento de Lighthouse.
- No cambió JS: `main.js` sigue en 35.223 B y SHA256 abreviado `33fc703676a510f5`. CSS suma **23 B** por la proporción explícita; hash final `2cf0fcf28f91b646`. Las entradas continúan versionándose por contenido desde PHP.

## Métricas antes y después

Medianas de tres pasadas; MB decimal. El volumen corresponde a la ventana de navegación de Lighthouse, **no a toda la página tras scroll y reproducción**. La Gift Card queda fuera de esa ventana: su ahorro se acredita separadamente por archivo.

| Viewport | Métrica | Baseline | Final | Delta absoluto | Delta % |
|---|---|---:|---:|---:|---:|
| 390 | Performance | 65 | 68 | +3 puntos | — |
| 390 | LCP | 7.971 ms | 6.020 ms | −1.951 ms | −24,5% |
| 390 | FCP | 2.688 ms | 2.680 ms | −8 ms | −0,3% |
| 390 | CLS | 0 | 0 | 0 | — |
| 390 | TBT | 304 ms | 274 ms | −30 ms | −9,9% |
| 390 | Hilo principal observado | 2.222 ms | 1.569 ms | −653 ms | −29,4% |
| 390 | Transferencia | 1.561.375 B | 1.174.689 B | −386.686 B | −24,8% |
| 390 | Solicitudes HTTP/S | 23 | 19 | −4 | −17,4% |
| 820 | Performance | 61 | 65 | +4 puntos | — |
| 820 | LCP | 8.872 ms | 7.296 ms | −1.575 ms | −17,8% |
| 820 | FCP | 2.685 ms | 2.673 ms | −12 ms | −0,5% |
| 820 | CLS | 0,000210 | 0,000210 | 0 | 0% |
| 820 | TBT | 393 ms | 326 ms | −67 ms | −17,0% |
| 820 | Hilo principal observado | 2.165 ms | 2.100 ms | −65 ms | −3,0% |
| 820 | Transferencia | 1.609.158 B | 1.379.552 B | −229.606 B | −14,3% |
| 820 | Solicitudes HTTP/S | 26 | 26 | 0 | 0% |
| 1440 | Performance | 43 | 46 | +3 puntos | — |
| 1440 | LCP | 8.044 ms | 6.314 ms | −1.730 ms | −21,5% |
| 1440 | FCP | 2.674 ms | 2.669 ms | −5 ms | −0,2% |
| 1440 | CLS | 0,000255 | 0,000255 | 0 | 0% |
| 1440 | TBT | 375 ms | 335 ms | −40 ms | −10,7% |
| 1440 | Hilo principal observado | 2.135 ms | 2.039 ms | −96 ms | −4,5% |
| 1440 | Transferencia | 1.484.287 B | 1.254.681 B | −229.606 B | −15,5% |
| 1440 | Solicitudes HTTP/S | 25 | 25 | 0 | 0% |

Los totales de `network-requests` también contienen recursos `data:` internos del navegador; se excluyen del recuento HTTP/S. Entradas brutas: 29→23, 32→32 y 31→31, respectivamente. Los bytes se toman sin cambiar de `total-byte-weight`.

En 390 los cuatro posters no se solicitan durante la ventana medida. En 820/1440 Lighthouse termina observándolos: el navegador puede anticipar medios próximos y Lighthouse inspecciona la página. Por eso no se atribuye una reducción de requests o de esos bytes a tablet/desktop. `native-video-lazy.json` prueba por separado el momento de solicitud antes/después del scroll en móvil. Cero MP4 antes de reproducción manual.

| Viewport | Rango Performance baseline → final | Rango LCP baseline → final | Rango TBT baseline → final |
|---|---|---|---|
| 390 | 54–65 → 67–70 | 7.967–8.014 → 5.976–6.023 ms | 293–645 → 240–293 ms |
| 820 | 60–63 → 59–65 | 8.869–8.873 → 7.227–7.302 ms | 347–439 → 311–527 ms |
| 1440 | 43–44 → 46–46 | 8.042–8.047 → 6.313–6.323 ms | 358–384 → 328–341 ms |

La reducción de bytes y el LCP se repiten. Los rangos de TBT y trabajo principal se solapan, especialmente en tablet: sus diferencias de mediana son observaciones, no una mejora garantizada de ejecución JS. FCP cambia menos de 13 ms, dentro de la variación; **no se declara mejorado**.

### Bloqueantes, fuentes y cobertura

`home.css` inicial pesa 97.374 B y el JS principal 35.223 B. Lighthouse identifica como bloqueantes CSS Home, CSS Google Fonts y el módulo principal. Las estimaciones de tiempo no se suman ni se convierten en ahorro conseguido.

Libre Bodoni conserva pesos 400/500 y cursiva 400, preconnect y `display=swap`; cuerpo en fuente de sistema. Se observan dos WOFF2, 43.198 B transferidos en conjunto. No se sustituye tipografía, se retira una variante o se cambia su entrega sin una comparación que justifique el coste visual y de caché externa.

Cobertura inicial CSS sin uso: **62.183 / 55.556 / 52.069 B** en 390 / 820 / 1440, antes y después. JS inicial sin uso: **21.865 / 21.865 / 22.010 B**. Se registran las advertencias; no acreditan código eliminable sin cubrir interacciones y preview. No se introduce PurgeCSS, CSS crítico duplicado ni un segundo build que fragmente el contrato compartido.

En `render-blocking-experiment.json` se ensayó únicamente en el navegador retirar `blocking="render"` y retrasar deliberadamente la respuesta de main 2,5 s. La suma diagnóstica de shifts pasa de **0,00622 a 0,52774**: la navegación fallback se pinta expandida y luego cambia a drawer. No son las métricas oficiales anteriores ni un escenario de producción. Se conserva el atributo para evitar esa regresión demostrada; rediseñar el bootstrap de navegación queda fuera de esta optimización de entrega. El [contrato de script](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/script) explica ese bloqueo explícito.

## QA e integridad visual

| Comprobación | Resultado y evidencia |
|---|---|
| `npm.cmd run lint` | PASS, ESLint y Stylelint |
| `npm.cmd run build` | PASS, recursos minificados reales, sin CSS/JS de guía |
| PHP lint | PASS, 65 archivos rastreados |
| Node | PASS: `probar-carrito.mjs`, `probar-cierre-comercio.mjs`, `probar-formularios.mjs`, `probar-home-publica.mjs` |
| Fechas PHP | PASS: `scripts/probar-fechas-formularios.php` |
| HTML público y preview | PASS: cero errores html5lib, H1/main únicos, 48/52 IDs únicos, relaciones y destinos locales válidos; `html-routes.json` |
| `git diff --check` | PASS |
| Responsive / overflow | PASS: 320, 360, 390, 425, 600, 768, 820, 992, 1024, 1280, 1440, 2560 px; todas las imágenes cargadas; `qa.json` |
| Teclado / foco | PASS a 390/820/1440: Skip→main, menú/Discover por Enter/Escape y retorno del foco, Hero Home/End/flechas, Guest Home/End; foco sólido visible |
| Hero | PASS: tres escenas, una sola activa/no inert; autoplay llega a segunda escena; pausa de usuario; reduced motion sin autoplay; fallback WebP en tres escenas |
| Guest Stories | PASS: vídeo nativo reproduce, avanza currentTime y pausa al navegar; controles y cuatro clips presentes. Poster tras aproximación, MP4 tras play |
| Sin JS | PASS a 390/820/1440: navegación expandida, primera escena/CTA y cuatro vídeos nativos; sin overflow |
| Texto 200% | PASS a 320/390/820/1440, incluida apertura/cierre del drawer; raíz 32 px mediante hoja exclusiva de QA. Es ampliación de texto, **no certificación de zoom nativo del navegador** |
| Consola / recursos | Cero errores/warnings observados y cero respuestas HTTP ≥400 durante QA normal |
| Contraste Hero final | PASS: 45 grupos de texto/CTA, tres escenas × 390/820/1440. Mínimo conservador **5,05:1**, sobre el fondo real en cajas de caracteres; `contrast-results.json`. No certifica todo el sitio ni cada frame |
| Integridad | PASS: originales fotográficos idénticos por hash, estructura SVG del logo idéntica fuera de raster embebidos, informes previos intactos, marcador ausente; `integrity-http.json` |

Comparaciones controladas con fuentes cargadas, DPR 1, reduced motion y lazy ya resuelto para comparar el mismo estado, sin alterar estas condiciones en Lighthouse. Capturas completas y por sección en **390, 820 y 1440 px**, más 768/1280 de la skill. Las tres escenas tienen pares individuales. Geometría final de 163 nodos en móvil/tablet y 159 en desktop: **cero diferencias** en cajas, copy normalizado, fuente, colores, object-fit y object-position en los cinco tamaños; `geometry-diff-normalized.json`.

La compresión cambia píxeles de la fotografía sin desplazar composición. MAE por canal de capturas Hero: 1,03–1,54 sobre 255, combinando codec y selección de resolución; no equivale a una garantía perceptual. Se inspeccionaron pares y láminas. Pure Soul y Discovery dan diferencia de píxeles cero en los tres tamaños. Las diferencias en la parte superior de algunas capturas de Wine Club/Gifting corresponden al Header sticky superpuesto, incluido su logo derivado y fase de scroll; no a fotografías o composición de esas secciones. No se usa una captura completa con escenas temporales distintas para afirmar regresión.

Evidencia de revisión: `comparison-sheet.jpg`, `compare-1440-wine-club.jpg`, `compare-1440-gifting.jpg`, `{baseline,final}-{ancho}-full.png`, `{baseline,final}-{ancho}-scene-{1,2,3}.png` y capturas individuales de secciones. No se reabre la selección de fotos ni la aprobación histórica; los derivados nuevos quedan sujetos a revisión humana de fidelidad.

## Caché, hosting y arquitectura

Se conserva `.htaccess` de R3 sin activar reglas globales nuevas. CSS/JS tienen TTL siete días y `must-revalidate`; sus entradas llevan query por hash de contenido y chunks llevan hash en nombre. Los derivados nuevos utilizan URLs nuevas, por lo que no dependen de invalidar las imágenes antiguas. No se aplica `immutable` nuevo a HTML o PHP. La Home devuelve `no-store` desde PHP incluso en `/`.

Compresión, tipos AVIF/WebP, headers y expires están protegidos por `IfModule`. Sin compresión disponible hay entrega normal; sin `mod_headers` los TTL avanzados no están garantizados y debe verificarse el comportamiento real, mientras PHP mantiene `no-store` del documento. No se convierte la disponibilidad local de PHP en una confirmación de Apache, AllowOverride o módulos. No se añaden reglas para contenido privado/dinámico ni se amplía el cacheo JSON genérico a una API nueva.

La arquitectura continúa siendo el documento PHP compartido, SCSS reducido y módulos existentes. No se modifica el build, componentes globales, backend, dependencias o sistemas comerciales. No hay nuevo proceso en hosting. Deben entregarse los ocho derivados y el paquete completo generado; conservar chunks anteriores durante TTL/sesiones abiertas según R3. Los informes y herramientas E no pertenecen al DocumentRoot del release.

## Reproducción y revisión local

La candidata final queda disponible en `http://127.0.0.1:8015/` y el baseline en `http://127.0.0.1:8014/`. Son servidores de revisión loopback con mail deshabilitada. Para iniciar otro ensayo, comprobar primero que los puertos estén libres y utilizar el router correspondiente, sin crear marcador:

```powershell
# Desde la raíz del repositorio, antes de abrir mediciones o QA.
npm.cmd run build
$env:CL_HOME_PUBLIC_REVIEW = '1'
php -d disable_functions=mail -S 127.0.0.1:8015 -t . scripts/fixtures/home-public-router.php
```

En otra consola, con baseline y final ya servidos:

```powershell
$r4Evidence = 'C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a4d8-3b7a-7b13-a3cb-9e75c05022d6/home-r4'
node "$r4Evidence/medir.mjs" baseline 3
node "$r4Evidence/medir.mjs" final 3
node "$r4Evidence/qa.cjs"
node "$r4Evidence/visual.cjs" final
python "$r4Evidence/validar-html.py"
```

Las mediciones deben ejecutarse de forma secuencial, sin build, QA o codificador concurrente. Las capturas normales y de texto/fallback se abren en E. La regeneración de derivados está en `derivados.cjs` y produce candidatos en E; el informe `derivatives.json` registra entradas, dimensiones, opciones y versiones. No genera ni sobrescribe originales.

## Pendientes reales y publicación futura

1. Revisar fidelidad de los nuevos derivados con los pares 390/820/1440. El cierre técnico no sustituye esa revisión ni autoriza publicación.
2. Repetir medición en Apache/staging representativo: gzip/brotli negociado, MIME AVIF/WebP/JS, `Cache-Control`, `Vary`, ETag, query versionada, perfil frío/caliente, HTTPS y respuesta del proxy. Verificar GoDaddy/cPanel/AllowOverride y Cloudflare reales, sin asumir módulos ni caché de HTML segura.
3. Los LCP de laboratorio siguen altos. Evaluar el presupuesto con transporte de hosting real antes de decidir otra intervención de fuentes/CSS/bootstrap de navegación. No se garantiza alcanzar 2,5 s con los cambios actuales.
4. Verificar Safari/Firefox/dispositivos físicos y zoom nativo. Navegadores sin lazy de vídeo conservarán posters eager. No se realizó lector de pantalla auditivo ni revisión completa de contraste fotográfico de todas las secciones/fotogramas.
5. Mantener los gates R3: alternativas accesibles/captions de Guest Stories, aprobación comercial de Pure Soul y destinos, validadores externos y recepción operativa de solicitudes. R4 no los resuelve ni activa módulos comerciales.
6. Solo un release autorizado desde `main`/tag podrá activar Home mediante el procedimiento y rollback de `HOME-PUBLIC-SEO.md`. Después, medir CWV de usuarios reales con datos suficientes; no publicar un INP inventado a partir de este QA.

## Archivos de R4

Modificados: `includes/home-document.php`, `includes/guest-stories.php`, `includes/gifting.php`, `assets/scss/home.scss`.

Nuevos: `assets/images/banner-the_clandestino_{1,2,3}-{1024,1672}.avif` (seis archivos), `assets/images/clandestino-logo-home.svg`, `assets/images/gift-cards/gift-card-720.webp` y este informe. CSS/JS compilados siguen ignorados por Git. Los tres informes históricos locales se preservan y no forman parte de los cambios R4.

**HOME R4 PERFORMANCE — WAITING FOR REVIEW**

## Revisión final del LCP residual — 2026-11-04

**Recomendación: cerrar técnicamente R4 y solicitar aprobación.** No se encontró un defecto local bloqueante que justifique modificar nuevamente la entrega o el diseño. Esta revisión cambia únicamente este documento; fuentes, build y ocho derivados conservan sus hashes iniciales. No se retira la animación aprobada ni el bloqueo del Header para mejorar una puntuación. Permanecen las validaciones de producción indicadas abajo.

Evidencia adicional en **E/final-review/**. Se revisaron las nueve pasadas finales existentes, sus tres trazas y logs de red conservados; no se inició otra auditoría general. Se repitieron las comprobaciones técnicas y funcionales sobre el build de producción. Los resultados originales de Lighthouse no se sobrescriben.

### Elemento real y dos escalas de tiempo distintas

En **las nueve pasadas finales** el LCP es el mismo `img.cl-hero__imagen` dentro de la primera escena: selector `div#home-fotografias > div.cl-hero > picture.cl-hero__media > img.cl-hero__imagen`. URL en los tres perfiles: `http://127.0.0.1:8015/assets/images/banner-the_clandestino_1-1672.avif`, HTTP 200, `image/avif`, 267.182 B de contenido / 267.329 B transferidos, prioridad de red **High**, `loading="eager"`, `fetchpriority="high"`, descubrimiento en el HTML inicial. No son LCP el logo, un titular, Pure Soul ni las escenas siguientes.

El valor principal de Lighthouse usa `throttlingMethod=simulate`. En cambio, **`lcp-breakdown-insight` presenta tiempos observados de la traza sin limitación aplicada**, no componentes del LCP simulado. No deben mezclarse ni interpretarse como si su suma tuviera que producir 6–7 s. La distinción está confirmada por [Lighthouse](https://github.com/GoogleChrome/lighthouse/issues/16947) y por el [código de LCPBreakdown de la versión utilizada](https://github.com/GoogleChrome/lighthouse/blob/v13.4.1/core/computed/metrics/lcp-breakdown.js), que omite render delay simulado. No se calcula uno artificial restando valores de ambas escalas.

Se muestra la pasada cuyo LCP coincide con la mediana de cada viewport, conservando componentes de **una misma navegación**, sin promediar ni sumar medianas independientes:

| Viewport / pasada | TTFB observado | Resource load delay | Resource load duration | Element render delay | Suma / LCP observado | LCP simulado |
|---|---:|---:|---:|---:|---:|---:|
| 390 / final-390-3 | 7,151 ms | 19,934 ms | 30,482 ms | 1.054,039 ms | 1.111,606 ms | 6.020,047 ms |
| 820 / final-820-1 | 8,194 ms | 46,294 ms | 25,310 ms | 1.087,249 ms | 1.167,047 ms | 7.296,406 ms |
| 1440 / final-1440-2 | 8,064 ms | 14,571 ms | 30,310 ms | 1.029,756 ms | 1.082,701 ms | 6.313,921 ms |

Las pequeñas diferencias frente a `observedLargestContentfulPaint` del audit `metrics` son redondeo a milisegundos. Rangos observados de las tres pasadas: **1.093–1.251 / 1.135–1.282 / 1.083–1.182 ms**, respectivamente. Son mediciones locales sin throttling aplicado, no rendimiento de un móvil real, CWV aprobados ni una nueva mejora frente a los valores simulados. Datos completos por pasada en `lcp-breakdown.json`.

### Causa del tiempo residual

**En la traza observada**, el archivo LCP termina pronto: 30–48 ms de duración en móvil y 21–48 ms en los demás perfiles. El TTFB de las nueve pasadas es de 7–15 ms. No hay evidencia de un PHP que tarde seis segundos en producir el documento. El mayor componente es el retraso de renderizado después de terminar la imagen.

La escena activa aplica `cl-hero-fotografia`, opacidad durante **720 ms**, junto con la animación del relato. Las trazas identifican esa animación sobre el `PICTURE` de Hero y sitúan el LCP **16–33 ms después de finalizarla** en las tres trazas guardadas. La separación FCP→LCP de las nueve pasadas es de 569–736 ms. Esto confirma su influencia en la presentación; no permite atribuir todo el render delay a la animación: también intervienen estilos, ejecución del bootstrap, fuentes, layout, decode y composición. Se conserva por el contrato visual. `animation-timing.json` registra timestamps; el instante de creación de la animación en la traza no se confunde con el inicio efectivo de todos sus frames.

**En el modelo simulado**, el coste principal restante es la transferencia y la competencia por ancho de banda. Se reconstruyó offline Lantern con los mismos logs, trazas, configuración y versión, sin alterar peticiones ni contenido. Reproduce exactamente los valores de la primera pasada de cada tamaño:

| Viewport | Estimación optimista | Estimación pesimista | Resultado de Lantern y del informe original |
|---|---:|---:|---:|
| 390 | 4.695,061 ms | 7.257,273 ms | 5.976,167 ms |
| 820 | 5.869,524 ms | 8.723,289 ms | 7.296,406 ms |
| 1440 | 4.672,246 ms | 7.973,569 ms | 6.322,908 ms |

La versión usada combina esas estimaciones con coeficientes 0,5 / 0,5; no es un INP ni un promedio de usuarios. En los seis grafos el recurso Hero es el último nodo relevante para esa estimación. Logo, CSS, fuentes, JS y fotos lazy de prioridad baja comparten transporte y pueden retrasar su finalización simulada, aunque esas fotos secundarias no sean el elemento LCP. No se suman sus duraciones como si fueran descargas consecutivas. `lantern-model.json` conserva nodos y tiempos; `modelo-lcp.mjs` reproduce el cálculo con los artefactos históricos. Es una reconstrucción, **no una nueva medición de navegación ni un antes/después**.

Condiciones determinantes, conservadas sin cambios: RTT 150 ms, 1638,4 Kbps y CPU ×4 simulados, también en desktop; perfiles 390×844 DPR 3, 820×1180 DPR 2 y 1440×1000 DPR 1. El servidor observado es PHP integrado, HTTP/1.1, recursos locales sin compresión de transporte. El modelo ve 97.397 B de CSS y 115.881 B de SVG, además del AVIF de 267.182 B y otras solicitudes. El PNG original no se descarga para pintar Hero. No se atribuye el resultado únicamente al peso del AVIF ni únicamente a la CPU.

CSS Home y Google Fonts siguen siendo bloqueantes; main conserva su bloqueo explícito para la mejora de navegación. En las primeras pasadas conservadas, CSS Home finaliza a 68–83 ms desde navegación, main a 74–83 ms y CSS de fuentes a 143–282 ms; los dos WOFF2 terminan a 220–367 ms. Influyen en el arranque, pero esos tiempos observados no explican por sí solos seis segundos de espera real. El cuerpo sigue usando fuente de sistema y Libre Bodoni mantiene `display=swap`. No se ha demostrado una mejora segura adicional por cambiar fuentes, extraer CSS crítico o eliminar componentes. Se conserva la evidencia previa del salto del Header al quitar `blocking="render"`.

La compresión y HTTP/2/HTTPS del hosting pueden cambiar sustancialmente ese grafo. La configuración Apache ya contempla compresión condicional; PHP integrado no la ejecuta. **No se estima un LCP de GoDaddy a partir de esta reconstrucción** ni se considera el resultado un falso positivo demostrado: existe un presupuesto de transferencia real que debe comprobarse bajo su transporte final.

### Primera escena y escenas posteriores

La primera foto está en el documento y se solicita inmediatamente con prioridad alta. Las escenas 2/3 permanecen dentro de `template`; no hay peticiones de sus AVIF/WebP/PNG durante la carga inicial verificada. El intervalo de autoplay es **6500 ms reales después de programar el estado activo**, no el LCP simulado de 6–7 s. Las trazas originales terminan antes de ese primer cambio automático.

Al navegar, el módulo materializa únicamente la escena destino, cambia su imagen a eager, conserva la prioridad low declarada y espera `decode()` antes de activarla. Esa espera protege la transición frente a una foto sin cargar; no retrasa la imagen LCP inicial. La reproducción automática y la selección manual se han probado, así como pausa de foco/usuario y reduced motion. No se precargan las tres fotos ni se añade un preload duplicado.

### Verificación de los ocho derivados

`derivatives-http.json` contiene SHA256, HTTP, MIME y dimensiones reales de cada archivo. Todos responden HTTP 200 con bytes idénticos a los archivos del repo:

| Derivado | Dimensiones | Peso | MIME |
|---|---|---:|---|
| Hero 1 / 1024 | 1024×576 | 147.074 B | image/avif |
| Hero 1 / 1672 | 1672×941 | 267.182 B | image/avif |
| Hero 2 / 1024 | 1024×576 | 137.203 B | image/avif |
| Hero 2 / 1672 | 1672×941 | 247.089 B | image/avif |
| Hero 3 / 1024 | 1024×576 | 101.657 B | image/avif |
| Hero 3 / 1672 | 1672×941 | 180.483 B | image/avif |
| Logo Home | SVG 231,58888×105,92984; viewBox original | 115.881 B | image/svg+xml |
| Gift Card | 720×466 | 60.332 B | image/webp |

Los AVIF conservan el lienzo y foco de la fotografía; el redondeo 1024×576 no introduce un nuevo crop editorial. Se verificaron nitidez, recortes y continuidad con las capturas R4 y las nuevas capturas de las tres escenas. La lámina `hero-continuity.jpg` compara la candidata R4 con esta revisión. La Gift Card mantiene detalle del arte a su tamaño visible y proporción CSS original. El logo mantiene trazados y máscaras, con raster internos embebidos: no tiene referencias a archivos temporales.

`srcset` ofrece AVIF 1024/1672 y WebP 768/1672, con `sizes="(min-width: 992px) 100vw, max(100vw, 960px)"`. En los perfiles originales se selecciona 1672; en los ensayos DPR 1 móvil se selecciona AVIF 1024. El `naturalWidth` que informa un navegador puede estar corregido por la densidad del candidato; las dimensiones de archivo de la tabla se obtienen del binario. Se conserva WebP como fallback y la foto inicial funciona sin JS. No existe un intento de fallback mediante respuesta 404 al AVIF: la selección de formato corresponde al soporte del navegador.

Se ensayaron **Chrome 156.0.8078.80 y Firefox 151.0** en 390/820/1440, con las tres escenas y Gift Card/logo correctamente decodificados. En cada navegación, visitar las tres escenas produce **exactamente tres solicitudes únicas de Hero**, sin descargar simultáneamente sus alternativas WebP o PNG. Firefox no implementa `loading` de vídeo en el binario probado: conserva los posters eager y los controles nativos; no es un fallo de imagen ni se promete en él el ahorro de posters observado en Chrome.

El primer intento de QA Firefox pidió `decode()` de la Gift Card mientras todavía estaba fuera de su zona lazy. Al aproximar el elemento real antes de comprobarlo, la prueba pasa; no se cambió el producto para corregir el instrumento. Safari/dispositivos físicos continúan pendientes: la sesión WebKit disponible no llegó a estar operativa y no se toma como una validación de Safari. El proyecto no declara aquí una matriz mínima de versiones adicional.

Las URLs de producción consumidas por PHP/HTML apuntan a `/assets/...` dentro del repo. No hay referencias a E, `candidates`, caché npm o Temp en la entrega de estos recursos. Las herramientas externas solo sirven para reproducir QA/generación y no son dependencias de ejecución del sitio. No se instalaron librerías.

### QA repetido, comparabilidad y decisión

- PASS: lint, build, PHP lint de 65 archivos, cuatro suites Node, prueba PHP de fechas y `git diff --check`; logs nuevos en `E/final-review/`.
- PASS: QA funcional repetido en los 12 anchos anteriores, incluyendo 390/820/1440 y los límites 320/768/992/1024/1280; teclado, foco, menú, Hero, autoplay, pausa, reduced motion, vídeo y fallback WebP. Sin JS a 390/820/1440 y texto 200% a 320/390/820/1440. Cero errores de consola o respuestas HTTP de error en ese ensayo. Resultados en el nuevo `qa.json`.
- PASS: continuidad de las tres escenas, selección responsive y ausencia de descargas duplicadas en Chrome/Firefox; capturas y `derivatives-browsers.json`. Se conserva el QA visual previo de geometría/contraste, pues las fuentes y los recursos son idénticos por hash. No se declara otra certificación WCAG.
- Sin cambio de producto: el build regenerado tiene los mismos hashes y tamaños que al iniciar esta revisión. Por ello se conservan como referencia comparable las nueve pasadas finales y el antes/después R4 anterior; no se inventa una mejora adicional ni se comparan mediciones con otra red como si fueran equivalentes. Las reconstrucciones offline reproducen exactamente sus tres informes de referencia.
- Originales, ocho derivados, fuentes R4 y tres informes históricos permanecen intactos; únicamente se amplía este documento. Sin marcador, commit, push, PR, merge o deploy.

**Decisión concreta:** no hay un defecto local bloqueante de descubrimiento, prioridad, doble descarga, formato, fuente temporal o transición que resolver antes de cerrar R4. Conservar la implementación actual y someter el cierre a aprobación. Antes de publicar, medir en Apache/GoDaddy con compresión negociada, HTTP/HTTPS y política CDN verificadas, validar Safari/dispositivos objetivo y mantener los gates audiovisuales/comerciales R3. Si el LCP real de staging sigue excediendo el presupuesto, abrir una intervención específica sustentada en esa traza; este resultado no autoriza alterar la animación aprobada o los encuadres.

**HOME R4 PERFORMANCE FINAL REVIEW — WAITING FOR APPROVAL**

## Cierre definitivo aprobado — 2026-11-04

El responsable del proyecto aprobó técnicamente R4 y confirmó el diagnóstico final sin defectos locales bloqueantes. Se cierra la fase preservando exactamente las optimizaciones y derivados revisados. No se introducen nuevas optimizaciones, cambios de composición, selección editorial o dependencias.

El paquete del commit `perf(home): optimizar carga y recursos visuales` se limita a cuatro fuentes (`includes/home-document.php`, `includes/guest-stories.php`, `includes/gifting.php`, `assets/scss/home.scss`), seis AVIF responsive del Hero, un derivado SVG del logo, un derivado WebP de Gift Card y este documento: **13 archivos**. Los originales, Pure Soul, la Home legacy y los tres informes locales no rastreados se preservan y quedan fuera del commit. El diff se contrasta con `origin/develop`; no se modifica `main` ni se crea el marcador de activación.

Se mantienen las mejoras medidas y el diagnóstico documentado: LCP simulado 7,97→6,02 / 8,87→7,30 / 8,04→6,31 s en 390/820/1440, transferencia −24,8% / −14,3% / −15,5%, logo −59,4%, Gift Card −80,4% y CLS sin regresión. Las limitaciones de simulación, el desglose observado y la reconstrucción de Lantern anteriores siguen vigentes; no se declaran INP, percentiles o métricas de usuarios reales inexistentes.

Validación de cierre: lint, build, PHP lint, suites Node, HTML, rutas/MIME de los ocho derivados y `git diff --check`. Evidencia nueva en **E/close/**. La evidencia funcional y visual extensa de `E/final-review/` conserva su validez porque los hashes de fuentes, build y derivados no cambiaron: tres escenas, autoplay/pausa/navegación, Guest Stories, teclado/foco, reduced motion, fallback WebP/sin JS, responsive y continuidad visual. No se repiten mediciones extensas ni se atribuyen mejoras nuevas a este cierre documental.

Pendientes antes de producción: validar Apache/GoDaddy, compresión, caché y MIME efectivos, HTTPS/HTTP2 y comportamiento de Cloudflare; Safari y dispositivos físicos; mantener los gates audiovisuales y comerciales de R3. **Cuando se seleccionen fotografías definitivas, habrá que regenerar sus derivados desde esos originales, revisar dimensiones/srcset/sizes, encuadres, fidelidad y contraste, y repetir las mediciones afectadas.** Los derivados actuales no deben reutilizarse para otra fotografía ni sobrescribirse bajo una URL ya cacheada sin una política explícita de versión.

La aprobación técnica y la publicación de la rama habilitan únicamente el PR manual hacia `develop`. La activación pública continúa requiriendo un release autorizado conforme a R3; este cierre no incluye merge, deploy ni activación comercial.

**HOME R4 READY FOR PR**
