<?php

	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if (!isset($_GET['id']))
		die("<alert>Requisicao invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento não encontrado!");
	$data = $res[0];
	$sql = "SELECT * FROM resumos_recusados WHERE eventos_id='".$eid."' ORDER BY cursos_id,autor1;";
	$resumos = $db->consulta($sql);
	if (count($resumos) == 0)
		$msg = "<i>Nenhum resumo recusado ainda.</i>";
	else {
			
		$msg = "";
			
		$lastCurso = 0;
		$r = 0;
		if(count($resumos)>0){
			foreach ($resumos as $r => $resum) {
				if ($resum['cursos_id'] != $lastCurso) {
					if ($lastCurso != 0){
						$msg .= "<tr>";
						$msg .= "<td><b>TOTAL DE RESUMOS:" . "</b></td>";
						$msg .= "<td><b>" . ($r-$rIni) . "</b></td>";
						$msg .= "</tr>";
						$msg .= "</table>";
						
					}
					$rIni = $r; 
					$lastCurso = $resum['cursos_id'];
					$msg .= "<center><h2>";
					$sql = "SELECT * FROM cursos WHERE id='".
						$resum['cursos_id']."';";
					$curso = $db->consulta($sql);
					$msg .= $curso[0]['nome'];
					$msg .= "</h2></center>";
					$msg .= "<table border=1><tr><th>".
						"N<sup>o</sup>:</th><th>Apresentador:".
						"</th><th>T&iacute;tulo:</th>".
						"<th>Gerar PDF:</th></tr>";
				}
				$msg .= "<tr>";
				$msg .= "<td>".($r+1)."</td>";
				$msg .= "<td>".$resum['autor1']."</td>";
				$msg .= "<td>".$resum['titulo']."</td>";
				$msg .= "<td><a target='_blank' href='./generateResumoRecusadoPDF.php?id=".$resum['id']."' onclick='document.forms[''].submit();'>Clique aqui</a></td>";
				$msg .= "</tr>";
			
			}
		}else{
			$msg.="Nenhum dado cadastrado";
		}
			
			
			
			$msg .= "<tr>";
			$msg .= "<td><b>TOTAL DE RESUMOS:" . "</b></td>";
			$msg .= "<td><b>" . (count($resumos) - $rIni) . "</b></td>";
			$msg .= "</tr>";
			$msg .= "</table>";
	
	}
?>
<h2>Resumos Recusados</h2><br /><hr /><br />
<?php echo $msg; ?>

