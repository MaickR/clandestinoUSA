/** Conserva el deep link histórico sin duplicar el formulario legacy en Home. */
export function inicializarAnclasLegacy(pagina) {
  if (!pagina.matches('[data-cl-home-publica]')) return;
  const destino = new URL(pagina.dataset.clReservaLegacy, window.location.origin);
  if (destino.origin !== window.location.origin || destino.pathname !== '/index.html' || destino.hash !== '#reservation') {
    throw new TypeError('Destino de reserva legacy no admitido.');
  }
  const continuar = () => {
    // La query del anfitrión evita antiguos 301 cacheados de /index.html a /.
    if (window.location.hash === '#reservation') window.location.replace(destino.href);
  };
  window.addEventListener('hashchange', continuar);
  continuar();
}
