<?php
	session_start();

	require_once 'db/DBUtils.class.php';
	require_once 'config/GeralConfig.class.php';

	$db = new DBUtils();
	$eventoId = GeralConfig::getEventoId();

	$sql = 'SELECT aux.eventos_id, aux.sessoes_id, aux.cursos_id, SUM(aux.resumos) AS resumos
			FROM aux_sessoes aux 
			WHERE aux.eventos_id = '.$eventoId.'
			GROUP BY aux.eventos_id, aux.sessoes_id, aux.cursos_id;';
	$sessoes = $db->executarConsulta($sql);

	$qnt_sessoes = count($sessoes);

	//Distribuindo as vagas de acordo com a quantidade de resumos

	for ($i=0; $i < $qnt_sessoes; $i++) {
		$qnt_resumos = $sessoes[$i][3];
		if($qnt_resumos < 15){
			//função round  arredonda o numero para o inteiro mais próximo
			$vagas = round($qnt_resumos / 6);

			//Verifica se ao arredondar o número ficou igual a zero
			if($vagas == 0) $vagas++;
			$sessoes[$i][4] = $vagas;
		}
		else{
			$sessoes[$i][4] = round($qnt_resumos / 7);
		}
	}

	for ($i=0; $i < $qnt_sessoes; $i++) {
		
		/* 
		- $sessoes[$i][0] = Id do Evento
		- $sessoes[$i][1] = Id da sessão
		- $sessoes[$i][2] = Id do curso
		- $sessoes[$i][4] = vagas disponiveis (calculadas no for das linhas 19 à 32)
		*/

		$sql = 'INSERT INTO vaga(sessao_id,curso_id,disponiveis,evento_id)
				VALUES ("'.$sessoes[$i][1].'","'.$sessoes[$i][2].'","'.$sessoes[$i][4].'","'.$sessoes[$i][0].'");';

		$inserir = $db->executar($sql);

		if(!$inserir){
			die("Erro ao inserir");
		}
	}
	if($inserir) echo "Vagas criadas com sucesso.";
?>