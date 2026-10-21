import { inicializarBotonCarga } from "../core/boton-carga.js";
import { mostrarResultado } from "./transaccion.js";

const instancias = new WeakMap();
const mensajes = {
  aplicado: ["Demo code applied", "The synthetic discount is included in every connected summary."],
  invalido: ["Code not recognized · demo", "Check the example code and try again. Your cart is preserved."],
  expirado: ["Code expired · demo", "This synthetic code is outside its example validity period."],
  "no-elegible": ["Code not eligible · demo", "DEMO10 requires a valid example selection of at least $50. This check did not change any existing discount."],
  "ya-aplicado": ["Code already applied", "Your example discount is already included. It has not been applied twice."],
  "otro-codigo-activo": ["One code per order", "Remove your current example code before applying a different one."],
  "ya-canjeado": ["Already redeemed by this customer · demo", "This synthetic campaign allows one redemption per verified customer. No customer history was checked."],
  error: ["Code could not be checked · demo", "Your selection and any existing discount are preserved. Try Apply again."],
  retirado: ["Demo code removed", "Every connected summary now shows the amount without that discount."],
};

/** Disclosure promocional; el anfitrión valida y el carrito conserva la única autoridad local. */
export function inicializarPromocion(raiz, { consultar, resumen, aplicar, quitar }) {
  if (instancias.has(raiz)) return instancias.get(raiz);
  const formulario = raiz.querySelector("form");
  const campo = raiz.querySelector("input");
  const boton = raiz.querySelector("[data-cl-promo-aplicar]");
  const retirar = raiz.querySelector("[data-cl-promo-quitar]");
  const region = raiz.querySelector("[data-cl-promo-mensaje]");
  const etiqueta = raiz.querySelector("[data-cl-promo-estado]");
  const aplicada = raiz.querySelector("[data-cl-promo-aplicada]");
  if (![formulario, campo, boton, retirar, region, etiqueta, aplicada].every(Boolean) || typeof consultar !== "function") throw new TypeError("Promoción incompleta.");
  const eventos = new AbortController();
  const opciones = { signal: eventos.signal };
  const carga = inicializarBotonCarga(boton);
  let peticion = null;
  let versionConsulta = null;
  let ultimoEstado = resumen().promocionEstado;
  function cancelar() {
    peticion?.abort(); peticion = null;
    carga.establecerCarga(false); campo.readOnly = false;
  }
  function avisar(estado) {
    etiqueta.textContent = estado === "aplicado" ? "Applied · synthetic discount" : "Example code";
    campo.setAttribute("aria-invalid", String(["invalido", "expirado", "no-elegible"].includes(estado)));
    mostrarResultado(region, ...mensajes[estado], estado === "aplicado" ? "exito" : estado === "error" ? "error" : "informacion");
  }
  formulario.addEventListener("submit", async (evento) => {
    evento.preventDefault();
    if (peticion) return;
    const codigo = campo.value.trim().toUpperCase();
    if (!codigo) { campo.setAttribute("aria-invalid", "true"); mostrarResultado(region, "Enter an example code", "Use a demo code to explore this field.", "error"); campo.focus(); return; }
    if (resumen().codigo === codigo) { avisar("ya-aplicado"); return; }
    const solicitud = new AbortController();
    peticion = solicitud; versionConsulta = resumen().version;
    carga.establecerCarga(true); campo.readOnly = true;
    etiqueta.textContent = "Checking example code…";
    mostrarResultado(region, "Checking code…", "Local preview only. No promotion service is contacted.");
    try {
      const respuesta = await consultar(codigo, resumen(), { signal: solicitud.signal });
      if (solicitud.signal.aborted || resumen().version !== versionConsulta) return;
      cancelar();
      const estado = respuesta.estado === "aplicado" ? aplicar(respuesta.descuento) : respuesta.estado;
      if (!mensajes[estado]) throw new TypeError("Resultado promocional desconocido.");
      avisar(estado);
    } catch {
      if (solicitud.signal.aborted) return;
      cancelar();
      avisar("error");
    }
  }, opciones);
  campo.addEventListener("input", () => {
    campo.removeAttribute("aria-invalid");
    etiqueta.textContent = campo.value.trim() ? "Ready to apply · demo" : "No code entered";
  }, opciones);
  retirar.addEventListener("click", () => { cancelar(); quitar(); avisar("retirado"); campo.focus(); }, opciones);
  const api = {
    actualizar(datos) {
      if (peticion && versionConsulta !== datos.version) {
        cancelar();
        mostrarResultado(region, "Selection changed", "Apply the example code again for the updated selection.");
      }
      aplicada.textContent = datos.codigo ? `${datos.codigo} · demonstration only` : "";
      raiz.querySelector("summary").textContent = datos.codigo ? `Demo code applied · ${datos.codigo}` : "Have a promo code?";
      aplicada.hidden = !datos.codigo; retirar.hidden = !datos.codigo;
      if (datos.promocionEstado === "no-elegible" && ultimoEstado !== "no-elegible") {
        mostrarResultado(region, "Demo discount removed", "Your changed selection no longer meets the example rule. Review the updated amounts.", "aviso");
      }
      ultimoEstado = datos.promocionEstado;
    },
    destruir() { cancelar(); eventos.abort(); instancias.delete(raiz); },
  };
  instancias.set(raiz, api);
  return api;
}
