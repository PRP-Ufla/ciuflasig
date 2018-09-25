<?php
	
	if(!isset($_POST["usuario"]) || !isset($_POST["senha"])) {
		die("Requisiчуo invсlida.");
	}

	require_once 'db/DBUtils.class.php';
	
	$db = new DBUtils();

	$usuario = $_POST["usuario"];
	$senha = $_POST["senha"];
	
	$procurarUsuarioSQL = "SELECT * FROM avaliador
							WHERE email = '".$usuario."' AND senha = '".sha1($senha)."' AND permissao = '1';";

	$usuario = $db->executarConsulta($procurarUsuarioSQL);

	if(count($usuario)) {

		$avaliadorId = $usuario[0]["id"];
		$procurarCertificadosSQL = "SELECT DISTINCT a.id AS id, a.nome AS nome FROM avaliador a
									INNER JOIN avaliacoes av ON(av.avaliador_id = a.id)
									WHERE a.permissao = '0' ORDER BY a.nome;";
		$certificados = $db->executarConsulta($procurarCertificadosSQL);

		$avaliadores = array();

		if(count($certificados)) {
			foreach($certificados as $valor) {
				$avaliador["id"] = $valor["id"];
				$avaliador["nome"] = $valor["nome"];
				array_push($avaliadores, $avaliador);
			}
			$data = array();
			$data['avaliadores'] = $avaliadores;
			session_start();
			$_SESSION['idUsuario'] = $usuario[0]['id'];
			echo json_encode($data);
		} else {
			//Nуo possuem certificados a serem emitidos
			echo 1;
		}
		
	} else {
		//Usuсrio invсlido.
		echo 0;
	}

?>