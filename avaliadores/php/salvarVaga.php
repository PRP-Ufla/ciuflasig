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

	$sessao = $_POST['sessao'];
	$area = $_POST['area'];
	$vagas = $_POST['vagas'];

	$evento_id = GeralConfig::getEventoId();

	$sql = "INSERT INTO vaga (sessao_id, curso_id, disponiveis, evento_id) 
			VALUES ('".$sessao."', '".$area."', '".$vagas."', '".$evento_id."');";

	$res = $db->executar($sql);

	if(!$res) {
		echo $sql;
	}

?>