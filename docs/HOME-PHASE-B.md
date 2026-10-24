# Home — base compartida y primeras secciones

2026-10-24. Rama `feature/home-experiences`. Revisión visual aprobada por el responsable del proyecto en la solicitud de cierre; sin activación comercial.

## Base y alcance

Árbol inicialmente limpio. `git fetch origin` confirmó el merge `d341d697761a5d5398ec64e4378a77b272132898` del PR #15 hacia `develop`; GitHub confirmó `merged: true`. `2cf3d08` es ancestro directo de ese merge. Se actualizó `develop` mediante avance rápido, se verificó divergencia 0/0 y se creó la feature desde esa base. Durante la construcción inicial no se crearon commits ni se hizo push, PR, merge de trabajo o deploy. La solicitud de cierre autoriza ahora un commit y push normal de esta feature; no autoriza PR, merge ni deploy.

Se integraron únicamente Welcome, Spanish Table, Footer y la base PHP compartida. Header y Hero conservan el diseño aprobado. `index.html` no cambia frente a `production-baseline` al ignorar finales CRLF: SHA-256 `0e8e79cf732c4080b58d8aa66968ca2e60fa6acf4b181e69986219ec927e1652`. No cambian módulos de patrones, Foundation, Core, originales multimedia, dependencias, backend, analítica ni otras secciones de Home.

## Estructura PHP y componentes

```text
home-preview.php             # Anfitrión local, noindex y 404 fuera de cli-server
includes/
  site.php                   # Datos públicos mínimos y rutas existentes
  header.php                 # Header aprobado, extraído sin alterar su marcado
  hero.php                   # Cuerpo editorial único: slider o estático/interior
  footer.php                 # Footer aprobado, sin cambios de diseño
  access.php                 # Modal de acceso existente, explícitamente demostrativo
  welcome.php                # Introducción editorial sin fotografía
  spanish-table.php          # Fotografía y relato gastronómico
```

Los cuatro componentes extraídos sustituyen sus ubicaciones anteriores bajo `style-guide/partials`; no quedan copias ni wrappers allí. `style-guide/navigation.php`, `partials/patrones-wave-1.php` y `partials/transacciones-wave-7.php` incluyen las mismas fuentes nuevas mediante `__DIR__`/`dirname`. El Hero interior de Patterns también consume `hero.php`, con título `cl-titulo-1`; el editorial conserva `cl-display`.

Los includes rechazan acceso HTTP directo con 404, no reciben rutas de petición y escapan sus datos dinámicos. No hay motor de plantillas, secretos, consultas ni lógica comercial. Los mapas del laboratorio siguen separados y no se importan desde Home. La ruta Home pública continúa siendo `/index.html`; el anfitrión local la sustituye explícitamente por `/home-preview.php` y declara Home activo.

Welcome reutiliza `cl-seccion--centrada`, eyebrow, tipografía Foundation y botón Core. Spanish Table reutiliza `cl-seccion--alterna`, grid Bootstrap, `cl-media-contenido` y acciones Core. Solo se añaden dos ajustes locales de composición: centrar la columna Welcome y conservar la mesa completa en 4:3 también en tablet. No se alteran estilos de los patrones compartidos.

Fotografía inspeccionada: `assets/images/gallery/tapas/the-clandestino-tapas-table-1.jpeg`, 2048×1536. Se reutilizan sus derivados AVIF y WebP existentes, sin archivos multimedia nuevos, con dimensiones explícitas, alt descriptivo, lazy loading y decoding async. La fotografía precede al relato en móvil y ocupa la columna izquierda desde md.

## Recursos y hosting

Home carga exclusivamente `home.css` y la entrada `dist/main.js`, además de fuentes y recursos compartidos; no carga CSS legacy, `style.new.css`, CSS/JS de guía ni fixtures. Se añaden al SCSS reducido los imports existentes de Media + Content y Footer, sin otra copia de Bootstrap.

