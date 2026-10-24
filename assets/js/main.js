import { inicializarNavegacion } from "./modules/patterns/navegacion-global.js";
import { inicializarAcceso } from "./modules/patterns/acceso.js";
import { inicializarModal } from "./modules/core/modal.js";

// Inicialización pública optativa; no activa páginas legacy ni lógica comercial.
const pagina = document.querySelector("[data-cl-site]");
if (pagina) {
  const navegacion = inicializarNavegacion(pagina);
  inicializarAcceso(pagina.querySelector("[data-cl-acceso]"), pagina.querySelector("[data-cl-acceso-abrir]"));
  // Demostración vacía explícita, sin proveedor comercial ni productos ficticios.
  const carrito = pagina.querySelector("[data-cl-nav-carrito]");
  const aviso = pagina.querySelector("#carrito-preview");
  if (carrito && aviso) {
    navegacion.actualizarCarrito({ unidades: 0, estado: "listo" });
    carrito.setAttribute("aria-controls", "carrito-preview");
    carrito.setAttribute("aria-haspopup", "dialog");
    carrito.setAttribute("data-bs-toggle", "modal");
    carrito.setAttribute("data-bs-target", "#carrito-preview");
    inicializarModal(aviso, { focoInicial: aviso.querySelector("button") });
  }
  // El módulo del slider se solicita únicamente si el documento contiene escenas.
  if (pagina.querySelector("[data-cl-escenas]")) {
    import("./modules/patterns/escenas-hero.js").then(({ inicializarEscenasHero }) => {
      for (const escenas of pagina.querySelectorAll("[data-cl-escenas]")) inicializarEscenasHero(escenas);
    });
  }
}
