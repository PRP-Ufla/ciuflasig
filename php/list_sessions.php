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
		$msg = "<button ".
			"onClick='confirmation2();window.open(\"php/numero_poster.php?id=".$eid.
			"\",\"_self\")'>Gerar numeração para pôsteres</button><br /><br />";
		$msg .= "<button ".
			"onClick='window.open(\"./generateResumosPerEventPDF.php?id=".$eid.
			"\",\"_self\")'>Gerar PDF da lista de resumos</button><br /><br />";
		$msg .= "<button ".
			"onClick='window.open(\"php/list_sessions_simples.php?id=".$eid.
			"\",\"_blank\")'>Gerar HTML simplificado da lista de sessões</button><br /><br />";
		$msg .= "<button ".
			"onClick='window.open(\"./avaliadores/index.html".
			"\",\"_blank\")'>Gerar distribuição de pôsteres para avaliadores</button><br /><br />";
		$msg .= "<button ".
			"onClick='window.open(\"php/list_sessions_avaliador.php?id=".$eid.
			"\",\"_blank\")'>Gerar HTML simplificado de avaliadores</button><br /><br />";
		$msg .= "<button ".
			"onClick='window.open(\"./generateCSVAvaliadorSessaoPoster.php?id=".$eid.
			"\",\"_blank\")'>Gerar CSV avaliador/sessão/pôster</button><br /><br />";	
		$msg .= "<button ".
			"onClick='window.open(\"./generateCSVEmailsAvaliadoresSessao.php?id=".$eid.
			"\",\"_blank\")'>Gerar CSV dos e-mails dos avaliadores por sessão</button><br /><br />";				
		/*$msg .= "<button ".
			"onClick='confirmation2();window.open(\"php/numero_poster.php?id=".$eid.
			"\",\"_self\")'>Gerar Numeração para postêres</button><br /><br />";*/	
	
		foreach ($res as $s => $ses) {
			
			$sql = "SELECT sum(resumos) FROM aux_sessoes WHERE "
					."eventos_id='".$eid."' AND sessoes_id='".$ses['id']."';";
			$nResumos = $db->consulta($sql);
			$nRes = $nResumos[0][0];
			
			$msg .= "<hr /><h3>Sess&atilde;o ".$ses['id']."</h3>";
			$msg .= "<b>N&uacute;mero de Resumos:</b> ".$nRes;
			$msg .= "<br />";
			$msg .= "<b>Dia e Hor&aacute;rio:</b> ".$ses['horario'];
			$msg .= "<br />";
			$msg .= "<b>Lista: </b>";
			$msg .= "<span id='ssec".$ses['id']."' style=".
				"'display: inline-block; border: 1px solid; ".
				"cursor: pointer; background: #bdf;' onClick='sshide(".
				"\"csec".$ses['id']."\",\"hsec".$ses['id']."\",\"ssec".
				$ses['id']."\")'>&nbsp;+&nbsp;</span>";
			$msg .= "<span id='hsec".$ses['id']."' style=".
				"'display: none; border: 1px solid; ".
				"cursor: pointer; background: #bdf;' onClick='hhshow(".
				"\"csec".$ses['id']."\",\"hsec".$ses['id']."\",\"ssec".
				$ses['id']."\")'>&nbsp;-&nbsp;</span>";
			$msg .= "<center><span id='csec".$ses['id']."' style=".
				"'display: none; border: 0px solid; width: 92%; ".
				"min-height: 200px;'>";
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
					$msg .= "<center><h2>";
					$sql = "SELECT * FROM cursos WHERE id='".
						$resum['cursos_id']."';";
					$curso = $db->consulta($sql);
					$msg .= $curso[0]['nome'];
					$msg .= "</h2></center>";
					$msg .= "<table border=1><tr><th>".
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
			$msg .= "<form action='./generateResumosPerSessionPDF.php?id=".$eid."' method='POST'>";
			$msg .= "<input type='hidden' name='sesId' id='sesId' value='".$ses['id']."'>";
			$msg .= "<button type='submit' >Gerar PDF de Todos os Resumos da ".
					"Sess&atilde;o</button><br /><br />";
			$msg .= "</form>";
		}
		
	}
?>
<h2>Sess&otilde;es de P&ocirc;ster</h2>
<?php echo $msg; ?>