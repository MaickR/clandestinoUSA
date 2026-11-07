// Paquete por lista permitida; nunca activa Home ni copia el checkout completo.
import { execFileSync } from 'node:child_process';
import { lstat, mkdir, readFile, readdir, writeFile } from 'node:fs/promises';
import { createHash } from 'node:crypto';
import { dirname, isAbsolute, join, relative, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import assert from 'node:assert/strict';

const raiz = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const destino = resolve(process.argv[2] || join(raiz, '.dist/home-r7'));
const relativo = relative(raiz, destino);
assert(relativo && (relativo.startsWith('.dist/') || relativo.startsWith('.dist\\') || relativo.startsWith('..') || isAbsolute(relativo)),
  'Usar .dist o un directorio externo al repositorio.');
const vuelta = relative(destino, raiz);
assert(vuelta.startsWith('..') || isAbsolute(vuelta), 'El destino no puede contener el repositorio.');
await mkdir(dirname(destino), { recursive: true });
await mkdir(destino); // Debe ser nuevo: nunca sobreescribir una entrega o backup.
const web = join(destino, 'web');
const rastreados = execFileSync('git', ['ls-files', '-z'], { cwd: raiz, encoding: 'utf8' }).split('\0').filter(Boolean);
const hosts = new Set(['home.php', 'contact-page.php', 'contact.php', 'reservation.php', 'form-token.php']);
// Partials anteriores a Discovery, sin require/include en los anfitriones vigentes.
// Se conservan en el repositorio; no son endpoints ni dependencias de la entrega.
const includesSinConsumidor = new Set(['includes/welcome.php', 'includes/spanish-table.php']);
const jsLegacy = new Set(['form-feedback.js', 'forms-security.js', 'gallery.js', 'hampers.js', 'preloader.js',
  'reservation.js', 'script.js', 'swc-carousel.js', 'tapas.js', 'utils.js', 'wines.js']);
const permitidos = rastreados.filter(ruta =>
  /^[^/]+\.html$/.test(ruta) || hosts.has(ruta) || ruta === '.htaccess' || ruta === 'robots.txt' || ruta === 'sitemap.xml'
  || (/^includes\/(?:[^/]+\.php|\.htaccess)$/.test(ruta) && !includesSinConsumidor.has(ruta))
  || /^assets\/css\/[^/]+\.css$/.test(ruta)
  || (ruta.startsWith('assets/js/') && jsLegacy.has(ruta.slice('assets/js/'.length)))
  || /^assets\/(?:images|favicon|icons|fonts)\/.+\.(?:avif|webp|jpe?g|jfif|png|gif|svg|ico|mp4|webm|woff2?|ttf|otf|eot|webmanifest)$/i.test(ruta)
  || ruta === 'assets/icons/LICENCIA-bootstrap-icons.txt'
  || ruta === 'assets/images/guest-stories/.htaccess');
const generados = ['assets/css/home.css', 'assets/icons/cl-iconos.svg', 'includes/.htaccess'];
for (const nombre of (await readdir(join(raiz, 'assets/js/dist'))).sort()) {
  assert(nombre.endsWith('.js') && nombre !== 'style-guide.js', 'Ejecutar build de producción, sin mapas ni guía.');
  generados.push(`assets/js/dist/${nombre}`);
}
const archivos = [...new Set([...permitidos, ...generados])].sort();
const manifiesto = [];
for (const ruta of archivos) {
  const origen = join(raiz, ruta);
  assert((await lstat(origen)).isFile(), `Falta archivo regular (sin symlink): ${ruta}`);
  const contenido = await readFile(origen);
  if (/^assets\/js\/dist\/.*\.js$/.test(ruta)) {
    const texto = contenido.toString();
    assert(!/localhost|127\.0\.0\.1|browser-sync-client|sourceMappingURL|\/node_modules\//i.test(texto), `Runtime de desarrollo: ${ruta}`);
    for (const coincidencia of texto.matchAll(/(?:from\s*|import\s*\()?["'](\.\/[^"']+\.js)["']/g)) {
      assert(archivos.includes(`assets/js/dist/${coincidencia[1].slice(2)}`), `Chunk ausente: ${coincidencia[1]}`);
    }
  }
  const salida = join(web, ruta);
  await mkdir(dirname(salida), { recursive: true });
  await writeFile(salida, contenido);
  manifiesto.push({ ruta, bytes: contenido.length, sha256: createHash('sha256').update(contenido).digest('hex') });
}
assert(archivos.includes('assets/js/dist/main.js') && archivos.includes('index.html'), 'Paquete incompleto.');
assert(!archivos.some(ruta => /(?:^|\/)(?:\.git|\.env|node_modules|docs|scripts|style-guide)(?:\/|$)|\.(?:map|bak|backup|log|zip)$/.test(ruta)), 'Archivo privado en paquete.');
const resumen = {
  base: execFileSync('git', ['rev-parse', 'HEAD'], { cwd: raiz, encoding: 'utf8' }).trim(),
  // Los hashes reflejan el árbol de trabajo, incluidas correcciones aún sin commit.
  activacion: false, archivos: manifiesto,
};
await writeFile(join(destino, 'manifest.json'), JSON.stringify(resumen, null, 2) + '\n');
console.log(JSON.stringify({ destino, archivos: archivos.length, bytes: manifiesto.reduce((total, entrada) => total + entrada.bytes, 0), activacion: false }));
