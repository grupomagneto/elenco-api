<!DOCTYPE html><html>
<head>
<title>Meu Modelo Favorito</title>
</head><body>
<?php
include('conecta.php');
date_default_timezone_set('America/Sao_Paulo');
$per_page=2;
$vote_time_start = microtime(true);
	if (isset($_GET['game_ID'])) { $game_ID = $_GET['game_ID']; }
	else { $game_ID = 8231; }
	if (isset($_GET['page'])) { $page = $_GET['page']; }
	else { $page=1; }
	if (isset($_GET['level'])) { $level = $_GET['level']; }
	else { $level=0; }

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
	if ($page <= $total_pages && $level == 0) {
		$write_level = $max_level;
		echo "<table align='center' border='1'><tr align='center'>
		<td><form id='form01' action='action_select.php' method='post'>
		<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_1' />
		<input type='hidden' name='game_ID' value='$game_ID' />
		<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_2' />
		<input type='hidden' name='write_level' value='$write_level' />
		<input type='hidden' name='max_level' value='$max_level' />
		<input type='hidden' name='view_level' value='$level' />
		<input type='hidden' name='total_pages' value='$total_pages' />
		<input type='hidden' name='vote_time_start' value='$vote_time_start' />
		<input type='hidden' name='page' value='$newpage' />";
		?>
		<a href="javascript: document.getElementById('form01').submit();">
		<?php echo "
		<img src='http://www.magnetoelenco.com.br/fotos/$foto01'>$candidate_elenco_ID_1
		</a></form></td>
		<td><form id='form02' action='action_select.php' method='post'>
		<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_2' />
		<input type='hidden' name='game_ID' value='$game_ID' />
		<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_1' />
		<input type='hidden' name='write_level' value='$write_level' />
		<input type='hidden' name='max_level' value='$max_level' />
		<input type='hidden' name='view_level' value='$level' />
		<input type='hidden' name='total_pages' value='$total_pages' />
		<input type='hidden' name='vote_time_start' value='$vote_time_start' />
		<input type='hidden' name='page' value='$newpage' />";
		?>
		<a href="javascript: document.getElementById('form02').submit();">
		<?php echo "
		<img src='http://www.magnetoelenco.com.br/fotos/$foto02'>$candidate_elenco_ID_2
		</a></form></td></tr></table>";
		}
	else {
		if ($level > 1) {
			$start_from = ($page-1) * $per_page;

			$sql01 = "SELECT id candidate_elenco_ID, arquivo foto_01 FROM (SELECT winner_candidate_ID id FROM tb_votes WHERE game_ID = '$game_ID' AND level = '$level' LIMIT $start_from, 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
			$result01 = mysqli_query($link2, $sql01);
			$row01 = mysqli_fetch_array($result01);
			$foto01 = $row01['foto_01'];
			$candidate_elenco_ID_1 = $row01['candidate_elenco_ID'];

			$start_from++;

			$sql02 = "SELECT id candidate_elenco_ID, arquivo foto_02 FROM (SELECT winner_candidate_ID id FROM tb_votes WHERE game_ID = '$game_ID' AND level = '$level' LIMIT $start_from, 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
			$result02 = mysqli_query($link2, $sql02);
			$row02 = mysqli_fetch_array($result02);
			$foto02 = $row02['foto_02'];
			$candidate_elenco_ID_2 = $row02['candidate_elenco_ID'];

			$sql03 = "SELECT COUNT(winner_candidate_ID) AS total FROM tb_votes WHERE game_ID = '$game_ID' AND level = '$level'";
			$result03 = mysqli_query($link2, $sql03);
			$row03 = mysqli_fetch_array($result03);
			$total_records = $row03['total'];

			if ($total_records % 2 == 0) {
				$total_pages = ceil($total_records/$per_page);
				$newpage = $page + 1;
				if ($page <= $total_pages) {
					$write_level = $level - 1;
					echo "<table align='center' border='1'><tr align='center'>
					<td><form id='form01' action='action_select.php' method='post'>
					<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_1' />
					<input type='hidden' name='game_ID' value='$game_ID' />
					<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_2' />
					<input type='hidden' name='write_level' value='$write_level' />
					<input type='hidden' name='max_level' value='$max_level' />
					<input type='hidden' name='view_level' value='$level' />
					<input type='hidden' name='total_pages' value='$total_pages' />
					<input type='hidden' name='vote_time_start' value='$vote_time_start' />
					<input type='hidden' name='page' value='$newpage' />";
					?>
					<a href="javascript: document.getElementById('form01').submit();">
					<?php echo "
					<img src='http://www.magnetoelenco.com.br/fotos/$foto01'>$candidate_elenco_ID_1
					</a></form></td>
					<td><form id='form02' action='action_select.php' method='post'>
					<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_2' />
					<input type='hidden' name='game_ID' value='$game_ID' />
					<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_1' />
					<input type='hidden' name='write_level' value='$write_level' />
					<input type='hidden' name='max_level' value='$max_level' />
					<input type='hidden' name='view_level' value='$level' />
					<input type='hidden' name='total_pages' value='$total_pages' />
					<input type='hidden' name='vote_time_start' value='$vote_time_start' />
					<input type='hidden' name='page' value='$newpage' />";
					?>
					<a href="javascript: document.getElementById('form02').submit();">
					<?php echo "
					<img src='http://www.magnetoelenco.com.br/fotos/$foto02'>$candidate_elenco_ID_2
					</a></form></td></tr></table>";
				}
			}
			else {
				$total_pages = ceil($total_records/$per_page);
				$newpage = $page + 1;
				if ($total_records > 1) {
					if ($page <= $total_pages) {
						$write_level = $level - 1;
						$total_records = $total_records - 1;
						echo "<table align='center' border='1'><tr align='center'>
						<td><form id='form01' action='action_select.php' method='post'>
						<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_1' />
						<input type='hidden' name='game_ID' value='$game_ID' />
						<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_2' />
						<input type='hidden' name='write_level' value='$write_level' />
						<input type='hidden' name='max_level' value='$max_level' />
						<input type='hidden' name='view_level' value='$level' />
						<input type='hidden' name='total_pages' value='$total_pages' />
						<input type='hidden' name='vote_time_start' value='$vote_time_start' />
						<input type='hidden' name='page' value='$newpage' />";
						?>
						<a href="javascript: document.getElementById('form01').submit();">
						<?php echo "
						<img src='http://www.magnetoelenco.com.br/fotos/$foto01'>Total Records: $total_records
						</a></form></td>
						<td><form id='form02' action='action_select.php' method='post'>
						<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_2' />
						<input type='hidden' name='game_ID' value='$game_ID' />
						<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_1' />
						<input type='hidden' name='write_level' value='$write_level' />
						<input type='hidden' name='max_level' value='$max_level' />
						<input type='hidden' name='view_level' value='$level' />
						<input type='hidden' name='total_pages' value='$total_pages' />
						<input type='hidden' name='vote_time_start' value='$vote_time_start' />
						<input type='hidden' name='page' value='$newpage' />";
						?>
						<a href="javascript: document.getElementById('form02').submit();">
						<?php echo "
						<img src='http://www.magnetoelenco.com.br/fotos/$foto02'>Total Records: $total_records
						</a></form></td></tr></table>";
					}
				}
				if ($page <= $total_pages && $total_records == 1) {
					$write_level = $level - 1;
					echo "<table align='center' border='1'><tr align='center'>
					<td><form id='form01' action='action_select.php' method='post'>
					<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_1' />
					<input type='hidden' name='game_ID' value='$game_ID' />
					<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_2' />
					<input type='hidden' name='write_level' value='$write_level' />
					<input type='hidden' name='max_level' value='$max_level' />
					<input type='hidden' name='view_level' value='$level' />
					<input type='hidden' name='total_pages' value='$total_pages' />
					<input type='hidden' name='vote_time_start' value='$vote_time_start' />
					<input type='hidden' name='page' value='$newpage' />";
					?>
					<a href="javascript: document.getElementById('form01').submit();">
					<?php echo "
					<img src='http://www.magnetoelenco.com.br/fotos/$foto01'>$candidate_elenco_ID_1
					</a></form></td>";

					$previous_level = $level + 1;

					$sql02 = "SELECT id candidate_elenco_ID, arquivo foto_02 FROM (SELECT loser_candidate_ID id FROM tb_votes WHERE game_ID = '$game_ID' AND level = '$previous_level' ORDER BY vote_delay DESC LIMIT 1) T1 INNER JOIN (SELECT arquivo, cd_elenco id FROM tb_foto ORDER BY dh_cadastro ASC) T2 USING (id) LIMIT 0, 1";
					$result02 = mysqli_query($link2, $sql02);
					$row02 = mysqli_fetch_array($result02);
					$foto02 = $row02['foto_02'];
					$candidate_elenco_ID_2 = $row02['candidate_elenco_ID'];

					echo "
					<td><form id='form03' action='action_select.php' method='post'>
					<input type='hidden' name='candidate_elenco_ID' value='$candidate_elenco_ID_2' />
					<input type='hidden' name='game_ID' value='$game_ID' />
					<input type='hidden' name='loser_candidate_ID' value='$candidate_elenco_ID_1' />
					<input type='hidden' name='write_level' value='$write_level' />
					<input type='hidden' name='max_level' value='$max_level' />
					<input type='hidden' name='view_level' value='$level' />
					<input type='hidden' name='total_pages' value='$total_pages' />
					<input type='hidden' name='vote_time_start' value='$vote_time_start' />
					<input type='hidden' name='page' value='$newpage' />";
					?>
					<a href="javascript: document.getElementById('form03').submit();">
					<?php echo "
					<img src='http://www.magnetoelenco.com.br/fotos/$foto02'>$candidate_elenco_ID_2
					</a></form></td></tr></table>";
				}
			}
		// Level > 1
		}
	}
	if ($level == 1){
			$sql = "SELECT tb_votes.winner_candidate_ID, tb_elenco.nome_artistico winner_name, tb_foto.arquivo winner_photo FROM tb_votes INNER JOIN tb_elenco ON tb_votes.winner_candidate_ID = tb_elenco.id_elenco INNER JOIN tb_foto ON tb_votes.winner_candidate_ID = tb_foto.cd_elenco WHERE game_ID = '$game_ID' AND level = '1' ORDER BY dh_cadastro ASC LIMIT 0, 1";
			$result = mysqli_query($link2, $sql);
			$row = mysqli_fetch_array($result);
			$winner_name = $row['winner_name'];
			$winner_candidate_ID = $row['winner_candidate_ID'];
			$winner_photo = $row['winner_photo'];
			echo "<table align='center' border='1'>
			<tr align='center'>
			<td>Quem ganhou foi:</td>
			</tr>
			<tr align='center'>
			<td><img src='http://www.magnetoelenco.com.br/fotos/$winner_photo'></td>
			</tr>
			<tr align='center'>
			<td>$winner_name</td>
			</tr></table>";
	}
mysqli_close($link2);
?>
</div>
</body>
</html>
