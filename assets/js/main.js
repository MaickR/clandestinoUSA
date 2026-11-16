import { inicializarNavegacion } from "./modules/patterns/navegacion-global.js";
import { inicializarAcceso } from "./modules/patterns/acceso.js";
import { inicializarModal } from "./modules/core/modal.js";
import { inicializarAnclasLegacy } from "./modules/patterns/anclas-legacy.js";

function esperarPrimerPintado(signal) {
  const pintado = performance.getEntriesByName("first-contentful-paint", "paint")[0];
  if (pintado || !globalThis.PerformanceObserver?.supportedEntryTypes?.includes("paint")) {
    return pintado?.startTime;
  }

  return new Promise(resolve => {
    const observador = new PerformanceObserver(lista => {
      const entrada = lista.getEntriesByName("first-contentful-paint")[0];
      if (entrada) terminar(entrada.startTime);
    });
    const cancelar = () => terminar();
    const terminar = tiempo => {
      observador.disconnect();
      signal.removeEventListener("abort", cancelar);
      resolve(tiempo);
    };
    signal.addEventListener("abort", cancelar, { once: true });
    observador.observe({ type: "paint", buffered: true });
  });
}

async function activarMovimientoExperiences(contenido) {
  const hero = contenido.querySelector(".cl-experiences__hero");
  const foto = hero?.querySelector(".cl-hero__imagen");
  const reducido = matchMedia("(prefers-reduced-motion: reduce)");
  if (reducido.matches || document.hidden || !CSS.supports("translate", "0 1px")) return;

  const carga = new AbortController();
  const terminarCarga = () => carga.abort();
  const eventosCarga = { signal: carga.signal };
  window.addEventListener("pagehide", terminarCarga, eventosCarga);
  document.addEventListener("visibilitychange", terminarCarga, eventosCarga);
  reducido.addEventListener("change", terminarCarga, eventosCarga);

  const ciclo = new AbortController();
  const { signal } = ciclo;
  const cancelar = () => ciclo.abort();
  const puedeEntrar = () => !signal.aborted && !reducido.matches && !document.hidden
    && !location.hash && scrollY === 0 && !contenido.contains(document.activeElement);
  if (!puedeEntrar() || performance.getEntriesByType("navigation")[0]?.type === "back_forward") cancelar();

  // Una interacción o salida de página invalida también un arranque aún pendiente.
  window.addEventListener("scroll", cancelar, { passive: true, signal });
  window.addEventListener("hashchange", cancelar, { signal });
  window.addEventListener("pagehide", cancelar, { signal });
  window.addEventListener("pageshow", evento => {
    if (evento.persisted || scrollY !== 0) cancelar();
  }, { signal });
  contenido.addEventListener("focusin", cancelar, { signal });
  document.addEventListener("visibilitychange", cancelar, { signal });
  reducido.addEventListener("change", cancelar, { signal });

  const inicio = performance.now();
  let animado = false;
  try {
    let fotoLista = false;
    if (puedeEntrar() && typeof foto?.decode === "function") {
      const decodificacion = foto.decode().then(() => { fotoLista = true; }, () => {});
      // Al salir del Hero, una foto pendiente deja de condicionar el resto de la página.
      await Promise.race([decodificacion, new Promise(resolve => {
        signal.addEventListener("abort", resolve, { once: true, signal: carga.signal });
        carga.signal.addEventListener("abort", resolve, { once: true });
      })]);
    }
    if (carga.signal.aborted) return;
    await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));
    if (carga.signal.aborted) return;
    const pintado = await esperarPrimerPintado(carga.signal);
    const limite = (pintado ?? inicio) + 270;
    if (carga.signal.aborted) return;

    const { inicializarMovimientoExperiences, inicializarReveladosExperiences } =
      await import("./modules/patterns/movimiento-experiences.js");
    if (carga.signal.aborted) return;
    if (fotoLista && puedeEntrar() && performance.now() <= limite) {
      animado = inicializarMovimientoExperiences(hero, ciclo);
    }
    inicializarReveladosExperiences(contenido, reducido);
  } catch (error) {
    cancelar();
    if (!carga.signal.aborted) console.warn("Movimiento de Experiences no disponible; contenido visible.", error);
  } finally {
    terminarCarga();
    if (!animado) cancelar();
  }
}