`main.js` inicializa solamente el anfitrión optativo `[data-cl-site]`. El slider se importa dinámicamente si existe `[data-cl-escenas]`; Gulp/esbuild genera el chunk correspondiente mediante splitting ESM. Una composición estática no solicita ese módulo. El carrito neutral se conecta únicamente si existen su activador y modal. Cuenta y carrito mantienen el comportamiento demostrativo aprobado, sin autenticación ni checkout.

Compilar antes de cualquier futuro despliegue; el paquete deberá incluir **todos** los archivos generados de `assets/js/dist`, incluido el chunk del slider, CSS e iconos. No se necesita Node en el hosting. Gulp observa también `includes/**/*.php`. No se modifica Apache ni se activa esta vista local en producción.

## Rutas y contenido

| Acción | Destino comprobado |
|---|---|
| Our Story | `/about.html` |
| Explore the Tapas | `/tapas.html` |
| Reserve a Table | `/index.html#reservation` |
| Navegación y Footer | Rutas legacy existentes y anclas comprobadas; Home activa en Header |

La reserva conduce al formulario legacy: una solicitud no equivale a confirmación. No se envió ningún formulario durante QA. Experiences conserva su destino aprobado `/index.html#services`; no se reasigna a Spanish Table. No se inventan Gift Cards, Eventos ni otras rutas comerciales.

El copy visible se conserva en inglés, sin modificaciones durante el cierre. El teléfono ya utilizado en Header se comparte con Footer. Dirección, Maps, correo y perfiles sociales quedan omitidos hasta confirmar su publicación; no se heredan datos históricos automáticamente. Horarios vacíos muestran el aviso aprobado `Opening hours · awaiting confirmation.`. Los enlaces legales existentes no equivalen a una validación jurídica de sus contenidos.

## Verificación y evidencia

Servidor de revisión: `npm run dev` → http://localhost:3000/home-preview.php. Referencias: `/style-guide/navigation.php` y `/style-guide/patterns.php#patrones-media`.

| Verificación | Resultado |
|---|---|
| Git previo, merge #15 y base sincronizada | PASS |
| ESLint + Stylelint, `npm run lint` | PASS |
| `npm run build`, sin assets de guía en build | PASS |
| PHP lint de Home, siete includes y tres consumidores de guía | PASS |
| HTML estructural renderizado: anidamiento, IDs únicos, H1 único, imágenes, enlaces y botones | PASS; no certificación W3C |
| `probar-carrito.mjs`, `probar-cierre-comercio.mjs` | PASS |
| `git diff --check` | PASS |
| 390, 425, 768, 1024, 1280, 1440 y 2560 px | PASS: capturas revisadas, sin overflow, recortes de contenido ni recursos rotos |
| Header y Hero antes/después | PASS visual: 42 comparaciones, tres escenas por ancho. Repetición final: 40 exactas; dos con 6/9 píxeles fotográficos distintos y delta máximo de un canal de 1/255. Sin cambios de dimensiones, texto o controles; no se afirma igualdad binaria de las 42 imágenes finales |
| Footer frente al Style Guide | PASS: píxeles idénticos en 390/768/1440, con datos idénticos y componente aislado para excluir superposición sticky |
| Teclado, foco, drawer, Discover, Escape y retorno de foco | PASS; Escape cierra primero Discover y después drawer |
| Carrito y cuenta: apertura, Escape y foco | PASS; sin backdrops residuales |
| Hero: Home/End, autoplay y pausas | PASS: avance 0→1→2 real; hover/foco/scroll recuperan reproducción; reduced motion permite navegación manual |
| Rutas internas y anclas de navegación/CTA/Footer | PASS: HTTP 200 y anclas existentes; siete includes directos devuelven 404 |
| Página estática de QA con mismo anfitrión | Sin solicitud del chunk del slider; documento simulado solo en navegador |
| Consola y recursos de Home | Sin errores observados ni HTTP ≥400 en sesiones visuales |
| Contraste sólido de nuevas secciones/Footer | PASS: mínimo 6,13:1 en 27 muestras de texto/acciones; foco de teclado sólido de 2px verificado |

