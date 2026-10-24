# Home Hero — iluminación, motion y autoplay

2026-10-23. Rama feature/home-header-hero. **Diseño considerado satisfactorio por el usuario; entrega técnica preparada para revisión hacia develop.** La solicitud «HOME HEADER + HERO FINAL DELIVERY» autoriza commit y push de esta vista previa, sin crear PR automáticamente, fusionar ni desplegar. El registro de iluminación y motion siguiente conserva la evidencia del refinamiento anterior; el cierre de integración figura al final. Fuentes anteriores respaldadas fuera del repositorio en lighting-motion/antes.json.

## Iluminación

La versión anterior combinaba 24% global y 56% direccional: 66,56% efectivo donde se superponían. Se compararon las tres escenas a 425/768/1440 con referencia, intermedia (16% + 54%) y ligera (12% + 46%). Intermedia: mínimo 3,83:1; ligera: 2,81:1. Se descartan por contraste insuficiente.

Elegida adaptación: global **14%**, refuerzo máximo **61%**, efectivo **66,46%** solo en una zona más concentrada. Móvil/tablet: 12% de refuerzo arriba, máximo entre 12–70% de altura, transparente al final; antes el máximo llegaba al 78% y el borde inferior mantenía 16%. Desktop: máximo hasta 40% de ancho (antes 48%), 28% al 64%, transparente desde 92%. La región de lectura conserva protección y el resto de la fotografía recupera luz. Sin radial, caja, nuevo color ni cambio de encuadre. Promedio RGB de las capturas completas aumenta 5,2–10,2%; es una comparación de píxeles, no una medida física de exposición.

Contraste mínimo en reposo, muestreo de fondo bajo glifos renderizados; tres escenas en 390/425/768/1024/1280/1440/2560, Chromium DPR 1:

| Escena | Eyebrow | Título | Descripción |
|---|---:|---:|---:|
| 1 · Spanish Gastronomy | 4,59:1 | 5,55:1 | 5,48:1 |
| 2 · Social Experience | 4,60:1 | 5,55:1 | 6,01:1 |
| 3 · Pure Soul | 4,64:1 | 4,98:1 | 5,56:1 |

CTA: 12,69:1 primario y 16,01:1 secundario entre texto/fondo Core, sin cambios. Indicadores: 13,59:1 entre champagne y oscuro; anillo bicolor con límite calculado ≥3,69:1 de al menos uno de sus tonos contra cualquier luminancia de fondo. Ese límite es teórico, separado del muestreo fotográfico; target 44px y activo por forma, además de color. No se certifica WCAG global.

## Motion

Foto entrante: fundido de 720ms sobre la foto saliente opaca, sin fundir ambas contra negro. Fondo local de escena transparente para permitir ese cruce; geometría y encuadre intactos. El contenido saliente se oculta inmediatamente para no mezclar mensajes. Eyebrow/título/descripción/CTA entran con opacidad y 8px verticales durante 520ms; delays 0/40/90/120ms. Finaliza en transform:none y opacity:1, sin capa transformada permanente. Reduced motion elimina animaciones/desplazamiento y el cambio de visibilidad retardado.

## Pausas: causa y corrección

Reproducido con el módulo anterior respaldado, sin ejecutar dos controladores: focusin fijaba intencion=false; salir no lo restablecía. Cualquier pointerdown en la pista también lo fijaba permanentemente, incluso un tap o click sin navegación. Ambos seguían en paused tras esperar más de un intervalo.

Se sustituye el booleano ambiguo por un Set de causas independientes. Estados diagnósticos: running, loading, paused-hover, paused-focus, paused-hidden-document, paused-out-of-view, paused-user, disabled-reduced-motion, paused-image-error y destroyed. El atributo de causas conserva las simultáneas. Hover/foco/visibilidad/intersección son temporales; se reanuda solo cuando no queda ninguna. Un evento repetido sin cambio de causa no reinicia el intervalo.

Bullet, teclado o swipe reconocible siguen siendo interacción manual deliberada y pausan hasta Resume. Un tap/click vacío ya no deja una pausa permanente. El control de pausa existente permanece disponible a lector de pantalla y visible al foco, anillo de 2px. Reduced motion bloquea autoplay y permite navegación manual. Anuncio solo manual/error, no en cada cambio automático.

Un solo timeout de 6500ms; se limpia al cambiar estado/navegar/destruir. Decode está protegido por generación y revisión de pausas: una petición antigua no cambia escena tras una pausa o destrucción. Error conserva escena legible y permite reintentar por control existente. Se mantienen API e idempotencia WeakMap, sin modificar carrusel.js ni main.js.

