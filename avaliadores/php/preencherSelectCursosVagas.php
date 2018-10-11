<?php
	
	session_start();
	
	if(!isset($_SESSION['avaliadorId'])) {
		die("Requisição Inválida.");
	}

	require_once 'config/GeralConfig.class.php';
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$evento_id = GeralConfig::getEventoId();

	$avaliadorId = $_SESSION['avaliadorId'];

	//Consulta antiga que preenchia as vagas e permitia um avaliador avaliar mais de um resumo de 
	//uma mesma sessão
	
	// $sql = "SELECT DISTINCT c.id, c.nome FROM cursos c
	// 		INNER JOIN vaga v ON (v.curso_id=c.id AND v.evento_id = '".$evento_id."' AND v.disponiveis>0)
	// 		JOIN cursos_departamento cd ON (cd.id_curso = c.id)
	// 		WHERE state = 0 AND
	// 		cd.id_departamento = (SELECT a.departamento
	// 							  FROM avaliador a
	// 							  WHERE a.id = ".$avaliadorId.")
	// 		ORDER BY c.nome ";

	$sql = "SELECT DISTINCT c.id, c.nome 
			FROM avaliador a
			INNER JOIN cursos_departamento cd ON (cd.id_departamento = a.departamento)
			INNER JOIN cursos c ON (c.id = cd.id_curso)
			JOIN vaga v ON (v.curso_id=c.id AND v.evento_id = '".$evento_id."' AND v.disponiveis>0)
			WHERE state = 0 AND	a.id = ".$avaliadorId."
			ORDER BY c.nome ";

	$cursos = $db->executarConsulta($sql);
	echo json_encode($cursos);
?>