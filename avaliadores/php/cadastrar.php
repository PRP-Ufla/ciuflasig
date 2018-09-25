<?php

	session_start();
	
	if(!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['senha']) || !isset($_POST['telefone']) || !isset($_POST['departamento'])  || !isset($_POST['cpf'])) {
		die("Requisição Inválida.");
	}
	
	require_once 'db/DBUtils.class.php';
	$db = new DBUtils();

	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$departamento = $_POST['departamento'];
	$cpf = $_POST['cpf'];
	$telefone = $_POST['telefone'];

	$procurarPorEmail = 'SELECT * FROM avaliador WHERE email = "'.$email.'";';

	$avaliador = $db->executarConsulta($procurarPorEmail);

	if($avaliador) {
		echo "Já existe um usuário com este e-mail.";
	} else {
		$inserirAvaliadorSQL = 'INSERT INTO avaliador (nome, email, senha, cpf, departamento, telefone) VALUES ("'.$nome.'", "'.$email.'", "'.
			sha1($senha).'", "'.$cpf.'", "'.$departamento.'", "'.$telefone.'");';

		$usuario = $db->executar($inserirAvaliadorSQL);

		if(!$usuario) {
			echo "Erro, SQL: ".$inserirAvaliadorSQL;
		}
	}
	
?>