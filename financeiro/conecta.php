<?php header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
if(!session_id()) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB Localhost
$user = 'root';
$password = 'root';
$db = 'testecadastro';
$host = 'localhost';
$port = 8889;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link,
   $host,
   $user,
   $password,
   $db,
   $port
);
mysqli_set_charset($link,"utf8");

// DB Online
// $user = 'vinigoulart1';
// $password = 'ThM]HETPv@';
// $db = 'testecadastro';
// $host = 'p3plcpnl0612.prod.phx3.secureserver.net';

// $link = mysqli_init();
// $success = mysqli_real_connect(
//    $link,
//    $host,
//    $user,
//    $password,
//    $db
// );
// mysqli_set_charset($link,"utf8");

// DB Online 2
// $user2 = 'elencooriginal';
// $password2 = 'M@g3l3nc0_0962';
// $db2 = 'elencooriginal';
// $host2 = 'elencooriginal.mysql.dbaas.com.br';

// $link2 = mysqli_init();
// $success2 = mysqli_real_connect(
//    $link2,
//    $host2,
//    $user2,
//    $password2,
//    $db2
// );
// mysqli_set_charset($link2,"utf8");

// DB Online 3
// $user2 = 'vinigoulart12';
// $password2 = 'm@g3l3nc01122';
// $db2 = 'vinigoulart12';
// $host2 = 'mysql02.vinigoulart.com.br';

// $link2 = mysqli_init();
// $success2 = mysqli_real_connect(
//    $link2,
//    $host2,
//    $user2,
//    $password2,
//    $db2
// );
// mysqli_set_charset($link2,"utf8");
?>
