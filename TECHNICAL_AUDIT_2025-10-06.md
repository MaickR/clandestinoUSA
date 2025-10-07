# The Clandestino USA — Auditoría técnica y de experiencia (2025-10-06)

> Informe elaborado para ti como desarrollador principal del proyecto. El objetivo es darte una fotografía realista del estado actual del código, priorizar riesgos y proponerte mejoras accionables en ciclos de trabajo.

## Resumen ejecutivo

### Valoración general
- **Experiencia de marca muy sólida:** La narrativa, la identidad visual y el tono comercial son consistentes en todas las páginas, lo que refuerza el posicionamiento premium del restaurante.
- **Frontend moderno pero pesado:** Un único paquete CSS/JS monolítico ofrece un UI cuidado, aunque penaliza el rendimiento y complica el mantenimiento.
- **Backend corto pero bien pensado:** `contact.php` aplica controles de seguridad relevantes (CSRF, rate limiting, scoring anti-spam), pero requiere endurecer la configuración y mejorar la observabilidad.
- **Higiene operativa en construcción:** No existen pruebas automatizadas, linters ni pipelines de despliegue. El tooling (PostCSS + PurgeCSS) está medio integrado y puede eliminar clases dinámicas críticas.

### Riesgos críticos a atajar primero
1. **Sobrecarga de assets y tiempos de bloqueo:** `assets/css/style.css` (>8k líneas) y `assets/js/script.js` (>1,2k líneas) se entregan en todas las páginas, aunque muchas no consumen galerías ni formularios. Esto afecta FCP y Core Web Vitals.
2. **Configuración sensible embebida:** Constantes de email/SMTP hardcodeadas en `contact.php` dificultan separar entornos y exponen credenciales si el repo se comparte.
3. **Huecos en datos estructurados:** Varias páginas (`menu.html`, `tapas.html`, `wines.html`, `hampers.html`) contienen bloques JSON-LD vacíos; Google los trata como schema inválido y puede descartar rich snippets.
4. **Riesgo de regresión en accesibilidad:** Carouseles y módulos interactivos dependen de librerías externas, pero carecen de manejo robusto de foco y anuncios `aria-live`. Se necesita un plan de pruebas sistemático.

### Plan de choque
- **0–2 semanas (estabilizar):**
  - Modulariza CSS y JS por tipo de página y carga bajo demanda los módulos pesados (reservas, galerías, Swiper testimonios).
  - Externaliza las credenciales de correo en variables de entorno y configura rotación de logs en servidor.
  - Completa o elimina los JSON-LD vacíos; valida el resultado con Google Rich Results Test.
  - Documenta el protocolo de pruebas manuales de accesibilidad (orden de foco, contraste, `prefers-reduced-motion`).
- **3–6 semanas (optimizar):**
  - Introduce un bundler moderno (Vite/Rollup) para hacer tree-shaking, code splitting y hashing de assets.
  - Añade pruebas automatizadas (Playwright para smoke flows, PHPUnit para `contact.php`).
  - Define presupuestos de rendimiento y ejecútalos en CI con Lighthouse CI.
- **6+ semanas (elevar):**
  - Migra el envío de correos a un proveedor transaccional (Postmark, Mailgun) con registros y webhooks.
  - Prepara la infraestructura para contenido bilingüe (ES/EN) y un sistema de microcopy reutilizable.
  - Automatiza reportes de SEO/SEM (Search Console, tagging de conversiones) para marketing.

---

## Fotografía general del proyecto

