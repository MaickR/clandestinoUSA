# Home R7 — preparación de publicación y ensayo operativo

2026-11-07 · America/Bogota · **R7 APROBADA TÉCNICAMENTE — READY FOR PR. Home pública desactivada.**

## Cierre definitivo aprobado — 2026-11-07

El responsable del proyecto aprueba técnicamente R7 para integración en `develop` mediante PR manual. Se autoriza el commit `build(home): preparar paquete seguro y despliegue reproducible` y el push normal de `feature/home-deployment-readiness` a origin. No se autoriza crear PR automáticamente, hacer merge, desplegar, modificar main ni activar la Home pública. Los estados anteriores de revisión y las restricciones de Git registradas debajo pertenecen a los ensayos previos; este cierre prevalece para la publicación de la rama.

El diff completo contra `origin/develop` se limita a **siete archivos**: `.htaccess`, `includes/.htaccess`, `scripts/empaquetar-home.mjs`, `scripts/ensayar-home-apache.mjs`, `scripts/fixtures/forms-apache-prepend.php`, `docs/ARQUITECTURA.md` y este informe. Solo comprende seguridad Apache/caché, empaquetado, ensayo aislado y documentación. No cambia HTML/PHP de producto, GSAP, Header, breakpoint, SCSS, fotografías, vídeos, textos o dependencias. Se corrigen únicamente líneas vacías finales detectadas al incorporar los archivos nuevos al índice.

### Verificación de cierre

| Comprobación | Resultado |
|---|---|
| Rama y base | Exclusivamente feature/home-deployment-readiness; origin/develop permanece en 5b24a90656798128abc7906b3e5c50df1b299d0b después de fetch |
| Instalación, lint y build | PASS: npm ci, npm run lint (JS y SCSS) y npm run build; sin cambios en package.json/lockfile ni dependencias nuevas |
| PHP y suites Node | PASS: 66 PHP; carrito, cierre comercial, 126 casos de formularios, 72 contratos Home pública y 27 comprobaciones de fechas/sesión |
| Empaquetador/manifiesto | PASS: 844 archivos, 347.384.141 bytes (331,291333 MiB); archivos reales y hashes verificados, payload idéntico al aprobado; rechazo de sobrescritura sin alterar el paquete existente |
| Exclusiones y medios | Solo welcome.php y spanish-table.php fuera del paquete; ambos originales conservados. Todos los recursos audiovisuales del inventario aprobado permanecen sin cambios |
| Seguridad | Sin secretos/material privado detectados; sin .git, .env, node_modules, informes, fixtures, logs, backups o fuentes de desarrollo en web; manifiesto fuera del document root |
| Apache crítico | PASS: 85 comprobaciones locales Apache/FastCGI/TLS, incluidas denegaciones, rutas, MIME operativo, caché, formularios con transporte simulado, activación y rollback aislados |
| Integridad operativa | Marcador ausente en checkout y entregable; los tres informes históricos continúan sin seguimiento, con sus SHA256 originales; git diff --check sin incidencias tras normalizar EOF |

Evidencia de cierre: `C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b50a-94d6-7253-a14b-6dac8b7a01b1/home-r7/closure/`. Se conserva la validación extensa de navegador/HEAD de la revisión anterior porque no cambió ningún archivo servido del paquete; no se repite Lighthouse ni otra auditoría visual. Los seis avisos de tooling ya documentados no motivan actualizaciones especulativas en este cierre.

**GO técnico para staging autorizado; NO-GO para publicación directa.** Siguen pendientes la cuenta real de GoDaddy/PHP/Apache y sus permisos, correo real autorizado, Cloudflare y confianza del proxy, HTTPS/certificados, caché, backup/restauración real y aprobaciones editoriales/audiovisuales correspondientes. Los tres iconos PWA legacy ausentes y los cinco JFIF de reserva sin MIME explícito en el laboratorio permanecen documentados, sin ampliar esta fase.

**Después de las imágenes definitivas de R8 será obligatorio regenerar el paquete.** Ejecutar instalación/build y empaquetador sobre el release main/tag aprobado, producir un manifiesto nuevo y repetir integridad, dependencias/rutas, caché/versionado y las pruebas afectadas por los recursos cambiados. Los 844 archivos y 331,3 MiB corresponden al inventario actual, no a una promesa del tamaño posterior a R8. El artefacto local actual sirve para revisión/ensayo y no debe reutilizarse como release definitivo sin esa regeneración.

---

## Revisión final del paquete — 2026-11-07

**Estado vigente: GO técnico para staging autorizado; NO autoriza publicación.** El peso inicial no era el peso transferido al visitar Home: era el inventario conservador de toda la web, con galerías, catálogos, fallbacks, originales y vídeos legacy.

La revisión se limita a empaquetado, dependencias e integridad. No repite auditoría visual, Lighthouse, SEO general ni diseño. Cambian únicamente la regla de inclusión de dos PHP en `scripts/empaquetar-home.mjs` y este informe. Los cambios anteriores de R7 en Apache/arquitectura permanecen sin nuevas modificaciones.

### Resultado y cambio mínimo

| Versión | Archivos | Bytes exactos | MiB |
|---|---:|---:|---:|
| Paquete inicial conservado | 846 | 347.386.519 | 331,293601 |
| Paquete final | **844** | **347.384.141** | **331,291333** |
| Diferencia | −2 | −2.378 | −0,002268 |

El redondeo sigue siendo **331,3 MiB**. No se fuerza una reducción de medios para aparentar una optimización.

Se excluyen exclusivamente `includes/welcome.php` (779 bytes) y `includes/spanish-table.php` (1.599 bytes). Se revisaron todos los require/include de los anfitriones y partials actuales: Home usa Discovery, cuyo marcado incorpora esa bienvenida; ninguno carga esos dos PHP ni selecciona un include mediante una entrada del visitante. Tampoco son endpoints públicos. La prueba de Home pública, formularios y páginas legacy pasa después de retirarlos **solo de la lista de empaquetado**.

Ambos originales siguen en el repositorio, con los mismos hashes que en el paquete inicial. No se eliminó ni modificó ningún HTML, partial de producto, JS/GSAP, SCSS, Header, fotografía, vídeo, dato comercial o dependencia. Los otros **844 archivos son idénticos por SHA256** a sus versiones iniciales, después de instalación limpia y build. La diferencia entre manifiestos es exactamente esa pareja.

El paquete inicial se conserva en `.dist/home-r7-initial-846/`; el nuevo entregable limpio está en `.dist/home-r7/`. El respaldo se movió solo después de comprobar sus rutas absolutas dentro de `.dist`; no se borraron versiones ni informes.

### Desglose de los 331,3 MiB

