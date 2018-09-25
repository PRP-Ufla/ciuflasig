<?php
	include("static/basicheaders.php");
	include("php/class_database.php");
	
	function writeResults($res) {
			$searchContent  = '';
			foreach ($res as $i => $row) {
			$searchContent .= "<div class='search-result-line' onClick='window.open(\"generateResumoPDF.php?id=".$row['id']."\",\"resumo".$row['id']."\");'>";
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
	
	$db = new Database();
	if (!isset($_POST['limitInit'])) {
		$_POST['limitInit'] = 1;
	}
	if (!isset($_POST['limitUp'])) {
		$_POST['limitUp'] = 20;
	}
	$limitCont = $_POST['limitUp']-$_POST['limitInit']+1;
	$nResults = 0;
	$searchContent = '';
	if (!isset($_POST['resumoId'])) {
		$_POST['resumoId'] = '';
	}
	if (!isset($_POST['resumoTitulo'])) {
		$_POST['resumoTitulo'] = '';
	}
	if (!isset($_POST['resumoAutor'])) {
		$_POST['resumoAutor'] = '';
	}
	if (!isset($_POST['resumoKeyword'])) {
		$_POST['resumoKeyword'] = '';
	}
	if (!isset($_POST['resumoConteudo'])) {
		$_POST['resumoConteudo'] = '';
	}
	if (!isset($_POST['resumoArea'])) {
		$_POST['resumoArea'] = "0";
	}
	if (!isset($_POST['resumoEdicao'])) {
		$_POST['resumoEdicao'] = "0";
	}
	
	$filtros = "(resumos.titulo LIKE '%".$_POST['resumoTitulo']."%'".
			" AND (resumos.autor1 LIKE '%".$_POST['resumoAutor']."%'".
			" OR resumos.autor2 LIKE '%".$_POST['resumoAutor']."%'".
			" OR resumos.autor3 LIKE '%".$_POST['resumoAutor']."%'".
			" OR resumos.autor4 LIKE '%".$_POST['resumoAutor']."%'".
			" OR resumos.autor5 LIKE '%".$_POST['resumoAutor']."%'".
			" OR resumos.autor6 LIKE '%".$_POST['resumoAutor']."%')".
			" AND resumos.resumo LIKE '%".$_POST['resumoConteudo']."%'".
			" AND resumos.palavras_chave LIKE '%".$_POST['resumoKeyword']."%'";
	if ($_POST['resumoArea'] != '0') {
		$filtros .= " AND resumos.cursos_id='".$_POST['resumoArea']."'";
	}
	if ($_POST['resumoEdicao'] != '0') {
		$filtros .= " AND resumos.eventos_id='".$_POST['resumoEdicao']."'";
	}
	$filtros .= ")";
	
	if ($_POST['resumoId'] != '') {

		$idStr = explode("-",$_POST['resumoId']);

		if (count($idStr) != 3) {
			$searchContent = "<font style='color: #D00;'><b>Identificador de resumo inv&aacute;lido!</b></font>";
		
		} else {	

			$sql = "SELECT resumos.*,evt.edicao, crs.nome FROM resumos,eventos evt,cursos crs".
				" WHERE evt.id=resumos.eventos_id AND resumos.eventos_id=evt.id AND CURDATE() > evt.termino AND crs.id=resumos.cursos_id AND resumos.ausente = 0".
				" AND resumos.id='".$idStr[0]."';";
			
			$res = $db->consulta($sql);
			$nResults = count($res);
			
			if (count($res) == 0) {
				$searchContent = "<i> Nenhum resumo recuperado nesta busca.</i>";
			
			} else {
				$searchContent = writeResults($res);
			}
		}
	} else {

		// Conta quantos resumos foram localizados
		$sql = "SELECT count(resumos.id) FROM resumos,eventos evt,cursos crs".
			" WHERE evt.id=resumos.eventos_id AND resumos.eventos_id=evt.id AND CURDATE() > evt.termino AND crs.id=resumos.cursos_id AND resumos.ausente = 0".
			" AND ".$filtros.
			" ORDER BY eventos_id DESC, titulo ASC;";
	
		$res = $db->consulta($sql);
		$nResults = $res[0][0];

		// Busca pelos resumos
		$sql = "SELECT resumos.*,evt.edicao, crs.nome FROM resumos,eventos evt,cursos crs".
			" WHERE evt.id=resumos.eventos_id AND resumos.eventos_id=evt.id AND CURDATE() > evt.termino AND crs.id=resumos.cursos_id AND resumos.ausente = 0".
			" AND ".$filtros.
			" ORDER BY eventos_id DESC, titulo ASC LIMIT ".
			($_POST['limitInit']-1).",".$limitCont.";";

		$res = $db->consulta($sql);
		if (count($res) == 0) {
			$searchContent = "<i> Nenhum resumo recuperado nesta busca.</i>";
		} else {
			$searchContent = writeResults($res);
		}
	}
	$sql = "SELECT * FROM cursos ORDER BY nome ASC, sigla ASC, id ASC;";
	$cursos = $db->consulta($sql);
	//$sql = "SELECT * FROM eventos ORDER BY id DESC;";
	$sql = "SELECT *, EXTRACT(YEAR FROM inicio) AS ano_inicio FROM eventos  WHERE CURDATE() > eventos.termino ORDER BY id DESC;";
	$edicoes = $db->consulta($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Biblioteca Digital</title>
	<style type="text/css"><!--
		#mn4{ color: #6bf; }
	!--></style>
	<script src="js/library.js" type="text/javascript"></script>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_main.html"); ?>
<div id="conteudo">
	<center>
    <h1>Biblioteca Digital</h1>
    <div id="searchContainer" class="container">
    	<form method="post" name="searchForm" id="searchForm" action="library.php">
    	<span id="searchFilters" class="contentBox">
    	<p>Preencha os filtros que deseja aplicar &agrave; busca:</p>
    	<table class="formTable">
    	<tr><td>Identificador do Resumo: </td><td><input type='text' name='resumoId' id='resumoId' size='15'
    		value=<?php echo "'".$_POST['resumoId']."'"; ?> /></td></tr>
    	<tr><td>T&iacute;tulo do Resumo: </td><td><input type='text' name='resumoTitulo' id='resumoTitulo' size='30'
    		value=<?php echo "'".$_POST['resumoTitulo']."'"; ?> /></td></tr>
    	<tr><td>Autor(a) do Resumo: </td><td><input type='text' name='resumoAutor' id='resumoAutor' size='30'
    		value=<?php echo "'".$_POST['resumoAutor']."'"; ?> /></td></tr>
    	<tr><td>Palavra-chave do Resumo: </td><td><input type='text' name='resumoKeyword' id='resumoKeyword' size='20'
    		value=<?php echo "'".$_POST['resumoKeyword']."'"; ?> /></td></tr>
		<tr><td>Conteúdo do Resumo: </td><td><input type='text' name='resumoConteudo' id='resumoConteudo' size='30'
    		value=<?php echo "'".$_POST['resumoConteudo']."'"; ?> /></td></tr>
    	<tr><td>&Aacute;rea do Resumo: </td><td><select name='resumoArea' id='resumoArea'>
    			<option value="0"><i>--- N&atilde;o filtrar por &aacute;rea ---</i></option>
    			<?php
    				foreach ($cursos as $i => $curso) {
    			?>
    			<option value='<?php echo $curso["id"]; ?>'
    			<?php if ($_POST['resumoArea'] == $curso['id']) echo "selected"; ?>
    			><?php echo $curso['nome']; ?></option>
    			<?php
    				}
    			?>
    		</select></td></tr>
    	<tr><td>Edi&ccedil;&atilde;o do Evento: </td><td><select name='resumoEdicao' id='resumoEdicao'>
    			<option value="0"><i>--- N&atilde;o filtrar por edi&ccedil;&atilde;o do evento ---</i></option>
    			<?php
    				foreach ($edicoes as $i => $edicao) {
    			?>
    			<option value='<?php echo $edicao["id"]; ?>'
    			<?php if ($_POST['resumoEdicao'] == $edicao['id']) echo "selected"; ?>
    			><?php echo $edicao['edicao']; ?> CIUFLA
				<?php echo " - ";
					  echo $edicao['ano_inicio']; ?> </option>
    			<?php
    				}
    			?>
    		</select></td></tr>
    	</table>
    	</span>
    	<input class="submit" type="submit" value="Buscar Resumos" />
    	<br><p>Exibindo
    		<input type='text' size='2' value=<?php echo '"'.$_POST['limitInit'].'"'; ?> name='limitInit' /> a
    		<input type='text' size='2' value=<?php echo '"'.$_POST['limitUp'].'"'; ?> name="limitUp" />
    		de <?php echo $nResults; ?> resultados.</p>
    	<span style="hidden: true;" id="searchContent" class="contentBox">
    		<h2>Resultados da Busca:</h3>
    		<?php echo $searchContent; ?>
    	</span>
    	</form>
    </div>
    </center>
</div>
<?php include("htm/bottom.html"); ?>
</div>
</body>
</html>