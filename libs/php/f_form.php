<?php
/*
  Fichero f_form.php
  Funciones para construir formularios
*/

if(!function_exists('todosYNinguno')){
	function todosYNinguno($todosYNinguno, $nombre){
	/*Opción por defecto y opción todos (línea de puntos y 'Todos')
	0 -> Nada
	1 -> linea de puntos -> devuelve 0
	2 -> Todos -> devuelve -1
	3 -> linea de puntos y todos
	*/
		if($todosYNinguno===1 || $todosYNinguno===3){
			echo linea().tab()."<option value='0' ";
			if(!isset($_REQUEST[$nombre])){
			echo "selected ";}
			echo "> --------------------- </option>";
			}
		if($todosYNinguno===2 || $todosYNinguno===3){
			echo linea().tab()."<option value='-1' ";
			if(isset($_REQUEST[$nombre]) && $_REQUEST[$nombre] == -1){
			echo "selected";}
			echo "> ---Todos--- </option>";
		}
		if(gettype($todosYNinguno)==="string"){
			echo linea().tab()."<option value='-1' disabled ";
			if(isset($_REQUEST[$nombre]) && $_REQUEST[$nombre] == -1){
			echo "selected";}
			echo "> ".$todosYNinguno." </option>";
		}
	}
}

/*
Crea un combo (select) a partir de los datos de entrada
parametros:
$con:						Conexión
$nombre:			 	Nombre del control select
$tabla:						Nombre de tabla (o  cadena SQL) de la que se extraen los datos
$datos:					Array asociativo (campoIndice => campoValor) con el nombre de los campos para rellenar el select. ej: ('dni' => 'nombre')
$cambiado:			Indica si se ha seleccionado un valor (cambia el estilo)
$todosYNinguno:	Añade dos opciones ('----------' y 'Todos') al inicio del select
$clase:						Estilo css del select
*/
if(!function_exists('combo')){
	function combo($con, $nombre, $tabla, $datos, $cambiado = 0,$todosYNinguno=3, $submit = 1, $clase = 's200'){
	//Comienza a construir el combo
	echo linea().'<select name="'.$nombre.'" class="'.$clase;
	if($cambiado>0){
		echo  ' selectActivo"';
		} else{
		echo '"';
		}
   if($submit === 1){
    echo ' onChange = "submit();"';
    }
    echo "> ";

	//Captura  nombres de campos deseados
	foreach($datos as $key=>$value){
		$indice = $key;
		$valor = $value;
		}
	$valor = $datos[$indice];

	//Forma la sentencia SQL
	if(startsWith($tabla,"SELECT")){
		$sql  = $tabla;
		}else{
		$sql = "SELECT * FROM $tabla ORDER BY $valor";
		}

	todosYNinguno($todosYNinguno, $nombre);
	//Llena el resto del combo
	// foreach($con->query($sql) as $row){
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result)){
		echo linea().tab();
		if(isset($_REQUEST[$nombre]) && $_REQUEST[$nombre] == $row[$indice]){
			echo "<option value='".$row[$indice]."' selected>".$row[$valor]."</option>";
		} else {
			echo "<option value='".$row[$indice]."'>".$row[$valor]."</option>";
		}
	}
	echo linea()."</select>".linea();
	}
}
	
/*
Crea un array asociativo a partir de los valores dados
parametros:
$con:						Conexión
$tabla:						Nombre de tabla (o  cadena SQL) de la que se extraen los datos
$datos:					Array asociativo (campoIndice => campoValor) con el nombre de los campos para incluir en el array. ej: ('dni' => 'nombre')
*/
if(!function_exists('sql2asoc')){
	function sql2asoc($con, $tabla, $datos){
	
	//Inicializa el array
	$r=array(); 
	//Captura  nombres de campos deseados
	foreach($datos as $key=>$value){
		$indice = $key;
		$valor = $value;
		}
	$valor = $datos[$indice];
	
	//Construye SQL
	if(startsWith($tabla,"SELECT")){
		$sql  = $tabla;
		}else{
			$sql = "SELECT * FROM $tabla ";
			}
	//Puebla array		
	$result = mysqli_query($con,$sql);
	if($result){
		while($row = mysqli_fetch_array($result)){
			$r[$row[$indice]] =$row[$valor];
			}
		}else{
		$r['xxxxx'] ='No hay valores';
	}
	return $r;
	}
}

/*
Crea un array  a partir de los valores dados
parametros:
$con:				Conexión
$tabla:			Nombre de tabla (o  cadena SQL) de la que se extraen los datos
$campos:		Array acon el nombre de los campos para incluir en el array devuelto
*/
if(!function_exists('sql2array')){
	function sql2array($con, $tabla, $campos){
	//Inicializa el array
	$r=array(); 
	//Construye SQL
	if(startsWith($tabla,"SELECT") || startsWith($tabla,"DESCRIBE")){
		$sql  = $tabla;
		}else{
			$sql = "SELECT * FROM $tabla ";
			}
			// echo $sql;
	//Puebla array		
	$result = mysqli_query($con,$sql);
			while($row = mysqli_fetch_array($result)){
			// print $i++;
			$r1=Array();
				foreach($campos as $campo){
					$r1[] = $row[$campo];
					}
					$r[] = $r1;
			}
	return $r;
	}
}

