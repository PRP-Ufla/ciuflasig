/*
 * Validação dos campos do formulário.
*/

function checkFields() {
	var msg = "";
	var senha = 0;
	try {
		if (document.getElementById("nome").value == "") {
			msg = msg + "- Nome\n";
		}
		
		if (document.getElementById("email").value == "") {
			msg = msg + "- E-mail\n";
		}
		
		if (document.getElementById("senha").value == "") {
			msg = msg + "- Senha\n";
		}
		
		if (document.getElementById("senha2").value == "") {
			msg = msg + "- Confirmar Senha\n";
		}
		
		//if (document.getElementById("bic_jr").value == "2") {
		//	msg = msg + "- Você é aluno BIC Junior(Ensino Médio)?\n";
		//}
		
		if (document.getElementById("mat").value == "" && document.getElementById("bic_jr").value != "1") {
			msg = msg + "- Matrícula\n";
		}
		
		if (document.getElementById("cpf").value == "") {
				msg = msg + "- CPF\n";
		}else{
		
		var cpf = document.getElementById("cpf").value; 
		
		if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" ||
		  cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" ||
		  cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999"){
		
			msg = msg + "- CPF Inválido\n";
			
		 }else{
				soma = 0;
 
				 for (i = 1; i <= 9; i++) {
				 soma += Math.floor(cpf.charAt(i-1)) * (11 - i);
				 }
				 
				 resto = 11 - (soma - (Math.floor(soma / 11) * 11));
				 
				 if ( (resto == 10) || (resto == 11) ) {
				 resto = 0;
				 }
				 
				 if ( resto != Math.floor(cpf.charAt(9)) ) {
				msg = msg + "- CPF Inválido\n";
				 }
				 
				 soma = 0;
				 
				 for (i = 1; i<=10; i++) {
				 soma += cpf.charAt(i-1) * (12 - i);
				 }
				 
				 resto = 11 - (soma - (Math.floor(soma / 11) * 11));
				 
				 if ( (resto == 10) || (resto == 11) ) {
				 resto = 0;
				 }
				 
				 if (resto != Math.floor(cpf.charAt(10)) ) {
				msg = msg + "- CPF Inválido\n";
				 }
			
			
		}
				
		
		}
			
		if (document.getElementById("ddd").value == "") {
			msg = msg + "- Telefone (DDD)\n";
		}
		
		if (document.getElementById("tel").value == "") {
			msg = msg + "- Telefone\n";
		}
		
		if (!($("#inst1").prop("checked") || ($("#inst2").prop("checked") && $("#escola").val() != "2")  || $("#inst3").prop("checked"))) {
			msg = msg + "- Instituição\n";
		}
		
		if (document.getElementById("curso").value == "0") {
			msg = msg + "- Curso\n";
		}
		
		if (document.getElementById("senha").value != document.getElementById("senha2").value) {
			msg = msg + "- Os campos (Senha de Acesso) e (Confirmar Senha) não possuem o mesmo conteúdo\n";
			senha = 1;
		}

	} catch (err) {
	}
	
	if (msg != "") {
		alert("Os seguintes campos são obrigatórios ou foram preenchidos incorretamente:\n\n"+
			msg);
		return false;
	} else
		return true;
}

/* Por: Sérgio A. Rodrigues(8) - 17/07/2013
 * Evento "change" da página da Ficha de Inscrição, conforme a seleção do usuário no campo de id bic_jr,
 * campos são mudados.
 */
$(function(){
	$("#bic_jr").on("change", function(){
		if ($("#bic_jr").val() == 1) {
			$("#curso").prop("disabled", "true");
			$("#mat").prop("disabled", "true");
			$("#mat").val("");
			$("#curso").val(6);
			$("#curso").prop("disabled", "true");
			$("#inst1").prop("disabled", "true");
			$("#inst2").removeAttr("disabled");
			$("#inst2").prop("checked", "true");
			$("#inst3").prop("disabled", "true");
			$("#escola").removeAttr("disabled");
		} else if($("#bic_jr").val() == 0 || $("#bic_jr").val() == 3) {
			$("#curso").removeAttr("disabled");
			$("#mat").removeAttr("disabled");
			$("#mat").val("");
			$("#curso").val("0");
			$("#inst1").removeAttr("disabled");
			$("#inst2").prop("disabled", "true");
			$("#inst3").removeAttr("disabled");
			$("#escola").prop("disabled", "true");
			$("#escola").val("2");
		} else {
			$("#mat").prop("disabled", "true");
			$("#mat").val("");
			$(".inst").removeAttr("checked");
			$(".inst").prop("disabled", "true");
			$("#escola").prop("disabled", "true");
			$("#outrasInsts").prop("disabled", "true");
			$("#curso").val("0");
			$("#curso").prop("disabled", "true");
		}
	});
	
	$(".inst").on("change", function(){
		if (this.value == 3) {
			$("#outrasInsts").removeAttr("disabled");
		} else {
			if ($("#outrasInsts").attr("disabled") == undefined) {
				$("#outrasInsts").prop("disabled", "true");
			}
		}
	});
});