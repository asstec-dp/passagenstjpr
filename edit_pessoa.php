<?php
session_start();
include_once("conexao.php");
$id_pessoa = filter_input(INPUT_GET, 'id_pessoa', FILTER_SANITIZE_NUMBER_INT);
$result_pessoa = "SELECT * FROM tbl_pessoa WHERE id_pessoa='$id_pessoa'";
$resultado_pessoa = pg_query($conn, $result_pessoa);
$row_pessoa = pg_fetch_assoc($resultado_pessoa);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>CRUD - Editar</title>		
	</head>
	<body>
		
		<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>

		<section class="col-md-auto">	
                <div class="content-center" id="conteiner">
                    <div class="row">
                        <h1>EDITAR PESSOA</h1>
                    </div> 
                                      
                    <form method="POST" action="proc_edit_pessoa.php">
                    
                        <!-- Inicio Campos -->
                        <div class="row">
                            <div class="col-md-6">                 
                                <input type="hidden" class="form-control" name="id_pessoa" id="id_pessoa" value="<?php echo $row_pessoa['id_pessoa']; ?>">                               
                            </div> 
                            <div class="col-md-6">                 
                                <input type="text" class="form-control" name="nome_completo" id="nome_completo" placeholder="Nome Completo" value="<?php echo $row_pessoa['nome_completo']; ?>">                               
                            </div>                        
                            <!-- Início Select Cargos -->
                            <div class="col-md-6">                 
                                <input type="text" class="form-control" name="cargo" id="cargo" placeholder="Cargo" value="<?php echo $row_pessoa['cargo']; ?>">                               
                            </div>  
                            <!-- Fim Select Cargos --> 
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="matricula" id="matricula" placeholder="Matrícula" value="<?php echo $row_pessoa['matricula']; ?>">
                            </div>
                        
                            <div class="col-md-4">
                                <input type="email" class="form-control" name="email_pessoa" id="email_pessoa" placeholder="E-mail" value="<?php echo $row_pessoa['email_pessoa']; ?>">
                            </div>

                            <div class="col-md-4">
                            	<input type="date" class="form-control" name="data_nascimento" id="data_nascimento" value="<?php echo $row_pessoa['data_nascimento']; ?>">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="C. P. F." value="<?php echo $row_pessoa['cpf']; ?>">
                            </div>
                        
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="rg" id="rg" placeholder="R. G." value="<?php echo $row_pessoa['rg']; ?>">
                            </div>
                        
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="passaporte" id="passaporte" placeholder="Passaporte" value="<?php echo $row_pessoa['passaporte']; ?>">
                            </div>
                            <div class="col-md-4">
                                <select class="custom-select" name="status_pessoa" id="inlineFormCustomSelectPref">
                                    <option name="status_pessoa" value="<?php echo $row_pessoa['status_pessoa']; ?>"></option>
                                    <option name="status_pessoa" value="ativo"selected>Ativo</option>
                                    <option name="status_pessoa" value="inativo">Inativo</option>
                                </select>  
                            </div>
                            
                        </div>
                        <div class="row">    
                            <input type="submit" id = "btnCadPessoa" value="Editar" name="btnCadPessoa"></input>
                        </div>
                        <!-- Fim Campos -->  
                    </form>
                    
                </div>
        </section>
	</body>
</html>