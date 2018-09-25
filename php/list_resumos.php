<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if ((!isset($_GET['eid'])) ||
		(!isset($_GET['uid'])))
			die("<alert>Requisicao Invalida!");
	$eid = $_GET['eid'];
	$uid = $_GET['uid'];
	$db = new Database();
	$sql = "SELECT * FROM usuarios WHERE id='".$uid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Usuario Invalido!");
	$user = $res[0];
	if (strtoupper(trim($user['email'])) != strtoupper(trim($_SESSION['email'])))
		die("<alert>Requisicao Invalida!!");
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento Invalido!");
	$evento = $res[0];
	$term = @strtotime($evento['termino_submissao']);
	$subIniday = @strtotime($evento['inicio_submissao']);
	$subTerday = @strtotime($evento['termino_submissao']);
	$selTerday = @strtotime($evento['termino_selecionar_sessao']);
	
	$sql = "SELECT r.*, s.horario FROM resumos r LEFT JOIN sessoes s
			ON(s.id = r.sessoes_id AND s.eventos_id='".$_SESSION['eid']."') 
			WHERE r.eventos_id='".$_SESSION['eid']."' AND ".
		"r.usuarios_id='".$_GET['uid']."' ORDER BY r.id,r.titulo;";
	$res = $db->consulta($sql);
	
	$sql = "SELECT * FROM resumos_recusados WHERE eventos_id='".$_SESSION['eid']."' AND usuarios_id='".$_GET['uid']."';";
	$resumos_recusados = $db->consulta($sql);

	if (count($res) == 0) {
		echo "<i>Nenhum resumo foi submetido.</i><br />";
	} else {
		foreach ($res as $i => $row)
		{
			echo "<span id='res".$i."'>";
			echo "<b>ID:</b> ".$row['id']."-".$row['eventos_id'].
				"-".$row['usuarios_id']." &nbsp;&nbsp;&nbsp;&nbsp; ".
				"&bull; <b>".$row['fomento']."</b> &bull; ";
			echo "<span style='float: right; color: #248;'>";
			echo "<span style='cursor: pointer;' ".
				"onClick='openResumo(".$row['id'].");'>".
				"Abrir</span>";
			//if ($term > time()) {
			if ($evento['termino_submissao'] >= date('Y-m-d')) {
				echo " | <span style='cursor: pointer;' ".
					"onClick='editResumo(".$row['id'].");'>".
					"Editar</span>";
				echo " | <span style='cursor: pointer;' ".
					"onClick='deleteResumo(".$row['id'].");'>".
					"Excluir</span>";
			}
			echo "</span><br />";
			echo "<b>T&iacute;tulo:</b> ".$row['titulo']."<br />";
			echo "<b>Palavras-Chave:</b> ".str_replace("|||", ";", $row['palavras_chave'])."<br />";
			

			if($row['status_selecao'] == 1 || $row['status_selecao'] == 2) {
					echo "<b>Sessão:</b> ".$row['sessoes_id'];
					echo "<br><b>Data e horário da sessão:</b> ".$row['horario'];	
			} else if($row['status_selecao'] == 0) {
					echo"<b>Sessão:</b> Você ainda não escolheu a sessão.";
				}
			echo "<hr /></span><br /><br />";
		}
	}
	
	$nResumos = $evento['resumos']-count($res);
	//if ($nResumos == 0 && (($subIniday <= @time()) && (@time() <= $subTerday))) // Ao utilizar strotime(linha 27) nas datas de submissão, o horário salvo era 00:00:00, o que gerava problema na comparação com a data atual
	if ($nResumos == 0 && (($evento['inicio_submissao'] <= date('Y-m-d')) && (date('Y-m-d') <= $evento['termino_submissao'])))
		echo "<br /><b><center>".
			"Voc&ecirc; n&atilde;o pode submeter mais nenhum resumo.".
			"</center></b><br />";
	//else if (($subIniday <= @time()) && (@time() <= $subTerday))
	else if (($evento['inicio_submissao'] <= date('Y-m-d')) && (date('Y-m-d') <= $evento['termino_submissao']))
		echo "<br /><b><center>".
			"Você ainda pode submeter mais ".$nResumos.
			" resumo(s).</center></b><br />";	
	
	$nResumosRecusados = count($resumos_recusados);
	if ($nResumosRecusados > 0) {
		echo "<b><center>".
			"Você possui ".$nResumosRecusados.
			" resumo(s) recusado(s). Por favor, verifique-o(s)".
			"<span style='cursor: pointer; color: #248;' ".
					"onClick='resumos_recusados(".$uid.");'>".
					" clicando aqui.</span></center></b><br />";
	}

?>