<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	@include("./cfg/config_course_state.php");
	@include("../cfg/config_course_state.php");
	if ((!isset($_SESSION['eid'])) ||
		(!isset($_GET['id'])) )
			die("<alert>Requisicao Invalida!");
	$db = new Database();
	$id = $_GET['id'];
	$sql = "SELECT * FROM resumos WHERE id='".$id."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Resumo Invalido!");
	$data = $res[0];
	$sql = "SELECT * FROM usuarios WHERE ".
		"eventos_id='".$_SESSION['eid']."' AND ".
		"email='".strtoupper(trim($_SESSION['email']))."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Usuario Invalido!");
	$user = $res[0];
	if ($data['usuarios_id'] != $user['id'])
		die("<alert>Posse invalida de resumo!");
	$sql = "SELECT * FROM cursos ORDER BY nome;";
	$res = $db->consulta($sql);
	$cursos = $res;
	
	//die("<b><i>N&atilde;o dispon&iacute;vel ainda.</i></b>");
	//echo $data['palavras_chave']."<br />";
	$pals = explode("|||",$data['palavras_chave']);
	
	function selected( $value, $selected ){
		return $value==$selected ? ' selected="selected"' : '';
}

?>
<h2>Editar Resumo</h2>
<p>Campos com * s&atilde;o obrigat&oacute;rios</p><br />
<form action='editresumo.php' method='post'
	onSubmit= "return checkFields();">
<input value="<?php echo $_GET['id']; ?>"
	type="hidden" name="rid" />
<h3>Dados do resumo:</h3>
<table border=0>
	<tr>
		<td>T&iacute;tulo do Resumo*:</td>
		<td><input type='text' name='titulo' id='titulo' size=40
			value= '<?php echo htmlentities($data['titulo'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>'/></td>
	</tr>
	<tr>
		<td>Palavras-Chave*:</td>
		<td>
			<input type='text' name='pal1' id='pal1' size=10
				value='<?php echo htmlentities($pals[0], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>' /> ; 
			<input type='text' name='pal2' id='pal2' size=10
				value='<?php echo htmlentities($pals[1], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>' /> ; 
			<input type='text' name='pal3' id='pal3' size=10
				value='<?php echo htmlentities($pals[2], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>' /></td>
	</tr>
	<tr>
		<td>Institui&ccedil;&atilde;o de Fomento:</td>
		<td><input type='text' name='fomento' id='fomento' size=30
			value='<?php echo htmlentities($data['fomento'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>'></td>
	</tr>
	<tr>
		<td>&Aacute;rea do Resumo*:</td>
		<td><select name='area' id='area'>
		<?php
			foreach ($cursos as $i => $row) {
			if ($row['state'] == $ATIVO AND $row['sigla'] != 'BicJr') {
				echo "<option value='".$row['id'].
					"'";
				if ($row['id'] == $data['cursos_id'])
					echo " selected ";
				echo ">".$row['nome']." (".$row['sigla'].
					")</option>\n";
			}
			}
		?></td>
	</tr>
	<tr><td>Departamento*:</td><td><select
		name="dpto" id="dpto">
		<option value='DAE' <?php echo selected( 'DAE', $data['departamento'] ); ?>>DAE</option>
		<option value='DAG' <?php echo selected( 'DAG', $data['departamento'] ); ?>>DAG</option>
		<option value='DBI' <?php echo selected( 'DBI', $data['departamento'] ); ?>>DBI</option>
		<option value='DCA' <?php echo selected( 'DCA', $data['departamento'] ); ?>>DCA</option>
		<option value='DCC' <?php echo selected( 'DCC', $data['departamento'] ); ?>>DCC</option>
		<option value='DCF' <?php echo selected( 'DCF', $data['departamento'] ); ?>>DCF</option>
		<option value='DCH' <?php echo selected( 'DCH', $data['departamento'] ); ?>>DCH</option>
		<option value='DCS' <?php echo selected( 'DCS', $data['departamento'] ); ?>>DCS</option>
		<option value='DED' <?php echo selected( 'DED', $data['departamento'] ); ?>>DED</option>
		<option value='DEF' <?php echo selected( 'DEF', $data['departamento'] ); ?>>DEF</option>
		<option value='DEG' <?php echo selected( 'DEG', $data['departamento'] ); ?>>DEG</option>
		<option value='DEL' <?php echo selected( 'DEL', $data['departamento'] ); ?>>DEL</option>
		<option value='DEN' <?php echo selected( 'DEN', $data['departamento'] ); ?>>DEN</option>
		<option value='DEX' <?php echo selected( 'DEX', $data['departamento'] ); ?>>DEX</option>
		<option value='DFI' <?php echo selected( 'DFI', $data['departamento'] ); ?>>DFI</option>
		<option value='DFP' <?php echo selected( 'DFP', $data['departamento'] ); ?>>DFP</option>
		<option value='DIR' <?php echo selected( 'DIR', $data['departamento'] ); ?>>DIR</option>
		<option value='DMV' <?php echo selected( 'DMV', $data['departamento'] ); ?>>DMV</option>
		<option value='DNU' <?php echo selected( 'DNU', $data['departamento'] ); ?>>DNU</option>
		<option value='DQI' <?php echo selected( 'DQI', $data['departamento'] ); ?>>DQI</option>
		<option value='DSA' <?php echo selected( 'DSA', $data['departamento'] ); ?>>DSA</option>
		<option value='DZO' <?php echo selected( 'DZO', $data['departamento'] ); ?>>DZO</option>
	</select></td></tr>
	<tr>
		<td>Local de Realiza&ccedil;&atilde;o da Pesquisa:</td>
		<td><input type='text' name='local_pesquisa' id='local_pesquisa' size=30
			value='<?php echo htmlentities($data['local_pesquisa'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>'></td>
	</tr>
	<tr>
		<td>Resumo*:</td>
		<td><br />(100 a 2500 caracteres)<br />
		<!-- VERIFICAÇÃO DE CARACTERES ANTIGA: onKeyUp='checkChars()';-->
			<textarea name='resumo' id='resumo' cols=50 rows=15 
				maxlength='2500'><?php echo $data['resumo']; ?></textarea></td>
	</tr>