/*
Crea un combo (select) a partir de un array asociativo
parametros:
$nombre: 	Nombre del control select
$array:			Array asociativo con los datos para el combo (clave => valor)
*/
if(!function_exists('asoc2combo')){
	function asoc2combo($nombre,$array,$todosYNinguno=3, $estilo=null, $submit = 1, $class="s200"){
	// echo '<select name="'.$nombre.'" class="s200" onChange = "submit();"> ';
	echo '<select name="'.$nombre.'" ';
	if($estilo!=null){
		echo 'style = "'.$estilo.'" ';
		} else
		{	
			echo 'class="'.$class.'" ';
			}
		if($submit == 1){
			echo ' onChange = "submit();"'; 
			}
		echo '>';
	todosYninguno($todosYNinguno, $nombre);
	foreach($array as $indice => $valor)
    		{
			echo tab();
				if(isset($_REQUEST[$nombre]) && $_REQUEST[$nombre] == $indice){
					echo "<option value='".$indice."' selected>".$valor."</option>";
				} else {
					echo "<option value='".$indice."'>".$valor."</option>";
				}
				echo linea();
    		}
	echo"</select>".linea();
	}
}

/*
Pasa las variables SESSION a REQUEST (si no hay existe ninguna variable REQUEST)
$vars: Array con el índice de las variables SESSION
*/
if(!function_exists('ses2req')){
	function ses2req($vars)	{
		$existe = 0;
		foreach($vars as $var){if(isset($_REQUEST[$var])) $existe = 1;}
		if($existe===0){	
			foreach($vars as $var){if(isset($_SESSION[$var])){$_REQUEST[$var] = $_SESSION[$var];}}
			}
		}
}
		
/*
Pasa las variables REQUEST a SESSION
$vars: Array con el índice de las variables REQUEST
*/
if(!function_exists('req2ses')){
	function req2ses($vars)	{
		foreach($vars as $var){
			if(isset($_REQUEST[$var])){$_SESSION[$var] = $_REQUEST[$var];}
			}
		}
}



/*
	Crea una tabla (table) a partir de los datos recibidos
	parámetros
	$filas				Array (creado con sql2array) con los datos a mostrar
	$campos:		Array con los nombres de los campos a mostrar
	$linkenPrimeraColumna Crea un enlace (<a href>) en la primera columna. El primer campo de $campos es el destino; el segundo, el texto del enlace. El primer campo no sale en la tabla.
	$conContador Pone un contador en cada linea
	$estilos		Array asociativo (campo=>estilo) para pasar CSS para columnas en concreto
	$claseTabla:	Clase CSS
	*/

if(!function_exists('mostrarTabla')){
	function mostrarTabla($filas, $campos,$linkenPrimeraColumna=0,$conContador=0,$estilos=array(),$claseTabla="tablaIncidencias"){
		// print_r($filas);
			$i = 1;
			if($filas){
			echo "<table style='margin:auto;' id='".$claseTabla."' >".linea();
			
			//cabecera de tabla
				echo tab()."<tr>".linea();
				if($conContador===1){
					echo tab().tab()."<th>#</th>".linea();
				}
				if($linkenPrimeraColumna===1){
				$columna=1;
				}else{
				$columna=0;
				}
				for($j=$columna;$j<count($campos);$j++){
					echo tab().tab()."<th>".capitalizar(trim($campos[$j]))."</th>".linea();
				}
				$columna++;
				echo tab()."</tr>".linea();
				
				//cuerpo de tabla
					foreach($filas as $entidad) {
						echo tab()."<tr>".linea();
						if($conContador===1){
							echo tab().tab()."<td style='padding:2px 7px;'>".$i++."</td>".linea();
							}	
						echo tab().tab()."<td >";
						if($linkenPrimeraColumna===1){
						 echo "<a href='gestionalumnosmatriculados.php?idFichaCurso=$entidad[0]'>".$entidad[1]."</a>";
						 }else{
						 echo $entidad[0];
						 }
						 echo "</td>".linea();
						for($j=$columna;$j<count($campos);$j++){
							$item = ($entidad[$j]);
							//comprobar si es fecha
							if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $item)){
							//cambiar fecha a dd-mm-aa
							$item = FechaHora::fechaDMA($item,"/");
							}
							echo tab().tab()."<td style='padding:2px 7px;";
							if(isset($estilos[$campos[$j]])){
								echo $estilos[$campos[$j]];
							}
							echo " '>".$item."</td>".linea();
						}
						echo tab()."</tr>".linea();
					}
				echo tab()."</table>".linea();
			}else{
				echo tab()."<div class='error'>No hay resultados</div>".linea();
			}
		}
}
		

