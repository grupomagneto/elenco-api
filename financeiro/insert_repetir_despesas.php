<?php header("Content-type: text/html; charset=ISO-8859-15");
session_start();
	$status_despesa 		= $_POST['status_despesa'];
	$data_venc_despesa 		= $_POST['data_venc_despesa'];
	$data_despesa 			= $_POST['data_despesa'];
	$valor_original_despesa = $_POST['valor_original_despesa'];
	$valor_despesa 			= $_POST['valor_despesa'];
	$tipo_despesa 			= $_POST['tipo_despesa'];
	$descricao_despesa 		= $_POST['descricao_despesa'];
	if ($status_despesa == 1) {
		echo "<script>alert('Não é possível inserir uma despesa paga repetidamente.');</script>";
	} elseif ($status_despesa == 0 && $data_venc_despesa == NULL || $status_despesa == 0 && $valor_original_despesa == NULL || $status_despesa == 0 && $tipo_despesa == NULL || $status_despesa == 0 && $descricao_despesa == NULL){
		echo "<script>alert('Despesa não inserida. Por favor complete todos os campos e tente novamente.');</script>";
	} else {
	$_SESSION['status_despesa'] 		= $_POST['status_despesa'];
	$_SESSION['data_venc_despesa'] 		= $_POST['data_venc_despesa'];
	$_SESSION['data_despesa'] 			= $_POST['data_despesa'];
	$_SESSION['valor_original_despesa'] = $_POST['valor_original_despesa'];
	$_SESSION['valor_despesa'] 			= $_POST['valor_despesa'];
	$_SESSION['tipo_despesa'] 			= $_POST['tipo_despesa'];
	$_SESSION['descricao_despesa'] 		= $_POST['descricao_despesa'];
echo "	
	<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
	<head>
	<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
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
		   width:50px;
		}
		</style>
	</head>
	<body>
	<center><div id='corpo'><p><h1>Repetição da Despesa:</h1></p></BR>
	<form action='action_repetir_despesa.php' method='post'>
Nº de vezes:
<p><input type='number' min='2' name='vezes' placeholder='0' required></p></BR>
Frequência:
<p><select name='frequencia' required>
		    <option value='Mensal'>Mensal</option>
		    <option value='Anual'>Anual</option>
	    </select></p></BR>
<button type='submit'>Incluir</button></form>
</div></center>
</body>
</html>";
}
?>
