$(function(){

	$("#principal #conteudo").off("click", "#escolher-sessao");

	var procurarVagas = function(cursoId) {
		$.post('php/procurarVagas.php', {cursoId : cursoId}, function(vagas){			
			vagas = JSON.parse(vagas); 
			$.each(vagas, function(index, vaga) {
				if(vaga.disponiveis > 0) {
					if(!$("#sessoes").is(":visible")) {
						$('#sessoes').show();
			 			$('#avisos-sessao').show();
					}
					var $tr = $("<tr />"),
						botao = "<input type='button' id='avaliar' value='Avaliar'/>";
					$tr.attr("vaga-id", vaga.id);
					$tr.append("<td>"+vaga.sessao_id+"</td>");
					$tr.append("<td>"+vaga.disponiveis+"</td>");
					$tr.append("<td>"+vaga.horario+"</td>");
					$tr.append("<td>"+botao+"</td>");
					$('#sessoes tbody').append($tr);
				}
			});
			if($("#sessoes tr").length == 1) {
			 	$('#principal #conteudo').append('<b>Não há sessões para esta área/curso.</b>');
			}
		});
	};

	$.post("php/preencherSelectCursosVagas.php", function(cursos){
		cursos = JSON.parse(cursos);
		var $option = $("<option />");
		$option.append("Selecione uma opção...");
		$("#curso").append($option);
		$.each(cursos, function(index, curso){
			$option = $("<option />");
			$option.attr("value", curso.id);
			$option.append(curso.nome);
			$("#curso").append($option);
		});
	});

	$("#principal #conteudo").on("click", "#escolher-sessao", function(){
		var cursoId = $("#curso").val();
		$("#principal #conteudo").load("html/escolher_sessao.html", function(){
			procurarVagas(cursoId);
		});
	});

});