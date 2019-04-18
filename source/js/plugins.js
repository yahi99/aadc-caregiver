// Avoid `console` errors in browsers that lack a console.
(function() {
  var method;
  var noop = function () {};
  var methods = [
    'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
    'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
    'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
    'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
  ];
  var length = methods.length;
  var console = (window.console = window.console || {});

  while (length--) {
    method = methods[length];

    // Only stub undefined methods.
    if (!console[method]) {
      console[method] = noop;
    }
  }
}());

$(document).ready(function(){
// @codekit-prepend "preloader.js";
// @codekit-prepend "modernizr-3.6.0.min.js";
// @codekit-prepend "menu-toggle.js";
// @codekit-prepend "js.cookie.js";
// @codekit-prepend "cookie-settings.js";
// @codekit-prepend "play-video.js";
// @codekit-prepend "focus.js";
// @codekit-prepend "skip-link-focus-fix.js";
// @codekit-prepend "interstitial.js";
// @codekit-prepend "scroll.to.js";
});
