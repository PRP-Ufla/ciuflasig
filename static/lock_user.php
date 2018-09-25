<?php
	if ($_SESSION['authLevel'] < 1) {
		header("Location: ./");
		die("<br />Acesso negado.<br />");
	}
?>