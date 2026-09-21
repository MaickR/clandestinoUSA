<p align="center">
  <img src="./assets/images/clandestino-logo.svg" alt="The Clandestino USA" width="220">
</p>

<h1 align="center">The Clandestino USA</h1>

<p align="center">
  <em>Escape to Spain without leaving California</em>
</p>

<p align="center">
  Sitio oficial del restaurante español en Mount Shasta, CA.<br>
  Refactorización incremental del código en producción hacia una plataforma digital de reservas, Wine Shop, Wine Club y fidelización.
</p>

<p align="center">
  <a href="https://theclandestinousa.com">Sitio web</a>
  ·
  <a href="mailto:info@theclandestinousa.com">Contacto</a>
  ·
  <a href="https://wa.me/14086090027">WhatsApp</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/estado-producción-2e7d32?style=flat-square" alt="Producción">
  <img src="https://img.shields.io/badge/stack-HTML%20·%20SCSS%20·%20JS%20·%20PHP-1565c0?style=flat-square" alt="Stack">
  <img src="https://img.shields.io/badge/hosting-GoDaddy%20cPanel-546e7a?style=flat-square" alt="Hosting">
  <img src="https://img.shields.io/badge/licencia-privada-b71c1c?style=flat-square" alt="Licencia">
</p>

---

## Descripción

**The Clandestino USA** es un restaurante de tapas y vinos españoles en Mount Shasta, California. Este repositorio mantiene el sitio en producción y lo evoluciona —sobre el código propio existente, sin plantillas de terceros— hacia una experiencia de venta digital: gift cards, reservas, catálogo de vinos, Spanish Wine Club, eventos y cuentas de usuario.

| | |
|---|---|
| **Ubicación** | 211 N Mt Shasta Blvd, Mount Shasta, CA 96067 |
| **Teléfono** | +1 (408) 609-0027 |
| **Email** | info@theclandestinousa.com |
| **Web** | [theclandestinousa.com](https://theclandestinousa.com) |

---

## Stack

| Capa | Tecnología |
|------|------------|
| Marcado | HTML5 semántico (migración progresiva a PHP con partials) |
| Estilos | SCSS (patrón 7-1) + Bootstrap 5 · BEM con prefijo `cl-` |
| Scripts | JavaScript modular (ES) · componentes Bootstrap vía `data-bs-*` |
| Backend | PHP en capas (Controllers → Services → Repositories → Models) |
| Build | Gulp · Sass · PostCSS · esbuild · optimización de imágenes |
| Hosting | GoDaddy Web Hosting Deluxe (cPanel, Apache) |

> No se contempla migrar a React ni Laravel en esta fase. El trabajo parte del código ya desplegado.

---

## Inicio rápido

```bash
# Clonar e instalar
git clone https://github.com/MaickR/clandestinoUSA.git
cd clandestinoUSA
npm install

# Variables de entorno
cp .env.example .env

# Desarrollo (watch + BrowserSync)
npm run dev

# Build de assets
npm run build
```

| Comando | Descripción |
|---------|-------------|
| `npm run dev` | Compilación en watch y servidor local |
| `npm run build` | CSS, JS, imágenes y sitemap |
| `npm run lint:css` | Stylelint sobre SCSS |
| `npm run lint:js` | ESLint sobre JavaScript |

---

## Estructura

```
clandestinoUSA/
├── index.html … contact.html   # Páginas públicas actuales
├── assets/
│   ├── scss/                   # Fuente de estilos (7-1)
│   ├── css/                    # CSS compilado / legado en producción
│   ├── js/                     # Módulos JavaScript
│   └── images/                 # AVIF · WebP · originales
├── docs/                       # Estándares, mapa del sitio y briefing
├── .agents/skills/             # Procedimientos para agentes de IA
├── AGENTS.md                   # Fuente de verdad transversal para agentes
├── gulpfile.mjs                # Pipeline de assets
└── package.json
```

---

## Documentación

| Documento | Contenido |
|-----------|-----------|
| [`AGENTS.md`](./AGENTS.md) | Reglas del proyecto para cualquier agente de IA |
| [`docs/ESTANDARES-DE-CODIGO.md`](./docs/ESTANDARES-DE-CODIGO.md) | Convenciones HTML, SCSS, JS y PHP |
| [`docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md`](./docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md) | Páginas, secciones y orden de trabajo |
| [`docs/BRIEFING-PROYECTO-PARA-OTRA-IA.md`](./docs/BRIEFING-PROYECTO-PARA-OTRA-IA.md) | Contexto completo del producto |
| [`README-SETUP-AGENTES.md`](./README-SETUP-AGENTES.md) | Configuración del entorno de agentes |

---

## Principios de desarrollo

1. **Simplicidad primero** — la solución más simple que cumple el objetivo.
2. **Cambios quirúrgicos** — tocar solo lo que la tarea requiere.
3. **Sin asunciones silenciosas** — aclarar ambigüedades antes de codificar.
4. **Criterio de éxito** — cada cambio debe poder verificarse en navegador o con un comando concreto.

Convenciones clave: documentation y código en **español**; texto visible al usuario en **inglés**; CSS BEM `cl-bloque__elemento--modificador`; commits Conventional Commits; Git Flow (`main` / `develop` / `feature/…`).

---

## Horarios

| Día | Horario |
|-----|---------|
| Lunes – Martes | Cerrado (SWC y eventos especiales) |
| Miércoles | 1:00 PM – 7:00 PM |
| Jueves – Sábado | 1:00 PM – 8:00 PM |
| Domingo | 1:00 PM – 7:00 PM |

---

<p align="center">
  <sub>© 2026 The Clandestino USA · Todos los derechos reservados</sub>
</p>
