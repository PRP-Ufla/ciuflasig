<?php
	
	session_start();

	if(!isset($_POST["protocolo"])) {
		die("Requisiчуo invсlida.");
	}

	require_once 'db/DBUtils.class.php';

	$db = new DBUtils();

	$protocolo = $_POST["protocolo"];

	$procurarProtocoloSQL = "SELECT cp.protocolo, cp.data_geracao,a.nome, e.edicao 
							FROM certificado_avaliador_protocolo cp 
							INNER JOIN avaliador a
							ON (a.id = cp.avaliador_id) INNER JOIN eventos e ON (cp.evento_id = e.id)
							WHERE cp.protocolo = '".$protocolo."';";

	$certificado = $db->executarConsulta($procurarProtocoloSQL);

	if(!count($certificado)) {
		echo "0";
	} else {
		echo json_encode($certificado);
	}

?>