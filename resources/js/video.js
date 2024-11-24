// Для нового iframe
var iframe = document.getElementById("frame");

console.log(123);

iframe.onload = function() {
  console.log("iframe загрузился: " + iframe.src);

  setTimeout( function() { 
    console.log(iframe.contentDocument) 
    }, 4000);
}; 
