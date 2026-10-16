import { crearAlerta } from "../core/alerta.js";
import { inicializarBotonCarga } from "../core/boton-carga.js";
import { inicializarAcordeon } from "../core/acordeon.js";

const porId = (id) => document.getElementById(id);

/** Mensajes asociados al campo; no sustituye validación comercial en servidor. */
function mostrarError(campo, mensaje, idError = `${campo.id}-error`) {
  const error = porId(idError);
  error.textContent = mensaje;
  error.hidden = !mensaje;
  campo.classList.toggle("cl-campo--error", Boolean(mensaje));
  if (mensaje) campo.setAttribute("aria-invalid", "true");
  else campo.removeAttribute("aria-invalid");
}

function validarSeleccion(formulario, nombre, errorId, mensaje) {
  const campos = [...formulario.querySelectorAll(`input[name="${nombre}"]`)];
  const valido = campos.some((campo) => campo.checked);
  for (const campo of campos) mostrarError(campo, valido ? "" : mensaje, errorId);
  return valido ? null : campos[0];
}

/** Ciclo local de demostración: sin requests, almacenamiento ni datos comerciales. */
function conectarDemo(id, { validar, actualizar, confirmar }) {
  const formulario = porId(`${id}-demo`);
  const boton = formulario.querySelector("[data-cl-demo-enviar]");
  const carga = inicializarBotonCarga(boton);
  const desenlace = porId(`${id}-outcome`);
  const feedback = porId(`${id}-feedback`);
  const confirmacion = formulario.querySelector("[data-cl-demo-confirmacion]");
  const controles = [...formulario.querySelectorAll("input, select, textarea, button[type=reset]")];
  let enCurso = false;
  let validado = false;
  function informar(mensaje, variante = "informacion") {
    feedback.replaceChildren(crearAlerta({ mensaje, variante }));
  }
  boton.disabled = false;
  formulario.addEventListener("input", () => {
    if (enCurso) return;
    actualizar();
    if (validado) validar();
    confirmacion.hidden = true;
    informar("Preview updated. Use the demo action to continue; nothing is sent.");
  });
  formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();
    if (enCurso) return;
    validado = true;
    const invalido = validar();
    if (invalido) {
      confirmacion.hidden = true;
      informar("Check the highlighted fields, then try again. Nothing has been sent.", "error");
      invalido.focus();
      return;
    }
    // Capturar el resumen antes de bloquear campos; no conservar datos tras recargar.
    const resumen = confirmar();
    const falla = desenlace.value === "error";
    enCurso = true;
    confirmacion.hidden = true;
    carga.establecerCarga(true);
    formulario.setAttribute("aria-busy", "true");
    for (const control of controles) control.disabled = true;
    desenlace.disabled = true;
    informar("Working on the local demonstration… Nothing is being sent.");
    window.setTimeout(() => {
      enCurso = false;
      carga.establecerCarga(false);
      formulario.removeAttribute("aria-busy");
      for (const control of controles) control.disabled = false;
      desenlace.disabled = false;
      if (falla) {
        informar("Demo action failed. Your entries are kept. Choose Success in Demo controls and try again.", "error");
      } else {
        confirmacion.textContent = resumen;
        confirmacion.hidden = false;
        informar("Demonstration completed. No payment, membership, gift, booking or inquiry was created.", "exito");
      }
    }, 1600);
  });
  formulario.addEventListener("reset", (evento) => {
    if (enCurso) { evento.preventDefault(); return; }
    validado = false;
    // El evento reset precede a la restauración nativa de los controles.
    queueMicrotask(() => {
      for (const campo of formulario.querySelectorAll("[aria-invalid]")) {
        campo.removeAttribute("aria-invalid");
        campo.classList.remove("cl-campo--error");
      }
      for (const error of formulario.querySelectorAll(".cl-mensaje-campo")) { error.hidden = true; error.textContent = ""; }
      confirmacion.hidden = true;
      actualizar();
      informar("Demo cleared. Nothing was sent or stored.");
      boton.focus();
    });
  });
  actualizar();
}

function iniciarMembresia() {
  const formulario = porId("club-demo");
  const seleccion = () => formulario.querySelector("input:checked")?.value;
  const nivel = () => formulario.querySelector("input:checked")?.closest("[data-cl-plan]");
  const nombre = () => nivel().querySelector("h3").textContent;
  conectarDemo("club", {
    validar: () => validarSeleccion(formulario, "club-plan-demo", "club-plan-error", "Select Gold or Diamond for this demo."),
    actualizar: () => {
      porId("club-summary").textContent = seleccion()
        ? `${nombre()} selected · example. ${nivel().querySelector(".cl-membresia__precio").innerText.replace(/\s+/g, " ").trim()}. Benefits unconfirmed.`
        : "No membership selected.";
    },
    confirmar: () => `${nombre()} selection completed · demonstration only. No enrollment, payment or renewal is scheduled.`,
  });
}

