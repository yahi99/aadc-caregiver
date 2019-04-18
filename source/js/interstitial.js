jQuery(document).ready(function($) {

//Interstitial;
    setTimeout(function(){
        $('a.external').click(function (e) {
            e.preventDefault();
            $("#link").attr('href',this.href);
            $("#interstitialModal").addClass(" opened");
            //$('html').toggleClass('modal-lock');
        });
        // Physician Exit Interstitial
        $('#menu-item-15 > a').click(function(e) {
          e.preventDefault();
          $("#physicianLink").attr('href', this.href);
          $("#physicianExitModal").addClass("opened");
        });
        
    },100);

    $('a#link, a#physicianLink').click(function (e) {
    	setTimeout(function(){
        		$("#interstitialModal, #physicianExitModal").removeClass(" opened");
                //$('html').toggleClass('modal-lock');
        	}, 200);
    });

    $('#interstitialModal #close, #physicianExitModal #physicianExitClose').click(function (e) {
        $("#interstitialModal, #physicianExitModal").removeClass(" opened");
    });

}); /* end of as page load scripts */






    
