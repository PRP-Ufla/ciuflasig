<?php
	include("../static/basicheaders.php");
	include("../static/lock_admin.php");
	include("../cfg/config_course_state.php");
	if ((!isset($_GET['id'])) ||
		(!isset($_GET['field'])) ||
		(!isset($_GET['value'])))
		 die("<alert>Requisicao Invalida.");
	include("class_database.php");
	$db = new Database();
	$sql = "UPDATE cursos SET ".
		$_GET['field']."='".$$_GET['value']."' WHERE ".
		"id='".$_GET['id']."';";
	if (!$db->executar($sql))
		die("<alert>SQL Invalido!<br />".$sql);
	echo "<done>";
?>