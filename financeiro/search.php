<?php
include("conecta.php");
    $key=$_GET['key'];
    $array = array();
    // $con=mysqli_connect("localhost:8889","root","root");
    $db=mysqli_select_db($link,"testecadastro");
    $query=mysqli_query($link,"select * from tb_elenco where nome_artistico LIKE '%{$key}%'");
    while($row=mysqli_fetch_assoc($query))
    {
      $array[] = $row['nome_artistico'];
    }
    echo json_encode($array);
    mysqli_close($link);
?>