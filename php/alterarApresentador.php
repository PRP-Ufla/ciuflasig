<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
    $db = new Database();

	function writeResults($res) {
            
		$searchContent  = '';

		foreach ($res as $i => $row) {

			$id = $row['id'];

			$resumoAutor = $_GET['resumoAutor'];

			$resumoAutor1 = $row['autor1'];
			$resumoAutor1 = "'" .$resumoAutor1. "'";
			$resumoAutor1 = str_replace(' ', '_', $resumoAutor1);

			$apresentador = "";
			$resumoAutor2 = "";
			$resumoAutor3 = "";
			$resumoAutor4 = "";
			$resumoAutor5 = "";
			$resumoAutor6 = "";

			if ($row['apresentador'] != '') {
				
				$apresentador = $row['apresentador'];
				$apresentador = str_replace(' ', '_', $apresentador);
				$apresentador = "'" .$apresentador. "'";
				
			} else $apresentador = $resumoAutor1;

			if ($row['autor2'] != '') {
				
				$resumoAutor2 = $row['autor2'];
				$resumoAutor2 = str_replace(' ', '_', $resumoAutor2);
				$resumoAutor2 = "'" .$resumoAutor2. "'";
				
			} else $resumoAutor2 = "''";

			if ($row['autor3'] != '') {

				$resumoAutor3 = $row['autor3'];
				$resumoAutor3 = str_replace(' ', '_', $resumoAutor3);
				$resumoAutor3 = "'" .$resumoAutor3. "'";
				
			} else $resumoAutor3 = "''";

			if ($row['autor4'] != '') {

				$resumoAutor4 = $row['autor4'];
				$resumoAutor4 = str_replace(' ', '_', $resumoAutor4);
				$resumoAutor4 = "'" .$resumoAutor4. "'";
				
			} else $resumoAutor4 = "''";

			if ($row['autor5'] != '') {

				$resumoAutor5 = $row['autor5'];
				$resumoAutor5 = str_replace(' ', '_', $resumoAutor5);
				$resumoAutor5 = "'" .$resumoAutor5. "'";

			} else $resumoAutor5 = "''";

			if ($row['autor6'] != '') {
				
				$resumoAutor6 = $row['autor6'];
				$resumoAutor6 = str_replace(' ', '_', $resumoAutor6);
				$resumoAutor6 = "'" .$resumoAutor6. "'";

			} else $resumoAutor6 = "''";

			$searchContent .= "<div data-toggle='modal' data-target='#myModal' class='search-result-line' onclick= setaDadosModal($resumoAutor1" .",". "$resumoAutor2" .",". "$resumoAutor3" .",". "$resumoAutor4" .",". "$resumoAutor5" .",". "$resumoAutor6" .",". "$apresentador" .",". "$id) >";                              
			$searchContent .= "<h4>".(	$i+1)." - ".$row['titulo']."</h4>";
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

	$searchContent = '';
    $resultadoBusca = "";

	if (!isset($_GET['resumoAutor'])) {
        $_GET['resumoAutor'] = '';

	} else {
        $resumoAutor = $_GET['resumoAutor'];
	}

    $filtros = "(resumos.autor1 LIKE '%".$_GET['resumoAutor']."%'".
            " OR resumos.autor2 LIKE '%".$_GET['resumoAutor']."%'".
            " OR resumos.autor3 LIKE '%".$_GET['resumoAutor']."%'".
            " OR resumos.autor4 LIKE '%".$_GET['resumoAutor']."%'".
            " OR resumos.autor5 LIKE '%".$_GET['resumoAutor']."%'".
			" OR resumos.autor6 LIKE '%".$_GET['resumoAutor']."%')";

    if ($_GET['resumoAutor'] != '' && $_GET['id'] != ''){			

        $resultadoBusca = '';
        $resultadoBusca .= "<br>";
        $resultadoBusca .= "<span style='hidden: true;' id='searchContent' class='contentBox' />";
		$resultadoBusca .= "<h2>Resultados da Busca: </h2>";
		
		$idEvento = $_GET['id'];

		$sql = "SELECT resumos.*,evt.edicao, crs.nome FROM resumos,eventos evt,cursos crs".
		" WHERE evt.id=".$idEvento." AND resumos.eventos_id=".$idEvento." AND CURDATE() > evt.termino AND crs.id=resumos.cursos_id AND resumos.ausente = 0".
		" AND ".$filtros.
		" ORDER BY eventos_id DESC, titulo ASC;";

        $res = $db->consulta($sql);
        
        if (count($res) == 0) {
            $searchContent = "<i> Nenhum resumo recuperado nesta busca.</i>";
        
        } else {
            $searchContent = writeResults($res);	
        }
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
		<meta http-equiv="Content-Type" content="text/html; accept-charset=utf-8=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php include("../static/stylesheets.php"); ?>
        <title>Alterar Apresentador</title>
        <script src="js/adminevent.js" type="text/javascript"></script>
		<style type="text/css"><!--
			#mn6{ color: #6bf;
			}
		--></style>
	</head>
<body>
    <center style="text-align: left;">
        <h1>Alterar Apresentador</h1>
        <div id="searchContainer">
            <form method="post" name="searchForm" id="form" action="">
                <span id="searchFilters">
                    <p>Preencha os filtros que deseja aplicar &agrave; busca:</p>
                    <table class="formTable">
                        <tr>
                            <td>
                                Autor(a) do Resumo: 
                            </td>
                            <td>
                            <input type='text' name='resumoAutor' id='resumoAutor' size='30'> 
                            </td>
                        </tr>
                    </table>
                </span>
                <input type="submit" value="Consultar" style="float: left"; onClick="alterarApresentadorBusca(document.getElementById('resumoAutor').value)"/>
				<br>
                </div>
			</form>
			<br>
			<div class="alert alert-success" id="alerta" role="alert" style="display:none;" >
    			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    			<strong>Successo!</strong> O apresentador foi alterado com sucesso!
  			</div>
            <?php echo $resultadoBusca; ?>
            <?php echo $searchContent; ?>

			<!-- Modal -->
			<div class='modal fade' id='myModal' tabindex='-1' role='dialog'>
				<div class='modal-dialog modal-dialog-centered' role='document'>
					<!-- Modal content-->
					<div class='modal-content'>
						<div class='modal-header'>
							<button type='button' class='close' data-dismiss='modal'>&times;</button>
							<h4 class='modal-title'>Alterar apresentador</h4>
						</div>
						<div class='modal-body'id='div-apresentador'>
						</div>
						<div class='modal-body' id='modal-body'>
						</div>
						<div class="modal-footer" id='footer'>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
						</div>
					</div>
				</div>
			</div>
			<!-- FIM MODAL -->

        </div>
    </center>
</body>
</html> 