<p align="center">
  <img src="./assets/images/clandestino-logo.svg" alt="The Clandestino USA" width="280">
</p>

<h1 align="center">🍷 The Clandestino USA</h1>

<p align="center">
  <strong>Auténtica experiencia gastronómica española en Mount Shasta, California</strong>
</p>

<p align="center">
  <a href="https://theclandestinousa.com">🌐 Sitio Web</a> •
  <a href="https://wa.me/14086090027">💬 WhatsApp</a> •
  <a href="mailto:info@theclandestinousa.com">📧 Email</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Estado-Producción-brightgreen?style=flat-square" alt="Estado">
  <img src="https://img.shields.io/badge/Versión-2.0.0-blue?style=flat-square" alt="Versión">
  <img src="https://img.shields.io/badge/Licencia-Privada-red?style=flat-square" alt="Licencia">
  <img src="https://img.shields.io/badge/Última_Actualización-Enero_2026-purple?style=flat-square" alt="Actualización">
</p>

---

## 📋 Descripción

**The Clandestino USA** es un restaurante de tapas españolas auténticas ubicado en el corazón de Mount Shasta, California. Este repositorio contiene el sitio web oficial, desarrollado con tecnologías web modernas optimizadas para rendimiento, SEO y accesibilidad.

### ✨ Características Principales

- 🎨 **Diseño Elegante** — Interfaz sofisticada inspirada en la hospitalidad española
- ⚡ **Alto Rendimiento** — Imágenes AVIF/WebP, lazy loading, preconnect optimizado
- 🔍 **SEO Avanzado** — Schema.org JSON-LD, Open Graph, sitemap con imágenes
- ♿ **Accesibilidad** — WAI-ARIA completo, skip links, landmarks semánticos
- 📱 **Responsive** — Adaptación perfecta a todos los dispositivos
- 🔒 **Seguridad** — CSP, HSTS, Permissions-Policy, headers de seguridad

---

## 🕐 Horarios de Atención

| Día | Horario | Notas |
|-----|---------|-------|
| **Lunes** | Cerrado | Solo SWC & Eventos Especiales |
| **Martes** | Cerrado | Solo SWC & Eventos Especiales |
| **Miércoles** | 1:00 PM - 7:00 PM | — |
| **Jueves** | 1:00 PM - 8:00 PM | — |
| **Viernes** | 1:00 PM - 8:00 PM | — |
| **Sábado** | 1:00 PM - 8:00 PM | — |
| **Domingo** | 1:00 PM - 7:00 PM | — |

> 📍 **Ubicación:** 211 N Mt Shasta Blvd, Mount Shasta, CA 96067

---

## 🛠️ Stack Tecnológico

```
Frontend           Optimización        Servidor
─────────────────  ─────────────────   ─────────────────
HTML5 Semántico    AVIF/WebP Images    Apache + cPanel
CSS3 Custom        Lazy Loading        SSL/TLS (Let's Encrypt)
Vanilla JavaScript  Preconnect/DNS     GoDaddy Hosting
Swiper.js          Minificación CSS    
Ionicons 5.5       fetchpriority
```

---

## 📁 Estructura del Proyecto

```
clandestinoUSA/
├── 📄 index.html          # Página principal
├── 📄 menu.html           # Carta y menús
├── 📄 wines.html          # Catálogo de vinos
├── 📄 tapas.html          # Menú de tapas
├── 📄 hampers.html        # Cestas gourmet
├── 📄 swc.html            # Spanish Wine Club
├── 📄 about.html          # Sobre nosotros
├── 📄 contact.html        # Contacto y FAQ
├── 📄 links.html          # Enlaces sociales
├── 📄 policies.html       # Políticas
├── 📄 terms.html          # Términos de servicio
├── 📄 offline.html        # Página offline
├── 📄 sitemap.xml         # Sitemap con imágenes
├── 📄 robots.txt          # Directivas de crawlers
├── 📄 .htaccess           # Configuración Apache
│
├── 📂 assets/
│   ├── 📂 css/
│   │   ├── style.css      # Estilos principales
│   │   └── style.min.css  # Versión minificada
│   │
│   ├── 📂 js/
│   │   ├── script.js      # JavaScript principal
│   │   ├── preloader.js   # Animación de carga
│   │   └── ...            # Módulos específicos
│   │
│   ├── 📂 images/
│   │   ├── 📂 avif/       # Imágenes AVIF (óptimo)
│   │   ├── 📂 webp/       # Imágenes WebP (fallback)
│   │   └── 📂 gallery/    # Galería fotográfica
│   │
│   └── 📂 favicon/        # Iconos y manifest
│
└── 📄 package.json        # Configuración npm
```

