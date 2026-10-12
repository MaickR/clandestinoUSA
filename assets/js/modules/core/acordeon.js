import Collapse from "bootstrap/js/src/collapse.js";

/** La Data API de Bootstrap conserva el teclado nativo y aria-expanded. */
export function inicializarAcordeon(panel) {
  if (!(panel instanceof HTMLElement) || !panel.classList.contains("collapse")) {
    throw new TypeError("Se requiere un panel Collapse existente.");
  }
  return Collapse.getOrCreateInstance(panel, { toggle: false });
}
