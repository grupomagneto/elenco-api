<?php
/**
 * Funcao getIdElenco recebe o nome artistico do registro de elenco e retorna o id 
 * @param String $nome_artistico nome artistico do elenco
 *
 * @return integer $id_elenco identificador do elenco
 */
function getIdElenco($nome_artistico){
	$sql = "select id_elenco from tb_elenco where nome_artistico = '$nome_artistico'";
	$rs = mysql_query($sql);
	if($row = mysql_fetch_array($rs)){
		$id_elenco = $row['id_elenco'];
		return $id_elenco;
	}
	else{
		return NULL;
	}
}

/**
 * Funcao getSexo recebe o identificador do registro de elenco e retorna o sexo 
 * @param integer $id_elenco identificador do elenco
 *
 * @return char $sexo sexo do elenco
 */
function getSexo($id_elenco){
	$sql = "select sexo from tb_elenco where id_elenco = $id_elenco";
	$rs_sexo = mysql_query($sql);
	if($row = mysql_fetch_array($rs_sexo)){
		$sexo = $row['sexo'];
		return $sexo;
	}
	else{
		return NULL;
	}
}

/**
 * Funcao getInfoContato recebe o identificador do registro de elenco e retorna os dados de contato com chaves extrangeiras
 * @param integer $id_elenco identificador do elenco
 *
 * @return Array $elenco_contato informacoes de contato do elenco
 */
function getInfoContato($id_elenco){
	$sql = "select nome, nome_responsavel, nome_artistico, dt_nascimento, naturalidade, sexo, tl_residencial, tl_comercial, tl_celular, 
			endereco, bairro, cd_cidade, cidade, uf, cep, email, cpf, rg, ator, fashion, drt, drt_tipo, exclusivo, cd_qualificacao, outra_agencia, outra_agencia_nome, 
			eventos, figuracao, casting_maospes, casting_corpo, nu, producao_cabelo, aparelho, fobia, cd_fobia, alergia, cd_alergia, 
			restricao_alimentar, cd_restricao_alimentar, restricao_religiosa, cd_restricao_religiosa, filhos, filhos_quantidade, 
			cd_melhor_dia, cd_melhor_horario, publicado, viajando, dt_viagem_inicio, dt_viagem_fim, dt_validade_contrato 
			from tb_elenco 
			where id_elenco = $id_elenco";
	
	$rs = mysql_query($sql);
	
	if($elenco_contato = mysql_fetch_array($rs)){
		return $elenco_contato;
	}
	else{
		return NULL;
	}		
}

/**
 * Funcao getInfoContatoExtenso recebe o identificador do registro de elenco e retorna os dados de contato por extenso
 * @param integer $id_elenco identificador do elenco
 *
 * @return Array $elenco_contato informacoes de contato do elenco
 */
function getInfoContatoExtenso($id_elenco){
	$sql = "select nome, nome_responsavel, nome_artistico, dt_nascimento, naturalidade, sexo, tl_residencial, tl_comercial, tl_celular, 
			endereco, bairro, tt_cidade.cidade, tb_elenco.cidade as naturalidade, uf, cep, email, cpf, rg, ator, fashion, drt, drt_tipo, exclusivo, qualificacao, outra_agencia, outra_agencia_nome, 
			eventos, figuracao, casting_maospes, casting_corpo, nu, producao_cabelo, aparelho, fobia, cd_fobia, alergia, cd_alergia, 
			restricao_alimentar, cd_restricao_alimentar, restricao_religiosa, cd_restricao_religiosa, filhos, filhos_quantidade, 
			melhor_dia, melhor_horario, ((YEAR(CURDATE())-YEAR(dt_nascimento)) - (RIGHT(CURDATE(),5) < RIGHT(dt_nascimento,5))) as idade, publicado, viajando, dt_viagem_inicio, dt_viagem_fim, dt_validade_contrato 
			from tb_elenco, tt_cidade, tt_qualificacao, tt_melhor_dia, tt_melhor_horario
			where id_elenco = $id_elenco
			and tb_elenco.cd_cidade = tt_cidade.id_cidade
			and tb_elenco.cd_qualificacao = tt_qualificacao.id_qualificacao
			and tb_elenco.cd_melhor_dia = tt_melhor_dia.id_melhor_dia
			and tb_elenco.cd_melhor_horario = tt_melhor_horario.id_melhor_horario";
	
	$rs = mysql_query($sql);
	
	if($elenco_contato = mysql_fetch_array($rs)){
		return $elenco_contato;
	}
	else{
		return NULL;
	}		
}

/**
 * Funcao getCaracteristicasFisicas recebe o identificador do registro de elenco e retorna os dados de caracteristicas fisicas com chaves extrangeiras
 * @param integer $id_elenco identificador do elenco
 *
 * @return Array $elenco_fisicas informacoes de caracteristicas fisicas do elenco
 */
