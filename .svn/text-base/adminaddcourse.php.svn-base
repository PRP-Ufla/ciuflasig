<?php
	@include("./static/basicheaders.php");
	@include("./static/lock_admin.php");
	@include("./php/class_database.php");
	if ((!isset($_POST['cursonome'])) ||
		(!isset($_POST['cursosigla'])))
			die("<alert>Requisicao Invalida!");
	$sql = "INSERT INTO cursos (id,nome,sigla) VALUES ".
		"(NULL,'".$_POST['cursonome']."','".$_POST['cursosigla']."');";
	$db = new Database();
	if (!$db->executar($sql))
		die("<alert>SQL Invalido!\n".$sql);
	
	header("Location: admincourses.php");
?>