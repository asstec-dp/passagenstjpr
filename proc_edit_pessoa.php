<?php
session_start();
include_once("conexao.php");

$id_pessoa = filter_input(INPUT_POST, 'id_pessoa', FILTER_SANITIZE_NUMBER_INT);
$nome_completo = filter_input(INPUT_POST, 'nome_completo', FILTER_SANITIZE_STRING);
$cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);
$matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_NUMBER_INT);
$email_pessoa = filter_input(INPUT_POST, 'email_pessoa', FILTER_SANITIZE_EMAIL);
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
$passaporte = filter_input(INPUT_POST, 'passaporte', FILTER_SANITIZE_STRING);
$status_pessoa = filter_input(INPUT_POST, 'status_pessoa', FILTER_SANITIZE_STRING);

//echo "Nome: $nome_completo <br>";
//echo "E-mail: $email_pessoa <br>";

$result_pessoa = "UPDATE tbl_pessoa SET nome_completo='$nome_completo', cargo='$cargo', matricula='$matricula', email_pessoa='$email_pessoa', data_nascimento='$data_nascimento', cpf='$cpf', rg='$rg', passaporte='$passaporte', status_pessoa='$status_pessoa' WHERE id_pessoa='$id_pessoa'";
$resultado_pessoa = pg_query($conn, $result_pessoa);

if(pg_affected_rows($resultado_pessoa)){
	$_SESSION['msg'] = "<p style='color:green;'>Usuário editado com sucesso</p>";
	header("Location: listar_pessoa.php");
}else{
	$_SESSION['msg'] = "<p style='color:red;'>Usuário não editado</p>";
	header("Location: edit_pessoa.php?id_pessoa=$id_pessoa");
}
