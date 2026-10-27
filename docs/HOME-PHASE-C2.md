# Home C2 — Private Experiences

2026-10-27. Rama `feature/home-private-experiences`, base `8e790e7`. Árbol limpio al comenzar. El registro inferior conserva las decisiones y verificaciones de cada etapa; este cierre establece el estado vigente.

## Cierre técnico — preparación de PR hacia develop

El responsable autoriza el cierre técnico y la publicación de la rama, sujetos a su revisión visual final. Se conserva The Private Invitation: fotografía `the-clandestino.jpg`, invitación solapada, separador ornamental, superficie cálida y CTA único de consulta. Este cierre no rediseña ni añade funciones. Se autoriza el commit `feat(home): integrar experiencias privadas` y un push normal a la rama feature; la creación del PR, el merge y el deploy quedan fuera del encargo.

Auditoría tras `git fetch origin`: HEAD, `develop` y `origin/develop` coinciden en `8e790e791d9380cde2d3930c79d6e4c5e815ee4d`, que incorpora Pure Soul. La rama feature no tenía publicación remota previa. El alcance comprende trece archivos: partial de C2, inclusión en Home Preview, SCSS de Home, ocho derivados AVIF/WebP y dos documentos. Sin temporales de QA, dependencias, analítica, fixtures, backend ni cambios de Envato. Header, Hero, Welcome, Spanish Table, Pure Soul, Footer y sus fuentes permanecen intactos. `index.html` tampoco cambia y coincide con `production-baseline` al ignorar CRLF. Los originales fotográficos conservan sus hashes; los ocho derivados se referencian en los dos srcsets y el JPEG permanece como fallback.

| Validación repetida para el cierre | Resultado |
|---|---|
| `npm run lint` y `npm run build` | PASS, sin instalaciones |
| `php -l` de Home Preview y nueve includes | PASS |
| `node scripts/probar-carrito.mjs` | PASS |
| `node scripts/probar-cierre-comercio.mjs` | PASS |
| HTML estructural local | PASS: anidamiento, 24 IDs únicos, H1 único, H2 asociado, ARIA, alt, dimensiones y CTA único; no certificación Nu/W3C |
| Recursos | Home, CSS, ocho derivados, fallback y Contact responden HTTP 200; partial directo responde 404 |
| Responsive local | 320/390/425/768/1024/1280/1440/2560 px sin overflow; CTA de 44 px o más |
| Teclado y destino | Tab desde Pure Soul alcanza CTA con foco champagne de 2 px y offset de 3 px; Enter abre `/contact.html#contact-form` y su formulario existente |
| Sin JavaScript | Scripts retirados y CSP `script-src 'none'` en anfitrión de QA externo: relato, imagen cargada y CTA con foco operativos |
| Consola Home | Sin errores ni warnings observados |
| `git diff --check` | PASS |

Revisión local de la composición y continuidad desde Pure Soul en móvil y tablet, además de desktop: sin cambio visual respecto al pulido aceptado. Capturas y resultados de cierre fuera del repositorio en `C:/Users/Mike/.codex/visualizations/2026/10/27/01a17bfa-36e8-7ce0-956c-d78c0f9bb620/c2-closure/`. Contraste recalculado con los colores renderizados: párrafo 8,80:1, titular 10,49:1 y CTA 12,69:1. Las pruebas previas de CLS y movimiento se conservan en sus apartados, sin atribuirlas a una medición nueva de este cierre.

La integración reutiliza Foundation/Core, sección, historia, media de experiencia, contenedor y breakpoints Bootstrap; sus ajustes son locales en `home.scss`. No añade JavaScript ni requiere Node en producción. El partial es PHP tradicional y el pipeline genera estáticos compatibles con el destino Apache/cPanel previsto. `home-preview.php` conserva deliberadamente su restricción a `cli-server` y no activa la Home pública.

Pendientes: revisión visual final del responsable, zoom nativo 200 %, otros motores/dispositivos, lector de pantalla y ejecución remota en GoDaddy/Apache. No se enviaron formularios ni se verificó entrega de correo. Una fotografía real futura de mesa preparada para una celebración sigue siendo una oportunidad, no un bloqueo del recurso aceptado. La publicación de esta rama no equivale a despliegue ni aprobación comercial.

## Pulido editorial previo — composición aceptada como base

El responsable acepta The Private Invitation como base artística y solicita únicamente revisar superficie, tamaños reales y fotografía. Se conserva íntegramente su estructura, posición, proporciones, solapamiento, separador, línea editorial, copy y movimiento CSS existente.

