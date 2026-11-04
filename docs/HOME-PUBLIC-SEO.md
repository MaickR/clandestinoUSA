# Home R3 — arquitectura pública y SEO técnico

2026-11-03 · America/Bogota · **Cierre técnico para PR manual. Header público aprobado. Publicación de Home deshabilitada.**

## Resultado y base

R2 (`55d4f4c392bd6ce31884f922173c612ffd7b1f92`) está integrada en `origin/develop` mediante PR #28, merge `a38a9af7b3d1c8ec157d0b0795bc70314eaf5f55`. Se actualizó `develop` por fast-forward y se creó `feature/home-public-seo` desde ese merge. Un nuevo fetch durante el cierre confirma la misma base vigente. R3 queda preparada para PR manual hacia develop; el cierre autorizado comprende el commit `feat(home): preparar arquitectura pública y SEO técnico` y push normal exclusivamente de la feature. No autoriza PR automático, merge, deploy, modificar main ni activar la Home.

Se consultaron AGENTS.md, reglas PHP/JS/SCSS, estándares, arquitectura, UX/UI, Visual Direction, Design System y documentación vigente de Home/R1/R2. Se utilizó el backlog de HOME-TECHNICAL-AUDIT: H01, H07, preparación de H08 y retirada pública de demos H09. No se repitió la auditoría general. Se contrastó el comportamiento histórico con `production-baseline` y con el `index.html` vigente, que ya incorpora R1.

Los tres informes locales no rastreados HOME-FINAL-AUDIT, HOME-TECHNICAL-AUDIT y HOME-VISUAL-ASSET-PLAN se preservan íntegros y sin seguimiento. Su comprobación SHA256 y los hashes iniciales de fuentes están en la evidencia externa. Los documentos históricos no se reescriben.

## Decisión arquitectónica

Se conserva `index.html` byte por byte y se añade `home.php` como anfitrión técnico de la nueva Home. No es una nueva página comercial ni una URL canónica alternativa. Ambos anfitriones PHP, público y preview, reutilizan **un documento**: `includes/home-document.php`, que incluye el head contextual y las secciones existentes.

La raíz de Apache solo pasa a `home.php` cuando existe el archivo operativo `.home-public-enabled` en el DocumentRoot. El marcador está ignorado por Git y **no existe en este checkout**. Ninguna URL, query o petición puede crearlo. Se mantiene `DirectoryIndex index.html`: añadir el PHP al servidor por sí solo no sustituye la Home histórica.

| Recurso | Sin marcador | Release habilitado |
|---|---|---|
| `/` | Home histórica mediante DirectoryIndex | Rewrite interno a `home.php`; única Home indexable en el dominio/HTTPS canónicos |
| `/home.php` | 404/noindex | 301 relativo fijo a `/`; sin parámetros de destino |
| `/index.html` | Redirect histórico a `/` en el dominio público | 200 histórico, `X-Robots-Tag: noindex, follow`; formulario, anchors y scripts intactos |
| `/home-preview.php` | Local CLI loopback solamente; noindex/no-store | Misma protección; Apache deniega acceso siempre |
| `/contact.html` | Rewrite R1 a `contact-page.php` | Igual, sin cambiar la URL comercial |
| `/includes/`, `/docs/`, `/scripts/`, marcador | No son documentos públicos de Apache | Igual |

