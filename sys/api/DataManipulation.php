<?php
#############################################################################
#                                                                           #
# conectaBD()                                                               #
# A fun��o conectaBD() faz a conexao com o banco de dados magnetointerat1   #
# A fun��o retorna o id da conexao                                          #
# A fun��o n�o recebe par�metros                                            #
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
# A fun��o desconectaBD() fecha a conexao com o banco de dados              #
# magnetointerat1                                                           #
# A fun��o n�o tem retorno                                                  #
# A fun��o 1 par�metro:                                                     #
# $dbconn => id da conexao com o banco de dados                             #
#                                                                           #
#############################################################################
function desconectaBD($dbconn){
	mysql_close($dbconn);
}

#############################################################################
#                                                                           #
# insereDados()                                                             #
# A fun��o insereDados() faz a inser��o gen�rica no banco de dados.         #
# A fun��o retorna o id auto-incremental do registro.                       #
# A fun��o recebe 3 (tr�s) par�metros:                                      #
# $nome_tabela => Nome da tabela do banco de dados onde a inser��o ocorrer� #
# $array_colunas => Array com a lista de colunas                            #
# $array_valores => Array com a lista de valores para a inser��o            #
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
# A fun��o atualizaDados() faz um update gen�rico no banco de dados.        #
# Poss�veis retornos para a fun��o:                                         #
# true => dados atualizados com sucesso                                     #
# false => falha na atualiza��o dos dados                                   #
# A fun��o recebe 4 (quatro) par�metros:                                    #
# $nome_tabela => Nome da tabela do banco de dados onde o update ocorrer�   #
# $array_colunas => Array com a lista de colunas                            #
# $array_valores => Array com a lista de valores para a inser��o            #
# $condicao => Condi��o para a execu��o do update                           #
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
# A fun��o deletaDados() faz um delete gen�rico no banco de dados.          #
# Poss�veis retornos para a fun��o:                                         #
# true => dados deletados com sucesso                                       #
# false => falha na remo��o dos dados                                       #
# A fun��o recebe 2 (dois) par�metros:                                      #
# $nome_tabela => Nome da tabela do banco de dados onde o delete ocorrer�   #
# $condicao => Condi��o para a execu��o do delete                           #
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
