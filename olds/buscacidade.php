<?php
    session_start();

    ob_start();
    
    include_once 'conexao.php';
	
	$btnCadViagem = filter_input(INPUT_POST, 'btnCadViagem', FILTER_SANITIZE_STRING);
	
	if($btnCadViagem){		
	
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		//var_dump($dados);
		//$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

		$result_viagem = "INSERT INTO tbl_viagem (id_usuario, id_contrato, protocolo_compra, evento, requisitante, grau, observacoes, status_viagem) VALUES (
		'" .$dados['id_usuario']. "',
		'" .$dados['id_contrato']. "',
		'" .$dados['protocolo_compra']. "',
		'" .$dados['evento']. "',
		'" .$dados['requisitante']. "',
        '" .$dados['grau']. "',
        '" .$dados['observacoes']. "',
        '" .$dados['status_viagem']. "'
		)";

        
        $resultado_viagem = $conn->prepare($result_viagem);
        $resultado_viagem->execute();

		if(pg_insert($conn, $result_viagem)){
			$_SESSION['msgcad'] = "Pessoa cadastrada com sucesso";
			header("Location: cadastrarViagem.php");
			
		}else{
			$_SESSION['msg'] = "Pessoa já cadastrada";
			header("Location: cadastrarViagem.php");
			
		}
		
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    
</head>
<body>

                            <div class="col-md-6">
                                <label id="date-side" for="cargo">Cargo</label> 
                                <select class="custom-select" id="cargo">
                                    <option selected disabled>Selecione</option>
                                    <option name="cargo" value="Desembargador">Desembargador</option>
                                    <option name="cargo" value="Juiz">Juiz</option>
                                    <option name="cargo" value="Servidor">Servidor</option>
                                    <option name="cargo" value="Estagiário">Estagiário</option>
                                    <option name="cargo" value="Externo">Externo</option>
                                </select>  
                            </div>

                            <!-- Select Comprador -->
                            <div class="col-md-4">
                                <?php
                                    $result_usuario = "SELECT tbl_usuario.id_usuario, tbl_usuario.id_pessoa, tbl_pessoa.id_pessoa, tbl_pessoa.nome_completo
                                    FROM tbl_pessoa
                                    INNER JOIN tbl_usuario ON tbl_pessoa.id_pessoa = tbl_usuario.id_pessoa
                                    ORDER BY id_usuario";
                                    
                                    $resultado_usuario = $conn->prepare($result_usuario);
                                    $resultado_usuario->execute();

                                    echo
                                    '<label id="date-side" for="id_usuario">Comprador</label>
                                    <select class="custom-select" name="id_usuario" id="id_usuario">
                                    <option value="id_usuario" selected="selected">Selecione</option>';
                                    while($row_usuario = $resultado_usuario->fetch(PDO::FETCH_ASSOC)){                    
                                        
                                        echo '<option value="'.$row_usuario['id_usuario'].'">'.$row_usuario['nome_completo'].'</option>';

                                    }
                                    echo '</select>';
                                    
                                ?>
                            </div>

                <script>
            $(document).ready(function() {
            $('#cargo').select2();
            $('#id_usuario').select2();
            });
        </script>

</body>
</html>