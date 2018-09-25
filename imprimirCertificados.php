<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");
	
	
	$InId = $_GET['inid'];
	$finId= $_GET['finid'];
	$cursoId=$_GET['curso'];
	
	$db = new Database();
	
	
	
	
	$sql="SELECT res.id as idR,res.titulo, res.usuarios_id, res.cursos_id, res.autor1, res.autor2, res.autor3, res.autor4, res.autor5, res.autor6, event.edicao, res.resumo, res.palavras_chave, res.fomento  FROM resumos res INNER JOIN eventos event ON (res.eventos_id= event.id) WHERE res.id>='".$InId."' AND res.cursos_id='".$cursoId."' AND  res.id<='".$finId."'";
	$res = $db->consulta($sql);
	
	$sql="SELECT * FROM cursos WHERE id='".$cursoId."'";
		$res2 = $db->consulta($sql);
	if(count($res)<=0){
		$break="";
	}else{
		$break="page-break-after: always;";
	}
	$div='<div style="width:650px; padding-left:1cm; padding-right:1.5cm; '.$break.' ">
  	<div id="principal">
  	<p align="right">&nbsp;</p>
  	<p>&nbsp;</p>
  	<p align="justify">AREA: '.$res2[0]['nome'].'<br />
  	Por favor, observe se este resumo contém o mínimo de informações necessárias para ser considerado um trabalho científico, isto é: introdução, material e métodos, resultados e conclusões.<br/><br/>
Se não tiver condições de ser apresentado no CIUFLA, por favor, emita um breve parecer nesta folha e o retorne à Pró-Reitoria de Pesquisa, logo que possível.<br/><br/>
Os resumos considerados adequados podem ser descartados.</p>
  	<div id="assinatura" align="center"></div>
  	</div>
	</div>';
	
	if(count($res)>=1){
		foreach ($res as $i=>$row){

			if($row["autor2"]!=""){
				$autor2="<br>".$row["autor2"];
			}
			if($row["autor3"]!=""){
				$autor3="<br>".$row["autor3"];
			}
			if($row["autor4"]!=""){
				$autor4="<br>".$row["autor4"];
			}
			if($row["autor5"]!=""){
				$autor5="<br>".$row["autor5"];
			}
			if($row["autor6"]!=""){
				$autor6="<br>".$row["autor6"];
			}
			$cursoId=$row["cursos_id"];
		$sql="SELECT * FROM cursos WHERE id='".$cursoId."'";
		$res = $db->consulta($sql);
		
		$div.='<div style="width:650px; padding-left:1cm; padding-right:1.5cm; page-break-after: always;">
  <div id="principal">
  	<p align="right"><strong>'.$row["edicao"].' CONGRESSO DE INICIAÇÃO CIENTÍFICA</strong></p>
	'.$res[0]["nome"].'<br>
      <strong>'.$row["titulo"].'</strong></br>
      <br>'.$row["autor1"].$autor2.$autor3.$autor4.$autor5.$autor6.'
    <p>Resumo:</p>
    <p align="justify">'.$row["resumo"].'
    </p>
    <p align="justify">Palavras-Chave: '.$row["palavras_chave"].'
    </p>
    <p align="justify"><br><br><br><br><br>Identificador deste resumo: '.$row["idR"].'-4-'.$row["usuarios_id"].'
    </p>
    <div id="assinatura" align="center"></div>
  </div>
</div>';
	}
}





	$texto='
<body>
<br/>
'.$div.'
</br>
</body>
	';
	$IdNome=($InId*$finId);
	
	require_once("../editais/dompdf/dompdf_config.inc.php");
	
	$dompdf = new DOMPDF();
	$dompdf->load_html($texto);
	$dompdf->set_paper('A4', 'portrait');
	$dompdf->render();
	$dompdf->stream("resumos-".$IdNome.".pdf");

	echo $texto;

?>