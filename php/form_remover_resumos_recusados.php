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
	$msg .= "<form name='removerResumosRecusados' action='php/removerResumosRecusados.php'>";
	$msg .= "<input type='hidden' name='eid' id='eid' value='".$eid."'>";
	$msg .= "<div>Atenção, administrador! Esta opção irá transferir os resumos recusados da tabela \"resumos\" para a tabela \"resumos_recusados\" no banco de dados.<br>";
	$msg .= "Fique atento, pois este é um passo irreversível!<br><br>";
	$msg .= "<button type='submit' onClick='return confirmation3()'>";
	$msg .= "Transferir Resumos";
	$msg .= "</button>";
	$msg .= "</div>";
	$msg .= "</form>";
?>

<h2>Remover Resumos Recusados</h2>
<?php echo $msg; ?>
