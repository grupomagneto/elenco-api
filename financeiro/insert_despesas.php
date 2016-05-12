<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	$status_despesa = $_POST['status_despesa'];
	$data_venc_despesa = $_POST['data_venc_despesa'];
	$data_despesa = $_POST['data_despesa'];
	$valor_original_despesa = $_POST['valor_original_despesa'];
	$valor_despesa = $_POST['valor_despesa'];
	$tipo_despesa = $_POST['tipo_despesa'];
	$descricao_despesa = $_POST['descricao_despesa'];
	$novo_valor_original_despesa = number_format($valor_original_despesa,2,".","");
	if ($status_despesa == 1 && $data_venc_despesa == NULL || $status_despesa == 1 && $data_despesa == NULL || $status_despesa == 1 && $valor_original_despesa == NULL || $status_despesa == 1 && $valor_despesa == NULL || $status_despesa == 1 && $tipo_despesa == NULL || $status_despesa == 1 && $descricao_despesa == NULL) {
		echo "<script>alert('Despesa não inserida. Por favor complete todos os campos e tente novamente.');</script>";
	} elseif ($status_despesa == 0 && $data_venc_despesa == NULL || $status_despesa == 0 && $valor_original_despesa == NULL || $status_despesa == 0 && $tipo_despesa == NULL || $status_despesa == 0 && $descricao_despesa == NULL){
		echo "<script>alert('Despesa não inserida. Por favor complete todos os campos e tente novamente.');</script>";
	} elseif ($status_despesa == 1 && $data_venc_despesa != NULL && $data_despesa != NULL && $valor_original_despesa != NULL && $valor_despesa != NULL && $tipo_despesa != NULL && $descricao_despesa != NULL) {
		$novo_valor_despesa = number_format($valor_despesa,2,".","");
		$sql = "INSERT INTO financeiro (tipo_entrada, status_despesa, data_venc_despesa, data_despesa, valor_original_despesa, valor_despesa, tipo_despesa, descricao_despesa) VALUES ('Despesa', '$status_despesa','$data_venc_despesa','$data_despesa','$novo_valor_original_despesa','$novo_valor_despesa','$tipo_despesa','$descricao_despesa')";
		mysqli_query($link, $sql);
		echo "<script>alert('Despesa inserida com sucesso!');</script>";
		// header("Location: insert.html");
	} elseif ($status_despesa == 0 && $data_venc_despesa != NULL && $valor_original_despesa != NULL && $tipo_despesa != NULL && $descricao_despesa != NULL) {
		$sql = "INSERT INTO financeiro (tipo_entrada, status_despesa, data_venc_despesa, valor_original_despesa, tipo_despesa, descricao_despesa) VALUES ('Despesa', '$status_despesa','$data_venc_despesa','$novo_valor_original_despesa','$tipo_despesa','$descricao_despesa')";
		mysqli_query($link, $sql);
		echo "<script>alert('Despesa inserida com sucesso!');</script>";
		// header("Location: insert.html");
	}
	mysqli_close($link);
?>
