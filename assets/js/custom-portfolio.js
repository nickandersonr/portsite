(function($){

	$(document).ready(function() {

		/* ---------------------------------------------- /*
		 * Owl slider
		/* ---------------------------------------------- */

		$('.portfolio-slider').owlCarousel({
			navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
			navigation: true,
			pagination: false,
			slideSpeed : 300,
			paginationSpeed : 400,
			singleItem: true
		});

		$('body').fitVids();

	});

})(jQuery);