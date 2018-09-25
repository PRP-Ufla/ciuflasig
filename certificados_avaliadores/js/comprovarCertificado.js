/*$(function(){

	$("#principal").on("click", "#comprovar", function(){
		var protocolo = $("#protocolo").val();
		if(protocolo != "") {
			$.post("php/comprovarCertificado.php", {protocolo : protocolo}, function(resposta){
				if(resposta == "0") {
					$("#principal #resposta").html("Autenticidade do certificado não comprovada.");
				} else {
					$("#principal #conteudo").load("html/certificado_info.html", function() {
						resposta = JSON.parse(resposta);
						resposta = resposta[0];
						$("#protocolo").html(resposta.protocolo);
						$("#primeiro-autor").html(resposta.nome);
						$("#edicao").html(resposta.edicao);
						var data = resposta.data_geracao.split("-");
						data = data[2]+"-"+data[1]+"-"+data[0];
						$("#data-geracao").html(data);
					});
				}
			});
		} else {
			$("#principal #resposta").html("Preencha o campo Protocolo.");
		}
	});

});*/

$(function(){

	$("#principal").on("click", "#comprovar", function(){
		var protocolo = $("#protocolo").val();
		if(protocolo != "") {
					$.post("php/comprovarCertificado.php", {protocolo : protocolo}, function(resposta){
						if(resposta == "0") {
							$("#principal #resposta").html("Autenticidade do certificado não comprovada.");
						} else {
						resposta0 = JSON.parse(resposta);
						resposta0 = resposta0[0];
						evento_id = resposta0.evento_id;
						$.post("php/pegandotitulos.php?evento_id="+evento_id, {protocolo : protocolo}, function(titulospegando){
						if(titulospegando != "0"){
								$("#principal #conteudo").load("html/certificado_info.html", function() {
									resposta = JSON.parse(resposta);
									resposta = resposta[0];
									$("#protocolo").html(resposta.protocolo);
									$("#avaliador").html(resposta.nome);
									titulospegando = JSON.parse(titulospegando);
									
										for(i=0;i<titulospegando.length;i++){
										$("#titulo-resumo").append((i+1)+" - "+titulospegando[i].titulo+"</br>"+"</br>");
										}
									$("#ciufla-edicao").html(resposta.edicao);
									var data = resposta.data_geracao.split("-");
									data = data[2]+"-"+data[1]+"-"+data[0];
									$("#data-geracao").html(data);
								});
							}else{
							$.post("php/avaliadorsemtitulosevento6.php", {protocolo : protocolo}, function(dados){
							$("#principal #conteudo").load("html/certificado_infoEvento6.html", function() {
									resposta = JSON.parse(dados);
									resposta = resposta[0];
									$("#protocolo").html(resposta.protocolo);
									$("#avaliador").html(resposta.nome);
									$("#ciufla-edicao").html(resposta.edicao);
									var data = resposta.data_geracao.split("-");
									data = data[2]+"-"+data[1]+"-"+data[0];
									$("#data-geracao").html(data);
								});
							});
							}
						});
						}
					});
	} else {
		$("#principal #resposta").html("Preencha o campo Protocolo.");
	}
});
});