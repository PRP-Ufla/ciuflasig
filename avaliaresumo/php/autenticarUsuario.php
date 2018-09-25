<?php

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$usuario = addslashes($_POST['usuario']);
	$senha = addslashes($_POST['senha']);

	$autenticarUsuarioSQL = 'SELECT * FROM usuarios WHERE nome = "'.$usuario.'" AND senha = "'.sha1($senha).'" AND cursos_id = "0" AND bic_jr = "0";';

	$usuario = $db->executarConsulta($autenticarUsuarioSQL);

	if(!count($usuario)) {
		$resposta = array("autenticado"=>"nao");
		echo json_encode($resposta);
	} else {
		$resposta = array("autenticado"=>"sim");
		session_start();
		$_SESSION['usuario'] = $usuario;
		echo json_encode($resposta);
	}

?>