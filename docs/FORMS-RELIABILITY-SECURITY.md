# Phase R1 — Fiabilidad y seguridad de formularios

Fecha de revisión: 2026-11-03 (America/Bogota). Rama: `feature/forms-reliability-security`, creada desde `origin/develop` actualizado, base `27b621eef82bf8ad534c729607c960bab67c8565`.

Implementación y revisión final local de H04/H05/H06/H13 para publicación de la rama y PR manual hacia develop. Sin creación automática de PR, merge ni deploy. No se enviaron correos reales. La evidencia histórica de `HOME-TECHNICAL-AUDIT.md` permanece íntegra. H01/H02/H03 y la publicación de Home siguen fuera del alcance.

## Defectos y estado

| Hallazgo | Causa confirmada | Corrección y estado R1 |
| --- | --- | --- |
| H04 | Cada handler exigía aceptación de tres envíos independientes y terminaba al primer fallo. Una copia rechazada devolvía 502 aunque el principal ya se hubiera aceptado. No existía trazabilidad segura. | **Corrección local verificada.** Éxito respecto del destinatario principal; fallos de copias registrados sin error general ni invitación a reenviar. Si el principal falla en HTML y en la alternativa de texto, no se envían copias y se responde 502. Recepción real pendiente. |
| H05 | Regex más comparación con el día del servidor; `strtotime()` normalizaba fechas imposibles al construir el correo. | **Corrección local verificada.** `DateTimeImmutable`, errores/advertencias, round-trip exacto y `America/Los_Angeles`. Fecha y hora sin recortar espacios; días pasados rechazados y día actual permitido. |
| H06 | Tokens generados en cliente, nunca verificados. Origen/referer solo sumaban puntuación y se comparaban con `HTTP_HOST`. | **Corrección local verificada.** Token aleatorio ligado a sesión, comparación `hash_equals`, rechazo 403 y origen complementario estricto. Integración real Apache/Cloudflare pendiente. |
| H13 | `clean()` escapaba antes de validar y se escapaba otra vez al construir HTML; el texto plano heredaba entidades. También saneaba silenciosamente emails y nombres. | **Corrección local verificada.** Entradas de tipo/codificación válidos, normalización mínima con `trim` donde corresponde, validación posterior y escaping solo en HTML. Texto plano conserva caracteres legibles. |

