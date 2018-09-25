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
	if ($user['email'] != $_SESSION['email'])
		die("<alert>Requisicao Invalida!");
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento Invalido!");
	$evento = $res[0];
	$term = @strtotime($evento['termino_submissao']);
	$subIniday = @strtotime($evento['inicio_submissao']);
	$subTerday = @strtotime($evento['termino_submissao']);
	$selTerday = @strtotime($evento['termino_selecionar_sessao']);
	
	$sql = "SELECT * FROM resumos WHERE ".
		"eventos_id='".$_SESSION['eid']."' AND ".
		"usuarios_id='".$_GET['uid']."' ORDER BY id,titulo;";
	$res = $db->consulta($sql);
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
			if ($term > time()) {
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
			if(@time() > $selTerday && ($row['status_selecao'] == 1 || $row['status_selecao'] == 2)) {
				echo "<b>Sessão:</b> ".$row['sessoes_id'];	
			} else if(@time() > $selTerday && $row['status_selecao'] == 0) {
				echo"<b>Sessão:</b> O sistema ainda não escolheu a sua sessão.";
			}
			echo "<hr /></span><br /><br />";
		}
	}
	$nResumos = $evento['resumos']-count($res);
	if ($nResumos == 0 && (($subIniday <= @time()) && (@time() <= $subTerday)))
		echo "<br /><b><center>".
			"Voc&ecirc; n&atilde;o pode submeter mais nenhum resumo.".
			"</center></b><br />";
	else if(($subIniday <= @time()) && (@time() <= $subTerday))
		echo "<br /><b><center>".
			"Você ainda pode submeter mais ".$nResumos.
			" resumo(s).</center></b><br />";
?>