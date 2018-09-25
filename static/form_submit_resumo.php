<?php
	
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_user.php");
	@include("../static/lock_user.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	@include("./cfg/config_course_state.php");
	@include("../cfg/config_course_state.php");
	
	$db = new Database();
	$sql = "SELECT * FROM usuarios WHERE ".
		"eventos_id='".$_SESSION['eid']."' AND ".
		"email='".strtoupper(trim($_SESSION['email']))."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Requisicao Invalida!");
	$user = $res[0];
	$sql = "SELECT * FROM cursos ORDER BY nome;";
	$cursos = $db->consulta($sql);
	if (count($cursos) == 0)
		die("<alert>Nao ha areas cadastradas!");
	
	echo "<h2>Submeter Resumo</h2>";
	echo "<p>Campos com * s&atilde;o obrigat&oacute;rios:</p>";
	echo "<form action='addresumo.php' method='post' onSubmit= \"return checkFields();\">";
	echo "<h3>Dados do resumo:</h3>";
	echo "<table border=0>";
	echo "<tr><td>T&iacute;tulo do Resumo*:</td>".
		"<td><input type='text' name='titulo' id='titulo' ".
		"size=40 /></td></tr>";
	echo "<tr><td>Palavras-Chave*:</td>".
		"<td><input type='text' name='pal1' id='pal1' ".
		"size=10 /> ; <input type='text' name='pal2' id='pal2' ".
		"size=10 /> ; <input type='text' name='pal3' id='pal3' ".
		"size=10 /></td></tr>";
	echo "<tr><td>Institui&ccedil;&atilde;o de Fomento:</td>".
		"<td><input type='text' name='fomento' id='fomento' ".
		"size=30 /></td></tr>";
	echo "<tr><td>Local de Realiza&ccedil;&atilde;o da Pesquisa:</td>".
		"<td><input type='text' name='local_pesquisa' id='local_pesquisa' ".
		"size=30 /><br>Ex.: Fazenda Muquem - UFLA, Laboratório de Microscopia Eletrônica, Biotério.</td></tr>";
	echo "<tr><td>&Aacute;rea do Resumo*:</td><td><select ".
		"name='area' id='area'><option value='0' selected>".
		"-- Selecione uma &Aacute;rea --</option>";
	foreach ($cursos as $i => $row) {
		if ($row['state'] == $ATIVO AND $row['sigla'] != 'BicJr') {
			echo "<option value='".$row['id'].
				"'>".$row['nome']." (".$row['sigla'].
				")</option>\n";
		}
	}
	echo "</select></td></tr>";
	echo "<tr><td>Departamento*:</td><td><select ".
		"name='dpto' id='dpto'><option value='0' selected>".
		"-- Selecione um Departamento --</option>".
		"<option value='DAE'>DAE</option>".
		"<option value='DAG'>DAG</option>".
		"<option value='DBI'>DBI</option>".
		"<option value='DCA'>DCA</option>".
		"<option value='DCC'>DCC</option>".
		"<option value='DCF'>DCF</option>".
		"<option value='DCH'>DCH</option>".
		"<option value='DCS'>DCS</option>".
		"<option value='DED'>DED</option>".
		"<option value='DEF'>DEF</option>".
		"<option value='DEG'>DEG</option>".
		"<option value='DEL'>DEL</option>".
		"<option value='DEN'>DEN</option>".
		"<option value='DEX'>DEX</option>".
		"<option value='DFI'>DFI</option>".
		"<option value='DFP'>DFP</option>".
		"<option value='DIR'>DIR</option>".
		"<option value='DMV'>DMV</option>".
		"<option value='DNU'>DNU</option>".
		"<option value='DQI'>DQI</option>".
		"<option value='DSA'>DSA</option>".
		"<option value='DZO'>DZO</option>";
		
	echo "</select></td></tr>";
	echo "<tr><td>Resumo*:</td><td><br />".
		"(100 a 2500 caracteres)<br />".
		"<textarea name='resumo' id='resumo' cols=50 rows=15".
		"maxlength='2500'>".
		"</textarea></td>";
		
	echo "</table><br />";
	echo "<h3>Dados dos autores:</h3>";
	echo "<table border=0>";
	echo "<tr><th>Nomes Completos</th> <th></th> <th>Orientador(a)*</th> </tr>";
	echo "<tr><td>1<sup>o</sup> Autor*:</td><td>".
		"<input type='hidden' name='autor1' value='".
		$user['nome']."' />".$user['nome']."</td><td><center>-</center></td></tr>";
	echo "<tr><td>2<sup>o</sup> Autor:</td><td>".
		"<input type='text' name='autor2' id='autor2'".
		" size=35 /></td>".
		"<td><center><input type='radio' name='autor_orientador' value='autor2' /></center></td></tr>";
	echo "<tr><td>3<sup>o</sup> Autor:</td><td>".
		"<input type='text' name='autor3' id='autor3'".
		" size=35 /></td>".
		"<td><center><input type='radio' name='autor_orientador' value='autor3' /></center></td></tr>";
	echo "<tr><td>4<sup>o</sup> Autor:</td><td>".
		"<input type='text' name='autor4' id='autor4'".
		" size=35 /></td>".
		"<td><center><input type='radio' name='autor_orientador' value='autor4' /></center></td></tr>";
	echo "<tr><td>5<sup>o</sup> Autor:</td><td>".
		"<input type='text' name='autor5' id='autor5'".
		" size=35 /></td>".
		"<td><center><input type='radio' name='autor_orientador' value='autor5' /></center></td></tr>";
	echo "<tr><td>6<sup>o</sup> Autor:</td><td>".
		"<input type='text' name='autor6' id='autor6'".
		" size=35 /></td>".
		"<td><center><input type='radio' name='autor_orientador' value='autor6' /></center></td></tr></table>";
	echo "<table><tr><th><br />Identifica&ccedil;&atilde;o dos".
		" Autores</th><th></th></tr>";
	echo "<tr><td>Exemplos:</td><td>".
	"a) 8<sup>o</sup> m&oacute;dulo de Agronomia, UFLA".
	", inicia&ccedil;&atilde;o cient&iacute;fica volunt&aacute;ria.".
	"<br />b) Orientador DCA, UFLA.".
	"<br />c) Coorientador DCH, UFLA.".
	"<br />d) 1<sup>o</sup> m&oacute;dulo de Filosofia, UFLA, ".
	"bolsista PIBIC/CNPq.".
	"<br />e) Bolsista Bic J&uacute;nior, Nome da Escola.".
	"<br /></td></tr>";
	echo "<tr><td>Identifica&ccedil;&atilde;o do 1<sup>o</sup>".
		" Autor*:</td><td><textarea name='infoautor1' id='infoautor1'".
		" cols=40 rows=2></textarea></td></tr>";
	echo "<tr><td>Identifica&ccedil;&atilde;o do 2<sup>o</sup>".
		" Autor:</td><td><textarea name='infoautor2' id='infoautor2'".
		" cols=40 rows=2></textarea></td></tr>";
	echo "<tr><td>Identifica&ccedil;&atilde;o do 3<sup>o</sup>".
		" Autor:</td><td><textarea name='infoautor3' id='infoautor3'".
		" cols=40 rows=2></textarea></td></tr>";
	echo "<tr><td>Identifica&ccedil;&atilde;o do 4<sup>o</sup>".
		" Autor:</td><td><textarea name='infoautor4' id='infoautor4'".
		" cols=40 rows=2></textarea></td></tr>";
	echo "<tr><td>Identifica&ccedil;&atilde;o do 5<sup>o</sup>".
		" Autor:</td><td><textarea name='infoautor5' id='infoautor5'".
		" cols=40 rows=2></textarea></td></tr>";
	echo "<tr><td>Identifica&ccedil;&atilde;o do 6<sup>o</sup>".
		" Autor:</td><td><textarea name='infoautor6' id='infoautor6'".
		" cols=40 rows=2></textarea></td></tr>";
	echo "</table><br /><br />";
	echo "<input type='submit' value='Submeter' />\n";
	echo "<input type='reset' value='Limpar Campos' />";
	echo "<br /></form><br />";
	echo "<b><font color='#dd0000'>Após clicar em 'Submeter', verifique se o seu resumo aparece em 'Resumos Submetidos' no menu à esquerda.</font></b>";