const inicializados = new WeakMap();

/** Navegación de colecciones editoriales; Scroll Snap y contenido siguen siendo nativos. */
export function inicializarCarrusel(contenedor) {
  if (!(contenedor instanceof HTMLElement)) throw new TypeError("Carrusel requiere un contenedor.");
  if (inicializados.has(contenedor)) return inicializados.get(contenedor);
  const pista = contenedor.querySelector("[data-cl-carrusel-pista]");
  const controles = contenedor.querySelector("[data-cl-carrusel-controles]");
  const anterior = controles?.querySelector("[data-cl-carrusel-anterior]");
  const siguiente = controles?.querySelector("[data-cl-carrusel-siguiente]");
  const posicion = controles?.querySelector("[data-cl-carrusel-posicion]");
  if (!pista || !controles || !anterior || !siguiente || !posicion) throw new TypeError("Carrusel incompleto.");
  const elementos = [...pista.children];
  const eventos = new AbortController();
  let cuadro = 0;
  let destruido = false;
  let rangoAnterior = "";
  const reducido = window.matchMedia("(prefers-reduced-motion: reduce)");

  function geometria() {
    const rect = pista.getBoundingClientRect();
    const estilo = getComputedStyle(pista);
    const inicio = rect.left + parseFloat(estilo.paddingLeft);
    const fin = rect.right - parseFloat(estilo.paddingRight);
    const visibles = elementos.map((elemento, indice) => ({ rect: elemento.getBoundingClientRect(), indice }))
      .filter(({ rect: r }) => r.right > inicio + 2 && r.left < fin - 2);
    return { inicio, visibles, maximo: Math.max(0, pista.scrollWidth - pista.clientWidth) };
  }

  function actualizar() {
    const { visibles, maximo } = geometria();
    const foco = document.activeElement;
    anterior.disabled = pista.scrollLeft <= 2;
    siguiente.disabled = pista.scrollLeft >= maximo - 2;
    controles.hidden = elementos.length < 2 || maximo <= 2;
    pista.hidden = elementos.length === 0;
    pista.tabIndex = maximo > 2 ? 0 : -1;
    const primero = visibles[0]?.indice ?? 0;
    const ultimo = visibles.at(-1)?.indice ?? primero;
    posicion.textContent = elementos.length ? `${primero + 1}–${ultimo + 1} of ${elementos.length} in view` : "No items";
    // Al deshabilitar el botón enfocado, mantener una salida de teclado útil.
    if ((foco === anterior && anterior.disabled) || (foco === siguiente && siguiente.disabled)) pista.focus({ preventScroll: true });
    const rango = `${primero}:${ultimo}`;
    if (rango !== rangoAnterior) {
      rangoAnterior = rango;
      contenedor.dispatchEvent(new CustomEvent("cl:carrusel-cambio", { detail: { primero, ultimo } }));
    }
  }

  function programar() {
    if (cuadro || destruido) return;
    cuadro = requestAnimationFrame(() => { cuadro = 0; actualizar(); });
  }

  function irA(indice, suave = true) {
    const elemento = elementos[Math.max(0, Math.min(indice, elementos.length - 1))];
    if (!elemento) return;
    const { inicio, maximo } = geometria();
    const destino = elemento.getBoundingClientRect().left - inicio + pista.scrollLeft;
    contenedor.dispatchEvent(new CustomEvent("cl:carrusel-navegar"));
    pista.scrollTo({ left: Math.max(0, Math.min(destino, maximo)), behavior: suave && !reducido.matches ? "smooth" : "auto" });
    programar();
  }

  function mover(paso) {
    const { inicio } = geometria();
    const actual = elementos.reduce((mejor, elemento, indice) => Math.abs(elemento.getBoundingClientRect().left - inicio) < Math.abs(elementos[mejor].getBoundingClientRect().left - inicio) ? indice : mejor, 0);
    irA(actual + paso);
  }
  anterior.addEventListener("click", () => mover(-1), { signal: eventos.signal });
  siguiente.addEventListener("click", () => mover(1), { signal: eventos.signal });
  pista.addEventListener("scroll", programar, { passive: true, signal: eventos.signal });
  pista.addEventListener("keydown", (evento) => {
    if (evento.target !== pista || evento.altKey || evento.ctrlKey || evento.metaKey) return;
    if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(evento.key)) return;
    evento.preventDefault();
    if (evento.key === "Home") irA(0);
    else if (evento.key === "End") irA(elementos.length - 1);
    else mover(evento.key === "ArrowRight" ? 1 : -1);
  }, { signal: eventos.signal });
  pista.addEventListener("focusin", (evento) => {
    const indice = elementos.findIndex((elemento) => elemento.contains(evento.target));
    if (indice < 0) return;
    const { inicio } = geometria();
    const rect = elementos[indice].getBoundingClientRect();
    if (rect.left < inicio - 2 || rect.right > pista.getBoundingClientRect().right - 2) irA(indice, false);
  }, { signal: eventos.signal });
  const observador = new ResizeObserver(programar);
  observador.observe(pista);
  const api = {
    destruir() {
      if (destruido) return;
      destruido = true;
      eventos.abort();
      observador.disconnect();
      cancelAnimationFrame(cuadro);
      controles.hidden = true;
      inicializados.delete(contenedor);
      contenedor.dispatchEvent(new CustomEvent("cl:carrusel-destruir"));
    },
  };
  inicializados.set(contenedor, api);
  actualizar();
  return api;
}
