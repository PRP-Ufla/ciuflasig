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
		"email='".$_SESSION['email']."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Usuario Invalido!");
	$user = $res[0];
	if ($data['usuarios_id'] != $user['id'])
		die("<alert>Posse invalida de resumo!");
	$sql = "SELECT * FROM cursos;";
	$res = $db->consulta($sql);
	$cursos = $res;
	
	//die("<b><i>N&atilde;o dispon&iacute;vel ainda.</i></b>");
	//echo $data['palavras_chave']."<br />";
	$pals = explode("|||",$data['palavras_chave']);
?>
<h2>Editar Resumo</h2>
<p>Campos com * s&atilde;o obrigat&oacute;rios</p><br />
<form action='editresumo.php' method='post'
	onSubmit='return checkFields();'>
<input value="<?php echo $_GET['id']; ?>"
	type="hidden" name="rid" />
<h3>Dados do resumo:</h3>
<table border=0>
	<tr>
		<td>T&iacute;tulo do Resumo*:</td>
		<td><input type='text' name='titulo' id='titulo' size=40
			value='<?php echo htmlentities(utf8_decode ($data['titulo']), ENT_QUOTES); ?>'/></td>
	</tr>
	<tr>
		<td>Palavras-Chave*:</td>
		<td>
			<input type='text' name='pal1' id='pal1' size=10
				value='<?php echo htmlentities(utf8_decode ($pals[0]), ENT_QUOTES); ?>' /> ; 
			<input type='text' name='pal2' id='pal2' size=10
				value='<?php echo htmlentities(utf8_decode ($pals[1]), ENT_QUOTES); ?>' /> ; 
			<input type='text' name='pal3' id='pal3' size=10
				value='<?php echo htmlentities(utf8_decode ($pals[2]), ENT_QUOTES); ?>' /></td>
	</tr>
	<tr>
		<td>Institui&ccedil;&atilde;o de Fomento:</td>
		<td><input type='text' name='fomento' id='fomento' size=30
			value='<?php echo htmlentities(utf8_decode ($data['fomento']), ENT_QUOTES); ?>' /></td>
	</tr>
	<tr>
		<td>&Aacute;rea do Resumo*:</td>
		<td><select name='area' id='area'>
		<?php
			foreach ($cursos as $i => $row) {
			if ($row['state'] == $ATIVO) {
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
	<tr>
		<td>Resumo*:</td>
		<td><br /><span id='nChars'>0 Caracteres</span>
			(Max. 2500)<br />
			<!-- VERIFICAÇÃO DE CARACTERES ANTIGA: onKeyUp='checkChars()';-->
			<textarea name='resumo' id='resumo' cols=50 rows=15 
				maxlength='2500'>
				<?php echo utf8_decode ($data['resumo']); ?></textarea></td>
	</tr>
</table><br />
<h3>Dados dos autores:</h3>
<table border=0>
	<tr>
		<th>Nomes Completos</th>
		<th></th>
	</tr>
	<tr>
		<td>1<sup>o</sup> Autor*:</td>
		<td><input type='hidden' name='autor1'
			value='<?php echo htmlentities(utf8_decode ($data['autor1']), ENT_QUOTES); ?>' />
			<?php echo htmlentities($data['autor1'], ENT_QUOTES); ?></td>
	</tr>
	<tr>
		<td>2<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor2' id='autor2' size=35 
			value='<?php echo htmlentities(utf8_decode ($data['autor2']), ENT_QUOTES); ?>' /></td>
	</tr>
	<tr>
		<td>3<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor3' id='autor3' size=35 
			value='<?php echo htmlentities(utf8_decode ($data['autor3']), ENT_QUOTES); ?>' /></td>
	</tr>
	<tr>
		<td>4<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor4' id='autor4' size=35 
			value='<?php echo htmlentities(utf8_decode ($data['autor4']), ENT_QUOTES); ?>' /></td>
	</tr>
	<tr>
		<td>5<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor5' id='autor5' size=35 
			value='<?php echo htmlentities(utf8_decode ($data['autor5']), ENT_QUOTES); ?>' /></td>
	</tr>
	<tr>
		<td>6<sup>o</sup> Autor:</td>
		<td><input type='text' name='autor6' id='autor6' size=35 
			value='<?php echo htmlentities(utf8_decode ($data['autor6']), ENT_QUOTES); ?>' /></td>
	</tr>
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
		<td><textarea name='infoautor1' id='infoautor1' cols=40 rows=2><?php echo utf8_decode ($data['info_autor1']); ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 2<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor2' id='infoautor2' cols=40 rows=2><?php echo utf8_decode ($data['info_autor2']); ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 3<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor3' id='infoautor3' cols=40 rows=2><?php echo utf8_decode ($data['info_autor3']); ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 4<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor4' id='infoautor4' cols=40 rows=2><?php echo utf8_decode ($data['info_autor4']); ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 5<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor5' id='infoautor5' cols=40 rows=2><?php echo utf8_decode ($data['info_autor5']); ?></textarea></td>
	</tr>
	<tr>
		<td>Identifica&ccedil;&atilde;o do 6<sup>o</sup> Autor:</td>
		<td><textarea name='infoautor6' id='infoautor6' cols=40 rows=2><?php echo utf8_decode ($data['info_autor6']); ?></textarea></td>
	</tr>
</table><br /><br />
<input type='submit' value='Salvar' />
<input type='reset' value='Limpar Campos' /><br />
</form><br />
