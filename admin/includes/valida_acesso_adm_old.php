<?php
	session_start();
	if($_SESSION['id_admin'] == ""){
		header("Location: /admin/login.php");
		exit();
	}
?>