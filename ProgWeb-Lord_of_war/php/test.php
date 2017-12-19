<?php

require_once('funcoes.php');

//Fazer uma consulta no banco de dados blog, na tabela post
//var_dump($consulta->SELECT("*")->FROM('usuario')->WHERE('conta = "AlanLucasSC"')->WHERE('senha = "96654117and"')->FINALIZE());

/*
$consulta->SELECT('*', 'mensage.id as id_mensage')->FROM('mensage')->COMBINE('INNER', 'usuario', 'mensage.user_id', 'usuario.id')->WHERE('mensage.id > 1');
echo $consulta->select;
$b = json_decode($consulta->FINALIZE());
var_dump($b);
var_dump(array_pop($b)->id_mensage);
*/

/*
$a = $consulta->SELECT('*')->FROM('army')->FINALIZE();
var_dump($a);
echo strlen($a).' ';
$a = json_decode($a);

var_dump($a);
*/
//echo count($a).' ';
//echo array_pop($a)->id_mensage;;



//Fazer um insert no bando de dados blog, na tabela tipo
//var_dump($insercao->INSERT('tipo', 'Mudanca')->VALUE('criação'));
//$insercao->INSERT('mensage', 'text', 'user_id')->VALUE('ola', '1');
//echo $insercao->insert;

//Fazer uma atualização no banco de dados blog, na tabela tipo
//var_dump($atualizar->UPDATE('tipo', 'Mudanca')->WHERE('id')->VALUE('deletado', 32));

//Fazer uma exclusão no banco de dados blog, na tabela tipo
//var_dump($deletar->DELETE('tipo')->WHERE('id')->VALUE(32));


//$atualizar->UPDATE('usuario', 'coin')->WHERE('id')->VALUE(100, 1);

var_dump($consulta->SELECT("*")->FROM('sala')->WHERE('id = 1')->FINALIZE());





//Criar uma nova Objeto para fazer a consulta
$cons = new Consultar();
//var_dump($cons);

//Criar uma nova Objeto para fazer a inserção de dados na tabela
$ins = new Inserir();
//var_dump($ins);

//Criar um novo Objeto para fazer a atualização de dados na tabela
$atu = new Atualizar();
//var_dump($atu);

//Criar um novo Objeto para fazer a exclusão de dados na tabela
$del = new Deletar();
//var_dump($del);
