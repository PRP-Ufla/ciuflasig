<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if (!isset($_GET['id']))
		die("<alert>Requisicao invalida!");
	$eid = $_GET['id'];
	$msg = "";
	$msg .= "<form name='admSelecionarSessoes' action='php/admSelecionarSessoes.php'>";
	$msg .= "<input type='hidden' name='eid' id='eid' value='".$eid."'>";
	$msg .= "<div>Aten��o Administrador, esta op��o ir� selecionar uma sess�o aleatoriamente para cada resumo que ainda n�o possui uma.<br>";
	$msg .= "Fique atento, pois este � um passo irrevers�vel!<br><br>";
	$msg .= "<button type='submit' onClick='return confirmation()'>";
	$msg .= "Selecionar Sess�es";
	$msg .= "</button>";
	$msg .= "</div>";
	$msg .= "</form>";
?>

<h2>Selecionar Sess&otilde;es Aleatoriamente</h2>
<?php echo $msg; ?>
