<?php
/*
  Conecta a una base de datos según la configuración definida por las constantes DB_
*/
if(!function_exists('conectar_db')){
	function conectar_db()  {
		// $conn = mysqli_connect(
			// DB_HOST,
			// DB_USER,
			// DB_PASSWORD,
			// DB_DATABASE,
			// DB_PORT);
		if(!$conn= mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE,DB_PORT)){
			error("Ocurrió un error al conectar con la base de datos (". DB_HOST.".".DB_DATABASE.")");
			die();
		} 
		mysqli_set_charset($conn,"UTF8");
		return $conn;
		}
}

if(!function_exists('get_db')){
	function  get_db($con,$sql,$campo=""){
		// debug($sql);
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
		if(nz($campo)){
			return $row[$campo];
			}else{
				return $row;
			}
	}
}

if(!function_exists('delete_db')){
	function delete_db($con,$tabla,$where = ""){
		$sql = "DELETE FROM $tabla ";
		if(!empty($where)){
			$sql .= " WHERE ";
			foreach($where as $key => $value){
				$key = limpia($key);$value = limpia($value);
				$sets[] = "`".$key."` = '".$value."'";
				}
			$sql .= implode(', ',$sets);
			}
			// debug($sql);
		mysqli_query($con, $sql);
		// debug(mysqli_affected_rows($con),"Borrados: ");
		return mysqli_affected_rows($con);
		// return false;
	}
}
	
if(!function_exists('insert_db')){
	function insert_db($con,$tabla,$form_data){
		$form_sani=array();
		foreach($form_data as $key=>$value){
			$key = limpia($key);$value = limpia($value);
			$form_sani[$key] = $value;
			}
		// retrieve the keys of the array (column titles)
		$fields = array_keys($form_sani);

		// build the query
		$sql = "INSERT INTO ".$tabla."
		(`".implode('`,`', $fields)."`)
		VALUES('".implode("','", $form_sani)."')";
		// debug($sql);die;
		// run and return the query result resource
		return mysqli_query($con,$sql);			
	}
}

if(!function_exists('update_db')){
	function update_db($con,$tabla,$array,$where=array()){
		$sql = "UPDATE $tabla SET ";
			foreach($array as $key => $value){
				$key = limpia($key);$value = limpia($value);
				$sets[] = "`".$key."` = '".$value."'";
				}
			$sql .= implode(', ',$sets);
			if(!empty($where)){
				$i=1;
				$sql .=" WHERE ";
				foreach($where as $key => $value){
					$key = limpia($key);$value = limpia($value);
					$sql .= "`$key` = '$value'";
					if ($i < count($where)) { // last item should not include the AND
						$sql .= ' AND ';
						}
					$i++;
					}
				}
			// debug($sql);
		return mysqli_query($con,$sql);
	}
}



// require_once('config.php');
// if(DEBUG){
	// error_reporting(E_ALL);
	// ini_set('display_errors', '1');
	// }
	// include (DIR_PHP.'f_includes.php');
	
	// $con = conectar_db();

	// $nombre = "Pepe Pérez";
	// $selectCategoria = "CAT1";
	// $array = array(
	// 'nombreCurso' => $nombre,
	// 'Categoria_idCategoria' =>$selectCategoria
	// );
	// $where = array('idCurso'=>157,'OTRO'=>'ESTO');
	// $tabla = 'curso';				
	// // insert_db($con,$tabla,$array);

	// debug($nombre);
	// $nombre = strip_tags($nombre);
	// debug($nombre);
		// $sql = "UPDATE $tabla SET ";
		// foreach($array as $key => $value){
			// $sets[] = "`".$key."` = `".$value."`";
			// // $sql .= $key. " = '".mysqli_real_escape_string($con,$value)."', ";
			// }
			// $sql .= implode(', ',$sets);
		// // $sql=substr($sql,0,strlen($sql)-2);
		// $sql .=" WHERE ";
		// $sets=null;
		// foreach($where as $key => $value){
			// $sets[] = "`".$key."` = `".$value."`";
		// }
			// $sql .= implode(', ',$sets);
		// debug($sql);
		// debug($array);
		// debug($where);
		// update_db($con,$tabla,$array,$where);