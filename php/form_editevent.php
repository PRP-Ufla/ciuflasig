<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_admin.php");
	@include("../static/lock_admin.php");
	@include("./php/class_database.php");
	@include("../php/class_database.php");
	if (!isset($_GET['id']))
		die("<alert>Requisicao invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento nao encontrado!");
	$data = $res[0];
	$ini = explode("-",$data['inicio']);
	$ter = explode("-",$data['termino']);
	$inis = explode("-",$data['inicio_submissao']);
	$ters = explode("-",$data['termino_submissao']);
	$inisel = explode("-",$data['inicio_selecionar_sessao']);
	$tersel = explode("-",$data['termino_selecionar_sessao']);
?>
<h2>Editar Evento</h2>
    <form action="admineditevent.php" method="post">
    <table border=0>
    <tr>
		<td>Edi&ccedil;&atilde;o do Evento:</td>
		<td>
			<input type="text" name="edicao" size=20
				value="<?php echo $data['edicao']; ?>"/>
			Ex: XXIII 
		</td>
    </tr>
    <tr>
		<td>Data de In&iacute;cio do Evento:</td>
		<td>
			<input type="text" name="ini_dia" size=1 maxlength=2
				value="<?php echo $ini[2]; ?>" /> /
			<input type="text" name="ini_mes" size=1 maxlength=2
				value="<?php echo $ini[1]; ?>" /> /
			<input type="text" name="ini_ano" size=3 maxlength=4
				value="<?php echo $ini[0]; ?>" />
		</td>
    </tr>
    <tr>
		<td>Data de T&eacute;rmino do Evento:</td>
		<td>
			<input type="text" name="ter_dia" size=1 maxlength=2
				value="<?php echo $ter[2]; ?>" /> /
			<input type="text" name="ter_mes" size=1 maxlength=2
				value="<?php echo $ter[1]; ?>" /> /
			<input type="text" name="ter_ano" size=3 maxlength=4
				value="<?php echo $ter[0]; ?>" />
		</td>
    </tr>
    <tr>
		<td>Data de In&iacute;cio das Submiss&otilde;es:</td>
		<td>
			<input type="text" name="isub_dia" size=1 maxlength=2
				value="<?php echo $inis[2]; ?>" /> /
			<input type="text" name="isub_mes" size=1 maxlength=2
				value="<?php echo $inis[1]; ?>" /> /
			<input type="text" name="isub_ano" size=3 maxlength=4
				value="<?php echo $inis[0]; ?>" />
		</td>
    </tr>
    <tr>
		<td>Data de T&eacute;rmino das Submiss&otilde;es:</td>
		<td>
			<input type="text" name="tsub_dia" size=1 maxlength=2
				value="<?php echo $ters[2]; ?>" /> /
			<input type="text" name="tsub_mes" size=1 maxlength=2
				value="<?php echo $ters[1]; ?>" /> /
			<input type="text" name="tsub_ano" size=3 maxlength=4
				value="<?php echo $ters[0]; ?>" />
		</td>
    </tr>
    <tr>
		<td>Data de In&iacute;cio da Seleção das Sessões:</td>
		<td>
			<input type="text" name="isel_dia" size=1 maxlength=2
				value="<?php echo $inisel[2]; ?>" /> /
			<input type="text" name="isel_mes" size=1 maxlength=2
				value="<?php echo $inisel[1]; ?>" /> /
			<input type="text" name="isel_ano" size=3 maxlength=4
				value="<?php echo $inisel[0]; ?>" />
		</td>
    </tr>
     <tr>
		<td>Data de T&eacute;rmino da Seleção das Sessões:</td>
		<td>
			<input type="text" name="tsel_dia" size=1 maxlength=2
				value="<?php echo $tersel[2]; ?>" /> /
			<input type="text" name="tsel_mes" size=1 maxlength=2
				value="<?php echo $tersel[1]; ?>" /> /
			<input type="text" name="tsel_ano" size=3 maxlength=4
				value="<?php echo $tersel[0]; ?>" />
		</td>
    </tr>
    <tr>
		<td>Limite de Resumos por Usu&aacute;rio:</td>
		<td><input type="text" name="resumos" size=2
			value="<?php echo $data['resumos']; ?>" /></td>
    </tr>
    <tr>
		<td>N&uacute;mero de Sess&otilde;es (Dias):</td>
		<td><input type="text" name="sessoes" size=2
			value="<?php echo $data['sessoes']; ?>" /></td>
    </tr>
    <tr>
		<td>Descri&ccedil;&atilde;o do Evento:</td>
		<td>
			<textarea name="desc" cols=40 rows=8><?php
				echo $data['descricao']; ?></textarea>
		</td>
    </tr>
    </table>
    <input type="hidden" name="eid" value="<?php echo $eid; ?>" />
    <input type="submit" value="Salvar" />
    <input type="button" value="Cancelar"
		onClick="evento(<?php echo $eid; ?>)" />
</form><br /><br />
