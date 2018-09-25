<?php
		
	session_start();
	
	/*if(!isset($_SESSION['avaliadorId'])) {
		die("Requisição Inválida.");
	}*/

	require_once 'config/GeralConfig.class.php';
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$evento_id = GeralConfig::getEventoId();

	//União de avaliadores do evento 6 com 7, certificados diferentes, logo
	//se o avaliador não for de um evento, será do outro.
	$procurarAvaliadoresSQL = '	SELECT YEAR(e.inicio) ano, e.edicao, e.id, r.id_avaliador
								FROM eventos e
								INNER JOIN resumos r ON r.eventos_id = e.id
								WHERE CURDATE( ) > e.termino
								AND r.eventos_id >6 
								AND r.id_avaliador = "'.$_GET['avaliadorId'].'" GROUP BY e.edicao DESC
								
								UNION
								
								SELECT YEAR(e.inicio) ano, e.edicao, v.evento_id AS id, a.avaliador_id AS id_avaliador
								FROM avaliacoes a
								INNER JOIN vaga v ON a.vaga_id = v.id
								INNER JOIN eventos e ON v.evento_id = e.id
								WHERE v.evento_id <=6
								AND a.avaliador_id = "'.$_GET['avaliadorId'].'" GROUP BY e.edicao DESC
								';
	
	$eventos = $db->executarConsulta($procurarAvaliadoresSQL);

	echo json_encode($eventos);


?>