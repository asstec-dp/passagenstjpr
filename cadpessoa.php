<?php

    session_start();

	ob_start();
    include_once 'conexao.php';
    
	$btnCadPessoa = filter_input(INPUT_POST, 'btnCadPessoa', FILTER_SANITIZE_STRING);
	
	if($btnCadPessoa){
	
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
        
        $resultado_pessoa = $conn->prepare($result_pessoa);
        $resultado_pessoa->execute();
        
        
		if($resultado_pessoa->execute()){
			$_SESSION['msgcad'] = "Pessoa cadastrada com sucesso";
			header("Location: cadpessoa.php");
			
		}else{
			$_SESSION['msg'] = "Pessoa já cadastrada";
			var_dump($conn);
			header("Location: cadpessoa.php");
			
        }
		
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Passageiro</title>
        <link rel="shortcut icon" href="assets/img/ico.png" type="image/png">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>	
        <header>					                
            <nav class="navbar navbar-expand-sm navbar-dark">
                <div class="col-md-4" >
                    <img src="assets/img/logobco.png" type="image/png" width=80 height=50>
                    <a style="color: #8A99A0; margin-left: 2rem;">
                        <strong>
                            <?php
                                echo $_SESSION['nome_completo']." - ".$_SESSION['matricula'];
                            ?>
                        </strong>
                    </a>
                </div>
                <div class="row">
                    <div>
                    <?php						
                        if(empty($_SESSION['id_usuario'])){
                            $_SESSION['msg'] = "Área restrita";
                            header("Location: index.php");	
                        }
                        ?> 
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <!-- Menu Viagem -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Viagem
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="cadviagem.php">Cadastrar Viagem</a>
                                <a class="dropdown-item" href="cadpessoa.php">Cadastrar Passageiro</a>
                                <a class="dropdown-item" href="#">Lançar Pagamento</a>
                            </div>
                        </li>
                        <!-- Menu Contrato -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Contrato
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="cadcontrato.php">Cadastrar <span class="sr-only"></a>
                                <a class="dropdown-item" href="#">Consultar</a>
                                <a class="dropdown-item" href="caditem.php">Cadastrar Itens</a>
                                <a class="dropdown-item" href="#">Cadastrar Aditivo</a>
                            </div>							
                        </li>
                        <!-- Menu Consultas -->
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
                        <!-- Menu Administrador -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administrador
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                
                                <a class="dropdown-item" href="cadusuario.php">Cadastrar Usuário <span class="sr-only">(current)</a>
                                
                                <a class="dropdown-item" href="#">Consultar</a>
                            </div>							
                        </li>
                        <!-- Menu Sair -->
                        <li class="nav-item">
                            <a class="nav-link" href="sair.php">Sair</span></a>
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
                ?>     

                <form method="POST" action="">
                    <!-- Inicio Campos -->

                    <div class="row">
                        <h1 class="h1-side">Cadastro de Pessoa</h1>
                    </div> 
                        <!-- Inicio Campos -->
                        <div class="row">
                            <div class="col-md-5">
                                <label id="date-side" for="nome_completo">Nome Completo</label>                  
                                <input type="text" class="form-control" name="nome_completo" id="nome_completo">                               
                            </div>
                                          
                            <!-- Início Select Cargos -->
                            <div class="col-md-4">
                                <label id="date-side" for="cargo">Cargo</label> 
                                <select class="custom-select" name="cargo" id="inlineFormCustomSelectPref">
                                    <option selected disabled>Selecione</option>
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
                                <label id="date-side" for="status_pessoa">Situação</label> 
                                <select class="custom-select" name="status_pessoa" id="inlineFormCustomSelectPref">
                                    <option value="Ativa" selected enabled>Ativa</option>
                                    <option name="status_pessoa" value="Inativa">Inativa</option>
                                </select>
                                </div>
                            <!-- Fim Select Situação --> 
                        </div>
                        <div class="row">

                            <div class="col-md-5 ">
                                <label id="date-side" for="cpf">C.P.F.</label>
                                <input type="text" class="cpf form-control" name="cpf" id="cpf" data-mask="000.000.000-00" data-mask-selectonfocus="true"/>
                            </div>
                        
                            <div class="col-md-4">
                                <label id="date-side" for="rg">R.G.</label>                                
                                <input type="text" class="form-control" name="rg" id="rg">
                            </div>
                        
                            <div class="col-md-3">
                                <label id="date-side" for="data_nascimento">Data de Nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" id="data_nascimento">
                            </div>
                            
                        </div>
                      
                        <div class= "row">

                            <div class="col-md-5">
                                <label id="date-side" for="email_pessoa">Email</label>      
                                <input type="email" class="form-control" name="email_pessoa" id="email_pessoa">
                            </div>

                            <div class="col-md-4">
                                <label id="date-side" for="matricula">Matrícula</label> 
                                <input type="text" class="form-control" name="matricula" id="matricula" data-mask="00000" data-mask-selectonfocus="true"/>
                            </div>     
                     
                            <div class="col-md-3">
                                <label id="date-side" for="passaporte">Passaporte</label> 
                                <input type="text" class="form-control" name="passaporte" id="passaporte">
                            </div>

                        </div>

                        <div class= "row">
                            <div class="form-group col-md-4">    
                            <input type="submit" id = "btnCadPessoa" value="Salvar" name="btnCadPessoa"></input>
                            </div>

                            <div class="form-group col-md-4">
                            <input type ="submit" id = "btnCadPessoa" value ="Cancelar"></input>
                            </div>
                                <form name="concluir" method="post" action="inicio.php">
                                    <div class="form-group col-md-4">
                                    <input type ="submit" id = "btnConcluir" value ="Concluir"></input>
                                    </div>
                                </form>
                        </div>
                        <!-- Fim Campos -->  
                    </form>
                    
                </div>
        </section>
        <footer>
            <br>
            <div class="text-center">© Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens  
            </div>
        </footer>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="assets/css/bootstrap.min.css"></script>
        <script src="assets/js/jquery.mask.min.js"></script>
		
    </body>
</html>