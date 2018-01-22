<?
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Define as variaveis com os valores do formulario
	$id_elenco    = intval($_POST['id_elenco']);
	$novo_horario = $_POST['novo_horario'];
	$novo_dia     = $_POST['novo_dia'];

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Formata a nova data
	$dh_agendamento = $novo_dia ." ". $novo_horario;

	// Monta os arrays e chama a funcao para update no banco de dados
	$colunas = array("dh_agendamento", "cd_elenco");
	$valores = array(toString($dh_agendamento), $id_elenco);
	$id = insereDados("tb_agenda", $colunas, $valores);

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	// Direciona o usuario para o formulario de cadastro
	$pagina_origem = $_SERVER['HTTP_REFERER'];
	if(strpos($pagina_origem, "admin")){
		header("Location: /magnetoelenco/admin/elenco/reagendar_confirmacao.php?flag=4");
	}
	else{
		header("Location: /magnetoelenco/v2/pre_cadastro_confirmacao.php?flag=2");
	}
?>
