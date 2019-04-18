
var hcpBox = document.getElementById('hcp-interstitial');

var ccBox = document.getElementById('cc-banner');
var ccButton = document.getElementById('cc-dismiss');

if (!Cookies.get('cc-box')) {

  ccBox.classList.add('opened');

  ccButton.onclick = function () {
    Cookies.set('cc-box', true, { expires: 14 });
    ccBox.classList.remove('opened');
    ccBox.classList.add('closed');
  };
}