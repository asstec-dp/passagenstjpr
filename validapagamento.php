<?php
session_start();

ob_start();

include_once 'conexao.php';

$btnValidaPagamento = filter_input(INPUT_POST, 'btnValidaPagamento', FILTER_SANITIZE_STRING);

$idpassagem = $_GET['id_passagem'];
$protocolo = $_GET['protocolo_pagamento'];
$notafiscal = $_GET['nota_fiscal'];
$fatura = $_GET['fatura'];
$totalfatura = $_GET['total_fatura'];


if ($btnValidaPagamento) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $result_pagamento = "INSERT INTO tbl_pagamento (id_passagem, protocolo_pagamento, nota_fiscal, fatura, total_fatura, obs_pagamento, data_notificacao, glosa, status_pagamento, valor_pago, id_usuario)
        VALUES (
        '" . $idpassagem . "',
        '" . $protocolo . "',
		'" . $notafiscal . "',
		'" . $fatura . "',
        '" . $totalfatura . "',
        '" . $dados['obs_pagamento'] . "',
        '" . $dados['data_notificacao'] . "',
        '" . $dados['glosa'] . "',
        '" . $dados['status_pagamento'] . "',
        '" . $dados['valor_pago'] . "',
        '" . $_SESSION['id_usuario'] . "'

        )";

    $resultado_pagamento = $conn->prepare($result_pagamento);
    $resultado_pagamento->execute();

    $result_update = "UPDATE tbl_passagem SET pagamento = true WHERE id_passagem = '$idpassagem'";
    $resultado_update = $conn->prepare($result_update);
    $resultado_update->execute();

    header("Location: atesto_geral.php");

    /*
        $_SESSION['msgcad'] = "Passagem cadastrada com sucesso";
        header("Location: atesto.php");
			
		}else{
			$_SESSION['msg'] = "Passagem não cadastrada.";
			header("Location: validapagamento.php");
		*/
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamentos</title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark">
            <!--Logo-->
            <img src="assets/img/logobco.png" type="image/png" width=80 height=50>
            <a style="color: #8A99A0; margin:0 2rem 0 1rem;font-size:small">
                <?php
                if (!empty($_SESSION['id_usuario'])) {
                    echo $_SESSION['nome_completo'] . " - " . $_SESSION['matricula'];
                } else {
                    header("Location: index.php");
                }
                ?>
            </a>
            <!--Menu Hamburger-->
            <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-target">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--navegação-->
            <div class="collapse navbar-collapse" id="nav-target">
                <ul class="navbar-nav ml-auto">
                    <!-- Menu Viagem -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="menu.php">Início</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Viagem
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="cadviagem.php">Cadastrar Viagem</a>
                            <a class="dropdown-item" href="cadpassagem.php">Cadastrar Passagem</a>
                            <a class="dropdown-item" href="cadpessoa.php">Cadastrar Passageiro</a>
                            <a class="dropdown-item" href="cadpagamento.php">Lançar Pagamento</a>
                        </div>
                    </li>
                    ';
                    }
                    ?>
                    <!-- Menu Contrato -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Contrato
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Consultar</a>
                            <?php
                            if ($_SESSION['funcao'] < 3) {
                                echo '
                                    <a class="dropdown-item" href="cadcontrato.php">Cadastrar <span class="sr-only"></a>
                                    <a class="dropdown-item" href="caditem.php">Cadastrar Itens</a>
                                    <a class="dropdown-item" href="#">Cadastrar Aditivo</a>
                                    
                                ';
                            }
                            ?>
                        </div>
                    </li>
                    <!-- Menu Consultas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Consultas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="consulta_viagem.php">Consultar Viagem</a>
                            <a class="dropdown-item" href="consulta_passagem.php">Consultar Passagem</a>
                            <a class="dropdown-item" href="consulta_pessoa.php">Consultar Passageiro</a>
                            <a class="dropdown-item" href="consulta_pagamento.php">Consultar Pagamento</a>
                        </div>
                    </li>
                    <!-- Menu Administrador -->
                    <?php
                    if ($_SESSION['funcao'] = 1) {
                        echo '
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Administrador
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="cadusuario.php">Cadastrar Usuário</a>
                                        <a class="dropdown-item" href="cadcidade.php">Cadastrar Cidade</a>
                                    </div>							
                                </li>
                                ';
                    }
                    ?>
                    <!-- Menu Sair -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="sair.php">Sair</span></a>
                    </li>
                </ul>
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
                <h1>Validar Pagamento</h1>
                <div class="row">
                    <?php
                    $result_passagem =
                        "SELECT * FROM tbl_passagem
                                LEFT JOIN tbl_pessoa
                                ON tbl_passagem.id_pessoa = tbl_pessoa.id_pessoa
                                LEFT JOIN tbl_item
                                ON tbl_passagem.id_item = tbl_item.id_item
                                WHERE tbl_passagem.id_passagem = $idpassagem";

                    $resultado_passagem = $conn->prepare($result_passagem);
                    $resultado_passagem->execute();
                    echo '
                        <input class="hidden" id="id_passagem" name="id_passagem" value="$idpassagem">
                            <table border="2    " style="margin: 0 0 0 0; border-color: #128588">
                                <tr style="background-color: #128588; color: white; text-align: center">
                                    <th>Passagem</th>
                                    <th style="width: 40rem">&nbsp &nbspPassageiro</th>
                                    <th style="width: 12rem">&nbsp Localizador</th>
                                    <th style="width: 15rem">Tarifa R$</th>
                                    <th style="width: 15rem">Taxa R$</th>
                                    <th style="width: 15rem">Desconto R$</th>
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
                                <td style="text-align: center">' . $idpassagem . '</td>
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
                <div class="row">
                    <div class="col-md-3">
                        <label id="date-side" for="valor_fatura">Valor Solicitado R$</label><br><br>
                        <input type="text" class="  form-control" name="valor_pagar" id="valor_pagar"
                            value="<?= $totalfatura; ?> " readonly>
                    </div>
                    <div class="col-md-3">
                        <label id="date-side" for="valor_apurado">Valor Apurado R$</label><br><br>
                        <input type="text" class="  form-control" name="valor_apurado" id="valor_apurado"
                            value="<?= round($vlrapurado, 2); ?> " readonly>

                    </div>
                    <div class="col-md-3">
                        <label id="date-side" for="glosa">Glosa R$</label><br><br>
                        <input type="text" class="  form-control" name="glosa" id="glosa"
                            value="<?= round($vrlglosa, 2); ?> " readonly>
                    </div>
                    <div class="col-md-3">
                        <label id="date-side" for="valor_pago">Valor Autorizado R$</label>
                        <input type="number" min="" step="any" class="form-control" name="valor_pago" id="valor_pago"
                            required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label id="date-side" for="data_notificacao">Notificação</label>
                        <input type="date" class="form-control" name="data_notificacao" id="data_notificacao">
                    </div>
                    <div class="col-md-9">
                        <label id="date-side" for="obs_pagamento">Observações do Pagamento</label>
                        <input type="text" class="  form-control" name="obs_pagamento" id="obs_pagamento"
                            maxlength="500">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="submit" onclick="return checkSubmission()" id="btnValidaPagamento" value="Salvar"
                            name="btnValidaPagamento" onclick="openNew()"></input>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" id="btnCancela" value="Cancelar"></input>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" id="btnConcluir" value="Concluir"></input>
                    </div>
                </div>
                <!-- Fim Campos -->
                <input type="hidden" class="form-control" name="status_pagamento" id="status_pagamento" value="ativo">
            </form>
        </div>
    </section>
    <footer>
        <br><br>
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
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="assets/css/bootstrap.min.css"></script>
    <script src="assets/js/jquery.mask.min.js"></script>
</body>

</html>