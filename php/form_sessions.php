<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_admin.php");
	@include("../static/lock_admin.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	@include("./cfg/config_course_state.php");
	@include("../cfg/config_course_state.php");
	if (!isset($_GET['id']))
		die("<alert>Requisicao invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento nao encontrado!</alert>");
	$evento = $res[0];
	$sql = "SELECT * FROM cursos;";
	$cursos = $db->consulta($sql);
	
	$sql = "SELECT * FROM resumos WHERE eventos_id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<i>Nenhum resumo submetido neste evento ainda.</i>");
	$resumos = $res;
	$nRes = count($resumos);// número de resumos submetidos
	$mRes = $nRes/$evento['sessoes']; // média de resumos
	
	$sql = "SELECT * FROM resumos_recusados WHERE eventos_id='".$eid."';";
	$res = $db->consulta($sql);
	$resumos_recusados = $res;
	
	$sql = "SELECT * FROM sessoes WHERE eventos_id='".$eid."' ORDER BY id ASC;";
	$sessoes = $db->consulta($sql);
			
?>
<h2>Organiza&ccedil;&atilde;o das Sess&otilde;es</h2>
<form action="savesessions.php" method="post">
<b>N&uacute;mero de Sess&otilde;es:</b>
	<?php echo $evento['sessoes']; ?><br />
<b>N&uacute;mero de Resumos Aprovados:</b>
	<?php echo count($resumos); ?><br />
<b>Resumos por Sess&atilde;o:</b> Aproximadamente
	<?php echo (($mRes-((int)$mRes)) > 0.0 ?
	(((int)$mRes)+1):((int)$mRes)); ?><br />
<b>N&uacute;mero de Resumos Recusados:</b>
	<?php echo count($resumos_recusados); ?><br /><br />
	
<span id="sshow" onClick="secshow();"
style="font-weight: bold; border: 1px solid; cursor: pointer; background: #cde;">
&nbsp;+ </span>
<span id="shide" onClick="sechide();"
style="font-weight: bold; display: none; border: 1px solid; cursor: pointer; background: #bdf;">
&nbsp;- </span>&nbsp;
<b>N&uacute;mero de Resumos Aprovados por &Aacute;rea:</b><br />
<span id="resumos_aprovados_area" style="display: none;">
<?php
	// mostrar quantos resumos aprovados por área de conhecimento
	foreach ($cursos as $j => $row) {
		if ($row['state'] == $ATIVO) { // $ATIVO é 0, $INATIVO é 1, vide arquivo config_course_state.php
			$sql = "SELECT * FROM resumos WHERE ".
				"eventos_id='".$eid."' AND ".
				"cursos_id='".$row['id']."';";
			$res = $db->consulta($sql);
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".
				$row['nome'].":</b> ".count($res)."<br />";
		}
	}
?>
</span><br />

<span id="sshow2" onClick="secshow2();"
style="font-weight: bold; border: 1px solid; cursor: pointer; background: #cde;">
&nbsp;+ </span>
<span id="shide2" onClick="sechide2();"
style="font-weight: bold; display: none; border: 1px solid; cursor: pointer; background: #bdf;">
&nbsp;- </span>&nbsp;
<b>N&uacute;mero de Resumos Recusados por &Aacute;rea:</b><br />
<span id="resumos_recusados_area" style="display: none;">
<?php
	// mostrar quantos resumos recusados por área de conhecimento
	foreach ($cursos as $j => $row) {
		if ($row['state'] == $ATIVO) { // $ATIVO é 0, $INATIVO é 1, vide arquivo config_course_state.php
			$sql = "SELECT * FROM resumos_recusados WHERE ".
				"eventos_id='".$eid."' AND ".
				"cursos_id='".$row['id']."';";
			$res = $db->consulta($sql);
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".
				$row['nome'].":</b> ".count($res)."<br />";
		}
	}
?>
</span>

<hr /><br />
<input type="hidden" name="id" value="<?php
	echo $eid; ?>" />

<?php if (count($sessoes) == 0) { ?>

<input type="hidden" name="sessoes" value="<?php
	echo $evento['sessoes']; ?>" />
<input type="hidden" name="act" value="add" />
<table border=0>
<tr>
	<th>Sessão&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th>Dia e Hor&aacute;rio</th>
<th>Sessão possui alunos BIC Junior?</th>	
</tr>
<?php for ($i=0;$i<$evento['sessoes'];$i++) { ?>
	<tr>
		<td><b><?php echo $i+1; ?></b></td>
		<td><textarea name="horario<?php echo $i+1; ?>" cols=25
			rows=2></textarea>&nbsp;&nbsp;&nbsp;</td>

		<td><select name="bic_jr<?php echo $i+1; ?>">
			<option value='0' selected>NÃO</option>
			<option value='1' >SIM</option>
			
		</select></td>
		
	</tr>
<?php } ?>
</table>

<?php } else { // caso existam as sessoes, ou seja, count($sessoes) != 0?> 
<input type="hidden" name="sessoes" value="<?php
	echo ($evento['sessoes'] > count($sessoes) ?
		$evento['sessoes']:count($sessoes)); ?>" />
<input type="hidden" name="act" value="update" />
<table border=0>
<tr>
	<th>Sessão&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th>Dia e Hor&aacute;rio</th>
<th>Sessão possui alunos BIC Junior?</th>

</tr>


<?php foreach ($sessoes as $i => $sessao) { ?>
	<tr>
		<td><b><?php echo $sessao['id']; ?></b></td>
		<td><textarea name="horario<?php echo $sessao['id']; ?>" 
			cols=25 rows=2><?php echo $sessao['horario']; ?></textarea>
			&nbsp;&nbsp;&nbsp;</td>
			
		  <td><select name="bic_jr<?php echo $sessao['id']; ?>">
			<?php 
			
			if($sessao['bic_jr']==1){
				echo "<option value='0' >NÃO</option>";
				echo "<option value='1' selected>SIM</option>";
			}else{
				echo"<option value='0' selected >NÃO</option>";
				echo"<option value='1' >SIM</option>";
			}
							
			
			?>
			
		</select></td>
		
	</tr> 
	

<?php } ?>
<?php for ($i=0;$i<($evento['sessoes']-count($sessoes));$i++) { ?>
	<tr>
		<td><b><?php echo $i+1+count($sessoes); ?></b></td>
		<td><textarea name="horario<?php echo $i+1+count($sessoes); ?>" 
			cols=25 rows=2></textarea>&nbsp;&nbsp;&nbsp;</td>

		<td><select name="bic_jr<?php echo $i+1+count($sessoes); ?>">
			<option value='0' selected>NÃO</option>
			<option value='1' >SIM</option>
			
		</select></td>
			
	</tr>
<?php } ?>
</table>

<?php } ?>

<br />
<input type="submit" value="Salvar Sess&otilde;es" />
<input type="button" value="Cancelar" onClick="sessoes(<?php
	echo $eid; ?>)" />
</form>
