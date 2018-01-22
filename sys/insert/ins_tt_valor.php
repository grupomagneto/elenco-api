<?
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");
	
	// Define as variaveis com os valores do formulario
	$valor              = $_POST['valor'];
	$tabela_tradicional = $_POST['tabela_tradicional'];
	
	// Define os nomes das colunas da tabela tradicional
	$coluna_id    = "id_".str_replace("tt_", "", $tabela_tradicional);
	$coluna_valor = str_replace("tt_", "", $tabela_tradicional);	
		
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Verifica se ja existe registro com o valor enviado
	$sql_verifica = "select $coluna_id from $tabela_tradicional where $coluna_valor = '$valor'";
	$rs_verifica = mysql_query($sql_verifica);
	if(mysql_num_rows($rs_verifica) == 0){
		// Monta os arrays e chama a funcao para insercao no banco de dados
		$colunas = array($coluna_valor);
		$valores = array(toString($valor));
		$id = insereDados($tabela_tradicional, $colunas, $valores);
	}
	else{
		$id = "";
	}
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario para o gerenciamento da tabela tradicional
	if($id != ""){
		header("Location: /magnetoelenco/admin/tabelas_tradicionais/tabela.php?tabela_tradicional=$tabela_tradicional&operacao=1");
	}
	else{
		header("Location: /magnetoelenco/admin/tabelas_tradicionais/tabela.php?tabela_tradicional=$tabela_tradicional&operacao=2");
	}
?>