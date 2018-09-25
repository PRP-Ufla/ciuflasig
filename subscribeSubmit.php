<?php
	header("Content-Type: text/html; charset=ISO-8859-1", true);
	include("static/basicheaders.php");
	include("php/class_database.php");
	include("cfg/config_course_state.php");
	include("cfg/config_mail.php");
	if (!isset($_POST['eid']))
		die("Requisicao Invalida!");
	$eid = $_POST['eid'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Evento Invalido!");
	$tit = $res[0]['edicao']." CIUFLA";
	$sql = "SELECT * FROM usuarios WHERE ".
		"eventos_id='".$eid."' AND ".
		"email='".strtoupper(trim($_POST['email']))."';";
	$res = $db->consulta($sql);
	if (count($res) > 0)
		die("Usuario (e-mail) ja cadastrado nesse evento!<br />".
			"Verifique seu email para dados de acesso.");
	
	//A variável POST bic_jr após a alteração é utilizada para identificação dos inscritos BIC Júnior, Iniciação Científica ou Iniciação a Docência
	//bic_jr = 0 Iniciacao Cientifica, bic_jr = 1 BIC Júnior e bic_jr = 3 Iniciação a Doencia	
	if($_POST['bic_jr']=="0"){
		$sql = "SELECT * FROM cursos WHERE ".
		"id='".$_POST['curso']."';";
		$res = $db->consulta($sql);
		if (count($res) == 0)
			die("Nenhum curso obtido.");
		$dados = $res[0];
		$curso = $dados['sigla']." - ".$dados['nome'];
		$cursoId=$_POST['curso'];
		$matricula=$_POST['mat'];
		$inc_docencia = 0;
		if($_POST['inst']==1){
			$instituicao="UFLA";
		}else if($_POST['inst']==3){
			$instituicao=$_POST['outrasInsts'];
		}else{
			die("Nenhuma instituição compativél selecionada.");
		}
	}
	else if($_POST['bic_jr']=="3"){
		$sql = "SELECT * FROM cursos WHERE ".
		"id='".$_POST['curso']."';";
		$res = $db->consulta($sql);
		if (count($res) == 0)
			die("Nenhum curso obtido.");
		$dados = $res[0];
		$curso = $dados['sigla']." - ".$dados['nome'];
		$cursoId=$_POST['curso'];
		$matricula=$_POST['mat'];
		$_POST['bic_jr'] = 0;
		$inc_docencia = 1;
		if($_POST['inst']==1){
			$instituicao="UFLA";
		}else if($_POST['inst']==3){
			$instituicao=$_POST['outrasInsts'];
		}else{
			die("Nenhuma instituição compativél selecionada.");
		}
	}else{
		$matricula=0;
		$curso="BicJr - Bic Júnior";
		$cursoId=6;
		$inc_docencia = 0;
		if($_POST['inst']==2){
		$instituicao=$_POST['escola'];
		}else{
			die("Nenhuma escola selecionada.");
		}
	}
	$tipTrab=0;
	$sql = "INSERT INTO usuarios (id,eventos_id,nome,email,senha,".
		"matricula,telefone,instituicao,cursos_id,curso,tipTrab,bic_jr,inc_docencia,cpf) ".
		"VALUES (NULL,".
		"'".$eid."',".
		"'".$_POST['nome']."',".
		"'".$_POST['email']."',".
		"'".sha1($_POST['senha'])."',".
		"'".$matricula."',".
		"'(".$_POST['ddd'].") ".$_POST['tel']."',".
		"'".$instituicao."',".
		"'".$cursoId."',".
		"'".$curso."',".
		"'".$tipTrab."',".
		"'".$_POST['bic_jr']."',".
		"'".$inc_docencia."',".
		"'".$_POST['cpf']."');";
	if (!$db->executar($sql))
		die("SQL Invalido!<br />".$sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Inscrever-se</title>
	<script src="js/subscribe.js" type="text/javascript"></script>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_main.html"); ?>
<div id="conteudo">
    <center><h3>Usu&aacute;rio cadastrado com sucesso!<br />
		Para submeter seu resumo <a href='loginuser.php?id=<?php echo $eid;?>'>clique aqui.</a></h3></center>
</div>
</body>
</html>
