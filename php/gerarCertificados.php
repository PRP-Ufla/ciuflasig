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
		die("<alert>Evento não encontrado!");
	$msg = "";
	$msg .= "<form action='./gerarCertificadosEletronicos.php?id=".$eid."' method='POST'>";
	$msg .= "<br>";
	$msg .= "Para disponibilizar os certificados eletrônicos de todos os resumos, clique no botão 'Gerar Certificados Eletrônicos'.";
	$msg .= " Atenção: realizar este procedimento após definir as ausências no banco de dados.<br><br>";
	$msg .= "<button type='submit' >Gerar Certificados Eletrônicos</button><br /><br />";
	$msg .= "</form>";
	
	$msg .= "";
	$msg .= "<form action='./generateCertificatesPerEventPDF.php?id=".$eid."' method='POST'>";
	$msg .= "<br>";
	$msg .= "Para gerar os certificados impressos de todos os resumos, clique no botão 'Gerar Certificados Impressos'.<br><br>";
	$msg .= "<button type='submit' >Gerar Certificados Impressos</button><br /><br />";
	$msg .= "</form>";
	
	$msg .= "<form action='./generateCertificatePDF.php?id=".$eid."' method='POST'>";
	$msg .= "<br>";
	$msg .= "Para gerar o certificado impresso de um resumo específico, digite seu ID na caixa de texto abaixo e clique no botão 'Gerar Certificado Impresso'.<br>";
	$msg .= "<input type='text' id='idResumo' name='idResumo' value='Digite o ID do resumo' onClick='reseta()'>";
	$msg .= "<br><br>";
	$msg .= "<button type='submit' onClick='return Check()'>Gerar Certificado Impresso</button><br /><br />";
	$msg .= "</form>";
?>
<h2>Gerar Certificados</h2>
<?php echo $msg; ?>
