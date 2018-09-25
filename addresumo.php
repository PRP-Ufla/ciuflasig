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
		die("Autor Invalido!");
	$user = $res[0];
	$uid = $user['id'];
	$sql = "SELECT * FROM eventos WHERE ".
		"id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Evento Invalida!");
	$evento = $res[0];
	$sql = "SELECT * FROM resumos WHERE ".
		"eventos_id='".$eid."' AND ".
		"usuarios_id='".$uid."';";
	$res = $db->consulta($sql);
	$resumos = $evento['resumos']-count($res);
	if ($resumos <= 0)
		die("Este usuario nao pode submeter mais nenhum resumo".
			" para este evento!");
	$palchaves = $_POST['pal1']."|||".$_POST['pal2']."|||".$_POST['pal3'];
//	$sql ='INSERT INTO `resumos`(`id`, `eventos_id`, `usuarios_id`, `cursos_id`, `status_selecao`, `resumo`, `titulo`, `palavras_chave`, `fomento`, `autor1`, `autor2`, `autor3`, `autor4`, `autor5`, `autor6`, `info_autor1`, `info_autor2`, `info_autor3`, `info_autor4`, `info_autor5`, `info_autor6`) VALUES (NULL, "'.$eid.'", "'.$uid.'", "'.$_POST['area'].'", 0, "'.$_POST['resumo'].'", "'.$_POST['titulo'].'", "'.$palchaves.'", "'.$_POST['fomento'].'", "'.$_POST['autor1'].'","'.$_POST['autor2'].'", "'.$_POST['autor3'].'", "'.$_POST['autor4'].'", "'.$_POST['autor5'].'", "'.$_POST['autor6'].'", "'.$_POST['infoautor1'].'", "'.$_POST['infoautor2'].'", "'.$_POST['infoautor3'].'", "'.$_POST['infoautor4'].'", "'.$_POST['infoautor5'].'", "'.$_POST['infoautor6'].'");';
//	$sql ="INSERT INTO `resumos`(`id`, `eventos_id`, `usuarios_id`, `cursos_id`, `status_selecao`, `resumo`, `titulo`, `palavras_chave`, `fomento`, `autor1`, `autor2`, `autor3`, `autor4`, `autor5`, `autor6`, `info_autor1`, `info_autor2`, `info_autor3`, `info_autor4`, `info_autor5`, `info_autor6`) VALUES (NULL, '".$eid."', '".$uid."', '".$_POST['area']."', 0, '".$_POST['resumo']."', '".$_POST['titulo']."', '".$palchaves."', '".$_POST['fomento']."', '".$_POST['autor1']."','".$_POST['autor2']."', '".$_POST['autor3']."', '".$_POST['autor4']."', '".$_POST['autor5']."', '".$_POST['autor6']."', '".$_POST['infoautor1']."', '".$_POST['infoautor2']."', '".$_POST['infoautor3']."', '".$_POST['infoautor4']."', '".$_POST['infoautor5']."', '".$_POST['infoautor6']."')";
//	$sql ="INSERT INTO `resumos`(`id`, `eventos_id`, `usuarios_id`, `cursos_id`, `status_selecao`, `resumo`, `titulo`, `palavras_chave`, `fomento`, `autor1`, `autor2`, `autor3`, `autor4`, `autor5`, `autor6`, `info_autor1`, `info_autor2`, `info_autor3`, `info_autor4`, `info_autor5`, `info_autor6`) VALUES (NULL, '".$eid."', '".$uid."', '".addslashes($_POST['area'])."', 0, '".addslashes($_POST['resumo'])."', '".addslashes($_POST['titulo'])."', '".addslashes($palchaves)."', '".addslashes($_POST['fomento'])."', '".addslashes($_POST['autor1'])."','".addslashes($_POST['autor2'])."', '".addslashes($_POST['autor3'])."', '".addslashes($_POST['autor4'])."', '".addslashes($_POST['autor5'])."', '".addslashes($_POST['autor6'])."', '".addslashes($_POST['infoautor1'])."', '".addslashes($_POST['infoautor2'])."', '".addslashes($_POST['infoautor3'])."', '".addslashes($_POST['infoautor4'])."', '".addslashes($_POST['infoautor5'])."', '".addslashes($_POST['infoautor6'])."')";
	$sql ="INSERT INTO `resumos`(`id`, `eventos_id`, `usuarios_id`, `cursos_id`, `status_selecao`, `resumo`, `titulo`, `palavras_chave`, `fomento`, `autor1`, `autor2`, `autor3`, `autor4`, `autor5`, `autor6`, `info_autor1`, `info_autor2`, `info_autor3`, `info_autor4`, `info_autor5`, `info_autor6`,`departamento`,`autor_orientador`,`local_pesquisa`, `apresentador`) VALUES (NULL, '".$eid."', '".$uid."', '".addslashes($_POST['area'])."', 0, '".addslashes($_POST['resumo'])."', '".addslashes($_POST['titulo'])."', '".addslashes($palchaves)."', '".addslashes($_POST['fomento'])."', '".addslashes($_POST['autor1'])."','".addslashes($_POST['autor2'])."', '".addslashes($_POST['autor3'])."', '".addslashes($_POST['autor4'])."', '".addslashes($_POST['autor5'])."', '".addslashes($_POST['autor6'])."', '".addslashes($_POST['infoautor1'])."', '".addslashes($_POST['infoautor2'])."', '".addslashes($_POST['infoautor3'])."', '".addslashes($_POST['infoautor4'])."', '".addslashes($_POST['infoautor5'])."', '".addslashes($_POST['infoautor6'])."', '".addslashes($_POST['dpto'])."', '".addslashes($_POST['autor_orientador'])."', '".addslashes($_POST['local_pesquisa'])."', '".addslashes($_POST['autor1'])."')";
	if (!$db->executar($sql))
		die("SQL Invalido!<br />".$sql);
	
	header("Location: user.php");
?>