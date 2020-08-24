<?php
include_once './conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>TJPR</title>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    </head>
    <body>
        <h1>Pesquisar</h1>
        <form method="POST" action="">
            <label>Assunto: </label>
            <input type="text" name="pessoa" id="pessoa" placeholder="Pesquisar pelo assunto">

            <input type="submit" name="SendPesqMsg" value="Pesquisar">
        </form><br><br>
        <?php
            $SendPesqMsg = filter_input(INPUT_POST, 'SendPesqMsg', FILTER_SANITIZE_STRING);
            if ($SendPesqMsg) {                
                $pessoa = filter_input(INPUT_POST, 'pessoa', FILTER_SANITIZE_STRING);

                //SQL para selecionar os registros
                $result_msg_cont = "SELECT * FROM tbl_pessoa WHERE nome_completo LIKE '%" . $pessoa . "%' ORDER BY nome_completo ASC LIMIT 1";
                
                $resultado_msg_cont = $conn->prepare($result_msg_cont);
                $resultado_msg_cont->execute();

                while ($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)) {
                    echo "ID: " . $row_msg_cont['id_pessoa'] . "<br>";
                    echo "Nome: " . $row_msg_cont['nome_completo'] . "<br>";
                    echo "CPF: " . $row_msg_cont['cpf'] . "<br>";
                }               
                
            }
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <script>
            $(function () {
                $("#pessoa").autocomplete({
                    source: 'proc_buscar_passagem.php'
                });
            });
        </script>
    </body>
</html>
