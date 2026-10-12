import { crearAlerta } from "./modules/core/alerta.js";
import { inicializarBotonCarga } from "./modules/core/boton-carga.js";
import { inicializarCantidad } from "./modules/core/cantidad.js";
import { inicializarAcordeon } from "./modules/core/acordeon.js";
import { inicializarModal } from "./modules/core/modal.js";
import { inicializarNotificaciones } from "./modules/core/notificacion.js";

// Los IDs son propios de esta guía; los módulos Core reciben elementos existentes.
const porId = (id) => document.getElementById(id);
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
  { mensaje: "Added to your order", variante: "exito" },
  { mensaje: "Your collection window is held for 10 minutes.", titulo: "Collection notice", persistente: true },
  { mensaje: "We couldn't confirm availability. Please try again.", variante: "error", urgente: true },
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
