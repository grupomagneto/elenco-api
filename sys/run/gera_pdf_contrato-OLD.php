<?php
	// Inclui os arquivos de sistema
	include($_SERVER['DOCUMENT_ROOT']."/admin/includes/valida_acesso_adm.php");	
	include($_SERVER['DOCUMENT_ROOT']."/sys/api/Basic.php");
	include($_SERVER['DOCUMENT_ROOT']."/sys/api/DataManipulation.php");
	include($_SERVER['DOCUMENT_ROOT']."/sys/api/MagnetoElenco.php");	
	
	// Recebe o id do elenco e a data de assinatura
	$id_elenco     = intval($_GET["id_elenco"]);
	$dt_impressao = $_GET['dt_impressao'];
	if($dt_impressao == "") $dt_impressao = date("d/m/Y");
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao que define os detalhes do elenco
	if($id_elenco != ""){
		$elenco_contato = getInfoContato($id_elenco);
	}
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);		

	// Inicia a criacao do PDF
	require($_SERVER['DOCUMENT_ROOT']."/sys/fpdf/fpdf.php");
	$pdf=new FPDF();
	$pdf->SetTopMargin(4);
	
	// Cria a PRIMEIRA PAGINA do contrato
	$pdf->AddPage();
	
	// Logo
	$pdf->Image('logo_elenco.jpg', 75, NULL, 50, NULL, 'JPG');
	$pdf->Ln(2);
	
	// Cabecalho
	$pdf->SetFont('Helvetica','B',10);
	$pdf->Cell(0, 4, 'INSTRUMENTO PARTICULAR DE PRESTAÇÃO DE SERVIÇOS DE AGENCIAMENTO,', 0, 1, 'C');
	$pdf->Cell(0, 4, 'INTERMEDIAÇÃO, REPRESENTAÇÃO E LICENÇA DE USO DE IMAGEM', 0, 1, 'C');
	$pdf->Ln(4);
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Pelo presente instrumento particular de contrato as partes', 0, 1, 'L');
	$pdf->Ln(4);	
	
	// Dados contratante
	$endereco_contratante = $elenco_contato['endereco'] ." ". $elenco_contato['cidade'] ." ". $elenco_contato['uf'];
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(60, 4, 'CONTRATANTE:', 0, 0, 'R');	
	$pdf->Cell(0, 4, mb_strtoupper($elenco_contato['nome'], "iso-8859-1"), 0, 1, 'L');
	$pdf->Cell(60, 4, 'REPRESENTANTE LEGAL (SE MENOR):', 0, 0, 'R');	
	$pdf->Cell(0, 4, mb_strtoupper($elenco_contato['nome_responsavel'], "iso-8859-1"), 0, 1, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(60, 4, 'CPF (SE MENOR, DO REPRESENTANTE):', 0, 0, 'R');	
	$pdf->Cell(0, 4, mb_strtoupper($elenco_contato['cpf'], "iso-8859-1"), 0, 1, 'L');
	$pdf->Cell(60, 4, 'ENDEREÇO:', 0, 0, 'R');	
	$pdf->Cell(0, 4, mb_strtoupper($endereco_contratante, "iso-8859-1"), 0, 1, 'L');
	$pdf->Ln(4);
	
	// Dados contratada
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(60, 4, 'CONTRATADA:', 0, 0, 'R');	
	$pdf->Cell(0, 4, 'MAG PRODUÇÕES ARTÍSTICAS E FOTOGRÁFICAS LTDA.', 0, 1, 'L');
	$pdf->SetFont('Helvetica','',8);	
	$pdf->Cell(60, 4, 'CNPJ:', 0, 0, 'R');	
	$pdf->Cell(0, 4, '10.880.184/0001-85', 0, 1, 'L');
	$pdf->Cell(60, 4, 'CF/DF:', 0, 0, 'R');	
	$pdf->Cell(0, 4, '07.522.086/001-99', 0, 1, 'L');
	$pdf->Cell(60, 4, 'ENDEREÇO:', 0, 0, 'R');	
	$pdf->Cell(0, 4, 'SHIN CA 02 LOTE A BLOCO A LOJA 01 - LAGO NORTE - BRASÍLIA - DF - 71.503-502', 0, 1, 'L');
	$pdf->Cell(60, 4, 'REPRESENTANTE LEGAL:', 0, 0, 'R');	
	$pdf->Cell(60, 4, 'ANELISE CATUNDA DE CLODOALDO PINTO', 0, 0, 'L');
	$pdf->Cell(10, 4, 'CPF:', 0, 0, 'R');	
	$pdf->Cell(0, 4, '022.808.181-59', 0, 1, 'L');	
	$pdf->Ln(4);
	
	// Chamada clausulas
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Têm justas e contratadas as seguintes cláusulas:', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 1 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 1ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(70, 4, 'O presente contrato tem como objeto a prestação, pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'dos serviços de divulgação e intermediação de contratação', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'junto às produtoras de cinema e TV, agências de publicidade, estúdios de fotografia, emissoras de televisão e similares, em todo', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'território nacional e no exterior, sem responsabilidade de conseguir trabalhos ou serviços, comprometendo-se, exclusivamente, a representar o', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'e promover sua divulgação e veiculação junto aos mercados citados, sendo responsável pela divulgação e comercialização de sua', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'imagem.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 2 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 2ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'O', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'não está obrigado a aceitar os serviços que lhe forem oferecidos, obrigando-se, entretanto, a manter sua ficha', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'cadastral sempre atualizada, sob pena das sanções previstas no Contrato, bem como a comparecer a novas sessões de fotografias, sempre que', 0, 1, 'L');
	
	$pdf->Cell(0, 4, 'convocado, a título de atualização de seu material, sem custos adicionais.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 3 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 3ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'A', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(57, 4, 'tem o direito de intermediar a contratação do', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'podendo representá-lo na contratação perante', 0, 1, 'L');	
	
	$pdf->Cell(101, 4, 'terceiros e receber a remuneração devida, repassando-a posteriormente para o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'na forma estipulada no Contrato.', 0, 1, 'L');	
	$pdf->Ln(4);

	// Clausula 4 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 4ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'O', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(10, 4, 'cede a', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'os direitos e o uso de sua imagem e expressões artísticas pelo tempo de duração do', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'Contrato, no território nacional ou fora dele, em qualquer meio de comunicação, reconhecendo que a imagem e seus direitos de exploração também', 0, 1, 'L');
	
	$pdf->Cell(74, 4, 'serão utilizados em meio virtual, principalmente no site da', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);	
	$pdf->Cell(68, 4, 'reconhecendo ainda ser da exclusiva propriedade da', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(69, 4, 'o material obtido nas sessões de fotografia e vídeo do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATANTE.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Parágrafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'A', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(21, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(63, 4, 'poderá comercializar o material fotográfico com o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'ou com terceiros.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 5 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 5ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'O', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'dispensa a citação de seu nome ou crédito autoral na divulgação das obras fotográficas cujos direitos são por ele', 0, 1, 'L');			
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(53, 4, 'aqui cedidos, não se responsabilizando a', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(21, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(87, 4, 'pela captação ou uso indevido de imagem por terceiros com quem a', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);	
	$pdf->Cell(21, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'não', 0, 1, 'L');			
	
	$pdf->Cell(0, 4, 'negociou.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 6 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 6ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(67, 4, 'A título de remuneração dos serviços prestados pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'e na hipótese de estipulada a “exclusividade” prevista na', 0, 1, 'L');		

	$pdf->Cell(170, 4, 'Cláusula 8ª, um percentual de 20% (vinte por cento) será adicionado sobre cada cachê resultante de qualquer trabalho executado pelo', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATANTE,', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(21, 4, 'permitindo-se à', 0, 0, 'L');			
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(72, 4, 'desde logo a retenção desse percentual, e o repasse ao', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'do valor de 80% (oitenta por cento) do', 0, 1, 'L');		
				
	$pdf->Cell(0, 4, 'montante líquido de cada cachê. Por montante líquido entende-se o valor do cachê após pagos os impostos e feitas as deduções legais na nota fiscal', 0, 1, 'L');		
	
	$pdf->Cell(0, 4, 'de serviço.', 0, 1, 'L');	
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Parágrafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(10, 4, 'Caso o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'opte pela “não-exclusividade” prevista na Cláusula 8ª, o percentual adicionado sobre a remuneração', 0, 1, 'L');
	
	$pdf->Cell(42, 4, 'de trabalhos intermediados pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'será de 30% (trinta por cento) sobre o montante líquido de cada cachê.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Parágrafo segundo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Existindo a necessidade de “refação” das imagens, por qualquer impropriedade ou imperfeição das fotos/vídeos, compromete-se o', 0, 1, 'L');	
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'a participar de nova sessão de trabalhos, fazendo jus à remuneração correspondente, com um adicional de 30% (trinta por cento) do', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'cachê líquido original.', 0, 1, 'L');	
	$pdf->Ln(4);		

 	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(26, 4, 'Parágrafo terceiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(143, 4, 'Para o caso de “reutilização” das imagens em nova contratação/campanha publicitária, a remuneração devida ao', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATANTE', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'será a de 70% (setenta por cento) do cachê líquido original.', 0, 1, 'L');	
	$pdf->Ln(4);
	
	// Clausula 7 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 7ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(41, 4, 'Apenas no primeiro trabalho do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(32, 4, 'obtido/intermediado pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'será realizado um desconto, desde que', 0, 1, 'L');		
	
	$pdf->Cell(0, 4, 'estipulada a “exclusividade” prevista na Cláusula 8ª, de 50% (cinqüenta por cento) sobre o valor líquido do cachê, como forma do pagamento e reembolso', 0, 1, 'L');
	
	$pdf->Cell(93, 4, 'dos gastos com sessão de fotos e vídeo, feitos sem custos iniciais para o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'sem prejuízo do estabelecido na Cláusula 6ª.', 0, 1, 'L');
	$pdf->Ln(5);
	
	// Rodape da primeira pagina
	$pdf->SetFont('Helvetica','',6);
	$pdf->Cell(0, 3, 'SHIN CA 02 Lote A Bloco A Loja 01 - Lago Norte - Brasília - DF - 71.503-502 – (61) 3201-7670', 0, 1, 'C');	
	$pdf->Cell(0, 3, 'www.magnetoelenco.com.br - elenco@grupomagneto.com.br', 0, 1, 'C');	


	// Cria a SEGUNDA PAGINA do contrato
	$pdf->AddPage();
	
	// Logo
	$pdf->Image('logo_elenco.jpg', 75, NULL, 50, NULL, 'JPG');
	$pdf->Ln(2);
	
	// Clausula 7 (continuacao)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Parágrafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Para o caso de escolha da “não-exclusividade” prevista na Cláusula 8ª, será realizado o desconto de 70% (setenta por cento)', 0, 1, 'L');	

	$pdf->Cell(69, 4, 'sobre o valor líquido do cachê do primeiro trabalho do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(24, 4, 'intermediado pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'sem prejuízo do estabelecido na', 0, 1, 'L');
	$pdf->Cell(0, 4, 'Cláusula 6ª.', 0, 1, 'L');
	$pdf->Ln(4);	

	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Parágrafo segundo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'As hipóteses de desconto do cachê do primeiro trabalho prevista nas cláusulas acima não se aplicam para os trabalhos de', 0, 1, 'L');
	$pdf->Cell(0, 4, 'figuração e recepção.', 0, 1, 'L');
	$pdf->Ln(4);	

	// Clausula 8 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 8ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Fica estabelecido que todas as cláusulas do Contrato serão regidas por uma relação de:', 0, 1, 'L');
	
	$pdf->Cell(49, 4, '(  ) exclusividade no agenciamento do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(6, 4, 'pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'inclusive para trabalhos no exterior;', 0, 1, 'L');
	
	$pdf->Cell(54, 4, '(  ) não-exclusividade no agenciamento do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(6, 4, 'pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATADA;', 0, 1, 'L');	
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Parágrafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(132, 4, 'Na hipótese de estipulada a cláusula de exclusividade, e caso haja descumprimento dela, sujeitar-se-á o', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATANTE', 0, 1, 'L');	

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'ao pagamento de multa no valor de R$ 1.000,00 (mil reais), acrescidos de correção monetária e juros moratórios de 1% ao mês desde a data da', 0, 1, 'L');	

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'constatação do prejuízo até o dia do pagamento, como forma de reparação mínima.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Parágrafo segundo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(90, 4, 'Na hipótese de estipulada a cláusula de não-exclusividade, obriga-se o', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'em até 24h depois da execução de', 0, 1, 'L');	
			
	$pdf->Cell(39, 4, 'serviço não intermediado pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'a informar a esta, por fax, carta ou e-mail, as circunstâncias do trabalho prestado, possibilitando a', 0, 1, 'L');	
		
	$pdf->Cell(0, 4, 'análise de eventual frustração da execução deste Contrato ou prejuízos, sob pena das sanções previstas no Contrato.', 0, 1, 'L');
	$pdf->Ln(4);
		
	// Clausula 9 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 9ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(15, 4, 'Envidará a', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'os melhores esforços para obter o pagamento do "Cachê Teste", no valor de R$ 30,00 (trinta reais),', 0, 1, 'L');
	
	$pdf->Cell(19, 4, 'sempre que o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'participar de testes ou seleções, aqui não incluídas sessões de fotografias e vídeo com intuito de atualização de', 0, 1, 'L');
	
	$pdf->Cell(0, 4, 'cadastro.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 10 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 10ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'O Contrato tem prazo de duração de 24 (vinte e quatro) meses, contados da assinatura do instrumento. Possível a prorrogação', 0, 1, 'L');	
	
	$pdf->Cell(0, 4, 'do Contrato por vezes indeterminadas após o término do prazo aqui estipulado, desde que exista manifestação das partes nesse sentido.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Parágrafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(133, 4, 'Durante a vigência do Contrato e caso estipulada a “exclusividade” prevista na Cláusula 8ª, não poderá o', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(48, 4, 'contratar outro agenciador que não a', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATADA.', 0, 1, 'L');
	$pdf->Ln(4);		
	
	// Clausula 11 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 11ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'O vínculo contratual não poderá ser rescindido sem motivo relevante. Se uma das partes der ensejo ao rompimento do vínculo', 0, 1, 'L');	
	
	$pdf->Cell(0, 4, 'sem motivo relevante, deverá arcar com multa no valor de R$ 1.000,00 (mil reais), além de indenização por eventuais perdas e danos.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 12 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 12ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(12, 4, 'Sendo o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'incapaz seu representante/assistente, com a assinatura de interveniência no cabeçalho deste instrumento,', 0, 1, 'L');	
	
	$pdf->Cell(0, 4, 'anui e concorda expressamente com os termos do contrato, podendo se fazer presente em todas as sessões de fotografia filmagem do agenciado, tudo', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'conforme os preceitos da Lei n. 8.069/90 (“Estatuto da Criança e do Adolescente”).', 0, 1, 'L');
	$pdf->Ln(4);


	// Clausula 13 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CLÁUSULA 13ª:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Para dirimir quaisquer controvérsias decorrentes deste Contrato as partes elegem como competente o foro da Circunscrição', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'Judiciária de Brasília, Distrito Federal.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Consideracoes finais e data
	$pdf->Cell(0, 4, 'E por estarem assim justas e contratadas as partes firmam o presente instrumento, em duas vias de igual teor.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$meses = array("janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
	$stamp_impressao = strtotime(formataDataBanco($dt_impressao));
	$data_emissao = date("d", $stamp_impressao) ." de ". $meses[(date("m", $stamp_impressao) - 1)] ." de ". date("Y", $stamp_impressao); 
	$pdf->Cell(0, 4, 'Brasília, '.$data_emissao, 0, 1, 'L');
	$pdf->Ln(11);	
	
	// Campos para assinatura
	$pdf->Line(20, 196, 190, 196);
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(60, 4, 'CONTRATANTE', 0, 0, 'R');
	$pdf->Cell(90, 4, 'CONTRATADA', 0, 1, 'R');
	
	$pdf->SetFont('Helvetica','B',6);
	$pdf->Cell(70, 4, '(Se menor, assinatura do representante)', 0, 1, 'R');
	$pdf->Ln(6);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'Testemunhas:', 0, 1, 'L');
	$pdf->Line(20, 222, 190, 222);
	$pdf->Ln(10);
	$pdf->SetFont('Helvetica','B',6);
	$pdf->Cell(30, 4, 'Nome:', 0, 0, 'R');
	$pdf->Cell(84, 4, 'Nome:', 0, 1, 'R');
	$pdf->Cell(30, 4, 'RG:', 0, 0, 'R');
	$pdf->Cell(84, 4, 'RG:', 0, 1, 'R');
	$pdf->Line(40, 232, 110, 232);
	$pdf->Line(40, 228, 110, 228);
	
	$pdf->Line(125, 232, 190, 232);
	$pdf->Line(125, 228, 190, 228);		
	
	// Rodape da segunda pagina
	$pdf->Ln(34);
	$pdf->SetFont('Helvetica','',6);
	$pdf->Cell(0, 3, 'SHIN CA 02 Lote A Bloco A Loja 01 - Lago Norte - Brasília - DF - 71.503-502 – (61) 3201-7670', 0, 1, 'C');	
	$pdf->Cell(0, 3, 'www.magnetoelenco.com.br - elenco@grupomagneto.com.br', 0, 1, 'C');	

	// Printa o pdf
	$pdf->Output("contrato_$id_elenco.pdf", "I");	
?>