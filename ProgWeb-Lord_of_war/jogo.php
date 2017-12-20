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
  //var_dump($_SESSION['turno']);
  //var_dump($_SESSION['sala_id']);
  //var_dump($_SESSION['adversario_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lord of War</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript">
      var jogador;
      var jogador2;
      var dados;
      var flag = 0;
      var turno2 = 0;
      var jogada = 0;
      var contador1;
      var contador2;
      var contador = 0;

      function verifica1(){
        count = 0;
        for (var i = 0; i < dados.length; i++){
          if (dados[i].vida * jogador[i].qnt < 1) {
            count++;
          }
        }
        contador1 = count;
      }

      function verifica2(){
        count = 0;
        for (var i = 0; i < dados.length; i++){
          if (dados[i].vida * jogador2[i].qnt < 1) {
            count++;
          }
        }
        contador2 = count;
      }

      setInterval(function(){
          verifica1();
          verifica2();
          if (contador1 === 3) {$('#texto').prepend(`Você perdeu
`); contador++;}
          if (contador2 === 3) {$('#texto').prepend(`Você Ganhou
`); contador++;}

          if (contador >= 50) {window.location.replace("./index.php");}

          $.post("php/bd.php", {jogada: 'ok'}, function(data){
          data = JSON.parse(data);
          turno = data[0].turno;
          //console.log('turno do jogo: '+data[0].turno+'  flag:' +flag+'  Seu turno:'+<?php echo $_SESSION['turno']; ?>);
          //console.log(data);

          

          if (flag === 1 && turno2 != turno) {
            flag = 0;
          }



          if (turno == <?php echo $_SESSION['turno']; ?> && flag === 0) {
            if (jogada === 1) {
              console.log(dados[data[0].pers].vida * jogador[data[0].pers].qnt);
              console.log(data[0].dano);
              dano_parcial = (dados[data[0].pers].vida * jogador[data[0].pers].qnt) - data[0].dano;
              jogador[data[0].pers].qnt = dano_parcial / dados[data[0].pers].vida;
              document.getElementById(''+data[0].pers+'vidaA').innerHTML = "Vida: "+dano_parcial+" <br>";
              data[0].pers++;
              $('#texto').prepend(`<--- Dano: `+data[0].dano+` Unidade: `+data[0].pers+`
`);
            }
            $('#texto').prepend(`<--- Seu turno
`);
            flag = 1;
            turno2 = turno;
            jogada = 1;
          }
          if (turno != <?php echo $_SESSION['turno']; ?>&& flag === 0) {
            if (jogada === 1) {
              //console.log(dados[data[0].pers].vida * jogador2[data[0].pers].qnt);
              //console.log(data[0].dano);
              dano_parcial = (dados[data[0].pers].vida * jogador2[data[0].pers].qnt) - data[0].dano;
              jogador2[data[0].pers].qnt = dano_parcial / dados[data[0].pers].vida;
              $('#'+data[0].pers+'persB')[0].innerHTML = "Vida: "+dano_parcial+" <br>";
              data[0].pers++;
              $('#texto').prepend(`Dano: `+data[0].dano+` Unidade: `+data[0].pers+`--->
`);
            }
              $('#texto').prepend(`Turno do oponente --->
`);
            flag = 1;
            turno2 = turno;
            jogada = 1;
          }
        });
      }, 500);
      

      function Atacar(id){
        valor = $('#'+id+'persA select')[0].value;
        life = dados[id].vida * jogador[id].qnt;
        //console.log(valor);
        //console.log(dados[id].vida * jogador[id].qnt);
        //console.log($('#0persB')[0].innerHTML);
        //console.log(dados[valor].vida * jogador2[valor].qnt);
        limit = (dados[id].mov * jogador[id].qnt) + (dados[valor].mov * jogador2[valor].qnt);
        //console.log('esse é o limite: '+limit);
        //console.log(<?php echo $_SESSION['turno']; ?>);
        if (turno == <?php echo $_SESSION['turno']; ?> && life > 0) {
          if (Math.random() * limit < (dados[id].mov * jogador[id].qnt)) {
            dano = Math.random() * dados[id].forca * jogador[id].qnt;
            //console.log(dano);
            //console.log(valor);
            $.post("php/bd.php", {dano: dano, valor: valor}, function(data1){ 
              //jogador = JSON.parse(data1);
            });
          }
          else{
            $.post("php/bd.php", {dano: 0, valor: valor}, function(data1){ 
              //jogador = JSON.parse(data1);
            });
          }
        }
        else{
          $('#texto').prepend(`<--- Não da para atacar pois ele morreu
`);
        }
      }

      $(document).ready(function() {
        $.post("php/bd.php", {armys: 'ok'}, function(data1){ 
          jogador = JSON.parse(data1);
        });

        $.post("php/bd.php", {armys2: 'ok'}, function(data2){ 
          //console.log(data2);
          jogador2 = JSON.parse(data2);
          $.post("php/bd.php", {pers: 'ok'}, function(data){
            console.log(jogador);
            jd1 = $('#accordion');
            jd2 = $('#accordion2');
            data = JSON.parse(data);
            option = '<select id="Atacar" class="form-control" style="margin-bottom: 10px;">';
            dados = data;
            for (var i = 0; i < data.length; i++){
              option += '<option value="'+i+'">'+data[i].nome+'</option>';
            }
            option += '</select>';
            for (var i = 0; i < data.length; i++) {
              jd1.append(
                `
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapse`+i+`a">
                        `+data[i].nome+`
                      </a>
                    </div>
                    <div id="collapse`+i+`a" class="collapse">
                      <div class="card-body" id="`+i+`persA">
                        <div id="`+i+`vidaA" value="`+data[i].vida * jogador[i].qnt+`">
                          Vida: `+data[i].vida * jogador[i].qnt+`<br>
                        </div>
                        Força: `+data[i].forca * jogador[i].qnt+`<br>
                        Movimentação: `+data[i].mov * jogador[i].qnt+`<br>`+option+`
                        <button onclick="Atacar(`+i+`)" type="button" class="btn btn-outline-success">Atacar</button>
                      </div>
                    </div>
                  </div>
                `
              );
            }

            for (var i = 0; i < data.length; i++) {
              jd2.append(
                `
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion2" href="#collapse`+i+`b">
                        `+data[i].nome+`
                      </a>
                    </div>
                    <div id="collapse`+i+`b" class="collapse">
                      <div class="card-body">
                        <div id="`+i+`persB">
                          Vida: `+data[i].vida * jogador2[i].qnt+`<br>
                        </div>
                        Força: `+data[i].forca * jogador2[i].qnt+`<br>
                        Movimentação: `+data[i].mov * jogador2[i].qnt+`<br>
                      </div>
                    </div>
                  </div>
                `
              );
            }
          });
        });
        //$('#texto').prepend(`ola <br> amfkafanfn`);
        //$('#texto').prepend(`ba`);
      });

    </script>
</head>
<body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: white !important;">
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
                    <li class="nav-item">
                      <a class="nav-link" href="cadastrar.php">Cadastrar</a>
                    </li>
                  <?php 
                    }
                    else{
                  ?>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Olá <?php echo $_SESSION['conta']; ?></a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" href="sala.php">Salas</a>
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
  <br>
	<div class="container">
    <div class="row">

      <div class="col-md-4"> <div id="accordion"></div> </div>

      <div class="col-md-4"> <textarea rows="6" cols="47" id="texto" style="box-shadow: 0 0 0 0; border: 0 none; outline: 0; overflow:auto;" readonly></textarea> </div>

      <div class="col-md-4"> <div id="accordion2"></div> </div>
    </div>
  </div>
</body>