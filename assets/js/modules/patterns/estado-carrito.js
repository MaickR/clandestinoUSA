const estados = new Set(["listo", "actualizando", "error", "desactualizado"]);

function normalizar(productos) {
  if (!Array.isArray(productos)) throw new TypeError("Las líneas deben ser una lista.");
  const ids = new Set();
  const lineas = productos.map((producto) => {
    if (!producto || typeof producto.id !== "string" || !/^[a-zA-Z0-9_-]+$/.test(producto.id) || ids.has(producto.id) ||
      typeof producto.nombre !== "string" || !producto.nombre.trim() ||
      !Number.isSafeInteger(producto.precio) || producto.precio < 0 ||
      !Number.isSafeInteger(producto.maximo) || producto.maximo < 1) {
      throw new TypeError("Línea inválida: identidad única, nombre, precio entero y límite requeridos.");
    }
    ids.add(producto.id);
    const cantidad = producto.cantidad ?? 1;
    if (!Number.isSafeInteger(cantidad) || cantidad < 1 || cantidad > producto.maximo) throw new RangeError("Cantidad inicial inválida.");
    const variantes = (producto.variantes ?? []).map((variante) => ({ ...variante }));
    const idsVariantes = new Set();
    for (const variante of variantes) {
      if (typeof variante.id !== "string" || !/^[a-zA-Z0-9_-]+$/.test(variante.id) || idsVariantes.has(variante.id) ||
        typeof variante.nombre !== "string" || !variante.nombre.trim() || !Number.isSafeInteger(variante.precio) || variante.precio < 0) {
        throw new TypeError("Variante inválida.");
      }
      idsVariantes.add(variante.id);
    }
    const varianteId = producto.varianteId ?? variantes[0]?.id ?? null;
    const seleccion = variantes.find((v) => v.id === varianteId);
    if (variantes.length && !seleccion) throw new TypeError("La variante seleccionada no existe.");
    if (producto.imagen && (!/^\/assets\/images\/[a-zA-Z0-9_./-]+$/.test(producto.imagen) || producto.imagen.includes(".."))) throw new TypeError("La imagen debe ser un recurso local confiable.");
    if (producto.disponible !== undefined && typeof producto.disponible !== "boolean") throw new TypeError("Disponibilidad inválida.");
    return { ...producto, cantidad, variantes, varianteId, precio: seleccion?.precio ?? producto.precio,
      variante: seleccion?.nombre ?? producto.variante ?? "", disponible: producto.disponible !== false, presente: true };
  });
  const maximo = lineas.reduce((suma, l) => suma + Math.max(l.precio, ...l.variantes.map((v) => v.precio)) * l.maximo, 0);
  if (!Number.isSafeInteger(maximo)) throw new RangeError("Los límites de importe exceden el rango seguro.");
  return lineas;
}

/** Estado local de una selección: unidades menores y snapshots; no conoce DOM, fixtures ni red. */
export function crearEstadoCarrito(productos = []) {
  let lineas = normalizar(productos);
  let estado = "listo";
  let descuento = null;
  let promocionEstado = "sin-codigo";
  let version = 0;
  const invalidas = new Set();
  const buscar = (id) => {
    const linea = lineas.find((l) => l.id === id);
    if (!linea) throw new TypeError("Línea desconocida.");
    return linea;
  };
  function subtotal() {
    const importe = lineas.filter((l) => l.presente).reduce((suma, l) => suma + l.precio * l.cantidad, 0);
    if (!Number.isSafeInteger(importe)) throw new RangeError("Importe fuera de rango.");
    return importe;
  }
  function cambiar() {
    const importe = subtotal();
    if (descuento && (importe < descuento.minimo || importe < descuento.importe)) {
      descuento = null;
      promocionEstado = "no-elegible";
    }
    version += 1;
  }
  const api = {
    resumen() {
      const activas = lineas.filter((l) => l.presente);
      const importe = subtotal();
      return { version, estado, moneda: "USD", lineas: activas.map((l) => ({ ...l, subtotalLinea: l.precio * l.cantidad, variantes: l.variantes.map((v) => ({ ...v })) })),
        unidades: activas.reduce((suma, l) => suma + l.cantidad, 0), subtotal: importe,
        descuento: descuento?.importe ?? 0, codigo: descuento?.codigo ?? null, promocionEstado,
        subtotalAjustado: importe - (descuento?.importe ?? 0), impuestos: null, cargos: null, total: null,
        valido: activas.length > 0 && estado === "listo" && activas.every((l) => l.disponible && !invalidas.has(l.id)) };
    },
    reemplazar(nuevas) {
      const validadas = normalizar(nuevas);
      // Validar antes de sustituir evita una colección parcialmente aplicada.
      const total = validadas.reduce((s, l) => s + l.precio * l.cantidad, 0);
      if (!Number.isSafeInteger(total)) throw new RangeError("Importe fuera de rango.");
      lineas = validadas; estado = "listo"; invalidas.clear(); cambiar();
    },
    agregar(producto) {
      const existente = lineas.find((l) => l.id === producto.id);
      if (existente) {
        if (existente.presente) existente.cantidad = Math.min(existente.maximo, existente.cantidad + 1);
        existente.presente = true;
        invalidas.delete(existente.id);
      } else {
        normalizar([...lineas, producto]);
        lineas.push(...normalizar([producto]));
      }
      cambiar();
    },
    cantidad(id, valor) {
      const linea = buscar(id);
      const valida = Number.isSafeInteger(valor) && valor >= 1 && valor <= linea.maximo;
      if (valida && linea.cantidad === valor && !invalidas.has(id)) return;
      if (valida) { linea.cantidad = valor; invalidas.delete(id); }
      else invalidas.add(id);
      cambiar();
    },
    variante(id, varianteId) {
      const linea = buscar(id);
      const variante = linea.variantes.find((v) => v.id === varianteId);
      if (!variante) throw new TypeError("Variante desconocida.");
      linea.varianteId = varianteId; linea.variante = variante.nombre; linea.precio = variante.precio; cambiar();
    },
    eliminar(id) { buscar(id).presente = false; invalidas.delete(id); cambiar(); },
    restaurar(id) { buscar(id).presente = true; cambiar(); },
    disponibilidad(id, disponible) {
      if (typeof disponible !== "boolean") throw new TypeError("Disponibilidad debe ser booleana.");
      buscar(id).disponible = disponible; cambiar();
    },
    establecerEstado(valor) {
      if (!estados.has(valor)) throw new TypeError("Estado de carrito desconocido.");
      if (estado !== valor) { estado = valor; cambiar(); }
    },
    aplicarDescuento(dato) {
      if (!dato || typeof dato.codigo !== "string" || !dato.codigo.trim() ||
        !Number.isSafeInteger(dato.importe) || dato.importe <= 0 || !Number.isSafeInteger(dato.minimo) || dato.minimo < 0) {
        throw new TypeError("Descuento inválido: código e importes enteros requeridos.");
      }
      if (descuento?.codigo === dato.codigo) return "ya-aplicado";
      if (!api.resumen().valido || subtotal() < dato.minimo || subtotal() < dato.importe) return "no-elegible";
      descuento = { codigo: dato.codigo, importe: dato.importe, minimo: dato.minimo };
      promocionEstado = "aplicado"; cambiar();
      return "aplicado";
    },
    quitarDescuento() { descuento = null; promocionEstado = "retirado"; cambiar(); },
  };
  subtotal();
  return api;
}
