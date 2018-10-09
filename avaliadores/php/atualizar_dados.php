<?php
    session_start();

    $sql;
    $avaliadorId = $_SESSION['avaliadorId'];

    if(isset($_POST['cpf'])) {
        $cpf = $_POST['cpf'];

        $sql = 'UPDATE avaliador
            SET cpf = "'.$cpf.'"
            WHERE avaliador.id = '.$avaliadorId.';';
    }
    else if(isset($_POST['departamento'])) {
        $departamento = $_POST['departamento'];

        $sql = 'UPDATE avaliador
            SET departamento = "'.$departamento.'"
            WHERE avaliador.id = '.$avaliadorId.';';
    }
    else{
        die("Requisiчуo Invсlida.");
    }

    require_once 'db/DBUtils.class.php';
    $db = new DBUtils();

    $atualizar = $db->executar($sql);
    
    if(!$atualizar){
        echo "Erro, SQL: ".$atualizar;
    }
?>