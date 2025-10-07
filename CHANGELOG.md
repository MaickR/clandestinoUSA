# 📋 Registro de Cambios - The Clandestino USA

Todos los cambios notables en este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/),
y este proyecto adhiere al [Versionado Semántico](https://semver.org/lang/es/).

---

## [1.2.0] - 2025-10-07

### 🎨 Mejoras de Diseño Responsivo

#### Footer Optimizado para Pantallas Ultra-Pequeñas (≤320px)
- **Centrado perfecto** de todos los elementos dentro de `.footer-brand`
- **Logo**: Reducido a 130px con centrado triple (margin auto + flexbox + text-align)
- **Textos**: 
  - Tamaño de fuente optimizado (0.75rem para address y contact-links)
  - Max-width de 280px para evitar líneas excesivamente largas
  - Line-height mejorado (1.3rem) para mejor legibilidad
  - Word-break en emails para prevenir overflow horizontal
- **Botón CTA**: 
  - Tamaño reducido y centrado (max-width: 240px)
  - Padding balanceado (11px vertical, 16px horizontal)
  - Fuente de 0.72rem para mejor ajuste
- **Separadores decorativos**: Reducidos de 18px a 16px
- **Listas de navegación**: 
  - Grid de 2 columnas centradas
  - Links con tamaño de 0.66rem
  - Max-width de 300px para mejor agrupación
- **Copyright**: Fuente reducida a 0.64rem con padding lateral
- **Layout general**: Convertido de grid a block para alineación vertical simple

#### Prevención de Desbordamiento
- Padding lateral reducido en `.footer.section` (8px)
- Todos los elementos con `margin-inline: auto` para centrado automático
- Eliminación de scroll horizontal en dispositivos de 320px o menos

---

## [1.1.0] - 2025-10-07

### ✨ Nuevas Funcionalidades

#### Modal de Cierre Temporal
- **Sistema de anuncio** de cierre temporal del restaurante
- **Countdown timer** en tiempo real hasta el 19 de octubre de 2025, 2:00 PM
- **Componentes del modal**:
  - Logo del restaurante centrado
  - Título: "Sourcing Excellence from Spain"
  - Subtítulo: "Seasonal Harvest Trip"
  - Descripción del viaje de aprovisionamiento
  - Contador regresivo con 4 unidades (Días:Horas:Minutos:Segundos)
  - Botón de WhatsApp con mensaje personalizado casual
- **Comportamiento**:
  - Aparece automáticamente después del preloader (solo en `index.html`)
  - Auto-cierre después de 20 segundos
  - Cierre manual con botón X o clic en overlay
  - Animación de entrada suave (fade + slide)
- **Responsive design**:
  - Adaptación completa para desktop (base)
  - Tablet (768px): números 3.2rem, gaps 1rem
  - Mobile (480px): números 2.4rem, gaps 0.5rem, unidades 4.5rem
  - Countdown horizontal en todas las resoluciones (flex-wrap: nowrap)

#### Galería de Imágenes con Modal (Menu.html)
- **Integración de Magnific Popup** para visualización de imágenes de productos
- **Funcionalidad implementada**:
  - Click en imagen de producto abre modal con vista ampliada
  - Galería navegable con flechas Previous/Next
  - Contador de imágenes (X of Y)
  - Soporte para teclado (ESC para cerrar, flechas para navegar)
  - Títulos descriptivos desde atributos alt
- **Productos con popup**:
  - **Wines** (3): Adaro, Mystic, Evoluzion
  - **Tapas** (3): Serrano Ham, Chorizo Sticks, Cheese Manchego
  - **Hampers** (3): Classic Hamper, Premium Selection, Artisan's Choice
- **Implementación técnica**:
  - Envoltorio de imágenes con `<a class="has-popup-image">`
  - Inicialización JavaScript en `script.js` (función `initMenuGallery()`)
  - Delay de 500ms para asegurar carga de jQuery y plugin
  - Configuración: type: 'image', gallery enabled, animations: mfp-fade

### 🔧 Mejoras Técnicas

#### Navegación Mejorada
- **Dropdown "Contact"** con submenú:
  - Contact Form (ancla a `#contact-form`)
  - FAQ (ancla a `#faq`)
- **Implementación**: Aplicada en las 9 páginas del sitio
  - index.html, about.html, contact.html, menu.html
  - tapas.html, wines.html, hampers.html, swc.html, policies.html
- **Estructura HTML**: Sistema `.has-submenu` / `.submenu` con JavaScript handlers existentes

#### Validación de Formulario de Contacto
- **Sistema de validación progresiva** sin errores prematuros
- **Tracking de interacción**: Objeto `touchedFields` para rastrear campos tocados
- **Lógica implementada**:
  - Errores solo se muestran después de `blur` en el campo
  - Validación silenciosa para habilitar/deshabilitar botón submit
  - Flag `formSubmitted` para mostrar todos los errores al enviar
- **Función principal**: `initClandestinoContactForm()` en `script.js`
- **Métodos**:
  - `validateField(fieldName, showError=true)`: Validación individual
  - `checkFormCompleteness()`: Validación sin UI (para botón)
  - Event listeners en `blur` para marcar campos como touched
- **Seguridad mejorada**:
  - CSRF token con timestamp
  - Mejor manejo de errores JSON en respuesta del servidor

#### Organización de Código
- **Externalización JavaScript**: 
  - ~400 líneas de JS inline movidas de `contact.html` a `script.js`
  - Mejor mantenibilidad y separación de concerns
  - Reducción de peso de HTML
  - Facilita debugging y testing

### 🐛 Correcciones

#### CSS
- **Eliminación de caracteres nulos** al final de `style.css`
- **Corrección de lint error** (at-rule or selector expected)
- **Validación sin errores** en todo el proyecto

#### JavaScript
- **Countdown timer**: Ajuste de separadores con margin-top negativos para alineación perfecta
- **Modal initialization**: Verificación de pathname para evitar ejecución en páginas incorrectas

---

## [1.0.0] - 2025-10-07

### 🎉 Lanzamiento Inicial

#### Estructura del Proyecto
- **9 páginas HTML completas**:
  - `index.html` - Página principal con hero slider
  - `about.html` - Historia y equipo
  - `contact.html` - Formulario de contacto y FAQ
  - `menu.html` - Menú general (vinos, tapas, hampers)
  - `tapas.html` - Catálogo de tapas
  - `wines.html` - Catálogo de vinos
  - `hampers.html` - Catálogo de hampers/cestas regalo
  - `swc.html` - Spanish Wine Club
  - `policies.html` - Políticas y términos

#### Sistema de Diseño
- **CSS personalizado** (`assets/css/style.css` - ~8,400 líneas)
- **Tipografías**:
  - Libre Bodoni (serif elegante)
  - Playfair Display (títulos dramáticos)
  - Merienda (decorativa)
  - Roboto (cuerpo)
  - Oswald (condensada)
- **Variables CSS**: Sistema de colores, tipografías y espaciados
- **Animaciones**: Keyframes para sliders, hover effects, parallax

#### Componentes Principales
- **Preloader**: Spinner con logo y barra de progreso
- **Header**: Logo, navegación responsive, botón CTA
- **Topbar**: Dirección, horarios, teléfono, email con schema.org
- **Hero Slider**: Carrusel con imágenes de alta calidad
- **Secciones**:
  - Services grid
  - About con imágenes
  - Menu showcase
  - Events calendar
  - Testimonials carousel
  - Reservation CTA
  - Footer con newsletter

#### JavaScript Funcional
- **`script.js`** (~1,900 líneas):
  - Preloader con progreso simulado
  - Navegación móvil (toggle, overlay)
  - Slider hero con auto-play
  - Back to top button
  - Parallax effects
  - Form handlers
  - Smooth scrolling
- **Scripts específicos**:
  - `hampers.js` - Generación dinámica de productos
  - `gallery.js` - Lightbox de imágenes
  - `wines.js` - Catálogo de vinos
  - `tapas.js` - Catálogo de tapas

#### Assets e Imágenes
- **Estructura de carpetas**:
  - `assets/images/` - Imágenes originales (JPG/PNG)
  - `assets/images/avif/` - Imágenes optimizadas AVIF
  - `assets/images/webp/` - Imágenes optimizadas WebP
- **Iconos**: Ionicons v5.5.2 CDN
- **Favicon**: Múltiples tamaños y formatos (SVG, PNG, ICO)

#### SEO y Accesibilidad
- **Meta tags completos**: Open Graph, Twitter Cards
- **Schema.org markup**: Restaurant, WebPage, Menu, MenuItem, BreadcrumbList
- **Canonical URLs**: En todas las páginas
- **Hreflang**: Soporte multiidioma preparado
- **Sitemap.xml**: Generado
- **Robots.txt**: Configurado
- **ARIA labels**: En componentes interactivos
- **Skip links**: Para accesibilidad de teclado

#### Integraciones
- **Google Tag Manager**: Configurado (GTM-MVF7WM94)
- **WhatsApp Business**: Links directos con mensajes pre-formateados
- **Google Maps**: Integración de ubicación
- **Redes Sociales**: Facebook, Instagram
- **Email**: Formulario de contacto con PHP backend

#### Librerías Externas
- **jQuery 3.6.4**: Manipulación DOM
- **Bootstrap 3.4.1**: Grid system (parcial)
- **Magnific Popup 1.1.0**: Lightbox
- **jQuery Paroller 1.4.6**: Parallax effects
- **Font Awesome 5.15.4**: Iconos adicionales
- **Isotope 3.0.6**: Filtrado de grid (hampers)
- **imagesLoaded 4.1.4**: Detección de carga de imágenes
- **Splitting.js**: Efectos de texto

#### Responsive Design
- **Breakpoints principales**:
  - Mobile: 0-575px
  - Tablet: 576-767px
  - Desktop: 768-991px
  - Large Desktop: 992-1199px
  - XL Desktop: 1200px+
  - Ultra-small: ≤340px (añadido en v1.2.0)

#### Performance
- **Lazy loading**: Imágenes con `loading="lazy"`
- **DNS prefetch**: Para CDNs externos
- **Preconnect**: A dominios críticos
- **Preload**: Imágenes hero
- **Formatos modernos**: AVIF y WebP con fallback
- **Minificación**: CSS minificado disponible

---

## 📝 Notas de Desarrollo

### Tecnologías Utilizadas
- HTML5 semántico
- CSS3 con variables custom
- JavaScript Vanilla ES6+
- jQuery 3.x
- PHP (backend de formularios)
- Node.js/npm (gestión de dependencias)

### Compatibilidad de Navegadores
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Opera 76+
- Dispositivos móviles iOS 13+ y Android 10+

### Entorno de Desarrollo
- Editor: VS Code
- Control de versiones: Git
- Repositorio: GitHub (MaickR/clandestinoUSA)
- Node.js: v18+
- npm: v9+

---

## 🎯 Próximas Mejoras Planeadas

### Corto Plazo
- [ ] Sistema de reservas online integrado
- [ ] Formulario de membresía al Wine Club
- [ ] Blog de noticias y eventos
- [ ] Galería de fotos expandida
- [ ] Testimonios con sistema de calificación

### Mediano Plazo
- [ ] Multi-idioma (inglés/español completo)
- [ ] Integración con redes sociales (feed de Instagram)
- [ ] Sistema de pedidos online
- [ ] Newsletter con MailChimp/SendGrid
- [ ] Analytics dashboard personalizado

### Largo Plazo
- [ ] App móvil (PWA)
- [ ] Sistema de fidelización
- [ ] Programa de referidos
- [ ] Integración con POS
- [ ] AR para visualizar productos

---

## 📞 Contacto y Soporte

**The Clandestino USA**  
211 N Mt Shasta Blvd, California, US 96067  
📧 info@theclandestinousa.com  
📱 +1 (408) 609-0027  
🌐 [theclandestinousa.com](https://theclandestinousa.com)

---

**Desarrollado con ❤️ por ByteForge**  
© 2025 The Clandestino USA. Todos los derechos reservados.
