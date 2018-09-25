var requisitarResumo = function(resumoId, areaId) {
	$.post("php/procurarResumoPorId.php", {resumoId:resumoId, areaId:areaId}, function(resumo) {
		resumo = JSON.parse(resumo);
		resumo = resumo[0];
		$("#resumo-div").attr("resumo-id", resumo.id);
		$("#resumo-div").attr("area-id", areaId);
		$("#titulo").val(resumo.titulo);
		var palavrasChaves = resumo.palavras_chave.split("|||");
		$("#palavras-chave1").val(palavrasChaves[0]);
		$("#palavras-chave2").val(palavrasChaves[1]);
		$("#palavras-chave3").val(palavrasChaves[2]);
		$("#fomento").val(resumo.fomento);
		$("#resumo").val(resumo.resumo);
		
		//$("#resumo_html").html($(resumo.resumo).text());
		$("#resumo_html").html(resumo.resumo);
		
		//$("#resumo_html *").removeAttr("style");
		//$("#resumo_html *").each(function(){
		//    $(this).removeClass($(this).attr("class"));
		//});


		//$("#resumo_html").children().removeAttr("style");
		//$("#resumo_html").children().children().removeAttr("style");
		//$("#resumo_html").children().children().children().removeAttr("style");
		//$("#resumo_html").children().children().children().children().removeAttr("style");
		//$("#resumo_html").children().removeClass();
		//$("#resumo_html").children().children().removeClass();
		//$("#resumo_html").children().children().children().removeClass();
		//$("#resumo_html").children().children().children().children().removeClass();
				
		if (resumo.autor_orientador == 'autor2') {
			var autorOrientador2 = " - Orientador(a)";
		} else {
			var autorOrientador2 = "";
		}
		
		if (resumo.autor_orientador == 'autor3') {
			var autorOrientador3 = " - Orientador(a)";
		} else {
			var autorOrientador3 = "";
		}
		
		if (resumo.autor_orientador == 'autor4') {
			var autorOrientador4 = " - Orientador(a)";
		} else {
			var autorOrientador4 = "";
		}
		
		if (resumo.autor_orientador == 'autor5') {
			var autorOrientador5 = " - Orientador(a)";
		} else {
			var autorOrientador5 = "";
		}
		
		if (resumo.autor_orientador == 'autor6') {
			var autorOrientador6 = " - Orientador(a)";
		} else {
			var autorOrientador6 = "";
		}
		
		$("#autor1").val(resumo.autor1);
		$("#info-autor1").val(resumo.info_autor1);
		$("#autor2").val(resumo.autor2 + autorOrientador2);
		$("#info-autor2").val(resumo.info_autor2);
		$("#autor3").val(resumo.autor3 + autorOrientador3);
		$("#info-autor3").val(resumo.info_autor3);
		$("#autor4").val(resumo.autor4 + autorOrientador4);
		$("#info-autor4").val(resumo.info_autor4);
		$("#autor5").val(resumo.autor5 + autorOrientador5);
		$("#info-autor5").val(resumo.info_autor5);
		$("#autor6").val(resumo.autor6 + autorOrientador6);
		$("#info-autor6").val(resumo.info_autor6);
		$("#status").val(resumo.status_avaliacao);
		$("#status").change();
		$("#parecer-avaliacao").val(resumo.parecer_avaliacao);
		
	});
};

$("#principal #conteudo").on("change", "#status", function() {
	if(this.value == 0 || this.value == 1) {
		$("#parecer").find("input").val("");
		$("#parecer").hide();
	} else if (this.value == 2) {
		$("#parecer").show();
	}
});

$("#principal #conteudo").on("click", "#avaliarResumo", function() {
	var resumoId = $("#resumo-div").attr("resumo-id");
	var areaId = $("#resumo-div").attr("area-id");
	var status = $("#status").val();
	if($("#status").val() == 0) {
		alert('Para avaliar o resumo, você deve selecionar um status.');
	} else if(status == 1) {
		$.post('php/avaliarResumo.php', {resumoId:resumoId,status:status}, function() {
			$("#principal #conteudo").load("html/resumos.html", function() {
				$("#principal #conteudo").off("click", "#status");
				$("#principal #conteudo").off("click", "#avaliarResumo");
				$("#principal #conteudo").off("click", "#voltar-resumos");
				$("#resumos").attr("curso-id", areaId);
				requisitarResumos();
			});
		});
	} else if(status == 2) {
		var parecer = $("#parecer-avaliacao").val();
		if(parecer == "") {
			alert('Como o pedido não foi aprovado, você deve escrever um parecer.');
		} else {
			$.post('php/avaliarResumo.php', {resumoId:resumoId,status:status, parecer:parecer}, function() {
				$("#principal #conteudo").load("html/resumos.html", function() {
					$("#principal #conteudo").off("click", "#status");
					$("#principal #conteudo").off("click", "#avaliarResumo");
					$("#principal #conteudo").off("click", "#voltar-resumos");
					$("#resumos").attr("curso-id", areaId);
					requisitarResumos();
				});
			});
		}
	}

});

$("#principal #conteudo").on("click", "#voltar-resumos", function() {
	var areaId = $("#resumo-div").attr("area-id");
	$("#principal #conteudo").load("html/resumos.html", function() {
		$("#principal #conteudo").off("click", "#status");
		$("#principal #conteudo").off("click", "#avaliarResumo");
		$("#principal #conteudo").off("click", "#voltar-resumos");
		$("#resumos").attr("curso-id", areaId);
		requisitarResumos();
	});
});