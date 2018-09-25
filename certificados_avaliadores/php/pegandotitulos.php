<?php
	
	session_start();

	if(!isset($_POST["protocolo"])) {
		die("Requisiчуo invсlida.");
	}

	require_once 'db/DBUtils.class.php';

	$db = new DBUtils();

	$protocolo = $_POST["protocolo"];
	$evento_id = $_GET["evento_id"];

	$procurarProtocoloSQL = "SELECT r.titulo FROM resumos r INNER JOIN certificado_avaliador_protocolo cpa
							ON r.id_avaliador = cpa.avaliador_id WHERE protocolo = '".$protocolo."' AND r.eventos_id = '".$evento_id."';";

	$certificado = $db->executarConsulta($procurarProtocoloSQL);

	if(!count($certificado)) {
		echo "0";
	} else {
		echo json_encode($certificado);
	}

?>