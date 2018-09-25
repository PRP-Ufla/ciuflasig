<?php

    if (!isset($_POST['id'])){
        die("Requisicao Invalida!");
    } else {
        $id = $_POST['id'];
    }

    if (!isset($_POST['protocolo'])){
        $protocolo = null;
    } else {
        $protocolo = $_POST['protocolo'];
    }
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="author" content="Renato R. R. de Oliveira e Vitor A. R. Andrade">
		<meta http-equiv="Content-Type" content="text/html; accept-charset=utf-8=UTF-8">
		<?php include("static/stylesheets.php"); ?>
		<script src='https://www.google.com/recaptcha/api.js?hl=pt-BR   '></script>
        <script type="text/javascript" src="js/script.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<title>CIUFLA - Certificados</title>
		<style type="text/css"><!--
			#mn6{ color: #6bf; }
		--></style>
	</head>
<body>
	<div id="centraliza">
		<?php include("htm/top.html"); ?>
		<?php include("htm/menu_main.html"); ?>
		<div id="conteudo">
			<center>
                <form action="recaptchaValidate.php" method="post">
                <div> Verificação de segurança</div>
                <br>
                <div class="g-recaptcha" data-sitekey="6LdZZVIUAAAAAAau6ACfF9-6spVEiS06rbglSNct" data-callback="callback"></div>
                <script>
                function callback(){

                    /* Após passar pelo reCAPTCHA, é criado um form com os dados vindos da busca do certificado
                     e é feito o redirecionamento para a geração do certificado */

                    var id = "<?php  echo $id; ?>";
                    var protocolo = "<?php  echo $protocolo; ?>";

                    var form = document.createElement("form");
                    var element1 = document.createElement("input");
                    var element2 = document.createElement("input");

                    form.method = "POST";
                    form.action = "generateCertificadoPDF.php";

                    element1.value=id;
                    element1.name="id";
                    form.appendChild(element1);

                    if (protocolo){
                        element2.value=protocolo;
                        element2.name="protocolo";
                        form.appendChild(element2);
                    }

                    document.body.appendChild(form);

                    form.submit();

                }
                </script>
                </form>
			</center>
		</div>
		<?php include("htm/bottom.html"); ?>
	</div>
</body>
</html>