// Inicialización pública optativa; no activa páginas legacy ni lógica comercial.
const pagina = document.querySelector("[data-cl-site]");
if (pagina) {
  const navegacion = inicializarNavegacion(pagina);
  const acceso = pagina.querySelector("[data-cl-acceso]");
  const abrirAcceso = pagina.querySelector("[data-cl-acceso-abrir]");
  if (acceso && abrirAcceso) {
    const modalAcceso = inicializarAcceso(acceso, abrirAcceso);
    navegacion.conectarAccesoPanel("nav-cuenta-panel", () => modalAcceso.abrir(abrirAcceso));
  }
  inicializarAnclasLegacy(pagina);
  // Demostración vacía explícita, sin proveedor comercial ni productos ficticios.
  const carrito = pagina.querySelector("[data-cl-nav-carrito]");
  const aviso = pagina.querySelector("#carrito-preview");
  if (carrito && aviso) {
    navegacion.actualizarCarrito({ unidades: 0, estado: "listo" });
    carrito.setAttribute("aria-controls", "carrito-preview");
    carrito.setAttribute("aria-haspopup", "dialog");
    carrito.setAttribute("data-bs-toggle", "modal");
    carrito.setAttribute("data-bs-target", "#carrito-preview");
    const modalCarrito = inicializarModal(aviso, { focoInicial: aviso.querySelector("button") });
    navegacion.conectarAccesoPanel("nav-carrito-panel", () => modalCarrito.abrir(carrito));
    const carritoPanel = pagina.querySelector("[data-cl-nav-carrito-panel]");
    carritoPanel?.setAttribute("aria-controls", "carrito-preview");
    carritoPanel?.setAttribute("aria-haspopup", "dialog");
  }
  // El módulo del slider se solicita únicamente si el documento contiene escenas.
  if (pagina.querySelector("[data-cl-escenas]")) {
    import("./modules/patterns/escenas-hero.js").then(({ inicializarEscenasHero }) => {
      for (const escenas of pagina.querySelectorAll("[data-cl-escenas]")) inicializarEscenasHero(escenas);
    });
  }
  // Los módulos audiovisuales se descargan solo en documentos con esta colección.
  if (pagina.querySelector("[data-cl-carrusel-media]")) {
    Promise.all([
      import("./modules/patterns/carrusel.js"),
      import("./modules/patterns/carrusel-media.js"),
    ]).then(([{ inicializarCarrusel }, { inicializarMediaCarrusel }]) => {
      for (const coleccion of pagina.querySelectorAll("[data-cl-carrusel-media]")) {
        inicializarMediaCarrusel(coleccion);
        inicializarCarrusel(coleccion);
      }
    });
  }
  if (pagina.matches(".cl-home-preview") && !matchMedia("(prefers-reduced-motion: reduce)").matches) {
    const cargarMovimiento = () => requestAnimationFrame(() => requestAnimationFrame(() => {
      if (document.hidden || matchMedia("(prefers-reduced-motion: reduce)").matches) return;
      import("./modules/patterns/movimiento-home.js")
        .then(({ inicializarMovimientoHome }) => inicializarMovimientoHome(pagina))
        .catch(error => console.warn("Motion Home GSAP no disponible; contenido visible.", error));
    }));
    // El recurso LCP y su primer frame tienen prioridad sobre el motor decorativo.
    const portada = pagina.querySelector("[data-cl-escenas] img");
    if (portada && typeof portada.decode === "function") portada.decode().then(cargarMovimiento, cargarMovimiento);
    else cargarMovimiento();
  }
  const contenidoExperiences = pagina.querySelector("main.cl-experiences");
  if (contenidoExperiences) activarMovimientoExperiences(contenidoExperiences);
}
