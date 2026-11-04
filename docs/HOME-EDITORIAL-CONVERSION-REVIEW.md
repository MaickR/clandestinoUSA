# Home R5 — revisión editorial, storytelling y conversión

2026-11-04 · America/Bogota · **Estado vigente: implementación revisada favorablemente y cierre R5 aprobado; validaciones superadas para commit y push normal de la feature y creación manual de PR hacia develop. Sin activación comercial.**

La autorización posterior aprueba E01, E02, E04, E06 y E09; E08 se aplica tras comprobar la evidencia interna indicada en el apartado 12. E03, E05 y E07 se conservan expresamente. Los apartados 1–6 y 8–11 documentan la propuesta y comprobaciones de la fase 1; sus recomendaciones y límites históricos no sustituyen esta selección. El apartado 7 queda sincronizado con el copy implementado. El apartado 12 registra la implementación y su QA; el apartado 13 sustituye sus estados anteriores de revisión pendiente y registra el cierre autorizado.

## 1. Diagnóstico ejecutivo

La Home comunica una oferta reconocible: vinos españoles, tapas y hospitalidad en Mount Shasta, con oportunidades de celebraciones, membresías y regalos. Su secuencia editorial tiene sentido comercial: presenta el lugar, facilita explorar productos, destaca Pure Soul, invita a reunirse, muestra personas reales y ofrece acciones para visitar, consultar o descubrir. No necesita otra estructura ni una reescritura general.

La mejora más importante es **ajustar la expectativa al servicio disponible**. Header y primera escena dicen “Reserve a Table”, mientras Reservation Invitation y Visit dicen “Request a Table”. Todos conducen al mismo formulario de solicitud, sin disponibilidad ni confirmación inmediata. Gifting presenta las tarjetas como parte de una oferta definida, aunque la acción real es preguntar por ellas. Los catálogos de vinos, tapas y hampers terminan en consultas por WhatsApp; no son un checkout.

La segunda oportunidad es concretar sin alargar: el tercer Hero puede nombrar Spanish Wines con un titular más breve; Pure Soul repite “character of its own” y la idea de compartir sin aportar identificación adicional; Private Experiences puede orientar mejor qué contar al equipo. El Club necesita nombrar sus dos niveles en la introducción. Sus diferencias comerciales no pueden resolverse con adjetivos: faltan beneficios actuales confirmados. Diamond debe conservar su protagonismo.

Se recomiendan **nueve cambios editoriales**, identificados E01–E09. Se conservan todos los demás textos de la candidata, salvo que una validación comercial posterior demuestre que alguno es incorrecto. No se proponen secciones, controles, destinos nuevos, promociones ni prestaciones. No hay datos de conversión, entrevistas ni experimentos que permitan cuantificar un aumento de ventas: el impacto esperado es mayor claridad y menor ambigüedad, no una previsión de ingresos.

### Prioridad comercial

| Prioridad | Decisión | Utilidad y límite |
|---|---|---|
| P0 antes de publicación | Validar oferta enlazada, Pure Soul y recepción de solicitudes | Un copy honesto en Home no corrige precios, beneficios o condiciones históricos en las páginas de destino. Son dependencias comerciales, no nuevas tareas técnicas de R5. |
| P1 | E01: “Request a Table” en Header y Hero 1 | Hace consistente el recorrido de mayor intención inmediata con el servicio de solicitud existente. |
| P1 | E06 y E09: Gift Cards como consulta | Evita interpretar una consulta como compra, emisión o disponibilidad garantizada. |
| P1 | E02 y E03: identificación de vinos/Pure Soul | Mantiene el vino como producto protagonista y reduce texto repetitivo. |
| P1 | E04: consulta de celebraciones más concreta | Ayuda a preparar una conversación útil sin inventar capacidad ni paquetes. |
| P2 | E05: nombrar Diamond y Gold | Aclara las dos opciones; no fabrica una diferenciación de beneficios. |
| P2 | E07 y E08: hampers claros e inglés estadounidense | Sustituye lujo verbal genérico por la categoría y el contenido del regalo. |

## 2. Preparación, autoridad y método

- `git fetch origin` confirmó R4, commit `5e663251779987015340039eef855e4afdb1a56c`, integrada mediante PR #30 en `origin/develop`, merge `1ffc9178f468a051982f1180e693514c4e46b6dc`.
- Se comprobó su ascendencia con `git merge-base --is-ancestor 5e66325 origin/develop`. `develop` avanzó de `d143a1c` a `1ffc917` mediante `git merge --ff-only origin/develop`; no se integró ninguna rama adicional. Se creó exactamente `feature/home-editorial-conversion` desde esa base.
- El árbol inicial tenía tres documentos no rastreados: HOME-FINAL-AUDIT, HOME-TECHNICAL-AUDIT y HOME-VISUAL-ASSET-PLAN. Se consultaron en lectura y se preservan sin editar, añadir al índice, mover, ocultar o eliminar.
- Se leyeron AGENTS.md, las reglas PHP/JS/SCSS, estándares, Git Workflow, Visual Direction, UX/UI Guidelines, arquitectura, mapa de producto, Core Component Library, Section Pattern Library y Design System Readiness, junto al cierre transversal del Design System. El mapa de producto contiene objetivos futuros; el documento PHP y los cierres posteriores determinan lo que existe ahora.
- Se consultaron Home Header/Hero, Phase B, Discovery, C1–C8 y las auditorías locales anteriores, más los cierres R1/R2/R3/R4 pertinentes. C7 sustituye la composición histórica de C2; Discovery sustituye Welcome y Spanish Table. Los estados históricos no sustituyen cierres posteriores.
- Se inspeccionaron `home.php`, `home-preview.php`, `includes/home-document.php`, `home-head.php`, `home-public.php`, `site.php` y todos los partials activos. También se distinguieron Welcome/Spanish Table y Access de la candidata pública: los dos primeros ya no se incluyen; Access y el carrito de muestra solo pertenecen al preview.
- Se contrastó el contexto de reservas y oferta histórica con `production-baseline:index.html`, sin usar `master` como autoridad ni trasladar sus promesas al nuevo copy.

### Candidata revisada y alcance de la comprobación

Se revisó **la variante pública real**, servida localmente en `http://127.0.0.1:8016/`, con `CL_HOME_PUBLIC_REVIEW=1`, `scripts/fixtures/home-public-router.php` y `disable_functions=mail`. Respuesta 200 y `X-Robots-Tag: noindex, nofollow`. No se creó `.home-public-enabled`, ni se activó la Home en producción. No se confundió el preview con el Header público: este no muestra cuenta ni carrito.

Se recorrió y capturó la candidata en Chrome a **320×1000, 390×1000, 820×1000 y 1440×1000 CSS px**, con fuentes cargadas. Para comparar longitud se sustituyó cada cadena propuesta **solo temporalmente en memoria del navegador**, se midió su caja y se restauró el original; una recarga confirmó los originales. No se guardó copy en PHP, HTML, CSS o JS. Las comprobaciones usaron reduced motion para estabilizar la lectura; no constituyen una nueva validación de animaciones.

Se comprobaron por HTTP local los destinos internos y los fragments de contacto/reserva, además de inspeccionar las acciones de los catálogos. Un 200 o un fragment existente confirma el destino local, **no vigencia comercial, recepción del equipo, correo entregado, compra ni reserva**. No se enviaron formularios, mensajes, llamadas o pagos. No se repitieron auditorías de rendimiento, arquitectura o accesibilidad cerradas.

Para reproducir la lectura desde la raíz del repositorio, comprobar que el puerto 8016 esté libre y ejecutar en PowerShell:

```powershell
$env:CL_HOME_PUBLIC_REVIEW = '1'
php -d disable_functions=mail -S 127.0.0.1:8016 -t . scripts/fixtures/home-public-router.php
```

Abrir `/` en esa dirección y revisar los cuatro anchos indicados. No crear el marcador de publicación. El servidor temporal de R5 se detuvo al terminar la revisión.

Evidencia auxiliar fuera del repositorio: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a537-3e02-7403-8086-c82b93e60626/home-r5/`: capturas `current-{320,390,820,1440}.png`, `current-inventory.json`, `routes.json` y `proposed-fit.json`. Son mediciones editoriales, no aprobación estética del copy nuevo.

### Orden efectivo confirmado antes del análisis

| Orden | Bloque renderizado | Fuente / destino de sección |
|---|---|---|
| 1 | Header y navegación | `includes/header.php` + configuración pública de `home.php`/`site.php` |
| 2 | Hero: mesa → encuentro → vino | `includes/home-document.php` + `includes/hero.php` |
| 3 | Discovery | `includes/discovery.php` · `#spanish-table` |
| 4 | Pure Soul | `includes/wines.php` · `#spanish-wines` |
| 5 | Private Experiences | `includes/private-experiences.php` · `#private-events` |
| 6 | Guest Stories | `includes/guest-stories.php` · `#guest-stories` |
| 7 | Reservation Invitation | `includes/reservation-cta.php` · `#reservation-invitation` |
| 8 | Spanish Wine Club | `includes/wine-club.php` · `#wine-club` |
| 9 | Gifting | `includes/gifting.php` · `#gifting` |
| 10 | Visit | `includes/visit.php` · `#visit` |
| 11 | Footer | `includes/footer.php` · `#pie-global` |

El H1 visualmente oculto precede al Hero: **“Spanish Wine & Tapas in Mount Shasta · The Clandestino”**. Las tres escenas llevan H2. Los aliases históricos invisibles no son secciones editoriales adicionales. No se recomienda modificar jerarquía ni orden.

## 3. Revisión en orden del DOM

Los textos siguientes son los actuales exactos, con entidades HTML decodificadas. Las mayúsculas visuales del eyebrow dependen de CSS. “Sin texto” significa que el campo no existe; no se propone crearlo. Para cada bloque se cubren objetivo (A), recorrido (B), mensaje (C), inventario (D), fortalezas (E), problemas (F), decisión (G), razón (H), ajuste responsive (I) y operación/destino (J).

### 3.1 Header y navegación

**A–C.** Facilitar acceso inmediato a visita y categorías comerciales. Es la orientación permanente del recorrido, no otro manifiesto de marca. Actualmente ofrece exploración de experiencias, restaurante, vinos y Club, y una acción de reserva.

**D. Texto actual exacto**

