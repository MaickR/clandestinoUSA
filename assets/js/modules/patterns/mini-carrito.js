import Offcanvas from "bootstrap/js/src/offcanvas.js";
import Modal from "bootstrap/js/src/modal.js";
import { inicializarCantidad } from "../core/cantidad.js";
import { moneda, pintarImportes, mostrarResultado } from "./transaccion.js";

const instancias = new WeakMap();

/** Vista compacta del proveedor conectado. Bootstrap posee trap, backdrop y scroll lock. */
export function inicializarMiniCarrito(panel, activador, proveedor) {
  if (instancias.has(panel)) return instancias.get(panel);
  if (!(panel instanceof HTMLElement) || !panel.id || !activador || typeof proveedor?.suscribir !== "function") throw new TypeError("Mini-cart requiere panel, activador y proveedor observable.");
  const lista = panel.querySelector("[data-cl-mini-lineas]");
  const plantilla = panel.querySelector("template");
  const mensaje = panel.querySelector("[data-cl-mini-mensaje]");
  const continuar = panel.querySelector("[data-cl-mini-continuar]");
  const deshacer = panel.querySelector("[data-cl-mini-deshacer]");
  const cerrar = panel.querySelector("[data-cl-mini-cerrar]");
  if (![lista, plantilla, mensaje, continuar, deshacer, cerrar].every(Boolean)) throw new TypeError("Mini-cart incompleto.");
  const instancia = Offcanvas.getOrCreateInstance(panel);
  const eventos = new AbortController();
  const opciones = { signal: eventos.signal };
  const vistas = new Map();
  let eliminada = null;
  let destino = null;
  let accion = null;
  let pendiente = null;
  let destruccion = null;
  const abiertos = () => [...document.querySelectorAll(".offcanvas.show, .offcanvas.showing, .offcanvas.hiding, .offcanvas-xl.show, .offcanvas-xl.showing, .offcanvas-xl.hiding, .modal.show")];

  // Se intercepta en captura, antes de que otro componente cambie su estado de apertura.
  function exclusividad(evento) {
    if (evento.target !== panel && !panel.matches(".show, .showing, .hiding")) return;
    const otros = abiertos().filter((n) => n !== evento.target);
    if (!otros.length) return;
    evento.preventDefault();
    evento.stopImmediatePropagation();
    pendiente = { panel: evento.target, activador: evento.relatedTarget };
    for (const otro of otros) {
      const tipo = otro.classList.contains("modal") ? "modal" : "offcanvas";
      const control = tipo === "modal" ? Modal.getOrCreateInstance(otro) : Offcanvas.getOrCreateInstance(otro);
      const ocultar = () => control.hide();
      if (otro.classList.contains("showing")) otro.addEventListener(`shown.bs.${tipo}`, ocultar, { once: true, signal: eventos.signal });
      else ocultar();
    }
  }
  function continuarPendiente() {
    if (!pendiente || abiertos().length) return;
    const solicitud = pendiente; pendiente = null;
    const control = solicitud.panel.classList.contains("modal") ? Modal.getOrCreateInstance(solicitud.panel) : Offcanvas.getOrCreateInstance(solicitud.panel);
    control.show(solicitud.activador);
  }
  for (const tipo of ["modal", "offcanvas"]) {
    document.addEventListener(`show.bs.${tipo}`, exclusividad, { ...opciones, capture: true });
    document.addEventListener(`hidden.bs.${tipo}`, continuarPendiente, opciones);
  }
  function pintar(datos) {
    const lineas = datos.lineas.slice(0, 3);
    const visibles = new Set(lineas.map((l) => l.id));
    for (const [id, vista] of vistas) {
      if (!visibles.has(id)) { vista.nodo.remove(); vistas.delete(id); }
    }
    for (const linea of lineas) {
      let vista = vistas.get(linea.id);
      if (!vista) {
        const nodo = plantilla.content.firstElementChild.cloneNode(true);
        nodo.dataset.clMiniLinea = linea.id;
        const campo = nodo.querySelector('input[type="number"]');
        campo.id = `${panel.id}-${linea.id}-cantidad`; campo.max = String(linea.maximo); campo.value = String(linea.cantidad);
        const etiqueta = nodo.querySelector("label"); etiqueta.htmlFor = campo.id;
        const error = nodo.querySelector(".cl-cantidad__mensaje"); error.id = `${campo.id}-error`; campo.setAttribute("aria-describedby", error.id);
        const foto = nodo.querySelector("img");
        if (linea.imagen) { foto.src = linea.imagen; foto.alt = linea.alt ?? linea.nombre; foto.classList.toggle("cl-mini-carrito__foto--vino", linea.tipo === "vino"); } else foto.remove();
        lista.append(nodo);
        vista = { nodo, campo, control: inicializarCantidad(nodo.querySelector("[data-cl-control-cantidad]")) };
        vistas.set(linea.id, vista);
      }
      vista.nodo.querySelector("[data-cl-mini-nombre]").textContent = linea.nombre;
      vista.nodo.querySelector("[data-cl-mini-variante]").textContent = linea.variante || "Example presentation";
      const contexto = `${linea.nombre} · ${linea.variante}`;
      vista.nodo.querySelector("label").textContent = `Quantity for ${contexto}`;
      for (const [valor, texto] of [["sumar", "Increase"], ["restar", "Decrease"]]) vista.nodo.querySelector(`[data-cl-cantidad="${valor}"]`).setAttribute("aria-label", `${texto} quantity for ${contexto}`);
      vista.nodo.querySelector("[data-cl-mini-quitar]").setAttribute("aria-label", `Remove ${contexto}`);
      vista.nodo.querySelector("[data-cl-mini-precio]").textContent = moneda(linea.subtotalLinea);
      vista.nodo.querySelector("[data-cl-mini-estado]").textContent = !linea.disponible ? "Unavailable · remove to continue" : !linea.elegible ? "Not eligible for this service" : "Example selection";
      if (linea.cantidadValida && vista.campo.valueAsNumber !== linea.cantidad) { vista.campo.value = String(linea.cantidad); vista.campo.dispatchEvent(new Event("input")); }
      vista.campo.disabled = !linea.disponible; vista.control.actualizar();
    }
    const estados = { listo: datos.valido ? "Ready to review your order" : datos.lineas.length ? "Review quantities, availability and service eligibility" : "Your selection is empty", actualizando: "Updating selection…", error: "Summary unavailable · review your full cart", desactualizado: "Summary out of date · refresh your full cart" };
    panel.querySelector("[data-cl-mini-contexto]").textContent = `${datos.lineas.length} lines · ${datos.unidades} items${datos.lineas.length > 3 ? " · first 3 shown" : ""}`;
    panel.querySelector("[data-cl-mini-vacio]").hidden = datos.lineas.length > 0;
    panel.querySelector("[data-cl-mini-resumen-estado]").textContent = estados[datos.estado];
    lista.setAttribute("aria-busy", String(datos.estado === "actualizando"));
    continuar.disabled = !datos.valido;
    pintarImportes(panel, datos);
    if (panel.contains(document.activeElement) && !document.activeElement.getClientRects().length) cerrar.focus();
  }
  const retirarSuscripcion = proveedor.suscribir(pintar);
  for (const tipo of ["input", "change"]) lista.addEventListener(tipo, (evento) => {
    if (evento.target.matches('input[type="number"]')) proveedor.cantidad(evento.target.closest("[data-cl-mini-linea]").dataset.clMiniLinea, evento.target.valueAsNumber);
  }, opciones);
  lista.addEventListener("click", (evento) => {
    const boton = evento.target.closest("[data-cl-mini-quitar]");
    if (!boton) return;
    eliminada = boton.closest("[data-cl-mini-linea]").dataset.clMiniLinea;
    proveedor.eliminar(eliminada); deshacer.hidden = false;
    mostrarResultado(mensaje, "Item removed", "Your full cart and connected summaries have been updated."); deshacer.focus();
  }, opciones);
  deshacer.addEventListener("click", () => {
    if (!eliminada) return;
    proveedor.restaurar(eliminada); eliminada = null; deshacer.hidden = true;
    mostrarResultado(mensaje, "Item restored", "Your previous quantity and presentation are restored."); cerrar.focus();
  }, opciones);
  activador.setAttribute("aria-controls", panel.id); activador.setAttribute("aria-haspopup", "dialog"); activador.setAttribute("aria-expanded", "false");
  activador.addEventListener("click", (evento) => { evento.preventDefault(); instancia.toggle(activador); }, opciones);
  cerrar.addEventListener("click", () => instancia.hide(), opciones);
  panel.addEventListener("shown.bs.offcanvas", () => { activador.setAttribute("aria-expanded", "true"); cerrar.focus(); }, opciones);
  panel.addEventListener("hidden.bs.offcanvas", () => {
    activador.setAttribute("aria-expanded", "false");
    if (destino) { destino.focus(); destino.scrollIntoView({ block: "start" }); destino = null; }
    else if (!pendiente) activador.focus({ preventScroll: true });
    if (accion) { const ejecutar = accion; accion = null; ejecutar(); }
  }, opciones);
  panel.querySelector("[data-cl-mini-ver]").addEventListener("click", (evento) => {
    const url = new URL(evento.currentTarget.href);
    if (url.origin !== location.origin || url.pathname !== location.pathname || !url.hash) return;
    const objetivo = document.getElementById(decodeURIComponent(url.hash.slice(1)));
    if (!objetivo) return;
    evento.preventDefault(); destino = objetivo; instancia.hide();
  }, opciones);
  continuar.addEventListener("click", () => { if (!proveedor.resumen().valido) return; accion = () => proveedor.continuar(); instancia.hide(); }, opciones);
  const api = {
    destruir() {
      if (destruccion) return destruccion;
      pendiente = null; destino = null; accion = null;
      destruccion = (async () => {
        if (panel.matches(".show, .showing, .hiding")) await new Promise((resolver) => {
          panel.addEventListener("hidden.bs.offcanvas", resolver, { once: true });
          if (panel.classList.contains("showing")) panel.addEventListener("shown.bs.offcanvas", () => instancia.hide(), { once: true });
          else instancia.hide();
        });
        retirarSuscripcion(); eventos.abort(); instancia.dispose(); lista.replaceChildren(); vistas.clear();
        for (const atributo of ["aria-controls", "aria-haspopup", "aria-expanded"]) activador.removeAttribute(atributo);
        instancias.delete(panel);
      })();
      return destruccion;
    },
  };
  instancias.set(panel, api);
  return api;
}
