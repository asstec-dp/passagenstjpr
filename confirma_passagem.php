<?php

session_start();

ob_start();

include_once 'conexao.php';


$resultultimo = "SELECT MAX(id_passagem) AS id_passagem FROM tbl_passagem INNER JOIN tbl_viagem
    ON tbl_passagem.id_viagem = tbl_viagem.id_viagem";
$resultado_ultimo = $conn->prepare($resultultimo);
$resultado_ultimo->execute();

while ($row_passagem = $resultado_ultimo->fetch(PDO::FETCH_ASSOC)) {

    $viagem = $row_passagem['id_viagem'];
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cofirmar Passagem</title>

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
        <div class="content-center" id="conteiner">
            <form method="POST">
                <h1>Validar Pagamento</h1>
                <div class="row">
                    <?php
                    $result_passagem =
                        "SELECT MAX(id_passagem) AS id_passagem 
                                LEFT JOIN tbl_pessoa
                                ON tbl_passagem.id_pessoa = tbl_pessoa.id_pessoa
                                LEFT JOIN tbl_item
                                ON tbl_passagem.id_item = tbl_item.id_item

                    $resultado_passagem = $conn->prepare($result_passagem);
                    $resultado_passagem->execute();
                    echo '

                            <table>
                                <tr>
                                    <th>Passagem</th>
                                    <th>&nbsp &nbspPassageiro</th>
                                    <th>Tarifa R$</th>
                                    <th>&nbsp Localizador</th>
                                    <th>Taxa R$</th>
                                    <th>Desconto R$</th>
                                </tr>';

                    while ($row_passagem = $resultado_passagem->fetch(PDO::FETCH_ASSOC)) {
                        $tarifa = $row_passagem['tarifa_voucher'];
                        $taxas = $row_passagem['taxas_voucher'];
                        $devalor = $row_passagem['desconto_valor'];
                        $comvalor = $row_passagem['comissao_valor'];
                        $desper = $row_passagem['desconto_percentual'];
                        $comper = $row_passagem['comissao_percentual'];


                        echo '
                                <tr>
                                <td style="text-align: center">' . $idviagem . '</td>
                                    <td name="nome_completo">&nbsp &nbsp ' . $row_passagem['nome_completo'] . '</td>
                                    <td style="text-align: center" name="localizador">' . $row_passagem['localizador'] . '</td>
                                    <td style="text-align: center" name="tarifa_voucher">' . $row_passagem['tarifa_voucher'] . '</td>
                                    <td style="text-align: center" name="taxas_voucher">' . $row_passagem['taxas_voucher'] . '</td>
                                    <td style="text-align: center" name="desconto_valor">' . $row_passagem['desconto_valor'] . '</td>
                                    
                                </tr>   
                                </table>';
                    }
                    //valor Apurado  
                    $trftx = $tarifa + $taxas;
                    $comissaperc = (($trftx  * $comper) / 100) + $trftx;
                    $descperc = $comissaperc - (($comissaperc *  $desper) / 100);
                    $comisvalor = $descperc + $comvalor;
                    $vlrapurado = $comisvalor - $devalor;

                    //valor Glosa

                    $vrlglosa = $totalfatura - $vlrapurado;
                    if ($vrlglosa < 0.05) {
                        $vrlglosa = 0;
                    }
                    ?>
                </div>
        </div>
    </section>
    <footer>
        <div class=" footer">©️ Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens
        </div>
    </footer>
</body>

</html>