function getCaracteristicasFisicas($id_elenco){
	$sql = "select peso, altura, manequim, sapato, cintura, busto, quadril, terno, camisa, cd_pele, cd_olho, cd_tipo_fisico, cd_cabelo, cd_cor_cabelo, 
			cd_comprimento_cabelo, sinais, sinais_onde, cursos, trab_realizados, observacoes, publicado 
			from tb_elenco 
			where id_elenco = $id_elenco";
	
	$rs = mysql_query($sql);
	
	if($elenco_fisicas = mysql_fetch_array($rs)){
		return $elenco_fisicas;
	}
	else{
		return NULL;
	}		
}

/**
 * Funcao getCaracteristicasFisicasExtenso recebe o identificador do registro de elenco e retorna os dados de caracteristicas fisicas por extenso
 * @param integer $id_elenco identificador do elenco
 *
 * @return Array $elenco_fisicas informacoes de caracteristicas fisicas do elenco
 */
function getCaracteristicasFisicasExtenso($id_elenco){
	$sql = "select peso, altura, manequim, sapato, cintura, busto, quadril, terno, camisa, pele, olho, tipo_fisico, cabelo, cor_cabelo, 
			comprimento_cabelo, sinais, sinais_onde, cursos, trab_realizados, observacoes, publicado 
			from tb_elenco, tt_pele, tt_olho, tt_tipo_fisico, tt_cabelo, tt_cor_cabelo, tt_comprimento_cabelo 
			where id_elenco = $id_elenco
			and tb_elenco.cd_pele = tt_pele.id_pele
			and tb_elenco.cd_olho = tt_olho.id_olho
			and tb_elenco.cd_tipo_fisico = tt_tipo_fisico.id_tipo_fisico
			and tb_elenco.cd_cabelo = tt_cabelo.id_cabelo
			and tb_elenco.cd_cor_cabelo = tt_cor_cabelo.id_cor_cabelo
			and tb_elenco.cd_comprimento_cabelo = tt_comprimento_cabelo.id_comprimento_cabelo";
	
	$rs = mysql_query($sql);
	
	if($elenco_fisicas = mysql_fetch_array($rs)){
		return $elenco_fisicas;
	}
	else{
		return NULL;
	}		
}

/**
 * Funcao getCasting recebe o identificador do registro de elenco e retorna as informacoes de casting
 * @param integer $id_elenco identificador do elenco
 *
 * @return string $casting informacoes de casting
 */
function getCasting($id_elenco){
	$sql = "select ator, fashion, figuracao, eventos, sexo 
			from tb_elenco 
			where id_elenco = $id_elenco";
	
	$rs = mysql_query($sql);
	
	$casting = "";
	
	if($row = mysql_fetch_array($rs)){
		$ator      = $row['ator'];
		$fashion   = $row['fashion'];
		$figuracao = $row['figuracao'];
		$eventos   = $row['eventos'];
		$sexo      = $row['sexo'];
		
		if($ator){
			if($sexo == "M") $casting .= "ator, ";
			else $casting .= "atriz, ";
		}
		
		if($fashion){
			$casting .= "fashion, ";
		}

		
		if($figuracao){
			$casting .= "figurante, ";
		}
		
		if($eventos){
			$casting .= "recepcionista de eventos, ";
		}
	}
	
	$casting .= "modelo fotográfico";
	
	return $casting;	
}

/**
 * Funcao confirmaIdentificacaoCasting recebe o identificador de casting e verifica se é o mesmo do cookie do navegador para testar a propriedade do casting
 * @param integer $identificacao identificacao que precisa ser confirmada
 *
 * @return boolean confirmacao positiva ou negativa
 */
function confirmaIdentificacaoCasting($identificacao){
	if(isset($_COOKIE['identificacao_casting'])){
		$identificacao_casting = $_COOKIE['identificacao_casting'];
		if($identificacao_casting == $identificacao) $confirmacao = true;
		else $confirmacao = false;
	}
	else{
		$confirmacao = false;
	}
	
	return $confirmacao;
}

/**
 * Funcao isElencoViajando recebe o identificador e verifica se o casting esta viajando na data corrente 
 * @param integer $identificacao identificacao que precisa ser confirmada
 *
 * @return boolean confirmacao positiva ou negativa
 */
function isElencoViajando($id_elenco){
	$sql = "select nome from tb_elenco
			where id_elenco = $id_elenco
			and viajando = 1
			and CURDATE() >= dt_viagem_inicio and CURDATE() <= dt_viagem_fim";
	$rs = mysql_query($sql);
	if(mysql_num_rows($rs) == 1){
		return true;
	}
	else{
		return false;
	}
}
?>