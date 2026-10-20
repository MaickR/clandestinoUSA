import { inicializarCarrito } from "../patterns/carrito.js";
import { inicializarCheckout } from "../patterns/checkout.js";
import { inicializarReserva } from "../patterns/reserva.js";
import { moneda, fechaRestaurante, describirFecha, mostrarResultado, pintarImportes } from "../patterns/transaccion.js";
import { inicializarBotonCarga } from "../core/boton-carga.js";
import { inicializarCantidad } from "../core/cantidad.js";
import { productosEjemplo, estadosEjemplo, coleccionEjemplo, consultarCodigoEjemplo } from "./transacciones-fixtures.js";

import { inicializarNavegacion } from "../patterns/navegacion-global.js";

const inicializadas = new WeakSet();
const porId = (id) => document.getElementById(id);

function pintarDatos(contenedor, datos) {
  const lista = document.createDocumentFragment();
  for (const [etiqueta, valor] of datos) {
    const termino = document.createElement("dt");
    const descripcion = document.createElement("dd");
    termino.textContent = etiqueta;
    descripcion.textContent = valor;
    lista.append(termino, descripcion);
  }
  contenedor.replaceChildren(lista);
}

function respuesta(dominio, clave, repetible = false) {
  const dato = estadosEjemplo[dominio].estados[clave];
  return { ...dato, mensaje: `${dato.mensaje} ${dato.siguiente}`, repetible };
}

function conectarPedido(raiz, carrito, pago) {
  const zona = raiz.querySelector("[data-cl-pedido-checkout]");
  const checkoutRaiz = zona.querySelector("[data-cl-checkout]");
  const resultado = checkoutRaiz.querySelector("[data-cl-checkout-resultado]");
  const fecha = porId("w7-pedido-fecha");
  const modalidad = () => checkoutRaiz.querySelector('input[name="w7-modalidad"]:checked').value;
  let pedidoRevisado = null;
  let ultimaVersion = null;
  fecha.min = fechaRestaurante();
  const checkout = inicializarCheckout(checkoutRaiz, {
    prepararValidacion() { fecha.min = fechaRestaurante(); },
    revisar() {
      const datos = carrito.resumen();
      if (!datos.valido) {
        mostrarResultado(resultado, "Review your cart first", "Refresh any outdated summary and remove unavailable example items before continuing.", "error");
        return false;
      }
      const pickup = modalidad() === "pickup";
      const servicio = pickup ? `Pickup requested: ${describirFecha(fecha.value)} · ${porId("w7-pedido-hora").value}` : `Order ahead / at table · ${porId("w7-pedido-referencia").value || "Reference not provided"}`;
      pedidoRevisado = { version: datos.version, servicio,
        contacto: `${porId("w7-pedido-nombre").value} · ${porId("w7-pedido-email").value}` };
      pintarDatos(checkoutRaiz.querySelector("[data-cl-checkout-datos]"), [
        ["Example selection", datos.lineas.map((l) => `${l.cantidad} × ${l.nombre} · ${l.variante} · ${moneda(l.subtotalLinea)}`).join("\n")],
        ["Service preference", `${servicio} · America/Los_Angeles · unconfirmed`],
        ...(pickup ? [["Pickup location", "211 N Mt Shasta Blvd, Mt Shasta, CA 96067"]] : [["Visit", "Order ahead is not a table reservation."]]),
        ["Example contact", pedidoRevisado.contacto], ["Phone", porId("w7-pedido-telefono").value || "Not provided · optional"],
        ["Instructions", porId("w7-pedido-notas").value || "None"],
        ["Items subtotal", moneda(datos.subtotal)], ["Demo discount", `${datos.codigo || "None"} · ${moneda(datos.descuento)}`],
        ["After demo discount", `${moneda(datos.subtotalAjustado)} USD`], ["Tax / charges / final total", "Not determined · not a payment authorization"],
      ]);
      return true;
    },
    resultado() {
      const valor = checkoutRaiz.querySelector("[data-cl-escenario]").value;
      return respuesta("pedido", valor === "exito" ? "recibido" : valor, valor === "error");
    },
    alInvalidar() { pedidoRevisado = null; pago.invalidar(); },
    alCompletar(dato) {
      if (!dato.repetible && pedidoRevisado) {
        pago.habilitar(pedidoRevisado);
        porId("w7-pago-titulo").focus();
        porId("w7-pago").scrollIntoView({ block: "start" });
      }
    },
  });
  function modalidadActual() {
    const pickup = modalidad() === "pickup";
    for (const [selector, visible] of [["[data-cl-pedido-pickup]", pickup], ["[data-cl-pedido-mesa]", !pickup]]) {
      const panel = checkoutRaiz.querySelector(selector);
      panel.hidden = !visible;
      for (const control of panel.querySelectorAll("input")) control.disabled = !visible;
    }
    zona.querySelector("[data-cl-pedido-direccion]").hidden = !pickup;
    zona.querySelector("[data-cl-pedido-contexto]").textContent = pickup ? "Pickup preference · service time unconfirmed." : "Order ahead is not a table reservation. Visit and kitchen service unconfirmed.";
  }
  for (const campo of checkoutRaiz.querySelectorAll('input[name="w7-modalidad"]')) campo.addEventListener("change", modalidadActual);
  checkoutRaiz.querySelector("[data-cl-escenario]").addEventListener("change", () => checkout.invalidar());
  const actualizar = () => {
    const datos = carrito.resumen();
    if (ultimaVersion === datos.version) return;
    ultimaVersion = datos.version;
    checkout.invalidar();
    const lista = zona.querySelector("[data-cl-pedido-lineas]");
    lista.replaceChildren(...datos.lineas.map((linea) => {
      const item = document.createElement("li");
      item.textContent = `${linea.cantidad} × ${linea.nombre}${linea.variante ? ` · ${linea.variante}` : ""}`;
      return item;
    }));
    pintarImportes(zona, datos);
    pago.actualizar(datos);
  };
  raiz.addEventListener("cl:carrito", actualizar);
  raiz.addEventListener("cl:carrito-continuar", () => {
    checkout.invalidar();
    checkoutRaiz.querySelector("[data-cl-checkout-entrada] h3").focus();
    zona.scrollIntoView({ block: "start" });
  });
  modalidadActual(); actualizar();
}

