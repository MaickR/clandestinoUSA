/**
 * Centered result dialog for Clandestino forms.
 * Auto-closes after 8 seconds. Backdrop, Escape, X, or Close dismiss it sooner.
 */
(function () {
  'use strict';

  var AUTO_MS = 8000;
  var root = null;
  var tick = null;
  var hideTimer = null;

  function markup(success) {
    var icon = success
      ? '<svg viewBox="0 0 52 52" aria-hidden="true"><circle class="cfb-circle" cx="26" cy="26" r="25"/><path class="cfb-mark" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>'
      : '<svg viewBox="0 0 52 52" aria-hidden="true"><circle class="cfb-circle" cx="26" cy="26" r="25"/><path class="cfb-mark" d="M16 16 36 36"/><path class="cfb-mark" d="M36 16 16 36"/></svg>';
    return (
      '<div class="cfb-card" role="dialog" aria-modal="true" aria-labelledby="cfb-title" aria-describedby="cfb-text">' +
        '<button type="button" class="cfb-x" data-cfb-close aria-label="Close">&times;</button>' +
        '<div class="cfb-icon">' + icon + '</div>' +
        '<h3 class="cfb-title" id="cfb-title"></h3>' +
        '<p class="cfb-text" id="cfb-text"></p>' +
        '<p class="cfb-count">Closing in <strong data-cfb-seconds>8</strong>s</p>' +
        '<button type="button" class="cfb-btn" data-cfb-close>Close</button>' +
      '</div>'
    );
  }

  function ensure() {
    if (root) return root;
    root = document.createElement('div');
    root.className = 'cfb';
    root.hidden = true;
    document.body.appendChild(root);
    root.addEventListener('click', function (e) {
      if (e.target === root || e.target.closest('[data-cfb-close]')) close();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && root && !root.hidden) close();
    });
    return root;
  }

  function clearTimers() {
    if (tick) { clearInterval(tick); tick = null; }
    if (hideTimer) { clearTimeout(hideTimer); hideTimer = null; }
  }

  function close() {
    clearTimers();
    if (!root) return;
    root.hidden = true;
    document.body.classList.remove('cfb-lock');
  }

  function open(opts) {
    var success = !!(opts && opts.success);
    var el = ensure();
    clearTimers();
    el.classList.toggle('is-ok', success);
    el.classList.toggle('is-bad', !success);
    el.innerHTML = markup(success);
    el.querySelector('#cfb-title').textContent = (opts && opts.title) || (success ? 'Sent' : 'Something went wrong');
    el.querySelector('#cfb-text').textContent = (opts && opts.message) || '';
    el.hidden = false;
    document.body.classList.add('cfb-lock');
    var secondsEl = el.querySelector('[data-cfb-seconds]');
    var left = 8;
    tick = setInterval(function () {
      left -= 1;
      if (secondsEl) secondsEl.textContent = String(Math.max(left, 0));
      if (left <= 0) close();
    }, 1000);
    hideTimer = setTimeout(close, AUTO_MS);
    var btn = el.querySelector('.cfb-btn');
    if (btn) btn.focus();
  }

  window.ClandestinoFeedback = { open: open, close: close };
})();
