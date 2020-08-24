<?php
include_once 'conexao.php';

$pessoa = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "SELECT id_pessoa, nome_completo, cpf FROM tbl_pessoa WHERE nome_completo iLIKE '%".$pessoa."%' ORDER BY nome_completo ASC LIMIT 7";

//Seleciona os registros
$resultado_msg_cont = $conn->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row_msg_cont['id_pessoa'];
    $data[] = $row_msg_cont['nome_completo'];
    $data[] = $row_msg_cont['cpf'];

}
/*
if($btnCadPessoa){
	
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

    $result_pessoa = "INSERT INTO tbl_passagem (id_pessoa) VALUES (
    '" .$dados['id_pessoa']. "'
    )";
    
    $resultado_pessoa = $conn->prepare($result_pessoa);
    $resultado_pessoa->execute();
*/

echo json_encode($data);