<?php
	setcookie("Cookie_countdown");
	header("Content-Type: text/html; charset=ISO-8859-1", true);
	include("static/basicheaders.php");
	include("static/lock_user.php");
	include("php/class_database.php");
	//include("static/contador.php");
	
	if (!isset($_SESSION['eid']))
		die("Requisicao Invalida!");
	$eid = $_SESSION['eid'];
	$db = new Database();
	$sql = "SELECT * FROM eventos WHERE id='".$eid."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Evento Invalido!");
	$dados = $res[0];
	$ciufla = $dados['edicao']." CIUFLA";
	$subIniday = @strtotime($dados['inicio_submissao']);
	$subTerday = @strtotime($dados['termino_submissao']);
	$selIniday = @strtotime($dados['inicio_selecionar_sessao']);
	$selTerday = @strtotime($dados['termino_selecionar_sessao']);
	$sql = "SELECT * FROM usuarios WHERE eventos_id='".$eid."' AND ".
		"email='".strtoupper(trim($_SESSION['email']))."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Usuario Invalido!");
	$user = $res[0];
	$uid = $user['id'];
	$sql = "SELECT * FROM resumos WHERE ".
		"eventos_id='".$eid."' AND ".
		"usuarios_id='".$uid."';";
	$res = $db->consulta($sql);
	$resumos = $dados['resumos']-count($res);
	
	$sql = "SELECT * FROM resumos_recusados WHERE ".
		"eventos_id='".$eid."' AND ".
		"usuarios_id='".$uid."';";
	$resumos_recusados = $db->consulta($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Submiss&atilde;o de Resumos</title>
	<style type="text/css"><!--
		#mn1{ color: #6bf; }
	--></style>
	<script src="js/jquery-2.0.3.min.js" type="text/javascript"></script>
	<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
	<script src="js/user.js" type="text/javascript"></script>
</head>
<body>
<div id="centraliza">

<?php include("htm/top.html"); ?>
<?php include("static/menu_user.php"); ?>
<div id="conteudo">
	<input type="hidden" id="eid" value="<?php echo $eid; ?>" />
	<input type="hidden" id="uid" value="<?php echo $uid; ?>" />
    <center>
	
	<div id="cronometro_div"><b><font color='#dd0000'>Sua sess„o expira em: <span id="cronometro"></font></b></span></div>
	<script language="javascript">
	var minutos=60;
	var seconds=00;
	var campo = document.getElementById("cronometro");
	var campo_div = document.getElementById("cronometro_div");
	function startCountdown()
	{
		if (seconds<=0){  
			seconds=60;
			minutos-=1;
		 } 
		 if (minutos<=-1){ 
			seconds=0;
			seconds+=1;
			campo.innerHTML="";
			campo_div.innerHTML="Sess„o expirada!";
			window.location.replace("logout.php");
			return false;
		 } else{ 
			seconds-=1
			if(seconds < 10) {
				seconds = "0" + seconds;
			} 
			campo.innerHTML = " " + minutos+":"+seconds+" hs.";
			setTimeout("startCountdown()",1000); 
		}  
	}		 
	startCountdown();
	</script>
	
	
    <h1>Resumos</h1>
    <h3>Bem-vindo ao <?php echo $ciufla; ?>!</h3>
    <p>Cada primeiro autor poder&aacute; submeter no m&aacute;ximo
		<?php echo $dados['resumos']; ?> resumos.</p>
	<!--<p>O aluno que n√£o realizar a sele√ß√£o das sess√µes no per√≠odo entre <?php echo @gmdate("d/m/Y",@strtotime($dados['inicio_selecionar_sessao'])); ?> e 
	<php echo @gmdate("d/m/Y",@strtotime($dados['termino_selecionar_sessao']));?> ter√° seu(s) resumo(s) distribu√≠do(s) aleatoriamente entre elas. </p>-->
	<br /><span id="loadBar" name="loadBar"></span><br />
    <table class="managecontainer">
    <tr>
		<td class="sidebar">
			<button class="sidebar" id="m2" onClick="submit()" <?php
				//if (($resumos <= 0) || !($subIniday <= @time() && @time() <= $subTerday))
				if (($resumos <= 0) || !(($dados['inicio_submissao'] <= date('Y-m-d')) && (date('Y-m-d') <= $dados['termino_submissao'])))
					echo " disabled ";
			?>>
				Submeter Resumo</button>
			<button class="sidebar" id="m1" onClick="resumo();">Resumos Submetidos</button>
			<button class="sidebar" id="m6" onClick="resumos_recusados()" <?php
				if (count($resumos_recusados) == 0) 
					echo " disabled ";
			?>>
				Resumos Recusados</button>				
			<button class="sidebar" id="m4" onClick="SelecionaSessao()"<?php
				 
				 //if (!($selIniday <= @time() && @time() <= $selTerday))
				 if (!(($dados['inicio_selecionar_sessao'] <= date('Y-m-d')) && (date('Y-m-d') <= $dados['termino_selecionar_sessao'])))
					echo " disabled ";
				
			?>>
				Selecionar Sessıes</button>
			
<!--			<button class="sidebar" id="m3" onClick="details()">
				Detalhes</button>-->
			
			<button class="sidebar" id="m5" onClick="alterarSenha()">
				Alterar senha</button>
			
		</td>
		<td class="managecontent"><span id="contentbar"></span></td>
    </tr>
    </table><br />
	
    <div id="cronometro_div2"><b><font color='#dd0000'>Sua sess„o expira em: <span id="cronometro2"></font></b></span></div>
	<script language="javascript">
	var minutos2=60;
	var seconds2=00;
	var campo2 = document.getElementById("cronometro2");
	var campo_div2 = document.getElementById("cronometro_div2");
	function startCountdown2()
	{
		if (seconds2<=0){  
			seconds2=60;
			minutos2-=1;
		 } 
		 if (minutos2<=-1){ 
			seconds2=0;
			seconds2+=1;
			campo2.innerHTML="";
			campo_div2.innerHTML="Sess„o expirada!";
			window.location.replace("logout.php");
			return false;
		 } else{ 
			seconds2-=1
			if(seconds2 < 10) {
				seconds2 = "0" + seconds2;
			} 
			campo2.innerHTML = " " + minutos2+":"+seconds2+" hs.";
			setTimeout("startCountdown2()",1000); 
		}  
	}		 
	startCountdown2();
	</script>
	
	</center>
</div>
<?php include("htm/bottom.html"); ?>
</body>
</html>