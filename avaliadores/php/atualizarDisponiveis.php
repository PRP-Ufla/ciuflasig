<?php

	session_start();
	
	if(!isset($_SESSION['avaliadorId']) || !isset($_SESSION['permissao']) || !isset($_POST['disponiveis'])
		|| !isset($_POST['vagaId'])) {
		die("Requisição Inválida.");
	}

	if($_SESSION['permissao'] == 0) {
		die("Você não tem permissão necessária.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$vagaId = $_POST['vagaId'];
	$disponiveis = $_POST['disponiveis'];

	$atualizarDisponiveisSQL = "UPDATE `vaga` SET `disponiveis` = '".$disponiveis."' WHERE `id` = '".$vagaId."';";

	if(!$db->executar($atualizarDisponiveisSQL)) {
		die("ERRO, SQL: ".$atualizarDisponiveisSQL);
	}

?>