El único ajuste de producto es el fondo local de la invitación: `color.mix($champagne-500, $neutral-800, 5%)`. El neutro recibe una aportación leve de champagne que recoge la madera y la luz de la fotografía y distingue mejor el plano del panel respecto al fondo exterior. Pasa de RGB 34/31/28 a aproximadamente 42/39/34. Es una superficie sólida calculada con primitivos existentes; no se crea un token, degradado, sombra, radio ni estilo global.

Los tamaños renderizados se mantienen porque no se identificó un problema de lectura o jerarquía:

| Viewport | Párrafo / interlineado | CTA / alto | Titular |
|---|---|---|---|
| 390 px | 17 / 28,9 px | 14 / 44 px | 32 px |
| 768 px | 17 / 28,9 px | 14 / 44 px | 39,36 px |
| 1440 px | 17 / 28,9 px | 14 / 44 px | 52 px |

La comparación antes/después confirma geometría, tipografía, saltos de línea, separación de 16 px entre titular y descripción y solapamientos de 24/48/64 px idénticos en esos tres anchos. Sin overflow; control adicional de 1280 px sin overflow. Contraste final: párrafo 8,80:1, titular/eyebrow 10,49:1 y CTA 12,69:1. Tab desde Pure Soul alcanza el CTA con anillo de 2 px y offset de 3 px; destino conservado `/contact.html#contact-form`. Transición desde Pure Soul inspeccionada en navegador, sin cambios en la sección anterior. Consola sin errores ni warnings observados.

Se conserva `assets/images/the-clandestino.jpg` y sus derivados, sin modificar originales. Una futura fotografía real de una mesa del establecimiento preparada para una celebración privada podría comunicar mejor la ocasión; queda registrada como oportunidad fotográfica, no como sustitución automática ni bloqueo del recurso actual. No se generan imágenes ficticias.

Ejecutados: `npm run lint`, `npm run build`, `php -l includes/private-experiences.php`, `php -l home-preview.php` y `git diff --check`: PASS. Lint detectó inicialmente una separación requerida antes del comentario SCSS; se corrigió y la repetición pasó. No hay cambios de PHP, JavaScript, dependencias ni backend. El partial conserva exactamente los mismos bytes que al comenzar este pulido. Solo cambian la declaración local de fondo en `home.scss` y este registro; el trabajo local anterior se preserva.

Evidencia externa: `C:/Users/Mike/.codex/visualizations/2026/10/27/01a17bfa-36e8-7ce0-956c-d78c0f9bb620/c2-polish/`. Capturas `before-*`, `after-*`, `compare-*`, continuidad desde Pure Soul y JSON de tamaños, geometría, contraste y foco. Limitaciones: revisión en navegador integrado local, sin dispositivos físicos, otros motores ni hosting remoto; este pulido no supone aprobación visual humana ni validación del envío del formulario.

**HOME C2 FINAL POLISH — WAITING FOR VISUAL APPROVAL**

## Refinamiento previo — The Private Invitation, base aceptada

La primera implementación fue rechazada visualmente: fotografía y relato parecían independientes, y el titular quedaba demasiado separado del resto del contenido. Este apartado sustituye sus decisiones de composición. El registro inferior conserva la evidencia histórica y no supone aprobación del diseño anterior.

La fotografía y una invitación cálida forman ahora una sola composición. La invitación reúne eyebrow, titular, párrafo y CTA en un único orden de lectura, con 16 px entre titular y descripción. Su superficie `--color-superficie` cruza 24 px del borde inferior de la foto en móvil, 48 px desde md y 64 px desde lg. El panel se limita a 48rem y se desplaza hacia la derecha en desktop; en móvil/tablet conserva márgenes laterales moderados. No se emplean posiciones absolutas para el contenido, alturas fijas, sombras, glassmorphism ni marco desplazado.

Se reevaluaron el original y las alternativas `inside-clandestino.jpg`, `bg/clandestino-usa.jpg` y `clandestino-photo.jpg`. Se conserva `the-clandestino.jpg` por su luz, profundidad y preparación de la barra, sin personas identificables visibles. El foco vertical pasa del 42 % al 20 % para recuperar más contexto del local. Móvil utiliza 3:2 y md+ 2:1; la invitación se apoya sobre una franja baja del primer plano, manteniendo libre el ambiente del restaurante. No hay retoques ni nuevos derivados.

