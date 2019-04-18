


// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the header
var header = document.getElementById("glossary-menu");

if (document.documentElement.clientWidth > 767.98) {
  // Get the offset position of the navbar
  var sticky = header.offsetTop + 310;
} else {
  var sticky = header.offsetTop + 180;
}

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
} 

$(window).scroll(function() {
    var scrollDistance = $(window).scrollTop();

// Assign active class to nav links while scolling
  $('.page-section').each(function(i) {

    if (document.documentElement.clientWidth > 767) {
      if ($(this).position().top <= scrollDistance - 250) {
          $('#glossary-menu li.active').removeClass('active');
          $('#glossary-menu li').eq(i).addClass('active');
      }
    } else if ($(this).position().top <= scrollDistance - 175) {
          $('#glossary-menu li.active').removeClass('active');
          $('#glossary-menu li').eq(i).addClass('active');
      }
  });

}).scroll();