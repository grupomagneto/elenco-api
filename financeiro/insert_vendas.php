<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	$nome = $_POST['nome'];
	$sobrenome = $_POST['sobrenome'];
	$produto = $_POST['produto'];
	$qtd = $_POST['qtd'];
	$data_venda = $_POST['data_venda'];
	$valor_venda = $_POST['valor_venda'];
	$forma_pagamento = $_POST['forma_pagamento'];
	$n_parcelas = $_POST['n_parcelas'];
	$novo_valor_venda = number_format($valor_venda,2,".","");
	if ($nome == NULL || $sobrenome == NULL || $produto == NULL || $qtd == NULL || $data_venda == NULL || $valor_venda == NULL || $forma_pagamento == NULL || $n_parcelas == NULL) {
		mysqli_close($link);
		echo "<script>alert('Venda não inserida. Por favor complete todos os campos e tente novamente.');</script>";
	} elseif ($nome != NULL && $sobrenome != NULL && $produto != NULL && $qtd != NULL && $data_venda != NULL && $valor_venda != NULL && $forma_pagamento != NULL && $n_parcelas != NULL){
		$sql = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, produto, qtd, valor_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$produto','$qtd','$novo_valor_venda','$data_venda','$forma_pagamento','$n_parcelas')";
		mysqli_query($link, $sql);
		header("Location: insert.html");
		mysqli_close($link);
	}
?>
