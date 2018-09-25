<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");

	$db = new Database();

	if (!isset($_POST['id']))
		die("Requisicao Invalida!");

	$sql = "SELECT * FROM resumos INNER JOIN eventos ".
		"ON resumos.eventos_id=eventos.id WHERE resumos.id='".
		$_POST['id']."';";
	
	$res = $db->consulta($sql);
	
	if (count($res) == 0){
		die("Resumo solicitado não encontrado.<br />".$sql);
	}
	
	$data = $res[0];
	$sql = "SELECT nome FROM cursos WHERE id='".$data['cursos_id']."';";
	$res = $db->consulta($sql);
	$area = $res[0]['nome'];
	
	$sql="SELECT bic_jr, tipTrab FROM usuarios WHERE id='".$data['usuarios_id']."';";
	$res=$db->consulta($sql);
	$bic=$res[0];
	
	if($bic["bic_jr"]=="1"){
		$trabalho=" - BIC JNIOR";
	} else if($bic["tipTrab"]=="2"){
			$trabalho=" - PIBID";
		} else {
			$trabalho="";
		}
	
	$consulta2 = mysql_query("SELECT * FROM caracteres");
	
	$busca = array();
	$troca = array();

	while( $result = mysql_fetch_array($consulta2)){

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

	
	/* -------------------- GERA E SALVA UM NOVO PROTOCOLO CASO A PESQUISA NO FORMULARIO NÃO O INCLUA --------------------*/
	if (!isset($_POST['protocolo'])){

		$protocoloCodigo = date('Y').".".uniqid().".".str_pad(rand(15,99999), 5, "0", STR_PAD_LEFT);

		$dataGeracao=date("Y-m-d");

		$sql = "SELECT c.id from certificado c 
					INNER join resumos r ON (c.resumo_id = r.id)
					WHERE (c.resumo_id = '".$_POST['id']."');";

		$certificadoId = $db->consulta($sql);            
		$certificadoId = $certificadoId[0][0];
		$inserirProtocoloSQL = 'INSERT INTO certificado_protocolo (`protocolo`, `certificado_id`, `data_geracao`) '
		.' VALUES ("'.$protocoloCodigo.'", "'.$certificadoId.'", "'.$dataGeracao.'");';

		$db->executar($inserirProtocoloSQL);
	
	} else {
		$protocoloCodigo = $_POST['protocolo'];
	}

	/* -------------------------------------------------------------------------------------------------------------------*/ 
	require('fpdf.php');
	
	
	
	class PDF extends FPDF{

		public $edicao;
		public $ano;
		public $rid;
		public $eid;
		public $uid;
		public $poster;
		public $sessao;
		
		function Header(){
            // Logo
            $this->Image('img/ufla2.png',30,12,33);
			$this->SetFont('Times','B',13);
			$this->SetY(12);
            $this->Cell(0,12,"UNIVERSIDADE FEDERAL DE LAVRAS",0,0,"R");
            $this->SetFont('Times','',10);
            $this->Cell(-20,20,"PRÓ-REITORIA DE PESQUISA",0,0,"R");
			$this->Ln(10);
		}
		
		function Footer(){

            $this->SetX(70);
            $eixoYAtual = $this->GetY();
            $EixoYImagem = $eixoYAtual + 45;
            $this->Image('img/assin_teo3_alpha.png',95,$EixoYImagem,25);
            $this->Cell(0,130,"TEODORICO DE CASTRO RAMALHO",0,0,"B");
            $this->SetX(85);
            $this->Cell(0,140,"Pró-Reitor de Pesquisa",10,0,"B");
			$this->SetY(-45);
            $this->SetFont("Times","B",12);
			global $protocoloCodigo;
			$this->Rect(21, 250, 170, 0, "D");
			$this->Cell(140,5,"Protocolo: " . $protocoloCodigo);
			$this->SetY(-40);
			$this->SetFont("Times","",12);
			$this->Cell(140,5,"Para verificar a autenticidade deste documento, utilize o protocolo acima no link abaixo:");
            $this->SetY(-35);
            $this->Cell(140,5, "http://www.prp.ufla.br/ciuflasig/certificados/");
		}
    }
    
	$eventoid = $data['eventos_id'];
	$pdf = new PDF();
	$pdf->edicao = $data['edicao'];
	$pdf->ano = $MONTHS[@substr($data['inicio'],5,2)]." de ".
		@substr($data['inicio'],0,4);
	$pdf->rid = $_POST['id'];
	$pdf->eid = $data['eventos_id'];
	$pdf->uid = $data['usuarios_id'];
	$pdf->SetMargins(20.0,10.0,20.0);
	$pdf->SetAuthor($data['autor1']);
	$pdf->SetCreator("Sistema de Gestão do CIUFLA ".
		"(usando FPDF v1.7)");
	$pdf->SetKeywords($data['palavras_chave']);
	$pdf->AddPage();
	
	$pdf->poster = $data['numero_poster'];
	$pdf->sessao = $data['sessoes_id'];
	$pdf->SetFont('Helvetica','',11);
	$pdf->Ln();
	$pdf->SetFont('Helvetica','B',12);
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

	$encoding = mb_internal_encoding();
	
	$texto = "        Certificamos que o trabalho \"";
	
	if ($data['titulo'][strlen($data['titulo'])-1] == ".")
		$data['titulo'][strlen($data['titulo'])-1] = "";

	// remove os possíveis espaços no começo e no fim do título
	$data['titulo'] = trim($data['titulo']);
	
	/* Se começar e terminar com aspas, fazer a remoção delas.
	 Essa verificação é feita pois existe o caso onde alguns títulos terminam mas não começam
	 com aspas (caso em que no final do título existe alguma citação), e nesses casos não podemos
	 usar o trim para remover as aspas.									
	 */
	if($data['titulo'][0] == '"' && $data['titulo'][strlen($data['titulo']) - 1] == '"') {
		$data['titulo'] = trim($data['titulo'], '"');
	}
	
	$texto .= mb_strtoupper($data['titulo'], $encoding);
	$texto .= "\", de autoria de ";

	$data['autor1'] = trim($data['autor1']);
	$texto .= mb_strtoupper($data['autor1'], $encoding);

	if ($data['autor2'] != "") {
		$data['autor2'] = trim($data['autor2']);
		$texto .= ($data['autor3'] != "" ? ", ":" e ").mb_strtoupper($data['autor2'], $encoding);
	}
	if ($data['autor3'] != "") {
		$data['autor3'] = trim($data['autor3']);
		$texto .= ($data['autor4'] != "" ? ", ":" e ").mb_strtoupper($data['autor3'], $encoding);
	}
	if ($data['autor4'] != "") {
		$data['autor4'] = trim($data['autor4']);
		$texto .= ($data['autor5'] != "" ? ", ":" e ").mb_strtoupper($data['autor4'], $encoding);
	}
	if ($data['autor5'] != "") {
		$data['autor5'] = trim($data['autor5']);
		$texto .= ($data['autor6'] != "" ? ", ":" e ").mb_strtoupper($data['autor5'], $encoding);
	}
	if ($data['autor6'] != "") {
		$data['autor6'] = trim($data['autor6']);
		$texto .= " e ".mb_strtoupper($data['autor6'], $encoding);
	}

	if ($data['apresentador'] != ""){
		$apresentador = mb_strtoupper($data['apresentador'], $encoding);
	} else {
		$apresentador = mb_strtoupper($data['autor1'], $encoding);
	}

	$texto .= ", foi apresentado por ".
		$apresentador.", no " .$data['edicao']. " CIUFLA, realizado no período de  ";

	$ini = explode("-",$data['inicio']);
	$ter = explode("-",$data['termino']);
	$texto .= $ini[2]." a ".
		$ter[2]." de ".$MONTHS[$ter[1]]." de ".$ter[0];
    $texto .= ", no câmpus da Universidade Federal de Lavras.";

    $pdf->SetFont('Times','B',15);
    $pdf->SetX(90);
	$pdf->Cell(0,17,"CERTIFICADO",0,0,"B");
	$pdf->Ln(20);
    $pdf->SetFont('Times','',12);
    $pdf->Multicell(0,6,$texto,0,"J");
    $pdf->Ln(15.0);
	$pdf->MultiCell(0,7,"Lavras(MG), ".date("d")." de ".$MONTHS[date("m")]." de ".date("Y").".",0,"R");

	$pdf->Output();
?>