<?php
    session_start();
    include_once 'conexao.php';
?>

<h1>Pesquisar Pessoa</h1>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="pesquisar_pessoa" placeholder="PESQUISAR">
	<input type="submit" name="submit_pessoa" value="ENVIAR">
</form>

<h1>Pesquisar Viagem</h1>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="pesquisar_viagem" placeholder="Pesquisar Viagem">
	<input type="submit" name="submit_viagem" value="ENVIAR">
</form>

<h1>Pesquisar Item</h1>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="pesquisar_item" placeholder="Pesquisar item">
	<input type="submit" name="submit_item" value="ENVIAR">
</form>

<h1>Pesquisar Origem</h1>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="pesquisar_origem" placeholder="Pesquisar origem">
	<input type="submit" name="submit_origem" value="ENVIAR">
</form>

<h1>Pesquisar Destino</h1>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="pesquisar_destino" placeholder="Pesquisar destino">
	<input type="submit" name="submit_destino" value="ENVIAR">
</form>

<?php
    //inicio pesquisar Pessoa
    $pesquisar_pessoa = filter_input(INPUT_POST, 'pesquisar_pessoa', FILTER_SANITIZE_STRING);

	$result_pessoas = "SELECT * FROM tbl_pessoa WHERE nome_completo ILIKE '%$pesquisar_pessoa%' OR cpf = '$pesquisar_pessoa' LIMIT 5";
    
    $resultado_pessoas = pg_query($conn, $result_pessoas);    

    $numRegistros = pg_num_rows($resultado_pessoas);
    
    if($numRegistros != 0){
        if (isset($_POST['submit_pessoa'])) {
            while($rows_pessoas = pg_fetch_array($resultado_pessoas)){
                echo "Nome: ".$rows_pessoas['nome_completo']."<br>";
                echo "CPF: ".$rows_pessoas['cpf']."<br>";      
            }
        }
    }else{
        echo "Pessoa não encontrada";
    }
    //Final pesquisar Pessoa

    //inicio pesquisar Viagem
    $pesquisar_viagem = filter_input(INPUT_POST, 'pesquisar_viagem', FILTER_SANITIZE_STRING);

	$result_viagem = "SELECT * FROM tbl_viagem WHERE protocolo_compra ILIKE '%$pesquisar_viagem%' LIMIT 1";
    
    $resultado_viagem = pg_query($conn, $result_viagem);    

    $numRegistrosViagens = pg_num_rows($resultado_viagem);
    
    if($numRegistrosViagens != 0){
        if (isset($_POST['submit_viagem'])) {
            while($rows_viagem = pg_fetch_array($resultado_viagem)){
                echo "Protocolo: ".$rows_viagem['protocolo_compra']."<br>"; 
                echo "Evento: ".$rows_viagem['evento']."<br>";           
            }
        }
    }else{
        echo "Protocolo não encontrado";
    }
    //Final pesquisar Viagem

    //inicio pesquisar item
    $pesquisar_item = filter_input(INPUT_POST, 'pesquisar_item', FILTER_SANITIZE_STRING);

	$result_item = "SELECT * FROM tbl_item WHERE descricao ILIKE '%$pesquisar_item%' LIMIT 1";
    
    $resultado_item = pg_query($conn, $result_item);    

    $numRegistrosItens = pg_num_rows($resultado_item);
    
    if($numRegistrosItens != 0){
        if (isset($_POST['submit_item'])) {
            while($rows_item = pg_fetch_array($resultado_item)){
                echo "Descrição: ".$rows_item['descricao']."<br>";    
            }
        }
    }else{
        echo "Item não encontrado";
    }
    //Final pesquisar Item

    //inicio pesquisar origem
    $pesquisar_origem = filter_input(INPUT_POST, 'pesquisar_origem', FILTER_SANITIZE_STRING);

	$result_origem = "SELECT * FROM tbl_cidade WHERE cidade ILIKE '%$pesquisar_origem%' LIMIT 1";
    
    $resultado_origem = pg_query($conn, $result_origem);    

    $numRegistrosOrigem = pg_num_rows($resultado_origem);
    
    if($numRegistrosOrigem != 0){
        if (isset($_POST['submit_origem'])) {
            while($rows_origem = pg_fetch_array($resultado_origem)){
                echo "Origem: ".$rows_origem['cidade']."<br>";     
            }
        }
    }else{
        echo "Origem não encontrada";
    }
    //Final pesquisar origem

    //inicio pesquisar Destino
    $pesquisar_destino = filter_input(INPUT_POST, 'pesquisar_destino', FILTER_SANITIZE_STRING);

	$result_destino = "SELECT * FROM tbl_cidade WHERE cidade ILIKE '%$pesquisar_destino%' LIMIT 1";
    
    $resultado_destino = pg_query($conn, $result_destino);    

    $numRegistrosDestino = pg_num_rows($resultado_destino);
    
    if($numRegistrosDestino != 0){
        if (isset($_POST['submit_destino'])) {
            while($rows_destino = pg_fetch_array($resultado_destino)){
                echo "destino: ".$rows_destino['cidade']."<br>";           
            }
        }
    }else{
        echo "Destino não encontrada";
    }
    //Final pesquisar origem

?>