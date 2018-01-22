<?php
	// Inclui os arquivos de sistema
	include($_SERVER['DOCUMENT_ROOT']."/magnetoelenco/sys/api/Basic.php");
	include($_SERVER['DOCUMENT_ROOT']."/magnetoelenco/sys/api/DataManipulation.php");
	include($_SERVER['DOCUMENT_ROOT']."/magnetoelenco/sys/api/MagnetoElenco.php");

	// Recebe o id do elenco
	$id_elenco = intval($_GET["id_elenco"]);
	if(!isset($id_elenco)){
		header("Location: /magnetoelenco/v2/nao_encontrado.php");
	}

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Definre arrays com as informacoes de contato e caracteristicas fisicas
	$elenco_contato = getInfoContatoExtenso($id_elenco);
	$elenco_fisicas = getCaracteristicasFisicasExtenso($id_elenco);

	// Define arrays com os valores de relacionamentos n:n
	$registros_categoria = getRegistrosRelacionamento("ta_elenco_categoria", "tt_categoria", "categoria", "cd_elenco", $id_elenco);
	$registros_tatuagem = getRegistrosRelacionamento("ta_elenco_tatuagem", "tt_tatuagem", "tatuagem", "cd_elenco", $id_elenco);
	$registros_piercing = getRegistrosRelacionamento("ta_elenco_piercing", "tt_piercing", "piercing", "cd_elenco", $id_elenco);
	$registros_aptidao = getRegistrosRelacionamento("ta_elenco_aptidao", "tt_aptidao", "aptidao", "cd_elenco", $id_elenco);
	$registros_esporte = getRegistrosRelacionamento("ta_elenco_esporte", "tt_esporte", "esporte", "cd_elenco", $id_elenco);
	$registros_danca = getRegistrosRelacionamento("ta_elenco_danca", "tt_danca", "danca", "cd_elenco", $id_elenco);
	$registros_lingua = getRegistrosRelacionamento("ta_elenco_lingua", "tt_lingua", "lingua", "cd_elenco", $id_elenco);
	$registros_sotaque = getRegistrosRelacionamento("ta_elenco_sotaque", "tt_sotaque", "sotaque", "cd_elenco", $id_elenco);
	$registros_instrumento = getRegistrosRelacionamento("ta_elenco_instrumento", "tt_instrumento", "instrumento", "cd_elenco", $id_elenco);
	$arrays_habilidades = array();
	$i = 0;
	if($registros_categoria != NULL){
		$arrays_habilidades[$i][0] = "Categorias";
		$arrays_habilidades[$i][1] = $registros_categoria;
		$i++;
	}
	if($registros_aptidao != NULL){
		$arrays_habilidades[$i][0] = "Aptidões";
		$arrays_habilidades[$i][1] = $registros_aptidao;
		$i++;
	}
	if($registros_esporte != NULL){
		$arrays_habilidades[$i][0] = "Esportes";
		$arrays_habilidades[$i][1] = $registros_esporte;
		$i++;
	}
	if($registros_danca != NULL){
		$arrays_habilidades[$i][0] = "Danças";
		$arrays_habilidades[$i][1] = $registros_danca;
		$i++;
	}
	if($registros_lingua != NULL){
		$arrays_habilidades[$i][0] = "Linguas";
		$arrays_habilidades[$i][1] = $registros_lingua;
		$i++;
	}
	if($registros_sotaque != NULL){
		$arrays_habilidades[$i][0] = "Sotaques";
		$arrays_habilidades[$i][1] = $registros_sotaque;
		$i++;
	}
	if($registros_instrumento != NULL){
		$arrays_habilidades[$i][0] = "Instrumentos";
		$arrays_habilidades[$i][1] = $registros_instrumento;
		$i++;
	}

	// Define arrays com o valor de relacionamentos 1:n
	if($elenco_contato['alergia']){
		$registro_alergia = getRegistrosTabelaAssociativa("tt_alergia", "alergia", "id_alergia", $elenco_contato['cd_alergia']);
		$alergia = "sim, ".$registro_alergia['0'];
	}
	else{
		$alergia = "não";
	}

	if($elenco_contato['fobia']){
		$registro_fobia = getRegistrosTabelaAssociativa("tt_fobia", "fobia", "id_fobia", $elenco_contato['cd_fobia']);
		$fobia = "sim, ".$registro_fobia['0'];
	}
	else{
		$fobia = "não";
	}

	if($elenco_contato['restricao_religiosa']){
		$registro_restricao_religiosa = getRegistrosTabelaAssociativa("tt_restricao_religiosa", "restricao_religiosa", "id_restricao_religiosa", $elenco_contato['cd_restricao_religiosa']);
		$restricao_religiosa = "sim, ".$registro_restricao_religiosa['0'];
	}
	else{
		$restricao_religiosa = "não";
	}

	if($elenco_contato['restricao_alimentar']){
		$registros_restricao_alimentar = getRegistrosTabelaAssociativa("tt_restricao_alimentar", "restricao_alimentar", "id_restricao_alimentar", $elenco_contato['cd_restricao_alimentar']);
		$restricao_alimentar = "sim, ".$registros_restricao_alimentar['0'];
	}
	else{
		$restricao_alimentar = "não";
	}

	// Consulta as fotos do elenco
	$sql_fotos = "select arquivo
				  from tb_foto
				  where cd_elenco = $id_elenco
				  and cd_tipo_foto <> 2
				  order by id_foto
				  limit 6";
	$rs_fotos = mysql_query($sql_fotos);

	$fotos = array();
	$i = 0;
	while($row = mysql_fetch_array($rs_fotos)){
		// Definindo o nome do arquivo de thumb
		$array_arquivo = explode(".", $row['arquivo']);
		if($i == 0){
			$nome_thumb = $array_arquivo[0]."_214x214.".$array_arquivo[1];
		}
		else{
			$nome_thumb = $array_arquivo[0]."_103x103.".$array_arquivo[1];
		}

		$fotos[$i] = $_SERVER['DOCUMENT_ROOT']."/magnetoelenco/pdf/".$nome_thumb;
		$i++;
	}

	// Consulta a qualificacao do elenco
	$sql_qualificacao = "select q.qualificacao, e.exclusivo
						 from tb_elenco as e, tt_qualificacao as q
						 where e.id_elenco = $id_elenco
						 and e.cd_qualificacao = q.id_qualificacao";
	$rs_qualificacao = mysql_query($sql_qualificacao);

	if($row_qualificacao = mysql_fetch_array($rs_qualificacao)){
		$qualificacao = strtoupper($row_qualificacao['qualificacao']);
		$exclusivo    = $row_qualificacao['exclusivo'];

		// Define a qualificacao
		if($exclusivo) $qualificacao .= "+";
	}

	// Inicia a criacao do PDF
	require($_SERVER['DOCUMENT_ROOT']."/magnetoelenco/sys/fpdf/fpdf.php");
	$pdf=new FPDF();
	$pdf->SetTopMargin(4);

	// Cria a PRIMEIRA PAGINA
	$pdf->AddPage('L', 'A4');

	// Cabecalho Logo
	$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/magnetoelenco/v2/img/logo_elenco_300.jpg', 20, NULL, 80, NULL, 'JPG');

	// Cabecalho classificacao do elenco
	$pdf->SetFillColor(159, 43, 6);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetY(5);
	$pdf->SetFont('Helvetica','B',30);
	$pdf->Cell(220, 4, '', 0, 0, 'L');
	$pdf->Cell(30, 18, $qualificacao, 0, 1, 'C', 1);
	$pdf->Ln(4);

	// Fotos do elenco
	$pdf->Image($fotos[0], 20, 35, 75, NULL, 'JPG');
	$pdf->Image($fotos[1], 100, 35, 35, NULL, 'JPG');
	$pdf->Image($fotos[2], 100, 75, 35, NULL, 'JPG');
	$pdf->Image($fotos[3], 20, 118, 35, NULL, 'JPG');
	$pdf->Image($fotos[4], 60, 118, 35, NULL, 'JPG');
	$pdf->Image($fotos[5], 100, 118, 35, NULL, 'JPG');

	// Bordas das fotos
	$pdf->SetDrawColor(103, 108, 134);
	$pdf->SetLineWidth(0.1);
	$pdf->Line(20, 34.8, 95, 34.8);
	$pdf->Line(20, 34.8, 20, 109.8);
	$pdf->Line(20, 109.8, 95, 109.8);
	$pdf->Line(95, 34.8, 95, 109.8);

	$pdf->Line(100.1, 34.8, 135.1, 34.8);
	$pdf->Line(100.1, 34.8, 100.1, 70);
	$pdf->Line(135.1, 34.8, 135.1, 70);
	$pdf->Line(100.1, 70, 135.1, 70);

	$pdf->Line(100.1, 74.8, 135.1, 74.8);
	$pdf->Line(100.1, 74.8, 100.1, 110);
	$pdf->Line(135.1, 74.8, 135.1, 110);
	$pdf->Line(100.1, 110, 135.1, 110);

	$pdf->Line(100.1, 117.8, 135.1, 117.8);
	$pdf->Line(100.1, 117.8, 100.1, 153);
	$pdf->Line(135.1, 117.8, 135.1, 153);
	$pdf->Line(100.1, 153, 135.1, 153);

	$pdf->Line(20.1, 117.8, 55.1, 117.8);
	$pdf->Line(20.1, 117.8, 20.1, 153);
	$pdf->Line(55.1, 117.8, 55.1, 153);
	$pdf->Line(20.1, 153, 55.1, 153);

	$pdf->Line(60.1, 117.8, 95.1, 117.8);
	$pdf->Line(60.1, 117.8, 60.1, 153);
	$pdf->Line(95.1, 117.8, 95.1, 153);
	$pdf->Line(60.1, 153, 95.1, 153);

	// Nome artistico e dados pessoais
	$pdf->Ln(12);
	$pdf->SetTextColor(159, 43, 6);
	$pdf->SetFont('Helvetica','B',30);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(0, 11, $elenco_contato['nome_artistico'], 0, 1, 'L');

	$pdf->SetTextColor(103, 108, 134);
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(11, 4, 'Cidade:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, $elenco_contato['cidade'], 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(12, 4, 'Casting:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, getCasting($id_elenco), 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(42, 4, 'Melhor(es) dia(s) para trabalhos:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, $elenco_contato['melhor_dia'], 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(49, 4, 'Melhor(es) horários(s) para trabalhos:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, $elenco_contato['melhor_horario'], 0, 1, 'L');

	$pdf->Ln(6);

	// Caracteristicas fisicas e restricoes
	$pdf->SetTextColor(159, 43, 6);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(44, 4, 'Características físicas:', 0, 0, 'L');
	$pdf->Cell(0, 4, 'Restrições:', 0, 1, 'L');

	$pdf->SetTextColor(103, 108, 134);
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(9, 4, 'Idade:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(35, 4, $elenco_contato['idade'].' anos', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(37, 4, 'Aceita cortar/pintar o cabelo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, printSimNao($elenco_contato['producao_cabelo']), 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(9, 4, 'Altura:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(35, 4, number_format($elenco_fisicas['altura'], 2, ",", ".").' m', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(11, 4, 'Alergia:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, $alergia, 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(9, 4, 'Peso:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(35, 4, $elenco_fisicas['peso'], 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(9, 4, 'Fobia:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, $fobia, 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(15, 4, 'Tipo físico:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(29, 4, $elenco_fisicas['tipo_fisico'], 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(25, 4, 'Restrição religiosa:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, $restricao_religiosa, 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(8, 4, 'Pele:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(36, 4, $elenco_fisicas['pele'], 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Habilidades:', 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(9, 4, 'Olhos:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(35, 4, $elenco_fisicas['olho'], 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$contador_habilidades = 0;
	if($contador_habilidades < sizeof($arrays_habilidades)){
		$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
		$contador_habilidades++;
	}
	else{
		$pdf->Cell(0, 4, '', 0, 1, 'L');
	}

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(11, 4, 'Cabelo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(33, 4, $elenco_fisicas['cabelo'], 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	if($contador_habilidades < sizeof($arrays_habilidades)){
		$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
		$contador_habilidades++;
	}
	else{
		$pdf->Cell(0, 4, '', 0, 1, 'L');
	}

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(20, 4, 'Cor do cabelo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(24, 4, $elenco_fisicas['cor_cabelo'], 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	if($contador_habilidades < sizeof($arrays_habilidades)){
		$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
		$contador_habilidades++;
	}
	else{
		$pdf->Cell(0, 4, '', 0, 1, 'L');
	}

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(24, 4, 'Compr. do cabelo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(20, 4, $elenco_fisicas['comprimento_cabelo'], 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	if($contador_habilidades < sizeof($arrays_habilidades)){
		$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
		$contador_habilidades++;
	}
	else{
		$pdf->Cell(0, 4, '', 0, 1, 'L');
	}

	if($elenco_contato['sexo'] == 'F'){
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(130, 4, '', 0, 0, 'L');
		$pdf->Cell(9, 4, 'Busto:', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(35, 4, $elenco_fisicas['busto'], 0, 0, 'L');
		$pdf->SetFont('Helvetica','',8);
		if($contador_habilidades < sizeof($arrays_habilidades)){
			$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
			$pdf->SetFont('Helvetica','B',8);
			$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
			$contador_habilidades++;
		}
		else{
			$pdf->Cell(0, 4, '', 0, 1, 'L');
		}

		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(130, 4, '', 0, 0, 'L');
		$pdf->Cell(11, 4, 'Cintura:', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(33, 4, $elenco_fisicas['cintura'], 0, 0, 'L');
		$pdf->SetFont('Helvetica','',8);
		if($contador_habilidades < sizeof($arrays_habilidades)){
			$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
			$pdf->SetFont('Helvetica','B',8);
			$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
			$contador_habilidades++;
		}
		else{
			$pdf->Cell(0, 4, '', 0, 1, 'L');
		}

		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(130, 4, '', 0, 0, 'L');
		$pdf->Cell(11, 4, 'Quadril:', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(33, 4, $elenco_fisicas['quadril'], 0, 0, 'L');
		$pdf->SetFont('Helvetica','',8);
		if($contador_habilidades < sizeof($arrays_habilidades)){
			$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
			$pdf->SetFont('Helvetica','B',8);
			$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
			$contador_habilidades++;
		}
		else{
			$pdf->Cell(0, 4, '', 0, 1, 'L');
		}
	}
	else{
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(130, 4, '', 0, 0, 'L');
		$pdf->Cell(12, 4, 'Camisa:', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(32, 4, '4'.$elenco_fisicas['camisa'], 0, 0, 'L');
		$pdf->SetFont('Helvetica','',8);
		if($contador_habilidades < sizeof($arrays_habilidades)){
			$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
			$pdf->SetFont('Helvetica','B',8);
			$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
			$contador_habilidades++;
		}
		else{
			$pdf->Cell(0, 4, '', 0, 1, 'L');
		}

		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(130, 4, '', 0, 0, 'L');
		$pdf->Cell(9, 4, 'Terno:', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(35, 4, '33'.$elenco_fisicas['terno'], 0, 0, 'L');
		$pdf->SetFont('Helvetica','',8);
		if($contador_habilidades < sizeof($arrays_habilidades)){
			$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
			$pdf->SetFont('Helvetica','B',8);
			$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
			$contador_habilidades++;
		}
		else{
			$pdf->Cell(0, 4, '', 0, 1, 'L');
		}
	}

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(15, 4, 'Manequim:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(29, 4, $elenco_fisicas['manequim'], 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	if($contador_habilidades < sizeof($arrays_habilidades)){
		$pdf->Cell(15, 4, $arrays_habilidades[$contador_habilidades][0].':', 0, 0, 'L');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0, 4, arrayParaStringComSeparador($arrays_habilidades[$contador_habilidades][1], ",", "não"), 0, 1, 'L');
		$contador_habilidades++;
	}
	else{
		$pdf->Cell(0, 4, '', 0, 1, 'L');
	}

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(11, 4, 'Sapato:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, $elenco_fisicas['sapato'], 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(15, 4, 'Tatuagem:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, arrayParaStringComSeparador($registros_tatuagem, ",", "não"), 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(12, 4, 'Piercing:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, arrayParaStringComSeparador($registros_piercing, ",", "não"), 0, 1, 'L');

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(130, 4, '', 0, 0, 'L');
	$pdf->Cell(28, 4, 'Aparelho nos dentes:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, printSimNao($elenco_contato['aparelho']), 0, 1, 'L');

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	// Printa o pdf
	$pdf->Output("Magneto_Elenco_".$elenco_contato['nome_artistico'].".pdf", "I");
?>