## QA ejecutado

- npm run lint, npm run build, php -l home-preview.php, HTML estructural (cierres, IDs únicos, H1, alt) y git diff --check: PASS. Se corrigieron espaciado de keyframes y especificidad de reduced motion antes del cierre. Assets de guía restaurados tras build.
- 16 transiciones consecutivas reales, varias vueltas; intervalos posteriores al primero ~6,5s. Instrumentación del timeout real: máximo uno activo, sin acelerar el reloj.
- Hover y foco entrar/salir repetidos, causas simultáneas, click vacío, pausa manual durante >6,5s/reanudación y recuperación efectiva de escena: PASS.
- Visibility API emulada: cero timers al ocultar; recupera running al volver. IntersectionObserver nativo con espacio añadido solo al DOM de QA para poder desplazar totalmente el Hero fuera de vista: pausa y recuperación correctas.
- Resize durante transición, móvil↔desktop, entrada de contenido y final transform:none: PASS. Reduced motion: animation:none, transform:none, cero timers y navegación manual válida.
- Idempotencia, destruir/reinicializar y destruir con decode pendiente: PASS; 0 timers tras destruir, 1 tras reiniciar, petición tardía no activa otra escena.
- Geometría final de foto/contenido/título/descripción/CTA idéntica a la referencia en 15 casos de los cinco anchos obligatorios; adicionales 390/1280, sin overflow horizontal. Capturas de tres escenas por ancho y variantes inspeccionadas.
- Style Guide smoke: Reviews y vídeo End/Home hasta extremos, galería abrir/Escape/retorno; sin errores de página observados. Home: sin pageerror ni HTTP ≥400 en sesión revisada. No se certifica toda la matriz histórica.

Recursos: CSS 62906 B / 11547 B gzip; JS 38378 B / 12155 B gzip. Laboratorio local sin throttling: LCP inicial 425px 1312ms, 1440px 1268ms; CLS 0 en ambas muestras. Solo primer banner solicitado al inicio. No equivalen a Core Web Vitals de campo.

Código editado: assets/scss/home.scss y assets/js/modules/patterns/escenas-hero.js. Documentación: este registro y notas Home en ARQUITECTURA.md / SECTION-PATTERN-LIBRARY.md. Home PHP, main.js, carrusel de colecciones, Wave 1 global, Header/nav/drawer y index.html idénticos al inicio. Sin nuevas dependencias, imágenes, rutas ni controles.

Evidencia: C:/Users/Mike/.codex/visualizations/2026/10/21/01a15f31-e70b-75b1-a2ca-76cd17ea7ffc/lighting-motion/. comparativa-{425,768,1024,1440,2560}.png: arriba anterior, debajo final, columnas escenas 1/2/3. variantes-{425,1440}.png; entrada-100.png / entrada-final.png. JSON: contraste-por-escena, contraste-controles, geometria-comparada, reproduccion-anterior, estabilidad, ciclo-vida, regresiones, rendimiento, html y proteccion.

Limitaciones reales: cambiar de pestaña en este Chromium headless no cambió document.hidden; no se afirma prueba nativa de pestaña oculta. Se probó su política mediante Visibility API emulada. Sin Safari/Firefox, táctil físico, lector auditivo ni zoom real 200%. Revisión: http://localhost:3000/home-preview.php.

## Entrega final de integración — 2026-10-23

Base local y origin/develop verificadas mediante fetch: 433622d26b1a5d94a67dbc085fef1dac89003304. La aprobación visual procede de la declaración del usuario de que el refinamiento resulta satisfactorio; no equivale a activación comercial ni autorización de merge/deploy.

