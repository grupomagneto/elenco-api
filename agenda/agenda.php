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
	$sql = "SELECT * FROM novo_cadastro LEFT OUTER JOIN nova_agenda ON novo_cadastro.id_elenco = nova_agenda.id_elenco_agenda";
	$result = mysqli_query($link, $sql);
		if (!$result) {
		 die("Database query failed: " . mysqli_error());
		}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<link href='_css/fullcalendar.css' rel='stylesheet' />
<link href='_css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='_js/moment.min.js'></script>
<script src='_js/jquery.min.js'></script>
<script src='_js/fullcalendar.min.js'></script>
<script src='_js/pt-br.js'></script>
<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultView: 'agendaWeek',
			scrollTime:  '09:00:00',
			minTime:     '09:00:00',
			maxTime:     '19:00:00',
			hiddenDays:  [ 0 ],
			aspectRatio: 3.7,
			allDaySlot:  false,
			slotWidth:   240,
			contentHeight: 460,
			timeFormat: 'H:mm',
			defaultDate: '<?php echo $hoje;?>',
			businessHours: false,
			editable: true,
			lang: 'pt-br',
			events: [
	<?php			
		while ($row = mysqli_fetch_array($result)) {
			if ($row['data_agendamento'] != NULL){
				$id = $row['id_elenco'];
				$id_agenda = $row['id_elenco_agenda'];
				$nome = $row['nome']." ".$row['sobrenome'];
				$celular = $row['celular'];
				$tipo_cadastro_efetivado = $row['tipo_cadastro_efetivado'];
				$tipo_cadastro = $row['tipo_cadastro'];
				if ($tipo_cadastro_efetivado != NULL && $tipo_cadastro_efetivado != '') {
					$tipo_cadastro = $tipo_cadastro_efetivado;
				} elseif ($tipo_cadastro_efetivado == NULL || $tipo_cadastro_efetivado == '') {
					$tipo_cadastro = $row['tipo_cadastro'];
				}
				$nome_responsavel = $row['celular'];
				$dt_nascimento = $row['dt_nascimento'];
				$sexo = $row['sexo'];
				$bairro = $row['bairro'];
				$cor_pele = $row['cor_pele'];
				$data_agendamento = $row['data_agendamento'];
				$hora_agendamento = $row['hora_agendamento'];
				$novo_data_agendamento = $row['novo_data_agendamento'];
				$novo_hora_agendamento = $row['novo_hora_agendamento'];
					if ($novo_data_agendamento != NULL && $novo_data_agendamento != '0000-00-00') {
						$data = $novo_data_agendamento;
					} elseif ($novo_data_agendamento == NULL || $novo_data_agendamento == '' || $novo_data_agendamento == '0000-00-00') {
						$data = $data_agendamento;
					} if ($novo_hora_agendamento != NULL) {
						$hora = $novo_hora_agendamento;
					} elseif ($novo_hora_agendamento == NULL || $novo_hora_agendamento == '') {
						$hora = $hora_agendamento;
					}
				$start = $data."T".$hora.":00";
					if ($tipo_cadastro == 'Gratuito' || $tipo_cadastro == 'Premium' || $tipo_cadastro == 'Ator') {
						$hora = date( "H:i", strtotime($hora) + 30 * 60 );
						$end = $data."T".$hora.":00";
					} elseif ($tipo_cadastro == 'Ensaio') {
						$hora = date( "H:i", strtotime($hora) + 90 * 60 );
						$end = $data."T".$hora.":00";
					}  elseif ($tipo_cadastro == 'Cancelado') {
						$start = "1900-01-01T00:00:00";
						$end = "1900-01-01T00:30:00";
					}
				$comparecimento = $row['comparecimento'];
				$novo_data_agendamento = $row['novo_data_agendamento'];
				$novo_hora_agendamento = $row['novo_hora_agendamento'];
				$hora_chegada = $row['hora_chegada'];
				$celular = mask($celular, '(##) ####-####');	
	echo"		{
					id: 		'$id_agenda',";
					if ($tipo_cadastro == 'Gratuito'){
	echo"			color:  	'#b00000',";				
					} elseif ($tipo_cadastro == 'Premium'){
	echo"			color:  	'#378006',";				
					} elseif ($tipo_cadastro == 'Ensaio'){
	echo"			color:  	'#00aeff',";				
					} elseif ($tipo_cadastro == 'Ator'){
	echo"			color:  	'#eab000',";				
					}
	echo"			title: 		'$nome-$celular-$tipo_cadastro',
					start: 		'$start',
					end: 		'$end',
					overlap: 	false
				},";
			}
		}
	echo"		{
					title: 		'Almoço',
					url: 		'http://www.google.com/',
					start: 		'".$hoje."T12:00:00',
					overlap: 	true,
					end: 		'".$hoje."T14:00:00'
				}
					]
			});

		});";
?>
</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: 'Roboto', sans-serif; font-weight: 300;
		font-size: 14px;
	}

	#calendar {
		max-width: 100%;
		margin: 0 auto;
	}
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
</style>
</head>
<body>
<div id='calendar'></div>
</body>
</html>
<?php
mysqli_close($link);
?>
