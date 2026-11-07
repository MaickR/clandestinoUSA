import { gsap } from "gsap/gsap-core";
import { CSSPlugin } from "gsap/CSSPlugin";
import { ScrollTrigger } from "gsap/ScrollTrigger";

const inicializados = new WeakMap();

// Segundos y px. Los perfiles distinguen voz editorial, fotografía y acción funcional.
const movimiento = {
  lectura: 0.84,
  aireCabecera: 16,
  cohorte: 64,
  stagger: 0.16,
  ease: "power2.out",
  perfiles: {
    eyebrow: { duration: 0.8, distancia: 16, opacity: 0 },
    titulo: { duration: 1.12, distancia: 32, opacity: 0 },
    texto: { duration: 1, distancia: 22, opacity: 0 },
    foto: { duration: 1.25, distancia: 34, opacity: 0.2 },
    accion: { duration: 0.8, distancia: 10, opacity: 1 },
    superficie: { duration: 1.18, distancia: 18, opacity: 1 },
    coleccion: { duration: 1.15, distancia: 26, opacity: 1 },
    datos: { duration: 0.9, distancia: 10, opacity: 1 },
  },
};

/** Timelines por unidad editorial; no modifica wrappers, geometría ni semántica. */
export function inicializarMovimientoHome(pagina) {
  if (!pagina?.matches(".cl-home-preview")) return null;
  if (inicializados.has(pagina)) return inicializados.get(pagina);
  if (!CSS.supports("translate", "0 1px")) return null;
  if (typeof IntersectionObserver !== "function") return null;
  gsap.registerPlugin(CSSPlugin, ScrollTrigger);

  const fichas = [];
  const eventos = new AbortController();
  const pulsadas = new Set();
  const cabecera = pagina.querySelector("[data-cl-cabecera]");
  const contenido = pagina.querySelector("main");
  const reducido = matchMedia("(prefers-reduced-motion: reduce)");
  const medios = gsap.matchMedia();
  let iniciado = false;
  let destruido = false;
  let medidas;
  let preparacion;
  let cuadro = 0;
  let bordeSuperior = (cabecera?.getBoundingClientRect().height || 0) + movimiento.aireCabecera;
  const superior = () => bordeSuperior;
  const lectura = () => superior() + Math.max(0, innerHeight - superior()) * movimiento.lectura;

  function actor(elemento, perfil, posicion = 0, ajustes = {}) {
    return elemento ? { elemento, perfil, ...movimiento.perfiles[perfil], posicion, ...ajustes } : null;
  }
  function grupo(id, ambito, actores, familia = id) {
    const lista = actores.filter(Boolean);
    if (!ambito || !lista.length) return;
    const ficha = { id, ambito, actores: lista, ancla: lista.find(a => a.elemento !== ambito)?.elemento || lista[0].elemento,
      marcador: lista[0].elemento, familia, orden: fichas.length };
    ficha.marcador.dataset.clMotionId = id;
    ficha.marcador.dataset.clMotionState = "UNINITIALIZED";
    for (const a of lista) {
      a.elemento.dataset.clMotionActor = a.perfil;
      a.elemento.dataset.clMotionOwner = id;
    }
    fichas.push(ficha);
  }
  function editorial(id, ambito, { tarjeta = false, corto = false, familia = id } = {}) {
    if (!ambito) return;
    const buscar = selector => ambito.querySelector(selector);
    const titulo = buscar("h2, h3");
    if (titulo) grupo(id + "-titulo", ambito, [
      tarjeta ? actor(ambito, "superficie", 0) : null,
      actor(buscar(".cl-eyebrow"), "eyebrow"),
      actor(titulo, "titulo", 0.14, corto ? { distancia: 22, duration: 1 } : {}),
      actor(buscar(".cl-home-vinos__firma"), "texto", 0.3, { distancia: 14 }),
    ], familia + "-titulo");
    const textos = [...ambito.querySelectorAll(".cl-seccion__descripcion, .cl-home-vinos__entrada")];
    textos.forEach((texto, indice) => grupo(id + "-texto-" + indice, ambito, [
      actor(texto, "texto", 0, corto ? { distancia: 18, duration: 0.95 } : {}),
      indice === textos.length - 1 ? actor(buscar(".cl-seccion__acciones, :scope > a.cl-boton"), "accion", 0.2) : null,
    ], familia + "-texto-" + indice));
  }
  function fotografia(id, ambito, elemento, ajustes = {}, familia = id) {
    grupo(id, ambito, [actor(elemento, "foto", 0, ajustes)], familia);
  }
  function construirMaestras() {
    editorial("discovery-intro", pagina.querySelector(".cl-home-editorial__entrada"));
    pagina.querySelectorAll(".cl-home-editorial__pieza").forEach((pieza, indice) => {
      fotografia("discovery-foto-" + indice, pieza, pieza.querySelector("picture"), {}, "discovery-fotos");
      editorial("discovery-relato-" + indice, pieza.querySelector(".cl-home-editorial__relato"), { familia: "discovery-relatos" });
    });
    editorial("club-intro", pagina.querySelector(".cl-home-club__cabecera"));
    editorial("club-diamond", pagina.querySelector(".cl-home-club__diamante"), { tarjeta: true, familia: "club-tarjetas" });
    editorial("club-gold", pagina.querySelector(".cl-home-club__oro"), { corto: true, familia: "club-tarjetas" });
    fotografia("club-fotografia", pagina.querySelector(".cl-home-club__seleccion"), pagina.querySelector(".cl-home-club__seleccion picture"), { distancia: 26, opacity: 0.35 });
  }
  function construirResto() {
    editorial("pure-soul-identidad", pagina.querySelector(".cl-home-vinos__cabecera"));
    const poster = pagina.querySelector(".cl-home-vinos__protagonista");
    fotografia("pure-soul-poster", poster, poster, { distancia: 22, duration: 1.3, opacity: 0.4 });
    editorial("pure-soul-relato", pagina.querySelector(".cl-home-vinos__relato"));
    // El marco entra una vez; la imagen interior conserva intacto su timeline fotográfico CSS.
    const escenario = pagina.querySelector(".cl-home-privadas__escenario");
    fotografia("private-fotografia", escenario, escenario, { distancia: 24, duration: 1.3, opacity: 0.45 });
    editorial("private", pagina.querySelector(".cl-home-privadas__invitacion"));
    editorial("historias", pagina.querySelector(".cl-home-historias__editorial"));
    const coleccion = pagina.querySelector(".cl-home-historias__coleccion");
    grupo("historias-coleccion", coleccion, [actor(coleccion, "coleccion")]);
    editorial("reserva", pagina.querySelector(".cl-home-reserva__contenido"));
    editorial("gifting-intro", pagina.querySelector(".cl-home-regalos__cabecera"));
    const seleccion = pagina.querySelector(".cl-home-regalos__seleccion");
    fotografia("gifting-hamper-foto", seleccion, seleccion?.querySelector("img"), { distancia: 30, duration: 1.2 });
    grupo("gifting-firma", seleccion, [actor(seleccion?.querySelector("figcaption"), "texto", 0, { distancia: 12, duration: 0.85 })]);
    editorial("gifting-hampers", pagina.querySelector(".cl-home-regalos__hampers"));
    const tarjeta = pagina.querySelector(".cl-home-regalos__tarjeta");
    fotografia("gifting-card-arte", tarjeta, tarjeta?.querySelector("img"), { distancia: 18, duration: 1.1, opacity: 0.35 });
    editorial("gifting-card", tarjeta?.querySelector(".cl-home-regalos__invitacion"), { corto: true });
    const visita = pagina.querySelector(".cl-home-visita");
    fotografia("visita-foto", visita, visita?.querySelector(".cl-banda-cta__media"), { distancia: 28, duration: 1.18, opacity: 0.35 });
    editorial("visita", visita?.querySelector(".cl-banda-cta__contenido"), { corto: true });
    grupo("visita-datos", visita, [actor(visita?.querySelector(".cl-home-visita__datos"), "datos")]);
  }

  function completar(ficha) {
    if (ficha.marcador.dataset.clMotionState === "COMPLETE") return;
    ficha.marcador.dataset.clMotionState = "COMPLETE";
    preparacion?.unobserve(ficha.ancla);
    ficha.trigger?.kill();
    ficha.contexto?.revert();
    pulsadas.delete(ficha);
  }
  function completarTodo() { for (const ficha of fichas) completar(ficha); }
  function completarVisibles(seccion = null) {
    // Leer antes de revertir evita intercalar medidas y escrituras.
    const visibles = fichas.filter(ficha => seccion?.contains(ficha.marcador)
      || ficha.actores.some(a => a.elemento.getBoundingClientRect().top < innerHeight));
    for (const ficha of visibles) completar(ficha);
  }
  function protegerDestino() {
    try { completarVisibles(document.getElementById(decodeURIComponent(location.hash.slice(1)))?.closest("main > section")); }
    catch { completarTodo(); }
  }
  const api = {
    destruir() {
      if (destruido) return;
      destruido = true;
      cancelAnimationFrame(cuadro);
      medidas?.disconnect();
      preparacion?.disconnect();
      completarTodo();
      medios.revert();
      eventos.abort();
    },
  };
  inicializados.set(pagina, api);
  function fallar(error) {
    api.destruir();
    console.warn("Motion Home GSAP cancelado; contenido visible y funcional.", error);
  }
  function refrescar() {
    if (cuadro || destruido) return;
    cuadro = requestAnimationFrame(() => {
      cuadro = 0;
      try {
        ScrollTrigger.refresh();
        // Una carga diferida puede mover un ancla entre el cálculo de ScrollTrigger y onEnter.
        // Reconciliar con la geometría actual; READY conserva su trigger hasta COMPLETE.
        for (const ficha of fichas) if (ficha.marcador.dataset.clMotionState === "READY"
          && ficha.ancla.getBoundingClientRect().top <= lectura()) reproducir(ficha);
      } catch (error) { fallar(error); }
    });
  }
  function reproducir(ficha) {
    if (ficha.marcador.dataset.clMotionState !== "READY" || destruido) return;
    const top = ficha.ancla.getBoundingClientRect().top;
    if (top > lectura() + 2) { refrescar(); return; }
    if (top < superior() || document.hidden || reducido.matches) { completar(ficha); return; }
    const limite = Math.min(innerHeight - 1, lectura() + movimiento.cohorte);
    const cohorte = fichas.filter(otra => otra.familia === ficha.familia && otra.marcador.dataset.clMotionState === "READY"
      && otra.ancla.getBoundingClientRect().top >= superior() && otra.ancla.getBoundingClientRect().top <= limite);
    cohorte.forEach((otra, indice) => {
      if (otra.ambito.contains(document.activeElement) || [...otra.ambito.querySelectorAll("video")].some(v => !v.paused)) {
        completar(otra); return;
      }
      otra.marcador.dataset.clMotionState = "ENTERING";
      otra.timeline.delay(Math.min(indice, 2) * movimiento.stagger).restart(true);
    });
  }

  function preparar(candidatas) {
    const margen = Math.min(48, innerHeight * 0.06);
    // Una sola fase de lectura; el JS síncrono no puede intercalarse con scroll o paint.
    const lote = candidatas.filter(f => f.marcador.dataset.clMotionState === "UNINITIALIZED")
      .map(ficha => ({ ficha, visible: ficha.actores.some(a => a.elemento.getBoundingClientRect().top < innerHeight + margen) }));
    for (const { ficha, visible } of lote) {
      preparacion?.unobserve(ficha.ancla);
      if (visible) { completar(ficha); continue; }
      ficha.contexto = gsap.context(() => {}, ficha.ambito);
      ficha.contexto.add(() => {
        ficha.timeline = gsap.timeline({ paused: true, onComplete: () => completar(ficha), onInterrupt: () => completar(ficha) });
        for (const a of ficha.actores) {
          ficha.timeline.fromTo(a.elemento,
            { translate: `0 ${a.distancia}px`, opacity: a.opacity },
            { translate: "0 0", opacity: 1, duration: a.duration, ease: movimiento.ease, immediateRender: true }, a.posicion);
        }
      });
      ficha.marcador.dataset.clMotionState = "READY";
    }
    for (const { ficha } of lote) {
      if (ficha.marcador.dataset.clMotionState !== "READY") continue;
      ficha.contexto.add(() => {
        ficha.trigger = ScrollTrigger.create({ trigger: ficha.ancla,
          // completar() retira el trigger: no usar once antes de aceptar la entrada real.
          start: () => `top ${Math.round(lectura())}px`, end: () => `bottom ${Math.round(superior())}px`,
          onEnter: () => { try { reproducir(ficha); } catch (error) { fallar(error); } },
          onLeave: () => completar(ficha), onEnterBack: () => completar(ficha),
          onLeaveBack: () => { if (ficha.marcador.dataset.clMotionState === "ENTERING") completar(ficha); },
        });
      });
    }
  }
  function observarPendientes() {
    preparacion?.disconnect();
    // Solo anticipa preparación una pantalla antes; ScrollTrigger sigue siendo el único disparador.
    preparacion = new IntersectionObserver(entradas => {
      try {
        const proximas = new Set(entradas.filter(e => e.isIntersecting).map(e => e.target));
        preparar(fichas.filter(f => proximas.has(f.ancla)));
      } catch (error) { fallar(error); }
    }, { rootMargin: `${innerHeight}px 0px` });
    for (const ficha of fichas) if (ficha.marcador.dataset.clMotionState === "UNINITIALIZED") preparacion.observe(ficha.ancla);
  }

  try {
    medios.add("(prefers-reduced-motion: no-preference)", () => {
      if (iniciado || destruido || document.hidden) return;
      iniciado = true;
      try {
        construirMaestras();
        construirResto();
        const destino = document.getElementById(decodeURIComponent(location.hash.slice(1)))?.closest("main > section");
        for (const ficha of fichas) if (destino?.contains(ficha.marcador)) completar(ficha);
        preparar(fichas.filter(f => f.ancla.getBoundingClientRect().top < innerHeight * 2));
        if (!destruido) observarPendientes();
      } catch (error) { fallar(error); }
      return () => completarTodo();
    });
    if (destruido) return api;
    if (typeof ResizeObserver === "function") {
      const alturas = new Map([contenido, cabecera].filter(Boolean).map(e => [e, e.getBoundingClientRect().height]));
      medidas = new ResizeObserver(entradas => {
        let cambio = false;
        for (const entrada of entradas) {
          const altura = entrada.target.getBoundingClientRect().height;
          if (altura !== alturas.get(entrada.target)) {
            alturas.set(entrada.target, altura);
            if (entrada.target === cabecera) bordeSuperior = altura + movimiento.aireCabecera;
            cambio = true;
          }
        }
        if (cambio) refrescar();
      });
      for (const elemento of alturas.keys()) medidas.observe(elemento);
    }
    const opciones = { signal: eventos.signal };
    pagina.addEventListener("focusin", evento => {
      if (!evento.target.matches(":focus-visible") || !evento.target.closest("main")) return;
      const caja = evento.target.getBoundingClientRect();
      // El auto-scroll de foco puede ser suave: no reproducir entradas mientras el teclado atraviesa la página.
      if (caja.top >= innerHeight || caja.bottom <= superior()) completarTodo();
      else completarVisibles(evento.target.closest("main > section"));
    }, opciones);
    pagina.addEventListener("play", evento => {
      if (evento.target instanceof HTMLVideoElement) for (const ficha of fichas) if (ficha.ambito.contains(evento.target)) completar(ficha);
    }, { ...opciones, capture: true });
    pagina.addEventListener("pointerdown", evento => {
      if (!evento.target.closest("a, button, input, select, textarea, video")) return;
      for (const ficha of fichas) if (ficha.marcador.dataset.clMotionState === "ENTERING" && ficha.actores.some(a => a.elemento.contains(evento.target))) {
        ficha.timeline.pause(); pulsadas.add(ficha);
      }
    }, opciones);
    const reanudar = () => { for (const ficha of pulsadas) ficha.timeline.resume(); pulsadas.clear(); };
    window.addEventListener("pointerup", reanudar, opciones);
    window.addEventListener("pointercancel", reanudar, opciones);
    window.addEventListener("hashchange", protegerDestino, opciones);
    window.addEventListener("pageshow", e => { if (e.persisted || scrollY > 0) protegerDestino(); }, opciones);
    window.addEventListener("resize", () => {
      bordeSuperior = (cabecera?.getBoundingClientRect().height || 0) + movimiento.aireCabecera;
      completarVisibles(); observarPendientes(); refrescar();
    }, opciones);
    window.addEventListener("blur", () => { for (const ficha of fichas) if (ficha.marcador.dataset.clMotionState === "ENTERING") completar(ficha); }, opciones);
    document.addEventListener("visibilitychange", () => { if (document.hidden) api.destruir(); }, opciones);
    reducido.addEventListener("change", () => { if (reducido.matches) api.destruir(); }, opciones);
  } catch (error) { fallar(error); }
  return api;
}
