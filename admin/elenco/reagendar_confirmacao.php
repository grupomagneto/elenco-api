<?php
	// Recebe a flag para definir a mensagem de confirmacao
	switch($_GET['flag']){
		case 1:
			$mensagem_confirmacao = "Agendamento não identificado. Por favor tente novamente.";
			break;
		case 2:
			$mensagem_confirmacao = "Reagendamento feito com sucesso!";
			break;	
		case 3:
			$mensagem_confirmacao = "Elenco não identificado. Por favor tente novamente.";
			break;
		case 4:
			$mensagem_confirmacao = "Agendamento feito com sucesso!";
			break;							
		default:
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Magneto Elenco - Reagendamento</title>

<style>
body{ font:11px arial; padding:0; margin:0; color:#58595b;}
.red{ color:#b3141a; font-weight:bold;}
.cipt{ width:200px; border:1px solid #a5acb2; padding:3px 0 3px 10px; color:#58595b;}
.cta{ width:680px; height:120px; border:1px solid #a5acb2; padding:3px 0 3px 10px; color:#58595b;}
.sucesso{margin-top:130px; font-size:18px; text-align:center;  font-weight:bold;}
</style>

</head>

<body>

<div class="sucesso"><?= $mensagem_confirmacao; ?></div>
 

</body>
</html>