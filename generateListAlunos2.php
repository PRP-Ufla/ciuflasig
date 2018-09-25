<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");

	
	$db = new Database();
	
	
	$sql = "SELECT b.nome, c.horario, b.matricula  FROM resumos a INNER JOIN usuarios b ON(b.id=a.usuarios_id) INNER JOIN sessoes c ON(c.id=a.sessoes_id AND c.eventos_id=4) WHERE a.eventos_id=4 ORDER BY a.sessoes_id";
	$res = $db->consulta($sql);
	$i=0;
	echo '
	<table width="800" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>Nº</td>
    <td>Nome</td>
    <td>Sessao</td>
    <td>matricula</td>
  </tr>';
	$b=0;
	foreach ($res as $i => $data) {
	$b=$b+1;
			echo '
  <tr>
 	<td>'.$b.'</td>
    <td>'.$data["nome"].'</td>
    <td>'.$data["horario"].'</td>
    <td>'.$data["matricula"].'</td>
    </tr>';
	}
	echo '</table>';
?>