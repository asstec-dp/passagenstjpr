<?php
include_once 'conexao.php';

$resultado = pg_query ($conn, "SELECT nome_completo FROM tbl_pessoa ORDER BY nome_completo ASC LIMIT 10");

while ($row = pg_fetch_array($resultado))

    echo $row;

?>