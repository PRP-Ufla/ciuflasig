<?php
	require_once 'db/DBUtils.class.php';
	require_once 'config/config_admin.php';
	
	$msg = "";
	$result = "";
	
	if (!isset($_POST['email'])|| $_POST['email'] == NULL){
		$result = 3;
	}
	else {
		$db = new DBUtils();
		if (!$db) {
			$msg = "Erro ao conectar ao banco de dados, tente novamente mais tarde!";
		}
		else {
			$sql = "SELECT * FROM avaliador WHERE email='".$_POST['email']."';";
			$result = $db->executarConsulta($sql);
			if (count($result) == 0) {
				$result = 4;
			} else {
				$email = $result[0]['email'];
				$newPassword = (rand(10001,1000001)*23) + (rand(10001,1000001)*31);
				$mensagem = "Prezado(a) Prof(a) ".$result[0]['nome'].",\n".
					"Foi solicitado no sistema do CIUFLA a troca de sua".
					" senha, a nova senha e:\n\nSenha: ".$newPassword."\n\n".
					"Pedimos que acesse o sistema no site abaixo e modifique sua senha para uma de".
					" sua preferencia:\nhttp://www.prp.ufla.br/ciuflasig/avaliadores/\n\n".
					"Atencao, a senha e case sensitive, ou seja, diferencia maiusculas de minusculas!".
					"\n\nAtenciosamente,\nPro-Reitoria de Pesquisa.";
				$reply = mail($email,"Sistema PRP - Nova Senha",$mensagem,"From: ".$MAIL_HEADERS['From']);
				if (!$reply) {
						$result = 5;
				}
				else {
					$sql = "UPDATE avaliador SET senha='".sha1($newPassword)."' WHERE email='".
						$_POST['email']."';";
					if (!$db->executar($sql)) {
							$result = 0;
					}
					else {
						unset($newPassword);
						$result = 1;
					}
				}
			}
		}
	}
	
	echo $result;
	
	

?>
