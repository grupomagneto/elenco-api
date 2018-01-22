<?php
include("conecta.php");
	$data_job = $_SESSION['data_job'];
	$produzido_por = $_SESSION['produzido_por'];
	$cliente_job = $_SESSION['cliente_job'];
	$campanha = $_SESSION['campanha'];
	$midia = $_SESSION['midia'];
	$praca = $_SESSION['praca'];
	$periodo = $_SESSION['periodo'];
	$periodo_tipo = $_SESSION['periodo_tipo'];
	$valor_total_job = $_SESSION['valor_total_job'];
	$n_participantes = $_SESSION['n_participantes'];
	$previsao_pagamento = $_SESSION['previsao_pagamento'];
	$emitiu_nota = $_SESSION['emitiu_nota'];
	$n_nota_fiscal = $_SESSION['n_nota_fiscal'];
	$data_nota = $_SESSION['data_nota'];
	$status_recebimento = $_SESSION['status_recebimento'];
	$data_recebimento = $_SESSION['data_recebimento'];
	$data_job = date("Y-m-d", strtotime($data_job));
	$data_nota = date("Y-m-d", strtotime($data_nota));
	$data_recebimento = date("Y-m-d", strtotime($data_recebimento));
	$subtotal = 0;
	if ($emitiu_nota == 0 && $status_recebimento == 0) {
			$part = 1;
			while ($part <= $n_participantes) {
				$nome = $_POST['typeahead'.$part];
				// $sobrenome = $_POST['sobrenome'.$part];
				$cache_bruto = $_POST['cache_bruto'.$part];
				$subtotal = $subtotal + $cache_bruto;
				$cache_liquido = $_POST['cache_liquido'.$part];
				$tipo_job = $_POST['tipo_job'.$part];
				$tipo_cache = $_POST['tipo_cache'.$part];
				$cache_bruto = number_format($cache_bruto,2,".","");
				$cache_liquido = number_format($cache_liquido,2,".","");
				if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL) {
					$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, status_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$status_recebimento', 0)";
					// echo $sql;
					mysqli_query($link, $sql);
				} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL) {
					echo "<script>alert('1-Cachê não inserido. Por favor complete todos os campos e tente novamente. data_job:$data_job, produzido_por:$produzido_por, cliente_job:$cliente_job, campanha:$campanha, nome:$nome, sobrenome:$sobrenome, cache_bruto:$cache_bruto, cache_liquido:$cache_liquido, tipo_job:$tipo_job, tipo_cache:$tipo_cache');</script>";
				}
				$part++;
			}
			if ($valor_total_job > $subtotal){
				$comissao = $valor_total_job - $subtotal;
				$sql = "INSERT INTO financeiro (tipo_entrada, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, cache_bruto, tipo_cache, emitiu_nota, status_recebimento) VALUES ('Cache', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$comissao', 'Extra', '$emitiu_nota', '$status_recebimento')";
				mysqli_query($link, $sql);
			}
		$caches = $part - 1;
		echo "$caches cachês inseridos com sucesso.";
	} elseif ($emitiu_nota == 1 && $status_recebimento == 1) {
			$part = 1;
			while ($part <= $n_participantes) {
				$nome = $_POST['nome'.$part];
				$sobrenome = $_POST['sobrenome'.$part];
				$cache_bruto = $_POST['cache_bruto'.$part];
				$subtotal = $subtotal + $cache_bruto;
				$cache_liquido = $_POST['cache_liquido'.$part];
				$tipo_job = $_POST['tipo_job'.$part];
				$tipo_cache = $_POST['tipo_cache'.$part];
				$cache_bruto = number_format($cache_bruto,2,".","");
				$cache_liquido = number_format($cache_liquido,2,".","");
				if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $n_nota_fiscal != NULL && $data_nota != NULL && $data_recebimento != NULL) {
					$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, data_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', '$data_recebimento', 0)";
					// echo $sql;
					mysqli_query($link, $sql);
				} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $n_nota_fiscal == NULL || $data_nota == NULL || $data_recebimento == NULL) {
					echo "<script>alert('2-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
				}
			$part++;
			}
			if ($valor_total_job > $subtotal){
				$comissao = $valor_total_job - $subtotal;
				$sql = "INSERT INTO financeiro (tipo_entrada, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, cache_bruto, tipo_cache, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, data_recebimento) VALUES ('Cache', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$comissao', 'Extra', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', '$data_recebimento')";
				mysqli_query($link, $sql);
			}
		$caches = $part - 1;
		echo "$caches cachês inseridos com sucesso.";
	} elseif ($emitiu_nota == 1 && $status_recebimento == 0) {
				$part = 1;
				while ($part <= $n_participantes) {
					$nome = $_POST['nome'.$part];
					$sobrenome = $_POST['sobrenome'.$part];
					$cache_bruto = $_POST['cache_bruto'.$part];
					$subtotal = $subtotal + $cache_bruto;
					$cache_liquido = $_POST['cache_liquido'.$part];
					$tipo_job = $_POST['tipo_job'.$part];
					$tipo_cache = $_POST['tipo_cache'.$part];
					$cache_bruto = number_format($cache_bruto,2,".","");
					$cache_liquido = number_format($cache_liquido,2,".","");
					if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $n_nota_fiscal != NULL && $data_nota != NULL) {
						$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', 0)";
					// echo $sql;
					mysqli_query($link, $sql);
				} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $n_nota_fiscal == NULL || $data_nota == NULL) {
					echo "<script>alert('3-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
					}
				$part++;
				}
				if ($valor_total_job > $subtotal){
					$comissao = $valor_total_job - $subtotal;
					$sql = "INSERT INTO financeiro (tipo_entrada, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, cache_bruto, tipo_cache, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento) VALUES ('Cache', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$comissao', 'Extra', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento')";
					mysqli_query($link, $sql);
				}
		$caches = $part - 1;
		echo "$caches cachês inseridos com sucesso.";
	} elseif ($emitiu_nota == 0 && $status_recebimento == 1) {
				$part = 1;
				while ($part <= $n_participantes) {
					$nome = $_POST['nome'.$part];
					$sobrenome = $_POST['sobrenome'.$part];
					$cache_bruto = $_POST['cache_bruto'.$part];
					$subtotal = $subtotal + $cache_bruto;
					$cache_liquido = $_POST['cache_liquido'.$part];
					$tipo_job = $_POST['tipo_job'.$part];
					$tipo_cache = $_POST['tipo_cache'.$part];
					$cache_bruto = number_format($cache_bruto,2,".","");
					$cache_liquido = number_format($cache_liquido,2,".","");
					if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $data_recebimento != NULL) {
						$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, status_recebimento, data_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$status_recebimento', '$data_recebimento', 0)";
					// echo $sql;
					mysqli_query($link, $sql);
				} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $data_recebimento == NULL) {
					echo "<script>alert('4-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
					}
				$part++;
				}
				if ($valor_total_job > $subtotal){
					$comissao = $valor_total_job - $subtotal;
					$sql = "INSERT INTO financeiro (tipo_entrada, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, cache_bruto, tipo_cache, emitiu_nota, status_recebimento, data_recebimento) VALUES ('Cache', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$comissao', 'Extra', '$emitiu_nota', '$status_recebimento', '$data_recebimento')";
					mysqli_query($link, $sql);
				}
		$caches = $part - 1;
		echo "$caches cachês inseridos com sucesso.";
	}
	mysqli_close($link);
?>
	