import { gsap } from "gsap/gsap-core";
import { CSSPlugin } from "gsap/CSSPlugin";

const iniciados = new WeakSet();
const revelados = new WeakSet();
const propiedadesMotion = ["translate", "transform", "scale", "rotate", "clip-path", "box-shadow"];

export function inicializarMovimientoExperiences(hero, ciclo) {
  if (ciclo.signal.aborted || iniciados.has(hero)) return false;
  const relato = hero.querySelector(".cl-hero__contenido");
  if (!relato) return false;
  const perfiles = [
    texto(".cl-eyebrow", [10, 8], 0.48, 0),
    texto("h1", [18, 12], 0.68, 0.10),
    texto(".cl-seccion__descripcion", [14, 10], 0.60, 0.23),
  ];
  const grupo = perfiles.map(perfil => ({ ...perfil, elemento: relato.querySelector(perfil.actor) })).filter(perfil => perfil.elemento);
  if (!grupo.length) return false;

  iniciados.add(hero);
  gsap.registerPlugin(CSSPlugin);
  const estilos = grupo.map(({ elemento }) => guardarEstilo(elemento));
  const contexto = gsap.context(() => {}, hero);
  const finalizar = () => ciclo.abort();
  ciclo.signal.addEventListener("abort", () => {
    try {
      contexto.revert();
    } finally {
      for (const estilo of estilos) restaurarEstilo(estilo);
    }
  }, { once: true });

  contexto.add(() => reproducir(grupo, finalizar));
  return true;
}

function guardarEstilo(elemento) {
  return {
    elemento,
    teniaEstilo: elemento.hasAttribute("style"),
    propiedades: propiedadesMotion.map(nombre => [nombre, elemento.style.getPropertyValue(nombre), elemento.style.getPropertyPriority(nombre)]),
  };
}

function restaurarEstilo({ elemento, teniaEstilo, propiedades }) {
  for (const [nombre, valor, prioridad] of propiedades) elemento.style.setProperty(nombre, valor, prioridad);
  if (!teniaEstilo && !elemento.style.cssText) elemento.removeAttribute("style");
}

const bordeCompleto = "inset(0% 0% 0% 0%)";

function texto(actor, [escritorio, movil], duration, desfase) {
  return {
    actor, duration, desfase,
    desde: { y: escritorio }, estrecho: { y: movil }, hasta: { y: 0 },
  };
}

function enfasis(desfase) {
  return {
    actor: ".cl-seccion__acciones a.cl-boton", duration: 0.52, desfase, accion: true,
    desde: { boxShadow: "inset 0 0 0 2px rgba(255, 239, 202, 0.62)" },
    hasta: { boxShadow: "inset 0 0 0 2px rgba(255, 239, 202, 0)" },
  };
}

function reproducir(grupo, terminar) {
  const ancho = matchMedia("(min-width: 992px)").matches;
  const lateral = matchMedia("(min-width: 768px)").matches;
  const secuencia = gsap.timeline({ paused: true, defaults: { ease: "power2.out" },
    onComplete: () => queueMicrotask(terminar), onInterrupt: () => queueMicrotask(terminar) });
  const primero = grupo[0].desfase ?? 0;
  for (const { elemento, desde, estrecho, lateral: desdeLateral, hasta, duration, desfase = 0 } of grupo) {
    const estado = lateral && desdeLateral ? desdeLateral : desde;
    const transformacion = "y" in desde || "scale" in desde;
    secuencia.fromTo(elemento, !ancho && estrecho ? estrecho : estado,
      { ...hasta, duration, immediateRender: false, ...(transformacion ? { force3D: false } : {}) }, desfase - primero);
  }
  secuencia.play();
}

