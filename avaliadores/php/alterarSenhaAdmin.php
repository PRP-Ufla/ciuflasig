<?php

	session_start();
	
	if(!isset($_SESSION['avaliadorId']) || !isset($_POST['novaSenha'])) {
		die("Requisição Inválida.");
	}

	if(empty($_POST['usuario']) || empty($_POST['novaSenha'])) {
		die("Alguns dos campos estão vazios.");
	}
	
	if($_SESSION['permissao'] == 0) {
		die("Você não tem permissão necessária.");
	}
	
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();
	
	$avaliadorId = $_POST['usuario'];
	$novaSenha = $_POST['novaSenha'];

	$procurarAvaliadorSQL = "SELECT * FROM `avaliador` WHERE `id` = '".$avaliadorId."';";

	if($db->executarConsulta($procurarAvaliadorSQL)) {
		$alterarSenhaSQL = "UPDATE `avaliador` SET `senha` = '".sha1($novaSenha).
								"' WHERE `id` = '".$avaliadorId."';";
		if(!$db->executar($alterarSenhaSQL)) {
			die("ERRO, SQL: ".$alterarSenhaSQL);
		}
		$resposta["status"] = 1;
		echo json_encode($resposta); 
	} else {
		$resposta["status"] = 0;
		echo json_encode($resposta); 
	}

?>