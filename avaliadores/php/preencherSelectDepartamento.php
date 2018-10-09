<?php
    session_start();
	
    require_once 'config/GeralConfig.class.php';
    require_once 'db/DBUtils.class.php';
    $db = new DBUtils();
    
    $sql = "SELECT d.id, d.nome FROM departamento d
            ORDER BY d.nome;";
    $departamento = $db->executarConsulta($sql);

    echo json_encode($departamento);
?>