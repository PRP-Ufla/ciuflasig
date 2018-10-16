<?php
	
	session_start();
	
	if(!isset($_SESSION['usuario']) || !isset($_POST['areaId'])) {
		die("Requisição Inválida.");
	}

	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$areaId = $_POST['areaId'];

	if($areaId == '6'){
		// Curso area 6 equivalente a bic_jr
		// A busca a baixo retorna todos os resumos dos primeiros autores setados como bic_jr

		$procurarResumoPorAreaSQL = 'SELECT resumos.* 
									FROM resumos
									INNER JOIN usuarios u ON (resumos.usuarios_id = u.id) 
									INNER JOIN eventos ON resumos.eventos_id=eventos.id 
									WHERE u.bic_jr = 1 AND  
									CURDATE() > eventos.termino_submissao AND 
									CURDATE() < eventos.termino 
									ORDER BY resumos.id';
	}
	else{
		/*$procurarResumoPorAreaSQL = 'SELECT resumos.* FROM resumos INNER JOIN eventos ON resumos.eventos_id=eventos.id WHERE cursos_id ='.$areaId.' AND  CURDATE() > eventos.termino_submissao AND CURDATE() < eventos.termino ';*/

		//Select nova, que não lista os bic_jr's
		$procurarResumoPorAreaSQL = 'SELECT resumos.* 
									FROM resumos
									INNER JOIN usuarios u ON (resumos.usuarios_id = u.id) 
									INNER JOIN eventos ON resumos.eventos_id=eventos.id 
									WHERE u.bic_jr = 0 AND  
									CURDATE() > eventos.termino_submissao AND 
									CURDATE() < eventos.termino 
									ORDER BY resumos.id';
	}
	$resumos = $db->executarConsulta($procurarResumoPorAreaSQL);

	echo json_encode($resumos);	

?>