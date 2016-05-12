<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	$hoje = date('Y-m-d', time());
	function mask($val, $mask)
		{
		 $maskared = '';
		 $k = 0;
		 for($i = 0; $i<=strlen($mask)-1; $i++)
		 {
		 if($mask[$i] == '#')
		 {
		 if(isset($val[$k]))
		 $maskared .= $val[$k++];
		 }
		 else
		 {
		 if(isset($mask[$i]))
		 $maskared .= $mask[$i];
		 }
		 }
		 return $maskared;
		}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
 	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	body { font-family: 'Roboto', sans-serif; font-weight: 300; }
	input[type='number'] {
	   width:50px;
	}
	#novo {
		color: red;
	}
	#tentativas {
		color: orange;
	}
	#agendado {
		color: green;
	}
	#remarcado {
		color: blue;
	}
	.fc-agendaWeek-view tr {
	    height: 40px;
	}

	.fc-agendaDay-view tr {
	    height: 40px;
	}
	.fc-agendaWeek-slots td div {
        height: 60px;
        line-height: 6px;
    }
    .fc-agendaWeek-axis {
        font-size:1px;
        line-height: 1px;
    }
	input[type='date'] {
	   width:145px;
	}
	</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.js'></script>
<script type='text/javascript' src='DataTables/datatables.js'></script>
	<script type='text/javascript'>
	$(document).ready(function(){
	    $('#resultado').DataTable( {
			"aaSorting": [[0,'asc'], [1,'asc']]
	    } );
	} );
	</script>
</head>
<body>
<div>
<center><h1>Gestão dos Cadastros</h1></center>
<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
	<thead>
		<tr>
			<th scope='col'>Status</th>
			<th scope='col'>Inserção</th>
			<th scope='col'>Nome</th>
			<th scope='col'>Telefone</th>
			<th scope='col'>Idade</th>
			<th scope='col'>Cadastro</th>
			<th scope='col'>Mais Info</th>
			<th scope='col'>Tentativas</th>
			<th scope='col'>Data Agendada</th>
			<th scope='col'>Horário</th>
			<th scope='col'>Agenda</th>
		</tr>
	</thead>
	<tbody>
<?php
	$sql = "SELECT *, TIMESTAMPDIFF(YEAR, dt_nascimento, CURDATE()) AS age FROM novo_cadastro LEFT OUTER JOIN nova_agenda ON novo_cadastro.id_elenco = nova_agenda.id_elenco_agenda";
	$result = mysqli_query($link, $sql);
		if (!$result) {
		 die("Database query failed: " . mysqli_error());
		}
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id_elenco'];
		$dt_insercao = $row['dt_insercao'];
		$dt_insercao = date( "d/m/Y H:i:s", strtotime($dt_insercao) -3 * 3600 );
		$nome = $row['nome']." ".$row['sobrenome'];
		$celular = $row['celular'];
		$celular = mask($celular, '(##) ####-####');
		$tipo_cadastro = $row['tipo_cadastro'];
			if ($row['tipo_cadastro_efetivado'] != NULL) {
				$tipo_cadastro = $row['tipo_cadastro_efetivado'];
			}
		$age = $row['age'];
		$_SESSION['nome'.$id] = $row['nome']." ".$row['sobrenome'];
		$_SESSION['email'.$id] = $row['email'];
		$_SESSION['cpf'.$id] = $row['cpf'];
		$_SESSION['nome_responsavel'.$id] = $row['nome_responsavel'];
		$_SESSION['cpf_responsavel'.$id] = $row['cpf_responsavel'];
		$_SESSION['dt_nascimento'.$id] = $row['dt_nascimento'];
		$_SESSION['sexo'.$id] = $row['sexo'];
		$_SESSION['bairro'.$id] = $row['bairro'];
		$_SESSION['cor_pele'.$id] = $row['cor_pele'];
		$_SESSION['facebook'.$id] = $row['facebook'];
		$_SESSION['instagram'.$id] = $row['instagram'];
		$_SESSION['twitter'.$id] = $row['twitter'];
		$_SESSION['observacao'.$id] = $row['observacao'];
		$_SESSION['id_typeform'.$id] = $row['id_typeform'];
			$a1 = array();
			array_push($a1, $id);
			$id_agenda = $row['id_elenco_agenda'];
			$a2 = array();
			array_push($a2, $id_agenda);
			$result_array = array_intersect($a1,$a2);
			if (!empty($result_array)) {
				$_SESSION['tipo_cadastro_efetivado'.$id] 	= $row['tipo_cadastro_efetivado'];
				$_SESSION['n_tentativas'.$id] 				= $row['n_tentativas'];
				$_SESSION['data_agendamento'.$id] 			= $row['data_agendamento'];
				$_SESSION['hora_agendamento'.$id] 			= $row['hora_agendamento'];
				$_SESSION['novo_data_agendamento'.$id] 		= $row['novo_data_agendamento'];
				$_SESSION['novo_hora_agendamento'.$id] 		= $row['novo_hora_agendamento'];
				$_SESSION['comparecimento'.$id] 			= $row['comparecimento'];
				$_SESSION['hora_chegada'.$id] 				= $row['hora_chegada'];
				$tipo_cadastro_efetivado 					= $row['tipo_cadastro_efetivado'];
				$n_tentativas 								= $row['n_tentativas'];
				$data_agendamento 							= $row['data_agendamento'];
				$hora_agendamento 							= $row['hora_agendamento'];
				$novo_data_agendamento				 		= $row['novo_data_agendamento'];
				$novo_hora_agendamento 						= $row['novo_hora_agendamento'];
				$comparecimento 							= $row['comparecimento'];
			}
