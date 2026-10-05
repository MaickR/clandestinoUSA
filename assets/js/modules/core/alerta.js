const variantes = new Set(["informacion", "exito", "aviso", "error"]);

/** Construye feedback textual; no acepta HTML, selectores ni URLs. */
export function crearAlerta({ mensaje, titulo = "", variante = "informacion" }) {
  if (typeof mensaje !== "string" || typeof titulo !== "string" || !variantes.has(variante)) {
    throw new TypeError("Alerta: strings y variante conocida requeridos.");
  }
  const alerta = document.createElement("div");
  alerta.className = `cl-alerta cl-alerta--${variante}`;
  const contenido = document.createElement("div");
  contenido.className = "cl-alerta__contenido";
  if (titulo) {
    const encabezado = document.createElement("p");
    encabezado.className = "cl-alerta__titulo";
    encabezado.textContent = titulo;
    contenido.append(encabezado);
  }
  const texto = document.createElement("p");
  texto.className = "cl-alerta__mensaje";
  texto.textContent = mensaje;
  contenido.append(texto);
  alerta.append(contenido);
  return alerta;
}