No se elige `index.php` ni se cambia el orden de índices para activar el release: depender de la precedencia heredada de cPanel permitiría servir la página equivocada. No se hace una redirección general de `index.html` después de activar, porque los fragments no llegan al servidor y el formulario legacy sigue allí. El HTTP noindex evita una segunda Home indexable; no se bloquea ese HTML en robots.txt, para que el buscador pueda leer la directiva. Google combina las directivas aplicables con el criterio más restrictivo, por lo que el noindex HTTP prevalece sobre el antiguo meta index. [Referencia de Google](https://developers.google.com/search/docs/crawling-indexing/robots-meta-tag).

`THE_REQUEST` distingue el acceso externo a `home.php` del rewrite interno. `[END]` detiene las rondas de rewrite por directorio. El archivo histórico no se sobrescribe, renombra ni elimina. No hay includes elegidos por input del visitante, redirecciones a hosts arbitrarios ni cambios en los handlers. [Flags de Apache](https://httpd.apache.org/docs/current/en/rewrite/flags.html), [DirectoryIndex](https://httpd.apache.org/docs/2.4/mod/mod_dir.html).

## Requisitos de Apache y hosting

La preparación utiliza Apache **2.4.10 o posterior**, `mod_rewrite`, `mod_dir`, `mod_headers` y `mod_authz_core`; AllowOverride debe permitir las directivas existentes y las nuevas. Las expresiones de `Header` requieren 2.4.10+. El PHP del virtual host debe ejecutar los archivos, nunca descargarlos; esta fase se probó con PHP 8.3.14, no con la configuración de GoDaddy. [Header/expr](https://httpd.apache.org/docs/2.4/mod/mod_headers.html), [expresiones y pruebas de archivo](https://httpd.apache.org/docs/2.4/expr.html).

El DocumentRoot debe ser la raíz efectiva de esta entrega. No se plantea instalación en un subdirectorio. Los redirects HTTPS/www existentes se conservan. Si hay proxy, debe sobrescribir de forma confiable `X-Forwarded-Proto`; comprobar su contrato y el HTTPS real en hosting. El origen PHP proviene de `includes/site.php`, nunca del Host recibido. Un host de staging o HTTP no emite index en el anfitrión nuevo. Esto no reemplaza autenticación o protección del staging completo.

Sin `mod_headers`, la ruta nueva y el legacy de entrada responden 503 si hay marcador, en vez de activar una segunda Home sin noindex. La ausencia de `mod_rewrite` debe detectarse **antes** de activar; el archivo de configuración no puede validar un módulo que Apache no ejecuta.

Los posters de Guest Stories conservan su denegación mientras no haya marcador; su `.htaccess` permite lectura en el release autorizado. Los MP4 y sus nombres permanecen intactos. La configuración no suprime los requisitos audiovisuales pendientes.

## SEO y datos confirmados

| Elemento | Implementación |
|---|---|
| Title público | `Spanish Tapas & Wine in Mount Shasta \| The Clandestino USA` |
| Description | `Discover Spanish tapas and wines at The Clandestino USA in Mount Shasta. Explore our wines, plan an evening with friends, or request a table.` |
| Canonical / og:url | `https://theclandestinousa.com/`, único y absoluto; independiente de query/Host |
| Robots público | `index, follow, max-image-preview:large` solo con marcador + host canónico + HTTPS; revisión local/staging noindex |
| Preview | Meta y HTTP `noindex, nofollow`, sin canonical público ni JSON-LD; no-store; denegado en Apache y CGI |
| Open Graph | website, site_name, locale, título, descripción, URL e imagen con alt y dimensiones reales |
| Twitter/X | summary_large_image, título, descripción, imagen y alt; sin cuenta social inventada |
| Imagen social | PNG original del primer Hero: `/assets/images/banner-the_clandestino_1.png`, 1672 × 941, 2.649.003 bytes. Sin generar ni sustituir fotografía visible |
| Sitemap | Una sola raíz `/`; imagen real de Home, sin claims/precios heredados de Pure Soul en esa entrada. Se retira su lastmod anterior; no se inventa fecha de publicación. Las otras diez URLs permanecen |
| robots.txt | Recursos CSS/JS/media rastreables; endpoints operativos, fuentes internas y laboratorio excluidos; sitemap absoluto. Se retira Host, sin añadir reglas especiales para buscadores/IA |
| Idioma | HTML `en`, OG `en_US`, centralizados. No se anuncia hreflang español sin URL traducida real |
| Semántica | H1/main únicos y orden de headings conservado; texto/enlaces reales renderizados por PHP, accesibles sin esperar JavaScript |

La indexación del documento nuevo depende del cutover: mientras falte el marcador, Apache conserva la Home histórica y `home.php` responde 404/noindex. El candidato loopback emite noindex incluso con su head público preparado. El sitemap mantiene la raíz ya existente y no anuncia `/home.php` ni Preview; su imagen de Home es preparación del paquete de release. Revisar y entregar sitemap/robots junto al cutover autorizado, sin enviarlos a Search Console como si la sustitución ya hubiese ocurrido. Canonical, OG y JSON-LD preparados no equivalen a contenido ya publicado ni indexado.

`includes/site.php` sigue siendo la configuración compartida. Se centralizan nombre, origen, idioma, locale, zona horaria, dirección estructurada y horario. La dirección y el horario visibles de Visit/Footer se generan de esos mismos datos y mantienen su texto aprobado. El teléfono mostrado es la única fuente del enlace `tel:` y del dato estructurado.

Datos utilizados: **The Clandestino USA**, **211 N Mt Shasta Blvd, Mount Shasta, CA 96067, US**, **+1 (408) 609-0027**, **Tuesday–Sunday, 4:00 PM–8:00 PM**, hora civil de **America/Los_Angeles**. Dirección/horario: instrucciones del propietario y configuración vigente; teléfono: configuración, enlaces y páginas legacy coincidentes. No se deriva geolocalización del teléfono. El email y los perfiles no confirmados de la configuración nueva siguen ausentes; no se trasladan automáticamente al schema.

Se añade un solo JSON-LD **Restaurant**, con `@id` estable `/#restaurant`, name, url, image, telephone, PostalAddress, OpeningHoursSpecification, servesCuisine Spanish y hasMenu hacia `/menu.html`. Sin SearchAction inexistente, ratings, reviews, premios, precios, coordenadas, ofertas, eventos, acciones de reserva ni catálogos ficticios. La zona horaria contextualiza la configuración y el horario; no se inventa una propiedad de Restaurant para ella. [LocalBusiness de Google](https://developers.google.com/search/docs/appearance/structured-data/local-business), [hasMenu de Schema.org](https://schema.org/hasMenu).

El JSON se serializa con excepciones y escapes HEX para contexto script; textos/atributos usan el escape existente. Falta de recursos de entrada del build produce 503/noindex sin stack trace ni detalles de archivo. Las entradas CSS/main.js llevan hash SHA256 corto por contenido; los chunks conservan los hashes de esbuild. El HTML permanece sin almacenamiento y no se cambia globalmente la caché de recursos legacy.

No se añade una infraestructura SEO, framework, dependencia, endpoint de IA ni llms.txt. El contenido servidor, enlaces rastreables, canonical y schema veraz sirven también a los sistemas de descubrimiento. No se garantiza aparición ni tráfico; Google no exige archivos ni schema especiales para sus funciones de IA. [Referencia oficial](https://developers.google.com/search/docs/appearance/ai-features).

## Rutas, CTA y compatibilidad

| Intención desde Home pública | Destino | Alcance real |
|---|---|---|
| Home / logo | `/` | Nueva raíz canónica futura |
| Reservas | `/index.html?legacy=1#reservation` | Formulario de solicitud R1 existente; sujeto a confirmación, sin disponibilidad/compra implícita |
| Contacto / Private Gathering / Gift Cards | `/contact.html#contact-form` o `/contact.html` | Contacto real existente; consulta, sin emisión/checkout de tarjetas |
| Restaurant / menú | `/menu.html` | Página legacy existente |
| Tapas | `/tapas.html` | Exploración; no se implementa Take Away transaccional |
| Wine Shop | `/wines.html` | Exploración legacy; no se convierte en compra |
| Wine Club | `/swc.html` | Destino histórico, oferta comercial pendiente de validación; no alta/pago nuevos |
| Hampers | `/hampers.html` | Exploración; sin carrito ni checkout |
| Experiences / Private Experiences | `/#private-events` | Sección real de Home; CTA posterior a contacto |
| Discover Pure Soul | `/#spanish-wines` | Sección actual; no se mantiene el antiguo fragment incorrecto como CTA nuevo |
| Guest Stories / Visit | `/#guest-stories`, `/#visit` | IDs reales conservados |
| About / Policies / Terms | Páginas legacy existentes | Sin migrarlas o reescribirlas |

No quedan href `#` vacíos en los CTA públicos de esta Home. Los identificadores históricos `home`, `services`, `about`, `pure-soul`, `reservation` y `special` tienen aliases invisibles en el documento público; `top` identifica el body. Los demás IDs de las secciones se conservan. Los enlaces literales a `index.html#...` permanecen atendidos por el archivo original, con sus anchors y scripts intactos.

`/#reservation` se continúa con JavaScript hacia el formulario histórico; el módulo valida origen, path y fragment antes de navegar. La query estable `legacy=1` evita reutilizar antiguos 301 cacheados de `/index.html` a `/`. Sin scripts, ese fragment llega a Reservation Invitation y su CTA permite abrir el formulario con un clic adicional. Los formularios conservan sus dependencias y fallbacks R1; no se promete una reserva enviada sin JavaScript ni se rebaja la protección CSRF. Los anchors/cachés de clientes antiguos deben probarse en el release con un perfil anterior y uno limpio.

## Contrato visual y defecto confirmado

Se mantienen fotografías, overlays, fondos, proporciones, copy comercial, botones, tipografía, animaciones y composición de todas las secciones. La extracción a documento compartido no duplica la Home. Hero mantiene su máquina de escenas, controles y pausas. Los cuatro vídeos, títulos/descripciones accesibles de R2, bota de vino, duraciones y tarjetas permanecen sin cambios.

Excepción mínima pública H09: se omiten acceso y carrito de demostración y sus modales, sin construir servicios aparentes. Preview los conserva. Tras retirarlos, el menú móvil quedaba junto al logo (x=156 a 390px); el modificador público añade únicamente `margin-inline-start: auto` al origen del control y lo mantiene en el extremo derecho (x=319, target 44px). A 320px, el logo deja de necesitar la reducción que reservaba espacio para tres controles y el Header crece **6,875px**; no se fuerza un tamaño artificial. El responsable del proyecto aprueba expresamente este Header público y sus diferencias funcionales en el cierre de R3, sin reabrir el diseño.

Defecto adicional reproducido: activar Experiences desde el drawer cerraba el panel pero dejaba el foco en BODY, ya que la sección no era enfocable. Se añade `tabindex="-1"` solo al destino `private-events`; el foco llega a la región nombrada, fuera del orden secuencial de Tab. Al recibir foco se muestra el anillo Core existente de la región; no es un borde permanente. No se modifica el componente global ni su ciclo de Bootstrap.

La comparación inicial de anchuras/alturas de Header, cada sección y Footer entre Preview R3 y la evidencia R2 coincide en los doce anchos, con el mismo estado inicial de carga. El cierre repite la comparación público/Preview tras recorrer y cargar las fotografías: coinciden las dimensiones de todas las secciones, salvo el Header a 320px indicado; los desplazamientos posteriores provienen de esa altura. La fotografía diferida de Wine Club aumenta su altura tras cargar a 320/390px en ambos anfitriones; esas medidas no se comparan como regresión con snapshots históricos anteriores a la carga. Su PHP, SCSS y fotografía no cambian frente a develop. Una lectura inicial de scrollbar de Guest Stories a 320px se repitió tras estabilizar el layout: ambas secciones miden 1102,203125px y la pista 530,0625px. No se aplicó CSS para variaciones transitorias de medición.

## Header aprobado y componentes comerciales para V1.0

El responsable aprueba el comportamiento visual del Header público: logo, navegación, menú y reserva funcionales, con cuenta/carrito demostrativos desactivados. La revisión específica de 390/820/1440px confirma altura de 83,546875px y logo de 128 × 58,546875px en ambos anfitriones. La hamburguesa mantiene posición a 390/820; a partir del breakpoint existente de 1200px se muestra navegación completa y se oculta la hamburguesa. A 1440px, navegación/reserva ocupan los 112px liberados al omitir cuenta/carrito. Estas diferencias funcionales quedan aprobadas, no pendientes de un rediseño.

Los activadores se omiten del HTML público por configuración PHP, no se eliminan de la plantilla ni del Design System. Se preservan los símbolos `cl-icon-cuenta`, `cl-icon-pedido`, `cl-icon-menu`, estilos BEM, Core Modal/Offcanvas y el contrato `conectarCarrito(proveedor, panel, inicializador)` con el mini-carrito reutilizable. Cuenta/carrito reales se integrarán sin reconstruir el Header, conforme a estos requisitos de V1.0:

- **Desktop:** recuperar los iconos aprobados de cuenta y carrito reales en el Header cuando sus servicios estén integrados y validados.
- **Móvil/tablet:** conservar disposición compacta y accesos coherentes en la navegación responsive; evitar duplicar activadores innecesariamente y repetir QA de foco, estados y reflow.
- **Cuenta:** requiere autenticación y sesión reales, panel funcional y adaptador de servicio; el actual `acceso.js` es sintético y no constituye autenticación reutilizable sin esa integración. La condición PHP por sí sola no lo activa.
- **Carrito:** requiere destino/panel y proveedor reales conectados al contrato existente. No conectar públicamente `#carrito-preview` ni restaurar un contador ficticio para aparentar servicio.
- Preservar iconografía, estilos y patrones aprobados. No habilitar `$esVistaPreviaHome` en público para recuperar controles.

Los modales, credenciales sintéticas readonly y estados de laboratorio se conservan en Preview/desarrollo. El bundle compartido todavía incluye el módulo demostrativo de acceso y la rama de carrito preview, pero no los ejecuta sin sus nodos y activadores; no depende de fixtures de la guía para operar el Header público. La integración comercial futura debe conectar sus adaptadores reales y mantener el uso de las demos limitado a desarrollo. R3 no implementa cuenta, carrito comercial, checkout ni autenticación.

## QA ejecutado y alcance de evidencia

Entorno: Windows, PHP 8.3.14 CLI/CGI y Chromium integrado, alto 1000px. Se aplicó `.agents/skills/qa-visual/SKILL.md`. No se enviaron solicitudes comerciales ni correos; mail nativo deshabilitado en servidores/suites.

| Verificación | Resultado |
|---|---|
| ESLint/Stylelint | PASS: `npm run lint` |
| Build | PASS: `npm run build`; outputs generados ignorados, sin edición manual |
| PHP lint | PASS: 65 PHP (60 rastreados + cinco nuevos), cero errores |
| Node existentes | PASS: `probar-carrito.mjs`, `probar-cierre-comercio.mjs`, `probar-formularios.mjs`; formularios: 126 casos + 27 de fechas/sesión |
| Fechas PHP | PASS: `php scripts/probar-fechas-formularios.php`, 27 comprobaciones |
| Contratos R3 | PASS: `node scripts/probar-home-publica.mjs`, 72 comprobaciones HTTP/PHP/CGI en copia temporal; marcador solo dentro de esa copia; activación, rollback, Host/HTTPS, alias, ausencia de demos, JSON-LD, NAP, meta único, hash cambiante y recurso faltante 503 |
| HTML | PASS estructural con html5lib: cero errores de parseo, H1/main únicos, 48 IDs públicos/52 preview, referencias ARIA/for resueltas, alt en imágenes. No es certificación Nu/W3C |
| Sitemap / enlaces | XML parseable, 11 URLs, raíz única; destinos internos de Home y fragments existentes, sin archivos/anchors ausentes; recursos referenciados presentes |
| Responsive normal | Público y Preview: 320/360/390/425/600/768/820/992/1024/1280/1440/2560px; overflow 0 |
| Texto 200% | Ambos: 320/360/390/425/768/820/1024/1440px; overflow 0 con y sin scripts. Raíz 32px solo en laboratorio, sin tocar SCSS del producto |
| Fallback sin scripts | Ambos en doce anchos; cero etiquetas script, navegación expandida visible/Header no sticky, contenido, enlaces y medios nativos conservados. Se renderizan también los noscript en el fixture; no es desactivar el motor del navegador |
| Teclado / foco | Menú Enter/Space, Discover, Escape por niveles/retorno, Skip→main, Tab/Shift+Tab, 76 pasos registrados incluidos vídeos/Footer, cero foco en escenas inert; Experiences→región corregido. Anillo Core visible |
| Hero / Guest | Selección de escenas con Space/Home y aria-current; Guest Home/End, estado 3–4 de 4 al extremo; reproducción nativa del primer clip readyState 4 y pausa por Space. Adaptadores/media restantes conservan evidencia R2; no se afirma nueva escucha de testimonios |
| Navegación real | CTA de reserva y `/#reservation` llegan a `/index.html?legacy=1#reservation`, con `clandestino-reservation-form`; sin enviar el formulario |
| Axe | Cero infracciones automáticas en ambos anfitriones a 390/768/1280. Revisión incompleta de contraste fotográfico y captions; preview también relación a modal oculto. No se presentan esos incompletos como PASS manual |
| Contraste | Sin cambios de colores/overlays ni nuevas superficies; se conserva la evidencia parcial R2. Axe cubre los casos evaluables, no todos los píxeles/escenas; no se declara contraste fotográfico completo |
| Consola / imágenes | Sin errores/warnings observados en carga normal; seis recorridos completos de captura con imágenes visibles cargadas, ninguna con naturalWidth 0 fuera de escenas inert |
| Integridad / diff | `git diff --check` PASS; index.html, handlers, páginas comerciales y tres informes previos intactos |
| Apache/GoDaddy | **PENDIENTE:** no hay httpd/apache2/Docker operativo disponible; fixture PHP y CGI no interpretan `.htaccess`. No se afirma haber ensayado rewrites ni GoDaddy |

Evidencia externa: `C:/Users/Mike/.codex/visualizations/2026/11/03/01a1a2e9-eac1-73c0-a558-cae8d4bbc1af/home-r3/`. Incluye logs, HTML renderizado, `html-routes-geometry.json`, geometría de ambos anfitriones, reflow/nojs, axe, recorrido de Tab y hashes. Capturas `preview-{390,768,1280}.jpg` / `public-{390,768,1280}.jpg`, tras recorrer el documento para cargar imágenes diferidas; `capture-loaded.json` registra anchos efectivos y ausencia de imágenes pendientes. `public-header-before-alignment.jpg`, `header-preview-320.jpg`, `header-public-320.jpg` y vistas de revisión registran la excepción del Header. Las capturas R2 anteriores permanecen en `home-r2/` y `home-r2-close/`.

Los instrumentos de texto/axe/sin scripts y el parser auxiliar viven fuera del repo. El fixture HTTP conservado en scripts permite reproducir el anfitrión y los contratos PHP; **no es un servidor de producción**. Cambios de viewport con pintura aún pendiente se excluyen de las capturas finales. Las capturas de página completa pueden omitir capas animadas fuera del viewport, aunque la imagen esté cargada: `public-private-768.jpg` comprueba la fotografía real de Private Experiences y su foco en viewport, sin alterar la animación aprobada. No se declara zoom nativo 200%, lector de pantalla auditivo, Safari/Firefox, dispositivo físico, Rich Results Test, Schema Markup Validator, tarjetas sociales remotas ni Search Console como pruebas realizadas.

## QA final de cierre y aprobación técnica

La aprobación visual explícita del responsable se registra en este documento. No se modifica el Header aprobado ni se introduce otra intervención visual durante el cierre; 14 fuentes de Header/arquitectura comprobadas por SHA256 permanecen idénticas a la revisión puntual aprobada. El diff final se revisa contra `origin/develop`, incluidos los ocho archivos nuevos de R3, sin incorporar los tres informes locales históricos.

| Control repetido en el cierre | Resultado |
|---|---|
| Lint/build | PASS: ESLint, Stylelint y build completo; sin dependencias nuevas |
| PHP / Node | PASS: 65 PHP; tres suites Node existentes, 126 casos de formularios y 27 de fechas/sesión; fechas PHP ejecutadas también directamente |
| Contratos R3 | PASS: 72 comprobaciones HTTP/PHP/CGI, incluido rollback y ausencia de activación en el repositorio de trabajo; el marcador solo se crea en la copia temporal |
| HTML / JSON-LD / XML / enlaces | PASS estructural: cero errores html5lib, 48 IDs públicos/52 preview, H1/main únicos; JSON Restaurant parseable y consistente; sitemap XML con once URLs; destinos y anchors comprobados |
| Público y Preview | PASS en 320/390/820/1440px, tras recorrer el documento y cargar imágenes: overflow 0, sin imágenes pendientes fuera de escenas inert, una escena activa y cuatro vídeos; mismas dimensiones de secciones entre anfitriones, salvo la diferencia aprobada de Header a 320px |
| Texto ampliado | PASS: ambos anfitriones a texto 200% en 320/390/820/1440px, con y sin scripts, overflow 0; fallback con navegación visible y Header desplazable. Es simulación de raíz a 32px, no zoom nativo |
| Menú / teclado / foco | PASS: menú móvil, Discover/Space/Escape, cierre y foco de Experiences en su región; Skip/Tab/Shift+Tab y foco visible; menú de ambos anfitriones a 320px/texto 200% cierra con Escape y retorna el foco; Discover de escritorio cierra y retorna foco |
| Hero / Guest / CTA | PASS: selección de escena y estados current/inert; Guest Home/End con posiciones estables; CTA y deep link de reserva llegan al formulario R1, sin enviarlo |
| Consola / assets | Sin errores/warnings observados en carga normal; CSS, main y tres chunks reales devuelven HTTP 200 y MIME correcto; entradas versionadas por contenido |
| Axe | Cero infracciones automáticas en ambos anfitriones a 390/820/1440px; se conservan incompletos de contraste fotográfico, captions y relación de preview a modal oculto, sin convertirlos en certificación manual |
| Protección / estado previo al cutover | PASS local: raíz normal idéntica a index.html, home.php cerrado 404, Preview/candidato noindex y marcador ausente; main, páginas HTML y handlers no se modifican |
| Apache / servicios externos | No ejecutado: Apache representativo, GoDaddy, Cloudflare/CDN, Search Console, Google Rich Results y validadores sociales remotos; siguen pendientes antes de activar |

Evidencia final: `C:/Users/Mike/.codex/visualizations/2026/11/03/01a1a2e9-eac1-73c0-a558-cae8d4bbc1af/home-r3-close/`, con logs, capturas de los cuatro anchos, geometría tras carga, parser, JSON/XML/rutas, HTTP/MIME de assets, texto/fallback, axe e integridad de fuentes. La revisión específica de Header y sus seis capturas comparativas permanece en `home-r3-header-review/`. Las capturas completas pueden omitir capas animadas fuera del viewport; se conservan las verificaciones de fotografía en viewport, sin cambiar animaciones para producir una captura.

**Aprobación técnica: R3 apta para commit, push de feature y PR manual hacia develop.** Los pendientes de producción no bloquean esta preparación desactivada; sí deben resolverse/verificarse antes del cutover conforme al procedimiento siguiente. Esta aprobación no declara funcionamiento de Apache en GoDaddy, entrega real de correo, rich results ni conformidad audiovisual WCAG AA completa.

## Inspección local reproducible

Desde la raíz del repo, con el build terminado y comprobando que los puertos estén libres:

```powershell
npm.cmd run lint
npm.cmd run build
php -d disable_functions=mail -S 127.0.0.1:8000 -t .
```

En otra consola, candidata pública local sin crear marcador:

```powershell
$env:CL_HOME_PUBLIC_REVIEW = '1'
php -d disable_functions=mail -S 127.0.0.1:8002 -t . scripts/fixtures/home-public-router.php
```

Abrir `http://127.0.0.1:8000/home-preview.php` y `http://127.0.0.1:8002/`. El servidor 8000 mantiene `/` histórica y `/home.php` 404; 8002 muestra el candidato con noindex. La variable solo habilita revisión en CLI-server/loopback; no permite activación en Apache/CGI. Cerrar ese proceso y retirar la variable de su consola al terminar. No iniciar otro proceso sobre los servidores de revisión si ya están disponibles.

Ejecutar `node scripts/probar-home-publica.mjs` para el ensayo positivo indexable y rollback aislados. Usa puertos efímeros, copia temporal y php-cgi disponible en PATH; elimina solo su copia. No activar el marcador real para ensayar. Para texto/fallback, el laboratorio externo en 8003 sirve `/qa/public?texto=200&sinjs=1` y `/qa/preview?texto=200&sinjs=1`; los parámetros no existen en el producto.

## Release futuro — no ejecutado

1. Obtener autorización específica de publicación: la aprobación del Header y la preparación para PR no activan el cutover. Cerrar H02 audiovisual y H03 comercial/Pure Soul y verificar recepción operativa R1 con autorización. Confirmar datos/horario vigentes antes de la fecha comercial objetivo 2026-11-15; la fecha no se introduce como oferta/evento/schema.
2. Crear backup recuperable fuera del DocumentRoot del release anterior, incluidos `.htaccess`, sitemap/robots, assets y chunks. Comprobar que el mecanismo de entrega no borre archivos ignorados operativos ni incluya accidentalmente el marcador.
3. Ensayar la configuración en **Apache representativo**: sintaxis, AllowOverride, módulos/versión, DirectoryIndex, root vs acceso directo, headers/noindex, query/fragments y retirada del marcador. Verificar PHP/HTTPS/proxy/caché y reproducción de posters/MP4. Después repetir en staging de GoDaddy protegido; no sustituirlo por PHP built-in.
4. Entregar PHP/includes y el build completo compatible: home.css, main.js, todos los chunks con hash, sprite, logo/media/fuentes e iconos requeridos; conservar assets legacy. No subir node_modules, `.git`, reportes, herramientas, secretos ni fixtures al hosting. Conservar chunks del release previo al menos durante el TTL de siete días y sesiones/documentos abiertos; no hacer limpieza destructiva durante la transición.
5. Con el marcador aún ausente, confirmar raíz histórica, preview denegado y código PHP no descargable. Preparar sitemap/robots y configuración del mismo paquete; validar que el middleware/CDN no elimina X-Robots-Tag ni cachea HTML como estático.
6. Solo tras nueva autorización de publicación, crear **al final** el marcador operativo vacío en el DocumentRoot, de forma atómica. No cambiar index.html ni DirectoryIndex en esa operación.
7. Comprobar desde perfil limpio y perfil con caché anterior: `https://theclandestinousa.com/` 200, canonical único/index; HTTP/www→HTTPS sin ciclos; `/home.php`→`/` y destino 200; `/index.html?legacy=1#reservation` formulario usable + noindex HTTP; `/home-preview.php` denegado; cero chunks/media 404, no metadatos duplicados. Verificar todos los CTA y un envío controlado autorizado de formulario.
8. Validar URL pública/JSON-LD en Rich Results Test y Schema Markup Validator, inspección de URL y sitemap en Search Console, y previews sociales reales. No garantizar rich results, indexación ni resultados de IA por tener JSON parseable. Monitorizar errores 4xx/5xx, solicitudes, conversiones y CWV reales después de publicación.

## Rollback futuro — no ejecutado

Ante fallo, retirar el marcador operativo fuera del DocumentRoot: `/` vuelve a `index.html`, se restablece su redirect histórico y desaparece su noindex condicional; `home.php` vuelve a 404 y los posters vuelven a su protección previa. Las peticiones ya iniciadas pueden acabar con el contexto anterior: volver a medir una petición nueva. No se elimina ni restaura contenido comercial para lograrlo, porque no se sobrescribió.

Si falla la propia sintaxis de `.htaccess` (500 antes de ejecutar PHP), retirar el marcador no basta: restaurar el `.htaccess` del backup verificado, junto al sitemap/robots anteriores si se revierte el paquete completo. Conservar assets/chunks de ambos releases durante la transición; no usar `git clean`, reset destructivo, force push ni borrado de directorios. Revisar caché de CDN/navegador y repetir URLs/solicitudes antes de dar por recuperado el sitio. El rollback por marcador fue probado en el fixture, no en Apache.

## Pendientes reales de publicación

- H02: cuatro clips sin tracks de subtítulos, sin escucha editorial completa/transcripción verificada y sin alternativa audiovisual integral. No se crean VTT/SRT en R3; evaluar captions/sonidos relevantes, alternativa y audiodescripción por clip. Permisos/audio declarados previamente no se reabren. **No hay afirmación de WCAG AA completa.**
- H03: aprobación comercial identificable del arte/claims de Pure Soul y de ofertas en destinos legacy. La aprobación visual no acredita precios, añadas, beneficios o disponibilidad. No se alteran en esta fase.
- Ensayo real de Apache/GoDaddy, validadores externos, caché previa/HTTPS/proxy y recepción de solicitudes. Son gates de publicación, no pruebas completadas.
- Optimización fotográfica H10, manejo de import fallido H12, tooling H14, CWV de campo y matriz completa de accesibilidad/navegadores permanecen en sus fases correspondientes. No se amplía R3 para resolverlos. La imagen social original se conserva; su entrega externa debe comprobarse.

## Archivos de R3

| Archivos | Responsabilidad |
|---|---|
| `.gitignore`, `.htaccess` | Marcador fuera de Git, DirectoryIndex, activación/retiro, directivas de indexación y protección de fuentes |
| `home.php`, `home-preview.php` | Anfitriones público futuro y local protegido |
| `includes/home-document.php`, `includes/home-head.php`, `includes/home-public.php` | Documento único, metadatos y helpers PHP de activación/schema/versionado |
| `includes/site.php` | Datos públicos y NAP compartidos |
| `includes/header.php`, `assets/scss/patterns/_navegacion-global.scss` | Omisión contextual de demos y alineación mínima pública |
| `includes/private-experiences.php` | Destino enfocable para navegación real |
| `includes/guest-stories.php`, `assets/images/guest-stories/.htaccess` | Contexto futuro habilitado, manteniendo protección previa mientras está desactivado |
| `assets/js/main.js`, `assets/js/modules/patterns/anclas-legacy.js` | Inicialización contextual y continuidad de reserva legacy |
| `robots.txt`, `sitemap.xml` | Rastreo coherente y única raíz canónica |
| `scripts/probar-home-publica.mjs`, `scripts/fixtures/home-public-router.php` | Contratos reproducibles aislados, sin transporte de correo |
| `docs/HOME-PUBLIC-SEO.md` | Decisión, evidencia, límites, release y rollback |

**HOME R3 READY FOR PR**
