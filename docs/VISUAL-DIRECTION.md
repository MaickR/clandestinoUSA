# Dirección visual — The Clandestino USA

Referencia estética para próximas waves y revisiones. Complementa UX-UI-GUIDELINES y los contratos de componentes; no redefine tokens ni atribuye aprobaciones nuevas. Foundation/Core/Waves 1 y 2 son la base aprobada del encargo. El refinamiento Wave 3 sigue pendiente de aprobación visual humana.

## Personalidad traducida a interfaz

Hospitalidad gastronómica premium significa una invitación comprensible: qué se comparte, cómo se vive y qué puede hacer la persona después. Dark-first y superficies cálidas dan intimidad; champagne guía la lectura y la acción. Libre Bodoni aporta voz editorial y la sans del sistema mantiene legibles contexto, precios y controles. La exclusividad se expresa mediante selección y cuidado, no con urgencia, premios o datos inventados.

La fotografía auténtica abre la conversación. El contenido identifica lo fotografiado y distingue archivo de oferta actual. No confundir una mesa con prueba de opiniones o consentimiento de invitados. El texto creativo de marca puede invitar; no debe fingir una cita ni una biografía verificable.

## Composición y jerarquía

- Elegir un protagonista por sección: experiencia, fotografía, relato o invitación. Darle peso mediante proporción y posición, antes de añadir decoración.
- Componer fotografía, titular, contexto y CTA como una decisión conjunta. No convertir todos los contenidos en la misma tarjeta con imagen encima.
- Usar las superficies para agrupar una invitación o proteger legibilidad, sin colocar automáticamente un panel opaco sobre una foto.
- Contrastar piezas dominantes con piezas de apoyo. La asimetría necesita alineaciones y gutters claros; no justifica huecos arbitrarios.
- Mantener lectura y teclado coherentes. Se puede cambiar de lado una imagen no interactiva, pero no desordenar acciones respecto al DOM.
- Un titular necesita una anchura de lectura intencional. Ajustar columnas y límites contextuales antes de tocar tamaños globales; comprobar los saltos reales, evitando `<br>` rígidos salvo manifiestos deliberados.

## Densidad y ritmo

El espacio separa ideas y facilita explorar. Deja de ser útil cuando una tarjeta mantiene un gran panel vacío, una tablet muestra una foto desmesurada o un offset separa título y prosa sin aportar jerarquía. Usar la escala de espaciado existente, distribuir el peso entre columnas y dejar que el contenido determine la altura.

Combinar una imagen principal con invitaciones secundarias compactas. Alternar secuencias fotográficas, bajadas de texto y superficies discretas; no repetir siempre un split 50/50. La diversidad pertenece a la composición, no a una colección de colores, radios y estilos de botón distintos.

## Criterio fotográfico

| Uso | Dirección |
|---|---|
| Hero | Fotografía y copy integrados en el mismo banner, con protección tonal localizada y contraste probado |
| Experiencia principal | Foto capaz de sostener el relato; preservar el alimento o ambiente esencial y situar la acción cerca de su contexto |
| Foto vertical | Usar su encuadre para una invitación lateral o un detalle; evitar estirarla como fondo horizontal |
| Panorámica | Mostrar el conjunto cuando la mesa completa importa; no recortarla a una franja irreconocible |
| Mosaico editorial | Colección con proporciones y alineaciones controladas; recortes de miniaturas revisados y ampliación completa cuando haya visor |
| Media lateral | Equilibrar anchura de fotografía y longitud real del texto; aprovechar tablet como dos columnas si el contenido cabe |
| Comunidad | Priorizar el espacio de encuentro y la mesa. Sin personas identificables mientras no exista permiso documentado |

Todos los contenedores y fotografías nuevos usan `--radio-md`; revisar el resultado renderizado, no solo el wrapper. Un `<picture>` intermedio no hereda automáticamente el radio de su abuelo. No añadir imágenes externas, generar derivados ni alterar originales sin autorización. Reservar dimensiones/proporciones y evitar distorsión. En el visor, `contain` conserva toda la fotografía; los recortes pertenecen exclusivamente a miniaturas.

## Acciones y controles

