<?php
    session_start();

    ob_start();
    
    include_once 'conexao.php';
    
	$btnCadItem = filter_input(INPUT_POST, 'btnCadItem', FILTER_SANITIZE_STRING);

	if($btnCadItem){

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(empty($dados['desconto_valor'])){
            $dados['desconto_valor'] = 0.00;
        } 
        if(empty($dados['comissao_valor'])){
            $dados['comissao_valor'] = 0.00;
        } 
        if(empty($dados['desconto_percentual'])){
            $dados['desconto_percentual'] = 0.00;
        } 
        if(empty($dados['comissao_percentual'])){
            $dados['comissao_percentual'] = 0.00;
        } 

        
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

        
        $resultado_item = $conn->prepare($result_item);
        $resultado_item->execute();
        
		if(pg_insert($conn)){
			$_SESSION['msgcad'] = "Item cadastrado com sucesso";
			header("Location: caditem.php");
			
		}else{
			$_SESSION['msg'] = "Item já cadastrado";
			var_dump($conn);
			header("Location: caditem.php");
			
        }
		
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Itens</title>
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
                        <h1 class="h1-side">Itens de Contrato</h1>
                        </div>
                    <div class="row">
                        <!-- Select Contrato -->
                            <div class="col-md-2">
                            <?php
                            
                                $result_contrato = "SELECT * FROM tbl_contrato ORDER BY id_contrato";

                                    $resultado_contrato = $conn->prepare($result_contrato);
                                    $resultado_contrato->execute();

                                    
                                    
                                    echo '<label id="date-side" for="contrato">Contrato</label><select class="custom-select" name="id_contrato" id="id_contrato">
                                    <option value="id_contrato" selected="selected">Selecione</option>';

                                    while($row_contrato = $resultado_contrato->fetch(PDO::FETCH_ASSOC))
                                    {                                
                                        echo '<option value="'.$row_contrato['id_contrato'].'">'.$row_contrato['num_contrato'].'</option>';
                                    }
                                    echo '</select>';
                            ?>
                            </div>
                            <div class="col-md-5">
                                <label id="date-side" for="descricao">Descrição</label> 
                                <select class="custom-select" name="descricao" id="inlineFormCustomSelectPref">
                                    <option selected disabled>Selecione</option>
                                    <option name="descricao" value="Passagem Aérea Nacional">Passagem Aérea Nacional</option>
                                    <option name="descricao" value="Passagem Aérea Internacional">Passagem Aérea Internacional</option>
                                    <option name="descricao" value="Passagem Rodoviária Nacional">Passagem Rodoviária Nacional</option>
                                    <option name="descricao" value="Seguro Viagem Internacional">Seguro Viagem Internacional</option>

                                </select>                               
                            </div>
                            
                            <div class="col-md-2 ">
                            <label id="date-side" for="valor_contratado">Valor Total</label> 
                                <input type="text" min="" step="any" class="form-control" name="valor_contratado" id="valor_contratado" placeholder="0.00">
                            </div>

                            <!-- Select Situação --> 
                            <div class="col-md-3">
                                <label id="date-side" for="status_item">Situação</label> 
                                <select class="custom-select" name="status_item" id="inlineFormCustomSelectPref">
                                    <option selected enabled value="ativo">Ativo</option>
                                    <option name="status_item" value="inativo">Inativo</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                        
                            <div class="col-md-3 ">
                                <input type="text" min="" step="any" class="form-control" name="desconto_valor" id="desconto_valor" placeholder="Desconto em Valor Monetário">
                            </div>
                        
                            <div class="col-md-3 ">
                                <input type="text" min="" max="100" step="any" class="form-control" name="desconto_percentual" id="desconto_percentual" placeholder="Desconto em Percentual">
                            </div>
                            
                            <div class="col-md-3 ">
                            </div>
                                                        
                        </div>
                      
                        <div class= "row">

                            <div class="col-md-3 ">
                                <input type="text" min="" step="any" class="form-control" name="comissao_valor" id="comissao_valor" placeholder="Comissão em Valor Monetário">
                            </div>
                        
                            <div class="col-md-3 ">
                                <input type="text" min="" max="100" step="any" class="form-control" name="comissao_percentual" id="comissao_percentual" placeholder="Comissão em Percentual">
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
        <script src="assets/js/jquery.mask.min.js"></script>
        
		
    </body>
    <footer>
        <br>
        <div class="text-center">© Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens  
        </div>
    </footer>  
</html>