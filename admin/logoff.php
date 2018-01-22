<?php
	session_start();

	unset($_SESSION['id_admin']);
	session_unset($_SESSION['id_admin']);

	header("Location: /magnetoelenco/admin/login.php");
?>