| Campo | Actual |
|---|---|
| Marca | The Clandestino USA |
| Navegación principal | Home · Experiences · Restaurant · Wine Shop |
| Agrupador | Discover |
| Dentro de Discover | Wine Club · About Us · Contact |
| CTA | Reserve a Table |
| Cabecera del menú móvil | Explore The Clandestino |
| Nota del menú | Spanish hospitality in Mount Shasta |
| Teléfono del menú | +1 (408) 609-0027 |
| Eyebrow / heading / descripción editorial | Sin texto adicional |

**E–H.** Los nombres son breves y reconocibles; la nota local orienta sin sobrecarga. “Wine Shop” identifica una categoría comercial y no necesita sustituirse por un término abstracto. La inconsistencia demostrable es “Reserve” frente a “Request” en otras entradas al mismo formulario. **E01: cambiar únicamente el CTA a “Request a Table”.** No renombrar categorías ni añadir Gift Cards, Events, cuenta o carrito para anticipar módulos futuros.

**I.** 15→15 caracteres. El botón permanece en 44 px de alto en los cuatro tamaños; ancho móvil idéntico y aproximadamente +1,5 px a 820/1440. Revisar el conjunto del Header tras una implementación aprobada; no cambiar estilos para este texto.

**J.** Home/marca → `/`; Experiences → `/#private-events`; Restaurant → `/menu.html`; Wine Shop → `/wines.html`; Wine Club → `/swc.html`; About Us → `/about.html`; Contact → `/contact.html`; CTA → `/index.html?legacy=1#reservation`; teléfono → `tel:+14086090027`. Discover despliega enlaces y no completa una operación. Catálogos, información, consulta y solicitud conservan sus límites del apartado 5.

Microcopy funcional que se conserva: “Skip to main content”, “Open main navigation”, “Close main navigation”, “Main navigation” y “Contains the current page” cuando corresponda a la página activa. No se propone modificar nombres accesibles ni comportamiento.

### 3.2 Hero — escena 1, mesa

**A–C.** Convertir intención local en solicitud de mesa o exploración de vinos. Es la primera respuesta a qué es el negocio y dónde está: vino y tapas españoles en Mount Shasta, con una bienvenida cercana.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | A taste of Spain |
| Heading | Spanish Wine & Tapas in Mount Shasta |
| Descripción | A taste of Spain. A table to share. Make yourself at home. |
| CTA principal | Reserve a Table |
| CTA secundario | Explore Wines |
| Microcopy comercial adicional | Sin texto |

**E–H.** El heading es específico, local y comprensible sin esperar otras escenas. La descripción aporta hospitalidad, sin premios, superlativos ni una experiencia inventada. “A taste of Spain” se repite como firma breve; no genera una confusión que justifique reescribirla. **Aplicar E01 al CTA principal: “Request a Table”. Conservar el resto.** El visitante debe entender la acción desde la primera pantalla, sin depender de la nota de confirmación mucho más abajo.

**I.** Ambos CTA mantienen su geometría medida; no se alarga el heading ni se añade microcopy sobre la fotografía. El contenido esencial permanece en la escena inicial y no se distribuye entre slides.

**J.** Principal → `/index.html?legacy=1#reservation`, solicitud pendiente; secundario → `/wines.html`, catálogo y consulta. No hay motor de disponibilidad o pago en estas acciones.

### 3.3 Hero — escena 2, encuentro

**A–C.** Abrir la intención de celebraciones y pertenencia. Amplía la primera escena hacia compartir, encuentros privados y Club, sin sustituir su identificación básica.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | Food · Fiesta · Friends |
| Heading | Gather, Sip & Celebrate |
| Descripción | Good wine, shared plates, and the pleasure of being together. |
| CTA principal | Private Experiences |
| CTA secundario | Explore the Wine Club |
| Microcopy comercial adicional | Sin texto |

**E–H.** Relaciona producto y vida social con un titular breve. “Fiesta” funciona como guiño de marca en una página en inglés. Los CTA diferencian consultar un encuentro de explorar un club. **Conservar íntegro:** no se demuestra una mejora al sustituir este texto por promesas de exclusividad, eventos concretos o beneficios no verificados.

**I.** Sin cambios de longitud, saltos o geometría; no añadir explicaciones a una escena secundaria. Su mensaje comercial también existe más abajo, de modo que el visitante no necesita ver el slider completo.

**J.** Private Experiences → `/#private-events`, invitación a contacto; Explore the Wine Club → `/swc.html`, información histórica pendiente de validar, sin alta transaccional nueva.

### 3.4 Hero — escena 3, vino

**A–C.** Generar descubrimiento de vino español con Pure Soul como entrada propia de la marca. Actualmente presenta el producto junto a una “Wine Selection” poco específica.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | Wines with character |
| Heading | Discover Pure Soul & Our Wine Selection |
| Descripción | Explore Spanish wines with character, from the first glass to the last. |
| CTA principal | Explore Wines |
| CTA secundario | Discover Pure Soul |
| Microcopy comercial adicional | Sin texto |

**E–H.** Pure Soul tiene nombre propio y un acceso a su relato; ambos CTA tienen destinos distintos y útiles. El heading reúne dos órdenes genéricas (“Discover”, “Our Wine Selection”), aunque los botones ya explican la acción. **E02: “Pure Soul & Spanish Wines”.** Identifica producto y categoría, reduce 14 caracteres y conserva el tono. No es una táctica de repetir keywords: sustituye una categoría imprecisa por la oferta existente. Descripción, eyebrow y acciones se conservan.

**I.** 39→25 caracteres; de tres a dos líneas en los cuatro anchos medidos. Reduce la altura del titular unos 40/40/51/67 px a 320/390/820/1440. La escena puede redistribuir su espacio editorial: requiere revisión visual humana del equilibrio con la foto; no cambiar alturas, tipografía ni espaciado para compensar.

**J.** Explore Wines → `/wines.html`; Discover Pure Soul → `/#spanish-wines`. Este segundo botón descubre una sección, no compra una botella ni abre una ficha transaccional.

Microcopy del Hero conservado: “Pause automatic slides”, “Resume automatic slides”, “Automatic slides disabled by reduced motion”, “Choose a photograph”, “Go to slide 1 of 3”, “Go to slide 2 of 3”, “Go to slide 3 of 3”, “Selecting a scene stops automatic rotation.” y “This scene could not load. Please try again.” La posición manual anuncia “Slide N of 3. ” seguida del heading de la escena; usaría el nuevo heading de E02 si se aprueba. No se modifica su lógica.

### 3.5 Discovery

**A–C.** Distribuir al visitante entre vinos, tapas/Take Away y hampers. Tras la bienvenida, convierte curiosidad en tres rutas concretas; es el primer catálogo editorial, no una tienda integrada.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | Welcome to The Clandestino |
| Heading | A little Spain. A world to discover. |
| Descripción | Spanish wines, authentic tapas, and thoughtful gifts. Discover the flavors and experiences waiting for you in Mount Shasta. |
| Vinos: heading | Spanish Wines |
| Vinos: descripción | Discover wines with character, chosen for sharing. |
| Vinos: CTA | Explore Wines |
| Tapas: heading | Spanish Tapas & Take Away |
| Tapas: descripción | Small plates to share. Ask us about Take Away. |
| Tapas: CTA | Explore Tapas |
| Hampers: heading | Gourmet Hampers |
| Hampers: descripción | A thoughtful selection for someone special. |
| Hampers: CTA | Discover Hampers |
| Microcopy adicional | Sin texto |

**E–H.** Las categorías se reconocen sin leer prosa larga. El heading aporta amplitud y el párrafo concreta oferta/localidad. Take Away se expresa correctamente como consulta. **Conservar todo.** “Chosen for sharing” o “someone special” son expresiones generales, pero aquí acompañan una categoría y una acción precisas; sustituirlas no resuelve una fricción demostrada. No convertir Explore Tapas en Order Takeout ni añadir opciones de recogida no implementadas. “Take Away” se mantiene como nombre del servicio del proyecto; no es necesario renombrarlo por “takeout” para escribir el resto en inglés estadounidense.

**I.** Sin cambios: se conserva la densidad de pies y botones, especialmente en 320/390. No añadir descripciones de producto a estos teasers ni insertar un cuarto destino.

**J.** Explore Wines → `/wines.html`; Explore Tapas → `/tapas.html`; Discover Hampers → `/hampers.html`. Son catálogos explorables con consultas posteriores por WhatsApp, sujetos a confirmar oferta/canal. La mención Take Away no asegura ventanas de recogida, cocina notificada, delivery o pedido aceptado.

### 3.6 Pure Soul

**A–C.** Dar identidad al vino protagonista y conducir al catálogo. Tras Discovery, aporta un nombre propio que diferencia al negocio de un restaurante genérico. Actualmente relaciona Pure Soul con raíces españolas, carácter y momentos compartidos.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | Our Flagship Wine |
| Heading | Pure Soul |
| Firma | NTC & Sons |
| Declaración, línea 1 | Spanish roots. |
| Declaración, línea 2 | A soul of its own. |
| Descripción | Discover Pure Soul, a Spanish red with a character of its own. Made for slow evenings and shared plates, it opens the door to our wider selection of Spanish wines. |
| CTA | Explore the Wine Shop |
| Microcopy adicional | Sin texto |

**E–H.** El nombre, firma y declaración son memorables y ya sostienen el relato sensorial. El párrafo repite “of its own” y “shared plates”, usados en otros lugares, y tarda en enlazar producto y marca. **E03: “Meet Pure Soul, a Spanish red by NTC & Sons. A starting point for discovering our wider selection of Spanish wines.”** Aporta una relación explícita entre entidades usando datos ya presentes; no atribuye una bodega, elaboración propia o exclusividad. Conservar nombre, firma, declaración y CTA. La descripción no debe convertirse en una ficha técnica sin datos validados.

**I.** 163→115 caracteres. Líneas 5→3 / 4→3 / 4→3 / 3→2 en los cuatro tamaños. Menor altura del relato puede cambiar su equilibrio frente al cartel, aunque no la retícula; revisión visual posterior sin compensar con espaciados.

**J.** Explore the Wine Shop → `/wines.html`, catálogo que incluye Pure Soul y acciones de consulta por WhatsApp. No conduce a compra directa. La imagen promocional conserva texto incrustado y afirmaciones que R5 no puede corregir con un párrafo. Mantener pendiente la validación comercial del nombre, marca, origen y material vigente, según H03/R3; no inferir añada, variedad, precio, exclusividad, producción propia ni stock a partir de ese arte.

### 3.7 Private Experiences

