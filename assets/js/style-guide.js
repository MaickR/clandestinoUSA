import { crearAlerta } from "./modules/core/alerta.js";
import { inicializarBotonCarga } from "./modules/core/boton-carga.js";
import { inicializarCantidad } from "./modules/core/cantidad.js";
import { inicializarAcordeon } from "./modules/core/acordeon.js";
import { inicializarModal } from "./modules/core/modal.js";
import { inicializarNotificaciones } from "./modules/core/notificacion.js";
import { inicializarProductosGuia } from "./modules/guia/productos.js";
import { inicializarGaleria } from "./modules/patterns/galeria.js";
import { inicializarComercialGuia } from "./modules/guia/comercial.js";
import { inicializarResenasGuia } from "./modules/guia/resenas.js";
import { inicializarCarrusel } from "./modules/patterns/carrusel.js";
import { inicializarMediaCarrusel } from "./modules/patterns/carrusel-media.js";
import { inicializarNavegacion } from "./modules/patterns/navegacion-global.js";
import { inicializarAcceso } from "./modules/patterns/acceso.js";
import { inicializarTransaccionesGuia } from "./modules/guia/transacciones.js";

// Los IDs son propios de esta guía; los módulos Core reciben elementos existentes.
const porId = (id) => document.getElementById(id);
// Cada página conecta únicamente sus ejemplos; las APIs Core no cambian.
function inicializarCoreGuia() {
  for (const boton of document.querySelectorAll("[data-cl-boton-demo]")) boton.addEventListener("click", () => {
    porId("botones-demo-resultado").textContent = `${boton.dataset.clBotonDemo} button activated — demonstration only. No commercial action took place.`;
  });
  inicializarCantidad(porId("cantidad-demo"));
  for (const panel of document.querySelectorAll(".cl-acordeon .collapse")) inicializarAcordeon(panel);
  inicializarModal(porId("modal-detalles"), { focoInicial: porId("modal-detalles-cerrar") });
  const confirmacion = inicializarModal(porId("modal-confirmacion"), { focoInicial: porId("conservar-item") });
  porId("abrir-confirmacion").addEventListener("click", (evento) => confirmacion.abrir(evento.currentTarget));
  porId("confirmar-demo").addEventListener("click", () => {
    porId("confirmacion-resultado").textContent = "Removal confirmed — demonstration only.";
    confirmacion.cerrar();
  });

  const contenedor = porId("notificaciones");
  const notificaciones = inicializarNotificaciones(contenedor, {
    regionRutina: porId("notificacion-rutina"), regionUrgente: porId("notificacion-urgente"),
  });
  const botonesToast = [porId("toast-rutina"), porId("toast-persistente"), porId("toast-urgente")];
  const ejemplos = [
    { mensaje: "Example selection updated — demonstration only.", variante: "exito" },
    { mensaje: "Collection details need restaurant confirmation. No window is held.", titulo: "Collection notice · demo", persistente: true },
    { mensaje: "No orders or reservations can be made from this guide.", titulo: "Important notice · demo", variante: "aviso", urgente: true },
  ];
  for (const [indice, boton] of botonesToast.entries()) {
    boton.addEventListener("click", () => {
      if (contenedor.childElementCount >= 3) return;
      notificaciones.mostrar({ ...ejemplos[indice], activador: boton });
      for (const control of botonesToast) control.setAttribute("aria-disabled", String(contenedor.childElementCount >= 3));
    });
  }
  contenedor.addEventListener("hidden.bs.toast", () => {
    // hidden se emite antes de retirar el nodo; habilitar en la siguiente microtarea.
    queueMicrotask(() => { for (const boton of botonesToast) boton.removeAttribute("aria-disabled"); });
  });

  function conectarCarga(id, resultadoId, mensajeEspera, mensajeFinal, grupo = null) {
    const boton = porId(id);
    const resultado = porId(resultadoId);
    const control = inicializarBotonCarga(boton);
    boton.addEventListener("click", () => {
      control.establecerCarga(true);
      grupo?.setAttribute("aria-busy", "true");
      resultado.textContent = mensajeEspera;
      window.setTimeout(() => {
        control.establecerCarga(false);
        grupo?.setAttribute("aria-busy", "false");
        resultado.textContent = mensajeFinal;
      }, 2200);
    });
  }
  conectarCarga("pedido-carga", "pedido-resultado", "Adding to your order…", "Added to your order — demonstration only.");
  conectarCarga("comprobar-demo", "formulario-resultado", "Checking availability…", "Availability check complete — demonstration only.", porId("formulario-carga"));
  porId("reintentar-demo").addEventListener("click", () => {
    porId("reintento-resultado").textContent = "Retry selected — no request was sent.";
  });
  porId("alerta-textual").append(crearAlerta({ titulo: "Text-only notice", mensaje: "Please contact our team with any dietary questions." }));
}

if (porId("cantidad-demo")) inicializarCoreGuia();
for (const contenedor of document.querySelectorAll("[data-cl-navegacion]")) inicializarNavegacion(contenedor);
if (porId("acceso-global")) inicializarAcceso(porId("acceso-global"), document.querySelector("[data-cl-acceso-abrir]"));
inicializarProductosGuia();
for (const galeria of document.querySelectorAll("[data-cl-galeria]")) inicializarGaleria(galeria);
inicializarComercialGuia();
inicializarResenasGuia();
inicializarTransaccionesGuia();
for (const contenedor of document.querySelectorAll("[data-cl-carrusel]")) {
  inicializarCarrusel(contenedor);
  if (contenedor.hasAttribute("data-cl-carrusel-media")) inicializarMediaCarrusel(contenedor);
}
