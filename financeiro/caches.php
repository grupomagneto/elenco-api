<?php
include("conecta.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Caches - Magneto Elenco</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	.set-width {
	  width: 85px;
	}
	#vencido {
		color: red;
	}
	#checar {
		color: orange;
	}
	#vigente {
		color: green;
	}
	#indisponivel {
		color: red;
	}
	#pendencia {
		color: orange;
	}
/*	#cento_vinte {
		color: red;
	}
	#noventa {
		color: red;
	}
	#sessenta {
		color: orange;
	}*/
	#recebido_nao_pago {
		color: green;
	}
		input[type='number'] {
	   width:50px;
	}
	</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js'></script>
<script type='text/javascript' src='DataTables/datatables.min.js'></script>
<script type='text/javascript'>
$(document).ready(function(){
    $('#resultado').DataTable( {
		"aaSorting": [[4,'asc'], [0,'asc']]
    } );
} );
</script>
</head>
<body>
<center><div>
	<h1>Cachês</h1>
<?php
	$hoje = date('Y-m-d', time());
	$result = mysqli_query($link, "SELECT * FROM (SELECT id id_cache, data_job, nome, sobrenome, id_elenco_financeiro id, campanha, cliente_job, produzido_por, status_recebimento, liberado, previsao_pagamento, status_pagamento, data_pagamento, data_recebimento, n_ligacoes, cache_liquido, abatimento_cache FROM financeiro WHERE tipo_entrada='cache' AND status_pagamento = 0 AND YEAR(data_job) > '2014' AND nome IS NOT NULL ORDER BY data_job DESC) T1 INNER JOIN (SELECT id_elenco id, email, tipo_cadastro_vigente, data_contrato_vigente, tl_celular FROM tb_elenco comum) T2 USING (id) ORDER BY data_job DESC");
		if (!$result) {
		 die('Erro: ' . mysqli_error($link));
	}

// 	$tmp = array();
// 	while ($val = mysql_fetch_array($sql1)) {
// 	    $tmp[] = $val['id_elenco_financeiro'];
// 	}

// 	$sql2 = mysql_query($link2, "SELECT * FROM table2 WHERE fk_id in (".implode(', ', $tmp).")
// ", $db2);

?>
<form name='caches' id='caches' action='action_caches.php' method='post'>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
		<thead>
 			<tr>
     			<th>Status</th>
				<th>Previsão Pgto.</th>
     			<th>Agenciado</th>
				<th>Cadastro</th>
				<th>Contrato</th>
     			<th>Produtora - Cliente - Job</th>
				<th>Data do Job</th>
				<!-- <th>Ligações</th> -->
				<th>Cachê Líquido</th>
				<th>Operação</th>
			</tr>
		</thead>
		<tbody>