**A–C.** Captar consultas de celebraciones y encuentros privados. Después del vino, presenta una ocasión para reunir personas; la siguiente etapa es una conversación con el equipo. El mensaje actual invita a imaginar una velada, sin un paquete definido.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | Private Experiences |
| Heading | The evening, held for you. |
| Descripción | Some moments deserve more than an ordinary night out. From intimate celebrations to gatherings around Spanish wines and shared plates, tell us what you have in mind. We'll help you explore the possibilities. |
| CTA | Plan Your Private Gathering |
| Microcopy adicional | Sin texto |

**E–H.** El CTA es contextual y la frase final deja claro que se exploran posibilidades. “More than an ordinary night out” es intercambiable con cualquier local y no ayuda a preparar la consulta. **E04: “Bring your celebration to The Clandestino. Tell us about your occasion, group, and plans for an evening of Spanish wines and shared plates. We'll explore the possibilities with you.”** Orienta a ocasión, grupo y planes, sin prometer sala, aforo, alquiler completo, menú o disponibilidad. Conservar heading y CTA. “Held for you” funciona como invitación editorial en este contexto de consulta; no debe reforzarse con “exclusively yours” o una afirmación de espacio reservado.

**I.** 207→181 caracteres. Líneas 8→6 / 6→5 / 5→4 / 4→4. Favorece lectura en móvil; revisar relación del bloque superpuesto con la foto, sin variar su protección tonal ni altura mínima.

**J.** Plan Your Private Gathering → `/contact.html#contact-form`, formulario general existente con categoría `Private Event`. No hay preselección automática ni transmisión del contexto de la Home. El usuario deberá escoger la categoría y escribir su consulta. Es consulta → conversación → propuesta eventual; el clic no reserva un espacio. La recepción real sigue pendiente de prueba operativa R1.

### 3.8 Guest Stories

**A–C.** Generar confianza mediante presencia humana y ambiente real, no mediante valoraciones inventadas. Entre invitación privada y solicitud de mesa, reduce la distancia emocional con el lugar. El relato actual habla de comida, vino y pertenencia.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | Guest Stories |
| Heading | More than wine. Memories. |
| Párrafo 1 | Some come for the wine. Others for the food. What brings us together is everything in between. |
| Párrafo 2 | Meet the people and shared moments that make The Clandestino feel like home. |
| Vídeo 1 / duración | A glass of red · 0:51 |
| Vídeo 2 / duración | Tapas & company · 1:31 |
| Vídeo 3 / duración | By the window · 1:18 |
| Vídeo 4 / duración | A sip of tradition · 0:06 |
| CTA comercial | Sin CTA |

Descripciones accesibles actuales, conservadas literalmente:

1. “A seated guest holds a glass of red wine at a table inside The Clandestino.”
2. “The camera moves from cheese and cured meats to two guests at the bar, with wine bottles in front of them.”
3. “The camera moves from a wine bottle to a seated guest by the window; another guest is visible nearby.”
4. “A guest drinks from a leather wineskin beside a board of tapas, then lowers it as the camera returns to the food.”

Microcopy conservado: “Previous guest story”, “Next guest story”, “The stories behind the table”, “Guest films”, “Scroll horizontally to explore all four films. With the collection focused, use Left and Right, Home or End. Playback starts only when you choose Play.”; sin JS: “Scroll to explore all four stories. Pause the current film before starting another.” Fallback: “Your browser does not support HTML5 video.” La posición es dinámica, por ejemplo “1–2 of 4 in view”, no una cantidad fija de vídeos visibles.

**E–H.** Los títulos identifican escenas sin fingir declaraciones. La prosa es voz de marca, no una cita de clientes. **Conservar íntegro**, incluidos los cuatro títulos neutrales y duraciones. No añadir nombres, estrellas, comillas, puntuación, “verified reviews”, citas de recomendación ni títulos como “The best wine in Mount Shasta”. El bloque puede aportar familiaridad; no prueba satisfacción, representatividad o recomendación verbal.

