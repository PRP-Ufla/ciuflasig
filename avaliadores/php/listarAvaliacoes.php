<?php
		
	session_start();
	
	if(!isset($_SESSION['avaliadorId'])) {
		die("Requisição Inválida.");
	}

	require_once 'config/GeralConfig.class.php';
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$evento_id = GeralConfig::getEventoId();

	$procurarAvaliadoresSQL = 'SELECT v.id, v.sessao_id, av.nome, c.nome as cursoNome, s.horario FROM avaliacoes a 
								INNER JOIN avaliador av 
								ON (av.id = a.avaliador_id) 
								INNER JOIN vaga v 
								ON (v.id = a.vaga_id AND v.evento_id = "'.$evento_id.'") 
								INNER JOIN sessoes s 
								ON (s.id = v.sessao_id AND s.eventos_id = "'.$evento_id.'") 
								INNER JOIN cursos c 
								on (c.id = v.curso_id) 
								WHERE a.avaliador_id = '.$_SESSION['avaliadorId'].';';

	$avaliacoes = $db->executarConsulta($procurarAvaliadoresSQL);

	echo json_encode($avaliacoes);


?>