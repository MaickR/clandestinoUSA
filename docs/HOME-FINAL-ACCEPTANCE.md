# Home R9 — aceptación final y traspaso

2026-11-10 · America/Bogota · **Home DEVELOPMENT COMPLETE** · **Home PRODUCTION NOT LIVE**

El responsable aprobó el cierre del desarrollo local de la nueva Home. La publicación requiere autorización independiente y completar los pendientes de activación de este informe. La raíz de operación permanece en la Home histórica. La candidata de revisión es local, no indexable y no habilita cuenta, carrito ni cobros.

R8 (`3117bc3`) está en `origin/develop` mediante el PR #34 (`a04918a`). `develop` avanzó por fast-forward desde `705cbc5` y se creó `feature/home-final-acceptance` desde `a04918a`. El árbol Git del merge es idéntico al de R8 (`7ee79d288cd1a9c5beb379d8fd88e23df4e439af`). No se modificaron diseños, código, dependencias ni `main`. Los tres informes históricos locales conservan sus SHA256 y siguen sin rastrear.

## Evidencias de aceptación

| Control | Evidencia |
|---|---|
| Header y accesibilidad visual | **R9:** candidata empaquetada en Chrome 157 a 390×844, 768×1024 y 1280×800; capturas revisadas, un H1 y un `main`, enlace de salto, sin desbordamiento horizontal ni errores de consola o HTTP en las solicitudes locales observadas. A 1023 px el menú abre con Enter, cierra con Escape y devuelve el foco visible; a 1024 px aparece la navegación horizontal. Preview conserva los accesos demo del panel; la candidata los omite del HTML junto con sus diálogos. **R6/R8:** matriz de teclado, foco, reflow, alt y contraste; R8 registró 96 muestras de contraste (mínimos 5,014:1 para texto normal y 5,235:1 para texto grande). |
| Hero y fotografía | **R9:** tres escenas seleccionadas por teclado, una petición inicial y tres recursos de escena tras recorrerlas. En 390 px se decodificaron los tres AVIF verticales; en 768 px vertical, mesa y brindis usan los verticales y Pure Soul usa la horizontal; a 1280 px el Hero inicial usa la horizontal. **R8:** 15 tamaños/orientaciones, AVIF/WebP y fallbacks existentes, encuadres y carga diferida aprobados. |
| Contenido y movimiento | **R9:** Discovery, Pure Soul, Private Experiences, Guest Stories, Reservations, Wine Club, Gifting y Visit están presentes y recorribles. El chunk GSAP carga y el grupo fotográfico de Private Experiences alcanza `COMPLETE`. Con reduced motion, el Hero desactiva el autoplay y no hay estilos de entrada activos; sin JS, navegación, Hero inicial y enlace a reserva siguen disponibles. Los cuatro vídeos conservan controles nativos, están en pausa y usan `preload="none"`. **R6/R8:** secuencias, saltos y fallbacks de carga ya probados. |
| CTA y formularios | **R9:** 15 destinos internos únicos responden 200 y sus fragments existen, incluidos los CTA de las tres escenas. Menú, tapas, vinos, Wine Club y hampers llevan a sus páginas existentes; eventos privados y Gift Cards, a `/contact.html#contact-form`. `tel:` y Maps se comprobaron como destinos configurados, sin iniciarlos. El CTA y `/#reservation` llegan a `/index.html?legacy=1#reservation`. Contacto genera CSRF. Un POST sintético de reserva devolvió 200 y «Request sent», con confirmación humana posterior indicada; `mail()` nativo deshabilitado y transporte simulado. **R7/R8:** se reutilizan los 126 casos de formularios y 27 comprobaciones de fechas/sesión. |
| SEO y protección | **R9:** raíz desactivada idéntica al `index.html` vigente y `/home.php` 404. Candidata loopback 200 con `noindex, nofollow` y `no-store`, canonical único `https://theclandestinousa.com/`, OG/Twitter y un JSON-LD `Restaurant`. Preview local noindex/no-store, sin canonical público ni JSON-LD y ausente del paquete. **R3/R7/R8:** contratos de robots/sitemap, publicación, denegación Apache y rollback ensayados en laboratorio. |
| Build y paquete R7 | **R9:** `npm.cmd run build` y empaquetador R7 sobre el merge integrado. 885 archivos, 354.643.732 B; todos los tamaños y SHA256 cotejados con el document root. Incluye 41 derivados R8, CSS, sprite y cinco archivos JS de producción. Excluye Preview, marcador, originales de trabajo, informes y herramientas. El SHA256 del manifiesto nuevo es `aa900bc80c2fd25e7ccbbc92952035acb36a7ae14e2ee3864e0992c5aa8a076a`. Al sustituir únicamente `base` por `705cbc5` completo, coincide con el SHA256 publicado en R8: `5c624080475dc55615a8fae427460d79f4a52d406bf2b525ea4feb88fb1aa57d`. Esto verifica la identidad del contenido entregable. **R8:** se reutilizan las 211 comprobaciones Apache/TLS/FastCGI y las suites de cierre; no se repitieron instalación, Lighthouse ni auditorías generales. |

