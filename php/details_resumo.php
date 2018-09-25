<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if ((!isset($_SESSION['eid'])) ||
		(!isset($_GET['id'])) )
			die("<alert>Requisicao Invalida!");
	$db = new Database();
	$id = $_GET['id'];
	$sql = "SELECT * FROM resumos WHERE id='".$id."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Resumo Invalido!");
	$data = $res[0];
	$sql = "SELECT * FROM usuarios WHERE ".
		"eventos_id='".$_SESSION['eid']."' AND ".
		"email='".strtoupper(trim($_SESSION['email']))."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Usuario Invalido!");
	$user = $res[0];
	if ($data['usuarios_id'] != $user['id'])
		die("<alert>Posse invalida de resumo!");
	$sql = "SELECT * FROM cursos WHERE id='".
		$data['cursos_id']."';";
	$res = $db->consulta($sql);
	$curso = $res[0];
	$area = $curso['sigla']." - ".$curso['nome'];
	
	echo "<center><h2>Detalhes do Resumo</h2></center><br />";
	/*echo "<button onClick='window.open(\"generateResumoPDF.php?id=".
		$data['id']."\",\"_self\");'>Gerar PDF</button><br />";*/
	echo "<table border=0>";
	echo "<tr><th>ID:</th><td>".
		$data['id']."-".$data['eventos_id']."-".
		$data['usuarios_id']."</td></tr>";
	echo "<tr><th>T&iacute;tulo:</th><td>".
		$data['titulo']."</td></tr>";
	echo "<tr><th>Palavras-Chave:</th><td>".
		str_replace("|||", ";", $data['palavras_chave']."</td></tr>");
	echo "<tr><th>Institui&ccedil;&atilde;o de Fomento:</th><td>".
		$data['fomento']."</td></tr>";
	echo "<tr><th>&Aacute;rea:</th><td>".
		$area."</td></tr>";
	echo "<tr><th>Departamento:</th><td>".
		$data['departamento']."</td></tr>";
	echo "<tr><th>Local de Realiza&ccedil;&atilde;o da Pesquisa:</th><td>".
		$data['local_pesquisa']."</td></tr>";
	for ($i=1; $i<=6; $i = $i+1) {
		$aut = "autor".$i;
		$iaut = "info_autor".$i;

		if ($data['autor_orientador'] == $aut) {
			$autor_orientador = "Orientador(a)";
		} else {
			$autor_orientador = '';
		}
		
		if ($data[$aut] != "") {
			echo "<tr><th>".$i."<sup>o</sup> Autor:<br /><b>".$autor_orientador."</b></th><td><br />".
				$data[$aut]."<br />".$data[$iaut]."<br /></td></tr>";
		}
	}
	/*echo "<tr><th>Resumo:</th><td><br /><div style='".
		"border: 1px solid #248;'><textarea id='resumo-detail' style='color: #000;".
		" border: none; width: 380px; padding: 10px; height: 500px;'".
		" disabled>".$data['resumo']."</textarea></div></td></tr>";*/
	echo "<tr><th>Resumo:</th><td><br>".
		$data['resumo']."</td></tr>";
	
	echo "</table><br />";
	
	echo "<button onClick='resumo();'>&lt;&lt; Voltar</button>";
?>