function conectarPago(raiz, carrito) {
  const zona = raiz.querySelector("[data-cl-pago]");
  const simular = zona.querySelector("[data-cl-pago-simular]");
  const consultar = zona.querySelector("[data-cl-pago-consultar]");
  const selector = zona.querySelector("[data-cl-escenario]");
  const region = zona.querySelector("[data-cl-pago-resultado]");
  const ayuda = zona.querySelector("[data-cl-pago-ayuda]");
  const carga = inicializarBotonCarga(simular);
  let ocupado = false;
  let cerrado = false;
  let versionRevisada = null;
  let temporizador;
  function mostrar(clave) {
    const dato = respuesta("pago", clave);
    mostrarResultado(region, dato.titulo, dato.mensaje, dato.variante);
  }
  function invalidar() {
    clearTimeout(temporizador); ocupado = false; cerrado = false; versionRevisada = null;
    carga.establecerCarga(false); selector.disabled = false; simular.disabled = true; consultar.hidden = true;
    region.replaceChildren();
    ayuda.textContent = "Review the current order details to explore a payment outcome. No amount is authorized.";
    pintarDatos(zona.querySelector("[data-cl-pago-contexto]"), [["Order review", "Required for the current selection"]]);
  }
  simular.addEventListener("click", () => {
    const datos = carrito.resumen();
    if (ocupado || cerrado || versionRevisada !== datos.version || !datos.valido) return;
    const version = datos.version;
    ocupado = true; carga.establecerCarga(true); selector.disabled = true; mostrar("procesando");
    temporizador = window.setTimeout(() => {
      if (carrito.resumen().version !== version) { invalidar(); return; }
      ocupado = false; cerrado = true; carga.establecerCarga(false); simular.disabled = true;
      mostrar(selector.value);
      consultar.hidden = !["pendiente", "desconocido", "error", "expirado"].includes(selector.value);
      region.focus();
    }, 650);
  });
  consultar.addEventListener("click", () => {
    if (versionRevisada !== carrito.resumen().version) { invalidar(); return; }
    mostrar("recuperacion"); consultar.hidden = true; region.focus();
  });
  zona.querySelector("[data-cl-pago-reiniciar]").addEventListener("click", () => {
    clearTimeout(temporizador); ocupado = false; cerrado = false; carga.establecerCarga(false);
    selector.disabled = false; consultar.hidden = true;
    simular.disabled = versionRevisada !== carrito.resumen().version || !carrito.resumen().valido;
    mostrarResultado(region, "Payment demonstration reset", "The current selection is preserved. This resets the local outcome only; it does not retry a payment.");
  });
  return {
    invalidar,
    actualizar(datos) {
      invalidar(); pintarImportes(zona, datos);
      zona.querySelector("[data-cl-pago-referencia]").textContent = `DEMO-PAY-${String(datos.version).padStart(3, "0")} · synthetic reference · not a receipt`;
    },
    habilitar(datos) {
      if (datos.version !== carrito.resumen().version || !carrito.resumen().valido) return;
      versionRevisada = datos.version; cerrado = false; simular.disabled = false;
      ayuda.textContent = "Example amounts in USD · tax, other charges and the final total remain unconfirmed. No payment method is connected.";
      pintarDatos(zona.querySelector("[data-cl-pago-contexto]"), [["Requested service", datos.servicio], ["Example contact", datos.contacto], ["Restaurant time", "America/Los_Angeles · service unconfirmed"]]);
    },
  };
}

