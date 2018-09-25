<?php

	session_start();
	
	if(!isset($_SESSION['avaliadorId']) || !isset($_SESSION['permissao']) || !isset($_POST['vagaId'])) {
		die("Requisição Inválida.");
	}

	if($_SESSION['permissao'] == 0) {
		die("Você não tem permissão necessária.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$vagaId = $_POST['vagaId'];

	$removerVagaSQL = "DELETE FROM `vaga` WHERE `id` = '".$vagaId."';";

	if(!$db->executar($removerVagaSQL)) {
		die("ERRO, SQL: ".$removerVagaSQL);
	}

	$removerAvaliacaoSQL = "DELETE FROM `avaliacoes` WHERE `vaga_id` = '".$vaga_id."';";

	if(!$db->executar($removerAvaliacaoSQL)){
		die("ERRO, SQL: ".$removerAvaliacaoSQL);
	}

?>