<?
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Define as variaveis com os valores do formulario
	$id_agenda    = $_POST['id_agenda'];
	$novo_horario = $_POST['novo_horario'];
	$novo_dia     = $_POST['novo_dia'];

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Formata a nova data
	$dh_agendamento = $novo_dia ." ". $novo_horario;

	// Monta os arrays e chama a funcao para update no banco de dados
	$colunas = array("dh_agendamento");
	$valores = array(toString($dh_agendamento));
	$id = atualizaDados("tb_agenda", $colunas, $valores, "id_agenda = $id_agenda");

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	// Direciona o usuario para o formulario de cadastro
	header("Location: /magnetoelenco/admin/elenco/reagendar_confirmacao.php?flag=2");
?>
