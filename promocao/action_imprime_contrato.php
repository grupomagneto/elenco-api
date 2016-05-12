<?php header("Content-type: text/html; charset=UTF-8");
include("conecta.php");
date_default_timezone_set('America/Sao_Paulo');
session_start();
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
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $data = date('Y-m-d');
    $dia = date('d', strtotime($data));
    $mes = date('m', strtotime($data));
    $ano = date('Y', strtotime($data));
    $semana = date('w');
    switch ($mes){
    case 1: $mes = "janeiro"; break;
    case 2: $mes = "fevereiro"; break;
    case 3: $mes = "março"; break;
    case 4: $mes = "abril"; break;
    case 5: $mes = "maio"; break;
    case 6: $mes = "junho"; break;
    case 7: $mes = "julho"; break;
    case 8: $mes = "agosto"; break;
    case 9: $mes = "setembro"; break;
    case 10: $mes = "outubro"; break;
    case 11: $mes = "novembro"; break;
    case 12: $mes = "dezembro"; break;
    }
    switch ($semana) {
    case 0: $semana = "domingo"; break;
    case 1: $semana = "segunda-feira"; break;
    case 2: $semana = "terça-feira"; break;
    case 3: $semana = "quarta-feira"; break;
    case 4: $semana = "quinta-feira"; break;
    case 5: $semana = "sexta-feira"; break;
    case 6: $semana = "sábado"; break;
    }
    $sql = "SELECT * FROM tb_elenco WHERE id_elenco = '$id'";
    $tipo_cadastro_efetivado  = $_SESSION['novo_cadastro'];
    $result = mysqli_query($link, $sql);
      while ($row = mysqli_fetch_array($result)) {
        $nome                     = $row['nome'];
        $nome                     = iconv("ISO-8859-15","UTF-8//IGNORE",$nome);
        $nome                     = preg_replace("[^a-zA-Z0-9_]", "", strtr($nome, "áàãâéêíóôõúüç", "ÁÀÃÂÉÊÍÓÔÕÚÜÇ"));
        $nome                     = strtoupper($nome);
        $nome_responsavel         = $row['nome_responsavel'];
        $nome_responsavel         = iconv("ISO-8859-15","UTF-8//IGNORE",$nome_responsavel);
        $nome_responsavel         = preg_replace("[^a-zA-Z0-9_]", "", strtr($nome_responsavel, "áàãâéêíóôõúüç", "ÁÀÃÂÉÊÍÓÔÕÚÜÇ"));
        $nome_responsavel         = strtoupper($nome_responsavel);
        $cpf_responsavel          = $row['cpf'];
        $cpf                      = $row['cpf'];
        $bairro                   = $row['bairro'];
        $bairro                   = iconv("ISO-8859-15","UTF-8//IGNORE",$bairro);
        $bairro                   = preg_replace("[^a-zA-Z0-9_]", "", strtr($bairro, "áàãâéêíóôõúüç", "ÁÀÃÂÉÊÍÓÔÕÚÜÇ"));
        $bairro                   = strtoupper($bairro);
        $celular                  = $row['tl_celular'];
        $celular                  = mask($celular, '(##) ####-####');
        if ($cpf_responsavel != NULL) {
        $cpf_responsavel          = mask($cpf_responsavel, '###.###.###-##');
        } if ($cpf != NULL) {
        $cpf                      = mask($cpf, '###.###.###-##');
        }
      }
      if ($tipo_cadastro_efetivado == NULL || $tipo_cadastro_efetivado == '') {
        $tipo = $tipo_cadastro;
      }
      if ($tipo_cadastro_efetivado != NULL && $tipo_cadastro_efetivado != '') {
        $tipo = $tipo_cadastro_efetivado;
      }
    }
