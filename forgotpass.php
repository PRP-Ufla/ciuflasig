<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="author" content="Sérgio A. Rodrigues">
	<?php include("static/stylesheets.php"); ?>
	<title>CIUFLA - Troca de senha</title>
</head>
<body>
<div id="centraliza">
<?php include("htm/top.html"); ?>
<?php include("htm/menu_main.html"); ?>
<div id="conteudo">
    <center>
        <h1>Troca de senha:</h1>
        <p>Digite seu e-mail no campo abaixo e clique em "Requisitar Senha".<br>Uma mensagem será enviada para o seu e-mail
        com uma senha temporária. Após receber sua senha, altere a sua senha no sistema.<br>
	Obs: Usuários que não se cadastraram com o e-mail instucional favor verificar a caixa de SPAM de seu e-mail.</p>
	<form name="recover_senha" method="post" action="recover.php">
	    E-mail: <input type="text" name="email" />
            <input type="submit" value="Requisitar Senha" />
        </form>
    </center>
</div>
<?php include("htm/bottom.html"); ?>
</body>
</html>