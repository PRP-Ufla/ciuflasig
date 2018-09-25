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
	$evento = $res[0];
	$sql = "SELECT * FROM cursos;";
	$cursos = $db->consulta($sql);
	$sql = "SELECT * FROM resumos WHERE eventos_id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<i>Nenhum resumo submetido neste evento ainda.</i>");
	$resumos = $res;
	$nResumos = count($resumos);
	
	if (!isset($_POST['act']))
		die("Requisicao Invalida!");
	if ($_POST['act'] == "update") {
		$sql = "DELETE FROM sessoes WHERE eventos_id='".$eid."';";
		if (!$db->executar($sql))
			die("Impossivel limpar sessoes!<br />".$sql);
	}
	
	// CADASTRA AS SESSÕES 
	
	$nSessoes = $evento['sessoes'];
	$idealResSec = (int) (count($resumos)/$nSessoes);
	$sql = "INSERT INTO sessoes (id,eventos_id,".
			"horario,resumos,bic_jr) VALUES ";
	for ($i=1; $i <= $nSessoes; $i++){
		if(($nSessoes != $i)){
			$sql .= "(".
					"'".$i."',".
					"'".$eid."',".
					"'".$_POST['horario'.$i]."',".
					"'".$idealResSec."',".
					"'".$_POST['bic_jr'.$i]."'),";
		}
		else {
			$sql .= "(".
				"'".$i."',".
				"'".$eid."',".
				"'".$_POST['horario'.$i]."',".
				"'".$idealResSec."',".
				"'".$_POST['bic_jr'.$i]."');";
		}
	}
	if (!$db->executar($sql))
		die("Erro no SQL!<br />".$sql);
	
	$sql = "SELECT * FROM sessoes WHERE eventos_id='".$eid."' AND bic_jr=1 ORDER BY id ASC";
	$sessoesBic = $db->consulta($sql);
	if (count($sessoesBic) == 0)
		die("Não há sessões selecionadas para alunos BIC Junior!");	
	$nSessoesBic = count($sessoesBic);
	foreach($sessoesBic as $j => $row){
		$secBic[] = $row['id'];
	}
		
	foreach ($cursos as $c => $curso){
		// INSERIR OS ALUNOS QUE SÃO BIC JUNIOR NAS SESSOES DA PARTE DA TARDE 			
		$sql = "SELECT a.*, b.bic_jr FROM resumos a ,usuarios b WHERE ". 
				"a.eventos_id='".$eid."' AND ".
				"a.usuarios_id=b.id AND b.bic_jr=1 ".
				"AND a.cursos_id='".$curso['id']."';";
		if (!$db->executar($sql))
			die("Erro no SQL!<br />".$sql);
		$bicJr = $db->consulta($sql);
		if (count($bicJr) > 0){ 
			$nResArea = count($bicJr); // quantos resumos por area.			
			if( $nResArea > 5){
				$nResInseridos = 5;
				$ideal = (int) ($nResArea/5); // numero de sessoes que a area ira ocupar, tomando 5 como ideal de resumos por sessao
				$trataResto = 1;
			}else{
				$nResInseridos = $nResArea;
				$ideal = 1;
				$trataResto = 0;
			}				
			$nMaxResSessao = (int) ($nResumos/$nSessoes); // limite de vagas por sessao(pode ser flexivel)
			$k = 0;
			$encheu = 0; // variavel que acresce 1 quando a sessao encher, para quando voltar a inserir, começar na proxima q tah vazia
			$secAlocadas = 0;// variavel que armazena em quantas sessoes foram alocados resumos.
			for($j=0; $j< $ideal; $j++){
				
				// TRATAMENTO PARA QUE A SESSAO NAO ULTRAPASSE O NUMERO DE RESUMOS PERMITIDO
				$sql = "SELECT SUM(resumos) somaresumos FROM aux_sessoes WHERE eventos_id='".$eid."'"
						." AND sessoes_id='".$secBic[$k]."';";
				$nResumosSec = $db->consulta($sql);
				$nResSec = $nResumosSec[0]['somaresumos'];
				//die("a". var_dump($nResSec));
				if($nResSec >= $nMaxResSessao){
					$k += 1;
					$encheu += 1;
				}
									
				if($k >= $nSessoesBic){
					$k = (0 + $encheu);
				}
				$sql = "SELECT * FROM aux_sessoes WHERE eventos_id='".$eid."' "
				."AND sessoes_id='".$secBic[$k]."' AND ".
				"cursos_id='".$curso['id']."' AND bic_jr=1;";
				$select = $db->consulta($sql);
				if (count($select) == 0){
					$sql = "INSERT INTO aux_sessoes(eventos_id, sessoes_id, cursos_id, resumos, bic_jr)".
							" VALUES ('".$eid."','".$secBic[$k]."','".$curso['id']."',".
							"'".$nResInseridos."', '1');";
					if (!$db->executar($sql))
						die("Erro no SQL!<br />".$sql);	
					$secAlocadas +=1;		
				}
				else{					
					$totalResumos = ($select[0]['resumos']+$nResInseridos);
					$sql = "UPDATE aux_sessoes SET resumos='".$totalResumos."' WHERE "
					."eventos_id='".$eid."' AND sessoes_id='".$secBic[$k]."'".
					" AND cursos_id='".$curso['id']."' AND bic_jr='1';";
					if (!$db->executar($sql))
						die("Erro no SQL!<br />".$sql);
				}
				$k++;
				
			}

			// TRATANDO O RESTO!
										
			if ($trataResto == 1){//verifica se precisa tratar o resto ou nao ( possui menos de 5 resumos total, vide linhas 76 a 83 )
				$resto = $nResArea%5;
				$sec = (0 + $encheu);
				for($j=0; $j< $resto; $j++){
					
					// TRATAMENTO PARA QUE A SESSAO NAO ULTRAPASSE O NUMERO DE RESUMOS PERMITIDO
					$sql = "SELECT SUM(resumos) somaresumos FROM aux_sessoes WHERE eventos_id='".$eid."'"
							." AND sessoes_id='".$secBic[$sec]."';";
					$nResumosSec = $db->consulta($sql);
					$nResSec = $nResumosSec[0]['somaresumos'];
					//die("a". var_dump($nResSec));
					if($nResSec >= $nMaxResSessao){
						$sec += 1;
						$encheu += 1;
					}
					
					if($sec >= $secAlocadas){
						$sec = (0 + $encheu);
					}
					$sql = "SELECT * FROM aux_sessoes WHERE eventos_id='".$eid."' "
							."AND sessoes_id='".$secBic[$sec]."' AND ".
							"cursos_id='".$curso['id']."' AND bic_jr=1;";
					$select = $db->consulta($sql);
					$sql = "UPDATE aux_sessoes SET resumos='".($select[0]['resumos']+1)."' WHERE "
							."eventos_id='".$eid."' AND sessoes_id='".$secBic[$sec]."'".
							" AND cursos_id='".$curso['id']."' AND bic_jr='1';";
					if (!$db->executar($sql))
						die("Erro no SQL!<br />".$sql);	
					$sec++;												
				}	
			}
		}
	}	
		// INSERINDO O RESTO DOS ALUNOS QUE NÃO SÃO BIC JUNIOR
		
		$sql = "SELECT a.cursos_id, COUNT(*) "
				."totalresumos FROM resumos a LEFT JOIN usuarios b ON (a.usuarios_id = b.id) WHERE "
				."a.eventos_id='".$eid."' AND b.bic_jr=0 GROUP BY a.cursos_id ORDER BY totalresumos;";
		if (!$db->executar($sql))
			die("Erro no SQL!<br />".$sql);
		$selectCursos = $db->consulta($sql);
		//die(var_dump($selectCursos));
		$sql = "SELECT * FROM sessoes WHERE eventos_id='".$eid."' ORDER BY bic_jr DESC, id ASC";
		$todasSessoes = $db->consulta($sql);
		if (count($todasSessoes) == 0)
			die("Não existem sessões!");	
		//die(var_dump($todasSessoes));
		$nSessoes = count($todasSessoes);
		foreach($todasSessoes as $j => $row){
			$sessoes[] = $row['id'];
		}
		//die(var_dump($sessoes));
		foreach($selectCursos as $c => $curso){		
			if ($curso['totalresumos'] > 0){ 
				$nResArea = $curso['totalresumos']; // quantos resumos por area.			
				if( $nResArea > 5){
					$nResInseridos = 5;
					$ideal = (int) ($nResArea/5); // numero de sessoes que a area ira ocupar, tomando 5 como ideal de resumos por sessao
					$trataResto = 1;
				}else{
					$nResInseridos = $nResArea;
					$ideal = 1;
					$trataResto = 0;
				}
			}
			
			$k = (0 + $encheu);
			$secAlocadas = 0;// variavel que armazena em quantas sessoes foram alocados resumos.
			for($j=0; $j< $ideal; $j++){
				
					// TRATAMENTO PARA QUE A SESSAO NAO ULTRAPASSE O NUMERO DE RESUMOS PERMITIDO
					$sql = "SELECT SUM(resumos) somaresumos FROM aux_sessoes WHERE eventos_id='".$eid."'"
							." AND sessoes_id='".$sessoes[$k]."';";
					$nResumosSec = $db->consulta($sql);
					$nResSec = $nResumosSec[0]['somaresumos'];
					//die("a". var_dump($nResSec));
					if($nResSec >= $nMaxResSessao){
						$k += 1;
						$encheu += 1;
					}
					
					if($k >= $nSessoes){
						$k = (0 + $encheu);
					}
					$sql = "SELECT * FROM aux_sessoes WHERE eventos_id='".$eid."' "
							."AND sessoes_id='".$sessoes[$k]."' AND ".
							"cursos_id='".$curso['cursos_id']."';";
					$select1 = $db->consulta($sql);
					//if($curso['cursos_id'] == 23)
						//die(var_dump($sessoes[$k],$encheu,$curso, $select1, count($select1),$nResInseridos, $select1[0]['resumos']));
					//die(var_dump($select1));
					if (count($select1) == 0){
						//if($curso['cursos_id'] == 23)
							//die("select1 = 0 nao pode");
						$sql = "INSERT INTO aux_sessoes(eventos_id, sessoes_id, cursos_id, resumos, bic_jr)".
								" VALUES ('".$eid."','".$sessoes[$k]."','".$curso['cursos_id']."',".
								"'".$nResInseridos."', '0');";
						if (!$db->executar($sql))
							die("Erro no SQL!<br />".$sql);	
						$secAlocadas +=1;		
					}
					else{
						//if($curso['cursos_id'] == 23)
							//die(var_dump($select1));	
						if($select1[0]['resumos'] < 3){
							$sql = "INSERT INTO aux_sessoes(eventos_id, sessoes_id, cursos_id, resumos, bic_jr)".
									" VALUES ('".$eid."','".$sessoes[$k]."','".$curso['cursos_id']."',".
									"'".$nResInseridos."', '0');";
							//if($curso['cursos_id'] == 23)
								//die($sql);
							if (!$db->executar($sql))
								die("Erro no SQL!<br />".$sql);	
						}				
						else{
							$sql = "SELECT * FROM aux_sessoes WHERE eventos_id='".$eid."' "
									."AND sessoes_id='".$sessoes[$k]."' AND ".
									"cursos_id='".$curso['cursos_id']."' AND bic_jr=0;";
							$select5 = $db->consulta($sql);
							//if($curso['cursos_id'] == 23)
								//die(var_dump($select5));
							if (count($select5) == 0){
								$sql = "INSERT INTO aux_sessoes(eventos_id, sessoes_id, cursos_id, resumos, bic_jr)".
										" VALUES ('".$eid."','".$sessoes[$k]."','".$curso['cursos_id']."',".
										"'".$nResInseridos."', '0');";
								if (!$db->executar($sql))
									die("Erro no SQL!<br />".$sql);	
							}else{
								$totalResumos = ($select5[0]['resumos']+$nResInseridos);
								$sql = "UPDATE aux_sessoes SET resumos='".$totalResumos."' WHERE "
										."eventos_id='".$eid."' AND sessoes_id='".$sessoes[$k]."'".
										" AND cursos_id='".$curso['cursos_id']."' AND bic_jr=0;";
								if (!$db->executar($sql))
									die("Erro no SQL!<br />".$sql);
							}
						}
					}
					$k++;
				//}
			}
			// TRATANDO O RESTO!
					
			if ($trataResto == 1){//verifica se precisa tratar o resto ou nao ( possui menos de 5 resumos total, vide linhas 76 a 83 )
				$resto = $nResArea%5;
				$sec = (0 + $encheu);
				for($j=0; $j< $resto; $j++){
					
					// TRATAMENTO PARA QUE A SESSAO NAO ULTRAPASSE O NUMERO DE RESUMOS PERMITIDO
					$sql = "SELECT SUM(resumos) somaresumos FROM aux_sessoes WHERE eventos_id='".$eid."'"
							." AND sessoes_id='".$sessoes[$sec]."';";
					$nResumosSec = $db->consulta($sql);
					$nResSec = $nResumosSec[0]['somaresumos'];
					//die("a". var_dump($nResSec));
					if($nResSec >= $nMaxResSessao){
						$sec += 1;
						$encheu += 1;
					}
					
					if($sec >= $secAlocadas){
						$sec = (0 + $encheu);
					}
					
					$sql = "SELECT * FROM aux_sessoes WHERE eventos_id='".$eid."' "
							."AND sessoes_id='".$sessoes[$sec]."' AND ".
							"cursos_id='".$curso['cursos_id']."' AND bic_jr=0 ORDER BY bic_jr ASC;";
					$select2 = $db->consulta($sql);
					if($select2 == ""){
						$sql = "SELECT * FROM aux_sessoes WHERE eventos_id='".$eid."' "
								." AND cursos_id='".$curso['cursos_id']."' ORDER BY bic_jr ASC, resumos ASC;";
						$select2 = $db->consulta($sql);
						//if($curso['cursos_id'] == 23)
							//die(var_dump($select2));
					
						$sql = "UPDATE aux_sessoes SET resumos='".($select2[0]['resumos']+1)."' WHERE "
								."eventos_id='".$eid."' AND sessoes_id='".$select2[0]['sessoes_id']."'".
								" AND cursos_id='".$curso['cursos_id']."' AND bic_jr=0;";
						if (!$db->executar($sql))
							die("Erro no SQL!<br />".$sql);	
					}
					else{
						$sql = "UPDATE aux_sessoes SET resumos='".($select2[0]['resumos']+1)."' WHERE "
								."eventos_id='".$eid."' AND sessoes_id='".$sessoes[$sec]."'".
								" AND cursos_id='".$curso['cursos_id']."' AND bic_jr=0;";
						//if($selectCursos[$n]['cursos_id'] == 8)
							//die("a".$sql);
						if (!$db->executar($sql))
							die("Erro no SQL!<br />".$sql);	
					}	
					$sec++;												
				}	
			}	
		}
					
		header("Location: adminevent.php?id=".$eid);
?>
