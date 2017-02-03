<?php
// $db = mysql_connect("p3plcpnl0612.prod.phx3.secureserver.net","vinigoulart1","ThM]HETPv@");
//  if (!$db) {
//  die("Database connection failed miserably: " . mysql_error());
//  }
// $db_select = mysql_select_db("testecadastro",$db);
//  if (!$db_select) {
//  die("Database selection also failed miserably: " . mysql_error());
//  }
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Emissão de Nota Fiscal</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	body { font-family: 'Roboto', sans-serif; font-weight: 300; }
	#corpo {
		max-width: 70%;
		align: center;
		text-align: left;
		margin-top: 60px;
	}
	input[type='number'] {
	   width:120px;
	}
	input[type='text'] {
	   width:120px;
	}
</style>
</head>
<body>
	<center><div id='corpo'><p><h1>Dados da Nota:</h1></p></BR>
<?php
		$id = $_POST['id'];
		// $_SESSION['id'] = $_POST['id'];
		$_SESSION['cliente_job'] = $_SESSION['cliente_job'.$id];
		$_SESSION['campanha'] = $_SESSION['campanha'.$id];
		$_SESSION['produzido_por'] = $_SESSION['produzido_por'.$id];
		$_SESSION['emitiu_nota'] = $_SESSION['emitiu_nota'.$id];
		$_SESSION['n_nota_fiscal'] = $_SESSION['n_nota_fiscal'.$id];
		$_SESSION['data_nota'] = $_SESSION['data_nota'.$id];
		// $cliente_job = $_SESSION['cliente_job'.$id];
		// $campanha = $_SESSION['campanha'.$id];
		// $produzido_por = $_SESSION['produzido_por'.$id];
		// $emitiu_nota = $_SESSION['emitiu_nota'.$id];
		$n_nota_fiscal = $_SESSION['n_nota_fiscal'.$id];
		$data_nota = $_SESSION['data_nota'.$id];
echo "	<form action='action_altera_nota.php' method='post'>";
echo "	Nº da Nota:";
echo "	<p><input type='number' name='novo_n_nota_fiscal' "; 
		if ($n_nota_fiscal != NULL) {
		    echo "placeholder='$n_nota_fiscal'></p></BR>";
		} else {
			echo "></p></BR>";
		}	
echo "	Data de Emissão:";
echo "	<p><input type='text' name='nova_data_nota' "; 
		if ($data_nota != NULL) {
		    echo "placeholder='$data_nota'></p></BR>";
		} else {
			echo "></p></BR>";
		}	
echo "	<button type='submit'>Incluir</button></form>";
		// if (!empty($_POST['id'])) {
// 		$novo_n_nota_fiscal = $_POST['novo_n_nota_fiscal'];
// 		$nova_data_nota = $_POST['nova_data_nota'];

// 		$cliente_job = $_SESSION['cliente_job'];
// 		$campanha = $_SESSION['campanha'.$id];
// 		$produzido_por = $_SESSION['produzido_por'];
// 		$emitiu_nota = $_SESSION['emitiu_nota'];
// 		$n_nota_fiscal = $_SESSION['n_nota_fiscal'];
// 		$data_nota = $_SESSION['data_nota'];
// 		if ($n_nota_fiscal != NULL && $data_nota != NULL && $novo_n_nota_fiscal != NULL && $novo_n_nota_fiscal != NULL) {
// 				$sql = "UPDATE financeiro SET emitiu_nota = REPLACE(emitiu_nota,'$emitiu_nota','1'), n_nota_fiscal = REPLACE(n_nota_fiscal,'$n_nota_fiscal','$novo_n_nota_fiscal'), data_nota = REPLACE(data_nota,'$data_nota','$nova_data_nota'), WHERE tipo_entrada='cache' AND cliente_job='$cliente_job' AND produzido_por='$produzido_por' AND campanha='$campanha' AND emitiu_nota='$emitiu_nota'";
// 			echo $sql;
// 			// mysql_query($sql, $db);
// 		} elseif ($n_nota_fiscal == NULL && $data_nota == NULL && $novo_n_nota_fiscal != NULL && $novo_n_nota_fiscal != NULL) {
// 				$sql = "UPDATE financeiro SET emitiu_nota = REPLACE(emitiu_nota,'$emitiu_nota','1'), n_nota_fiscal = '$novo_n_nota_fiscal', data_nota = '$nova_data_nota', WHERE tipo_entrada='cache' AND cliente_job='$cliente_job' AND produzido_por='$produzido_por' AND campanha='$campanha' AND emitiu_nota='$emitiu_nota'";
// 			echo $sql;
// 			// mysql_query($sql, $db);
// 		} 	elseif ($n_nota_fiscal != NULL && $data_nota != NULL && $novo_n_nota_fiscal == NULL && $novo_n_nota_fiscal == NULL) {
// 				$sql = "UPDATE financeiro SET emitiu_nota = REPLACE(emitiu_nota,'$emitiu_nota','0'), n_nota_fiscal = NULL, data_nota = NULL, WHERE tipo_entrada='cache' AND cliente_job='$cliente_job' AND produzido_por='$produzido_por' AND campanha='$campanha' AND emitiu_nota='$emitiu_nota'";
// 			echo $sql;
// 			// mysql_query($sql, $db);
// 		}
// 		mysql_close($db);
// }
?>
</div></center>
</body>
</html>