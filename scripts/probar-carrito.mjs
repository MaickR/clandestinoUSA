// Regresión de invariantes de compra local; ejecutar con node scripts/probar-carrito.mjs.
import assert from "node:assert/strict";
import { crearEstadoCarrito } from "../assets/js/modules/patterns/estado-carrito.js";
import { moneda, fechaRestaurante, describirFecha } from "../assets/js/modules/patterns/transaccion.js";
import { productosEjemplo, coleccionEjemplo, estadosEjemplo } from "../assets/js/modules/guia/transacciones-fixtures.js";

const carrito = crearEstadoCarrito(productosEjemplo);
assert.equal(carrito.resumen().subtotal, 8100);
carrito.cantidad("vino", 3);
assert.equal(carrito.resumen().subtotal, 17100);
assert.equal(carrito.aplicarDescuento({ codigo: "DEMO10", importe: 1000, minimo: 5000 }), "aplicado");
assert.equal(carrito.resumen().subtotalAjustado, 16100);
assert.equal(carrito.aplicarDescuento({ codigo: "DEMO10", importe: 1000, minimo: 5000 }), "ya-aplicado");
assert.equal(carrito.resumen().descuento, 1000);
carrito.variante("vino", "copa");
assert.equal(carrito.resumen().subtotal, 7200);
assert.equal(carrito.resumen().subtotalAjustado, 6200);

// Una selección que deja de cumplir la regla pierde el descuento con motivo explícito.
carrito.cantidad("vino", 1);
assert.equal(carrito.resumen().subtotal, 4800);
assert.equal(carrito.resumen().descuento, 0);
assert.equal(carrito.resumen().promocionEstado, "no-elegible");
carrito.eliminar("tabla");
assert.equal(carrito.resumen().unidades, 1);
carrito.restaurar("tabla");
assert.equal(carrito.resumen().unidades, 2);
carrito.cantidad("vino", 0);
assert.equal(carrito.resumen().valido, false);
carrito.cantidad("vino", 1);
assert.equal(carrito.resumen().valido, true);
carrito.disponibilidad("vino", false);
assert.equal(carrito.resumen().valido, false);
carrito.eliminar("vino");
assert.equal(carrito.resumen().valido, true);
for (const estado of ["error", "actualizando", "desactualizado"]) {
  carrito.establecerEstado(estado);
  assert.equal(carrito.resumen().valido, false);
}
carrito.establecerEstado("listo");
assert.equal(carrito.resumen().valido, true);

for (const cantidad of [1, 2, 8, 20, 40]) {
  carrito.reemplazar(coleccionEjemplo(cantidad));
  const datos = carrito.resumen();
  assert.equal(datos.lineas.length, cantidad);
  assert.equal(datos.total, null);
  assert.equal(datos.impuestos, null);
  assert.equal(datos.cargos, null);
  assert.ok(Number.isSafeInteger(datos.subtotal));
}
assert.equal(carrito.resumen().unidades, 120);

// Los datos inválidos no sustituyen una colección válida ni mutan snapshots anteriores.
const anterior = carrito.resumen();
assert.throws(() => carrito.reemplazar([productosEjemplo[0], productosEjemplo[0]]), TypeError);
assert.throws(() => carrito.reemplazar([{ ...productosEjemplo[0], id: undefined }]), TypeError);
assert.equal(carrito.resumen().subtotal, anterior.subtotal);
assert.throws(() => carrito.agregar({ ...productosEjemplo[0], id: "inseguro", precio: Number.MAX_SAFE_INTEGER }), RangeError);
assert.equal(carrito.resumen().subtotal, anterior.subtotal);
anterior.lineas[0].precio = 0;
assert.notEqual(carrito.resumen().lineas[0].precio, 0);
carrito.reemplazar([]);
assert.equal(carrito.resumen().unidades, 0);
assert.equal(carrito.resumen().valido, false);

assert.equal(moneda(11700), "$117.00");
assert.throws(() => moneda(1.5), TypeError);
assert.equal(fechaRestaurante(new Date("2028-05-18T01:00:00Z")), "2028-05-17");
assert.equal(fechaRestaurante(new Date("2028-11-05T09:30:00Z")), "2028-11-05");
assert.equal(describirFecha("2028-05-18"), "May 18, 2028");
assert.equal(Object.values(estadosEjemplo).reduce((suma, familia) => suma + Object.keys(familia.estados).length, 0), 58);
console.log("PASS: estado de carrito, cantidades, variantes, descuentos, recuperación, colecciones, fechas y58 estados.");