| Área | Observaciones claves |
| --- | --- |
| **Stack del repo** | Sitio estático multipágina con HTML+CSS+JS compartidos. Paquetes centralizados (`assets/css/style.css`, `assets/js/script.js`) y scripts específicos (`wines.js`, `hampers.js`). Backend limitado a `contact.php`. Build con PostCSS + PurgeCSS + CSSNano. |
| **Cobertura de contenido** | Landing principal y páginas temáticas (`about`, `menu`, `tapas`, `wines`, `swc`, `hampers`, `contact`, `policies`, `terms`, `links`, `offline`). Amplio uso de imágenes en JPG/WebP/AVIF. |
| **Herramientas de desarrollo** | `package.json` tiene estructura inválida (faltan comas/cierre en scripts). No hay linters ni formateadores configurados. PurgeCSS se ejecuta sin distinguir entornos y puede eliminar clases necesarias. |
| **Dependencias externas** | Swiper 6.8.4, Ionicons, jQuery (legacy para SWC), Magnific Popup, Isotope, Splitting.js. Se cargan desde CDN sin Subresource Integrity (SRI). |
| **Analítica** | Google Tag Manager presente. No se observa banner de consentimiento ni adaptación a Consent Mode. |

---

## Auditoría frontend

### HTML y semántica
**Fortalezas**
- Todas las páginas definen `lang="en"` y viewport coherentes.
- Las páginas de contacto y legales incluyen skip links y landmarks semánticos, mejorando la navegación con lector de pantalla.
- Uso extensivo de microdatos (`itemscope`, `itemtype`) que aportan contexto de negocio a motores de búsqueda.

**Brechas y oportunidades**
- **Bloques JSON-LD vacíos** en `menu.html`, `tapas.html`, `wines.html`, `hampers.html`: mejor eliminarlos o completarlos con datos reales.
- Jerarquía de encabezados inconsistente (varios `h1` por hero o tarjetas). Limita a un `h1` real y usa `aria-level` si el diseño exige varias cabeceras grandes.
- Imágenes decorativas con `alt="shape"` o `alt=""` sin `role="presentation"`. Marca explícitamente las decorativas para reducir ruido a lectores.
- Múltiples secciones repiten patrones `div.container`; encapsular esos layouts en parciales/templating reduciría duplicidad.

### Arquitectura CSS
**Fortalezas**
- Tokens de diseño centralizados (`:root`) para paleta, tipografías fluidas y espaciados.
- Uso de `clamp()` para tipografía responsiva avanzada.
- Formularios con estados visuales accesibles (errores/success contrastados, focus visible).

**Brechas y oportunidades**
- `style.css` supera las 8k líneas. Divide por contexto o adopta CSS por página (imports condicionales) para reducir bloqueo.
- La safelist de PurgeCSS usa regex como `/aria-/` que no coinciden con las clases reales; revisa la configuración para no eliminar clases dinámicas (`is-open`, `swiper-slide-active`).
- Faltan source maps: habilítalos en entornos de desarrollo para depurar.
- Unifica criterio de nomenclatura (BEM, utilidades) para evitar mezclar `kf-`, `clandestino-` y nombres largos sin patrón.

### JavaScript: calidad y rendimiento
**Fortalezas**
- `script.js` está en strict mode, usa IIFEs y helpers de selección seguros.
- Lógica de formularios con debounce, caché en localStorage y validaciones defensivas.
- Coordinación clara entre estados del backend (`error`, `success`) y mensajes en la UI.

**Brechas y oportunidades**
- Paquete único para todo el sitio. Convierte funcionalidades en ES modules y carga condicionalmente según página.
- Dependencias legacy: `sw.js` usa jQuery solo para el carrusel de SWC. Migra a inicialización nativa de Swiper o empaqueta jQuery solo para esa vista.
- Algunos scripts CDN carecen de `async/defer`. Revisa cada inclusión para no bloquear el parser.
- No hay telemetría ante errores JS. Integra Sentry o similar, especialmente para formularios críticos.
- Configura ESLint + Prettier para evitar estilos inconsistentes y detectar código muerto.

### Accesibilidad (A11y) y WAI-ARIA
**Fortalezas**
- Skip link funcional y feedback accesible (`aria-live`) en el formulario de contacto.
- Iconografía con `aria-label` adecuado en la mayoría de casos.

