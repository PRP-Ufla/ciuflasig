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
	
	$sql = 'SELECT * FROM avaliacoes WHERE avaliador_id = '.$avaliadorId.' AND vaga_id = '.$vagaId.';';
	$sess = $db1 -> consulta($sql);
	
	if (count($res) == 0){
		echo "0";
	}
	
	else if (count($sess) > 0) {
		echo "1";
	}
	
	else {
		$decrementarDisponibilidadeDeVagaSQL = 'UPDATE vaga SET disponiveis = disponiveis-1 WHERE id = '.$vagaId.';';

		$avaliacoesSQL = 'INSERT INTO avaliacoes (avaliador_id, vaga_id) VALUES ("'.$avaliadorId.'", "'.$vagaId.'");';

		if(!($db->executar($decrementarDisponibilidadeDeVagaSQL) && $db->executar($avaliacoesSQL))) {
			echo "Erro, SQL: ".$decrementarDisponibilidadeDeVagaSQL;
		}
	}

?>