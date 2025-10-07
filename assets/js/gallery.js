/* Custom Clandestino Gallery & Lightbox (vanilla JS)
   - Lightbox with prev/next/close, keyboard nav, focus trap
   - Filter support (data-clandestino-gallery-filter)
   - Accessible: role=dialog, aria-modal, live caption
*/
(() => {
  'use strict';
  const GALLERY_GRID_SELECTOR = '[data-clandestino-gallery-grid]';
  const FILTER_BAR_SELECTOR = '[data-clandestino-gallery-filter]';
  let lightboxEl, stageImg, captionEl, idx = 0, activeGroup = null, groups = new Map();
  let lastFocused = null;

  function buildLightbox(){
    if(lightboxEl) return;
    lightboxEl = document.createElement('div');
    lightboxEl.className = 'clx-lightbox';
    lightboxEl.setAttribute('role','dialog');
    lightboxEl.setAttribute('aria-modal','true');
    lightboxEl.setAttribute('aria-label','Image gallery viewer');
    lightboxEl.innerHTML = `
      <button class="clx-lightbox-close" aria-label="Close (Esc)">✕</button>
      <button class="clx-lightbox-nav clx-lightbox-prev" aria-label="Previous image" title="Previous (Arrow Left)">‹</button>
      <div class="clx-lightbox-stage">
        <img alt="" />
        <p class="clx-lightbox-caption" aria-live="polite"></p>
      </div>
      <button class="clx-lightbox-nav clx-lightbox-next" aria-label="Next image" title="Next (Arrow Right)">›</button>`;
    document.body.appendChild(lightboxEl);
    stageImg = lightboxEl.querySelector('img');
    captionEl = lightboxEl.querySelector('.clx-lightbox-caption');
    lightboxEl.addEventListener('click', e=>{ if(e.target === lightboxEl) closeLightbox(); });
    lightboxEl.querySelector('.clx-lightbox-close').addEventListener('click', closeLightbox);
    lightboxEl.querySelector('.clx-lightbox-prev').addEventListener('click', ()=> showRelative(-1));
    lightboxEl.querySelector('.clx-lightbox-next').addEventListener('click', ()=> showRelative(1));
    document.addEventListener('keydown', keyHandler);
  }

  function keyHandler(e){
    if(!lightboxEl || !lightboxEl.classList.contains('is-open')) return;
    if(e.key === 'Escape') closeLightbox();
    else if(e.key === 'ArrowRight') showRelative(1);
    else if(e.key === 'ArrowLeft') showRelative(-1);
    else if(e.key === 'Tab') trapFocus(e);
  }
  function trapFocus(e){
    const focusables = lightboxEl.querySelectorAll('button, [href], img');
    if(!focusables.length) return;
    const first = focusables[0];
    const last = focusables[focusables.length-1];
    if(e.shiftKey && document.activeElement === first){ e.preventDefault(); last.focus(); }
    else if(!e.shiftKey && document.activeElement === last){ e.preventDefault(); first.focus(); }
  }

  function openLightbox(groupId, i){
    buildLightbox();
    const group = groups.get(groupId); if(!group) return;
    idx = i; activeGroup = groupId; lastFocused = document.activeElement;
    updateImage();
    lightboxEl.classList.add('is-open');
    document.documentElement.classList.add('clx-lightbox-lock');
    document.body.classList.add('clx-lightbox-lock');
    setTimeout(()=>{ lightboxEl.querySelector('.clx-lightbox-close')?.focus(); },30);
  }
  function closeLightbox(){
    if(!lightboxEl) return;
    lightboxEl.classList.remove('is-open');
    document.documentElement.classList.remove('clx-lightbox-lock');
    document.body.classList.remove('clx-lightbox-lock');
    lastFocused && lastFocused.focus && lastFocused.focus();
  }
  function showRelative(delta){
    const group = groups.get(activeGroup); if(!group) return;
    idx = (idx + delta + group.items.length) % group.items.length;
    updateImage(true);
  }
  function updateImage(animate){
    const group = groups.get(activeGroup); if(!group) return;
    const item = group.items[idx]; if(!item) return;
    if(animate){ stageImg.classList.add('clx-fade-out'); setTimeout(()=> stageImg.classList.remove('clx-fade-out'), 240); }
    stageImg.src = item.src; stageImg.alt = item.alt || '';
    captionEl.textContent = item.alt || '';
  }

  function initGalleries(){
    document.querySelectorAll(GALLERY_GRID_SELECTOR).forEach((grid, gi)=>{
      const groupId = 'g'+gi; const anchors = grid.querySelectorAll('a.clandestino-popup-gallery');
      if(!anchors.length) return; const data = { id: groupId, items: []};
      anchors.forEach((a,i)=>{
        const img = a.querySelector('img');
        const alt = img ? img.getAttribute('alt') : '';
        data.items.push({ src: a.getAttribute('href'), alt });
        a.setAttribute('data-gallery-group', groupId);
        a.setAttribute('data-gallery-index', String(i));
        a.setAttribute('role','button');
        a.setAttribute('aria-label', alt ? `View image: ${alt}` : 'View image');
        a.addEventListener('click', e=>{ e.preventDefault(); openLightbox(groupId, i); });
      });
      groups.set(groupId, data);
    });
  }

  function initFilters(){
    document.querySelectorAll(FILTER_BAR_SELECTOR).forEach(bar => {
      bar.addEventListener('click', e => {
        const link = e.target.closest('a[data-filter]');
        if(!link) return;
        e.preventDefault();
        const filter = link.getAttribute('data-filter') || '*';
        bar.querySelectorAll('a[data-filter]').forEach(a=> a.classList.toggle('active', a===link));
        const grid = bar.parentElement.querySelector(GALLERY_GRID_SELECTOR);
        if(grid) applyFilter(grid, filter);
      });
    });
  }
  function applyFilter(grid, filter){
    const items = Array.from(grid.children).filter(el=> el.classList.contains('clandestino-gallery-item'));
    const showAll = filter === '*' || filter === '.all';
    const cls = filter.startsWith('.') ? filter.slice(1) : filter;
    items.forEach(item => {
      const match = showAll || item.classList.contains(cls);
      if(match){
        item.classList.remove('is-filter-hidden');
        item.style.display='block';
        requestAnimationFrame(()=>{ item.style.opacity='1'; item.style.transform='scale(1)'; });
      } else {
        item.classList.add('is-filter-hidden');
        item.style.opacity='0'; item.style.transform='scale(.94)'; item.style.pointerEvents='none';
        setTimeout(()=>{ if(item.classList.contains('is-filter-hidden')) item.style.display='none'; }, 320);
      }
    });
  }

  function initVideoOverlays(){
    // Handle video overlays - hide when playing, show when paused/ended
    document.querySelectorAll('.clandestino-gallery-video-wrapper').forEach(wrapper => {
      const video = wrapper.querySelector('video');
      const overlay = wrapper.querySelector('.clandestino-gallery-video-overlay');
      
      if(!video || !overlay) return;
      
      // Click on overlay/play button to start video
      overlay.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        video.play();
      });
      
      // Hide overlay when video starts playing
      video.addEventListener('play', () => {
        overlay.style.opacity = '0';
        overlay.style.pointerEvents = 'none';
      });
      
      // Show overlay when video is paused
      video.addEventListener('pause', () => {
        overlay.style.opacity = '1';
        overlay.style.pointerEvents = 'auto';
      });
      
      // Show overlay when video ends
      video.addEventListener('ended', () => {
        overlay.style.opacity = '1';
        overlay.style.pointerEvents = 'auto';
      });
      
      // Ensure overlay is visible initially
      overlay.style.opacity = '1';
      overlay.style.pointerEvents = 'auto';
    });
    
    // Handle testimonial videos in index.html (Swiper carousel)
    document.querySelectorAll('.testi-card .video-wrap video').forEach(video => {
      const videoWrap = video.closest('.video-wrap');
      if(!videoWrap) return;
      
      // Create overlay if it doesn't exist
      let overlay = videoWrap.querySelector('.video-overlay');
      if(!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'video-overlay';
        overlay.innerHTML = '<div class="video-play-btn"><ion-icon name="play" aria-hidden="true"></ion-icon></div>';
        videoWrap.appendChild(overlay);
      }
      
      // Click on overlay to play
      overlay.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        video.play();
      });
      
      // Hide overlay when playing
      video.addEventListener('play', () => {
        overlay.style.opacity = '0';
        overlay.style.pointerEvents = 'none';
      });
      
      // Show overlay when paused
      video.addEventListener('pause', () => {
        overlay.style.opacity = '1';
        overlay.style.pointerEvents = 'auto';
      });
      
      // Show overlay when ended
      video.addEventListener('ended', () => {
        overlay.style.opacity = '1';
        overlay.style.pointerEvents = 'auto';
      });
    });
  }

  document.addEventListener('DOMContentLoaded', ()=>{ 
    initGalleries(); 
    initFilters(); 
    initVideoOverlays();
  });
})();
