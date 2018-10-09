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

	/*$procurarVagasSQL = 'SELECT v.id, v.sessao_id, c.nome as cursoNome, s.horario, v.disponiveis
								-- FROM vaga_aux v
								FROM vaga v
								INNER JOIN sessoes s
								ON (s.id = v.sessao_id AND s.eventos_id = "'.$evento_id.'")
								INNER JOIN cursos c
								ON (c.id = v.curso_id)
								
								WHERE v.evento_id =  "'.$evento_id.'"
								ORDER BY v.sessao_id;';*/

	/*$procurarVagasSQL = 'SELECT v.id, v.sessao_id, c.nome AS cursoNome, s.horario, v.disponiveis, a.resumos

						FROM vaga v
						INNER JOIN 
										-- Para pegar resumos de bic_jrs e não bic_jrs (sem separa-los)
										(SELECT aux.eventos_id, aux.sessoes_id, aux.cursos_id, SUM(aux.resumos) AS resumos
										FROM aux_sessoes aux 
										WHERE aux.eventos_id = "'.$evento_id.'"
										GROUP BY aux.eventos_id, aux.sessoes_id, aux.cursos_id) a
										
						ON (v.sessao_id = a.sessoes_id AND a.cursos_id = v.curso_id AND a.eventos_id = "'.$evento_id.'")

						INNER JOIN cursos c
						ON (c.id = v.curso_id)
						INNER JOIN sessoes s
						ON (s.id = v.sessao_id AND s.eventos_id = "'.$evento_id.'")
						GROUP BY a.eventos_id, a.sessoes_id, a.cursos_id';*/

	$procurarVagasSQL = 'SELECT v.id, v.sessao_id, c.nome AS cursoNome, s.horario, v.disponiveis, a.resumos, t.total
						FROM vaga v
						INNER JOIN 
										-- Para pegar resumos de bic_jrs e não bic_jrs sem separa-los
										(SELECT aux.eventos_id, aux.sessoes_id, aux.cursos_id, SUM(aux.resumos) AS resumos
										FROM aux_sessoes aux 
										WHERE aux.eventos_id = "'.$evento_id.'"
										GROUP BY aux.eventos_id, aux.sessoes_id, aux.cursos_id) a
										
						ON (v.sessao_id = a.sessoes_id AND a.cursos_id = v.curso_id AND a.eventos_id = "'.$evento_id.'")

						INNER JOIN cursos c
						ON (c.id = v.curso_id)
						INNER JOIN sessoes s
						ON (s.id = v.sessao_id AND s.eventos_id = "'.$evento_id.'")

						LEFT JOIN 
									(SELECT v.sessao_id, v.curso_id, v.evento_id, COUNT(v.id) AS total
									FROM avaliacoes a
									INNER JOIN vaga v
									ON (a.vaga_id = v.id)
									WHERE v.evento_id = "'.$evento_id.'"
									GROUP BY v.sessao_id, v.curso_id, v.evento_id
									ORDER BY total) t
						ON (t.sessao_id = v.sessao_id AND t.curso_id = v.curso_id)

						GROUP BY a.eventos_id, a.sessoes_id, a.cursos_id';

	$vagas = $db->executarConsulta($procurarVagasSQL);

	echo json_encode($vagas);

?>