const escenas = [
  [".cl-experiences__introduccion", [
    texto(".cl-eyebrow", [11, 8], 0.49, 0),
    texto("h2", [18, 12], 0.73, 0.10),
    texto(".cl-seccion__descripcion", [14, 9], 0.62, 0.23),
    {
      actor: ".cl-experiences__fotografias", duration: 0.72, desfase: 0.07,
      desde: { clipPath: "polygon(0% 0%, 88% 0%, 82% 100%, 0% 100%)" },
      hasta: { clipPath: "polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)" },
    },
  ]],
  [".cl-experiences__mesa", [
    {
      // Recorte compensado: el acercamiento apenas cambia los límites exteriores del marco.
      actor: ".cl-experiences__mesa-foto img", duration: 0.78,
      desde: { scale: 1.055, clipPath: "inset(2.6% 2.6% 2.6% 2.6% round 4px)" },
      hasta: { scale: 1, clipPath: "inset(0% 0% 0% 0% round 4px)" },
    },
    texto(".cl-eyebrow", [10, 8], 0.47, 0.09),
    texto("h2", [17, 12], 0.68, 0.19),
    texto(".cl-seccion__descripcion", [13, 9], 0.58, 0.31),
    enfasis(0.43),
  ]],
  [".cl-experiences__privadas", [
    texto(".cl-eyebrow", [12, 8], 0.51, 0),
    texto("h2", [21, 14], 0.79, 0.14),
    texto(".cl-seccion__descripcion", [16, 10], 0.67, 0.26),
    enfasis(0.38),
    {
      actor: ".cl-experiences__privadas-escena img", duration: 0.76, desfase: 0.04,
      desde: { xPercent: -2.4, scale: 1.06 }, hasta: { xPercent: 0, scale: 1 },
    },
    ...[2, 3].map(posicion => ({
      actor: `.cl-experiences__privadas-detalle:nth-child(${posicion}) img`, duration: 0.58, desfase: 0.12,
      desde: { clipPath: "inset(0% 11% 0% 0%)" }, hasta: { clipPath: bordeCompleto },
    })),
  ]],
  [".cl-experiences__invitacion", [
    {
      actor: ".cl-banda-cta__imagen", duration: 0.62,
      desde: { clipPath: "inset(0% 11% 0% 0%)" },
      lateral: { clipPath: "inset(0% 0% 0% 11%)" }, hasta: { clipPath: bordeCompleto },
    },
    texto(".cl-eyebrow", [9, 8], 0.50, 0.08),
    texto("h2", [17, 11], 0.72, 0.19),
    texto(".cl-seccion__descripcion", [12, 9], 0.63, 0.31),
    enfasis(0.44),
  ]],
];

