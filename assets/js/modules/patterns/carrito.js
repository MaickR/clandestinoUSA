import { inicializarCantidad } from "../core/cantidad.js";
import { crearEstadoCarrito } from "./estado-carrito.js";
import { inicializarPromocion } from "./promocion.js";
import { moneda, mostrarResultado, pintarImportes } from "./transaccion.js";

const instancias = new WeakMap();

/** Renderiza líneas estables desde datos del anfitrión; importes y descuentos viven en un solo estado. */
export function inicializarCarrito(raiz, productos, { consultarCodigo } = {}) {
  if (!(raiz instanceof HTMLElement) || !raiz.id) throw new TypeError("Carrito requiere raíz con identidad.");
  if (instancias.has(raiz)) return instancias.get(raiz);
  const lista = raiz.querySelector("[data-cl-carrito-lineas]");
  const plantilla = raiz.querySelector("[data-cl-carrito-plantilla]");
  const continuar = raiz.querySelector("[data-cl-carrito-continuar]");
  const region = raiz.querySelector("[data-cl-carrito-mensaje]");
  const deshacer = raiz.querySelector("[data-cl-carrito-deshacer]");
  const vacio = raiz.querySelector("[data-cl-carrito-vacio]");
  if (!lista || !(plantilla instanceof HTMLTemplateElement) || !continuar || !region || !deshacer || !vacio) throw new TypeError("Presentación de carrito incompleta.");
  const modelo = crearEstadoCarrito(productos);
  const presentaciones = new Map();
  const eventos = new AbortController();
  const opciones = { signal: eventos.signal };
  let ultimaEliminada = null;
  let promocion;

  function crearLinea(linea) {
    const nodo = plantilla.content.firstElementChild.cloneNode(true);
    nodo.dataset.clLinea = linea.id;
    const buscar = (nombre) => nodo.querySelector(`[data-cl-${nombre}]`);
    const titulo = buscar("linea-nombre");
    titulo.id = `${raiz.id}-${linea.id}-nombre`;
    nodo.querySelector("article").setAttribute("aria-labelledby", titulo.id);
    const campo = nodo.querySelector('input[type="number"]');
    campo.id = `${raiz.id}-${linea.id}-cantidad`;
    campo.value = String(linea.cantidad); campo.max = String(linea.maximo);
    nodo.querySelector("[data-cl-linea-cantidad-etiqueta]").htmlFor = campo.id;
    const contexto = document.createElement("span");
    contexto.className = "visually-hidden"; contexto.textContent = ` for ${linea.nombre}`;
    nodo.querySelector("[data-cl-linea-cantidad-etiqueta]").append(contexto);
    for (const [direccion, texto] of [["sumar", "Increase"], ["restar", "Decrease"]]) nodo.querySelector(`[data-cl-cantidad="${direccion}"]`).setAttribute("aria-label", `${texto} ${linea.nombre} quantity`);
    const error = nodo.querySelector(".cl-cantidad__mensaje");
    error.id = `${campo.id}-error`; campo.setAttribute("aria-describedby", error.id);
    const variante = buscar("linea-variante");
    variante.id = `${raiz.id}-${linea.id}-variante`;
    nodo.querySelector("[data-cl-linea-variante-etiqueta]").htmlFor = variante.id;
    variante.replaceChildren(...linea.variantes.map((v) => new Option(v.nombre, v.id)));
    variante.value = linea.varianteId ?? "";
    buscar("linea-variantes").hidden = linea.variantes.length < 2;
    const quitar = buscar("quitar");
    quitar.dataset.clQuitar = linea.id;
    quitar.setAttribute("aria-label", `Remove ${linea.nombre} from cart`);
    const imagen = buscar("linea-imagen");
    imagen.hidden = !linea.imagen;
    if (linea.imagen) { imagen.src = linea.imagen; imagen.alt = linea.alt ?? linea.nombre; }
    else imagen.remove();
    imagen.classList.toggle("cl-carrito__foto--vino", linea.tipo === "vino");
    buscar("linea-sin-imagen").hidden = Boolean(linea.imagen);
    const control = inicializarCantidad(nodo.querySelector("[data-cl-control-cantidad]"));
    const presentacion = { nodo, campo, control, variante, titulo, buscar };
    presentaciones.set(linea.id, presentacion);
    lista.append(nodo);
    return presentacion;
  }
  function pintar() {
    const datos = modelo.resumen();
    const activas = new Set(datos.lineas.map((l) => l.id));
    for (const [id, vista] of presentaciones) vista.nodo.hidden = !activas.has(id);
    for (const linea of datos.lineas) {
      const vista = presentaciones.get(linea.id) ?? crearLinea(linea);
      vista.nodo.hidden = false;
      vista.titulo.textContent = linea.nombre;
      vista.buscar("linea-descripcion").textContent = linea.descripcion ?? linea.variante;
      vista.buscar("linea-unidad").textContent = `${moneda(linea.precio)} each · example`;
      vista.buscar("linea-subtotal").textContent = vista.campo.value !== "" && vista.campo.checkValidity() ? moneda(linea.subtotalLinea) : "—";
      vista.buscar("linea-estado").textContent = linea.disponible ? (linea.restringido ? "Wine · eligibility unconfirmed" : "Example selection") : "Unavailable · remove this item to continue";
      vista.campo.disabled = !linea.disponible;
      vista.variante.disabled = !linea.disponible;
      vista.control.actualizar();
    }
    vacio.hidden = datos.lineas.length > 0;
    continuar.disabled = !datos.valido;
    lista.setAttribute("aria-busy", String(datos.estado === "actualizando"));
    pintarImportes(raiz, datos);
    for (const nodo of raiz.querySelectorAll("[data-cl-carrito-conteo]")) nodo.textContent = `${datos.unidades} ${datos.unidades === 1 ? "item" : "items"}`;
    const notaVino = raiz.querySelector("[data-cl-carrito-vino]");
    if (notaVino) notaVino.hidden = !datos.lineas.some((l) => l.restringido);
    promocion?.actualizar(datos);
    raiz.dispatchEvent(new CustomEvent("cl:carrito", { detail: datos, bubbles: true }));
  }
  for (const tipo of ["input", "change"]) lista.addEventListener(tipo, (evento) => {
    const nodo = evento.target.closest("[data-cl-linea]");
    if (!nodo) return;
    if (evento.target.matches('input[type="number"]')) modelo.cantidad(nodo.dataset.clLinea, evento.target.valueAsNumber);
    else if (tipo === "change" && evento.target.matches("[data-cl-linea-variante]")) modelo.variante(nodo.dataset.clLinea, evento.target.value);
    else return;
    pintar();
  }, opciones);
  lista.addEventListener("click", (evento) => {
    const boton = evento.target.closest("[data-cl-quitar]");
    if (!boton) return;
    const linea = modelo.resumen().lineas.find((l) => l.id === boton.dataset.clQuitar);
    if (!linea) return;
    ultimaEliminada = linea.id;
    modelo.eliminar(linea.id); pintar();
    mostrarResultado(region, "Item removed", `${linea.nombre} was removed from your example selection.`);
    deshacer.hidden = false;
    deshacer.setAttribute("aria-label", `Undo removal of ${linea.nombre}`);
    deshacer.focus();
  }, opciones);
  deshacer.addEventListener("click", () => {
    if (!ultimaEliminada) return;
    const id = ultimaEliminada;
    modelo.restaurar(id); ultimaEliminada = null; deshacer.hidden = true; pintar();
    mostrarResultado(region, "Item restored", "Your example quantity and selection have been restored.");
    const vista = presentaciones.get(id);
    (vista.campo.disabled ? vista.buscar("quitar") : vista.campo).focus();
  }, opciones);
  continuar.addEventListener("click", () => {
    if (modelo.resumen().valido) raiz.dispatchEvent(new CustomEvent("cl:carrito-continuar", { detail: modelo.resumen(), bubbles: true }));
  }, opciones);
  const promocionRaiz = raiz.querySelector("[data-cl-promocion]");
  if (promocionRaiz && consultarCodigo) promocion = inicializarPromocion(promocionRaiz, {
    consultar: consultarCodigo, resumen: modelo.resumen,
    aplicar(dato) { const estado = modelo.aplicarDescuento(dato); pintar(); return estado; },
    quitar() { modelo.quitarDescuento(); pintar(); },
  });
  const api = {
    resumen: modelo.resumen,
    reemplazarLineas(nuevas) {
      modelo.reemplazar(nuevas);
      for (const vista of presentaciones.values()) vista.nodo.remove();
      presentaciones.clear(); ultimaEliminada = null; deshacer.hidden = true;
      pintar();
    },
    agregar(producto) {
      modelo.agregar(producto);
      const vista = presentaciones.get(producto.id);
      if (vista) { vista.campo.value = String(modelo.resumen().lineas.find((l) => l.id === producto.id).cantidad); vista.campo.dispatchEvent(new Event("input", { bubbles: true })); }
      pintar();
    },
    disponibilidad(id, disponible) { modelo.disponibilidad(id, disponible); pintar(); },
    establecerEstado(estado) { modelo.establecerEstado(estado); pintar(); },
    destruir() {
      eventos.abort(); promocion?.destruir();
      for (const vista of presentaciones.values()) vista.nodo.remove();
      presentaciones.clear(); instancias.delete(raiz);
    },
  };
  instancias.set(raiz, api);
  pintar();
  return api;
}
