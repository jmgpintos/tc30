<?php

if (!function_exists('validar_telefono')) {

    /**
     * Comprueba que el teléfono tenga 9 cifras
     * 
     * @param type $telefono
     */
    function validar_telefono($telefono)
    {
        return (strlen(limpia_espacios($telefono)) == 9);
    }

}

if (!function_exists('letra_nif')) {

    /**
     * Devuelve LA LETRA del NIF correspondiente a $dni
     * 
     * @param int $dni El número del DNI (sin letra)
     * @return String
     */
    function letra_nif($dni)
    {
        return substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($dni, "XYZ", "012") % 23, 1);
    }

}


if (!function_exists('comprobar_letra_nif')) {

    /**
     * Comprueba que la letra del DNI dado sea correcta. Válido para NIF y NIE
     * 
     * @param String $dni
     * @return boolean
     */
    function comprobar_letra_nif($dni)
    {
        if (strlen($dni) < 9) {
            return false; // "DNI demasiado corto."
        }

        $dni = strtoupper($dni);

        $letra = substr($dni, -1, 1);
        $numero = substr($dni, 0, 8);

        // Si es un NIE hay que cambiar la primera letra por 0, 1 ó 2 dependiendo de si es X, Y o Z.
        $numero = str_replace(array('X', 'Y', 'Z'), array(0, 1, 2), $numero);

        $modulo = $numero % 23;
        $letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
        $letra_correcta = substr($letras_validas, $modulo, 1);

        if ($letra_correcta != $letra) {
            return false; //"Letra incorrecta, la letra deber&iacute;a ser la $letra_correcta.";
        } else {
            return true; //"OK";
        }
    }

}


if (!function_exists('datecheck')) {

    /**
     * 
     * echo datecheck("25-01-1969")==1?'true':'false';
     * @param type $date
     * @return type
     */
    function datecheck($date = null, $sep = "-")
    {

        if (is_null($date) || empty($date)) {
            return false;
        }
        $sep = substr(preg_filter('/\d/', '', $date), 0, 1);
//        put($date. ' '. $sep);
//        var_dump($date);
        $fecha = explode($sep, $date);
        $anno = strlen($fecha[0]) == 4 ? $fecha[0] : $fecha[2];
        $mes = $fecha[1];
        $dia = strlen($fecha[0]) == 4 ? $fecha[2] : $fecha[0];
//        echo $dia . ' - ' . $mes . ' - ' . $anno . "\n";
        return checkdate($mes, $dia, $anno);
    }

//    $date = '1969-01-25';
//    $sep = substr(preg_filter('/\d/', '', $date), 0, 1);
//    echo $sep;
//    echo datecheck($date);
}

function comprobar_documento_identificacion($dni)
{
    if (strlen($dni) < 9) {
        return "DNI demasiado corto.";
    }

    $dni = strtoupper($dni);

    $letra = substr($dni, -1, 1);
    $numero = substr($dni, 0, 8);

    // Si es un NIE hay que cambiar la primera letra por 0, 1 ó 2 dependiendo de si es X, Y o Z.
    $numero = str_replace(array('X', 'Y', 'Z'), array(0, 1, 2), $numero);

    $modulo = $numero % 23;
    $letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
    $letra_correcta = substr($letras_validas, $modulo, 1);

    if ($letra_correcta != $letra) {
        return "Letra incorrecta, la letra deber&iacute;a ser la $letra_correcta.";
    } else {
        return "OK";
    }
}

