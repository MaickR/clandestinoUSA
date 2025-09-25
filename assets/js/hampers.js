// assets/js/hampe      { key: 'basket-03', title: 'Artisan\'s Choice', desc: 'Handcrafted goods delivering an authentic experience.', price: 193.15 },s.js
// Dynamic rendering of Gift Hampers (baskets) grid, matching site styles

(function ($) {
  $(function () {
    if (typeof Splitting === 'function') {
      Splitting();
    }

    // Base data adapted from index.html slides
    const hampers = [
      { key: 'basket-02', title: 'Premium Selection', desc: 'Exquisite wines paired with finest gourmet specialties.', price: 330.50, category: 'luxury' },
      { key: 'basket-06', title: 'Luxury Indulgence', desc: 'Sophisticated delights for the most special occasions.', price: 321, category: 'luxury' },
      { key: 'basket-12', title: 'Gourmet Experience', desc: 'Carefully curated products for the discerning palate.', price: 225.20, category: 'gourmet' },
      { key: 'basket-05', title: 'Elegant Delight', desc: 'Perfect harmony of taste and quality in every bite.', price: 210.50, category: 'gourmet' },
      { key: 'basket-07', title: 'Epicurean Basket', desc: 'A wonderful gift for true culinary enthusiasts here.', price: 209.75, category: 'gourmet' },
      { key: 'basket-08', title: 'Savory Collection', desc: 'Delicious assortment of carefully selected treasures.', price: 208.25, category: 'gourmet' },
      { key: 'basket-11', title: 'Signature Hamper', desc: 'Our quality seal represented in a single package here.', price: 198.75, category: 'classic' },
      { key: 'basket-03', title: 'Artisan’s Choice', desc: 'Handcrafted goods for a genuine experience.', price: 193.15, category: 'classic' },
      { key: 'basket-09', title: 'Exclusive Treat', desc: 'Premium selection from our exclusive gourmet line here.', price: 149, category: 'classic' },
      { key: 'basket-01', title: 'Classic Basket', desc: 'Traditional selection perfect for timeless gifting.', price: 127.60, category: 'classic' },
      { key: 'basket-10', title: 'Deluxe Offering', desc: 'Premium combination balancing quality with great value.', price: 125.90, category: 'classic' },
      { key: 'basket-07', title: 'Refined Selection', desc: 'Finely chosen products for detail-oriented lovers.', price: 123.40, category: 'classic' },
      { key: 'basket-13', title: 'Custom Hamper', desc: 'Create your unique personalized gift basket experience.', price: null, category: 'custom' },
    ];

    // Image sources (only .webp are available in the provided folder)
    const IMG_DIR = './assets/images/hampers/';
    function imgFor(key) { return IMG_DIR + key + '.webp'; }

    // Hampers: only existing .webp assets (no avif/webp switching required here)
    function pictureMarkup(path, alt) {
      return `<img src="${path}" alt="${alt}" loading="lazy" decoding="async" />`;
    }

    // WhatsApp URL builder
    function buildWhatsAppURL(hamper) {
      const baseURL = 'https://wa.me/14086090027';
      const message = hamper.price == null 
        ? `Hello! I'm interested in the ${hamper.title} (Custom Hamper) from The Clandestino USA website. Could you please provide more details and pricing?`
        : `Hello! I would like to purchase the ${hamper.title} for $${hamper.price.toFixed(2)} from The Clandestino USA website. Please let me know how to proceed.`;
      return `${baseURL}?text=${encodeURIComponent(message)}`;
    }

    // Render grid
    const $container = $('.kf-menu-items');
    const $grid = $container.find('.row');
    $container.attr('aria-busy', 'true');

    const itemsHtml = hampers.map(h => {
      const priceText = h.price == null
        ? 'Ask for price'
        : `$${h.price.toLocaleString(undefined, { minimumFractionDigits: (h.price % 1 ? 2 : 0), maximumFractionDigits: 2 })}`;
      const alt = `${h.title} Gift Hamper`;
      const img = imgFor(h.key);
      const whatsappURL = buildWhatsAppURL(h);
      const klass = h.category || 'classic';

      return `
      <div class="kf-menu-item-col all hamper ${klass}">
        <div class="kf-menu-item">
          <div class="image kf-image-hover">
            <a href="${img}" class="has-popup-image">
              ${pictureMarkup(img, alt)}
            </a>
          </div>
          <div class="desc">
            <h5 class="name">${h.title}</h5>
            <div class="subname">${h.desc}</div>
            <div class="price-section">
              <div class="wine-price">${priceText}</div>
              <a href="${whatsappURL}" class="cart-btn" target="_blank" rel="noopener noreferrer" aria-label="Inquire about ${h.title} via WhatsApp">
                <ion-icon name="cart-outline" aria-hidden="true"></ion-icon>
              </a>
            </div>
          </div>
        </div>
      </div>`;
    }).join('');

    $grid.html(itemsHtml);
    $container.attr('aria-busy', 'false');

    // Layout with Isotope and Gallery
    function initPopup() {
      if (!$.fn.magnificPopup) return;
      // Destroy previous instances if any
      try { $.magnificPopup.instance && $.magnificPopup.close(); } catch(e) {}
      $('.has-popup-image').off('click.mfp');
      $('.has-popup-image').magnificPopup({
        type: 'image',
        gallery: { enabled: true, tPrev: 'Prev', tNext: 'Next' },
        image: { verticalFit: true },
        removalDelay: 160,
        mainClass: 'mfp-fade',
        closeBtnInside: true
      });
    }

    if ($.fn.imagesLoaded && $.fn.isotope) {
      $grid.imagesLoaded(function () {
        $grid.isotope({
          itemSelector: '.kf-menu-item-col',
          layoutMode: 'fitRows',
          fitRows: { gutter: 0 }
        });
        initPopup();
      });
    } else {
      initPopup();
    }

    // Filter interaction (now enabled)
    $('.kf-filter').on('click', 'a', function(e){
      e.preventDefault();
      var $a = $(this);
      $('.kf-filter a').removeClass('active').attr('aria-selected','false');
      $a.addClass('active').attr('aria-selected','true');
      var selector = $a.data('href') || '.all';
      if ($.fn.isotope) {
        $grid.isotope({ filter: selector === '.all' ? '*' : selector });
        setTimeout(initPopup, 600);
      }
    });
  });
})(jQuery);
