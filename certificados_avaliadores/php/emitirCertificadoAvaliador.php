<?php
	
	session_start();
		
	function convertem($term, $tp) { 
    if ($tp == "1") $palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"); 
    elseif ($tp == "0") $palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ"); 
    return $palavra; 
} 

	if(!isset($_GET['id'])) {
		die("Requisição inválida!");
	}

	require_once 'db/DBUtils.class.php';
	include("config/config_months.php");
	
	$db = new DBUtils();

	$certificadoId = $_GET['id'];
	$certificadoIdevento = $_GET['idevento'];
	
	if($_GET['idevento'] > 6){
	$avaliador = "SELECT r.*, e.* FROM resumos r INNER JOIN eventos e  ".
		"ON r.eventos_id = e.id WHERE r.id_avaliador='".$_GET['id']."' AND r.eventos_id = '".$_GET['idevento']."';";
		
	$avaliadordados = $db->executarConsulta($avaliador);
	
	$nomeAvaliador = "SELECT * FROM avaliador WHERE id='".$_GET['id']."';";
	$sess = $db->executarConsulta($nomeAvaliador);
	$nome = $sess[0]['nome'];
	
	$diaInicio = explode("-",$avaliadordados[0]['inicio']);
	$mes = explode("-",$avaliadordados[1]['inicio']);
	$diaFim = explode("-", $avaliadordados[0]['termino']);
	
	if(count($avaliadordados) > 0) {

		$dataAtual = gmdate("d-m-Y");
		$dataMesAtual = explode("-", $dataAtual);
		$protocoloCodigo= date('Y').".".uniqid().".".str_pad(rand(15,99999), 5, "0", STR_PAD_LEFT);
	
		$certificadoTexto = 'Certificamos que '.convertem(utf8_decode($nome),1).' foi avaliador(a) de resumos, apresentados na forma de pôsteres, no '.utf8_decode($avaliadordados[0]["edicao"]).' 
		Congresso de Iniciação 	Científica da UFLA - CIUFLA, realizado no período de '.$diaInicio[2].' 
		a '.$diaFim[2].' de '.$MONTHS[$mes[1]].' de '.$diaInicio[0].', no <i>campus</i> da 	Universidade Federal de Lavras.';
		
		
		
		$textoPDF = '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style>
		@page { margin: 100px 20px; }
		#header { position: fixed; left: 0px; top: -100px; right: 0px; height: 60px; text-align: center; margin-top:20px;  }
		#footer { position: fixed; left: 0px; bottom: -100px; right: 0px; height:100px;}
		#footer .page:after { content: counter(page, upper-roman); }
		</style>
		  <div id="header">
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		      <tr>
		        <td width="26%" align="center" valign="top"><img src="../img/ufla2.png" width="130" height="53" /></td>
		        <td width="74%" align="center" valign="top"><p><strong>UNIVERSIDADE FEDERAL DE LAVRAS</strong><br />
		          PR&Oacute;-REITORIA DE PESQUISA
		        </p></td>
		      </tr>
		    </table>
		  </div>
			    <div id="footer">
		      <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td>
				<hr />
				</td>
				 </tr>
				<tr>
		          <td align="left" valign="top"><div id="fone">Protocolo: <b>'.$protocoloCodigo.'</b><br />
		            Para verificar a autenticidade deste documento, utilize o protocolo acima no link abaixo:<br>
		            http://www.prp.ufla.br/ciuflasig/certificados/<br />
		          </div></td>
		          <td align="center" valign="top">
		          <td align="right" valign="top">
		        </tr>
		      </table>
		    </div>
		<div style="width:650px; padding-left:1.5cm; padding-right:1.5cm; text-align: center;">
		  <div id="principal">
		    <br/>
			<b><h2>CERTIFICADO</h2></b>
			<p style="line-height:150%; text-align:justify; text-indent: 70px;">'.$certificadoTexto.'</p>
			<p align="right">Lavras, '.date('d').' de '.$MONTHS[$dataMesAtual[1]].' de '.date('Y').'.</p>
			 <div id="assinatura" align="center">
			<p><img src="../img/assin_teo3_alpha.png" width="135" height="54" /><br />
		     TEODORICO DE CASTRO RAMALHO<br />
		        Pr&oacute;-Reitor de Pesquisa
		      </p>
		    </div>
			<br/>
			<p align="left">Trabalhos avaliados:</p>
			<table style="line-height:150%">
			
			';
			
			for($i=0;$i < COUNT($avaliadordados);$i++){
			$x = $i + 1;
			$remover = "";
			$size = strlen($avaliadordados[$i]['titulo']);
					for($j = 1; $j < $size; $j++){
					$letraf = substr($avaliadordados[$i]['titulo'],  $size - $j);
					$letrai = substr($avaliadordados[$i]['titulo'],1);
					if($letraf == "." || $letraf == ";"){
					$avaliadordados[$i]['titulo'] = substr($avaliadordados[$i]['titulo'], 0, -1) . $remover;
					}
					else if($letrai == " "){
					$avaliadordados[$i]['titulo'] = substr($avaliadordados[$i]['titulo'], 0, 1) . $remover;
					}
					else if ($letraf == " "){
					$avaliadordados[$i]['titulo'] = substr($avaliadordados[$i]['titulo'], 0, -1) . $remover;
					}
					else{
						$j  = $size;
					}
					}
					
				if($i + 1 == COUNT($avaliadordados)){
				$textoPDF .= ' <tr> <td align="justify">'.$x." - ".''.utf8_decode($avaliadordados[$i]['titulo']).''.".".'</td> </tr>';
				}else{
				$textoPDF .= ' <tr> <td align="justify">'.$x." - ".''. utf8_decode($avaliadordados[$i]['titulo']).''.";".'</td> </tr>';
				}
			}
			
			 
			
			$textoPDF .= '
			
			</table>
			<br/>
		  </div>
		    <div id="site"></div>
		  <p>&nbsp;	</p>
		</div>';

		$dataGeracao=date("Y-m-d");

		$inserirProtocoloSQL = 'INSERT INTO certificado_avaliador_protocolo (`protocolo`, `avaliador_id`, `data_geracao`,`evento_id`)
			VALUES ("'.$protocoloCodigo.'", "'.$certificadoId.'", "'.$dataGeracao.'","'.$certificadoIdevento.'");';

		$db->executar($inserirProtocoloSQL);

		require_once("dompdf/dompdf_config.inc.php");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($textoPDF);
		$dompdf->set_paper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream("certificado.pdf");

	} else {
		die("ID do certificado ou e-mail inválido!");
	}
	}else{
	
	$nomeAvaliador = "SELECT * FROM avaliador WHERE id='".$_GET['id']."';";
	$sess = $db->executarConsulta($nomeAvaliador);
	$nome = $sess[0]['nome'];
	
	$certificadoTexto = 'Certificamos que '.convertem(utf8_decode($nome),1).' foi avaliador(a) de trabalhos apresentados sob a
	forma de pôsteres no XXVI Congresso de Iniciação 	Científica da UFLA - CIUFLA, realizado no período de 14 
	a 18 de outubro de 2013, no <i>campus</i> da 	Universidade Federal de Lavras.';
	
	$dataAtual = gmdate("d-m-Y");
	$dataMesAtual = explode("-", $dataAtual);

	$protocoloCodigo=date('Y').".".uniqid().".".str_pad(rand(15,99999), 5, "0", STR_PAD_LEFT);

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
	            http://www.prp.ufla.br/ciuflasig/certificados/<br />
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

	$inserirProtocoloSQL = 'INSERT INTO certificado_avaliador_protocolo (`protocolo`, `avaliador_id`, `data_geracao`,`evento_id`)
			VALUES ("'.$protocoloCodigo.'", "'.$certificadoId.'", "'.$dataGeracao.'","'.$certificadoIdevento.'");';

	$db->executar($inserirProtocoloSQL);

		require_once("dompdf/dompdf_config.inc.php");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($textoPDF);
		$dompdf->set_paper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream("certificado.pdf");

	}
?>