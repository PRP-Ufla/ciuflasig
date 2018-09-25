$(function(){
	
	$("#principal #conteudo").off("click", "#avaliar");
	
	$("#principal #conteudo").on("click", "#avaliar", function(){
	
		alert("Não é possível a alteração da avaliação de sessões/cursos posteriormente.");
		if(confirm("Você tem certeza que deseja avaliar este resumo?")) {
			var vagaId = $(this).parents("tr").attr("vaga-id");
			$.post("php/avaliarResumo.php", {vagaId : vagaId}, function(resposta) {
				if (resposta == "0") {
					alert("SESSÃO INDISPONÍVEL! Por favor, escolha outra sessão. Não há mais vagas disponíveis na sessão escolhida.");
					return false;
				}
				else if (resposta == "1") {
					alert("Avaliador(a), você já escolheu uma vaga nesta sessão. Por favor, escolha outra sessão.");
					return false;
				} else {
					console.log(resposta);
					$("#principal #conteudo").load("html/principal.html");
				}
			});
		}
	});
});