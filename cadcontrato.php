<?php
	
	session_start();

    ob_start();
    
    include_once 'conexao.php';
	
	$btnCadContrato = filter_input(INPUT_POST, 'btnCadContrato', FILTER_SANITIZE_STRING);
	
	if($btnCadContrato){	
    
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

        $resultado_contrato = $conn->prepare($result_contrato);
        $resultado_contrato->execute();

		if(pg_insert($conn)){
			$_SESSION['msgcad'] = "Contrato cadastrado com sucesso";
			header("Location: caditem.php");
		}else{
			$_SESSION['msg'] = "Contrato já cadastrado";
			var_dump($conn);
			header("Location: caditem.php");
			
		}
		
	}

?>

<!DOCTYPE html>

<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <title>Cadastro de Contrato</title>
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

                        if(isset($_SESSION['msgcad'])){
                            echo $_SESSION['msgcad'];
                            unset($_SESSION['msgcad']);
                        }
                    ?>                                    
                    <form method="POST" action="">
                    <!-- Inicio Campos -->
                    <!--Linha 1 -->
                        <div class="row">
                            <h1 class="h1-side">Cadastro de Contrato</h1>
                        </div>
                    <!--Linha 2 -->
                        <div class="row">
                            <div class="col-md-4">
                                <label id="date-side" for="num_contrato">Número do Contrato</label>
                                <input type="text" class="form-control" name="num_contrato" id="num_contrato">
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
                    <!--Linha 3 -->    
                        <div class= "row">

                            <div class="col-md-6">
                                <label id="date-side" for="contratada">Nome da Empresa</label>
                                <input type="text" class="form-control" name="contratada" id="contratada">
                            </div>

                            <div class="col-md-6">
                                <label id="date-side" for="cnpj">CNPJ</label>
                                <input type="text" class="form-control" name="cnpj" id="cnpj" data-mask="00.000.000/0000-00" data-mask-selectonfocus="true">
                            </div>
                    <!--Linha 4 -->
                        </div>
                        <div class= "row">
                            <div class="col-md-6">
                                <label id="date-side" for="email_contratada">E-mail</label>
                                <input type="email" class="form-control" name="email_contratada" id="email_contratada">
                            </div>
                            <div class="col-md-6">
                                <label id="date-side" for="telefone">Telefone</label>
                                <input type="text" class="telefone form-control" name="telefone" id="telefone" data-mask="(00) 0000-0000" data-mask-selectonfocus="true"/>
                            </div>

                        </div>
                    <!--Linha 5 -->
                            <div class="row">
                            <div class="col-md-6">
                                <input type="submit" value="Salvar" name="btnCadContrato"></input>     
                            </div>
                            <div class="col-md-6">
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
            <script src="assets/js/jquery.mask.min.js"></script>
    </body>
    <footer>
        <br>
        <div class="text-center">© Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens  
        </div>
    </footer>  
</html>