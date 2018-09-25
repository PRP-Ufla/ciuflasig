<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if (!isset($_POST['eid']))
		die("Requisicao invalida!");
	$eid = $_POST['eid'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Requisicao Invalida!");
	$arrayResumos = $_POST['resumos'];
	$resumos = explode("/", $arrayResumos);
	$arrayCursos = $_POST['cursos_id'];
	$cursos = explode("/", $arrayCursos);
	$nRes = count($resumos) - 1;
	$bicJr = $_POST['bic_jr'];
	$nome = $_POST['nome_aluno'];
	$today = @gmdate("Y-m-d");
	$interromper = Array();
	$k = 0;
	$s = 0;
	for($i=0; $i<$nRes ; $i++){
		$status = $_POST['status_'.$resumos[$i]];
		if($status == 0){
			$sessao = $_POST['sessoes_'.$resumos[$i]];
			//die(var_dump($sessao));
			$sql = "SELECT sum(resumos) FROM aux_sessoes WHERE sessoes_id='".$sessao."' AND eventos_id='".$eid."' AND cursos_id='".$cursos[$i]."' AND bic_jr='".$bicJr."';";
			$vagasSec = $db->consulta($sql); // vagas nas sessões
			
			$sql = "SELECT COUNT(*) FROM resumos a, usuarios b WHERE a.usuarios_id=b.id AND a.sessoes_id='".$sessao."' AND a.eventos_id='".$eid."' AND b.bic_jr='".$bicJr."' AND a.cursos_id='".$cursos[$i]."';";
			$resumosSec = $db->consulta($sql); // quantos ja foram alocados em cada sessão
			//die($sql);
			//die(var_dump($sessao, $resumos[$i],$cursos[$i], $eid, $vagasSec, $resumosSec));
			if($resumosSec <= $vagasSec){
				$sql = "UPDATE resumos SET sessoes_id='".$sessao."' , status_selecao=1 , data_selecao='".$today."'  WHERE id='".$resumos[$i]."' AND eventos_id='".$eid."';";
				if (!$db->executar($sql))
					die("Erro no SQL!<br />".$sql);	
				$k += 1;
			}
			else{
				//$interromper[$i] = 1;
				$interromper[$s] = $i + 1;
				$s += 1;
			}
		}
		else{
			$k +=1;
		}
	}
	if($k == $nRes){
		header("Location: user.php?id=".$eid);
	}
	else{
		$msg = "Atenção " . $nome . ", devido ao grande número de acessos simultâneos:\n\n";
		for($j=0; $j<count($interromper); $j++){
			//if($interromper[$j] == 1){
			//	$msg .= "* As vagas destinadas ao seu curso na sessão escolhida para o " . ($j+1) . "º resumo acabaram...\n";
			//}
			$msg .= "- As vagas destinadas ao seu curso na sessão escolhida para o " . ($interromper[$j]) . "º resumo acabaram.\n\n";
		}
		$msg .= "Por favor, faça uma nova seleção e tente novamente.";
		echo "<html>".
			"<body>".
			"<input type='hidden' id='mensagem' name'mensagem' value='$msg'>".
			"<script type='text/javascript'>".
			"var msg = document.getElementById('mensagem').value;".
			"alert(msg);".
			"location.href='user.php?id=$eid';".
			"</script></body></html>";
	}
		
?>