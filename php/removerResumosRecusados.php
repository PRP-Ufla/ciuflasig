<?php

	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if (!isset($_GET['eid']))
		die("<alert>Requisicao invalida!");
	$eid = $_GET['eid'];
	$db = new Database();
	
	$sql1 = "INSERT INTO `resumos_recusados`(`eventos_id`, `usuarios_id`, `cursos_id`, `sessoes_id`, `data_selecao`, `status_selecao`, `resumo`,".
			"`titulo`, `palavras_chave`, `fomento`, `autor1`, `autor2`, `autor3`, `autor4`, `autor5`, `autor6`, `info_autor1`, `info_autor2`,".
			"`info_autor3`, `info_autor4`, `info_autor5`, `info_autor6`, `status_avaliacao`, `parecer_avaliacao`, `ausente`, `resumo_backup`,".
			"`id_avaliador`, `numero_poster`, `departamento`, `autor_orientador`, `local_pesquisa`)".
			" SELECT `eventos_id`, `usuarios_id`, `cursos_id`, `sessoes_id`, `data_selecao`, `status_selecao`, `resumo`,".
			"`titulo`, `palavras_chave`, `fomento`, `autor1`, `autor2`, `autor3`, `autor4`, `autor5`, `autor6`, `info_autor1`, `info_autor2`,".
			"`info_autor3`, `info_autor4`, `info_autor5`, `info_autor6`, `status_avaliacao`, `parecer_avaliacao`, `ausente`, `resumo_backup`,".
			"`id_avaliador`, `numero_poster`, `departamento`, `autor_orientador`, `local_pesquisa` FROM resumos WHERE status_avaliacao = 2".
			" AND eventos_id=".$eid.";";
	$res1 = $db->executar($sql1);
	if ($res1 == 0)
		die("<alert>Evento não encontrado!");

	$sql2 = "DELETE FROM resumos WHERE status_avaliacao = 2 AND eventos_id=".$eid.";";
	$res2 = $db->executar($sql2);
	if ($res2 == 0)
		die("<alert>Evento não encontrado!");
	
	header("Location: ../adminevent.php?id=".$eid);
?>