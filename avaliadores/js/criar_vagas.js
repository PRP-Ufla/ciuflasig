$(function(){
	$("#principal #conteudo").off("click", "#button-criar-vagas");

	$("#principal #conteudo").on("click", "#button-criar-vagas", function(){
		alert("Não é possível reverter esse processo posteriormente.");
		var answer = confirm("Tem certeza que deseja criar as vagas?")
		if(answer){
			$.post("php/criar_vagas.php", function(resposta) {
				alert(resposta);
				$("#principal #conteudo").load("html/principal.html");
			});
		}
	});
});