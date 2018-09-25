<?php
	@include("static/basicheaders.php");
	@include("php/class_database.php");
	@include("cfg/config_months.php");

	
	$db = new Database();
	
	
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=1 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "<br/>";
	echo "SESSAO 1</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=2 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "</br></br>SESSAO 2</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=3 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "</br></br>SESSAO 3</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=4 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "</br></br>SESSAO 4</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=5 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "</br></br>SESSAO 5</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=6 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "</br></br>SESSAO 6</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=7 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "</br></br>SESSAO 7</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=8 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "</br></br>SESSAO 8</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
	$sql = "SELECT usuarios.nome, usuarios.matricula, sessoes.horario, resumos.sessoes_id FROM `resumos` INNER JOIN usuarios ON (usuarios.id=resumos.usuarios_id) INNER JOIN sessoes ON(resumos.sessoes_id=sessoes.id) WHERE sessoes.eventos_id=4 AND sessoes.id=9 ORDER BY sessoes.horario";
	$res = $db->consulta($sql);
	$i=0;
	echo "</br></br>SESSAO 9</br></br>";
	foreach ($res as $i => $data) {
			echo "NOME: ".$data["nome"]." - MATRICULA: ".$data["matricula"]." - HORARIO: ".$data["horario"]."</br>";
	}
?>