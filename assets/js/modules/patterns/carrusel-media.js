const inicializados = new WeakMap();

/** Adaptador de video nativo: no carga fuentes ni sustituye sus controles. */
export function inicializarMediaCarrusel(contenedor) {
  if (!(contenedor instanceof HTMLElement)) throw new TypeError("Media requiere un contenedor.");
  if (inicializados.has(contenedor)) return inicializados.get(contenedor);
  const eventos = new AbortController();
  let destruido = false;
  function pausar(excepto = null) {
    for (const video of contenedor.querySelectorAll("video")) if (video !== excepto) video.pause();
  }
  contenedor.addEventListener("play", (evento) => {
    if (evento.target instanceof HTMLVideoElement) pausar(evento.target);
  }, { capture: true, signal: eventos.signal });
  for (const nombre of ["cl:carrusel-cambio", "cl:carrusel-navegar"]) contenedor.addEventListener(nombre, () => pausar(), { signal: eventos.signal });
  document.addEventListener("visibilitychange", () => { if (document.hidden) pausar(); }, { signal: eventos.signal });
  const observador = new IntersectionObserver((entradas) => {
    if (entradas.some((entrada) => !entrada.isIntersecting)) pausar();
  });
  observador.observe(contenedor);
  const api = {
    destruir() {
      if (destruido) return;
      destruido = true;
      pausar();
      eventos.abort();
      observador.disconnect();
      inicializados.delete(contenedor);
    },
  };
  contenedor.addEventListener("cl:carrusel-destruir", api.destruir, { signal: eventos.signal });
  inicializados.set(contenedor, api);
  return api;
}
