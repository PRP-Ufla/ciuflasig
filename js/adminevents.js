// Encoding: ISO-8859-1
var script = document.createElement('script');
script.src = 'js/bibliotecaAjax.js';
script.type = 'text/javascript';
script.defer = true;
script.id = 'scriptID';
// Insert the created object to the html head element
var head = document.getElementsByTagName('head').item(0);
head.appendChild(script);

var last;

window.onload = function() {
	last = "m1";
	eventos();
}

function refreshContents(novo) {
	try {
		document.getElementById(last).style.backgroundColor = "";
		document.getElementById(novo).style.backgroundColor = "#ddd";
		last = novo;
	} catch (err) {
		alert(err.description);
	}
}

function eventos() {
	var url = "static/list_adminevents.php";
	//alert("Aki entrou!\n"+url);
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
	refreshContents("m1");
}

function addEvento() {
	var url = "static/form_addevent.php";
	//alert("Aki entrou!\n"+url);
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
	refreshContents("m2");
}

function trataDados(){
	var data = ajax.responseText;
	if (data.substr(0,7) == "<alert>") {	
		alert(data.replace("<alert>", ""));
		return;
	} else if (data.substr(0,9) == "<deleted>") {
		eventos();
		return;
	} else {
		try {
			document.getElementById("contentbar").innerHTML = data;
		} catch (err) {
			alert("Falha em obter container \"contentbar\"!"+
				err.description);
		}
	}
}
