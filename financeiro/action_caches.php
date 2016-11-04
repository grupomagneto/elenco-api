<?php
include("conecta.php");
	if (!empty($_POST['id'])) {
	    $id = $_POST['id'];
		$nova_data_pagamento = $_POST['nova_data_pagamento'.$id];
		$status_pagamento = $_SESSION['status_pagamento'.$id];
		$data_pagamento = $_SESSION['data_pagamento'.$id];
		if ($status_pagamento == 0 && $nova_data_pagamento != NULL && $data_pagamento == NULL) {
			$sql = "UPDATE financeiro SET status_pagamento = REPLACE(status_pagamento,'$status_pagamento', '1'), data_pagamento='$nova_data_pagamento' WHERE tipo_entrada='cache' AND id='$id'";
		} elseif ($status_pagamento == 0 && $nova_data_pagamento != NULL && $data_pagamento != NULL) {
			$sql = "UPDATE financeiro SET status_pagamento = REPLACE(status_pagamento,'$status_pagamento', '1'), data_pagamento = REPLACE(data_pagamento,'$data_pagamento', '$nova_data_pagamento') WHERE tipo_entrada='cache' AND id='$id'";
		} elseif ($status_pagamento == 1 && $nova_data_pagamento != NULL && $data_pagamento == NULL) {
			$sql = "UPDATE financeiro SET data_pagamento='$nova_data_pagamento' WHERE tipo_entrada='cache' AND id='$id'";
		} elseif ($status_pagamento == 1 && $nova_data_pagamento != NULL && $data_pagamento != NULL) {
			$sql = "UPDATE financeiro SET data_pagamento = REPLACE(data_pagamento,'$data_pagamento', '$nova_data_pagamento') WHERE tipo_entrada='cache' AND id='$id'";
		} elseif ($status_pagamento == 0 && $nova_data_pagamento == NULL && $data_pagamento != NULL) {
			$sql = "UPDATE financeiro SET data_pagamento = NULL WHERE tipo_entrada='cache' AND id='$id'";
		} elseif ($status_pagamento == 0 && $nova_data_pagamento == NULL && $data_pagamento == NULL) {
			echo "Nada foi alterado.";
		} elseif ($status_pagamento == 1 && $nova_data_pagamento == NULL && $data_pagamento != NULL) {
			$sql = "UPDATE financeiro SET status_pagamento = REPLACE(status_pagamento,'$status_pagamento', '0'), data_pagamento = NULL WHERE tipo_entrada='cache' AND id='$id'";
		} elseif ($status_pagamento == 1 && $nova_data_pagamento == NULL && $data_pagamento == NULL) {
			$sql = "UPDATE financeiro SET status_pagamento = REPLACE(status_pagamento,'$status_pagamento', '0') WHERE tipo_entrada='cache' AND id='$id'";
		} 
	// } elseif (!empty($_POST['excluir'])) {  
	//     $id = $_POST['excluir'];
	// 	$sql = "DELETE FROM financeiro WHERE id='$id'";
	// }
		mysqli_query($link, $sql);
}
		header("Location: caches.php");
		mysqli_close($link);
?>