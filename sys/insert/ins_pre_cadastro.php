<?
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");
	
	// Define as variaveis com os valores do formulario
	$nome             = limpaString($_POST['nome']);
	$nome_responsavel = limpaString($_POST['nome_responsavel']);
	$dt_nascimento    = formataDataBanco(limpaString($_POST['dt_nascimento']));
	//$sexo             = limpaString($_POST['sexo'];
	$tl_residencial   = limpaString($_POST['ddd_residencial']) . str_replace("-", "", limpaString($_POST['tl_residencial']));
	$tl_comercial     = limpaString($_POST['ddd_comercial']) . str_replace("-", "", limpaString($_POST['tl_comercial']));
	$tl_celular       = limpaString($_POST['ddd_celular']) . str_replace("-", "", limpaString($_POST['tl_celular']));
	$endereco         = limpaString($_POST['endereco']);
	$bairro           = limpaString($_POST['bairro']);
	$cd_cidade        = limpaString($_POST['cd_cidade']);
	$uf               = limpaString($_POST['uf']);
	$cep              = str_replace(".", "", limpaString($_POST['cep']));
	$cep              = str_replace("-", "", $cep);	
	$email            = limpaString($_POST['email']);
	$cpf              = str_replace(".", "", limpaString($_POST['cpf']));
	$cpf              = str_replace("-", "", $cpf);
	$rg               = limpaString($_POST['rg']);
		
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Monta os arrays e chama a funcao para insercao no banco de dados
	$colunas = array("nome", "nome_responsavel", "dt_nascimento", "tl_residencial", "tl_comercial", "tl_celular", "endereco", "bairro", "cd_cidade");
	array_push($colunas, "uf", "cep", "email", "cpf", "rg", "cd_status_elenco");
	
	$valores = array(toString($nome), toString($nome_responsavel), toString($dt_nascimento), toString($tl_residencial), toString($tl_comercial), toString($tl_celular), toString($endereco), toString($bairro), $cd_cidade);
	array_push($valores, toString($uf), toString($cep), toString($email), toString($cpf), toString($rg), 1);
	
	$id_elenco = insereDados("tb_elenco", $colunas, $valores);
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario para o proximo passo do cadastro
	if($id_elenco != ""){
		header("Location: /magnetoelenco/v2/pre_cadastro_agendar.php?id_elenco=$id_elenco");
	}
	else{
		header("Location: /magnetoelenco/v2/pre_cadastro_confirmacao.php?flag=1");
	}
?>