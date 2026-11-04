// Contratos HTTP/PHP aislados. Este fixture no interpreta ni valida Apache.
import assert from 'node:assert/strict';
import { spawn, execFileSync } from 'node:child_process';
import { mkdtemp, cp, mkdir, readFile, writeFile, rm } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import { resolve, join, dirname, basename } from 'node:path';
import { fileURLToPath } from 'node:url';
import { createServer } from 'node:net';
import { request } from 'node:http';
import { runInNewContext } from 'node:vm';

const raiz = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const temporal = await mkdtemp(join(tmpdir(), 'cl-home-public-'));
const socket = createServer();
await new Promise(resolver => socket.listen(0, '127.0.0.1', resolver));
const puerto = socket.address().port;
await new Promise(resolver => socket.close(resolver));
for (const archivo of ['home.php', 'home-preview.php', 'index.html', 'contact-page.php', 'contact.html', 'includes', 'scripts/fixtures/home-public-router.php']) {
  await cp(join(raiz, archivo), join(temporal, archivo), { recursive: true });
}
await mkdir(join(temporal, 'assets/css'), { recursive: true });
await mkdir(join(temporal, 'assets/js/dist'), { recursive: true });
await writeFile(join(temporal, 'assets/css/home.css'), '/* paquete de prueba */');
await writeFile(join(temporal, 'assets/js/dist/main.js'), '// paquete de prueba');
const servidor = spawn('php', ['-d', 'disable_functions=mail', '-d', 'display_errors=0',
  '-d', `session.save_path=${temporal}`, '-S', `127.0.0.1:${puerto}`, '-t', temporal,
  join(temporal, 'scripts/fixtures/home-public-router.php')], {
  cwd: temporal, env: { ...process.env, CL_HOME_PUBLIC_REVIEW: '' }, stdio: ['ignore', 'pipe', 'pipe'],
});
let registro = '';
servidor.stderr.on('data', datos => { registro += datos; });
servidor.stdout.on('data', datos => { registro += datos; });
servidor.on('error', error => { registro += error.message; });
const origen = `http://127.0.0.1:${puerto}`;
let comprobaciones = 0;
const igual = (actual, esperado) => { assert.equal(actual, esperado); comprobaciones++; };
const coincide = (actual, patron) => { assert.match(actual, patron); comprobaciones++; };
const ausente = (actual, patron) => { assert.doesNotMatch(actual, patron); comprobaciones++; };

async function obtener(ruta, cabeceras = {}) {
  // node:http conserva Host para ensayar el dominio canónico sin DNS ni red externa.
  return new Promise((resolver, rechazar) => {
    const peticion = request(origen + ruta, { headers: cabeceras }, respuesta => {
      let cuerpo = '';
      respuesta.setEncoding('utf8');
      respuesta.on('data', datos => { cuerpo += datos; });
      respuesta.on('end', () => resolver({ codigo: respuesta.statusCode, cabeceras: respuesta.headers, cuerpo }));
    });
    peticion.on('error', rechazar);
    peticion.end();
  });
}

function cgi(archivo, ruta, host = 'theclandestinousa.com') {
  return execFileSync('php-cgi', ['-d', 'cgi.force_redirect=0', '-d', 'disable_functions=mail', '-d', 'display_errors=0'], {
    cwd: temporal,
    env: { ...process.env, REDIRECT_STATUS: '200', REQUEST_METHOD: 'GET',
      SCRIPT_FILENAME: join(temporal, archivo), SCRIPT_NAME: '/' + archivo,
      DOCUMENT_ROOT: temporal, REQUEST_URI: ruta, HTTP_HOST: host, HTTPS: 'on',
      REMOTE_ADDR: '127.0.0.1', SERVER_PROTOCOL: 'HTTP/1.1' }, encoding: 'utf8',
  });
}

