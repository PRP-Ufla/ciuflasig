$(function(){

	$("#principal #conteudo").off("click", "#salvar-vaga");

	$.post("php/preencherSelectSessoes.php", function(sessoes){
		sessoes = JSON.parse(sessoes);
		var $option = $("<option />");
		$option.append("Selecione uma opção...");
		$("#sessao").append($option);
		$.each(sessoes, function(index, sessao){
			$option = $("<option />");
			$option.attr("value", sessao.id);
			$option.append("Sessao "+sessao.id);
			$("#sessao").append($option);
		});
	});

	$.post("php/preencherSelectCursos.php", function(cursos){
		cursos = JSON.parse(cursos);
		var $option = $("<option />");
		$option.append("Selecione uma opção...");
		$("#area").append($option);
		$.each(cursos, function(index, curso){
			$option = $("<option />");
			$option.attr("value", curso.id);
			$option.append(curso.nome);
			$("#area").append($option);
		});
	});

	$("#principal #conteudo").on("click", "#salvar-vaga", function(){
		var sessao = $("#sessao").val(),
			area = $("#area").val(),
			vagas = $("#vagas").val();
		$.post("php/salvarVaga.php", {sessao : sessao, area : area, vagas : vagas});
	});

});