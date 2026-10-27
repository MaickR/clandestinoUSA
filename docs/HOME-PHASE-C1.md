# Home C1 — refinamiento visual Pure Soul

Rama `feature/home-wines`. Las versiones previas de tres zonas y de cabecera global fueron rechazadas visualmente. El responsable aprobó la composición actual, el retrato, el marco desplazado, el degradado, la jerarquía y la distribución responsive. La aprobación comercial del arte sigue pendiente.

## Composición

Una imagen íntegra y un único relato reúnen `Our Flagship Wine`, el H2 `Pure Soul`, la firma NTC & Sons, la entrada editorial, la descripción y el CTA `Explore the Wine Shop` hacia `/wines.html`. En escritorio y tablet el retrato queda a la izquierda y la identidad se integra con el relato a la derecha. En móvil el orden de lectura es identidad, imagen, relato y CTA. CSS Grid usa el contenedor Foundation y los breakpoints Bootstrap; no se agregó JavaScript ni CSS legacy.

El marco es un pseudo-elemento no interactivo detrás del `picture`, con borde champagne de un píxel y desplazamiento de 12 px en móvil y 16 px desde md. El contexto aislado y el espacio reservado evitan recortes. El fondo local usa un degradado diagonal discreto entre mezclas de los primitivos de vino y neutro existentes; no cambia tokens globales. Se reutilizan `cl-seccion`, `cl-historia`, `cl-historia__declaracion`, `cl-eyebrow`, `cl-display`, `cl-vino__imagen`, botón Core, variables semánticas de espacio y radio, y mixins Bootstrap.

## Arte provisional y bloqueo de publicación

Se utiliza el mismo `assets/images/pure-soul-poster.jpg` del legacy y sus derivados AVIF/WebP, con proporción 3:4, `contain`, dimensiones y carga diferida. El archivo y la etiqueta no se modificaron. **No está aprobado para producción**: incorpora “COMING SOON TO THE BEST BARS AND RESTAURANTS IN CALIFORNIA.”, “LIMITED EDITION”, “BOTTLE 1763 OF 3000”, “Grenache 85% · Vidadillo 15%” y “Barrel Aged”, datos que requieren validación comercial vigente o sustitución del recurso por uno aprobado. No se ocultaron los textos.

## QA de esta iteración

- Comparación visual del original y la nueva C1 en escritorio y móvil; revisión de la nueva composición también en 768 px. Medidas de layout a 320, 390, 425, 768, 1024, 1280, 1440 y 2560 px sin overflow de documento. La captura móvil completa se ensambla a partir de vistas nativas para evitar el recorte del capturador fullPage.
- Refinamiento de fondo: comparación visual del uniforme anterior, degradado diagonal y degradado horizontal en 390, 768 y 1440 px. Se selecciona el diagonal por su transición suave y equilibrio entre el retrato y el relato. La geometría medida de C1, Spanish Table y Footer coincide con la versión uniforme en los tres anchos.
- Contraste calculado para el texto HTML contra el extremo más claro del degradado: descripción 10.27:1, eyebrow 12.24:1, título 15.13:1 y CTA 12.69:1. El marco decorativo semitransparente alcanza aproximadamente 4.54:1 en el extremo más claro. Esto no certifica el texto incrustado en la imagen.
- Teclado: Tab desde Spanish Table llega al CTA con foco visible de 2 px. Sin JavaScript: el contenido, el arte y el enlace se presentan mediante una respuesta local con scripts eliminados y CSP restrictiva.
- `npm run lint`, `npm run build`, PHP lint, pruebas Node `probar-carrito.mjs` y `probar-cierre-comercio.mjs`, `git diff --check` y validación estructural HTML básica: PASS. Esta última no sustituye la validación Nu/W3C. Rutas del CTA, CSS e imágenes: HTTP 200.
- El zoom nativo al 200 % y pruebas con lector de pantalla físico no se han verificado. El navegador local no sustituye Safari, Firefox, dispositivos reales ni QA de producción.

Las capturas comparativas de prueba usaron extremos RGB redondeados; el color Sass compilado difiere dos unidades en el canal azul del extremo vino. La Home actual termina provisionalmente en Footer; no existe todavía una siguiente sección comercial que contrastar.

La integración se limita a Home Preview local y no autoriza la publicación del póster ni la activación de comercio.
