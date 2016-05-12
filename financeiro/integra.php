<?php header("Content-type: text/html; charset=ISO-8859-15");
	$db = mysql_connect("p3plcpnl0612.prod.phx3.secureserver.net","vinigoulart1","ThM]HETPv@"); 
	if (!$db) {
	die("Database connection failed miserably: " . mysql_error());
	}
	$db_select = mysql_select_db("testecadastro",$db);
	if (!$db_select) {
	die("Database selection also failed miserably: " . mysql_error());
	}
	$sql1 = mysql_query("SELECT nome, sobrenome, id_elenco, id FROM financeiro WHERE tipo_entrada = 'cache' OR tipo_entrada = 'venda' AND nome IS NOT NULL", $db);
 	$sql2 = mysql_query("SELECT nome_artistico, id_elenco FROM tb_elenco WHERE nome_artistico IS NOT NULL", $db);
	echo "25";
	$a1 = array();
	while ($row = mysql_fetch_array($sql1)) {
		$id = $row['id'];
		$nome1.$id = $row['nome']." ".$row['sobrenome'];
		array_push($a1, $nome1.$id, $id);
	}
	$a2 = array();
	while ($row2 = mysql_fetch_array($sql2)) {
		$id2 = $row2['id_elenco'];
		$nome2.$id2 = $row2['nome_artistico'];
		array_push($a2, $nome2.$id2, $id2);
		// Trocou todos os nomes do sql2
		// echo "Nome2: ".$nome2.$id2;
	} 
			// echo "Nome1: ".$nome1.$id;
			// Trocou todos os nomes do sql1
	$result = array_intersect($a1,$a2);
		// $match = $result[0];
		// echo $result[0];
	// }
	print_r($result);
	// $sql3 = mysql_query("UPDATE financeiro SET id_elenco = $id2 WHERE id = $match");
		// Pegou apenas os últimos nomes

		

	// 	$a2 = array("nome"=>$nome2);
	// 	while ($sql1) {
			// $nome1 = $row['nome']." ".$row['sobrenome'];
// 			$a1 = array($nome1);		
			
		// }


		

		// echo $nome1.$id;
		// echo "Mudando";
		// echo $nome2.$id2;
		// echo $a1;
		// echo $nome1;
	// }
	
	// while ($row = mysql_fetch_array($sql1)) {
	// 	$nome = $row['nome'];
	// 	$sobrenome = $row['sobrenome'];
	// 	$id_elenco = $row['id_elenco'];
	// 	$nome1 = $nome." ".$sobrenome;
	// 	echo $nome1;
	// }
	// while ($row2 = mysql_fetch_array($sql2)) {
	// 	$nome2 = $row2['nome_artistico'];
	// 	echo $nome2;
	// }
	// if ($nome1.$id == $nome_artistico.$id2){
	// 	echo "rolou";
	//     echo "Financeiro: ".$nome1.$id;
	// 	echo "tb_elenco: ".$nome_artistico.$id2;
	// }	echo "não rolou";
	//     echo "Financeiro: ".$nome1.$id;
	// 	echo "tb_elenco: ".$nome_artistico.$id2;
	mysql_close($db);
?>