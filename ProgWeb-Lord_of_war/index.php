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
	<script src="js/funcoes.js"></script>
	<script type="text/javascript">
		var array = [];
		var tamanho;
		function mais(a){
			//console.log(tamanho);
			qnt = a.value;
			if (qnt >= 0) {
				//console.log('if '+$('#'+a.id).val());
				//$('#'+a.id).removeClass('is-invalid').addClass('is-valid');
				a = a.id;
				a = a.replace('data', '');
				$('#'+a).text(array[a] * qnt);
			}
			else{
				//console.log('else '+$('#'+a.id).val());
				//$('#'+a.id).removeClass('is-valid').addClass('is-invalid');
				//$('#'+a.id).val(0);
			}
			count = 0;
			for (var i = 0; i < tamanho; i++) {
				count += $('#'+i+'data').val() * array[i];
			}
			max = <?php echo $_SESSION['coin'][0]->coin; ?>;
			
			//console.log();
			if (count > max) {
				for (var i = 0; i < tamanho; i++) {
					$('#'+i+'data').removeClass('is-valid').addClass('is-invalid');
				}
			}
			else {
				for (var i = 0; i < tamanho; i++) {
					$('#'+i+'data').removeClass('is-invalid').addClass('is-valid');
				}
			}
			$('#Total').text(count);
			if (count > max) {
				$('#Alerta').removeClass('alert-success').addClass('alert-danger');
				$('#Alerta').text('Limite da compra excedido!');
			}
			else{
				$('#Alerta').removeClass('alert-danger').addClass('alert-success');
				$('#Alerta').text('A compra pode ser efetuada!');
			}
		}
		/*
		setInterval(function(){
		    a = $('.btn');
		    a.append('i');
		}, 1000);
		*/
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
        <?php  
	        if ($login !== 1){
	    ?>
        <div class="panel-heading error" style="background-color: #f0efef !important;">
            <h2 style=" font-size: 50px; color: #ea1414 ; text-align: center;">
                Crie seu próprio exército e lute com outros jogadores.
            </h2>
            <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <h4 style="color: rgba(0,0,0,.5); margin-top: 7px; margin-right: 7px;">
                            Faça o login para você começar a jogar
                        </h4>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.html" style="color: rgba(0,0,0,.5);">Login</a>
                    </li>
                </ul>
        </div>
        <?php 
        	}
        	else{
        ?>
        	<table class="table" style="background-color: white;">
        		<thead class="thead-dark">
        			<tr>
        				<th>#</th>
        				<th>Classe</th>
        				<th>Vida</th>
        				<th>Força</th>
        				<th>Movimentação</th>
        				<th>Preço</th>
        				<th>Quantidade</th>
        				<th>Total</th>
        			</tr>
        		</thead>
        		<tbody id="pers">
        			
        		</tbody>
        	</table>

        <?php 
        	}
        ?>

        <!--
        <div class="panel panel-default">
			<div class="panel-heading">
				<h3 style="color: #777;">
					Chat
				</h3>
			</div>
			<div class="panel-body">
			</div>
		</div>
			<div class="input-group">
			  	<input type="text" class="form-control" placeholder="Text" aria-label="Text" aria-describedby="basic-addon2" id="Text">
			  	<span class="input-group-addon" id="basic-addon2"> 
			  		<button type="button" class="btn btn-outline-success button">Enviar</button>
			  	</span>
			</div>
		</div>
	-->
	<br>
	<br>
</body>
</html>