<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Meu Modelo Favorito</title>
<!-- <style>
* {
  /*margin: 0px;*/
  padding: 0px;
}

*:focus {
  outline: none; }

html, body {
	position: relative;
	height: 100%;
	width: 100%;
	background: #c65eff;
	background: -moz-linear-gradient(-45deg,  #c65eff 0%, #ef017c 100%);
	background: -webkit-linear-gradient(-45deg,  #c65eff 0%,#ef017c 100%);
	background: linear-gradient(135deg,  #c65eff 0%,#ef017c 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c65eff', endColorstr='#ef017c',GradientType=1 );
}

body {
  margin: 0px;
  padding: 0px;
  overflow: hidden;
}

table, th, td {
    border: 0px solid black;
    border-collapse: collapse;
    border-spacing: 0px;
}
.foto {
	border: 0px solid #7524CD;
	box-shadow: 0px 2px 4px 0px rgba(0,0,0,0.50);
	border-radius: 25px;
}
.ou {
	width: 60px;
	height: 60px; 
}
.question {
	font-family: 'Roboto', sans-serif;
	font-size: 36px;
	color: #FFFFFF;
	font-weight: 100;
    margin-top: 50px;
    margin-bottom: 50px;
}

p {
	font-family: 'Roboto', sans-serif;
	font-size: 16px;
	color: #FFFFFF;
	font-weight: 100;
}

/*progress0*/
.progress progress{ position:relative; color:#FFFFFF; margin: 0; left: 50%; margin-left: -250px; width: 500px; height:10px; top: 50px; background:rgba(255,255,255,0.3); border:1px solid rgba(255,255,255,0.3); border-radius:8px; }
.progress progress::-webkit-progress-bar{ background:rgba(255,255,255,0.3); border-radius:8px; }
.progress progress::-webkit-progress-value{ background-color:#fff; border-radius:8px; }
.progress progress::-moz-progress-bar{ background-color:#fff; border-radius:8px; }

@media only screen and (max-width:350px) and (orientation:portrait){
.foto {
	width: 140px;
	height: 140px;
}
.ou {
	width: 30px;
	height: 30px; 
}
.question  {
	font-size: 24px;
	font-weight: 400;
	margin-left: 30px;
	margin-right: 30px;
}
.progress progress{ margin-left: -140px; width: 280px; top: 50px; }
}


@media only screen and (max-width:480px) and (orientation:landscape){
.foto {
	width: 160px;
	height: 160px;
}
.ou {
	width: 30px;
	height: 30px; 
}
.question  {
	font-size: 20px;
	font-weight: 400;
	margin-left: 100px;
	margin-right: 100px;
	margin-top: 20px;
	margin-bottom: 20px;
}
.progress progress{ margin-left: -180px; width: 360px; top: 20px; }
}

@media only screen and (min-width:481px) and (max-width:767px) and (orientation:landscape){
.foto {
	width: 200px;
	height: 200px;
}
.ou {
	width: 50px;
	height: 50px; 
}
.question  {
	font-size: 24px;
	font-weight: 400;
	margin-left: 100px;
	margin-right: 100px;
	margin-top: 20px;
	margin-bottom: 20px;
}
.progress progress{ margin-left: -180px; width: 360px; top: 20px; }
}

@media only screen and (min-width:351px) and (max-width:767px) and (orientation:portrait){
.foto {
	width: 160px;
	height: 160px;
}
.ou {
	width: 30px;
	height: 30px; 
}
.question  {
	font-size: 24px;
	font-weight: 400;
	margin-left: 30px;
	margin-right: 30px;
}
.progress progress{ margin-left: -160px; width: 320px; top: 50px; }
}
</style>
<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet"> -->
</head><body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include('conecta.php');

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

date_default_timezone_set('America/Sao_Paulo');
$per_page=2;
$vote_time_start = microtime(true);
if (isset($_GET['game_ID'])) { $game_ID = $_GET['game_ID']; }
else { $game_ID = 8395; }
$sql_ip = "SELECT voter_facebook_ID FROM tb_votes WHERE game_ID = '$game_ID' AND voter_facebook_ID = '$ip' LIMIT 1";
$result_ip = mysqli_query($link2, $sql_ip);
$row_ip = mysqli_fetch_array($result_ip);
$registered_vote = $row_ip['voter_facebook_ID'];

$sql03 = "SELECT COUNT(candidate_elenco_ID) AS total FROM tb_games WHERE game_ID = '$game_ID'";
$result03 = mysqli_query($link2, $sql03);
$row03 = mysqli_fetch_array($result03);
$total_records = $row03['total'];

// PROGRESS BAR
$left_pages = $total_records;
$total_progress = 1;
while ($left_pages > 1){
	$left_pages = ceil($left_pages/$per_page);
	$total_progress = $total_progress + $left_pages;
}
if (isset($_GET['progress'])) {
	$current_progress = $_GET['progress'];
} else {
	$current_progress = 1;
}

if ($registered_vote == $ip) { // SE JÁ VOTOU
	if (isset($_GET['page']) && isset($_GET['level'])) {
		$sql_question = "SELECT question, role, client, campaign FROM tb_games WHERE game_ID = '$game_ID' limit 1";
		$result_question = mysqli_query($link2, $sql_question);
		$row_question = mysqli_fetch_array($result_question);
			$question = $row_question['question'];
			$role = $row_question['role'];
			$client = $row_question['client'];
			$campaign = $row_question['campaign'];
		$page = $_GET['page'];
		$level = $_GET['level'];
		if ($level == 1){ // SE JÁ TERMINOU DE VOTAR
			include('result.php');
		} else {
		if ($level == 0) { // PRIMEIRO NÍVEL DE VOTAÇÃO
			
			$start_from = ($page-1) * $per_page;

			$sql01 = "SELECT id candidate_elenco_ID, arquivo foto_01 FROM (SELECT candidate_elenco_ID id FROM tb_games WHERE game_ID = '$game_ID' LIMIT $start_from, 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
			$result01 = mysqli_query($link2, $sql01);
			$row01 = mysqli_fetch_array($result01);
				$foto01 = $row01['foto_01'];
				$candidate_elenco_ID_1 = $row01['candidate_elenco_ID'];

			$start_from++;

			$sql02 = "SELECT id candidate_elenco_ID, arquivo foto_02 FROM (SELECT candidate_elenco_ID id FROM tb_games WHERE game_ID = '$game_ID' LIMIT $start_from, 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
			$result02 = mysqli_query($link2, $sql02);
			$row02 = mysqli_fetch_array($result02);
			$foto02 = $row02['foto_02'];
			$candidate_elenco_ID_2 = $row02['candidate_elenco_ID'];

			$total_pages = ceil($total_records/$per_page);

			$max_level = 1;
			$candidate_number = $total_records;
			while ($candidate_number > 2) {
				$candidate_number = ceil($candidate_number/$per_page);
				$max_level++;
			}
				$newpage = $page + 1;
				if ($page <= $total_pages) {
					$write_level = $max_level;
					}
		} else { // FASES FINAIS DE VOTAÇÃO
			$start_from = ($page-1) * $per_page;

			$sql01 = "SELECT id candidate_elenco_ID, arquivo foto_01 FROM (SELECT winner_candidate_ID id FROM tb_votes WHERE game_ID = '$game_ID' AND level = '$level' AND voter_facebook_ID = '$ip' LIMIT $start_from, 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
			$result01 = mysqli_query($link2, $sql01);
			$row01 = mysqli_fetch_array($result01);
			$foto01 = $row01['foto_01'];
			$candidate_elenco_ID_1 = $row01['candidate_elenco_ID'];

			$start_from++;

			$sql02 = "SELECT id candidate_elenco_ID, arquivo foto_02 FROM (SELECT winner_candidate_ID id FROM tb_votes WHERE game_ID = '$game_ID' AND level = '$level' AND voter_facebook_ID = '$ip' LIMIT $start_from, 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
			$result02 = mysqli_query($link2, $sql02);
			$row02 = mysqli_fetch_array($result02);
			$foto02 = $row02['foto_02'];
			$candidate_elenco_ID_2 = $row02['candidate_elenco_ID'];

			$sql03 = "SELECT COUNT(winner_candidate_ID) AS total FROM tb_votes WHERE game_ID = '$game_ID' AND level = '$level' AND voter_facebook_ID = '$ip' ";
			$result03 = mysqli_query($link2, $sql03);
			$row03 = mysqli_fetch_array($result03);
			$total_records = $row03['total'];

			$total_pages = ceil($total_records/$per_page);
			$newpage = $page + 1;
			if ($page <= $total_pages) {
				$write_level = $level - 1;
			}

			$max_level = 1;
			$candidate_number = $total_records;
			while ($candidate_number > 2) {
				$candidate_number = ceil($candidate_number/$per_page);
				$max_level++;
			}

			if (!isset($foto02)) { // REPESCAGEM
				$previous_level = $_GET['level'];
				$sql_odd = "SELECT id loser_candidate_elenco_ID2, arquivo foto_ODD2, vote_delay FROM (SELECT vote_delay, loser_candidate_ID id FROM tb_votes WHERE game_ID = '$game_ID' AND level = '$previous_level' AND voter_facebook_ID = '$ip' ORDER BY CAST(vote_delay AS UNSIGNED) DESC LIMIT 0,1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
				$result_odd = mysqli_query($link2, $sql_odd);
				$row_odd = mysqli_fetch_array($result_odd);
				$foto02 = $row_odd['foto_ODD2'];
				$candidate_elenco_ID_2 = $row_odd['loser_candidate_elenco_ID2'];
			}
		}
	}
}
	else { include('result.php'); exit(); } // DISPLAY RESULTADO PARA QUEM JÁ VOTOU

} else { // SE AINDA NÃO VOTOU
	if (isset($_GET['page'])) { $page = $_GET['page']; }
	else { $page=1; }
	if (isset($_GET['level'])) { $level = $_GET['level']; }
	else { $level=0; }

	$start_from = ($page-1) * $per_page;

	$sql_question = "SELECT question, role, client, campaign FROM tb_games WHERE game_ID = '$game_ID' limit 1";
	$result_question = mysqli_query($link2, $sql_question);
	$row_question = mysqli_fetch_array($result_question);
		$question = $row_question['question'];
		$role = $row_question['role'];
		$client = $row_question['client'];
		$campaign = $row_question['campaign'];

	$sql01 = "SELECT id candidate_elenco_ID, arquivo foto_01 FROM (SELECT candidate_elenco_ID id FROM tb_games WHERE game_ID = '$game_ID' LIMIT $start_from, 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
	$result01 = mysqli_query($link2, $sql01);
	$row01 = mysqli_fetch_array($result01);
		$foto01 = $row01['foto_01'];
		$candidate_elenco_ID_1 = $row01['candidate_elenco_ID'];

	$start_from++;

	$sql02 = "SELECT id candidate_elenco_ID, arquivo foto_02 FROM (SELECT candidate_elenco_ID id FROM tb_games WHERE game_ID = '$game_ID' LIMIT $start_from, 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
	$result02 = mysqli_query($link2, $sql02);
	$row02 = mysqli_fetch_array($result02);
	$foto02 = $row02['foto_02'];
	$candidate_elenco_ID_2 = $row02['candidate_elenco_ID'];

	$sql03 = "SELECT COUNT(candidate_elenco_ID) AS total FROM tb_games WHERE game_ID = '$game_ID'";
	$result03 = mysqli_query($link2, $sql03);
	$row03 = mysqli_fetch_array($result03);
	$total_records = $row03['total'];

	$total_pages = ceil($total_records/$per_page);

	$max_level = 1;
	$candidate_number = $total_records;
	while ($candidate_number > 2) {
		$candidate_number = ceil($candidate_number/$per_page);
		$max_level++;
	}
		$newpage = $page + 1;
		if ($page <= $total_pages) {
			$write_level = $max_level;
			}
}
if ($level != 1){
echo "<table align='center'>
<tr align='center'>
<td colspan='3'><p class='question'>$question</p></td>
</tr>
<tr align='center'>
<td><form id='form01' action='action_select.php' method='post'>
<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_1' />
<input type='hidden' name='game_ID' value='$game_ID' />
<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_2' />
<input type='hidden' name='write_level' value='$write_level' />
<input type='hidden' name='max_level' value='$max_level' />
<input type='hidden' name='view_level' value='$level' />
<input type='hidden' name='total_pages' value='$total_pages' />
<input type='hidden' name='progress' value='$current_progress' />
<input type='hidden' name='facebook_ID' value='$ip' />
<input type='hidden' name='vote_time_start' value='$vote_time_start' />
<input type='hidden' name='page' value='$newpage' />";
?>
<a href="javascript:document.getElementById('form01').submit();">
<?php echo "
<img src='http://www.magnetoelenco.com.br/fotos/$foto01' class='foto'>
</a></form></td>
<td><img src='ou.svg' class='ou'></td>
<td><form id='form02' action='action_select.php' method='post'>
<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_2' />
<input type='hidden' name='game_ID' value='$game_ID' />
<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_1' />
<input type='hidden' name='write_level' value='$write_level' />
<input type='hidden' name='max_level' value='$max_level' />
<input type='hidden' name='view_level' value='$level' />
<input type='hidden' name='total_pages' value='$total_pages' />
<input type='hidden' name='progress' value='$current_progress' />
<input type='hidden' name='facebook_ID' value='$ip' />
<input type='hidden' name='vote_time_start' value='$vote_time_start' />
<input type='hidden' name='page' value='$newpage' />";
?>
<a href="javascript:document.getElementById('form02').submit();">
<?php echo "
<img src='http://www.magnetoelenco.com.br/fotos/$foto02' class='foto'>
</a></form></td></tr></table>
	<div class='progress'>
	<progress id='progressbar1' value='$current_progress' max='$total_progress'></progress>
	</div>";
}
// mysqli_close($link2);
?>
</body>
</html>