import { inicializarBotonCarga } from "../core/boton-carga.js";
import { fechaRestaurante, describirFecha, mostrarResultado, validarFormulario } from "./transaccion.js";

const instancias = new WeakMap();

/** Selección de disponibilidad recibida por el anfitrión; ninguna consulta de red. */
export function inicializarReserva(raiz, { escenario, alInvalidar }) {
  if (instancias.has(raiz)) return instancias.get(raiz);
  const formulario = raiz.querySelector("[data-cl-reserva-busqueda]");
  const fecha = formulario.querySelector('input[type="date"]');
  const personas = formulario.querySelector("select");
  const horarios = raiz.querySelector("[data-cl-reserva-horarios]");
  const mensaje = raiz.querySelector("[data-cl-reserva-disponibilidad]");
  const resumen = raiz.querySelector("[data-cl-reserva-resumen]");
  const boton = formulario.querySelector('button[type="submit"]');
  const carga = inicializarBotonCarga(boton);
  const abortador = new AbortController();
  const opciones = { signal: abortador.signal };
  let listo = false;
  let ocupado = false;
  let temporizador;
  fecha.min = fechaRestaurante();

  function seleccion() {
    const hora = horarios.querySelector("input:checked");
    return listo && hora ? { fecha: fecha.value, personas: personas.value, hora: hora.value, texto: hora.nextElementSibling.textContent } : null;
  }
  function invalidar() {
    clearTimeout(temporizador);
    ocupado = false;
    listo = false;
    carga.establecerCarga(false);
    horarios.hidden = true;
    for (const radio of horarios.querySelectorAll("input")) radio.checked = false;
    resumen.textContent = "Choose example times again after changing the date or party size.";
    alInvalidar();
  }
  for (const campo of [fecha, personas]) campo.addEventListener("change", () => {
    invalidar();
    mostrarResultado(mensaje, "Selection changed", "Find example times for your new preferences. No previous time is held.");
  }, opciones);
  formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();
    fecha.min = fechaRestaurante();
    if (ocupado || !validarFormulario(formulario)) return;
    invalidar();
    ocupado = true;
    carga.establecerCarga(true);
    mostrarResultado(mensaje, "Looking for example times…", "No live availability is checked.");
    temporizador = window.setTimeout(() => {
      ocupado = false;
      carga.establecerCarga(false);
      const estado = escenario();
      if (estado === "error" || estado === "sin-horas") {
        mostrarResultado(mensaje, estado === "error" ? "Times could not be shown · demo" : "No example times for this search", "Try another date or choose another demo outcome, then search again. Your contact details are preserved.", estado === "error" ? "error" : "aviso");
        return;
      }
      listo = true;
      horarios.hidden = false;
      mostrarResultado(mensaje, "Example evening times", "Choose a time below. These options do not represent available tables.");
    }, 500);
  }, opciones);
  horarios.addEventListener("change", () => {
    alInvalidar();
    const datos = seleccion();
    if (datos) resumen.textContent = `${describirFecha(datos.fecha)} · ${datos.texto} · ${datos.personas} guests. Restaurant time · America/Los_Angeles. Demonstration only.`;
  }, opciones);
  const api = {
    seleccion,
    perderHorario() {
      invalidar();
      mostrarResultado(mensaje, "This example time is no longer available", "Your contact details remain below. Search again and choose a different time.", "aviso");
      boton.focus();
    },
    destruir() { clearTimeout(temporizador); abortador.abort(); instancias.delete(raiz); },
  };
  instancias.set(raiz, api);
  return api;
}
