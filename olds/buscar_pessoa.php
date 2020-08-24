<?php
    session_start();
    include_once 'conexao.php';
?>

<h1>Pesquisar Pessoa</h1>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="pesquisar" placeholder="PESQUISAR">
	<input type="submit" name="submit" value="ENVIAR">
</form>

<?php
    
    $pesquisar = filter_input(INPUT_POST, 'pesquisar', FILTER_SANITIZE_STRING);

    //$pesquisar = $_POST['pesquisar'];
	$result_pessoas = "SELECT * FROM tbl_pessoa WHERE nome_completo ILIKE '%$pesquisar%' LIMIT 5";
    
    $resultado_pessoas = pg_query($conn, $result_pessoas);    

    $numRegistros = pg_num_rows($resultado_pessoas);
    
    if($numRegistros != 0){
        if (isset($_POST['submit'])) {
            while($rows_pessoas = pg_fetch_array($resultado_pessoas)){
                echo "Nome: ".$rows_pessoas['nome_completo']."<br>";
                echo "CPF: ".$rows_pessoas['cpf']."<br>";            
            
            }
        }
    }else{
        echo "pessoa não encontrada";
    }
    
    
    
	

    
	
?>