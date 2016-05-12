<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	if (!empty($_POST['id'])) {
		$id = $_POST['id'];
		$nova_data_recebimento = $_POST['nova_data_recebimento'.$id];
		$data_job = $_SESSION['data_job'.$id];
		$cliente_job = $_SESSION['cliente_job'.$id];
		$campanha = $_SESSION['campanha'.$id];
		$produzido_por = $_SESSION['produzido_por'.$id];
		$data_recebimento = $_SESSION['data_recebimento'.$id];
		$status_recebimento = $_SESSION['status_recebimento'.$id];
		if ($status_recebimento == 1 && $data_recebimento != NULL && $nova_data_recebimento == NULL) {
			$sql = "UPDATE financeiro SET status_recebimento = REPLACE(status_recebimento,'$status_recebimento', '0'), data_recebimento = NULL WHERE data_job='$data_job' AND cliente_job='$cliente_job' AND campanha='$campanha' AND produzido_por='$produzido_por' AND status_recebimento='$status_recebimento'";
		} elseif ($status_recebimento == 1 && ($data_recebimento == NULL || $data_recebimento == '') && $nova_data_recebimento == NULL) {
			$sql = "UPDATE financeiro SET status_recebimento = REPLACE(status_recebimento,'$status_recebimento', '0'), data_recebimento = NULL WHERE data_job='$data_job' AND cliente_job='$cliente_job' AND campanha='$campanha' AND produzido_por='$produzido_por' AND status_recebimento='$status_recebimento'";
		} elseif ($status_recebimento == 1 && ($data_recebimento == NULL || $data_recebimento == '') && $nova_data_recebimento != NULL) {
			$sql = "UPDATE financeiro SET data_recebimento = '$nova_data_recebimento' WHERE data_job='$data_job' AND cliente_job='$cliente_job' AND campanha='$campanha' AND produzido_por='$produzido_por' AND status_recebimento='$status_recebimento'";
		} elseif ($status_recebimento == 1 && $data_recebimento != NULL && $nova_data_recebimento != NULL) {
			$sql = "UPDATE financeiro SET data_recebimento = REPLACE(data_recebimento,'$data_recebimento', '$nova_data_recebimento') WHERE data_job='$data_job' AND cliente_job='$cliente_job' AND campanha='$campanha' AND produzido_por='$produzido_por' AND status_recebimento='$status_recebimento'";
		} elseif ($status_recebimento == 0 && ($data_recebimento == NULL || $data_recebimento == '') && $nova_data_recebimento != NULL) {
			$sql = "UPDATE financeiro SET status_recebimento = REPLACE(status_recebimento,'$status_recebimento', '1'), data_recebimento = '$nova_data_recebimento' WHERE data_job='$data_job' AND cliente_job='$cliente_job' AND campanha='$campanha' AND produzido_por='$produzido_por' AND status_recebimento='$status_recebimento'";
		} elseif ($status_recebimento == 0 && $data_recebimento != NULL && $nova_data_recebimento != NULL) {
			$sql = "UPDATE financeiro SET status_recebimento = REPLACE(status_recebimento,'$status_recebimento', '1'), data_recebimento = REPLACE(data_recebimento,'$data_recebimento', '$nova_data_recebimento') WHERE data_job='$data_job' AND cliente_job='$cliente_job' AND campanha='$campanha' AND produzido_por='$produzido_por' AND status_recebimento='$status_recebimento'";
		} elseif ($status_recebimento == 0 && $data_recebimento != NULL && $nova_data_recebimento == NULL) {
			$sql = "UPDATE financeiro SET data_recebimento = NULL WHERE data_job='$data_job' AND cliente_job='$cliente_job' AND campanha='$campanha' AND produzido_por='$produzido_por' AND status_recebimento='$status_recebimento'";
		} elseif ($status_recebimento == 0 && ($data_recebimento == NULL || $data_recebimento == '') && $nova_data_recebimento == NULL) {
			echo "Nada foi alterado.";
		}
		mysqli_query($link, $sql);
}
		header("Location: jobs.php");
		mysqli_close($link);
?>
