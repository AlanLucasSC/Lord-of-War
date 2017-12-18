<?php
	session_start();
	session_destroy();
	//$_SESSION["nome"]=NULL;
	//$_SESSION["id"]=NULL;
	//$_SESSION["senha"]=NULL;
	header("location:../index.php");
	
?>