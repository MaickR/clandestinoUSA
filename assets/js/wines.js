// assets/js/wines.js
// Dynamic rendering of the Wines menu with filtering and gallery

(function ($) {
  $(function () {
    if (typeof Splitting === 'function') {
      Splitting();
    }

  // Provided wines data
    const wines = [
      {
        name: "Fagus",
        reference: "16VIFA",
        region: "Aragón, Campo de Borja",
        brand: "Fagus",
        winerys: "Bodegas Aragonesas",
        alcohol: "14,5%",
        Grape: "Grenache",
        desc: "Bold and elegant Grenache showcasing Aragón's terroir.",
        priceGlass: "$13",
        priceBottle: "$40",
  image: "",
      },
      {
        name: "Viña Temprana",
        reference: "18VITE",
        region: "Aragón, Campo de Borja",
        brand: "Viña Temprana",
        winerys: "Bodegas Aragonesas",
        alcohol: "14%",
        Grape: "Grenache",
        desc: "Fresh and vibrant Grenache with exceptional character.",
        priceGlass: "$7",
        priceBottle: "$21",
  image: "",
      },
      {
        name: "Neton",
        reference: "15VINE",
        region: "Castilla la Mancha, Albacete",
        brand: "Neton",
        winerys: "Bodegas Terramagna",
        alcohol: "14,5%",
        Grape: "Grenache Tintorera",
        priceGlass: "$10",
        priceBottle: "$30",
  image: "",
      },
      {
        name: "Crianza Hermanos",
        reference: " 10VIFR",
        region: "Rioja Alavesa",
        brand: "Crianza Hermanos del Val",
        winerys: "Bodegas Hermanos Frías del Val",
        alcohol: "15%",
        Grape: "Tempranillo",
  desc: "Structured Tempranillo with refined Rioja character.",
        priceGlass: "$10",
        priceBottle: "$30",
        image: "",
      },
      {
        name: "Cigales",
        reference: " 9VIPRSI",
        region: "Cigales",
        brand: "Aire de Protos ",
        winerys: "Bodegas Protos",
        alcohol: "13%",
        Grape: "Tempranillo,Garnacha, Albillo",
  desc: "Fresh red blend showing vibrant Cigales elegance.",
  priceGlass: "$9",
  priceBottle: "$25",
  image: "",
      },
      {
        name: "Sangria",
        reference: " 23SANGRIA",
        region: "Andalucía",
        brand: "Care ",
        winerys: "Bodegas Añadas",
        alcohol: "13%",
        Grape: "Tempranillo, Garnacha",
  desc: "Refreshing Spanish classic with bright fruit notes.",
  priceGlass: "$9",
  priceBottle: "$29",
  image: "",
      },
      {
        name: "Mimosa",
        reference: " 26MIMOSA",
        region: "Cataluña",
        brand: "Canals & Munné",
        winerys: "Bodegas Canals&Munne",
        alcohol: "13%",
        Grape: "Macabeo, Xarel·lo, Parellada",
  desc: "Lively sparkling blend—crisp citrus and finesse.",
        priceGlass: "$10",
        priceBottle: "$35",
  image: "",
      },
      {
        name: "Garnacha Nativa",
        reference: "19VINATI",
        region: "Aragón, Cariñena ",
        brand: "Garnacha Nativa",
        winerys: " Bodegas Añadas Care",
        alcohol: "14%",
        Grape: "Grenache 100 red",
  desc: "Pure Garnacha expression: silky, ripe and vibrant.",
  priceGlass: "$10",
  priceBottle: "$29",
  image: "",
      },
      {
        name: "Garnacha Blanca",
        reference: "20VINABC",
        region: "Aragón, Cariñena ",
        brand: "Garnacha Nativa",
        winerys: " Bodegas Añadas Care",
        alcohol: "14%",
        Grape: "Grenache 100 white",
  desc: "Elegant white Garnacha with floral mineral finish.",
  priceGlass: "$10",
  priceBottle: "$29",
  image: "",
      },
      {
        name: "Tinto sobre Lías",
        reference: "21VILITI",
        region: "Aragón, Cariñena ",
        brand: "Tinto sobre Lías",
        winerys: " Bodegas Añadas Care",
        alcohol: "14,5%",
        Grape: "Grenache, Syrah",
  desc: "Lees-aged depth with dark fruit and subtle spice.",
        priceGlass: "$8",
  priceBottle: "$23",
  image: "",
      },
      {
        name: "Blanco sobre Lías",
        reference: "22VILIBC",
        region: "Aragón, Cariñena ",
        brand: " Blanco sobre Lías",
        winerys: " Bodegas Añadas Care",
        alcohol: "13,5%",
        Grape: "Grenache, Chardonnay",
  desc: "Creamy textured white—citrus, stone fruit, finesse.",
        priceGlass: "$8",
  priceBottle: "$23",
  image: "",
      },
      {
        name: "El Alba",
        reference: "3VIAL",
        region: "Navarra  ",
        brand: " EL ALBA",
        winerys: "Finca Albret",
        alcohol: "14%",
        Grape: "Grenache",
  desc: "Sunlit Garnacha: bright berries and gentle spice.",
        priceGlass: "$9",
        priceBottle: "$28",
  image: "",
      },
      {
        name: "Oceanico",
        reference: "5VIOC",
        region: "Rías Baixas ",
        brand: " Oceanico",
        winerys: "Maior de Mendoza",
        alcohol: "12%",
        Grape: "Albariño",
  desc: "Atlantic Albariño—saline, citrus, refined freshness.",
  priceGlass: "$11",
  priceBottle: "$36",
  image: "",
      },
      {
        name: "Wine Roots",
        reference: "11VIRO",
        region: "Rioja ",
        brand: " Wine Roots",
        winerys: "Bodegas Corral",
        alcohol: "13%",
        Grape: "White Grenache",
  desc: "Textured white Rioja with subtle oak and balance.",
        priceGlass: "$12",
        priceBottle: "$38",
  image: "",
      },
      {
        name: "Garbinada",
        reference: "4VISA",
        region: "Priorat",
        brand: "Garbinada",
        winerys: "Bodegas Sangenis I Vaque",
        alcohol: "14,5%",
        Grape: "Grenache, Carinyena",
  desc: "Mineral Priorat core—dense fruit, lifted finish.",
  priceGlass: "$12",
  priceBottle: "$36",
  image: "",
      },
      {
        name: "Linaje Garsea",
        reference: "7VIGA",
        region: "Ribera Duero",
        brand: "Linaje Garsea",
        winerys: "Bodegas y Viñedos Linaje",
        alcohol: "14,5%",
        Grape: "Tempranillo",
  desc: "Bold Ribera Tempranillo—ripe plum and structure.",
  priceGlass: "$15",
  priceBottle: "$50",
  image: "",
      },
      {
        name: "Frisante",
        reference: "13VIVA",
        region: "Castillo y Leon",
        brand: "Frisante",
        winerys: "Finca Valdemoya",
        alcohol: "8%",
        Grape: "Verdejo",
  desc: "Playful semi-sparkling Verdejo—fresh and lively.",
        priceGlass: "$6",
        priceBottle: "$19",
  image: "",
      },
      {
        name: "Comenge Biberius",
        reference: "6VICO",
        region: "Ribera Duero",
        brand: "Comenge Biberius",
        winerys: "Comenge Bodegas y Viñedos",
        alcohol: "14,5%",
        Grape: "Tempranillo",
  desc: "Juicy modern style Ribera with polished tannins.",
        priceGlass: "$10",
        priceBottle: "$30",
  image: "",
      },
      // New wines added
      {
        name: "Viña Marichalar Reserva",
        reference: "32VIMAR",
        region: "La Rioja",
        brand: "Viña Marichalar",
        winerys: "Estate Selection",
        alcohol: "13,5%",
        Grape: "Tempranillo, Graciano, Garnacha",
        desc: "Rich red and black cherries with licorice, spice and dark chocolate nuance.",
        priceGlass: "$12",
        priceBottle: "$38",
        image: "",
      },
      {
        name: "Pradorey Blanco",
        reference: "31PRBL",
        region: "Castilla y León",
        brand: "Pradorey Blanco",
        winerys: "Bodegas Pradorey",
        alcohol: "14%",
        Grape: "Verdejo",
        desc: "Elegant and fresh Verdejo—vibrant citrus, white flowers and mineral finish.",
        priceGlass: "$14",
        priceBottle: "$45",
        image: "",
      },
      {
        name: "Adaro",
        reference: "30ADARO",
        region: "Ribera del Duero",
        brand: "Adaro",
        winerys: "Bodegas Pradorey",
        alcohol: "13%",
        Grape: "Tempranillo",
        desc: "Elegant, tasty and fresh—silky tannins, red plum and subtle oak.",
        priceGlass: "$15",
        priceBottle: "$50",
        image: "",
      },
      {
        name: "Mystic",
        reference: "33MYSTIC",
        region: "Aragón, Cariñena",
        brand: "Mystic",
        winerys: "NTC",
        alcohol: "14,5%",
        Grape: "Grenache, Syrah",
        desc: "Lees-aged depth with dark fruit and subtle spice complexity.",
        priceGlass: "$9",
        priceBottle: "$29",
        image: "",
      },
      {
        name: "Evoluzion",
        reference: "34EVOL",
        region: "Aragón, Cariñena",
        brand: "Evoluzion",
        winerys: "NTC",
        alcohol: "12,5%",
        Grape: "Grenache, Chardonnay",
        desc: "Creamy textured white—citrus zest, stone fruit and refined finesse.",
        priceGlass: "$9",
        priceBottle: "$29",
        image: "",
      },
      {
        name: "Dionysus",
        reference: "1CACAN",
        region: " Cataluña",
        brand: "Dionysus",
        winerys: "Canals&Munne",
        alcohol: "12%",
        Grape: "Xarello, Chardonnay, Macabeo",
  desc: "Elegant sparkling blend—creamy mousse, citrus zest.",
        priceGlass: "$9",
        priceBottle: "$28",
  image: "",
      },
      {
        name: "Hecula",
        reference: "29 VIHE",
        region: " Murcia, Yecla",
        brand: "Hecula",
        winerys: "Bodegas Castaño",
        alcohol: "14%",
        Grape: "Monastrell",
  desc: "Mediterranean Monastrell: dark fruit and spice.",
        priceGlass: "$11",
        priceBottle: "$32",
        image: "",
      },
    ];

    // Use JPG/PNG assets only (no WebP). Map by sanitized reference code.
    const IMAGE_DIR = './assets/images/wines/';
    const imageMap = {
      '16VIFA': 'fagus.png',
      '18VITE': 'Vina-Temprana.jpg',
      '15VINE': 'neton.jpg',
      '8VIPRVE': 'protos.jpg',
      '10VIFR': 'crianza-hermanos.jpg',
      '9VIPRSI': 'cigales.jpg',
      '23SANGRIA': 'sangria.jpg',
      '26MIMOSA': 'mimosa.jpg',
      '19VINATI': 'garnacha.jpg',
      '20VINABC': 'garnacha-white.jpg',
      '21VILITI': 'tinto.jpg',
      '22VILIBC': 'blanco.jpg',
      '3VIAL': 'alba.jpg',
      '5VIOC': 'oceanico.jpg',
      '11VIRO': 'roots.jpg',
      '4VISA': 'garbinada.jpg',
      '7VIGA': 'linaje.jpg',
      '13VIVA': 'frisante.jpg',
      '6VICO': 'comenge.jpg',
      '2CEC': 'garcea.jpg',
      '1CACAN': 'dyonisus.jpg',
      '29VIHE': 'hecula.jpg',
  '32VIMAR': 'VIÑA MARICHALAR.jpg',
  '31PRBL': 'PRADOREY BLANCO.jpeg',
  '30ADARO': 'ADARO.jpeg',
  '33MYSTIC': 'MYSTIC.jpeg',
  '34EVOL': 'EVOLUZION.jpeg',
    };

    function getImageForWine(w) {
      const ref = String(w.reference || '').replace(/\s+/g, '').toUpperCase();
      const file = imageMap[ref];
      return file ? IMAGE_DIR + file : null;
    }

    function pictureMarkup(originalPath, alt) {
      if (!originalPath) return '';
      const parts = originalPath.split('/assets/images/');
      if (parts.length !== 2) return `<img src="${originalPath}" alt="${alt}" loading="lazy" decoding="async" />`;
      const tail = parts[1];
      if (/\.svg$/i.test(tail)) return `<img src="${originalPath}" alt="${alt}" loading="lazy" decoding="async" />`;
      const baseDir = './assets/images';
      const avif = `${baseDir}/avif/${tail.replace(/\.(jpe?g|png|webp)$/i, '.avif')}`;
      const webp = `${baseDir}/webp/${tail.replace(/\.(jpe?g|png|webp)$/i, '.webp')}`;
      return `<picture>
  <source srcset="${avif}" type="image/avif">
  <source srcset="${webp}" type="image/webp">
  <img src="${originalPath}" alt="${alt}" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='${fallbackImg}';" />
</picture>`;
    }

    // Categorization rules
    function getCategory(w) {
      const name = (w.name || '').toLowerCase();
      const grape = (w.Grape || '').toLowerCase();
      if (/(frisante|mimosa|cava|sparkling|bubbles|dionysus)/.test(name)) return 'sparkling';
      if (/(xarel|macabeo|parellada|cava|sparkling|bubbles)/.test(grape)) return 'sparkling';
      if (/(blanco|blanca|white|verdejo|albariñ|chardonnay)/.test(name) || /(blanco|blanca|white|verdejo|albariñ|albillo|chardonnay|white grenache)/.test(grape)) return 'white';
      return 'red';
    }

  const $container = $('.kf-menu-items');
  const $grid = $container.find('.row');
    const fallbackImg = './assets/images/wines.jpeg';
    const order = { red: 1, white: 2, sparkling: 3 };

  // WhatsApp URL builder for wines
  function buildWineWhatsAppURL(wine) {
    const baseURL = 'https://wa.me/14086090027';
    // Elegant, concise purchase-focused message (English)
    const lines = [
      `Hello Clandestino Team,`,
      `I'd like to purchase: ${wine.name}${wine.brand ? ' – ' + wine.brand : ''}.`,
      wine.region ? `Region: ${wine.region}.` : '',
      wine.Grape ? `Grape: ${wine.Grape}.` : '',
      wine.alcohol ? `Alcohol: ${wine.alcohol}.` : '',
      'Please confirm availability and next steps.',
      'Thank you.'
    ].filter(Boolean);
    const message = lines.join('\n');
    return `${baseURL}?text=${encodeURIComponent(message)}`;
  }

  const itemsHtml = wines
      .map((w) => ({ ...w, _cat: getCategory(w) }))
      .sort((a, b) => order[a._cat] - order[b._cat] || a.name.localeCompare(b.name))
      .map((w) => {
    const imgUrl = getImageForWine(w) || fallbackImg; // prefer JPG/PNG, fallback to placeholder
        const alt = `${w.brand ? w.brand + ' ' : ''}${w.name} — ${w.region}`.trim();
        const priceParts = [];
        const isMobile = window.innerWidth <= 768;
        if (w.priceGlass) priceParts.push(`${w.priceGlass} ${isMobile ? 'G' : 'glass'}`);
        if (w.priceBottle) priceParts.push(`${w.priceBottle} ${isMobile ? 'B' : 'bottle'}`);
        const price = priceParts.join(isMobile ? ' / ' : ' • ');
        const grapeAlc = [w.Grape, w.alcohol].filter(Boolean).join(' • ');
        const brandRegion = [w.brand && w.brand.trim(), w.region && w.region.trim()].filter(Boolean).join(' • ');
        const whatsappURL = buildWineWhatsAppURL(w);

        return `
      <div class="kf-menu-item-col all ${w._cat}">
        <div class="kf-menu-item">
          <div class="image kf-image-hover">
            <a href="${imgUrl}" class="has-popup-image">
              ${pictureMarkup(imgUrl, alt)}
            </a>
          </div>
          <div class="desc">
            <h5 class="name">${w.name}</h5>
            <div class="subname">${w.desc ? w.desc : brandRegion}</div>
            <div class="subname">${w.desc ? brandRegion : grapeAlc}</div>
            <div class="subname">${w.desc ? grapeAlc : ''}</div>
            <div class="price-section">
              <div class="wine-price">${price}</div>
              <a href="${whatsappURL}" class="cart-btn" target="_blank" rel="noopener noreferrer" aria-label="Purchase inquiry for ${w.name} via WhatsApp" title="Order this wine">
                <ion-icon name="cart-outline" aria-hidden="true"></ion-icon>
                <span class="visually-hidden">Order ${w.name}</span>
              </a>
            </div>
          </div>
        </div>
      </div>`;
      })
      .join('');

  // Announce busy while updating the DOM
  $container.attr('aria-busy', 'true');
  $grid.html(itemsHtml);
  $container.attr('aria-busy', 'false');

  // Function to regenerate items on resize
  function regenerateItems() {
    const newItemsHtml = wines
      .map((w) => ({ ...w, _cat: getCategory(w) }))
      .sort((a, b) => order[a._cat] - order[b._cat] || a.name.localeCompare(b.name))
      .map((w) => {
  const imgUrl = getImageForWine(w) || fallbackImg;
        const alt = `${w.brand ? w.brand + ' ' : ''}${w.name} — ${w.region}`.trim();
        const priceParts = [];
        const isMobile = window.innerWidth <= 768;
        if (w.priceGlass) priceParts.push(`${w.priceGlass} ${isMobile ? 'G' : 'glass'}`);
        if (w.priceBottle) priceParts.push(`${w.priceBottle} ${isMobile ? 'B' : 'bottle'}`);
        const price = priceParts.join(isMobile ? '\n' : ' • ');
        const grapeAlc = [w.Grape, w.alcohol].filter(Boolean).join(' • ');
        const brandRegion = [w.brand && w.brand.trim(), w.region && w.region.trim()].filter(Boolean).join(' • ');
        const whatsappURL = buildWineWhatsAppURL(w);

        return `
      <div class="kf-menu-item-col all ${w._cat}">
        <div class="kf-menu-item">
          <div class="image kf-image-hover">
            <a href="${imgUrl}" class="has-popup-image">
              ${pictureMarkup(imgUrl, alt)}
            </a>
          </div>
          <div class="desc">
            <h5 class="name">${w.name}</h5>
            <div class="subname">${w.desc ? w.desc : brandRegion}</div>
            <div class="subname">${w.desc ? brandRegion : grapeAlc}</div>
            <div class="subname">${w.desc ? grapeAlc : ''}</div>
            <div class="price-section">
              <div class="wine-price">${price}</div>
              <a href="${whatsappURL}" class="cart-btn" target="_blank" rel="noopener noreferrer" aria-label="Purchase inquiry for ${w.name} via WhatsApp" title="Order this wine">
                <ion-icon name="cart-outline" aria-hidden="true"></ion-icon>
                <span class="visually-hidden">Order ${w.name}</span>
              </a>
            </div>
          </div>
        </div>
      </div>`;
      })
      .join('');
    $container.attr('aria-busy', 'true');
    $grid.html(newItemsHtml);
    $container.attr('aria-busy', 'false');
    initWinePopup();
    // Re-run isotope layout & normalize heights
    if ($.fn.isotope) {
      $grid.isotope('reloadItems').isotope();
    }
    runAfterImages(normalizeCardHeights);
  }

  // Resize listener to update prices on screen size change
  let resizeTimeout;
  $(window).on('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function(){
      regenerateItems();
      // Heights will be normalized inside regenerateItems after images load
    }, 250);
  });

  // Normalize card heights to keep consistent grid and left alignment
  function normalizeCardHeights() {
    var isMultiColumn = window.innerWidth >= 992; // only when 2-column layout active
    var $items = $grid.find('.kf-menu-item');
    $items.css('height',''); // reset
    if (!isMultiColumn) return; // single column mobile: natural height
    var max = 0;
    $items.each(function(){
      var h = this.getBoundingClientRect().height;
      if (h > max) max = h;
    });
    if (max > 0) { $items.css('height', max + 'px'); }
  }

  // Helper to run a callback after images are fully loaded
  function runAfterImages(cb){
    if ($.fn.imagesLoaded) {
      $grid.imagesLoaded(function(){
        cb && cb();
      });
    } else { cb && cb(); }
  }

  function initWinePopup() {
    if (!$.fn.magnificPopup) return;
    try { $.magnificPopup.instance && $.magnificPopup.close(); } catch(e) {}
    $('.has-popup-image').off('click.mfp').magnificPopup({
      type: 'image',
      gallery: { enabled: true },
      image: { verticalFit: true },
      mainClass: 'mfp-fade',
      removalDelay: 160
    });
  }

  if ($.fn.imagesLoaded && $.fn.isotope) {
    $grid.imagesLoaded(function () {
      $grid.isotope({ itemSelector: '.kf-menu-item-col', layoutMode: 'fitRows', fitRows: { gutter: 0 } });
      initWinePopup();
      normalizeCardHeights();
    });
  } else { initWinePopup(); }

  // Re-normalize after isotope arrangement (filtering / relayout)
  if ($.fn.isotope) {
    $grid.on('arrangeComplete', function(){
      normalizeCardHeights();
    });
  }

    // Filter buttons
    $('.kf-filter').on('click', 'a', function (e) {
      e.preventDefault();
      var $a = $(this);
      $('.kf-filter a').removeClass('active');
      $a.addClass('active');
      // Update ARIA selected for tabs
      $('.kf-filter a[role="tab"]').attr('aria-selected', 'false');
      $a.attr('aria-selected', 'true');
      var selector = $a.data('href') || '.all';
      if ($.fn.isotope) {
  $grid.isotope({ filter: selector === '.all' ? '*' : selector });
  // Re-init popup after transition to ensure bindings remain
  setTimeout(initWinePopup, 600);
  runAfterImages(normalizeCardHeights);
      }
    });

    // Simple parallax (optional)
    $(window)
      .on('scroll', function () {
        var sc = $(window).scrollTop();
        $('.js-parallax').each(function () {
          var speed = 0.25;
          $(this).css('background-position', 'center ' + -sc * speed + 'px');
        });
      })
      .trigger('scroll');
  });
})(jQuery);
