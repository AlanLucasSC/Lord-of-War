<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cadastrar</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/handlebars-v4.0.11.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			xyz = 1;
			$('.bgn').mouseenter(function(){
				//console.log($(this).val());
				$(".desc").css({'display' : 'block'});
			});
			$('.bgn').mouseleave(function(){
				$(".desc").css({'display' : 'none'});
			});
			$('#errolog').hide(); //Esconde o elemento com id errolog
			$('#sucesslog').hide();
			$('#formcadastro').submit(function(){ 	//Ao submeter formulário
				var conta=$('#conta').val();	//Pega valor do campo conta
				var senha=$('#senha').val();	//Pega valor do campo senha
				console.log(conta);
				console.log(senha);
				$.post("php/bd.php", {new_conta: conta, new_senha: senha}, function(data){
			        	if (data === 'fail') {
			        		$('#errolog').show();
			        	}
			        	else{
			        		$('#successlog').show();
			        	}
			         }
			         , "html"); 
				return false;	//Evita que a página seja atualizada
			});
			//a.append('<h4 class=/"outerMensage">batata</h4>');

		});

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
                <li class="nav-item">
                  <a class="nav-link" href="login.html">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cadastrar.php">Cadastrar</a>
                </li>
  	        </ul>
          </div>
        </nav>
	<br>
	<br>
	<div class="panel panel-default margins-1" id="errolog">
		<div class="panel-heading error">
			<h3 style="color: white; text-align: center;">
				ERROR: Usuário ou senha errados!!!!
			</h3>
		</div>
	</div>
	<div class="panel panel-default margins-1" id="successlog">
		<div class="panel-heading success">
			<h3 style="color: white; text-align: center;">
				SUCCESS: Cadastro feito com sucesso!
			</h3>
		</div>
	</div>
	<form class="margins-3" id="formcadastro">
	  <div class="form-group">
	    <label for="exampleInputEmail1">User:</label>
	    <input type="text" class="form-control" id="conta" placeholder="User" name='conta'>
	    <small id="emailHelp" class="form-text text-muted">We'll never share your user with anyone else.</small>
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Password:</label>
	    <input type="password" class="form-control" id="senha" placeholder="Password" name="senha">
	  </div>
	  <button type="submit" class="btn btn-primary">Cadastrar</button>
	</form>


	<div id="resposta">
		
	</div>
</body>
</html>