<?php
	include("static/basicheaders.php");
	include("php/class_database.php");
	$db = new Database();
	
	function writeResults($res) {

			$searchContent  = '';

			foreach ($res as $i => $row) {

				$id = $row['id'];

				// Caso seja preenchido o protocolo no campo de busca, o mesmo será passado por parâmetro
				// na url de geração do certificado.
				if ($_POST['certificadoProtocolo'] == '') {

					$searchContent .= "<form id='form' method='post' target='_blank' action='./recaptcha.php'>";
					$searchContent .= "<input type='hidden' name='id' value='$id'/>";
					$searchContent .= "<div onclick='this.parentNode.submit();' class='search-result-line'>";
					$searchContent .= "</form>";

				} else {
					
					$certificadoProtocolo = $_POST['certificadoProtocolo'];
					$searchContent .= "<form id='form' method='post' target='_blank' action='./recaptcha.php'>";
					$searchContent .= "<input type='hidden' name='id' value='$id'/>";
					$searchContent .= "<input type='hidden' name='protocolo' value='$certificadoProtocolo'/>";
					$searchContent .= "<div onclick='this.parentNode.submit();' class='search-result-line'>";
					$searchContent .= "</form>";
				}

				$searchContent .= "<h4>".($i+$_POST['limitInit'])." - ".$row['titulo']."</h4>";
				$searchContent .= "<p><b>Autores:</b> ".$row['autor1'];

				if ($row['autor2'] != '') {
					$searchContent .= ", ".$row['autor2'];
				}
				if ($row['autor3'] != '') {
					$searchContent .= ", ".$row['autor3'];
				}
				if ($row['autor4'] != '') {
					$searchContent .= ", ".$row['autor4'];
				}
				if ($row['autor5'] != '') {
					$searchContent .= ", ".$row['autor5'];
				}
				if ($row['autor6'] != '') {
					$searchContent .= ", ".$row['autor6'];
				}

				$searchContent .= "<br /><b>Edi&ccedil;&atilde;o:</b> ".$row['edicao']." CIUFLA";
				$searchContent .= "<br /><b>&Aacute;rea:</b> ".$row['nome'];
				$searchContent .= "<br /><b>Palavras-chave:</b> ".str_replace("|||", ";", $row['palavras_chave']);
				$searchContent .= "</p>";
				$searchContent .= "</div>";
			}

			return $searchContent;
	}

	if (!isset($_POST['limitInit'])) {
		$_POST['limitInit'] = 1;
	}
	if (!isset($_POST['limitUp'])) {
		$_POST['limitUp'] = 20;
	}

	$limitCont = $_POST['limitUp']-$_POST['limitInit']+1;
	
	$nResults = 0;
	$searchContent = '';
	$resultadoBusca = "";

	if (!isset($_POST['certificadoProtocolo'])) {
		$_POST['certificadoProtocolo'] = '';

	} else {
		$certificadoProtocolo = $_POST['certificadoProtocolo'];
	}

	if (!isset($_POST['resumoAutor'])) {
		$_POST['resumoAutor'] = '';
	
	} else {
		$resumoAutor = $_POST['resumoAutor'];
	}

	if (!isset($_POST['resumoTitulo'])) {
		$_POST['resumoTitulo'] = '';
	
	} else {
		$resumoTitulo = $_POST['resumoTitulo'];
	}

	$filtros = "resumos.titulo LIKE '%".$_POST['resumoTitulo']."%'".
			" AND resumos.autor1 LIKE '%".$_POST['resumoAutor']."%'";

	if ($_POST['certificadoProtocolo'] != '') {  

			// Procura id do resumo a partir do Protocolo do certificado
			$sql = "SELECT r.id from certificado c 
				INNER join resumos r ON (c.resumo_id = r.id)
				INNER JOIN certificado_protocolo p ON (p.certificado_id = c.id)
				WHERE (p.protocolo = '".$certificadoProtocolo."');";
			$resumoId = $db->consulta($sql);
			$resumoId = $resumoId[0][0];

			// Busca final dos dados para geração do certificado
			$sql = "SELECT resumos.*,evt.edicao, crs.nome FROM resumos,eventos evt,cursos crs".
				" WHERE evt.id=resumos.eventos_id AND resumos.eventos_id=evt.id AND CURDATE() > evt.termino AND crs.id=resumos.cursos_id AND resumos.ausente = 0".
				" AND resumos.id='".$resumoId."';";
			$res = $db->consulta($sql);
			$nResults = count($res);

			$resultadoBusca = '';
			$resultadoBusca .= "<br>";
			$resultadoBusca .= "<span style='hidden: true;' id='searchContent' class='contentBox'>";
			$resultadoBusca .= "<h2>Resultados da Busca:</h2>";
			
			if (count($res) == 0) {
				$searchContent = "<i> Protocolo inválido. Nenhum resumo recuperado nesta busca.</i>";
			
			} else {
				$searchContent = writeResults($res);
			}

	} else {

		if ($_POST['resumoTitulo'] != '' || $_POST['resumoAutor'] != ''){			

			$sql = "SELECT count(resumos.id) FROM resumos,eventos evt,cursos crs, certificado c".
				" WHERE c.resumo_id = resumos.id AND evt.id=resumos.eventos_id AND resumos.eventos_id=evt.id AND CURDATE() > evt.termino AND crs.id=resumos.cursos_id AND resumos.ausente = 0".
				" AND ".$filtros.
				" ORDER BY eventos_id DESC, titulo ASC;";

			$res = $db->consulta($sql);
			$nResults = $res[0][0];

			if (!isset($limiteInferior)) {
				$limiteInferior = 1;
			}

			if (!isset($limiteSuperior)) {
				$limiteSuperior = 20;
			}

			$resultadoBusca = '';
			$resultadoBusca .= "<br>";
			$resultadoBusca .= "<span style='hidden: true;' id='searchContent' class='contentBox' />";
			$resultadoBusca .= "<h2>Resultados da Busca:</h2>";
			
			$sql = "SELECT resumos.*, evt.edicao, crs.nome
					FROM resumos
					JOIN certificado c ON c.resumo_id = resumos.id
					JOIN eventos evt ON evt.id = resumos.eventos_id
					JOIN cursos crs ON crs.id = resumos.cursos_id
					WHERE CURDATE() > evt.termino AND resumos.ausente = 0".
					" AND ".$filtros.
					" ORDER BY eventos_id DESC, titulo ASC LIMIT ".
					($_POST['limitInit']-1).",".$limitCont.";";

			$res = $db->consulta($sql);
			
			if (count($res) == 0) {
				$searchContent = "<i> Nenhum certificado recuperado nesta busca.</i>";
			
			} else {
				$searchContent = writeResults($res);	
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
		<meta http-equiv="Content-Type" content="text/html; accept-charset=utf-8=UTF-8">
		<?php include("static/stylesheets.php"); ?>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<title>CIUFLA - Certificados de Apresentação </title>
		<style type="text/css"><!--
			#mn6{ color: #6bf;
			}
		--></style>
	</head>
<body>
	<div id="centraliza">
		<?php include("htm/top.html"); ?>
		<?php include("htm/menu_main.html"); ?>
		<div id="conteudo">
			<center>
				<h1>Certificados de Apresentação</h1>
				<div id="searchContainer" class="container">
					<form method="post" name="searchForm" id="form" action="ciuflasigCertificados.php">
						<span id="searchFilters" class="contentBox">
							<p>Preencha os filtros que deseja aplicar &agrave; busca:</p>
							<table class="formTable">
								<tr>
									<td>
										Protocolo:
									</td>
									<td>
										<input type='text' name='certificadoProtocolo' id='certificadoProtocolo' size='30'
    										value=<?php echo "'".$_POST['certificadoProtocolo']."'"; ?> '>
									</td>
								</tr>
								<tr>
									<td>
										T&iacute;tulo do Resumo: 
									</td>
									<td>
									<input type='text' name='resumoTitulo' id='resumoTitulo' size='30'
    										value=<?php echo "'".$_POST['resumoTitulo']."'"; ?> '>
									</td>
								</tr>
								<tr>
									<td>
										Autor(a) do Resumo: 
									</td>
									<td>
									<input type='text' name='resumoAutor' id='resumoAutor' size='30'
    										value=<?php echo "'".$_POST['resumoAutor']."'"; ?> '> 
									</td>
								</tr>
							</table>
						</span>
						<input class="submit" type="submit" value="Consultar" style="float: left";/>
						<br><br><div id='pesquisa'>
							<br><div style= 'display:<?php if ($searchContent != '') echo 'block'; else echo 'none';?>' > Exibindo
									<input type='text' size='2' value=<?php echo '"'.$_POST['limitInit'].'"'; ?> name='limitInit' /> a
									<input type='text' size='2' value=<?php echo '"'.$_POST['limitUp'].'"'; ?> name="limitUp" />
									de <?php echo $nResults; ?> resultados.
								</div>
						</div>
					</form>
					<?php echo $resultadoBusca; ?>
					<?php echo $searchContent; ?>
				</div>
			</center>
		</div>
		<?php include("htm/bottom.html"); ?>
	</div>
</body>
</html> 
