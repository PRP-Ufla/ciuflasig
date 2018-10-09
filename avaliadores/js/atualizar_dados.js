$(function(){

    $('#principal #conteudo').off('click', '#atualizarDados');

    // Função para escolher o departamento através de um select
	$.post("php/preencherSelectDepartamento.php", function(departamentos){
		departamentos = JSON.parse(departamentos);
		var $option = $("<option />");
		// $option.append("Selecione um departamento...");
		$("#departamento").append($option);
		$.each(departamentos, function(index, departamento){
			$option = $("<option />");
			$option.attr("value", departamento.id);
			$option.append(departamento.nome);
			$("#departamento").append($option);
		});
		
	});

    // FIM
    
    function valida_cpf(cpf){
        if (cpf != "" && (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" ||
            cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" ||
            cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")){
        
            alert("CPF Invalido");
            return false;
        }

        else if (cpf == ""){
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
        }
    }

    function valida_departamento(departamento){
        if(departamento === ""){
            alert("Departamento Invalido");
            return false;
        }
    }

    $('#principal #conteudo').on('click', '#atualizarDados', function(){
        var departamento = $("#departamento").val(),
            cpf = $('#cpf').val(),
            protocolo = $('#protocolo-atualizar').val();

            // Se protocolo = 1 deve-se atualizar os dois valores
            // Se protocolo = 2 deve-se atualizar o departamento
            // Se protocolo = 3 deve-se atualizar o cpf


        if(protocolo === '1'){
            if(valida_cpf(cpf) != false && valida_departamento(departamento) != false){
                $.post('php/atualizar_dados.php', {departamento : departamento}, function(resposta){
                    $('departamento').val("");
                });
                $.post('php/atualizar_dados.php', {cpf : cpf}, function(resposta){
                    $('#cpf').val("");
                });
                $("#principal #conteudo").load("html/principal.html");
                $("#principal #cabecalho").load("html/menu_usuario2.html");
            }
        }
        else if(protocolo === '2'){
            if(valida_departamento(departamento) != false){
                $.post('php/atualizar_dados.php', {departamento : departamento}, function(resposta){
                    $('departamento').val("");
                });
                $("#principal #conteudo").load("html/principal.html");
                $("#principal #cabecalho").load("html/menu_usuario2.html");
            }
        }
        else if(protocolo === '3'){
            if(valida_cpf(cpf) != false){
                $.post('php/atualizar_dados.php', {cpf : cpf}, function(resposta){
                    $('#cpf').val("");
                });
                $("#principal #conteudo").load("html/principal.html");
                $("#principal #cabecalho").load("html/menu_usuario2.html");
            }
        }
        
    });
    
});