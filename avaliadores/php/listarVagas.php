<?php
		
	session_start();
	
	if(!isset($_SESSION['avaliadorId']) || !isset($_SESSION['permissao'])) {
		die("Requisição Inválida.");
	}

	if($_SESSION['permissao'] == 0) {
		die("Você não tem permissão necessária.");
	}

	require_once 'config/GeralConfig.class.php';
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$evento_id = GeralConfig::getEventoId();

	$procurarVagasSQL = 'SELECT v.id, v.sessao_id, c.nome as cursoNome, s.horario, v.disponiveis 
								FROM vaga v
								INNER JOIN sessoes s
								ON (s.id = v.sessao_id AND s.eventos_id = "'.$evento_id.'")
								INNER JOIN cursos c
								on (c.id = v.curso_id)
								WHERE v.evento_id =  "'.$evento_id.'"
								ORDER BY v.sessao_id;';

	$vagas = $db->executarConsulta($procurarVagasSQL);

	echo json_encode($vagas);

?>