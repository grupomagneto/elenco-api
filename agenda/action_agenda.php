<?php
header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
			unset ($id, $n_tentativas, $tipo_cadastro_efetivado, $data_agendamento, $hora_agendamento, $comparecimento, $novo_data_agendamento, $novo_hora_agendamento, $hora_chegada, $id_agenda, $result_array, $a1, $a2, $dt_insercao, $nome, $celular, $tipo_cadastro, $email, $nome_responsavel, $dt_nascimento, $sexo, $bairro, $cor_pele, $facebook, $instagram, $twitter);
if (!empty($_POST['alterar'])) {
    $id 							= 	$_POST['alterar'];
	$tipo_cadastro_efetivado		=	$_SESSION['tipo_cadastro_efetivado'.$id];
	$n_tentativas 					= 	$_SESSION['n_tentativas'.$id];
	$data_agendamento 				= 	$_SESSION['data_agendamento'.$id];
	$hora_agendamento 				= 	$_SESSION['hora_agendamento'.$id];
	$comparecimento					=	$_SESSION['comparecimento'.$id];
	$novo_data_agendamento			=	$_SESSION['novo_data_agendamento'.$id];
	$novo_hora_agendamento			=	$_SESSION['novo_hora_agendamento'.$id];
	$hora_chegada					=	$_SESSION['hora_chegada'.$id];
	$novo_n_tentativas 				= 	$_POST['novo_n_tentativas'.$id];
	$novo_comparecimento 			= 	$_POST['novo_comparecimento'.$id];
	$novo_novo_data_agendamento 	= 	$_POST['novo_novo_data_agendamento'.$id];
	$novo_novo_hora_agendamento 	= 	$_POST['novo_novo_hora_agendamento'.$id];
	$novo_tipo_cadastro_efetivado 	= 	$_POST['novo_tipo_cadastro_efetivado'.$id];
	$novo_hora_chegada 				= 	$_POST['novo_hora_chegada'.$id];
	if ($novo_novo_data_agendamento == $novo_data_agendamento || $novo_novo_data_agendamento == $data_agendamento) {
		$novo_novo_data_agendamento = NULL;
	}
	if ($novo_hora_chegada == $hora_chegada) {
		$novo_hora_chegada = NULL;
	}
	// echo    "id: ".$id."<BR />";
	// echo    "tipo_cadastro: ".$tipo_cadastro_efetivado."<BR />";
	// echo    "n_tentativas: ".$n_tentativas."<BR />";
	// echo    "data_agendamento: ".$data_agendamento."<BR />";
	// echo    "hora_agendamento: ".$hora_agendamento."<BR />";
	// echo    "comparecimento: ".$comparecimento."<BR />";
	// echo    "novo_data_agendamento: ".$novo_data_agendamento."<BR />";
	// echo    "novo_hora_agendamento: ".$novo_hora_agendamento."<BR />";
	// echo    "hora_chegada: ".$hora_chegada."<BR />";
	// echo    "novo_n_tentativas: ".$novo_n_tentativas."<BR />";
	// echo    "novo_comparecimento: ".$novo_comparecimento."<BR />";
	// echo    "novo_novo_data_agendamento: ".$novo_novo_data_agendamento."<BR />";
	// echo    "novo_novo_hora_agendamento: ".$novo_novo_hora_agendamento."<BR />";
	// echo    "novo_tipo_cadastro_efetivado: ".$novo_tipo_cadastro_efetivado."<BR />";
	// echo    "novo_hora_chegada: ".$novo_hora_chegada."<BR />";
	$sql_pull = "SELECT id_elenco_agenda FROM nova_agenda";
	$result = mysqli_query($link, $sql_pull);
		if (!$result) {
		 die("Database query failed: " . mysqli_error());
		}
		$a1 = array();
		array_push($a1, $id);
		$a2 = array();
		while ($row = mysqli_fetch_array($result)) {
			$id_elenco_agenda = $row['id_elenco_agenda'];
			array_push($a2, $id_elenco_agenda);
		}
		$result_array = array_intersect($a1,$a2);
		if (!empty($result_array)) {
			$sql = "UPDATE nova_agenda SET";
			$replace = array();
			$set = array();
			$new = "novo_";
			if (isset($novo_n_tentativas) && $novo_n_tentativas != NULL && isset($n_tentativas)) {
				array_push($replace, 'n_tentativas');
			} elseif (!isset($n_tentativas) && $novo_n_tentativas != NULL){
				array_push($set, 'n_tentativas');
			}
			if (isset($novo_comparecimento) && $novo_comparecimento != NULL && isset($comparecimento)) {
				array_push($replace, 'comparecimento');
			} elseif (!isset($comparecimento) && $novo_comparecimento != NULL){
				array_push($set, 'comparecimento');
			}
			if (isset($novo_novo_data_agendamento) && $novo_novo_data_agendamento != NULL && isset($novo_data_agendamento)) {
				array_push($replace, 'novo_data_agendamento');
			} elseif (!isset($novo_data_agendamento) && $novo_novo_data_agendamento != NULL){
				if (!isset($data_agendamento) && $novo_novo_data_agendamento != NULL){
					array_push($set, 'data_agendamento');
					$new = "novo_novo_";
				} elseif (isset($data_agendamento) && $novo_novo_data_agendamento != NULL){
					array_push($set, 'novo_data_agendamento');
				}
			}
			if (isset($novo_novo_hora_agendamento) && $novo_novo_hora_agendamento != NULL && isset($novo_hora_agendamento)) {
				array_push($replace, 'novo_hora_agendamento');
			} elseif (!isset($novo_hora_agendamento) && $novo_novo_hora_agendamento != NULL){
				if (!isset($hora_agendamento) && $novo_novo_hora_agendamento != NULL){
					array_push($set, 'hora_agendamento');
					$new = "novo_novo_";
				} elseif (isset($hora_agendamento) && $novo_novo_hora_agendamento != NULL){
					array_push($set, 'novo_hora_agendamento');
				}
			}
			if (isset($novo_hora_chegada) && $novo_hora_chegada != NULL && isset($hora_chegada)) {
				array_push($replace, 'hora_chegada');
			} elseif (!isset($hora_chegada) && $novo_hora_chegada != NULL){
				array_push($set, 'hora_chegada');
			}
			if (isset($novo_tipo_cadastro_efetivado) && $novo_tipo_cadastro_efetivado != NULL && isset($tipo_cadastro_efetivado)) {
				array_push($replace, 'tipo_cadastro_efetivado');
			} elseif (!isset($tipo_cadastro_efetivado) && $novo_tipo_cadastro_efetivado != NULL){
				array_push($set, 'tipo_cadastro_efetivado');
			}
			$arr_lenght = count($replace);
			$comma = $arr_lenght - 1;
			if ($arr_lenght > 0) {
				for($i=1;$i<=$arr_lenght;$i++) {
					foreach($replace as $key => $value) {
					    $$key = $value;
						$sql .= " ".$value." = REPLACE(".$value.", '${$value}', '${$new.$value}')";
						if ($comma > 0) {
							$sql .= ", ";
							$comma--;
						}
						$arr_lenght--;
					}
				}
			} 
			$arr_lenght = count($set);
			$comma = $arr_lenght - 1;
			if ($arr_lenght > 0) {
				for($i=1;$i<=$arr_lenght;$i++) {
					foreach($set as $key => $value) {
					    $$key = $value;
						$sql .= " ".$value." = '${$new.$value}'";
						if ($comma > 0) {
							$sql .= ", ";
							$comma--;
						}
						$arr_lenght--;
					}
				}
			}
			$sql .= " WHERE id_elenco_agenda = '".$id."'";
			mysqli_query($link, $sql);
			// echo $sql;
		} elseif (empty($result_array)) {
			$colunas = array();
			array_push($colunas, 'id_elenco_agenda');
			$valores = array();
			array_push($valores, $id);
			if (isset($novo_n_tentativas) && $novo_n_tentativas != NULL) {
				array_push($colunas, 'n_tentativas');
				array_push($valores, $novo_n_tentativas);
			} if (isset($novo_tipo_cadastro_efetivado) && $novo_tipo_cadastro_efetivado != NULL) {
				array_push($colunas, 'tipo_cadastro_efetivado');
				array_push($valores, $novo_tipo_cadastro_efetivado);
			} if (isset($novo_comparecimento) && $novo_comparecimento != NULL) {
				array_push($colunas, 'comparecimento');
				array_push($valores, $novo_comparecimento);
			} if (isset($novo_hora_chegada) && $novo_hora_chegada != NULL) {
				array_push($colunas, 'hora_chegada');
				array_push($valores, $novo_hora_chegada);
			} if (isset($novo_novo_hora_agendamento) && $novo_novo_hora_agendamento != NULL) {
				array_push($colunas, 'hora_agendamento');
				array_push($valores, $novo_novo_hora_agendamento);
			} if (isset($novo_novo_data_agendamento) && $novo_novo_data_agendamento != NULL) {
				array_push($colunas, 'data_agendamento');
				array_push($valores, $novo_novo_data_agendamento);
			}
			$col = implode(", ",$colunas);
			$val = implode("', '",$valores);
			$sql2 = "INSERT INTO nova_agenda ($col) VALUES ('$val')";
			mysqli_query($link, $sql2);
			// echo $sql2;
		}
}
header("Location: gestao.php");
mysqli_close($link);
?>