<?php
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id_cache'];
		$cadastro = $row['tipo_cadastro_vigente'];
		$contrato = $row['data_contrato_vigente'];
		if ($hoje <= date('Y-m-d', strtotime($contrato."+2 years")) && $contrato != NULL) {
			$contrato = "<div id='vigente'><strong>OK</strong></div>";
			// echo $contrato;
		} elseif ($hoje > date('Y-m-d', strtotime($contrato."+2 years")) && $contrato != NULL) {
			$contrato = "<div id='vencido'><strong>Vencido</strong></div>";
			// echo $contrato;
		} elseif ($contrato == NULL || $contrato == '') {
			$contrato = "<form id='checar".$id."' method='get' action='action_checar.php' target='resultado2".$id."'><input type='hidden' name='checar' value='$id'><button type='button' id='checa".$id."'>Checar</button></form>
<script type='text/javascript'>
document.getElementById('checa".$id."').addEventListener('click', function() {
	window.open('action_checar.php', 'resultado2".$id."', 'toolbar=no,scrollbars=no,directories=no,titlebar=yes,resizable=no,location=no,status=no,menubar=no,top=100,left=700,width=400,height=300');
	document.getElementById('checar".$id."').submit();
});
</script>";
		}
		// $_SESSION['data_job'.$id] = $row['data_job'];
		$adicional = 45;
		$previsao_pagamento = $row['previsao_pagamento'] + $adicional;
		$previsao = date('Y-m-d', strtotime($row['data_job']." + ".$previsao_pagamento." days"));
		$data_job = date('Y-m-d', strtotime($row['data_job']));
		$data_recebimento = date('Y-m-d', strtotime($row['data_recebimento']));
		$n_ligacoes = $row['n_ligacoes'];
		$liberado = $row['liberado'];
		// $_SESSION['nome'.$id] = $row['nome'];
		// $_SESSION['sobrenome'.$id] = $row['sobrenome'];
		// $_SESSION['campanha'.$id] = $row['campanha'];
		// $_SESSION['cliente_job'.$id] = $row['cliente_job'];
		// $_SESSION['produzido_por'.$id] = $row['produzido_por'];	
		// $_SESSION['liberado'.$id] = $row['liberado'];
		// $_SESSION['status_pagamento'.$id] = $row['status_pagamento'];
		// $_SESSION['data_pagamento'.$id] = $row['data_pagamento'];
		// $_SESSION['data_recebimento'.$id] = $row['data_recebimento'];
		// $_SESSION['cache_liquido'.$id] = $row['cache_liquido'];	
		$cache_liquido = $row['cache_liquido'] - $row['abatimento_cache'];
		$cache_liquido_format = number_format($cache_liquido,2,",",".");
		$sessenta = date('Y-m-d', strtotime($row['data_job']. ' + 60 days'));
		$noventa = date('Y-m-d', strtotime($row['data_job']. ' + 90 days'));	
		$cento_vinte = date('Y-m-d', strtotime($row['data_job']. ' + 120 days'));
		$cento_oitenta = date('Y-m-d', strtotime($row['data_job']. ' + 180 days'));
		$previsao_format = date('d/m/Y', strtotime($previsao));
		$data_job_format = date('d/m/Y', strtotime($data_job));
echo " 			<tr>";
echo "     			<td>";
					// if ($row['status_recebimento'] == 1 && $row['status_pagamento'] == 0) {
					// if ($row['liberado'] == 1 && $row['status_pagamento'] == 0) {
					if ($liberado == 1 && $hoje <= date('Y-m-d', strtotime($row['data_contrato_vigente']."+2 years")) && $row['data_contrato_vigente'] != NULL || $liberado == 1 && $previsao <= $hoje && $row['status_recebimento'] == 1 && $hoje <= date('Y-m-d', strtotime($row['data_contrato_vigente']."+2 years")) && $row['data_contrato_vigente'] != NULL) {
					    echo "<div id='recebido_nao_pago'><strong> Liberado</strong></div>";
					} elseif ($previsao <= $hoje && $row['status_recebimento'] == 1 && $hoje > date('Y-m-d', strtotime($row['data_contrato_vigente']."+2 years")) || $row['data_contrato_vigente'] == NULL) {
					    echo "<div id='pendencia'><strong>  Pendência</strong></div>";
					// // } elseif ($row['status_recebimento'] == 0 && $row['status_pagamento'] == 0 && $hoje >= $sessenta && $hoje < $noventa) {
					// } elseif ($row['liberado'] == 0 && $row['status_pagamento'] == 0 && $hoje >= $sessenta && $hoje < $noventa) {
					//     echo "<div id='sessenta'><strong>(3) Indisponível (60+)</strong></div>";
					// // } elseif ($row['status_recebimento'] == 0 && $row['status_pagamento'] == 0 && $hoje >= $noventa && $hoje < $cento_vinte) {
					// } elseif ($row['liberado'] == 0 && $row['status_pagamento'] == 0 && $hoje >= $noventa && $hoje < $cento_vinte) {
					//     echo "<div id='noventa'><strong>(2) Indisponível (90+)</strong></div>";
					// // } elseif ($row['status_recebimento'] == 0 && $row['status_pagamento'] == 0 && $hoje >= $cento_vinte) {
					// } elseif ($row['liberado'] == 0 && $row['status_pagamento'] == 0 && $hoje >= $cento_vinte && $hoje < $cento_oitenta) {
					//     echo "<div id='cento_vinte'><strong>(1) Indisponível (120+)</strong></div>";
					// } elseif ($row['liberado'] == 0 && $row['status_pagamento'] == 0 && $hoje >= $cento_oitenta) {
					//     echo "<div id='cento_vinte'><strong>(8) Indisponível (180+)</strong></div>";
					// // } elseif ($row['status_recebimento'] == 0 && $row['status_pagamento'] == 0 && $hoje <= $sessenta) {
					// } elseif ($row['liberado'] == 0 && $row['status_pagamento'] == 0 && $hoje <= $sessenta) {
					//     echo "(4) Indisponível";
					// } elseif ($row['liberado'] == 0 && $row['status_pagamento'] == 0) {
					} else {
					    echo "<div id='indisponivel'><strong>Indisponível</strong></div>";
					// } elseif ($row['status_recebimento'] == 0 && $row['status_pagamento'] == 1) {
					//     echo "(3) Adiantamento";
					// } elseif ($row['status_recebimento'] == 1 && $row['status_pagamento'] == 1) {
					//     echo "(2) Pago";
					}
