<?php
	
	session_start();

    ob_start();

    include_once 'conexao.php';
	
	$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
	
	if($btnCadUsuario){		
	
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		//var_dump($dados);
		//$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

		$result_usuario = "INSERT INTO tbl_usuario (id_pessoa, usuario, senha, unidade, status_usuario)VALUES (
		'" .$dados['id_pessoa']. "',
		'" .$dados['usuario']. "',
        '" .$dados['senha']. "',
        '" .$dados['unidade']. "',
        '" .$dados['status_usuario']. "'
		)";

        
        $resultado_passagem = $conn->prepare($result_usuario);
        $resultado_passagem->execute();

		if(pg_insert($conn, $result_usuario)){
			$_SESSION['msgcad'] = "Usuário cadastrado com sucesso";
			header("Location: menu.php");
			
		}else{
			$_SESSION['msg'] = "Usuário já cadastrado";
			header("Location: menu.php");
			
		}
		
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>CADASTRO DE USUÁRIO</title>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <link rel="shortcut icon" href="assets/img/icon.jpeg" type="image/png">
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
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">		
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
                                
                                <a class="dropdown-item" href="cadusuario.php">Cadastrar Usuário <span class="sr-only">(current)</a>
                                
                                <a class="dropdown-item" href="#">Consultar</a>
                            </div>							
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sair.php">Sair </span></a>
                        </li>
                    </ul>   
                </div>
            </nav>
        </header>
        <section class="col-md-auto">	
            <div class="content-center">
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
                            <div class="colum-md-6" id="h1">
                                <h3>Cadastro de Usuário</h3>
                            </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                    $result_pessoa = "SELECT id_pessoa, nome_completo
                                    FROM tbl_pessoa
                                    ORDER BY nome_completo ASC";
                                    
                                    $resultado_pessoa = $conn->prepare($result_pessoa);
                                    $resultado_pessoa->execute();

                                    echo
                                    '<label id="date-side" for="id_pessoa">Nome</label>
                                    <select class="custom-select" name="id_pessoa" id="id_pessoa">
                                    <option value="id_pessoa" selected="selected">Pesquisar</option>';
                                    while($row_pessoa = $resultado_pessoa->fetch(PDO::FETCH_ASSOC)){                    
                                        
                                        echo '<option value="'.$row_pessoa['id_pessoa'].'">'.$row_pessoa['nome_completo'].'</option>';

                                    }
                                    echo '</select>';
                                    
                                ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">                 
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Login">                               
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">                 
                                <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">                               
                            </div>
                        </div>
                        <div class="row">
                       <!-- Início Select Unidade -->
                            <div class="col-md-12">
                                <label id="date-side" for="unidade">Unidade</label>
                                <select class="custom-select" name="unidade" id="inlineFormCustomSelectPref">
                                    <option selected disabled>Selecione</option>
                                    <option value="Presidência">Presidência</option>
                                    <option value="Departamento do Patrimônio">Departamento do Patrimônio</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                        <!-- Início Select Situação -->
                            <div class="col-md-12">
                                <label id="date-side" for="status_usuario">Situação</label>
                                <select class="custom-select" name="status_usuario" id="inlineFormCustomSelectPref">
                                    <option value="ativa" selected enabled>Ativa</option>
                                    <option value="inativa">Inativa</option>
                                </select>
                            </div>
                        </div>
                        <!-- Fim Select Situação --> 
                        <br>
                        <div class="row"> 
                            <div class="col-md-6">
                                <input type="submit" value="Salvar" name="btnCadUsuario"></input>     
                            </div>
                            <div class="col-md-6">
                                <input type ="submit" value ="Cancelar"></input>
                            </div>
                        </div>
                            <!-- Fim Campos -->    
                </form>
            </div>                                         
        </section>

        <footer>
            <br><br>
            <div class="text-center">© Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens  
            </div>
        </footer>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
            <script src="assets/css/bootstrap.min.css"></script>
            <script src="assets/js/jquery.mask.min.js"></script>

            <script>
                $(document).ready(function() {
                $('#id_pessoa').select2();
                });
            </script>
    </body>
</html>