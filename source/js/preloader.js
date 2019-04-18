jQuery(document).ready(function($) {
	
	  $('#status').fadeOut(); // will first fade out the loading animation 
	  $('#preloader').delay(250).fadeOut('slow'); // will fade out the white DIV that covers the website. 
	  $('body').delay(250).css({'overflow':'visible'});

}); /* end of as page load scripts */