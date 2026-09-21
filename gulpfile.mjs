//? Dependencias de gulp
import gulp from 'gulp';
const { src, dest, watch, series, parallel } = gulp;

//? Entorno (.env) — evita URLs hardcodeadas de un ambiente a otro
import 'dotenv/config';
const SITE_URL = process.env.SITE_URL || 'http://localhost:3000';

//? Limpieza previa al build (SOLO de artefactos del pipeline nuevo, nunca del CSS real en producción)
import { deleteAsync } from 'del';

//? CSS y SASS
import sass from 'gulp-sass';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import sourcemaps from 'gulp-sourcemaps';
import cssnano from 'cssnano';
import * as sassCompiler from 'sass';
const sassGulp = sass(sassCompiler);

//? Imágenes
import imagemin from 'gulp-imagemin';
import imageminMozjpeg from 'imagemin-mozjpeg';
import imageminPngquant from 'imagemin-pngquant';
import imageminSvgo from 'imagemin-svgo';
import webp from 'gulp-webp';
import avif from 'gulp-avif';

/*
! REGLA DE SEGURIDAD NO NEGOCIABLE
! Este pipeline NUNCA escribe ni borra assets/css/style.css ni assets/css/style.min.css
! (son el CSS real en producción, migrado a mano/histórico, no generado).
! Todo lo que compila el SCSS nuevo va a assets/css/style.new.css hasta que el refactor
! de una sección esté completo y verificado — el corte final (renombrar style.new.css a
! style.css) es un paso manual y deliberado, nunca automático.
*/

//* Rutas — separadas explícitamente entre "real en producción" y "pipeline nuevo en construcción"
const RUTAS = {
    scssEntrada: 'assets/scss/main.scss',
    scssTodo: 'assets/scss/**/*.scss',
    cssDestino: 'assets/css',
    cssArchivoNuevo: 'style.new.css', // ! nunca "style.css" — ver regla de seguridad arriba
    jsEntrada: 'assets/js/main.js',
    jsTodo: 'assets/js/**/*.js',
    jsDestino: 'assets/js/dist',
    imagenesRaster: 'assets/images/**/*.{jpg,jpeg,png}',
    imagenesSvg: 'assets/images/**/*.svg',
    imagenesDestino: 'assets/images',
    html: ['*.html', '*.php', 'pages/**/*.html', 'pages/**/*.php'],
};

//* Herramienta que evita que se detenga el proceso de compilación
import plumber from 'gulp-plumber';

//? Ve los cambios en el navegador
import { createRequire } from 'module';
const require = createRequire(import.meta.url);
const browserSync = require('browser-sync').create();

//? Herramientas adicionales
import rename from 'gulp-rename';
import sitemap from 'gulp-sitemap';
import esbuild from 'gulp-esbuild';

//* Limpia SOLO los artefactos del pipeline nuevo (nunca el CSS real de producción)
function limpiar() {
    return deleteAsync([
        `${RUTAS.cssDestino}/${RUTAS.cssArchivoNuevo}`,
        `${RUTAS.cssDestino}/${RUTAS.cssArchivoNuevo}.map`,
        RUTAS.jsDestino,
    ]);
}

//* Compila el SCSS nuevo a un archivo separado del CSS real (style.new.css, nunca style.css)
function css(done) {
    src(RUTAS.scssEntrada)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sassGulp())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(rename(RUTAS.cssArchivoNuevo))
        .pipe(sourcemaps.write('.'))
        .pipe(dest(RUTAS.cssDestino))
        .pipe(browserSync.stream());
    done();
}

//* Optimiza JPG/PNG en su propio lugar (assets/images)
//! Modifica los originales in-place — haz commit en git antes de correr esto la primera vez,
//! así git es tu respaldo si algo no se ve bien después de optimizar.
function imagenesRaster() {
    return src(RUTAS.imagenesRaster, { encoding: false })
        .pipe(imagemin([
            imageminMozjpeg({ quality: 80 }),
            imageminPngquant({ quality: [0.7, 0.8] }),
        ]))
        .pipe(dest(RUTAS.imagenesDestino));
}

//* Optimiza SVG (el logo actual pesa 425 KB sin optimizar — prioridad alta)
function imagenesSvg() {
    return src(RUTAS.imagenesSvg)
        .pipe(imagemin([imageminSvgo()]))
        .pipe(dest(RUTAS.imagenesDestino));
}

//* Genera versiones WebP a partir de JPG/PNG originales
function generarWebpVersiones() {
    return src(RUTAS.imagenesRaster, { encoding: false })
        .pipe(webp({ quality: 50 }))
        .pipe(dest(`${RUTAS.imagenesDestino}/webp`));
}

//* Genera versiones AVIF a partir de JPG/PNG originales
function generarAvifVersiones() {
    return src(RUTAS.imagenesRaster, { encoding: false })
        .pipe(avif({ quality: 50 }))
        .pipe(dest(`${RUTAS.imagenesDestino}/avif`));
}

//* Bundle de JS con esbuild: respeta módulos ES6 (named exports, import() dinámico)
function js() {
    return src(RUTAS.jsEntrada)
        .pipe(plumber())
        .pipe(esbuild({
            // ! esbuild no acepta "outfile" y "outdir" a la vez — con splitting:true es obligatorio usar solo outdir.
            bundle: true,
            minify: true,
            sourcemap: true,
            format: 'esm',
            splitting: true,
            outdir: RUTAS.jsDestino,
            target: 'es2020',
        }))
        .pipe(dest(RUTAS.jsDestino));
}

//* Generación de sitemap para SEO — URL leída de .env (SITE_URL), nunca hardcodeada
function generarSitemap() {
    return src([...RUTAS.html, '!node_modules/**'])
        .pipe(sitemap({ siteUrl: SITE_URL }))
        .pipe(dest('.'));
}

//? Configuración de BrowserSync — sirve el proyecto tal cual, sobre HTTP real (nunca abrir por file://)
function servidor(done) {
    browserSync.init({
        server: {
            baseDir: './',
        },
    });
    done();
}

//? Función para recargar BrowserSync
function recargar(done) {
    browserSync.reload();
    done();
}

//? Tarea de desarrollo
function dev() {
    watch(RUTAS.scssTodo, css);
    watch(RUTAS.jsTodo, js);
    watch(RUTAS.imagenesRaster, series(imagenesRaster, generarWebpVersiones, generarAvifVersiones, recargar));
    watch(RUTAS.html, series(generarSitemap, recargar));
}

/*
* CÓMO SE HACE EL CORTE FINAL (cutover) DE UNA SECCIÓN YA MIGRADA A SCSS:
* 1. Confirma visualmente que assets/css/style.new.css cubre TODAS las reglas de esa
*    sección igual o mejor que assets/css/style.css.
* 2. Haz commit del estado actual (checkpoint de seguridad).
* 3. Recién ahí, y a mano, se agrega el <link> a style.new.css en las páginas migradas
*    y se retira gradualmente el <link> a style.css — nunca se borra style.css de un
*    tirón hasta que TODAS las páginas estén migradas.
* Este gulpfile no automatiza este paso a propósito — es una decisión que requiere tu
* confirmación explícita cada vez, no un comando.
*/

export {
    css,
    js,
    imagenesRaster,
    imagenesSvg,
    generarWebpVersiones,
    generarAvifVersiones,
    generarSitemap,
    limpiar,
};

export default series(
    limpiar,
    parallel(imagenesRaster, imagenesSvg),
    generarWebpVersiones,
    generarAvifVersiones,
    css,
    js,
    generarSitemap,
    servidor,
    dev,
);
