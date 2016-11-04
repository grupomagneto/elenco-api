<?php
include("conecta.php");
	$data_job = $_POST['data_job'];
	$produzido_por = $_POST['produzido_por'];
	$cliente_job = $_POST['cliente_job'];
	$campanha = $_POST['campanha'];
	$nome = $_POST['nome'];
	$sobrenome = $_POST['sobrenome'];
	$cache_bruto = $_POST['cache_bruto'];
	$cache_liquido = $_POST['cache_liquido'];
	$tipo_job = $_POST['tipo_job'];
	$tipo_cache = $_POST['tipo_cache'];
	$emitiu_nota = $_POST['emitiu_nota'];
	$n_nota_fiscal = $_POST['n_nota_fiscal'];
	$data_nota = $_POST['data_nota'];
	$status_recebimento = $_POST['status_recebimento'];
	$data_recebimento = $_POST['data_recebimento'];
	$cache_bruto = number_format($cache_bruto,2,".","");
	$cache_liquido = number_format($cache_liquido,2,".","");
	if ($emitiu_nota == 0 && $status_recebimento == 0) {
		if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL) {
				$sql = "INSERT INTO financeiro (tipo_entrada, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, status_recebimento, status_pagamento) VALUES ('Cache', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$status_recebimento', 0)";
				mysqli_query($link, $sql);		
				header("Location: insert.html");
		} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL) {
				mysqli_close($link);
				echo "<script>alert('Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
		}
	} elseif ($emitiu_nota == 1 && $status_recebimento == 1) {
		if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $n_nota_fiscal != NULL && $data_nota != NULL && $data_recebimento != NULL) {
				$sql = "INSERT INTO financeiro (tipo_entrada, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, data_recebimento, status_pagamento) VALUES ('Cache', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', '$data_recebimento', 0)";
				mysqli_query($link, $sql);		
				header("Location: insert.html");
		} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $n_nota_fiscal == NULL || $data_nota == NULL || $data_recebimento == NULL) {
				mysqli_close($link);
				echo "<script>alert('Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
		}
	} elseif ($emitiu_nota == 1 && $status_recebimento == 0) {
		if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $n_nota_fiscal != NULL && $data_nota != NULL) {
				$sql = "INSERT INTO financeiro (tipo_entrada, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, status_pagamento) VALUES ('Cache', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', 0)";
				mysqli_query($link, $sql);		
				header("Location: insert.html");
		} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $n_nota_fiscal == NULL || $data_nota == NULL) {
				mysqli_close($link);
				echo "<script>alert('Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
		}
	} elseif ($emitiu_nota == 0 && $status_recebimento == 1) {
		if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $data_recebimento != NULL) {
				$sql = "INSERT INTO financeiro (tipo_entrada, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, status_recebimento, data_recebimento, status_pagamento) VALUES ('Cache', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$status_recebimento', '$data_recebimento', 0)";
				mysqli_query($link, $sql);		
				header("Location: insert.html");
		} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $data_recebimento == NULL) {
				mysqli_close($link);
				echo "<script>alert('Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
		}
	}
?>
