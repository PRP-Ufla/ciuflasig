var requisitarResumos = function() {

	var areaId = $("#resumos").attr("curso-id");
	$.post("php/procurarResumoPorArea.php", {areaId:areaId}, function(resumos){
		var resumos = JSON.parse(resumos);
		var status;
		var numero = 1;
		$.each(resumos, function(i, value) {
			if(value.status_avaliacao == 0) {
				status = "Não avaliado.";
			} else if(value.status_avaliacao == 1) {
				status = "Aprovado.";
			} else if(value.status_avaliacao == 2) {
				status = "Reprovado.";
			}
		$("#resumos tbody").append("<tr><td>"+numero+"</td><td>"+value.id+"</td><td resumo-id='"+value.id+"'>"+value.titulo+
				"</td><td><input id='avaliar' type='button' value='Avaliar Resumo'/></td><td>"+status+"</td></tr>");
				numero++;	
		});
	});

};

$("#conteudo").on("click", "#avaliar", function() {

	var resumoId = $(this).parents("tr").children("td:eq(2)").attr("resumo-id"),
		areaId = $("#resumos").attr("curso-id");

	$("#principal #conteudo").load("html/avaliar.html", function(){
		$("#principal #conteudo").off("click", "#avaliar");
		$("#principal #conteudo").off("click", "#voltar-area");
		requisitarResumo(resumoId, areaId);
	});

});

$("#principal #conteudo").on("click", "#voltar-area", function() {
	$("#principal #conteudo").load("html/principal.html", function() {
		$("#principal #conteudo").off("click", "#avaliar");
		$("#principal #conteudo").off("click", "#voltar-area");
	});
});