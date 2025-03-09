// Для нового iframe
var iframe = document.getElementById("frame");
const pageWidth = document.documentElement.scrollWidth
const pageHeight = document.documentElement.scrollHeight
console.log(pageWidth);
console.log(pageHeight);

window.onload = function() {
	var token = iframe.dataset.tkn
	var id = iframe.dataset.id
	var url = "http://localhost:81/content?id=" + id + "&width=" + pageWidth +"&height=" + pageHeight + "&tkn=" + token;
    iframe.innerHTML = '<iframe width="' + pageWidth + '" height="' + pageHeight + '" src="'+ url +'" frameborder="0" allowfullscreen></iframe>' 
}


