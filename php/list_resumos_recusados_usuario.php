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
	
	$sql = "SELECT r.*, s.horario FROM resumos_recusados r LEFT JOIN sessoes s
			ON(s.id = r.sessoes_id AND s.eventos_id='".$_SESSION['eid']."') 
			WHERE r.eventos_id='".$_SESSION['eid']."' AND ".
		"r.usuarios_id='".$_GET['uid']."' ORDER BY r.id,r.titulo;";
		$res = $db->consulta($sql);
	if (count($res) == 0) {
		echo "<i>Nenhum resumo submetido foi recusado.</i><br />";
	} else {
		foreach ($res as $i => $row)
		{
			echo "<span id='res".$i."'>";
			echo "<b>ID:</b> ".$row['id']."-".$row['eventos_id'].
				"-".$row['usuarios_id']." &nbsp;&nbsp;&nbsp;&nbsp; ".
				"&bull; <b>".$row['fomento']."</b> &bull; ";
			echo "<span style='float: right; color: #248;'>";
			echo "<span style='cursor: pointer;' ".
				"onClick='openResumoRecusado(".$row['id'].");'>".
				"Abrir</span>";

			echo "</span><br />";
			echo "<b>T&iacute;tulo:</b> ".$row['titulo']."<br />";
			echo "<b>Palavras-Chave:</b> ".str_replace("|||", ";", $row['palavras_chave'])."<br />";
			echo"<b>Resumo recusado.</b>";
			echo "<hr /></span>";
		}
	}
	
	$nResumos = count($res);
	echo "<br /><b><center>".
			"Você possui ".$nResumos.
			" resumo(s) recusado(s).</center></b><br />";
?>