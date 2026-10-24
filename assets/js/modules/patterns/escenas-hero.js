const inicializados = new WeakMap();

/** Escenas superpuestas; independiente de las colecciones Scroll Snap de Waves 3/5. */
export function inicializarEscenasHero(contenedor) {
  if (!(contenedor instanceof HTMLElement)) throw new TypeError("Hero requiere un contenedor.");
  if (inicializados.has(contenedor)) return inicializados.get(contenedor);
  const pista = contenedor.querySelector("[data-cl-escenas-pista]");
  const controles = contenedor.querySelector("[data-cl-escenas-controles]");
  const pausa = contenedor.querySelector("[data-cl-escenas-pausa]");
  const posicion = contenedor.querySelector("[data-cl-escenas-posicion]");
  const indicadores = [...contenedor.querySelectorAll("[data-cl-escenas-indice]")];
  const escenas = [...(pista?.children ?? [])];
  if (!escenas.length || !controles || !pausa || !posicion || indicadores.length !== escenas.length) throw new TypeError("Escenas incompletas.");
  const eventos = new AbortController();
  const reducido = matchMedia("(prefers-reduced-motion: reduce)");
  const pausas = new Set(["intersection"]);
  const estados = {
    "reduced-motion": "disabled-reduced-motion", user: "paused-user", error: "paused-image-error",
    hidden: "paused-hidden-document", intersection: "paused-out-of-view", focus: "paused-focus", hover: "paused-hover",
  };
  if (reducido.matches) pausas.add("reduced-motion");
  if (document.hidden) pausas.add("hidden");
  if (contenedor.contains(document.activeElement)) pausas.add("focus");
  if (matchMedia("(hover: hover)").matches && contenedor.matches(":hover")) pausas.add("hover");
  let actual = Math.max(0, escenas.findIndex(escena => escena.classList.contains("cl-hero__diapositiva--activa")));
  let solicitud = 0;
  let revisionPausas = 0;
  let temporizador = null;
  let destruido = false;
  let cargando = false;
  let puntero = null;

  function programar() {
    clearTimeout(temporizador);
    temporizador = null;
    const causa = Object.keys(estados).find(nombre => pausas.has(nombre));
    contenedor.dataset.clEscenasEstado = destruido ? "destroyed" : causa ? estados[causa] : cargando ? "loading" : "running";
    contenedor.dataset.clEscenasPausas = [...pausas].join(" ");
    pausa.textContent = reducido.matches ? "Automatic slides disabled by reduced motion" : pausas.has("user") || pausas.has("error") ? "Resume automatic slides" : "Pause automatic slides";
    pausa.setAttribute("aria-disabled", String(reducido.matches));
    if (destruido || pausas.size || cargando) return;
    temporizador = setTimeout(() => { temporizador = null; irA(actual + 1, false); }, 6500);
  }

  function cambiarPausa(causa, activa) {
    // Un observer repetido o el foco entre hijos no reinician el intervalo.
    if (pausas.has(causa) === activa) return;
    if (activa) pausas.add(causa);
    else pausas.delete(causa);
    revisionPausas++;
    programar();
  }

  async function cargar(escena) {
    const plantilla = escena.querySelector("[data-cl-escenas-imagen]");
    if (plantilla) plantilla.replaceWith(plantilla.content.cloneNode(true));
    const imagen = escena.querySelector("img");
    imagen.loading = "eager";
    await imagen.decode();
  }

  async function irA(indice, manual = true) {
    if (destruido) return;
    if (manual) { cambiarPausa("user", true); cambiarPausa("error", false); }
    const destino = (indice + escenas.length) % escenas.length;
    const turno = ++solicitud;
    const revision = revisionPausas;
    cargando = true;
    programar();
    try { await cargar(escenas[destino]); }
    catch {
      if (turno === solicitud && !destruido) {
        cargando = false;
        posicion.textContent = "This scene could not load. Please try again.";
        cambiarPausa("error", true);
      }
      return;
    }
    if (destruido || turno !== solicitud) return;
    cargando = false;
    // Tras una pausa durante decode, esperar otro intervalo completo antes de rotar.
    if (!manual && (pausas.size || revision !== revisionPausas)) { programar(); return; }
    actual = destino;
    escenas.forEach((escena, numero) => {
      const activa = numero === actual;
      escena.classList.toggle("cl-hero__diapositiva--activa", activa);
      escena.inert = !activa;
      if (activa) escena.removeAttribute("aria-hidden");
      else escena.setAttribute("aria-hidden", "true");
      if (activa) indicadores[numero].setAttribute("aria-current", "true");
      else indicadores[numero].removeAttribute("aria-current");
    });
    if (manual) posicion.textContent = "Slide " + (actual + 1) + " of " + escenas.length + ". " + escenas[actual].querySelector("h2").textContent;
    programar();
  }

  indicadores.forEach((indicador, indice) => indicador.addEventListener("click", () => irA(indice), { signal: eventos.signal }));
  pausa.addEventListener("click", () => {
    if (reducido.matches) return;
    const reanudar = pausas.has("user") || pausas.has("error");
    cambiarPausa("user", !reanudar);
    if (reanudar) cambiarPausa("error", false);
  }, { signal: eventos.signal });
  contenedor.addEventListener("keydown", evento => {
    if (evento.target !== pista || evento.altKey || evento.ctrlKey || evento.metaKey) return;
    if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(evento.key)) return;
    evento.preventDefault();
    irA(evento.key === "Home" ? 0 : evento.key === "End" ? escenas.length - 1 : actual + (evento.key === "ArrowRight" ? 1 : -1));
  }, { signal: eventos.signal });
  // Un tap o scroll no expresa intención de detener la rotación permanentemente.
  pista.addEventListener("pointerdown", evento => {
    if (evento.pointerType === "mouse" || evento.target.closest("a, button")) return;
    puntero = { id: evento.pointerId, x: evento.clientX, y: evento.clientY };
  }, { signal: eventos.signal });
  pista.addEventListener("pointerup", evento => {
    if (!puntero || evento.pointerId !== puntero.id) return;
    const dx = evento.clientX - puntero.x;
    const dy = evento.clientY - puntero.y;
    puntero = null;
    if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy) * 1.4) irA(actual + (dx < 0 ? 1 : -1));
  }, { signal: eventos.signal });
  pista.addEventListener("pointercancel", () => { puntero = null; }, { signal: eventos.signal });
  contenedor.addEventListener("pointerenter", evento => { if (evento.pointerType !== "touch") cambiarPausa("hover", true); }, { signal: eventos.signal });
  contenedor.addEventListener("pointerleave", evento => { if (evento.pointerType !== "touch") cambiarPausa("hover", false); }, { signal: eventos.signal });
  contenedor.addEventListener("focusin", () => cambiarPausa("focus", true), { signal: eventos.signal });
  contenedor.addEventListener("focusout", () => queueMicrotask(() => { if (!destruido) cambiarPausa("focus", contenedor.contains(document.activeElement)); }), { signal: eventos.signal });
  document.addEventListener("visibilitychange", () => cambiarPausa("hidden", document.hidden), { signal: eventos.signal });
  reducido.addEventListener("change", () => cambiarPausa("reduced-motion", reducido.matches), { signal: eventos.signal });
  const observador = new IntersectionObserver(([entrada]) => cambiarPausa("intersection", !entrada.isIntersecting));
  observador.observe(contenedor);
  controles.hidden = false;
  const api = {
    destruir() {
      if (destruido) return;
      destruido = true;
      solicitud++;
      clearTimeout(temporizador);
      temporizador = null;
      eventos.abort();
      observador.disconnect();
      controles.hidden = true;
      programar();
      inicializados.delete(contenedor);
    },
  };
  inicializados.set(contenedor, api);
  programar();
  return api;
}
