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
	
	$sql = "SELECT * FROM usuarios WHERE eventos_id='".$eid.
		"' ORDER BY nome ASC;";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<i>Ningu&eacute;m cadastrado ainda.</i>");
	$users = $res;
?>
<h3>Usu&aacute;rios Cadastrados:
	<?php echo count($users); ?></h3>
<table border=0 style="border-spacing: 5px;">
<tr>
	<th>Nome:</th>
	<th>E-mail:</th>
</tr>
<?php foreach ($users as $i => $row) { ?>
<tr>
	<td style="padding: 0px 20px 0px 0px;">
		<b><?php echo $row['nome']; ?></b></td>
	<td><?php echo $row['email']; ?></td>
</tr>
<?php } ?>
</table><br />
