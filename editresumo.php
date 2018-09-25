<?php
	include("static/basicheaders.php");
	include("static/lock_user.php");
	include("php/class_database.php");
	if (!isset($_SESSION['eid']))
		die("Requisicao Invalida!");
	$eid = $_SESSION['eid'];
	if (!isset($_POST['autor1']))
		die("Requisicao Invalida!");
	$db = new Database();
	$sql = "SELECT * FROM usuarios WHERE ".
		"eventos_id='".$_SESSION['eid']."' AND ".
		"email='".strtoupper(trim($_SESSION['email']))."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Autor Invalida!");
	$user = $res[0];
	$uid = $user['id'];
	$palchaves = $_POST['pal1']."|||".$_POST['pal2']."|||".$_POST['pal3'];
	$sql = "UPDATE resumos SET ".
		"cursos_id='".addslashes($_POST['area'])."',".
		"titulo='".addslashes($_POST['titulo'])."',".
		"palavras_chave='".addslashes($palchaves)."',".
		"fomento='".addslashes($_POST['fomento'])."',".
		"resumo='".addslashes($_POST['resumo'])."',".
		"autor1='".addslashes($_POST['autor1'])."',".
		"autor2='".addslashes($_POST['autor2'])."',".
		"autor3='".addslashes($_POST['autor3'])."',".
		"autor4='".addslashes($_POST['autor4'])."',".
		"autor5='".addslashes($_POST['autor5'])."',".
		"autor6='".addslashes($_POST['autor6'])."',".
		"info_autor1='".addslashes($_POST['infoautor1'])."',".
		"info_autor2='".addslashes($_POST['infoautor2'])."',".
		"info_autor3='".addslashes($_POST['infoautor3'])."',".
		"info_autor4='".addslashes($_POST['infoautor4'])."',".
		"info_autor5='".addslashes($_POST['infoautor5'])."',".
		"info_autor6='".addslashes($_POST['infoautor6'])."',".
		"departamento='".addslashes($_POST['dpto'])."',".
		"autor_orientador='".addslashes($_POST['autor_orientador'])."',".
		"local_pesquisa='".addslashes($_POST['local_pesquisa'])."'".
		" WHERE id='".addslashes($_POST['rid'])."';";
	if (!$db->executar($sql))
		die("SQL Invalido!<br />".$sql);
	
	header("Location: user.php");
?>