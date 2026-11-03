// Pruebas HTTP reales con sesiones y transporte simulado; nunca habilitar mail() nativo.
import assert from 'node:assert/strict';
import { spawn, execFileSync } from 'node:child_process';
import { mkdtemp, readFile, writeFile, readdir, rm } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import { resolve, join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import { createServer } from 'node:net';
import { runInNewContext } from 'node:vm';

const raiz = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const temporal = await mkdtemp(join(tmpdir(), 'clx-forms-qa-'));
const socket = createServer();
await new Promise((resolver) => socket.listen(0, '127.0.0.1', resolver));
const puerto = socket.address().port;
await new Promise((resolver) => socket.close(resolver));
const origen = `http://127.0.0.1:${puerto}`;
await writeFile(join(temporal, 'modo.txt'), 'all');
const servidor = spawn('php', [
  '-d', 'disable_functions=mail', '-d', 'display_errors=0',
  '-d', `session.save_path=${temporal}`, '-d', `sys_temp_dir=${temporal}`,
  '-S', `127.0.0.1:${puerto}`, '-t', raiz, join(raiz, 'scripts/fixtures/forms-router.php'),
], { cwd: raiz, env: { ...process.env, CLX_FORMS_TEST_DIR: temporal }, stdio: ['ignore', 'pipe', 'pipe'] });
let registro = '';
servidor.stderr.on('data', (datos) => { registro += datos.toString(); });
servidor.stdout.on('data', (datos) => { registro += datos.toString(); });
const pausa = (ms) => new Promise((resolver) => setTimeout(resolver, ms));

async function captura() {
  const contenido = await readFile(join(temporal, 'correo.jsonl'), 'utf8').catch(() => '');
  return contenido.trim() ? contenido.trim().split('\n').map((linea) => JSON.parse(linea)) : [];
}

async function preparar(modo = 'all') {
  await writeFile(join(temporal, 'modo.txt'), modo);
  await writeFile(join(temporal, 'correo.jsonl'), '');
  for (const nombre of await readdir(temporal)) {
    if (/^clx_(res_)?rl_.*\.json$/.test(nombre)) await rm(join(temporal, nombre));
  }
  const respuesta = await fetch(`${origen}/form-token.php`, { headers: { Origin: origen } });
  assert.equal(respuesta.status, 200);
  assert.match(respuesta.headers.get('cache-control'), /no-store/);
  const cookie = respuesta.headers.get('set-cookie');
  assert.match(cookie, /HttpOnly/i);
  assert.match(cookie, /SameSite=Lax/i);
  assert.doesNotMatch(cookie, /;\s*secure/i);
  const datos = await respuesta.json();
  assert.match(datos.token, /^[a-f0-9]{64}$/);
  return { token: datos.token, cookie: cookie.split(';')[0] };
}

async function enviar(ruta, datos, sesion, cabeceras = {}) {
  const respuesta = await fetch(`${origen}/${ruta}.php`, {
    method: 'POST',
    body: new URLSearchParams({ ...datos, csrf_token: sesion.token }),
    headers: { Origin: origen, Cookie: sesion.cookie, ...cabeceras },
  });
  assert.match(respuesta.headers.get('content-type'), /application\/json/);
  const json = await respuesta.json();
  assert.equal(typeof json.success, 'boolean');
  if (!json.success) assert.equal(typeof json.errorMessage, 'string');
  return { codigo: respuesta.status, json };
}

async function probarResultadoCliente(tipo, caso) {
  // Ejecutar el listener real; DOM/transporte/reloj son dobles, sin copiar su lógica de resultado.
  const contacto = tipo === 'contact';
  const pagina = await readFile(join(raiz, contacto ? 'contact.html' : 'index.html'), 'utf8');
  const marcador = contacto ? "form.addEventListener('submit', " : "document.addEventListener('submit', ";
  const inicio = pagina.indexOf(marcador, pagina.indexOf(contacto ? '<!-- Contact Form Modal Handler -->' : '<!-- Reservation form:')) + marcador.length;
  const fin = pagina.indexOf('}, true);', inicio);
  assert.ok(inicio >= marcador.length && fin > inicio);
  const clases = new Set();
  const atributos = new Map();
  const boton = {
    disabled: false,
    classList: { contains: (valor) => clases.has(valor), add: (valor) => clases.add(valor), remove: (valor) => clases.delete(valor) },
    setAttribute: (clave, valor) => atributos.set(clave, valor),
    getAttribute: (clave) => atributos.get(clave),
    removeAttribute: (clave) => atributos.delete(clave),
  };
  let reinicios = 0;
  const formulario = { id: 'clandestino-reservation-form', action: 'contact.php', reset: () => { reinicios++; } };
  for (const campo of ['name', 'email', 'phone', 'guests', 'date', 'time', 'eventType', 'notes', 'customTitle', 'budget']) formulario[campo] = { value: 'QA' };
  const resultados = [];
  let temporizadorActivo = false;
  let vencer;
  let lecturaIniciada = false;
  let solicitudes = 0;
  const entorno = {
    window: { ClandestinoForms: caso === 'helper-ausente' ? undefined : { preparar: async () => {} } },
    document: { getElementById: (id) => ['clx-submit-btn', 'reservation-submit'].includes(id) ? boton : null },
    form: formulario, FORM_ID: formulario.id, ENDPOINT: 'reservation.php', statusEl: null, loadedAtField: null,
    validateForm: () => true, fieldError: () => '', looksSpammy: () => false, setStamp: () => {}, showInlineStatus: () => {},
    showModal: (success, title, message) => resultados.push({ success, title, message }),
    feedback: (success, title, message) => resultados.push({ success, title, message }),
    FormData: class {}, AbortController,
    setTimeout: (callback) => { temporizadorActivo = true; vencer = callback; return 1; },
    clearTimeout: () => { temporizadorActivo = false; },
    fetch: async (url, opciones) => {
      solicitudes++;
      return {
        ok: caso !== 'fallo-total' && caso !== 'http-error-success',
        json: async () => {
          lecturaIniciada = true;
          assert.ok(temporizadorActivo, 'El timeout debe cubrir también la lectura del cuerpo');
          if (caso === 'cuerpo-bloqueado') {
            return await new Promise((resolver, rechazar) => opciones.signal.addEventListener('abort', () => rechazar(Object.assign(new Error('Aborted'), { name: 'AbortError' })), { once: true }));
          }
          if (caso === 'json-roto') throw new Error('Invalid JSON');
          if (caso === 'contrato-invalido') return { success: 'false', message: 'Invalid' };
          if (caso === 'fallo-total') return { success: false, errorMessage: 'We could not send your request. Please call us.' };
          return { success: true, message: 'Your request was accepted for processing. We will confirm by email or phone.' };
        },
      };
    },
  };
  const listener = runInNewContext('(' + pagina.slice(inicio, fin + 1) + ')', entorno);
  const pendiente = listener({ target: formulario, preventDefault() {}, stopImmediatePropagation() {} });
  await new Promise((resolver) => setImmediate(resolver));
  if (caso === 'cuerpo-bloqueado') {
    assert.ok(lecturaIniciada && temporizadorActivo);
    vencer();
  }
  await pendiente;
  await new Promise((resolver) => setImmediate(resolver));
  assert.equal(resultados.length, 1, `${tipo}/${caso}`);
  assert.equal(resultados[0].success, caso === 'aceptado', `${tipo}/${caso}`);
  assert.equal(reinicios, caso === 'aceptado' ? 1 : 0, 'Conservar datos salvo aceptación');
  assert.equal(boton.disabled, false);
  assert.equal(clases.has('is-loading'), false);
  assert.equal(atributos.has('data-sending'), false);
  assert.equal(temporizadorActivo, false);
  assert.equal(solicitudes, caso === 'helper-ausente' ? 0 : 1);
  if (caso === 'helper-ausente') assert.match(resultados[0].message, /No (message|request) was sent/);
  else if (caso !== 'aceptado' && caso !== 'fallo-total') assert.match(resultados[0].message, /before submitting again/);
}

try {
  let listo = false;
  for (let intento = 0; intento < 60; intento++) {
    try {
      await fetch(`${origen}/form-token.php`);
      listo = true;
      break;
    } catch { await pausa(100); }
  }
  assert.ok(listo, registro);
  for (const tipo of ['contact', 'reservation']) {
    for (const caso of ['aceptado', 'fallo-total', 'helper-ausente', 'json-roto', 'contrato-invalido', 'http-error-success', 'cuerpo-bloqueado']) {
      await probarResultadoCliente(tipo, caso);
    }
  }
  // Ejecutar el módulo real sin navegador ni correo: fallos del bootstrap CSRF son cerrados.
  let respuestaToken = { ok: true, json: async () => ({ success: true, token: 'b'.repeat(64) }) };
  const entornoCliente = {
    window: {}, fetch: async () => {
      if (respuestaToken instanceof Error) throw respuestaToken;
      return respuestaToken;
    },
  };
  runInNewContext(await readFile(join(raiz, 'assets/js/forms-security.js'), 'utf8'), entornoCliente);
  const campoToken = { value: '', defaultValue: '' };
  const formularioCliente = { querySelector: () => campoToken };
  await entornoCliente.window.ClandestinoForms.preparar(formularioCliente);
  assert.equal(campoToken.value, 'b'.repeat(64));
  assert.equal(campoToken.defaultValue, campoToken.value);
  for (const fallo of [
    { ok: false, json: async () => ({ success: false }) },
    { ok: true, json: async () => ({ success: true, token: 'client-only' }) },
    { ok: true, json: async () => { throw new Error('Invalid JSON'); } },
    new Error('Network unavailable'),
  ]) {
    respuestaToken = fallo;
    await assert.rejects(entornoCliente.window.ClandestinoForms.preparar(formularioCliente));
  }
  execFileSync('php', ['-d', `session.save_path=${temporal}`, join(raiz, 'scripts/probar-fechas-formularios.php')], { stdio: 'inherit' });
  const fecha = new Intl.DateTimeFormat('en-CA', { timeZone: 'America/Los_Angeles', year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date());
  const contacto = {
    name: 'Zoë O’Neil & Ana', email: 'qa@example.invalid', tel: '+1 555 010 0000',
    subject: 'General Question', message: 'Fish & wine, "tapas", O\'Neil — español 日本語 🍷',
    form_loaded_at: String(Math.floor(Date.now() / 1000) - 10),
  };
  const reserva = {
    name: contacto.name, email: contacto.email, phone: contacto.tel,
    guests: '2', time: '16:00', date: fecha, eventType: 'standard', accept: 'on',
    notes: contacto.message, form_loaded_at: contacto.form_loaded_at,
  };
  let total = 46;
  for (const [ruta, valido, campoTexto] of [['contact', contacto, 'message'], ['reservation', reserva, 'notes']]) {
    for (const [nombre, cambio, estado, modo, cabeceras] of [
      ['válido / hoy en Los Angeles', {}, 200],
      ['BrowserSync local existente', {}, 200, 'all', { Origin: 'http://localhost:3000' }],
      ['CSRF ausente', {}, 403, 'all', { token: '' }],
      ['CSRF incorrecto', {}, 403, 'all', { token: 'a'.repeat(64) }],
      ['CSRF de otra sesión', {}, 403, 'all', { Cookie: '' }],
      ['origen ajeno', {}, 403, 'all', { Origin: 'https://evil.invalid' }],
      ['origen null', {}, 403, 'all', { Origin: 'null' }],
      ['puerto ajeno', {}, 403, 'all', { Origin: 'https://theclandestinousa.com:444' }],
      ['esquema inseguro', {}, 403, 'all', { Origin: 'http://theclandestinousa.com' }],
      ['referer ajeno', {}, 403, 'all', { Referer: 'https://evil.invalid/form' }],
      ['host/proxy manipulados', {}, 403, 'all', { Host: 'evil.invalid', Origin: 'https://evil.invalid', 'X-Forwarded-Proto': 'https', 'X-Forwarded-Host': 'theclandestinousa.com' }],
      ['fetch metadata cross-site', {}, 403, 'all', { 'Sec-Fetch-Site': 'cross-site' }],
      ['inyección de cabecera', { name: 'Ana\r\nBcc: evil@example.invalid' }, 422],
      ['array malformado', { 'name[]': 'Ana', name: undefined }, 422],
      ['array anidado', { 'diet[][]': 'vegan' }, 422],
      ['correo inválido sin saneamiento silencioso', { email: 'qa <>@example.invalid' }, 422],
      ['fallo total', {}, 502, 'total-failure'],
      ['fallo principal, copias disponibles', {}, 502, 'primary-failure'],
      ['fallo de copia', {}, 200, 'copy-failure'],
      ['fallo de ambas copias', {}, 200, 'copies-failure'],
      ['alternativa en texto plano', {}, 200, 'fallback'],
      ['HTML malicioso como texto', { [campoTexto]: '<script>alert("x")</script> & <img src=x onerror=alert(1)>' }, 200],
      ['honeypot', { website: 'bot' }, 200],
      ['spam combinado', { [campoTexto]: 'viagra https://example.invalid https://other.invalid' }, 200],
      ['time-trap expirado', { form_loaded_at: String(Math.floor(Date.now() / 1000) - 10801) }, 400],
      ['autofill rápido', { form_loaded_at: String(Math.floor(Date.now() / 1000)) }, 200],
      ['sin timestamp aislado', { form_loaded_at: '' }, 200],
    ]) {
      const sesion = await preparar(modo);
      const headers = { ...cabeceras };
      if ('token' in headers) { sesion.token = headers.token; delete headers.token; }
      const datos = { ...valido, ...cambio };
      if (datos.name === undefined) delete datos.name;
      const resultado = await enviar(ruta, datos, sesion, headers);
      assert.equal(resultado.codigo, estado, `${ruta}: ${nombre}: ${JSON.stringify(resultado.json)}`);
      const correos = await captura();
      const sinCorreo = estado >= 400 && estado !== 502 || /honeypot|spam combinado/.test(nombre);
      if (sinCorreo) assert.equal(correos.length, 0, nombre);
      else if (estado === 502) {
        assert.equal(correos.length, 2);
        assert.ok(correos.every((correo) => correo.role === 'primary' && !correo.accepted));
        assert.equal(resultado.json.error, 'send');
      } else {
        assert.equal(resultado.json.success, true);
        assert.ok(correos.some((correo) => correo.role === 'primary' && correo.accepted));
        assert.ok(correos.some((correo) => correo.role === 'internal'));
        if (nombre.includes('válido')) {
          assert.ok(correos[0].body.includes('Fish &amp; wine, &quot;tapas&quot;, O&#039;Neil — español 日本語 🍷'));
          assert.ok(correos[0].body.includes('Zoë O’Neil &amp; Ana'));
          assert.ok(!correos[0].body.includes('&amp;amp;'));
        }
        if (nombre === 'alternativa en texto plano') {
          assert.equal(correos.length, 6);
          assert.ok(correos[1].body.includes(contacto.message));
          assert.ok(!correos[1].body.includes('&amp;'));
        }
        if (nombre === 'fallo de copia') {
          assert.equal(correos.length, 4);
          assert.ok(correos.at(-1).accepted && correos.at(-1).role === 'internal');
        }
        if (nombre.startsWith('HTML')) {
          assert.ok(correos[0].body.includes('&lt;script&gt;'));
          assert.ok(!correos[0].body.includes('<script>'));
          assert.ok(!correos[0].body.includes('<img src=x'));
        }
      }
      total++;
    }
    const sesionInvalida = await preparar();
    const invalida = await fetch(`${origen}/${ruta}.php`, {
      method: 'POST',
      body: new URLSearchParams({ ...valido, csrf_token: sesionInvalida.token }).toString() + `&${campoTexto}=%FF`,
      headers: { Cookie: sesionInvalida.cookie, Origin: origen, 'Content-Type': 'application/x-www-form-urlencoded' },
    });
    assert.equal(invalida.status, 422);
    assert.equal((await captura()).length, 0);
    total++;
    const sinToken = await fetch(`${origen}/${ruta}.php`, {
      method: 'POST', body: new URLSearchParams(valido),
      headers: { Cookie: sesionInvalida.cookie, Origin: origen },
    });
    assert.equal(sinToken.status, 403);
    assert.equal((await captura()).length, 0);
    total++;
    // Reenvío inmediato conserva throttle y no genera una segunda notificación.
    const sesion = await preparar();
    assert.equal((await enviar(ruta, valido, sesion)).codigo, 200);
    assert.equal((await enviar(ruta, valido, sesion)).codigo, 429);
    assert.equal((await captura()).length, 3);
    total++;
    for (const metodo of ['GET', 'PUT']) {
      const respuesta = await fetch(`${origen}/${ruta}.php`, { method: metodo });
      assert.equal(respuesta.status, 405);
      assert.equal(respuesta.headers.get('allow'), 'POST');
      total++;
    }
  }
  for (const date of ['2027-02-31', '2027-02-29', '2000-01-01', '2027-13-01', ' 2027-03-01', '2027-03-01junk']) {
    const sesion = await preparar();
    assert.equal((await enviar('reservation', { ...reserva, date }, sesion)).codigo, 422);
    assert.equal((await captura()).length, 0);
    total++;
  }
  // Un token de sesión se conserva entre pestañas y no cambia al volver a consultarlo.
  const sesionPersistente = await preparar();
  const otroToken = await fetch(`${origen}/form-token.php`, { headers: { Cookie: sesionPersistente.cookie } });
  assert.equal((await otroToken.json()).token, sesionPersistente.token);
  total++;
  for (const headers of [
    { Origin: 'https://evil.invalid' }, { Origin: 'null' },
    { Origin: `${origen}/path` }, { Origin: 'https://theclandestinousa.com.evil.invalid' },
  ]) {
    assert.equal((await fetch(`${origen}/form-token.php`, { headers })).status, 403);
    total++;
  }
  assert.equal((await fetch(`${origen}/form-token.php`, { method: 'POST' })).status, 405);
  total++;
  // Cabeceras ausentes admitidas con token; navegación legítima con Referer funciona.
  for (const headers of [{}, { Referer: `${origen}/contact.html?from=home` }]) {
    const sesion = await preparar();
    const respuesta = await fetch(`${origen}/contact.php`, {
      method: 'POST', body: new URLSearchParams({ ...contacto, csrf_token: sesion.token }),
      headers: { Cookie: sesion.cookie, ...headers },
    });
    assert.equal(respuesta.status, 200);
    total++;
  }
  const sesionSpam = await preparar();
  const spamSinOrigen = await fetch(`${origen}/contact.php`, {
    method: 'POST', body: new URLSearchParams({ ...contacto, message: 'viagra information please', csrf_token: sesionSpam.token }),
    headers: { Cookie: sesionSpam.cookie },
  });
  assert.equal(spamSinOrigen.status, 200);
  assert.equal((await captura()).length, 0);
  total++;
  // Navegación convencional: token insertado en HTML, POST sin JS ni X-Requested-With.
  await preparar();
  const documentoContacto = await fetch(`${origen}/contact.html`);
  assert.match(documentoContacto.headers.get('content-type'), /text\/html/);
  const cookieContacto = documentoContacto.headers.get('set-cookie').split(';')[0];
  const htmlContacto = await documentoContacto.text();
  const tokenContacto = htmlContacto.match(/name="csrf_token" id="clx-csrf-token" value="([a-f0-9]{64})"/)[1];
  const envioNativo = await fetch(`${origen}/contact.php`, {
    method: 'POST', body: new URLSearchParams({ ...contacto, csrf_token: tokenContacto }),
    headers: { Cookie: cookieContacto },
  });
  assert.equal(envioNativo.status, 200);
  assert.equal((await envioNativo.json()).success, true);
  total++;
  const antes = registro;
  const sesion = await preparar('copy-failure');
  await enviar('contact', contacto, sesion);
  await pausa(50);
  const logs = registro.slice(antes.length).split('\n').filter((linea) => linea.includes('[formularios]'));
  assert.equal(logs.length, 3);
  assert.ok(logs.some((linea) => linea.includes('"role":"copy","accepted":false')));
  assert.ok(logs.every((linea) => !/example\.invalid|Zoë|Fish|555|ntcusa/.test(linea)));
  console.log(`PASS: ${total} casos; correo nativo deshabilitado; contratos JSON, logs, CSRF, calendario y antispam.`);
  if (process.argv.includes('--serve')) {
    await preparar();
    console.log(`QA local: ${origen}/contact.html y ${origen}/index.html#reservation`);
    console.log(`Control simulado: ${join(temporal, 'modo.txt')}`);
    console.log('Detener con Ctrl+C. Nunca subir el router ni las pruebas al hosting.');
    await new Promise((resolver) => { process.once('SIGINT', resolver); process.once('SIGTERM', resolver); });
  }
} finally {
  servidor.kill();
  await new Promise((resolver) => servidor.exitCode !== null ? resolver() : servidor.once('exit', resolver));
  // Solo se limpia el directorio único creado por esta ejecución.
  assert.ok(temporal.startsWith(join(tmpdir(), 'clx-forms-qa-')));
  await rm(temporal, { recursive: true, force: true });
}