- Header y acceso: partials Wave 6 existentes. Hero: partial editorial compartido por Home, Patterns y Navigation, estilos Wave 1 y botones Core. Entrada SCSS selectiva y main.js condicionado al anfitrión Home; sin CSS legacy, scripts de guía, fixtures comerciales, mini-cart ni nuevas dependencias en el bundle Home. La fábrica de mini-cart se inyecta exclusivamente en el laboratorio transaccional.
- Se retiran dos restos sin consumidores de la primera implementación: indicadores opcionales de carrusel.js y variables de opacidad del radial base. Ambos archivos quedan idénticos a develop; Home mantiene su tratamiento fotográfico aprobado. No se cambian diseño, textos, encuadres ni controles.
- Vacío conocido: badge 0 y modal neutral explícitamente demostrativo. Account conserva el acceso demostrativo aprobado. No existe proveedor comercial, autenticación, checkout ni nueva integración de reservas. El drawer conserva solo Wave 6; debe cerrarse antes de usar los iconos originales Cart/Account.
- Destinos provisionales comprobados con HTTP 200 y anclas existentes: reserva /index.html#reservation, experiencias /index.html#services, Private Experiences /index.html#private-events, Pure Soul /index.html#pure-soul, vinos /wines.html, club /swc.html; navegación adicional /menu.html, /about.html y /contact.html. Se reutilizan páginas legacy; no se valida ni activa su backend. Las futuras páginas reales sustituirán estas rutas mediante los datos del anfitrión.
- Vista local exclusiva de PHP cli-server, noindex y 404 en otros SAPIs. npm run dev sirve http://localhost:3000/home-preview.php. index.html conserva su SHA-256 0e8e79cf732c4080b58d8aa66968ca2e60fa6acf4b181e69986219ec927e1652 y no presenta diferencias funcionales frente a production-baseline. PNG originales conservados; seis WebP en 768/1672px, 81702–327932 B. Fuentes originales 1672×941: no se promete detalle nativo 4K.

QA de cierre ejecutado sobre el build: lint JS/SCSS, build, cuatro PHP lint, validación estructural del HTML renderizado (cierres, IDs, un H1, alt, href y type) y git diff --check. Scripts Node existentes probar-carrito.mjs y probar-cierre-comercio.mjs: PASS. La comprobación HTML es estructural, no certificación W3C.

Navegador Chromium, DPR 1: tres escenas a 390/425/768/1024/1280/1440/2560 (21 casos), fuentes cargadas, copy y CTA dentro del media, inactivos inert/aria-hidden y sin overflow. Capturas inspeccionadas; no flechas ni control de rotación visible en reposo. Autoplay: 18 transiciones reales, loop y máximo un timeout. Hover/foco recuperables, pausa manual persistente, teclado Home/End, reduced motion sin animación y navegación manual, Visibility API emulada e IntersectionObserver nativo: PASS. Destruir deja cero timers, reiniciar deja uno; decode tardío no activa otra escena. Drawer/Discover, Escape, foco visible y retorno de foco de Cart/Account sin backdrops ni scroll lock residuales: PASS. Sticky comprobado con espacio añadido solo al DOM de QA para permitir scroll completo.

Contraste revalidado con máscara de glifos interiores y captura del fondo fotográfico en los 21 casos: mínimos globales eyebrow 4,59:1, título 4,98:1, descripción 5,48:1. Por escena (eyebrow/título/descripción): 1: 5,13/5,55/5,48; 2: 4,67/5,56/6,20; 3: 4,59/4,98/5,61. El muestreo del refinamiento anterior, más amplio en bordes de glifos, se conserva arriba. CTA Core sin cambios: 12,69:1 y 16,01:1. No se certifica accesibilidad global.

Regresiones smoke: galería abrir/Escape/retorno, carruseles Reviews/vídeo Home/End hasta extremos (tolerancia de redondeo 1px), mini-cart abrir/foco/cerrar, cantidad/eliminar/Undo y badge 2→3→1→3→0→2: PASS. Sin errores de página observados en guía; sin errores de consola ni HTTP ≥400 en las sesiones Home revisadas. No se afirma cobertura exhaustiva de todas las Waves.

Mediciones locales nuevas, sin throttling: home.css 62847 B / 11534 B gzip; main.js 38378 B / 12155 B gzip. LCP 425px 1192ms y 1440px 1144ms; CLS 0 en ambas muestras. Siete recursos iniciales observados y solo el primer banner (768/1672 según viewport); los otros se materializan al navegar. No son Core Web Vitals de campo.

Evidencia local fuera del repositorio: C:/Users/Mike/.codex/visualizations/2026/10/21/01a15f31-e70b-75b1-a2ca-76cd17ea7ffc/final-delivery/. Capturas home-{ancho}-{escena}.png y láminas escenas-{ancho}.png; geometria.json, funcional.json, autoplay.json, ciclo-vida.json, contraste.json, regresiones.json, rutas.json y rendimiento.json. No se incluyen capturas ni temporales en Git. Continúan las limitaciones de navegador/dispositivo/lector/zoom descritas arriba; revisión de código mediante PR y futuras integraciones comerciales siguen pendientes.
