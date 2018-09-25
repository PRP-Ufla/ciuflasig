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
	$sql = "SELECT * FROM sessoes WHERE eventos_id='".$eid.
		"' ORDER BY id ASC;";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		$msg = "<i>Nenhuma sess&atilde;o definida ainda.</i>";
	else {
		$msg = "";
		foreach ($res as $s => $ses) {
			
			$sql = "SELECT sum(resumos) FROM aux_sessoes WHERE "
					."eventos_id='".$eid."' AND sessoes_id='".$ses['id']."';";
			$nResumos = $db->consulta($sql);
			$nRes = $nResumos[0][0];
			
			$msg .= "<hr /><br><h3 style='background-color: #D3D3D3; text-align:center; font-size: 30px;'>SESS&Atilde;O DE P&Ocirc;STERES ".$ses['id']."</h3>";
			$msg .= "<!--<b>N&uacute;mero de Resumos:</b> ".$nRes;
			$msg .= "<br />-->";
			//$msg .= "<b>Dia e Hor&aacute;rio:</b> ".$ses['horario'];
			//$msg .= "<br />";
			$msg .= "<center><span id='csec".$ses['id']."' style=".
				"'border: 0px solid; width: 92%; ".
				"min-height: 200px; '>";
			$lastCurso = 0;
			$sql = "SELECT * FROM resumos WHERE ".
				"eventos_id='".$eid."' AND ".
				"sessoes_id='".$ses['id']."' ORDER BY cursos_id,autor1";
			$resumos = $db->consulta($sql);
			$r=0;
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
					$msg .= "<br><center><h2 style='margin:0';>";
					$sql = "SELECT * FROM cursos WHERE id='".
						$resum['cursos_id']."';";
					$curso = $db->consulta($sql);
					$msg .= $curso[0]['nome'];
					$msg .= "</h2></center>";
					$msg .= "<b>Dia e Hor&aacute;rio:</b> ".$ses['horario']."<br><br>";
					$msg .= "<table border=1 width = 100% style='font-size: 14px;'><tr><th>".
						"N<sup>o</sup>:</th><th>Apresentador:".
						"</th><th>T&iacute;tulo:</th></tr>";
				}
				$msg .= "<tr>";
				$msg .= "<td>".($r+1)."</td>";
				$msg .= "<td>".$resum['autor1']."</td>";
				$msg .= "<td>".$resum['titulo']."</td>";
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
			$msg .= "</table>";
			$msg .= "</span></center><br />";
		}
		
	}
?>
<h2 style='text-align:center; font-size: 40px;'>SESS&Otilde;ES DE P&Ocirc;STERES</h2>
<?php echo $msg; ?>
