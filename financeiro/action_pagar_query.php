<?php
include('conecta.php');
	$id_cache_01 = $_GET['id'];
	if (!empty($_GET['utilizar'])) {
		$utilizar = $_GET['utilizar'];
	}
	if (!empty($_GET['sacar'])) {
		$sacar = $_GET['sacar'];
	}
if (!$sacar && !$utilizar) {
	echo "Escolha uma das opção: Utilizar ou Sacar.";
} else {
	$data = $_GET['data_pagamento'];
	$sql = "SELECT id_elenco_financeiro, nome, sobrenome, cache_liquido, abatimento_cache, valor_cheque FROM financeiro WHERE id = '$id_cache_01'";
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($result);
		$id_elenco = $row['id_elenco_financeiro'];
		$cache_liquido = $row['cache_liquido'];
		$abatimento_cache_existente = $row['abatimento_cache'];
		$valor_cheque_existente = $row['valor_cheque'];
		$nome = $row['nome'];
		$sobrenome = $row['sobrenome'];
		if (!empty($_GET['saldo_utilizado'])) {
		$saldo_utilizado = $_GET['saldo_utilizado'];
		}
		elseif (empty($_GET['saldo_utilizado'])) {
		$saldo_utilizado = 0;
		}
		if (!empty($_GET['saldo_sacado'])) {
		$saldo_sacado = $_GET['saldo_sacado'];
		}
		elseif (empty($_GET['saldo_sacado'])) {
		$saldo_sacado = 0;
		}
		// Eu acho que posso definir isso separado, mesmo não usando... para fazer apenas uma vez
		$sql_n_caches = "SELECT COUNT(id) AS n_caches FROM financeiro WHERE tipo_entrada = 'Cache' AND status_pagamento = 0 AND id_elenco_financeiro = '$id_elenco' AND id <> '$id_cache_01' ORDER BY cache_liquido DESC";
			$result3 = mysqli_query($link, $sql_n_caches);
			$row3 = mysqli_fetch_array($result3);
			$n_total_caches = $row3['n_caches'];
		$sql_outros_caches = "SELECT id, cache_liquido, abatimento_cache, valor_cheque FROM financeiro WHERE tipo_entrada = 'Cache' AND status_pagamento = 0 AND id_elenco_financeiro = '$id_elenco' AND id <> '$id_cache_01' ORDER BY cache_liquido DESC";
			$result2 = mysqli_query($link, $sql_outros_caches);
			$n = 1;
			while ($row2 = mysqli_fetch_array($result2)) {
				${'id_novo_cache_'.$n} = $row2['id'];
				${'cache_liquido_'.$n} = $row2['cache_liquido'];
				${'abatimento_cache_'.$n} = $row2['abatimento_cache'];
				${'valor_cheque_'.$n} = $row2['valor_cheque'];
				$n++;
			}

	$sql2 = "SELECT SUM(cache_liquido) AS saldo_a_receber, SUM(abatimento_cache) AS abatimento, SUM(valor_cheque) AS cheque FROM financeiro WHERE status_pagamento = 0 AND id_elenco_financeiro = '$id_elenco'";
		$result2 = mysqli_query($link, $sql2);
		$row2 = mysqli_fetch_array($result2);
		if ($row2['abatimento'] == NULL || $row2['abatimento'] == '' || $row2['abatimento'] == '0') {
			$abatimento_total = 0;
		} elseif ($row2['abatimento'] != NULL && $row2['abatimento'] != '' || $row2['abatimento'] != '0') {
			$abatimento_total = $row2['abatimento'];
		}
		if ($row2['cheque'] == NULL || $row2['cheque'] == '') {
			$cheque_total = 0;
		} elseif ($row2['cheque'] != NULL && $row2['cheque'] != '') {
			$cheque_total = $row2['cheque'];
		}
			$saldo_a_receber = $row2['saldo_a_receber'] - $abatimento_total - $cheque_total;
			$saldo_a_receber_format = number_format($saldo_a_receber,2,",",".");

	if ($cache_liquido < $saldo_utilizado + $saldo_sacado + $abatimento_cache_existente + $valor_cheque_existente) {
		if ($saldo_a_receber < $saldo_utilizado + $saldo_sacado + $abatimento_cache_existente + $valor_cheque_existente) {
			echo "Saldo insuficiente.";
		}
		// Vai utilizar outros cachês
		elseif ($saldo_a_receber >= $saldo_utilizado + $saldo_sacado + $abatimento_cache_existente + $valor_cheque_existente) {
			if ($utilizar == 'true'){
				$operacao = $_GET['operacao'];
				if (!$operacao) {
					echo "Por favor, selecione uma forma de utilização do crédito.";
				} else {
					if ($operacao == '30') {
						$produto = "3x4";
					} elseif ($operacao == '249') {
						$produto = "Cadastro Premium";
						$tipo_cadastro_vigente = "Premium";
						$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data' WHERE id_elenco = '$id_elenco'";
						mysqli_query($link, $sql_tb_elenco);
						mysqli_query($link2, $sql_tb_elenco);
					} elseif ($operacao == '299') {
						$produto = "Cadastro Premium";
						$tipo_cadastro_vigente = "Premium";
						$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data' WHERE id_elenco = '$id_elenco'";
						mysqli_query($link, $sql_tb_elenco);
						mysqli_query($link2, $sql_tb_elenco);
					} elseif ($operacao == '899') {
						$produto = "Cadastro Profissional";
						$tipo_cadastro_vigente = "Profissional";
						$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data' WHERE id_elenco = '$id_elenco'";
						mysqli_query($link, $sql_tb_elenco);
						mysqli_query($link2, $sql_tb_elenco);
					} elseif ($operacao == '999') {
						$produto = "Cadastro Profissional";
						$tipo_cadastro_vigente = "Profissional";
						$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data' WHERE id_elenco = '$id_elenco'";
						mysqli_query($link, $sql_tb_elenco);
						mysqli_query($link2, $sql_tb_elenco);
					}
					// Usar cache original e quitar
					$sql_utilizar = "UPDATE financeiro SET abatimento_cache = '$cache_liquido', data_abatimento = '$data', produto_abatimento = '$produto', status_pagamento = '1' WHERE id = '$id_cache_01'";
					mysqli_query($link, $sql_utilizar);
					// Diminuir a diferenca
					$restante = $saldo_utilizado - $cache_liquido;
					$n = 1;
					while ($restante > 0) {
						if ($restante > ${'cache_liquido_'.$n}) {
							${'sql_utilizar_novo_'.$n} = "UPDATE financeiro SET abatimento_cache = '${'cache_liquido_'.$n}', data_abatimento = '$data', produto_abatimento = '$produto', status_pagamento = '1' WHERE id = '${'id_novo_cache_'.$n}'";
							mysqli_query($link, ${'sql_utilizar_novo_'.$n});
							$restante = $restante - ${'cache_liquido_'.$n};					
						} elseif ($restante == ${'cache_liquido_'.$n}) {
							${'sql_utilizar_novo_'.$n} = "UPDATE financeiro SET abatimento_cache = '${'cache_liquido_'.$n}', data_abatimento = '$data', produto_abatimento = '$produto', status_pagamento = '1' WHERE id = '${'id_novo_cache_'.$n}'";
							mysqli_query($link, ${'sql_utilizar_novo_'.$n});
							$restante = 0;
						} elseif ($restante < ${'cache_liquido_'.$n}) {
							${'sql_utilizar_novo_'.$n} = "UPDATE financeiro SET abatimento_cache = '$restante', data_abatimento = '$data', produto_abatimento = '$produto' WHERE id = '${'id_novo_cache_'.$n}'";
							mysqli_query($link, ${'sql_utilizar_novo_'.$n});
							$restante = 0;
						}
						$n++;
					}
					// Inserir Venda
					$sql_venda = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, produto, status_venda, qtd, valor_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$id_elenco','$produto','Pago','1','$saldo_utilizado','$data','Abatimento de Cachê','1')";
					mysqli_query($link, $sql_venda);
				}
			}
			if ($sacar == 'true'){
				$n_cheque = $_GET['n_cheque'];
				$conta = $_GET['conta'];
				if (!$conta) {
					echo "Por favor, selecione uma Conta Bancária para o Cheque.";
				}
				$sql_sacar = "UPDATE financeiro SET valor_cheque = '$saldo_sacado', data_pagamento = '$data', n_cheque = '$n_cheque', conta_cheque = '$conta' WHERE id = '$id_cache_01'";
				mysqli_query($link, $sql_sacar);
			}
			if ($cache_liquido == ($saldo_utilizado + $saldo_sacado + $abatimento_cache_existente + $valor_cheque_existente)) {
				$sql_quitar_01 = "UPDATE financeiro SET status_pagamento = '1' WHERE id = '$id_cache_01'";
				mysqli_query($link, $sql_quitar_01);
			}
		}
	// Utiliza apenas o cachê selecionado
	} elseif ($cache_liquido >= $saldo_utilizado + $saldo_sacado + $abatimento_cache_existente + $valor_cheque_existente) {
		if (isset($utilizar) && $utilizar == 'true'){
			$operacao = $_GET['operacao'];
			if (!$operacao) {
				echo "Por favor, selecione uma forma de utilização do crédito.";
			} else {
			if ($operacao == '30') {
				$produto = "3x4";
				$sql_utilizar = "UPDATE financeiro SET abatimento_cache = '$saldo_utilizado', data_abatimento = '$data', produto_abatimento = '$produto' WHERE id = '$id_cache_01'";
				mysqli_query($link, $sql_utilizar);
				$sql_venda = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, produto, status_venda, qtd, valor_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$id_elenco','$produto','Pago','1','$saldo_utilizado','$data','Abatimento de Cachê','1')";
				mysqli_query($link, $sql_venda);
			} elseif ($operacao == '249') {
				$produto = "Cadastro Premium";
				$sql_utilizar = "UPDATE financeiro SET abatimento_cache = '$saldo_utilizado', data_abatimento = '$data', produto_abatimento = '$produto' WHERE id = '$id_cache_01'";
				mysqli_query($link, $sql_utilizar);
				$tipo_cadastro_vigente = "Premium";
				$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data' WHERE id_elenco = '$id_elenco'";
				mysqli_query($link, $sql_tb_elenco);
				mysqli_query($link2, $sql_tb_elenco);
				$sql_venda = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, produto, status_venda, qtd, valor_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$id_elenco','$produto','Pago','1','$saldo_utilizado','$data','Abatimento de Cachê','1')";
				mysqli_query($link, $sql_venda);
			} elseif ($operacao == '299') {
				$produto = "Cadastro Premium";
				$sql_utilizar = "UPDATE financeiro SET abatimento_cache = '$saldo_utilizado', data_abatimento = '$data', produto_abatimento = '$produto' WHERE id = '$id_cache_01'";
				mysqli_query($link, $sql_utilizar);
				$tipo_cadastro_vigente = "Premium";
				$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data' WHERE id_elenco = '$id_elenco'";
				mysqli_query($link, $sql_tb_elenco);
				mysqli_query($link2, $sql_tb_elenco);
				$sql_venda = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, produto, status_venda, qtd, valor_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$id_elenco','$produto','Pago','1','$saldo_utilizado','$data','Abatimento de Cachê','1')";
				mysqli_query($link, $sql_venda);
			} elseif ($operacao == '899') {
				$produto = "Cadastro Profissional";
				$sql_utilizar = "UPDATE financeiro SET abatimento_cache = '$saldo_utilizado', data_abatimento = '$data', produto_abatimento = '$produto' WHERE id = '$id_cache_01'";
				mysqli_query($link, $sql_utilizar);
				$tipo_cadastro_vigente = "Profissional";
				$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data' WHERE id_elenco = '$id_elenco'";
				mysqli_query($link, $sql_tb_elenco);
				mysqli_query($link2, $sql_tb_elenco);
				$sql_venda = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, produto, status_venda, qtd, valor_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$id_elenco','$produto','Pago','1','$saldo_utilizado','$data','Abatimento de Cachê','1')";
				mysqli_query($link, $sql_venda);
			} elseif ($operacao == '999') {
				$produto = "Cadastro Profissional";
				$sql_utilizar = "UPDATE financeiro SET abatimento_cache = '$saldo_utilizado', data_abatimento = '$data', produto_abatimento = '$produto' WHERE id = '$id_cache_01'";
				mysqli_query($link, $sql_utilizar);
				$tipo_cadastro_vigente = "Profissional";
				$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data' WHERE id_elenco = '$id_elenco'";
				mysqli_query($link, $sql_tb_elenco);
				mysqli_query($link2, $sql_tb_elenco);
				$sql_venda = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, produto, status_venda, qtd, valor_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$id_elenco','$produto','Pago','1','$saldo_utilizado','$data','Abatimento de Cachê','1')";
				mysqli_query($link, $sql_venda);
			}
			}
		}
		if ($sacar == 'true'){
			$n_cheque = $_GET['n_cheque'];
			$conta = $_GET['conta'];
			if (!$conta) {
				echo "Por favor, selecione uma Conta Bancária para o Cheque.";
			}
			$sql_sacar = "UPDATE financeiro SET valor_cheque = '$saldo_sacado', data_pagamento = '$data', n_cheque = '$n_cheque', conta_cheque = '$conta' WHERE id = '$id_cache_01'";
			mysqli_query($link, $sql_sacar);
		}
		if ($cache_liquido == ($saldo_utilizado + $saldo_sacado + $abatimento_cache_existente + $valor_cheque_existente)) {
			$sql_quitar_01 = "UPDATE financeiro SET status_pagamento = '1' WHERE id = '$id_cache_01'";
			mysqli_query($link, $sql_quitar_01);
		}
	} 
}
mysqli_close($link);
mysqli_close($link2);
header("Location: action_print.php?id=$id_cache_01");
?>