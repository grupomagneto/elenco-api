<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
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
		$novo_n_nota_fiscal = $_POST['novo_n_nota_fiscal'];
		$nova_data_nota = $_POST['nova_data_nota'];
		$cliente_job = $_SESSION['cliente_job'];
		$campanha = $_SESSION['campanha'];
		$produzido_por = $_SESSION['produzido_por'];
		$emitiu_nota = $_SESSION['emitiu_nota'];
		$n_nota_fiscal = $_SESSION['n_nota_fiscal'];
		$data_nota = $_SESSION['data_nota'];
		if ($n_nota_fiscal != NULL && $data_nota != NULL && $novo_n_nota_fiscal != NULL && $novo_n_nota_fiscal != NULL) {
				$sql = "UPDATE financeiro SET n_nota_fiscal = REPLACE(n_nota_fiscal,'$n_nota_fiscal','$novo_n_nota_fiscal'), data_nota = REPLACE(data_nota,'$data_nota','$nova_data_nota') WHERE tipo_entrada='cache' AND cliente_job='$cliente_job' AND produzido_por='$produzido_por' AND campanha='$campanha' AND emitiu_nota='$emitiu_nota'";
			mysqli_query($link, $sql);
			echo "Nota Fiscal alterada com sucesso.";
			echo "<button type='button' id='fechar'>Fechar esta janela</button>
					<script type='text/javascript'>
						document.getElementById('fechar').addEventListener('click', function() {
						window.close();
						});
					</script>";
		} elseif ($n_nota_fiscal == NULL && $data_nota == NULL && $novo_n_nota_fiscal != NULL && $novo_n_nota_fiscal != NULL) {
				$sql = "UPDATE financeiro SET emitiu_nota = REPLACE(emitiu_nota,'$emitiu_nota','1'), n_nota_fiscal = '$novo_n_nota_fiscal', data_nota = '$nova_data_nota' WHERE tipo_entrada='cache' AND cliente_job='$cliente_job' AND produzido_por='$produzido_por' AND campanha='$campanha' AND emitiu_nota='$emitiu_nota'";
			mysqli_query($link, $sql);
			echo "Nota Fiscal criada com sucesso.";
			echo "<button type='button' id='fechar'>Fechar esta janela</button>
					<script type='text/javascript'>
						document.getElementById('fechar').addEventListener('click', function() {
						window.close();
						});
					</script>";
		} 	elseif ($n_nota_fiscal != NULL && $data_nota != NULL && $novo_n_nota_fiscal == NULL && $novo_n_nota_fiscal == NULL) {
				$sql = "UPDATE financeiro SET emitiu_nota = REPLACE(emitiu_nota,'$emitiu_nota','0'), n_nota_fiscal = NULL, data_nota = NULL WHERE tipo_entrada='cache' AND cliente_job='$cliente_job' AND produzido_por='$produzido_por' AND campanha='$campanha' AND emitiu_nota='$emitiu_nota'";
			mysqli_query($link, $sql);
			echo "Nota Fiscal excluída com sucesso.";
			echo "<button type='button' id='fechar'>Fechar esta janela</button>
					<script type='text/javascript'>
						document.getElementById('fechar').addEventListener('click', function() {
						window.close();
						});
					</script>";
		}
		mysqli_close($link);
?>
</div></center>
</body>
</html>