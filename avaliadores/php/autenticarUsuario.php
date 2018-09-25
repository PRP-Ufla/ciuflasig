<?php
	
	session_start();
	
	if(!isset($_POST['email']) || !isset($_POST['senha'])) {
		die("Requisição Inválida.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$email = addslashes($_POST['email']);
	$senha = addslashes($_POST['senha']);

	$autenticarUsuarioSQL = 'SELECT * FROM avaliador WHERE email = "'.$email.'" AND senha = "'.sha1($senha).'";';

	$avaliador = $db->executarConsulta($autenticarUsuarioSQL);

	if(!count($avaliador)) {
		$resposta = array("autenticado"=>"nao");
		echo json_encode($resposta);
	} else {
		$resposta = array("autenticado"=>"sim");
		$_SESSION['avaliadorId'] = $avaliador[0]['id'];
		$_SESSION['permissao'] = $avaliador[0]['permissao'];
		$resposta['permissao'] = $avaliador[0]['permissao'];
		echo json_encode($resposta);
	}

?>