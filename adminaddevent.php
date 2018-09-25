<?php
	include("static/basicheaders.php");
	include("static/lock_admin.php");
	include("php/class_database.php");
	$db = new Database();
	$sql = "INSERT INTO eventos (".
		"id,edicao,inicio,termino,inicio_submissao,termino_submissao,".
		"inicio_selecionar_sessao,termino_selecionar_sessao,descricao,resumos,sessoes,certificado_por,path_assinatura) VALUES (".
		"NULL,'".$_POST['edicao']."',".
		"'".$_POST['ini_ano']."-".$_POST['ini_mes']."-".
			$_POST['ini_dia']."',".
		"'".$_POST['ter_ano']."-".$_POST['ter_mes']."-".
			$_POST['ter_dia']."',".
		"'".$_POST['isub_ano']."-".$_POST['isub_mes']."-".
			$_POST['isub_dia']."',".
		"'".$_POST['tsub_ano']."-".$_POST['tsub_mes']."-".
			$_POST['tsub_dia']."',".
		"'".$_POST['isel_ano']."-".$_POST['isel_mes']."-".
			$_POST['isel_dia']."',".
		"'".$_POST['tsel_ano']."-".$_POST['tsel_mes']."-".
			$_POST['tsel_dia']."',".
		"'".$_POST['desc']."',".
		"'".$_POST['resumos']."',".
		"'".$_POST['sessoes']."',".
		"'',". //certificado_por
		"''". //path_assinatura
		");";
	if (!$db->executar($sql))
		die("Erro na execucao do comando SQL.<br />".$sql);
	
	header("Location: ./adminevents.php");
?>