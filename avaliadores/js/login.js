$(function(){

	$("#principal #conteudo").off("click", "#acessar");
 
	$("#principal #conteudo").on("click", "#acessar", function(){
		var email = $("#email").val(),
			senha = $("#senha").val();
		$.post("php/autenticarUsuario.php", { email : email, senha : senha }, function(resposta){
			resposta = JSON.parse(resposta);
			if(resposta.autenticado == 'sim') {
				$("#principal #conteudo").load("html/principal.html");
				if(resposta.permissao == 0) {
					$("#principal #cabecalho").load("html/menu_usuario2.html");
				} else {
					$("#principal #cabecalho").load("html/menu_admin.html");
				}
			} else {
				alert("Usu�rio e/ou senhas incorretos.");
			}
		});
	});
	
	$("#principal #conteudo").off("click","#recup-senha");
	
	$("#principal #conteudo").on("click","#recup-senha", function(){
	
		$("#principal #conteudo").load("html/recuperarsenha.html");
		
		$("#principal #conteudo").off("click", "#Enviar");

		$("#principal #conteudo").on("click","#Enviar", function(){
		var email = $("#email").val();

			$.post("php/recover.php", {email : email}, function(resposta){
						if(resposta[0] == 0){
						alert("N�o foi poss�vel enviar o e-mail para seu endere�o cadastrado, contate o administrador para solucionar do problema.");
						}else if(resposta[0] == 1){
						alert("Sua senha foi alterada com sucesso, verifique seu e-mail cadastrado para obter a nova senha. ");
						}
						else if(resposta[0] == 3){
						alert("E-Mail n�o informado!");
						}else if(resposta[0] == 4){
						alert("Usuario n�o cadastrado!");
						}
						else if(resposta[0] == 5){
						alert("N�o foi poss�vel enviar e-mail para seu endere�o cadastrado,Contate o administrador para solu��o do problema.");
						}
			
			});
		
		});
		
	});

});