<?php
    @include("./static/basicheaders.php");
	@include("./php/class_database.php");
	@include("../static/basicheaders.php");
	@include("../php/class_database.php");
    if (!isset($_GET['id']))
    die("<alert>Requisicao invalida!");
    $eid = $_GET['id'];
    $db = new Database();
    $sql = 'SELECT *
            FROM usuarios
            WHERE usuarios.eventos_id = '.$eid.'
            ORDER BY usuarios.nome;';
    $usuarios = $db->consulta($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="js/jquery-2.0.3.min.js" type="text/javascript"></script>
    <script src="js/adminevent.js" type="text/javascript"></script>
    <!-- <form action="php/validaNovaSenha.php" method="post"
		onSubmit="teste()"> -->
    <center><h2>Atualizar dados dos usuários</h2></center>
</head>
<body>
<form>
    <table border=0 align="center">
    <tr><td colspan="2" align="center" height="30"><h3>Selecione o Usuário</h3></td></tr>
    <tr>
        <td colspan="2" height="40"><select name="nomeUsuario" id="usu-id">
        <option value="0" id="usu0" selected></option>
        <?php
            foreach ($usuarios as $i => $row) {
                echo "<option id=\"usu".$row['id']."\" value='".$row['id'].
                "'>".$row['nome']." -> ".$row['email']."
                </option>\n";
            }
        ?>
        </select></td>
    </tr>

    <!---Edição de email-->
    <tr>
        <td width="100">Novo E-mail</td>
        <td><input type="text" name="email" id="novo-email" /></td>
    </tr>
    <tr>
        <td width="100">Confirme o E-mail</td>
        <td><input type="text" name="email2" id="novo-email2" /></td>
    </tr>
        <tr><td colspan="2" height="30">
            <center><input type="button" name="save-email" value="Atualizar Email" 
                    onClick="verificaEmail(<?php echo $eid; ?>)"/>
            </center>
    </td></tr>

    <!---Edição de senha-->
    <tr>
        <td width="100">Nova Senha</td>
        <td><input type="password" name="nova-senha" id="nova-senha" /></td>
    </tr>
    <tr>
        <td width="100">Confirme a Senha</td>
        <td><input type="password" name="nova-senha2" id="nova-senha2" /></td>
    </tr>
        <tr><td colspan="2" height="30">
            <center><input type="button" name="save-senha" value="Atualizar Senha" 
                    onClick="verificaSenha(<?php echo $eid; ?>)"/>
            </center></td></tr>
    </table><br />
</form>
</body>
</html>




