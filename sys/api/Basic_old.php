<?
function printOptionsSelect($array, $value, $text, $select=0){
  	for($i = 0; $i < sizeof($array); $i++){
		if($select == $array[$i][$value]) $texto_select = " selected";
		else $texto_select = "";
		echo("<option value=\"" . $array[$i][$value] . "\" ".$texto_select.">". $array[$i][$text] ."</option>\n");
  	}	
}

/**
 * Funcao montaCampoSelect cria um campo select dinamicamente com as informações de uma tabela (geralmente uma tabela tradicional)
 * @param string $tabela nome da tabela
 * @param string $nome name e id do campo
 * @param string $campo_text campo cujo valor comporá o texto de cada opção do select
 * @param string $campo_value campo cujo valor comporá o valor de cada opção do select
 * @param integer $size altura do campo select
 * @param boolean $multiplo permite seleção múltipla ou não
 * @param string $ordenacao define o campo usado para ordenação dos elementos no select
 * @param string $estilo conteudo para a propriedade style do select
 * @param string $selected valor que deve aparecer selecioanado
 *
 * @return string 
 */
function montaCampoSelect($tabela, $nome, $campo_text, $campo_value, $size = 1, $multiplo = false, $ordenacao, $estilo, $selected = ""){
	// inicializa a string para a montagem do campo
	if($size > 1 && $multiplo == true){
		$nome .= "[]";
		$campo_select = "<select name=\"$nome\" id=\"$nome\" size=\"$size\" style=\"$estilo\" multiple=\"multiple\">\n";
	}
	else{
		$campo_select = "<select name=\"$nome\" id=\"$nome\" size=\"$size\" style=\"$estilo\">\n";
	}
	
	// monta o sql e faz a consulta no banco de dados
	$sql = "select $campo_value, $campo_text from $tabela order by $ordenacao";
	$rs = mysql_query($sql);
	
	while($row = mysql_fetch_array($rs)){
		if($multiplo){
			if($selected != ""){
				if(array_search($row[0], $selected) !== false){
					$campo_select .= "<option value=\"" . $row[0] . "\" selected >". $row[1] ."</option>\n";
				}
				else{
					$campo_select .= "<option value=\"" . $row[0] . "\">". $row[1] ."</option>\n";
				}
			}
			else{
				$campo_select .= "<option value=\"" . $row[0] . "\">". $row[1] ."</option>\n";
			}
		}
		else{
			if($row[0] == $selected){
				$campo_select .= "<option value=\"" . $row[0] . "\" selected >". $row[1] ."</option>\n";
			}
			else{
				$campo_select .= "<option value=\"" . $row[0] . "\">". $row[1] ."</option>\n";
			}		
		}
	}
	
	$campo_select .= "</select>";
	
	return $campo_select;
}

/**
 * Funcao montaCampoSelectComClasse identico ao montaCampoSelect mas recebe o valor do atributo class
 * @param string $tabela nome da tabela
 * @param string $nome name e id do campo
 * @param string $campo_text campo cujo valor comporá o texto de cada opção do select
 * @param string $campo_value campo cujo valor comporá o valor de cada opção do select
 * @param integer $size altura do campo select
 * @param boolean $multiplo permite seleção múltipla ou não
 * @param string $ordenacao define o campo usado para ordenação dos elementos no select
 * @param string $classe conteudo para o atributo class do select
 * @param string $selected valor que deve aparecer selecioanado
 *
 * @return string 
 */