try {
  let listo = false;
  for (let intento = 0; intento < 40; intento++) {
    try { await obtener('/'); listo = true; break; } catch { await new Promise(resolver => setTimeout(resolver, 100)); }
  }
  assert.ok(listo, registro);
  const legacy = await readFile(join(raiz, 'index.html'), 'utf8');
  igual((await obtener('/')).cuerpo, legacy);
  igual((await obtener('/home.php')).codigo, 404);
  const preview = await obtener('/home-preview.php');
  igual(preview.codigo, 200);
  coincide(preview.cabeceras['x-robots-tag'], /noindex/);
  ausente(preview.cuerpo, /rel="canonical"|application\/ld\+json/);
  coincide(preview.cuerpo, /id="carrito-preview"/);

  // El marcador existe exclusivamente en la copia temporal; nunca en el checkout.
  await writeFile(join(temporal, '.home-public-enabled'), '');
  const cabeceras = { Host: 'theclandestinousa.com', 'X-Forwarded-Proto': 'https' };
  const publica = await obtener('/', cabeceras);
  igual(publica.codigo, 200);
  coincide(publica.cabeceras['x-robots-tag'], /^index, follow/);
  coincide(publica.cabeceras['cache-control'], /no-store/);
  igual((publica.cuerpo.match(/rel="canonical"/g) || []).length, 1);
  coincide(publica.cuerpo, /rel="canonical" href="https:\/\/theclandestinousa.com\/"/);
  for (const nombre of ['robots', 'description', 'twitter:card']) {
    igual((publica.cuerpo.match(new RegExp(`name="${nombre}"`, 'g')) || []).length, 1);
  }
  igual((publica.cuerpo.match(/<title>/g) || []).length, 1);
  coincide(publica.cuerpo, /og:image:width" content="1672"/);
  coincide(publica.cuerpo, /<html lang="en">/);
  ausente(publica.cuerpo, /id="carrito-preview"|id="acceso-global"|data-cl-acceso-abrir|data-cl-nav-carrito/);
  igual((publica.cuerpo.match(/<video /g) || []).length, 4);
  igual((publica.cuerpo.match(/<h1 /g) || []).length, 1);
  const esquema = JSON.parse(publica.cuerpo.match(/<script type="application\/ld\+json">(.*?)<\/script>/s)[1]);
  igual(esquema['@type'], 'Restaurant');
  igual(esquema.url, 'https://theclandestinousa.com/');
  igual(esquema.address.streetAddress, '211 N Mt Shasta Blvd');
  igual(esquema.address.addressLocality, 'Mount Shasta');
  igual(esquema.telephone, '+14086090027');
  igual(esquema.openingHoursSpecification[0].opens, '16:00');
  igual(esquema.openingHoursSpecification[0].closes, '20:00');
  igual(esquema.openingHoursSpecification[0].dayOfWeek.join(','), 'Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday');
  ausente(JSON.stringify(esquema), /aggregateRating|review|priceRange|offers|event|geo/);
  for (const id of ['home', 'services', 'about', 'pure-soul', 'reservation', 'special', 'private-events', 'guest-stories', 'visit']) {
    coincide(publica.cuerpo, new RegExp(`id="${id}"`));
  }
  coincide(publica.cuerpo, /id="private-events"[^>]*tabindex="-1"/);
  coincide(publica.cuerpo, /\/index.html\?legacy=1#reservation/);
  coincide(publica.cuerpo, /\/assets\/css\/home.css\?v=[a-f0-9]{16}/);
  const versionAntes = publica.cuerpo.match(/home.css\?v=[a-f0-9]{16}/)[0];
  await writeFile(join(temporal, 'assets/css/home.css'), '/* paquete modificado */');
  assert.notEqual((await obtener('/', cabeceras)).cuerpo.match(/home.css\?v=[a-f0-9]{16}/)[0], versionAntes);
  comprobaciones++;
  coincide((await obtener('/', { Host: 'staging.example', 'X-Forwarded-Proto': 'https' })).cabeceras['x-robots-tag'], /noindex/);
  coincide((await obtener('/', { Host: 'theclandestinousa.com' })).cabeceras['x-robots-tag'], /noindex/);
  const alias = await obtener('/home.php?next=https://example.org', cabeceras);
  igual(alias.codigo, 301);
  igual(alias.cabeceras.location, '/');
  const formulario = await obtener('/index.html?legacy=1', cabeceras);
  igual(formulario.cuerpo, legacy);
  coincide(formulario.cabeceras['x-robots-tag'], /noindex, follow/);
  coincide(formulario.cuerpo, /id="reservation"/);
  const contacto = await obtener('/contact.html');
  igual(contacto.codigo, 200);
  coincide(contacto.cuerpo, /name="csrf_token"/);
  for (const ruta of ['/includes/site.php', '/docs/HOME-PUBLIC-SEO.md', '/scripts/fixtures/home-public-router.php', '/.home-public-enabled']) {
    igual((await obtener(ruta)).codigo, 403);
  }
  coincide(cgi('home.php', '/'), /X-Robots-Tag: index, follow/i);
  coincide(cgi('home.php', '/'), /id="guest-stories"/);
  coincide(cgi('home-preview.php', '/home-preview.php'), /Status: 404/);
  await rm(join(temporal, 'assets/css/home.css'));
  igual((await obtener('/', cabeceras)).codigo, 503);
  await rm(join(temporal, '.home-public-enabled'));
  igual((await obtener('/')).cuerpo, legacy);
  igual((await obtener('/home.php')).codigo, 404);

  const codigoAnclas = (await readFile(join(raiz, 'assets/js/modules/patterns/anclas-legacy.js'), 'utf8')).replace('export function', 'function');
  for (const [hash, esperadas] of [['#reservation', 1], ['#visit', 0]]) {
    const destinos = [];
    const contexto = { URL, window: { location: { origin: 'https://theclandestinousa.com', hash, replace: url => destinos.push(url) }, addEventListener() {} } };
    runInNewContext(codigoAnclas + '\ninicializarAnclasLegacy({matches:()=>true,dataset:{clReservaLegacy:"/index.html?legacy=1#reservation"}});', contexto);
    igual(destinos.length, esperadas);
    if (esperadas) igual(destinos[0], 'https://theclandestinousa.com/index.html?legacy=1#reservation');
  }
  assert.throws(() => runInNewContext(codigoAnclas + '\ninicializarAnclasLegacy({matches:()=>true,dataset:{clReservaLegacy:"https://example.org/index.html#reservation"}});', { URL, window: { location: { origin: 'https://theclandestinousa.com' } } }), /no admitido/);
  comprobaciones++;
  const apache = await readFile(join(raiz, '.htaccess'), 'utf8');
  coincide(apache, /DirectoryIndex index.html/);
  coincide(apache, /RewriteRule \^\$ home.php \[END\]/);
  coincide(apache, /Header always set X-Robots-Tag "noindex, follow" "expr=-f/);
  const robots = await readFile(join(raiz, 'robots.txt'), 'utf8');
  ausente(robots, /^Disallow: \/(?:index\.html|home\.php|assets\/(?:css|js|images)\/?)\s*$/m);
  coincide(robots, /Sitemap: https:\/\/theclandestinousa.com\/sitemap.xml/);
  const sitemap = await readFile(join(raiz, 'sitemap.xml'), 'utf8');
  ausente(sitemap, /home-preview|home.php|index.html/);
  igual((sitemap.match(/<loc>https:\/\/theclandestinousa.com\/<\/loc>/g) || []).length, 1);
  console.log(`PASS: ${comprobaciones} contratos de Home pública; HTTP/PHP/CGI aislados, no Apache; mail nativo deshabilitado.`);
} catch (error) {
  console.error(registro);
  throw error;
} finally {
  servidor.kill();
  if (servidor.exitCode === null) await new Promise(resolver => servidor.once('exit', resolver));
  // Solo se elimina la copia efímera creada por esta suite, nunca el checkout.
  assert.equal(dirname(temporal), resolve(tmpdir()));
  assert.ok(basename(temporal).startsWith('cl-home-public-'));
  await rm(temporal, { recursive: true, force: true });
}