echo"  
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
  <title>Imprimir Contrato Magneto Elenco</title>
  <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
  <style type='text/css'>
    p.p1 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: center; font: 10px Roboto}
    p.p2 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: center; font: 10px Roboto}
    p.p3 {margin: 0.0px 0.0px 0.0px 0.0px; font: 10px Roboto}
    p.p4 {margin: 0.0px 0.0px 0.0px 0.0px; font: 10px Roboto}
    p.p5 {margin: 0.0px 0.0px 10.0px 0.0px; text-align: right; font: 10px Roboto}
    p.p6 {margin: 0.0px 0.0px 10.0px -100px; text-indent: 100px; font: 10px Roboto}
    p.p7 {margin: 0.0px 0.0px 10.0px 0.0px; font: 10px Roboto}
    p.p8 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: justify; font: 10px Roboto}
    p.p9 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: center; font: 10px Roboto}
    p.p10 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: justify; font: 10px Roboto}
    p.p11 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: justify; font: 10px Roboto}
    p.p12 {margin: 0.0px 0.0px 0.0px 0.0px; font: 10px Roboto}
    p.p13 {margin: 0.0px 0.0px 0.0px 0.0px; font: 10px Roboto}
    p.p14 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: justify; font: 10px Roboto}
    p.p15 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: center; font: 10px Roboto}
    p.p16 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: center; font: 5.0px Roboto}
    p.p17 {margin: 0.0px 0.0px 0.0px 0.0px; font: 7.0px Roboto}
    p.p18 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: center; font: 10px Roboto}
    p.p19 {margin: 0.0px 0.0px 0.0px 0.0px; text-align: right; font: 7px Roboto; min-height: 15px}
    p.p23 {margin: 0.0px; text-align: right; font: 10px Roboto; color: red}
    p.p24 {margin: 0.0px; text-align: right; font: 10px Roboto; color: gray}
    span.s1 {font: 9.0px Roboto}
    span.s2 {text-decoration: underline}
    span.s3 {font: 9.0px Roboto}
    span.s4 {font-kerning: none}
    table.t1 {width: 500px; border-collapse: collapse}
    table.t2 {width: 500px; border-collapse: collapse}
    table.t3 {width: 500px; border-collapse: collapse}
    td.td1 {width: 200px; border-style: solid; border-width: 0px; border-color: #cbcbcb; padding: 0.0px 5.0px 0.0px 5.0px}
    td.td2 {width: 300px; border-style: solid; border-width: 0px; border-color: #cbcbcb; padding: 0.0px 5.0px 0.0px 5.0px}
    td.td6 {width: 250px; border-style: solid; border-width: 1px 0px 0px 0px; border-color: #000000; padding: 0.0px 5.0px 0.0px 5.0px}
    td.td8 {width: 50px; border-style: solid; border-width: 0px; border-color: #000000; padding: 0.0px 5.0px 0.0px 5.0px}
    td.td9 {width: 200px; border-style: solid; border-width: 0px 0px 1px 0px; border-color: #000000 #cbcbcb #000000 #cbcbcb; padding: 0.0px 5.0px 0.0px 5.0px}
    .todo {
            max-width: 1000px;
            margin: auto;
            position: relative;
            background-color: e5e5e5;
    }
    .assinaturas {
            max-width: 500px;
            margin: auto;
            position: relative;    
    }
        </style>
      </head>
      <body>
  </style>
</head>
<body>
<div class='todo'>
<table width='100%' border='0'>
  <tr>
    <td width='20%' align='left'><img src='images/logo.png' width='100' height='100' /></td>
    <td width='80%' align='right'><p class='p23'><b>T 61 3202-7266</b></p><p class='p24'>SHIN CA 02, lote A, bloco A, loja 01<br />Lago Norte 71.503-502<br />Brasília - DF, Brasil<br />www.magnetoelenco.com.br</p></td>
  </tr>
</table>
<p class='p2'><b>INSTRUMENTO PARTICULAR DE</b> <b>PRESTAÇÃO DE SERVIÇOS DE AGENCIAMENTO,</b></p>
<p class='p2'><b>INTERMEDIAÇÃO, REPRESENTAÇÃO E LICENÇA DE USO DE IMAGEM</b></p>
</center>
<p class='p3'><br></p>
<p class='p4'>Pelo presente instrumento particular de contrato as partes</p>
<p class='p3'><br></p>
<table width='500' cellspacing='0' cellpadding='0' class='t1'>
  <tbody>
    <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'><b>CONTRATANTE:</b></p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'><b>$nome</b><br></p></div>
      </td>
    </tr>";
if ($nome_responsavel != NULL && $nome_responsavel != '') {
echo "   <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'><b>REPRESENTANTE LEGAL:</b></p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'><b>$nome_responsavel</b><br></p></div>
      </td>
    </tr>";
}
if ($cpf_responsavel != NULL && $cpf_responsavel != '' && $cpf_responsavel != $cpf) {
echo "
    <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'>CPF DO REPRESENTANTE LEGAL:</p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'>$cpf_responsavel<br></p></div>
      </td>
    </tr>";
  }
if ($cpf != NULL || $cpf == $cpf_responsavel) {
echo "
    <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'>CPF:</p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'>$cpf<br></p></div>
      </td>
    </tr>";
  }
echo"
    <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'>BAIRRO / TELEFONE:</p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'>$bairro / $celular<br></p></div>
      </td>
    </tr>
  </tbody>
</table>
<p class='p3'><br></p>
<table width='500' cellspacing='0' cellpadding='0' class='t1'>
  <tbody>
    <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'><b>CONTRATADA:</b></p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'><b>MAG2 PRODUÇÕES ARTÍSTICAS E FOTOGRÁFICAS LTDA.</b></p></div>
      </td>
    </tr>
    <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'>CNPJ:</p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'>10.880.184/0001-85</p></div>
      </td>
    </tr>
    <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'>ENDEREÇO:</p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'>SHIN CA 02 LOTE A BLOCO A LOJA 01 – BRASÍLIA - DF</p></div>
      </td>
      </tr>
    <tr>
      <td valign='top' class='td1'>
        <div style='height:12px; overflow:hidden'><p class='p5'>REPRESENTANTE LEGAL:</p></div>
      </td>
      <td valign='top' class='td2'>
        <div style='height:12px; overflow:hidden'><p class='p6'>ANELISE CATUNDA DE CLODOALDO PINTO CPF: 022808181-59</p></div>
      </td>
    </tr>
  </tbody>
</table>
<p class='p3'><br></p>
<p class='p4'>têm justas e contratadas as seguintes cláusulas:</p>
<p class='p3'><br></p>
<p class='p8'><b>CLÁUSULA 1<sup>a</sup>:</b> O presente contrato tem como objeto a prestação, pela <b>CONTRATADA</b>, dos serviços de divulgação e intermediação de contratação do <b>CONTRATANTE</b> junto às produtoras de cinema e TV, agências de publicidade e eventos, estúdios de fotografia, emissoras de televisão e similares, em todo território nacional e no exterior, sem responsabilidade de conseguir trabalhos ou serviços, comprometendo-se, exclusivamente, a representar o <b>CONTRATANTE</b> e promover sua divulgação nos mercados citados, sendo responsável pela divulgação e comercialização de sua imagem.</p>
<p class='p9'><br></p>
<p class='p8'><b>CLÁUSULA 2<sup>a</sup>: </b>O <b>CONTRATANTE</b> não está obrigado a aceitar os trabalhos que lhe forem oferecidos, obrigando-se, entretanto, a manter sua ficha cadastral sempre atualizada, sob pena das sanções previstas no Contrato, bem como a comparecer a novas sessões de fotografias, sempre que convocado, a título de atualização de seu material, sem custos adicionais.</p>
<p class='p10'><br></p>
<p class='p8'><b>Parágrafo primeiro:</b> Uma vez que o <b>CONTRATANTE </b>aceite um trabalho oferecido pela <b>CONTRATADA</b><span class='s1'>,</span> ele deverá comparecer ao local informado, na data e hora comunicadas, sob pena de multa de 10% (dez por cento) do seu cachê líquido em caso de atraso, ou, na hipótese de não comparecimento, o <b>CONTRATANTE</b> poderá sofrer as sanções previstas neste Contrato.</p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo segundo:</b> A remuneração do <b>CONTRATANTE</b> por cada trabalho de foto/vídeo realizado é dividida em: 30% (trinta por cento) pela prestação do serviço e 70% (setenta por cento) pela utilização de sua imagem.</p>
<p class='p10'><br></p>
<p class='p8'><b>Parágrafo terceiro:</b> Na hipótese da aceitação de um trabalho por parte do CONTRATANTE e existindo a necessidade de 'refação' das imagens deste trabalho, por qualquer imperfeição das fotos/vídeos, compromete-se o <b>CONTRATANTE </b>a participar de nova sessão de trabalhos, fazendo jus à remuneração correspondente, com um adicional de 30% (trinta por cento) sobre o cachê líquido original.</p>
<p class='p10'><br></p>
<p class='p8'><b>Parágrafo quarto: </b>Para o caso de 'reutilização' das imagens em nova contratação/campanha publicitária, a remuneração devida ao <b>CONTRATANTE</b> será a de 70% (setenta por cento) do cachê líquido original caso a utilização em mídia/praça/período seja a igual a originalmente prevista. Caso a utilização sofra alteração, o valor devido ao <b>CONTRATANTE</b> será ajustado proporcionalmente.<span class='Apple-converted-space'> </span></p>
<p class='p11'><br></p>
<p class='p8'><b>CLÁUSULA 3<sup>a</sup>:</b> A <b>CONTRATADA</b> tem o direito de intermediar a contratação do <b>CONTRATANTE</b>, podendo representá-lo na contratação perante terceiros e receber a remuneração devida, repassando-a posteriormente para o <b>CONTRATANTE</b> na forma estipulada no Contrato.</p>
<p class='p10'><br></p>
<p class='p8'><b>CLÁUSULA 4<sup>a</sup>: </b>O <b>CONTRATANTE </b>cede à <b>CONTRATADA</b> os direitos e o uso de sua imagem e expressões artísticas pelo tempo de duração do Contrato, no território nacional ou fora dele, em qualquer meio de comunicação, reconhecendo que a imagem e seus direitos de exploração também serão utilizados em meio virtual, principalmente no site da <b>CONTRATADA</b>.";
if ($tipo == 'Premium' || $tipo == 'premium' || $tipo == 'Gratuito' || $tipo == 'gratuito' || $tipo == 'Ator' || $tipo == 'ator') {
  echo "Reconhece ainda ser da exclusiva propriedade da <b>CONTRATADA</b> o material obtido nas sessões de fotografia e vídeo do <b>CONTRATANTE</b>.</p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo primeiro:</b> A <b>CONTRATADA</b> poderá comercializar o material fotográfico com terceiros, desde que o <b>CONTRATANTE </b>autorize; poderá também vender o material fotográfico para o próprio <b>CONTRATANTE.</p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo segundo: </b>Qualquer material fotográfico ou de vídeo produzido por terceiros e fornecido pelo <b>CONTRATANTE</b> à <b>CONTRATADA</b> para ser incluído em seu perfil no site da <b>CONTRATADA</b> é de inteira responsabilidade do <b>CONTRATANTE</b>, ficando a <b>CONTRATADA </b>isenta de qualquer responsabilidade legal sobre o uso deste material. Caso a <b>CONTRATADA</b> fique em qualquer hipótese responsabilizada por material entregue pelo <b>CONTRATANTE</b>, este indenizará a<span class='Apple-converted-space'>  </span><b>CONTRATADA</b><span class='s1'>.</span></p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo terceiro:</b> A compra do material fotográfico por parte do <b>CONTRATANTE</b> inclui Cessão de Direitos de Uso de Imagem para uso pessoal, em pasta portfolio própria, dentro de seu ambiente familiar, em redes sociais públicas e inclusive em sites ou materiais de divulgação de empresas concorrentes da <b>CONTRATADA</b><span class='s1'>.</span></p>
<p class='p11'><br></p>";
}
if ($tipo == 'Profissional' || $tipo == 'profissional' || $tipo == 'Ensaio' || $tipo == 'ensaio') {
  echo "<p class='p11'><br></p>
<p class='p8'><b>Parágrafo primeiro:</b> A <b>CONTRATADA</b> entregará um DVD com mínimo de 30 fotos escolhidas e tratadas, provenientes da sessão do Ensaio Fotográfico realizado após a assinatura deste contrato, para o <b>CONTRATANTE</b> em até 15 (quinze) dias corridos após a sua realização.</p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo segundo:</b> A compra do material fotográfico por parte do <b>CONTRATANTE</b> inclui Cessão de Direitos de Uso de Imagem para uso pessoal, em pasta portfolio própria, dentro de seu ambiente familiar, em redes sociais públicas e inclusive em sites ou materiais de divulgação de empresas concorrentes da <b>CONTRATADA</b><span class='s1'>.</span></p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo terceiro: </b>Qualquer material fotográfico ou de vídeo produzido por terceiros e fornecido pelo <b>CONTRATANTE</b> à <b>CONTRATADA</b> para ser incluído em seu perfil no site da <b>CONTRATADA</b> é de inteira responsabilidade do <b>CONTRATANTE</b>, ficando a <b>CONTRATADA </b>isenta de qualquer responsabilidade legal sobre o uso deste material. Caso a <b>CONTRATADA</b> fique em qualquer hipótese responsabilizada por material entregue pelo <b>CONTRATANTE</b>, este indenizará a<span class='Apple-converted-space'>  </span><b>CONTRATADA</b><span class='s1'>.</span></p>
<p class='p11'><br></p>";
}
echo"<p class='p8'><b>CLÁUSULA 5<sup>a</sup>:</b> O <b>CONTRATANTE</b> dispensa a citação de seu nome ou crédito autoral na divulgação das obras fotográficas cujos direitos são por ele aqui cedidos, não se responsabilizando a <b>CONTRATADA </b>pela captação ou uso indevido de imagem por terceiros com quem a <b>CONTRATADA</b> não negociou.</p>
<p class='p10'><br></p>
<p class='p8'><b>CLÁUSULA 6<sup>a</sup>:</b> O <b>CONTRANTE</b> opta pelo ";
if ($tipo == 'Profissional' || $tipo == 'profissional') {
  echo "<span class='s2'><b>CADASTRO PROFISSIONAL</b></span><b>:</b> estipulação de <b>não-exclusividade</b> do <b>CONTRATANTE </b>com a <b>CONTRATADA</b> no agenciamento.</p>";
}
if ($tipo == 'Premium' || $tipo == 'premium' || $tipo == 'Ensaio' || $tipo == 'ensaio' || $tipo == 'Ator' || $tipo == 'ator') {
  echo "<span class='s2'><b>CADASTRO PREMIUM</b></span><b>:</b> estipulação de <b>não-exclusividade</b> do <b>CONTRATANTE </b>com a <b>CONTRATADA</b> no agenciamento.</p>";
}
if ($tipo == 'Gratuito' || $tipo == 'gratuito') {
  echo "<span class='s2'><b>CADASTRO GRATUITO</b></span>: estipulação de <b>exclusividade</b> do <b>CONTRATANTE </b>com a <b>CONTRATADA </b>no agenciamento,<b> </b>inclusive para trabalhos em outros estados do território nacional e no exterior.</p>";
}
echo"
<p class='p10'><br></p>
<p class='p8'><b>Parágrafo primeiro:</b> Caso o <b>CONTRATANTE</b> deseje trocar a modalidade da relação estabelecida na cláusula 6<sup>a</sup>, esta poderá ocorrer apenas antes da realização da <i>1<sup>a</sup> sessão de fotos e vídeo</i>. Para sessões agendadas aos sábados (dia reservado exclusivamente para recepção de agenciados que optarem pelo 'CADASTRO PREMIUM' ou 'CADASTRO PROFISSIONAL'), a <b>CONTRATADA</b> se reserva o direito de recusar o atendimento de optantes pelo 'CADASTRO GRATUITO'.</p>
<p class='p10'><br></p>";
if ($tipo == 'Gratuito' || $tipo == 'gratuito') {
  echo "<p class='p8'><b>Parágrafo segundo:</b> Em caso de opção pelo 'CADASTRO GRATUITO', se ocorrer descumprimento da cláusula de exclusividade pelo <b>CONTRATANTE</b>,<span class='Apple-converted-space'>  </span>ele ficará sujeito ao pagamento de multa no valor de R$ 1.000,00 (mil reais), acrescidos de correção monetária e juros moratórios de 1% ao mês desde a data da constatação do prejuízo pela <b>CONTRATADA</b> até o pagamento, como forma de reparação mínima.</p>
<p class='p10'><br></p>";
}
if ($tipo == 'Premium' || $tipo == 'premium' || $tipo == 'Ensaio' || $tipo == 'ensaio' || $tipo == 'Ator' || $tipo == 'ator') {
  echo "<p class='p8'><b>CLÁUSULA 7<sup>a</sup>: </b>Na hipótese de opção pelo 'CADASTRO PREMIUM', previsto na Cláusula 6<sup>a</sup>, será retido pela <b>CONTRATADA </b>o percentual de 20% (vinte por cento) do montante líquido sobre cada cachê resultante de qualquer trabalho do <b>CONTRATANTE</b>, ficando, portanto, o <b>CONTRATANTE</b> com o valor de 80% (oitenta por cento) do montante líquido de cada cachê. Por montante líquido entende-se o valor do cachê após pagos os impostos e feitas as deduções legais na nota fiscal de serviço.</p>
  <p class='p10'><br></p>
<s><p class='p8'><b>CLÁUSULA 8<sup>a</sup>: </b>Apenas no primeiro trabalho do <b>CONTRATANTE</b> obtido/intermediado pela<b> CONTRATADA </b>e na hipótese de opção pelo 'CADASTRO GRATUITO' será retido pela <b>CONTRATADA</b> o percentual de 80% (oitenta por cento) sobre o valor líquido do cachê, como forma do pagamento e reembolso dos gastos com sessão de fotos e vídeo, feitos sem custos iniciais para o <b>CONTRATANTE</b><span class='s1'>.</span></p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo primeiro: </b>A partir do segundo trabalho obtido/intermediado pela<b> CONTRATADA</b> e<b> </b>caso o <b>CONTRATANTE</b> opte pelo 'CADASTRO GRATUITO' previsto na Cláusula 6<sup>a</sup>, o percentual retido pela <b>CONTRATADA,</b> sobre o montante líquido de cada cachê, será de 40% (quarenta por cento).</p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo segundo: </b>As hipóteses de retenção do cachê do primeiro trabalho prevista na Cláusula 8<sup>a</sup> acima, como forma de reembolso da <b>CONTRATADA</b>, não se aplicam para os trabalhos de figuração e recepção.</p></s>";
} if ($tipo == 'Profissional' || $tipo == 'profissional') {
  echo "<p class='p8'><b>CLÁUSULA 7<sup>a</sup>: </b>Na hipótese de opção pelo 'CADASTRO PROFISSIONAL', previsto na Cláusula 6<sup>a</sup>, será retido pela <b>CONTRATADA </b>o percentual de 10% (dez por cento) do montante líquido sobre cada cachê resultante de qualquer trabalho do <b>CONTRATANTE</b>, ficando, portanto, o <b>CONTRATANTE</b> com o valor de 90% (noventa por cento) do montante líquido de cada cachê. Por montante líquido entende-se o valor do cachê após pagos os impostos e feitas as deduções legais na nota fiscal de serviço.</p>
  <p class='p10'><br></p>
<s><p class='p8'><b>CLÁUSULA 8<sup>a</sup>: </b>Apenas no primeiro trabalho do <b>CONTRATANTE</b> obtido/intermediado pela<b> CONTRATADA </b>e na hipótese de opção pelo 'CADASTRO GRATUITO' será retido pela <b>CONTRATADA</b> o percentual de 80% (oitenta por cento) sobre o valor líquido do cachê, como forma do pagamento e reembolso dos gastos com sessão de fotos e vídeo, feitos sem custos iniciais para o <b>CONTRATANTE</b><span class='s1'>.</span></p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo primeiro: </b>A partir do segundo trabalho obtido/intermediado pela<b> CONTRATADA</b> e<b> </b>caso o <b>CONTRATANTE</b> opte pelo 'CADASTRO GRATUITO' previsto na Cláusula 6<sup>a</sup>, o percentual retido pela <b>CONTRATADA,</b> sobre o montante líquido de cada cachê, será de 40% (quarenta por cento).</p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo segundo: </b>As hipóteses de retenção do cachê do primeiro trabalho prevista na Cláusula 8<sup>a</sup> acima, como forma de reembolso da <b>CONTRATADA</b>, não se aplicam para os trabalhos de figuração e recepção.</p></s>";
} if ($tipo == 'Gratuito' || $tipo == 'gratuito') {
  echo "<s><p class='p8'><b>CLÁUSULA 7<sup>a</sup>: </b>Na hipótese de opção pelo 'CADASTRO PREMIUM', previsto na Cláusula 6<sup>a</sup>, será retido pela <b>CONTRATADA </b>o percentual de 20% (vinte por cento) do montante líquido sobre cada cachê resultante de qualquer trabalho do <b>CONTRATANTE</b>, ficando, portanto, o <b>CONTRATANTE</b> com o valor de 80% (oitenta por cento) do montante líquido de cada cachê. Por montante líquido entende-se o valor do cachê após pagos os impostos e feitas as deduções legais na nota fiscal de serviço.</p></s>
  <p class='p10'><br></p>
<p class='p8'><b>CLÁUSULA 8<sup>a</sup>: </b>Apenas no primeiro trabalho do <b>CONTRATANTE</b> obtido/intermediado pela<b> CONTRATADA </b>e na hipótese de opção pelo 'CADASTRO GRATUITO' será retido pela <b>CONTRATADA</b> o percentual de 80% (oitenta por cento) sobre o valor líquido do cachê, como forma do pagamento e reembolso dos gastos com sessão de fotos e vídeo, feitos sem custos iniciais para o <b>CONTRATANTE</b><span class='s1'>.</span></p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo primeiro: </b>A partir do segundo trabalho obtido/intermediado pela<b> CONTRATADA</b> e<b> </b>caso o <b>CONTRATANTE</b> opte pelo 'CADASTRO GRATUITO' previsto na Cláusula 6<sup>a</sup>, o percentual retido pela <b>CONTRATADA,</b> sobre o montante líquido de cada cachê, será de 40% (quarenta por cento).</p>
<p class='p11'><br></p>
<p class='p8'><b>Parágrafo segundo: </b>As hipóteses de retenção do cachê do primeiro trabalho prevista na Cláusula 8<sup>a</sup> acima, como forma de reembolso da <b>CONTRATADA</b>, não se aplicam para os trabalhos de figuração e recepção.</p>";
}
echo "
<p class='p10'><br></p>
<p class='p8'><b>CLÁUSULA 9<sup>a</sup> - DA POLÍTICA DE REMARCAÇÕES DE HORÁRIOS DE SESSÃO DE FOTOS E VÍDEO: </b>Remarcações de horários agendados para realização da <i>1<sup>a</sup> sessão de fotos e vídeo</i> da <b>CONTRATANTE</b>,<b> </b>ocorridas com prazos superiores a 72 (setenta e duas) horas do horário agendado serão gratuitas e ilimitadas.</p>
<p class='p10'><br></p>
<p class='p8'><b>Parágrafo primeiro: </b>Remarcações com prazos inferiores a 72 (setenta e duas) horas do horário agendado poderão ser realizadas por telefone mediante cobrança de taxa de R$ 30,00 (trinta reais) para a primeira ocorrência e de R$ 60,00 (sessenta reais) para a segunda ocorrência. Após a segunda ocorrência o cadastro do agenciado ficará bloqueado e poderá ser liberado presencialmente apenas.</p>
<p class='p10'><br></p>
<p class='p8'><b>Parágrafo segundo:</b> Atrasos superiores a 30 (trinta) minutos do horário agendado serão considerados 'não comparecimento' e sofrerão cobrança de uma taxa de R$ 60,00 (sessenta reais). Todas as taxas de remarcações são cumulativas.</p>
<p class='p10'><br></p>";
if ($tipo == 'Profissional' || $tipo == 'profissional') {
  echo "<p class='p8'><b>CLÁUSULA 10<sup>a</sup>:</b> O Contrato tem prazo de duração de 36 (trinta e seis) meses contados da assinatura ou aceitação eletrônica do instrumento e substitui as versões anteriores firmadas entre as partes.<span class='Apple-converted-space'> </span></p>";
} if ($tipo == 'Gratuito' || $tipo == 'gratuito') {
  echo "<p class='p8'><b>CLÁUSULA 10<sup>a</sup>:</b> O Contrato tem prazo de duração de 24 (vinte e quatro) meses contados da assinatura ou aceitação eletrônica do instrumento e substitui as versões anteriores firmadas entre as partes.<span class='Apple-converted-space'> </span></p>";
} if ($tipo == 'Premium' || $tipo == 'premium' || $tipo == 'Ensaio' || $tipo == 'ensaio' || $tipo == 'Ator' || $tipo == 'ator') {
  echo "<p class='p8'><b>CLÁUSULA 10<sup>a</sup>:</b> O Contrato tem prazo de duração de 24 (vinte e quatro) meses contados da assinatura ou aceitação eletrônica do instrumento e substitui as versões anteriores firmadas entre as partes.<span class='Apple-converted-space'> </span></p>";
}
  echo "<p class='p9'><br></p>
<p class='p8'><b>CLÁUSULA 11<sup>a</sup>:</b> O vínculo contratual poderá ser rescindido sem motivo relevante, a qualquer momento, por qualquer uma das partes. Porém, caso haja quebra de contrato ou má fé de uma das partes, esta deverá arcar com multa no valor de R$ 1.000,00 (mil reais), além de indenização por eventuais perdas e danos.</p>
<p class='p10'><br></p>
<p class='p8'><b>CLÁUSULA 12<sup>a</sup>: </b>Sendo o <b>CONTRATANTE</b> incapaz seu representante/assistente, com a assinatura de interveniência no cabeçalho deste instrumento, anui e concorda expressamente com os termos do contrato, podendo se fazer presente em todas as sessões de fotografia filmagem do agenciado, tudo conforme os preceitos da Lei n. 8.069/90 ('Estatuto da Criança e do Adolescente').</p>
<p class='p11'><br></p>
<p class='p8'><b>CLÁUSULA 13<sup>a</sup>: </b>Para dirimir quaisquer controvérsias decorrentes deste Contrato as partes elegem o foro da de Brasília, Distrito Federal.</p>
<p class='p11'><br></p>
<p class='p8'>E por estarem assim justas e contratadas as partes firmam o presente instrumento, em duas vias de igual teor.</p>
<p class='p13'><br></p>
<p class='p13'><br></p>
<p class='p12'><span class='s3'>Brasília, $dia de $mes de $ano.</span></p>
<p class='p13'><br></p>
<p class='p13'><br></p>
<p class='p13'><br></p>
<div class='assinaturas'>
<table cellspacing='0' cellpadding='0' class='t3'>
  <tbody>
    <tr>
      <td valign='top' class='td6'>
        <p class='p15'><b>CONTRATANTE</b></p>
        <p class='p16'><b>(Se menor, assinatura do representante)</b></p>
      </td>
      <td valign='top' class='td6'>
        <p class='p15'><b>CONTRATADA</b></p>
      </td>
    </tr>
  </tbody>
</table>
<p class='p17'><b>Testemunhas:</b></p>
<p class='p18'><br></p>
<table cellspacing='0' cellpadding='0' class='t3'>
  <tbody>
    <tr>
      <td valign='bottom' class='td8'>
        <p class='p19'><b>Nome:</b></p>
      </td>
      <td valign='top' class='td9'>
        <p class='p19'><br></p>
      </td>
      <td valign='bottom' class='td8'>
        <p class='p19'><b>Nome:</b></p>
      </td>
      <td valign='top' class='td9'>
        <p class='p19'><span class='s4'></span><br></p>
      </td>
    </tr>
    <tr>
      <td valign='bottom' class='td8'>
        <p class='p19'><b>RG:</b></p>
      </td>
      <td valign='top' class='td9'>
        <p class='p19'><br></p>
      </td>
      <td valign='bottom' class='td8'>
        <p class='p19'><b>RG:</b></p>
      </td>
      <td valign='top' class='td9'>
      </td>
    </tr>
  </tbody>
</table>
</div>
</div>
</body>
</html>";
mysqli_close($link);
?>

