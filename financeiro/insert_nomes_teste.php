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
		if ($n_participantes > 1) {
			$part = 1;
			while ($part <= $n_participantes) {
				$nome_artistico = $_POST['typeahead'.$part];
				$pieces = explode(" ", $nome_artistico);
				$nome = $pieces[0];
				if (isset($pieces[2])) {
					$sobrenome = $pieces[1]." ".$pieces[2];
				} else {
					$sobrenome = $pieces[1];
				}
				$sql_ID = "SELECT id_elenco FROM tb_elenco WHERE nome_artistico LIKE '$nome_artistico'";
				// echo $sql_ID;
				$query = mysqli_query($link, $sql_ID);
				$row = mysqli_fetch_assoc($query);
				$id_elenco = $row['id_elenco'];
				$cache_bruto = $_POST['cache_bruto'.$part];
				$subtotal = $subtotal + $cache_bruto;
				$cache_liquido = $_POST['cache_liquido'.$part];
				$tipo_job = $_POST['tipo_job'.$part];
				$tipo_cache = $_POST['tipo_cache'.$part];
				$cache_bruto = number_format($cache_bruto,2,".","");
				$cache_liquido = number_format($cache_liquido,2,".","");
				if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL) {
					$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, id_elenco_financeiro, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, status_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$id_elenco', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$status_recebimento', 0)";
					// echo $sql;
					mysqli_query($link, $sql);
				} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL) {
					echo "<script>alert('1-Cachê não inserido. Por favor complete todos os campos e tente novamente. data_job:$data_job, produzido_por:$produzido_por, cliente_job:$cliente_job, campanha:$campanha, nome:$nome, sobrenome:$sobrenome, cache_bruto:$cache_bruto, cache_liquido:$cache_liquido, tipo_job:$tipo_job, tipo_cache:$tipo_cache');</script>";
				}
				$part++;
				$caches = $part - 1;
			}
		}
		if ($n_participantes == 1) {
	    	$part = "";
	    	$caches = 1;
			$nome_artistico = $_POST['typeahead'];
			$pieces = explode(" ", $nome_artistico);
			$nome = $pieces[0];
			if (isset($pieces[2])) {
				$sobrenome = $pieces[1]." ".$pieces[2];
			} else {
				$sobrenome = $pieces[1];
			}
			$sql_ID = "SELECT id_elenco FROM tb_elenco WHERE nome_artistico LIKE '$nome_artistico'";
			// echo $sql_ID;
			$query = mysqli_query($link, $sql_ID);
			$row = mysqli_fetch_assoc($query);
			$id_elenco = $row['id_elenco'];
			$cache_bruto = $_POST['cache_bruto'];
			$subtotal = $subtotal + $cache_bruto;
			$cache_liquido = $_POST['cache_liquido'];
			$tipo_job = $_POST['tipo_job'];
			$tipo_cache = $_POST['tipo_cache'];
			$cache_bruto = number_format($cache_bruto,2,".","");
			$cache_liquido = number_format($cache_liquido,2,".","");
			if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL) {
				$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, id_elenco_financeiro, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, status_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$id_elenco', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$status_recebimento', 0)";
				// echo $sql;
				mysqli_query($link, $sql);
			} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL) {
				echo "<script>alert('1-Cachê não inserido. Por favor complete todos os campos e tente novamente. data_job:$data_job, produzido_por:$produzido_por, cliente_job:$cliente_job, campanha:$campanha, nome:$nome, sobrenome:$sobrenome, cache_bruto:$cache_bruto, cache_liquido:$cache_liquido, tipo_job:$tipo_job, tipo_cache:$tipo_cache');</script>";
			}
	    }
			if ($valor_total_job > $subtotal){
				$comissao = $valor_total_job - $subtotal;
				$sql = "INSERT INTO financeiro (tipo_entrada, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, cache_bruto, tipo_cache, emitiu_nota, status_recebimento) VALUES ('Cache', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$comissao', 'Extra', '$emitiu_nota', '$status_recebimento')";
				mysqli_query($link, $sql);
			}
		echo "$caches cachê(s) inserido(s) com sucesso.";
	} elseif ($emitiu_nota == 1 && $status_recebimento == 1) {
		if ($n_participantes > 1) {
			$part = 1;
			while ($part <= $n_participantes) {
				$nome_artistico = $_POST['typeahead'.$part];
				$pieces = explode(" ", $nome_artistico);
				$nome = $pieces[0];
				if (isset($pieces[2])) {
					$sobrenome = $pieces[1]." ".$pieces[2];
				} else {
					$sobrenome = $pieces[1];
				}
				$sql_ID = "SELECT id_elenco FROM tb_elenco WHERE nome_artistico LIKE '$nome_artistico'";
				// echo $sql_ID;
				$query = mysqli_query($link, $sql_ID);
				$row = mysqli_fetch_assoc($query);
				$id_elenco = $row['id_elenco'];
				$cache_bruto = $_POST['cache_bruto'.$part];
				$subtotal = $subtotal + $cache_bruto;
				$cache_liquido = $_POST['cache_liquido'.$part];
				$tipo_job = $_POST['tipo_job'.$part];
				$tipo_cache = $_POST['tipo_cache'.$part];
				$cache_bruto = number_format($cache_bruto,2,".","");
				$cache_liquido = number_format($cache_liquido,2,".","");
				if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $n_nota_fiscal != NULL && $data_nota != NULL && $data_recebimento != NULL) {
					$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, id_elenco_financeiro, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, data_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$id_elenco', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', '$data_recebimento', 0)";
					// echo $sql;
					mysqli_query($link, $sql);
				} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $n_nota_fiscal == NULL || $data_nota == NULL || $data_recebimento == NULL) {
					echo "<script>alert('2-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
				}
			$part++;
			$caches = $part - 1;
			}
		}
		if ($n_participantes == 1) {
	    	$part = "";
	    	$caches = 1;
			$nome_artistico = $_POST['typeahead'];
			$pieces = explode(" ", $nome_artistico);
			$nome = $pieces[0];
			if (isset($pieces[2])) {
				$sobrenome = $pieces[1]." ".$pieces[2];
			} else {
				$sobrenome = $pieces[1];
			}
			$sql_ID = "SELECT id_elenco FROM tb_elenco WHERE nome_artistico LIKE '$nome_artistico'";
			// echo $sql_ID;
			$query = mysqli_query($link, $sql_ID);
			$row = mysqli_fetch_assoc($query);
			$id_elenco = $row['id_elenco'];
			$cache_bruto = $_POST['cache_bruto'.$part];
			$subtotal = $subtotal + $cache_bruto;
			$cache_liquido = $_POST['cache_liquido'.$part];
			$tipo_job = $_POST['tipo_job'.$part];
			$tipo_cache = $_POST['tipo_cache'.$part];
			$cache_bruto = number_format($cache_bruto,2,".","");
			$cache_liquido = number_format($cache_liquido,2,".","");
			if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $n_nota_fiscal != NULL && $data_nota != NULL && $data_recebimento != NULL) {
				$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, id_elenco_financeiro, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, data_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$id_elenco', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', '$data_recebimento', 0)";
				// echo $sql;
				mysqli_query($link, $sql);
			} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $n_nota_fiscal == NULL || $data_nota == NULL || $data_recebimento == NULL) {
				echo "<script>alert('2-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
			}
			$caches = 1;
		}
			if ($valor_total_job > $subtotal){
				$comissao = $valor_total_job - $subtotal;
				$sql = "INSERT INTO financeiro (tipo_entrada, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, cache_bruto, tipo_cache, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, data_recebimento) VALUES ('Cache', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$comissao', 'Extra', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', '$data_recebimento')";
				mysqli_query($link, $sql);
			}
		echo "$caches cachê(s) inserido(s) com sucesso.";
	} elseif ($emitiu_nota == 1 && $status_recebimento == 0) {
			if ($n_participantes > 1) {
				$part = 1;
				while ($part <= $n_participantes) {
					$nome_artistico = $_POST['typeahead'.$part];
					$pieces = explode(" ", $nome_artistico);
					$nome = $pieces[0];
					if (isset($pieces[2])) {
						$sobrenome = $pieces[1]." ".$pieces[2];
					} else {
						$sobrenome = $pieces[1];
					}
					$sql_ID = "SELECT id_elenco FROM tb_elenco WHERE nome_artistico LIKE '$nome_artistico'";
					// echo $sql_ID;
					$query = mysqli_query($link, $sql_ID);
					$row = mysqli_fetch_assoc($query);
					$id_elenco = $row['id_elenco'];
					$cache_bruto = $_POST['cache_bruto'.$part];
					$subtotal = $subtotal + $cache_bruto;
					$cache_liquido = $_POST['cache_liquido'.$part];
					$tipo_job = $_POST['tipo_job'.$part];
					$tipo_cache = $_POST['tipo_cache'.$part];
					$cache_bruto = number_format($cache_bruto,2,".","");
					$cache_liquido = number_format($cache_liquido,2,".","");
					if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $n_nota_fiscal != NULL && $data_nota != NULL) {
						$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, id_elenco_financeiro, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$id_elenco', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', 0)";
					// echo $sql;
					mysqli_query($link, $sql);
					} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $n_nota_fiscal == NULL || $data_nota == NULL) {
						echo "<script>alert('3-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
					}
				$part++;
				$caches = $part - 1;
				}
			}
			if ($n_participantes == 1) {
		    	$part = "";
		    	$caches = 1;
				$nome_artistico = $_POST['typeahead'];
				$pieces = explode(" ", $nome_artistico);
				$nome = $pieces[0];
				if (isset($pieces[2])) {
					$sobrenome = $pieces[1]." ".$pieces[2];
				} else {
					$sobrenome = $pieces[1];
				}
				$sql_ID = "SELECT id_elenco FROM tb_elenco WHERE nome_artistico LIKE '$nome_artistico'";
				// echo $sql_ID;
				$query = mysqli_query($link, $sql_ID);
				$row = mysqli_fetch_assoc($query);
				$id_elenco = $row['id_elenco'];
				$cache_bruto = $_POST['cache_bruto'.$part];
				$subtotal = $subtotal + $cache_bruto;
				$cache_liquido = $_POST['cache_liquido'.$part];
				$tipo_job = $_POST['tipo_job'.$part];
				$tipo_cache = $_POST['tipo_cache'.$part];
				$cache_bruto = number_format($cache_bruto,2,".","");
				$cache_liquido = number_format($cache_liquido,2,".","");
				if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $n_nota_fiscal != NULL && $data_nota != NULL) {
					$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, id_elenco_financeiro, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$id_elenco', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento', 0)";
				// echo $sql;
				mysqli_query($link, $sql);
				} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $n_nota_fiscal == NULL || $data_nota == NULL) {
					echo "<script>alert('3-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
				}
			}
				if ($valor_total_job > $subtotal){
					$comissao = $valor_total_job - $subtotal;
					$sql = "INSERT INTO financeiro (tipo_entrada, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, cache_bruto, tipo_cache, emitiu_nota, n_nota_fiscal, data_nota, status_recebimento) VALUES ('Cache', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$comissao', 'Extra', '$emitiu_nota', '$n_nota_fiscal', '$data_nota', '$status_recebimento')";
					mysqli_query($link, $sql);
				}
		echo "$caches cachê(s) inserido(s) com sucesso.";
	} elseif ($emitiu_nota == 0 && $status_recebimento == 1) {
			if ($n_participantes > 1) {
				$part = 1;
				while ($part <= $n_participantes) {
					$nome_artistico = $_POST['typeahead'.$part];
					$pieces = explode(" ", $nome_artistico);
					$nome = $pieces[0];
					if (isset($pieces[2])) {
						$sobrenome = $pieces[1]." ".$pieces[2];
					} else {
						$sobrenome = $pieces[1];
					}
					$sql_ID = "SELECT id_elenco FROM tb_elenco WHERE nome_artistico LIKE '$nome_artistico'";
					// echo $sql_ID;
					$query = mysqli_query($link, $sql_ID);
					$row = mysqli_fetch_assoc($query);
					$id_elenco = $row['id_elenco'];
					$cache_bruto = $_POST['cache_bruto'.$part];
					$subtotal = $subtotal + $cache_bruto;
					$cache_liquido = $_POST['cache_liquido'.$part];
					$tipo_job = $_POST['tipo_job'.$part];
					$tipo_cache = $_POST['tipo_cache'.$part];
					$cache_bruto = number_format($cache_bruto,2,".","");
					$cache_liquido = number_format($cache_liquido,2,".","");
					if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $data_recebimento != NULL) {
						$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, id_elenco_financeiro, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, status_recebimento, data_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$id_elenco', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$status_recebimento', '$data_recebimento', 0)";
					// echo $sql;
					mysqli_query($link, $sql);
					} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $data_recebimento == NULL) {
						echo "<script>alert('4-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
					}
					$part++;
					$caches = $part - 1;
				}
			}
			if ($n_participantes == 1) {
		    	$part = "";
		    	$caches = 1;
				$nome_artistico = $_POST['typeahead'.$part];
				$pieces = explode(" ", $nome_artistico);
				$nome = $pieces[0];
				if (isset($pieces[2])) {
					$sobrenome = $pieces[1]." ".$pieces[2];
				} else {
					$sobrenome = $pieces[1];
				}
				$sql_ID = "SELECT id_elenco FROM tb_elenco WHERE nome_artistico LIKE '$nome_artistico'";
				// echo $sql_ID;
				$query = mysqli_query($link, $sql_ID);
				$row = mysqli_fetch_assoc($query);
				$id_elenco = $row['id_elenco'];
				$cache_bruto = $_POST['cache_bruto'.$part];
				$subtotal = $subtotal + $cache_bruto;
				$cache_liquido = $_POST['cache_liquido'.$part];
				$tipo_job = $_POST['tipo_job'.$part];
				$tipo_cache = $_POST['tipo_cache'.$part];
				$cache_bruto = number_format($cache_bruto,2,".","");
				$cache_liquido = number_format($cache_liquido,2,".","");
				if ($data_job != NULL && $produzido_por != NULL && $cliente_job != NULL && $campanha != NULL && $nome != NULL && $sobrenome != NULL && $cache_bruto != NULL && $cache_liquido != NULL && $tipo_job != NULL && $tipo_cache != NULL && $data_recebimento != NULL) {
					$sql = "INSERT INTO financeiro (tipo_entrada, midia, praca, periodo, periodo_tipo, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, nome, sobrenome, id_elenco_financeiro, cache_bruto, cache_liquido, tipo_job, tipo_cache, opcao_pagamento, emitiu_nota, status_recebimento, data_recebimento, status_pagamento) VALUES ('Cache', '$midia', '$praca', '$periodo', '$periodo_tipo', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$nome', '$sobrenome', '$id_elenco', '$cache_bruto', '$cache_liquido', '$tipo_job', '$tipo_cache', 'Após recebimento', '$emitiu_nota', '$status_recebimento', '$data_recebimento', 0)";
				// echo $sql;
				mysqli_query($link, $sql);
				} elseif ($data_job == NULL || $produzido_por == NULL || $cliente_job == NULL || $campanha == NULL || $nome == NULL || $sobrenome == NULL || $cache_bruto == NULL || $cache_liquido == NULL || $tipo_job == NULL || $tipo_cache == NULL || $data_recebimento == NULL) {
					echo "<script>alert('4-Cachê não inserido. Por favor complete todos os campos e tente novamente.');</script>";
				}			
			}
				if ($valor_total_job > $subtotal){
					$comissao = $valor_total_job - $subtotal;
					$sql = "INSERT INTO financeiro (tipo_entrada, previsao_pagamento, data_job, produzido_por, cliente_job, campanha, cache_bruto, tipo_cache, emitiu_nota, status_recebimento, data_recebimento) VALUES ('Cache', '$previsao_pagamento', '$data_job', '$produzido_por', '$cliente_job', '$campanha', '$comissao', 'Extra', '$emitiu_nota', '$status_recebimento', '$data_recebimento')";
					mysqli_query($link, $sql);
				}
		
		echo "$caches cachê(s) inserido(s) com sucesso.";
	}
	mysqli_close($link);
?>
	