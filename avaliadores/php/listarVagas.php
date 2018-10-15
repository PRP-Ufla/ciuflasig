<?php
		
	session_start();
	
	if(!isset($_SESSION['avaliadorId']) || !isset($_SESSION['permissao'])) {
		die("Requisição Inválida.");
	}

	if($_SESSION['permissao'] == 0) {
		die("Você não tem permissão necessária.");
	}

	require_once 'config/GeralConfig.class.php';
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$evento_id = GeralConfig::getEventoId();

	$procurarVagasSQL = 'SELECT v.id, v.sessao_id, c.nome AS cursoNome, s.horario, v.disponiveis, ava.total AS total, aux.resumos
						FROM vaga v

						INNER JOIN cursos c
						ON (c.id = v.curso_id)

						INNER JOIN sessoes s
						ON (s.id = v.sessao_id AND s.eventos_id = "'.$evento_id.'")

						-- Para pegar resumos de bic_jrs e não bic_jrs sem separa-los
						INNER JOIN
							(SELECT aux.eventos_id, aux.sessoes_id, aux.cursos_id, SUM(aux.resumos) AS resumos
							FROM aux_sessoes aux 
							WHERE aux.eventos_id = "'.$evento_id.'"
							GROUP BY aux.eventos_id, aux.sessoes_id, aux.cursos_id) aux
						ON (aux.cursos_id = v.curso_id AND aux.sessoes_id = v.sessao_id)

						-- Pegando as vagas que já foram avaliadas
						LEFT JOIN 
							(SELECT v.curso_id, v.sessao_id, COUNT(v.curso_id) AS total
							FROM avaliacoes a 
							INNER JOIN vaga v
							ON(a.vaga_id = v.id)
							WHERE v.evento_id = "'.$evento_id.'"
							
							GROUP BY v.curso_id, v.sessao_id) ava 
						ON (ava.curso_id = v.curso_id AND ava.sessao_id = v.sessao_id)

						WHERE v.evento_id = "'.$evento_id.'"';

	$vagas = $db->executarConsulta($procurarVagasSQL);

	echo json_encode($vagas);

?>