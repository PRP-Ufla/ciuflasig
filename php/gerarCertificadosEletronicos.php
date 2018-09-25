<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");
	if (!isset($_GET['id']))
		die("Requisicao Invalida!");
		
	$eid = $_GET['id'];
	$db = new Database();
	
	$sql = "INSERT INTO certificado (usuario_id, resumo_id, evento_id) ".
		"SELECT usuarios_id, id, eventos_id ".
		"FROM resumos ".
		"WHERE eventos_id ='".
		$_GET['id']."' AND ausente = 0;";
		
	$res = $db->executar($sql);
	
	if ($res == 1) {
		echo "<script>
				alert('Certificados virtuais gerados com sucesso!');
				window.location.replace('adminevent.php?id=".$eid."');
			  </script>";
	}
	
	else if ($res == 0) {
		echo "<script>
				alert('Falha na geração dos certificados virtuais.');
				window.location.replace('adminevent.php?id=".$eid."');
			  </script>";
	}
	
	//header("Location: adminevent.php?id=".$eid);
?>