Una respuesta satisfactoria indica aceptación por el transporte para el destinatario principal, **no entrega en bandeja de entrada ni reserva confirmada**. El contrato de PHP distingue esos conceptos: [manual de mail()](https://www.php.net/manual/en/function.mail.php). La reserva sigue pendiente de confirmación por el negocio.

## Flujo y decisiones

### Correo

- Principal operativo: `ntcusa@nicolastena.com`.
- Copia pública: `info@theclandestinousa.com`; existe además un destinatario interno ya configurado en los handlers, cuya dirección no se añade a interfaces, respuestas ni logs.
- Se conservan envíos individuales y la alternativa de texto plano existente cuando falla el intento HTML. Un intento aceptado no se repite para ese destinatario.
- Principal rechazado en ambos intentos: 502, `success:false`, `error:send`, alternativas de teléfono/correo; ninguna copia procesada.
- Principal aceptado: 200, `success:true`, `message`, incluso si una o ambas copias fallan. Se intentan ambas copias aunque la primera falle.
- Logs `[formularios]`: identificador aleatorio común, formulario, rol, aceptación y uso de alternativa de texto. Sin nombre, email del visitante, teléfono, mensaje, token, IP ni direcciones de destinatarios. No se registra el error crudo de transporte.
- Asunto y nombre fijo del remitente codificados para cabeceras MIME UTF-8; cuerpo declarado UTF-8/8bit; `Reply-To` usa solamente el email validado. Se mantiene la prohibición CR/LF en campos de cabecera.

### Calendario

`fechaSolicitudReserva()` recibe opcionalmente un reloj inyectado para pruebas, sin interruptores de reloj ni de correo en producción. Comprueba formato exacto, calendario real, advertencias y round-trip de fecha/hora. No utiliza `strtotime()` para normalizar entradas. Referencia: [DateTimeImmutable::createFromFormat](https://www.php.net/manual/en/datetimeimmutable.createfromformat.php).

Se compara con las 00:00 del día civil en `America/Los_Angeles`, incluso si el servidor o visitante están en otra zona. Hoy permanece permitido aunque la hora elegida ya haya pasado: el formulario es una solicitud, no un motor de disponibilidad. Se conservan los enums de horas y grupos existentes; no se añaden cierres por día de semana, capacidad ni reglas de atención. Las horas permitidas existentes (16:00–19:30) no caen en los intervalos ambiguos/inexistentes de DST.

El calendario/estimador legacy conserva su comportamiento previo, incluida su ventana inicial de dos días y sus indicaciones locales de disponibilidad. R1 no certifica esas indicaciones como disponibilidad real ni cambia sus reglas comerciales.

### Sesión, CSRF y origen

- `form-token.php`: GET del mismo sitio, token de 32 bytes de `random_bytes`, representado en 64 caracteres hexadecimales. Sin CORS permisivo; respuesta privada y `no-store`.
- Token estable durante la sesión: funciona entre pestañas, con Back y tras un envío. No se genera mediante JavaScript ni se guarda en URL/localStorage/sessionStorage.
- Ambos POST exigen el token de esa sesión. Ausente, vacío, incorrecto, array o de otra sesión: 403 antes de antispam/correo. POST vacío conserva el 400 previo, sin efectos.
- Sesión `clx_forms`, modo estricto, solo cookies, sin trans-SID, cookie host-only, `HttpOnly`, `SameSite=Lax`, `Secure` en hosting. La excepción HTTP solo existe en PHP built-in y loopback.
- Orígenes HTTPS explícitos: dominio canónico y www. Host, esquema y puerto se validan como origen completo; esquemas/puertos ajenos, `null`, sufijos maliciosos, credenciales en URL y orígenes con ruta se rechazan. Origin y Referer presentes deben ser válidos; `Sec-Fetch-Site: cross-site` se rechaza.
- Cabeceras Origin/Referer ausentes se admiten con token válido: conserva navegación convencional y políticas de privacidad. No sustituyen el token.
- No se usa `HTTP_HOST`, `X-Forwarded-Host`, `X-Forwarded-Proto` ni `CF-Visitor` para autorizar el origen o rebajar `Secure`. Los orígenes HTTP locales se limitan al puerto del servidor PHP built-in y al puerto fijo 3000 de BrowserSync (`gulpfile.mjs`), siempre con una lista fija de loopback y exclusivamente en PHP built-in.
- Errores de sesión/token producen un error genérico sin detalles técnicos ni correo. `display_errors` se desactiva en este flujo.

Referencia del patrón de token sincronizado y defensa adicional de origen: [OWASP CSRF Prevention](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html).

### Compatibilidad del frontend

Apache reescribe internamente solo `/contact.html` a `contact-page.php`, **después** de las reglas canónicas existentes. El wrapper lee el mismo documento e inserta únicamente el token en el hidden ya existente; no cambia URL, estilos ni composición. Acceso directo al wrapper devuelve 404. Esto permite POST convencional sin JavaScript, que conserva su respuesta JSON. El router local reproduce esa asociación; su funcionamiento en Apache real aún requiere ensayo.

Con JavaScript, `forms-security.js` obtiene un token vigente justo antes del POST y conserva su valor por defecto tras `reset()`. El contacto cancela los otros listeners de envío legacy y reutiliza la API existente para limpiar errores tras el éxito. Se retiran únicamente los generadores de tokens locales y se permite el nombre Unicode con signos en la validación legacy. Autofill no se bloquea por rapidez aislada.

En `index.html` se añade únicamente un campo oculto, la carga del helper y la preparación del envío/manejo de resultado incierto. No hay cambios en el markup visual de Home. La reserva ya depende del calendario JavaScript; no se introduce un formulario alternativo ni un rediseño.

Si no puede prepararse la sesión, el mensaje indica que no se envió la solicitud. Si el POST pudo llegar pero la conexión, timeout o JSON impiden conocer el resultado, se conserva el formulario y se pide llamar antes de reenviar. No hay reintentos automáticos. Una desconexión tras aceptación sigue siendo operativamente incierta; R1 no añade persistencia ni idempotencia durable.

## Archivos

| Archivos | Responsabilidad |
| --- | --- |
| `contact.php`, `reservation.php` | Integración localizada de seguridad, validación y notificación; mismas claves JSON. |
| `includes/formularios.php` | Sesión/token/origen, validación de forma del POST, calendario y correo compartidos. Elimina duplicación real de seguridad y envío de ambos handlers, sin MVC ni framework. |
| `form-token.php`, `assets/js/forms-security.js` | Bootstrap de token para el flujo AJAX actual. |
| `contact-page.php`, `.htaccess` | Token insertado en el documento de contacto para navegación convencional. |
| `contact.html`, `index.html`, `assets/js/script.js` | Conexión del token, un único envío y feedback coherente; sin cambios visuales de componentes. |
| `eslint.config.mjs` | Incluye el nuevo helper JS en el lint, sin incorporar todo el legacy. |
| `scripts/probar-formularios.mjs`, `scripts/probar-fechas-formularios.php`, `scripts/fixtures/forms-router.php` | Suite, reloj determinista y transporte local simulado, respectivamente. |
| `docs/ARQUITECTURA.md`, este documento | Contrato actualizado y evidencia de R1. |

## Pruebas reproducibles

Desde la raíz, con PHP 8 + mbstring y Node existentes, sin instalar dependencias:

```powershell
node scripts/probar-formularios.mjs
php scripts/probar-fechas-formularios.php
node scripts/probar-carrito.mjs
node scripts/probar-cierre-comercio.mjs
npm run lint
npm run build
php -l contact.php
php -l reservation.php
php -l form-token.php
php -l contact-page.php
php -l includes/formularios.php
php -l scripts/fixtures/forms-router.php
php -l scripts/probar-fechas-formularios.php
git diff --check
```

Resultado final: **126 comprobaciones**, incluidas 27 de calendario/sesión, cinco del helper cliente y 14 sobre los listeners reales de contacto/reserva con DOM/transporte/reloj simulados. Pasan las dos suites Node previas, lint JS/SCSS, build y PHP lint (PHP local 8.3.14). Se comprobaron también los partials PHP existentes. Ninguna dependencia añadida.

La suite crea un directorio temporal exclusivo para sesiones, throttle y captura de correo; arranca PHP con `disable_functions=mail` y reemplaza la función únicamente en el router de QA. Si la función nativa sigue habilitada, el router devuelve 503 y no ejecuta handlers. El código de producción no tiene modo de correo simulado seleccionable por entorno/HTTP. El temporal se limpia al terminar la suite normal.

Cobertura positiva y negativa:

| Grupo | Evidencia automatizada |
| --- | --- |
| Solicitudes | Contacto y reserva legítimos, hoy en zona del negocio, contratos `success/message/error/errorMessage`, 200/400/403/405/422/429/502; GET/PUT de handlers rechazados. |
| Fechas | Imposibles, bisiestos, año cero, mes/día cero o fuera de rango, pasado, sufijos/espacios, hora 24:00; medianoche UTC/Los Angeles, salto primaveral y retorno de otoño, offsets -07:00/-08:00. Cero correo ante fecha inválida. |
| CSRF/origen | Ausente, vacío, incorrecto, otra sesión, legítimo, token entre pestañas; origen ajeno/null, esquema/puerto/sufijo malicioso, Referer ajeno, Host/proxy manipulados, Fetch Metadata cross-site. Sin cabeceras de origen con token válido y POST convencional de contacto funcionan. |
| Correo | Aceptación completa; rechazo total; principal fallido aunque copias pudieran aceptar; una o ambas copias fallidas con éxito general; alternativa de texto plano. No se omite la última copia por fallo de la primera. |
| Encoding | Ampersand, comillas, apóstrofes, nombre con signos, español, japonés y emoji; HTML escapado una vez y texto plano fiel. Payload script/img inactivo; CR/LF de cabecera, UTF-8 inválido, arrays y arrays anidados rechazados. |
| Antispam | Honeypot y spam combinado devuelven éxito ficticio sin correo; time-trap expirado; autofill rápido y timestamp ausente aislado no bloquean; segundo envío inmediato devuelve 429 sin otra notificación. Se conservan blocklist, scoring y límites existentes. |
| Fallos de bootstrap | Rechazo HTTP del token, token no ligado al formato servidor, JSON roto y fallo de red rechazan la preparación. Logs correlacionados sin datos personales innecesarios. |

### Revisión local con navegador

```powershell
node scripts/probar-formularios.mjs --serve
```

El proceso imprime una URL loopback con puerto libre y la ruta de `modo.txt`. Abrir `/contact.html`, `/index.html#reservation` y `/home-preview.php`. Para finalizar, Ctrl+C. El proceso de QA debe detenerse también si se cierra externamente la terminal.

`modo.txt` admite `all`, `total-failure`, `primary-failure`, `copy-failure`, `copies-failure`, `fallback`, `token-failure`, `helper-failure`, `invalid-json` e `invalid-contract`. Cambiarlo afecta exclusivamente al stub. Para pruebas sucesivas respetar el throttle (20 s; cuatro solicitudes/15 min) o reiniciar la suite. Usar datos ficticios `.invalid`.

Pruebas manuales realizadas:

- Contacto con `Zoë O’Neil & Ana`, ampersand/comillas/Unicode: éxito visible y una sola secuencia de tres notificaciones simuladas.
- Reserva completada con el calendario y selectores originales, envío mediante teclado: 200 y solicitud pendiente de confirmación visible.
- Copia pública rechazada: contacto conserva resultado satisfactorio; captura del stub con principal aceptado, dos intentos rechazados de copia y destinatario interno aceptado.
- Fallo total: reserva muestra alternativas de contacto y conserva los datos. No hay notificaciones secundarias.
- JSON roto después de aceptación: contacto muestra resultado desconocido y pide llamar antes de reenviar; sin repetición automática.
- Formularios a 390/768/1280 px: sin overflow horizontal; foco avanza de nombre a email con Tab. Un H1 por documento; no se cambian campos visibles ni sus labels/atributos de accesibilidad.
- Consola consultada en contacto, reserva y Home Preview: sin errores/warnings relevantes al flujo observado.

### Integridad y QA visual

Directorio externo de evidencia local:

`C:/Users/Mike/.codex/visualizations/2026/11/03/01a1a07e-60c3-7e03-a258-de5266cb32f2/forms-r1/`

`integridad.json` demuestra que el HTML visible de `contact.html` e `index.html` coincide con la base al excluir scripts/campo oculto y líneas vacías; el resto de `script.js`, fuera de los IIFE del contacto, es idéntico. `home-preview.php`, partials existentes, SCSS, CSS y recursos gráficos versionados no tienen diferencias. Los tres informes previos siguen sin seguimiento y con sus hashes originales.

Se verificó explícitamente la integridad de Header, Hero, Discovery, Pure Soul, Private Experiences, Guest Stories, C8, Wine Club, Gifting, Visit y Footer. `responsive.json` recoge sus secciones presentes, cero imágenes rotas observadas, H1 único y ausencia de overflow a 390/768/1280; también contiene las métricas de los formularios. Las capturas de formularios por ancho complementan esa evidencia. Capturas exploratorias tomadas durante scroll/fade o con otra dimensión efectiva no se usan como aprobación visual.

| Punto de QA | Resultado y límite |
| --- | --- |
| Anchos / overflow | PASS 390, 768 y 1280 px en Home Preview y ambos formularios. |
| Teclado / foco | PASS recorrido local nombre→email y envío con Enter. Sin cambios en estilos de foco; no se recertifica todo el teclado legacy. |
| Layout / recursos | Fuentes visuales y recursos intactos; H1 único, secciones presentes y cero imágenes rotas observadas. |
| Contraste / accesibilidad integral | Sin cambios de color, estilos o componentes. No se declara una nueva auditoría WCAG completa ni se cierran defectos legacy ajenos a R1. |
| Consola | Sin errores/warnings relevantes en las observaciones del flujo. |

La comprobación de integridad y QA técnica no sustituyen la aprobación humana final de las interfaces.

Al finalizar se detuvo el servidor de QA y se restauró el viewport. La revisión automática bloqueó la limpieza recursiva de `C:/Users/Mike/AppData/Local/Temp/clx-forms-qa-prPnFW` con el motivo `blocked by policy`; ese temporal aislado permanece fuera del repositorio. No se volvió a intentar su eliminación. `browser-mail-results.json` conserva únicamente los roles/resultados simulados, y `contact-confirmed-partial.jpg` muestra la confirmación visible con una copia fallida.

## Configuración y validación operativa pendiente

1. GoDaddy/cPanel: PHP 8 compatible, mbstring, sesiones de archivo con directorio privado/escribible y cookies habilitadas; `session.auto_start=0`, `display_errors=Off`, `log_errors=On`. Verificar límites de ejecución y `post_max_size` con formularios reales.
2. Apache: `mod_rewrite`/AllowOverride deben aplicar la nueva asociación de contacto, conservando los redirects canónicos. Ensayar URL canónica/www, HTTPS, query strings, GET de contacto y POST de ambos handlers. El servidor built-in reproduce la asociación, pero **no ejecuta .htaccess**; Apache real no está certificado localmente.
3. Cloudflare: HTTPS público y conexión al origen con TLS validado, sin cachear `form-token.php`, handlers ni el contacto con sesión, y sin eliminar Set-Cookie. Comprobar cookies `Secure; HttpOnly; SameSite=Lax`, host-only y ausencia de tokens compartidos entre visitantes. No habilitar caché de todo el HTML por encima de `no-store`.
4. No habilitar orígenes cPanel temporales ni proxies mediante cabeceras arbitrarias. Cualquier dominio nuevo requiere configuración explícita y prueba. No cambiar los redirects/proxy existentes como parte de R1.
5. El throttle existente utiliza `REMOTE_ADDR`, no cabeceras Cloudflare. Detrás del proxy, revisar IP efectiva para evitar límites compartidos; no confiar sin configuración en `CF-Connecting-IP`/X-Forwarded-For. La sincronización concurrente de los ficheros de throttle no se rediseña en R1.
6. Correo: comprobar disponibilidad/política de `mail()`, remitente/envelope, SPF, DKIM, DMARC, límites y logs del MTA. Confirmar por prueba **expresamente autorizada** recepción en principal/copias, carpeta spam, Unicode, asunto, Reply-To y respuesta del negocio. No se han probado entrega real, rebotes ni disponibilidad de buzones.
7. Proteger/rotar el log de PHP fuera del webroot y comprobar que roles/correlación permiten diagnosticar fallos parciales. No publicar informes, pruebas, router, temporales ni herramientas de desarrollo.
8. Una caída posterior a la aceptación del transporte sigue sin garantizar conocimiento del resultado por el navegador. No existe almacenamiento durable ni reserva confirmada; el feedback evita el reenvío ciego, pero no garantiza deduplicación ante recarga o envío manual repetido.

R1 queda lista para revisión técnica local. Los cuatro defectos tienen corrección y evidencia reproducible; sus validaciones operativas indicadas permanecen pendientes y no autorizan activar servicios ni publicar Home.

## Revisión final y cierre controlado

Se revisaron los 16 archivos de R1 completos contra la base de develop, incluyendo los cambios acotados dentro del JS legacy minificado. El código anterior y posterior a los IIFE del contacto permanece idéntico. Los tres informes locales no rastreados conservan sus hashes y se excluyen del commit. No cambian dependencias, destinatarios de producción, secretos, recursos gráficos, estilos ni componentes de Home; los datos ficticios están exclusivamente en las pruebas y en ejemplos de esta documentación.

La revisión corrigió tres caminos de error de H04/H06 sin ampliar el alcance:

- El contacto mantiene el timeout hasta terminar de leer y validar el JSON; una respuesta con cabeceras recibidas pero cuerpo bloqueado termina como resultado incierto.
- La reserva captura también la ausencia del helper CSRF; el botón se recupera, se conservan los datos y no se hace POST del formulario.
- Ambos formularios exigen `success` booleano y no aceptan un resultado positivo con HTTP de error. Un JSON malformado o un contrato como `success:"false"` no muestra éxito ni provoca reintentos automáticos.

Los 14 escenarios nuevos ejecutan el listener real extraído de cada documento: aceptado, fallo total, helper ausente, JSON roto, contrato inválido, HTTP de error con éxito contradictorio y cuerpo bloqueado hasta timeout. Comprueban mensaje, una sola solicitud como máximo, conservación/reinicio de datos, recuperación del botón y cancelación final del temporizador.

| Clasificación | Resultado final y límites |
| --- | --- |
| **Validado localmente** | PHP/session/cookies mediante HTTP y CLI; token desde los formularios reales y comprobación en los handlers; contactos/reservas con correo simulado; estados de aceptación, fallo parcial, fallo total y resultado incierto; calendario de Los Angeles con DST automático; contratos, encoding, antispam, lint/build/suites y diff. |
| **Pendiente de GoDaddy** | Ejecución efectiva de `.htaccess` bajo Apache, PHP/extensiones/permisos reales, cookies Secure bajo HTTPS/Cloudflare, reglas de caché, IP efectiva y entrega/spam/rebotes/Reply-To por prueba real autorizada. No hay certificación de entrega ni autorización de deploy. |
| **Reutilizable para futuras reservas** | Validación calendárica con reloj inyectable y zona explícita; separación validación/escaping; patrón CSRF ligado a sesión; interpretación de aceptación de transporte y logs sin contenido personal. Se pueden adaptar estos fundamentos al nuevo contrato; no se crea ahora ese sistema. |
| **Específico del legacy** | Wrapper de `/contact.html`, IDs/campos/listeners/modales actuales, enums de horas/grupos, honeypots/scoring/throttle y lista fija de destinatarios/orígenes. El calendario/estimador local no constituye disponibilidad del restaurante. No se presenta esta integración como API comercial general. |

El horario vigente **Tuesday–Sunday, 4:00 PM–8:00 PM** permanece intacto. El servidor no lo convierte en restricción de reservas: durante QA se aceptó una solicitud pendiente para el lunes 30 de noviembre de 2026. Los slots ya existentes siguen siendo 16:00–19:30; no se añade un slot, bloqueo por lunes ni regla de capacidad. Ningún mensaje afirma una mesa confirmada.

Evidencia nueva de cierre (fuera del repositorio): `C:/Users/Mike/.codex/visualizations/2026/11/03/01a1a07e-60c3-7e03-a258-de5266cb32f2/forms-r1-final/`. Se repitieron en navegador el contacto válido, fallo total de contacto con datos conservados, reserva con copia fallida y texto pendiente de confirmación, fallo de carga del helper de reserva sin correos ni bloqueo del botón y contrato de respuesta inválido sin ventana de éxito. La suite utiliza los documentos y handlers reales; solo el transporte y los fallos intencionales del router son simulados.
