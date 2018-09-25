<?php
	@include("./static/basicheaders.php");
	@include("../static/basicheaders.php");
	@include("./static/lock_admin.php");
	@include("../static/lock_admin.php");
?>
<center><h1>Registrar Evento</h1>
    <center><form action="adminaddevent.php" method="post">
    <table border=0>
    <tr>
		<td>Edi&ccedil;&atilde;o do Evento:</td>
		<td>
			<input type="text" name="edicao" size=20 />
			Ex: XXIII
		</td>
    </tr>
    <tr>
		<td>Data de In&iacute;cio do Evento:</td>
		<td>
			<input type="text" name="ini_dia" size=1 maxlength=2 /> /
			<input type="text" name="ini_mes" size=1 maxlength=2 /> /
			<input type="text" name="ini_ano" size=3 maxlength=4 />
		</td>
    </tr>
    <tr>
		<td>Data de T&eacute;rmino do Evento:</td>
		<td>
			<input type="text" name="ter_dia" size=1 maxlength=2 /> /
			<input type="text" name="ter_mes" size=1 maxlength=2 /> /
			<input type="text" name="ter_ano" size=3 maxlength=4 />
		</td>
    </tr>
    <tr>
		<td>Data de In&iacute;cio das Submiss&otilde;es:</td>
		<td>
			<input type="text" name="isub_dia" size=1 maxlength=2 /> /
			<input type="text" name="isub_mes" size=1 maxlength=2 /> /
			<input type="text" name="isub_ano" size=3 maxlength=4 />
		</td>
    </tr>
    <tr>
		<td>Data de T&eacute;rmino das Submiss&otilde;es:</td>
		<td>
			<input type="text" name="tsub_dia" size=1 maxlength=2 /> /
			<input type="text" name="tsub_mes" size=1 maxlength=2 /> /
			<input type="text" name="tsub_ano" size=3 maxlength=4 />
		</td>
    </tr>
    <tr>
		<td>Data de In&iacute;cio da Seleção das Sessões:</td>
		<td>
			<input type="text" name="isel_dia" size=1 maxlength=2 /> /
			<input type="text" name="isel_mes" size=1 maxlength=2 /> /
			<input type="text" name="isel_ano" size=3 maxlength=4 />
		</td>
    </tr>
    <tr>
		<td>Data de T&eacute;rmino da Seleção das Sessões:</td>
		<td>
			<input type="text" name="tsel_dia" size=1 maxlength=2 /> /
			<input type="text" name="tsel_mes" size=1 maxlength=2 /> /
			<input type="text" name="tsel_ano" size=3 maxlength=4 />
		</td>
    </tr>
    <tr>
		<td>Limite de Resumos por Usu&aacute;rio:</td>
		<td><input type="text" name="resumos" size=2 /></td>
    </tr>
    <tr>
		<td>N&uacute;mero de Sess&otilde;es (Dias):</td>
		<td><input type="text" name="sessoes" size=2 /></td>
    </tr>
    <tr>
		<td>Descri&ccedil;&atilde;o do Evento:</td>
		<td>
			<textarea name="desc" cols=30 rows=4></textarea>
		</td>
    </tr>
    </table>
    <input type="submit" value="Registrar" />
    <input type="reset" value="Limpar Campos" />
</form></center><br /><br />
