tabControl();

/*
We also apply the switch when a viewport change is detected on the fly
(e.g. when you resize the browser window or flip your device from 
portrait mode to landscape). We set a timer with a small delay to run 
it only once when the resizing ends. It's not perfect, but it's better
than have it running constantly during the action of resizing.
*/
var resizeTimer;
$(window).on('resize', function(e) {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {
    tabControl();
  }, 250);
});

/*
The function below is responsible for switching the tabs when clicked.
It switches both the tabs and the accordion buttons even if 
only the one or the other can be visible on a screen. We prefer
that in order to have a consistent selection in case the viewport
changes (e.g. when you esize the browser window or flip your 
device from portrait mode to landscape).
*/
function tabControl() {
  $('#tabs ul li:first-child a').addClass('active');
  $('#tabs ul li:last-child a').removeClass('active');
  $('#anna').addClass(' active');
  $('#james').removeClass(' active');
  var tabs = $('.tabbed-content').find('.tabs');
  if(tabs.is(':visible')) {
    tabs.find('a').on('click', function(event) {
      event.preventDefault();
      var target = $(this).attr('href'),
          currId = $(this).attr('href'),
          tabs = $(this).parents('.tabs'),
          buttons = tabs.find('a'),
          item = tabs.parents('.tabbed-content').find('.item');
      buttons.removeClass('active');
      item.removeClass('active');
      $(this).addClass('active');
      $(target).addClass('active');
      setTimeout(function() {
        location.hash = currId;
      }, 250);
    });
  } else {
    $('#tabs ul li:first-child a').removeClass('active');
    $('#tabs ul li:last-child a').addClass('active');
    $('#anna').removeClass(' active');
    $('#james').addClass(' active');
    $('.item').on('click', function() {
      var container = $(this).parents('.tabbed-content'),
          currId = $(this).attr('id'),
          items = container.find('.item');
      container.find('.tabs a').removeClass('active');
      items.removeClass('active');
      $(this).addClass('active');
      container.find('.tabs a[href$="#'+ currId +'"]').addClass('active');
      setTimeout(function() {
        location.hash = currId;
      }, 250);
    });
  } 
}

$('#james2').on('click', function() {
    setTimeout(function() {
      $('#tabs ul li:first-child a').removeClass('active');
      $('#tabs ul li:last-child a').addClass('active');
    }, 350);
});

$('#anna2').on('click', function() {
    setTimeout(function() {
      $('#tabs ul li:last-child a').removeClass('active');
      $('#tabs ul li:first-child a').addClass('active');
    }, 350);
});