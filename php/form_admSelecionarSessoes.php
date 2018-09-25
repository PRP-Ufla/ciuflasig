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
	$msg .= "<div>Atenção Administrador, esta opção irá selecionar uma sessão aleatoriamente para cada resumo que ainda não possui uma.<br>";
	$msg .= "Fique atento, pois este é um passo irreversível!<br><br>";
	$msg .= "<button type='submit' onClick='return confirmation()'>";
	$msg .= "Selecionar Sessões";
	$msg .= "</button>";
	$msg .= "</div>";
	$msg .= "</form>";
?>

<h2>Selecionar Sess&otilde;es Aleatoriamente</h2>
<?php echo $msg; ?>
