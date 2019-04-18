function handleFirstTab(e){9===e.keyCode&&(document.body.classList.add("user-is-tabbing"),window.removeEventListener("keydown",handleFirstTab))}jQuery(document).ready(function(e){setTimeout(function(){e("a.external").click(function(t){t.preventDefault(),e("#link").attr("href",this.href),e("#interstitialModal").addClass(" opened")})},100),e("a#link").click(function(t){setTimeout(function(){e("#interstitialModal").removeClass(" opened")},200)}),e("#interstitialModal #close").click(function(t){e("#interstitialModal").removeClass(" opened")})}),jQuery(document).ready(function(e){e("#status").fadeOut(),e("#preloader").delay(250).fadeOut("slow"),e("body").delay(250).css({overflow:"visible"})}),jQuery(document).ready(function(e){e(".menu-toggle").click(function(){e(this).toggleClass("up"),e(".menu-toggle + #menu-container").slideToggle(500,function(){})})}),jQuery(document).ready(function(e){e(".widget_custom_html").contents().unwrap(),e(".table-container table").addClass("table")}),jQuery(document).ready(function(e){e("#billboard p, .radius-box-image-text p, .fluid-container.image.right .headline, #main h1, body:not(.home) #main h2, #main h3, #main li, #next-page a, .centered-blue-header").each(function(){var t=e(this).html();t=t.replace(/ ([^ ]*)$/,"&nbsp;$1"),e(this).html(t)})}),jQuery(document).ready(function(e){setTimeout(function(){e(".post-thumbnail").each(function(){var t,n=e(this).find("img").height()-5;e("#billboard").height(n)}),e(window).on("resize",function(){e(".post-thumbnail").each(function(){var t,n=e(this).find("img").height();e("#billboard").height(n)})})},2)}),jQuery(document).ready(function(e){e(".fluid-container.image.right").each(function(){var t=e(this),n=t.find("img").height();t.height(n)})}),window.addEventListener("keydown",handleFirstTab),function(e,t,n){function i(e,t){return typeof e===t}function o(){var e,t,n,o,r,s,a;for(var l in b)if(b.hasOwnProperty(l)){if(e=[],(t=b[l]).name&&(e.push(t.name.toLowerCase()),t.options&&t.options.aliases&&t.options.aliases.length))for(n=0;n<t.options.aliases.length;n++)e.push(t.options.aliases[n].toLowerCase());for(o=i(t.fn,"function")?t.fn():t.fn,r=0;r<e.length;r++)1===(a=(s=e[r]).split(".")).length?C[a[0]]=o:(!C[a[0]]||C[a[0]]instanceof Boolean||(C[a[0]]=new Boolean(C[a[0]])),C[a[0]][a[1]]=o),x.push((o?"":"no-")+a.join("-"))}}function r(e){var t=S.className,n=C._config.classPrefix||"";if(T&&(t=t.baseVal),C._config.enableJSClass){var i=new RegExp("(^|\\s)"+n+"no-js(\\s|$)");t=t.replace(i,"$1"+n+"js$2")}C._config.enableClasses&&(t+=" "+n+e.join(" "+n),T?S.className.baseVal=t:S.className=t)}function s(e,t){if("object"==typeof e)for(var n in e)P(e,n)&&s(n,e[n]);else{var i=(e=e.toLowerCase()).split("."),o=C[i[0]];if(2==i.length&&(o=o[i[1]]),void 0!==o)return C;t="function"==typeof t?t():t,1==i.length?C[i[0]]=t:(!C[i[0]]||C[i[0]]instanceof Boolean||(C[i[0]]=new Boolean(C[i[0]])),C[i[0]][i[1]]=t),r([(t&&0!=t?"":"no-")+i.join("-")]),C._trigger(e,t)}return C}function a(){return"function"!=typeof t.createElement?t.createElement(arguments[0]):T?t.createElementNS.call(t,"http://www.w3.org/2000/svg",arguments[0]):t.createElement.apply(t,arguments)}function l(){var e=t.body;return e||((e=a(T?"svg":"body")).fake=!0),e}function u(e,n,i,o){var r,s,u,d,c="modernizr",f=a("div"),p=l();if(parseInt(i,10))for(;i--;)(u=a("div")).id=o?o[i]:c+(i+1),f.appendChild(u);return(r=a("style")).type="text/css",r.id="s"+c,(p.fake?p:f).appendChild(r),p.appendChild(f),r.styleSheet?r.styleSheet.cssText=e:r.appendChild(t.createTextNode(e)),f.id=c,p.fake&&(p.style.background="",p.style.overflow="hidden",d=S.style.overflow,S.style.overflow="hidden",S.appendChild(p)),s=n(f,e),p.fake?(p.parentNode.removeChild(p),S.style.overflow=d,S.offsetHeight):f.parentNode.removeChild(f),!!s}function d(e,t){return!!~(""+e).indexOf(t)}function c(e){return e.replace(/([A-Z])/g,function(e,t){return"-"+t.toLowerCase()}).replace(/^ms-/,"-ms-")}function f(t,n,i){var o;if("getComputedStyle"in e){o=getComputedStyle.call(e,t,n);var r=e.console;if(null!==o)i&&(o=o.getPropertyValue(i));else if(r){var s;r[r.error?"error":"log"].call(r,"getComputedStyle returning null, its possible modernizr test results are inaccurate")}}else o=!n&&t.currentStyle&&t.currentStyle[i];return o}function p(t,i){var o=t.length;if("CSS"in e&&"supports"in e.CSS){for(;o--;)if(e.CSS.supports(c(t[o]),i))return!0;return!1}if("CSSSupportsRule"in e){for(var r=[];o--;)r.push("("+c(t[o])+":"+i+")");return u("@supports ("+(r=r.join(" or "))+") { #modernizr { position: absolute; } }",function(e){return"absolute"==f(e,null,"position")})}return n}function h(e){return e.replace(/([a-z])-([a-z])/g,function(e,t,n){return t+n.toUpperCase()}).replace(/^-/,"")}function m(e,t,o,r){function s(){u&&(delete M.style,delete M.modElem)}if(r=!i(r,"undefined")&&r,!i(o,"undefined")){var l=p(e,o);if(!i(l,"undefined"))return l}for(var u,c,f,m,g,v=["modernizr","tspan","samp"];!M.style&&v.length;)u=!0,M.modElem=a(v.shift()),M.style=M.modElem.style;for(f=e.length,c=0;f>c;c++)if(m=e[c],g=M.style[m],d(m,"-")&&(m=h(m)),M.style[m]!==n){if(r||i(o,"undefined"))return s(),"pfx"!=t||m;try{M.style[m]=o}catch(e){}if(M.style[m]!=g)return s(),"pfx"!=t||m}return s(),!1}function g(e,t){return function(){return e.apply(t,arguments)}}function v(e,t,n){var o;for(var r in e)if(e[r]in t)return!1===n?e[r]:i(o=t[e[r]],"function")?g(o,n||t):o;return!1}function y(e,t,n,o,r){var s=e.charAt(0).toUpperCase()+e.slice(1),a=(e+" "+B.join(s+" ")+s).split(" ");return i(t,"string")||i(t,"undefined")?m(a,t,o,r):v(a=(e+" "+k.join(s+" ")+s).split(" "),t,n)}function A(e,t,i){return y(e,n,n,t,i)}var b=[],w={_version:"3.6.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,t){var n=this;setTimeout(function(){t(n[e])},0)},addTest:function(e,t,n){b.push({name:e,fn:t,options:n})},addAsyncTest:function(e){b.push({name:null,fn:e})}},C=function(){};C.prototype=w,C=new C;var x=[],S=t.documentElement,T="svg"===S.nodeName.toLowerCase(),_="Moz O ms Webkit",k=w._config.usePrefixes?_.toLowerCase().split(" "):[];w._domPrefixes=k;var E=w._config.usePrefixes?" -webkit- -moz- -o- -ms- ".split(" "):["",""],P;w._prefixes=E,function(){var e={}.hasOwnProperty;P=i(e,"undefined")||i(e.call,"undefined")?function(e,t){return t in e&&i(e.constructor.prototype[t],"undefined")}:function(t,n){return e.call(t,n)}}(),w._l={},w.on=function(e,t){this._l[e]||(this._l[e]=[]),this._l[e].push(t),C.hasOwnProperty(e)&&setTimeout(function(){C._trigger(e,C[e])},0)},w._trigger=function(e,t){if(this._l[e]){var n=this._l[e];setTimeout(function(){var e,i;for(e=0;e<n.length;e++)(i=n[e])(t)},0),delete this._l[e]}},C._q.push(function(){w.addTest=s});var O=function(){function e(e,t){var o;return!!e&&(t&&"string"!=typeof t||(t=a(t||"div")),!(o=(e="on"+e)in t)&&i&&(t.setAttribute||(t=a("div")),t.setAttribute(e,""),o="function"==typeof t[e],t[e]!==n&&(t[e]=n),t.removeAttribute(e)),o)}var i=!("onblur"in t.documentElement);return e}();w.hasEvent=O;var j=function(){var t=e.matchMedia||e.msMatchMedia;return t?function(e){var n=t(e);return n&&n.matches||!1}:function(t){var n=!1;return u("@media "+t+" { #modernizr { position: absolute; } }",function(t){n="absolute"==(e.getComputedStyle?e.getComputedStyle(t,null):t.currentStyle).position}),n}}();w.mq=j;var z=function(e,t){var n=!1,i,o=a("div").style;if(e in o){var r=k.length;for(o[e]=t,n=o[e];r--&&!n;)o[e]="-"+k[r]+"-"+t,n=o[e]}return""===n&&(n=!1),n};w.prefixedCSSValue=z;var B=w._config.usePrefixes?_.split(" "):[];w._cssomPrefixes=B;var L={elem:a("modernizr")};C._q.push(function(){delete L.elem});var M={style:L.elem.style};C._q.unshift(function(){delete M.style}),w.testAllProps=y,w.testAllProps=A,w.testProp=function(e,t,i){return m([e],n,t,i)},w.testStyles=u,C.addTest("customelements","customElements"in e),C.addTest("history",function(){var t=navigator.userAgent;return(-1===t.indexOf("Android 2.")&&-1===t.indexOf("Android 4.0")||-1===t.indexOf("Mobile Safari")||-1!==t.indexOf("Chrome")||-1!==t.indexOf("Windows Phone")||"file:"===location.protocol)&&(e.history&&"pushState"in e.history)}),C.addTest("pointerevents",function(){var e=!1,t=k.length;for(e=C.hasEvent("pointerdown");t--&&!e;)O(k[t]+"pointerdown")&&(e=!0);return e}),C.addTest("postmessage","postMessage"in e),C.addTest("webgl",function(){var t=a("canvas"),n="probablySupportsContext"in t?"probablySupportsContext":"supportsContext";return n in t?t[n]("webgl")||t[n]("experimental-webgl"):"WebGLRenderingContext"in e});var N=!1;try{N="WebSocket"in e&&2===e.WebSocket.CLOSING}catch(e){}C.addTest("websockets",N),C.addTest("cssanimations",A("animationName","a",!0)),function(){C.addTest("csscolumns",function(){var e=!1,t=A("columnCount");try{(e=!!t)&&(e=new Boolean(e))}catch(e){}return e});for(var e,t,n=["Width","Span","Fill","Gap","Rule","RuleColor","RuleStyle","RuleWidth","BreakBefore","BreakAfter","BreakInside"],i=0;i<n.length;i++)e=n[i].toLowerCase(),t=A("column"+n[i]),("breakbefore"===e||"breakafter"===e||"breakinside"==e)&&(t=t||A(n[i])),C.addTest("csscolumns."+e,t)}(),C.addTest("flexbox",A("flexBasis","1px",!0)),C.addTest("picture","HTMLPictureElement"in e),C.addAsyncTest(function(){var e,t,n,i=a("img"),o="sizes"in i;!o&&"srcset"in i?(t="data:image/gif;base64,R0lGODlhAgABAPAAAP///wAAACH5BAAAAAAALAAAAAACAAEAAAICBAoAOw==",e="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",n=function(){s("sizes",2==i.width)},i.onload=n,i.onerror=n,i.setAttribute("sizes","9px"),i.srcset=e+" 1w,"+t+" 8w",i.src=e):s("sizes",o)}),C.addTest("srcset","srcset"in a("img")),C.addTest("webworkers","Worker"in e),o(),r(x),delete w.addTest,delete w.addAsyncTest;for(var R=0;R<C._q.length;R++)C._q[R]();e.Modernizr=C}(window,document),$("#play-video").on("click",function(e){$("#video")[0].src+="&autoplay=1",e.preventDefault()});