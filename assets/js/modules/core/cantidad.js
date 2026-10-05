const inicializados = new WeakMap();

/** Utiliza stepUp/stepDown y validez nativa; no calcula precios ni inventario. */
export function inicializarCantidad(elemento) {
  if (!(elemento instanceof HTMLElement)) throw new TypeError("Se requiere un control de cantidad.");
  if (inicializados.has(elemento)) return inicializados.get(elemento);
  const campo = elemento.querySelector('input[type="number"]');
  const restar = elemento.querySelector('[data-cl-cantidad="restar"]');
  const sumar = elemento.querySelector('[data-cl-cantidad="sumar"]');
  const mensaje = elemento.querySelector(".cl-cantidad__mensaje");
  if (!campo || !restar || !sumar || !mensaje || !campo.checkValidity() || campo.value === "") {
    throw new TypeError("Cantidad requiere campo válido, botones y mensaje asociado.");
  }
  let ultimoValido = campo.value;
  function puedeCambiar(direccion) {
    if (campo.disabled || !campo.checkValidity() || campo.value === "") return false;
    const prueba = campo.cloneNode();
    prueba.value = campo.value;
    try {
      if (direccion === "sumar") prueba.stepUp();
      else prueba.stepDown();
    } catch (error) {
      throw new Error(`Cantidad requiere step numérico: ${error.message}`, { cause: error });
    }
    return prueba.checkValidity() && prueba.value !== campo.value;
  }
  function actualizar() {
    const valido = campo.value !== "" && campo.checkValidity();
    campo.setAttribute("aria-invalid", String(!valido));
    campo.classList.toggle("cl-campo--error", !valido);
    restar.disabled = !puedeCambiar("restar");
    sumar.disabled = !puedeCambiar("sumar");
    return valido;
  }
  campo.addEventListener("input", () => {
    if (actualizar()) {
      ultimoValido = campo.value;
      mensaje.textContent = "";
    } else mensaje.textContent = "Enter a quantity within the allowed range and step.";
  });
  campo.addEventListener("change", () => {
    if (!actualizar()) {
      campo.value = ultimoValido;
      actualizar();
      mensaje.textContent = "Invalid quantity. The last valid quantity has been restored.";
    }
  });
  for (const [boton, direccion] of [[restar, "restar"], [sumar, "sumar"]]) {
    boton.addEventListener("click", () => {
      if (!puedeCambiar(direccion)) return;
      if (direccion === "sumar") campo.stepUp();
      else campo.stepDown();
      campo.dispatchEvent(new Event("input", { bubbles: true }));
      campo.dispatchEvent(new Event("change", { bubbles: true }));
    });
  }
  actualizar();
  const control = { actualizar };
  inicializados.set(elemento, control);
  return control;
}
