<?php

    session_start();

	ob_start();
	
	$btnCadPessoa = filter_input(INPUT_POST, 'btnCadPessoa', FILTER_SANITIZE_STRING);
	
	if($btnCadPessoa){

		include_once 'conexao.php';
	
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		//var_dump($dados);
		//$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

		$result_pessoa = "INSERT INTO tbl_pessoa (nome_completo, matricula, cargo, email_pessoa, data_nascimento, cpf, rg, passaporte, status_pessoa) VALUES (
		'" .$dados['nome_completo']. "',
		'" .$dados['matricula']. "',
		'" .$dados['cargo']. "',
		'" .$dados['email_pessoa']. "',
		'" .$dados['data_nascimento']. "',
        '" .$dados['cpf']. "',
        '" .$dados['rg']. "',
        '" .$dados['passaporte']. "',
        '" .$dados['status_pessoa']. "'
		)";

        $resultado_pessoa = pg_query($conn, $result_pessoa);
        
		if(pg_insert($conn)){
			$_SESSION['msgcad'] = "Pessoa cadastrada com sucesso";
			header("Location: menu.php");
			
		}else{
			$_SESSION['msg'] = "Pessoa já cadastrada";
			var_dump($conn);
			header("Location: menu.php");
			
        }
		
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Passageiro</title>
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
                        <h1 class="h1-side">Cadastro de Passageiro</h1>
                    </div> 
                        <!-- Inicio Campos -->
                        <div class="row">
                            <div class="col-md-5">                 
                                <input type="text" class="form-control" name="nome_completo" id="nome_completo" placeholder="Nome Completo">                               
                            </div>
                                          
                            <!-- Início Select Cargos -->
                            <div class="col-md-4">
                                <select class="custom-select" name="cargo" id="inlineFormCustomSelectPref">
                                    <option selected disabled>Cargo</option>
                                    <option name="cargo" value="Desembargador">Desembargador</option>
                                    <option name="cargo" value="Juiz">Juiz</option>
                                    <option name="cargo" value="Servidor">Servidor</option>
                                    <option name="cargo" value="Estagiário">Estagiário</option>
                                    <option name="cargo" value="Externo">Externo</option>
                                </select>  
                            </div> 
                            <!-- Fim Select Cargos --> 
                            <!-- Início Select Situação --> 
                            <div class="col-md-3">
                                <select class="custom-select" name="status_pessoa" id="inlineFormCustomSelectPref">
                                <option selected disabled>Situação</option>
                                    <option name="status_pessoa" value="Ativa">Ativa</option>
                                    <option name="status_pessoa" value="Inativa">Inativa</option>
                                </select>
                                </div>
                            <!-- Fim Select Situação --> 
                        </div>
                        <div class="row">

                            <div class="col-md-5 ">
                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="C. P. F.">
                            </div>
                        
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="rg" id="rg" placeholder="R. G.">
                            </div>
                        
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" placeholder="Data de Nascimento">
                                <label>Data de Nascimento</label> </div>
                            
                        </div>
                      
                        <div class= "row">

                            <div class="col-md-5">
                                <input type="email" class="form-control" name="email_pessoa" id="email_pessoa" placeholder="E-mail">
                            </div>

                            <div class="col-md-4">
                                <input type="text" class="form-control" name="matricula" id="matricula" placeholder="Matrícula">
                            </div>     
                     
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="passaporte" id="passaporte" placeholder="Passaporte">
                            </div>

                        </div>

                        <div class= "row">
                            <div class="form-group col-md-6">    
                            <input type="submit" id = "btnCadPessoa" value="Salvar" name="btnCadPessoa"></input>
                            </div>

                            <div class="form-group col-md-6">
                            <input type ="submit" id = "btnCadPessoa" value ="Cancelar"></input>
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