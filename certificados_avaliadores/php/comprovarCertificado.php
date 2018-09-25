<?php
	
	session_start();

	if(!isset($_POST["protocolo"])) {
		die("Requisiчуo invсlida.");
	}

	require_once 'db/DBUtils.class.php';

	$db = new DBUtils();

	$protocolo = $_POST["protocolo"];

	/*$procurarProtocoloSQL = "SELECT cp.protocolo, cp.data_geracao, a.nome, e.edicao
							FROM certificado_avaliador_protocolo cp 
							INNER JOIN avaliador a
							ON (a.id = cp.avaliador_id)
							INNER JOIN eventos e
							ON (cp.evento_id = e.id)
							WHERE cp.protocolo = '".$protocolo."';";*/
							
	$procurarProtocoloSQL = "SELECT cpa.protocolo, cpa.data_geracao, cpa.evento_id, a.nome, r.titulo, e.edicao FROM certificado_avaliador_protocolo cpa
	INNER JOIN avaliador a
	ON (cpa.avaliador_id = a.id)
	LEFT JOIN resumos r
	ON (r.id_avaliador = a.id)
	LEFT JOIN eventos e
	ON (e.id = cpa.evento_id)
	WHERE cpa.protocolo = '".$protocolo."';";

	$certificado = $db->executarConsulta($procurarProtocoloSQL);

	if(!count($certificado)) {
		echo "0";
	} else {
		echo json_encode($certificado);
	}

?>