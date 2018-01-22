<?php
	session_start();
	include("../sys/api/Basic.php");
	include("../sys/api/DataManipulation.php");

	// Recebe os dados do formulário
	$login = limpaString($_POST['login']);
	$senha = $_POST['senha'];
	//FIM

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Consulta o BD para validar as informações
	// $sql = "select id_admin, cd_tipo_admin from tb_admin where login = '$login' and senha = PASSWORD('$senha')";
	$sql = "select id_admin, cd_tipo_admin from tb_admin where login = '$login' and senha = '$senha'";
	$rs = mysql_query($sql);

	if ($row = mysql_fetch_array($rs)){
		session_start();
		$_SESSION['id_admin']      = $row['id_admin'];
		$_SESSION['login']         = $login;
		$_SESSION['id_tipo_admin'] = $row['cd_tipo_admin'];

		// Atualiza o ultimo acesso do usuario
		date_default_timezone_set('America/Sao_Paulo');
		$agora = date('Y-m-d H:i:s');
		$sqlUpdate = "update tb_admin set dh_ultimo_acesso = '$agora' where id_admin = $id_admin;";
		mysql_query($sqlUpdate);

		header("Location: /magnetoelenco/admin/index.php");
	}
	else{
		$_SESSION['id_admin'] = "";
		unset($_SESSION['id_admin']);
		header("Location: /magnetoelenco/admin/login.php?erro=1");
	}
	//FIM

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
?>
