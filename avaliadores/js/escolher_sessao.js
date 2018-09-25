$(function(){
	
	$("#principal #conteudo").off("click", "#avaliar");
	
	$("#principal #conteudo").on("click", "#avaliar", function(){
	
		alert("N�o � poss�vel a altera��o da avalia��o de sess�es/cursos posteriormente.");
		if(confirm("Voc� tem certeza que deseja avaliar este resumo?")) {
			var vagaId = $(this).parents("tr").attr("vaga-id");
			$.post("php/avaliarResumo.php", {vagaId : vagaId}, function(resposta) {
				if (resposta == "0") {
					alert("SESS�O INDISPON�VEL! Por favor, escolha outra sess�o. N�o h� mais vagas dispon�veis na sess�o escolhida.");
					return false;
				}
				else if (resposta == "1") {
					alert("Avaliador(a), voc� j� escolheu uma vaga nesta sess�o. Por favor, escolha outra sess�o.");
					return false;
				} else {
					console.log(resposta);
					$("#principal #conteudo").load("html/principal.html");
				}
			});
		}
	});
});