Una sección debe hacer evidente su siguiente paso. Explorar carta/club y consultar un encuentro son acciones distintas de reservar o comprar. Una invitación principal puede usar el botón Core con borde o superficie; enlaces editoriales secundarios conservan subrayado, foco y target suficiente. La fotografía de una galería es un enlace/control real, con nombre accesible y una indicación visible para ampliar.

En overlays, cierre y navegación permanecen disponibles aunque falle la media. Caption y contador quedan fuera de la foto. Bootstrap/Core conserva trap, Escape, backdrop y retorno de foco; no hay segundo sistema modal ni atajos globales.

## Responsive con intención

- Teléfono: jerarquía clara, fotos proporcionadas y acciones cómodas. Una galería puede usar dos columnas; una experiencia secundaria puede mantener foto lateral si el texto sigue siendo legible.
- Tablet: revisar dimensiones efectivas y anchos de línea. Una experiencia principal puede pasar a foto y texto laterales, mientras una galería usa miniaturas equilibradas de igual peso.
- Desktop: introducir protagonismo y asimetría sin perder la retícula. Los elementos de apoyo no deben inflarse hasta parecer protagonistas vacíos.
- Probar entre breakpoints Bootstrap, texto largo, 320px y poca altura. El visor limita su superficie al viewport y permite scroll interno para captions extensos, conservando sus controles.

## Recursos visuales

Champagne para jerarquía/acción y bordes selectivos para separación. Superficies cálidas para agrupación; sombras únicamente en overlays donde Core ya las contempla. Iconos cuando explican una acción o categoría, no para completar cuatro cajas. Nada de glow, glassmorphism, gradientes decorativos, radios grandes ni nueva tipografía. Las microinteracciones confirman acción y foco; no sustituyen contenido ni provocan movimiento innecesario.

## Referencias concretas aprobadas

- **Wave 1 / `cl-hero`:** copy y foto superpuestos en todos los tamaños; la protección elíptica es localizada, sin rectángulo opaco global. El texto no cae debajo de la fotografía en móvil.
- **Wave 1 / `cl-media-contenido`:** columnas desde md, proporciones contextuales y orden imagen/narrativa conservado. Es la primera opción para un split que no requiere otra responsabilidad.
- **Wave 1 / `cl-banda-cta--destacada`:** fotografía lateral, invitación con nota útil y acciones claras; sirve de referencia para densidad y CTA contextual.
- **Wave 2 / `cl-producto-gastronomico`:** fotografía protagonista y pie comercial con precio/acción agrupados. La experiencia editorial no debe copiar ese pie de catálogo.
- **Wave 2 / `cl-item-menu`:** filas con media opcional, metadatos y acciones compactas; no simples líneas de título/precio sin contexto.
- **Wave 2 / `cl-vino`:** botella completa con contain y ficha legible, sin recortar etiquetas para imitar una foto ambiental.
- **Home C1 / Pure Soul:** marco editorial desplazado aprobado para esta imagen protagonista: línea champagne fina detrás de la fotografía, desplazamiento moderado y adaptable, sin sombras ni decoración excesiva. Es un recurso selectivo; ante un segundo caso real se evaluará una abstracción breve y reutilizable, sin convertirlo por ahora en componente global.
- **Wave 3 / `cl-experiencia--destacada`:** el usuario aprobó expresamente esta composición antes del refinamiento. Se conserva su distribución y comportamiento; la normalización local de radio no cambia esa dirección.

## Antipatrones que debemos detectar

Hero con texto debajo de la foto cuando debe estar integrado; panel opaco que tapa el ambiente; imágenes excesivas en tablet; CTAs planos sin jerarquía contextual; tarjetas con espacios muertos; filas de menú sin riqueza informativa; grids editoriales monótonos o irregulares por mera decoración. Estos criterios proceden de la revisión del usuario y de los contratos vigentes, no suponen una aprobación histórica de cada alternativa.

## Autoevaluación antes de entregar

Comprobar en navegador identidad, composición, jerarquía, densidad, adecuación al contenido, carácter responsive, accesibilidad y coste de recursos. Corregir los problemas encontrados antes de solicitar la revisión integral. Compilar no demuestra una composición bien resuelta; QA técnico y aprobación estética humana son decisiones distintas.

**Principio rector:** reutilizar el lenguaje visual aprobado sin repetir siempre la misma composición.
