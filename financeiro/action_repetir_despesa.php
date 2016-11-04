<?php
include("conecta.php");
	$status_despesa = $_SESSION['status_despesa'];
	$data_venc_despesa = $_SESSION['data_venc_despesa'];
	$data_despesa = $_SESSION['data_despesa'];
	$valor_original_despesa = $_SESSION['valor_original_despesa'];
	$valor_despesa = $_SESSION['valor_despesa'];
	$tipo_despesa = $_SESSION['tipo_despesa'];
	$descricao_despesa = $_SESSION['descricao_despesa'];
	$vezes = $_POST['vezes'];
	$frequencia = $_POST['frequencia'];
	if ($frequencia == 'Mensal') {
		while ($vezes > 0) {
			$novo_valor_original_despesa = number_format($valor_original_despesa,2,".","");
			if ($status_despesa == 0 && $data_venc_despesa != NULL && $valor_original_despesa != NULL && $tipo_despesa != NULL && $descricao_despesa != NULL) {
				$sql = "INSERT INTO financeiro (tipo_entrada, status_despesa, data_venc_despesa, valor_original_despesa, tipo_despesa, descricao_despesa) VALUES ('Despesa', '$status_despesa','$data_venc_despesa','$novo_valor_original_despesa','$tipo_despesa','$descricao_despesa')";
				// echo $sql;
				mysqli_query($link, $sql);
			}
			$vezes--;
			$data_venc_despesa = date('Y-m-d', strtotime("+1 month", strtotime($data_venc_despesa)));
		}
	echo "<script>alert('Despesa inserida com sucesso!');</script>";
	} elseif ($frequencia == 'Anual') {
		while ($vezes > 0) {
			$novo_valor_original_despesa = number_format($valor_original_despesa,2,".","");
			if ($status_despesa == 0 && $data_venc_despesa != NULL && $valor_original_despesa != NULL && $tipo_despesa != NULL && $descricao_despesa != NULL) {
				$sql = "INSERT INTO financeiro (tipo_entrada, status_despesa, data_venc_despesa, valor_original_despesa, tipo_despesa, descricao_despesa) VALUES ('Despesa', '$status_despesa','$data_venc_despesa','$novo_valor_original_despesa','$tipo_despesa','$descricao_despesa')";
				// echo $sql;
				mysqli_query($link, $sql);
			}
			$vezes--;
			$data_venc_despesa = date('Y-m-d', strtotime("+1 year", strtotime($data_venc_despesa)));
		}
	echo "<script>alert('Despesa inserida com sucesso!');</script>";
	}
	mysqli_close($link);
?>
