$(function(){
	
	var answer = confirm("Tem certeza que deseja gerar a distribuicao de avaliadores?")
		if (answer){
			$.post("php/distribuir_resumos.php", function(resposta){
			
				if(resposta == 1){
				
				alert("Sucesso na distribuicao");
				
				}else{
			
				alert("Falha na distribuicao, favor comunicar ao administrador");
				
					}
			});
		}

});