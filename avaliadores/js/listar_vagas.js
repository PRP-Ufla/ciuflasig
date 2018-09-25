$(function(){

	$("#principal #conteudo").off("click", ".remover-vaga");
	$("#principal #conteudo").off("click", "#atualizar-disponiveis");

	$.post('php/listarVagas.php', function(vagas){
		vagas = JSON.parse(vagas);
		if(vagas == null) {
			$('#principal #conteudo').append('<b>Não existe nenhuma vaga cadastrada.</b>');
		} else {
			$('#table-vagas').show();
			$.each(vagas, function(index, vaga) {
				var $tr = $("<tr />");
				$tr.attr("vaga-id", vaga.id);
				$tr.append("<td>"+vaga.sessao_id+"</td>");
				$tr.append("<td>"+vaga.cursoNome+"</td>");
				$tr.append("<td>"+vaga.horario+"</td>");
				$tr.append("<td><input type='text' id='disponiveis' value='"+vaga.disponiveis+"'/></td>");
				$tr.append("<td><input type='button' id='atualizar-disponiveis' value='Atualizar'/></td>");
				$tr.append("<td><img height='25' width='25' class='remover-vaga' src='img/delete.png' title='Remover Vaga'></td>");
				$('#table-vagas tbody').append($tr);
			});	
		}
	});

	$("#principal #conteudo").on("click", ".remover-vaga", function(){
		if(confirm("Tem certeza que deseja excluir esta vaga?")) {
			var vagaId = $(this).parents("tr").attr("vaga-id");
			$.post("php/removerVaga.php", {vagaId : vagaId}, function() {
				alert("Vaga excluída com sucesso!");
				$("#principal #conteudo").load("html/listar_vagas.html");
			});
		}
	});

	$("#principal #conteudo").on("click", "#atualizar-disponiveis", function(){
		var disponiveis = $(this).parents("td").siblings().find("input").val(),
			vagaId = $(this).parents("tr").attr("vaga-id");
		$.post("php/atualizarDisponiveis.php", {vagaId : vagaId, disponiveis : disponiveis}, function() {
			alert("Vaga atualizada com sucesso!");
			$("#principal #conteudo").load("html/listar_vagas.html");
		});
	});

});