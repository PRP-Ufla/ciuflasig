<?php
	
	session_start();
	
	if(!isset($_SESSION['avaliadorId'])) {
		die("Requisição Inválida.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$sql = "SELECT id, nome FROM cursos WHERE state = 0 ORDER BY nome;";

	$cursos = $db->executarConsulta($sql);

	echo json_encode($cursos);

?>