| Tipo en assets/images | Archivos | Bytes | MiB | % del paquete inicial |
|---|---:|---:|---:|---:|
| Vídeos MP4 | 20 | 246.358.094 | 234,945387 | 70,918 % |
| Raster originales/legacy: JPEG/JPG/JFIF/PNG | 239 | 59.689.417 | 56,924264 | 17,182 % |
| Entrega AVIF/WebP | 507 | 38.966.859 | 37,161693 | 11,217 % |
| SVG de imágenes/logos | 7 | 1.061.147 | 1,011989 | 0,305 % |
| .htaccess de posters | 1 | 315 | 0,000300 | <0,001 % |

**Fotografías y arte raster acumulados: 98.656.276 bytes (746 archivos; 94,085957 MiB).** El grupo incluye posters, gift cards y arte, además de fotografía: no se ha realizado una clasificación editorial de R8. “Original/legacy” y “AVIF/WebP” son categorías de formato/entrega para contabilizar bytes, no una afirmación de que cada JPEG sea un master ni de que cada WebP tenga un original equivalente distribuido.

Todos los medios se conservan sin cambios. Assets/images acumula **346.075.832 bytes**; el resto de la aplicación final suma **1.308.309 bytes**. El tamaño de disco del paquete no implica descargar los 20 MP4 en cada visita; no se reproduce vídeo automáticamente ni se cambia preload.

Distribución final por grupos disjuntos, sumables:

| Directorio/grupo | Archivos | Bytes |
|---|---:|---:|
| raiz | 20 | 526.203 |
| assets/css | 7 | 387.650 |
| assets/favicon | 7 | 77.602 |
| assets/icons | 2 | 13.121 |
| assets/images | 774 | 346.075.832 |
| assets/js/dist | 5 | 170.125 |
| assets/js | 11 | 72.143 |
| includes | 18 | 61.465 |
| **Total** | **844** | **347.384.141** |

Detalle de **archivos directos** por directorio, sin sumar otra vez sus subdirectorios. Esta tabla también es sumable; todos los medios tienen los mismos tamaños inicial/final:

| Directorio | Archivos | Bytes directos |
|---|---:|---:|
| assets/images/gallery/videos | 20 | 246.358.094 |
| assets/images | 74 | 24.994.327 |
| assets/images/gallery/tapas | 52 | 12.975.847 |
| assets/images/gallery/wines | 34 | 8.027.027 |
| assets/images/webp/gallery/tapas | 52 | 5.668.332 |
| assets/images/bocatas | 23 | 4.483.588 |
| assets/images/avif/gallery/tapas | 52 | 3.975.119 |
| assets/images/gallery | 14 | 3.432.188 |
| assets/images/webp/gallery/wines | 34 | 3.388.186 |
| assets/images/avif/gallery/wines | 34 | 2.352.661 |
| assets/images/wines | 50 | 2.314.439 |
| assets/images/gold | 11 | 2.171.395 |
| assets/images/webp/bocatas | 23 | 2.011.370 |
| assets/images/paella | 5 | 1.782.420 |
| assets/images/hampers | 13 | 1.692.306 |
| assets/images/bg | 12 | 1.575.415 |
| assets/images/gift-cards | 8 | 1.557.790 |
| assets/images/webp/gallery | 14 | 1.536.476 |
| assets/images/diamond | 5 | 1.518.625 |
| assets/images/avif/bocatas | 23 | 1.433.098 |
| assets/images/gallery/quesos | 8 | 1.381.856 |
| assets/images/avif/gallery | 14 | 1.076.684 |
| assets/images/webp/gold | 11 | 946.320 |
| assets/images/webp/wines | 28 | 877.138 |
| assets/images/webp/paella | 5 | 834.598 |
| assets/images/webp | 26 | 761.624 |
| assets/images/avif | 26 | 685.330 |
| assets/images/avif/gold | 11 | 677.508 |
| assets/images/webp/diamond | 5 | 667.628 |
| assets/images/avif/paella | 5 | 635.466 |
| assets/images/avif/wines | 28 | 632.280 |
| assets/images/webp/gallery/quesos | 8 | 623.832 |
| assets/images/chocolate | 3 | 530.421 |
| Raíz (archivos directos) | 20 | 526.203 |
| assets/images/avif/diamond | 5 | 466.679 |
| assets/images/webp/bg | 8 | 458.916 |
| assets/images/avif/gallery/quesos | 8 | 418.403 |
| assets/css | 7 | 387.650 |
| assets/images/avif/bg | 8 | 331.277 |
| assets/images/events | 1 | 234.543 |
| assets/images/webp/chocolate | 3 | 185.276 |
| assets/js/dist | 5 | 170.125 |
| assets/images/guest-stories | 5 | 156.811 |
| assets/images/avif/chocolate | 3 | 101.762 |
| assets/images/webp/events | 1 | 89.928 |
| assets/favicon | 7 | 77.602 |
| assets/js | 11 | 72.143 |
| includes | 18 | 61.465 |
| assets/images/avif/events | 1 | 52.849 |
| assets/icons | 2 | 13.121 |

### Los diez archivos más pesados

Todos están en `assets/images/gallery/videos/` y suman **189.842.016 bytes**. Son vídeos existentes, conservados íntegros; los diez tienen consumidores literales en las páginas legacy.

| Archivo | Bytes |
|---|---:|
| clandestino-user-6.mp4 | 34.275.209 |
| clandestino-user-5.mp4 | 27.686.048 |
| clandestino-user-7.mp4 | 22.124.416 |
| Cliente-2.mp4 | 20.290.264 |
| clandestino-promo-4.mp4 | 17.780.734 |
| clandetino-user.mp4 | 17.432.868 |
| Cliente-4.mp4 | 14.762.320 |
| clandestino-promo-3.mp4 | 13.930.496 |
| cliente-6.mp4 | 11.048.863 |
| Client-1.mp4 | 10.510.798 |

### Dependencias confirmadas y reservas conservadas

Se cruzaron el manifiesto completo, HTML/PHP, require/include, URLs CSS, imports de chunks, JSON del manifiesto web y DOM real de Home + las 12 páginas legacy. Se observaron también los catálogos construidos por JavaScript: **13 hampers, 17 tapas y 26 vinos**. Galería usa href/src del DOM; wines/tapas construyen AVIF/WebP y fallbacks; hampers construye rutas desde claves basket; PHP compone variantes del Hero y Guest Stories. No se trató una búsqueda literal como prueba suficiente de uso o desuso.

Clasificación mutuamente excluyente de los 844 archivos, en orden de prioridad:

| Categoría | Archivos | Bytes |
|---|---:|---:|
| contrato-operativo | 23 | 527.808 |
| dinamico-potencial | 230 | 37.952.223 |
| generado-confirmado | 98 | 5.207.508 |
| referencia-exacta | 339 | 259.029.373 |
| reserva-sin-consumidor-identificado | 154 | 44.667.229 |