function conectarCarrito(raiz, carrito) {
  const zona = raiz.querySelector("[data-cl-carrito]");
  const region = zona.querySelector("[data-cl-carrito-mensaje]");
  const cabecera = inicializarNavegacion(raiz);
  let temporizador;
  const actualizarContador = () => cabecera.actualizarCarrito(carrito.resumen());
  raiz.addEventListener("cl:carrito", actualizarContador); actualizarContador();
  zona.querySelector("[data-cl-carrito-coleccion]").addEventListener("change", (evento) => {
    clearTimeout(temporizador);
    carrito.reemplazarLineas(coleccionEjemplo(Number(evento.target.value)));
    zona.querySelector("[data-cl-escenario]").value = "listo";
    mostrarResultado(region, "Example collection updated", "Synthetic layout data only. Review every item; the cart is not paginated.");
  });
  for (const boton of zona.querySelectorAll("[data-cl-agregar]")) boton.addEventListener("click", () => {
    carrito.agregar(productosEjemplo.find((p) => p.id === boton.dataset.clAgregar));
    mostrarResultado(region, "Selection updated", "Your connected summaries now reflect the example selection.");
  });
  zona.querySelector("[data-cl-carrito-reintentar]").addEventListener("click", () => {
    clearTimeout(temporizador); carrito.establecerEstado("actualizando");
    mostrarResultado(region, "Refreshing example selection…", "No inventory, price or promotion service is contacted.");
    temporizador = window.setTimeout(() => {
      carrito.establecerEstado("listo");
      mostrarResultado(region, "Example summary refreshed", "Review the current selection. Unavailable items must still be removed.");
    }, 500);
  });
  zona.querySelector("[data-cl-escenario]").addEventListener("change", (evento) => {
    clearTimeout(temporizador);
    const valor = evento.target.value;
    if (valor === "vacio" || valor === "listo") carrito.reemplazarLineas(valor === "vacio" ? [] : productosEjemplo);
    else if (["no-disponible", "restringido"].includes(valor)) {
      carrito.establecerEstado("listo");
      const linea = carrito.resumen().lineas.find((l) => valor === "restringido" ? l.restringido : true);
      if (linea) carrito.disponibilidad(linea.id, false);
    } else carrito.establecerEstado(valor === "modalidad-no-disponible" ? "error" : valor);
    const mensajes = {
      error: ["Summary unavailable · demo", "Your selection is preserved. Refresh the example summary to recover."],
      desactualizado: ["Summary out of date · demo", "Review updated example amounts before continuing. Your selection is preserved."],
      actualizando: ["Updating selection · demo", "Continuation is paused. Use Refresh example summary to finish this state."],
      "no-disponible": ["An item is unavailable · demo", "Remove the unavailable item to continue."],
      restringido: ["Wine restricted · example state", "The selected wine is unavailable for this example. Remove it; real eligibility must be checked separately."],
      "modalidad-no-disponible": ["Service unavailable · demo", "Pickup or table service cannot be confirmed in this state. Refresh the example; no alternative service is assumed."],
      vacio: ["Your table is waiting", "Add an example board or bottle to begin again."],
      listo: ["Main example restored", "Two items, synthetic prices. No service is confirmed."],
    };
    mostrarResultado(region, ...mensajes[valor], valor === "error" ? "error" : "informacion");
  });
}

