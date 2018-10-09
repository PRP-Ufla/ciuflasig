<?php
    session_start();
    require_once 'db/DBUtils.class.php';
    $db = new DBUtils();
    
    $avaliadorId = $_SESSION['avaliadorId'];
    $sql = 'SELECT *
            FROM avaliador 
            WHERE avaliador.id = '.$avaliadorId.' AND ((avaliador.cpf = "") OR (avaliador.cpf = NULL));';
    $cpf = $db->executarConsulta($sql);

    $sql = 'SELECT *
            FROM avaliador 
            WHERE avaliador.id = '.$avaliadorId.' AND avaliador.departamento = "0";';
    $departamento = $db->executarConsulta($sql);

    if(count($cpf) == 1 && count($departamento) == 1){
        // Não tem nem cpf nem departamento
        $protocolo = '1';
    }
    else if(count($cpf) == 0 && count($departamento) == 1){
        // Não tem departamento mas tem cpf
        $protocolo = '2';
    }
    else if(count($cpf) == 1 && count($departamento) == 0){
        // Não tem cpf mas tem departamento
        $protocolo = '3';
    }
    else{
        // Tem os dois
        $protocolo = '0';
    }

    echo $protocolo;

?>