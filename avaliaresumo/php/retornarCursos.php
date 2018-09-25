<?php
	
	session_start();

	if(!isset($_SESSION['usuario'])) {
		die("Requisiчуo Invсlida.");
	}
	
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$procurarCursosSQL = 'SELECT id, nome FROM cursos WHERE state = 0 ORDER BY nome;';

	$cursos = $db->executarConsulta($procurarCursosSQL);

	echo json_encode($cursos);	

?>