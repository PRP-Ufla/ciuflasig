$(function(){

	$("#principal #conteudo").off("click", ".remover");

	$.post('php/listarTodasAvaliacoes.php', function(avaliacoes){
		avaliacoes = JSON.parse(avaliacoes);
		if(avaliacoes == null) {
			$('#principal #conteudo').append('<b>Não possui nenhuma sessão/curso avaliada.</b>');
		} else {
			$('#table-avaliacoes').show();
			$.each(avaliacoes, function(index, avaliacao) {
				var $tr = $("<tr />");
				$tr.attr("vaga-id", avaliacao.vagaId);
				$tr.attr("avaliacao-id", avaliacao.avaliacaoId);
				$tr.append("<td>"+avaliacao.sessao_id+"</td>");
				$tr.append("<td>"+avaliacao.nome+"</td>");
				$tr.append("<td>"+avaliacao.cursoNome+"</td>");
				$tr.append("<td>"+avaliacao.horario+"</td>");
				$tr.append("<td><img height='25' width='25' class='remover' src='img/delete.png' title='Remover'></td>");
				$('#table-avaliacoes tbody').append($tr);
			});	
		}
	});

	$("#principal #conteudo").on("click", ".remover", function(){
		if(confirm("Tem certeza que deseja excluir esta avaliação?")) {
			var vagaId = $(this).parents("tr").attr("vaga-id"),
				avaliacaoId = $(this).parents("tr").attr("avaliacao-id");
			$.post("php/removerAvaliacao.php", {vagaId : vagaId, avaliacaoId: avaliacaoId}, function() {
				alert("Avaliação excluída com sucesso!");
				$("#principal #conteudo").load("html/listar_todas_avaliacoes.html");
			});
		}
	});

});