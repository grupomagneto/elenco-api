<?php
include('conecta.php');
date_default_timezone_set('America/Sao_Paulo');
$id = $_POST['id_elenco'];
$from_account = $_POST['from_account'];
// echo $id;
$hoje = date('Y-m-d', time());
$agora = date('Y-m-d h:i:s', time());
$result = mysqli_query($link, "SELECT * FROM financeiro WHERE request_timestamp IS NOT NULL AND status_pagamento<>'1' AND id_elenco_financeiro='$id'");
$taxa = 10;
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
  // echo $sql;
  $desconto = 0;
}
mysqli_close($link);
header("Location: transferencias.php");
?>