Fuentes: [R3 · SEO público](HOME-PUBLIC-SEO.md), [R6 · navegación y movimiento](HOME-MOTION-DESIGN.md), [R7 · paquete y operación](HOME-DEPLOYMENT-READINESS.md) y [R8 · fotografías y cierre](HOME-R8-VISUAL-ASSETS.md). Los resultados previos se toman de los informes versionados; el cotejo por hash no requiere acceso al manifiesto histórico.

Los resultados detallados del recorrido y de la integridad del paquete, junto con las capturas de 390, 768 y 1280 px, se conservaron como evidencia local fuera del repositorio. Se usaron PHP CLI en loopback y Chrome con terceros bloqueados. El recorrido leyó la candidata desde el document root empaquetado. La evidencia sobre las reglas de Apache proviene de los ensayos de R7 y R8. Los puertos efímeros se cerraron al terminar.

Para reproducir la revisión local desde la raíz, con puertos libres:

```powershell
npm.cmd run build
node scripts/empaquetar-home.mjs .dist/home-r9-qa
php -d disable_functions=mail -S 127.0.0.1:8000 -t . scripts/fixtures/home-public-router.php
# En otra consola, solo para revisión local:
$env:CL_HOME_PUBLIC_REVIEW = '1'
php -d disable_functions=mail -S 127.0.0.1:8002 -t . scripts/fixtures/home-public-router.php
```

El destino de empaquetado debe ser nuevo. Abrir `http://127.0.0.1:8000/home-preview.php` y `http://127.0.0.1:8002/`; comprobar 390/768/1280 px y el límite 1023/1024 px. Para la reserva, abrir el CTA y verificar el formulario. Para probar envíos usar únicamente el fixture de transporte simulado de R7, fuera del paquete.

## Bloqueantes y límites del cierre

