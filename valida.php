<?php
session_start();

include_once 'conexao.php';

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);

if($btnLogin){	
	$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

	if((!empty($usuario)) AND (!empty($senha))){
		
		$result_usuario = "SELECT * FROM tbl_usuario
		INNER JOIN tbl_pessoa ON tbl_usuario.id_pessoa = tbl_pessoa.id_pessoa
		WHERE usuario = '$usuario' LIMIT 1";

		$resultado_usuario = $conn->prepare($result_usuario);
		$resultado_usuario->execute();
		
		if($resultado_usuario){
			$row_usuario = $resultado_usuario->fetch(PDO::FETCH_ASSOC);		
			
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id_usuario'] = $row_usuario['id_usuario'];
				$_SESSION['id_pessoa'] = $row_usuario['id_pessoa'];
				$_SESSION['nome_completo'] = $row_usuario['nome_completo'];
				$_SESSION['cargo'] = $row_usuario['cargo'];
				$_SESSION['usuario'] = $row_usuario['usuario'];
				$_SESSION['senha'] = $row_usuario['senha'];
				$_SESSION['unidade'] = $row_usuario['unidade'];
				$_SESSION['status_usuario'] = $row_usuario['status_usuario'];
				$_SESSION['matricula'] = $row_usuario['matricula'];
				$_SESSION['funcao'] = $row_usuario['funcao'];
				
				header("Location: inicio.php");
			}else{
				$_SESSION['msg'] = "Login ou senha incorreto!";
				header("Location: index.php");
			}
		}
	}else{
		$_SESSION['msg'] = "Preencha todos os campos!";
		header("Location: index.php");
	}
}else{
	$_SESSION['msg'] = "Página não encontrada";
	header("Location: index.php");
}