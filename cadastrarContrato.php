<?php
	
	session_start();

	ob_start();
	
	$btnCadContrato = filter_input(INPUT_POST, 'btnCadContrato', FILTER_SANITIZE_STRING);
	
	if($btnCadContrato){

		include_once 'conexao.php';
    
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		
		$result_contrato = "INSERT INTO tbl_contrato (num_contrato, contratada, cnpj, telefone, vigencia, email_contratada, status_contrato)  VALUES (
		'" .$dados['num_contrato']. "',
		'" .$dados['contratada']. "',
		'" .$dados['cnpj']. "',
		'" .$dados['telefone']. "',
		'" .$dados['vigencia']. "',
        '" .$dados['email_contratada']. "',
        '" .$dados['status_contrato']. "'
        )";       

        $resultado_contrato = pg_query($conn, $result_contrato);
        
		if(pg_insert($conn)){
			$_SESSION['msgcad'] = "Contrato cadastrado com sucesso";
			header("Location: cadastrarItem.php");
		}else{
			$_SESSION['msg'] = "Contrato já cadastrado";
			var_dump($conn);
			header("Location: cadastrarItem.php");
			
		}
		
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Contrato</title>
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

		<section class="col-md-auto">	
            <div class="content-center" id="conteiner">
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }

                    if(isset($_SESSION['msgcad'])){
                        echo $_SESSION['msgcad'];
                        unset($_SESSION['msgcad']);
                    }
                ?>                                    
                <form method="POST" action="">
                    <!-- Inicio Campos -->

                    <div class="row">
                        <h1 class="h1-side">Cadastro de Contrato</h1>
                    </div>

                    <div class="row"">
                        <div class="col-md-4">
                            <label id="date-side" for="num_contrato">Número do Contrato</label>
                            <input type="text" class="form-control" name="num_contrato" id="num_contrato" placeholder="Digite o número do contrato.">
                        </div>                          
                        <div class="col-md-4">
                            <label id="date-side" for="vigencia">Vigência</label>
                            <input type="date" class="form-control" name="vigencia" id="date-side">
                        </div>
                        <!-- Inicio Select Contrato -->
                        <div class="col-md-4">
                            <label id="date-side" for="status_contrato">Situação</label>
                            <select class="custom-select" name="status_contrato" id="inlineFormCustomSelectPref">
                                <option selected enabled>Vigente</option>
                                <option name="status_contrato" value="Vencido">Vencido</option>
                            </select>
                        </div>
                        <!-- Fim Select Contrato -->
                    </div>
                    
                    <div class= "row">

                        <div class="col-md-6">
                        <input type="text" class="form-control" name="contratada" id="contratada" placeholder="Nome da Empresa">
                        </div>

                        <div class="col-md-6">
                        <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="CNPJ">
                        </div>

                    </div>
                    <div class= "row">

                        <div class="col-md-6"><input type="email" class="form-control" name="email_contratada" id="email_contratada" placeholder="E-mail">
                        </div>

                        <div class="col-md-6"><input type="tel" class="form-control" name="telefone" id="telefone" placeholder="Telefone"/>
                        </div>

                    </div>

                        <div class="row">
                        <div class="form-group col-md-6">
                            <input type="submit" value="Salvar" name="btnCadContrato"></input>     
                        </div>
                        <div class="form-group col-md-6">
                            <input type ="submit" value ="Cancelar"></input>
                        </div>
                    </div>

                    <!-- Fim Campos -->    
                </form>                                          
            </div>
        </section>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="assets/css/bootstrap.min.css"></script>
		
    </body>
    <footer>
        <br>
        <div class="text-center">© Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens  
        </div>
    </footer>  
</html>