function montaCampoSelectComClasse($tabela, $nome, $campo_text, $campo_value, $size = 1, $multiplo = false, $ordenacao, $classe, $selected = ""){
	// inicializa a string para a montagem do campo
	if($size > 1 && $multiplo == true){
		$nome .= "[]";
		$campo_select = "<select name=\"$nome\" id=\"$nome\" size=\"$size\" class=\"$classe\" multiple=\"multiple\">\n";
	}
	else{
		$campo_select = "<select name=\"$nome\" id=\"$nome\" size=\"$size\" class=\"$classe\">\n";
	}
	
	// monta o sql e faz a consulta no banco de dados
	$sql = "select $campo_value, $campo_text from $tabela order by $ordenacao";
	$rs = mysql_query($sql);
	
	$campo_select .= "<option value=\"\">Todos</option>\n";
	while($row = mysql_fetch_array($rs)){
		if($multiplo){
			if($selected != ""){
				if(array_search($row[0], $selected) !== false){
					$campo_select .= "<option value=\"" . $row[0] . "\" selected >". $row[1] ."</option>\n";
				}
				else{
					$campo_select .= "<option value=\"" . $row[0] . "\">". $row[1] ."</option>\n";
				}
			}
			else{
				$campo_select .= "<option value=\"" . $row[0] . "\">". $row[1] ."</option>\n";
			}
		}
		else{
			if($row[0] == $selected){
				$campo_select .= "<option value=\"" . $row[0] . "\" selected >". $row[1] ."</option>\n";
			}
			else{
				$campo_select .= "<option value=\"" . $row[0] . "\">". $row[1] ."</option>\n";
			}		
		}
	}
	
	$campo_select .= "</select>";
	
	return $campo_select;
}

function listaArquivos($dir){
	if ($handle = opendir($dir)){	
		$i = 0;
		while(false !== ($file = readdir($handle))){
		   $lista_arquivos[$i] = $file;
		   $i++;
		}	
	   closedir($handle);
	}
	
	return $lista_arquivos;
}

/**
 * Funcao removePrimeiroAnd remove a primeira ocorrencia de and na string
 * @param string $string string para remoção de and
 *
 * @return string 
 */
function removePrimeiroAnd($string){
	$string = substr($string, 4);
		
	return $string;
}

/**
 * Funcao limpaString remove formatações e injections de uma string
 * @param string $string string para remoção de formatações
 *
 * @return string 
 */
function limpaString($string){
	$string = stripslashes($string);
	$string = strip_tags($string);
	$string = htmlspecialchars($string);
	$string = str_replace("'", "''", $string);
		
	return $string;
}

/**
 * Funcao formataDataBanco recebe uma data no formato dd/mm/aaaa e retorna uma data
 * no formato aaaa-mm-dd
 * @param string $data data no formato dd/mm/aaaa
 *
 * @return string
 */
function formataDataBanco($data){	
	$vdata = explode("/", $data);
	$data_formatada = $vdata[2] ."-". $vdata[1] ."-". $vdata[0];
	return $data_formatada;
}

/**
 * Funcao toString adiciona aspas simples a uma string para formatacao SQL
 * @param string $str string para formatacao
 *
 * @return string $str string com aspas simples
 */
function toString($str){
	return "'" . $str . "'";
}

/**
 * Funcao selecionaCombo compara 2 valores e printa selected caso sejam iguais
 * @param integer $x valor x
 * @param integer $y valor y
 *
 * @return a funcão não tem retorno
 */
function selecionaCombo($x, $y){
	if($x == $y) echo("selected");
}

function selecionaRadio($x, $y){
	if($x == $y) echo("checked");
}

function defineSemana($data){
	$stamp = strtotime($data);
	$dia_semana = date("w", $stamp);
	
	$reduz_dias = 0;
	for($i = $dia_semana; $i >= 0; $i--){
		$reduz_dias--;
	}
	
	$adiciona_dias = 0;
	for($i = $dia_semana; $i < 6; $i++){
		$adiciona_dias++;
	}
	
	$limites_semana[0] = dateAdd(date("Y-m-d", $stamp), $reduz_dias);
	$limites_semana[1] = dateAdd(date("Y-m-d", $stamp), $adiciona_dias);
	
	return $limites_semana;
}

function dateAdd($data, $dias){
	$stamp = strtotime($data);
	$add = 86400 * $dias;
	
	$stamp_novo = $stamp + $add;
	$data_nova = date("Y-m-d", $stamp_novo);
	
	return $data_nova;
}

