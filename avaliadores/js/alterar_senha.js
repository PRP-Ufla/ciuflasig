$(function(){

	$("#principal #conteudo").off("click", "#alterar-senha");

	$("#principal #conteudo").on("click", "#alterar-senha", function(){

		if($("#senha-antiga").val() === "" || $("#senha-nova").val() === "" 
			|| $("#senha-nova2").val() === "") {
			alert("Preencha todos os campos.");
		} else {
			if($("#senha-nova").val() != $("#senha-nova2").val()) {
				alert("Os campos Nova senha e Confirmar nova senha estão diferentes.");
			} else {
				var senhaAntiga = $("#senha-antiga").val(),
					novaSenha = $("#senha-nova").val();
				$.post("php/alterarSenha.php", {senhaAntiga : senhaAntiga, novaSenha : novaSenha}, 
					function(resposta){
						resposta = JSON.parse(resposta);
						if(resposta["status"] == 0) {
							alert("A sua senha atual está incorreta.");
						} else {
							$(".campos-senha").val("");
							alert("Senha alterada com sucesso.");
						}
				});
			}
		}

	});

});