<?
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Define as variaveis com os valores do formulario
	$login             = $_POST['login'];
	$cd_tipo_admin     = $_POST['cd_tipo_admin'];
	$senha             = $_POST['senha'];
	$confirmacao_senha = $_POST['confirmacao_senha'];

	// Confirma a senha
	if($senha != $confirmacao_senha){
		header("Location: /magnetoelenco/admin/usuario/admin.php?msg=3");
		die();
	}

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Verifica se ja existe registro com o login enviado
	$sql_verifica = "select id_admin from tb_admin where login = '$login'";
	$rs_verifica = mysql_query($sql_verifica);
	if(mysql_num_rows($rs_verifica) == 0){
		// Monta os arrays e chama a funcao para insercao no banco de dados
		$colunas = array("login", "cd_tipo_admin", "senha");
		$valores = array(toString($login), $cd_tipo_admin, "PASSWORD('$senha')");
		$id = insereDados("tb_admin", $colunas, $valores);
	}
	else{
		$id = "";
	}

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	// Direciona o usuario para o formulario de cadastro
	if($id != ""){
		header("Location: /magnetoelenco/admin/usuario/admin.php?msg=1");
	}
	else{
		header("Location: /magnetoelenco/admin/usuario/admin.php?msg=2");
	}
?>
