<?php
	include("php/class_database.php");
	
	if (!isset($_POST['email'])) {
		$msg = "<font color='#cc0000'>E-mail n&atilde;o informado!</font>";
	}
	else {
		$db = new Database();
		if (!$db->conectar()) {
			$msg = "<font color='#cc0000'>Erro ao conectar ao banco de dados!<br />".
				"Tente novamente mais tarde!</font>";
		}
		else {
			$db->selecionarBD();
			
			$sql = "SELECT id FROM eventos ORDER BY id DESC LIMIT 1";
			$result = $db->consulta($sql);
			$evento_id = $result[0]['id'];
			
			$sql = "SELECT * FROM usuarios WHERE email='".strtoupper(trim($_POST['email']))."' AND eventos_id = '".$evento_id."';";
			$result = $db->consulta($sql);
			if (count($result) == 0) {
				$msg = "<font color='#cc0000'>Usu&aacute;rio n&atilde;o cadastrado no evento atual!</font>";
			} else {
				$email = $_POST['email'];
				$newPassword = (rand(10001,1000001)*23) + (rand(10001,1000001)*31);
				$mensagem = "Prezado(a) ".$result[0]['nome'].",\n".
					"Foi solicitado no sistema CIUFLA da PRP a troca de sua".
					" senha, a nova senha e;:\n\nSenha: ".$newPassword."\n\n".
					"Pedimos que acesse o sistema no site abaixo e modifique sua senha para uma de".
					" sua preferencia:\nhttp://www.prp.ufla.br/ciuflasig/\n\n".
					"Atencao, a senha e case sensitive, ou seja, diferencia maiusculas de minusculas!".
					"\n\nAtenciosamente,\nPro-Reitoria de Pesquisa.";
				$reply = mail($email,"Sistema CIUFLA PRP - Nova Senha",$mensagem,"From: ".$MAIL_HEADERS['From']);
				if (!$reply) {
					$msg = "<font color='#cc0000'>N&atilde;o foi poss&iacute;vel enviar e-mail".
						" para seu endere&ccedil;o cadastrado!<br />".
						"Contate o administrador para solu&ccedil;&atilde;o do problema.</font>";
				}
				else {
					$sql = "UPDATE usuarios SET senha='".sha1($newPassword)."' WHERE email='".
						$_POST['email']."';";
					if (!$db->executar($sql)) {
						$msg = "<font color='#cc0000'>Erro ao atualizar a nova senha!<br />".
							"Contate o administrador para solu&ccedil;&atilde;o do problema.</font>";
					}
					else {
						$msg = "Sua senha foi alterada com sucesso!<br />Verifique seu e-mail ".
							"cadastrado para obter a nova senha.";
						unset($newPassword);
					}
				}
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Troca de senha</title>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_main.html"); ?>
<div id="conteudo">
    <center>
        <h1>Troca de senha:</h1>
        <b><?php echo $msg; ?></b><br />
        <input type="button" value="Voltar" onclick="window.open('./','_self')" />
    </center>
</div>
<?php include("htm/bottom.html"); ?>
</body>
</html>