<?php
	
    /*
     * Script para alterar a senha do usuário.
     * Por: Sérgio A. Rodrigues(8) - 31/07/2013
    */

    include("../static/basicheaders.php");
    include("class_database.php");
    include("../cfg/config_course_state.php");
    
    if (!isset($_POST['eid']) || !isset($_POST['uid']))
	die("Requisicao Invalida!");
        
    $eid = $_POST['eid'];
    $uid = $_POST['uid'];
    
    $db = new Database();
    
    $sql = "SELECT * FROM eventos WHERE id='".$eid."';";
    $res = $db->consulta($sql);
    
    if (count($res) == 0)
        die("Evento invalido!");
    
    $sql = "SELECT * FROM usuarios WHERE id = ".$uid." AND eventos_id = ".$eid.";";    
    $res = $db->consulta($sql);
    
    if (count($res) == 0)
        die("Usuario invalido!");
        
    $sql = "SELECT * FROM usuarios WHERE id = ".$uid." AND eventos_id = ".$eid." AND senha = '".sha1($_POST['senha_atual'])."';";
    $res = $db->consulta($sql);
    
    if (count($res) == 0)
        die("Senha incorreta.");
        
    $sql = "UPDATE usuarios SET senha = '".sha1($_POST['nova_senha'])."' WHERE id = ".$uid." AND eventos_id = ".$eid.";";
    
    if (!$db->executar($sql))
	die("SQL Invalido!<br />".$sql);
    else {
        echo "Senha alterada com sucesso.";
    }

?>