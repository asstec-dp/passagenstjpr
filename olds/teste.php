<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Teste</title>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    </head>
    <body>
    <h1>Pesquisar</h1>
    <form method="Post" action="">
    <label>Nome Completo</lable>
    <input type="text" name="nome_completo" id="nome_completo" placeholder="Pesquise o nome">
    
    </form>
        <?php

        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
        $(function(){
            $("#nome_completo").autocomplete({
                source: 'proc_pesq_msg.php'
            });
        });
            </script>
    </body>
</html>