- **contrato-operativo:** hosts, documentos/rutas conservados, autorización Apache, robots/sitemap y licencia. No requieren que otra página contenga su ruta literal para ser necesarios.
- **referencia-exacta:** ruta hallada en el código, un require/import resuelto o URL CSS. Una mención textual demuestra referencia, no que todo visitante la descargue.
- **generado-confirmado:** ruta completa ausente en la búsqueda literal pero presente en el DOM construido por PHP/JS.
- **dinamico-potencial:** familia de catálogo o stem relacionado con código que compone rutas; **es un indicio, no consumo demostrado**. Se conservan 230 archivos por prudencia.
- **reserva-sin-consumidor-identificado:** 154 archivos, **44.667.229 bytes**, sin consumidor identificado en este alcance. No se afirma que estén obsoletos ni se eliminan automáticamente.

El inventario individual, con ruta, bytes, hash, categoría, referencias e indicios, se conserva en **E2/dependency-final.csv** y **E2/dependency-final.json**. Los 384 archivos de las dos últimas categorías no se presentan como dependencias todas demostradas ni como candidatos todos eliminables. **Este paquete es conservador y funcionalmente verificado; no se certifica como el mínimo absoluto por análisis estático.**

Reservas relevantes:

- Dos vídeos sin consumo identificado: `clandestino-wine-promo.mp4` (7.554.540 bytes) y `cliente-6.mp4` (11.048.863 bytes). Se mantienen; no se descarta un recurso publicado por faltar una referencia actual.
- `clandestino-art.mp4` (7.603.656 bytes) solo tiene indicio por nombre compartido con una fotografía; se clasifica potencial, **sin afirmar que el vídeo se use**.
- 32 fotografías de gallery/wines y sus dos familias de derivados representan gran parte de la reserva visual. También hay fotografías/arte antiguos, variantes de gift cards y paella. R8 y la revisión editorial podrán decidir qué URLs retirar, con sus dependencias e historial.
- `assets/css/style.min.css` (125.816 bytes) no tiene consumo identificado en estas páginas ni en la búsqueda del baseline; se conserva como reserva de compatibilidad legacy. No se cambia la distribución histórica de CSS para ahorrar 0,12 MiB.
- `preloader.js`, `reservation.js` y `utils.js` son archivos históricos vacíos, cero bytes. Se conservan; su presencia no explica el peso.
- `includes/access.php` sí tiene un require condicional en el documento compartido. No se elimina por estar deshabilitado el acceso demostrativo en el anfitrión público. Se mantienen todos los hosts/handlers y el código realmente compartido.

### Recursos faltantes y límites encontrados

**Home candidata: cero recursos locales declarados ausentes.** Se verificaron las 56 rutas de recursos extraídas del HTML PHP completo, incluidas plantillas y variantes, contra el paquete; además, la carga real de la candidata no registró HTTP fallidos. CSS, entrada JS, cuatro chunks —incluido GSAP/ScrollTrigger—, sprite, imágenes y vídeos necesarios están presentes.

Se encontraron **tres referencias latentes del manifiesto PWA legacy** a `assets/images/icons/menu-shortcut.png`, `reservation-shortcut.png` y `wine-shortcut.png`. Faltan también en el repositorio y en el paquete inicial; **no son omisiones introducidas por el empaquetador**. La nueva Home no enlaza ese webmanifest. El recorrido normal de las páginas legacy no pidió esos iconos, por lo que hubo cero 404 observados; un navegador que procese esos shortcuts puede pedirlos y obtener 404. No se inventan iconos ni se cambia el manifiesto fuera de este alcance. Queda registrada la limitación de los shortcuts PWA legacy para una corrección separada.

Los cinco JFIF de reserva respondieron 200 pero sin Content-Type explícito en este Apache. No son recursos declarados de Home ni consumidores observados del catálogo. Si R8 decide usarlos, exigir MIME image/jpeg verificado en el destino; no se atribuye al paquete una garantía de MIME que el servidor local no emitió.

### Seguridad del document root

- Se enumeraron los archivos reales, incluidos dotfiles, y se compararon con el manifiesto: **844 archivos exactos**, sin extras ni symlinks, todos con tamaño/SHA256 correctos.
- Cero rutas de .env, .git, node_modules, scripts internos, fixtures, docs/informes, logs, backups o temporales. El manifiesto y los resultados permanecen fuera de web.
- Revisión de los textos distribuibles con patrones de credenciales de alta confianza: cero claves privadas, tokens reconocibles o asignaciones de secretos detectadas. Esto se combina con la lista permitida y revisión de configuración; no se presenta como demostración matemática de ausencia de cualquier secreto posible.
- El empaquetador parte de archivos rastreados permitidos y outputs concretos, comprueba archivos regulares, chunks y separación de build/guía. La exclusión de los dos partials está explícita y comentada. No se depende de .htaccess para justificar la presencia de datos privados.
- Apache se prueba con centinelas ficticios en una **copia desechable de ensayo**: .env/.git/node_modules/fuentes/backups/includes/scripts/docs/Preview y marcador denegados. Esos centinelas y la fuente de prueba no están en el entregable limpio.
- Los includes de runtime se mantienen dentro del document root bajo autorización Apache y guards PHP. Son código de presentación/configuración pública, sin secretos; los require internos siguen funcionando.

### Pruebas específicas después del cambio

| Comprobación | Resultado |
|---|---|
| Instalación limpia | npm ci PASS; sin cambiar package.json/lockfile ni añadir dependencias |
| Build y tooling afectado | npm run build y npm run lint:js PASS. CSS/JS/sprite idénticos al paquete inicial por SHA256 |
| Manifiesto | 844 hashes verificados; solo dos exclusiones; todos los archivos conservados idénticos a los iniciales |
| HTTP de todos los archivos | **844 HEAD**: 819 respuestas 200, 20 denegaciones 403, tres 405 de handlers que requieren su método correcto, un 301 del alias home.php y un 404 del wrapper contact-page.php solicitado directamente. No son 404 de assets |
| MIME operativo | CSS, JavaScript/chunks, AVIF/WebP/JPEG/PNG/SVG, MP4 y favicon servidos; Range de vídeo y fuente WOFF2 ficticia comprobados por el ensayo. JFIF de reserva: límite indicado arriba |
| Protocolo existente de ensayo | **85 comprobaciones PASS**, conservando activación y rollback aislados, rutas, denegaciones, cookies, CSRF, origen, fecha estricta, caché y correo simulado |
| Navegador antes/después | Home y 12 HTML legacy, con catálogos generados, sin errores HTTP locales ni externos observados; 13/17/26 productos antes y después. No se enviaron formularios reales ni se abrieron compras/WhatsApp |
| Recursos de Home | 56 rutas declaradas presentes; sin faltantes; CSS y JS/GSAP cargados |
| Protección operativa | Marcador retirado al finalizar el ensayo; no existe en checkout ni en el entregable; procesos propios terminados |
| Alcance | Dos partials originales y tres informes sin seguimiento preservados; páginas, media y motor GSAP intactos; git diff --check PASS |

