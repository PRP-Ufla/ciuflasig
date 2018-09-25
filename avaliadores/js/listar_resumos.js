$(function(){

	$.post('php/listarResumos.php', function(resumos){
			
		resumos = JSON.parse(resumos);
		if(resumos == null) {

			$('#principal #conteudo').append('<b>Voc&ecirc; ainda n&atilde;o possui nenhum resumo.</b>');
		} else {
		
			$('#resumos').show();
			$.each(resumos, function(index, resumo) {
				var $tr = $("<tr />");
				//botao = "<input resumo-id='"resumo.id"' type='button' id='visualizar' value='visualizar'/>";	
				$tr.append("<td>"+resumo.sessoes_id+"</td>");
				$tr.append("<td>"+resumo.horario+"</td>");
				$tr.append("<td>"+resumo.titulo+"</td>");
				$tr.append("<td><input resumo-id='"+resumo.id+"' type='button' id='visualizar' value='visualizar'/></td>");
				$('#resumos tbody').append($tr);
			});	
			
			$("#principal #conteudo").off("click", "#visualizar");
			$("#principal #conteudo").on("click", "#visualizar", function(){
					var resumoId = $(this).attr("resumo-id");
					window.open('../generateResumoPDF.php?id='+resumoId);
			});
		}
	});


});