<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");
	
	header("Content-type: application/csv");   
	header("Content-Disposition: attachment; filename=avaliador_sessao_poster.csv");   
	header("Pragma: no-cache");
	
	if (!isset($_GET['id']))
		die("Requisicao Invalida!");
	$eid = $_GET['id'];
	$db = new Database();  
	  
	$sql = "SELECT concat(\"Sessão \", r.sessoes_id,\" - \", s.horario) 'sessao', c.nome AS area, a.nome AS avaliador,".
			"COUNT(r.numero_poster) AS qtd_posteres, ".
			"CONCAT('\"', GROUP_CONCAT(r.numero_poster ORDER BY r.numero_poster SEPARATOR ';'), '\"') 'posteres' ".
			"FROM resumos r LEFT JOIN avaliador a ON (r.id_avaliador = a.id) INNER JOIN cursos c ON (c.id = r.cursos_id) ".
			"INNER JOIN sessoes s ON (s.id = r.sessoes_id AND s.eventos_id = r.eventos_id) WHERE r.eventos_id ='".
			$_GET['id']."' GROUP BY id_avaliador, sessoes_id ORDER BY r.sessoes_id, MIN(r.numero_poster);";
	
	$cabecalho = "Sessão;Área;Avaliador;Qtd. Pôsteres;Pôsteres";
	echo $cabecalho;
	echo "\n";
	
	$rs = mysql_query($sql) or die ('table_from_doom');  
	while ($ret = mysql_fetch_assoc($rs))  
	{  
		echo implode(';', $ret);  
		echo "\n";  
	} 
?>