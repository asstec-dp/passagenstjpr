<?php
$servidor = "passagenstjpr.cjspllmwjxzm.us-east-2.rds.amazonaws.com";
$porta = 5432;
$bancoDeDados = "dbpassagens";
$usuario = "postgres";
$senha = "c0mp4rt1l#31";

$conn = pg_connect("host=$servidor port=$porta dbname=$bancoDeDados user=$usuario password=$senha");

if(!$conn) {
	die("Não foi possível se conectar ao banco de dados.");
}
else{
}


?>