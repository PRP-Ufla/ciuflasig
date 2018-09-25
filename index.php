<?php
	include("static/basicheaders.php");
	header("Content-Type: text/html; charset=ISO-8859-1", true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Sistema de Gest&atilde;o</title>
	<style type="text/css"><!--
		#mn1{ color: #6bf; }
	!--></style>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_main.html"); ?>
<div id="conteudo">
    <center><h3>Bem-vindo ao sistema de gest&atilde;o do CIUFLA!</h3>
    <?php include("static/list_events.php"); ?>
<p><font color="#dd0000"><b>Para correta visualização do sistema utilize o navegador Mozilla Firefox ou Google Chrome. Não utilize o Internet Explorer.</b></font></p>
	</center><br /><br />
</div>
<?php include("htm/bottom.html");?>
</div>
</body>
</html>
