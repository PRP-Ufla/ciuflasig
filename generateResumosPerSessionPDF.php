<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");
	if (!isset($_GET['id']))
		die("Requisicao Invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$sesId = $_POST['sesId'];
	//die(var_dump($sesId));
	$sql = "SELECT resumos.*,eventos.edicao,eventos.inicio FROM resumos INNER JOIN eventos ".
		"ON resumos.eventos_id=eventos.id WHERE resumos.eventos_id='".
		$_GET['id']."' AND resumos.sessoes_id='".$sesId."' ORDER BY resumos.sessoes_id,resumos.cursos_id,".
		"resumos.autor1,resumos.id;";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Evento solicitado não possui resumos.<br />".$sql);
	$allResumos = $res;
	
	$consulta2 = mysql_query("SELECT * FROM caracteres");
	
	$busca = array();
	$troca = array();
	
	require('fpdf.php');
	class PDF extends FPDF
	{
		public $edicao;
		public $ano;
		public $rid;
		public $eid;
		public $uid;
		public $poster;
		public $sessao;
		
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
		function Footer()
		{	
			$this->SetY(-20);
			$this->SetFont("Helvetica","I",11);
			$this->Cell(140,5,"Sessão: ".$this->sessao);
			$this->SetY(-15);
			$this->SetFont("Helvetica","I",11);
			$this->Cell(140,5,"Número pôster: ".$this->poster);
			$this->SetY(-10);
			$this->SetFont("Helvetica","I",11);
			$this->Cell(140,5,"Identificador deste resumo: ".
				$this->rid."-".$this->eid."-".$this->uid);
			$this->SetY(-10);
			$this->Cell(0,5,$this->ano,0,0,"R");
			
		}
	}	

	$pdf = new PDF();
	$pdf->eid = $eid;
	$pdf->SetMargins(20.0,10.0,20.0);
	$pdf->SetAuthor("Pró-Reitoria de Pesquisa");
	$pdf->SetCreator("Sistema de Gestão do CIUFLA ".
		"(usando FPDF v1.7)");
	$pdf->SetTitle("Todos os resumos do evento.");
	
	$lastSec = -1;
	foreach ($allResumos as $resumoIndex => $data) {
	
		while( $result = mysql_fetch_array($consulta2) )	
	{
        array_push($busca, $result['cod_caractere']);
        array_push($troca, $result['desenho']);
	}
	
	$resumo = str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $data['resumo'],ENT_QUOTES, 'ISO-8859-15')));
	
	$titulo =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $data['titulo'],ENT_QUOTES, 'ISO-8859-15')));
	
	$info_autor1 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $data['info_autor1'],ENT_QUOTES, 'ISO-8859-15')));
	
	$info_autor2 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $data['info_autor2'],ENT_QUOTES, 'ISO-8859-15')));
	
	$info_autor3 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $data['info_autor3'],ENT_QUOTES, 'ISO-8859-15')));
	
	$info_autor4 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $data['info_autor4'],ENT_QUOTES, 'ISO-8859-15')));
	
	$info_autor5 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $data['info_autor5'],ENT_QUOTES, 'ISO-8859-15')));
	
	$info_autor6 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode( $data['info_autor6'],ENT_QUOTES, 'ISO-8859-15')));
	
	$palavrachave =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode($data['palavras_chave'] ,ENT_QUOTES, 'ISO-8859-15')));
	
	$fomento =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode($data['fomento'] ,ENT_QUOTES, 'ISO-8859-15')));
	
	$autor1 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode($data['autor1'],ENT_QUOTES, 'ISO-8859-15')));
	
	$autor2 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode($data['autor2'],ENT_QUOTES, 'ISO-8859-15')));
	
	$autor3 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode($data['autor3'],ENT_QUOTES, 'ISO-8859-15')));
	
	$autor4 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode($data['autor4'],ENT_QUOTES, 'ISO-8859-15')));
	
	$autor5 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode($data['autor5'],ENT_QUOTES, 'ISO-8859-15')));
	
	$autor6 =  str_replace("\n", " ",str_replace($busca,$troca,html_entity_decode($data['autor6'],ENT_QUOTES, 'ISO-8859-15')));
	
	$sql="SELECT bic_jr, tipTrab FROM usuarios WHERE id='".$data['usuarios_id']."';";
	$res=$db->consulta($sql);
	$bic=$res[0];
	
	$trabalho="";
	if($bic["bic_jr"]==1){
		$trabalho=" - BIC JÚNIOR";
	}
	if($bic["tipTrab"]==2){
		$trabalho=" - PIBID";
	}
		
	$sql = "SELECT nome FROM cursos WHERE id='".$data['cursos_id']."';";
	$res = $db->consulta($sql);
	$area = $res[0]['nome'];
	$pdf->edicao = $data['edicao'];
	$pdf->ano = $MONTHS[@substr($data['inicio'],5,2)]." de ".
		@substr($data['inicio'],0,4);
	if ($lastSec != $data['sessoes_id']) {
		$pdf->AddPage();
		$pdf->SetFont('Helvetica','B',24);
		$pdf->Cell(0,150,"Sessão ".$data['sessoes_id'],0,0,"C");
		$lastSec = $data['sessoes_id'];
	}
	$pdf->AddPage();
	$pdf->rid = $data['id'];
	$pdf->uid = $data['usuarios_id'];
	$pdf->poster = $data['numero_poster'];
	$pdf->sessao = $data['sessoes_id'];
	
	$pdf->SetFont('Helvetica','',11);
	$pdf->Write(7,$area.$trabalho);
	$pdf->Ln();
	$pdf->SetFont('Helvetica','B',12);
	$pdf->Write(6,$titulo);
	$pdf->Ln(10);
	
	if ($data['autor_orientador'] == 'autor2') {
		$autor_orientador2 = " - Orientador(a)";
	} else {
		$autor_orientador2 = "";
	}
	
	if ($data['autor_orientador'] == 'autor3') {
		$autor_orientador3 = " - Orientador(a)";
	} else {
		$autor_orientador3 = "";
	}	
	
	if ($data['autor_orientador'] == 'autor4') {
		$autor_orientador4 = " - Orientador(a)";
	} else {
		$autor_orientador4 = "";
	}	
	
	if ($data['autor_orientador'] == 'autor5') {
		$autor_orientador5 = " - Orientador(a)";
	} else {
		$autor_orientador5 = "";
	}

	if ($data['autor_orientador'] == 'autor6') {
		$autor_orientador6 = " - Orientador(a)";
	} else {
		$autor_orientador6 = "";
	}
	
	$pdf->SetFont('Helvetica','',11);
	$pdf->Write(5,$autor1." - ".$info_autor1);
	$pdf->Ln(7.5);
	if ($data['autor2'] != "") {
		$pdf->Write(5,$autor2." - ".$info_autor2.$autor_orientador2);
		$pdf->Ln(7.5);
	}
	if ($data['autor3'] != "") {
		$pdf->Write(5,$autor3." - ".$info_autor3.$autor_orientador3);
		$pdf->Ln(7.5);
	}
	if ($data['autor4'] != "") {
		$pdf->Write(5,$autor4." - ".$info_autor4.$autor_orientador4);
		$pdf->Ln(7.5);
	}
	if ($data['autor5'] != "") {
		$pdf->Write(5,$autor5." - ".$info_autor5.$autor_orientador5);
		$pdf->Ln(7.5);
	}
	if ($data['autor6'] != "") {
		$pdf->Write(5,$autor6." - ".$info_autor6.$autor_orientador6);
		$pdf->Ln(7.5);
	}
	
	$pdf->SetFont('Helvetica','B',11);
	$pdf->Cell(0,9,"Resumo",0,0,"L");
	$pdf->Ln(10);
	$pdf->SetFont('Helvetica','',11);
	$pdf->MultiCell(0,4.5,$resumo);
	$pdf->Ln(5);
	$pc = explode("|||",$palavrachave); // A partir do CIUFLA 2015 (Evento 8), as palavras-chaves são separadas por ||| e não por ;
	$pdf->Write(7,"Palavras-Chave: ".$pc[0].", ".$pc[1].", ".
		$pc[2].".");
	$pdf->Ln(5);
	if ($fomento != "") {
		$pdf->Write(7,"Instituição de Fomento: ".$fomento);
		$pdf->Ln();
	}
	}
	$pdf->Output();
?>