El original aporta líneas editoriales y repetición discreta. Se auditó `form-pattern.png` (16 810 B): su trama geométrica verde/negra domina y no corresponde a una invitación impresa. Los SVG `img-pattern.svg` y `footer-form-pattern.svg` también resultan excesivos para este contexto. Se reutiliza únicamente `separator.svg` (1293 B) como máscara CSS decorativa junto al eyebrow, coloreada con `--color-acento`. La superficie cálida y el borde sutil proceden de Foundation; no se simula grano ni se añade una textura externa.

Se retira la nota opcional de servicios para concentrar la invitación en la ocasión y su consulta. El copy principal, el único CTA y `/contact.html#contact-form` permanecen intactos. `cl-seccion`, figura/declaración/texto de historia, media/imagen de experiencia y botón Core mantienen sus contratos. Bootstrap aporta contenedor y breakpoints md/lg; el grid local controla la composición. No se modifica `cl-experiencia--destacada` ni ningún patrón global.

### Movimiento progresivo

Mejora exclusivamente CSS, dentro de `@supports (animation-timeline: view())` y `prefers-reduced-motion: no-preference`: la foto se asienta de escala 1,015 a 1 durante su entrada al viewport. La animación termina al completar esa entrada, sin parallax continuo. Imagen, relato y CTA mantienen opacidad 1; la invitación y el CTA no se animan ni se retrasan. Sin soporte o con reducción de movimiento, queda la composición estática.

La primera prueba detectó que `overflow: hidden` convertía el picture en referencia de scroll y anulaba el efecto. Se corrigió a `overflow: clip`. En el navegador se registró escala 1,01245 al comenzar la entrada y 1 al finalizar, con opacidad 1 y CLS 0. No se añade JavaScript, dependencia ni observador al producto.

### QA de este refinamiento

| Comprobación | Resultado ejecutado |
|---|---|
| 320/390/425/768/1024/1280/1440/2560 px | Sin overflow de documento ni del texto; CTA de al menos 44 px, con ajuste natural a dos líneas en 320 |
| Antes/después 390/768/1440 | Capturados e inspeccionados: proximidad narrativa, integración por solapamiento, profundidad, encuadre, claridad y continuidad |
| Regresión sobre secciones aprobadas | 391 elementos visibles comparados en ocho anchos: ninguna diferencia de geometría o estilos |
| CLS local 390 y 1440 | 0 antes/después de cargar la foto; figura y panel reservan la misma altura |
| Movimiento real | Escala de entrada medida; escala final 1, opacidad siempre 1; CTA sin animación |
| Reduced motion | Rama CSS forzada en anfitrión externo: animación none, transform none, contenido visible. No emulación de preferencia del SO |
| Sin soporte de timeline | Bloque supports retirado solo en QA: fotografía estática y contenido visible |
| Sin JavaScript | Scripts retirados y CSP script-src none: H2 y CTA presentes, opacidad 1 y foco Core operativo; navegación global conserva su fallback expandido |
| Teclado y destino | Tab desde Pure Soul alcanza CTA con anillo de 2 px y offset de 3 px; Enter abre Contact y su formulario existente |
| Contraste | Eyebrow/título 11,56:1; párrafo 9,70:1; botón 12,69:1 |
| HTML estructural | Anidamiento, H1 único, H2, IDs, referencias ARIA, alt/dimensiones y un CTA: PASS; no certificación Nu/W3C |
| Lint / build / PHP lint / suites Node existentes / diff --check | PASS |
| Consola de Home | Sin errores ni warnings observados |

CSS minificado frente a la implementación anterior: 74 498 → 75 897 B; gzip Node: 13 300 → 13 584 B (+284 B). Único recurso gráfico adicional solicitado: SVG existente de 1293 B. Ocho derivados y originales previos conservados, sin nuevas fuentes, scripts o instalaciones.

Evidencia externa: `C:/Users/Mike/.codex/visualizations/2026/10/27/01a17bfa-36e8-7ce0-956c-d78c0f9bb620/c2-refined/`. `before-*`, `after-*` y `compare-*` contienen las capturas; JSON de responsive, regresión, movimiento, alternativas, CLS, accesibilidad y destino registran las pruebas. Los anfitriones de QA permanecen fuera del repositorio.

