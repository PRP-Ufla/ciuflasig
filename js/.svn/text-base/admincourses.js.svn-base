var script = document.createElement('script');
script.src = 'js/bibliotecaAjax.js';
script.type = 'text/javascript';
script.defer = true;
script.id = 'scriptID';
// Insert the created object to the html head element
var head = document.getElementsByTagName('head').item(0);
head.appendChild(script);

window.onload = function() {
	listCourses();
}

function closeAddDialog() {
	try {
		var box = document.getElementById("addDialog");
		box.style.display = "none";
		box.innerHTML = "";
	} catch (err) { }
}

function openAddDialog() {
	var box;
	try {
		box = document.getElementById("addDialog");
		box.innerHTML = "<center><h1>Adicionar Curso</h1>"+
			"<form action='adminaddcourse.php' method='post'>"+
			"<table border=0><tr>"+
			"<td>Nome do Curso:</td>"+
			"<td><input type='text' name='cursonome' size=25 /></td>"+
			"</tr><tr>"+
			"<td>Sigla do Curso</td>"+
			"<td><input type='text' name='cursosigla' size=10 /></td>"+
			"</tr></table>"+
			"<input type='submit' value='Adicionar' />"+
			" <input type='button' value='Cancelar' "+
			"onClick='closeAddDialog();' />"+
			"</form></center>";
		box.style.display = "inline-block";
	} catch (err) {
		alert("Erro ao obter container \"addDialog\"!\n"+
			err.description);
	}
}

function listCourses() {
	requisicaoHTTP( "GET", "static/list_courses.php", true );
}

function desativar(id) {
	var url = "php/updatecourse.php?id="+id+"&field=state&value=INATIVO";
	requisicaoHTTP( "GET", url, true );
}
function ativar(id) {
	var url = "php/updatecourse.php?id="+id+"&field=state&value=ATIVO";
	requisicaoHTTP( "GET", url, true );
}

function trataDados(){
	var data = ajax.responseText;
	if (data.substr(0,6) == "<done>"){
		//alert("Done!");
		listCourses();
		return;
	} else if (data.substr(0,7) == "<alert>") {	
		//alert(data.replace("<alert>", ""));
		return;
	} else if (data.substr(0,7) == "<added>"){
		listCourses();
		try {
			var box = document.getElementById("addDialog");
			box.innerHTML = "";
			box.style.display = "none";
		} catch (err) {}
		return;
	} else {
		try {
			document.getElementById("courselist").innerHTML = data;
		} catch (err) {
			alert("Falha em obter container \"courselist\"!"+
				err.description);
		}
	}
}