function conectarReserva(raiz) {
  const zona = raiz.querySelector("[data-cl-reserva]");
  const checkoutRaiz = zona.querySelector("[data-cl-checkout]");
  const selector = zona.querySelector("[data-cl-escenario]");
  let checkout;
  const detalles = zona.querySelector("[data-cl-reserva-detalles]");
  const ayudaContacto = zona.querySelector("[data-cl-reserva-contacto-ayuda]");
  const reserva = inicializarReserva(zona, {
    escenario: () => selector.value,
    alInvalidar() { checkout?.invalidar(); detalles.hidden = true; ayudaContacto.hidden = false; },
    alSeleccionar() { detalles.hidden = false; ayudaContacto.hidden = true; },
  });
  checkout = inicializarCheckout(checkoutRaiz, {
    revisar() {
      const datos = reserva.seleccion();
      if (!datos) {
        mostrarResultado(checkoutRaiz.querySelector("[data-cl-checkout-resultado]"), "Choose an example time", "Find example times for the current date and party size, then select one.", "error");
        zona.querySelector("[data-cl-reserva-busqueda] button").focus();
        return false;
      }
      pintarDatos(checkoutRaiz.querySelector("[data-cl-checkout-datos]"), [
        ["Requested visit", `${describirFecha(datos.fecha)} · ${datos.texto} · America/Los_Angeles`],
        ["Guests", datos.personas], ["Example contact", `${porId("w7-reserva-nombre").value} · ${porId("w7-reserva-email").value}`],
        ["Phone", porId("w7-reserva-telefono").value || "Not provided · optional"],
        ["Preferences", porId("w7-reserva-notas").value || "None"], ["Availability", "Demonstration only · no table held"],
      ]);
      return true;
    },
    resultado() {
      if (selector.value === "perdido") { reserva.perderHorario(); return respuesta("reserva", "perdido"); }
      if (selector.value === "error") return respuesta("reserva", "error", true);
      if (selector.value === "pendiente") return respuesta("reserva", "pendiente");
      const datos = reserva.seleccion();
      return { titulo: "Reservation confirmed · simulation only", mensaje: `DEMO-BOOK-LOCAL · ${describirFecha(datos.fecha)} · ${datos.texto} · ${datos.personas} guests · America/Los_Angeles. No table has been booked.`, variante: "exito" };
    },
  });
  selector.addEventListener("change", () => {
    if (["sin-horas", "error"].includes(selector.value)) reserva.perderHorario();
    else checkout.invalidar();
  });
}

function conectarGestion(raiz) {
  const zona = raiz.querySelector("[data-cl-gestion]");
  const region = zona.querySelector("[data-cl-gestion-resultado]");
  const cancelacion = zona.querySelector("[data-cl-gestion-confirmacion]");
  const modificacion = zona.querySelector("[data-cl-gestion-modificacion]");
  const selector = zona.querySelector("[data-cl-escenario]");
  const etiqueta = zona.querySelector(".cl-estado");
  const iniciarCambio = zona.querySelector("[data-cl-gestion-cambio]");
  const iniciarCancelacion = zona.querySelector("[data-cl-gestion-cancelar]");
  selector.addEventListener("change", () => {
    etiqueta.textContent = "Confirmed · simulation only";
    iniciarCambio.disabled = false;
    iniciarCancelacion.disabled = false;
    cancelacion.hidden = true; modificacion.hidden = true; region.replaceChildren();
  });
  zona.querySelector("[data-cl-gestion-cancelar]").addEventListener("click", () => {
    cancelacion.hidden = false; modificacion.hidden = true;
    zona.querySelector("[data-cl-gestion-conservar]").focus();
  });
  zona.querySelector("[data-cl-gestion-cambio]").addEventListener("click", () => {
    cancelacion.hidden = true; modificacion.hidden = false; porId("w7-gestion-notas").focus();
  });
  for (const atributo of ["conservar", "atras"]) zona.querySelector(`[data-cl-gestion-${atributo}]`).addEventListener("click", () => {
    cancelacion.hidden = true; modificacion.hidden = true;
    zona.querySelector(atributo === "conservar" ? "[data-cl-gestion-cancelar]" : "[data-cl-gestion-cambio]").focus();
  });
  for (const [atributo, estado] of [["confirmar", "cancelada"], ["enviar", "modificada"]]) zona.querySelector(`[data-cl-gestion-${atributo}]`).addEventListener("click", () => {
    const valor = selector.value;
    const dato = valor === "pendiente" ? {
      titulo: atributo === "confirmar" ? "Cancellation request pending · demo" : "Change request pending · demo",
      mensaje: "The original example booking remains unchanged until the request is confirmed. Check its result before sending it again.",
      variante: "informacion",
    } : respuesta("reserva", valor === "exito" ? estado : valor === "politica" ? "politica" : valor);
    if (valor === "exito") {
      etiqueta.textContent = atributo === "confirmar" ? "Cancelled · simulation only" : "Modified · simulation only";
      iniciarCambio.disabled = atributo === "confirmar";
      iniciarCancelacion.disabled = atributo === "confirmar";
    }
    mostrarResultado(region, dato.titulo, dato.mensaje, dato.variante);
    if (valor !== "error") { cancelacion.hidden = true; modificacion.hidden = true; }
    region.focus();
  });
}

