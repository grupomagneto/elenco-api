<?
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Define as variaveis com os valores do formulario
	$texto = $_POST['texto'];

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Monta os arrays e chama a funcao para update no banco de dados
	$colunas = array("texto");
	$valores = array(toString($texto));
	atualizaDados("tb_conteudo", $colunas, $valores, "1 = 1");

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	// Direciona o usuario para o formulario de cadastro
	header("Location: /magnetoelenco/admin/elenco/cursos.php");
?>