echo " 			<tr>";
echo "     			<td>";
					if (!isset($id_agenda)) {
					    echo "<div id='novo'><strong>(1) Novo</strong></div>";
					} elseif (isset($id_agenda) && $tipo_cadastro_efetivado == NULL && $data_agendamento == NULL) {
					    echo "<div id='tentativas'><strong>(2) ".$n_tentativas." Tentativa(s)</strong></div>";
					} elseif (isset($id_agenda) && $tipo_cadastro_efetivado == NULL && $data_agendamento != NULL && $novo_data_agendamento == NULL) {
					    echo "<div id='agendado'><strong>(3) Agendado</strong></div>";
					} elseif (isset($id_agenda) && $tipo_cadastro_efetivado == NULL && $data_agendamento != NULL && $novo_data_agendamento != NULL) {
					    echo "<div id='remarcado'><strong>(4) Remarcado</strong></div>";
					} elseif (isset($id_agenda) && $tipo_cadastro_efetivado != NULL && $tipo_cadastro_efetivado != 'Cancelado') {
					    echo "(5) Cadastrado";
					} elseif (isset($id_agenda) && $tipo_cadastro_efetivado == 'Cancelado') {
					    echo "(6) Cancelado";
					}
echo "     			</td>";
echo "     			<td>".$dt_insercao."</td>";
echo "     			<td>".$nome."</td>";
echo "     			<td><strong>".$celular."</strong></td>";
echo "				<td><center>".$age."</center></td>";
echo "     			<td>".$tipo_cadastro."</td>";
echo "     			<td><form id='info".$id."' method='get' action='mais_info.php' target='resultado".$id."'><input type='hidden' name='info' value='$id'><button type='button' id='visualizar".$id."'>Visualizar</button></form></td>";
echo "				<script type='text/javascript'>
						document.getElementById('visualizar".$id."').addEventListener('click', function() {
							window.open('mais_info.php', 'resultado".$id."', 'toolbar=no,scrollbars=no,directories=no,titlebar=yes,resizable=no,location=no,status=no,menubar=no,top=100,left=700,width=600,height=700');
							document.getElementById('info".$id."').submit();
						});
					</script>";
echo "     			<td><form id='action".$id."' action='action_agenda.php' method='post'><input type='number' name='novo_n_tentativas".$id."' ";
					if (!isset($n_tentativas)) {
					    echo "placeholder='0'></td>";
					} elseif (isset($n_tentativas)) {
						$n_tentativas_mais = $n_tentativas;
						$n_tentativas_mais++;
						echo "placeholder='".$n_tentativas."' min='".$n_tentativas_mais."'></td>";
					}
echo "     			<td><input type='date' name='novo_novo_data_agendamento".$id."' size='10' ";
					if (isset($data_agendamento)) {
						if (isset($novo_data_agendamento) && $novo_data_agendamento != '0000-00-00') {
					    echo "value='".$novo_data_agendamento."'></td>";
						} elseif (!isset($novo_data_agendamento) || $novo_data_agendamento == '0000-00-00') {
						echo "value='".$data_agendamento."'></td>";
						}
					} elseif (!isset($data_agendamento)) {
						echo "placeholder='".$hoje."' value=''></td>";
					}
echo "     			<td><select name='novo_novo_hora_agendamento".$id."')'>";
					if (isset($hora_agendamento)) {
						if (isset($novo_hora_agendamento) && $novo_hora_agendamento != '') {
echo "					<option disabled selected>".$novo_hora_agendamento."</option>";
						} elseif (!isset($novo_hora_agendamento) || $novo_hora_agendamento == '') {
echo "					<option disabled selected>".$hora_agendamento."</option>";
						}
					} elseif (!isset($hora_agendamento)) {
echo "					<option disabled selected> -- </option>";
					}
echo "					<option disabled>-Manhã</option>
						<option value='09:00'>09:00</option>
					    <option value='09:30'>09:30</option>
						<option value='10:00'>10:00</option>
					    <option value='10:30'>10:30</option>
						<option value='11:00'>11:00</option>
					    <option value='11:30'>11:30</option>
						<option disabled>-Tarde</option>
						<option value='14:00'>14:00</option>
					    <option value='14:30'>14:30</option>
						<option value='15:00'>15:00</option>
					    <option value='15:30'>15:30</option>
						<option value='16:00'>16:00</option>
					    <option value='16:30'>16:30</option>
						<option value='17:00'>17:00</option>
						<option value='17:30'>17:30</option>
				    </select>
					</td>";
echo "				<td><button type='submit' name='alterar' value='$id'>Marcar</button></form></td>
				</tr>";
unset ($id, $n_tentativas, $tipo_cadastro_efetivado, $data_agendamento, $hora_agendamento, $comparecimento, $novo_data_agendamento, $novo_hora_agendamento, $hora_chegada, $id_agenda, $result_array, $a1, $a2, $dt_insercao, $nome, $celular, $tipo_cadastro, $email, $nome_responsavel, $dt_nascimento, $sexo, $bairro, $cor_pele, $facebook, $instagram, $twitter);
	}
?>
</tbody>
</table>
</div>
</body>
</html>
<?php
	mysqli_close($link);
?>