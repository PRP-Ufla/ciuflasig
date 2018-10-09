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
    <center><h3>Atualizar senha dos usuários</h3></center>
</head>
<body>
<form>
    <table border=0>
    <tr>
    <td>Selecione o Usuário</td>
        <td><select name="nomeUsuario" id="usu-id">
        <option value="0" id="usu0" selected></option>
        <?php
            foreach ($usuarios as $i => $row) {
                echo "<option id=\"usu".$row['id']."\" value='".$row['id'].
                "'>".$row['nome']."
                </option>\n";
            }
        ?>
        </select></td>
    </tr>
    <tr>
        <td>Nova Senha</td>
        <td><input type="password" name="nova-senha" id="nova-senha" /></td>
    </tr>
    <tr>
        <td>Confirme a Senha</td>
        <td><input type="password" name="nova-senha2" id="nova-senha2" /></td>
    </tr>
    </table><br />
    <center><input type="button" value="Atualizar" 
    onClick="vertificaSenha(<?php echo $eid; ?>)"/></center>
    
</form>
</body>
</html>




