<?php 
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if (!isset($_GET['eid']))
		die("<alert>Requisicao invalida!");
	$eid = $_GET['eid'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento não encontrado!");
	$dados = $res[0];
	$selIniday = @strtotime($dados['inicio_selecionar_sessao']);
	$selTerday = @strtotime($dados['termino_selecionar_sessao']);
	$today = @gmdate("Y-m-d");
	
		
		$sql = "SELECT * FROM cursos WHERE state=0;";
		$cursos = $db->consulta($sql);
		//die(var_dump($cursos));
		
		foreach($cursos as $i => $curso){
			
			//SELECIONAR SESSAO PARA OS RESUMOS DE ALUNOS BIC JR PRIMEIRO
			
			$sql = "SELECT * FROM resumos a, usuarios b WHERE a.usuarios_id=b.id AND status_selecao=0 AND ".
					"a.eventos_id='".$eid."' AND b.bic_jr='1' AND a.cursos_id='".$curso['id']."'";
			$resumos = $db->consulta($sql);
			//die(var_dump($resumos));
			if(count($resumos > 0)){
				$k = 0;
				$sql = "SELECT * FROM aux_sessoes WHERE eventos_id='".$eid."' AND cursos_id='".$curso['id']."' AND bic_jr=1 ";
				$sessoes = $db->consulta($sql);
				for($j=0; $j<count($sessoes); $j++){
					$sql = "SELECT COUNT(*) nRes FROM resumos a, usuarios b WHERE a.usuarios_id=b.id AND ".
							" a.sessoes_id='".$sessoes[$j]['sessoes_id']."' AND a.eventos_id='".$eid."' AND b.bic_jr=1 AND a.cursos_id='".$curso['id']."';";
					$nRes = $db->consulta($sql); 
					$nResumos = count($resumos);// numero de resumos que ja estao na sessao selecionada.
					$nResSec = $sessoes[$j]['resumos'];
					$sec = $sessoes[$j]['sessoes_id'];
					$vagas = $nResSec - $nRes[0]['nRes'];
					//if($curso['id'] == 9)
					//die(var_dump($nResumos, $nResSec, $sec, $vagas, $sessoes));
						
						if($nResumos <= $vagas){
							$limite = $nResumos + $k;
							for($r = $k; $r<$limite; $r++){
								$idRes = $resumos[$r]['0'];
								$sql = "UPDATE resumos SET sessoes_id='".$sec."' , status_selecao=2 , data_selecao='".$today."' ".
										"WHERE id='".$idRes."' AND eventos_id='".$eid."';";
								if (!$db->executar($sql))
									die("Erro no SQL!<br />".$sql);	
								$k++;
							}
						}	
						else{
							$limite = $vagas + $k;
							for($r = $k; $r<$limite; $r++){
								$idRes = $resumos[$r]['0'];
								$sql = "UPDATE resumos SET sessoes_id='".$sec."' , status_selecao=2 , data_selecao='".$today."' ".
										"WHERE id='".$idRes."' AND eventos_id='".$eid."';";
								if (!$db->executar($sql))
									die("Erro no SQL!<br />".$sql);	
									$k++;
							}
						}
				}
			}
			
			// SELECIONAR SESSÃO PARA O RESTO DOS ALUNOS ( NÃO BIC JR )
			
			$sql = "SELECT * FROM resumos a, usuarios b WHERE a.usuarios_id=b.id AND status_selecao=0 AND ".
					"a.eventos_id='".$eid."' AND b.bic_jr='0' AND a.cursos_id='".$curso['id']."'";
			$resumos = $db->consulta($sql);
			//die(var_dump($resumos));
			if(count($resumos > 0)){
				$k = 0;
				$sql = "SELECT * FROM aux_sessoes WHERE eventos_id='".$eid."' AND cursos_id='".$curso['id']."' AND bic_jr=0 ";
				$sessoes = $db->consulta($sql);
				for($j=0; $j<count($sessoes); $j++){
					$sql = "SELECT COUNT(*) nRes FROM resumos a, usuarios b WHERE a.usuarios_id=b.id AND ".
							" a.sessoes_id='".$sessoes[$j]['sessoes_id']."' AND a.eventos_id='".$eid."' AND b.bic_jr=0 AND a.cursos_id='".$curso['id']."';";
					$nRes = $db->consulta($sql); 
					$nResumos = count($resumos);// numero de resumos que ja estao na sessao selecionada.
					$nResSec = $sessoes[$j]['resumos'];
					$sec = $sessoes[$j]['sessoes_id'];
					$vagas = $nResSec - $nRes[0]['nRes'];
					//if($curso['id'] == 9)
					//die(var_dump($nResumos, $nResSec, $sec, $vagas, $sessoes));
						
						if($nResumos <= $vagas){
							$limite = $nResumos + $k;
							for($r = $k; $r<$limite; $r++){
								$idRes = $resumos[$r]['0'];
								$sql = "UPDATE resumos SET sessoes_id='".$sec."' , status_selecao=2 , data_selecao='".$today."' ".
										"WHERE id='".$idRes."' AND eventos_id='".$eid."';";
								if (!$db->executar($sql))
									die("Erro no SQL!<br />".$sql);	
								$k++;
							}
						}	
						else{
							$limite = $vagas + $k;
							for($r = $k; $r<$limite; $r++){
								$idRes = $resumos[$r]['0'];
								$sql = "UPDATE resumos SET sessoes_id='".$sec."' , status_selecao=2 , data_selecao='".$today."' ".
										"WHERE id='".$idRes."' AND eventos_id='".$eid."';";
								if (!$db->executar($sql))
									die("Erro no SQL!<br />".$sql);	
									$k++;
							}
						}
				}
			}
			
		}
		header("Location: ../adminevent.php?id=".$eid);
?>