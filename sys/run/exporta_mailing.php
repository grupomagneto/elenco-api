<?php
	// Inclui os arquivos de sistema
	include("../api/DataManipulation.php");
	include("../api/Basic.php");
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();	

	// Recebe os dados do formulario
	$separador  = $_POST['separador'];
	if($separador == "") $separador = ";";
	
	// Busca os destinatarios do email
	$sql = "SELECT DISTINCT nome_artistico, email, tl_residencial, tl_celular, endereco, cd_qualificacao, dt_validade_contrato, dt_insercao, foto.dt_foto
			FROM tb_elenco 
			LEFT JOIN (
				SELECT DISTINCT cd_elenco, dt_foto
				FROM tb_foto
				WHERE dt_foto > '0000-00-00'
				ORDER BY dt_foto DESC
			) AS foto ON foto.cd_elenco = tb_elenco.id_elenco
			WHERE cd_status_elenco = 2
			AND publicado = 1 
			ORDER BY nome_artistico ASC, dt_foto DESC
			/*
			where email is not null 
			and email <> '' 
			and cd_status_elenco = 2
			and publicado = 1 
			order by nome_artistico
			*/";
			
	$rs = mysql_query($sql);
	$output = "";
	$title = true;
	while($row = mysql_fetch_array($rs,MYSQL_ASSOC)){
		$count = 0;
		if( $title ){
			foreach( $row as $key => $value ){
				$count++;
				$output .= $key;
				if( $count < count($row) ){
					$output .= $separador;
				}else{
					$output .= "\n";
				}
			}
			$title = false;
			$count = 0;
		}
		foreach( $row as $key => $value ){
			$count++;
			$output .= $value;
			if( $count < count($row) ){
				$output .= $separador;
			}else{
				$output .= "\n";
			}
		}
	}
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
	
	// Define o header do TXT
	header ("content-type: application/text");
	
	// Printa o output
	echo $output;
		
	// Direciona o usuario para a pagina de resposta
	//header("Location: /admin/mensagem/index.php");
?>
