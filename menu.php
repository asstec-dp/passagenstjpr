<?php
    session_start();
    include_once 'conexao.php';
?>

<!DOCTYPE html>

<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Viagem</title>
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
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
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

                        <a class="dropdown-item" href="cadusuario.php">Cadastrar Usuário <span class="sr-only">(current)</a>

                        <a class="dropdown-item" href="#">Consultar</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sair.php">Sair </span></a>
                </li>
            </ul>
                    </div>
                </nav>
        </header>
	<body>
        
            <div class="d-inline-block border border-primary">
                <?php

                    $result_item = "SELECT * FROM tbl_item ORDER BY descricao";

                    $resultado_item = $conn->prepare($result_item);
                    $resultado_item->execute();

                    while($row_item = $resultado_item->fetch(PDO::FETCH_ASSOC))
                        {                                
                            echo '<div id="menu">'."<strong>Item:</strong> ".$row_item['descricao'].
                            " - <strong>Valor Contratado:</strong> ".
                            number_format($row_item['valor_contratado'],2)." R$"."</div>";
                        }
                ?>
            </div>
            <div  class="d-inline-block border border-primary">
                <?php

                    $result_pas = "SELECT * FROM tbl_passagem WHERE status_passagem ILIKE 'ativa' ORDER BY data_ida";

                    $resultado_pas = $conn->prepare($result_pas);
                    $resultado_pas->execute();

                    while($row_passagem = $resultado_pas->fetch(PDO::FETCH_ASSOC))
                        {                                
                            echo '<div id="menu">'."<strong>Localizador:</strong> ".$row_passagem['localizador'].
                            " - <strong>Companhia:</strong> ".$row_passagem['companhia'].
                            " - <strong>Ida:</strong> ".$row_passagem['data_ida']."</div>";
                        }
                ?>
            </div>
        </div>

        <footer>
        <div class="text-center">© Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens
            </div>
        </footer>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="assets/css/bootstrap.min.css"></script>		
	</body>

</html>
