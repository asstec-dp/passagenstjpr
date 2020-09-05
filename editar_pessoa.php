<?php
session_start();
include_once './conexao.php';

$id_pessoa = filter_input(INPUT_GET, 'id_pessoa', FILTER_SANITIZE_NUMBER_INT);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Editar Pessoa</title>

        <link rel="shortcut icon" href="assets/img/icon.png" type="image/png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/sidebar.css">
        <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    </head>

    <body>
        <?php
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            //SQL para selecionar o registro
            $result_msg_cont = "SELECT * FROM tbl_pessoa WHERE id_pessoa=$id_pessoa";
            
            //Seleciona os registros
            $resultado_msg_cont = $conn->prepare($result_msg_cont);
            $resultado_msg_cont->execute();
            $row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC); 
        
        ?>
        <header>
            <nav class="navbar fixed-top navbar-expand-md navbar-dark">
                <div class="header">
                    <div class="logo">
                        <img src="assets/img/logobco.png" type="image/png" width=80>
                    </div>
                    <div class="session">                    
                        <a id="session">
                            <i class="fas fa-user"></i>
                            <?php
                                if(!empty($_SESSION['id_usuario'])){
                                    echo $_SESSION['nome_completo']." - ".$_SESSION['matricula'];
                                }else{
                                    header("Location: index.php");   	
                                }
                            ?>
                        </a>
                    </div>              				                
                    <!--Logo-->                      
                    <div class="buttonHamb">
                        <!--Menu Hamburger-->
                        <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-target">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <!--navegação-->
                    <div class="collapse navbar-collapse" id="nav-target">
                        <ul class="navbar-nav ml-auto">

                            <!-- início -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="menu.php" id="navbarSupportedContent" role="button" aria-haspopup="true" aria-expanded="false" style="margin-right:.5rem">
                                <i class="fas fa-home"></i>
                                Início
                                </a>
                            </li>

                            <!-- Menu Cadastrar -->
                            <?php
                                if($_SESSION['funcao'] < 3){
                                    echo '                            
                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Cadastrar
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadviagem.php">Viagem</a>
                                                <a class="dropdown-item" href="cadpassagem.php">Passagem</a>
                                                <a class="dropdown-item" href="cadpessoa.php">Passageiro</a>
                                    ';
                                }
                                if ($_SESSION['funcao'] == 1){
                                    echo '
                                                <a class="dropdown-item" href="cadcontrato.php">Contrato</a>
                                                <a class="dropdown-item" href="cadaditivo.php">Aditivo</a>
                                    ';
                                }
                                if($_SESSION['funcao'] < 3){
                                    echo '
                                            </div>
                                        </li>
                                        
                                        <!-- Menu Editar -->

                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Editar
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="editviagem.php">Viagem</a>
                                                <a class="dropdown-item" href="editpassagem.php">Passagem</a>
                                                <a class="dropdown-item" href="editpessoa.php">Passageiro</a>
                                    ';
                                }                                
                                if ($_SESSION['funcao'] == 1){

                                    echo '
                                                <a class="dropdown-item" href="editcontrato.php">Contrato</a>
                                                <a class="dropdown-item" href="edititem.php">Item de Contrato</a>
                                                <a class="dropdown-item" href="editaditivo.php">Aditivo</a>
                                    ';
                                }
                                if($_SESSION['funcao'] < 3){
                                    echo '
                                            </div>
                                        </li>
                                    '; 
                                }
                            ?>
                            <?php
                                if($_SESSION['funcao'] < 3){
                                    echo '
                                        <!--Menu Pagamento -->
                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Pagamento
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadpagamento.php">Lançar</a>
                                                <a class="dropdown-item" href="editpagamento.php">Alterar</a>
                                            </div>
                                        </li>
                                    ';
                                }
                            ?>

                            <!-- Menu Consultar -->
                            <li class="nav-item dropdown">                            
                                <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Consultar
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="consultar_viagem.php">Viagem</a>
                                    <a class="dropdown-item" href="consulpassagem.php">Passagem</a>
                                    <a class="dropdown-item" href="cadpessoa.php">Passageiro</a>
                                    <a class="dropdown-item" href="consulta_pagamento.php">Pagamento</a>
                                </div>
                            </li>

                            <!-- Menu Administrador -->
                            <?php
                                if($_SESSION['funcao'] < 3){
                                    echo '
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Administrador
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-left text-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadcidade.php">Cadastrar Cidade</a>
                                    ';
                                }
                                if($_SESSION['funcao'] == 1){
                                    echo '
                                                <a class="dropdown-item" href="cadusuario.php">Cadastrar Usuário</a>
                                                <a class="dropdown-item" href="cadcontrato.php">Cadastrar Contrato</a>
                                                <a class="dropdown-item" href="cadaditivo.php">Cadastrar Aditivo</a>
                                    ';
                                }
                            ?>
                            <?php
                                if($_SESSION['funcao'] < 3){
                                    echo '
                                            </div>							
                                        </li>
                                    ';
                                }
                            ?>

                            <!-- Menu Sair -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="sair.php">
                                    <span>Sair</span>
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>                                    
                            </li>
                        </ul>
                    </div>                                             
                </div>
            </nav>
        </header>
        
        <section class="col-md-auto">	
            <div class="content-center" id="conteiner">
                <form method="POST" action="proc_edit_pessoa.php">
                    <h1>Editar Pessoa</h1>
                    <input type="hidden" name="id_pessoa" value="<?php if(isset($row_msg_cont['id_pessoa'])){ echo $row_msg_cont['id_pessoa']; } ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <label id="date-side" for="nome_completo">Nome Completo</label>
                            <input type="text" class="form-control" name="nome_completo" placeholder="Inserir o nome completo" id="nome_completo"  maxlength="100" value="<?php if(isset($row_msg_cont['nome_completo'])){ echo $row_msg_cont['nome_completo']; } ?>">
                        </div>
                        <!-- Início Select Cargos -->
                        <div class="col-md-4">
                            <label id="date-side" for="cargo">Cargo</label>
                            <select class="custom-select" name="cargo" id="cargo">
                                <option selected><?php if(isset($row_msg_cont['cargo'])){ echo $row_msg_cont['cargo']; } ?></option>
                                <option name="cargo" value="Desembargador">Desembargador</option>
                                <option name="cargo" value="Juiz">Juiz</option>
                                <option name="cargo" value="Servidor">Servidor</option>
                                <option name="cargo" value="Estagiário">Estagiário</option>
                                <option name="cargo" value="Externo">Externo</option>
                            </select>  
                        </div> 
                    </div> 

                    <div class="row">
                        <div class="col-md-5 ">
                            <label id="date-side" for="cpf">C.P.F.</label>   
                            <input type="text" class="cpf form-control" name="cpf" id="cpf" required="required" data-mask="000.000.000-00" data-mask-selectonfocus="true" value="<?php if(isset($row_msg_cont['cpf'])){ echo $row_msg_cont['cpf']; } ?>">
                        </div>
                        
                        <div class="col-md-4">
                            <label id="date-side" for="rg">R.G.</label> 
                            <input type="text" name="rg" maxlength="14"  placeholder="C. P. F" value="<?php if(isset($row_msg_cont['rg'])){ echo $row_msg_cont['rg']; } ?>">
                        </div>

                        <div class="col-md-3">
                            <label id="date-side" for="data_nascimento">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" value="<?php if(isset($row_msg_cont['data_nascimento'])){ echo $row_msg_cont['data_nascimento']; } ?>">
                        </div>
                    </div>
                    <div class= "row">
                        <div class="col-md-5">
                            <label id="date-side" for="email_pessoa">Email</label>
                            <input type="email" name="email_pessoa" placeholder="Seu melhor e-mail" id="email_pessoa" value="<?php if(isset($row_msg_cont['email_pessoa'])){ echo $row_msg_cont['email_pessoa']; } ?>">
                        </div>

                        <div class="col-md-4">
                            <label id="date-side" for="matricula">Matrícula</label>
                            <input type="text" name="matricula" placeholder="Inserir a matricula" id="matricula" value="<?php if(isset($row_msg_cont['matricula'])){ echo $row_msg_cont['matricula']; } ?>">
                        </div>
                        <div class="col-md-3">
                            <label id="date-side" for="passaporte">Passaporte</label>
                            <input type="text" name="passaporte" placeholder="Passaporte" id="passaporte" value="<?php if(isset($row_msg_cont['passaporte'])){ echo $row_msg_cont['passaporte']; } ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label id="date-side" name="passaporte" for="passaporte">Status:</label>
                        <input type="text" name="status_pessoa" placeholder="Status" value="<?php if(isset($row_msg_cont['status_pessoa'])){ echo $row_msg_cont['status_pessoa']; } ?>"> 
                    </div>     
                    <input name="SendEditCont" type="submit" value="Editar">
                
                </form>
            </div>
        </section>
        <footer>
            <div class="footer">©️ Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens  
            </div>
        </footer>
       <!-- Verificar se o ja aconteceu um 'submit' -->
       
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="assets/css/bootstrap.min.css"></script>
        <script src="assets/js/jquery.mask.min.js"></script>
        
    </body>
</html>
