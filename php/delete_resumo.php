<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if ((!isset($_SESSION['eid'])) ||
		(!isset($_GET['id'])) )
			die("<alert>Requisicao Invalida!");
	$db = new Database();
	$id = $_GET['id'];
	$eid = $_SESSION['eid'];
	$sql = "SELECT * FROM resumos WHERE id='".$id."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Resumo Invalido!");
	$data = $res[0];
	$sql = "SELECT * FROM usuarios WHERE ".
		"eventos_id='".$_SESSION['eid']."' AND ".
		"email='".strtoupper(trim($_SESSION['email']))."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Usuario Invalido!");
	$user = $res[0];
	if ($data['usuarios_id'] != $user['id'])
		die("<alert>Posse invalida de resumo!");
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento invalido!");
	$evento = $res[0];
	$term = @mktime($evento['termino_submissao']);
	if ($term < @time())
		die("<alert>Periodo de submissoes ja terminou.");
	
	$sql = "DELETE FROM resumos WHERE id='".$id."';";
	if (!$db->executar($sql))
		die("<alert>SQL Invalido!\n".$sql);
	
	echo "<deleted>";
?>