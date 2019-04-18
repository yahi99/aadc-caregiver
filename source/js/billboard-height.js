setTimeout(function(){

	if (document.documentElement.clientWidth < 767.98) {
		$('#billboard-image').each(function() {
		    // Set up the variables
		    var $this = $(this),
		        //w = $this.find('img').width(), // Width of the image inside .box
		        h = $this.find('img').height() -115; // Height of the image inside .box
		    $('#billboard').height(h); // Set width and height of .box to match image
		  });

		$(window).on('resize', function() {
		// For each .box element
		  $('#billboard-image').each(function() {
		    // Set up the variables
		    var $this = $(this),
		        //w = $this.find('img').width(), // Width of the image inside .box
		        h = $this.find('img').height() -115; // Height of the image inside .box
		    $('#billboard').height(h); // Set width and height of .box to match image
		  });
		});
	}

	if (document.documentElement.clientWidth > 767.98) {
		$('#billboard-image').each(function() {
		    // Set up the variables
		    var $this = $(this),
		        //w = $this.find('img').width(), // Width of the image inside .box
		        h = $this.find('img').height() -127; // Height of the image inside .box
		    $('#billboard').height(h); // Set width and height of .box to match image
		  });

		$(window).on('resize', function() {
		// For each .box element
		  $('#billboard-image').each(function() {
		    // Set up the variables
		    var $this = $(this),
		        //w = $this.find('img').width(), // Width of the image inside .box
		        h = $this.find('img').height() -127; // Height of the image inside .box
		    $('#billboard').height(h); // Set width and height of .box to match image
		  });
		});
	}

	if (document.documentElement.clientWidth > 991.98) {
		$('#billboard-image').each(function() {
		    // Set up the variables
		    var $this = $(this),
		        //w = $this.find('img').width(), // Width of the image inside .box
		        h = $this.find('img').height() -137; // Height of the image inside .box
		    $('#billboard').height(h); // Set width and height of .box to match image
		  });

		$(window).on('resize', function() {
		// For each .box element
		  $('#billboard-image').each(function() {
		    // Set up the variables
		    var $this = $(this),
		        //w = $this.find('img').width(), // Width of the image inside .box
		        h = $this.find('img').height() -137; // Height of the image inside .box
		    $('#billboard').height(h); // Set width and height of .box to match image
		  });
		});
	}

}, 100);



	

