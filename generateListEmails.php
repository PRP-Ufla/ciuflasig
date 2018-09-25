<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");

	
	$db = new Database();
	
	
	$sql = "SELECT * FROM usuarios INNER JOIN resumos ON (usuarios_id=usuarios.id) WHERE usuarios.eventos_id=4";
	$res = $db->consulta($sql);
	$total=count($res);
	$i=0;
	echo "<br/>";
	foreach ($res as $i => $data) {
		if($data["email"]!="vitor.anacleto@gmail.com"){
			echo $data["email"]."; ";
		}
		
		if($i%20==0 && $i<>0){
			echo "<br/><br/><br/>";
		}
	}

?>