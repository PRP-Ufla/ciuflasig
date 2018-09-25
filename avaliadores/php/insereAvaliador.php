<?php


	require_once 'config/GeralConfig.class.php';
	$evento_id = GeralConfig::getEventoId();
	
	@include("db/class_database.php");
	$db = new Database();
	$dados = mysql_query('	SELECT r.sessoes_id, r.cursos_id, r.num_resumos, a.num_avaliadores, a.avaliadores_id, r.resumos_id, r.nomes_1autor, v.disponiveis, 
								FLOOR(r.num_resumos/(a.num_avaliadores+v.disponiveis)) resumos_por_avaliador, 
								(r.num_resumos % (a.num_avaliadores+v.disponiveis)) resumos_resto, r.eventos_id
								
								FROM 

								/* (r) e uma sub-seleção que conta a quantidade de resumos*/

								(SELECT re.sessoes_id, re.cursos_id, re.eventos_id, GROUP_CONCAT(id) resumos_id, GROUP_CONCAT(re.autor1) nomes_1autor, COUNT( * ) num_resumos

								FROM  

								/* sub-seleção para ordenar os resumos por evento, sessao e nome do 1 autor*/
								(SELECT * FROM resumos ORDER BY sessoes_id,cursos_id,autor1)re 

								WHERE re.eventos_id ="'.$evento_id.'"
								GROUP BY re.sessoes_id, re.cursos_id, re.eventos_id
								ORDER BY  re.sessoes_id,re.cursos_id,re.autor1
								)r

								LEFT JOIN 

								/* (a) é uma sub-seleção que conta a quantidade de avaliadores*/(

								SELECT sessao_id, curso_id, evento_id, GROUP_CONCAT(avaliador_id) avaliadores_id,  COUNT( * ) num_avaliadores
								FROM vaga
								INNER JOIN avaliacoes ON vaga.id = vaga_id
								WHERE evento_id = "'.$evento_id.'"
								GROUP BY sessao_id, curso_id
								ORDER BY sessao_id
								)a 

								ON ( r.sessoes_id = a.sessao_id
								AND r.cursos_id = a.curso_id
								AND r.eventos_id = a.evento_id ) 

								/* Junção para pegar vagas remanescentes(Sem Avaliador)*/

								LEFT JOIN vaga v ON ( r.sessoes_id = v.sessao_id
								AND r.cursos_id = v.curso_id
								AND r.eventos_id = v.evento_id )  ');

	
	
	
	//Pegando dados da busca

		$avaliadoresId = array();
		$numAvaliadores = array();
		$numResumos = array();
		$resumosId = array();
		$resumos_por_avaliador = array();
		$resto = array();
		
		while( $linhas = mysql_fetch_array($dados) ) 
		{ 
		array_push($avaliadoresId, $linhas['avaliadores_id']); 
		array_push($numAvaliadores, $linhas['num_avaliadores']);
		array_push($numResumos, $linhas['num_resumos']);
		array_push($resumosId, $linhas['resumos_id']); 
		array_push($resumos_por_avaliador, $linhas['resumos_por_avaliador']); 
		array_push($resto, $linhas['resumos_resto']); 
		
		}
		//print_r($resumosId);

	/*
	1°Quebrar as vírgulas no explode e ordenar o avaliadores_id
	2ºQubrar as vírgulas nos resumos_id
	3°Verificar se tem resto a Divisão de resumos por avaliador
	4ºUPDATE no campo id_avaliador na tabela resumos
	5°COUNT apanas para pegar o numero de linhas para o FOR( o -1 para o vetor iniciando no 0)
	*/
	$conta = 0;
	$alterarAvaliador = '';
	for($i = 0; $i < COUNT($resumosId); $i++){
	
		$avaliadoresid = explode(",", $avaliadoresId[$i]);
		sort($avaliadoresid);
		
		$resumosid = explode(",", $resumosId[$i]);
		$contador = 0;	
		$restob = $resto[$i];
		
			if($numAvaliadores[$i] != ''){
			for($x = 0; $x < $numAvaliadores[$i]; $x++ ){
			
				if($restob != 0){
					
					for($y = 0; $y <= $resumos_por_avaliador[$i];  $y++ ){
								$alterarAvaliador = "UPDATE resumos SET id_avaliador = '".$avaliadoresid[$x]."' WHERE id = '".$resumosid[$contador]."';";
								if (!$db->executar($alterarAvaliador)) echo "errado";
								$conta++;
							$contador++;
						}
						
					$restob--;
					
				}
				else{
						
						for($w = 0; $w < $resumos_por_avaliador[$i]; $w++ ){
							$alterarAvaliador = "UPDATE resumos SET id_avaliador = '".$avaliadoresid[$x]."' WHERE id = '".$resumosid[$contador]."';";
							if (!$db->executar($alterarAvaliador)) echo "errado";
							$conta++;
						$contador++;
						}
					
					
				}
			}
		}
	}
	
	//echo $alterarAvaliador;

	
	echo $conta;
		
?>