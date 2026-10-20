import { inicializarCantidad } from "../core/cantidad.js";
import { moneda, mostrarResultado } from "./transaccion.js";

const instancias = new WeakMap();

/** Carrito local sin persistencia. El anfitrión entrega datos validados, nunca totales del DOM. */
export function inicializarCarrito(raiz, productos) {
  if (instancias.has(raiz)) return instancias.get(raiz);
  if (!raiz || !Array.isArray(productos) || !productos.length || productos.some((p) =>
    !p.id || !Number.isSafeInteger(p.precio) || p.precio < 0 || !Number.isSafeInteger(p.maximo) || p.maximo < 1)) {
    throw new TypeError("Carrito requiere contenedor y productos con importes enteros.");
  }
  const abortador = new AbortController();
  const opciones = { signal: abortador.signal };
  const lineas = productos.map((producto) => {
    const nodo = raiz.querySelector(`[data-cl-linea="${producto.id}"]`);
    if (!nodo) throw new TypeError("Falta la presentación de una línea.");
    const campo = nodo.querySelector('input[type="number"]');
    const control = inicializarCantidad(nodo.querySelector("[data-cl-control-cantidad]"));
    return { ...producto, nodo, campo, control, cantidad: 1, presente: true };
  });
  let estado = "listo";
  const region = raiz.querySelector("[data-cl-carrito-mensaje]");
  const continuar = raiz.querySelector("[data-cl-carrito-continuar]");
  const vacio = raiz.querySelector("[data-cl-carrito-vacio]");
  let temporizador;

  function resumen() {
    const activas = lineas.filter((linea) => linea.presente);
    const valido = activas.length > 0 && activas.every((linea) => linea.campo.value !== "" && linea.campo.checkValidity());
    const total = activas.reduce((suma, linea) => suma + linea.precio * linea.cantidad, 0);
    if (!Number.isSafeInteger(total)) throw new RangeError("Total fuera de rango.");
    return { lineas: activas.map(({ id, nombre, variante, cantidad, precio }) => ({ id, nombre, variante, cantidad, precio })), total, valido: valido && estado === "listo" };
  }

  function pintar() {
    for (const linea of lineas) {
      linea.nodo.hidden = !linea.presente;
      linea.nodo.querySelector("[data-cl-linea-subtotal]").textContent = linea.campo.checkValidity() && linea.campo.value !== "" ? moneda(linea.precio * linea.cantidad) : "—";
      linea.nodo.querySelector("[data-cl-linea-estado]").textContent = estado === "no-disponible" && linea === lineas[0] ? "Unavailable · demo. Remove this item or reset the demo." : "Availability is illustrative";
    }
    const datos = resumen();
    vacio.hidden = datos.lineas.length > 0;
    for (const nodo of raiz.querySelectorAll("[data-cl-carrito-total]")) nodo.textContent = datos.valido ? moneda(datos.total) : "Review required";
    for (const nodo of raiz.querySelectorAll("[data-cl-carrito-conteo]")) nodo.textContent = `${datos.lineas.reduce((n, l) => n + l.cantidad, 0)} items · demo`;
    continuar.disabled = !datos.valido;
    raiz.dispatchEvent(new CustomEvent("cl:carrito", { detail: datos, bubbles: true }));
  }

  for (const linea of lineas) {
    const actualizar = () => {
      if (linea.campo.value !== "" && linea.campo.checkValidity()) linea.cantidad = linea.campo.valueAsNumber;
      pintar();
    };
    linea.campo.addEventListener("input", actualizar, opciones);
    linea.campo.addEventListener("change", actualizar, opciones);
  }
  raiz.addEventListener("click", (evento) => {
    const boton = evento.target.closest("button");
    if (!boton) return;
    if (boton.hasAttribute("data-cl-quitar")) {
      const linea = lineas.find((l) => l.id === boton.dataset.clQuitar);
      linea.presente = false;
      if (estado === "no-disponible" && linea === lineas[0]) estado = "listo";
      pintar();
      mostrarResultado(region, "Item removed · demo", `${linea.nombre} has been removed. You can add it again below.`);
      raiz.querySelector(`[data-cl-agregar="${linea.id}"]`).focus();
    }
    if (boton.hasAttribute("data-cl-agregar")) {
      const linea = lineas.find((l) => l.id === boton.dataset.clAgregar);
      linea.presente = true;
      linea.cantidad = Math.min(linea.maximo, linea.cantidad + (linea.nodo.hidden ? 0 : 1));
      linea.campo.value = String(linea.cantidad);
      linea.campo.dispatchEvent(new Event("input", { bubbles: true }));
      mostrarResultado(region, "Selection updated · demo", "Review the example quantities and totals before continuing.");
      pintar();
    }
    if (boton.hasAttribute("data-cl-carrito-reintentar")) {
      estado = "actualizando";
      pintar();
      mostrarResultado(region, "Updating example summary…", "No inventory or price service is contacted.");
      clearTimeout(temporizador);
      temporizador = window.setTimeout(() => {
        estado = "listo"; pintar();
        mostrarResultado(region, "Example summary refreshed", "Fixture values restored. Real totals must be confirmed by the restaurant.");
      }, 500);
    }
    if (boton === continuar && resumen().valido) raiz.dispatchEvent(new CustomEvent("cl:carrito-continuar", { bubbles: true, detail: resumen() }));
  }, opciones);
  const api = {
    resumen,
    escenario(valor) {
      clearTimeout(temporizador);
      estado = ["error", "desactualizado", "no-disponible", "actualizando"].includes(valor) ? valor : "listo";
      if (["vacio", "listo"].includes(valor)) {
        for (const linea of lineas) {
          linea.presente = valor !== "vacio";
          linea.cantidad = 1;
          linea.campo.value = "1";
          linea.control.actualizar();
          linea.nodo.querySelector(".cl-cantidad__mensaje").textContent = "";
        }
      }
      pintar();
      const mensajes = {
        error: ["Summary unavailable · demo", "Your items are preserved. Refresh the example summary to continue."],
        desactualizado: ["Summary out of date · demo", "Review refreshed prices before continuing. Your selection is preserved."],
        "no-disponible": ["An item is unavailable · demo", "Remove the sharing board to continue with the remaining selection."],
        actualizando: ["Updating selection · demo", "Continuation is paused. Refresh the example to finish this state."],
        vacio: ["Your table is waiting", "Add a board or a bottle to explore this demonstration."],
      };
      const [titulo, mensaje] = mensajes[valor] || ["Example cart restored", "Amounts are fixtures in USD. Nothing is ordered or charged."];
      mostrarResultado(region, titulo, mensaje, estado === "error" ? "error" : "informacion");
    },
    destruir() { abortador.abort(); clearTimeout(temporizador); instancias.delete(raiz); },
  };
  instancias.set(raiz, api);
  pintar();
  return api;
}
