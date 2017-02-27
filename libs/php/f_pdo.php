<?php
/*
  Conecta a una base de datos según la configuración definida por las constantes DB_
*/
if(!function_exists('conectar_db')){
	  function conectar_db()  {
		$dsn = 'mysql:dbname='.DB_DATABASE.';host='.DB_HOST;
		$usuario = DB_USER;
		$contraseña = DB_PASSWORD;
		try {
			$conn = new PDO($dsn, $usuario, $contraseña,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			} catch (PDOException $e) {
				error( 'Falló la conexión: ' . $e->getMessage());
				}
		return $conn;
		}
	}
	
if(!function_exists('insert_db')){
	function insert_db($conn,$tabla,$array){
		$sql = "INSERT INTO $tabla (";
		foreach(array_keys($array) as $key){$sql .= $key.", ";}
		$sql .= ") VALUES (";
		foreach(array_keys($array) as $key){$sql .= ":".$key.", ";}
		$sql .=");";
		$sql = str_replace(", )",")",$sql);
		foreach($array as $key=>$value){$a_exe[":".$key] = $value;}
		try{
			$stmt = $conn->prepare($sql);
			$r = $stmt->execute($a_exe);
		}catch(PDOException $e) {
				error( 'Falló: ' . $e->getMessage());
				}
		return $r;
		}
}

if(!function_exists('delete_db')){
	function delete_db($conn,$tabla,$array){
		// $array = array('idCurso'=>$_REQUEST['selectCurso']);
		$sql = "DELETE FROM $tabla ";
		$query = "WHERE ";
		foreach(array_keys($array) as $key){$query .= $key." = :".$key;}
		$sql .= $query;
		try{
			$stmt = $conn->prepare($sql);
			foreach($array as $key => $value){$stmt->bindParam(':'.$key,$value);}
			$r = $stmt->execute();
		}catch(PDOException $e) {
				error( 'Falló: ' . $e->getMessage());
				}
		return $r;
	}
}
if(!function_exists('update_db')){
	function update_db($con,$tabla,$array,$where){
		$sql = "UPDATE $tabla SET ";
		foreach(array_keys($array) as $key){$sql .= $key." = :".$key.", ";}
		$sql=substr($sql,0,strlen($sql)-2);
		$sql .=" WHERE ";
		foreach(array_keys($where) as $key){$sql .= $key." = :".$key.", ";}
		$sql=substr($sql,0,strlen($sql)-2);
		// debug($sql);
		$bind = array_merge($array,$where);
		try{
			$stmt = $con->prepare($sql);
			$r = $stmt->execute($bind); 
		}catch(PDOException $e) {
				error( 'Falló: ' . $e->getMessage());
				}
		return $r;
	}
}

if(!function_exists('get_db')){
	function  get_db($campo,$sql,$con){
		$query =  $con->query($sql);
		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row[$campo];
	}
}