**Brechas y oportunidades**
- Añade `role="group"`, `aria-roledescription="carousel"` y navegación por teclado en Swiper (paginations focusables, `aria-live="polite"`).
- El preloader debería marcar `aria-busy` o `role="status"` y ofrecer una vía rápida para saltarlo.
- Evita handlers `onclick` sobre `div`; usa `<button>` con `keydown` para accesibilidad full.
- Revisa contraste de dorados sobre fondos oscuros (objetivo WCAG AA 4.5:1) y ofrece variantes alto-contraste si fuera necesario.
- Respeta `prefers-reduced-motion` en parallax y animaciones automáticas.

### Rendimiento y estrategia de assets
- **Imágenes:** Gran trabajo con `loading="lazy"` y formatos AVIF/WebP. Implementa `<picture>` en héroes para servir el formato óptimo según navegador.
- **Caching:** Genera nombres versionados (`style.[hash].css`) para permitir cache busting sin invalidar todo el CDN.
- **Servicio mal nombrado:** `sw.js` en realidad es un inicializador Swiper. Renómbralo (`swc-carousel.js`) para evitar confusión con service workers.
- **CSS crítico:** Evalúa inlining parcial del CSS above-the-fold en `index.html` y difiere el resto.
- **Fuentes:** Considera autoalojar Libre Bodoni / Playfair y usar `font-display: swap`.

### SEO/SEM
- Metadatos extensivos (title, description, OG, Twitter) ya implementados.
- `robots.txt` y `sitemap.xml` operativos.
- **Acciones sugeridas:**
  - Depura keywords repetidas para evitar keyword stuffing; adapta long tails al mercado local (Mount Shasta, Spanish tapas, wine club).
  - Completa schema de menús (`Menu`, `MenuSection`, `MenuItem`) con datos reales.
  - Publica FAQs en JSON-LD para capturar cajas de preguntas frecuentes.
  - Monitoriza Core Web Vitals (CLS, LCP, INP) desde Search Console y define objetivos internos.

---

## Auditoría backend e infraestructura

### `contact.php`
**Aciertos**
- Controles de seguridad completos: CSRF, rate limiting por IP, scoring anti-spam, honeypots y control de payload.
- Helper `respond()` centraliza respuestas HTTP y JSON coherentes.
- Logging enriquecido (IP/UA) y guardado de correos fallidos para seguimiento manual.

**Puntos de mejora**
- Sustituye constantes de correo por variables de entorno (`MAIL_TO_ADDRESS`, `MAIL_FROM_ADDRESS`, etc.). Facilitará staging/producción.
- Considera usar SDK de un proveedor transaccional para mejorar entregabilidad y métricas.
- Los logs residen en `sys_get_temp_dir()`: garantiza permisos, rota archivos y limpia históricos.
- Valida números telefónicos con una librería fiable (libphonenumber) y normaliza formato internacional en emails.
- El rate limiting basado en archivos no escala en despliegues con varios nodos. Evalúa Redis o base de datos ligera.
- Añade pruebas automatizadas para scoring, validaciones y manejo de errores.

### Seguridad y privacidad
- GTM activo sin banner de cookies ni consentimiento explícito. Evalúa cumplimiento CCPA/CPRA y, si abres mercado UE, GDPR.
- El header `Content-Security-Policy: default-src 'self'` bloquea scripts externos (incluido GTM). Ajusta la política o migra a CSP mediante meta-tag bien configurado.
- HSTS ya se envía; verifica que todas las URLs canónicas estén en HTTPS.
- Publica `/.well-known/security.txt` para canalizar reportes de vulnerabilidades.
- Mantén el allowlist de `subject` sincronizado con las opciones del frontend (y piensa en localización futura).

---

## Construcción, despliegue y tooling
- Corrige `package.json` (estructura JSON válida) e incorpora scripts: `lint`, `format`, `test`, `build`.
- Añade `.nvmrc` o `.node-version` para fijar la versión de Node usada en builds.
- Automatiza el build de PostCSS y empaquetado en CI (GitHub Actions) y anexa reportes Lighthouse como artefactos.
- Documenta en `README` el flujo local (`npm install`, `npm run build`, `php -S localhost:8000` para testear `contact.php`).
- Evalúa migrar a un generador estático (Astro, Eleventy) o al menos plantillas parciales para gestionar componentes repetidos.

