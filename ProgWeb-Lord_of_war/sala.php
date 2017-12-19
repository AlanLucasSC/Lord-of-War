<?php 
	session_start();
	$_SESSION['length_id'] = 0;
	if (isset($_SESSION)) {
		if (isset($_SESSION['conta']) AND isset($_SESSION['senha']) AND $_SESSION['id'] != NULL) {
			$login = 1;
		}
		else {
			$login = 2;
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lord of War</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		var array = [];
		var qnt;
		$.post("php/bd.php", {army: 'qnt'}, function(data){
			data = JSON.parse(data);
			qnt = data[0].qnt;
			console.log(qnt);
			if (qnt !== 3) {
				$('#alerta').removeClass('alert-success').addClass('alert-danger');
				$('#alerta').text('Precisa ter um exército cadastrado');
			}
		});

		function Entrar(element){
			if (qnt === 3) {
				$.post("php/bd.php", {entrando: element.id}, function(data){
					window.location.replace("./jogo.php");
				});
			}
		}
		$(document).ready(function(){
			$.post("php/bd.php", {salas: 'ok'}, function(data){
				a = $('#pers');
				console.log(data);
				data = JSON.parse(data);
				tamanho = data.length;
				for(i = 0; i < data.length; i++){
					array[i] = data[i].preco;
					a.append(
					`
						<tr class='table-striped'>
							<th scope="row" >#`+data[i].id+`</th>
							<td>`+data[i].conta+`</td>
							<td> <button id="`+data[i].id+`" onclick="Entrar(this)" type="button" class="btn btn-outline-success">Entrar</button> </td>
						</tr>
					`
					);
				}
			});
		});
	</script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand logo" href="index.php">Lord of war</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse navbar-right" id="navbarSupportedContent">
	            <ul class="navbar-nav mr-auto">
	                <?php  
	                	if ($login !== 1){
	                ?>
		                <li class="nav-item">
		                  <a class="nav-link" href="login.html">Login</a>
		                </li>
	                <?php 
	                	}
	                	else{
	                ?>
	                	<li class="nav-item">
		                  <a class="nav-link" href="#">Olá <?php echo $_SESSION['conta']; ?></a>
		                </li>

		                <li class="nav-item">
		                  <a class="nav-link" href="#">Salas</a>
		                </li>

	                	<li class="nav-item">
	                		<a class="nav-link" href="#">
	                			<?php echo $_SESSION['coin'][0]->coin; ?>
	                			<img src="./img/coin.png" class="img-responsive" alt="Cinque Terre" width="20" height="20"> 
	                		</a>
		                </li>

		                <li class="nav-item">
		                  <a class="nav-link" href="./php/sair.php">Sair</a>
		                </li>
	                <?php 
	                	}
	                ?>
	  	    	</ul>
	        </div>
        </nav>
	<div class="container">
        <br>
        <br>
        <div class="panel-heading error" style="background-color: #f0efef !important;">
            <h2 style=" font-size: 50px; text-align: center;">
                <div id="alerta" class="alert alert-success" role="alert">
				  Escolha alguma sala para poder jogar.
				</div>
            </h2>
        </div>
        <table class="table" style="background-color: white;">
       		<thead class="thead-dark">
        		<tr>
        			<th>Sala</th>
        			<th>Jogador</th>
        			<th>#</th>
        		</tr>
        	</thead>
        	<tbody id="pers">
       			
       		</tbody>
        </table>
    </div>
	<br>
	<br>
</body>
</html>