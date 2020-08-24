<?php
    session_start();

    ob_start();
    
    include_once 'conexao.php';
	
	$btnCadPagamento = filter_input(INPUT_POST, 'btnCadPagamento', FILTER_SANITIZE_STRING);
	
	if($btnCadPagamento){		
	
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		//var_dump($dados);
		//$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

		$result_pagamento = "INSERT INTO tbl_pagamento (id_viagem, id_pessoa, id_item, data_compra, origem, destino, data_ida, data_retorno, companhia, localizador, tarifa_voucher, taxas_voucher, classe, status_passagem)VALUES (
		'" .$dados['id_viagem']. "',
		'" .$dados['id_pessoa']. "',
		'" .$dados['id_item']. "',
		'" .$dados['data_compra']. "',
		'" .$dados['origem']. "',
        '" .$dados['destino']. "',
        '" .$dados['data_ida']. "',
        '" .$dados['data_retorno']. "',
        '" .$dados['companhia']. "',
        '" .$dados['localizador']. "',
        '" .$dados['tarifa_voucher']. "',
        '" .$dados['taxas_voucher']. "',
        '" .$dados['classe']. "',
        '" .$dados['status_passagem']. "'
		)";

        
        $resultado_pagamento = $conn->prepare($result_pagamento);
        $resultado_pagamento->execute();

		if(pg_insert($conn, $result_pagamento)){
			$_SESSION['msgcad'] = "Passagem cadastrada com sucesso";
			header("Location: cadviagem.php");
			
		}else{
			$_SESSION['msg'] = "Passagem já existente do banco de dados";
			header("Location: cadviagem.php");
			
		}
		
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamentos</title>

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
                            <div class="row">
                                <h1 class="h1-side">Pagamento</h1>
                            </div>
                            <div class="row">
                                <!-- Select Viagem -->
                                <div class="col-md-3">
                                    <?php
                                        $result_passagem = "SELECT tbl.passagem.id_passagem, tbl_passagem.id_viagem, tbl_viagem.id_viagem, tbl_viagem.protocolo_compra
                                        FROM tbl_viagem
                                        INNER JOIN tbl_passagem ON tbl_viagem.id_viagem = tbl_passagem.id_viagem
                                        ORDER BY id_viagem DESC";
                                        
                                        $resultado_passagem = $conn->prepare($result_passagem);
                                        $resultado_passagem->execute();

                                        echo
                                        '<label id="date-side" for="id_pessoa">Protocolo da Viagem</label>
                                        <select class="custom-select" name="id_viagem" id="id_viagem">
                                        <option value="id_viagem" selected="selected">Pesquisar</option>';
                                        while($row_passagem = $resultado_passagem->fetch(PDO::FETCH_ASSOC)){                    
                                            
                                            echo '<option value="'.$row_passagem['id_viagem'].'">'.$row_passagem['protocolo_compra'].'</option>';

                                        }
                                        echo '</select>';
                                        
                                    ?>
                                </div>
                                <!-- Select Passageiro -->
                                <div class="col-md-6">
                                    <?php
                                         $result_passageiro = "SELECT tbl_passagem.id_passagem, tbl_passagem.id_pessoa, tbl_pessoa.id_pessoa, tbl_pessoa.nome_completo
                                         FROM tbl_pessoa
                                         INNER JOIN tbl_passagem ON tbl_pessoa.id_pessoa = tbl_passagem.id_pessoa
                                         ORDER BY nome_completo";
                                        
                                        $resultado_passageiro = $conn->prepare($result_passageiro);
                                        $resultado_passageiro->execute();

                                        echo
                                        '<label id="date-side" for="id_pessoa">Passageiro</label>
                                        <select class="custom-select" name="id_pessoa" id="id_pessoa">
                                        <option value="id_pessoa" selected="selected">Pesquisar</option>';
                                        while($row_passageiro = $resultado_passageiro->fetch(PDO::FETCH_ASSOC)){                    
                                            
                                            echo '<option value="'.$row_passageiro['id_pessoa'].'">'.$row_passageiro['nome_completo'].'</option>';

                                        }
                                        echo '</select>';
                                        
                                    ?>
                                </div>
                                    <!-- Select Item -->
                                <div class="col-md-3">
                                    <?php
                                        $result_item = "SELECT id_item, descricao
                                        FROM tbl_item
                                        ORDER BY id_item";
                                        
                                        $resultado_item = $conn->prepare($result_item);
                                        $resultado_item->execute();

                                        echo
                                        '<label id="date-side" for="id_item">Tipo</label>
                                        <select class="custom-select" name="id_item" id="id_item">
                                        <option value="id_item" selected="selected">Selecionar</option>';
                                        while($row_item = $resultado_item->fetch(PDO::FETCH_ASSOC)){                    
                                            
                                            echo '<option value="'.$row_item['id_item'].'">'.$row_item['descricao'].'</option>';

                                        }
                                        echo '</select>';
                                        
                                    ?>
                                </div>
                                      
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label id="date-side" for="data_compra">Data de Compra</label>
                                    <input type="date" class="form-control" name="data_compra" id="data_compra">
                                </div>
                                <div class="col-md-4">
                                    <label id="date-side" for="companhia">Companhia</label>                 
                                    <input type="text" class="form-control" name="companhia" id="companhia" maxlength="48">                               
                                </div>
                                <div class="col-md-4">
                                    <label id="date-side" for="localizador">Localizador</label>                 
                                    <input type="text" class="form-control" name="localizador" id="localizador" maxlength="15">                               
                                </div>
                            
                            </div>
                            <div class="row">
                                <!-- Select Origem -->
                                <div class="col-md-6">
                                    <?php
                                        $result_cidade = "SELECT origem, destino
                                        FROM tbl_cidade
                                        ORDER BY origem ASC";
                                        
                                        $resultado_cidade = $conn->prepare($result_cidade);
                                        $resultado_cidade->execute();

                                        echo
                                        '<label id="date-side" for="origem">Origem</label>
                                        <select class="custom-select" name="origem" id="origem">
                                        <option selected="selected">Pesquisar</option>';
                                        while($row_origem = $resultado_cidade->fetch(PDO::FETCH_ASSOC)){                    
                                            
                                            echo '<option name="origem" value="'.$row_origem['origem'].'">'.$row_origem['origem'].'</option>';

                                        }
                                        echo '</select>';
                                        
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        $resultado_cidade = $conn->prepare($result_cidade);
                                        $resultado_cidade->execute();
                                        echo
                                        '<label id="date-side" for="destino">Destino</label>
                                        <select class="custom-select" name="destino" id="destino">
                                        <option selected="selected">Pesquisar</option>';
                                        while($row_destino = $resultado_cidade->fetch(PDO::FETCH_ASSOC)){                    
                                            
                                            echo '<option value="'.$row_destino['destino'].'">'.$row_destino['destino'].'</option>';

                                        }
                                        echo '</select>';
                                        
                                    ?>
                                </div>  
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label id="date-side" for="data_ida">Data de Ida</label>
                                    <input type="date" class="form-control" name="data_ida" id="data_ida">
                                </div>
                                <div class="col-md-6">
                                    <label id="date-side" for="data_retorno">Data de Retorno</label>
                                    <input type="date" class="form-control" name="data_retorno" id="data_retorno">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 ">
                                    <label id="date-side" for="tarifa_voucher">Preço da Passagem (sem as taxas)</label> 
                                    <input type="text" min="" step="any" class="form-control" name="tarifa_voucher" id="tarifa_voucher">
                                </div>
                                <div class="col-md-3 ">
                                    <label id="date-side" for="taxas_voucher">Taxa de Embarque (e outras)</label> 
                                    <input type="text" min="" step="any" class="form-control" name="taxas_voucher" id="taxas_voucher">
                                </div>
                                <div class="col-md-3">
                                    <label id="date-side" for="classe">Classe da Passagem</label> 
                                    <select class="custom-select" name="classe" id="classe">
                                        <option value="normal" selected enabled>Normal</option>
                                        <option value="cúpula">Cúpula</option>
                                    </select>  
                                </div>
                                <div class="col-md-3">
                                    <label id="date-side" for="status_passagem">Situação</label> 
                                    <select class="custom-select" name="status_passagem" id="status_passagem">
                                        <option value="ativa" selected enabled>Ativa</option>
                                        <option value="cancelada">Cancelada</option>
                                    </select>  
                                </div>
                                    <div class="col-md-4">
                                        <input type="submit" id = "btnCadPagamento" value="Salvar" name="btnCadPagamento"></input>
                                    </div>
                                    <div class="col-md-4">  
                                        <input type ="submit" id = "btnCancela" value ="Cancelar"></input>
                                    </div>
                                    <div class="col-md-4">  
                                    <input type ="submit" id = "btnConcluir" value ="Concluir"></input>
                        </div>
                        <!-- Fim Campos -->  
                
                            </div>
                    </form>
            </div>
    </section>
    <footer>
        <br><br>
        <div class="text-center">© Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens  
        </div>
    </footer>   

                <script>
                    $(document).ready(function() {
                    $('#id_pessoa').select2();
                    $('#id_viagem').select2();
                    $('#origem').select2();
                    $('#destino').select2();
                    });
                 </script>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="assets/css/bootstrap.min.css"></script>
        <script src="assets/js/jquery.mask.min.js"></script>
	

</body>
</html>