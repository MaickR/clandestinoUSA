import { inicializarNavegacion } from "./modules/patterns/navegacion-global.js";
import { inicializarEscenasHero } from "./modules/patterns/escenas-hero.js";
import { inicializarAcceso } from "./modules/patterns/acceso.js";
import { inicializarModal } from "./modules/core/modal.js";

// La vista previa es el único anfitrión; no activa ejemplos ni lógica comercial.
const home = document.querySelector("[data-cl-home-preview]");
if (home) {
  const navegacion = inicializarNavegacion(home);
  inicializarAcceso(home.querySelector("[data-cl-acceso]"), home.querySelector("[data-cl-acceso-abrir]"));
  // Demostración vacía explícita, sin proveedor comercial ni productos ficticios.
  const carrito = home.querySelector("[data-cl-nav-carrito]");
  navegacion.actualizarCarrito({ unidades: 0, estado: "listo" });
  carrito.setAttribute("aria-controls", "carrito-preview");
  carrito.setAttribute("aria-haspopup", "dialog");
  carrito.setAttribute("data-bs-toggle", "modal");
  carrito.setAttribute("data-bs-target", "#carrito-preview");
  const aviso = home.querySelector("#carrito-preview");
  inicializarModal(aviso, { focoInicial: aviso.querySelector("button") });
  for (const escenas of home.querySelectorAll("[data-cl-escenas]")) inicializarEscenasHero(escenas);
}
