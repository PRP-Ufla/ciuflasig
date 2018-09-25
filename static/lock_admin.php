<?php
	if ($_SESSION['authLevel'] < 2) {
		header("Location: ./");
		die("<br />Acesso negado.<br />");
	}
?>