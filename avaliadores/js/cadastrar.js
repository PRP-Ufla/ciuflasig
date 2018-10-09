$(function(){

	$('#principal #conteudo').off('click', '#cadastrar');

	// Função para escolher o departamento através de um select
	
	$.post("php/preencherSelectDepartamento.php", function(departamentos){
		departamentos = JSON.parse(departamentos);
		var $option = $("<option />");
		$("#departamento").append($option);
		$.each(departamentos, function(index, departamento){
			$option = $("<option />");
			$option.attr("value", departamento.id);
			$option.append(departamento.nome);
			$("#departamento").append($option);
		});
		
	});

	// FIM

	$('#principal #conteudo').on('click', '#cadastrar', function(){
		var nome = $('#nome').val(),
			email = $('#email').val(),
			senha = $('#senha').val(),
			senha2 = $('#senha2').val(),
			departamento = $("#departamento").val(),
			telefone = $('#telefone').val()
			cpf = $('#cpf').val();

		if(senha != senha2) {
			alert("As senhas digitadas nos campos estao diferentes!");
			return false;
		}
		
		if (cpf != "" && (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" ||
		  cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" ||
		  cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")){
		
			alert("CPF Invalido");
			return false;
		}
		
		else {
		
			soma = 0;
 
			for (i = 1; i <= 9; i++) {
			soma += Math.floor(cpf.charAt(i-1)) * (11 - i);
			}
			
			resto = 11 - (soma - (Math.floor(soma / 11) * 11));
				 
			if ( (resto == 10) || (resto == 11) ) {
			resto = 0;
			}
				 
			if ( resto != Math.floor(cpf.charAt(9)) ) {
			alert ("CPF Invalido");
			return false;
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
			alert ("CPF Invalido");
			return false;
			}
			
			
			if(nome != "" && email != "" && senha != "" && senha2 != "" && telefone != "" && departamento != "" && cpf != "") {
				$.post('php/cadastrar.php', {nome : nome, email : email, senha : senha, telefone : telefone, departamento : departamento, cpf : cpf}, function(resposta){
					if(resposta == "") {
						$('#nome').val("");
						$('#email').val("");
						$('#senha').val("");
						$('#senha2').val("");
						$('#departamento').val("");
						$('#telefone').val("");
						$('#cpf').val("");
						alert("Avaliador cadastrado com sucesso!");
						
						//Essa funcão pode ser apagada, apenas direciona pra pagina de login do usuario
						$("#principal #conteudo").load("index.html");

						return true;
					} else {
						alert("Ja existe um avaliador com este e-mail!");
						return false;
					}
				});
			} else {
				alert("Preencha todos os campos!");
				return false;
			}
		}

	});

});