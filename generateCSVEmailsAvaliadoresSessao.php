<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");
	
	header("Content-type: application/csv");   
	header("Content-Disposition: attachment; filename=emails_avaliadores_sessao.csv");   
	header("Pragma: no-cache");
	
	if (!isset($_GET['id']))
		die("Requisicao Invalida!");
	$eid = $_GET['id'];
	$db = new Database();  
	  
	$sql = "SELECT r.sessoes_id, CONCAT('\"', GROUP_CONCAT(DISTINCT a.email ORDER BY r.sessoes_id SEPARATOR ';'), '\"') 'emails',COUNT(DISTINCT a.email) AS qtd_emails, ".
			"COUNT(r.numero_poster) AS qtd_posteres FROM resumos r LEFT JOIN avaliador a ON (r.id_avaliador = a.id) ".
			"INNER JOIN cursos c ON (c.id = r.cursos_id) WHERE r.eventos_id ='".
			$_GET['id']."' GROUP BY sessoes_id ORDER BY r.sessoes_id;";
			
	$cabecalho = "ID Sessão;E-mails;Qtd. E-mails;Qtd. Pôsteres";
	echo $cabecalho;
	echo "\n";
	
	$rs = mysql_query($sql) or die ('table_from_doom');  
	while ($ret = mysql_fetch_assoc($rs))  
	{  
		echo implode(';', $ret);  
		echo "\n";  
	} 
?>