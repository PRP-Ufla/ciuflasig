<?php
	@set_time_limit(600);
	$gmtDate = @gmdate ("D, d M Y H:i:s");
	
	header ("Expires: {$gmtDate} GMT");
	header ("Last-Modified: {$gmtDate} GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header("Content-Type: text/html;  charset=ISO-8859-1",true);
	
	@session_start();
	if (!isset($_SESSION['time'])) {
		$_SESSION['time'] = time();
		$_SESSION['authLevel'] = 0;
	} else if (time() - $_SESSION['time'] > 21600) {
		$_SESSION['time'] = time();
		if ($_SESSION['authLevel'] != 0) {
			$_SESSION['authLevel'] = 0;
			header("Location: ./");
		}
	} else {
		$_SESSION['time'] = time();
	}
?>