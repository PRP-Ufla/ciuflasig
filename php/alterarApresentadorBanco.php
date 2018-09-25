<?php
@include("/static/basicheaders.php");
@include("./php/class_database.php");
@include("../php/class_database.php");

if (isset($_GET['novoApresentador']) && isset($_GET['idResumo'])) {
    echo alteraApresentadorBanco($_GET['novoApresentador'], $_GET['idResumo']);
}

function alteraApresentadorBanco($apresentador, $idResumo){

    $db = new Database();

    $sql = "UPDATE resumos SET resumos.apresentador= resumos." .$apresentador. " where resumos.id=" .$idResumo. ";";

    $res = $db->executar($sql);
}
?>