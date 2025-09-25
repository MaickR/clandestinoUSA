// assets/js/tapas.js
// Dynamic rendering of the Tapas & Take Away menu with filtering and gallery

(function ($) {
  $(function () {
    if (typeof Splitting === 'function') {
      Splitting();
    }

    // Tapas / Raciones
    const tapas = [
      { name: 'Sandwich', note: 'Choose 2: sausage / cheese', desc: 'Artisanal sandwich with premium Spanish ingredients.', price: 14.90, category: 'tapas' },
      { name: 'Mixed Tapas Board', note: '(2 people)', desc: 'Curated selection of cheeses & charcuterie.', price: 24.00, category: 'tapas' },
      { name: 'Mixed Tapas Board', note: '(4 people)', desc: 'Perfect sharing assortment for group dining.', price: 48.00, category: 'tapas' },
      { name: 'Mixed Tapas Board', note: '(6 people)', desc: 'Generous feast of authentic Spanish flavors.', price: 62.00, category: 'tapas' },
      { name: 'Chorizo Sticks', desc: 'Premium cured chorizo snack sticks.', price: 12.00, category: 'tapas' },
      { name: 'Olives', desc: 'Handpicked olives marinated in Mediterranean herbs.', price: 8.50, category: 'tapas' },
      { name: 'Olives – Mussels', desc: 'Olives paired with delicate Mediterranean mussels.', price: 14.00, category: 'tapas' },
      { name: 'Mussels', desc: 'Ocean-fresh mussels prepared Spanish style.', price: 10.00, category: 'tapas' },
    ];

    // Take Away (Para llevar)
    const takeAway = [
      { name: 'Serrano ham', note: 'Large bag', desc: 'Premium cured serrano ham. $24.00 per portion.', price: 24.00, category: 'take-away' },
      { name: 'Butifarra Catalana', note: 'Per piece', desc: 'Traditional Catalan sausage – $18.20 per piece.', price: 18.20, category: 'take-away' },
      { name: 'Chorizo Sarta', note: 'Per piece', desc: 'Classic cured chorizo ring – $14.60 per piece.', price: 14.60, category: 'take-away' },
      { name: 'Vic sausage', note: 'Per piece', desc: 'Renowned Vic-style salami – $18.20 per piece.', price: 18.20, category: 'take-away' },
      { name: 'Artisanal Chocolate', note: 'Per unit', desc: 'Handcrafted Gourmet Chocolate – Salt • Gold • Extra Dark', price: 5.50, category: 'take-away' },
    ];

    // Cheeses (own category)
    const quesos = [
      { name: 'Manchego Cheese', note: 'Wedge', desc: 'Classic Manchego wedge – $24.00 per wedge.', price: 24.00, category: 'quesos' },
      { name: 'Idiazábal Cheese', note: 'Wedge', desc: 'Smoky Basque sheep cheese wedge.', price: 28.00, category: 'quesos' },
      { name: 'Mahón Cheese', note: 'Wedge', desc: 'Creamy Menorcan cow’s milk cheese wedge.', price: 18.00, category: 'quesos' },
      { name: 'Rabell Cheese', note: 'Wedge', desc: 'Aged Spanish Rabell style cheese wedge.', price: 24.00, category: 'quesos' },
    ];

    const items = [...tapas, ...takeAway, ...quesos];

    // Placeholder image selection
    const fallback = './assets/images/tapas.jpeg';
    const pool = [
      './assets/images/bocatas/clandestino-sandwich-15.jpeg',
      './assets/images/gallery/tapas/the-clandestino-tapas-6.jpeg',
      './assets/images/gallery/tapas/the-clandestino-tapas-7.jpeg',
      './assets/images/bocatas/the-clandestino-tapas.jpg',
      './assets/images/gallery/tapas/the-clandestino-chorizo.jpeg',
      './assets/images/bocatas/',
      './assets/images/service-3.jpg',
      './assets/images/menu-1.png',
      './assets/images/bocatas/aceitunas.jpg',
      './assets/images/bocatas/olivas.jpg',
      './assets/images/menu-4.png',
    ];
    function getImg(it, i) {
  if (it.name === 'Olives') return './assets/images/bocatas/aceitunas.jpg';
  if (it.name === 'Olives – Mussels') return './assets/images/bocatas/olivas.jpg';
  if (it.name === 'Mussels') return './assets/images/gallery/tapas/the-clandestino-tapas-15.jpeg';
      if (it.name === 'Jamón Serrano') return './assets/images/gallery/tapas/jamon-cerrano.jpg';
  if (it.name === 'Butifarra Catalana') return './assets/images/gallery/tapas/the-clandestino-chorizo-5.jpeg';
  if (it.name === 'Chorizo Sarta') return './assets/images/gallery/tapas/the-clandestino-chorizo-2.jpeg';
  if (it.name === 'Salchichón de Vic') return './assets/images/gallery/tapas/the-clandestino-chorizo-4.jpeg';
  if (it.name === 'Artisanal Chocolate') return './assets/images/chocolate/Clandestino-Chocolate.jpeg';
  if (it.name === 'Manchego Cheese') return './assets/images/gallery/quesos/manchego.jpg';
  if (it.name === 'Idiazábal Cheese') return './assets/images/gallery/quesos/the-clandestino-quesos-1.jpeg';
  if (it.name === 'Mahón Cheese') return './assets/images/gallery/quesos/mahon.jpg';
  if (it.name === 'Rabell Cheese') return './assets/images/gallery/quesos/mancebo.jpg';
      if (/choco/i.test(it.name)) return './assets/images/chocolate/Clandestino-Chocolate.jpeg';
      return pool[i % pool.length] || fallback;
    }

    function pictureMarkup(originalPath, alt) {
      // Derive avif/webp candidate paths by inserting folders after /images/
      if (!originalPath) return '';
      const parts = originalPath.split('/assets/images/');
      if (parts.length !== 2) {
        return `<img src="${originalPath}" alt="${alt}" loading="lazy" decoding="async" />`;
      }
      const tail = parts[1];
      // Skip SVG or PNG (except we still attempt if png present for consistency?)
      if (/\.svg$/i.test(tail)) {
        return `<img src="${originalPath}" alt="${alt}" loading="lazy" decoding="async" />`;
      }
      const baseDir = './assets/images';
      const avif = `${baseDir}/avif/${tail.replace(/\.(jpe?g|png|webp)$/i, '.avif')}`;
      const webp = `${baseDir}/webp/${tail.replace(/\.(jpe?g|png|webp)$/i, '.webp')}`;
      return `<picture>
  <source srcset="${avif}" type="image/avif">
  <source srcset="${webp}" type="image/webp">
  <img src="${originalPath}" alt="${alt}" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='${fallback}';" />
</picture>`;
    }

    function formatPrice(it) {
      if (typeof it.price === 'number') return `$${it.price.toFixed(2)}`;
      if (it.priceRange) return `$${it.priceRange}`;
      return 'Ask for price';
    }

    const $container = $('.kf-menu-items');
    const $grid = $container.find('.row');

    // WhatsApp URL builder for tapas
    function buildTapasWhatsAppURL(item) {
      const baseURL = 'https://wa.me/14086090027';
      const message = `Hello The Clandestino Team,

I'm visiting from theclandestinousa.com and would like to order ${item.name}${item.note ? ' (' + item.note + ')' : ''}.

Could you please confirm availability and provide ordering details?

Thank you!`;
      return `${baseURL}?text=${encodeURIComponent(message)}`;
    }

    const itemsHtml = items
      .map((it, i) => {
  const img = getImg(it, i);
        const alt = `${it.name}${it.note ? ' — ' + it.note : ''}`;
        const price = formatPrice(it);
        const klass = it.category; // tapas | take-away | quesos
        const whatsappURL = buildTapasWhatsAppURL(it);
        
        return `
        <div class="kf-menu-item-col all ${klass}">
          <div class="kf-menu-item">
            <div class="image kf-image-hover">
              <a href="${img}" class="has-popup-image">
                ${pictureMarkup(img, alt)}
              </a>
            </div>
            <div class="desc">
              <h5 class="name">${it.name}</h5>
              <div class="subname">${it.desc ? it.desc : (it.note ? it.note : '')}&nbsp;</div>
              <div class="subname">${it.desc && it.note ? it.note : ''}&nbsp;</div>
              <div class="price-section">
                <div class="wine-price">${price}</div>
                <a href="${whatsappURL}" class="cart-btn" target="_blank" rel="noopener noreferrer" aria-label="Order ${it.name} via WhatsApp">
                  <ion-icon name="restaurant-outline" aria-hidden="true"></ion-icon>
                </a>
              </div>
            </div>
          </div>
        </div>`;
      })
      .join('');

    // Render
    $container.attr('aria-busy', 'true');
    $grid.html(itemsHtml);
    $container.attr('aria-busy', 'false');

    // Initialize popup and isotope after content is loaded
    function initTapasPopup() {
      if ($.fn.magnificPopup) {
        $('.has-popup-image').magnificPopup({ 
          type: 'image', 
          gallery: { enabled: true }, 
          image: { verticalFit: true } 
        });
      }
    }

    // Isotope initialization with proper re-layout
    if ($.fn.imagesLoaded && $.fn.isotope) {
      $grid.imagesLoaded(function () {
        $grid.isotope({ 
          itemSelector: '.kf-menu-item-col', 
          layoutMode: 'fitRows',
          transitionDuration: '0.6s'
        });
        initTapasPopup();
      });
    } else {
      initTapasPopup();
    }

    // Filters with proper Isotope re-layout
    $('.kf-filter').on('click', 'a', function (e) {
      e.preventDefault();
      var $a = $(this);
      $('.kf-filter a').removeClass('active');
      $a.addClass('active');
      $('.kf-filter a[role="tab"]').attr('aria-selected', 'false');
      $a.attr('aria-selected', 'true');
      var selector = $a.data('href') || '.all';
      
      if ($.fn.isotope) {
        $grid.isotope({ filter: selector === '.all' ? '*' : selector });
        // Re-initialize popup after filtering to ensure proper binding
        setTimeout(function() {
          initTapasPopup();
        }, 650); // Wait for transition to complete
      }
    });

  });
})(jQuery);