---

## Contenido e internacionalización
- Narrativa potente, pero solo en inglés. Prepara archivos de contenido (JSON/YAML) para habilitar versión en español.
- Verifica coherencia de horarios, teléfono y dirección en todas las páginas y en schema.
- Ofrece versiones imprimibles de menús mediante CSS específico (`@media print`).

---

## Testing y garantía de calidad
- Actualmente sin automatización. Recomendado:
  - **Unit tests:** lógica de utilidades JS (`utils.js`) y helpers PHP.
  - **Integration/UI tests:** Flujos críticos (reserva, contacto, Wine Club) con Playwright.
  - **Accesibilidad:** axe-core CLI o Pa11y integrados en CI.
  - **Performance:** Lighthouse CI + WebPageTest para escenarios reales.
- Documenta un checklist QA manual (navegadores, dispositivos, teclado, lector de pantalla, reduced motion).

---

## Observabilidad y analítica
- Define eventos GA4 (envíos de formulario, clics de teléfono, CTA de reservas) y comprueba que se empujan al `dataLayer`.
- Centraliza logs de `contact.php` en un servicio gestionado (Logtail, Papertrail) para monitorizar fallos a distancia.
- Implementa monitorización de uptime (Pingdom/UptimeRobot) y alertas ante respuestas 5xx del endpoint.

---

## Recomendaciones priorizadas

### Quick wins (esta semana)
1. Reparar `package.json` y añadir scripts básicos (`lint`, `format`, `test`).
2. Eliminar o completar los JSON-LD vacíos.
3. Renombrar `sw.js` y cargarlo solo donde se usa.
4. Añadir `aria-roledescription="carousel"` y mejorar el control por teclado en el Swiper de testimonios.

### Corto plazo (este mes)
1. Dividir bundles CSS/JS y habilitar code splitting con Vite/Rollup.
2. Externalizar configuración de correo y adoptar un proveedor transaccional.
3. Configurar ESLint/Prettier/Stylelint con pre-commits (`lint-staged`).
4. Incorporar Lighthouse CI y axe-core a la revisión de PRs.

### Estratégico (próximo trimestre)
1. Adoptar arquitectura basada en componentes/parciales (Astro/Eleventy) para mantener contenido y datos de menú.
2. Desplegar versión bilingüe y enriquecer SEO dinámico (schema por ítem del menú).
3. Automatizar dashboards (Search Console API, GA4) para medir SEO/SEM.
4. Valorar un headless CMS (Contentful, Sanity) que dé autonomía al equipo comercial.

---

## Apéndice A — Herramientas recomendadas
- **Rendimiento:** Lighthouse CI, WebPageTest, Calibre.
- **Accesibilidad:** axe DevTools, Pa11y CI, tota11y.
- **Seguridad:** Mozilla Observatory, SecurityHeaders.com, OWASP Zap para el formulario.
- **SEO:** Screaming Frog, Ahrefs Site Audit, APIs de Search Console.
- **Monitorización:** Sentry (frontend), Logtail/Papertrail (PHP), UptimeRobot.
- **Localización:** Phrase o Lokalise para gestionar traducciones.

---

## Apéndice B — Estándares de código sugeridos
- Adopta convenciones consistentes (`kebab-case` para clases CSS, `camelCase` en JS).
- Define `.editorconfig` con espaciado, codificación UTF-8 y salto de línea final.
- Añade TypeScript o, al menos, JSDoc en módulos JS complejos (precio de reserva) para ganar mantenibilidad.
- Documenta en el README el contrato API entre frontend y backend (`success`, `error`, `errorMessage`).

---

*Preparado para: Equipo de desarrollo de The Clandestino USA — 2025-10-06*
