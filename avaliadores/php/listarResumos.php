<?php
		
	session_start();
	
	if(!isset($_SESSION['avaliadorId'])) {
		die("Requisiчуo Invсlida.");
	}

	require_once 'config/GeralConfig.class.php';
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$evento_id = GeralConfig::getEventoId();

	$procurarAvaliadoresSQL = '	SELECT  r.sessoes_id,r.id, s.horario,r.titulo FROM resumos r INNER JOIN sessoes s ON (r.sessoes_id = s.id AND r.eventos_id = s.eventos_id )
								WHERE r.id_avaliador = '.$_SESSION['avaliadorId'].' AND r.eventos_id = "'.$evento_id.'" ORDER BY r.sessoes_id, r.id';

	$resumos = $db->executarConsulta($procurarAvaliadoresSQL);

	echo json_encode($resumos);


?>