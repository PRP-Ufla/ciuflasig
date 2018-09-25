$(function(){

	$("#principal #conteudo").on("click", ".exit", function() {
		$.post("php/logout.php", function() {
			$("#principal #conteudo").load("html/login.html");
		});
	}); 
 
	var paginaLogin= function() {
		$("#principal #conteudo").load("html/login.html");
	};

	paginaLogin();

	$("#principal #conteudo").on("click", "#autenticar", function(){
		var usuario = $("#usuario").val(),
			senha = $("#senha").val();
		$.post("php/autenticarUsuario.php", { usuario : usuario, senha : senha }, function(resposta){
			resposta = JSON.parse(resposta);
			if(resposta.autenticado == 'sim') {
				$("#principal #conteudo").load("html/principal.html");
			} else {
				alert("Usuário e/ou senhas incorretos.");
			}
		});
	});

});