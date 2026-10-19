import Collapse from "bootstrap/js/src/collapse.js";

const inicializados = new WeakMap();

/** Navegación web con disclosures Bootstrap; sin trap ni bloqueo del documento. */
export function inicializarNavegacion(contenedor, { raizScroll = null } = {}) {
  if (!(contenedor instanceof HTMLElement)) throw new TypeError("Se requiere un contenedor de navegación.");
  if (inicializados.has(contenedor)) return inicializados.get(contenedor);
  const cabecera = contenedor.querySelector("[data-cl-cabecera]");
  const testigo = contenedor.querySelector("[data-cl-cabecera-testigo]");
  const boton = contenedor.querySelector("[data-cl-nav-control]");
  const panel = contenedor.querySelector("[data-cl-nav-panel]");
  const expandir = contenedor.querySelector("[data-cl-nav-expandir]");
  const subpanel = contenedor.querySelector("[data-cl-nav-subpanel]");
  const marca = contenedor.querySelector("[data-cl-nav-marca]");
  const filaCabecera = contenedor.querySelector(".cl-cabecera__fila");
  if (![cabecera, testigo, boton, panel, expandir, subpanel, marca, filaCabecera].every((nodo) => nodo instanceof HTMLElement)) {
    throw new TypeError("La navegación requiere cabecera, testigo, controles y paneles.");
  }
  const eventos = new AbortController();
  const opciones = { signal: eventos.signal };
  // Sin JS la navegación queda visible; solo se mejora tras validar el contrato completo.
  panel.classList.add("collapse");
  subpanel.classList.add("collapse");
  boton.hidden = false;
  expandir.hidden = false;
  const movil = Collapse.getOrCreateInstance(panel, { toggle: false });
  const secundaria = Collapse.getOrCreateInstance(subpanel, { toggle: false });
  let destinoPendiente = null;
  let restaurar = false;
  let cerrarTrasAbrir = false;
  function cerrarMovil() {
    if (panel.classList.contains("collapsing")) cerrarTrasAbrir = true;
    else movil.hide();
  }
  panel.addEventListener("shown.bs.collapse", (evento) => {
    if (evento.target === panel && cerrarTrasAbrir) { cerrarTrasAbrir = false; movil.hide(); }
  }, opciones);
  panel.addEventListener("hidden.bs.collapse", (evento) => {
    if (evento.target !== panel) return;
    secundaria.hide();
    if (destinoPendiente) {
      destinoPendiente.focus({ preventScroll: true });
      destinoPendiente.scrollIntoView({ block: "start" });
      destinoPendiente = null;
    } else if (restaurar) boton.focus();
    restaurar = false;
  }, opciones);
  cabecera.addEventListener("keydown", (evento) => {
    if (evento.key !== "Escape") return;
    if (subpanel.classList.contains("show")) {
      secundaria.hide();
      expandir.focus();
    } else if (getComputedStyle(boton).display !== "none" && panel.classList.contains("show")) {
      restaurar = true;
      cerrarMovil();
    } else return;
    evento.preventDefault();
    evento.stopPropagation();
  }, opciones);
  cabecera.addEventListener("click", (evento) => {
    const enlace = evento.target.closest("a[href]");
    if (!enlace || !cabecera.contains(enlace)) return;
    const url = new URL(enlace.href);
    const local = url.origin === location.origin && url.pathname === location.pathname && url.search === location.search;
    const destino = local && url.hash ? document.getElementById(decodeURIComponent(url.hash.slice(1))) : null;
    if (getComputedStyle(boton).display !== "none" && panel.classList.contains("show")) {
      destinoPendiente = destino;
      cerrarMovil();
    } else {
      secundaria.hide();
      if (destino) destino.focus({ preventScroll: true });
    }
  }, opciones);
  cabecera.addEventListener("focusout", (evento) => {
    if (evento.relatedTarget && !cabecera.contains(evento.relatedTarget)) {
      secundaria.hide();
      if (getComputedStyle(boton).display !== "none" && panel.classList.contains("show")) {
        destinoPendiente = evento.relatedTarget;
        cerrarMovil();
      }
    }
  }, opciones);
  contenedor.addEventListener("click", (evento) => {
    if (!cabecera.contains(evento.target)) secundaria.hide();
  }, opciones);
  // Un observer sustituye los listeners de scroll; no cambia las dimensiones del header.
  const observador = new IntersectionObserver(([entrada]) => {
    const sobreViewport = entrada.boundingClientRect.top < (entrada.rootBounds?.top ?? 0);
    cabecera.classList.toggle("cl-cabecera--fijada", !entrada.isIntersecting && sobreViewport);
  }, { root: raizScroll });
  observador.observe(testigo);
  const medidas = new ResizeObserver(() => {
    // El alto cerrado evita que abrir el panel reduzca su propio espacio disponible.
    const fila = marca.getBoundingClientRect();
    const control = boton.getBoundingClientRect();
    const estiloFila = getComputedStyle(filaCabecera);
    const alto = getComputedStyle(boton).display === "none"
      ? cabecera.getBoundingClientRect().height
      : Math.max(fila.height, control.height) + parseFloat(estiloFila.paddingTop)
        + parseFloat(estiloFila.paddingBottom) + parseFloat(getComputedStyle(cabecera).borderBottomWidth);
    contenedor.style.setProperty("--navegacion-offset", `${alto}px`);
  });
  medidas.observe(cabecera);
  let destruccion = null;
  const control = {
    destruir() {
      if (destruccion) return destruccion;
      eventos.abort();
      observador.disconnect();
      medidas.disconnect();
      // Bootstrap conserva callbacks durante la transición; esperar antes de dispose.
      destruccion = Promise.all([panel, subpanel].filter((nodo) => nodo.classList.contains("collapsing")).map((nodo) => new Promise((resolver) => {
        const terminar = () => {
          nodo.removeEventListener("shown.bs.collapse", terminar);
          nodo.removeEventListener("hidden.bs.collapse", terminar);
          resolver();
        };
        nodo.addEventListener("shown.bs.collapse", terminar);
        nodo.addEventListener("hidden.bs.collapse", terminar);
      }))).then(() => {
        movil.dispose();
        secundaria.dispose();
        panel.classList.remove("collapse", "show", "collapsing");
        subpanel.classList.remove("collapse", "show", "collapsing");
        panel.style.removeProperty("height");
        subpanel.style.removeProperty("height");
        boton.hidden = true;
        expandir.hidden = true;
        boton.setAttribute("aria-expanded", "false");
        expandir.setAttribute("aria-expanded", "true");
        cabecera.classList.remove("cl-cabecera--fijada");
        contenedor.style.removeProperty("--navegacion-offset");
        inicializados.delete(contenedor);
      });
      return destruccion;
    },
  };
  inicializados.set(contenedor, control);
  return control;
}
