// Для нового iframe
var iframe = document.getElementById("frame");
const pageWidth = document.documentElement.clientWidth
const pageHeight = document.documentElement.clientHeight
console.log(pageWidth);
console.log(pageHeight);

window.onload = function() {
	var token = iframe.dataset.tkn
	var id = iframe.dataset.id
	var testurl = iframe.dataset.testurl
	var url = "http://79.132.139.76:81/test?v=" + testurl + "&width=" + pageWidth +"&height=" + pageHeight + "&tkn=" + token;
    iframe.innerHTML = '<iframe width="' + pageWidth + '" height="' + pageHeight + '" src="'+ url +'" frameborder="0" allowfullscreen></iframe>'
}


