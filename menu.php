<?php
	session_start();
?>

<!DOCTYPE html>

<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Viagem</title>
        <link rel="shortcut icon" href="assets/img/icon.jpeg" type="image/png">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
	

    <header>					
        <nav class="navbar navbar-expand-sm navbar-dark">

<img src="assets/img/logobco.png" type="image/png" width=80 height=50>
<div class="row">
</div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">		
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Viagem
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="cadastrarViagem.php">Cadastrar Viagem</a>
                    <a class="dropdown-item" href="cadastrarPessoa.php">Cadastrar Passageiro</a>
                    <a class="dropdown-item" href="#">Lançar Pagamento</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Contrato
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="cadastrarContrato.php">Cadastrar <span class="sr-only"></a>
                    <a class="dropdown-item" href="#">Consultar</a>
                    <a class="dropdown-item" href="cadastrarItem.php">Cadastrar Itens</a>
                    <a class="dropdown-item" href="#">Cadastrar Aditivo</a>
                </div>							
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Consultas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Consultar Viagem</a>
                    <a class="dropdown-item" href="#">Consultar Passageiro</a>
                    <a class="dropdown-item" href="#">Consultar Pagamento</a>
                    <a class="dropdown-item" href="#">Consultar usuário</a>								
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Administrador
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                    <a class="dropdown-item" href="cadastrarUsuario.php">Cadastrar Usuário <span class="sr-only">(current)</a>
                
                    <a class="dropdown-item" href="#">Cadastrar Cargo <span class="sr-only">(current)</a>
                    
                    <a class="dropdown-item" href="#">Consultar</a>
                </div>							
            </li>
            <li class="nav-item">
                <a class="nav-link" href="inicio.php">Sair </span></a>
            </li>
        </ul>   
                    </div>
                </nav>
        </header>
	<body>
		<section class="col-md-auto">
			<div class="content-center">	
				<div>
					<a href="https://tjpr.jus.br">
						<img src="assets/img/tjpr.png" alt="Logo TJPR">
					</a>
				</div>
				<div>
					<?php						
						if(!empty($_SESSION['id_usuario'])){
							echo '<div id="menu">'."Olá ".$_SESSION['nome_completo'].",<br>".'</div>';
							echo '<div id="menu">'."Bem vindo(a) <br>".'</div>';
							echo '<div id="menu">'."<a href='sair.php'>Sair</a>".'</div>';
						}else{
							$_SESSION['msg'] = "Área restrita";
							header("Location: inicio.php");	
						}
					?>
				</div>
			</div>			
		</section>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="assets/css/bootstrap.min.css"></script>		
	</body>
	<footer>
    <div class="text-center">© Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens  
    </div>
    </footer>
</html>
