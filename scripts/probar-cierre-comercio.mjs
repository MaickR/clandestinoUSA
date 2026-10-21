// Pruebas de contratos nuevos; las interacciones/foco/overlays se comprueban en navegador.
import assert from 'node:assert/strict';
import { crearEstadoCarrito } from '../assets/js/modules/patterns/estado-carrito.js';
import { paginarCarrito } from '../assets/js/modules/patterns/paginacion-carrito.js';
import { ventanasServicio, validarHorario, relojRestaurante } from '../assets/js/modules/patterns/horario-servicio.js';
import { validarGrupo } from '../assets/js/modules/patterns/reserva.js';
import { productosEjemplo, coleccionEjemplo, horarioEjemplo, horarioExcepcionEjemplo } from '../assets/js/modules/guia/transacciones-fixtures.js';

const carrito = crearEstadoCarrito(productosEjemplo);
const idCopa = carrito.agregar({ ...productosEjemplo[1], id: 'vino-copa', varianteId: 'copa', cantidad: 2 });
assert.equal(idCopa, 'vino-copa');
assert.equal(carrito.resumen().lineas.length, 3);
assert.equal(carrito.resumen().subtotal, 10500);
carrito.modalidad('pickup');
assert.equal(carrito.resumen().valido, false);
assert.equal(carrito.resumen().lineas.find(l => l.id === idCopa).elegible, false);
carrito.modalidad('mesa');
assert.equal(carrito.resumen().valido, true);
carrito.agregar({ ...productosEjemplo[1], id: 'otra-copa', varianteId: 'copa' });
assert.equal(carrito.resumen().lineas.length, 3);
assert.equal(carrito.resumen().lineas.find(l => l.id === idCopa).cantidad, 3);
carrito.variante('vino', 'copa');
assert.equal(carrito.resumen().lineas.find(l => l.id === idCopa).cantidad, 3);
const nuevaBotella = carrito.agregar(productosEjemplo[1]);
assert.notEqual(nuevaBotella, 'vino');
assert.equal(carrito.resumen().lineas.find(l => l.id === nuevaBotella).varianteId, 'botella');
const antesReprecio = carrito.resumen();
assert.throws(() => carrito.agregar({ ...productosEjemplo[1], id: 'reprecio', variantes: productosEjemplo[1].variantes.map(v => ({ ...v, precio: v.precio + 100 })) }), TypeError);
assert.equal(carrito.resumen().version, antesReprecio.version);
assert.equal(carrito.resumen().subtotal, antesReprecio.subtotal);
carrito.agregar({ ...productosEjemplo[0], id: 'tabla-cuatro', varianteId: 'cuatro', cantidad: 2 });
assert.equal(carrito.resumen().lineas.find(l => l.id === 'tabla-cuatro').subtotalLinea, 12800);
carrito.eliminar('tabla-cuatro'); carrito.restaurar('tabla-cuatro');
assert.equal(carrito.resumen().lineas.find(l => l.id === 'tabla-cuatro').cantidad, 2);
assert.equal(carrito.aplicarDescuento({codigo:'DEMO10', importe:1000, minimo:5000}), 'aplicado');
assert.equal(carrito.aplicarDescuento({codigo:'DEMO10', importe:1000, minimo:5000}), 'ya-aplicado');
assert.equal(carrito.aplicarDescuento({codigo:'OTRO', importe:500, minimo:0}), 'otro-codigo-activo');
const copia = carrito.resumen(); copia.lineas.find(l => l.id === nuevaBotella).variantes[0].modalidades.length = 0;
assert.equal(carrito.resumen().lineas.find(l => l.id === nuevaBotella).variantes[0].modalidades.length, 2);
carrito.quitarDescuento(); assert.equal(carrito.resumen().descuento, 0);