</table><br />
<h3>Dados dos autores:</h3>
<table border=0>
	<tr>
		<th>Nomes Completos</th>
		<th></th>
		<th>Orientador(a)*
	</tr>
	<tr>
		<td>1<sup>o</sup> Autor*:</td>
		<td><input type='hidden' name='autor1'
			value='<?php echo htmlentities($data['autor1'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>' />
			<?php echo htmlentities($data['autor1'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?></td>
		<td><center>-</center></td>
	</tr>
	<tr>
		<td>2<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor2' id='autor2' size=35 
			value='<?php echo htmlentities($data['autor2'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>'></td>

		<td><center><?php if ($data['autor_orientador'] == 'autor2') {
		
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor2' checked />";
				  } else {
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor2' />";
				  }
				  
				  echo $autor_orientador;
			?></center></td>
	</tr>
	<tr>
		<td>3<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor3' id='autor3' size=35 
			value='<?php echo htmlentities($data['autor3'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>'></td>
			
		<td><center><?php if ($data['autor_orientador'] == 'autor3') {
		
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor3' checked />";
				  } else {
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor3' />";
				  }
				  
				  echo $autor_orientador;
			?></center></td>
	</tr>
	<tr>
		<td>4<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor4' id='autor4' size=35 
			value='<?php echo htmlentities($data['autor4'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>'></td>
			
		<td><center><?php if ($data['autor_orientador'] == 'autor4') {
		
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor4' checked />";
				  } else {
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor4' />";
				  }
				  
				  echo $autor_orientador;
			?></center></td>
	</tr>
	<tr>
		<td>5<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor5' id='autor5' size=35 
			value='<?php echo htmlentities($data['autor5'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>'></td>
			
		<td><center><?php if ($data['autor_orientador'] == 'autor5') {
		
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor5' checked />";
				  } else {
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor5' />";
				  }
				  
				  echo $autor_orientador;
			?></center></td>
	</tr>
	<tr>
		<td>6<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor6' id='autor6' size=35 
			value='<?php echo htmlentities($data['autor6'], ENT_QUOTES | ENT_IGNORE, "iso-8859-1"); ?>'></td>
			
		<td><center><?php if ($data['autor_orientador'] == 'autor6') {
		
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor6' checked />";
				  } else {
						$autor_orientador = "<input type='radio' name='autor_orientador' value='autor6' />";
				  }
				  
				  echo $autor_orientador;
			?></center></td>
	</tr>
	</table>
	<table>
	<tr>
		<th><br />Identifica&ccedil;&atilde;o dos Autores</th>
		<th></th>
	</tr>
	<tr>
		<td>Exemplos:</td>
		<td>
		a) 8<sup>o</sup> m&oacute;dulo de Agronomia, UFLA,
			inicia&ccedil;&atilde;o cient&iacute;fica 
			volunt&aacute;ria.<br />
		b) Orientador DCA, UFLA.<br />
		c) Coorientador DCH, UFLA.<br />
		d) 1<sup>o</sup> m&oacute;dulo de Filosofia, UFLA, bolsista 
			PIBIC/CNPq.<br />
		e) Bolsista Bic J&uacute;nior CNPq/FAPEMIG, 3<sup>o</sup> ano 
			do Ensino M&eacute;dio da Nome da Escola.<br /><br /></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 1<sup>o</sup> Autor*:</td>
		<td><textarea name='infoautor1' id='infoautor1' cols=40 rows=2><?php echo $data['info_autor1']; ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 2<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor2' id='infoautor2' cols=40 rows=2><?php echo $data['info_autor2']; ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 3<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor3' id='infoautor3' cols=40 rows=2><?php echo $data['info_autor3']; ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 4<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor4' id='infoautor4' cols=40 rows=2><?php echo $data['info_autor4']; ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 5<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor5' id='infoautor5' cols=40 rows=2><?php echo $data['info_autor5']; ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 6<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor6' id='infoautor6' cols=40 rows=2><?php echo $data['info_autor6']; ?></textarea></td>
	</tr>
</table><br /><br />
<input type='submit' value='Salvar' />
<input type='reset' value='Limpar Campos' /><br />
</form><br />