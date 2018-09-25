<?php
	
	session_start();
		
	if(!isset($_SESSION['idUsuario']) || !isset($_GET['avaliadorNome']) || !isset($_GET['avaliadorId'])) {
		die("Requisição inválida!");
	}

	require_once 'db/DBUtils.class.php';
	include("config/config_months.php");
	
	$db = new DBUtils();

	$nome = $_GET['avaliadorNome'];
	$avaliadorId = $_GET['avaliadorId'];

	$certificadoTexto = 'Certificamos que '.utf8_decode($nome).' foi avaliador(a) de trabalhos apresentados sob a
	forma de pôsteres no XXVI Congresso de Iniciação 	Científica da UFLA - CIUFLA, realizado no período de 14 
	a 18 de outubro de 2013, no <i>campus</i> da 	Universidade Federal de Lavras.';
	
	$dataAtual = gmdate("d-m-Y");
	$dataMesAtual = explode("-", $dataAtual);

	//$protocoloCodigo=date('Y').".".date('diGms').".".str_pad(rand(15,99999), 5, "0", STR_PAD_LEFT);
	$protocoloCodigo= date('Y').".".uniqid().".".str_pad(rand(15,99999), 5, "0", STR_PAD_LEFT);

	$textoPDF = '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<div style="width:650px; padding-left:1.5cm; padding-right:1.5cm; text-align: center;">
	  <div id="cabeca">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td width="26%" align="center" valign="top"><img src="../img/ufla2.png" width="130" height="53" /></td>
	        <td width="74%" align="center" valign="top"><p><strong>UNIVERSIDADE FEDERAL DE LAVRAS</strong><br />
	          PR&Oacute;-REITORIA DE PESQUISA
	        </p></td>
	      </tr>
	    </table>
	  </div>
	  <div id="principal">
	  	<p><br/></p>
		<br/>
		<br/>
	    <p><b><h2>CERTIFICADO</h2></b></p>
	    <div></div>
		<p style="line-height:150%; text-align:justify; text-indent: 70px;">'.$certificadoTexto.'</p>
		<br/>
		<p align="right">Lavras, '.date('d').' de '.$MONTHS[$dataMesAtual[1]].' de '.date('Y').'.</p>
		<br/>
		<br/>
	    <div id="assinatura" align="center">
		<p><img src="../img/assin_teo3_alpha.png" width="135" height="54" /><br />
	     TEODORICO DE CASTRO RAMALHO<br />
	        Pr&oacute;-Reitor de Pesquisa
	      </p>
	    </div>
	  </div>
	  <div style="position:absolute; bottom:1.5cm; ">
	    <div id="campus">
	      <hr />
	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	        <tr>
	          <td align="left" valign="top"><div id="fone">Protocolo: <b>'.$protocoloCodigo.'</b><br />
	            Para verificar a autenticidade deste documento, utilize o protocolo acima no link abaixo:<br>
	            http://www.prp.ufla.br/ciuflasig/certificados_avaliadores/<br />
	          </div></td>
	          <td align="center" valign="top">
	          <td align="right" valign="top">
	        </tr>
	      </table>
	    </div>
	    <div id="site"></div>
	  </div>
	  <p>&nbsp;	</p>
	</div>';

	$dataGeracao=date("Y-m-d");

	$inserirProtocoloSQL = 'INSERT INTO certificado_avaliador_protocolo (`protocolo`, `avaliador_id`, `data_geracao`)
		VALUES ("'.$protocoloCodigo.'", "'.$avaliadorId.'", "'.$dataGeracao.'");';

	$db->executar($inserirProtocoloSQL);

	require_once("dompdf/dompdf_config.inc.php");
	
	$dompdf = new DOMPDF();
	$dompdf->load_html($textoPDF);
	$dompdf->set_paper('A4', 'portrait');
	$dompdf->render();
	$dompdf->stream("certificado.pdf");

?>