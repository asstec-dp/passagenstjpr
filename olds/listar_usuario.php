<?php
session_start();
include_once 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>LISTAR USUÁRIOS</title>		
	</head>
	<body>
		<section class="col-md-auto">	
                <div class="content-center" id="conteiner">
                    <div class="row">
                        <h1>LISTAR USUÁRIOS</h1>
                    </div> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        
                        // Receber o número da página
                        $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);

                        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

                        //Setar a quantidade de itens por página
                        $qnt_result_pg = 3;

                        //Calcular o inicio visualização
                        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

                        $result_usuario = "SELECT *
                        /*tbl_usuario.id_usuario, tbl_usuario.usuario, tbl_usuario.senha, tbl_usuario.unidade, tbl_usuario.status_usuario, tbl_usuario.registro, tbl_pessoa.nome_completo, tbl_pessoa.matricula*/
		                FROM tbl_pessoa 
		                JOIN tbl_usuario ON tbl_pessoa.id_pessoa = tbl_usuario.id_pessoa ORDER BY tbl_pessoa.nome_completo OFFSET
                         $inicio LIMIT $qnt_result_pg";

                        $resultado_usuario = pg_query($conn, $result_usuario);
                        while($row_usuario = pg_fetch_assoc($resultado_usuario)){
                            echo "ID USUARIO: " . $row_usuario['id_usuario']."<br>";
                            //echo "ID PESSOA: " . $row_usuario['id_pessoa']."<br>";
                            echo "NOME: " . $row_usuario['nome_completo']."<br>";
                            echo "MATRICULA: " . $row_usuario['matricula']."<br>";
                            echo "USUARIO: " . $row_usuario['usuario']."<br>";
                            echo "SENHA: " . $row_usuario['senha']."<br>";
                            echo "UNIDADE: " . $row_usuario['unidade']."<br>";
                            echo "Status: " . $row_usuario['status_usuario']."<br>";
                            //echo "REGISTRO: " . $row_usuario['registro']."<br>";
                            //echo "CARGO: " . $row_usuario['cargo']."<br>";
                            //echo "E-MAIL: " . $row_usuario['email_pessoa']."<br>";
                            //echo "DATA DE NASCIMENTO: " . $row_usuario['data_nascimento']."<br>";
                            //echo "C. P. F.: " . $row_usuario['cpf']."<br>";
                            //echo "R. G.: " . $row_usuario['rg']."<br>";
                            //echo "PASSAPORTE: " . $row_usuario['passaporte']."<br>";
                            //echo "Status: " . $row_usuario['status_pessoa']."<br>";
                            echo "<a href='edit_usuario.php?id_usuario=" . $row_usuario['id_usuario'] . "'>Editar</a><br>";
                            echo "<a href='proc_apagar_pessoa.php?id_usuario=" . $row_usuario['id_usuario'] . "'>Apagar</a><br><hr>";
                        }

                        //Paginação - Somar a quantidade de usuários
                        $result_pg = "SELECT COUNT(id_usuario) AS num_result FROM tbl_usuario";
                        $resultado_pg = pg_query($conn, $result_pg);
                        $row_pg = pg_fetch_assoc($resultado_pg);
                        //echo $row_pg['num_result'];
                        //Quantidade de página
                        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

                        //Limitar os links antes depois
                        $max_links = 2;
                        echo "<a href='listar_usuario.php?pagina=1'>Primeira</a> ";

                            for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
                                if($pag_ant >= 1){
                                    echo "<a href='listar_usuario.php?pagina=$pag_ant'>$pag_ant</a> ";
                                }                                
                            }

                        echo "$pagina ";

                        for($pag_post = $pagina + 1; $pag_post <= $pagina + $max_links; $pag_post++){
                            if($pag_post <= $quantidade_pg){
                                echo "<a href='listar_usuario.php?pagina=$pag_post'>$pag_post</a> ";
                            }                                
                        }
                        echo "<a href='listar_usuario.php?pagina=$quantidade_pg'>Última</a> ";
                    ?>
                     <!--                 
                    <form method="POST" action="processa.php">
                    
                        Inicio Campos
                        <div class="row">
                            <div class="col-md-6">                 
                                <input type="text" class="form-control" name="nome_completo" id="nome_completo" placeholder="Nome Completo">                               
                            </div>                        
                             Início Select Cargos
                            <div class="col-md-4">
                                <select class="custom-select" name="cargo" id="inlineFormCustomSelectPref">
                                    <option selected disabled>Cargo</option>
                                    <option name="cargo" value="Desembargador">Desembargador</option>
                                    <option name="cargo" value="Magistrado">Magistrado</option>
                                    <option name="cargo" value="Servidor">Servidor</option>
                                    <option name="cargo" value="Estagiário">Estagiário</option>
                                    <option name="cargo" value="Externo">Externo</option>
                                    <option name="cargo" value="Cadastrar">Cadastrar</option>
                                </select>  
                            </div> 
                            Fim Select Cargos 
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="matricula" id="matricula" placeholder="Matrícula">
                            </div>
                        
                            <div class="col-md-4">
                                <input type="email" class="form-control" name="email_pessoa" id="email_pessoa" placeholder="E-mail">
                            </div>

                            <div class="col-md-4">
                            	<input type="date" class="form-control" name="data_nascimento" id="data_nascimento">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="C. P. F.">
                            </div>
                        
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="rg" id="rg" placeholder="R. G.">
                            </div>
                        
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="passaporte" id="passaporte" placeholder="Passaporte">
                            </div>
                            
                        </div>
                        <div class="row">    
                            <input type="submit" id = "btnCadPessoa" value="Salvar" name="btnCadPessoa"></input>
                                
                            <input type ="submit" id = "btnCadPessoa" value ="Cancelar"></input>
                           
                        </div>
                        Fim Campos
                    </form> -->  
                    
                </div>
        </section>
	</body>
</html>