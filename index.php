<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>DAGR - LOGIN</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/style.css"> 
	</head>
	<body>

		<header>
			
            <nav class="navbar navbar-expand-sm navbar-dark">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						
						<li class="nav-item active">
							<a class="nav-link" href="#">Login<span class="sr-only">(current)</span></a>
					  	</li>
					  	<li class="nav-item">
							<a class="nav-link" href="cadastrarUsuarios.php">Cadastre-se Aqui</a>
						</li>			
					</ul>
				</div>
			</nav>

        </header>

		<section class="col-md-auto">
			<div class="content-center">	
				<div>
					<a href="https://tjpr.jus.br">
						<img src="assets/img/tjpr.png" alt="Logo TJPR">
					</a>
				</div>

				<?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}

					if(isset($_SESSION['msgcad'])){
						echo $_SESSION['msgcad'];
						unset($_SESSION['msgcad']);
					}
				?>

				<form method="POST" action="valida.php">               
					
					<input type="text" name="login" placeholder="Digite seu login">
					
					<input type="password" name = "senha" id="senha" placeholder="Digite sua senha" >
										
					<button type = "submit" name = "btnLogin" value="Acessar">Enviar</button>
							
					<!--<h4>Você ainda não possui uma conta?</h4>
					<a href="cadastrar.php">Crie grátis</a> -->
					
				</form> 

			</div>
			
		</section>	
	</body>
</html>