function iniciarRegalo() {
  const formulario = porId("gift-demo");
  const importe = () => formulario.querySelector("input[type=radio]:checked")?.value;
  const nombre = porId("gift-recipient");
  const mensaje = porId("gift-message");
  conectarDemo("gift", {
    validar: () => {
      const primero = validarSeleccion(formulario, "gift-amount-demo", "gift-amount-error", "Choose one of the six gift amounts.");
      for (const campo of [nombre, mensaje]) mostrarError(campo, campo.validity.tooLong ? "Shorten this text to the indicated limit." : "");
      return primero || [nombre, mensaje].find((campo) => !campo.validity.valid) || null;
    },
    actualizar: () => {
      porId("gift-preview-amount").textContent = importe() ? `$${importe()} USD` : "Choose an amount";
      porId("gift-preview-amount").classList.toggle("cl-regalo__importe--pendiente", !importe());
      porId("gift-preview-name").textContent = nombre.value.trim() || "someone special";
      porId("gift-preview-message").textContent = mensaje.value.trim() || "A little Spain. A moment to share.";
      porId("gift-summary").textContent = importe() ? `One gift · $${importe()} USD · example selection. Delivery and policies pending.` : "No amount selected.";
    },
    confirmar: () => `Gift request preview completed · $${importe()} USD example. No card was issued, purchased or delivered.`,
  });
  const presentacion = porId("gift-format-demo");
  presentacion.addEventListener("change", () => {
    porId("gift-preview-format").textContent = `Design preview · ${presentacion.selectedOptions[0].textContent}`;
  });
}

function iniciarEvento() {
  const formulario = porId("event-demo");
  conectarDemo("event", {
    validar: () => validarSeleccion(formulario, "event-choice-demo", "event-choice-error", "Select the hypothetical event first."),
    actualizar: () => {
      porId("event-summary").textContent = porId("event-choice").checked ? "A journey through Spanish wine · May 18, 2028 · 6:00 PM PDT · example selected. No seat held." : "No event selected.";
    },
    confirmar: () => "Event selection completed · hypothetical event, May 18, 2028. This is not a reservation or a ticket.",
  });
}

function fechaRestaurante() {
  // La fecha preferida corresponde a Mount Shasta, independientemente del cliente.
  const partes = new Intl.DateTimeFormat("en-US", { timeZone: "America/Los_Angeles", year: "numeric", month: "2-digit", day: "2-digit" }).formatToParts(new Date());
  const valor = (tipo) => partes.find((parte) => parte.type === tipo).value;
  return `${valor("year")}-${valor("month")}-${valor("day")}`;
}

function iniciarConsulta() {
  const formulario = porId("private-demo");
  const campos = [...formulario.querySelectorAll("input, select, textarea")];
  const fecha = porId("private-date");
  fecha.min = fechaRestaurante();
  conectarDemo("private", {
    validar: () => {
      fecha.min = fechaRestaurante();
      let primero = null;
      for (const campo of campos) {
        let mensaje = "";
        if (campo.required && !campo.value.trim()) mensaje = "Complete this required field.";
        else if (campo.id === "private-date" && (!campo.validity.valid || campo.value < fecha.min)) mensaje = "Choose today or a future restaurant local date. Availability is not checked.";
        else if (campo.type === "email" && !campo.validity.valid) mensaje = "Enter a complete example email, such as guest@example.com.";
        else if (campo.type === "number" && !campo.validity.valid) mensaje = "Enter a whole number of guests, at least 1. Capacity is not checked.";
        else if (!campo.validity.valid) mensaje = "Check this field and its length limit.";
        mostrarError(campo, mensaje);
        if (mensaje && !primero) primero = campo;
      }
      return primero;
    },
    actualizar: () => {
      const ocasion = porId("private-occasion");
      porId("private-summary").textContent = ocasion.value
        ? `${ocasion.selectedOptions[0].textContent} · ${porId("private-guests").value ? `${porId("private-guests").value} guests` : "Guest count pending"} · ${fecha.value || "Date pending"}. Inquiry preview only.`
        : "Your inquiry preview is empty.";
    },
    confirmar: () => "Inquiry received · demonstration only. Awaiting a response is a future visual state; no message was sent and no reservation is confirmed.",
  });
}

function iniciarEstados() {
  for (const ficha of document.querySelectorAll("[data-cl-estado-comercial]")) {
    const selector = ficha.querySelector("select");
    const feedback = ficha.querySelector("[data-cl-estado-feedback]");
    const reintentar = ficha.querySelector("[data-cl-estado-reintentar]");
    function actualizar() {
      const opcion = selector.selectedOptions[0];
      feedback.replaceChildren(crearAlerta({ titulo: `${opcion.textContent} · example`, mensaje: opcion.dataset.clMensaje, variante: opcion.dataset.clVariante }));
      ficha.querySelector("[data-cl-estado-skeleton]").hidden = selector.value !== "loading";
      if (reintentar) {
        reintentar.hidden = selector.value !== "error";
        ficha.querySelector("[data-cl-estado-volver]").hidden = selector.value !== "empty";
        ficha.querySelector("[data-cl-estado-no-disponible]").hidden = !["sold", "ended", "cancelled", "tba", "rescheduled", "soon"].includes(selector.value);
      }
    }
    selector.addEventListener("change", actualizar);
    reintentar?.addEventListener("click", () => { selector.value = "available"; actualizar(); selector.focus(); });
    actualizar();
  }
}

/** Conecta exclusivamente los ejemplos presentes en Patterns Wave 4. */
export function inicializarComercialGuia() {
  if (!porId("wave-4")) return;
  for (const panel of document.querySelectorAll("#club-faq .collapse, #event-details .collapse")) inicializarAcordeon(panel);
  iniciarMembresia();
  iniciarRegalo();
  iniciarEvento();
  iniciarConsulta();
  iniciarEstados();
}
