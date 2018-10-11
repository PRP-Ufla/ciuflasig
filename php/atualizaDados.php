<?php
    @include("./static/basicheaders.php");
	@include("./php/class_database.php");
	@include("../static/basicheaders.php");
	@include("../php/class_database.php");

    if (!isset($_POST['usuId']) && (!isset($_POST['novoEmail1']) || !isset($_POST['senha1']))){
        die("<alert>Requisicao invalida!");
    }

    function get_sql_Email($email, $uid){
        return 'UPDATE usuarios
        SET usuarios.email = "'.$email.'"
        WHERE usuarios.id = '.$uid.';';
    }

    function get_sql_Senha($senha, $uid){
        return 'UPDATE usuarios
        SET usuarios.senha = "'.$senha.'"
        WHERE usuarios.id = '.$uid.';';
    }

    $uid = $_POST['usuId'];
    $db = new Database();
    $sql = "";

    if(isset($_POST['novoEmail1'])){
        $email = $_POST['novoEmail1'];
        $sql = get_sql_Email($email, $uid);
    }
    else if(isset($_POST['senha1'])){
        $senha = sha1($_POST['senha1']);
        $sql = get_sql_Senha($senha, $uid);
    }

    if ($sql == "" || !$db->executar($sql))
        die("SQL Inválido!");

    else echo "Atualizado";
?>