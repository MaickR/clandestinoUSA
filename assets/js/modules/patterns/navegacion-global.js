import Collapse from "bootstrap/js/src/collapse.js";
import Offcanvas from "bootstrap/js/src/offcanvas.js";

const inicializados = new WeakMap();

/** Un único árbol responsive; Bootstrap conserva trap, backdrop, Escape y scroll. */
export function inicializarNavegacion(contenedor, { raizScroll = null } = {}) {
  if (!(contenedor instanceof HTMLElement)) throw new TypeError("Se requiere un contenedor de navegación.");
  if (inicializados.has(contenedor)) return inicializados.get(contenedor);
  const buscar = (nombre) => contenedor.querySelector(`[data-cl-${nombre}]`);
  const cabecera = buscar("cabecera");
  const testigo = buscar("cabecera-testigo");
  const boton = buscar("nav-control");
  const panel = buscar("nav-panel");
  const expandir = buscar("nav-expandir");
  const subpanel = buscar("nav-subpanel");
  const origen = buscar("nav-origen");
  const cierre = buscar("nav-cierre");
  const tituloPanel = buscar("nav-cabecera");
  const piePanel = buscar("nav-pie");
  if (![cabecera, testigo, boton, panel, expandir, subpanel, origen, cierre, tituloPanel, piePanel].every((nodo) => nodo instanceof HTMLElement)) {
    throw new TypeError("La navegación requiere cabecera, paneles y controles completos.");
  }
  panel.classList.add("offcanvas-xl", "offcanvas-end");
  subpanel.classList.add("collapse");
  boton.hidden = false;
  expandir.hidden = false;
  tituloPanel.hidden = false;
  piePanel.hidden = false;
  const drawer = Offcanvas.getOrCreateInstance(panel);
  const secundaria = Collapse.getOrCreateInstance(subpanel, { toggle: false });
  const eventos = new AbortController();
  const opciones = { signal: eventos.signal };
  const escritorio = window.matchMedia("(min-width: 1200px)");
  let transicion = false;
  let cerrarPendiente = false;
  let destinoPendiente = null;
  let destruccion = null;
  function cerrar() {
    if (transicion) cerrarPendiente = true;
    else drawer.hide();
  }
  boton.addEventListener("click", () => {
    if (!transicion) drawer.toggle(boton);
  }, opciones);
  panel.addEventListener("show.bs.offcanvas", () => {
    transicion = true;
    boton.setAttribute("aria-disabled", "true");
    boton.setAttribute("aria-expanded", "true");
    boton.setAttribute("aria-label", "Close main navigation");
    // Se mueve el mismo activador dentro del trap oficial: una sola X en el DOM.
    cierre.append(boton);
  }, opciones);
  panel.addEventListener("shown.bs.offcanvas", () => {
    transicion = false;
    boton.removeAttribute("aria-disabled");
    if (cerrarPendiente || escritorio.matches) {
      cerrarPendiente = false;
      drawer.hide();
    } else boton.focus();
  }, opciones);
  panel.addEventListener("hide.bs.offcanvas", (evento) => {
    if (transicion) { evento.preventDefault(); cerrarPendiente = true; return; }
    transicion = true;
    boton.setAttribute("aria-disabled", "true");
  }, opciones);
  panel.addEventListener("hidden.bs.offcanvas", () => {
    transicion = false;
    cerrarPendiente = false;
    origen.append(boton);
    boton.removeAttribute("aria-disabled");
    boton.setAttribute("aria-expanded", "false");
    boton.setAttribute("aria-label", "Open main navigation");
    secundaria.hide();
    if (destinoPendiente) {
      destinoPendiente.focus({ preventScroll: true });
      destinoPendiente.scrollIntoView({ block: "start" });
      destinoPendiente = null;
    } else if (escritorio.matches) expandir.focus();
    else boton.focus({ preventScroll: true });
  }, opciones);
  // Captura local: Discover cierra antes de que Escape llegue al Offcanvas oficial.
  cabecera.addEventListener("keydown", (evento) => {
    if (evento.key === "Escape" && subpanel.classList.contains("show")) {
      evento.preventDefault();
      evento.stopPropagation();
      secundaria.hide();
      expandir.focus();
    }
  }, { ...opciones, capture: true });
  cabecera.addEventListener("click", (evento) => {
    const enlace = evento.target.closest("a[href]");
    if (!enlace || !cabecera.contains(enlace)) return;
    const url = new URL(enlace.href);
    const local = url.origin === location.origin && url.pathname === location.pathname && url.search === location.search;
    const destino = local && url.hash ? document.getElementById(decodeURIComponent(url.hash.slice(1))) : null;
    secundaria.hide();
    if (!escritorio.matches && (panel.classList.contains("show") || transicion)) {
      destinoPendiente = destino;
      cerrar();
    } else if (destino) destino.focus({ preventScroll: true });
  }, opciones);
  cabecera.addEventListener("focusout", (evento) => {
    if (escritorio.matches && evento.relatedTarget && !cabecera.contains(evento.relatedTarget)) secundaria.hide();
  }, opciones);
  contenedor.addEventListener("click", (evento) => {
    if (escritorio.matches && !cabecera.contains(evento.target)) secundaria.hide();
  }, opciones);
  const observador = new IntersectionObserver(([entrada]) => {
    cabecera.classList.toggle("cl-cabecera--fijada", !entrada.isIntersecting && entrada.boundingClientRect.top < (entrada.rootBounds?.top ?? 0));
  }, { root: raizScroll });
  observador.observe(testigo);
  const medidas = new ResizeObserver(() => {
    contenedor.style.setProperty("--navegacion-offset", `${cabecera.getBoundingClientRect().height}px`);
  });
  medidas.observe(cabecera);
  const control = {
    destruir() {
      if (destruccion) return destruccion;
      destruccion = (async () => {
        if (panel.classList.contains("show") || transicion) {
          await new Promise((resolver) => {
            panel.addEventListener("hidden.bs.offcanvas", resolver, { once: true });
            cerrar();
          });
        }
        if (subpanel.classList.contains("collapsing")) {
          await new Promise((resolver) => {
            const terminar = () => {
              subpanel.removeEventListener("shown.bs.collapse", terminar);
              subpanel.removeEventListener("hidden.bs.collapse", terminar);
              resolver();
            };
            subpanel.addEventListener("shown.bs.collapse", terminar);
            subpanel.addEventListener("hidden.bs.collapse", terminar);
          });
        }
        eventos.abort();
        observador.disconnect();
        medidas.disconnect();
        drawer.dispose();
        secundaria.dispose();
        panel.classList.remove("offcanvas-xl", "offcanvas-end");
        subpanel.classList.remove("collapse", "show");
        boton.hidden = true;
        expandir.hidden = true;
        tituloPanel.hidden = true;
        piePanel.hidden = true;
        contenedor.style.removeProperty("--navegacion-offset");
        cabecera.classList.remove("cl-cabecera--fijada");
        inicializados.delete(contenedor);
      })();
      return destruccion;
    },
  };
  inicializados.set(contenedor, control);
  return control;
}
