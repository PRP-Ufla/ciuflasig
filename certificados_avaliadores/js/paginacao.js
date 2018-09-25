$(function(){
 
	var paginaInicial = function() {
		$("#principal #conteudo").load("html/principal.html");
	};

	var paginaComprovar = function() {
		$("#principal #conteudo").load("html/comprovar.html");
	};

	var paginaContato = function() {
		$("#principal #conteudo").load("html/contato.html");
	};

	var paginaSobre = function() {
		$("#principal #conteudo").load("html/sobre.html");
	};

	paginaInicial();

	$("#principal #cabecalho a").on("click", function(){
		if(this.text === "INICIO") {
			paginaInicial();
		} else if(this.text === "COMPROVAR") {
			paginaComprovar();
		} else if(this.text === "CONTATO") {
			paginaContato();
		} else if(this.text === "SOBRE") {
			paginaSobre();
		}	
	});

});