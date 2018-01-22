<?
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Define as variaveis com os valores do formulario
	$id                = $_POST['id'];
	$senha             = $_POST['senha'];
	$confirmacao_senha = $_POST['confirmacao_senha'];

	// Confirma a senha
	if($senha != $confirmacao_senha){
		header("Location: /magnetoelenco/admin/usuario/admin.php?id=$id&msg=3");
		die();
	}

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Monta os arrays e chama a funcao para update no banco de dados
	$colunas = array("senha");
	$valores = array(toString(sha1($senha)));
	$id = atualizaDados("tb_admin", $colunas, $valores, "id_admin = $id");

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	// Direciona o usuario para o formulario de cadastro
	header("Location: /magnetoelenco/admin/usuario/admin.php?id=$id&msg=4");
?>