Evidencia fuera de Git: `C:/Users/Mike/.codex/visualizations/2026/10/24/01a16c90-5dce-73f0-a2c2-5d2b625561ae/home/`. `before-*`/`after-*`: comparación de componentes. `home-{ancho}.png`: capturas completas. `review-{ancho}.png`: copias reducidas para revisión. `visual.json`, `functional.json`, `autoplay.json` y `home.html`: registros de QA. Los scripts auxiliares permanecen en esa carpeta, sin dependencias nuevas en el repo.

Limitaciones: Chrome local, DPR 1; sin Safari/Firefox, dispositivos físicos, lector de pantalla auditivo, zoom real 200%, hosting GoDaddy/Apache ni métricas de campo. La comprobación de contraste de esta fase cubre superficies sólidas nuevas y Footer; el contraste fotográfico del Hero conserva su composición y evidencia aprobadas. BrowserSync emite el warning existente DEP0060, sin fallo de compilación. El cierre técnico no sustituye aprobación visual, confirmación de datos comerciales, validación de servicios ni autorización de publicación.

## Cierre técnico aprobado — 2026-10-24

La aprobación visual procede de la declaración expresa del responsable del proyecto en la solicitud «Cierre de Home Fase B». No se ha cambiado código ni composición durante el cierre; se actualiza únicamente este informe existente.

- Fetch remoto: `develop` y `origin/develop` siguen en `d341d69`, divergencia 0/0. Diff completo revisado, incluidos los siete archivos nuevos de `includes/`; no se incluyen temporales, capturas, outputs compilados ni archivos ajenos.
- Comparación de fuentes con `develop`: Header, Footer y acceso idénticos al retirar el guard de acceso directo; Hero idéntico al retirar ese guard y la opción de título interior. Los consumidores apuntan a una única implementación y Home no importa configuración ni módulos de demostraciones del Style Guide. El modal de cuenta conserva sus campos sintéticos aprobados y su aviso explícito, sin servicio comercial.
- Reejecutados lint, build, 11 PHP lint, HTML estructural renderizado, ambas suites Node existentes y `git diff --check`. El build genera main y su chunk de escenas presente, sin assets de guía ni sourcemaps. QA de navegador y evidencia de cierre en `closure-*` dentro de la misma carpeta externa indicada arriba.
- Composición comprobada en Chrome local a 390/425/768/1024/1280/1440/2560 px. Se conservan dimensiones, textos, controles y layout; 42 comparaciones de Header/Hero dentro de la tolerancia histórica de raster de 1/255. En la captura completa de 1024 px se observó una variación limitada a los píxeles de la fotografía de Spanish Table, con fuentes multimedia y encuadre intactos; el resto de la UI coincide. No se afirma igualdad binaria de esa fotografía. Footer volvió a coincidir con Style Guide a igualdad de datos en 390/768/1440; teclado, foco, drawer, modales, rutas, contraste, Hero estático sin chunk de slider y autoplay/pausas verificados.
- Hosting revisado por código y recursos locales: includes con rutas de filesystem confiables y nombres que coinciden con los archivos; URLs web desde la raíz del dominio. PHP nativo sin servicios persistentes y recursos precompilados, compatibles por diseño con hosting tradicional. La sintaxis existente requiere PHP 7.4 o superior; ejecución local en PHP 8.3.14. No se afirma prueba de Apache/cPanel/GoDaddy remoto ni se ha comprobado su versión de PHP. `home-preview.php` mantiene intencionalmente 404 fuera de cli-server; no es un cutover productivo.
- `index.html`, handlers de reservas/contacto, backend, módulos de patrones, fuentes multimedia, dependencias, configuración Apache y analítica sin cambios frente a `develop`. Las rutas legacy solo se consultaron mediante GET; no se enviaron formularios comerciales.

**HOME PHASE B READY FOR PR**
