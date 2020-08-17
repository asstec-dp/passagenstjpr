<?php
session_start();

	ob_start();
	
	$btnCadViagem = filter_input(INPUT_POST, 'btnCadViagem', FILTER_SANITIZE_STRING);
	
	if($btnCadViagem){

		include_once 'conexao.php';
	
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		//var_dump($dados);
		//$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

		$result_viagem = "INSERT INTO tbl_viagem (id_usuario, id_contrato, protocolo_compra, evento, requisitante, grau, observacoes, status_viagem) VALUES (
		'" .$dados['id_usuario']. "',
		'" .$dados['id_contrato']. "',
		'" .$dados['protocolo_compra']. "',
		'" .$dados['evento']. "',
		'" .$dados['requisitante']. "',
        '" .$dados['grau']. "',
        '" .$dados['observacoes']. "',
        '" .$dados['status_viagem']. "'
		)";

		$resultado_viagem = pg_query($conn, $result_viagem);

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
                    <div class="row">
                        <h1 class="h1-side">Cadastro de Viagem</h1>
                    </div>
                        <!-- Inicio Campos -->
                           
                        <div class="row">
                            <!-- Select Comprador -->
                            <div class="col-md-4">
                            <?php
                            include_once 'conexao.php';
                                $sql = "SELECT tbl_usuario.id_usuario, tbl_usuario.id_pessoa, tbl_pessoa.id_pessoa, tbl_pessoa.nome_completo
                                FROM tbl_pessoa
                                INNER JOIN tbl_usuario ON tbl_pessoa.id_pessoa = tbl_usuario.id_pessoa
                                ORDER BY id_usuario";
                                 
                                 $resultado = pg_query($conn,$sql);
           
                                if (pg_num_rows($resultado)!=0){
                                    echo
                                    '<label id="date-side" for="id_usuario">Comprador</label>
                                    <select class="custom-select" name="id_usuario" id="id_usuario">
                                    <option value="id_usuario" selected="selected">Selecione</option>';
                                    while($elemento = pg_fetch_array($resultado))
                                    {
                                    $id_usuario = $elemento['id_usuario'];
                                    $nome_completo = $elemento['nome_completo'];
                                    echo '<option value="'.$id_usuario.'">'.$nome_completo.'</option>';
                                    }
                                    echo '</select>';
                                    }
                            ?>
                            </div>
                             <!-- Select Contrato -->
                            <div class="col-md-4">
                            <?php

                            $sql = "SELECT * FROM tbl_contrato ORDER BY id_contrato";
                                 $resultado = pg_query($conn,$sql);
           
                                if (pg_num_rows($resultado)!=0){
                                    echo '<label id="date-side" for="contrato">Contrato</label><select class="custom-select" name="id_contrato" id="id_contrato">
                                    <option value="id_contrato" selected="selected">Selecione</option>';
                                    while($elemento = pg_fetch_array($resultado))
                                    {
                                    $num_contrato = $elemento['num_contrato'];
                                    $id_contrato = $elemento['id_contrato'];
                                    echo '<option value="'.$id_contrato.'">'.$num_contrato.'</option>';
                                    }
                                    echo '</select>';
                                    }
                            ?> 
                            </div>  

                            <div class="form-group col-md-4">
                            <label id="date-side" for="protocolo_compra">Protocolo da Compra</label>
                            <input type="text" class="form-control" name="protocolo_compra" id="protocolo_compra" placeholder="Informe o Protocolo da Compra">
                            </div>
                      
                        <div class="row">
                            <!-- Início Select Grau -->
                            <div class="form-group col-md-4">
                                <label id="date-side" for="grau">Grau</label>
                                <select class="custom-select" name="grau" id="inlineFormCustomSelectPref">
                                <option selected enabled name="grau" value="2">2º Grau</option>
                                    <option name="grau" value="1">1º Grau</option>
                            </select>
                            </div> 
                            <!-- Fim Select Grau -->
                            <div class="form-group col-md-4">
                                <label id="date-side" for="status_viagem">Situação</label>
                                <select class="custom-select" name="status_viagem" id="inlineFormCustomSelectPref">
                                    <option selected enabled name="status_viagem" value="Ativa">Ativa</option>
                                    <option name="status_viagem" value="Cancelada">Cancelada</option>
                                </select>
                            </div>
                            <!-- Fim Select Status -->
                            <div class="form-group col-md-4">
                                <label id="date-side" for="requisitante">Requisitante</label>
                                <input type="text" class="form-control" name="requisitante" id="requisitante" placeholder="Opcional">
                            </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label id="date-side" for="evento">Evento</label>
                                <input type="text" class="form-control" name="evento" id="evento" placeholder="Descreva o evento ou motivo da viagem">
                                <label id="date-side" for="observacoes">Observações</label>
                                <input type="text" class="form-control" name="observacoes" id="observacoes" placeholder="Opcional">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                            <input type="submit" id = "btnCadViagem" value="Salvar" name="btnCadViagem"></input>
                            </div>
                            <div class="form-group col-md-6">  
                            <input type ="submit" id = "btnCadViagem" value ="Cancelar"></input>
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