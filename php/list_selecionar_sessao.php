<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if ((!isset($_GET['eid'])) ||
		(!isset($_GET['uid'])))
			die("<alert>Requisicao Invalida!");
	$eid = $_GET['eid'];
	$uid = $_GET['uid'];
	$db = new Database();
	$sql = "SELECT * FROM usuarios WHERE id='".$uid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Usuario Invalido!");
	$user = $res[0];
	if (strtoupper(trim($user['email'])) != strtoupper(trim($_SESSION['email'])))
		die("<alert>Requisicao Invalida!");
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento Invalido!");
	$evento = $res[0];
	$term = @strtotime($evento['termino_selecionar_sessao']);
	$sql = "SELECT * FROM resumos WHERE ".
		"eventos_id='".$_SESSION['eid']."' AND ".
		"usuarios_id='".$_GET['uid']."' ORDER BY id,titulo;";
	$res = $db->consulta($sql);
	
	$sql = "SELECT * FROM resumos_recusados WHERE eventos_id='".$_SESSION['eid']."' AND usuarios_id='".$_GET['uid']."';";
	$resumos_recusados = $db->consulta($sql);
	$nResumosRecusados = count($resumos_recusados);
	
	$resumos = "";
	$cursos = "";
	
	
	if (count($res) == 0) {
		echo "<i><b>Nenhum resumo foi submetido para que sua sessão possa ser selecionada.<b></i><br />";
		if ($nResumosRecusados > 0) {
			echo "<b><br />".
				"Você possui ".$nResumosRecusados.
				" resumo(s) recusado(s). Por favor, verifique-o(s)".
				"<span style='cursor: pointer; color: #248;' ".
					"onClick='resumos_recusados(".$uid.");'>".
					" clicando aqui.</span></center></b><br />";
		}
	} else {
		echo "<b><h2>".
			"Selecionar Sessões".
			"</h2></b>";
		echo "<h3>Selecione uma das sessões disponíveis na qual deseja apresentar seu(s) resumo(s) e clique em 'Salvar':</h3>";
		echo "<h4><font color='#dd0000'>Verifique com o(a) orientador(a) se ele(a) estará disponível para comparecer na sessão selecionada.</font></h4>";
		echo "<h4><font color='#dd0000'>A PRP poderá, a seu critério, designar outra sessão para apresentação.</font></h4>";
		
		if ($nResumosRecusados >= 0) {
			echo "<b>".
				"Você possui ".$nResumosRecusados.
				" resumo(s) recusado(s). Por favor, verifique-o(s)".
				"<span style='cursor: pointer; color: #248;' ".
					"onClick='resumos_recusados(".$uid.");'>".
					" clicando aqui.</span></center></b><br /><br /><br /><hr>";
		}
		
		$esconde = 0;
		foreach ($res as $i => $row){
			if($user['bic_jr'] == 1){
					$sql = "SELECT a.*, s.horario FROM aux_sessoes a INNER JOIN sessoes s
					ON (s.id = a.sessoes_id AND s.eventos_id = '".$eid."') WHERE a.eventos_id='".$eid."' AND a.bic_jr='".$user['bic_jr']."' AND ".
							" a.cursos_id='".$row['cursos_id']."' ORDER BY a.sessoes_id;";
				$sessoes = $db->consulta($sql);
			}
			else{
				$sql = "SELECT a.*, s.horario FROM aux_sessoes a INNER JOIN sessoes s 
				ON (s.id = a.sessoes_id AND s.eventos_id = '".$eid."') WHERE a.eventos_id='".$eid."' AND a.cursos_id='".$row['cursos_id']."' AND a.bic_jr='".$user['bic_jr']."' ".
						" ORDER BY a.sessoes_id;";
				$sessoes = $db->consulta($sql);
				//die(var_dump($sessoes, $eid, $row['cursos_id'], $user['bic_jr']));
				//die($sql);
			}
			$resumos .= $row['id']."/"; 
			$cursos .= $row['cursos_id']."/";
			echo "<form name='selecionarSessao' action='selecionarSessoes.php' method='POST' >";
			echo "<input type='hidden' name='eid' id='eid' value='".$eid."'/>";
			echo "<input type='hidden' name='uid' id='uid' value='".$uid."'/>";
			echo "<input type='hidden' name='status_".$row['id']."' id='status_".$row['id']."' value='".$row['status_selecao']."'/>";
			echo "<input type='hidden' id='nome_aluno' name='nome_aluno' value='".$user['nome']."'>";
			echo "<input type='hidden' id='bic_jr' name='bic_jr' value='".$user['bic_jr']."'>";
			if($row['status_selecao'] == 0){
				echo "<span id='res".$i."' style='display:block'>";
				echo "<b>ID:</b> ".$row['id']."-".$row['eventos_id'].
					"-".$row['usuarios_id']." &nbsp;&nbsp;&nbsp;&nbsp; ".
					"&bull; <b>".$row['fomento']."</b> &bull; ";
				echo "<span style='float: right; color: #248;'>";
				//if ($term >= time()) {
				if ($evento['termino_selecionar_sessao'] >= date('Y-m-d')){
					echo "<select name='sessoes_".$row['id']."' id='sessoes_".$row['id']."' >".
								"<option value='0' selected>---Selecionar---</option>";
						for($i = 0; $i< count($sessoes); $i++){
							echo "<option value='".$sessoes[$i]['sessoes_id']."'>Sessão ".$sessoes[$i]['sessoes_id']." - ".$sessoes[$i]['horario']."</option>";
						}
					echo "</select>";	
				}
				echo "</span><br />";
				echo "<b>T&iacute;tulo:</b> ".$row['titulo']."<br />";
				echo "<b>Palavras-Chave:</b> ".str_replace("|||", ";", $row['palavras_chave']);
				echo "<hr /></span><br /><br />";	
			}
			else{
				$esconde +=1;
			}
		}
		echo "<input type='hidden' id='resumos' name='resumos' value='".$resumos."'>";
		echo "<input type='hidden' id='cursos_id' name='cursos_id' value='".$cursos."'>";
		if($esconde != ($i+1)){
			echo "<center><button type='submit' name='Enviar' id='Enviar' value='Enviar' onClick='return CheckSelecionaSessao()'>Salvar</button></center>";
		}
		else{
			echo "<i>Todos os resumos aprovados que você possui já passaram pelo processo de Seleção de Sessões.</i><br>";
		}	
		echo "</form>";
	}
	
	
?>