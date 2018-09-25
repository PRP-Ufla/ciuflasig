<?php

    /*
     * Formulário para alterar a senha do usuário.
     * Por: Sérgio A. Rodrigues(8) - 31/07/2013
    */

    header("Content-Type: text/html; charset=ISO-8859-1", true);
    echo "<h2>Alterar senha:</h2>";     
    echo "<p><b>Os campos com * são de preenchimento obrigatório.</b></p>";
    echo "<input type='hidden' id='usuario' name='uid' value='".$_GET['uid']."'>";
    echo "<input type='hidden' id='evento' name='eid' value='".$_GET['eid']."'>";
    echo "<label>Senha Atual *:</label> <input type='password' id='senha_atual' class='form_alterar'><br><br>";
    echo "<label>Nova Senha *: </label><input type='password' id='nova_senha' class='form_alterar'><br><br>";
    echo "<label>Confirmar Nova Senha *: </label><input type='password' id='confirmar_nova_senha' class='form_alterar'><br><br>";
    echo "<input type='button' onclick='alterarSenhaSubmit()' value='Alterar Senha'><br><br>";
    echo "<b><span id='alterar_senha_msg'></span></b><br>";

?>