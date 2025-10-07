"use strict";

// Legacy stub maintained to avoid broken requests when older caches hit /sw.js.
// The actual carousel initializer now lives in ./assets/js/swc-carousel.js and is
// only loaded on the Spanish Wine Club page.
(function () {
  if (typeof document === "undefined") {
    return;
  }

  if (document.querySelector("script[src*='assets/js/swc-carousel.js']")) {
    return;
  }

  var script = document.createElement("script");
  script.src = "./assets/js/swc-carousel.js";
  script.defer = true;
  document.head.appendChild(script);

  if (typeof console !== "undefined" && console.warn) {
    console.warn("sw.js is deprecated. Use assets/js/swc-carousel.js instead.");
  }
})();
