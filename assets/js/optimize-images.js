// assets/js/optimize-images.js
// Runtime enhancement: wrap <img> tags with <picture> providing AVIF + WebP sources
// and upgrade inline background-image styles to use image-set for modern formats.
// Non-destructive: original <img> kept as fallback; add data-no-opt to skip.

(function(){
  const IMG_ROOT = './assets/images/';
  const AVIF_ROOT = './assets/images/avif/';
  const WEBP_ROOT = './assets/images/webp/';

  const IMG_EXT_RE = /\.(jpe?g|png)$/i;

  function buildAltPaths(src){
    if(!src) return null;
    if(!src.includes('/assets/images/') || !IMG_EXT_RE.test(src)) return null;
    if(src.includes('/avif/') || src.includes('/webp/')) return null; // already optimized variant
    const rel = src.split('/assets/images/')[1];
    const baseNoExt = rel.replace(/\.[^.]+$/, '');
    return {
      avif: AVIF_ROOT + baseNoExt + '.avif',
      webp: WEBP_ROOT + baseNoExt + '.webp',
      original: src
    };
  }

  function upgradeImg(img){
    if(img.dataset.optimized) return; // avoid double processing
    if(img.hasAttribute('data-no-opt')) return;
    const src = img.getAttribute('src');
    const paths = buildAltPaths(src);
    if(!paths) return;
    const picture = document.createElement('picture');
    // Preserve layout-related classes on picture; keep utility classes on img if needed
    if(img.className) picture.className = img.className;
    const avif = document.createElement('source');
    avif.type = 'image/avif';
    avif.srcset = paths.avif;
    const webp = document.createElement('source');
    webp.type = 'image/webp';
    webp.srcset = paths.webp;
    // Clone original img for fallback
    const clone = img.cloneNode(true);
    // Remove class from fallback to avoid double styling (optional). Comment out if undesired.
    // clone.removeAttribute('class');
    clone.dataset.optimized = 'true';
    picture.appendChild(avif);
    picture.appendChild(webp);
    picture.appendChild(clone);
    img.replaceWith(picture);
  }

  function upgradeInlineBackground(el){
    const style = el.getAttribute('style');
    if(!style) return;
    // Find occurrences of background-image or background with url(...)
    const urlRe = /url\((['"]?)([^)'"]+\.(?:jpe?g|png))(?:\?[^)'"]*)?\1\)/ig;
    let modified = false;
    let newStyle = style.replace(urlRe, (match, quote, url) => {
      if(!url.includes('/assets/images/') || url.includes('/avif/') || url.includes('/webp/')) return match;
      const paths = buildAltPaths(url.replace(/^\.\//,''));
      if(!paths) return match;
      modified = true;
      // image-set with fallbacks; browsers ignore unknown types gracefully
      return `image-set(url(${paths.avif}) type("image/avif"), url(${paths.webp}) type("image/webp"), url(${paths.original}))`;
    });
    if(modified){
      el.setAttribute('style', newStyle);
    }
  }

  function processAll(root){
    root.querySelectorAll('img').forEach(upgradeImg);
    root.querySelectorAll('[style*="background"]').forEach(upgradeInlineBackground);
  }

  function observeMutations(){
    const observer = new MutationObserver(muts => {
      muts.forEach(m => {
        m.addedNodes.forEach(node => {
          if(!(node instanceof HTMLElement)) return;
            if(node.tagName === 'IMG') upgradeImg(node);
            processAll(node);
        });
      });
    });
    observer.observe(document.documentElement, { childList: true, subtree: true });
  }

  function onReady(fn){
    if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn); else fn();
  }

  onReady(() => {
    processAll(document);
    observeMutations();
  });
})();
