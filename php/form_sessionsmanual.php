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
		die("<alert>Evento nao encontrado!");
	$data = $res[0];
	$sql = "SELECT * FROM sessoes WHERE eventos_id='".$eid.
		"' ORDER BY id ASC;";
	$res = $db->consulta($sql);
	
	$sql = "SELECT * FROM sessoes WHERE eventos_id='".$eid.
		"' AND bic_jr=1 ORDER BY id ASC;";
	$resBic = $db->consulta($sql);
	//die(var_dump($res));
	if (count($res) == 0)
		$msg = "<i>Nenhuma sess&atilde;o definida ainda.</i>";
	else {
		$msg = "<br /><br />";
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
			$msg .= "<b>Organização da Sessão: </b>";
			$msg .= "<span id='ssec".$ses['id']."' style=".
				"'display: inline-block; border: 1px solid; ".
				"cursor: pointer; background: #bdf;' onClick='setBic(".$ses['id'].");sshide(".
				"\"csec".$ses['id']."\",\"hsec".$ses['id']."\",\"ssec".
				$ses['id']."\")'>&nbsp;+&nbsp;</span>";
			$msg .= "<span id='hsec".$ses['id']."' style=".
				"'display: none; border: 1px solid; ".
				"cursor: pointer; background: #bdf;' onClick='hhshow(".
				"\"csec".$ses['id']."\",\"hsec".$ses['id']."\",\"ssec".
				$ses['id']."\")'>&nbsp;-&nbsp;</span>";
			$msg .= "<span id='csec".$ses['id']."' style=".
				"'display: none; border: 0px solid; width: 92%; ".
				"min-height: 200px;'>";	
			$sql = "SELECT * FROM cursos ";
			$cursos = $db->consulta($sql);
			//die(var_dump($cursos));
			$msg .= "<form name='formulario' action='savesessionsmanual.php' method='POST' >";	
			$msg .= "<table border=1><tr><td><b><big>Curso:</big></b></td>".
					"<td><b>Total de Resumos:</b></td>".
					"<td><b>Resumos BIC Junior:</b></td>".
					"<td><b>Quantidade a ser remanejada:</b></td>".
					"<td><b>Remanejando BIC Júnior?</td></b>".
					"<td><b>Sessão Destino:</b></td></tr>";			
			$cursosExistentes[$ses['id']] = "";
			foreach ($cursos as $row => $curso){	
				//die(var_dump($curso));	
				$msg .= "<input type='hidden' name='id' id='id' value='".$eid."'/>";
				$msg .= "<input type='hidden' name='sessao' id='sessao' value='".$ses['id']."'/>";
				$msg .= "<input type='hidden' name='curso' id='curso' value='".$curso['id']."'/>";
				$sql = "SELECT SUM(resumos) FROM aux_sessoes WHERE eventos_id='".$eid."' AND ".
						"sessoes_id='".$ses['id']."' AND cursos_id='".$curso['id']."';";
				$soma = $db->consulta($sql);
				$sql = "SELECT SUM(resumos) FROM aux_sessoes WHERE eventos_id='".$eid."' AND ".
						"sessoes_id='".$ses['id']."' AND cursos_id='".$curso['id']."' AND bic_jr=1;";
				$somaBic = $db->consulta($sql);
				if($somaBic[0][0] == ""){
					$somaBic[0][0] = 0;
				}
				//die("soma:". var_dump($soma));
				if($soma[0][0] > 0){
					$cursosExistentes[$ses['id']] .= $curso['id'] . "/";
					$msg .= "<tr><td><b>";
					$msg .= $curso['nome'];
					$msg .= "<input type='hidden' name='nomecurso_".$ses['id']."_".$curso['id']."' id='nomecurso_".$ses['id']."_".$curso['id']."' value='".$curso['nome']."'/>";
					$msg .=	"</b></td>";
					$msg .= "<td><b>";
					$msg .= $soma[0][0];
					$msg .= "<input type='hidden' name='soma_".$ses['id']."_".$curso['id']."' id='soma_".$ses['id']."_".$curso['id']."' value='".$soma[0][0]."'/>";
					$msg .=	"</b></td>";
					$msg .= "<td><b>";
					$msg .= $somaBic[0][0];
					$msg .= "<input type='hidden' name='somaBic_".$ses['id']."_".$curso['id']."' id='somaBic_".$ses['id']."_".$curso['id']."' value='".$somaBic[0][0]."'/>";
					$msg .=	"</b></td>";
					$msg .= "<td><b>";
					$msg .= "<input type='text' name='qntRem_".$ses['id']."_".$curso['id']."' id='qntRem_".$ses['id']."_".$curso['id']."' />";
					$msg .=	"</b></td>";
					$msg .= "<td><b>";
					$msg .= "<select id='bic_jr_".$ses['id']."_".$curso['id']."' name='bic_jr_".$ses['id']."_".$curso['id']."' onChange='CheckBic(".$ses['id'].") ; SelectSessoes(".$ses['id'].")'>".
							"<option value='0' selected>NÃO</option>".
							"<option value='1' >SIM</option>";
					$msg .= "</select>";
					$msg .= "</b></td>";
					$msg .= "<td><b>";
					$msg .= "<select style='display:block' name='sessaoDestino_".$ses['id']."_".$curso['id']."' id='sessaoDestino_".$ses['id']."_".$curso['id']."' >".
							"<option value='0' selected>---Selecionar---</option>";
					for($i = 0; $i< count($res); $i++){
						$msg .= "<option value='".$res[$i]['id']."'>Sessão ".$res[$i]['id']."</option>";
					}
					$msg .=	"</select>";
					$msg .= "<select style='display:none' name='sessaoDestinoBic_".$ses['id']."_".$curso['id']."' id='sessaoDestinoBic_".$ses['id']."_".$curso['id']."' >".
							"<option value='0' selected>---Selecionar---</option>";
					for($i = 0; $i< count($resBic); $i++){
						$msg .= "<option value='".$resBic[$i]['id']."'>Sessão ".$resBic[$i]['id']."</option>";
					}
					$msg .=	"</select>";
					$msg .= "</b></td>";
					$msg .= "</tr>";	
				}
			}	
			//if($ses['id'] == 2)
			//die(var_dump($cursosExistentes[$ses['id']]));
			$msg .= "<input type='hidden' name='cursosExistentes_".$ses['id']."' id='cursosExistentes_".$ses['id']."' value='".$cursosExistentes[$ses['id']]."'/>";
			
			$msg .= "<table align='center'>";
			$msg .= "<tr>";
			$msg .= "<td><button type='submit' name='Enviar' value='Enviar' onClick='return checkFields(".$ses['id'].")'>Realizar<br>Mudanças</button></td>";	
			$msg .= "</tr>";
			$msg .= "</table>";
			$msg .= "</table>";
			$msg .= "</form>";
			$msg .= "</span><br />";
		}
	}
?>

<h2>Sess&otilde;es de P&ocirc;ster</h2>
<p>Administrador, preencha os campos referentes às mudanças que deseja fazer e clique no botão "Realizar Mudanças", existente no final da tabela de cada sessão.</p>
<?php echo $msg; ?>
