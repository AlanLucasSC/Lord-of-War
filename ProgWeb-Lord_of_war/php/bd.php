<?php  
	//requirindo o arquivo funcoes.php, onde está as funções de consultas, inserts, deletes, updates
	require_once('funcoes.php');
  if (!isset($_SESSION)) {
    session_start();
  }
    if (isset($_POST['army'])) {
      $a = $consulta->SELECT("count(*) as qnt")->FROM('user_army')->WHERE('usuario_id = '.$_SESSION['id'][0]->id)->FINALIZE();
      echo $a;
    }

    if (isset($_POST['entrando'])) {
      $atualizar->UPDATE('sala', 'adversario_id')->WHERE('id')->VALUE($_SESSION['id'][0]->id, $_POST['entrando']);
    }

    if (isset($_POST['entrou'])) {
      $a = $consulta->SELECT("sala.adversario_id")->FROM('sala')->WHERE('jogador_id = '.$_SESSION['id'][0]->id)->FINALIZE();
      echo $a;
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