// Encoding: ISO-8859-1
var script = document.createElement('script');
script.src = 'js/bibliotecaAjax.js';
script.type = 'text/javascript';
script.defer = true;
script.id = 'scriptID';
// Insert the created object to the html head element
var head = document.getElementsByTagName('head').item(0);
head.appendChild(script);
