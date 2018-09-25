<?php
	include("static/basicheaders.php");
	if ($_SESSION['authLevel'] >= 2)
		header("Location: admin.php");
	@include("php/class_database.php");
	$msg = "";
	if (isset($_POST["_apw"])) {
		$passwd = md5($_POST["_apw"]);
		$db = new Database();
		$sql = "SELECT senha FROM usuarios WHERE ".
			"id='1';";
		$res = $db->consulta($sql);
		if (strcasecmp($res[0]['senha'], $passwd)==0) {
			$_SESSION['authLevel'] = 2;
			$_SESSION['email'] = "prp@prp.ufla.br";
			$_SESSION['passwd'] = $passwd;
			$_SESSION['nome'] = "Administrador";
			header("Location: admin.php");
		} else{
			$msg = "Senha incorreta.<br /><br />";
			//echo $passwd."<br/>".$res[0]['senha'];
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Login de Administrador</title>
	<style type="text/css"><!--
		#mn2{ color: #6bf; }
	--></style>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_main.html"); ?>
<div id="conteudo">
    <center><h3>Entre com a senha de administrador.</h3></center>
    <center>
    <font color="#c00">
		<b><?php echo $msg; ?></b>
    </font>
    <form action="loginadmin.php" method="post">
		Senha: <input type="password" name="_apw" size=20 /><br />
		<input class="submit" type="submit" value="Entrar" /><br />
    </form></center>
</div>
<?php include("htm/bottom.html"); ?>
</div>
</body>
</html> 
