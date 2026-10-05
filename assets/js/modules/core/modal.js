import Modal from "bootstrap/js/src/modal.js";

const inicializados = new WeakMap();

/** Adapta foco inicial y retorno; Bootstrap mantiene trap, Esc y backdrop. */
export function inicializarModal(elemento, { focoInicial = elemento } = {}) {
  if (!(elemento instanceof HTMLElement) || !elemento.classList.contains("modal")
    || !(focoInicial instanceof HTMLElement) || !elemento.contains(focoInicial)) {
    throw new TypeError("Se requiere modal y foco perteneciente a su contenido.");
  }
  if (inicializados.has(elemento)) return inicializados.get(elemento);
  let activador = null;
  const instancia = Modal.getOrCreateInstance(elemento);
  elemento.addEventListener("show.bs.modal", (evento) => {
    const abierto = document.querySelector(".modal.show");
    if (abierto && abierto !== elemento) {
      evento.preventDefault();
      return;
    }
    activador = evento.relatedTarget instanceof HTMLElement ? evento.relatedTarget : document.activeElement;
  });
  elemento.addEventListener("shown.bs.modal", () => focoInicial.focus());
  elemento.addEventListener("hidden.bs.modal", () => {
    if (activador instanceof HTMLElement && activador.isConnected && activador.getClientRects().length) {
      activador.focus();
    }
  });
  const control = {
    abrir(origen) {
      if (!(origen instanceof HTMLElement)) throw new TypeError("Se requiere activador existente.");
      instancia.show(origen);
    },
    cerrar() { instancia.hide(); },
  };
  inicializados.set(elemento, control);
  return control;
}
