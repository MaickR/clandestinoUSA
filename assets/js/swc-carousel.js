// assets/js/swc-carousel.js
// Accessible Swiper initialization for the Spanish Wine Club carousel
(function () {
  function initCarousel() {
    if (typeof Swiper === 'undefined') {
      return;
    }

    var wrapper = document.querySelector('.clandestino-swc-carousel');
    if (!wrapper) {
      return;
    }

    var container = wrapper.querySelector('.swiper-container');
    if (!container) {
      return;
    }

    var slides = Array.prototype.slice.call(container.querySelectorAll('.swiper-slide'));
    if (!slides.length) {
      return;
    }

    // Ensure slide labels reflect actual count
    slides.forEach(function (slide, index) {
      slide.setAttribute('aria-label', 'Slide ' + (index + 1) + ' of ' + slides.length);
      slide.setAttribute('aria-hidden', index === 0 ? 'false' : 'true');
      if (index !== 0) {
        slide.setAttribute('tabindex', '-1');
      }
    });

    // Optional live region to announce slide changes for screen readers
    var announcer = document.createElement('span');
    announcer.className = 'sr-only swiper-announcer';
    announcer.setAttribute('aria-live', 'polite');
    announcer.setAttribute('aria-atomic', 'true');
    announcer.textContent = slides[0].getAttribute('aria-label');
    wrapper.appendChild(announcer);

    var swiper = new Swiper(container, {
      speed: 700,
      spaceBetween: 28,
      slidesPerView: 1,
      slidesPerGroup: 1,
      autoHeight: true,
      loop: true,
      centeredSlides: true,
      grabCursor: true,
      watchSlidesProgress: true,
      observer: true,
      observeParents: true,
      autoplay: {
        delay: 6200,
        disableOnInteraction: false
      },
      navigation: {
        nextEl: '.clandestino-swc-carousel .swiper-button-next',
        prevEl: '.clandestino-swc-carousel .swiper-button-prev'
      },
      pagination: {
        el: '.clandestino-swc-carousel .swiper-pagination',
        clickable: true
      },
      keyboard: {
        enabled: true,
        onlyInViewport: true
      },
      a11y: {
        enabled: true,
        prevSlideMessage: 'Previous highlight',
        nextSlideMessage: 'Next highlight',
        firstSlideMessage: 'This is the first highlight',
        lastSlideMessage: 'This is the last highlight',
        paginationBulletMessage: 'Go to highlight {{index}}'
      },
      on: {
        init: function () {
          updateAccessibility(this);
        },
        slideChange: function () {
          updateAccessibility(this);
        },
        resize: function () {
          try {
            this.updateAutoHeight();
          } catch (err) {
            /* noop */
          }
        }
      }
    });

    function updateAccessibility(swiperInstance) {
      var activeIndex = swiperInstance.realIndex;
      slides.forEach(function (slide, idx) {
        var isActive = idx === activeIndex;
        slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
        if (isActive) {
          slide.removeAttribute('tabindex');
        } else {
          slide.setAttribute('tabindex', '-1');
        }
      });

      announcer.textContent = slides[activeIndex].getAttribute('aria-label');
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCarousel);
  } else {
    initCarousel();
  }
})();
