$(function(){

	var preencherSelectCurso = function() {
		$.getJSON("php/retornarCursos.php", function(cursos){
			$.each(cursos, function(i, value){
			 	$("#cursos").append("<option id="+value.id+">"+value.nome+"</option>")
			});
		});
	};

	preencherSelectCurso();

	$("#principal #conteudo").on("click", "#avancar", function(){
		if($("#cursos").val() != "") {
			var areaId = $("#cursos").find("option:selected").attr("id");
			$("#principal #conteudo").load("html/resumos.html", function() {
				$("#principal #conteudo").off("click", "#avancar");
				$("#resumos").attr("curso-id", areaId);
				requisitarResumos();
			});
		} else {
			alert("Selecione um curso a ser avaliado.");
		}
	});

});