Se consultó en esta fase el [PR #23](https://github.com/MaickR/clandestinoUSA/pull/23): registra la confirmación del responsable de permisos de uso y reproducción correcta de audio. **No se reabren esos permisos ni se declara que el audio falta.** Esa confirmación no aporta una transcripción o una verificación semántica completa de lo dicho. Esta revisión no escuchó ni transcribió los clips; por ello no atribuye opiniones. Los pendientes de subtítulos y alternativas accesibles de R3 permanecen, sin volver a auditarlos ni alterar multimedia.

**I.** Sin cambios: conserva el relato de dos párrafos, pies y duración. Los títulos ya envuelven en algunos tamaños estrechos; no ampliarlos con mensajes comerciales. Mantener el carrusel como pausa narrativa, sin añadir botones de reserva a las tarjetas.

**J.** Las acciones son reproducción manual y navegación entre cuatro archivos locales; no existe una compra, reseña externa o consulta asociada. El siguiente CTA comercial ya aparece en Reservation Invitation. No añadir uno por obligación.

### 3.9 Reservation Invitation

**A–C.** Recuperar la intención de visita tras la prueba de ambiente. Es el puente directo entre emoción y solicitud de mesa, antes de seguir hacia Club y regalos.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | Your next Clandestino moment |
| Heading | A table worth gathering around. |
| Descripción | Spanish wines, tapas to share, and moments worth celebrating. Your next evening starts at The Clandestino. |
| CTA | Request a Table |
| Microcopy | Table requests are subject to confirmation. |

**E–H.** Texto cálido, acción precisa y expectativa explícita. Aunque retoma vinos, tapas y encuentro, aquí la repetición sirve a una decisión concreta después de una secuencia extensa. **Conservar íntegro**, coherente con el copy aprobado de C8. No sustituir la nota por “Your table is waiting” ni añadir urgencia, disponibilidad o garantías. E01 corrige las otras entradas a este recorrido; no requiere reescribir esta sección.

**I.** Sin cambios de longitud ni geometría en 320/390/820/1440. Mantener CTA y nota juntos. No ampliar la descripción para explicar el motor futuro.

**J.** Request a Table → `/index.html?legacy=1#reservation`. Formulario legacy/R1 de solicitud, no calendario con disponibilidad autoritativa ni confirmación instantánea. Recepción por el equipo y confirmación posterior son pasos distintos del clic y de la aceptación por el transporte de correo.

### 3.10 Spanish Wine Club

**A–C.** Abrir una relación continuada con el vino español y llevar a informarse sobre membresías. Después de resolver la visita inmediata, propone pertenencia. El bloque actual presenta dos opciones sin nombrarlas en el párrafo general y describe los niveles con frases prudentes pero genéricas.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | The Spanish Wine Club |
| Heading | Discover more of Spain, one wine at a time. |
| Descripción | Two ways to explore Spanish wine, thoughtfully brought together by The Clandestino. |
| Diamond: eyebrow | The signature tier |
| Diamond: heading | Diamond Membership |
| Diamond: descripción | Explore our signature Wine Club tier and discover what makes it special. |
| Diamond: CTA | Explore Diamond |
| Gold: eyebrow | Sin texto |
| Gold: heading | Gold Membership |
| Gold: descripción | Discover the Gold membership and find your place in the club. |
| Gold: CTA | Explore Gold |
| Microcopy adicional | Sin texto |

**E–H.** Heading y protagonismo Diamond sostienen una invitación propia; las acciones “Explore” no simulan alta o pago. **E05, solo descripción general: “Explore Diamond and Gold, the two membership tiers of our Spanish Wine Club.”** Identifica inmediatamente las opciones y mantiene Diamond primero. Conservar el resto, incluidas las dos descripciones de nivel: reemplazarlas por otras frases genéricas no mejora la decisión. Se reconoce expresamente su limitación comercial; una diferenciación persuasiva necesita beneficios confirmados, no más adjetivos.

No presentar “signature tier” como sinónimo de más vendido. No importar “Most Popular”, precios, cuatro botellas, periodicidad, envíos, eventos exclusivos o prioridad de reservas desde SWC sin aprobación comercial actual. No inventar una ventaja de Gold ni degradarlo con “basic”, “entry-level” o “budget”.

**I.** Introducción 83→76 caracteres; 3→3 líneas a 320 y 2→2 a 390/820/1440. Los nombres y bloques Diamond/Gold no cambian; se conserva la composición Diamond First aprobada, incluida tablet 7/5 y fotografía inferior.

**J.** Explore Diamond y Explore Gold → **el mismo `/swc.html`**, sin selector ni preselección del nivel. También allí “Join” abre WhatsApp, no una suscripción pagada. La ruta responde, pero conserva precios, cantidades, beneficios y mensajes históricos que deben validarse antes de publicar la Home. No se proponen fragments nuevos ni se cambia a Contact sin una decisión comercial autorizada. E05 no resuelve la vigencia del destino.

### 3.11 Gifting

**A–C.** Captar intención de regalo mediante hampers y consulta de Gift Cards. Es una segunda ocasión de compra, independiente de comer en el local; actualmente combina selección cuidada y lenguaje aspiracional.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow general | Gifts & Gourmet Hampers |
| Heading general | A taste of Spain, ready to give. |
| Descripción general | Thoughtfully curated hampers and gift cards for celebrations, thank-yous, and meaningful moments. |
| Pie de fotografía | Selected with care. Given with love. |
| Hampers: eyebrow | The Gifting Atelier |
| Hampers: heading | The art of giving well. |
| Hampers: descripción | Carefully curated gourmet hampers, bringing Spanish flavours together for the people and moments that matter. |
| Hampers: CTA | Explore Hampers |
| Gift Cards: heading | A Clandestino moment, their way. |
| Gift Cards: descripción | Thinking of a Gift Card? Let’s explore a thoughtful way to give The Clandestino. |
| Gift Cards: CTA | Ask About Gift Cards |
| Microcopy adicional | Sin texto |

**E–H.** Los usos de regalo son reconocibles y los CTA distinguen catálogo de consulta. Los headings breves y sus énfasis tipográficos ya funcionan. Hay cuatro mejoras concretas:

- **E06, descripción general:** “Explore gourmet hampers for celebrations and thank-yous, or ask us about gift cards.” Diferencia la exploración del producto de la consulta sobre tarjetas desde el inicio del bloque.
- **E07, eyebrow hampers:** “Gourmet Hampers”. “Atelier” no identifica la oferta ni acredita un taller o servicio especial; la categoría permite comprender el subbloque sin depender del contexto.
- **E08, descripción hampers:** “Spanish wines and gourmet specialties, brought together in hampers for the people and occasions that matter.” Explicita el contenido general mostrado, evita repetir curated y usa inglés estadounidense. No define una composición garantizada para cada cesta.
- **E09, descripción Gift Cards:** “Ask our team about gift card options for someone you’d like to treat.” Sustituye una invitación vaga por la conversación real con el equipo, sin prometer monto, entrega o emisión.

Conservar ambos headings, eyebrow general, pie de fotografía y CTA. “Ready to give” se mantiene como expresión editorial del regalo; no debe acompañarse de entrega inmediata o stock garantizado. Si el negocio no ofrece actualmente alguna categoría, la solución requerirá revisar la oferta, no añadir disclaimers técnicos a la Home.

**I.** E06 97→84 caracteres, E07 19→15, E08 109→108, E09 80→69. Ningún bloque crece en las medidas realizadas; E06 pasa de tres a dos líneas a 390. La banda Gift Cards conserva dos líneas de descripción en 320/390/820 y una en 1440. Se mantienen los énfasis existentes en “ready to give.”, “giving well.” y “their way.”; no trasladarlos a frases nuevas ni tocar estilos.

**J.** Explore Hampers → `/hampers.html`, catálogo con consultas por WhatsApp y oferta pendiente de confirmar. Ask About Gift Cards → `/contact.html#contact-form`, contacto general, sin categoría/preselección específica de tarjeta ni emisión, saldo, checkout o entrega digital conectados. El diseño de una Gift Card no demuestra que exista un servicio de compra operativo. El usuario debe explicar su interés en el mensaje.

### 3.12 Visit

**A–C.** Resolver la última decisión práctica: dónde ir, cuándo y cómo solicitar mesa o preguntar. Es el cierre de intención local y da una salida clara también a quien no quiere explorar más productos.

| D. Campo | Actual exacto |
|---|---|
| Eyebrow | Visit The Clandestino |
| Heading | Your next Spanish evening starts here. |
| Descripción | Spanish wines, shared plates, and the pleasure of good company. Find us in Mount Shasta. |
| Dirección, línea 1 | 211 N Mt Shasta Blvd |
| Dirección, línea 2 | Mount Shasta, CA 96067 |
| Horario, línea 1 | Tuesday–Sunday |
| Horario, línea 2 | 4:00 PM – 8:00 PM |
| CTA principal | Request a Table |
| CTA secundario | Get Directions |
| Microcopy | Table requests are subject to confirmation. |
| Enlace telefónico | Call Us +1 (408) 609-0027 |
| Ayuda accesible de Maps | (opens Google Maps in a new tab) |

**E–H.** Dirección, horas, mapa, teléfono y solicitud responden a decisiones reales. La última reiteración de hospitalidad acompaña información útil y no necesita un nuevo eslogan. **Conservar íntegro.** El horario procede de configuración compartida y de la confirmación del propietario registrada en R3, no de los ejemplos del Style Guide. No añadir “open now”, parking, walk-ins, terraza, accesibilidad física o tiempo de viaje sin evidencia. No eliminar el teléfono por duplicarse en Footer: aquí permite actuar en contexto.

**I.** Sin cambios. Conservar las dos líneas de dirección/horario y su comportamiento natural. No añadir “Pacific Time” al bloque visible por iniciativa de R5; los horarios son civiles del local, `America/Los_Angeles`, y no se convierten a la zona del visitante.

**J.** Request a Table → `/index.html?legacy=1#reservation`; Get Directions → Google Maps para `211 N Mt Shasta Blvd, Mt Shasta, CA 96067, USA`, nueva pestaña; Call Us → `tel:+14086090027`. Destinos cotejados con la configuración; no se hizo una llamada ni se verificó atención en vivo. El mapa no es una reserva.

### 3.13 Footer

**A–C.** Ofrecer orientación secundaria, datos locales y acceso a información legal. Cierra la marca y permite recuperar una ruta sin subir toda la Home. Actualmente resume hospitalidad y agrupa enlaces con claridad.

| D. Campo | Actual exacto |
|---|---|
| Descripción de marca | A little Spain in Mount Shasta. Tapas to share, wines to discover, and time for good company. |
| Encabezado de navegación | Explore |
| Enlaces Explore | Home · Experiences · Restaurant · Wine Shop |
| Encabezado secundario | Discover more |
| Enlaces Discover more | Wine Club · About Us · Contact · Private Experiences |
| Encabezado de contacto | Visit & contact |
| Dirección, línea 1 | 211 N Mt Shasta Blvd |
| Dirección, línea 2 | Mount Shasta, CA 96067 |
| Enlace de mapa | Find us on Google Maps |
| Ayuda accesible del mapa | (opens a new tab) |
| Teléfono | +1 (408) 609-0027 |
| Horario, línea 1 | Tuesday–Sunday |
| Horario, línea 2 | 4:00 PM – 8:00 PM |
| Enlaces legales | Policies · Reservation terms |
| Copyright renderizado en esta revisión | © 2026 The Clandestino USA |
| Eyebrow / heading / CTA comercial independiente | Sin texto adicional |

**E–H.** El párrafo es breve y coherente; los rótulos son útiles. La repetición de ubicación/contacto refuerza orientación y consistencia de datos; no es keyword stuffing. **Conservar íntegro.** No introducir newsletter, redes, correo, sellos de pago, ratings o links de servicios futuros para completar espacios. Email y perfiles sociales no confirmados están omitidos deliberadamente; no trasladarlos del legacy automáticamente.

**I.** Sin cambios, especialmente en las columnas tablet y desktop y en la pila móvil. Conservar el año dinámico existente, no fijarlo a 2026 como parte del copy nuevo.

**J.** Explore comparte las rutas públicas del Header. Wine Club → `/swc.html`; About Us → `/about.html`; Contact → `/contact.html`; Private Experiences → `/#private-events`; Maps/teléfono son los mismos de Visit; Policies → `/policies.html`; Reservation terms → `/terms.html`. Los destinos legales responden localmente; R5 no certifica vigencia jurídica ni reescribe documentos legales.

## 4. Tabla de cambios: ACTUAL → RECOMENDADO → JUSTIFICACIÓN — propuesta inicial

Una sola propuesta por cambio. E01 se aplica en dos ubicaciones del mismo recorrido. Las cadenas no enumeradas se conservan como aparecen en el apartado 3.

| ID / prioridad / ubicación | ACTUAL | RECOMENDADO | JUSTIFICACIÓN |
|---|---|---|---|
| E01 · P1 · Header y Hero 1, CTA principal | Reserve a Table | **Request a Table** | Mismo servicio y destino que C8/Visit: solicitud sujeta a confirmación. Unifica expectativa sin añadir texto. |
| E02 · P1 · Hero 3, heading | Discover Pure Soul & Our Wine Selection | **Pure Soul & Spanish Wines** | Nombra producto y categoría; elimina una orden redundante y reduce longitud. |
| E03 · P1 · Pure Soul, descripción | Discover Pure Soul, a Spanish red with a character of its own. Made for slow evenings and shared plates, it opens the door to our wider selection of Spanish wines. | **Meet Pure Soul, a Spanish red by NTC & Sons. A starting point for discovering our wider selection of Spanish wines.** | Relaciona vino/marca sin repetir la declaración “of its own”; conserva conexión al catálogo. Datos sujetos a validación comercial ya existente. |
| E04 · P1 · Private Experiences, descripción | Some moments deserve more than an ordinary night out. From intimate celebrations to gatherings around Spanish wines and shared plates, tell us what you have in mind. We'll help you explore the possibilities. | **Bring your celebration to The Clandestino. Tell us about your occasion, group, and plans for an evening of Spanish wines and shared plates. We'll explore the possibilities with you.** | Sustituye un cliché por orientación útil para la consulta y mantiene el resultado exploratorio. |
| E05 · P2 · Wine Club, descripción general | Two ways to explore Spanish wine, thoughtfully brought together by The Clandestino. | **Explore Diamond and Gold, the two membership tiers of our Spanish Wine Club.** | Identifica las dos opciones sin fabricar beneficios. Diamond se nombra primero. |
| E06 · P1 · Gifting, descripción general | Thoughtfully curated hampers and gift cards for celebrations, thank-yous, and meaningful moments. | **Explore gourmet hampers for celebrations and thank-yous, or ask us about gift cards.** | Distingue catálogo de consulta desde la entrada del bloque. |
| E07 · P2 · Hampers, eyebrow | The Gifting Atelier | **Gourmet Hampers** | Categoría clara; evita una denominación de lujo que no explica un servicio verificable. |
| E08 · P2 · Hampers, descripción | Carefully curated gourmet hampers, bringing Spanish flavours together for the people and moments that matter. | **Spanish wines and gourmet specialties, brought together in hampers for the people and occasions that matter.** | Concreta contenido general del regalo, reduce repetición y usa inglés estadounidense. No garantiza composición individual. |
| E09 · P1 · Gift Cards, descripción | Thinking of a Gift Card? Let’s explore a thoughtful way to give The Clandestino. | **Ask our team about gift card options for someone you’d like to treat.** | Explica el paso real sin prometer compra, emisión ni formato. |

### Impacto sobre longitud y saltos

Caracteres incluyen espacios/puntuación. Líneas medidas con el mismo CSS y fuentes de la candidata, cambiando una cadena cada vez solo en memoria y restaurándola. Son comprobaciones de ajuste, no garantía de equivalencia visual completa al aplicar todo junto.

| Cambio | Caracteres actual→propuesto | 320 px, líneas | 390 px, líneas | 820 px, líneas | 1440 px, líneas |
|---|---|---|---|---|---|
| E01 | 15→15 | Botón 44→44 px | Botón 44→44 px | Botón 44→44 px | Botón 44→44 px |
| E02 | 39→25 | 3→2 | 3→2 | 3→2 | 3→2 |
| E03 | 163→115 | 5→3 | 4→3 | 4→3 | 3→2 |
| E04 | 207→181 | 8→6 | 6→5 | 5→4 | 4→4 |
| E05 | 83→76 | 3→3 | 2→2 | 2→2 | 2→2 |
| E06 | 97→84 | 3→3 | 3→2 | 2→2 | 2→2 |
| E07 | 19→15 | 1→1 | 1→1 | 1→1 | 1→1 |
| E08 | 109→108 | 3→3 | 3→3 | 3→3 | 3→3 |
| E09 | 80→69 | 2→2 | 2→2 | 2→2 | 1→1 |

No se propone ningún salto manual nuevo. La declaración de Pure Soul conserva sus dos líneas deliberadas. La reducción de altura de E02/E03/E04 puede desplazar acciones o variar espacio libre dentro de la composición existente. Si el resultado conjunto necesita una compensación visual, debe revisarse el copy con el responsable antes de tocar CSS; R5 no autoriza esa modificación.

## 5. Matriz de CTA y estado real de operación

| CTA / enlaces de Home | Destino efectivo de la candidata pública | Estado verificado y límite |
|---|---|---|
| Reserve a Table, recomendado Request a Table; Request a Table de C8/Visit | `/index.html?legacy=1#reservation` | 200 local y `#reservation` existente. Formulario R1 → `reservation.php`; solicitud, sin disponibilidad ni reserva confirmada. No se realizó POST ni se acreditó recepción real. |
| Explore Wines; Explore the Wine Shop; Wine Shop | `/wines.html` | 200 local; catálogo legacy, Pure Soul incluido. Acciones construidas por `assets/js/wines.js` abren consulta de compra por WhatsApp y piden confirmar disponibilidad y siguientes pasos. Sin checkout nuevo. |
| Discover Pure Soul | `/#spanish-wines` | Sección presente en el DOM público; información de marca, después acceso a Wines. Sin ficha/compra directa. |
| Explore Tapas | `/tapas.html` | 200 local; `assets/js/tapas.js` genera consultas de pedido por WhatsApp solicitando disponibilidad y detalles. No hay pedido aceptado ni recogida confirmada. |
| Restaurant | `/menu.html` | 200 local; menú legacy. No se acredita carrito, order ahead o pago real por enlazarlo. |
| Experiences; Private Experiences | `/#private-events` | Sección real, no landing ni evento reservable. |
| Plan Your Private Gathering | `/contact.html#contact-form` | 200 y fragment existente; POST de contacto a `contact.php`, categoría `Private Event` seleccionada por el usuario. Sin contexto precargado, aforo, propuesta o fecha retenida. |
| Explore the Wine Club; Explore Diamond; Explore Gold; Wine Club | `/swc.html` | 200 local. Los dos niveles llevan a la misma página; “Join Diamond/Gold” enlaza a WhatsApp. Precio/cadencia/beneficios históricos pendientes de confirmar. Sin alta, suscripción o cobro nuevo. |
| Discover Hampers; Explore Hampers | `/hampers.html` | 200 local; `assets/js/hampers.js` genera consultas por WhatsApp, algunas con precio precargado. La oferta y esos importes requieren validación; no es carrito ni compra aceptada. |
| Ask About Gift Cards | `/contact.html#contact-form` | Consulta general; sin Gift Card emitida, saldo, entrega, pago ni preselección específica. |
| Contact | `/contact.html` | Página/formulario existentes; 200 local no equivale a mensaje entregado o canal atendido. |
| Get Directions; Find us on Google Maps | `https://www.google.com/maps/place/211+N+Mt+Shasta+Blvd,+Mt+Shasta,+CA+96067,+USA` | Enlace a ubicación configurada, nueva pestaña. No implica mesa o servicio disponible. |
| Call Us; teléfono de Header/Footer | `tel:+14086090027` | Enlace de llamada coherente con número mostrado. No se llamó ni se verificó atención. |
| Home / logos; About Us; Policies; Reservation terms | `/`; `/about.html`; `/policies.html`; `/terms.html` | Destinos informativos presentes/200 en ensayo local. Sin operación comercial nueva ni validación legal. |
| Play/controles de Guest Stories | Cuatro MP4 locales y carrusel existente | Reproducción/navegación manual; sin reseña atribuida ni acción comercial. |

Se preserva `?legacy=1` en reservas: no es un parámetro promocional; forma parte del destino R3 para evitar redirects antiguos en caché. No sustituirlo por `/#reservation`, que en la nueva Home identifica un alias previo a la invitación, no el formulario legacy. Las diferencias de anchors de `home-preview.php` son de laboratorio y no deben guiar la propuesta pública.

## 6. Continuidad narrativa, conversión y SEO editorial

### Recorrido completo

La secuencia funciona como **lugar y bienvenida → opciones → vino propio de la identidad → ocasión de encuentro → personas → solicitar mesa → pertenencia → regalar → visitar**. Los accesos de Header/Hero y Discovery permiten actuar antes de terminar el relato. No es necesario obligar a pasar por Pure Soul, los vídeos o Wine Club para encontrar una acción comercial.

La primera escena responde a la oferta y la ubicación sin depender de autoplay. Discovery cubre tres intenciones de producto. Pure Soul aporta especificidad; Private orienta la ocasión; Guest Stories muestra ambiente sin forzar una venta. C8 convierte esa disposición en una solicitud clara. El tramo final separa continuidad del Club, regalo y logística local. La repetición de vinos/tapas/compartir es coherente con la marca; solo se reduce donde puede sustituirse por información más útil.

Las acciones no deben uniformarse todas como “Discover More”. “Explore” indica información/catálogo; “Ask” o “Plan” abre consulta; “Request” solicita mesa; “Get Directions” y “Call” resuelven visita. Mantener esa diferencia ayuda a elegir. Tampoco conviene que todos los CTA lleven a contacto: los catálogos son útiles y sus rutas existen, aunque su oferta requiera validación.

En móvil se conserva una idea por bloque y la acción junto a su contexto. Los nueve cambios no amplían párrafos ni añaden explicaciones del sistema futuro. El Club tiene un límite real: sin diferencias comerciales confirmadas, no puede convencer por comparación de valor. Se conserva como invitación a explorar; no se presenta este documento como una solución de ese vacío de negocio.

### Intención de búsqueda y relevancia local

| Intención a atender | Contenido que ya responde | Recomendación editorial |
|---|---|---|
| Vino español y tapas en Mount Shasta | H1, primer Hero, Discovery, Visit, title/description R3 | Conservar especificidad local; no repetir el nombre de la ciudad en cada heading. |
| Descubrir vinos españoles / Pure Soul | Hero 3, Pure Soul, enlaces a Wines | E02 precisa la categoría; E03 relaciona producto y marca. El catálogo sigue siendo el destino de exploración. |
| Tapas / Take Away | Discovery y `/tapas.html` | Mantener oferta como exploración/consulta. No introducir “order online”, delivery o pickup garantizado. |
| Celebraciones / experiencias privadas | Private Experiences y Contact | E04 ayuda a describir la ocasión. No prometer bodas, catering, buyout o capacidad sin confirmación. |
| Spanish Wine Club | Heading de sección, Diamond/Gold y SWC | E05 nombra planes. La intención comparativa requiere términos actuales en el destino, no keywords añadidas en Home. |
| Regalos gourmet / Gift Cards | Discovery, Gifting, Hampers, Contact | E06–E09 distinguen tipos de acción y hacen explícita la categoría del regalo. |
| Dirección, horario y contacto | Visit/Footer, datos compartidos y Restaurant R3 | Conservar consistencia. Confirmar cambios operativos en una sola fuente, no reescribir horas para SEO. |

Estas son hipótesis de intención derivadas de la oferta, **no volúmenes o consultas observados en Search Console**. Mount Shasta se comunica con claridad. Siskiyou County y visitantes de California, Oregon y Washington definen la audiencia, pero no prueban servicio en esas zonas. No introducir listas geográficas, distancias, “near me” ni envíos a esos estados. Tampoco añadir “Siskiyou County” a un bloque que no necesita esa explicación; el contexto local ya se expresa mediante localidad y dirección.

Los headings editoriales pueden ser evocadores cuando eyebrow, descripción y enlace identifican lo que ofrecen. No hace falta convertir “More than wine. Memories.” o “The art of giving well.” en frases de buscador. E07 precisa una categoría donde “Atelier” no aportaba información; no reemplaza toda la voz de marca por términos de catálogo.

Se conservan literalmente los metadatos editoriales públicos de R3:

- **Title:** `Spanish Tapas & Wine in Mount Shasta | The Clandestino USA`
- **Description:** `Discover Spanish tapas and wines at The Clandestino USA in Mount Shasta. Explore our wines, plan an evening with friends, or request a table.`
- **H1:** `Spanish Wine & Tapas in Mount Shasta · The Clandestino`

No se modifica canonical, schema, robots, sitemap, Open Graph, H1 o jerarquía. La relación explícita entre nombre, oferta, localidad y enlaces ayuda a interpretar el negocio tanto a personas como a sistemas de búsqueda; no garantiza inclusión o posicionamiento. La recomendación prioriza contenido útil y verificable conforme a [Google Search Central: contenido para personas](https://developers.google.com/search/docs/fundamentals/creating-helpful-content). Para sus funciones de IA, Google mantiene las prácticas SEO habituales y no exige archivos o schema especiales; no se justifica añadir infraestructura en R5. [Google Search Central: funciones de IA](https://developers.google.com/search/docs/appearance/ai-features).

## 7. Copy final en inglés — selección aprobada e implementada

Este conjunto incorpora E01, E02, E04, E06, E08 y E09; conserva el texto original de E03, E05 y E07 y las demás cadenas visibles. **Implementado y revisado favorablemente; autorizado el cierre de la feature, sin autorización de publicación comercial.** Los campos de contacto y horario siguen siendo datos compartidos. El inventario funcional/accesible del apartado 3 se conserva.

### Header

| Campo | Copy final |
|---|---|
| Navigation | Home · Experiences · Restaurant · Wine Shop |
| Discover | Wine Club · About Us · Contact |
| Main CTA | Request a Table |
| Mobile panel title | Explore The Clandestino |
| Mobile panel note | Spanish hospitality in Mount Shasta |
| Phone | +1 (408) 609-0027 |

### Hero 1

| Campo | Copy final |
|---|---|
| Eyebrow | A taste of Spain |
| Heading | Spanish Wine & Tapas in Mount Shasta |
| Description | A taste of Spain. A table to share. Make yourself at home. |
| Primary CTA | Request a Table |
| Secondary CTA | Explore Wines |

### Hero 2

| Campo | Copy final |
|---|---|
| Eyebrow | Food · Fiesta · Friends |
| Heading | Gather, Sip & Celebrate |
| Description | Good wine, shared plates, and the pleasure of being together. |
| Primary CTA | Private Experiences |
| Secondary CTA | Explore the Wine Club |

### Hero 3

| Campo | Copy final |
|---|---|
| Eyebrow | Wines with character |
| Heading | Pure Soul & Spanish Wines |
| Description | Explore Spanish wines with character, from the first glass to the last. |
| Primary CTA | Explore Wines |
| Secondary CTA | Discover Pure Soul |

### Discovery

| Campo | Copy final |
|---|---|
| Eyebrow | Welcome to The Clandestino |
| Heading | A little Spain. A world to discover. |
| Description | Spanish wines, authentic tapas, and thoughtful gifts. Discover the flavors and experiences waiting for you in Mount Shasta. |
| Wines heading | Spanish Wines |
| Wines description | Discover wines with character, chosen for sharing. |
| Wines CTA | Explore Wines |
| Tapas heading | Spanish Tapas & Take Away |
| Tapas description | Small plates to share. Ask us about Take Away. |
| Tapas CTA | Explore Tapas |
| Hampers heading | Gourmet Hampers |
| Hampers description | A thoughtful selection for someone special. |
| Hampers CTA | Discover Hampers |

### Pure Soul

| Campo | Copy final |
|---|---|
| Eyebrow | Our Flagship Wine |
| Heading | Pure Soul |
| Signature | NTC & Sons |
| Statement, line 1 | Spanish roots. |
| Statement, line 2 | A soul of its own. |
| Description | Discover Pure Soul, a Spanish red with a character of its own. Made for slow evenings and shared plates, it opens the door to our wider selection of Spanish wines. |
| CTA | Explore the Wine Shop |

### Private Experiences

| Campo | Copy final |
|---|---|
| Eyebrow | Private Experiences |
| Heading | The evening, held for you. |
| Description | Bring your celebration to The Clandestino. Tell us about your occasion, group, and plans for an evening of Spanish wines and shared plates. We'll explore the possibilities with you. |
| CTA | Plan Your Private Gathering |

### Guest Stories

| Campo | Copy final |
|---|---|
| Eyebrow | Guest Stories |
| Heading | More than wine. Memories. |
| Paragraph 1 | Some come for the wine. Others for the food. What brings us together is everything in between. |
| Paragraph 2 | Meet the people and shared moments that make The Clandestino feel like home. |
| Film 1 | A glass of red · 0:51 |
| Film 2 | Tapas & company · 1:31 |
| Film 3 | By the window · 1:18 |
| Film 4 | A sip of tradition · 0:06 |

### Reservation Invitation

| Campo | Copy final |
|---|---|
| Eyebrow | Your next Clandestino moment |
| Heading | A table worth gathering around. |
| Description | Spanish wines, tapas to share, and moments worth celebrating. Your next evening starts at The Clandestino. |
| CTA | Request a Table |
| Note | Table requests are subject to confirmation. |

### Spanish Wine Club

| Campo | Copy final |
|---|---|
| Eyebrow | The Spanish Wine Club |
| Heading | Discover more of Spain, one wine at a time. |
| Description | Two ways to explore Spanish wine, thoughtfully brought together by The Clandestino. |
| Diamond eyebrow | The signature tier |
| Diamond heading | Diamond Membership |
| Diamond description | Explore our signature Wine Club tier and discover what makes it special. |
| Diamond CTA | Explore Diamond |
| Gold heading | Gold Membership |
| Gold description | Discover the Gold membership and find your place in the club. |
| Gold CTA | Explore Gold |

### Gifting

| Campo | Copy final |
|---|---|
| Eyebrow | Gifts & Gourmet Hampers |
| Heading | A taste of Spain, ready to give. |
| Description | Explore gourmet hampers for celebrations and thank-yous, or ask us about gift cards. |
| Photo caption | Selected with care. Given with love. |
| Hampers eyebrow | The Gifting Atelier |
| Hampers heading | The art of giving well. |
| Hampers description | Spanish wines and gourmet specialties, brought together in hampers for the people and occasions that matter. |
| Hampers CTA | Explore Hampers |
| Gift Cards heading | A Clandestino moment, their way. |
| Gift Cards description | Ask our team about gift card options for someone you’d like to treat. |
| Gift Cards CTA | Ask About Gift Cards |

### Visit

| Campo | Copy final |
|---|---|
| Eyebrow | Visit The Clandestino |
| Heading | Your next Spanish evening starts here. |
| Description | Spanish wines, shared plates, and the pleasure of good company. Find us in Mount Shasta. |
| Address line 1 | 211 N Mt Shasta Blvd |
| Address line 2 | Mount Shasta, CA 96067 |
| Hours line 1 | Tuesday–Sunday |
| Hours line 2 | 4:00 PM – 8:00 PM |
| Primary CTA | Request a Table |
| Secondary CTA | Get Directions |
| Note | Table requests are subject to confirmation. |
| Phone link | Call Us +1 (408) 609-0027 |

### Footer

| Campo | Copy final |
|---|---|
| Brand description | A little Spain in Mount Shasta. Tapas to share, wines to discover, and time for good company. |
| Explore | Home · Experiences · Restaurant · Wine Shop |
| Discover more | Wine Club · About Us · Contact · Private Experiences |
| Contact heading | Visit & contact |
| Address line 1 | 211 N Mt Shasta Blvd |
| Address line 2 | Mount Shasta, CA 96067 |
| Map link | Find us on Google Maps |
| Phone | +1 (408) 609-0027 |
| Hours line 1 | Tuesday–Sunday |
| Hours line 2 | 4:00 PM – 8:00 PM |
| Legal links | Policies · Reservation terms |
| Copyright at review date | © 2026 The Clandestino USA |

## 8. Cambios que conviene NO hacer

1. Reescribir las secciones que ya identifican oferta, emoción y siguiente paso: Discovery, Hero 2, Guest Stories, C8, Visit y Footer se conservan íntegros.
2. Alterar fotografía, tipografía, énfasis, espaciado, colores, botones, animaciones, alturas, orden DOM o contratos de componentes para acomodar copy. No hay nueva Wave ni rediseño.
3. Prometer compra con “Buy Now”, recogida con “Order Online”, reserva con “Confirmed” o alta con “Join Today” cuando el destino es informativo o de consulta.
4. Usar beneficios históricos de Club, promociones, descuentos, precios, cantidades, entregas, disponibilidad o exclusividad como hechos actuales sin validación. No convertir Diamond en “Most Popular”.
5. Inventar detalles de Pure Soul, sustituir el cartel o retocar sus leyendas en esta fase. La revisión del recurso comercial es una dependencia ya registrada.
6. Convertir títulos de vídeos en opiniones, copiar supuestas frases, inventar autores o introducir estrellas. No exigir de nuevo permisos ya confirmados en PR #23; sí distinguirlos de verificación verbal y alternativas accesibles pendientes.
7. Añadir historias de origen, biografías, premios, “family-owned”, producción propia, autenticidad certificada o acuerdos con bodegas sin fuentes del negocio.
8. Eliminar cada repetición de vino/tapas/compartir: parte de ella sostiene reconocimiento y reinvitación. Evitar únicamente repeticiones que ocupan el lugar de información útil.
9. Añadir localidades o estados para SEO, garantías de resultados, FAQs sin necesidad, keywords artificiales, archivos para IA o cambios al SEO técnico R3.
10. Recuperar la navegación futura de nueve ítems, Welcome/Spanish Table retirados, demos de pago, carrito, cuenta, eventos o reservas del Style Guide. No añadir secciones por iniciativa editorial.

## 9. Riesgos comerciales, visuales y funcionales

| Riesgo | Consecuencia | Tratamiento dentro de esta propuesta |
|---|---|---|
| Oferta histórica en SWC y catálogos | El visitante puede recibir precios, beneficios o condiciones no vigentes después de un CTA correcto | Validación comercial antes de publicar. No corregir otros archivos ni redirigir CTA silenciosamente. |
| Solicitudes sin recepción operativa verificada | El usuario puede creer que el negocio recibió algo que solo aceptó el transporte | Mantener “Request”/nota de confirmación. Conservar la validación operativa R1 como requisito previo, sin enviar mensajes en R5. |
| Gift Cards solo por consulta | Una imagen o lenguaje de regalo puede interpretarse como compra disponible | E06/E09 explicitan consulta; conservar “Ask About Gift Cards”. No prometer emisión, entrega o canje. |
| Pure Soul: arte y datos pendientes | El copy nuevo no elimina afirmaciones incrustadas ni certifica vigencia comercial | No ampliar claims; mantener H03 y solicitar datos mínimos, sin editar el recurso. |
| Club sin diferencias actuales confirmadas | La comparación sigue siendo insuficiente para decidir una membresía | E05 mejora identificación; conservar descripciones prudentes hasta disponer de beneficios aprobados. No fingir que esta limitación queda resuelta. |
| Vídeos sin contenido verbal verificado en R5 | Titulares valorativos podrían atribuir una opinión inexistente | Conservar títulos neutrales. Respetar permisos/audio confirmados y pendientes audiovisuales ya documentados. |
| Reducción de texto E02/E03/E04 | Puede cambiar alineación percibida y espacio libre con el diseño intacto | Medidas en cuatro anchos y revisión humana posterior del conjunto; no compensar con CSS sin autorización. |
| Contacto sin contexto precargado | Una persona debe volver a explicar interés en Private/Gift Cards | El copy invita a escribir al equipo. Registrar límite; no inventar preselecciones o nuevos campos. |
| Medición editorial local | Fuentes/plataformas o aplicación conjunta pueden variar saltos | Resultado de ajuste en Chrome, no aprobación visual universal. Una futura implementación exige revisar 320/390/820/1440 con el copy aprobado. |

No se abren de nuevo auditorías técnicas cerradas. Estos riesgos explican límites comerciales y de texto relevantes para aprobar la propuesta; no autorizan cambios de código, multimedia, infraestructura o servicios.

## 10. Datos mínimos pendientes de validar

| Dato / responsable comercial | Qué decisión desbloquea |
|---|---|
| Pure Soul: denominación comercial, relación con NTC & Sons, origen y recurso promocional vigente | Aprobar E03 y conservar con fundamento “Our Flagship Wine”, “Spanish roots” y la imagen. No se necesitan notas de cata inventadas. |
| Diamond y Gold: oferta actual, diferencias, beneficios, precio/cadencia y condiciones/modalidad de entrega o recogida | Validar SWC y, solo si hay información útil aprobada, precisar después las descripciones de niveles. Mantener Diamond protagonista. |
| Vinos, tapas/Take Away y hampers: catálogo actual, forma de consultar/comprar, recogida disponible y condiciones aplicables | Garantizar que los destinos cumplen la expectativa de exploración/consulta. No publicar horarios de cocina, envíos o stock inferidos. |
| Gift Cards: si se ofrecen hoy, qué opciones puede explicar el equipo y proceso real | Aprobar la invitación de consulta. Importes, entrega, emisión y redención solo se publicarán cuando estén definidos; no son prestaciones asumidas. |
| Reservas y experiencias privadas: canal atendido, responsable y proceso de respuesta/confirmación | Dar continuidad a las consultas sin inventar plazos, aforo o disponibilidad. La prueba de recepción se realizará en una fase autorizada. |
| Dirección, teléfono y horario: confirmar que siguen vigentes al lanzamiento | Conservar coherencia Visit/Footer/datos estructurados. No se reabren como desconocidos: R3 ya registra su fuente confirmada. |

Para testimonios, el dato editorial que permitiría otra evaluación futura es el contenido verbal íntegro revisado por clip. No se solicita para conservar los títulos actuales ni se reabre la autorización de uso. Los subtítulos/alternativas siguen su cierre audiovisual propio.

## 11. Verificación y límite de entrega — fase 1

- Documento contrastado con el DOM y las cadenas de los partials activos: once bloques principales, tres escenas y las dos categorías de Club, hampers/tarjetas y cuatro títulos audiovisuales.
- Revisión local en 320/390/820/1440 y comparación temporal de E01–E09 sin guardar cambios en fuentes. Las acciones de catálogo se inspeccionaron como consultas, no como checkout.
- Destinos locales 200: Wines, Tapas, Menu, Hampers, SWC, About, Contact, legacy de reservas, Policies y Terms; fragments `contact-form` y `reservation` presentes. No se acreditan operaciones externas por ello.
- Único archivo creado dentro del repositorio: `docs/HOME-EDITORIAL-CONVERSION-REVIEW.md`. Ningún archivo de producto o configuración se modifica; no se ejecutó build ni se instalaron dependencias para esta fase documental.
- SHA256 de los tres informes previos preservados: HOME-FINAL-AUDIT `49B97D8320715F61AC0BCAEAE196E847C56B6F397CA971B29D9CCFCE75932BCC`; HOME-TECHNICAL-AUDIT `F7A3A637C4F9FB672AF3F8EDAEACF6F70A0D3F5AABD83CDD1C875C3EDDE79D68`; HOME-VISUAL-ASSET-PLAN `68201E6CD72B41BD3365DDF3D31980F67B4F8BA2DE2C2B396C372D2EE90E8690`.
- Verificados estado Git, hashes de preservación y ausencia de diferencias en archivos rastreados o en el índice. `git diff --check` sin incidencias; el documento nuevo se comprueba también con `git diff --no-index --check -- NUL docs/HOME-EDITORIAL-CONVERSION-REVIEW.md`, ya que aún no está rastreado. Sin commit, staging, push, PR, merge de trabajo, deploy o modificación de `main`; únicamente el fast-forward de preparación solicitado sobre `develop`.

La aprobación solicitada corresponde a **E01–E09 y a la conservación del resto del copy**, con los datos comerciales pendientes expresamente señalados. No implica aprobación de publicación ni de una operación comercial. La implementación comenzará únicamente después de aprobación humana y dentro del alcance que se autorice.

**HOME R5 EDITORIAL & CONVERSION — WAITING FOR REVIEW**

STOP.

## 12. Implementación aprobada y QA responsive — evidencia de implementación

2026-11-04 · `feature/home-editorial-conversion` · Base conservada `1ffc9178f468a051982f1180e693514c4e46b6dc`. Se verificaron rama y estado antes de editar. No se repitió la auditoría editorial ni se propusieron alternativas nuevas. Se aplicó la skill local `qa-visual`, añadiendo sus tamaños 768/1280 a los cuatro solicitados.

### 12.1 Selección ejecutada

| ID | Resultado | Cadena implementada o conservada |
|---|---|---|
| E01 | Implementado en Header, Hero 1 y partial reutilizable Spanish Table | `Request a Table`. Se conservan `$rutaReserva`, sus valores por anfitrión y todos los href. Spanish Table sigue sin incluirse en la Home activa; solo se unifica la etiqueta de la misma solicitud. |
| E02 | Implementado exclusivamente en el heading de Hero 3 | `Pure Soul & Spanish Wines`. Descripción, acciones, imágenes y funcionamiento intactos. |
| E03 | Conservado íntegro | `Discover Pure Soul, a Spanish red with a character of its own. Made for slow evenings and shared plates, it opens the door to our wider selection of Spanish wines.` Arte y composición intactos. |
| E04 | Implementado en Private Experiences | `Bring your celebration to The Clandestino. Tell us about your occasion, group, and plans for an evening of Spanish wines and shared plates. We'll explore the possibilities with you.` Se conservan `Plan Your Private Gathering` y `/contact.html#contact-form`. |
| E05 | Conservado íntegro | `Two ways to explore Spanish wine, thoughtfully brought together by The Clandestino.` Diamond sigue protagonista y Gold alternativa; no se alteran niveles, beneficios, condiciones ni destino. |
| E06 | Implementado en la descripción general de Gifting | `Explore gourmet hampers for celebrations and thank-yous, or ask us about gift cards.` |
| E07 | Conservado íntegro | `The Gifting Atelier`. Eyebrow, heading y jerarquía intactos. |
| E08 | Implementado tras comprobar documentación interna | `Spanish wines and gourmet specialties, brought together in hampers for the people and occasions that matter.` Describe la familia de regalos; no garantiza componentes de cada referencia. |
| E09 | Implementado en la descripción de Gift Cards | `Ask our team about gift card options for someone you’d like to treat.` Se conservan `Ask About Gift Cards` y `/contact.html#contact-form`. |

**Alcance compartido de E01:** Header y Hero reciben el mismo copy desde sus fuentes existentes, tanto en candidata pública como en Home Preview. El partial Spanish Table comparte `$rutaReserva` y se ha alineado sin reactivarlo. C8 y Visit ya decían `Request a Table` y no se editaron. Las muestras independientes de Style Guide que dicen `Reserve a Table` describen destinos demostrativos explícitos, no esta solicitud comercial; no se modificaron. Ninguna página legacy se reescribió.

### 12.2 Decisión E08 y evidencia

La condición de documentación interna se considera satisfecha para una descripción general de la oferta:

- `hampers.html:38–40` identifica la categoría como Gourmet Spanish Gift Baskets y describe cestas con vino, conservas y alimentos artesanos: `Curated gourmet Spanish gift hampers & premium baskets with wine, conservas, artisanal foods & festive pairings from Mount Shasta, CA.`
- `hampers.html:60` presenta `Gourmet Spanish hampers with wines, conservas & artisanal foods.` La descripción de Premium Selection en `hampers.html:130` documenta `Exquisite wines paired with the finest Spanish gourmet specialties.` No se trasladan sus precios ni estados de stock al nuevo texto.
- El catálogo generado por `assets/js/hampers.js` describe Premium Selection como vinos junto a especialidades gourmet. El recurso existente de `includes/gifting.php`, `basket-05.webp`, ya documenta vinos españoles y delicatessen en su alt; la fotografía y su contexto aprobado se registran en `docs/HOME-PHASE-C4.md`.

Se aplica la frase aprobada porque coincide con esa documentación de categoría y selección. **No se afirma que todos los hampers incluyan vino, ni que una fotografía determine la composición comercial vigente.** La confirmación de contenido por referencia, precios, disponibilidad y condiciones continúa pendiente antes de venta/publicación. La evidencia cumple la condición editorial solicitada; no acredita inventario en vivo.

### 12.3 Antes/después y responsive

URL de ensayo: `http://127.0.0.1:8016/`, candidata pública local con `CL_HOME_PUBLIC_REVIEW=1`, sin marcador de activación y con correo nativo deshabilitado. También se verificó `/home-preview.php`: comparte los cambios y conserva sus destinos propios. Chrome instalado, viewport de 1000 px de alto y fuentes reales cargadas; reduced motion para estabilizar comparaciones.

Evidencia externa **E**: `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a537-3e02-7403-8086-c82b93e60626/home-r5-implementation/`.

| Comprobación | Resultado |
|---|---|
| 320, 390, 820 y 1440 px solicitados | PASS: comparación antes/después de Header/Hero 1, menú móvil, Hero 3, Private Experiences y Gifting. Sin overflow, corte de texto o botones superpuestos observado. |
| 768 y 1280 px de la skill | PASS: capturas, dimensiones, overflow, foco y comportamiento del menú según breakpoint. |
| Hero 3 | PASS: heading de 3→2 líneas en los cuatro anchos solicitados. La altura de la sección permanece idéntica a la anterior; botones y foto conservan su composición, sin CSS de compensación. |
| Private Experiences | PASS: párrafo 8→6 / 6→5 / 5→4 / 4→4 líneas en 320/390/820/1440. La sección reduce aproximadamente 58/29/29/0 px respectivamente de forma natural. No se ajustan espaciados ni recortes mediante código. |
| Gifting | PASS: descripción general 3→3 / 3→2 / 2→2 / 2→2 líneas. Hampers conserva 3 líneas en los cuatro; Gift Cards conserva 2/2/2/1. Se mantienen figuras, énfasis y jerarquía. |
| Botones y alineación | PASS: acciones comprobadas con alto ≥44 px. Header conserva su altura; `Request` solo añade aproximadamente 1,5 px al ancho automático del botón en tablet/escritorio. |
| Imágenes | PASS en la lectura final: recursos decodificados, sin imágenes rotas observadas; fuentes y fotografías sin cambios. |
| Teclado y foco | PASS en seis anchos: Tab al enlace de salto; Enter abre menú, Space opera Discover, Escape cierra submenú y drawer, con retorno al control. Enter activa escena 3. CTA revisados con foco visible de 2 px y offset de 3 px. |
| Contraste | PASS del texto revisado/recolocado: 54 muestras sobre Hero 3 y Private, mínimo 5,12:1 y 9,04:1 respectivamente. Gifting sobre superficies sólidas: mínimo 8,47:1. Se respetan 4,5:1 normal y 3:1 grande. No es una certificación global de accesibilidad. |
| Navegación | PASS: todos los href de Header/main/Footer coinciden antes/después en los seis tamaños. Clics de mesa, Private y Gift Cards probados en 390/1440, con fragments de destino presentes y sin envíos. |
| Consola y red de Home | PASS: sin errores/warnings relevantes ni respuestas HTTP ≥400 durante el recorrido final de Home. Los destinos legacy no se someten a una nueva auditoría general. |
| Sin JavaScript | PASS muestreado en 320: etiquetas nuevas y heading emitidos en servidor, sin overflow; Header conserva enlaces utilizables. |

Las capturas `before-*` registran el estado anterior real y `after-*` la implementación. Las láminas `compare-clean-{320,390,820,1440}-{hero3,private,gifting}.png` muestran izquierda antes / derecha después, sin overlays accidentales del Header o foco. Para esos recortes limpios se reprodujeron las cadenas iniciales en la respuesta local del navegador, usando los mismos recursos verificados por hash; no se restauraron ni alteraron fuentes del checkout. Se esperó la carga/decodificación y pintura de las imágenes lazy. Los artefactos iniciales de captura no se trataron como defectos del producto.

Registros: `before-responsive.json`, `after-responsive.json`, `comparison.json`, `keyboard-focus.json`, `contrast.json`, `gifting-contrast.json`, `navigation.json`, `home-console.json`, `html-validation.json`, `preservation.json` y capturas. En el muestreo fotográfico se comparan píxeles interiores de texto con su fondo real, excluyendo píxeles de fotografía que no cambian al ocultar temporalmente el texto. No se modifica CSS persistente para medir.

### 12.4 QA técnico ejecutado

| Comando / comprobación | Resultado |
|---|---|
| `npm.cmd run lint` | PASS: ESLint y Stylelint. |
| `npm.cmd run build` | PASS. `home.css` y `main.js` regenerados conservan exactamente sus hashes iniciales; no hay cambio de estilos o comportamiento por R5. |
| `php -l` sobre los PHP rastreados | PASS: 65 archivos, incluidos los cinco partials modificados. |
| `php scripts/probar-fechas-formularios.php` | PASS: 27 comprobaciones. |
| `node scripts/probar-carrito.mjs` | PASS. |
| `node scripts/probar-cierre-comercio.mjs` | PASS. |
| `node scripts/probar-formularios.mjs` | PASS: 126 casos y sus comprobaciones de calendario/sesión, correo nativo deshabilitado. |
| `node scripts/probar-home-publica.mjs` | PASS: 72 contratos HTTP/PHP/CGI aislados; no valida Apache real. |
| HTML renderizado público y preview, `html5lib` | PASS: cero errores del parser, IDs únicos, referencias ARIA/for resueltas, un H1 y un main, jerarquía sin saltos e imágenes con alt. |
| `git diff --check`; documento aún no rastreado con `git diff --no-index --check -- NUL docs/HOME-EDITORIAL-CONVERSION-REVIEW.md` | PASS de formato. Sin staging. |

No se añadieron suites, dependencias, configuraciones o infraestructura al repositorio. Los auxiliares de QA y capturas viven exclusivamente en E.

### 12.5 Archivos y preservación

Archivos de producto modificados: `includes/header.php`, `includes/home-document.php`, `includes/spanish-table.php`, `includes/private-experiences.php`, `includes/gifting.php`. Son **ocho sustituciones de cadenas**: tres E01, una E02, una E04 y tres en Gifting. Único documento actualizado: este informe, que continúa sin seguimiento como al inicio de R5; no se añade al índice.

Se verificó que Discovery, Pure Soul, Wine Club, Guest Stories, Reservation Invitation, Visit y Footer conservan sus hashes iniciales. Hero 2 y los demás campos de Hero permanecen idénticos en el diff; `Plan Your Private Gathering`, títulos protegidos y títulos audiovisuales se conservaron. `site.php`, rutas, PHP anfitriones, legacy, assets, SCSS, JS y dependencias no tienen diferencias rastreadas. El año del Footer sigue siendo dinámico.

Los tres informes históricos no rastreados conservan los SHA256 del apartado 11. Todos los archivos locales se preservan; no se hizo stash, limpieza, cambio de ramas, commit, push, PR, merge o deploy durante la implementación. `main` sigue en `464471ef0e1902ca9dc3d2d415cbcf6ad865a7f0`; `.home-public-enabled` no existe. La Home pública continúa desactivada.

### 12.6 Riesgos pendientes y decisión

**QA de la intervención R5: PASS, sin regresiones demostradas que requieran corregir estilos.** La aprobación del copy habilitó estas sustituciones; la revisión humana del resultado implementado sigue pendiente. No se declara merge-ready ni se autoriza publicación.

Permanecen los riesgos comerciales ya documentados: vigencia de Pure Soul/arte y catálogos; beneficios, precios y condiciones de SWC; composición/disponibilidad de hampers; oferta y proceso de Gift Cards; recepción real y atención de solicitudes. Las acciones siguen siendo exploración, consulta o solicitud, sin compra, emisión o mesa confirmada implícitas.

Guest Stories conserva cuatro vídeos y cero tracks de subtítulos en esta entrega. Los permisos/audio confirmados no se reabren; subtítulos y alternativas accesibles siguen siendo pendientes históricos de publicación fuera de R5. El HTML válido y el QA focalizado no acreditan conformidad WCAG global. Esta revisión se realizó en Chrome local, no en dispositivos físicos ni en Apache/GoDaddy.

Para repetir la lectura, utilizar el comando del apartado 2 y abrir `/` y `/home-preview.php` en los cuatro anchos solicitados; el servidor de revisión temporal se detuvo al cerrar. No crear el marcador de activación y no enviar formularios durante QA editorial.

**HOME R5 EDITORIAL IMPLEMENTED — WAITING FOR REVIEW**

STOP.

## 13. Cierre editorial aprobado — preparación de PR manual

2026-11-04 · America/Bogota. El responsable revisó favorablemente la implementación R5 y autorizó el commit `refactor(home): refinar storytelling y claridad comercial` y push normal de `feature/home-editorial-conversion` a origin para crear un PR **manual** hacia `develop`. Esta autorización sustituye las restricciones históricas de no commit/no push para este cierre exclusivamente. No autoriza PR automático, merge, deploy, cambios en `main` ni activación de Home pública. No se redacta la descripción del PR.

### Alcance consolidado

Tras `git fetch origin`, `origin/develop` y la base de la feature coinciden en `1ffc9178f468a051982f1180e693514c4e46b6dc`. La rama remota R5 no existía al iniciar este cierre. Se comprobó el diff completo: cinco partials con ocho sustituciones de cadenas E01/E02/E04/E06/E08/E09 y este documento. No se introduce nuevo copy ni cambios visuales durante el cierre.

Archivos autorizados para el commit:

- `includes/header.php`: etiqueta E01 compartida.
- `includes/home-document.php`: etiqueta E01 de Hero 1 y heading E02 de Hero 3.
- `includes/spanish-table.php`: coherencia E01 de la misma solicitud reutilizable, sin reactivar la sección.
- `includes/private-experiences.php`: descripción E04, con CTA y destino intactos.
- `includes/gifting.php`: descripciones E06, E08 y E09.
- `docs/HOME-EDITORIAL-CONVERSION-REVIEW.md`: propuesta, selección aprobada, evidencia E08, implementación, QA y cierre.

E03, E05 y E07 permanecen expresamente conservados. Se contrastaron las fuentes con la copia anterior: cada partial modificado equivale exactamente a aplicar las cadenas aprobadas y ningún otro cambio. Los demás includes mantienen sus hashes iniciales. No hay diferencias de assets, SCSS, JS, fotografías, configuración, rutas o páginas legacy.

### Validaciones repetidas de cierre

| Validación | Resultado |
|---|---|
| `npm.cmd run lint` | PASS: ESLint y Stylelint. |
| `npm.cmd run build` | PASS. Los hashes de `home.css` y `main.js` coinciden con los de la entrega R5 previamente comprobada. |
| PHP lint | PASS en los 65 PHP rastreados. |
| `php scripts/probar-fechas-formularios.php` | PASS: 27 comprobaciones. |
| Cuatro suites Node existentes | PASS: `probar-carrito.mjs`, `probar-cierre-comercio.mjs`, `probar-formularios.mjs` (126 casos) y `probar-home-publica.mjs` (72 contratos). Correo nativo deshabilitado en fixtures. |
| HTML público y preview renderizados nuevamente | PASS con html5lib: cero errores, IDs únicos, referencias resueltas, un H1/main, jerarquía sin saltos y alt presentes. No se declara accesibilidad audiovisual completa. |
| Copy y CTA | PASS: ambas variantes muestran cuatro etiquetas `Request a Table`, ninguna etiqueta `Reserve a Table`, el nuevo heading y las descripciones aprobadas. `Plan Your Private Gathering` y su ruta se conservan. |
| Rutas y anclas | PASS: respuestas 200 locales en reservas legacy, Contact, Wines, Hampers, SWC y Tapas; fragments `reservation` y `contact-form` presentes. Sin POST, mensajes o compras. |
| Responsive, teclado y foco | Se conserva la evidencia del apartado 12 en 320/390/820/1440 y 768/1280: sin overflow ni recortes observados, navegación y foco conservados. No se repiten mediciones extensivas porque las fuentes coinciden con la selección ya validada y los bundles reconstruidos mantienen sus hashes. |
| `git diff --check` y revisión del índice | PASS; solo los seis archivos autorizados. Los informes históricos quedan fuera del índice. |

La evidencia nueva se guarda fuera del repositorio en `C:/Users/Mike/.codex/visualizations/2026/11/04/01a1a537-3e02-7403-8086-c82b93e60626/home-r5-close/`: `integrity.json`, contratos HTTP, HTML renderizado y `html-validation.json`. Las capturas y resultados extensos anteriores permanecen en `home-r5-implementation/`.

### Integridad y pendientes reales

HOME-FINAL-AUDIT, HOME-TECHNICAL-AUDIT y HOME-VISUAL-ASSET-PLAN conservan exactamente los SHA256 registrados en el apartado 11 y siguen sin seguimiento. El informe R5, que era nuevo y no rastreado, se incorpora explícitamente al commit autorizado. No se usa `git add .`, stash, limpieza ni fuerza sobre el remoto. El SHA final y la sincronización se informan después del commit/push, sin intentar incluir en el propio documento el hash de su commit.

La Home pública permanece desactivada: no existe `.home-public-enabled`; ambas variantes locales responden noindex. `main` conserva `464471ef0e1902ca9dc3d2d415cbcf6ad865a7f0`. El cierre no modifica los pendientes comerciales del apartado 12.6 ni los subtítulos/alternativas audiovisuales previos, ni acredita recepción de correo, disponibilidad, compra, reserva confirmada o funcionamiento de Apache/GoDaddy.

**HOME R5 READY FOR PR**

STOP.
