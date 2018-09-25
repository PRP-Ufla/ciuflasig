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
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento n�o encontrado!");
	$msg = "";
	$msg .= "<form action='./gerarCertificadosEletronicos.php?id=".$eid."' method='POST'>";
	$msg .= "<br>";
	$msg .= "Para disponibilizar os certificados eletr�nicos de todos os resumos, clique no bot�o 'Gerar Certificados Eletr�nicos'.";
	$msg .= " Aten��o: realizar este procedimento ap�s definir as aus�ncias no banco de dados.<br><br>";
	$msg .= "<button type='submit' >Gerar Certificados Eletr�nicos</button><br /><br />";
	$msg .= "</form>";
	
	$msg .= "";
	$msg .= "<form action='./generateCertificatesPerEventPDF.php?id=".$eid."' method='POST'>";
	$msg .= "<br>";
	$msg .= "Para gerar os certificados impressos de todos os resumos, clique no bot�o 'Gerar Certificados Impressos'.<br><br>";
	$msg .= "<button type='submit' >Gerar Certificados Impressos</button><br /><br />";
	$msg .= "</form>";
	
	$msg .= "<form action='./generateCertificatePDF.php?id=".$eid."' method='POST'>";
	$msg .= "<br>";
	$msg .= "Para gerar o certificado impresso de um resumo espec�fico, digite seu ID na caixa de texto abaixo e clique no bot�o 'Gerar Certificado Impresso'.<br>";
	$msg .= "<input type='text' id='idResumo' name='idResumo' value='Digite o ID do resumo' onClick='reseta()'>";
	$msg .= "<br><br>";
	$msg .= "<button type='submit' onClick='return Check()'>Gerar Certificado Impresso</button><br /><br />";
	$msg .= "</form>";
?>
<h2>Gerar Certificados</h2>
<?php echo $msg; ?>
