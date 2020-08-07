<?php
session_start();
include_once("conexao.php");
$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin){

	$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

	echo "$login - $senha";

	if((!empty($login)) AND (!empty($senha))){
		//Gerar a senha criptografa
		echo password_hash($senha, PASSWORD_DEFAULT);
		//Pesquisar o usuário no BD
		$result_usuario = "SELECT id_usuario, id_pessoa, senha FROM tbl_usuario WHERE 'login'='$login' LIMIT 1";
		$resultado_usuario = pg_query($conexao, $result_usuario);
		if($resultado_usuario){

			$row_usuario = pg_fetch_assoc($resultado_usuario);

			if(password_verify($senha, $row_usuario['senha'])){

				
				$_SESSION['id_usuario'] = $row_usuario['id_usuario'];
				$_SESSION['id_pessoa'] = $row_usuario['id_pessoa'];
				$_SESSION['login'] = $row_usuario['login'];

				header("Location: cadastrarUsuarios.php");
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

?>