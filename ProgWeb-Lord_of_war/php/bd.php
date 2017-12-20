<?php  
	//requirindo o arquivo funcoes.php, onde está as funções de consultas, inserts, deletes, updates
  	require_once('funcoes.php');
    if (!isset($_SESSION)) {
      session_start();
    }

    if ( isset($_POST['dano']) and isset($_POST['valor']) ) {
      if ($_SESSION['turno'] === 0) {
        $atualizar->UPDATE('sala', 'dano', 'pers', 'turno')->WHERE('jogador_id')->VALUE($_POST['dano'], $_POST['valor'], 1, $_SESSION['id'][0]->id);

      }
      else{
        $atualizar->UPDATE('sala', 'dano', 'pers', 'turno')->WHERE('adversario_id')->VALUE($_POST['dano'], $_POST['valor'], 0, $_SESSION['id'][0]->id);
      }
    }

    if (isset($_POST['jogada'])) {
      if ($_SESSION['turno'] === 0) {
        $a = $consulta->SELECT("*")->FROM('sala')->WHERE('jogador_id = '.$_SESSION['id'][0]->id)->FINALIZE();
      }
      else{
        $a = $consulta->SELECT("*")->FROM('sala')->WHERE('adversario_id = '.$_SESSION['id'][0]->id)->FINALIZE();
      }
      echo $a;
    }

    if (isset($_POST['dados'])) {
      $a = $consulta->SELECT("*")->FROM('sala')->WHERE('usuario_id = '.$_SESSION['id'][0]->id)->FINALIZE();
    }

    if (isset($_POST['armys'])) {
      $a = $consulta->SELECT("*")->FROM('user_army')->WHERE('usuario_id = '.$_SESSION['id'][0]->id)->FINALIZE();
      echo $a;
    }

    if (isset($_POST['armys2'])) {
      $a = $consulta->SELECT("*")->FROM('user_army')->WHERE('usuario_id = '.$_SESSION['adversario_id'])->FINALIZE();
      echo $a;
    }

    if (isset($_POST['army'])) {
      $a = $consulta->SELECT("count(*) as qnt")->FROM('user_army')->WHERE('usuario_id = '.$_SESSION['id'][0]->id)->FINALIZE();
      echo $a;
    }

    if (isset($_POST['entrando'])) {
      $a = $consulta->SELECT("sala.adversario_id", "sala.id as sala_id")->FROM('sala')->WHERE('jogador_id = '.$_SESSION['id'][0]->id)->FINALIZE();
      $b = json_decode($a);
      if ($b[0]->adversario_id !== null) {
        $_SESSION['data'] = $b;
        $_SESSION['adversario_id'] = $b[0]->adversario_id;
      }
      $_SESSION['sala_id'] = $b[0]->sala_id;
      $_SESSION['turno'] = 1;
      $atualizar->UPDATE('sala', 'adversario_id')->WHERE('id')->VALUE($_SESSION['id'][0]->id, $_POST['entrando']);
    }

    if (isset($_POST['entrou'])) {
      $a = $consulta->SELECT("sala.adversario_id", "sala.id as sala_id")->FROM('sala')->WHERE('jogador_id = '.$_SESSION['id'][0]->id)->FINALIZE();
      $b = json_decode($a);
      if ($b[0]->adversario_id !== null) {
        $_SESSION['data'] = $b;
        $_SESSION['adversario_id'] = $b[0]->adversario_id;
        $_SESSION['sala_id'] = $b[0]->sala_id;
        $_SESSION['turno'] = 0;
        $atualizar->UPDATE('sala', 'turno')->WHERE('jogador_id')->VALUE(0, $_SESSION['id'][0]->id);
      }
      echo $a;
    }

    if(isset($_POST['new_conta']) and isset($_POST['new_senha'])) {
      $insercao->INSERT('usuario', 'conta', 'senha', 'coin')->VALUE($_POST['new_conta'], $_POST['new_senha'], 100);
      $a = $consulta->SELECT("*")->FROM('usuario')->WHERE('conta = "'.$_POST['new_conta'].'"')->WHERE('senha = '.$_POST['new_senha'])->FINALIZE();
      if ($a === '[]') {
        echo "fail";
      }
      else{
        echo "ok";
      }
    }

  	if(isset($_POST['conta']) and isset($_POST['senha'])) {
  		$login = 'conta = "'.$_POST['conta'].'"';
  		$senha = 'senha = "'.$_POST['senha'].'"';
  		$a = $consulta->SELECT("*")->FROM('usuario')->WHERE($login)->WHERE($senha)->FINALIZE();	// responde com
      if (!empty($a)) {
        $b = json_decode($a);
        $_SESSION['id'] = $b;
        $_SESSION['conta'] = $_POST['conta'];
        $_SESSION['senha'] = $_POST['senha'];
        $_SESSION['coin'] = $b;
        echo $a;
      }
  	}

    if(isset($_POST['text'])) {
      $data = date("Y/m/d H:i:s");
      $insercao->INSERT('mensage', 'text', 'user_id', 'creation_time')->VALUE($_POST['text'], $_SESSION['id'][0]->id, $data);
      echo 'ok';
    }

    if(isset($_POST['id']) and isset($_POST['id_per']) and isset($_POST['qnt'])) {
      $insercao->INSERT('user_army', 'usuario_id', 'army_id', 'qnt')->VALUE($_POST['id'], $_POST['id_per'], $_POST['qnt']);
      $_SESSION['coin'][0]->coin = $_SESSION['coin'][0]->coin - $_POST['value'];
      $atualizar->UPDATE('usuario', 'coin')->WHERE('id')->VALUE($_SESSION['coin'][0]->coin, $_POST['id']);
      echo 'ok';
    }

    if (isset($_POST['id_j'])) {
      $insercao->INSERT('sala', 'jogador_id')->VALUE($_POST['id_j']);
      echo "ok";
    }

    if (isset($_POST['salas'])) {
      $a = $consulta->SELECT("conta", 'sala.id')->FROM('sala')->COMBINE('INNER', 'usuario', 'sala.jogador_id', 'usuario.id')->WHERE('adversario_id is NULL')->FINALIZE();
      echo $a;
    }

    if (isset($_POST['mensage'])) {
      $where = 'mensage.id > '.$_SESSION['length_id'];
      $a = $consulta->SELECT('mensage.id as id_mensage', 'conta', 'text', 'usuario.id as id', 'creation_time as time')->FROM('mensage')->COMBINE('INNER', 'usuario', 'mensage.user_id', 'usuario.id')->WHERE($where)->ORDER_BY('creation_time', 'ASC')->FINALIZE();
      if (strlen($a) > 2) {
        $b = json_decode($a);
        if (count($b) != 0) {
          $_SESSION['length_id'] = array_pop($b)->id_mensage;
          echo $a;
        }
      }
    }

    if (isset($_POST['pers'])) {
      //$where = 'mensage.id > '.$_SESSION['length_id'];
      $a = $consulta->SELECT('*')->FROM('army')->FINALIZE();
      if (strlen($a) > 2) {
        $b = json_decode($a);
        if (count($b) != 0) {
          //$_SESSION['length_id'] = array_pop($b)->id_mensage;
          echo $a;
        }
      }
    }

?>