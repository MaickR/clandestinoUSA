import { inicializarModal } from "../core/modal.js";
import { inicializarBotonCarga } from "../core/boton-carga.js";
import { crearAlerta } from "../core/alerta.js";

const inicializados = new WeakMap();

/** Interfaz sintética de acceso. No envía, guarda ni autentica credenciales. */
export function inicializarAcceso(contenedor, activador) {
  if (!(contenedor instanceof HTMLElement) || !(activador instanceof HTMLButtonElement)) {
    throw new TypeError("Se requiere modal y activador de acceso existentes.");
  }
  if (inicializados.has(contenedor)) return inicializados.get(contenedor);
  const formulario = contenedor.querySelector("form");
  const email = contenedor.querySelector("#acceso-email");
  const clave = contenedor.querySelector("#acceso-clave");
  const mostrar = contenedor.querySelector("[data-cl-acceso-mostrar]");
  const enviar = contenedor.querySelector("[data-cl-acceso-enviar]");
  const estado = contenedor.querySelector("[data-cl-acceso-estado]");
  const feedback = contenedor.querySelector("[data-cl-acceso-feedback]");
  if (![formulario, email, clave, mostrar, enviar, estado, feedback].every((nodo) => nodo instanceof HTMLElement)) {
    throw new TypeError("El formulario demostrativo está incompleto.");
  }
  const modal = inicializarModal(contenedor, { focoInicial: email });
  const carga = inicializarBotonCarga(enviar);
  let temporizador = null;
  activador.hidden = false;
  mostrar.hidden = false;
  enviar.disabled = false;
  estado.disabled = false;
  const avisar = (mensaje, variante = "informacion") => feedback.replaceChildren(crearAlerta({ mensaje, variante }));
  function ocultarClave() {
    clave.type = "password";
    mostrar.textContent = "Show";
    mostrar.setAttribute("aria-label", "Show password");
    mostrar.setAttribute("aria-pressed", "false");
  }
  function preparar(modo = "ready") {
    window.clearTimeout(temporizador);
    carga.establecerCarga(modo === "loading");
    formulario.setAttribute("aria-busy", String(modo === "loading"));
    email.value = modo === "invalid" ? "invalid-sample" : "guest@example.invalid";
    clave.value = modo === "invalid" ? "demo" : "sample-only";
    for (const campo of [email, clave]) {
      campo.removeAttribute("aria-invalid");
      campo.classList.remove("cl-campo--error");
      contenedor.querySelector(`#${campo.id}-error`).hidden = true;
    }
    feedback.replaceChildren();
    if (modo === "loading") avisar("Loading preview only. No authentication request is running.");
    if (modo === "error") avisar("Example access error. A real service would offer a safe recovery step here.", "error");
    if (modo === "complete") avisar("Interface example complete. No authentication took place and no session exists.", "exito");
  }
  activador.addEventListener("click", () => modal.abrir(activador));
  mostrar.addEventListener("click", () => {
    const visible = clave.type === "password";
    clave.type = visible ? "text" : "password";
    mostrar.textContent = visible ? "Hide" : "Show";
    mostrar.setAttribute("aria-label", visible ? "Hide password" : "Show password");
    mostrar.setAttribute("aria-pressed", String(visible));
  });
  formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();
    if (formulario.getAttribute("aria-busy") === "true") return;
    let primero = null;
    for (const [campo, valido] of [[email, /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)], [clave, clave.value.length >= 8]]) {
      campo.setAttribute("aria-invalid", String(!valido));
      campo.classList.toggle("cl-campo--error", !valido);
      contenedor.querySelector(`#${campo.id}-error`).hidden = valido;
      if (!valido && !primero) primero = campo;
    }
    if (primero) {
      avisar("Please review the sample fields. This demonstration does not submit a sign-in request.", "error");
      primero.focus();
      return;
    }
    carga.establecerCarga(true);
    formulario.setAttribute("aria-busy", "true");
    avisar("Checking the interface sample only…");
    temporizador = window.setTimeout(() => {
      carga.establecerCarga(false);
      formulario.setAttribute("aria-busy", "false");
      avisar("Preview only. The authentication service is not connected; you have not signed in.");
    }, 900);
  });
  estado.addEventListener("change", () => { ocultarClave(); preparar(estado.value); });
  contenedor.addEventListener("hidden.bs.modal", () => {
    estado.value = "ready";
    ocultarClave();
    preparar();
  });
  preparar();
  inicializados.set(contenedor, modal);
  return modal;
}
