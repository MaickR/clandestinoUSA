import { crearAlerta } from "../core/alerta.js";
import { inicializarBotonCarga } from "../core/boton-carga.js";
import { inicializarCantidad } from "../core/cantidad.js";

/** Demostración local: último resultado en memoria, sin pedidos ni importes calculados. */
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
  let enCurso = false;
  // Core puede restaurar el valor al confirmar; el primer envío conserva el aviso.
  let cantidadInvalida = false;
  campo.addEventListener("input", () => {
    cantidadInvalida = campo.value === "" || !campo.checkValidity();
  });

  function informar(mensaje, variante = "informacion") {
    resultado.replaceChildren(crearAlerta({ mensaje, variante }));
  }

  formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();
    if (enCurso) return;
    if (cantidadInvalida || !cantidad.actualizar()) {
      informar("Check the quantity before adding. Only 1–6 whole boards are allowed in this demo.", "error");
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
    informar("Adding to the demonstration selection… No order is being sent.");
    window.setTimeout(() => {
      enCurso = false;
      carga.establecerCarga(false);
      campo.disabled = false;
      desenlace.disabled = false;
      cantidad.actualizar();
      if (falla) {
        informar("Demo action failed. Your previous selection is unchanged. Choose Success to try again.", "error");
      } else {
        seleccion.textContent = `${unidades} ${unidades === "1" ? "board" : "boards"} · Cheese & charcuterie · demo selection only.`;
        seleccion.dataset.seleccion = "true";
        informar("Demo selection updated. No order, stock check or payment has taken place.", "exito");
      }
      limpiar.disabled = seleccion.dataset.seleccion !== "true";
    }, 1600);
  });
  limpiar.addEventListener("click", () => {
    seleccion.textContent = "Your demonstration selection is empty.";
    delete seleccion.dataset.seleccion;
    limpiar.disabled = true;
    informar("Demo selection cleared.");
    boton.focus();
  });
  document.getElementById("catalogo-reintentar").addEventListener("click", () => {
    document.getElementById("catalogo-reintento").textContent = "Retry demonstrated. No network request was sent; this static error example remains visible.";
  });
}
