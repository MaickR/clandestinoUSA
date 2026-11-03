/* Token obtenido del servidor justo antes del envío: admite sesiones caducadas y varias pestañas. */
(function () {
  'use strict';

  window.ClandestinoForms = {
    async preparar(formulario, signal) {
      const respuesta = await fetch('form-token.php', {
        credentials: 'same-origin',
        cache: 'no-store',
        signal,
        headers: { Accept: 'application/json' },
      });
      const datos = await respuesta.json();
      if (!respuesta.ok || !datos.success || !/^[a-f0-9]{64}$/.test(datos.token)) {
        throw new Error('Form session unavailable');
      }
      const campo = formulario.querySelector('[name="csrf_token"]');
      campo.value = datos.token;
      // reset() conserva un token válido sin generar valores independientes en el cliente.
      campo.defaultValue = datos.token;
    },
  };
})();