function conectarComercio(raiz) {
  for (const zona of raiz.querySelectorAll("[data-cl-comercio]")) {
    const familia = zona.dataset.clComercio;
    const checkoutRaiz = zona.querySelector("[data-cl-checkout]");
    const region = zona.querySelector("[data-cl-checkout-resultado]");
    const seleccion = zona.querySelector("[data-cl-comercio-seleccion]");
    const selector = zona.querySelector("[data-cl-escenario]");
    let datos = null;
    if (familia === "evento") inicializarCantidad(zona.querySelector("[data-cl-control-cantidad]"));
    const checkout = inicializarCheckout(checkoutRaiz, {
      revisar() {
        if (!datos) {
          mostrarResultado(region, "Choose and import a selection", "Use the linked Wave 4 example, then import your selection above. No selection is assumed.", "error");
          zona.querySelector("[data-cl-comercio-importar]").focus();
          return false;
        }
        if (familia === "evento" && selector.value === "agotado") {
          mostrarResultado(region, "Event sold out · demo", "No places are available in this state. Your details remain. Choose another demo outcome to explore registration.", "aviso");
          return false;
        }
        pintarDatos(checkoutRaiz.querySelector("[data-cl-checkout-datos]"), [
          ...datos, ["Example contact email", porId(`w7-${familia}-email`).value],
          ...(familia === "evento" ? [["Attendees", porId("w7-evento-cantidad").value], ["Price / tax / total", "On inquiry · no final amount"]] : []),
          ...(familia === "club" ? [["Example conditions", "Explicitly accepted for this local preview only"]] : []),
        ]);
        return true;
      },
      resultado() {
        const valor = selector.value;
        if (valor === "error") return respuesta(familia, familia === "club" ? "fallo" : "error", true);
        if (valor === "pendiente") return respuesta(familia, familia === "evento" ? "pendiente" : "pago");
        return respuesta(familia, familia === "regalo" ? "emitida" : familia === "club" ? "activacion" : "confirmado");
      },
    });
    zona.querySelector("[data-cl-comercio-importar]").addEventListener("click", () => {
      checkout.invalidar();
      datos = null;
      if (familia === "regalo") {
        const importe = document.querySelector('input[name="gift-amount-demo"]:checked');
        if (importe) datos = [["Gift amount · example", `${moneda(Number(importe.value) * 100)} USD`], ["For", porId("gift-recipient").value || "Someone special"], ["Personal note", porId("gift-message").value || "No note"], ["Presentation / delivery", "Unconfirmed"], ["Tax / final charge", "Unconfirmed"]];
      } else if (familia === "club") {
        const plan = document.querySelector('input[name="club-plan-demo"]:checked');
        if (plan) datos = [["Selected profile", plan.value === "gold" ? "Gold" : "Diamond"], ["Benefits", plan.value === "gold" ? "Historical profile: Aragón selection, four bottles, tasting notes and pairings. Current benefits unconfirmed." : "Historical profile: broader premium Spanish selection, four bottles, tastings and additional privileges. Current benefits unconfirmed."], ["Price / cadence / renewal", "Unconfirmed · no current promotional offer"]];
      } else if (porId("event-choice").checked) datos = [["Example event", "A journey through Spanish wine"], ["Date", "May 18, 2028 · 6:00 PM PDT · America/Los_Angeles"], ["Capacity", "4 places · synthetic fixture only"]];
      if (datos) {
        const lista = document.createElement("dl"); lista.className = "cl-transaccion__datos";
        pintarDatos(lista, datos); seleccion.replaceChildren(lista);
        mostrarResultado(region, "Selection imported · local preview", "Review the details below. Changing the original selection requires importing it again.");
      } else {
        seleccion.textContent = "No selection imported.";
        mostrarResultado(region, "Selection missing", "Choose in the linked Wave 4 example first, then return and import it.", "aviso");
      }
    });
    if (familia === "evento") selector.addEventListener("change", () => {
      checkout.invalidar();
      zona.querySelector("[data-cl-evento-cupos]").textContent = selector.value === "agotado" ? "No example places available · sold out demo. No waitlist offered." : "4 example places · not real capacity. No place is held.";
    });
    else selector.addEventListener("change", () => checkout.invalidar());
  }
}

