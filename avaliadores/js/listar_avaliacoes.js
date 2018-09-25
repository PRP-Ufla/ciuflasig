$(function(){

	$.post('php/listarAvaliacoes.php', function(avaliacoes){
		avaliacoes = JSON.parse(avaliacoes);
		if(avaliacoes == null) {
			$('#principal #conteudo').append('<b>Você ainda não marcou nenhuma sessão/curso para avaliar.</b>');
		} else {
			$('#minhas-avaliacoes').show();
			$.each(avaliacoes, function(index, avaliacao) {
				var $tr = $("<tr />");
				$tr.attr("vaga-id", avaliacao.id);
				$tr.append("<td>"+avaliacao.sessao_id+"</td>");
				$tr.append("<td>"+avaliacao.cursoNome+"</td>");
				$tr.append("<td>"+avaliacao.horario+"</td>");
				$('#minhas-avaliacoes tbody').append($tr);
			});	
		}
	});

});