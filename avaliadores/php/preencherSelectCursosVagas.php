<?php
	
	session_start();
	
	if(!isset($_SESSION['avaliadorId'])) {
		die("Requisição Inválida.");
	}

	require_once 'config/GeralConfig.class.php';
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$evento_id = GeralConfig::getEventoId();

	$sql = "SELECT DISTINCT c.id, c.nome FROM cursos c
			INNER JOIN vaga v ON (v.curso_id=c.id AND v.evento_id = '".$evento_id."' AND v.disponiveis>0)
			WHERE state = 0 ORDER BY c.nome;";

	$cursos = $db->executarConsulta($sql);

	echo json_encode($cursos);

?>