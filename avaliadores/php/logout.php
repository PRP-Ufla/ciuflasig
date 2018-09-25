<?php
	
	session_start();
	
	if(!isset($_SESSION['avaliadorId'])) {
		die("Requisição Inválida.");
	}

	unset($_SESSION['avaliadorId']);
	
	session_destroy();
	
?>