<?php
session_start();

include 'conexao.php';

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Pesquisa de Passagem</title>
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" <link
        rel="stylesheet" href="assets/css/style.css">
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
                                <a class="dropdown-item" href="consulpassagem.php">Passagem</a>
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
        <div class="conteiner theme-showcase" role="main" style="margin-top: 6rem">
            <h1>Consulta de Passagens</h1>
            <?php

            //parâmetros para a paginação
            $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
            $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

            //qtde de linhas por páginas
            $qnt_result_pg = 12;

            // marcar OFFSET - inicio da visulalização
            $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

            //consulta banco e monta a tabela
            $result_passagem =
                "SELECT * FROM tbl_passagem
                                    LEFT JOIN tbl_pessoa
                                    ON tbl_passagem.id_pessoa = tbl_pessoa.id_pessoa
                                    LEFT JOIN tbl_item
                                    ON tbl_passagem.id_item = tbl_item.id_item
                                    LEFT JOIN tbl_viagem
                                    ON tbl_passagem.id_viagem = tbl_viagem.id_viagem
                                    LIMIT $qnt_result_pg
                                    OFFSET $inicio";

            $resultado_passagem = $conn->prepare($result_passagem);
            $resultado_passagem->execute();
            if ($resultado_passagem->rowCount() > 0) {

                echo '
                                    <table class="table table-striped">
                                    <tr>
                                        <th style="text-align: center">Pass.</th>
                                        <th style="text-align: center"> Passageiro</th>
                                        <th style="text-align: center"> SEI Compra</th>
                                        <th style="text-align: center"> Localizador</th>
                                        <th style="text-align: center">Origema</th>
                                        <th style="text-align: center"> Destino</th>
                                        <th style="text-align: center"> Ida</th>
                                        <th style="text-align: center">Situação</th>
                                        <th style="text-align: center"></th>
                                    </tr>';

                while ($row_passagem = $resultado_passagem->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                                        <tr>
                                            <td style="text-align: center">' . $row_passagem['id_passagem'] . '</td>
                                            <td name="nome_completo">&nbsp &nbsp ' . $row_passagem['nome_completo'] . '</td>
                                            <td style="text-align: center" name="protocolo_compra">' . $row_passagem['protocolo_compra'] . '</td>
                                            <td style="text-align: center" name="localizador">' . $row_passagem['localizador'] . '</td>
                                            <td style="text-align: center" name="origem">' . $row_passagem['origem'] . '</td>
                                            <td style="text-align: center" name="destino">' . $row_passagem['destino'] . '</td>
                                            <td style="text-align: center" name="data_ida">' . $row_passagem['data_ida'] . '</td>
                                            <td style="text-align: center" name="desconto_valor">' . $row_passagem['status_passagem'] . '</td>
                                            <td>
                                            <button class="btn btn-xs btn-info" type="button" data-toggle="modal" data-target="#myModal">Consultar</button>
                                            </td>
                                            <td>
                                            <button class="btn btn-xs btn-primary" type="button" data-toggle="modal" value="' . $row_passagem['id_passagem'] . '" data-target="#myModal">Editar</button>
                                            </td>
                                        ';
                    $nomecompleto = $row_passagem['nome_completo'];
                }
                echo '
                                        </tr>


                                                <!-- Início Modal -->
                                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">' . $row_passagem['nome_completo'] . '</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        ...
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                        </table>';
            ?>
            <?php
                // dados para paginação após consulta ao BD:
                //verifica banco e conta qtde de linhas
                $result_pg = "SELECT COUNT(id_passagem) AS num_result FROM tbl_passagem";
                $resultado_pg = $conn->prepare($result_pg);
                $resultado_pg->execute();
                $row_pg = $resultado_pg->fetch(PDO::FETCH_ASSOC);

                //calcula a qtde de páginas 
                $qtd_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
                //determina qtde de links antes e depois da página atual 
                $max_links = 2;
                // dados para paginação após consulta ao BD:
                //verifica banco e conta qtde de linhas
                $result_pg = "SELECT COUNT(id_passagem) AS num_result FROM tbl_passagem";
                $resultado_pg = $conn->prepare($result_pg);
                $resultado_pg->execute();
                $row_pg = $resultado_pg->fetch(PDO::FETCH_ASSOC);

                //calcula a qtde de páginas 
                $qtd_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
                //determina qtde de links antes e depois da página atual 
                $max_links = 2;
                //define primeira página
                echo "<div style='text-align: center'>";
                echo "<a href='consulta_passagem.php?pagina=1'><strong>Primeira  </strong></a>";
                //define páginas anteriores
                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                    if ($pag_ant >= 1) {
                        echo "<a href='consulta_passagem.php?pagina=$pag_ant'><strong>  $pag_ant  </strong></a>";
                    }
                };
                echo "$pagina";
                //define páginas posteriores
                for ($pag_post = $pagina + 1; $pag_post <= $pagina + $max_links; $pag_post++) {
                    if ($pag_post <= $qtd_pg) {
                        echo "<a href='consulta_passagem.php?pagina=$pag_post'><strong>  $pag_post  </strong></a>";
                    }
                }
                //define última página
                echo "<a href='consulta_passagem.php?pagina=$qtd_pg'><strong>  Última</strong></a>";
                echo '</div>';
                /*      echo '<nav aria-label="pagination">';
                                        echo '<ul class="pagination">';
                                                        //define primeira página
                                                        echo "<li class='page-item'>";
                                                        echo "<span class='page-link'><a href='consulta_passagem.php?pagina=1'>Primeira</a></span>";
                                                        echo '</li>';

                                                        //define páginas anteriores
                                                        for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant ++){
                                                            if($pag_ant >= 1){
                                                                echo "<li class='page-item'><a class='page-link' href='consulta_passagem.php?pagina=$pag_ant'>$pag_ant</a></li>";
                                                            }
                                                        };
                                                        echo '<li class="page-item"><span class="page-link">';
                                                        echo "$pagina";
                                                        echo '</span>';
                                                        echo '</li>';

                                                            //define páginas posteriores
                                                            for($pag_post = $pagina +1; $pag_post <= $pagina + $max_links; $pag_post ++){
                                                                if($pag_post <= $qtd_pg){
                                                                echo "<li class='page-item'><a class='page-link' href='consulta_passagem.php?pagina=$pag_post'>$pag_post</a></li> ";
                                                                }
                                                            }
                                                            //define última página
                                                            echo '<li class="page-item">';
                                                            echo "<span class='page-link'><a href='consulta_passagem.php?pagina=$qtd_pg'> Última</a></span>";
                                                            echo '</li>';
                                                        echo '</ul>';
                                                    echo '</nav>';      */
            }
            ?>
        </div>
    </section>
    <footer>
        <div class="footer">©️ Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script src="assets/css/bootstrap.min.css"></script>
</body>

</html>