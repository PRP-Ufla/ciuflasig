<?php
	@include("db/class_database.php");
	@include("cfg/config_months.php");
	if (!isset($_GET['id']))
		die("Requisicao Invalida!");
	$db = new Database();
	$sql = "SELECT r.*, e.* FROM resumos r INNER JOIN eventos e  ".
		"ON r.eventos_id = e.id WHERE r.id_avaliador='".$_GET['id']."' AND r.eventos_id > 5;";
	$ress = $db->consulta($sql);
	$res = $ress[0];
	

	
	$sql = "SELECT * FROM avaliador WHERE id='".$_GET['id']."';";
	$sess = $db->consulta($sql);
	$ses = $sess[0]['nome'];
	
	if (count($res) == 0)
		die("Resumo solicitado não encontrado.<br />".$sql);
	
	
	$consulta2 = mysql_query("SELECT * FROM caracteres");
	
	$busca = array();
	$troca = array();

	while( $result = mysql_fetch_array($consulta2) )	
	{
        array_push($busca, $result['cod_caractere']);
        array_push($troca, $result['desenho']);
	}


	$titulo =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $res['titulo'],ENT_QUOTES, 'ISO-8859-15')));
	 
	require('fpdf.php');
	

	class PDF extends FPDF
	{
		public $edicao;
		public $ano;
		public $rid;
		public $eid;
		public $uid;
		
		function Header()
		{
			// Select Arial bold 15
			$this->SetFont('Helvetica','B',11);
			//$this->SetY(2);
			// Move to the right
			$this->Cell(0,5,$this->edicao." Congresso de ".
			"Iniciação Científica da UFLA",0,0,"R");
			$this->Ln(10);
		}
		/*function Footer()
		{
			$this->SetY(-15);
			$this->SetFont("Helvetica","I",11);
			$this->Cell(140,5,"Identificador deste resumo: ".
				$this->rid."-".$this->eid."-".$this->uid);
			$this->SetY(-15);
			$this->Cell(0,5,$this->ano,0,0,"R");
		
		}*/
		
	}
	$tabela = mysql_query("SELECT r.*, e.* FROM resumos r INNER JOIN eventos e  ".
		"ON r.eventos_id = e.id WHERE r.id_avaliador='".$_GET['id']."' AND r.eventos_id > 5;");
		
	$pdf = new PDF();

	$pdf->edicao = $res['edicao'];
	$pdf->ano = $MONTHS[@substr($res['inicio'],5,2)]." de ".
		@substr($data['inicio'],0,4);
	$pdf->eid = $res['eventos_id'];
	$pdf->SetMargins(20.0,10.0,20.0);
	$pdf->SetAuthor($res['autor1']);
	$pdf->SetCreator("Sistema de Gestão do CIUFLA ".
		"(usando FPDF v1.7)");
	$pdf->SetTitle("Certificado");
	$pdf->AddPage();
	
	$pdf->SetFont('Helvetica','B',14);
	//$pdf->Write(6,'Certificado');
	$pdf->Ln(10);
	$pdf->Cell(0, 2,'Certificado', 0, 1, 'C');
	$pdf->Ln(15);
	
	$pdf->SetFont('Helvetica','',11);
	$pdf->Write(7,'dasdsadasdas '.$ses);
	$pdf->Ln(15);
	
	$texto = '';
	
	while($linha=mysql_fetch_array($tabela)){
	$pdf->MultiCell(0,4.5,$linha['titulo']); //GERA AS LINHAS DO MEU BANCO DE DADOS
	$pdf->Ln(5);
	}
	
	
	$pdf->Output();
	
	
?>