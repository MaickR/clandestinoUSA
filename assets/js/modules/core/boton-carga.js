const inicializados = new WeakMap();

/** Bloquea activaciones reales conservando el foco durante la espera. */
export function inicializarBotonCarga(boton) {
  if (!(boton instanceof HTMLButtonElement)) throw new TypeError("Se requiere un botón nativo.");
  if (inicializados.has(boton)) return inicializados.get(boton);
  let cargando = false;
  let estadoAnterior;
  boton.addEventListener("click", (evento) => {
    if (cargando) {
      evento.preventDefault();
      evento.stopImmediatePropagation();
    }
  }, true);
  const control = {
    establecerCarga(valor) {
      if (typeof valor !== "boolean") throw new TypeError("Carga requiere boolean.");
      if (valor === cargando) return;
      if (valor) {
        estadoAnterior = boton.getAttribute("aria-disabled");
        boton.setAttribute("aria-disabled", "true");
        boton.setAttribute("aria-busy", "true");
      } else {
        if (estadoAnterior === null) boton.removeAttribute("aria-disabled");
        else boton.setAttribute("aria-disabled", estadoAnterior);
        boton.removeAttribute("aria-busy");
      }
      cargando = valor;
      boton.classList.toggle("cl-boton--cargando", valor);
    },
  };
  inicializados.set(boton, control);
  return control;
}
