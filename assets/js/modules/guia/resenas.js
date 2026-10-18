import { inicializarBotonCarga } from "../core/boton-carga.js";
import { crearAlerta } from "../core/alerta.js";

function inicializarListado(raiz) {
  const lista = raiz.querySelector("[data-cl-resenas-items]");
  const entradas = [...lista.children];
  const filtro = raiz.querySelector("[data-cl-resenas-filtro]");
  const orden = raiz.querySelector("[data-cl-resenas-orden]");
  const reset = raiz.querySelector("[data-cl-resenas-reset]");
  const mas = raiz.querySelector("[data-cl-resenas-mas]");
  const disponibilidad = raiz.querySelector("[data-cl-resenas-disponibilidad]");
  const contador = raiz.querySelector("[data-cl-resenas-contador]");
  let limite = 3;

  function representar() {
    const listo = disponibilidad.value === "ready";
    const seleccion = entradas.filter((entrada) => filtro.value === "all" || entrada.dataset.clResenaPuntuacion === filtro.value);
    seleccion.sort((a, b) => {
      const puntuacionA = Number(a.dataset.clResenaPuntuacion);
      const puntuacionB = Number(b.dataset.clResenaPuntuacion);
      if (orden.value === "highest") return puntuacionB - puntuacionA;
      if (orden.value === "lowest") return puntuacionA - puntuacionB;
      const fechaA = a.dataset.clResenaFecha;
      const fechaB = b.dataset.clResenaFecha;
      if (!fechaA || !fechaB) return Number(!fechaA) - Number(!fechaB);
      return orden.value === "oldest" ? fechaA.localeCompare(fechaB) : fechaB.localeCompare(fechaA);
    });
    for (const entrada of entradas) entrada.hidden = true;
    for (const [indice, entrada] of seleccion.entries()) {
      lista.append(entrada);
      entrada.hidden = !listo || indice >= limite;
    }
    for (const control of [filtro, orden, reset]) control.disabled = !listo;
    lista.hidden = !listo || seleccion.length === 0;
    raiz.querySelector("[data-cl-resenas-vacio]").hidden = !listo || seleccion.length > 0;
    raiz.querySelector("[data-cl-resenas-error]").hidden = disponibilidad.value !== "error";
    raiz.querySelector("[data-cl-resenas-carga]").hidden = disponibilidad.value !== "loading";
    mas.hidden = !listo || seleccion.length <= limite;
    contador.textContent = listo ? `${seleccion.length} fictional ${seleccion.length === 1 ? "review" : "reviews"} · ${Math.min(limite, seleccion.length)} shown of ${entradas.length} total. No real guest data.` : "Example collection unavailable. Filters retained.";
  }

  for (const control of [filtro, orden]) control.addEventListener("change", () => { limite = 3; representar(); });
  disponibilidad.disabled = false;
  disponibilidad.addEventListener("change", representar);
  reset.addEventListener("click", () => { filtro.value = "all"; orden.value = "newest"; limite = 3; representar(); });
  mas.addEventListener("click", () => {
    const anteriores = new Set(entradas.filter((entrada) => !entrada.hidden));
    limite += 3;
    representar();
    // El botón desaparece al terminar; llevar foco a la primera entrada revelada.
    const primera = [...lista.children].find((entrada) => !entrada.hidden && !anteriores.has(entrada));
    const titulo = primera?.querySelector("h3");
    if (titulo) { titulo.tabIndex = -1; titulo.focus(); }
  });
  raiz.querySelector("[data-cl-resenas-recuperar]").addEventListener("click", () => {
    disponibilidad.value = "ready";
    representar();
    filtro.focus();
  });
  representar();
}

