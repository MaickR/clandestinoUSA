<div align="center">
  
  ![GitHub repo size](https://img.shields.io/github/repo-size/MaickR/clandestinoUSA)
  ![GitHub stars](https://img.shields.io/github/stars/MaickR/clandestinoUSA?style=social)
  ![GitHub forks](https://img.shields.io/github/forks/MaickR/clandestinoUSA?style=social)
  ![GitHub last commit](https://img.shields.io/github/last-commit/MaickR/clandestinoUSA)
  ![GitHub issues](https://img.shields.io/github/issues/MaickR/clandestinoUSA)

  <br />
  <br />

  <img src="./assets/images/clandestino-logo.svg" alt="The Clandestino USA Logo" width="200" />

  <h1 align="center">The Clandestino USA</h1>
  <h3 align="center">🍷 Authentic Spanish Tapas Bar & Wine Experience 🍷</h3>

  <p align="center">
    Sitio web oficial del restaurante español The Clandestino USA<br />
    Experiencia gastronómica auténtica en Mount Shasta, California
  </p>

  <a href="https://theclandestinousa.com"><strong>➥ Visitar Sitio Web</strong></a>

</div>

<br />

## 📋 Tabla de Contenidos

- [Acerca del Proyecto](#-acerca-del-proyecto)
- [Características](#-características)
- [Tecnologías](#-tecnologías)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Instalación](#-instalación)
- [Uso](#-uso)
- [Responsive Design](#-responsive-design)
- [SEO y Performance](#-seo-y-performance)
- [Changelog](#-changelog)
- [Contribuir](#-contribuir)
- [Licencia](#-licencia)
- [Contacto](#-contacto)

---

## 🎯 Acerca del Proyecto

**The Clandestino USA** es un restaurante español de tapas, vinos y productos artesanales ubicado en Mount Shasta, California. Este repositorio contiene el código fuente del sitio web oficial, diseñado para ofrecer una experiencia digital elegante que refleja la autenticidad y calidad de la cocina española.

### ✨ Características Principales

- 🍷 **Catálogo de Vinos**: Selección curada de vinos españoles premium
- 🥘 **Menú de Tapas**: Tapas auténticas y productos artesanales
- 🎁 **Gift Hampers**: Cestas de regalo personalizadas
- 🍇 **Spanish Wine Club**: Programa exclusivo de membresía
- 📅 **Sistema de Reservas**: Integración con WhatsApp para reservas
- 📱 **100% Responsive**: Optimizado para todos los dispositivos
- 🌐 **SEO Optimizado**: Schema.org markup completo
- ♿ **Accesibilidad**: ARIA labels y navegación por teclado
- 🚀 **Performance**: Lazy loading, AVIF/WebP, preloading

---

## 🛠️ Tecnologías

### Frontend
- **HTML5** - Semántico y accesible
- **CSS3** - Variables custom, Grid, Flexbox, Animations
- **JavaScript ES6+** - Vanilla JS y jQuery
- **Responsive Design** - Mobile-first approach

### Librerías y Frameworks
- [jQuery 3.6.4](https://jquery.com/) - DOM manipulation
- [Magnific Popup](https://dimsemenov.com/plugins/magnific-popup/) - Lightbox para galería
- [jQuery Paroller](https://github.com/tgomilar/paroller.js) - Parallax effects
- [Isotope](https://isotope.metafizzy.co/) - Grid filtering
- [Ionicons](https://ionic.io/ionicons) - Icon system
- [Font Awesome](https://fontawesome.com/) - Additional icons

### Herramientas de Desarrollo
- **Node.js** - Entorno de ejecución
- **npm** - Gestión de paquetes
- **Git** - Control de versiones
- **VS Code** - Editor de código

### Integraciones
- **Google Tag Manager** - Analytics
- **Schema.org** - Structured data
- **Open Graph** - Social media sharing
- **WhatsApp Business API** - Reservas y contacto
- **Google Maps** - Ubicación

---

## 📁 Estructura del Proyecto

```
clandestinoUSA/
├── assets/
│   ├── css/
│   │   ├── style.css           # Estilos principales (~8,400 líneas)
│   │   ├── style.min.css       # CSS minificado
│   │   └── faq-styles.css      # Estilos FAQ
│   ├── js/
│   │   ├── script.js           # JavaScript principal (~1,900 líneas)
│   │   ├── gallery.js          # Galería de imágenes
│   │   ├── hampers.js          # Catálogo hampers dinámico
│   │   ├── wines.js            # Catálogo de vinos
│   │   ├── tapas.js            # Catálogo de tapas
│   │   └── swc-carousel.js     # Carrusel Wine Club
│   ├── images/
│   │   ├── avif/               # Imágenes AVIF optimizadas
│   │   ├── webp/               # Imágenes WebP optimizadas
│   │   └── [jpg/png]           # Imágenes originales
│   └── favicon/                # Iconos multi-formato
├── index.html                  # Página principal
├── about.html                  # Sobre nosotros
├── contact.html                # Contacto y FAQ
├── menu.html                   # Menú general
├── tapas.html                  # Catálogo tapas
├── wines.html                  # Catálogo vinos
├── hampers.html                # Catálogo hampers
├── swc.html                    # Spanish Wine Club
├── policies.html               # Políticas
├── contact.php                 # Backend formulario
├── sitemap.xml                 # Sitemap SEO
├── robots.txt                  # Robots SEO
├── sw.js                       # Service Worker PWA
├── package.json                # Dependencias npm
├── CHANGELOG.md                # Registro de cambios
└── README.md                   # Este archivo
```

---

## 🚀 Instalación

### Prerrequisitos

Antes de comenzar, asegúrate de tener instalado:

- [Git](https://git-scm.com/downloads) - Control de versiones
- [Node.js](https://nodejs.org/) (v18+) - Entorno de ejecución
- [npm](https://www.npmjs.com/) (v9+) - Gestor de paquetes

### Clonar el Repositorio

**Linux y macOS:**
```bash
sudo git clone https://github.com/MaickR/clandestinoUSA.git
cd clandestinoUSA
```

**Windows:**
```bash
git clone https://github.com/MaickR/clandestinoUSA.git
cd clandestinoUSA
```

### Instalar Dependencias

```bash
npm install
```

### Configuración del Entorno

1. **Servidor Local**: Usa cualquier servidor HTTP local:
   ```bash
   # Opción 1: Live Server (VS Code extension)
   # Opción 2: http-server (npm)
   npm install -g http-server
   http-server -p 8080
   
   # Opción 3: Python
   python -m http.server 8080
   ```

2. **Variables de Entorno**: 
   - Configura Google Tag Manager ID en los archivos HTML
   - Actualiza contact.php con credenciales SMTP si es necesario

---

## 💻 Uso

### Desarrollo Local

1. Abre el proyecto en tu editor de código favorito
2. Inicia un servidor local (ver sección Instalación)
3. Navega a `http://localhost:8080` en tu navegador
4. Realiza cambios y recarga el navegador para ver actualizaciones

### Scripts Disponibles

```bash
# Iniciar servidor de desarrollo
npm start

# Validar HTML
npm run validate-html

# Optimizar imágenes (requiere configuración adicional)
npm run optimize-images
```

### Páginas Principales

- **`/`** - Homepage con hero slider y secciones principales
- **`/about.html`** - Historia del restaurante y equipo
- **`/menu.html`** - Menú general (vinos, tapas, hampers)
- **`/tapas.html`** - Catálogo completo de tapas
- **`/wines.html`** - Catálogo completo de vinos
- **`/hampers.html`** - Cestas de regalo
- **`/swc.html`** - Spanish Wine Club
- **`/contact.html`** - Formulario de contacto y FAQ

---

## 📱 Responsive Design

El sitio está optimizado para todos los tamaños de pantalla:

| Breakpoint | Rango | Dispositivos |
|------------|-------|--------------|
| **Ultra-Small** | ≤340px | Móviles muy pequeños |
| **Mobile** | 341-575px | Smartphones |
| **Tablet** | 576-767px | Tablets pequeñas |
| **Desktop** | 768-991px | Tablets grandes, laptops |
| **Large Desktop** | 992-1199px | Monitores estándar |
| **XL Desktop** | ≥1200px | Monitores grandes |

### Optimizaciones Mobile (≤320px)

- Footer centrado y compacto
- Logo reducido a 130px
- Fuentes escaladas (0.64rem - 1.1rem)
- Botones touch-friendly (min 44x44px)
- Navegación hamburger
- Imágenes lazy-load
- Grid flexible de 1-2 columnas

---

## 🔍 SEO y Performance

### SEO Features

✅ **Meta Tags Completos**
- Open Graph para redes sociales
- Twitter Cards
- Canonical URLs
- Hreflang tags preparados

✅ **Structured Data (Schema.org)**
- Restaurant
- WebPage
- Menu / MenuItem
- BreadcrumbList

✅ **Sitemap XML**
- Todas las páginas indexadas
- Prioridades configuradas
- Frecuencia de actualización

✅ **Robots.txt**
- Configurado para crawlers
- Directrices claras

### Performance

⚡ **Optimizaciones Implementadas**
- **Lazy Loading**: Imágenes y videos
- **Formatos Modernos**: AVIF, WebP con fallback JPG
- **Preload**: Recursos críticos (hero images, fonts)
- **DNS Prefetch**: CDNs externos
- **Minificación**: CSS minificado disponible
- **Compression**: Gzip/Brotli ready
- **Caching**: Headers configurados

⚡ **Lighthouse Scores** (Target)
- Performance: 90+
- Accessibility: 95+
- Best Practices: 95+
- SEO: 100

---

## 📝 Changelog

Ver el archivo [CHANGELOG.md](./CHANGELOG.md) para un historial detallado de cambios.

### Versión Actual: 1.2.0

**Últimas Actualizaciones:**
- ✨ Modal de cierre temporal con countdown
- 🖼️ Galería Magnific Popup en menu.html
- 📱 Footer optimizado para pantallas ≤320px
- ✅ Validación progresiva de formularios
- 🎯 Navegación mejorada con dropdown Contact

---

## 🤝 Contribuir

Las contribuciones son lo que hacen que la comunidad de código abierto sea un lugar increíble para aprender, inspirar y crear. Cualquier contribución que hagas será **muy apreciada**.

### Proceso de Contribución

1. **Fork** el proyecto
2. **Crea** tu rama de features (`git checkout -b feature/AmazingFeature`)
3. **Commit** tus cambios (`git commit -m 'feat: Add some AmazingFeature'`)
4. **Push** a la rama (`git push origin feature/AmazingFeature`)
5. **Abre** un Pull Request

### Estándares de Código

- **HTML**: Semántico, accesible, indentación 2 espacios
- **CSS**: BEM naming, variables CSS, mobile-first
- **JavaScript**: ES6+, comentarios JSDoc, camelCase
- **Commits**: Conventional Commits (feat, fix, docs, style, refactor)

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

**Copyright © 2025 The Clandestino USA. Todos los derechos reservados.**

---

## 📞 Contacto

### The Clandestino USA

**Dirección:**  
📍 211 N Mt Shasta Blvd  
California, US 96067

**Contacto:**  
📧 [info@theclandestinousa.com](mailto:info@theclandestinousa.com)  
📱 [+1 (408) 609-0027](tel:+14086090027)  
🌐 [theclandestinousa.com](https://theclandestinousa.com)

**Horario:**  
🕐 Lunes a Domingo: 2:00 PM - 8:00 PM

**Redes Sociales:**  
📘 [Facebook](https://www.facebook.com/profile.php?id=61559740614798)  
📸 [Instagram](https://www.instagram.com/theclandestinousa/)  
🗺️ [Google Maps](https://www.google.com/maps/place/211+N+Mt+Shasta+Blvd,+Mt+Shasta,+CA+96067,+USA)

### Desarrollador

**ByteForge**  
🔗 [GitHub Repository](https://github.com/MaickR/clandestinoUSA)  
📧 Para consultas técnicas, abre un [Issue](https://github.com/MaickR/clandestinoUSA/issues)

---

<div align="center">
  
  ### 🍷 Hecho con ❤️ y buen vino español 🍷
  
  **The Clandestino USA** - Authentic Spanish Experience in Mount Shasta
  
  <br />
  
  [![Website](https://img.shields.io/website?url=https%3A%2F%2Ftheclandestinousa.com)](https://theclandestinousa.com)
  [![Maintenance](https://img.shields.io/maintenance/yes/2025)](https://github.com/MaickR/clandestinoUSA)
  ![Version](https://img.shields.io/badge/version-1.2.0-blue)
  
</div>
