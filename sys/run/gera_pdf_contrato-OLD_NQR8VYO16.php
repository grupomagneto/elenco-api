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
	$pdf->Cell(0, 4, 'INSTRUMENTO PARTICULAR DE PRESTA��O DE SERVI�OS DE AGENCIAMENTO,', 0, 1, 'C');
	$pdf->Cell(0, 4, 'INTERMEDIA��O, REPRESENTA��O E LICEN�A DE USO DE IMAGEM', 0, 1, 'C');
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
	$pdf->Cell(60, 4, 'ENDERE�O:', 0, 0, 'R');	
	$pdf->Cell(0, 4, mb_strtoupper($endereco_contratante, "iso-8859-1"), 0, 1, 'L');
	$pdf->Ln(4);
	
	// Dados contratada
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(60, 4, 'CONTRATADA:', 0, 0, 'R');	
	$pdf->Cell(0, 4, 'MAG PRODU��ES ART�STICAS E FOTOGR�FICAS LTDA.', 0, 1, 'L');
	$pdf->SetFont('Helvetica','',8);	
	$pdf->Cell(60, 4, 'CNPJ:', 0, 0, 'R');	
	$pdf->Cell(0, 4, '10.880.184/0001-85', 0, 1, 'L');
	$pdf->Cell(60, 4, 'CF/DF:', 0, 0, 'R');	
	$pdf->Cell(0, 4, '07.522.086/001-99', 0, 1, 'L');
	$pdf->Cell(60, 4, 'ENDERE�O:', 0, 0, 'R');	
	$pdf->Cell(0, 4, 'SHIN CA 02 LOTE A BLOCO A LOJA 01 - LAGO NORTE - BRAS�LIA - DF - 71.503-502', 0, 1, 'L');
	$pdf->Cell(60, 4, 'REPRESENTANTE LEGAL:', 0, 0, 'R');	
	$pdf->Cell(60, 4, 'ANELISE CATUNDA DE CLODOALDO PINTO', 0, 0, 'L');
	$pdf->Cell(10, 4, 'CPF:', 0, 0, 'R');	
	$pdf->Cell(0, 4, '022.808.181-59', 0, 1, 'L');	
	$pdf->Ln(4);
	
	// Chamada clausulas
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'T�m justas e contratadas as seguintes cl�usulas:', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 1 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 1�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(70, 4, 'O presente contrato tem como objeto a presta��o, pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'dos servi�os de divulga��o e intermedia��o de contrata��o', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'junto �s produtoras de cinema e TV, ag�ncias de publicidade, est�dios de fotografia, emissoras de televis�o e similares, em todo', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'territ�rio nacional e no exterior, sem responsabilidade de conseguir trabalhos ou servi�os, comprometendo-se, exclusivamente, a representar o', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'e promover sua divulga��o e veicula��o junto aos mercados citados, sendo respons�vel pela divulga��o e comercializa��o de sua', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'imagem.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 2 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 2�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'O', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'n�o est� obrigado a aceitar os servi�os que lhe forem oferecidos, obrigando-se, entretanto, a manter sua ficha', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'cadastral sempre atualizada, sob pena das san��es previstas no Contrato, bem como a comparecer a novas sess�es de fotografias, sempre que', 0, 1, 'L');
	
	$pdf->Cell(0, 4, 'convocado, a t�tulo de atualiza��o de seu material, sem custos adicionais.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 3 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 3�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'A', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(57, 4, 'tem o direito de intermediar a contrata��o do', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'podendo represent�-lo na contrata��o perante', 0, 1, 'L');	
	
	$pdf->Cell(101, 4, 'terceiros e receber a remunera��o devida, repassando-a posteriormente para o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'na forma estipulada no Contrato.', 0, 1, 'L');	
	$pdf->Ln(4);

	// Clausula 4 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 4�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'O', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(10, 4, 'cede a', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'os direitos e o uso de sua imagem e express�es art�sticas pelo tempo de dura��o do', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'Contrato, no territ�rio nacional ou fora dele, em qualquer meio de comunica��o, reconhecendo que a imagem e seus direitos de explora��o tamb�m', 0, 1, 'L');
	
	$pdf->Cell(74, 4, 'ser�o utilizados em meio virtual, principalmente no site da', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);	
	$pdf->Cell(68, 4, 'reconhecendo ainda ser da exclusiva propriedade da', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(69, 4, 'o material obtido nas sess�es de fotografia e v�deo do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATANTE.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Par�grafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'A', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(21, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(63, 4, 'poder� comercializar o material fotogr�fico com o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'ou com terceiros.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 5 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 5�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(3, 4, 'O', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'dispensa a cita��o de seu nome ou cr�dito autoral na divulga��o das obras fotogr�ficas cujos direitos s�o por ele', 0, 1, 'L');			
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(53, 4, 'aqui cedidos, n�o se responsabilizando a', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(21, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(87, 4, 'pela capta��o ou uso indevido de imagem por terceiros com quem a', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);	
	$pdf->Cell(21, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'n�o', 0, 1, 'L');			
	
	$pdf->Cell(0, 4, 'negociou.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 6 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 6�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(67, 4, 'A t�tulo de remunera��o dos servi�os prestados pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'e na hip�tese de estipulada a �exclusividade� prevista na', 0, 1, 'L');		

	$pdf->Cell(170, 4, 'Cl�usula 8�, um percentual de 20% (vinte por cento) ser� adicionado sobre cada cach� resultante de qualquer trabalho executado pelo', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATANTE,', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(21, 4, 'permitindo-se �', 0, 0, 'L');			
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(72, 4, 'desde logo a reten��o desse percentual, e o repasse ao', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'do valor de 80% (oitenta por cento) do', 0, 1, 'L');		
				
	$pdf->Cell(0, 4, 'montante l�quido de cada cach�. Por montante l�quido entende-se o valor do cach� ap�s pagos os impostos e feitas as dedu��es legais na nota fiscal', 0, 1, 'L');		
	
	$pdf->Cell(0, 4, 'de servi�o.', 0, 1, 'L');	
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Par�grafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(10, 4, 'Caso o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'opte pela �n�o-exclusividade� prevista na Cl�usula 8�, o percentual adicionado sobre a remunera��o', 0, 1, 'L');
	
	$pdf->Cell(42, 4, 'de trabalhos intermediados pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'ser� de 30% (trinta por cento) sobre o montante l�quido de cada cach�.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Par�grafo segundo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Existindo a necessidade de �refa��o� das imagens, por qualquer impropriedade ou imperfei��o das fotos/v�deos, compromete-se o', 0, 1, 'L');	
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'a participar de nova sess�o de trabalhos, fazendo jus � remunera��o correspondente, com um adicional de 30% (trinta por cento) do', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'cach� l�quido original.', 0, 1, 'L');	
	$pdf->Ln(4);		

 	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(26, 4, 'Par�grafo terceiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(143, 4, 'Para o caso de �reutiliza��o� das imagens em nova contrata��o/campanha publicit�ria, a remunera��o devida ao', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATANTE', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'ser� a de 70% (setenta por cento) do cach� l�quido original.', 0, 1, 'L');	
	$pdf->Ln(4);
	
	// Clausula 7 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 7�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(41, 4, 'Apenas no primeiro trabalho do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(32, 4, 'obtido/intermediado pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'ser� realizado um desconto, desde que', 0, 1, 'L');		
	
	$pdf->Cell(0, 4, 'estipulada a �exclusividade� prevista na Cl�usula 8�, de 50% (cinq�enta por cento) sobre o valor l�quido do cach�, como forma do pagamento e reembolso', 0, 1, 'L');
	
	$pdf->Cell(93, 4, 'dos gastos com sess�o de fotos e v�deo, feitos sem custos iniciais para o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'sem preju�zo do estabelecido na Cl�usula 6�.', 0, 1, 'L');
	$pdf->Ln(5);
	
	// Rodape da primeira pagina
	$pdf->SetFont('Helvetica','',6);
	$pdf->Cell(0, 3, 'SHIN CA 02 Lote A Bloco A Loja 01 - Lago Norte - Bras�lia - DF - 71.503-502 � (61) 3201-7670', 0, 1, 'C');	
	$pdf->Cell(0, 3, 'www.magnetoelenco.com.br - elenco@grupomagneto.com.br', 0, 1, 'C');	


	// Cria a SEGUNDA PAGINA do contrato
	$pdf->AddPage();
	
	// Logo
	$pdf->Image('logo_elenco.jpg', 75, NULL, 50, NULL, 'JPG');
	$pdf->Ln(2);
	
	// Clausula 7 (continuacao)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Par�grafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Para o caso de escolha da �n�o-exclusividade� prevista na Cl�usula 8�, ser� realizado o desconto de 70% (setenta por cento)', 0, 1, 'L');	

	$pdf->Cell(69, 4, 'sobre o valor l�quido do cach� do primeiro trabalho do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(24, 4, 'intermediado pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'sem preju�zo do estabelecido na', 0, 1, 'L');
	$pdf->Cell(0, 4, 'Cl�usula 6�.', 0, 1, 'L');
	$pdf->Ln(4);	

	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Par�grafo segundo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'As hip�teses de desconto do cach� do primeiro trabalho prevista nas cl�usulas acima n�o se aplicam para os trabalhos de', 0, 1, 'L');
	$pdf->Cell(0, 4, 'figura��o e recep��o.', 0, 1, 'L');
	$pdf->Ln(4);	

	// Clausula 8 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 8�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Fica estabelecido que todas as cl�usulas do Contrato ser�o regidas por uma rela��o de:', 0, 1, 'L');
	
	$pdf->Cell(49, 4, '(  ) exclusividade no agenciamento do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(6, 4, 'pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'inclusive para trabalhos no exterior;', 0, 1, 'L');
	
	$pdf->Cell(54, 4, '(  ) n�o-exclusividade no agenciamento do', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(6, 4, 'pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATADA;', 0, 1, 'L');	
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Par�grafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(132, 4, 'Na hip�tese de estipulada a cl�usula de exclusividade, e caso haja descumprimento dela, sujeitar-se-� o', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATANTE', 0, 1, 'L');	

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'ao pagamento de multa no valor de R$ 1.000,00 (mil reais), acrescidos de corre��o monet�ria e juros morat�rios de 1% ao m�s desde a data da', 0, 1, 'L');	

	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'constata��o do preju�zo at� o dia do pagamento, como forma de repara��o m�nima.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Par�grafo segundo:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(90, 4, 'Na hip�tese de estipulada a cl�usula de n�o-exclusividade, obriga-se o', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE,', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'em at� 24h depois da execu��o de', 0, 1, 'L');	
			
	$pdf->Cell(39, 4, 'servi�o n�o intermediado pela', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'a informar a esta, por fax, carta ou e-mail, as circunst�ncias do trabalho prestado, possibilitando a', 0, 1, 'L');	
		
	$pdf->Cell(0, 4, 'an�lise de eventual frustra��o da execu��o deste Contrato ou preju�zos, sob pena das san��es previstas no Contrato.', 0, 1, 'L');
	$pdf->Ln(4);
		
	// Clausula 9 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 9�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(15, 4, 'Envidar� a', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CONTRATADA,', 0, 0, 'L');		
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'os melhores esfor�os para obter o pagamento do "Cach� Teste", no valor de R$ 30,00 (trinta reais),', 0, 1, 'L');
	
	$pdf->Cell(19, 4, 'sempre que o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'participar de testes ou sele��es, aqui n�o inclu�das sess�es de fotografias e v�deo com intuito de atualiza��o de', 0, 1, 'L');
	
	$pdf->Cell(0, 4, 'cadastro.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 10 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 10�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'O Contrato tem prazo de dura��o de 24 (vinte e quatro) meses, contados da assinatura do instrumento. Poss�vel a prorroga��o', 0, 1, 'L');	
	
	$pdf->Cell(0, 4, 'do Contrato por vezes indeterminadas ap�s o t�rmino do prazo aqui estipulado, desde que exista manifesta��o das partes nesse sentido.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(28, 4, 'Par�grafo primeiro:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(133, 4, 'Durante a vig�ncia do Contrato e caso estipulada a �exclusividade� prevista na Cl�usula 8�, n�o poder� o', 0, 0, 'L');	
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 1, 'L');
	
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(48, 4, 'contratar outro agenciador que n�o a', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(0, 4, 'CONTRATADA.', 0, 1, 'L');
	$pdf->Ln(4);		
	
	// Clausula 11 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 11�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'O v�nculo contratual n�o poder� ser rescindido sem motivo relevante. Se uma das partes der ensejo ao rompimento do v�nculo', 0, 1, 'L');	
	
	$pdf->Cell(0, 4, 'sem motivo relevante, dever� arcar com multa no valor de R$ 1.000,00 (mil reais), al�m de indeniza��o por eventuais perdas e danos.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Clausula 12 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 12�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(12, 4, 'Sendo o', 0, 0, 'L');
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(23, 4, 'CONTRATANTE', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'incapaz seu representante/assistente, com a assinatura de interveni�ncia no cabe�alho deste instrumento,', 0, 1, 'L');	
	
	$pdf->Cell(0, 4, 'anui e concorda expressamente com os termos do contrato, podendo se fazer presente em todas as sess�es de fotografia filmagem do agenciado, tudo', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'conforme os preceitos da Lei n. 8.069/90 (�Estatuto da Crian�a e do Adolescente�).', 0, 1, 'L');
	$pdf->Ln(4);


	// Clausula 13 (cada linha em um bloco de codigo)
	$pdf->SetFont('Helvetica','B',8);
	$pdf->Cell(22, 4, 'CL�USULA 13�:', 0, 0, 'L');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(0, 4, 'Para dirimir quaisquer controv�rsias decorrentes deste Contrato as partes elegem como competente o foro da Circunscri��o', 0, 1, 'L');	

	$pdf->Cell(0, 4, 'Judici�ria de Bras�lia, Distrito Federal.', 0, 1, 'L');
	$pdf->Ln(4);
	
	// Consideracoes finais e data
	$pdf->Cell(0, 4, 'E por estarem assim justas e contratadas as partes firmam o presente instrumento, em duas vias de igual teor.', 0, 1, 'L');
	$pdf->Ln(4);
	
	$meses = array("janeiro", "fevereiro", "mar�o", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
	$stamp_impressao = strtotime(formataDataBanco($dt_impressao));
	$data_emissao = date("d", $stamp_impressao) ." de ". $meses[(date("m", $stamp_impressao) - 1)] ." de ". date("Y", $stamp_impressao); 
	$pdf->Cell(0, 4, 'Bras�lia, '.$data_emissao, 0, 1, 'L');
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
	$pdf->Cell(0, 3, 'SHIN CA 02 Lote A Bloco A Loja 01 - Lago Norte - Bras�lia - DF - 71.503-502 � (61) 3201-7670', 0, 1, 'C');	
	$pdf->Cell(0, 3, 'www.magnetoelenco.com.br - elenco@grupomagneto.com.br', 0, 1, 'C');	

	// Printa o pdf
	$pdf->Output("contrato_$id_elenco.pdf", "I");	
?>
<?php
echo "<mm:dwdrfml documentRoot=" . __FILE__ .">";$included_files = get_included_files();foreach ($included_files as $filename) { echo "<mm:IncludeFile path=" . $filename . " />"; } echo "</mm:dwdrfml>";
?>