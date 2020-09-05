<?php

session_start();

ob_start();

include_once 'conexao.php';

$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);

if ($btnCadUsuario) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

    $result_usuario = "INSERT INTO tbl_usuario (id_pessoa, usuario, senha, status_usuario, funcao, unidade)VALUES (
		'" . $dados['id_pessoa'] . "',
		'" . $dados['usuario'] . "',
        '" . $dados['senha'] . "',
        '" . $dados['status_usuario'] . "',
        '" . $dados['funcao'] . "',
        '" . $dados['unidade'] . "'
       
		)";


    $resultado_passagem = $conn->prepare($result_usuario);
    $resultado_passagem->execute();

    header("Location: menu.php");

    /*if(pg_insert($conn)){
			$_SESSION['msgcad'] = "Contrato cadastrado com sucesso";
			header("Location: menu.php");
		}else{
			$_SESSION['msg'] = "Contrato já cadastrado";
			var_dump($conn);
            header("Location: cadusuario.php"); 
        }*/
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>CADASTRO DE USUÁRIO</title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

</head>

<body>
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
                        if (!empty($_SESSION['id_usuario'])) {
                            echo $_SESSION['nome_completo'] . " - " . $_SESSION['matricula'];
                        } else {
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
                            <a class="nav-link" href="menu.php" id="navbarSupportedContent" role="button"
                                aria-haspopup="true" aria-expanded="false" style="margin-right:.5rem">
                                <i class="fas fa-home"></i>
                                Início
                            </a>
                        </li>

                        <!-- Menu Cadastrar -->
                        <?php
                        if ($_SESSION['funcao'] < 3) {
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
                        if ($_SESSION['funcao'] == 1) {
                            echo '
                                                <a class="dropdown-item" href="cadcontrato.php">Contrato</a>
                                                <a class="dropdown-item" href="cadaditivo.php">Aditivo</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] < 3) {
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
                        if ($_SESSION['funcao'] == 1) {

                            echo '
                                                <a class="dropdown-item" href="editcontrato.php">Contrato</a>
                                                <a class="dropdown-item" href="edititem.php">Item de Contrato</a>
                                                <a class="dropdown-item" href="editaditivo.php">Aditivo</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                            </div>
                                        </li>
                                    ';
                        }
                        ?>
                        <?php
                        if ($_SESSION['funcao'] < 3) {
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Consultar
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="consultar_viagem.php">Viagem</a>
                                <a class="dropdown-item" href="consulta_passagem.php">Passagem</a>
                                <a class="dropdown-item" href="cadpessoa.php">Passageiro</a>
                                <a class="dropdown-item" href="consulta_pagamento.php">Pagamento</a>
                            </div>
                        </li>

                        <!-- Menu Administrador -->
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Administrador
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-left text-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadcidade.php">Cadastrar Cidade</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] == 1) {
                            echo '
                                                <a class="dropdown-item" href="cadusuario.php">Cadastrar Usuário</a>
                                                <a class="dropdown-item" href="cadcontrato.php">Cadastrar Contrato</a>
                                                <a class="dropdown-item" href="cadaditivo.php">Cadastrar Aditivo</a>
                                    ';
                        }
                        ?>
                        <?php
                        if ($_SESSION['funcao'] < 3) {
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
        <div class="content-center">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            if (isset($_SESSION['msgcad'])) {
                echo $_SESSION['msgcad'];
                unset($_SESSION['msgcad']);
            }
            ?>


            <form method="POST" action="">

                <h3>Novo Usuário</h3>
                <!-- Inicio Campos -->
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
                        while ($row_pessoa = $resultado_pessoa->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option value="' . $row_pessoa['id_pessoa'] . '">' . $row_pessoa['nome_completo'] . '</option>';
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
                            <option value="1">Departamento de Comunicação e Cerimonial</option>
                            <option value="2">Departamento do Patrimônio</option>
                            <option value="3">DP-DCA</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <!-- Início Select Situação -->
                    <div class="col-md-12">
                        <label id="date-side" for="funcao">Função</label>
                        <select class="custom-select" name="funcao" id="funcao">
                            <option selected="selected" disabled>Selecione</option>
                            <option value="1">Administrador</option>
                            <option value="2">Comprador</option>
                            <option value="3">Consultor</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <input type="submit" onclick="return checkSubmission()" value="Salvar"
                            name="btnCadUsuario"></input>
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Cancelar"></input>
                    </div>
                </div>
                <input type="hidden" class="form-control" name="status_usuario" id="status_usuario" value="ativo">
                <!-- Fim Campos -->
            </form>
        </div>
    </section>
    <footer>
        <div class="footer">©️ Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens
        </div>
    </footer>
    <!-- Verificar se o ja aconteceu um 'submit' -->
    <script>
    var submissionflag = false;

    function checkSubmission() {
        if (!submissionflag) {
            submissionflag = true;
            document.getElementById("btnsave").disabled = true;
            return true;
        } else {
            return false;
        }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="assets/css/bootstrap.min.css"></script>
    <script src="assets/js/jquery.mask.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#id_pessoa').select2();
    });
    </script>
</body>

</html>