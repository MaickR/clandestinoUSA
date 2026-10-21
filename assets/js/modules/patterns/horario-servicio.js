const aMinutos = (hora) => {
  if (!/^([01]\d|2[0-3]):[0-5]\d$/.test(hora)) throw new TypeError("Hora local inválida.");
  const [h, m] = hora.split(":").map(Number);
  return h * 60 + m;
};
const aHora = (minutos) => `${String(Math.floor(minutos / 60)).padStart(2, "0")}:${String(minutos % 60).padStart(2, "0")}`;

/** Fecha y reloj civiles en la zona del restaurante, independientes del dispositivo. */
export function relojRestaurante(zona, ahora = new Date()) {
  const partes = new Intl.DateTimeFormat("en-US", { timeZone: zona, year: "numeric", month: "2-digit", day: "2-digit", hour: "2-digit", minute: "2-digit", hourCycle: "h23" }).formatToParts(ahora);
  const leer = (tipo) => partes.find((p) => p.type === tipo).value;
  return { fecha: `${leer("year")}-${leer("month")}-${leer("day")}`, minutos: Number(leer("hour")) * 60 + Number(leer("minute")) };
}

/** Configuración recibida, sin capacidad ni confirmación comercial. No admite servicio nocturno. */
export function ventanasServicio(fecha, servicio, configuracion, ahora = new Date()) {
  const reloj = relojRestaurante(configuracion.zona, ahora);
  const civil = /^\d{4}-\d{2}-\d{2}$/.test(fecha) && new Date(`${fecha}T12:00:00Z`);
  if (!civil || Number.isNaN(civil.valueOf()) || civil.toISOString().slice(0, 10) !== fecha || fecha < reloj.fecha) return { estado: "fecha-invalida", horas: [] };
  const excepcion = configuracion.excepciones?.[fecha];
  const apertura = excepcion && Object.hasOwn(excepcion, "apertura") ? excepcion.apertura : configuracion.semana[civil.getUTCDay()];
  const regla = excepcion?.servicios?.[servicio] ?? configuracion.servicios[servicio];
  if (!apertura || !regla || regla.habilitado === false) return { estado: "cerrado", horas: [] };
  const inicio = aMinutos(apertura.desde);
  const cierre = aMinutos(apertura.hasta);
  // El cierre es exclusivo, incluso cuando una excepción acorta la jornada.
  const fin = Math.min(cierre - 1, cierre - (regla.duracion ?? 0), aMinutos(regla.ultima ?? apertura.hasta));
  const paso = regla.intervalo;
  if (!Number.isSafeInteger(paso) || paso < 1 || !Number.isSafeInteger(regla.anticipacion ?? 0) || (regla.anticipacion ?? 0) < 0 || !Number.isSafeInteger(regla.duracion ?? 0) || (regla.duracion ?? 0) < 0 || fin < inicio) throw new TypeError("Regla de servicio inválida.");
  const horas = [];
  for (let minuto = inicio; minuto <= fin; minuto += paso) {
    if (fecha === reloj.fecha && minuto <= reloj.minutos + (regla.anticipacion ?? 0)) continue;
    horas.push(aHora(minuto));
  }
  return { estado: horas.length ? "disponible" : "sin-horas", horas };
}

/** Valida de nuevo al revisar/confirmar: disabled/min/max no son autoridad. */
export function validarHorario(fecha, hora, servicio, configuracion, ahora = new Date()) {
  return ventanasServicio(fecha, servicio, configuracion, ahora).horas.includes(hora);
}

export function describirHora(hora) {
  const minutos = aMinutos(hora);
  const h = Math.floor(minutos / 60);
  return `${h % 12 || 12}:${String(minutos % 60).padStart(2, "0")} ${h < 12 ? "AM" : "PM"}`;
}