Las comparativas utilizan las capturas nativas nítidas conservadas de la implementación anterior, con las mismas fuentes de C2 registradas al iniciar este refinamiento. Se presentan sin escalado ni alteración de contenido. Las nuevas tomas iniciales también se conservan como `before-live-*`; algunas captaron el repintado del navegador al cambiar de viewport.

Limitaciones: zoom nativo al 200 % no verificado en el navegador integrado; reducción de movimiento comprobada mediante activación de la rama CSS en QA, sin cambiar el SO; sin Safari/Firefox, dispositivo físico, lector auditivo ni hosting remoto. El capturador limita imágenes de viewport muy ancho; 2560 conserva el mismo tamaño de contenedor de 1440 y tiene geometría comprobada. No se enviaron formularios ni se validó entrega de correo. Fotografía y resultado continúan pendientes de aprobación visual humana.

Este refinamiento modifica únicamente el partial de C2, sus reglas locales en `home.scss` y este informe. Los cambios locales anteriores se preservan.

**HOME C2 REFINED — WAITING FOR VISUAL APPROVAL**

## Registro histórico — primera implementación, no aprobada visualmente

## Composición y recorrido

`includes/private-experiences.php` se incluye después de `includes/wines.php` en Home Preview. Conserva `id="private-events"`, H2 asociado y el concepto `The evening, held for you.`. Una fotografía amplia presenta el restaurante y una bajada editorial reúne titular, relato y una sola acción. La consulta conduce a `/contact.html#contact-form`; no reserva ni confirma disponibilidad.

La superficie neutra cálida Foundation separa C2 del fondo vino de Pure Soul. No hay marco desplazado, overlay, filtro, texto superpuesto, slider ni animación. Desktop utiliza seis columnas para la identidad y cinco para el relato con una columna de separación; tablet conserva dos columnas iguales desde md; móvil apila fotografía, identidad, relato, CTA y nota. El contenido determina la altura.

Se reutilizan `cl-seccion`, los elementos media/imagen de `cl-experiencia`, figura/bajada/texto/declaración de `cl-historia`, eyebrow, botón Core, contenedor y grid Bootstrap. No se aplica `cl-experiencia--destacada`, cuyo contrato es lateral. `home.scss` importa experiencia y contiene exclusivamente ajustes locales `cl-home-privadas*`, con tokens existentes y `media-breakpoint-up(md)`. Foundation, patrones compartidos y tokens permanecen intactos.

## Fotografía y primera revisión

La primera versión se inspeccionó a 390, 768 y 1440 px. `bg/clandestino-usa.jpg` resultó demasiado oscura y vacía para protagonizar la invitación; la figura parcial del borde derecho también distrae. `inside-clandestino.jpg` conservaba identidad, pero daba demasiado protagonismo a sillas vacías. Se descartaron ambas para esta implementación, sin alterarlas.

Se seleccionó `assets/images/the-clandestino.jpg`, 2048 × 1536: barra de madera con copas preparadas, botellas y profundidad hacia el interior. Se reconoce el establecimiento y no hay personas identificables visibles. La selección es una propuesta para revisión, no una aprobación humana ni una oferta vigente de los vinos fotografiados.

Móvil conserva 4:3 completo. Desde md se muestra 2:1, conservando la anchura y dos tercios de la altura, con foco vertical al 42 % para mantener copas, barra y contexto. No se retoca luz o color. Se generan ocho derivados independientes `private-room-{640,960,1600,2048}.{avif,webp}`, con dimensiones 4:3, AVIF calidad 62 y WebP calidad 83. Los originales conservan sus hashes de HEAD. La fuente JPEG original permanece como fallback.

`picture` declara srcset y sizes según los contenedores Bootstrap. En las muestras DPR 1 se solicitaron AVIF de 640 px en móvil (54 686 B) y 1600 px en desktop (223 415 B). Las fuentes no se amplían artificialmente. Imagen con dimensiones explícitas, lazy loading, decoding async y alt que identifica la barra, copas y estanterías reales.

La primera revisión también detectó un margen anulado al combinar figura y media en el mismo elemento. La figura narrativa y el picture de experiencia se separaron para recuperar el espaciado compartido de 32 px sin duplicar reglas. La segunda revisión y las capturas finales muestran escenario y relato integrados, titular legible de dos líneas y CTA cercano. La nota breve permite descubrir catering y experiencias de vino; no introduce condiciones comerciales inventadas.

## Verificación ejecutada

