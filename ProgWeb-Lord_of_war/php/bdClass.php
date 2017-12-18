<?php

require_once('readJson.php');

class bd{
	$info = bdInfo('info.json');
	//host
	private $host = $info->db_HOST;
	
	//usuario
	private $usuario = $info->db_USERNAME;

	//senha
	private $senha = $info->db_PASSWORD;

	//banco
	private $bd = $info->db_DATABASE;

	private $conn = $info->db_PASSWORD;

	public function conecta_mysql(){

		//cria conexão;
		$this->conn = mysqli_connect($this->host, $this->usuario, $this->senha, $this->bd);

		//ajuda charset de comunicação entre aplicação e bd
		mysqli_set_charset($this->conn, 'utf8');
			
		//verificar se houve erro de conexão
		if(mysqli_connect_errno()){
			echo 'Erro ao tentar se conectar com o BD MySQL: ' .mysqli_connect_error();
		}

		//return $this->conn;
	}

	function __construct(){
		$this->conecta_mysql();
	}

	public function exec($query, $type, $param){
		//echo $param['nome'];
		//echo $param['senha'];
		//echo $type;
		//echo $query;
        $stmt=$this->conn->prepare($query);
		$stmt->bind_param($type, ...$param);
		//echo "string";
		$stmt->execute();
		if($stmt->field_count>0)
			$result = $stmt->get_result();
		else
			$result=TRUE;
		if ($this->conn->errno) {
			die('Invalid query: '.$this->conn->error());
		}
		return $result;
	}
}