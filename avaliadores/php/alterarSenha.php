<?php

	session_start();
	
	if(!isset($_SESSION['avaliadorId']) || !isset($_POST['senhaAntiga']) 
		|| !isset($_POST['novaSenha'])) {
		die("Requisição Inválida.");
	}

	if(empty($_POST['senhaAntiga']) || empty($_POST['novaSenha'])) {
		die("Alguns dos campos estão vazios.");
	}
	
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();
	
	$avaliadorId = $_SESSION['avaliadorId'];
	$novaSenha = $_POST['novaSenha'];
	$senhaAntiga = $_POST['senhaAntiga'];

	$procurarAvaliadorSQL = "SELECT * FROM `avaliador` WHERE `id` = '".$avaliadorId."'
	 							AND `senha` = '".sha1($senhaAntiga)."';";

	if($db->executarConsulta($procurarAvaliadorSQL)) {
		$alterarSenhaSQL = "UPDATE `avaliador` SET `senha` = '".sha1($novaSenha).
								"' WHERE `id` = '".$avaliadorId."' AND `senha` = '".sha1($senhaAntiga)."';";
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