<?php

	@include("./php/db/class_database.php");
	@include("../php/db/class_database.php");
	
	session_start();
	
	if(!isset($_SESSION['avaliadorId']) || !isset($_POST['vagaId'])) {
		die("Requisiчуo Invсlida.");
	}

	require_once 'db/DBUtils.class.php';
	
	$db = new DBUtils();
	$db1 = new Database();

	$avaliadorId = $_SESSION['avaliadorId'];
	$vagaId = $_POST['vagaId'];
	
	$sql = 'SELECT * FROM vaga WHERE id = '.$vagaId.' AND disponiveis > 0;';
	$res = $db1->consulta($sql);
	
	//Consulta para verificar se o avaliador estс avaliando a mesma vaga duas vezes
	//se tornou desnecessсrio devido a nova consulta logo a baixo
	// $sql = 'SELECT * FROM avaliacoes WHERE avaliador_id = '.$avaliadorId.' AND vaga_id = '.$vagaId.';';
	// $sess = $db1 -> consulta($sql);

	//Verifica se o avaliador estс escolhendo uma avaliaчуo da mesma sessуo e do mesmo evento
	$sql =	'SELECT *
					FROM vaga 
					JOIN avaliacoes 
					ON (vaga.id = avaliacoes.vaga_id)
					JOIN 
					(SELECT vaga.sessao_id AS sessao_id, vaga.evento_id AS evento_id 
							FROM vaga
							WHERE vaga.id = '.$vagaId.') AS vagaAtual
							ON (vaga.sessao_id = vagaAtual.sessao_id
							AND vaga.evento_id = vagaATual.evento_id)
					WHERE avaliacoes.avaliador_id = '.$avaliadorId.';';

	$sessao = $db1 -> consulta($sql);

	if (count($res) == 0){
		echo "0";
	}
	
	//Ler a linha 23
	// else if (count($sess) > 0) {
	// 	echo "1";
	// }

	else if (count($sessao) > 0){
		echo "1";
	}

	else {
		$decrementarDisponibilidadeDeVagaSQL = 'UPDATE vaga SET disponiveis = disponiveis - 1 WHERE id = '.$vagaId.';';

		$avaliacoesSQL = 'INSERT INTO avaliacoes (avaliador_id, vaga_id) VALUES ("'.$avaliadorId.'", "'.$vagaId.'");';

		if(!($db->executar($decrementarDisponibilidadeDeVagaSQL) && $db->executar($avaliacoesSQL))) {
			echo "Erro, SQL: ".$decrementarDisponibilidadeDeVagaSQL;
		}
	}

?>