export function inicializarReveladosExperiences(contenido, reducido) {
  if (reducido.matches || document.hidden || revelados.has(contenido)
    || typeof IntersectionObserver !== "function") return;
  revelados.add(contenido);
  gsap.registerPlugin(CSSPlugin);

  const pendientes = new Map();
  for (const [selector, perfiles] of escenas) {
    const seccion = contenido.querySelector(selector);
    for (const perfil of perfiles) {
      const elemento = seccion?.querySelector(perfil.actor);
      if (!elemento || (perfil.desde.clipPath && !CSS.supports("clip-path", perfil.desde.clipPath))) continue;
      const imagenes = elemento instanceof HTMLImageElement ? [elemento] : [...elemento.querySelectorAll("img")];
      pendientes.set(elemento, { ...perfil, elemento, seccion, imagenes });
    }
  }
  if (!pendientes.size) return;

  const cabecera = contenido.closest("[data-cl-site]")?.querySelector("[data-cl-cabecera]");
  const eventos = new AbortController();
  const opciones = { signal: eventos.signal };
  const activos = new Set();
  let pausado = true;
  let ultimoScroll = scrollY;
  let mayorScroll = scrollY;
  let observador;
  let limite;

  function retirar(elemento) {
    pendientes.delete(elemento);
    observador?.unobserve(elemento);
  }

  function terminarActivos(seccion) {
    for (const activo of activos) if (!seccion || activo.seccion === seccion) activo.terminar();
  }

  function liberarSiTermino() {
    if (pendientes.size || activos.size) return;
    observador?.disconnect();
    eventos.abort();
  }

  function destruir() {
    pendientes.clear();
    terminarActivos();
    liberarSiTermino();
  }

  function finalizarVisibles(seccion, fondo = innerHeight) {
    // Se leen las posiciones juntas, antes de revertir los estilos de una entrada activa.
    const vistos = [...pendientes.values()].filter(({ elemento, seccion: unidad }) =>
      unidad === seccion || (seccion && (unidad.compareDocumentPosition(seccion) & Node.DOCUMENT_POSITION_FOLLOWING))
      || elemento.getBoundingClientRect().top < fondo);
    for (const { elemento } of vistos) retirar(elemento);
    terminarActivos(seccion);
    liberarSiTermino();
  }

  function destinoActual() {
    try {
      return document.getElementById(decodeURIComponent(location.hash.slice(1)))?.closest("main > section");
    } catch { return null; }
  }

  function comenzar(grupo) {
    const estilos = grupo.map(({ elemento }) => guardarEstilo(elemento));
    const activo = { seccion: grupo[0].seccion, terminar };
    const contexto = gsap.context(() => {}, activo.seccion);
    activos.add(activo);

    function terminar() {
      if (!activos.delete(activo)) return;
      try {
        contexto.revert();
      } finally {
        for (const estilo of estilos) restaurarEstilo(estilo);
        liberarSiTermino();
      }
    }

    contexto.add(() => reproducir(grupo, terminar));
  }

  function admitir(entradas, fuente) {
    if (fuente !== observador || pausado || eventos.signal.aborted) return;
    try {
      const y = scrollY;
      const bajando = y >= mayorScroll - 1;
      mayorScroll = Math.max(mayorScroll, y);
      const { anterior, siguiente } = limite;
      const entrantes = entradas.filter(entrada => entrada.isIntersecting && pendientes.has(entrada.target));
      if (!entrantes.length) return;

      const unidades = new Set(entrantes.map(({ target }) => pendientes.get(target).seccion));
      const lecturas = [...pendientes.values()].filter(({ seccion }) => unidades.has(seccion))
        .map(actor => ({ ...actor, top: actor.elemento.getBoundingClientRect().top }));
      const admitidos = new Map();
      for (const actor of lecturas) {
        if (actor.top > siguiente) continue;
        retirar(actor.elemento);
        if (!bajando || actor.top < anterior || actor.seccion.contains(document.activeElement)
          || (actor.accion && actor.elemento.matches(":hover"))
          || actor.imagenes.some(foto => !foto.complete || !foto.naturalWidth)) continue;
        const grupo = admitidos.get(actor.seccion) || [];
        grupo.push(actor);
        admitidos.set(actor.seccion, grupo);
      }
      for (const grupo of admitidos.values()) comenzar(grupo.sort((a, b) => (a.desfase ?? 0) - (b.desfase ?? 0)));
      liberarSiTermino();
    } catch (error) {
      destruir();
      console.warn("Revelado de Experiences cancelado; contenido visible.", error);
    }
  }

  function ventanaLectura() {
    const inferior = innerHeight;
    const superior = Math.min(Math.round(cabecera?.getBoundingClientRect().height || 0), inferior - 1);
    const util = inferior - superior;
    const linea = Math.round(superior + util * 0.81);
    // Solo se agrupan acompañantes dentro de la franja visible contigua a la línea.
    return { superior, inferior, linea, anterior: linea - Math.min(85, util * 0.13), siguiente: Math.min(inferior - 14, linea + 56) };
  }

  function observar(ventana = ventanaLectura()) {
    observador?.disconnect();
    if (!pendientes.size || pausado || eventos.signal.aborted) return;
    limite = ventana;
    const { superior, inferior, linea } = ventana;
    observador = new IntersectionObserver(admitir, { rootMargin: `-${superior}px 0px -${inferior - linea}px 0px` });
    for (const elemento of pendientes.keys()) observador.observe(elemento);
  }

  function pausar() {
    pausado = true;
    observador?.disconnect();
    terminarActivos();
  }

  function reanudar(inicial = false) {
    if (!pausado || document.hidden || eventos.signal.aborted) return;
    ultimoScroll = scrollY;
    mayorScroll = Math.max(mayorScroll, ultimoScroll);
    const ventana = ventanaLectura();
    const desdeElInicio = inicial && ultimoScroll === 0 && !location.hash;
    finalizarVisibles(destinoActual(), desdeElInicio ? ventana.linea : ventana.inferior);
    pausado = false;
    observar(ventana);
  }

  window.addEventListener("scroll", () => {
    const y = scrollY;
    if (Math.abs(y - ultimoScroll) > innerHeight * 0.5) terminarActivos();
    ultimoScroll = y;
    mayorScroll = Math.max(mayorScroll, y);
  }, { passive: true, ...opciones });
  window.addEventListener("scrollend", () => {
    if (!limite || pausado) return;
    const atrasados = [...pendientes.keys()].filter(elemento => elemento.getBoundingClientRect().top < limite.anterior);
    for (const elemento of atrasados) retirar(elemento);
    liberarSiTermino();
  }, opciones);
  window.addEventListener("hashchange", () => finalizarVisibles(destinoActual()), opciones);
  window.addEventListener("resize", () => {
    finalizarVisibles(destinoActual());
    observar();
  }, opciones);
  window.addEventListener("pagehide", evento => {
    if (evento.persisted) pausar();
    else destruir();
  }, opciones);
  window.addEventListener("pageshow", evento => {
    if (evento.persisted) reanudar();
    else if (scrollY > 0) finalizarVisibles(destinoActual());
  }, opciones);
  document.addEventListener("visibilitychange", () => {
    if (document.hidden) pausar();
    else reanudar();
  }, opciones);
  reducido.addEventListener("change", destruir, opciones);
  contenido.addEventListener("focusin", evento => finalizarVisibles(evento.target.closest("main > section")), opciones);
  contenido.addEventListener("pointerdown", evento => {
    const accion = evento.target.closest("a.cl-boton");
    if (!accion) return;
    retirar(accion);
    terminarActivos(accion.closest("main > section"));
    liberarSiTermino();
  }, { capture: true, ...opciones });
  reanudar(true);
}
