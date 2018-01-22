<?
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");
	
	// Define as variaveis com os valores do formulario
	$cd_casting = $_POST['cd_casting'];
	$cd_elenco  = $_POST['cd_elenco'];
	$nome       = $_POST['nome'];
	$identificacao_casting = $_POST['identificacao_casting'];
		
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Verifica se o usuario selecionou um casting ou se deseja cadastrar um novo
	if($cd_casting == ""){
		// Criacao de um novo casting
		$colunas = array("nome", "identificacao");
		$valores = array(toString($nome), toString($identificacao_casting));
		$id_casting = insereDados("tb_casting", $colunas, $valores);
		
		$array_elenco = array($cd_elenco);
		insertTabelaAssociativa("ta_casting_elenco", "cd_casting", "cd_elenco", $id_casting, $array_elenco);
	}
	else{
		$array_elenco = array($cd_elenco);
		insertTabelaAssociativa("ta_casting_elenco", "cd_casting", "cd_elenco", $cd_casting, $array_elenco);		
	}
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario para o formulario de cadastro
	header("Location: /magnetoelenco/v2/adiciona_sucesso.php?id_elenco=$cd_elenco");
?>