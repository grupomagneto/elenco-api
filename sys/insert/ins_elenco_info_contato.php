<?
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");
	
	// Define as variaveis com os valores do formulario
	$nome             = limpaString($_POST['nome']);
	$nome_responsavel = limpaString($_POST['nome_responsavel']);
	$nome_artistico   = limpaString($_POST['nome_artistico']);
	$dt_nascimento    = formataDataBanco($_POST['dt_nascimento']);
	$naturalidade     = $_POST['naturalidade'];
	$sexo             = $_POST['sexo'];
	$tl_residencial   = $_POST['ddd_residencial'] . str_replace("-", "", $_POST['tl_residencial']);
	$tl_comercial     = $_POST['ddd_comercial'] . str_replace("-", "", $_POST['tl_comercial']);
	$tl_celular       = $_POST['ddd_celular'] . str_replace("-", "", $_POST['tl_celular']);
	$endereco         = $_POST['endereco'];
	$bairro           = $_POST['bairro'];
	$cd_cidade        = $_POST['cd_cidade'];
	$cidade           = $_POST['cidade'];
	$uf               = $_POST['uf'];
	$cep              = $_POST['cep'];
	$email            = $_POST['email'];
	$cpf              = $_POST['cpf'];
	$rg               = $_POST['rg'];
	// $dt_validade_contrato = formataDataBanco($_POST['dt_validade_contrato']);
	
	$ator               = $_POST['ator'];
	$fashion            = $_POST['fashion'];
	$drt                = $_POST['drt'];
	$drt_tipo           = $_POST['drt_tipo'];
	$exclusivo          = $_POST['exclusivo'];
	$cd_qualificacao    = $_POST['cd_qualificacao'];
	$cd_melhor_dia      = $_POST['cd_melhor_dia'];
	$cd_melhor_horario  = $_POST['cd_melhor_horario'];
	$outra_agencia      = $_POST['outra_agencia'];
	$outra_agencia_nome = $_POST['outra_agencia_nome'];
	$eventos            = $_POST['eventos'];
	$figuracao          = $_POST['figuracao'];
	$casting_maospes    = $_POST['casting_maospes'];
	$casting_corpo      = $_POST['casting_corpo'];
	$nu                 = $_POST['nu'];
	$producao_cabelo    = $_POST['producao_cabelo'];
	$aparelho           = $_POST['aparelho'];
	
	$fobia = $_POST['fobia'];
	if($fobia == 1) $cd_fobia = $_POST['cd_fobia'];
	else $cd_fobia = "NULL";
	
	$alergia = $_POST['alergia'];
	if($alergia == 1) $cd_alergia = $_POST['cd_alergia'];
	else $cd_alergia = "NULL";
	
	$restricao_alimentar = $_POST['restricao_alimentar'];
	if($restricao_alimentar == 1) $cd_restricao_alimentar = $_POST['cd_restricao_alimentar'];
	else $cd_restricao_alimentar = "NULL";
	
	$restricao_religiosa = $_POST['restricao_religiosa'];
	if($restricao_religiosa == 1) $cd_restricao_religiosa = $_POST['cd_restricao_religiosa'];
	else $cd_restricao_religiosa = "NULL";
	
	$filhos            = $_POST['filhos'];
	$filhos_quantidade = $_POST['filhos_quantidade'];
	
	// Recebe os dados de viagem e valida as datas
	$viajando = $_POST['viajando'];
	if($viajando == 1){
		$dt_viagem_inicio = toString(formataDataBanco($_POST['dt_viagem_inicio']));
		$dt_viagem_fim    = toString(formataDataBanco($_POST['dt_viagem_fim']));
	}
	else{
		$dt_viagem_inicio = "NULL";
		$dt_viagem_fim    = "NULL";	
	}
		
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Verifica se ja existe cadastro com as informacoes enviadas
	//$sql_verifica = "select id_elenco from tb_elenco where email = '$email' or cpf = '$cpf' or rg = '$rg'";
	//$rs_verifica = mysql_query($sql_verifica);
	//if(mysql_num_rows($rs_verifica) == 0){
	
	// Monta os arrays e chama a funcao para insercao no banco de dados
	$colunas = array("nome", "nome_responsavel", "nome_artistico", "dt_nascimento", "naturalidade", "sexo", "tl_residencial", "tl_comercial", "tl_celular", "endereco", "bairro", "cd_cidade", "cidade");
	array_push($colunas, "uf", "cep", "email", "cpf", "rg", "ator", "fashion", "drt", "drt_tipo", "exclusivo", "cd_qualificacao", "outra_agencia", "outra_agencia_nome", "eventos", "figuracao");
	array_push($colunas, "casting_maospes", "casting_corpo", "nu", "producao_cabelo", "aparelho");
	array_push($colunas, "fobia", "cd_fobia", "alergia", "cd_alergia", "restricao_alimentar", "cd_restricao_alimentar", "restricao_religiosa", "cd_restricao_religiosa");
	array_push($colunas, "filhos", "filhos_quantidade", "cd_melhor_dia", "cd_melhor_horario");
	// array_push($colunas, "viajando", "dt_viagem_inicio", "dt_viagem_fim", "dt_validade_contrato", "cd_status_elenco");
	array_push($colunas, "viajando", "dt_viagem_inicio", "dt_viagem_fim", "cd_status_elenco");
	
	$valores = array(toString($nome), toString($nome_responsavel), toString($nome_artistico), toString($dt_nascimento), toString($naturalidade), toString($sexo), toString($tl_residencial), toString($tl_comercial), toString($tl_celular), toString($endereco), toString($bairro), $cd_cidade, toString($cidade));
	array_push($valores, toString($uf), toString($cep), toString($email), toString($cpf), toString($rg), $ator, $fashion, $drt, toString($drt_tipo), $exclusivo, $cd_qualificacao, $outra_agencia, toString($outra_agencia_nome), $eventos, $figuracao);
	array_push($valores, $casting_maospes, $casting_corpo, $nu, $producao_cabelo, $aparelho);
	array_push($valores, $fobia, $cd_fobia, $alergia, $cd_alergia, $restricao_alimentar, $cd_restricao_alimentar, $restricao_religiosa, $cd_restricao_religiosa);
	array_push($valores, $filhos, toString($filhos_quantidade), $cd_melhor_dia, $cd_melhor_horario);
	// array_push($valores, $viajando, $dt_viagem_inicio, toString($dt_validade_contrato), $dt_viagem_fim, 2);
	array_push($valores, $viajando, $dt_viagem_inicio, $dt_viagem_fim, 2);
	
	$id_elenco = insereDados("tb_elenco", $colunas, $valores);
		
	//}
	//else{
	//	$id_elenco = "";
	//}
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario para o proximo passo do cadastro
	if($_POST['avancar'] == "sim"){
		header("Location: /magnetoelenco/admin/elenco/caracteristicas_fisicas.php?id_elenco=$id_elenco");
	}
	else{
		header("Location: /magnetoelenco/admin/elenco/info_contato.php?id_elenco=$id_elenco");
	}
?>