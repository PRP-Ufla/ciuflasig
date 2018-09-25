<?php
	
	session_start();
	
	if(!isset($_SESSION['avaliadorId']) && !isset($_POST['cursoId'])) {
		die("Requisição Inválida.");
	}

	require_once 'config/GeralConfig.class.php';
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$cursoId = $_POST['cursoId'];
	$evento_id = GeralConfig::getEventoId();

	$procurarVagasSQL = 'SELECT v.*, s.horario, c.nome FROM vaga v 
						INNER JOIN sessoes s
						ON (s.id = v.sessao_id AND s.eventos_id = "'.$evento_id.'" 
						AND v.curso_id = "'.$cursoId.'")
						INNER JOIN cursos c
						on (c.id = v.curso_id)
						WHERE v.evento_id = "'.$evento_id.'"';

	$vagas = $db->executarConsulta($procurarVagasSQL);

	echo json_encode($vagas);

?>