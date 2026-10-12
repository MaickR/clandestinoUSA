import { mkdir, readFile, writeFile } from "node:fs/promises";
import { fileURLToPath, pathToFileURL } from "node:url";
import { resolve } from "node:path";

const raiz = fileURLToPath(new URL("../", import.meta.url));
const identificador = /^[a-z][a-z0-9]*(?:-[a-z0-9]+)*$/;

/** Valida el manifiesto sin perder duplicados como ocurriría con claves JSON. */
export function validarManifiesto(manifiesto) {
  if (!Array.isArray(manifiesto) || manifiesto.length === 0) {
    throw new Error("El manifiesto debe ser una lista no vacía.");
  }
  const nombres = new Set();
  for (const entrada of manifiesto) {
    if (!entrada || Object.keys(entrada).sort().join(",") !== "archivo,nombre"
      || typeof entrada.nombre !== "string" || typeof entrada.archivo !== "string"
      || !identificador.test(entrada.nombre) || !identificador.test(entrada.archivo)) {
      throw new Error("Entrada de icono inválida: se requieren nombre y archivo simples.");
    }
    if (nombres.has(entrada.nombre)) throw new Error(`Nombre duplicado: ${entrada.nombre}`);
    nombres.add(entrada.nombre);
  }
  return [...manifiesto].sort((a, b) => a.nombre < b.nombre ? -1 : a.nombre > b.nombre ? 1 : 0);
}

/** Transforma solo el formato controlado del paquete; no sanitiza SVG externos. */
export function crearSimbolo(nombre, fuente) {
  if (typeof nombre !== "string" || !identificador.test(nombre) || typeof fuente !== "string") {
    throw new TypeError("Se requiere nombre simple y fuente SVG textual.");
  }
  const svg = fuente.trim().match(/^<svg\s+([^>]+)>([\s\S]+)<\/svg>$/);
  const vista = svg?.[1].match(/\bviewBox="([\d.\s-]+)"/);
  if (!svg || !vista || !/\bfill="currentColor"/.test(svg[1])) {
    throw new Error(`Estructura SVG inesperada: ${nombre}`);
  }
  const geometria = svg[2].trim();
  // La selección oficial actual contiene paths/rect/circle; fallar si cambia el formato.
  const restos = geometria.replace(/<(path|rect|circle)\b[^<>]*\/>/g, "").trim();
  if (restos || /\b(?:on\w+|href|id|class)\s*=/.test(geometria)) {
    throw new Error(`Geometría SVG inesperada: ${nombre}`);
  }
  return `  <symbol id="cl-icon-${nombre}" viewBox="${vista[1]}" fill="currentColor">\n${geometria}\n  </symbol>`;
}

/** Genera el único sprite desplegable a partir de los SVG del paquete instalado. */
export async function generarIconos() {
  const manifiesto = validarManifiesto(JSON.parse(await readFile(resolve(raiz, "scripts/iconos.json"), "utf8")));
  const simbolos = [];
  for (const { nombre, archivo } of manifiesto) {
    const fuente = await readFile(resolve(raiz, "node_modules/bootstrap-icons/icons", `${archivo}.svg`), "utf8");
    simbolos.push(crearSimbolo(nombre, fuente));
  }
  const salida = `<svg xmlns="http://www.w3.org/2000/svg">\n${simbolos.join("\n")}\n</svg>\n`;
  await mkdir(resolve(raiz, "assets/icons"), { recursive: true });
  await writeFile(resolve(raiz, "assets/icons/cl-iconos.svg"), salida);
}

if (process.argv[1] && pathToFileURL(resolve(process.argv[1])).href === import.meta.url) {
  await generarIconos();
  console.log("Sprite generado: assets/icons/cl-iconos.svg");
}