for (const n of [1,2,8,10,11,20,40]) {
  carrito.reemplazar(coleccionEjemplo(n));
  const datos = carrito.resumen();
  let suma = 0;
  for (let p = 1; p <= Math.ceil(n/10); p++) {
    const vista = paginarCarrito(n,p); const lineas = datos.lineas.slice(vista.inicio,vista.fin);
    assert.ok(lineas.length <= 10); suma += lineas.reduce((s,l)=>s+l.subtotalLinea,0);
  }
  assert.equal(suma,datos.subtotal);
  assert.equal(paginarCarrito(n,999).pagina,Math.ceil(n/10));
}
carrito.reemplazar(coleccionEjemplo(11));
carrito.eliminar('muestra-11'); assert.equal(paginarCarrito(carrito.resumen().lineas.length,2).pagina,1);
carrito.restaurar('muestra-11'); assert.equal(carrito.resumen().lineas.at(-1).id,'muestra-11');
assert.equal(paginarCarrito(0).paginas,1);
assert.throws(()=>paginarCarrito(-1),TypeError);

const antes = new Date('2028-05-10T12:00:00Z');
for (const fecha of ['2028-05-15','2028-05-16']) for (const servicio of ['pickup','mesa','reserva']) assert.equal(ventanasServicio(fecha,servicio,horarioEjemplo,antes).estado,'cerrado');
for (const fecha of ['2028-05-17','2028-05-21']) {
  assert.equal(ventanasServicio(fecha,'pickup',horarioEjemplo,antes).horas[0],'14:00');
  assert.equal(ventanasServicio(fecha,'pickup',horarioEjemplo,antes).horas.at(-1),'19:30');
  assert.equal(ventanasServicio(fecha,'reserva',horarioEjemplo,antes).horas.at(-1),'19:00');
  for (const hora of ['13:30','20:00','20:30','bogus']) assert.equal(validarHorario(fecha,hora,'reserva',horarioEjemplo,antes),false);
}
assert.equal(ventanasServicio('2028-05-09','pickup',horarioEjemplo,antes).estado,'fecha-invalida');
assert.equal(ventanasServicio('2028-02-30','pickup',horarioEjemplo,antes).estado,'fecha-invalida');
assert.equal(ventanasServicio('2028-05-18','reserva',horarioExcepcionEjemplo,antes).estado,'cerrado');
assert.equal(ventanasServicio('2028-05-19','pickup',horarioExcepcionEjemplo,antes).horas[0],'16:00');
assert.equal(ventanasServicio('2028-05-19','pickup',horarioExcepcionEjemplo,antes).horas.at(-1),'17:30');
assert.equal(validarHorario('2028-05-18','18:00','evento',horarioEjemplo,antes),true);
assert.equal(validarHorario('2028-05-18','18:00','evento',horarioExcepcionEjemplo,antes),false);
assert.equal(validarHorario('2028-05-19','14:00','pickup',horarioEjemplo,antes),true);
assert.equal(validarHorario('2028-05-19','14:00','pickup',horarioExcepcionEjemplo,antes),false);
const tarde = new Date('2028-05-17T23:10:00Z');
assert.equal(relojRestaurante(horarioEjemplo.zona,tarde).minutos,970);
assert.equal(validarHorario('2028-05-17','16:00','pickup',horarioEjemplo,tarde),false);
assert.equal(validarHorario('2028-05-17','17:00','pickup',horarioEjemplo,tarde),true);
assert.equal(relojRestaurante(horarioEjemplo.zona,new Date('2028-05-18T01:00:00Z')).fecha,'2028-05-17');
for (const [fecha, instante] of [['2028-03-12','2028-03-12T09:30:00Z'],['2028-11-05','2028-11-05T09:30:00Z']]) {
  const ahora=new Date(instante);
  assert.equal(relojRestaurante(horarioEjemplo.zona,ahora).fecha,fecha);
  assert.equal(ventanasServicio(fecha,'reserva',horarioEjemplo,ahora).horas[0],'14:00');
}
for(const n of [1,6,10]) assert.equal(validarGrupo(String(n)),n);
for(const n of [11,15]) assert.equal(validarGrupo('grande',String(n)),n);
for(const n of ['',0,10,-1,11.5,Number.MAX_SAFE_INTEGER+1]) assert.equal(validarGrupo('grande',String(n)),null);
assert.equal(validarGrupo('11'),null);
console.log('PASS: líneas/variantes simultáneas, fusión/reprecio/Undo, modalidades, descuentos únicos, paginación global, horario/excepciones/DST y grupos.');
