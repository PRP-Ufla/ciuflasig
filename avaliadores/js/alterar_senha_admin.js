$(function(){

	$.post("php/preencherSelectUsuarioAvaliador.php", function(usuarios){
	
		usuarios = JSON.parse(usuarios);
		var $option = $("<option />");
		$option.append("Selecione um usuário");
		$("#usuario").append($option);
		$.each(usuarios, function(index, usuario){
			$option = $("<option />");
			$option.attr("value", usuario.id);
			$option.append(usuario.nome+" -> "+usuario.email);
			$("#usuario").append($option);
		});
	});

	
	
	$("#principal #conteudo").off("click", "#alterar-senha");

	$("#principal #conteudo").on("click", "#alterar-senha", function(){

		if($("#senha-nova").val() === "" || $("#senha-nova2").val() === "" || $("#usuario").val() === "") {
			alert("Preencha todos os campos.");
		} else {
			if($("#senha-nova").val() != $("#senha-nova2").val()) {
				alert("Os campos Nova senha e Confirmar nova senha estão diferentes.");
			} else {
				var usuario = $("#usuario").val(),
					novaSenha = $("#senha-nova").val();
				$.post("php/alterarSenhaAdmin.php", { novaSenha : novaSenha, usuario: usuario }, 
					function(resposta){
						resposta = JSON.parse(resposta);
						if(resposta["status"] == 0) {
							alert("Senha atual incorreta.");
						} else {
							$(".campos-senha").val("");
							alert("Senha alterada com sucesso.");
						}
				});
			}
		}

	});

});