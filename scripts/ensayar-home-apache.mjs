// Laboratorio Windows: copia nueva, Apache/FastCGI en loopback y TLS local; sin correo nativo.
import assert from 'node:assert/strict';
import { spawn, execFileSync } from 'node:child_process';
import { mkdir, readFile, writeFile, rename, unlink, readdir } from 'node:fs/promises';
import { dirname, join, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import http from 'node:http';
import https from 'node:https';
import { createServer } from 'node:net';

const raiz = resolve(dirname(fileURLToPath(import.meta.url)), '..');
assert(process.argv.length === 5, 'Uso: node scripts/ensayar-home-apache.mjs <Apache24> <php-cgi.exe> <directorio-nuevo>');
assert(process.platform === 'win32', 'Lanzador portable preparado para Windows.');
const apache = resolve(process.argv[2]).replaceAll('\\', '/');
const php = resolve(process.argv[3]).replaceAll('\\', '/');
const salida = resolve(process.argv[4]).replaceAll('\\', '/');
await mkdir(salida); // Nunca sobreescribir un ensayo o respaldo anterior.
const paquete = join(salida, 'paquete');
execFileSync(process.execPath, [join(raiz, 'scripts/empaquetar-home.mjs'), paquete], { stdio: 'inherit' });
const web = (paquete + '/web').replaceAll('\\', '/');
const privado = salida + '/privado';
await mkdir(privado);
await mkdir(privado + '/sesiones');
await writeFile(privado + '/modo.txt', 'all');
const pausa = ms => new Promise(resolver => setTimeout(resolver, ms));
async function puertoLibre() {
  const socket = createServer();
  await new Promise((resolver, rechazar) => { socket.once('error', rechazar); socket.listen(0, '127.0.0.1', resolver); });
  const puerto = socket.address().port;
  await new Promise(resolver => socket.close(resolver));
  return puerto;
}
const puertoHttp = await puertoLibre(), puertoHttps = await puertoLibre(), puertoPhp = await puertoLibre();
execFileSync(apache + '/bin/openssl.exe', ['req', '-x509', '-newkey', 'rsa:2048', '-nodes', '-keyout', privado + '/key.pem',
  '-out', privado + '/cert.pem', '-days', '2', '-subj', '/CN=localhost', '-addext', 'basicConstraints=CA:FALSE',
  '-addext', 'subjectAltName=DNS:localhost,IP:127.0.0.1'],
{ env: { ...process.env, OPENSSL_CONF: apache + '/conf/openssl.cnf' }, stdio: 'ignore', windowsHide: true });
const ini = privado + '/php.ini';
await writeFile(ini, [
  'extension_dir="' + dirname(php).replaceAll('\\', '/') + '/ext"', 'extension=mbstring', 'disable_functions=mail',
  'auto_prepend_file="' + raiz.replaceAll('\\', '/') + '/scripts/fixtures/forms-apache-prepend.php"',
  'display_errors=Off', 'log_errors=On', 'error_log="' + privado + '/php.log"',
  'session.save_path="' + privado + '/sesiones"', 'sys_temp_dir="' + privado + '/sesiones"', '',
].join('\n'));
const modulos = ['authz_core', 'authz_host', 'dir', 'mime', 'headers', 'rewrite', 'filter', 'deflate', 'expires',
  'log_config', 'ssl', 'socache_shmcb', 'brotli', 'proxy', 'proxy_fcgi'];
function configuracion(omitidos = []) {
  return [
    'ServerRoot "' + apache + '"', 'Listen 127.0.0.1:' + puertoHttp, 'Listen 127.0.0.1:' + puertoHttps,
    'ServerName localhost', 'PidFile "' + privado + '/httpd.pid"', 'ErrorLog "' + privado + '/apache.log"',
    ...modulos.filter(nombre => !omitidos.includes(nombre)).map(nombre => 'LoadModule ' + nombre + '_module modules/mod_' + nombre + '.so'),
    'TypesConfig "' + apache + '/conf/mime.types"', 'DocumentRoot "' + web + '"', '<Directory "' + web + '">',
    'AllowOverride All', 'Require all granted', 'Options +FollowSymLinks', '</Directory>',
    '<FilesMatch "\\.php$">', 'SetHandler "proxy:fcgi://127.0.0.1:' + puertoPhp + '/"', '</FilesMatch>',
    '# Adaptación del drive Windows, exclusiva del laboratorio.',
    'ProxyFCGIBackendType GENERIC', 'ProxyFCGISetEnvIf "reqenv(\'SCRIPT_FILENAME\') =~ m#^/(.*)$#" SCRIPT_FILENAME "$1"',
    'SSLSessionCache "shmcb:' + privado + '/ssl-cache(512000)"',
    '<VirtualHost 127.0.0.1:' + puertoHttps + '>', 'ServerName localhost', 'SSLEngine on',
    'SSLCertificateFile "' + privado + '/cert.pem"', 'SSLCertificateKeyFile "' + privado + '/key.pem"', '</VirtualHost>', '',
  ].join('\n');
}
const conf = privado + '/httpd.conf';
let servidor;
const procesos = [];
function arrancar(ejecutable, argumentos, entorno = {}) {
  const hijo = spawn(ejecutable, argumentos, { windowsHide: true, env: { ...process.env, ...entorno }, stdio: ['ignore', 'pipe', 'pipe'] });
  hijo.on('error', error => console.error(error.message));
  hijo.stdout.on('data', () => {});
  hijo.stderr.on('data', () => {});
  procesos.push(hijo);
  return hijo;
}
async function detener(hijo) {
  if (!hijo || hijo.exitCode !== null || hijo.signalCode !== null) return;
  // Apache -X no crea un árbol de workers; solo se cierra el proceso propio.
  const terminado = new Promise(resolver => hijo.once('exit', resolver));
  hijo.kill();
  await terminado;
}
async function iniciarApache(omitidos = []) {
  await writeFile(conf, configuracion(omitidos));
  execFileSync(apache + '/bin/httpd.exe', ['-t', '-f', conf], { stdio: 'pipe', windowsHide: true });
  servidor = arrancar(apache + '/bin/httpd.exe', ['-X', '-f', conf]);
  for (let intento = 0; intento < 100; intento++) {
    try { await pedir('/no-existe'); return; } catch { await pausa(100); }
  }
  throw new Error('Apache no arrancó; consultar privado/apache.log.');
}
function pedir(ruta, { tls = false, host, headers = {}, body, method = 'GET' } = {}) {
  return new Promise((resolver, rechazar) => {
    const peticion = (tls ? https : http).request({ hostname: '127.0.0.1', port: tls ? puertoHttps : puertoHttp, path: ruta,
      method, rejectUnauthorized: false, headers: { ...(host ? { Host: host } : {}), ...headers } }, respuesta => {
      const trozos = [];
      respuesta.on('data', trozo => trozos.push(trozo));
      respuesta.on('end', () => resolver({ status: respuesta.statusCode, headers: respuesta.headers, cuerpo: Buffer.concat(trozos).toString() }));
    });
    peticion.on('error', rechazar);
    peticion.setTimeout(10000, () => peticion.destroy(new Error('Timeout de ensayo')));
    peticion.end(body);
  });
}
const resultados = [];
async function comprobar(nombre, ruta, estado, opciones = {}, revisar = () => {}) {
  const respuesta = await pedir(ruta, opciones);
  assert.equal(respuesta.status, estado, nombre + ': ' + ruta);
  revisar(respuesta);
  resultados.push({ nombre, ruta, estado, cache: respuesta.headers['cache-control'], robots: respuesta.headers['x-robots-tag'],
    tipo: respuesta.headers['content-type'], location: respuesta.headers.location });
  return respuesta;
}
const marcador = web + '/.home-public-enabled';
try {
  arrancar(php, ['-c', ini, '-b', '127.0.0.1:' + puertoPhp], { CLX_APACHE_TEST_DIR: privado, PHP_INI_SCAN_DIR: '' });
  await iniciarApache();
  await comprobar('Home histórica antes de activar', '/', 200, {}, r => assert.match(r.cuerpo, /id="reservation"/));
  await comprobar('Anfitrión desactivado', '/home.php', 404);
  await comprobar('Preview denegada', '/home-preview.php', 403);
  await comprobar('Poster antes de activar', '/assets/images/guest-stories/conversacion.webp', 403);
  // Centinelas ficticios: nunca leer secretos ni copiar documentos internos al paquete.
  for (const ruta of ['.env', '.git/config', 'node_modules/fixture.txt', 'assets/scss/fixture.scss', 'assets/js/modules/fixture.js', 'backup.sql', 'copia.backup.js', 'AGENTS.md', 'gulpfile.mjs', 'includes/fixture.txt']) {
    await mkdir(dirname(web + '/' + ruta), { recursive: true });
    await writeFile(web + '/' + ruta, 'QA sentinel');
    await comprobar('Archivo privado', '/' + ruta, 403);
  }
  for (const ruta of ['/includes/site.php', '/docs/interno.md', '/scripts/fixture.php', '/style-guide/', '/.home-public-enabled']) await comprobar('Ruta privada', ruta, 403);
  await comprobar('Wrapper directo', '/contact-page.php', 404);
  await comprobar('404 real', '/ruta-inexistente-r7', 404);
  await writeFile(marcador, '');
  const local = await comprobar('Activación solo local', '/', 200, {}, r => assert.match(r.headers['x-robots-tag'], /noindex/));
  await writeFile(salida + '/home-local.html', local.cuerpo);
  const canonica = { tls: true, host: 'theclandestinousa.com' };
  const publica = await comprobar('SEO canónico TLS simulado', '/', 200, canonica, r => {
    assert.match(r.headers['x-robots-tag'], /^index, follow/);
    assert.match(r.cuerpo, /rel="canonical" href="https:\/\/theclandestinousa.com\/"/);
    assert.match(r.cuerpo, /"@type":"Restaurant"/);
    assert.doesNotMatch(r.cuerpo, /noindex|style-guide\.js|browser-sync-client/);
  });
  await writeFile(salida + '/home-canonica.html', publica.cuerpo);
  await comprobar('Alias de Home', '/home.php', 301, {}, r => {
    const destino = new URL(r.headers.location, 'http://127.0.0.1:' + puertoHttp);
    assert.equal(destino.href, 'http://127.0.0.1:' + puertoHttp + '/');
  });
  await comprobar('Legacy y reserva conservados', '/index.html?legacy=1', 200, canonica, r => {
    assert.match(r.headers['x-robots-tag'], /noindex, follow/); assert.match(r.cuerpo, /id="reservation"/);
  });
  await comprobar('Canonical HTTP', '/?r7=1', 301, { host: 'theclandestinousa.com' }, r => assert.equal(r.headers.location, 'https://theclandestinousa.com/?r7=1'));
  await comprobar('Canonical www', '/', 301, { tls: true, host: 'www.theclandestinousa.com' }, r => assert.equal(r.headers.location, 'https://theclandestinousa.com/'));
  await comprobar('Preview sigue denegada', '/home-preview.php', 403);
  const manifiesto = JSON.parse(await readFile(paquete + '/manifest.json', 'utf8'));
  for (const archivo of manifiesto.archivos.filter(entrada => entrada.ruta.endsWith('.html'))) {
    await comprobar('Página legacy del paquete', '/' + archivo.ruta, 200, canonica);
  }
  const css = await comprobar('CSS versionado', publica.cuerpo.match(/href="(\/assets\/css\/home.css\?v=[^"]+)"/)[1], 200, {}, r => assert.match(r.headers['content-type'], /text\/css/));
  for (const nombre of await readdir(web + '/assets/js/dist')) await comprobar('JS y chunks', '/assets/js/dist/' + nombre, 200, {}, r => assert.match(r.headers['content-type'], /(?:text|application)\/javascript/));
  for (const [ruta, tipo] of [['/assets/icons/cl-iconos.svg', /image\/svg\+xml/],
    ['/assets/images/guest-stories/conversacion.webp', /image\/webp/],
    ['/assets/images/avif/about-banner.avif', /image\/avif/]]) {
    await comprobar('Media y MIME', ruta, 200, {}, r => assert.match(r.headers['content-type'], tipo));
  }
  await comprobar('Revalidación ETag', '/assets/css/home.css', 304, { headers: { 'If-None-Match': css.headers.etag } });
  await comprobar('Compresión gzip', '/assets/css/home.css', 200, { headers: { 'Accept-Encoding': 'gzip' } }, r => assert.equal(r.headers['content-encoding'], 'gzip'));
  await comprobar('Compresión Brotli', '/assets/css/home.css', 200, { headers: { 'Accept-Encoding': 'br' } }, r => assert.equal(r.headers['content-encoding'], 'br'));
  await comprobar('Vídeo parcial', '/assets/images/gallery/videos/Client-1.mp4', 206, { headers: { Range: 'bytes=0-99' } });
  await writeFile(web + '/fuente-qa.woff2', 'QA sentinel');
  await comprobar('MIME de fuente (fixture)', '/fuente-qa.woff2', 200, {}, r => assert.match(r.headers['content-type'], /font\/woff2/));
  await comprobar('Contacto con token', '/contact.html', 200, canonica, r => {
    assert.match(r.cuerpo, /name="csrf_token"[^>]+value="[a-f0-9]{64}"/);
    assert.match(r.headers['cache-control'], /private/);
  });
  const contacto = { name: 'QA Ensayo', email: 'qa@example.invalid', tel: '+1 555 010 0000', subject: 'General Question', message: 'Ensayo local sin envio real.' };
  const reserva = { name: contacto.name, email: contacto.email, phone: contacto.tel, guests: '2', time: '16:00', date: '2099-11-20', eventType: 'standard', accept: 'on', notes: contacto.message };
  for (const [ruta, datos] of [['/contact.php', contacto], ['/reservation.php', reserva]]) {
    for (const [modo, estado] of [['all', 200], ['copies-failure', 200], ['total-failure', 502], ['csrf', 403], ['origin', 403], ...(ruta === '/reservation.php' ? [['date', 422]] : [])]) {
      for (const nombre of await readdir(privado + '/sesiones')) if (/^clx_.*rl_.*\.json$/.test(nombre)) await unlink(privado + '/sesiones/' + nombre);
      await writeFile(privado + '/modo.txt', modo); await writeFile(privado + '/correo.jsonl', '');
      const token = await comprobar('Token HTTPS privado', '/form-token.php', 200, canonica, r => {
        assert.match(r.headers['cache-control'], /private.*no-store/);
        assert.match(r.headers['set-cookie'][0], /secure; HttpOnly; SameSite=Lax/);
      });
      const body = new URLSearchParams({ ...datos, form_loaded_at: String(Math.floor(Date.now() / 1000) - 15),
        csrf_token: modo === 'csrf' ? '' : JSON.parse(token.cuerpo).token, ...(modo === 'date' ? { date: '2099-02-31' } : {}) }).toString();
      await comprobar('Formulario ' + modo, ruta, estado, { ...canonica, method: 'POST', body,
        headers: { Origin: modo === 'origin' ? 'https://evil.invalid' : 'https://theclandestinousa.com', Cookie: token.headers['set-cookie'][0].split(';')[0],
          'Content-Type': 'application/x-www-form-urlencoded', 'Content-Length': Buffer.byteLength(body) } }, r => {
        assert.equal(JSON.parse(r.cuerpo).success, estado === 200);
        assert.match(r.headers['cache-control'], /private.*no-store/);
      });
      const correo = await readFile(privado + '/correo.jsonl', 'utf8');
      if (['csrf', 'origin', 'date'].includes(modo)) assert.equal(correo, '');
      else assert(correo.length > 0);
    }
  }
  await rename(web + '/assets/css/home.css', privado + '/home.css');
  await comprobar('Paquete incompleto falla cerrado', '/', 503, {}, r => assert.match(r.headers['x-robots-tag'], /noindex/));
  await rename(privado + '/home.css', web + '/assets/css/home.css');
  await detener(servidor); await iniciarApache(['headers']);
  await comprobar('Sin mod_headers falla cerrado', '/', 503);
  await detener(servidor); await iniciarApache(['brotli', 'deflate', 'expires']);
  await comprobar('Sin compresión/Expires opcionales', '/', 200);
  await comprobar('CSS sin módulos opcionales', '/assets/css/home.css', 200, { headers: { 'Accept-Encoding': 'br,gzip' } }, r => {
    assert.equal(r.headers['content-encoding'], undefined);
    assert.match(r.headers['cache-control'], /public, max-age=604800/);
  });
  await detener(servidor); await iniciarApache();
  await unlink(marcador);
  await comprobar('Rollback restaura legacy', '/', 200, {}, r => assert.match(r.cuerpo, /id="reservation"/));
  await comprobar('Rollback cierra candidato', '/home.php', 404);
  await comprobar('Rollback conserva redirect histórico', '/index.html', 301, canonica);
  await comprobar('Rollback cierra posters', '/assets/images/guest-stories/conversacion.webp', 403);
  await writeFile(salida + '/resultados.json', JSON.stringify({ puertoHttp, puertoHttps, puertoPhp, resultados }, null, 2) + '\n');
  console.log('PASS: ' + resultados.length + ' comprobaciones Apache/TLS/FastCGI; activación y rollback aislados; correo simulado.');
} catch (error) {
  await writeFile(salida + '/fallo.json', JSON.stringify({ error: error.message, resultados }, null, 2));
  throw error;
} finally {
  await unlink(marcador).catch(error => { if (error.code !== 'ENOENT') throw error; });
  for (const proceso of procesos.reverse()) await detener(proceso);
}
