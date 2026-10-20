import { inicializarBotonCarga } from "../core/boton-carga.js";
import { validarFormulario, mostrarResultado } from "./transaccion.js";

const instancias = new WeakMap();

/** Dos etapas locales: datos y revisión. El anfitrión aporta validación/contexto/resultados. */
export function inicializarCheckout(raiz, { revisar, resultado, prepararValidacion = () => {}, alCompletar = () => {}, alInvalidar = () => {} }) {
  if (!(raiz instanceof HTMLElement) || typeof revisar !== "function" || typeof resultado !== "function") throw new TypeError("Checkout requiere raíz y callbacks.");
  if (instancias.has(raiz)) return instancias.get(raiz);
  const formulario = raiz.querySelector("form");
  const entrada = raiz.querySelector("[data-cl-checkout-entrada]");
  const revision = raiz.querySelector("[data-cl-checkout-revision]");
  const confirmar = raiz.querySelector("[data-cl-checkout-confirmar]");
  const volver = raiz.querySelector("[data-cl-checkout-volver]");
  const region = raiz.querySelector("[data-cl-checkout-resultado]");
  if (!formulario || !entrada || !revision || !confirmar || !volver || !region) throw new TypeError("Checkout incompleto.");
  const abortador = new AbortController();
  const opciones = { signal: abortador.signal };
  const carga = inicializarBotonCarga(confirmar);
  let ocupado = false;
  let terminado = false;
  let revisionActual = false;
  let temporizador;

  function mostrarPaso(revisando, enfocar = true) {
    revisionActual = revisando;
    entrada.hidden = revisando;
    revision.hidden = !revisando;
    for (const nodo of raiz.querySelectorAll("[data-cl-checkout-paso]")) {
      if (nodo.dataset.clCheckoutPaso === (revisando ? "revision" : "datos")) nodo.setAttribute("aria-current", "step");
      else nodo.removeAttribute("aria-current");
    }
    if (enfocar) (revisando ? revision : entrada).querySelector("[tabindex='-1']")?.focus();
  }
  function invalidar() {
    const anterior = ocupado || terminado || revisionActual;
    clearTimeout(temporizador);
    ocupado = false; terminado = false;
    carga.establecerCarga(false); volver.disabled = false; confirmar.disabled = false;
    if (revisionActual) mostrarPaso(false, revision.contains(document.activeElement));
    if (anterior) mostrarResultado(region, "Review needed", "Your details are preserved. Review the current selection before continuing.");
    alInvalidar();
  }
  for (const tipo of ["input", "change"]) formulario.addEventListener(tipo, () => {
    if (ocupado || terminado || revisionActual) invalidar();
    else alInvalidar();
  }, opciones);
  formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();
    if (ocupado || revisionActual) return;
    prepararValidacion();
    if (!validarFormulario(formulario)) {
      mostrarResultado(region, "Check your details", "Correct the highlighted fields. Your other entries are preserved.", "error");
      return;
    }
    if (!revisar()) return;
    terminado = false;
    confirmar.disabled = false;
    mostrarResultado(region, "Ready to review · demo", "Check the details below. This preview cannot create a commercial operation.");
    mostrarPaso(true);
  }, opciones);
  volver.addEventListener("click", () => {
    if (ocupado) return;
    invalidar(); mostrarPaso(false);
  }, opciones);
  confirmar.addEventListener("click", () => {
    if (ocupado || terminado || !revisionActual) return;
    prepararValidacion();
    if (!validarFormulario(formulario)) { mostrarPaso(false); validarFormulario(formulario); return; }
    if (!revisar()) return;
    ocupado = true;
    carga.establecerCarga(true);
    volver.disabled = true;
    mostrarResultado(region, "Processing demonstration…", "No payment, booking or message is sent.");
    temporizador = window.setTimeout(() => {
      ocupado = false;
      carga.establecerCarga(false);
      volver.disabled = false;
      const respuesta = resultado();
      terminado = respuesta.repetible !== true;
      confirmar.disabled = terminado;
      mostrarResultado(region, respuesta.titulo, respuesta.mensaje, respuesta.variante || "informacion");
      region.focus();
      alCompletar(respuesta);
    }, 600);
  }, opciones);
  const api = {
    invalidar,
    destruir() { clearTimeout(temporizador); abortador.abort(); instancias.delete(raiz); },
  };
  instancias.set(raiz, api);
  return api;
}
