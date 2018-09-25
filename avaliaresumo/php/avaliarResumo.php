<?php

	session_start();
	
	if(!isset($_SESSION['usuario']) || !isset($_POST['status']) || !isset($_POST['resumoId'])) {
		die("Requisiчуo Invсlida.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$status = $_POST['status'];
	$resumoId = $_POST['resumoId'];

	if($status == 1) {

		$alterarStatusResumoSQL = 'UPDATE resumos SET status_avaliacao = 1 WHERE id = '.$resumoId.';';
		$db->executar($alterarStatusResumoSQL);

	} else if($status == 2) {

		$parecer = utf8_decode($_POST['parecer']);

		$alterarStatusResumoSQL = 'UPDATE resumos SET status_avaliacao = 2, parecer_avaliacao = "'.addslashes($parecer).'" WHERE id = '.$resumoId.';';
		$db->executar($alterarStatusResumoSQL);

	}

?>