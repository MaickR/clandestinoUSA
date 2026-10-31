# Criterios de UX/UI — The Clandestino USA

Guía práctica para decidir, diseñar y revisar. Complementa `ESTANDARES-DE-CODIGO.md` y los contratos de Foundation/Core/Patterns; no sustituye sus tokens ni convierte recomendaciones en prohibiciones absolutas.

## Experiencia y decisiones

- Hacer evidente qué puede hacer la persona, qué necesita aportar y qué ocurre después. Priorizar una acción principal por contexto; diferenciar explorar, solicitar y confirmar.
- Mantener nombres, jerarquía y comportamiento consistentes entre páginas. Agrupar acciones relacionadas; evitar competir con varias prioridades visuales.
- Reducir pasos y contenido que no ayudan a decidir. Prevenir errores con límites y ayudas antes de que ocurran; ofrecer recuperación clara y feedback útil junto a la acción.
- Toda acción importante debe poder ejecutarse con teclado y tacto. No prometer disponibilidad, pagos o reservas confirmadas si el sistema no los comprueba.

## Mobile first, contenido y grid

- Empezar por móvil y escalar según el espacio y el contenido; una tablet no necesita automáticamente el layout de teléfono.
- En páginas públicas, una presentación editorial apilada en una columna en teléfonos centra eyebrow, títulos/subtítulos, descripciones breves, dirección, horarios, avisos breves y enlaces/acciones complementarias. Aplicar el centrado al bloque editorial concreto, nunca globalmente al sitio. No extender esta norma a formularios, tablas, listas o contenido extenso; tablet y desktop conservan la alineación que requiera su composición.
- Usar exclusivamente los breakpoints Bootstrap vigentes y su grid como estructura principal. No añadir cortes arbitrarios para un dispositivo concreto.
- Probar entre breakpoints, textos largos, 320px, poca altura y zoom 200%. El contenido determina la altura; una fotografía no debe expulsar controles ni cortar texto.
- Usar `--espacio-1`…`--espacio-9`. La base visual preferente es 8 con subdivisiones de 4, compatible con la escala existente; no todas las medidas deben ser múltiplos de 8.
- Preferir anchos relativos, límites de lectura y proporciones coherentes. Justificar medidas contextuales como los límites de grupos de acciones y `clamp()` local, sin crear otra escala global.

## Interacciones y formularios

- Acciones importantes: targets de aproximadamente 44px o más, foco visible, orden lógico y nombres claros. Hover/active cuando apliquen, sin depender de hover para descubrir funcionalidad.
- Disabled solo cuando corresponda semánticamente; explicar el motivo cuando ayude. Loading y error pertenecen al contexto de la operación. Una imagen o etiqueta estática no necesita estados interactivos artificiales.
- Labels reales y asociados. Ayuda breve antes de introducir datos; validación útil y no agresiva mientras se escribe. Al confirmar, errores específicos cerca del campo y asociados al control; no depender solo del color.
- Conservar los datos introducidos después de un error y facilitar su corrección. En futuras operaciones, la validación definitiva, seguridad y datos comerciales se comprueban en servidor.
- Texto normal ≥4.5:1; texto grande y controles/foco esenciales ≥3:1. Sobre fotografía, revisar el recorte y cada formato usado; no asumir contraste por el aspecto general de una imagen.

## Rendimiento y evidencia

- Referencias: **LCP ≤2.5s, INP ≤200ms, CLS ≤0.1**, evaluadas al percentil 75 y separando móvil/escritorio cuando existan datos de usuarios reales. Fuente: [Core Web Vitals](https://web.dev/articles/vitals).
- Usar el laboratorio local para detectar regresiones; sus resultados no equivalen a métricas reales de usuarios. Registrar dispositivo, red y condiciones al comparar páginas migradas.
- Preferir AVIF/WebP cuando ahorren peso conservando calidad y contexto visual. JPEG/PNG siguen siendo válidos cuando convenga; no fabricar fuentes inexistentes.
- Reservar dimensiones/proporciones de imágenes. Lazy loading fuera del viewport; una imagen LCP necesita carga oportuna y puede requerir prioridad alta, comprobada en la página real.
- Evitar JS, librerías, fuentes y recursos que no aporten una función necesaria. Medir bundles e imágenes antes/después; no perseguir métricas mediante trucos que degraden la experiencia.

## Identidad y revisión

La dirección es editorial premium, cálida y gastronómica: fotografía auténtica, tipografía con personalidad, ritmo generoso, texto cercano y CTAs claros. Buscar una mesa acogedora, no una interfaz fría, corporativa, genérica o monótona. La sofisticación nace de composición, proporciones y contraste, no de una apariencia artificialmente lujosa.

Reutilizar la paleta y los componentes existentes. Añadir un recurso visual solo cuando resuelva una necesidad de contenido/legibilidad. Evaluar el conjunto en navegador y admitir ajustes de contexto sin multiplicar variantes por página. El QA técnico y la aprobación visual humana son decisiones distintas; registrar ambas con honestidad.

Una promo destacada usa media cuando ayuda a entender la invitación comercial. Elegir una fotografía relacionada, una acción principal y una nota que aclare el siguiente paso; conservar la banda simple para mensajes breves. El detalle debe aportar contexto, no beneficios, urgencia o descuentos inventados.
