<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	if (!empty($_POST['alterar'])) {
	    $id = $_POST['alterar'];
		$novo_valor_despesa = $_POST['novo_valor_despesa'.$id];
		$nova_data_despesa = $_POST['nova_data_despesa'.$id];
		$data_venc_despesa = $_SESSION['data_venc_despesa'.$id];
		$tipo_despesa = $_SESSION['tipo_despesa'.$id];
		$descricao_despesa = $_SESSION['descricao_despesa'.$id];
		$valor_original_despesa = $_SESSION['valor_original_despesa'.$id];
		$data_despesa = $_SESSION['data_despesa'.$id];
		$valor_despesa = $_SESSION['valor_despesa'.$id];
		$status_despesa = $_SESSION['status_despesa'.$id];
		$novo_valor_despesa_format = number_format($novo_valor_despesa,2,".","");
		if ($status_despesa == 0 && $novo_valor_despesa != NULL && $nova_data_despesa != NULL) {
			// Se o status da despesa for não recebida e o usuário preencher nova data e novo valor.
			$sql = "UPDATE financeiro SET status_despesa = REPLACE(status_despesa,'$status_despesa', '1'), valor_despesa='$novo_valor_despesa_format', data_despesa='$nova_data_despesa' WHERE data_venc_despesa='$data_venc_despesa' AND tipo_entrada='despesa' AND tipo_despesa='$tipo_despesa' AND descricao_despesa='$descricao_despesa' AND status_despesa='$status_despesa'";
		} elseif ($status_despesa == 0 && $novo_valor_despesa == NULL || $status_despesa == 0 && $nova_data_despesa == NULL) {
			// Se o status da despesa for não recebida e o usuário não preencher nova data ou novo valor.
			echo "Por favor preencha todas as informações.";
		} elseif ($status_despesa == 1 && $novo_valor_despesa == NULL && $nova_data_despesa == NULL) {
			// Se o status da despesa for recebida e o usuário não preencher nova data e novo valor.
			$sql = "UPDATE financeiro SET status_despesa = REPLACE(status_despesa,'$status_despesa', '0'), valor_despesa=NULL, data_despesa=NULL WHERE data_venc_despesa='$data_venc_despesa' AND tipo_entrada='despesa' AND tipo_despesa='$tipo_despesa' AND descricao_despesa='$descricao_despesa' AND status_despesa='$status_despesa'";
		} elseif ($status_despesa == 1 && $novo_valor_despesa != NULL && $nova_data_despesa != NULL) {
			// Se o status da despesa for recebida e o usuário preencher nova data e novo valor.
			$sql = "UPDATE financeiro SET valor_despesa='$novo_valor_despesa_format', data_despesa='$nova_data_despesa' WHERE data_venc_despesa='$data_venc_despesa' AND tipo_entrada='despesa' AND tipo_despesa='$tipo_despesa' AND descricao_despesa='$descricao_despesa' AND status_despesa='$status_despesa'";
		} elseif ($status_despesa == 1 && $novo_valor_despesa != NULL && $nova_data_despesa == NULL) {
			// Se o status da despesa for recebida e o usuário preencher novo valor mas não nova data.
			$sql = "UPDATE financeiro SET valor_despesa='$novo_valor_despesa_format' WHERE data_venc_despesa='$data_venc_despesa' AND tipo_entrada='despesa' AND tipo_despesa='$tipo_despesa' AND descricao_despesa='$descricao_despesa' AND status_despesa='$status_despesa'";
		} elseif ($status_despesa == 1 && $novo_valor_despesa == NULL && $nova_data_despesa != NULL) {
			// Se o status da despesa for recebida e o usuário não preencher novo valor mas preencher nova data.
			$sql = "UPDATE financeiro SET data_despesa='$nova_data_despesa' WHERE data_venc_despesa='$data_venc_despesa' AND tipo_entrada='despesa' AND tipo_despesa='$tipo_despesa' AND descricao_despesa='$descricao_despesa' AND status_despesa='$status_despesa'";
		}   
	} elseif (!empty($_POST['excluir'])) {  
	    $id = $_POST['excluir'];
		$sql = "DELETE FROM financeiro WHERE id='$id'";
	}
		mysqli_query($link, $sql);
		header("Location: despesas.php");
		mysqli_close($link);
?>
