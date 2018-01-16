<?php
    $key=$_GET['key'];
    $array = array();
    $con=mysql_connect("localhost:8889","root","root");
    $db=mysql_select_db("testecadastro",$con);
    $query=mysql_query("select * from tb_elenco where nome_artistico LIKE '%{$key}%'");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['nome_artistico'];
    }
    echo json_encode($array);
?>