function getNomeMes($numero_mes){
	$numero_mes = $numero_mes - 1;
	$meses = array("janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
	return $meses[$numero_mes];
}

function getDiaSemana($numero_dia){
	$dias = array("domingo", "segunda-feira", "terça-feira", "quarta-feira", "quinta-feira", "sexta-feira", "sábado");
	return $dias[$numero_dia];
}

/**
 * Funcao formataData recebe uma data no formato aaaa-mm-dd e retorna uma data
 * no formato dd/mm/yyyy
 * @param string $data data no formato aaaa-mm-dd
 *
 * @return string $data_formatada data no formato dd/mm/yyyy
 */
function formataData($data){
	$vdatahora = explode(" ", $data);
	$vdatasemformato = $vdatahora[0];
	$vhora = $vdatahora[1];
	
	$vdata = explode("-", $vdatasemformato);
	$data_formatada = $vdata[2] ."/". $vdata[1] ."/". $vdata[0];
	return $data_formatada;
}

/**
 * Funcao formataDataHora recebe uma data no formato aaaa-mm-dd HH:mm:ss e retorna uma data
 * no formato dd/mm/yyyy HH:mm:ss
 * @param string $data data no formato aaaa-mm-dd HH:mm:ss
 *
 * @return string $data_formatada data no formato dd/mm/yyyy HH:mm:ss
 */
function formataDataHora($data){
	$vdatahora = explode(" ", $data);
	$vdatasemformato = $vdatahora[0];
	$vhora = $vdatahora[1];
	
	$vdata = explode("-", $vdatasemformato);
	$data_formatada = $vdata[2] ."/". $vdata[1] ."/". $vdata[0];
	return $data_formatada ." ". $vhora;
}

function formataHora($data){
	$vdatahora = explode(" ", $data);
	$vhorasemformato = $vdatahora[1];
	$vhora = explode(":", $vhorasemformato);
	$hora_formatada = $vhora[0] .":". $vhora[1];	
	
	return $hora_formatada;
}

function formataMoney($money){
	$money = number_format($money, 2, ",", ".");
	$money = "R$ " . $money;
	return $money;
}


function getStatusAdministrador(){
	if(!$_SESSION['admlogado']){
		header("Location: /adm/adm_acesso.php");
	}
}

/**
 * Funcao uploadArquivo faz o upload de um determinado arquivo
 * @param string $arquivo arquivo para upload
 * @param string $nome_arquivo nome que o arquivo deve receber
 * @param string $diretorio diretório para onde o arquivo deve ser enviado
 *
 * @return boolean
 */
function uploadArquivo($arquivo, $nome_arquivo, $diretorio){
	$nome_arquivo = $diretorio . $nome_arquivo;
	if(move_uploaded_file($arquivo, $nome_arquivo)){
		return true;
	}
	else{
		return false;
	}
}

/**
 * Funcao enviaArquivo faz o tratamento do nome do arquivo e chama a funcao de upload
 * @param string $arquivo arquivo para upload
 * @param string $nome_arquivo nome que o arquivo deve receber
 * @param integer $cd_elenco identificacao unica do registro de elenco 
 * @param integer $cd_tipo_foto identificacao unica do tipo de foto  
 * @param string $diretorio diretório para onde o arquivo deve ser enviado
 * @param date $data data associada ao arquivo
 * @param boolean $gera_thumb se deve ou nao ser gerado thumb para o arquivo
 * @param boolean $gera_pdf se deve ou nao ser gerado thumb para o pdf
 *
 * @return boolean
 */
function enviaArquivo($arquivo, $nome_arquivo, $cd_elenco, $cd_tipo_foto, $diretorio, $data, $gera_thumb = false, $gera_pdf = false){
	// Define o nome do arquivo no padrao do sistema
	$extensao_arquivo = getExtensaoArquivo($nome_arquivo);
	$cd_elenco_formatado = str_pad($cd_elenco, 6, "0", STR_PAD_LEFT);
	$data_formatada = date("YmdHis");
	$nome_formatado = "elenco_".$cd_elenco_formatado."_".$data_formatada.".".$extensao_arquivo;
	
	// Formata a data correspondente ao arquivo
	if($data != "") $data = toString(formataDataBanco($data));
	else $data = "NULL";
	
	// Chama a funcao para o upload do arquivo
	if(uploadArquivo($arquivo, $nome_formatado, $diretorio)){
		// Upload do arquivo efetuado. Gravar as informacoes no banco de dados
		
		// Cria o thumb quando solicitado
		if($gera_thumb){
			$array_arquivo = explode(".", $nome_formatado);
			$nome_thumb = $array_arquivo[0]."_72x72.".$array_arquivo[1];
			file_get_contents("http://www.magnetoelenco.com.br/v2/thumb.php?src=".$nome_formatado."&dest=".$nome_thumb."&x=72&y=72");
		}
		
		// Cria o thumb para pdf quando solicitado
		if($gera_pdf){
			$array_arquivo = explode(".", $nome_formatado);
			$nome_thumb214 = $array_arquivo[0]."_214x214.".$array_arquivo[1];
			file_get_contents("http://www.magnetoelenco.com.br/v2/thumb_pdf.php?src=".$nome_formatado."&dest=".$nome_thumb214."&x=214&y=214");

			$nome_thumb103 = $array_arquivo[0]."_103x103.".$array_arquivo[1];
			file_get_contents("http://www.magnetoelenco.com.br/v2/thumb_pdf.php?src=".$nome_formatado."&dest=".$nome_thumb103."&x=103&y=103");			
		}		
		
		// Chamada da funcao de conexao com o banco de dados
		$idconn = conectaBD();
		
		// Monta os arrays e chama a funcao para insercao no banco de dados
		$colunas = array("arquivo", "cd_elenco", "cd_tipo_foto", "dt_foto");
		$valores = array(toString($nome_formatado), $cd_elenco, $cd_tipo_foto, $data);
		$id_elenco = insereDados("tb_foto", $colunas, $valores);	
		
		// Chamada da funcao para desconexao com o banco de dados
		desconectaBD($idconn);
		
		return true;
	}
	else{
		return false;		
	}	
}

/**
 * Funcao getExtensaoArquivo retorna a extensao do arquivo informado
 * @param string $arquivo nome do arquivo
 *
 * @return string $extensao extensao do arquivo
 */
function getExtensaoArquivo($arquivo){
	if(strpos($arquivo, ".")){
		$extensao = substr($arquivo, strlen($arquivo) - 4, 4);
		$extensao = str_replace(".", "", $extensao);
		$extensao = strtolower($extensao);
		
		return $extensao;
	}
	else{
		return false;
	}
}

/**
 * Funcao getDDD recebe um telefone no formato 9999999999 e retorna um numero
 * equivalente ao DDD no formato 999
 * @param string $fone telefone no formato 9999999999
 *
 * @return string $ddd numero no formato 999
 */
function getDDD($fone){
	$ddd = substr($fone, 0, 2);
	return $ddd;
}

/**
 * Funcao getTelefone recebe um telefone no formato 9999999999 e retorna um numero
 *  no formato 9999999
 * @param string $fone telefone no formato 99999999
 *
 * @return string $telefone numero no formato 99999999
 */
function getTelefone($fone){
	$telefone = substr($fone, 2);
	return $telefone;
}

/**
 * Funcao insertTabelaAssociativa insere um registro de relacionamento em uma tabela associativa
 * @param string $tabela nome do da tabela associativa
 * @param string $cd_a nome do primeiro identificador
 * @param string $cd_b nome do segundo identificador
 * @param integer $value_a valor do primeiro identificador
 * @param Array $value_b Array com valores do segundo identificador identificador
 *
 * @return string 
 */
function insertTabelaAssociativa($tabela, $cd_a, $cd_b, $value_a, $value_b){
	if(sizeof($value_b) > 1){
	
		foreach($value_b as $valor){
			// Monta a string sql
			$sql = "insert into $tabela set $cd_a = $value_a, $cd_b = $valor";
			mysql_query($sql);
		}
		
	}
	elseif(sizeof($value_b) == 1){

		// Monta a string sql
		$sql = "insert into $tabela set $cd_a = $value_a, $cd_b = $value_b[0]";
		mysql_query($sql);	
	
	}
}

/**
 * Funcao getRegistrosTabelaAssociativa seleciona e retorna os registro de relacionamento em uma tabela associativa
 * @param string $tabela nome do da tabela associativa
 * @param string $campo_selecao nome do campo com os registros que devem ser retornados
 * @param string $campo_comparacao nome do campo que deve servir como condicional
 * @param integer $value_comparacao valor do campo condicional para a consulta
 *
 * @return Array $registros lista de registros
 */
function getRegistrosTabelaAssociativa($tabela, $campo_selecao, $campo_comparacao, $value_comparacao){
	$sql = "select $campo_selecao from $tabela where $campo_comparacao = $value_comparacao";
	$rs = mysql_query($sql);
	
	$i = 0;
	while($row = mysql_fetch_array($rs)){
		$registros[$i] = $row[0];
		$i++;
	}
	
	return $registros;
}

/**
 * Funcao getRegistrosRelacionamento seleciona e retorna os valores da tabela tradicional relacionados em uma tabela associativa
 * @param string $tabela_associativa nome do da tabela associativa
 * @param string $tabela_tradicional nome do da tabela tradicional
 * @param string $campo_selecao nome do campo com os registros que devem ser retornados
 * @param string $campo_comparacao nome do campo que deve servir como condicional
 * @param integer $value_comparacao valor do campo condicional para a consulta
 *
 * @return Array $registros lista de registros
 */
function getRegistrosRelacionamento($tabela_associativa, $tabela_tradicional, $campo_selecao, $campo_comparacao, $value_comparacao){
	$sql = "select $campo_selecao from $tabela_associativa as ta, $tabela_tradicional as tt where ta.cd_$campo_selecao = tt.id_$campo_selecao and ta.$campo_comparacao = $value_comparacao";
	$rs = mysql_query($sql);
	
	$i = 0;
	while($row = mysql_fetch_array($rs)){
		$registros[$i] = $row[0];
		$i++;
	}
	
	if($i == 0) $registros = NULL;
	
	return $registros;
}

/**
 * Funcao deletaRegistrosTabelaAssociativa deleta os registro de relacionamento em uma tabela associativa
 * @param string $tabela nome do da tabela associativa
 * @param string $campo_comparacao nome do campo que deve servir como condicional
 * @param integer $value_comparacao valor do campo condicional para a consulta
 *
 * @return boolean
 */
function deletaRegistrosTabelaAssociativa($tabela, $campo_comparacao, $value_comparacao){
	$sql = "delete from $tabela where $campo_comparacao = $value_comparacao";
	if(mysql_query($sql)){
		return true;
	}
	else{
		return false;
	}
}

/**
 * Funcao arrayParaStringComSeparador recebe um array e retorna uma string com os elementos do array separados por um caractere
 * @param Array $array array com valores
 * @param string $separador string ou caractere que servira como separador entre os elementos
 * @param string $retorno_vazio string que será retornada no caso do array estar vazio
 *
 * @return string $string_formatada;
 */
function arrayParaStringComSeparador($array, $separador, $retorno_vazio = ""){
	if(sizeof($array) > 0){	
		$string_formatada = "";
		foreach($array as $chave => $valor){
			if($chave == sizeof($array)-1) $string_formatada .= "$valor";
			else $string_formatada .= "$valor$separador ";
		}
		
		return $string_formatada;
	}
	else{
		return $retorno_vazio;
	}
}

/**
 * Funcao printSimNao Avalia o parâmetro recebido e retorna sim ou não
 * @param boolean $valor valor booleano que deve ser avaliado
 *
 * @return string $retorno string com o valor sim ou nao
 */
function printSimNao($valor){
	if($valor){
		return "sim";
	}
	else{
		return "não";
	}
}

/**
 * Funcao generatePassword gera senhas aleatoriamente
 * @param integer $length comprimento da senha
 * @param integer $strength complexidade da senha
 *
 * @return string $password string com senha gerada aleatoriamente
 */
function generatePassword($length=9, $strength=0){
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

/**
 * Funcao sendEmail envia um e-mail em formato html
 * @param string $from_name nome do remetente
 * @param string $from_email endereço de e-mail do remetente
 * @param string $to endereço de e-mail do destinatário
 * @param string $subject assunto da mensagem enviada
 * @param string $message texto da mensagem enviada
 * 
 * @return boolean 
 */
 function sendEmail($from_name, $from_email, $to, $subject, $message){
	//Definir o header Content-type.
	$mailheaders  = "MIME-Version: 1.0\n";
	$mailheaders .= "Content-type: text/html; charset=iso-8859-1\n";
	$mailheaders .= "From: ".$from_name." <".$from_email.">\n";
	$mailheaders .= "Return-Path: <".$from_email.">\n";
		
	if(mail($to, $subject, $message, $mailheaders)) return true;
	else return false;
 }
?>