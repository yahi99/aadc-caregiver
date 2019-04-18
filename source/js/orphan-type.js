jQuery(document).ready(function($) {

	$('#main p').each(function(){
	    var string = $(this).html();
	    string = string.replace(/ ([^ ]*)$/,'&nbsp;$1');
	    $(this).html(string);
	});

}); /* end of as page load scripts */