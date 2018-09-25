<?php
	
	session_start();

	if(!isset($_SESSION['usuario']) || !isset($_POST['resumoId']) || !isset($_POST['areaId'])) {
		die("Requisiчуo Invсlida.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$resumoId = $_POST['resumoId'];
	$areaId = $_POST['areaId'];

	$procurarResumoPorAreaSQL = 'SELECT * FROM resumos WHERE id = '.$resumoId.';';

	$resumos = $db->executarConsulta($procurarResumoPorAreaSQL);

	echo json_encode($resumos);	

?>