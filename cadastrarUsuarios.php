<?php
	session_start();

	ob_start();
	
	$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
	
	if($btnCadUsuario){

		include_once 'conexao.php';
	
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		//var_dump($dados);
		$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

		$result_usuario = "INSERT INTO tbl_usuario (id_pessoa, login, senha) VALUES (

		'" .$dados['id_pessoa']. "',
		'" .$dados['login']. "',
		'" .$dados['senha']. "'
		)";

		$resultado_usuario = pg_connect($conn, $result_usuario);

		if(pg_insert_id($conn)){
			$_SESSION['msgcad'] = "Usuário cadastrado com sucesso";
			header("Location: index.php");
			
		}else{
			$_SESSION['msg'] = "Usuário já cadastrado";
			var_dump($conn);
			header("Location: index.php");
			
		}
		
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Usuários</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
	

		<header>
					
			<nav class="navbar navbar-expand-sm navbar-dark">
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						
						<li class="nav-item">
							<a class="nav-link" href="index.php">Login </span></a>
						</li>
						<li class="nav-item dropdown  active">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Usuários
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="#">Cadastrar <span class="sr-only">(current)</a>
								<a class="dropdown-item" href="#">Consultar</a>
							</div>
							
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Passagens
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="#">Cadastrar</a>
								<a class="dropdown-item" href="#">Consultar</a>
							</div>
						</li>
			
					</ul>
				</div>
			</nav>

		</header>
		

		<section class="col-md-auto">			
				
			<div class="content-center">
				<div>
					<h1>CADASTRO DE USUÁRIO</h1>
				</div>

				
				
				
				<form method="POST" action="">
					
					<div type="radio">
						
						<div>
							<input type="radio" name = "tipo" id= "1" value= "magistrado"  >
							<label for = "magistrado">Magistrado</label>
						</div>
						<div>
							
							<input type="radio" name = "tipo" id="servidor"  value= "servidor"  checked>
							
							<label for = "servidor">Servidor</label>
						</div>
						<div>
							
							<input type="radio" name = "tipo" id="estagiario" value= "estagiario" >
							<label for = "estagiario">Estagiario</label>		
						</div>

					</div>	

					<input name = "id_pessoa" id="id_pessoa"  placeholder="Digite a pessoa" maxlength = "10" required >

					<input type = "text" name ="login" id="login" placeholder="Digite o login" maxlength = "200" required>
								
					<input type="password" name ="senha" id="senha" placeholder="Digite a senha" maxlength = "8" required>			
					
					<input type ="submit" name="btnCadUsuario" id = "btnCadUsuario" value ="Cadastrar"></input>	
					</form>
				</div>
		</section>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="assets/css/bootstrap.min.css"></script>
		
	</body>
</html>
