import { inicializarModal } from "../core/modal.js";

const inicializadas = new WeakMap();

/** Galería estática explícita. Bootstrap/Core posee el ciclo de foco y el modal. */
export function inicializarGaleria(contenedor) {
  if (!(contenedor instanceof HTMLElement)) throw new TypeError("Se requiere un contenedor de galería.");
  if (inicializadas.has(contenedor)) return inicializadas.get(contenedor);

  const fotos = [...contenedor.querySelectorAll("a[data-cl-galeria-abrir]")].filter((enlace) => {
    if (!enlace.getAttribute("href")?.trim()) return false;
    const url = new URL(enlace.href, document.baseURI);
    return enlace.closest("[data-cl-galeria]") === contenedor
      && enlace.dataset.clGaleriaTitulo?.trim()
      && enlace.getAttribute("aria-disabled") !== "true"
      && ["http:", "https:"].includes(url.protocol) && url.origin === location.origin;
  });
  if (!fotos.length) {
    const vacia = { abrir: () => false, cerrar: () => {} };
    inicializadas.set(contenedor, vacia);
    return vacia;
  }

  const visor = contenedor.querySelector("[data-cl-galeria-visor]");
  const requerir = (selector) => {
    const elemento = visor?.querySelector(selector);
    if (!(elemento instanceof HTMLElement)) throw new TypeError(`Falta estructura de galería: ${selector}`);
    return elemento;
  };
  const cerrar = requerir("[data-cl-galeria-cerrar]");
  const anterior = requerir("[data-cl-galeria-anterior]");
  const siguiente = requerir("[data-cl-galeria-siguiente]");
  const contador = requerir("[data-cl-galeria-contador]");
  const titulo = requerir("[data-cl-galeria-titulo]");
  const descripcion = requerir("[data-cl-galeria-descripcion]");
  const anuncio = requerir("[data-cl-galeria-anuncio]");
  const media = requerir("[data-cl-galeria-media]");
  const carga = requerir("[data-cl-galeria-carga]");
  const error = requerir("[data-cl-galeria-error]");
  let imagen = requerir("[data-cl-galeria-foto]");
  const modal = inicializarModal(visor, { focoInicial: cerrar });
  let posicion = 0;
  let abierto = false;
  let revision = 0;
  let espera;
  let cancelarImagen = () => {};
  anterior.disabled = fotos.length === 1;
  siguiente.disabled = fotos.length === 1;

  function cancelarCarga() {
    revision += 1;
    clearTimeout(espera);
    cancelarImagen();
    carga.hidden = true;
    media.setAttribute("aria-busy", "false");
  }

  function mostrar(indice) {
    cancelarCarga();
    posicion = (indice + fotos.length) % fotos.length;
    const enlace = fotos[posicion];
    const actual = revision;
    const miniatura = enlace.querySelector("img");
    const ancho = Number(miniatura?.getAttribute("width") || enlace.dataset.clGaleriaAncho);
    const alto = Number(miniatura?.getAttribute("height") || enlace.dataset.clGaleriaAlto);
    media.style.aspectRatio = Number.isFinite(ancho) && Number.isFinite(alto) && ancho > 0 && alto > 0 ? `${ancho} / ${alto}` : "4 / 3";
    titulo.textContent = enlace.dataset.clGaleriaTitulo;
    descripcion.textContent = enlace.dataset.clGaleriaDescripcion || "";
    descripcion.hidden = !descripcion.textContent;
    contador.textContent = `${String(posicion + 1).padStart(2, "0")} / ${String(fotos.length).padStart(2, "0")}`;
    const contexto = `Photograph ${posicion + 1} of ${fotos.length}. ${titulo.textContent}`;
    anuncio.textContent = contexto;
    error.hidden = true;
    media.setAttribute("aria-busy", "true");

    // Se inserta la misma imagen que se carga; sin segunda descarga ni precarga vecina.
    const solicitud = new Image();
    solicitud.className = "cl-visor__foto";
    solicitud.dataset.clGaleriaFoto = "";
    solicitud.alt = enlace.dataset.clGaleriaAlt || titulo.textContent;
    solicitud.decoding = "async";
    solicitud.hidden = true;
    imagen.replaceWith(solicitud);
    imagen = solicitud;
    const terminar = (fallo) => {
      if (actual !== revision || !abierto) return;
      clearTimeout(espera);
      carga.hidden = true;
      media.setAttribute("aria-busy", "false");
      solicitud.hidden = fallo;
      error.hidden = !fallo;
      anuncio.textContent = fallo ? `${contexto}. The photograph could not be loaded. Close the viewer, or choose Next photograph when available.` : contexto;
    };
    solicitud.onload = () => terminar(false);
    solicitud.onerror = () => terminar(true);
    cancelarImagen = () => { solicitud.onload = null; solicitud.onerror = null; };
    espera = setTimeout(() => { if (actual === revision && abierto) carga.hidden = false; }, 150);
    solicitud.src = miniatura?.currentSrc || enlace.href;
  }

  const control = {
    abrir(indice = 0, origen = fotos[indice]) {
      if (!Number.isInteger(indice) || indice < 0 || indice >= fotos.length) throw new RangeError("Índice de fotografía inválido.");
      posicion = indice;
      if (abierto) mostrar(indice);
      else modal.abrir(origen);
      return true;
    },
    cerrar: () => modal.cerrar(),
  };
  visor.addEventListener("show.bs.modal", (evento) => {
    if (evento.defaultPrevented) return;
    abierto = true;
    mostrar(posicion);
  });
  visor.addEventListener("hide.bs.modal", () => { abierto = false; cancelarCarga(); });
  visor.addEventListener("hidden.bs.modal", () => { imagen.removeAttribute("src"); imagen.hidden = true; });
  anterior.addEventListener("click", () => mostrar(posicion - 1));
  siguiente.addEventListener("click", () => mostrar(posicion + 1));
  visor.addEventListener("keydown", (evento) => {
    if (!abierto || fotos.length === 1 || evento.altKey || evento.ctrlKey || evento.metaKey || evento.shiftKey
      || evento.target.closest("input, textarea, select, [contenteditable]")) return;
    if (evento.key === "ArrowLeft" || evento.key === "ArrowRight") {
      evento.preventDefault();
      mostrar(posicion + (evento.key === "ArrowLeft" ? -1 : 1));
    }
  });
  contenedor.addEventListener("click", (evento) => {
    if (evento.defaultPrevented || evento.button !== 0 || evento.ctrlKey || evento.metaKey || evento.shiftKey || evento.altKey) return;
    const enlace = evento.target.closest("[data-cl-galeria-abrir]");
    const indice = fotos.indexOf(enlace);
    if (indice < 0) return;
    evento.preventDefault();
    control.abrir(indice, enlace);
  });
  inicializadas.set(contenedor, control);
  return control;
}
