<?php
session_start();

ob_start();

include_once 'conexao.php';

$btnCadAditivo = filter_input(INPUT_POST, 'btnCadAditivo', FILTER_SANITIZE_STRING);

if ($btnCadAditivo) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $result_aditivo = "INSERT INTO tbl_aditivo (id_contrato, num_aditivo, id_item, valor_aditivo, nova_vigencia, status_aditivo, id_usuario) VALUES (
                '" . $dados['id_contrato'] . "',
                '" . $dados['num_aditivo'] . "',
                '" . $dados['id_item'] . "',
                '" . $dados['valor_aditivo'] . "',
                '" . $dados['nova_vigencia'] . "',
                '" . $dados['status_aditivo'] . "',
                '" . $_SESSION['id_usuario'] . "'
                
                )";

    $resultado_aditivo = $conn->prepare($result_aditivo);
    $resultado_aditivo->execute();



    $novavigencia = $dados['nova_vigencia'];
    $valoraditivo = $dados['valor_aditivo'];
    $item = $dados['id_item'];
    $valoratual = $dados['valor_atual'];
    $novovalor = $valoratual + $valoraditivo;


    $result_updateItem = "UPDATE tbl_item SET valor_contratado = '$novovalor' WHERE id_item = '$item'";
    $resultado_updateItem = $conn->prepare($result_updateItem);
    $resultado_updateItem->execute();

    $result_updateContrato = "UPDATE tbl_contrato SET vigencia = '$novavigencia' WHERE status_contrato = 'vigente'";
    $resultado_updateContrato = $conn->prepare($result_updateContrato);
    $resultado_updateContrato->execute();
    header("Location: cadaditivo.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aditivo</title>

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
        <div class="content-center" id="conteiner">
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

            <form method="POST">

                <h1>Aditivo de Contrato</h1>

                <div class="row">
                    <!-- Select Contrato -->
                    <div class="col-md-4">
                        <?php
                        $result_contrato = "SELECT *
                                    FROM tbl_contrato
                                    WHERE tbl_contrato.status_contrato LIKE 'vigente'
                                    ORDER BY id_contrato";

                        $resultado_contrato = $conn->prepare($result_contrato);
                        $resultado_contrato->execute();

                        echo
                            '<label id="date-side" for="id_contrato">Contrato</label>
                                    <select class="custom-select" name="id_contrato" id="id_contrato">
                                    <option disabled>Selecione</option>';
                        while ($row_contrato = $resultado_contrato->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option selected="selected"  value="' . $row_contrato['id_contrato'] . '">' . $row_contrato['num_contrato'] . '</option>';
                        }
                        echo '</select>';

                        ?>
                    </div>

                    <!--Número do Aditivo-->
                    <div class="col-md-4">
                        <label id="date-side" for="num_aditivo">Número do Aditivo</label>
                        <input type="text" class="form-control" name="num_aditivo" id="num_aditivo" maxlength="8"
                            required="required" placeholder="000/AAAA">
                    </div>
                    <!-- Nova Vigência -->
                    <div class="col-md-4">
                        <label id="date-side" for="nova_vigencia">Vigência</label>
                        <input type="date" class="form-control" name="nova_vigencia" id="nova_vigencia">
                    </div>
                </div>


                <div class="row">
                    <!-- Select Item -->
                    <div class="col-md-4">
                        <?php
                        $result_item = "SELECT *
                                    FROM tbl_item
                                    WHERE tbl_item.status_item LIKE 'ativo'
                                    ORDER BY id_item";

                        $resultado_item = $conn->prepare($result_item);
                        $resultado_item->execute();

                        echo
                            '<label id="date-side" for="id_item">Item</label>
                                    <select class="custom-select" name="id_item" id="id_item" onChange="update()">
                                    <option selected="selected" disabled>Selecionar</option>';
                        while ($row_item = $resultado_item->fetch(PDO::FETCH_ASSOC)) {

                            echo '<option value="' . $row_item['id_item'] . '">' . $row_item['descricao'] . '</option>';
                        }
                        echo '</select>';


                        ?>
                    </div>

                    <!-- Valor Atual-->
                    <div class="col-md-4 ">
                        <label id="date-side" for="valor_atual">Valor Total Anterior do Item R$</label>
                        <input type="number" min="" step="0.01" class="form-control" name="valor_atual" id="valor_atual">
                    </div>
                    <!-- Valor Aditivo-->
                    <div class="col-md-4 ">
                        <label id="date-side" for="valor_aditivo">Valor do Aditado R$</label>
                        <input type="number" min="" step="0.00" class="form-control" name="valor_aditivo"
                            id="valor_aditivo">
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <input type="submit" onclick="return checkSubmission()" id="btnCadAditivo" value="Salvar"
                                name="btnCadAditivo"></input>
                        </div>
                        <div class="col-md-6">
                            <input type="submit" id="btnConcluir" href="menu.php" value="Concluir"></input>

                        </div>
                        <input type="hidden" class="form-control" name="status_aditivo" id="status_aditivo"
                            value="ativo">
                        <!-- Fim Campos -->
            </form>
        </div>
    </section>
    <footer>
        <div class="footer">©️ Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens
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


</body>

</html>