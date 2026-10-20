import { crearAlerta } from "../core/alerta.js";

/** Formatea unidades menores: no acepta precios ni cantidades desde HTML comercial. */
export function moneda(centavos, divisa = "USD") {
  if (!Number.isSafeInteger(centavos)) throw new TypeError("El importe debe ser entero seguro.");
  return new Intl.NumberFormat("en-US", { style: "currency", currency: divisa }).format(centavos / 100);
}

/** Feedback compartido sobre Core; una sola región viva por operación. */
export function mostrarResultado(region, titulo, mensaje, variante = "informacion") {
  region.replaceChildren(crearAlerta({ titulo, mensaje, variante }));
}

/** Todos los resúmenes consumen el mismo snapshot; aquí solo se presenta, no se calcula. */
export function pintarImportes(raiz, datos) {
  for (const nodo of raiz.querySelectorAll("[data-cl-importe]")) {
    const clave = nodo.dataset.clImporte;
    const valor = datos[clave];
    nodo.textContent = valor === null ? (nodo.dataset.clPendiente || "Not determined") :
      !datos.valido ? "Review required" : `${clave === "descuento" && valor ? "−" : ""}${moneda(valor, datos.moneda)}`;
  }
}

/** Valida únicamente controles habilitados; asocia cada error y enfoca el primero. */
export function validarFormulario(formulario) {
  let primero = null;
  for (const campo of formulario.querySelectorAll("input, select, textarea")) {
    if (campo.disabled || !campo.willValidate) continue;
    if (["text", "email"].includes(campo.type) && campo.required) {
      campo.setCustomValidity(campo.value.trim() ? "" : "Please enter a value, not only spaces.");
    }
    if (campo.type === "tel") {
      const valor = campo.value.trim();
      campo.setCustomValidity(!valor || (/^\+?[\d\s().-]+$/.test(valor) && /\d/.test(valor)) ? "" : "Use digits and standard phone separators.");
    }
    const valido = campo.checkValidity();
    campo.setAttribute("aria-invalid", String(!valido));
    const error = formulario.querySelector(`[data-cl-error="${campo.id}"]`);
    if (error) {
      const mensajes = { email: "Enter a valid email address.", tel: "Use digits, spaces, +, parentheses or hyphens.", date: "Choose a valid restaurant date, today or later.", time: "Enter a valid requested time." };
      error.textContent = valido ? "" : (campo.dataset.clMensajeError || mensajes[campo.type] || "Please complete this field with a valid value.");
      error.hidden = valido;
    }
    if (!valido && !primero) primero = campo;
  }
  primero?.focus();
  return !primero;
}

/** Una fecha civil no se convierte en instante; comparación ISO independiente del dispositivo. */
export function fechaRestaurante(ahora = new Date()) {
  const partes = new Intl.DateTimeFormat("en-US", {
    timeZone: "America/Los_Angeles", year: "numeric", month: "2-digit", day: "2-digit",
  }).formatToParts(ahora);
  const leer = (tipo) => partes.find((parte) => parte.type === tipo).value;
  return `${leer("year")}-${leer("month")}-${leer("day")}`;
}

/** Presenta fecha civil sin desplazarla de día; no calcula offsets de una reserva. */
export function describirFecha(fecha) {
  if (!/^\d{4}-\d{2}-\d{2}$/.test(fecha)) return "Date not selected";
  const [ano, mes, dia] = fecha.split("-").map(Number);
  return new Intl.DateTimeFormat("en-US", { timeZone: "UTC", dateStyle: "long" })
    .format(new Date(Date.UTC(ano, mes - 1, dia)));
}
