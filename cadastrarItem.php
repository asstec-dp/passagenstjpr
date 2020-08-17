<?php
session_start();

	ob_start();
    
	$btnCadItem = filter_input(INPUT_POST, 'btnCadItem', FILTER_SANITIZE_STRING);

	if($btnCadItem){

        include_once 'conexao.php';

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
		$result_item = "INSERT INTO tbl_item (id_contrato, descricao, valor_contratado, desconto_valor, comissao_valor, desconto_percentual, comissao_percentual, status_item) VALUES (
		'" .$dados['id_contrato']. "',
		'" .$dados['descricao']. "',
		'" .$dados['valor_contratado']. "',
		'" .$dados['desconto_valor']. "',
		'" .$dados['comissao_valor']. "',
        '" .$dados['desconto_percentual']. "',
        '" .$dados['comissao_percentual']. "',
        '" .$dados['status_item']. "'
		)";

        $resultado_item = pg_query($conn, $result_item);
        
		if(pg_insert($conn)){
			$_SESSION['msgcad'] = "Item cadastrado com sucesso";
			header("Location: cadastrarItem.php");
			
		}else{
			$_SESSION['msg'] = "Item já cadastrado";
			var_dump($conn);
			header("Location: cadastrarItem.php");
			
        }
		
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Itens</title>
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
                                    <a class="dropdown-item" href="#">Cadastrar Passageiro</a>
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
                                    <a class="dropdown-item" href="#">Cadastrar Itens</a>
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
                                    
                                    <a class="dropdown-item" href="#">Cadastrar Usuário <span class="sr-only">(current)</a>
                                
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
                        <h1 class="h1-side">Cadastro de Itens do Contrato</h1>
                        </div>
                    <div class="row">
                        <!-- Select Contrato -->
                            <div class="col-md-2">
                            <?php
                            include_once 'conexao.php';
                            $sql = "SELECT * FROM tbl_contrato ORDER BY id_contrato";
                                 $resultado = pg_query($conn,$sql);
           
                                if (pg_num_rows($resultado)!=0){
                                    echo '<label id="date-side" for="id_contrato">   Contrato</label><select class="custom-select" name="id_contrato" id="id_contrato">
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
                            <div class="col-md-5">
                                <label id="date-side" for="descricao">Descrição do Item</label>                 
                                <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Digite a descrição do item">                               
                            </div>
                            
                            <div class="col-md-2 ">
                            <label id="date-side" for="valor_contratado">Valor Total</label> 
                                <input type="number" min="" step="any" class="form-control" name="valor_contratado" id="valor_contratado" placeholder="0.00">
                            </div>

                            <!-- Select Situação --> 
                            <div class="col-md-3">
                                <label id="date-side" for="status_item">Situação</label> 
                                <select class="custom-select" name="status_item" id="inlineFormCustomSelectPref">
                                <option selected enabled>Ativo</option>
                                    <option name="status_item" value="Inativo">Inativo</option>
                                </select>
                                </div>

                        </div>
                        <div class="row">
                        
                            <div class="col-md-3 ">
                                <input type="number" min="" step="any" class="form-control" name="desconto_valor" id="desconto_valor" placeholder="Desconto em Valor Monetário">
                            </div>
                        
                            <div class="col-md-3 ">
                                <input type="number" min="" max="100" step="any" class="form-control" name="desconto_percentual" id="desconto_percentual" placeholder="Desconto em Percentual">
                            </div>
                            
                            <div class="col-md-3 ">
                            </div>
                                                        
                        </div>
                      
                        <div class= "row">

                            <div class="col-md-3 ">
                                <input type="number" min="" step="any" class="form-control" name="comissao_valor" id="comissao_valor" placeholder="Comissão em Valor Monetário">
                            </div>
                        
                            <div class="col-md-3 ">
                                <input type="number" min="" max="100" step="any" class="form-control" name="comissao_percentual" id="comissao_percentual" placeholder="Comissão em Percentual">
                            </div>
                        
                            <div class="col-md-3 ">
                            </div>

                        </div>

                        <div class= "row">
                            <div class="form-group col-md-4">    
                            <input type="submit" id = "btnCadItem" value="Salvar" name="btnCadItem"></input>
                            </div>

                            <div class="form-group col-md-4">
                            <input type ="submit" id ="btnCancelar" value ="Cancelar"></input>
                            </div>

                            <div class="form-group col-md-4">
                            <input type ="submit" id ="btnConcluir" value ="Concluir"></input>
                            </div>
                           
                        </div>
                        <!-- Fim Campos -->  
                    </form>
                    
                </div>
                </div>
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