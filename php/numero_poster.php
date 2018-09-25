<?php

	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if (!isset($_GET['id']))
		die("<alert>Requisicao invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento não encontrado!");
	$data = $res[0];
	$sql = "SELECT * FROM sessoes WHERE eventos_id='".$eid.
		"' ORDER BY id ASC;";
	$res = $db->consulta($sql);

	if (count($res) == 0)
	echo  "<i>Nenhuma sess&atilde;o definida ainda.</i>";
	else {
		foreach ($res as $s => $ses) {
		$sql = "SELECT r.*,a.nome avaliador FROM resumos r LEFT JOIN avaliador a ON (r.id_avaliador = a.id) WHERE ".
				"r.eventos_id='".$eid."' AND ".
				"r.sessoes_id='".$ses['id']."' ORDER BY r.cursos_id,r.autor1";
			$resumos = $db->consulta($sql);
			$r=0;
			$lastCurso = 0;
			if(count($resumos)>0){
				foreach ($resumos as $r => $resum) {
				//$idResumo = $resumos[0]['id'];
				$x = $r + 1;
				$inserirNumero = "UPDATE resumos SET numero_poster = '".$x."' WHERE eventos_id = '".$eid."' AND id = '".$resum['id']."' ;";
				if (!$db->executar($inserirNumero)) echo "errado";
				}
			}else{
			echo "Não possui resumos";
			}

		}
	}
		header("Location: ../adminevent.php?id=".$eid);
?>

