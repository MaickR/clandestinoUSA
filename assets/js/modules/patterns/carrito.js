import { inicializarCantidad } from "../core/cantidad.js";
import { crearEstadoCarrito } from "./estado-carrito.js";
import { inicializarPromocion } from "./promocion.js";
import { moneda, mostrarResultado, pintarImportes } from "./transaccion.js";
import { paginarCarrito } from "./paginacion-carrito.js";

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
  let pagina = 1;
  const suscriptores = new Set();
  const paginacion = raiz.querySelector("[data-cl-carrito-paginacion]");

  function cambiarPagina(valor, enfocar = false) {
    pagina = paginarCarrito(modelo.resumen().lineas.length, valor).pagina;
    pintar();
    if (enfocar) {
      lista.focus();
      mostrarResultado(region, `Page ${pagina}`, "The summary includes every page of your selection.");
    }
  }

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
    const error = nodo.querySelector(".cl-cantidad__mensaje");
    error.id = `${campo.id}-error`; campo.setAttribute("aria-describedby", error.id);
    const variante = buscar("linea-variante");
    variante.id = `${raiz.id}-${linea.id}-variante`;
    nodo.querySelector("[data-cl-linea-variante-etiqueta]").htmlFor = variante.id;
    const contextoVariante = document.createElement("span"); contextoVariante.className = "visually-hidden";
    contextoVariante.textContent = ` for ${linea.nombre}`;
    nodo.querySelector("[data-cl-linea-variante-etiqueta]").append(contextoVariante);
    variante.replaceChildren(...linea.variantes.map((v) => new Option(v.nombre, v.id)));
    variante.value = linea.varianteId ?? "";
    buscar("linea-variantes").hidden = linea.variantes.length < 2;
    const quitar = buscar("quitar");
    quitar.dataset.clQuitar = linea.id;
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
    const proyeccion = paginarCarrito(datos.lineas.length, pagina);
    pagina = proyeccion.pagina;
    const visibles = datos.lineas.slice(proyeccion.inicio, proyeccion.fin);
    const activas = new Set(visibles.map((l) => l.id));
    const lineaEnfocada = document.activeElement.closest?.("[data-cl-linea]");
    if (lineaEnfocada && lista.contains(lineaEnfocada) && !activas.has(lineaEnfocada.dataset.clLinea)) lista.focus();
    for (const [id, vista] of presentaciones) vista.nodo.hidden = !activas.has(id);
    for (const linea of visibles) {
      const vista = presentaciones.get(linea.id) ?? crearLinea(linea);
      vista.nodo.hidden = false;
      vista.titulo.textContent = linea.nombre;
      if (linea.cantidadValida && vista.campo.valueAsNumber !== linea.cantidad) {
        vista.campo.value = String(linea.cantidad);
        vista.campo.dispatchEvent(new Event("input"));
      }
      vista.variante.value = linea.varianteId ?? "";
      const contextoLinea = `${linea.nombre} · ${linea.variante}`;
      vista.nodo.querySelector("[data-cl-linea-cantidad-etiqueta]").textContent = `Quantity for ${contextoLinea}`;
      for (const [direccion, texto] of [["sumar", "Increase"], ["restar", "Decrease"]]) vista.nodo.querySelector(`[data-cl-cantidad="${direccion}"]`).setAttribute("aria-label", `${texto} quantity for ${contextoLinea}`);
      vista.buscar("quitar").setAttribute("aria-label", `Remove ${contextoLinea} from cart`);
      vista.buscar("linea-descripcion").textContent = linea.descripcion ?? linea.variante;
      vista.buscar("linea-unidad").textContent = `${moneda(linea.precio)} each · example`;
      vista.buscar("linea-subtotal").textContent = vista.campo.value !== "" && vista.campo.checkValidity() ? moneda(linea.subtotalLinea) : "—";
      vista.buscar("linea-estado").textContent = !linea.elegible ? "Not eligible for this service · choose another presentation or remove" : linea.disponible ? (linea.restringido ? "Wine · eligibility unconfirmed" : "Example selection · presentation and quantity are separate") : "Unavailable · remove this item to continue";
      vista.campo.disabled = !linea.disponible;
      vista.variante.disabled = !linea.disponible;
      vista.control.actualizar();
    }
    vacio.hidden = datos.lineas.length > 0;
    continuar.disabled = !datos.valido;
    lista.setAttribute("aria-busy", String(datos.estado === "actualizando"));
    if (paginacion) {
      paginacion.hidden = proyeccion.paginas < 2;
      paginacion.querySelector("[data-cl-pagina-anterior]").disabled = pagina === 1;
      paginacion.querySelector("[data-cl-pagina-siguiente]").disabled = pagina === proyeccion.paginas;
      paginacion.querySelector("[data-cl-pagina-estado]").textContent = `Page ${pagina} of ${proyeccion.paginas} · ${datos.lineas.length} ${datos.lineas.length === 1 ? "line" : "lines"} · ${datos.unidades} ${datos.unidades === 1 ? "item" : "items"}`;
    }
    pintarImportes(raiz, datos);
    for (const nodo of raiz.querySelectorAll("[data-cl-carrito-conteo]")) nodo.textContent = `${datos.unidades} ${datos.unidades === 1 ? "item" : "items"}`;
    const notaVino = raiz.querySelector("[data-cl-carrito-vino]");
    if (notaVino) notaVino.hidden = !datos.lineas.some((l) => l.restringido);
    promocion?.actualizar(datos);
    raiz.dispatchEvent(new CustomEvent("cl:carrito", { detail: datos, bubbles: true }));
    for (const suscriptor of suscriptores) suscriptor(datos);
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
    modelo.restaurar(id); ultimaEliminada = null; deshacer.hidden = true;
    cambiarPagina(Math.floor(modelo.resumen().lineas.findIndex((l) => l.id === id) / 10) + 1);
    mostrarResultado(region, "Item restored", "Your example quantity and selection have been restored.");
    const vista = presentaciones.get(id);
    (vista.campo.disabled ? vista.buscar("quitar") : vista.campo).focus();
  }, opciones);
  paginacion?.querySelector("[data-cl-pagina-anterior]").addEventListener("click", () => cambiarPagina(pagina - 1, true), opciones);
  paginacion?.querySelector("[data-cl-pagina-siguiente]").addEventListener("click", () => cambiarPagina(pagina + 1, true), opciones);
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
    suscribir(callback) { if (typeof callback !== "function") throw new TypeError("Suscriptor requerido."); suscriptores.add(callback); callback(modelo.resumen()); return () => suscriptores.delete(callback); },
    cantidad(id, valor) { modelo.cantidad(id, valor); pintar(); },
    variante(id, valor) { modelo.variante(id, valor); pintar(); },
    eliminar(id) { modelo.eliminar(id); pintar(); },
    restaurar(id) { modelo.restaurar(id); pintar(); },
    modalidad(valor) { modelo.modalidad(valor); pintar(); },
    continuar() { if (modelo.resumen().valido) continuar.click(); },
    reemplazarLineas(nuevas) {
      modelo.reemplazar(nuevas);
      for (const vista of presentaciones.values()) vista.nodo.remove();
      presentaciones.clear(); ultimaEliminada = null; deshacer.hidden = true; pagina = 1;
      pintar();
    },
    agregar(producto) {
      const id = modelo.agregar(producto);
      cambiarPagina(Math.floor(modelo.resumen().lineas.findIndex((l) => l.id === id) / 10) + 1);
    },
    disponibilidad(id, disponible) { modelo.disponibilidad(id, disponible); pintar(); },
    establecerEstado(estado) { modelo.establecerEstado(estado); pintar(); },
    destruir() {
      eventos.abort(); promocion?.destruir();
      for (const vista of presentaciones.values()) vista.nodo.remove();
      presentaciones.clear(); suscriptores.clear(); instancias.delete(raiz);
    },
  };
  instancias.set(raiz, api);
  pintar();
  return api;
}
