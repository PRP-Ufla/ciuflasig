<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");
	if (!isset($_GET['id']))
		die("Requisicao Invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$idResumo = $_POST['idResumo'];
	$sql = "SELECT resumos.*,eventos.edicao,eventos.inicio,eventos.termino,".
		"eventos.certificado_por,eventos.path_assinatura FROM resumos ".
		"INNER JOIN eventos ".
		"ON resumos.eventos_id=eventos.id WHERE resumos.id='".$idResumo."'";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("ID de resumo inválido!<br />".$sql);
	$allResumos = $res;
	
	require('fpdf.php');

	$pdf = new FPDF("L","mm","A4");
	$pdf->SetMargins(25.0,80.0,25.0);
	$pdf->SetAuthor("Pró-Reitoria de Pesquisa");
	$pdf->SetCreator("Sistema de Gestão do CIUFLA ".
		"(usando FPDF v1.7)");
	$pdf->SetTitle("Certificados do evento.");
	
	$lastSec = -1;
	foreach ($allResumos as $resumoIndex => $data) {
		
	$texto = "        Certificamos que o trabalho ";
	if ($data['titulo'][strlen($data['titulo'])-1] == ".")
		$data['titulo'][strlen($data['titulo'])-1] = " ";
	$texto .= strtoupper(strtr($data['titulo'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	$texto .= " de autoria de ";
	$texto .= strtoupper(strtr($data['autor1'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	if ($data['autor2'] != "") {
		$texto .= ($data['autor3'] != "" ? ", ":" e ").strtoupper(strtr($data['autor2'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	}
	if ($data['autor3'] != "") {
		$texto .= ($data['autor4'] != "" ? ", ":" e ").strtoupper(strtr($data['autor3'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	}
	if ($data['autor4'] != "") {
		$texto .= ($data['autor5'] != "" ? ", ":" e ").strtoupper(strtr($data['autor4'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	}
	if ($data['autor5'] != "") {
		$texto .= ($data['autor6'] != "" ? ", ":" e ").strtoupper(strtr($data['autor5'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	}
	if ($data['autor6'] != "") {
		$texto .= " e ".strtoupper(strtr($data['autor6'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	}
	$texto .= " foi apresentado no ".
		$data['edicao']." CIUFLA, realizado no período de ";
	$ini = explode("-",$data['inicio']);
	$ter = explode("-",$data['termino']);
	$texto .= $ini[2]." a ".
		$ter[2]." de ".$MONTHS[$ter[1]]." de ".$ter[0];
	$texto .= ", no câmpus da Universidade Federal de Lavras.";	
	
	$pdf->AddPage();
	
	$pdf->SetFont('Arial','',13);
	$pdf->Multicell(0,7,$texto,0,"J");
	/*$pdf->Write(7,"        Certificamos que o trabalho ");
	$pdf->SetFont('Arial','B',13);
	if ($data['titulo'][strlen($data['titulo'])-1] == ".")
		$data['titulo'][strlen($data['titulo'])-1] = " ";
	$pdf->Write(7,strtoupper(strtr($data['titulo'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
	$pdf->SetFont('Arial','',13);
	$pdf->Write(7," de autoria de ");
	$pdf->SetFont('Arial','B',13);
	$pdf->Write(7,strtoupper(strtr($data['autor1'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
	if ($data['autor2'] != "") {
		$pdf->Write(7,($data['autor3'] != "" ? ", ":" e ").strtoupper(strtr($data['autor2'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
	}
	if ($data['autor3'] != "") {
		$pdf->Write(7,($data['autor4'] != "" ? ", ":" e ").strtoupper(strtr($data['autor3'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
	}
	if ($data['autor4'] != "") {
		$pdf->Write(7,($data['autor5'] != "" ? ", ":" e ").strtoupper(strtr($data['autor4'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
	}
	if ($data['autor5'] != "") {
		$pdf->Write(7,($data['autor6'] != "" ? ", ":" e ").strtoupper(strtr($data['autor5'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
	}
	if ($data['autor6'] != "") {
		$pdf->Write(7," e ".strtoupper(strtr($data['autor6'] ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")));
	}
	$pdf->SetFont('Arial','',13);
	$pdf->Write(7," foi apresentado no ".
		$data['edicao']." CIUFLA, realizado no período de ");
	$ini = explode("-",$data['inicio']);
	$ter = explode("-",$data['termino']);
	$pdf->Write(7,$ini[2]." a ".
		$ter[2]." de ".$MONTHS[$ter[1]]." de ".$ter[0]);
	$pdf->Write(7,", no câmpus da Universidade Federal de Lavras.");*/
	$pdf->Ln(15.0);
	//$pdf->MultiCell(0,7,"Lavras(MG), ".$ter[2]." de ".$MONTHS[$ter[1]]." de ".$ter[0].".",0,"R");
	$pdf->MultiCell(0,7,"Lavras(MG), ".date("d")." de ".$MONTHS[date("m")]." de ".date("Y").".",0,"R");
	$pdf->Ln(10.0);
	$pdf->Image("img/assin_teo3_alpha.png",128.5,NULL,40.0);
	$pdf->MultiCell(0,6,"TEODORICO DE CASTRO RAMALHO",0,"C");
	$pdf->MultiCell(0,6,"Pró-Reitor de Pesquisa",0,"C");
	
	}
	$pdf->Output();
?>