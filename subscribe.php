<?php
	header("Content-Type: text/html; charset=ISO-8859-1", true);
	include("static/basicheaders.php");
	include("php/class_database.php");
	include("cfg/config_course_state.php");
	if (!isset($_GET['id']))
		die("Requisicao Invalida!");
	$eid = $_GET['id'];
	$db = new Database();
	$today = @gmdate("Y-m-d");
	$sql = "SELECT * FROM eventos WHERE id='".$eid."' AND ".
		"termino_submissao >= '".$today."';";
	$res = $db->consulta($sql);
	if (count($res) == 0)
		die("Evento Invalido!");
	$sql = "SELECT * FROM cursos ORDER BY nome;";
	$cursos = $db->consulta($sql);
	if (count($cursos) == 0)
		die("Nenhum curso cadastrado, inscricao indisponivel!");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Inscrever-se</title>
	<script src="js/jquery-2.0.3.min.js" type="text/javascript"></script>
	<script src="js/subscribe.js" type="text/javascript"></script>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_main.html"); ?>
<div id="conteudo">
    <center><h1>Ficha de Inscri&ccedil;&atilde;o</h1>
    Todos os campos s&atilde;o obrigat&oacute;rios.<br />
    O e-mail deve ser v&aacute;lido pois ser&atilde;o enviadas
		informa&ccedil;&otilde;es para o mesmo.<br />
    Favor utilizar preferencialmente o e-mail institucional.<br /><br />
    <form action="subscribeSubmit.php" method="post"
		onSubmit="return checkFields()">
    <table border=0>
    <tr>
		<td>Nome Completo:</td>
		<td><input type="text" name="nome" id="nome" size=40 /></td>
    </tr>
     <tr>
		<td>Você está vinculado a qual programa:</td>
		<td><select name="bic_jr" id="bic_jr">
				<option value="2" selected>-- Selecionar --</option>
				<option value="0">Iniciação Científica</option>
				<option value="1">Bic Júnior</option>
				<!-- <option value="3">Iniciação à Docência</option> -->
			</select></td>
    </tr>
    <tr>
		<td>E-mail:</td>
		<td><input type="text" name="email" id="email" size=30 />
		<br><font color='red'>(Obrigatório e-mail institucional. Ex.: exemplo@computacao.ufla.br)</color></td>
    </tr>
    <tr>
		<td>Senha de Acesso:</td>
		<td><input type="password" name="senha" id="senha" size=25 /></td>
    </tr>
    <tr>
		<td>Confirmar Senha:</td>
		<td><input type="password" name="senha2" id="senha2" size=25 /></td>
    </tr>
   
    <tr>
		<td>Matr&iacute;cula:</td>
		<td><input disabled type="text" name="mat" id="mat" size=30 /><br />
		(Campo não requisitado para Bic Jr)</td>
    </tr>
	<tr>
		<td>CPF:</td>
		<td><input type="text" name="cpf" id="cpf" size=11  maxlength="11" /><br/>
		(Somente Números)
		</td>
    </tr>
    <tr>
		<td>Telefone:</td>
		<td>( <input type="text" name="ddd" id="ddd" size=2
			maxlength=2 /> )
		<input type="text" name="tel" id="tel" size=10 /></td>
    </tr>
    <tr><td></>Institui&ccedil;&atilde;o:</td><td><table><tr><td>
				<input disabled type="radio" name="inst" value="1"  class="inst" id="inst1" /> UFLA</td><td>
				<input disabled type="radio" name="inst" value="2" class="inst"	id="inst2" /> Escola(Bic Jr):<select disabled name="escola" id="escola">
				<option value="2" selected>-- Selecionar --</option>
				<option value="E.E. Azarias Ribeiro">E.E. Azarias Ribeiro</option>
				<option value="E.E. Cinira Carvalho">E.E. Cinira Carvalho</option>
				<option value="E.E. Cristiano de Souza">E.E. Cristiano de Souza</option>
				<option value="E.E. Dora Matarazzo">E.E. Dora Matarazzo</option>
				<option value="E.E. Firmino Costa">E.E. Firmino Costa</option>
				<option value="E.E. João Batista Hermeto">E.E. João Batista Hermeto</option>
				<option value="E.E. Tiradentes">E.E. Tiradentes</option>
				<option value="Colégio Tiradentes">Colégio Tiradentes</option>
			</select></td><td>
				<input disabled type="radio" name="inst" value="3" class="inst" 	id="inst3" /> Outras: <input disabled type="text" name="outrasInsts" id="outrasInsts" size=15></td></tr>
    </tr>
    </table>
    <tr>
		<td>Curso/Área:</td>
		<td><select disabled name="curso" id="curso">
		<option value="0" id="cur0" selected>-- Selecione um Curso --</option>
		<?php
			foreach ($cursos as $i => $row) {
				if ($row['state'] == $ATIVO && $row['id']!=6) {
					echo "<option id=\"cur".$row['id']."\" value='".$row['id'].
						"'>".$row['nome']." (".$row['sigla'].
						")</option>\n";
				}else if($row['state'] == $ATIVO && $row['id']==6){
                                        echo "<option id=\"cur".$row['id']."\" value='".$row['id'].
						"' >".$row['nome']." (".$row['sigla'].
						")</option>\n";
                                }
			}
		?>
		</select>(Campo não requisitado para Bic Jr)</td>
    </tr>
    
    
    </table><br />
    <input type="submit" value="Inscrever" />
    <input type="reset" value="Limpar Campos" />
    <input type="hidden" name="eid" value="<?php echo $eid; ?>" />
    </form>
	</center><br /><br />
</div>
<?php include("htm/bottom.html"); ?>
</div>
</body>
</html>