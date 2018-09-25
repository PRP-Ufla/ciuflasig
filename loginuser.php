<?php
	include("static/basicheaders.php");
	include("php/class_database.php");
	include("cfg/config_course_state.php");
	if (!isset($_GET['id']))
		die("Requisicao Invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$msg = "";
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Evento Invalido!");
	$ciufla = $res[0]['edicao']." CIUFLA";
	$subday = @strtotime($res[0]['termino_submissao']);
	$selIniday = @strtotime($res[0]['inicio_selecionar_sessao']);
	$selTerday = @strtotime($res[0]['termino_selecionar_sessao']);
	if (isset($_POST['email'])) {
		$sql = "SELECT * FROM usuarios WHERE eventos_id='".$eid."' ".
			"AND email='".strtoupper(trim($_POST['email']))."' ".
			"AND senha='".sha1($_POST['senha'])."';";
		$res = $db->consulta($sql);
		if (count($res) == 0) {
			//echo $sql."<br />";
			$msg = "<br /><b><font color='#d00'>".
				"Login ou senha inv&aacute;lida!".
				"</font></b><br /><br />";
		} else {
			$_SESSION['authLevel'] = 1;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['passwd'] = $_POST['senha'];
			$_SESSION['nome'] = $res[0]['nome'];
			$_SESSION['eid'] = $eid;
			header("Location: user.php");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Submiss&atilde;o/Acesso de Resumos</title>
	<script src="js/subscribe.js" type="text/javascript"></script>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_main.html"); ?>
<div id="conteudo">
    <center>
    <h1><?php echo $ciufla; ?></h1>
    <h2><?php
		if (@time() <= $subday)
			echo "Submiss&atilde;o de Resumos <br>";
		if (($selIniday <= @time()) && (@time() <= $selTerday))
			echo "Seleção das Sessões <br>";
		else
			echo "Acesso aos Resumos Submetidos <br>";
		
	?></h2>
    <?php echo $msg; ?>
    <div style="border: 1px solid #248; width: 500px; padding: 15px;">
    Efetue o login para prosseguir:<br />
    <form action="loginuser.php?id=<?php echo $eid; ?>"
		method="post">
	<table border=0>
	<tr>
		<td>E-mail:</td>
		<td><input type="text" size=30 name="email" /></td>
	</tr>
	<tr>
		<td>Senha:</td>
		<td><input type="password" size=30 name="senha" /></td>
	</tr>
	</table>
	<input type="submit" value="Entrar" />
	</form></div>
	<a href="forgotpass.php?id=<?php echo $eid; ?>">
		Esqueceu sua senha?</a><br /><br />
    </center>
</div>
<?php include("htm/bottom.html"); ?>
</body>
</html>
