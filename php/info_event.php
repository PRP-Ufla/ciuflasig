<?php
	@include("./static/basicheaders.php");
	@include("./php/class_database.php");
	@include("../static/basicheaders.php");
	@include("../php/class_database.php");
	if (!isset($_GET['id']))
		die("<alert>Requisicao invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("<alert>Evento nao encontrado: ".$eid);
	$data = $res[0];
	
	$edicao = $data["edicao"]." CIUFLA";
?>
<b>Edi&ccedil;&atilde;o:</b> <?php echo $edicao; ?><br />
<b>Realiza&ccedil;&atilde;o:</b>
	<?php echo @gmdate("d/m/Y",@strtotime($data['inicio'])); ?> a
	<?php echo @gmdate("d/m/Y",@strtotime($data['termino'])); ?>
	<br />
<b>Inscri&ccedil;&otilde;es:</b>
	<?php
		echo @gmdate("d/m/Y",@strtotime($data['inicio_submissao']));
	?> a
	<?php
		echo @gmdate("d/m/Y",@strtotime($data['termino_submissao'])); 
	?>
	<br />
<b>Submiss&otilde;es:</b>
	<?php
		echo @gmdate("d/m/Y",@strtotime($data['inicio_submissao']));
	?> a
	<?php
		echo @gmdate("d/m/Y",@strtotime($data['termino_submissao'])); 
	?>
	<br /><?php 
  /*<b>Seleção das Sessões:</b>
	<?php
		echo @gmdate("d/m/Y",@strtotime($data['inicio_selecionar_sessao']));
	?> a
	<?php
		echo @gmdate("d/m/Y",@strtotime($data['termino_selecionar_sessao'])); 
	?>
	*/
	?>
	<br />
<b>N&uacute;mero de Sess&otilde;es:</b>
	<?php echo $data['sessoes']; ?><br />
<b>N&uacute;mero de Resumos por Primeiro Autor:</b>
	<?php echo $data['resumos']; ?><br />
<b>Descri&ccedil;&atilde;o Geral:</b><br /><br />
	<?php echo $data['descricao']; ?>
	<br /><br />
