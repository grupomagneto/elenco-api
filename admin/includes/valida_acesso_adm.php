<?php
	session_start();
	if($_SESSION['id_admin'] == ""){
		header("Location: /magnetoelenco/admin/login.php");
		exit();
	}
?>
