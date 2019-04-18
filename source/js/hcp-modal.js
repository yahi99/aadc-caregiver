jQuery(document).ready(function($) {
	
	$('#hcp-interstitial').addClass('opened');

	$('.close-modal').click(function (e) {
         e.preventDefault();
         $('#hcp-interstitial').removeClass('opened');
    });

}); /* end of as page load scripts */