<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_admin.php");
	@include("../static/lock_admin.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	@include("./cfg/config_course_state.php");
	@include("../cfg/config_course_state.php");
	$db = new Database();
	$sql = "SELECT * FROM cursos ".
		"ORDER BY nome, id;";
	$result = $db->consulta($sql);
	if (count($result) == 0) {
		echo "<div style='width: 580px; height: 10px; ".
			"display: inline-block; background: #ccc; ".
			"margin: 0; padding: 10px 10px 10px 10px;'>".
			"<i>Nenhum curso cadastrado at&eacute; o momento.</i>".
			"</div>";
	} else {
		foreach ($result as $i => $row)
		{
			$bg = "background: #bfd;";
			if ($row['state'] != $ATIVO) {
				$bg = "background: #fbd;";
			}
			echo "<div class='itemlink' style='".$bg."'>";
			echo " ID#".$row['id']." - ".$row['sigla']." - ".
				$row['nome'];
			if ($row['state'] == $ATIVO) {
				echo "<div style='float: right; color: #b00;".
					"font-weight: bold; cursor: pointer;' ".
					"onClick='desativar(".$row['id'].");'>".
					"Desativar</div>";
			} else {
				echo "<div style='float: right; color: #0b0;".
					"font-weight: bold; cursor: pointer;' ".
					"onClick='ativar(".$row['id'].");'>".
					"Ativar</div>";
			}
			echo "</div>";
		}
	}
?>
 
