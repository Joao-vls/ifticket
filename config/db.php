<?php
$bdServidor = '127.0.0.1';
$bdUsuario = 'root';
$bdSenha = '04042003';
$bdBanco = 'ifticket';
$sql = "mysql:host=$bdServidor;dbname=$bdBanco;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
//$conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);
// if (mysqli_connect_errno($conexao)) {
// 	echo "Problemas para conectar no banco. Verifique os dados!";
// 	die();
// }
try {
  $my_Db_Connection = new PDO($sql, $bdUsuario, $bdSenha, $dsn_Options);
} catch (PDOException $error) {
  echo 'Connection error: ' . $error->getMessage();
}