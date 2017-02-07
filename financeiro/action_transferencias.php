<?php
include('conecta.php');
include('functions.php');
date_default_timezone_set('America/Sao_Paulo');
$id = $_POST['id_elenco'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$from_account = $_POST['from_account'];
$valor = $_POST['valor'];
$cpf = $_POST['cpf'];
$full_name = $_POST['full_name'];
$bank = $_POST['bank'];
$bank_agency = $_POST['bank_agency'];
$bank_account = $_POST['bank_account'];
$taxa = 10;

$result = mysqli_query($link, "SELECT * FROM financeiro WHERE request_timestamp IS NOT NULL AND status_pagamento<>'1' AND id_elenco_financeiro='$id'");
  $lista = "";
    while ($row = mysqli_fetch_array($result)) {
      $cliente = $row['cliente_job'];
      $campanha = $row['campanha'];
      $liquido = $row['cache_liquido'];
      $liquido = number_format($liquido,2,",",".");
      $lista .= "<li>$cliente - $campanha - R$ $liquido</li>";
    }

// envia email
if (empty($_SESSION[$id])) {

    define('GUSER', 'inteligencia@magnetoelenco.com.br'); // <-- Insira aqui o seu GMail
    define('GPWD', 'rom54808285');    // <-- Insira aqui a senha do seu GMail
    $subject = "Acabamos de transferir seu dinheiro!";

    // Corpo do email
    $msg = "
    <!DOCTYPE html PUBLIC>
    <html lang='pt-BR'>
    <head>
    <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:400' />
      <style type='text/css'>
        h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
      </style>
    </head>
    <body>
    <p>Oi $nome,</p>
    <p>Só pra avisar que seu dinheiro está a caminho e deve chegar na sua conta até amanhã. :)</p>
    <p>Para seu controle, pagamos os cachês relativos aos trabalhos:</p>
    <strong><ul>$lista</ul></strong>
    <p>E a transferência no valor total de R$ $valor (a soma dos cachês menos R$ $taxa,00 de taxa de transferência) foi feita para a seguinte conta cadastrada:</p>
    <strong><ul>
    <li>Banco: $bank</li>
    <li>Agência: $bank_agency</li>
    <li>Conta corrente: $bank_account</li>
    <li>$full_name</li>
    <li>$cpf</li>
    </ul></strong>
    <p>Obrigado pela confiança e até nosso próximo trabalho!
    <BR />
    <p>Abração,</p>
    <p>Time Magneto Elenco</p>
    </body>
    </html>";

    require_once "phpmailer/class.phpmailer.php";
    smtpmailer($email, 'inteligencia@magnetoelenco.com.br', 'Magneto Elenco', $subject, $msg);
    $_SESSION[$id] = "yes";
}

//Update DB como caches pagos
$hoje = date('Y-m-d', time());
$agora = date('Y-m-d h:i:s', time());
$result = mysqli_query($link, "SELECT * FROM financeiro WHERE request_timestamp IS NOT NULL AND status_pagamento<>'1' AND id_elenco_financeiro='$id'");
$desconto = $taxa;
while ($row = mysqli_fetch_array($result)) {
  $id_cache = $row['id'];
  $valor_pago = $row['cache_liquido'] - $desconto;
  $produto_abatimento = "Taxa de Transferência";
  $sql = "UPDATE financeiro SET status_pagamento='1',data_pagamento='$hoje',valor_pago='$valor_pago',transfer_timestamp='$agora',from_account='$from_account'";
  if ($desconto > 0) {
    $sql .= ",abatimento_cache='$desconto',data_abatimento='$hoje',produto_abatimento='$produto_abatimento'";
  }
  $sql .= " WHERE request_timestamp IS NOT NULL AND status_pagamento<>'1' AND id_elenco_financeiro='$id'";
  mysqli_query($link, $sql);
  $desconto = 0;
}
mysqli_close($link);
header("Location: transferencias.php");
?>
