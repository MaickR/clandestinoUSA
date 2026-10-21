import { inicializarBotonCarga } from "../core/boton-carga.js";
import { describirFecha, mostrarResultado, validarFormulario } from "./transaccion.js";
import { relojRestaurante, ventanasServicio, validarHorario, describirHora } from "./horario-servicio.js";

const instancias = new WeakMap();

/** Tamaño de fixture; el grupo grande siempre requiere evaluación manual. */
export function validarGrupo(valor, cantidad) {
  const numero = Number(valor === "grande" ? cantidad : valor);
  return Number.isSafeInteger(numero) && numero >= 1 && (valor === "grande" ? numero > 10 : numero <= 10) ? numero : null;
}

/** Preferencias civiles y horarios del anfitrión; ninguna consulta de red. */
export function inicializarReserva(raiz, { escenario, configuracion, alInvalidar, alSeleccionar = () => {} }) {
  if (!(raiz instanceof HTMLElement) || typeof configuracion !== "function") throw new TypeError("Reserva requiere raíz y configuración de servicio.");
  if (instancias.has(raiz)) return instancias.get(raiz);
  const formulario = raiz.querySelector("[data-cl-reserva-busqueda]");
  const fecha = formulario.querySelector('input[type="date"]');
  const personas = formulario.querySelector("select");
  const grupo = formulario.querySelector("[data-cl-reserva-grupo]");
  const cantidad = grupo.querySelector("input");
  const horarios = raiz.querySelector("[data-cl-reserva-horarios]");
  const lista = horarios.querySelector(".cl-reserva__horas");
  const mensaje = raiz.querySelector("[data-cl-reserva-disponibilidad]");
  const resumen = raiz.querySelector("[data-cl-reserva-resumen]");
  const boton = formulario.querySelector('button[type="submit"]');
  const carga = inicializarBotonCarga(boton);
  const abortador = new AbortController();
  const opciones = { signal: abortador.signal };
  let listo = false;
  let ocupado = false;
  let configuracionRevisada = null;
  let temporizador;

  function criterios() {
    fecha.min = relojRestaurante(configuracion().zona).fecha;
    const grande = personas.value === "grande";
    grupo.hidden = !grande; cantidad.disabled = !grande;
    cantidad.setCustomValidity(!grande || validarGrupo("grande", cantidad.value) ? "" : "Enter a whole guest count greater than 10.");
  }
  function seleccion() {
    criterios();
    const numero = validarGrupo(personas.value, cantidad.value);
    const grande = personas.value === "grande";
    const hora = horarios.querySelector("input:checked");
    if (!listo || !numero || !fecha.checkValidity() || configuracionRevisada !== JSON.stringify(configuracion())) return null;
    if (grande) return ventanasServicio(fecha.value, "reserva", configuracion()).horas.length ? { fecha: fecha.value, personas: numero, grande: true, hora: null, texto: "Time and capacity to be discussed" } : null;
    return hora && validarHorario(fecha.value, hora.value, "reserva", configuracion()) ? { fecha: fecha.value, personas: numero, grande: false, hora: hora.value, texto: describirHora(hora.value) } : null;
  }
  function invalidar() {
    clearTimeout(temporizador); ocupado = false; listo = false; configuracionRevisada = null;
    carga.establecerCarga(false); horarios.hidden = true;
    for (const radio of horarios.querySelectorAll("input")) radio.checked = false;
    resumen.textContent = "Check times again for your updated visit preferences.";
    alInvalidar();
  }
  for (const campo of [fecha, personas, cantidad]) campo.addEventListener("change", () => {
    criterios(); invalidar();
    mostrarResultado(mensaje, personas.value === "grande" ? "Plan a larger gathering" : "Selection changed", personas.value === "grande" ? "Tell us the guest count, choose an open date, then continue to an inquiry. Capacity and time require manual confirmation." : "Find example times for your new preferences. No previous time is held.");
  }, opciones);
  formulario.addEventListener("submit", (evento) => {
    evento.preventDefault(); criterios();
    if (ocupado || !validarFormulario(formulario)) return;
    invalidar(); ocupado = true; carga.establecerCarga(true);
    mostrarResultado(mensaje, "Checking example service hours…", "No live availability or capacity is checked.");
    temporizador = window.setTimeout(() => {
      ocupado = false; carga.establecerCarga(false);
      const ventanas = ventanasServicio(fecha.value, "reserva", configuracion());
      if (!ventanas.horas.length) {
        mostrarResultado(mensaje, ventanas.estado === "cerrado" ? "Closed on this date · demo" : "No current example times", "Choose another restaurant date within the shared demo schedule. Your contact details are preserved.", "aviso"); return;
      }
      const estado = escenario();
      if (["error", "sin-horas"].includes(estado)) {
        mostrarResultado(mensaje, estado === "error" ? "Times could not be shown · demo" : "No example availability", "Choose another demo outcome and search again. Your contact details are preserved.", estado === "error" ? "error" : "aviso"); return;
      }
      listo = true; configuracionRevisada = JSON.stringify(configuracion());
      if (personas.value === "grande") {
        resumen.textContent = `${describirFecha(fecha.value)} · ${cantidad.value} guests · inquiry only`;
        mostrarResultado(mensaje, "Large group · availability unconfirmed", "Add your contact details and preferences. This is a request for manual review; no table or time is confirmed.");
        alSeleccionar(seleccion()); return;
      }
      lista.replaceChildren(...ventanas.horas.map((hora) => {
        const etiqueta = document.createElement("label"); etiqueta.className = "cl-opcion cl-reserva__hora";
        const radio = document.createElement("input"); radio.className = "cl-opcion__control"; radio.type = "radio"; radio.name = `${raiz.id}-horario`; radio.value = hora;
        const texto = document.createElement("span"); texto.textContent = describirHora(hora);
        etiqueta.append(radio, texto); return etiqueta;
      }));
      horarios.hidden = false;
      mostrarResultado(mensaje, "Example times within service hours", "Choose a time, then add your contact details. Synthetic intervals and service duration; no seats are held.");
    }, 500);
  }, opciones);
  horarios.addEventListener("change", () => {
    alInvalidar();
    const datos = seleccion();
    if (datos) { resumen.textContent = `${describirFecha(datos.fecha)} · ${datos.texto} · ${datos.personas} guests`; alSeleccionar(datos); }
  }, opciones);
  const api = {
    seleccion,
    actualizarConfiguracion() { criterios(); invalidar(); mostrarResultado(mensaje, "Demo hours changed", "Check the updated date and times. Your contact details are preserved."); },
    perderHorario() { invalidar(); mostrarResultado(mensaje, "This example time is no longer current", "Search again and choose a current time. Your contact details are preserved.", "aviso"); boton.focus(); },
    destruir() { clearTimeout(temporizador); abortador.abort(); instancias.delete(raiz); },
  };
  criterios(); instancias.set(raiz, api); return api;
}
