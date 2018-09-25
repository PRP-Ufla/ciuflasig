<?php

	session_start();
	
	if(!isset($_SESSION['avaliadorId']) || !isset($_SESSION['permissao']) || !isset($_POST['vagaId']) || !isset($_POST['avaliacaoId'])) {
		die("Requisição Inválida.");
	}

	if($_SESSION['permissao'] == 0) {
		die("Você não tem permissão necessária.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$vagaId = $_POST['vagaId'];
	$avaliacaoId = $_POST['avaliacaoId'];

	$atualizarVagaDisponiveisSQL = "UPDATE vaga SET disponiveis = disponiveis + 1 
									WHERE id = '".$vagaId."';";

	if(!$db->executar($atualizarVagaDisponiveisSQL)) {
		die("ERRO, SQL: ".$atualizarVagaDisponiveisSQL);
	}

	$removerAvaliacaoSQL = "DELETE FROM avaliacoes WHERE id = '".$avaliacaoId."';";

	if(!$db->executar($removerAvaliacaoSQL)){
		die("ERRO, SQL: ".$removerAvaliacaoSQL);
	}

?>