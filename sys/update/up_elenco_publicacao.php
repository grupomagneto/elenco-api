<?
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");	
	include("../api/Basic.php");
	include("../api/DataManipulation.php");
	
	// Define as variaveis com os valores do formulario
	$id_elenco = $_GET['id_elenco'];
	$publicado = $_GET['publicado'];
		
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Monta os arrays e chama a funcao para insercao no banco de dados
	$colunas = array("publicado");	
	$valores = array(toString($publicado));
		
	atualizaDados("tb_elenco", $colunas, $valores, "id_elenco = $id_elenco");	
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario de volta para o formulario de cadastro
	$pagina_origem = $_SERVER['HTTP_REFERER'];
	header("Location: $pagina_origem");
?>