Revisión local con PHP 8.3.14 y navegador integrado Chromium: `http://127.0.0.1:8000/home-preview.php#private-events`. Para reproducir con el pipeline habitual: `npm run dev` y `http://localhost:3000/home-preview.php#private-events`.

| Comprobación | Resultado |
|---|---|
| 320, 390, 425, 768, 1024, 1280, 1440 y 2560 px | PASS: medidas, texto y CTA sin overflow; capturas guardadas |
| 390, 768 y 1440 px | PASS de revisión técnica y cualitativa local: fotografía reconocible, relato integrado, jerarquía y CTA claros |
| Transición Pure Soul → C2 → Footer | Inspeccionada: cambia de retrato lateral a escenario horizontal; neutro cálido y separación existente del Footer |
| Teclado y foco C2 | PASS: Tab desde Pure Soul alcanza el CTA; anillo de 2 px y offset 3 px; Enter abre el destino real |
| Header conservado | Drawer abre, Escape cierra y devuelve foco; sin backdrop residual después de finalizar la transición |
| Contraste sólido | PASS: título/eyebrow 12,96:1; relato/nota 10,87:1; CTA 12,69:1; foco sobre superficie 12,96:1 |
| HTML estructural | PASS: anidamiento explícito, IDs únicos, un H1, H2 de sección, referencias ARIA, dimensiones y alt; no certificación Nu/W3C |
| Recursos y destino | Home, CSS, ocho derivados, fallback y Contact HTTP 200; ancla del formulario existente; include directo HTTP 404 |
| Sin JavaScript | PASS C2 con todos los scripts retirados y CSP script-src none en anfitrión externo de QA; misma altura, contenido y enlace |
| CLS local | 0 en muestras nuevas de 390 y 1440 px, antes y después de acercarse a la foto diferida; altura reservada idéntica tras carga |
| Consola de Home | Sin errores ni warnings observados |
| npm run lint / npm run build | PASS |
| PHP lint | PASS en Home y los nueve includes |
| Suites Node existentes | PASS: probar-carrito.mjs y probar-cierre-comercio.mjs |
| git diff --check | PASS |
| Protección de secciones aprobadas | Fuentes intactas; comparación de 544 elementos en ocho anchos sin diferencias de geometría/estilo del contenido visible |
| Legacy y originales | index.html equivalente a production-baseline al ignorar CRLF; originales fotográficos sin cambios |

La comparación bruta registra 16 diferencias de posición horizontal en enlaces del drawer oculto durante los cambios de viewport; todos permanecían fuera del área visible. No hay diferencias en las propiedades restantes ni en el contenido visible. Se comprobó aparte apertura/cierre y retorno de foco del drawer.

CSS Home minificado: 71 191 → 74 498 B; gzip Node por defecto: 12 862 → 13 300 B (+438 B). Ningún cambio de JavaScript fuente, dependencia o lógica comercial.

## Evidencia y límites

Evidencia externa a Git: `C:/Users/Mike/.codex/visualizations/2026/10/27/01a17bfa-36e8-7ce0-956c-d78c0f9bb620/c2/`. `first-*` y `second-*` registran las revisiones; `final-{ancho}.png` las capturas; `transition-1440.png` ensambla dos vistas nativas según sus offsets, sin huecos, para superar el límite de altura del capturador. JSON de responsive, contraste/foco, CLS, destino, HTML y comparación antes/después en la misma carpeta. Los anfitriones/scripts de QA permanecen fuera del repositorio y no forman parte de la entrega productiva.

El capturador limita el área física de imágenes muy anchas/altas; la captura de 2560 px queda truncada, aunque la geometría del documento a ese ancho está comprobada y el contenedor mantiene el mismo tamaño de 1440 px. La vista de transición se compone de capturas nativas; no representa un viewport de 1637 px de alto.

Zoom nativo al 200 % no verificado: los atajos del navegador integrado no cambiaron el viewport; no se sustituyó por zoom CSS. Sin Safari/Firefox, dispositivos físicos, lector de pantalla auditivo ni QA de Apache/cPanel remoto. CLS es una muestra local sin throttling, no una métrica de campo. La respuesta sin JS conserva el fallback global preexistente de navegación expandida; la comprobación se limita a la sección C2.

No se enviaron formularios ni se validó entrega de correo. La activación comercial y cualquier dato de capacidad, fechas, privacidad exclusiva, formatos o disponibilidad requieren validación propia. La selección fotográfica y la composición esperan revisión visual humana.

**Registro técnico de la primera implementación; diseño rechazado visualmente.**
