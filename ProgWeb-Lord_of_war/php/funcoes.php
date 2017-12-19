<?php

require_once('readJson.php');

function select($path){
	$resultado = SelectMySQL($path);
	$param = array();
	while($row = $resultado->fetch(PDO::FETCH_OBJ)){
		array_push($param, $row);
	}
	return json_encode($param);
}

function SelectMySQL($select){
	$info = bdInfo('../info.json');
	$user = $info->db_USERNAME;
	$pass = $info->db_PASSWORD;
	$dbh = new PDO('mysql:host='.$info->db_HOST.';dbname='.$info->db_DATABASE, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	return $dbh->query($select);
}

class Consultar{
	public $select = "";
	public $cont = 0;

	public function SELECT(...$in)
	{
		$this->select =  "SELECT ";
		foreach ($in as $key) {
			$this->select = $this->select.$key.', ';
		}
		$this->select = substr($this->select, 0, -2);
		return $this;
	}

	public function FROM($from)
	{
		$this->select = $this->select." FROM ".$from." ";
		return $this;
	}

	public function WHERE($where)
	{
		if ($this->cont == 0) {
			$this->select = $this->select."WHERE ".$where." ";
			$this->cont++;
		}
		else {
			$this->select = $this->select."AND ".$where." ";
		}
		return $this;
	}

	public function ORDER_BY($where, $desc)
	{
		$this->select = $this->select."ORDER BY ".$where." ".$desc.' ';
		return $this;
	}

	public function COMBINE($desc, $table, $collumn1, $collumn2)
	{
		$this->select = $this->select.' '.$desc." JOIN ".$table." ON ".$collumn1." = ".$collumn2." ";
		return $this;
	}

	public function FINALIZE()
	{
		$this->select = $this->select.";";
		$query =  select($this->select);
		$this->select = "";
		return $query;
	}
}

class Inserir{

	public $insert = "";
	public $cont = 0;
	public $qntValue = 0;
	public $collumn;
	public $data;

	public function INSERT($table, ...$collumn)
	{
		$this->collumn = $collumn;
		$this->insert =  "INSERT INTO ".$table." (";
		foreach ($collumn as $key) {
			$this->insert = $this->insert.$key.',';
			$this->cont++;
		}
		$this->insert = substr($this->insert, 0, -1);
		$this->insert = $this->insert.")";
		$this->insert =  $this->insert." VALUES (";
		foreach ($collumn as $key) {
			$this->insert = $this->insert.':'.$key.',';
			$this->cont++;
		}
		$this->insert = substr($this->insert, 0, -1);
		$this->insert = $this->insert.")";
		return $this;
	}

    public function VALUE(...$values)
    {
      	$info = bdInfo('../info.json');
		$user = $info->db_USERNAME;
		$pass = $info->db_PASSWORD;
		$dbh = new PDO('mysql:host='.$info->db_HOST.';dbname='.$info->db_DATABASE, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		$values = $this->Key($values);
		$dbh->prepare($this->insert)->execute($values);
        unset($dbh);
        return 'Success';
	}

	public function Key($values)
	{
		$dados = array();
		for ($i = 0; $i < count($this->collumn); $i++) {
			$dados[$this->collumn[$i]] = $values[$i];
		}
		return $dados;
	}

	public function clean()
	{
		$this->insert = '';
		$this->cont = 0;
		$this->qntValue = 0;
	}
}

class Atualizar{
	public $update = '';
	public $cont = 0;
	public $qntValue = 0;
	public $collumn;
	public $where;
	public $data;

	public function UPDATE($table, ...$collumn)
	{
		$this->collumn = $collumn;
		$this->update =  "UPDATE ".$table." SET ";
		foreach ($collumn as $key) {
			$this->update = $this->update.$key.' = :'.$key.' AND';
			$this->cont++;
		}
		$this->update = substr($this->update, 0, -3);
		return $this;
	}

	public function WHERE(...$collumn)
	{
		$this->update =  $this->update."WHERE ";
		$this->where = $collumn;
		foreach ($collumn as $key) {
			$this->update = $this->update.$key.' = :'.$key.' AND ';
			$this->cont++;
		}
		$this->update = substr($this->update, 0, -4);
		return $this;
	}
	public function VALUE(...$values)
    {
      	$info = bdInfo('../info.json');
		$user = $info->db_USERNAME;
		$pass = $info->db_PASSWORD;
		$dbh = new PDO('mysql:host='.$info->db_HOST.';dbname='.$info->db_DATABASE, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		$values = $this->Key($values);
		$dbh->prepare($this->update)->execute($values);
		return 'Success';
	}
	public function Key($values)
	{
		//var_dump($values);
		$cont = 0;
		$dados = array();
		for ($i = 0; $i < count($this->collumn); $i++) {
			$dados[$this->collumn[$i]] = $values[$i];
			$cont++;
		}
		for ($i = 0; $i < count($this->where); $i++) {
			$dados[$this->where[$i]] = $values[$cont + $i];
		}
		//var_dump($dados);
		return $dados;
	}
}

class Deletar{
	public $delete = "";
	public $cont = 0;
	public $qntValue = 0;
	public $collumn;
	public $where;
	public $data;

	public function DELETE($in)
	{
		$this->delete =  "DELETE FROM ".$in." ";
		return $this;
	}

	public function WHERE(...$collumn)
	{
		$this->delete =  $this->delete."WHERE ";
		$this->where = $collumn;
		foreach ($collumn as $key) {
			$this->delete = $this->delete.$key.' = :'.$key.' AND ';
			$this->cont++;
		}
		$this->delete = substr($this->delete, 0, -4);
		return $this;
	}
	public function VALUE(...$values)
    {
      	$info = bdInfo('../info.json');
		$user = $info->db_USERNAME;
		$pass = $info->db_PASSWORD;
		$dbh = new PDO('mysql:host='.$info->db_HOST.';dbname='.$info->db_DATABASE, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		$values = $this->Key($values);
		$dbh->prepare($this->delete)->execute($values);
		return 'Success';
	}
	public function Key($values)
	{
		//var_dump($values);
		$dados = array();
		for ($i = 0; $i < count($this->where); $i++) {
			$dados[$this->where[$i]] = $values[$i];
		}
		//var_dump($dados);
		return $dados;
	}
}

$insercao = new Inserir();
$consulta = new Consultar();
$atualizar = new Atualizar();
$deletar = new Deletar();