echo "				</td>";
echo "     			<td>".$previsao_format."</td>";
echo "     			<td>".$row['nome']." ".$row['sobrenome']."</td>";
echo "     			<td>".$cadastro."</td>";
echo "     			<td>".$contrato."</td>";
echo "     			<td>".$row['produzido_por']." - ".$row['cliente_job']." - ".$row['campanha']."</td>";
echo "     			<td>".$data_job_format."</td>";
// echo "     			<td>";
// 					if ($row['data_recebimento'] == NULL || $row['data_recebimento'] == '') {
// 					    echo "Não Recebido</td>";
// 					} else {
// 						echo $row['data_recebimento']."</td>";
// 					}
// echo "     			<td><input type='number' name='n_ligacoes".$id."' size='5' ";
// 					if ($row['n_ligacoes'] != NULL) {
// 					    echo "value='".$row['n_ligacoes']."'></td>";
// 					} else {
// 						echo "placeholder='0' value=''></td>";
// 					}
echo "     			<td>R$ ".$cache_liquido_format."</td>";
// echo "     			<td><input type='date' name='nova_data_pagamento".$id."' size='10' class='input' ";
// 					if ($row['data_pagamento'] != NULL) {
// 					    echo "value='".$row['data_pagamento']."'></td>";
// 					} else {
// 						echo "placeholder='$hoje' value=''></td>";
// 					}
echo "     			<td><form id='pagar".$id."' method='get' action='action_pagar.php' target='resultado".$id."'><input type='hidden' name='pagar' value='$id'><button type='button' id='paga".$id."'>Pagar</button></form></td>";
echo "				<script type='text/javascript'>
						document.getElementById('paga".$id."').addEventListener('click', function() {
							window.open('action_pagar.php', 'resultado".$id."', 'toolbar=no,scrollbars=no,directories=no,titlebar=yes,resizable=no,location=no,status=no,menubar=no,top=100,left=700,width=400,height=600');
							document.getElementById('pagar".$id."').submit();
						});
					</script>";
echo " 			</tr>";
}
	$result2 = mysqli_query($link, "SELECT SUM(cache_liquido) AS total FROM financeiro WHERE status_pagamento=0 AND status_recebimento=1 AND YEAR(data_job) > '2014' AND data_job + INTERVAL previsao_pagamento + $adicional DAY <= CURDATE() AND id_elenco_financeiro IS NOT NULL AND tipo_entrada = 'cache'");
		if (!$result2) {
		 die("Database query failed: " . mysqli_error());
}
	while ($row2 = mysqli_fetch_array($result2)) {
		$total = $row2['total'];
		$total_format = number_format($total,2,",",".");
}
?>
		</tbody>
		<tr>
			<th>Liberado</th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
			<th></th>
 			<th></th>
 			<th><?php echo "R$: $total_format"; ?></th>
 			<th></th>
		</tr>
	</table>
</form>
</div></center>
</body>
</html>
<?php
 mysqli_close($link);
?>