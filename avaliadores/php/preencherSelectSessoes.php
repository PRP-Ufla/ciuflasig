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

	//Editar este número, conforme o id do evento atual do CIUFLA.
	$evento_id = GeralConfig::getEventoId();

	$sql = "SELECT id FROM sessoes WHERE eventos_id = '".$evento_id."';";

	$sessoes = $db->executarConsulta($sql);
	
	echo json_encode($sessoes);

?>