function inicializarFormulario(formulario) {
  const radios = [...formulario.querySelectorAll('[name="puntuacion"]')];
  const texto = formulario.elements.texto;
  const aviso = formulario.elements.aviso;
  const enviar = formulario.querySelector('[type="submit"]');
  const limpiar = formulario.querySelector('[type="reset"]');
  const resultado = formulario.querySelector("[data-cl-resena-resultado]");
  const feedback = formulario.querySelector("[data-cl-resena-feedback]");
  const contador = formulario.querySelector("[data-cl-resena-contador]");
  const puntuacionActual = formulario.querySelector("[data-cl-resena-puntuacion-actual]");
  const carga = inicializarBotonCarga(enviar);
  let esperando = false;
  let validarAlEditar = false;
  let simulacionTerminada = false;

  function actualizarPuntuacion() {
    const elegido = radios.find((radio) => radio.checked);
    puntuacionActual.textContent = elegido ? `${elegido.value} out of 5 stars selected.` : "No rating selected.";
  }

  function editarBorrador() {
    if (!simulacionTerminada || esperando) return;
    // Un solo anuncio al volver a editar; no repetirlo en cada pulsación.
    simulacionTerminada = false;
    mensaje("Draft updated. Run the simulation again; no review has been sent, saved or published.");
  }

  function longitud() { return [...texto.value.trim()].length; }
  function mostrarError(controles, id, invalido) {
    formulario.querySelector(`#${id}`).hidden = !invalido;
    for (const control of controles) {
      control.setAttribute("aria-invalid", String(invalido));
      control.classList.toggle("cl-campo--error", invalido && control === texto);
    }
  }
  function validar() {
    const sinPuntuacion = !radios.some((radio) => radio.checked);
    const textoInvalido = longitud() < 20 || longitud() > 1000;
    mostrarError(radios, "resena-puntuacion-error", sinPuntuacion);
    mostrarError([texto], "resena-texto-error", textoInvalido);
    mostrarError([aviso], "resena-aviso-error", !aviso.checked);
    return sinPuntuacion ? radios[0] : textoInvalido ? texto : !aviso.checked ? aviso : null;
  }
  function actualizarContador() {
    const cantidad = longitud();
    contador.textContent = `${cantidad.toLocaleString("en-US")} / 1,000 characters${cantidad > 1000 ? " · Too long" : ""}`;
    if (validarAlEditar) validar();
  }
  function mensaje(mensajeTexto, variante = "informacion") {
    feedback.replaceChildren(crearAlerta({ mensaje: mensajeTexto, variante }));
  }
  for (const control of [enviar, limpiar, resultado]) control.disabled = false;
  puntuacionActual.hidden = false;
  actualizarPuntuacion();
  texto.addEventListener("input", () => { actualizarContador(); editarBorrador(); });
  for (const radio of radios) radio.addEventListener("change", () => { actualizarPuntuacion(); editarBorrador(); });
  aviso.addEventListener("change", editarBorrador);
  formulario.addEventListener("change", () => { if (validarAlEditar) validar(); });
  formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();
    if (esperando) return;
    validarAlEditar = true;
    const primerError = validar();
    if (primerError) {
      mensaje("Please correct the marked fields. No review was submitted.", "error");
      primerError.focus();
      return;
    }
    esperando = true;
    simulacionTerminada = false;
    carga.establecerCarga(true);
    formulario.setAttribute("aria-busy", "true");
    for (const control of [...radios, texto, aviso, limpiar, resultado]) control.disabled = true;
    mensaje("Simulating your submission locally. Nothing is being sent.");
    window.setTimeout(() => {
      esperando = false;
      carga.establecerCarga(false);
      formulario.removeAttribute("aria-busy");
      for (const control of [...radios, texto, aviso, limpiar, resultado]) control.disabled = false;
      simulacionTerminada = true;
      mensaje(resultado.value === "error" ? "Simulation failed. Your rating and text are retained. Try again; no real review was sent or published." : "Submission simulated · Pending moderation. No real review was sent, saved or published. Your example remains here for editing.", resultado.value === "error" ? "error" : "exito");
    }, 1200);
  });
  formulario.addEventListener("reset", (evento) => {
    if (esperando) { evento.preventDefault(); return; }
    validarAlEditar = false;
    simulacionTerminada = false;
    for (const control of [...radios, texto, aviso]) { control.removeAttribute("aria-invalid"); control.classList.remove("cl-campo--error"); }
    for (const id of ["resena-puntuacion-error", "resena-texto-error", "resena-aviso-error"]) formulario.querySelector(`#${id}`).hidden = true;
    // El evento reset precede al restablecimiento nativo de los campos.
    contador.textContent = "0 / 1,000 characters";
    puntuacionActual.textContent = "No rating selected.";
    mensaje("Example cleared. No review was sent, saved or published.");
    radios[0].focus();
  });
}

function inicializarEstados(raiz) {
  const selector = raiz.querySelector("select");
  const vista = raiz.querySelector("[data-cl-resenas-vista]");
  const reintentar = raiz.querySelector("[data-cl-resenas-reintentar]");
  const estados = {
    empty: ["No ratings yet", "No average or stars are shown until published ratings are available."],
    partial: ["Rating details incomplete", "Some source records are missing. No reliable average or distribution can be shown."],
    source: ["Source unavailable", "The original source cannot be checked. No cached score is presented as current."],
    loading: ["Loading ratings · example", "Static loading demonstration. No request is running and no score is displayed."],
    error: ["Ratings could not be loaded", "Demonstration error. Retry to return to the no-data example."],
  };
  function representar() {
    const [titulo, descripcion] = estados[selector.value];
    vista.querySelector("h3").textContent = titulo;
    vista.querySelector("p").textContent = descripcion;
    vista.classList.toggle("cl-estado-vista--error", selector.value === "error");
    raiz.querySelector("[data-cl-resenas-skeleton]").hidden = selector.value !== "loading";
    reintentar.hidden = !["error", "source"].includes(selector.value);
  }
  selector.disabled = false;
  selector.addEventListener("change", representar);
  reintentar.addEventListener("click", () => { selector.value = "empty"; representar(); selector.focus(); });
}

/** Conecta únicamente demos locales; no persiste ni solicita datos. */
export function inicializarResenasGuia() {
  for (const raiz of document.querySelectorAll("[data-cl-resenas-listado]")) inicializarListado(raiz);
  for (const formulario of document.querySelectorAll("[data-cl-resena-formulario]")) inicializarFormulario(formulario);
  for (const raiz of document.querySelectorAll("[data-cl-resenas-estado]")) inicializarEstados(raiz);
}
