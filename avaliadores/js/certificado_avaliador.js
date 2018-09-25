$(function(){
		$.post('php/listarAvaliadores.php', function(certificados){
				
		certificados = JSON.parse(certificados);
		if(certificados == null) {

			$('#principal #conteudo').append('<b>Voc&ecirc; n&atilde;o possui nenhum certificado.</b>');
		} else {
		
			$('#certificados').show();
			$.each(certificados, function(index, certificado) {
				var $tr = $("<tr />");
				//botao = "<input resumo-id='"resumo.id"' type='button' id='visualizar' value='visualizar'/>";	
				$tr.append("<td width = '80%'>"+certificado.edicao+" - "+certificado.ano+"</td>");
				$tr.append("<td><input certificado-idevento='"+certificado.id+"' certificado-id='"+certificado.id_avaliador+"' type='button' id='visualizar' value='visualizar'/></td>");
				$('#certificados tbody').append($tr);
			});	
			
			$("#principal #conteudo").off("click", "#visualizar");
			$("#principal #conteudo").on("click", "#visualizar", function(){
					var certific = $(this).attr("certificado-id");
					var idevento = $(this).attr("certificado-idevento");
					window.open('../avaliadores/php/emitirCertificadoAvaliador.php?id='+certific+'&idevento='+idevento);
			});
		}
	});

});