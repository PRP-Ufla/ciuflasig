<?php
	
	session_start();
	
	if(!isset($_SESSION['usuario']) || !isset($_POST['areaId'])) {
		die("Requisição Inválida.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$areaId = $_POST['areaId'];

	$procurarResumoPorAreaSQL = 'SELECT resumos.* FROM resumos INNER JOIN eventos ON resumos.eventos_id=eventos.id WHERE cursos_id ='.$areaId.' AND  CURDATE() > eventos.termino_submissao AND CURDATE() < eventos.termino ';

	$resumos = $db->executarConsulta($procurarResumoPorAreaSQL);

	echo json_encode($resumos);	

?>