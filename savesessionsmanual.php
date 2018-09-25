<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_admin.php");
	@include("../static/lock_admin.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	@include("./cfg/config_course_state.php");
	@include("../cfg/config_course_state.php");
	if (!isset($_POST['id']))
		die("Requisicao invalida!");
	$eid = $_POST['id'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Requisicao Invalida!");
	$sessaoAtual = $_POST['sessao'];
	$arrayCursos = $_POST['cursosExistentes_'.$sessaoAtual];
	$cursosExistentes = explode("/", $arrayCursos);
	$nCursos = count($cursosExistentes) - 1;
	//die(var_dump($nCursos). var_dump($arrayCursos). var_dump($cursosExistentes));
	for($j = 0; $j < $nCursos; $j++){
		$curso = $cursosExistentes[$j];
		$resRemanejar = $_POST['qntRem_'.$sessaoAtual."_".$curso];
		$sessaoDestino = $_POST['sessaoDestino_'.$sessaoAtual."_".$curso];
		if($sessaoDestino == 0){
			$sessaoDestino = $_POST['sessaoDestinoBic_'.$sessaoAtual."_".$curso];
		}
		$bicJr = $_POST['bic_jr_'.$sessaoAtual."_".$curso];
		//die("cursos existentes:" . var_dump($cursosExistentes). "sessao atual:" .$sessaoAtual . "curso:" . $curso . "resumos a remanejar:" . $resRemanejar . "sessao destino:" . $sessaoDestino . "bic jr?" . $bicJr);
		
		
		//TRATAR PARA MODIFICAR SOMENTE OS CAMPOS PREENCHIDOS PELO ADMINISTRADOR.
		if(!(($resRemanejar == "" || $resRemanejar == 0) && $sessaoDestino == 0)){
		//die("cursos existentes:" . var_dump($cursosExistentes). "sessao atual:" .$sessaoAtual . "curso:" . $curso . "resumos a remanejar:" . $resRemanejar . "sessao destino:" . $sessaoDestino);
			
			$sql = "SELECT * FROM aux_sessoes WHERE "
					."eventos_id='".$eid."' AND sessoes_id='".$sessaoAtual."'".
					" AND cursos_id='".$curso."' AND bic_jr='".$bicJr."';";
			if (!$db->executar($sql))
				die("Erro no SQL!<br />".$sql);
			$selectAtual = $db->consulta($sql);
			//die(var_dump($selectAtual));
			
			$sql = "SELECT * FROM aux_sessoes WHERE "
					."eventos_id='".$eid."' AND sessoes_id='".$sessaoDestino."'".
					" AND cursos_id='".$curso."' AND bic_jr='".$bicJr."';";
			if (!$db->executar($sql))
				die("Erro no SQL!<br />".$sql);
			$selectDestino = $db->consulta($sql);
			if (count($selectDestino) == 0){
				$sql = "INSERT INTO aux_sessoes(eventos_id, sessoes_id, cursos_id, resumos, bic_jr)".
						" VALUES ('".$eid."','".$sessaoDestino."','".$curso."',".
						"'".$resRemanejar."', '".$bicJr."');";
				if (!$db->executar($sql))
					die("Erro no SQL!<br />".$sql);	
				$nResSecAtual = ($selectAtual[0]['resumos'] - $resRemanejar); // variavel que recebe a quantidade de resumos que a sessao atual ficará após a mudança
				
				//TRATANDO QUANDO O NUMERO DE RESUMOS A SEREM REMANEJADOS = NUMERO DE RESUMOS QUE EXISTEM NA SESSAO ATUAL.
				if($selectAtual[0]['resumos'] == $resRemanejar){
					$sql = "DELETE FROM aux_sessoes WHERE "
							."eventos_id='".$eid."' AND sessoes_id='".$sessaoAtual."'".
							" AND cursos_id='".$curso."' AND bic_jr='".$bicJr."';";
					if (!$db->executar($sql))
						die("Erro no SQL!<br />".$sql);
				}
				else{
					$sql = "UPDATE aux_sessoes SET resumos='".$nResSecAtual."' WHERE "
							."eventos_id='".$eid."' AND sessoes_id='".$sessaoAtual."'".
							" AND cursos_id='".$curso."' AND bic_jr='".$bicJr."';";
					if (!$db->executar($sql))
						die("Erro no SQL!<br />".$sql);
				}
			}
			else{
				if($selectDestino[0]['bic_jr'] != $bicJr){
					$sql = "INSERT INTO aux_sessoes(eventos_id, sessoes_id, cursos_id, resumos, bic_jr)".
							" VALUES ('".$eid."','".$sessaoDestino."','".$curso."',".
							"'".$resRemanejar."', '".$bicJr."');";
					if (!$db->executar($sql))
						die("Erro no SQL!<br />".$sql);	
				}
				else{
					$nResSecDestino = ($selectDestino[0]['resumos'] + $resRemanejar); // variavel que recebe a quantidade de resumos que a sessao destino ficará após a mudança
					$sql = "UPDATE aux_sessoes SET resumos='".$nResSecDestino."' WHERE "
							."eventos_id='".$eid."' AND sessoes_id='".$sessaoDestino."'".
							" AND cursos_id='".$curso."' AND bic_jr='".$bicJr."';";
					if (!$db->executar($sql))
						die("Erro no SQL!<br />".$sql);
					$nResSecAtual = ($selectAtual[0]['resumos'] - $resRemanejar); // variavel que recebe a quantidade de resumos que a sessao atual ficará após a mudança
					
					//TRATANDO QUANDO O NUMERO DE RESUMOS A SEREM REMANEJADOS = NUMERO DE RESUMOS QUE EXISTEM NA SESSAO ATUAL.
					if($selectAtual[0]['resumos'] == $resRemanejar){
						$sql = "DELETE FROM aux_sessoes WHERE "
								."eventos_id='".$eid."' AND sessoes_id='".$sessaoAtual."'".
								" AND cursos_id='".$curso."' AND bic_jr='".$bicJr."';";
						if (!$db->executar($sql))
							die("Erro no SQL!<br />".$sql);
					}
					else{
						$nResSecAtual = ($selectAtual[0]['resumos'] - $resRemanejar);
						$sql = "UPDATE aux_sessoes SET resumos='".$nResSecAtual."' WHERE "
								."eventos_id='".$eid."' AND sessoes_id='".$sessaoAtual."'".
								" AND cursos_id='".$curso."' AND bic_jr='".$bicJr."';";
						if (!$db->executar($sql))
							die("Erro no SQL!<br />".$sql);
					}
				}
			}
		}
	}
	header("Location: adminevent.php?id=".$eid);
?>
