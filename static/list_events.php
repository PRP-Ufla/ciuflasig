<?php
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	$db = new Database();
	$today = @gmdate("Y-m-d");
	$sql = "SELECT * FROM eventos WHERE ".
		"inicio_submissao <= '".$today."' AND ".
		"termino >= '".$today."' ".
		"ORDER BY inicio ASC,inicio_submissao ASC;";
	$result = $db->consulta($sql);
	if (count($result) == 0) {
		echo "<center><big><i>Nenhum congresso aberto no".
			" momento.</i></big></center>";
	} else {
		$k = count($result)-1;
		foreach ($result as $i => $row)
		{
			$subIniday = @strtotime($result[$k]['inicio_submissao']);
			$subTerday = @strtotime($result[$k]['termino_submissao']);
			$selIniday = @strtotime($result[$k]['inicio_selecionar_sessao']);
			$selTerday = @strtotime($result[$k]['termino_selecionar_sessao']);
			echo "<div style='display: block; width: 400px; ".
				"border: 2px solid #248; margin: 15px; ".
				"padding: 15px; text-align: left; color: #124;".
				"background: #cef;'>";
			echo "<center><h2 style='color: #000;'>".$result[$k]['edicao'].
				" Congresso de Inicia&ccedil;&atilde;o ".
				"Cient&iacute;fica da UFLA - CIUFLA</h2></center>";
			echo "Realiza&ccedil;&atilde;o: ".
				@gmdate("d/m/Y",@strtotime($result[$k]['inicio']))." a ".
				@gmdate("d/m/Y",@strtotime($result[$k]['termino']))."<br />";
			echo "Inscri&ccedil;&otilde;es: ".
				@gmdate("d/m/Y",@strtotime($result[$k]['inicio_submissao'])).
				" a ".
				@gmdate("d/m/Y",@strtotime($result[$k]['termino_submissao'])).
				"<br />";
			echo "Submiss&atilde;o de Resumos: ".
				"11/06/2018 a 22/07/2018".
				"<br />";
			echo "Submiss&atilde;o de Resumos BIC JR: ".
				"13/09/2018 a 14/09/2018".
				"<br />";
			/*echo "Submiss&atilde;o de Resumos: ".
				@gmdate("d/m/Y",@strtotime($result[$k]['inicio_submissao'])).
				" a ".
				@gmdate("d/m/Y",@strtotime($result[$k]['termino_submissao'])).
				"<br />";*/
			/*echo "Seleção das Sessões: ".
				@gmdate("d/m/Y",@strtotime($result[$k]['inicio_selecionar_sessao'])).
				" a ".
				@gmdate("d/m/Y",@strtotime($result[$k]['termino_selecionar_sessao'])).
				"<br />";*/
			echo "<center><p style='color: #124;'>".
				$result[$k]['descricao']."</p><br />";
				
			//if (($subIniday <= @time()) && (@time() <= $subTerday)) {
			if (($result[$k]['inicio_submissao'] <= date('Y-m-d')) && (date('Y-m-d') <= $result[$k]['termino_submissao'])) {
				echo "| <a style='color: #248; font-weight: bold;'".
					" href='subscribe.php?id=".$result[$k]['id'].
					"' target='_self'> Inscrever-se</a> | ";
				echo "| <a style='color: #248; font-weight: bold;'".
					" href='loginuser.php?id=".$result[$k]['id'].
					"' target='_self'>Submeter Resumos (APENAS BIC JR)</a> | ";
			} 
			
			//if (($selIniday <= @time()) && (@time() <= $selTerday)) {
			if (($result[$k]['inicio_selecionar_sessao'] <= date('Y-m-d')) && (date('Y-m-d') <= $result[$k]['termino_selecionar_sessao'])) {
				echo "| <a style='color: #248; font-weight: bold;'".
					" href='loginuser.php?id=".$result[$k]['id'].
					"' target='_self'> Selecionar Sessões</a> |";
			}		
			else {
				echo "| <a style='color: #248; font-weight: bold;'".
					" href='loginuser.php?id=".$result[$k]['id'].
					"' target='_self'> Acessar Resumos Submetidos</a> |";
			}	
			echo "</center></div>";
			$k--;
		}
	}
?>
