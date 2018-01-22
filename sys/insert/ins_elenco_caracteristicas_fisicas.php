<?
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");
	
	// Define as variaveis com os valores do formulario
	$id_elenco             = $_POST['id_elenco'];
	$peso                  = $_POST['peso'];
	$altura                = $_POST['altura'];
	$manequim              = $_POST['manequim'];
	$busto                 = $_POST['busto'];
	$cintura               = $_POST['cintura'];
	$quadril               = $_POST['quadril'];
	$camisa                = $_POST['camisa'];
	$terno                 = $_POST['terno'];
	$sapato                = $_POST['sapato'];
	$cd_pele               = $_POST['cd_pele'];
	$cd_olho               = $_POST['cd_olho'];
	$sinais                = $_POST['sinais'];
	$sinais_onde           = $_POST['sinais_onde'];
	$cd_tatuagem           = $_POST['cd_tatuagem'];
	$cd_piercing           = $_POST['cd_piercing'];
	$cd_tipo_fisico        = $_POST['cd_tipo_fisico'];
	$cd_cabelo             = $_POST['cd_cabelo'];
	$cd_cor_cabelo         = $_POST['cd_cor_cabelo'];
	$cd_comprimento_cabelo = $_POST['cd_comprimento_cabelo'];
	$cd_aptidao            = $_POST['cd_aptidao'];
	$cd_comprimento_cabelo = $_POST['cd_comprimento_cabelo'];
	$cd_esporte            = $_POST['cd_esporte'];
	$cd_danca              = $_POST['cd_danca'];
	$cd_lingua             = $_POST['cd_lingua'];
	$cd_sotaque            = $_POST['cd_sotaque'];
	$cd_instrumento        = $_POST['cd_instrumento'];
	$cursos                = $_POST['cursos'];
	$trab_realizados       = $_POST['trab_realizados'];
	$observacoes           = $_POST['observacoes'];
	
	// Tratamento de valores vazios
	if($altura == "") $altura = "NULL";
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Monta a string sql e atualiza os dados da tabela de elenco
	$colunas = array("peso", "altura", "manequim", "sapato", "cintura", "busto", "quadril", "terno", "camisa");
	array_push($colunas, "cd_pele", "cd_olho", "cd_tipo_fisico", "cd_cabelo", "cd_cor_cabelo", "cd_comprimento_cabelo", "sinais", "sinais_onde", "cursos", "trab_realizados", "observacoes");
	
	$valores = array(toString($peso), $altura, toString($manequim), toString($sapato), toString($cintura), toString($busto), toString($quadril), toString($terno), toString($camisa));
	array_push($valores, $cd_pele, $cd_olho, $cd_tipo_fisico, $cd_cabelo, $cd_cor_cabelo, $cd_comprimento_cabelo, $sinais, toString($sinais_onde), toString($cursos), toString($trab_realizados), toString($observacoes));
	
	atualizaDados("tb_elenco", $colunas, $valores, "id_elenco = $id_elenco");
	
	// Remove os dados das tabelas associativas
	deletaRegistrosTabelaAssociativa("ta_elenco_aptidao", "cd_elenco", $id_elenco);
	deletaRegistrosTabelaAssociativa("ta_elenco_categoria", "cd_elenco", $id_elenco);
	deletaRegistrosTabelaAssociativa("ta_elenco_danca", "cd_elenco", $id_elenco);
	deletaRegistrosTabelaAssociativa("ta_elenco_esporte", "cd_elenco", $id_elenco);
	deletaRegistrosTabelaAssociativa("ta_elenco_instrumento", "cd_elenco", $id_elenco);
	deletaRegistrosTabelaAssociativa("ta_elenco_lingua", "cd_elenco", $id_elenco);
	deletaRegistrosTabelaAssociativa("ta_elenco_piercing", "cd_elenco", $id_elenco);
	deletaRegistrosTabelaAssociativa("ta_elenco_sotaque", "cd_elenco", $id_elenco);
	deletaRegistrosTabelaAssociativa("ta_elenco_tatuagem", "cd_elenco", $id_elenco);	
	
	// Insere os dados das tabelas associativas
	insertTabelaAssociativa("ta_elenco_aptidao", "cd_elenco", "cd_aptidao", $id_elenco, $cd_aptidao);
	insertTabelaAssociativa("ta_elenco_categoria", "cd_elenco", "cd_categoria", $id_elenco, $cd_categoria);
	insertTabelaAssociativa("ta_elenco_danca", "cd_elenco", "cd_danca", $id_elenco, $cd_danca);
	insertTabelaAssociativa("ta_elenco_esporte", "cd_elenco", "cd_esporte", $id_elenco, $cd_esporte);
	insertTabelaAssociativa("ta_elenco_instrumento", "cd_elenco", "cd_instrumento", $id_elenco, $cd_instrumento);
	insertTabelaAssociativa("ta_elenco_lingua", "cd_elenco", "cd_lingua", $id_elenco, $cd_lingua);
	insertTabelaAssociativa("ta_elenco_piercing", "cd_elenco", "cd_piercing", $id_elenco, $cd_piercing);
	insertTabelaAssociativa("ta_elenco_sotaque", "cd_elenco", "cd_sotaque", $id_elenco, $cd_sotaque);
	insertTabelaAssociativa("ta_elenco_tatuagem", "cd_elenco", "cd_tatuagem", $id_elenco, $cd_tatuagem);
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario para o proximo passo do cadastro
	if($_POST['btnGravar'] == "gravar e avançar"){
		header("Location: /magnetoelenco/admin/elenco/index.php");
	}
	else{
		header("Location: /magnetoelenco/admin/elenco/caracteristicas_fisicas.php?id_elenco=$id_elenco");
	}
?>