**E2** (fuera del repositorio y del document root):

`C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b50a-94d6-7253-a14b-6dac8b7a01b1/home-r7/package-review/`

Evidencia: inventory-initial.json; dependency-final.csv/json; final/integrity-security-home.json; final/browser-dependencies.json; final/http-all-files.json; ensayo-final/resultados.json. Los scripts de inspección y el adaptador del lanzador se conservan en E2; el procedimiento productivo original scripts/ensayar-home-apache.mjs no se modifica. Se utilizó una copia externa del lanzador únicamente para insertar la inspección de navegador/HEAD durante la ventana de activación aislada.

SHA256 del manifiesto final: `80c3779699740108388c0da0a97b0451de0b435a48add44afedad3fb9701d9a1`. SHA256 inicial conservado: `42f9b600e46be0b970de2af5e496ff2ef688585e2546123017df3c187a50ab40`.

### Decisión de esta revisión

**GO para staging autorizado** con este paquete conservador de 844 archivos. El volumen está explicado, no hay omisiones nuevas de Home ni material privado detectado, y las únicas exclusiones tienen evidencia y prueba posterior. No se exige retirar la reserva visual para ensayar; tampoco se declara que cada archivo reservado tenga consumidor demostrado.

**NO-GO para publicación pública.** Siguen pendientes los requisitos de la cuenta GoDaddy ya documentados: handler/versiones y overrides, permisos/temporales, TLS y proxy confiable, Cloudflare/caché, correo real autorizado, backup/restauración real y aprobaciones R8/editoriales/audiovisuales. Añadir al registro de límites los shortcuts PWA legacy y el MIME de JFIF si se decide utilizarlos. No se han probado contra GoDaddy ni se ha accedido a cPanel. No hubo commit, push, PR, merge, deploy o modificación de main.

---


## Estado, base y alcance

