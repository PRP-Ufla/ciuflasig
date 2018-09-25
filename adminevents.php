<?php
	include("static/basicheaders.php");
	include("static/lock_admin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Gerenciador de Eventos</title>
	<style type="text/css"><!--
		#mn2{ color: #6bf; }
	!--></style>
	<script src="js/adminevents.js" type="text/javascript"></script>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_admin.html"); ?>
<div id="conteudo">
    <center><h1>Gerenciador de Eventos</h1>
    <span id="loadBar" name="loadBar"></span><br />
    <table class="managecontainer">
    <tr>
		<td class="sidebar">
			<button class="sidebar" id="m1" onClick="eventos();">
				Eventos</button>
			<button class="sidebar" id="m2" onClick="addEvento()">
				Adicionar Evento</button>
		</td>
		<td class="managecontent"><span id="contentbar"></span></td>
    </tr>
    </table><br /><br />
    </center><br /><br />
</div>
<?php include("htm/bottom.html"); ?>
</div>
</body>
</html>
  
