<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_admin.php");
	@include("../static/lock_admin.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	$db = new Database();
	$today = @gmdate("Y-m-d");
	$sql = "SELECT * FROM eventos ".
		"ORDER BY inicio DESC,inicio_submissao DESC;";
	$result = $db->consulta($sql);
	if (count($result) == 0) {
		echo "<div style='width: 580px; height: 10px; ".
			"display: inline-block; background: #ccc; ".
			"margin: 0; padding: 10px 10px 10px 10px;'>".
			"<i>Nenhum evento cadastrado at&eacute; o momento.</i>".
			"</div>";
	} else {
		foreach ($result as $i => $row)
		{
			echo "<div class='itemlink'>";
			echo " <a href='adminevent.php?id=".$row['id'].
				"' target='_self' style='color: inherit;'>ID#".
				$row['id']." - ".$row['edicao'].
				" CIUFLA </a>";
			echo "</div>";
		}
	}
?>
