// Pipeline de frontend: Sass + Bootstrap, PostCSS, esbuild, PHP local y BrowserSync.
// Outputs permitidos: assets/css/style.new.css (+ .map en dev) y assets/js/dist/**.
// El CSS/JS legacy no se compila ni se toca.
import { spawn } from "node:child_process";
import { rm } from "node:fs/promises";
import net from "node:net";
import gulp from "gulp";
import gulpSass from "gulp-sass";
import * as dartSass from "sass";
import postcss from "gulp-postcss";
import autoprefixer from "autoprefixer";
import cssnano from "cssnano";
import rename from "gulp-rename";
import browserSync from "browser-sync";
import { build as esbuild } from "esbuild";

const { src, dest, series, parallel, watch } = gulp;
const sass = gulpSass(dartSass);

const PHP_HOST = "127.0.0.1";
const PHP_PORT = 8000;
const SYNC_PORT = 3000;

const paths = {
  scssEntry: "assets/scss/main.scss",
  scssWatch: "assets/scss/**/*.scss",
  cssDir: "assets/css",
  cssOut: "assets/css/style.new.css",
  cssMap: "assets/css/style.new.css.map",
  jsEntry: "assets/js/main.js",
  jsWatch: ["assets/js/main.js", "assets/js/modules/**/*.js"],
  jsDist: "assets/js/dist",
  jsOut: "assets/js/dist/main.js",
  legacyWatch: [
    "*.html",
    "*.php",
    "assets/css/*.css",
    "!assets/css/style.new.css",
    "assets/js/*.js",
    "!assets/js/main.js",
  ],
};

// Bootstrap 5.3 aún usa @import y funciones Sass globales.
const sassOptions = {
  quietDeps: true,
  silenceDeprecations: ["import", "global-builtin", "color-functions"],
  loadPaths: ["node_modules"],
};

const server = browserSync.create();
let phpProcess = null;

// --- Clean: solo outputs generados por este pipeline ---
export async function clean() {
  await Promise.all(
    [paths.cssOut, paths.cssMap, paths.jsDist].map((p) => rm(p, { recursive: true, force: true })),
  );
}

// --- CSS ---
function cssDev() {
  return src(paths.scssEntry, { sourcemaps: true })
    .pipe(sass(sassOptions).on("error", sass.logError))
    .pipe(postcss([autoprefixer()]))
    .pipe(rename("style.new.css"))
    .pipe(dest(paths.cssDir, { sourcemaps: "." }))
    .pipe(server.stream({ match: "**/*.css" }));
}

function cssBuild() {
  return src(paths.scssEntry)
    .pipe(sass(sassOptions).on("error", sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(rename("style.new.css"))
    .pipe(dest(paths.cssDir));
}

// --- JS ---
const jsOptions = {
  entryPoints: [paths.jsEntry],
  outfile: paths.jsOut,
  bundle: true,
  format: "esm",
  target: "es2020",
  logLevel: "warning",
};

const jsDev = () => esbuild({ ...jsOptions, sourcemap: true, minify: false });
const jsBuild = () => esbuild({ ...jsOptions, sourcemap: false, minify: true });

// --- PHP local ---
function portInUse(port, host) {
  return new Promise((resolve) => {
    const socket = net.connect({ port, host });
    socket.once("connect", () => { socket.destroy(); resolve(true); });
    socket.once("error", () => resolve(false));
  });
}

function stopPhp() {
  if (!phpProcess || phpProcess.exitCode !== null) return;
  phpProcess.kill();
  phpProcess = null;
}

async function php() {
  if (phpProcess) return;
  if (await portInUse(PHP_PORT, PHP_HOST)) {
    throw new Error(`El puerto ${PHP_PORT} ya está en uso; cierra el proceso que lo ocupa.`);
  }
  await new Promise((resolve, reject) => {
    const child = spawn("php", ["-S", `${PHP_HOST}:${PHP_PORT}`, "-t", "."], { stdio: "ignore" });
    phpProcess = child;
    child.once("error", (err) => {
      phpProcess = null;
      reject(new Error(
        err.code === "ENOENT"
          ? "PHP CLI no está disponible en el PATH. Instálalo para usar `npm run dev`."
          : `No se pudo iniciar PHP: ${err.message}`,
      ));
    });
    child.once("exit", (code) => {
      if (phpProcess === child) {
        phpProcess = null;
        if (code) console.error(`PHP terminó con código ${code}`);
      }
    });
    // Si no falla al arrancar, se considera iniciado.
    setTimeout(resolve, 500);
  });
}

// --- BrowserSync ---
function serve(done) {
  server.init({
    proxy: `http://${PHP_HOST}:${PHP_PORT}`,
    port: SYNC_PORT,
    ui: false,
    notify: false,
    open: false,
  }, done);
}

const reload = (done) => { server.reload(); done(); };

function watcher() {
  watch(paths.scssWatch, cssDev);
  watch(paths.jsWatch, series(jsDev, reload));
  watch(paths.legacyWatch, reload);
}

// Cierre limpio del proceso PHP (Ctrl+C y terminación).
for (const signal of ["SIGINT", "SIGTERM", "SIGHUP"]) {
  process.on(signal, () => { stopPhp(); process.exit(0); });
}
process.on("exit", stopPhp);

export const dev = series(clean, parallel(cssDev, jsDev), php, serve, watcher);
export const build = series(clean, parallel(cssBuild, jsBuild));
export default dev;