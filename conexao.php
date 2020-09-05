<?php
//Credenciais de acesso ao BD
define('HOST', 'passagenstjpr.cjspllmwjxzm.us-east-2.rds.amazonaws.com');
define('PORT', 5432);
define('USER', 'postgres');
define('PASS', 'c0mp4rt1l#31');
define('DBNAME', 'dbpassagens');

$conn = new PDO('pgsql:host=' . HOST . ';port=' . PORT . ';dbname=' . DBNAME . ';', USER, PASS);


/*
if(!$conn) {
	die("Não foi possível se conectar ao banco de dados.");
}
else{
   echo "Conectou!!!!";
}
*/