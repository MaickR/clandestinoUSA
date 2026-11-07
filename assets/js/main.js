import { inicializarNavegacion } from "./modules/patterns/navegacion-global.js";
import { inicializarAcceso } from "./modules/patterns/acceso.js";
import { inicializarModal } from "./modules/core/modal.js";
import { inicializarAnclasLegacy } from "./modules/patterns/anclas-legacy.js";

// Inicialización pública optativa; no activa páginas legacy ni lógica comercial.
const pagina = document.querySelector("[data-cl-site]");
if (pagina) {
  const navegacion = inicializarNavegacion(pagina);
  const acceso = pagina.querySelector("[data-cl-acceso]");
  const abrirAcceso = pagina.querySelector("[data-cl-acceso-abrir]");
  if (acceso && abrirAcceso) {
    const modalAcceso = inicializarAcceso(acceso, abrirAcceso);
    navegacion.conectarAccesoPanel("nav-cuenta-panel", () => modalAcceso.abrir(abrirAcceso));
  }
  inicializarAnclasLegacy(pagina);
  // Demostración vacía explícita, sin proveedor comercial ni productos ficticios.
  const carrito = pagina.querySelector("[data-cl-nav-carrito]");
  const aviso = pagina.querySelector("#carrito-preview");
  if (carrito && aviso) {
    navegacion.actualizarCarrito({ unidades: 0, estado: "listo" });
    carrito.setAttribute("aria-controls", "carrito-preview");
    carrito.setAttribute("aria-haspopup", "dialog");
    carrito.setAttribute("data-bs-toggle", "modal");
    carrito.setAttribute("data-bs-target", "#carrito-preview");
    const modalCarrito = inicializarModal(aviso, { focoInicial: aviso.querySelector("button") });
    navegacion.conectarAccesoPanel("nav-carrito-panel", () => modalCarrito.abrir(carrito));
    const carritoPanel = pagina.querySelector("[data-cl-nav-carrito-panel]");
    carritoPanel?.setAttribute("aria-controls", "carrito-preview");
    carritoPanel?.setAttribute("aria-haspopup", "dialog");
  }
  // El módulo del slider se solicita únicamente si el documento contiene escenas.
  if (pagina.querySelector("[data-cl-escenas]")) {
    import("./modules/patterns/escenas-hero.js").then(({ inicializarEscenasHero }) => {
      for (const escenas of pagina.querySelectorAll("[data-cl-escenas]")) inicializarEscenasHero(escenas);
    });
  }
  // Los módulos audiovisuales se descargan solo en documentos con esta colección.
  if (pagina.querySelector("[data-cl-carrusel-media]")) {
    Promise.all([
      import("./modules/patterns/carrusel.js"),
      import("./modules/patterns/carrusel-media.js"),
    ]).then(([{ inicializarCarrusel }, { inicializarMediaCarrusel }]) => {
      for (const coleccion of pagina.querySelectorAll("[data-cl-carrusel-media]")) {
        inicializarMediaCarrusel(coleccion);
        inicializarCarrusel(coleccion);
      }
    });
  }
  if (pagina.matches(".cl-home-preview") && !matchMedia("(prefers-reduced-motion: reduce)").matches) {
    const cargarMovimiento = () => requestAnimationFrame(() => requestAnimationFrame(() => {
      if (document.hidden || matchMedia("(prefers-reduced-motion: reduce)").matches) return;
      import("./modules/patterns/movimiento-home.js")
        .then(({ inicializarMovimientoHome }) => inicializarMovimientoHome(pagina))
        .catch(error => console.warn("Motion Home GSAP no disponible; contenido visible.", error));
    }));
    // El recurso LCP y su primer frame tienen prioridad sobre el motor decorativo.
    const portada = pagina.querySelector("[data-cl-escenas] img");
    if (portada && typeof portada.decode === "function") portada.decode().then(cargarMovimiento, cargarMovimiento);
    else cargarMovimiento();
  }
}
