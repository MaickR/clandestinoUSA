import { crearAlerta } from "../core/alerta.js";
import { inicializarBotonCarga } from "../core/boton-carga.js";
import { inicializarCantidad } from "../core/cantidad.js";

/** Última selección y subtotal ilustrativo en memoria; nunca importes de una compra. */
export function inicializarProductosGuia() {
  const formulario = document.getElementById("pedido-demo");
  if (!formulario) return;
  const campo = document.getElementById("pedido-unidades");
  const cantidad = inicializarCantidad(document.getElementById("pedido-cantidad"));
  const boton = document.getElementById("pedido-agregar");
  const carga = inicializarBotonCarga(boton);
  const resultado = document.getElementById("pedido-feedback");
  const seleccion = document.getElementById("pedido-seleccion");
  const limpiar = document.getElementById("pedido-limpiar");
  const desenlace = document.getElementById("pedido-resultado-demo");
  const subtotal = document.getElementById("pedido-subtotal");
  const datosSeleccion = document.getElementById("pedido-seleccion-datos");
  const precioEjemplo = Number(formulario.dataset.clPrecioEjemplo);
  if (!Number.isSafeInteger(precioEjemplo) || precioEjemplo < 0) {
    throw new TypeError("La demo requiere un precio de ejemplo en centavos.");
  }
  const moneda = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD" });
  function subtotalEjemplo(unidades) {
    return moneda.format(precioEjemplo * Number(unidades) / 100);
  }
  function actualizarSubtotal() {
    subtotal.textContent = campo.value !== "" && campo.checkValidity()
      ? subtotalEjemplo(campo.value) : "—";
  }
  let enCurso = false;
  // Core puede restaurar el valor al confirmar; el primer envío conserva el aviso.
  let cantidadInvalida = false;
  campo.addEventListener("input", () => {
    cantidadInvalida = campo.value === "" || !campo.checkValidity();
    actualizarSubtotal();
  });
  campo.addEventListener("change", actualizarSubtotal);
  actualizarSubtotal();

  function informar(mensaje, variante = "informacion") {
    resultado.replaceChildren(crearAlerta({ mensaje, variante }));
  }

  formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();
    if (enCurso) return;
    if (cantidadInvalida || !cantidad.actualizar()) {
      informar("Check quantity: choose 1–6 whole boards for this demo.", "error");
      cantidadInvalida = false;
      campo.focus();
      return;
    }
    const unidades = campo.value;
    const falla = desenlace.value === "error";
    enCurso = true;
    carga.establecerCarga(true);
    campo.disabled = true;
    desenlace.disabled = true;
    limpiar.disabled = true;
    cantidad.actualizar();
    informar("Updating your demo selection… No order is being sent.");
    window.setTimeout(() => {
      enCurso = false;
      carga.establecerCarga(false);
      campo.disabled = false;
      desenlace.disabled = false;
      cantidad.actualizar();
      if (falla) {
        informar("Demo action failed. Your previous selection is unchanged. Try again.", "error");
      } else {
        seleccion.textContent = `${unidades} ${unidades === "1" ? "board" : "boards"} selected · demonstration only.`;
        document.getElementById("seleccion-unidades").textContent = unidades;
        document.getElementById("seleccion-subtotal").textContent = subtotalEjemplo(unidades);
        datosSeleccion.hidden = false;
        seleccion.dataset.seleccion = "true";
        informar("Demo selection updated. Nothing has been ordered or charged.", "exito");
      }
      limpiar.disabled = seleccion.dataset.seleccion !== "true";
    }, 1600);
  });
  limpiar.addEventListener("click", () => {
    seleccion.textContent = "Your demonstration selection is empty.";
    delete seleccion.dataset.seleccion;
    datosSeleccion.hidden = true;
    limpiar.disabled = true;
    informar("Demo selection cleared.");
    boton.focus();
  });
  document.getElementById("catalogo-reintentar").addEventListener("click", () => {
    document.getElementById("catalogo-reintento").textContent = "Retry demonstrated. No network request was sent; this static error example remains visible.";
  });
}
