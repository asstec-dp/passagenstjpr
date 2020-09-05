<?php
include_once './conexao.php';
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Celke - Listar Contatos</title>
    </head>
    <body>
        <h1>Listar Mensagem</h1>
        <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        //SQL para selecionar os registros
        $result_msg_cont = "SELECT * FROM tbl_pessoa ORDER BY id_pessoa ASC";

        //Seleciona os registros
        $resultado_msg_cont = $conn->prepare($result_msg_cont);
        $resultado_msg_cont->execute();

        while ($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)) {
            echo "ID: " . $row_msg_cont['id_pessoa'] . "<br>";
            echo "Nome: " . $row_msg_cont['nome_completo'] . "<br>";
            echo "Matricula: " . $row_msg_cont['matricula'] . "<br>";
            echo "Cargo: " . $row_msg_cont['cargo'] . "<br>";
            echo "E-mail: " . $row_msg_cont['email_pessoa'] . "<br>";
            echo "Data de nascimento: " . $row_msg_cont['data_nascimento'] . "<br>";
            echo "C. P. F: " . $row_msg_cont['cpf'] . "<br>";
            echo "R.G: " . $row_msg_cont['rg'] . "<br>";
            echo "Passaporte: " . $row_msg_cont['passaporte'] . "<br>";
            echo "Status: " . $row_msg_cont['status_pessoa'] . "<br>";

            echo "<a href='editar_pessoa.php?id_pessoa=".$row_msg_cont['id_pessoa']."'>Editar</a><br><hr>";
        }
        ?>
    </body>
</html>
