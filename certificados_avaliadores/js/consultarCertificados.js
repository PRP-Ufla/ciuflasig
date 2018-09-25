$(function(){

	$("#principal #conteudo").on("click", "#autenticar", function(){
		var usuario = $("#principal #usuario").val(),
			senha = $("#principal #senha").val();
		if(usuario != "" && senha != "") {
			$.post("php/procurarCertificados.php", {usuario : usuario, senha : senha}, function(resposta){
				respostaAutenticarUsuario(resposta);
			});	
		} else {
			$("#principal #resposta").html("O campo usuário e/ou o campo senha não foi preenchido.");
		}
	});

	$("#principal #conteudo").on("change", "#avaliadores-aptos", function(){
		var nomeAvaliador = $("#avaliadores-aptos").val();
		if(nomeAvaliador == '-1') {
			$("#nome-avaliador").val("");
		} else {
			$("#nome-avaliador").val(nomeAvaliador);
		}
	});

	/*$("#principal #conteudo").on("click", "#gerar-certificado", function(){
		var avaliadorNome = $("#nome-avaliador").val(),
			avaliadorId = $("#avaliadores-aptos").find("option:selected").attr("avaliador-id");
		if(avaliadorNome != "") {
			window.open("php/emitirCertificado.php?avaliadorNome="+avaliadorNome+"&avaliadorId="+avaliadorId);
		} else {
			alert("O campo 'Nome do Avaliador' não foi preenchido!");
		}
	});*/
	
	var respostaAutenticarUsuario = function(resposta) {
		if(resposta != 0) {
			if(resposta != 1) {
				listarAvaliadoresAptos(JSON.parse(resposta));
			} else {
				$("#principal #resposta").html("Não existem certificados a serem emitidos.");
			}
		} else {
			$("#principal #resposta").html("Usuário e/ou senha incorretos.");
		}
	};

	
	
	var listarAvaliadoresAptos = function(dados) {
		$("#principal #conteudo").load("html/listar_certificados.html", function(){
			$("#avaliadores-aptos").append("<option value='-1'>SELECIONE UMA OPÇÃO...</option>");
			$.each(dados.avaliadores, function(i, val){
				$("#avaliadores-aptos").append("<option avaliador-id='"+val.id+"'>"+val.nome.toUpperCase()+"</option>");
				}); 
			});
		};
				
				
	// Modificação para a escolha dos eventos
	$("#principal #conteudo").on("change", "#avaliadores-aptos", function(){
		
		$('#certificados tbody').empty();
		
		var nomeAvaliador = $("#avaliadores-aptos").val();
			if(nomeAvaliador == '-1') {
				$("#certificados").val("");
			
			} else {
				
				avaliadorId = $("#avaliadores-aptos").find("option:selected").attr("avaliador-id");
				
				$.post("php/listarAvaliadores.php?avaliadorId="+avaliadorId, function(certificados){
				
					certificados = JSON.parse(certificados);

					if(certificados == null) {

						$('#certificados tbody').append("Voc&ecirc; n&atilde;o possui nenhum certificado.");
					
					} else {
					
						$('#certificados').show();
						$.each(certificados, function(index, certificado) {
							var $tr = $("<tr />");
							//botao = "<input resumo-id='"resumo.id"' type='button' id='visualizar' value='visualizar'/>";	
							$tr.append("<td width = '80%'>"+certificado.edicao+" - "+certificado.ano+"</td>");
							$tr.append("<td><input certificado-idevento='"+certificado.id+"' certificado-id='"+certificado.id_avaliador+"' type='button' id='visualizar' value='Gerar Certificado'/></td>");
							$('#certificados tbody').append($tr);
						});	
									
						$("#principal #conteudo").off("click", "#visualizar");
						$("#principal #conteudo").on("click", "#visualizar", function(){
							var certific = $(this).attr("certificado-id");
							var idevento = $(this).attr("certificado-idevento");
							window.open('../certificados_avaliadores/php/emitirCertificadoAvaliador.php?id='+certific+'&idevento='+idevento);
						});
					}
				});
			}
		});
		// ------------

});