PR [#32](https://github.com/MaickR/clandestinoUSA/pull/32) de R6 fusionado hacia develop; merge y origin/develop verificados en **5b24a90656798128abc7906b3e5c50df1b299d0b**. Develop actualizado exclusivamente mediante fast-forward; rama de trabajo **feature/home-deployment-readiness**. Sin commit, push, PR, merge de feature, modificación de main, deploy ni activación pública. El marcador no existe en el checkout ni en el paquete entregable.

Se leyeron AGENTS, reglas PHP/JS/SCSS, estándares, arquitectura, workflow, Visual Direction, auditoría técnica, R1, R3, R4 y el cierre vigente de R6. La configuración se contrastó con production-baseline; las páginas y su comportamiento visual no se modifican. Los registros antiguos dentro de R6 no sustituyen su cierre aprobado del 7 de noviembre.

No se repiten Lighthouse ni las auditorías de diseño cerradas. No se seleccionan ni modifican fotografías, encuadres, textos, Header, breakpoint 1024, animaciones, Hero, carruseles o secciones. R8 conserva la selección editorial. La aprobación R1–R6 no certifica correo real, hosting, servicios comerciales futuros ni las alternativas audiovisuales pendientes.

Los tres informes locales siguen **sin seguimiento y sin cambios**:

| Informe | SHA256 |
|---|---|
| HOME-FINAL-AUDIT.md | 49b97d8320715f61ac0bcaeae196e847c56b6f397ca971b29d9ccfce75932bcc |
| HOME-TECHNICAL-AUDIT.md | f7a3a637c4f9fb672af3f8edaeacf6f70a0d3f5aabd83cdd1c875c3edde79d68 |
| HOME-VISUAL-ASSET-PLAN.md | 68201e6cd72b41bd3365ddf3d31980f67b4f8ba2de2c2b396c372d2ee90e8690 |

## Diagnóstico y defectos comprobados

**Compatible localmente con Apache 2.4 + PHP FastCGI, sin Node en runtime. Compatibilidad efectiva de la cuenta GoDaddy pendiente.**

| Hallazgo comprobado | Corrección y verificación |
|---|---|
| La configuración inicial devolvía 200 para centinelas .env y .git/config en la copia Apache | Denegación de dotfiles, directorios privados, fuentes y tooling; backups incluso con extensión intermedia, logs y archivos de configuración. Centinelas sin secretos pasan a 403. No se prueba con credenciales reales |
| Home recibía dos Cache-Control, por Header always y mod_expires; la regla global sustituía el private de endpoints PHP | Expires desactivado para HTML/PHP; limpieza de la tabla onsuccess; política específica private/no-store para contacto, reserva y token. Ensayo con sesiones y módulos presentes/ausentes |
| Faltaba un paquete reproducible y una prueba de cutover/rollback en Apache | Empaquetador por lista permitida, manifiesto SHA256 fuera de web y ensayo portable aislado. No se elimina ningún archivo del repositorio |
| Protección de includes dependía del rewrite raíz | Defensa adicional includes/.htaccess mediante autorización Apache; los require PHP siguen funcionando |

Los problemas de arranque y expectativas corregidos durante la construcción del laboratorio (rutas FastCGI con drive Windows, redirección Location absoluta de Apache y registro condicional del mail simulado) pertenecen al instrumental. No motivaron cambios en PHP de producto ni en UI.

No se endurece globalmente CSP ni se retira HSTS sin verificar dependencias/subdominios. Se mantiene la configuración histórica, con sus límites indicados abajo.

## Requisitos verificables del hosting

| Requisito | Estado / criterio |
|---|---|
| Apache | R3 requiere 2.4.10+ por END y expresiones Header; usar versión mantenida por proveedor. Ensayado 2.4.70 Win64. No acredita versión Linux de la cuenta |
| Módulos obligatorios | rewrite, dir, headers, authz_core y mime; AllowOverride debe admitir Options, índices, autorización y FileInfo de los .htaccess. All funciona en el laboratorio; confirmar permisos efectivos de cPanel |
| PHP | Código con sintaxis PHP 8; ensayo y lint con 8.3.14. Seleccionar rama/parche mantenidos por proveedor y repetir pruebas con esa versión; no presentar el parche local como recomendación de seguridad vigente |
| Extensiones/funciones | mbstring, session, date/timezone, JSON, hash, random_bytes y mail en hosting real; includes y archivos legibles. PHP debe ejecutarse, nunca descargarse |
| Sesión/temporales | session.save_path y sys_temp_dir privados, escribibles y fuera de DocumentRoot. Rate limits de R1 usan temporales; no son persistencia comercial |
| Errores/logs | display_errors=Off, log_errors=On y destino privado; revisar acceso y retención. No exponer excepciones, PII o logs por HTTP |
| DocumentRoot | Raíz de web, instalada en raíz de dominio. No funciona como paquete genérico bajo /subcarpeta por sus rutas absolutas |
| HTTPS | Certificado válido, cadena y renovación, dominio y www; revisar subdominios antes de aceptar HSTS includeSubDomains/preload existente |
| Proxy/CDN | Contrato confiable de X-Forwarded-Proto y bypass de caché de sesiones/HTML/POST; no confiar en cabeceras arbitrarias de clientes |
| Correo | Cuenta/proveedor debe permitir mail y el remitente/envelope actuales. Entrega, SPF/DKIM/DMARC, spam y respuesta humana pendientes de prueba autorizada |
| Espacio/transferencia | Paquete final 347.384.141 bytes, más copia anterior, backup y logs privados. Validar cuota antes de subir |

No se requieren MySQL, Laravel, React, Redis, colas, procesos persistentes propios, npm, Node, Gulp o BrowserSync en el hosting. El servicio PHP/Apache lo administra el proveedor. Node/npm solo construyen y ensayan en el equipo de preparación.

Documentación del proveedor orienta dónde consultar la versión, sin demostrar la de esta cuenta: [PHP en cPanel](https://www.godaddy.com/en-ca/help/view-or-change-the-php-version-for-my-web-hosting-cpanel-16090). Referencias de configuración: [DirectoryIndex](https://httpd.apache.org/docs/2.4/mod/mod_dir.html), [Header](https://httpd.apache.org/docs/2.4/mod/mod_headers.html), [FastCGI](https://httpd.apache.org/docs/2.4/mod/mod_proxy_fcgi.html).

## Inventario exacto y arquitectura del paquete

Generación local: node scripts/empaquetar-home.mjs. Salida por defecto: **.dist/home-r7/**. El destino debe ser nuevo; el script falla si ya existe. Puede darse un directorio nuevo externo como primer argumento. El script no construye ni activa: exige outputs de build, rechaza mapas/guía en dist, symlinks y chunks ausentes.

- **web/** es el único contenido candidato al DocumentRoot.
- **manifest.json** queda fuera de web: lista exacta ordenada de ruta, bytes y SHA256 de cada archivo, base Git y activacion:false. Refleja el árbol de trabajo revisable, incluidas correcciones aún sin commit. Antes de un release real, reconstruir desde main/tag aprobado y comprobar árbol limpio.
- No contiene marcador, Preview, informes, fixtures ni configuración del laboratorio.
- Se conservan medios de todas las páginas legacy, incluidas galerías dinámicas: no es solo la primera pantalla de Home. El manifiesto enumera cada uno; no se deduce una poda editorial para R8.

Inventario **inicial** de R7, conservado como referencia del primer ensayo: **846 archivos; 347.386.519 bytes** (~331,3 MiB). La revisión superior detalla el entregable final de 844 archivos y la exclusión de dos partials; los grupos de la tabla siguiente describen el inicial.

| Grupo | Archivos necesarios / incluidos |
|---|---|
| Anfitriones y formularios PHP (5) | home.php, contact-page.php, contact.php, reservation.php, form-token.php |
| Includes (20 archivos) | Los 19 PHP compartidos de includes, más includes/.htaccess. Configuración pública site, documento/head/publicación, Header/Hero/Footer, secciones y utilidades R1; require por rutas internas |
| HTML legacy (12) | index.html, contact.html, about.html, menu.html, tapas.html, wines.html, swc.html, hampers.html, links.html, policies.html, terms.html, offline.html |
| CSS (7) | home.css compilado y seis hojas legacy: style.css, style.min.css, faq-styles.css, form-feedback.css, pure-soul.css, whatsapp-float.css |
| JS compilado (5) | main.js y los cuatro chunks listados debajo, todos juntos |
| JS legacy (11) | form-feedback, forms-security, gallery, hampers, preloader, reservation, script, swc-carousel, tapas, utils, wines (.js). Tres archivos vacíos históricos se conservan; no se reescriben |
| Imágenes/vídeos/configuración local de posters (774) | Medios rastreados permitidos de assets/images, con su estructura y .htaccess de guest-stories. AVIF/WebP/JPEG/JFIF/PNG/SVG/MP4 existentes; sin regenerar ni elegir fotos |
| Otros (12) | .htaccess raíz, robots.txt, sitemap.xml, siete favicon/manifiesto, sprite y licencia Bootstrap Icons |

Outputs exactos de Home en esta base:

| Archivo | Bytes |
|---|---:|
| assets/css/home.css | 100.835 |
| assets/js/dist/main.js | 37.078 |
| assets/js/dist/escenas-hero-SYIHFQF2.js | 4.430 |
| assets/js/dist/carrusel-YPMOSIAB.js | 2.811 |
| assets/js/dist/carrusel-media-ROPSGG56.js | 892 |
| assets/js/dist/movimiento-home-QLIQHD27.js | 124.914 |
| assets/icons/cl-iconos.svg | 12.028 |

GSAP 3.15.1, CSSPlugin y ScrollTrigger están dentro del chunk movimiento-home; sin CDN ni node_modules en runtime. El metafile verifica ausencia de BrowserSync y módulos guía. La Home usa Google Fonts externa (Libre Bodoni) y fuentes de sistema; no hay WOFF local productiva que inventariar. Las páginas legacy conservan sus CDNs actuales.

**Fuera del paquete:** assets/scss, assets/js/main.js y style-guide.js fuente, modules, optimize-images.js, style.new.css/guía no consumidos por estas páginas, source maps, node_modules, .git/.env, herramientas/lockfile, .agents/.cursor/.github, docs, scripts, fixtures, informes, promociones.txt editorial, comprimidos, backups y logs. El repositorio no se borra para construir este inventario.

## Apache, rutas y SEO de transición

| Ruta / condición | Resultado ensayado |
|---|---|
| / sin marcador | index.html mediante DirectoryIndex; no se sustituye ni renombra |
| / con marcador en copia local | Rewrite interno a home.php, 200; noindex en host local |
| / con marcador + host canónico + TLS | 200, meta y X-Robots-Tag index/follow; canonical fijo https://theclandestinousa.com/ |
| /home.php desactivada / activada | 404/noindex / 301 a raíz. Apache convierte la Location local en absoluta; se comprueba mismo origen y ausencia de bucle |
| /index.html?legacy=1 con marcador | 200 legacy y X-Robots-Tag noindex, follow; formulario y fragments conservados |
| /index.html sin marcador, host público | 301 histórico a raíz; rollback no borra index.html |
| /contact.html | Wrapper PHP R1 con token real; sin alterar URL o composición. Acceso directo a contact-page.php: 404 |
| /home-preview.php | 403 en Apache incluso con marcador. En PHP integrado solo loopback, noindex/no-store |
| includes/docs/scripts/style-guide/marcador/privados | 403; includes además denegado en su directorio |
| Posters Guest Stories | 403 sin marcador; 200 WebP con marcador; MP4 admiten Range 206 |
| Ruta inexistente / falta de home.css | 404 real / 503 genérico y noindex. No hay página de error diseñada nueva |
| Marcador sin mod_headers | 503; sin mod_rewrite la activación no es válida y debe impedirse por preflight |

THE_REQUEST separa acceso externo de rewrite interno y END evita rondas que vuelvan a redirigir. El ensayo reproduce HTTP a HTTPS y www a host canónico, conserva query y llega a 200 en el destino local equivalente. Los fragments no llegan a Apache: no se redirige todo index.html al activar. El CTA usa /index.html?legacy=1#reservation, evitando 301 antiguos cacheados. Chrome comprueba /#reservation hacia esa URL, y el parser comprueba los destinos/anchors de Home, incluidos aliases services/pure-soul. No se promete disponibilidad ni confirmación de mesa.

Home pública candidata mantiene canonical, OG/Twitter y Restaurant coherentes con site.php; sin SearchAction, ratings, ofertas o datos comerciales nuevos. robots.txt no es control de acceso. Sitemap conserva 11 URLs y una sola raíz; no anuncia home.php/Preview ni inventa lastmod de publicación. Se validan antes del cutover, pero **no se envía sitemap ni se solicita indexación ahora**. Search Console, Rich Results y URL Inspection deben comprobar la URL pública solo tras autorización y publicación; los ficheros preparados no demuestran indexación de Google.

El servidor integrado PHP ignora .htaccess: sirve para Preview, no demuestra redirects, autorización, MIME, compresión o caché de Apache. FastCGI del laboratorio exige cookies Secure incluso en loopback, a diferencia de cli-server. La adaptación de SCRIPT_FILENAME con drive Windows vive solo en la configuración del ensayo, jamás en el paquete Linux.

## Caché, compresión y CDN

- HTML/PHP: un Cache-Control efectivo no-cache/no-store/max-age=0. Contacto, reserva y token: private/no-store/max-age=0; cookies host-only, Secure, HttpOnly, SameSite=Lax y Vary Cookie conservados. No aplicar Cache Everything a estos documentos, POST o sesiones.
- home.css y main.js reciben ?v= con 16 caracteres SHA256 desde PHP; chunks con hash esbuild. CSS/JS estáticos: siete días; no se cambia globalmente la caché legacy. La caché/CDN debe incluir la query en su clave.
- Imágenes AVIF/WebP y demás medios: seis meses y stale-while-revalidate; fuentes, si las hubiera localmente, seis meses/immutable. **No sustituir bytes bajo una URL fotográfica cacheada en R8** sin URL versionada o invalidación acreditada.
- ETag MTime/Size y Last-Modified permiten revalidación estática (304 probado). No se comparan como prueba de igualdad de contenido entre máquinas: mandan los SHA256 del manifiesto.
- Gzip y Brotli reales funcionaron en Apache local; también se probó funcionamiento sin ambos módulos y sin Expires. En GoDaddy son opcionales: confirmar soporte, MIME, Vary y ausencia de doble compresión. No comprimir de nuevo AVIF/WebP/MP4.
- No borrar chunks antiguos en la subida ni al revertir. Un main.js cacheado o pestaña abierta puede pedirlos después. Conservar la unión de chunks de versiones aún servidas; siete días no limita la vida de una pestaña. Definir retención operativa y comprobar perfiles previos/limpios antes de retirar archivos.
- Invalidación de publicación: entregar primero chunks/medios, después entradas CSS/JS y PHP revisadas, comprobar versión en HTML; purgar HTML y claves afectadas en CDN si corresponde. Al rollback, restaurar entradas exactas y purgar de nuevo HTML; conservar chunks de ambas versiones.

**Observación externa de solo lectura:** HEAD a https://theclandestinousa.com/ el 2026-11-07 respondió 200, Server cloudflare, CF-Cache-Status DYNAMIC y CF-RAY. También mostró el Cache-Control duplicado histórico. Esto confirma paso observado por Cloudflare, **no acceso a su cuenta, reglas, modo TLS, caché de otros recursos ni hosting de origen**. Evidencia public-head.txt; no hubo solicitudes a formularios públicos.

R3 acepta X-Forwarded-Proto para evitar redirects cuando termina TLS un proxy. Antes de publicar hay que acreditar quién lo sobrescribe y la protección del origen; no se certifica ese límite de confianza con cabeceras sintéticas. Revisar Full (strict), TLS del origen, reglas de caché, Rocket Loader/transformaciones si existen y redirecciones de cPanel. No se modificó ninguna cuenta/CDN.

## Build y verificación del paquete

Desde la raíz, con Node/npm de preparación y PHP disponibles:

~~~powershell
npm.cmd ci
npm.cmd run lint
npm.cmd run build
node scripts/probar-carrito.mjs
node scripts/probar-cierre-comercio.mjs
node scripts/probar-formularios.mjs
node scripts/probar-home-publica.mjs
php scripts/probar-fechas-formularios.php
node scripts/empaquetar-home.mjs
git diff --check
~~~

Para repetir el empaquetado usar un destino nuevo, por ejemplo node scripts/empaquetar-home.mjs .dist/home-r7-segundo. No ejecutar watcher mientras se construye/verifica un release. Dos builds completos dieron hashes idénticos en CSS, sprite, main y cuatro chunks; no se promete ZIP idéntico en timestamps/ETags.

Verificar por separado antes de una subida:

~~~powershell
$paqueteR7 = Resolve-Path .dist/home-r7
$listaR7 = Get-Content "$paqueteR7/manifest.json" -Raw | ConvertFrom-Json
foreach ($entradaR7 in $listaR7.archivos) {
  $hashR7 = (Get-FileHash -LiteralPath "$paqueteR7/web/$($entradaR7.ruta)").Hash.ToLowerInvariant()
  if ($hashR7 -ne $entradaR7.sha256) { throw "Hash distinto: $($entradaR7.ruta)" }
}
if (Test-Path "$paqueteR7/web/.home-public-enabled") { throw 'Marcador inesperado' }
if (@(Get-ChildItem "$paqueteR7/web" -Recurse -File -Force).Count -ne $listaR7.archivos.Count) {
  throw 'Contenido adicional o ausente'
}
~~~

Subir solo web, preservando dotfiles y estructura. No comprimir/copiar la raíz del checkout. Si se usa ZIP con cPanel, comprobar explícitamente .htaccess raíz, includes/.htaccess y guest-stories/.htaccess dentro del archivo antes de extraer. Los manifiestos, claves TLS de ensayo, ini, sesiones y resultados quedan **fuera** de DocumentRoot y no se suben.

npm ci mantuvo lockfile y dependencias: 511 paquetes instalados, seis avisos de tooling (cinco moderate y uno high, incluido follow-redirects). npm audit --omit=dev: cero. No hay dependencias nuevas ni audit fix/force. No se interpreta omit=dev como sustituto del análisis del bundle: el metafile confirma qué llega al navegador.

## Ensayo local reproducible

El lanzador scripts/ensayar-home-apache.mjs requiere un Apache24 portable Windows con openssl y módulos del ensayo, PHP CGI y mbstring existentes. No descarga herramientas, instala servicios, toca hosts/DNS, abre puertos públicos ni reutiliza el webroot del checkout.

~~~powershell
node scripts/ensayar-home-apache.mjs C:/herramientas/Apache24 C:/php/php-cgi.exe .dist/ensayo-home-r7
~~~

El directorio debe ser nuevo. El lanzador crea paquete y directorio privado, reserva puertos de loopback, genera certificado autofirmado local, deshabilita mail nativo **antes de arrancar PHP**, carga el transporte simulado mediante auto_prepend_file externo y ensaya marcador/retirada únicamente en esa copia. Termina los procesos propios; escribe resultados.json. Apache -X evita instalar un servicio y simplifica el cierre.

El transporte falla cerrado si mail nativo está habilitado o falta el contexto aislado. Solo registra rol/aceptación; no guarda destinatarios, cuerpo, token ni PII. Las pruebas de POST usan una conexión TLS a 127.0.0.1 y Host/Origin canónicos sintéticos: prueban PHP/Apache y cookies, **no DNS, confianza del certificado público, HTTP/2, Cloudflare o el envío de un navegador en el dominio real**. La omisión de validación del certificado está limitada a este cliente de ensayo.

No subir el web del ensayo: contiene centinelas falsos privados y una fuente ficticia para probar MIME. El entregable limpio es .dist/home-r7/web, creado por el empaquetador.

Para Preview visual, independiente de Apache:

~~~powershell
php -d disable_functions=mail -S 127.0.0.1:8019 -t .
~~~

Abrir http://127.0.0.1:8019/home-preview.php en 390/768/1280 y 1023/1024. Esto no activa /. Para revisar visualmente la variante pública sin Apache puede usarse el router R3 con CL_HOME_PUBLIC_REVIEW=1 y mail deshabilitado; sigue siendo un ensayo PHP, no sustituto de Apache. No crear marcador en el checkout para revisar.

El Apache portable utilizado aquí se obtuvo de [Apache Lounge](https://www.apachelounge.com/download/) fuera del repo, versión 2.4.70-261106 Win64 VS18; ZIP verificado contra [SHA256 del distribuidor](https://www.apachelounge.com/download/VS18/binaries/httpd-2.4.70-261106-Win64-VS18.zip.txt): b96a40b66a99428b2e4aea48ebe98bab826c768df4ace81f78dd7e26a98ad311. No es una dependencia nueva de la aplicación ni una certificación de GoDaddy.

## QA ejecutado y evidencia

Evidencia externa **E**:

C:/Users/Mike/.codex/visualizations/2026/11/07/01a1b50a-94d6-7253-a14b-6dac8b7a01b1/home-r7/

| Comprobación | Resultado y límite |
|---|---|
| npm ci / lint / build | PASS; instalación limpia, ESLint/Stylelint y dos builds con hashes idénticos. build-1.json, build-2.json |
| PHP lint | PASS: 66 PHP, incluidos 65 anteriores y el fixture nuevo |
| Suites Node previas | PASS: carrito, cierre comercial, 126 casos formularios y 72 contratos Home pública |
| Fechas/sesión R1 | PASS: 27 comprobaciones, medianoche/DST y America/Los_Angeles; sin modificar calendario ni motor de reservas |
| Apache 2.4.70 + PHP 8.3.14 FastCGI | PASS: **85 comprobaciones** en ensayo-completo/resultados.json, incluidos activación, rollback, rutas, 12 HTML legacy, 404/503, noindex/index, CSRF, origen, fecha estricta, correo total/parcial/fallido, cookies, compresión, MIME, ETag y Range |
| Módulos ausentes | PASS: sin headers se impide activación con 503; sin Expires/deflate/Brotli funciona sin compresión y conserva caché explícita de assets. rewrite sigue siendo requisito obligatorio de preflight |
| HTML pública y Preview | PASS: html5lib sin errores de parseo, H1/main únicos, IDs y referencias ARIA/for resueltos, alt presentes, medios y fragments de enlaces presentes. html-qa.json; no equivale a certificación Nu/W3C/WCAG |
| Chrome real sobre Apache/TLS local | PASS: 390/768/1023/1024/1280 × 900, captura, lectura completa, imágenes cargadas, sin overflow, menú con Enter/Escape/Tab/Shift+Tab y retorno; foco solid de 2 px. browser-qa.json y apache-*.png |
| GSAP/ScrollTrigger y Hero | PASS: chunk dinámico solicitado, 44 unidades de movimiento registradas y finalización al recorrer, sin alterar fuentes/animaciones. Metafile con GSAP/CSSPlugin/ScrollTrigger y sin runtime guía/BrowserSync |
| Reduced motion / sin JS | PASS: movimiento decorativo ausente en reduced motion; contenido y navegación nativa presentes sin JS. browser-qa.json, browser-extra.json |
| Navegación/contraste | PASS del recorrido probado, reserva legacy real por URL y contraste muestreado en navegación sobre fondo sólido. No se repite contraste exhaustivo fotográfico de R2/R4 ni se certifican subtítulos |
| Consola/red | Cero errores/warnings/HTTP >=400 en la matriz normal de Home candidata. Errores 403/404/503 provocados se registran aparte en servidor |
| Integridad | Hashes de informes preservados; sin cambios en páginas, PHP de producto, JS/SCSS, fotografías o lockfile. git diff --check PASS |

Los primeros ensayos y sus fallos instrumentales se conservan separados; la referencia final es ensayo-completo. No se seleccionan pruebas fallidas como validación. No hubo correos reales ni POST al sitio público.

## Publicación futura: procedimiento condicionado a autorización

**Estos pasos no se ejecutaron contra producción.** Solo el equivalente local de activación/rollback está probado. El release real nace de main/tag aprobado después de revisar R7/R8 y superar el go/no-go.

1. **Preflight del destino.** Identificar cuenta, dominio, DocumentRoot y versión/handler PHP; confirmar módulos y overrides con soporte/cPanel y rutas de prueba protegidas. Revisar Apache/cPanel redirects, Cloudflare, TLS/certificados, caché y permisos. No dejar phpinfo público.
2. **Backup restaurable.** Descargar copia completa de la web actual, dotfiles, configuración PHP efectiva y versiones de recursos. Guardar fuera de public_html y fuera del paquete. Inventariar hashes/fecha y validar lectura del respaldo. Conservar configuración/estado de activación; no inventar respaldo de DB si ninguna existe para esta web.
3. **Construir release revisado.** Desde main/tag y lockfile aprobado, npm ci → lint/tests → build → empaquetador. Verificar manifiesto/hash, dotfiles, ausencia de marcador, fuentes/privados y espacio. Conservar manifiesto y release anterior localmente.
4. **Staging autorizado y privado.** Crear/usar solo el proporcionado por el responsable. Proteger el sitio completo mediante acceso autorizado; host distinto debe seguir noindex. Usar transporte simulado y datos sintéticos bajo configuración de laboratorio aislada; jamás copiar el fixture como endpoint público. Repetir rutas, navegador, TLS, cookies, recursos y rollback con el handler real.
5. **Planificar ventana y respaldo de diferencias.** Acordar responsable, observación y criterio de reversión; confirmar que no hubo cambios de producción después del backup. Subida inicial con Home desactivada **no es inocua**: R1 y .htaccess afectan legacy, por lo que también necesita autorización y validación.
6. **Subir en orden.** Primero medios/chunks nuevos sin eliminar anteriores, después entradas CSS/JS y PHP/includes revisados; entregar .htaccess compatible con el handler de cPanel conservando directivas propias de la cuenta. Subir robots/sitemap con el release autorizado. No sobrescribir a ciegas el bloque generado por cPanel ni datos ajenos.
7. **Validar antes del cutover.** / sigue histórica; home.php 404; Preview/includes/privados 403; contacto y token seguros; recursos completos. Comprobar hashes/versiones de la subida y comportamiento desde cliente previo/limpio. Detener si hay errores de ejecución, rutas o correo.
8. **Activación explícita y única.** Tras permiso final, crear de forma controlada el archivo vacío .home-public-enabled en el DocumentRoot efectivo. No cambiar DirectoryIndex ni borrar index.html. Evitar una copia incompleta; el marcador se crea al final. Verificar que no es descargable.
9. **Validación inmediata.** Raíz nueva 200, home.php 301, legacy con noindex y formulario, redirects canónicos sin bucle, canonical/robots/social/schema correctos y Search Console cuando corresponda. Verificar assets/chunks/fotos/posters/vídeos, Header 1023/1024, GSAP, menú, consola, sesiones y logs.
10. **Correo real, solo autorizado.** Enviar una solicitud sintética identificada a destinatarios de prueba acordados o bajo autorización explícita sobre los reales; comprobar principal/copias, respuesta JSON/UX, bandejas/spam, Reply-To/UTF-8 y recepción por el negocio. La aceptación de mail no confirma entrega ni reserva. No provocar fallos deliberados en clientes.
11. **Observación e invalidación.** Purgar solo recursos acordados, confirmar ausencia de HTML/sesión cacheados y monitorizar errores/aceptación privada sin PII. Conservar backups y chunks anteriores. No retirar legacy ni activar cuenta/carrito/checkout por este cutover.

## Rollback reproducible

**Disparadores:** 5xx persistentes, PHP descargable, pérdida de CSRF/sesión, formulario inaccesible, error de correo principal, assets/chunks rotos, redirecciones cíclicas, SEO noindex inesperado en raíz canónica o regresión funcional de navegación.

1. Retirar el marcador del DocumentRoot para recuperar index.html y cerrar home.php/posters nuevos. En cPanel, eliminarlo o moverlo **fuera** de public_html; no dejar una copia .bak pública.
2. Purgar HTML/redirecciones afectadas en CDN y verificar / histórica 200, home.php 404 y comportamiento histórico de index.html.
3. Si el fallo afecta R1, .htaccess, includes o recursos compartidos, retirar el marcador por sí solo **no revierte esos archivos**. Restaurar desde el backup las versiones exactas afectadas, incluido el .htaccess operativo y configuración PHP; mantener disponibles los chunks de ambas versiones.
4. Verificar contacto/token/reserva con prueba autorizada o simulada, cookies/caché y logs; comprobar que la web histórica no tiene errores de consola/rutas.
5. Registrar hora, versión y motivo fuera de la web. No borrar evidencia ni respaldo antes de evaluar la causa. Una solicitud ya aceptada por correo no se deshace con rollback: no reenviar automáticamente.

El laboratorio prueba retirada del marcador y retorno a legacy, cierre de anfitrión/posters y redirect histórico. La restauración de un backup **real de GoDaddy**, su propagación CDN y la continuidad de correo son pendientes externos; no se declara probado un rollback completo de esa cuenta.

## Go/no-go y verificaciones pendientes de hosting

**R7 aprobada técnicamente para PR manual; GO para staging autorizado y NO-GO para publicación directa.**

- [x] R6 integrada, rama correcta e historial local preservado; solo los siete archivos autorizados de R7 forman el commit.
- [x] Build limpio/reproducible, paquete mínimo por lista y manifiesto exacto, sin activar.
- [x] Apache/FastCGI/TLS local, rutas/seguridad/caché, sesiones/correo simulado, activación/rollback y navegación comprobados.
- [x] Diseño, GSAP, breakpoint, textos y fotografías intactos; sin reabrir auditorías cerradas.
- [x] Revisión técnica humana de R7 aprobada para integración mediante PR manual hacia develop.
- [ ] Release main/tag aprobado; R8/editorial y requisitos audiovisuales/comerciales pendientes resueltos; paquete regenerado tras las imágenes definitivas de R8.
- [ ] Versión/handler/extensions de PHP reales, módulos Apache, AllowOverride, DocumentRoot, permisos y temporales privados acreditados.
- [ ] Staging autorizado privado con prueba de R1 sobre PHP/Apache reales, sin debilitar origen/CSRF ni cookies para un hostname temporal.
- [ ] TLS del origen/edge, www, HSTS/subdominios, confianza de X-Forwarded-Proto y ausencia de bucles acreditados.
- [ ] Reglas Cloudflare/cPanel, claves de caché con query, bypass de POST/sesión, compresión real y purga acreditados.
- [ ] Backup y restauración real ensayados, política de retención de chunks/versiones definida y espacio suficiente.
- [ ] Correo real controlado autorizado, principal/copias/bandejas y operación humana confirmados.
- [ ] Verificación pública autorizada de SEO/social/Search Console y seguimiento posterior planificados.

**Recomendación:** integrar R7 mediante PR manual y ensayar en staging autorizado de la cuenta. El resultado local sustenta la arquitectura tradicional Apache/PHP; no sustituye R8, la regeneración posterior del paquete, las verificaciones externas ni la autorización final de publicación.
