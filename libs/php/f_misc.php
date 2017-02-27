<?php

if(!function_exists('nz')){
	function nz(&$valor, $reemplazo=''){
		return isset($valor)?$valor:$reemplazo;
	}
}

if(!function_exists('linea')){
	function linea(){
		return "\n";
	}
}

if(!function_exists('tab')){
	function tab(){
		return "\t";
	}
}

if(!function_exists('limpia')){
	function limpia($valor){
		$con = conectar_db();
		return strip_tags(mysqli_real_escape_string($con,$valor));
	}
}

 // include_once("config.php");
