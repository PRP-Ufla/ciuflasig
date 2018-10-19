$(function(){

	$("#principal #conteudo").off("click", ".remover-vaga");
	$("#principal #conteudo").off("click", "#atualizar-disponiveis");
	$("#principal #conteudo").off("click", "#ordenar-tab");
	
	function carregar(ordenar){
		$.post('php/listarVagas.php', {ordenar : ordenar}, function(vagas){
			vagas = JSON.parse(vagas);
			if(vagas == null) {
				$('#principal #conteudo').append('<b>Não existe nenhuma vaga cadastrada.</b>');
			} else {
				$('#table-vagas').show();
				$.each(vagas, function(index, vaga) {

					if(vaga.total === null){
						vaga.total = 0;
					}
					var $tr = $("<tr />"),
						media;

					vaga.total = parseInt(vaga.total) + parseInt(vaga.disponiveis);

					media = vaga.resumos / vaga.total;

					//Função para arredondar para duas casas, somente numeros com casas decimais
					var m = media+"",

						decimal = m.indexOf(".");

					if(decimal !== -1){
						media = media.toFixed(2);
					}

					if(media === Infinity){
						//Possível que está mensagem tenha de ser alterada
						media = "Sem vagas disponibilizadas";
					}

					$tr.attr("vaga-id", vaga.id);
					$tr.append("<td>"+vaga.sessao_id+"</td>");
					$tr.append("<td>"+vaga.cursoNome+"</td>");
					$tr.append("<td>"+vaga.horario+"</td>");
					$tr.append("<td>"+vaga.resumos+"</td>");
					$tr.append("<td>"+media+"</td>");
					$tr.append("<td>"+vaga.total+"</td>");
					$tr.append("<td><input type='text' id='disponiveis' value='"+vaga.disponiveis+"'/></td>");
					$tr.append("<td><input type='button' id='atualizar-disponiveis' value='Atualizar'/></td>");
					$tr.append("<td><img height='25' width='25' class='remover-vaga' src='img/delete.png' title='Remover Vaga'></td>");
					$('#table-vagas tbody').append($tr);
				});	
			}
		});
	}
	
	function exibePag(ordenar){
		$("#principal #conteudo").load("html/listar_vagas.html", function(){
			$('#ordenar option[value='+ ordenar +']').attr('selected','selected');
			$('#msg').hide();
		});
		carregar(ordenar);
	}

	$("#principal #conteudo").on("click", ".remover-vaga", function(){
		if(confirm("Tem certeza que deseja excluir esta vaga?")) {
			var vagaId = $(this).parents("tr").attr("vaga-id");
			$.post("php/removerVaga.php", {vagaId : vagaId}, function() {
				alert("Vaga excluída com sucesso!");
				//$("#principal #conteudo").load("html/listar_vagas.html");
				exibePag($("#ordenar").val());
			});
		}
	});

	$("#principal #conteudo").on("click", "#atualizar-disponiveis", function(){
		var disponiveis = $(this).parents("td").siblings().find("input").val(),
			vagaId = $(this).parents("tr").attr("vaga-id");
		$.post("php/atualizarDisponiveis.php", {vagaId : vagaId, disponiveis : disponiveis}, function() {
			alert("Vaga atualizada com sucesso!");
			//$("#principal #conteudo").load("html/listar_vagas.html");
			exibePag($("#ordenar").val());
		});
	});

	$("#principal #conteudo").on("click", "#ordenar-tab", function(){
		ordenar = $("#ordenar").val();
		exibePag(ordenar);
	});

});