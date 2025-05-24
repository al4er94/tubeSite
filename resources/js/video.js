// Для нового iframe
var iframe = document.getElementById("frame");
const frameWidth = iframe.offsetWidth
const frameHeight = frameWidth / 2
console.log(frameWidth);
console.log(frameHeight);

window.onload = function() {
	var token = iframe.dataset.tkn
	var id = iframe.dataset.id
	var testurl = iframe.dataset.testurl
	var url = "https://79.132.139.76:81/test?v=" + testurl + "&width=" + frameWidth +"&height=" + frameHeight + "&tkn=" + token;
    iframe.innerHTML = '<iframe width="' + frameWidth + '" height="' + frameHeight + '" src="'+ url +'" frameborder="0" allowfullscreen></iframe>'
}
