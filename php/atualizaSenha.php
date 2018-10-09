<?php
    @include("./static/basicheaders.php");
	@include("./php/class_database.php");
	@include("../static/basicheaders.php");
	@include("../php/class_database.php");
    if (!isset($_POST['usuId']) || !isset($_POST['senha1']))
    die("<alert>Requisicao invalida!");
    $uid = $_POST['usuId'];
    $db = new Database();
    $senha = sha1($_POST['senha1']);
    
    $sql = 'UPDATE usuarios
            SET usuarios.senha = "'.$senha.'"
            WHERE usuarios.id = '.$uid.';';

    if (!$db->executar($sql))
        die("SQL Invalido!<br />".$sql);

    else echo "Atualizado";
?>