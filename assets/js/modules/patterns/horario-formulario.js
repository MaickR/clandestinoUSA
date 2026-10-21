import { relojRestaurante, ventanasServicio, validarHorario, describirHora } from "./horario-servicio.js";

/** Selector nativo derivado de la misma configuración que reservas; sin disponibilidad real. */
export function inicializarHorarioFormulario({ fecha, hora, ayuda, servicio, configuracion, alInvalidar = () => {} }) {
  const eventos = new AbortController();
  function actualizar(limpiar = false) {
    const config = configuracion();
    fecha.min = relojRestaurante(config.zona).fecha;
    const anterior = limpiar ? "" : hora.value;
    const ventanas = ventanasServicio(fecha.value, servicio, config);
    hora.replaceChildren(new Option(ventanas.estado === "cerrado" ? "No service on this date" : "Choose an example time", ""), ...ventanas.horas.map((h) => new Option(describirHora(h), h)));
    hora.value = ventanas.horas.includes(anterior) ? anterior : "";
    hora.setCustomValidity("");
    ayuda.textContent = ventanas.estado === "cerrado" ? "Service is not available on this date. Please choose another day." : ventanas.estado === "sin-horas" ? "No example times remain for this date. Please choose another day." : ventanas.horas.length ? `Example preferences: ${describirHora(ventanas.horas[0])}–${describirHora(ventanas.horas.at(-1))} · ${config.zona}. Synthetic cutoffs and lead time; service unconfirmed.` : "Choose a current restaurant date to see example service preferences.";
    if (anterior && !hora.value) alInvalidar();
    return ventanas;
  }
  fecha.addEventListener("change", () => { actualizar(true); alInvalidar(); }, { signal: eventos.signal });
  hora.addEventListener("change", () => hora.setCustomValidity(""), { signal: eventos.signal });
  actualizar();
  return {
    actualizarConfiguracion() { actualizar(true); alInvalidar(); },
    validar() {
      actualizar();
      const valido = validarHorario(fecha.value, hora.value, servicio, configuracion());
      hora.setCustomValidity(valido ? "" : "Choose a current example service time for an open date.");
      return valido;
    },
    destruir() { eventos.abort(); },
  };
}
