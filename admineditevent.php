<?php
	include("static/basicheaders.php");
	include("static/lock_admin.php");
	include("php/class_database.php");
	if (!isset($_POST['eid']))
		die("Requisicao Invalida!");
	$db = new Database();
		
	$sql = "DELETE FROM sessoes WHERE id>'".$_POST['sessoes']."';";
	if (!$db->executar($sql))
		die("Erro na execucao do comando SQL.<br />".$sql);
		
	$sql = "UPDATE eventos SET ".
		"edicao='".$_POST['edicao']."',".
		"inicio='".$_POST['ini_ano']."-".$_POST['ini_mes']."-".
			$_POST['ini_dia']."',".
		"termino='".$_POST['ter_ano']."-".$_POST['ter_mes']."-".
			$_POST['ter_dia']."',".
		"inicio_submissao='".$_POST['isub_ano']."-".
			$_POST['isub_mes']."-".$_POST['isub_dia']."',".
		"termino_submissao='".$_POST['tsub_ano']."-".
			$_POST['tsub_mes']."-".$_POST['tsub_dia']."',".
		"inicio_selecionar_sessao='".$_POST['isel_ano']."-".
			$_POST['isel_mes']."-".$_POST['isel_dia']."',".
		"termino_selecionar_sessao='".$_POST['tsel_ano']."-".
			$_POST['tsel_mes']."-".$_POST['tsel_dia']."',".
		"descricao='".$_POST['desc']."',".
		"resumos='".$_POST['resumos']."',".
		"sessoes='".$_POST['sessoes']."'".
		" WHERE id='".$_POST['eid']."';";
						
	if (!$db->executar($sql))
		die("Erro na execucao do comando SQL.<br />".$sql);
	
	header("Location: ./adminevent.php?id=".$_POST['eid']);
?>

