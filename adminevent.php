<?php
	include("static/basicheaders.php");
	include("static/lock_admin.php");
	include("php/class_database.php");
	if (!isset($_GET['id']))
		die("Requisicao invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Evento não encontrado!");
	$data = $res[0];
	$selTerday = @strtotime($data['termino_selecionar_sessao']);
	$edicao = $data["edicao"]." CIUFLA";
	
	$sql = "SELECT * FROM resumos WHERE status_avaliacao = 2 AND eventos_id='".$eid."';";
	$resumos_recusados = $db->consulta($sql);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/modal/css/bootstrap.css">
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Gerenciador de Evento</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/adminevent.js" type="text/javascript"></script>
	<script src="css/modal/js/bootstrap.min.js"></script>

	<!--<script src="js/savesessionsmanual.js" type="text/javascript"></script> -->

</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_admin.html"); ?>
<div id="conteudo">
    <center><h1>Gerenciador de Evento</h1>
    <h2><?php echo $edicao." #".$eid; ?></h2>
    <span id="loadBar" name="loadBar"></span><br />
    <table class="managecontainer">
    <tr>
		<td class="sidebar">
			<input type="hidden" id="eid" value="<?php echo $eid;?>" />
			<button class="sidebar" id="m1" onClick="evento('<?php
				echo $eid; ?>');">
				Dados do Evento</button>
			<button class="sidebar" id="m2" onClick="edit(<?php
				echo $eid; ?>)">
				Editar Evento</button>
			<button class="sidebar" id="m3" onClick="inscritos(<?php
				echo $eid; ?>)">
				Inscritos</button>
			<button class="sidebar" id="m11" onClick="removerrecusados(<?php
				echo $eid; ?>);"<?php if(count($resumos_recusados) == 0)
										echo "disabled"?>>
				Remover Resumos Recusados</button>
			<button class="sidebar" id="m12" onClick="listarrecusados(<?php
				echo $eid; ?>);">
				Listar Resumos Recusados</button>
			<button class="sidebar" id="m4" onClick="mngsessoes(<?php
				echo $eid; ?>)">
				Organizar Sess&otilde;es</button>
			<button class="sidebar" id="m6" onClick="mngsessoesmanual(<?php
				echo $eid; ?>)">
				Organizar Sess&otilde;es Manualmente</button>		
			<button class="sidebar" id="m7" onClick="admSelecionarSessoes(<?php
				echo $eid; ?>)"<?php if(@time() <= $selTerday)
										echo "disabled"?>>
				Selecionar Sess&otilde;es Aleatoriamente </button>		
			<button class="sidebar" id="m5" onClick="sessoes(<?php
				echo $eid; ?>)">
				Sess&otilde;es</button>
			<button class="sidebar" id="m13" onClick="alterarApresentador(<?php
				echo $eid; ?>)">
				Alterar Apresentador</button>
			<button class="sidebar" id="m8" onClick="gerarCertificados(<?php
				echo $eid; ?>)">
				Gerar Certificados</button>
			<button class="sidebar" id="m14" onClick="usuarios(<?php
				echo $eid; ?>);">
				Alterar Senhas e E-mail's</button>
			<button class="sidebar" id="m9" onClick="parent.open('./avaliadores')">
				Sistema de Avaliação de Sessão</button>
			<button class="sidebar" id="m10" onClick="parent.open('./avaliaresumo')">
				Sistema de Avaliação de Resumo</button>
		</td>
		<td class="managecontent"><span id="contentbar"></span></td>
    </tr>
    </table><br /><br />
    </center><br /><br />
</div>
<?php include("htm/bottom.html"); ?>
</div>
</body>
</html>
  
