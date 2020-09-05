<?php 
// Dados da conexão com o banco de dados
define('HOST', 'passagenstjpr.cjspllmwjxzm.us-east-2.rds.amazonaws.com');
define('PORT', 5432);
define('USER', 'postgres');
define('PASS', 'c0mp4rt1l#31');
define('DBNAME', 'dbpassagens');



// Recebe os parâmetros enviados via GET
$acao = (isset($_GET['acao'])) ? $_GET['acao'] : '';
$parametro = (isset($_GET['parametro'])) ? $_GET['parametro'] : '';

// Configura uma conexão com o banco de dados
$opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
$conn = new PDO('pgsql:host=' . HOST . ';port=' . PORT . ';dbname=' . DBNAME . ';', USER, PASS, $opcoes);

// Verifica se foi solicitado uma consulta para o autocomplete
if($acao == 'autocomplete'):
	$where = (!empty($parametro)) ? 'WHERE busca LIKE ?' : '';
	$sql = "SELECT * FROM tbl_passagem
    LEFT JOIN tbl_pessoa ON tbl_passagem.id_pessoa = tbl_pessoa.id_pessoa" . $where;

	$stm = $conn->prepare($sql);
	$stm->bindValue(1, '%'.$parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);

	$json = json_encode($dados);
	echo $json;
endif;

// Verifica se foi solicitado uma consulta para preencher os campos do formulário
if($acao == 'consulta'):
	$sql = "SELECT * FROM tbl_passagem LEFT JOIN tbl_pessoa ON tbl_passagem.id_pessoa = tbl_pessoa.id_pessoa";
	$sql .= "WHERE busca iLIKE ? LIMIT 1";

	$stm = $conn->prepare($sql);
	$stm->bindValue(1, $parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);

	$json = json_encode($dados);
	echo $json;
endif;