---

## 🚀 Registro de Cambios — Enero 2026

### 🆕 Versión 2.0.0 — *28 de Enero, 2026*

#### 📅 Actualización de Horarios
- ✅ **Nuevos horarios implementados** en todos los archivos HTML
- ✅ Lunes y Martes: Exclusivo para miembros del Spanish Wine Club y eventos especiales
- ✅ Miércoles y Domingo: 1:00 PM - 7:00 PM
- ✅ Jueves a Sábado: 1:00 PM - 8:00 PM
- ✅ JSON-LD Schema.org actualizado con `openingHoursSpecification` detallado

#### 🔍 Optimizaciones SEO
- ✅ **sitemap.xml** recreado — Eliminados duplicados corruptos, añadida extensión `image:image`
- ✅ **robots.txt** mejorado — Reglas específicas por crawler, bloqueo de bad bots
- ✅ **JSON-LD** actualizado — `dateModified` a 2026-01-28
- ✅ **Open Graph** actualizado — `og:updated_time` sincronizado

#### ⚡ Mejoras de Rendimiento
- ✅ **Preload AVIF** — Cambio de JPG a AVIF en imágenes críticas (50% menos peso)
- ✅ **Preconnect** añadidos — Google Tag Manager, fonts.googleapis.com
- ✅ **sw.js eliminado** — Archivo legacy sin uso removido

#### 🔒 Seguridad Reforzada
- ✅ **Content-Security-Policy** implementado — Compatible con GTM, Fonts, Swiper, Ionicons
- ✅ **Permissions-Policy** añadido — Bloqueo de geolocation, microphone, camera, FLoC

#### 📅 Mantenimiento General
- ✅ **Copyright actualizado** — 2025 → 2026 en todos los archivos HTML
- ✅ **FAQ actualizado** — Nuevos horarios reflejados en preguntas frecuentes

---

### 📊 Historial de Versiones Anteriores

| Versión | Fecha | Cambios Principales |
|---------|-------|---------------------|
| 1.9.x | Dic 2025 | Auditoría de precios, corrección de productos |
| 1.8.x | Nov 2025 | Optimización de imágenes AVIF |
| 1.7.x | Oct 2025 | Auditoría técnica completa |
| 1.6.x | Sep 2025 | Implementación de JSON-LD Schema |

---

## 🧪 Auditoría Técnica

### Puntuación Lighthouse (Enero 2026)

| Métrica | Puntuación | Estado |
|---------|------------|--------|
| Performance | 92+ | 🟢 Excelente |
| Accessibility | 95+ | 🟢 Excelente |
| Best Practices | 100 | 🟢 Perfecto |
| SEO | 100 | 🟢 Perfecto |

### Validaciones
- ✅ HTML5 válido (W3C Validator)
- ✅ CSS3 válido (W3C CSS Validator)
- ✅ Schema.org válido (Google Rich Results Test)
- ✅ Open Graph válido (Facebook Debugger)

---

## 🔧 Configuración del Servidor

### Headers de Seguridad (.htaccess)

```apache
# Seguridad implementada
✓ Strict-Transport-Security (HSTS)
✓ X-Content-Type-Options: nosniff
✓ X-Frame-Options: SAMEORIGIN
✓ Referrer-Policy: strict-origin-when-cross-origin
✓ Content-Security-Policy (CSP completo)
✓ Permissions-Policy
```

### Caché Configurado

| Tipo de Archivo | TTL |
|-----------------|-----|
| HTML/PHP | Sin caché |
| CSS/JS | 7 días |
| Imágenes | 6 meses |
| Fuentes | 6 meses (immutable) |

---

## 📞 Contacto

<table>
  <tr>
    <td align="center">📍</td>
    <td><strong>Dirección</strong><br>211 N Mt Shasta Blvd<br>Mount Shasta, CA 96067</td>
  </tr>
  <tr>
    <td align="center">📞</td>
    <td><strong>Teléfono</strong><br>+1 (408) 609-0027</td>
  </tr>
  <tr>
    <td align="center">📧</td>
    <td><strong>Email</strong><br>info@theclandestinousa.com</td>
  </tr>
  <tr>
    <td align="center">🌐</td>
    <td><strong>Web</strong><br>https://theclandestinousa.com</td>
  </tr>
</table>

---

## 👨‍💻 Desarrollo

**Desarrollado por:** ByteForge  
**Mantenimiento:** Equipo The Clandestino USA

---

<p align="center">
  <sub>© 2026 The Clandestino USA. Todos los derechos reservados.</sub>
</p>