**Sin bloqueantes locales de la nueva Home.** Hay un pendiente de activación en el recorrido heredado de reservas: [el formulario histórico](../index.html#reservation) usa [reglas de navegador](../assets/js/script.js) para mostrar un estimado y franjas simuladas, sin consultar inventario real. R9 reprodujo tanto «Disponible provisionalmente» como «Ese horario ya está reservado» en una franja prefijada. La solicitud sí llega al handler R1 con transporte simulado; el 200 significa que se aceptó para procesamiento, no que se asignó una mesa. Antes de publicar, retirar o sustituir esas reglas simuladas y validar los mensajes y la posibilidad de solicitar una mesa. Este hallazgo no requiere reabrir el diseño de Home.

## Pendientes de hosting real

- En staging privado de GoDaddy/cPanel, verificar DocumentRoot, módulos y `AllowOverride`, versión/handler PHP, permisos de sesión y temporales, y logs privados. Comprobar ejecución PHP, denegaciones, redirects, MIME AVIF/WebP, Range MP4 y recursos versionados.
- Acreditar TLS de origen, confianza del proxy, reglas de Cloudflare y caché por query; excluir HTML, sesiones y POST de caché. Probar perfiles limpio y con caché anterior, y Safari/iOS en dispositivo real. Medir rendimiento en condiciones de hosting.
- Confirmar correo de contacto/reserva con una prueba operativa autorizada: entrega, remitente, SPF/DKIM/DMARC, spam y respuesta del equipo. Ensayar la restauración del backup real y la purga/reversión de CDN. Nada de esto se ejecutó en R9.

## Guest Stories: accesibilidad audiovisual

Los cuatro clips tienen título, descripción breve, póster y controles nativos, pero no pistas de subtítulos. Escuchar y revisar cada clip; verificar y editar transcripción, subtítulos sincronizados con diálogo y sonidos pertinentes, y alternativa descriptiva o audiodescripción según el contenido. Comprobar idioma, controles y disponibilidad de las alternativas en el reproductor. Es un pendiente previo a publicación; no se declara conformidad WCAG AA completa.

## Funciones comerciales aún no implementadas

- Cuenta/autenticación y sesión de cliente; carrito persistente, pedidos, checkout y cobros.
- Take Away transaccional, compra de vinos o hampers, altas y cobros del Wine Club, y emisión/venta/redención de Gift Cards.
- Inventario de mesas, disponibilidad y confirmación automática de reservas, o contratación/pago de eventos. Los flujos disponibles son exploración o consulta; reserva y contacto son solicitudes gestionadas por el equipo.

## Contratos reutilizables

| Reutilizar | Contrato para las siguientes páginas |
|---|---|
| `includes/site.php`, `includes/header.php`, `includes/footer.php` | Un origen de configuración para NAP, horarios, rutas y navegación activa. Header compartido con Offcanvas a menos de 1024 CSS px, fallback expandido, Escape y retorno de foco. Renderizar acciones comerciales solo si el anfitrión dispone del servicio real; conectar cuenta y mini-carrito a los componentes existentes (`conectarCarrito`, `actualizarCarrito`). |
| Foundation/Core y patrones editoriales | Reusar tokens, sprite, botones, enlaces, `cl-seccion`, `cl-historia`, `cl-banda-cta`, patrones de membresía y carrusel/media. Mantener semántica de secciones y destinos enlazables. Las composiciones y secuencias específicas de Home sirven como referencia, sin convertirse en dependencias de otras páginas. |
| Home Hero, imágenes y movimiento | `<picture>` con dimensiones, alt contextual y AVIF/WebP según encuadre; cargar primero solo la imagen crítica y diferir escenas secundarias. Mejorar con GSAP/ScrollTrigger solo donde se necesita; contenido legible de base, una entrada y respeto de reduced motion. |
| Anfitrión, SEO y formularios | Documento compartido con head contextual, canonical fijo, schema veraz y entradas CSS/JS versionadas. Para consultas y solicitudes, reutilizar endpoints y protecciones R1 (sesión/CSRF, validación en servidor y mensajes accesibles). Mantener el enlace de reserva legacy con su query y fragment mientras siga siendo el destino. |

## Lista para activación futura — sin ejecutar

- [ ] Obtener autorización de publicación y confirmar horario/NAP, claims de Pure Soul y condiciones vigentes de las ofertas legacy. Resolver la accesibilidad audiovisual de Guest Stories y retirar la disponibilidad simulada de reserva.
- [ ] Generar el paquete desde `main` o tag aprobado; validar manifiesto, cuotas y dependencias. Guardar backup restaurable fuera del DocumentRoot y acordar responsables, ventana y umbrales de rollback.
- [ ] Superar staging privado con el handler, proxy y TLS reales. Verificar sesiones, formularios, correo autorizado, contenido audiovisual, caché y rollback.
- [ ] Entregar primero recursos/chunks y luego entradas y PHP, conservando los chunks previos. Con la Home todavía desactivada, verificar raíz histórica, Preview denegado y rutas privadas protegidas.
- [ ] Solo con autorización de cutover, crear `.home-public-enabled` al final, de forma atómica. Comprobar raíz 200/indexable solo en el origen canónico HTTPS, `/home.php` → `/`, reserva legacy accesible y noindex, CTA, consola y medios. Validar sitemap/robots, schema, tarjetas sociales y Search Console.
- [ ] Monitorizar errores y solicitudes. Ante fallo, retirar el marcador, purgar HTML cuando corresponda y confirmar la raíz histórica. Si falla la configuración Apache, restaurar `.htaccess` y la configuración anterior desde el backup; verificar nuevamente rutas y formularios.