function conectarEstados(raiz) {
  const zona = raiz.querySelector("[data-cl-operaciones]");
  const dominio = zona.querySelector("[data-cl-estado-dominio]");
  const valor = zona.querySelector("[data-cl-estado-valor]");
  for (const [clave, dato] of Object.entries(estadosEjemplo)) dominio.add(new Option(dato.nombre, clave));
  function pintar() {
    const familia = estadosEjemplo[dominio.value];
    const dato = familia.estados[valor.value];
    zona.querySelector("[data-cl-estado-titulo]").textContent = familia.nombre;
    zona.querySelector("[data-cl-estado-etiqueta]").textContent = dato.titulo;
    zona.querySelector("[data-cl-estado-referencia]").textContent = `${familia.referencia} · synthetic reference, no commercial validity`;
    mostrarResultado(zona.querySelector("[data-cl-estado-mensaje]"), dato.titulo, dato.mensaje, dato.variante);
    zona.querySelector("[data-cl-estado-siguiente]").textContent = dato.siguiente;
    const enlace = zona.querySelector("[data-cl-estado-accion]");
    enlace.href = familia.destino;
    enlace.textContent = `Review ${familia.nombre.toLowerCase()} example`;
  }
  function poblar() {
    valor.replaceChildren(...Object.entries(estadosEjemplo[dominio.value].estados).map(([clave, dato]) => new Option(dato.titulo, clave)));
    pintar();
  }
  dominio.addEventListener("change", poblar);
  valor.addEventListener("change", pintar);
  poblar();
}

function conectarCuenta(raiz) {
  const zona = raiz.querySelector("[data-cl-cuenta]");
  const selector = zona.querySelector("[data-cl-cuenta-estado]");
  const lista = zona.querySelector("[data-cl-cuenta-lista]");
  const filas = [...lista.children];
  const region = zona.querySelector("[data-cl-cuenta-resultado]");
  const reintentar = zona.querySelector("[data-cl-cuenta-reintentar]");
  function pintar() {
    const valor = selector.value;
    lista.replaceChildren(...(valor === "operaciones" ? filas : []));
    lista.hidden = valor !== "operaciones";
    reintentar.hidden = valor !== "error";
    const mensajes = {
      operaciones: ["Fictional history", "No customer records have been loaded."],
      vacio: ["Your story is still to come", "There are no operations in this example. Explore the menu or plan a visit."],
      error: ["Operations could not be shown · demo", "Try loading the fictional examples again. No real account is connected."],
      "sin-autorizacion": ["Authorization required · demo", "No operation details are shown. A future service must verify the account holder before returning records."],
    };
    mostrarResultado(region, ...mensajes[valor], valor === "error" ? "error" : "informacion");
  }
  selector.addEventListener("change", pintar);
  reintentar.addEventListener("click", () => { selector.value = "operaciones"; pintar(); selector.focus(); });
  pintar();
}

/** Orquestación explícita del laboratorio; los módulos de producto no conocen estos IDs. */
export function inicializarTransaccionesGuia() {
  const raiz = document.querySelector("[data-cl-wave-7]");
  if (!raiz || inicializadas.has(raiz)) return;
  inicializadas.add(raiz);
  const zonaCarrito = raiz.querySelector("[data-cl-carrito]");
  const carrito = inicializarCarrito(zonaCarrito, productosEjemplo, { consultarCodigo: consultarCodigoEjemplo });
  conectarCarrito(raiz, carrito);
  const pago = conectarPago(raiz, carrito);
  conectarPedido(raiz, carrito, pago);
  conectarReserva(raiz);
  conectarGestion(raiz);
  conectarComercio(raiz);
  conectarEstados(raiz);
  conectarCuenta(raiz);
  for (const boton of raiz.querySelectorAll("[data-cl-demo-habilitar]")) boton.disabled = false;
}
