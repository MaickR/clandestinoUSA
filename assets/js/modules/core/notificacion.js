import Toast from "bootstrap/js/src/toast.js";

const inicializados = new WeakMap();
const variantes = new Set(["informacion", "exito", "aviso", "error"]);

/** Las regiones live deben existir antes de crear mensajes; contenido solo textual. */
export function inicializarNotificaciones(contenedor, { regionRutina, regionUrgente }) {
  if (!(contenedor instanceof HTMLElement) || !contenedor.isConnected
    || regionRutina?.getAttribute("aria-live") !== "polite"
    || regionUrgente?.getAttribute("aria-live") !== "assertive"
    || !regionRutina.isConnected || !regionUrgente.isConnected) {
    throw new TypeError("Se requieren contenedor y regiones live existentes.");
  }
  if (inicializados.has(contenedor)) return inicializados.get(contenedor);
  const control = {
    mostrar({ mensaje, titulo = "", variante = "informacion", urgente = false, persistente = false, activador = null }) {
      if (typeof mensaje !== "string" || typeof titulo !== "string" || !variantes.has(variante)
        || typeof urgente !== "boolean" || typeof persistente !== "boolean"
        || (activador !== null && !(activador instanceof HTMLElement))) {
        throw new TypeError("Notificación: contrato textual inválido.");
      }
      const elemento = document.createElement("div");
      elemento.className = `toast cl-notificacion cl-notificacion--${variante}`;
      const fila = document.createElement("div");
      fila.className = "cl-notificacion__fila";
      const contenido = document.createElement("div");
      contenido.className = "cl-notificacion__contenido";
      if (titulo) {
        const encabezado = document.createElement("p");
        encabezado.className = "cl-notificacion__titulo";
        encabezado.textContent = titulo;
        contenido.append(encabezado);
      }
      const texto = document.createElement("p");
      texto.className = "cl-notificacion__mensaje";
      texto.textContent = mensaje;
      contenido.append(texto);
      const cerrar = document.createElement("button");
      cerrar.type = "button";
      cerrar.className = "cl-boton-icono";
      cerrar.setAttribute("aria-label", "Close notification");
      cerrar.textContent = "×";
      fila.append(contenido, cerrar);
      elemento.append(fila);
      contenedor.append(elemento);
      const instancia = Toast.getOrCreateInstance(elemento, { autohide: !persistente && !urgente, delay: 8000 });
      cerrar.addEventListener("click", () => instancia.hide());
      elemento.addEventListener("hidden.bs.toast", () => {
        const devolverFoco = elemento.contains(document.activeElement);
        instancia.dispose();
        elemento.remove();
        if (devolverFoco && activador?.isConnected) activador.focus();
      }, { once: true });
      instancia.show();
      const region = urgente ? regionUrgente : regionRutina;
      region.textContent = "";
      requestAnimationFrame(() => { region.textContent = [titulo, mensaje].filter(Boolean).join(". "); });
      return elemento;
    },
  };
  inicializados.set(contenedor, control);
  return control;
}
