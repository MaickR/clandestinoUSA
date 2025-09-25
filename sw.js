// SWC carousel initialization (requires jQuery and Swiper 6.8.4 which are loaded on the page)
(function(){
	if (typeof jQuery === 'undefined' || typeof Swiper === 'undefined') return;
	jQuery(function($){
		var $container = $('.kf-history-carousel .swiper-container');
		if (!$container.length) return;
		/* Config preserved per user's original with site-friendly tweaks */
				new Swiper('.kf-history-carousel .swiper-container', {
					speed: 700,
					spaceBetween: 28,
					slidesPerView: 1,
				slidesPerGroup: 1,
					autoHeight: true,
					loop: true,
				loopAdditionalSlides: 0,
				loopedSlides: 4,
					centeredSlides: true,
					grabCursor: true,
					watchSlidesProgress: true,
				observer: true,
				observeParents: true,
			autoplay: {
						delay: 6200,
				disableOnInteraction: false,
			},
			navigation: {
				nextEl: '.kf-history-carousel .swiper-button-next',
				prevEl: '.kf-history-carousel .swiper-button-prev',
			},
			effect: 'slide',
			resistanceRatio: 0.8,
			touchReleaseOnEdges: true,
			on: {
						resize: function(){
							try { this.update(); } catch(e) {}
						}
			}
		});
	});
})();
