<?php
#############################################################################
#                                                                           #
# conectaBD()                                                               #
# A função conectaBD() faz a conexao com o banco de dados magnetointerat1   #
# A função retorna o id da conexao                                          #
# A função não recebe parâmetros                                            #
#                                                                           #
#############################################################################
function conectaBD(){
	$dbconn = mysql_connect('elencooriginal.mysql.dbaas.com.br', 'elencooriginal', 'M@g3l3nc0_0962');
	mysql_select_db('elencooriginal', $dbconn);
	return $dbconn;
}

#############################################################################
#                                                                           #
# desconectaBD()                                                            #
# A função desconectaBD() fecha a conexao com o banco de dados              #
# magnetointerat1                                                           #
# A função não tem retorno                                                  #
# A função 1 parâmetro:                                                     #
# $dbconn => id da conexao com o banco de dados                             #
#                                                                           #
#############################################################################
function desconectaBD($dbconn){
	mysql_close($dbconn);
}

#############################################################################
#                                                                           #
# insereDados()                                                             #
# A função insereDados() faz a inserção genérica no banco de dados.         #
# A função retorna o id auto-incremental do registro.                       #
# A função recebe 3 (três) parâmetros:                                      #
# $nome_tabela => Nome da tabela do banco de dados onde a inserção ocorrerá #
# $array_colunas => Array com a lista de colunas                            #
# $array_valores => Array com a lista de valores para a inserção            #
#                                                                           #
#############################################################################
function insereDados($nome_tabela, $array_colunas, $array_valores, $debug = false){
	if(sizeof($array_colunas) != sizeof($array_valores)){
		//Quantidade de colunas diferente da quantidade de valores
		return -1;
	}
	else{
		//Monta a string sql
		$sql = "INSERT INTO $nome_tabela (";
		for($i = 0; $i < sizeof($array_colunas); $i++){
			$sql .= $array_colunas[$i];
			if($i < (sizeof($array_colunas) - 1)) $sql .= ", ";
		}
		$sql .= ") VALUES (";
		for($i = 0; $i < sizeof($array_valores); $i++){
			$sql .= $array_valores[$i];
			if($i < (sizeof($array_valores) - 1)) $sql .= ", ";
		}
		$sql .= ");";

		if($debug) die($sql);

		//Executa a string
		mysql_query($sql) or die("ERRO - insereDados - " . mysql_error());
		return mysql_insert_id();
	}
}

#############################################################################
#                                                                           #
# atualizaDados()                                                           #
# A função atualizaDados() faz um update genérico no banco de dados.        #
# Possíveis retornos para a função:                                         #
# true => dados atualizados com sucesso                                     #
# false => falha na atualização dos dados                                   #
# A função recebe 4 (quatro) parâmetros:                                    #
# $nome_tabela => Nome da tabela do banco de dados onde o update ocorrerá   #
# $array_colunas => Array com a lista de colunas                            #
# $array_valores => Array com a lista de valores para a inserção            #
# $condicao => Condição para a execução do update                           #
#                                                                           #
#############################################################################
function atualizaDados($nome_tabela, $array_colunas, $array_valores, $condicao, $debug = false){
	if(sizeof($array_colunas) != sizeof($array_valores)){
		//Quantidade de colunas diferente da quantidade de valores
		return false;
	}
	else{
		//Monta a string sql
		$sql = "UPDATE $nome_tabela SET ";
		for($i = 0; $i < sizeof($array_colunas); $i++){
			$sql .= $array_colunas[$i] . " = " . $array_valores[$i];
			if($i < (sizeof($array_colunas) - 1)) $sql .= ",";
		}
		$sql .= " WHERE " . $condicao . ";";

		if($debug) die($sql);

		//Executa a string
		if(mysql_query($sql)){
			return true;
		}
		else{
			echo("ERRO - atualizaDados - " . mysql_error());
			return false;
		}
	}
}

#############################################################################
#                                                                           #
# deletaDados()                                                             #
# A função deletaDados() faz um delete genérico no banco de dados.          #
# Possíveis retornos para a função:                                         #
# true => dados deletados com sucesso                                       #
# false => falha na remoção dos dados                                       #
# A função recebe 2 (dois) parâmetros:                                      #
# $nome_tabela => Nome da tabela do banco de dados onde o delete ocorrerá   #
# $condicao => Condição para a execução do delete                           #
#                                                                           #
#############################################################################
function deletaDados($nome_tabela, $condicao){
	//Monta a string sql
	$sql = "DELETE FROM $nome_tabela WHERE " . $condicao . ";";

	//Executa a string
	if(mysql_query($sql)){
		return mysql_affected_rows();
	}
	else{
		echo("ERRO - deletaDados - " . mysql_error());
		return false;
	}
}
?>
