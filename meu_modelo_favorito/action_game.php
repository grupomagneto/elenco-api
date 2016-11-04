<?php header('Content-type: text/html; charset=UTF-8');
include('conecta.php');
	$casting = $_POST['casting'];
	$casting = str_replace("http://www.magnetoelenco.com.br/v2/meu_casting.php?id_casting=", "", "$casting");
	$question = $_POST['question'];
	$role = $_POST['role'];
	$client = $_POST['client'];
	$campaign = $_POST['campaign'];
	$sql = "SELECT cd_elenco FROM ta_casting_elenco WHERE cd_casting = '$casting'";
	$result = mysqli_query($link2, $sql);
	$count = mysqli_num_rows($result);
	while ($row = mysqli_fetch_array($result)) {
		$candidate_elenco_ID = $row['cd_elenco'];
		$sql2 = "INSERT INTO tb_games (game_ID, candidate_elenco_ID, question, role, client, campaign) VALUES ('$casting','$candidate_elenco_ID','$question','$role','$client','$campaign')";
		mysqli_query($link2, $sql2);
	}
	echo $count." perfis inseridos com sucesso.";
mysqli_close($link2);
?>