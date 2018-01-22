<?php

function getFeriados($dia=NULL,$mes=NULL){
	if( !isset($dia) ) $dia = date("d");
	if( !isset($mes) ) $mes = date("m");
	
	$message = false;
	
	// JANEIRO
	if ($dia == "01" && $mes == "01"){ $message = "Confraternização Universal | Dia Mundial da Paz "; }
	
	// FEVEREIRO
	elseif ($dia == "08" && $mes == "02"){ $message = "Carnaval"; }
	elseif ($dia == "09" && $mes == "02"){ $message = "Carnaval"; }
	elseif ($dia == "10" && $mes == "02"){ $message = "Carnaval"; }
	
	// MARÇO
	elseif ($dia == "25" && $mes == "03"){ $message = "Sexta-feira da Paixão"; }
	elseif ($dia == "26" && $mes == "03"){ $message = "Sábado de Aleluia"; }
		
	// ABRIL
	elseif ($dia == "21" && $mes == "04"){ $message = "Tiradentes - Aniversário de Brasília"; }
	
	// MAIO
	elseif ($dia == "01" && $mes == "05"){ $message = "Dia do Trabalho"; }
	elseif ($dia == "26" && $mes == "05"){ $message = "Corpus Christi"; }
	
	// JUNHO
	
	// JULHO
	
	// AGOSTO
		
	// SETEMBRO
	elseif ($dia == "07" && $mes == "09"){ $message = "Independência do Brasil"; }
	
	// OUTUBRO
	elseif ($dia == "12" && $mes == "10"){ $message = "Nossa Senhora Aparecida"; }
	
	// NOVEMBRO
	elseif ($dia == "02" && $mes == "11"){ $message = "Dia de Finados"; }
	elseif ($dia == "15" && $mes == "11"){ $message = "Proclamação da República "; }
	
	// DEZEMBRO
	elseif ($dia == "25" && $mes == "12"){ $message = "Natal"; }

	
	return $message;
}
?>