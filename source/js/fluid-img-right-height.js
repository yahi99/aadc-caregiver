jQuery(document).ready(function($) {

	//$(window).on('load resize', function() {
	// For each .box element
	  $('.fluid-container.image.right').each(function() {
	    // Set up the variables
	    var $this = $(this),
	        //w = $this.find('img').width(), // Width of the image inside .box
	        h = $this.find('img').height(); // Height of the image inside .box
	    $this.height(h); // Set width and height of .box to match image
	  });
	//});

});




	

