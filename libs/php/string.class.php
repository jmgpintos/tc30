<?php

Class Cadena {

    private static function mb_ucfirst($string, $encoding = 'UTF-8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    /*
      Pone en mayúscula la primera letra de cada palabra en $cad
      return -> string.
     */

    public static function capitalizar($cad)
    {
        $tipo = gettype($cad);
        $r = null;
        switch ($tipo) {
            case "array":
                foreach ($cad as $cadena) {
                    $r[] = self::capitalizar($cadena);
                }
                break;
            case "string":
                $largo = strlen(trim($cad));
                if ($largo) {
                    $separadores = Array(" ", "-", "(", "[");
//                    $preposiciones = array('a', 'ante', 'bajo', 'cabe', 'con', 'contra', 'de', 'desde', 'en', 'entre', 'hacia', 'hasta', 'para', 'por', 'según', 'sin', 'so', 'sobre', 'tras', /* no es prepo */ 'del', 'al');
//                    $articulos = array('el', 'la', 'las', 'los', 'un', 'unos', 'un', 'una', 'unas');
//                    $nexos = array('y', 'u', 'o', 'e');
//                    $particulas = array('a', 'ante', 'bajo', 'cabe', 'con', 'contra', 'de', 'desde', 'en', 'entre', 'hacia', 'hasta', 'para', 'por', 'según', 'sin', 'so', 'sobre', 'tras', /* no es prepo */ 'del', 'al', 'el', 'la', 'las', 'los', 'un', 'unos', 'un', 'una', 'unas', 'y', 'u', 'o', 'e', 'que', 'lo');
                    $particulas = Array("a", "de", "da", "del", "y", "o", "la", "de los",
                        "d'", "das", "al", "no", "en", "ni", "por", "ser", "e");
                    $cad = self::mb_ucfirst($cad);
                    // $cad = strtolower($cad);
                    $r = strtoupper(substr($cad, 0, 1)); //Primera letra
                    for ($i = 1; $i < $largo; $i++) {
                        if (in_array($cad[$i - 1], $separadores)) {
                            $r.=strtoupper($cad[$i]); //Si está detrás de un separador, se pone en mayúsculas
                        } else {
                            $r.=$cad[$i]; //Si no, se deja en minúsculas
                        }
                    }
                    //Está cada palabra capitalizada, ahora hay que poner en minúscula las partículas
                    $r = explode(" ", $r);
                    $largo = count($r);
                    for ($i = 0; $i < $largo; $i++) {
                        if (in_array(strtolower($r[$i]), $particulas)) {
                            $r[$i] = mb_strtolower($r[$i]);
                        }
                    }
                    $r = implode(" ", $r);
                }
                break;
            case "boolean":$r = $cad ? "TRUE" : "FALSE";
                break;
            case "NULL":$r = "NULO";
                break;
            default:
                $r = $cad;
                break;
        }
        return ucfirst($r);
    }

    /*
      Mira si $haystack empieza por $needle
      return -> boolean
     */

    public static function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    /*
      Mira si $haystack acaba con $needle
      return -> boolean
     */

    public static function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    public static function stripAccents($string)
    {
        $tofind = "ÀÁÂÄÅàáâäÒÓÔÖòóôöÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
        $replac = "AAAAAaaaaOOOOooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
        return utf8_encode(strtr(utf8_decode($string), utf8_decode($tofind), $replac));
    }

}

//
//$cad = new Cadena();
//$cad = 'álvarez';
//echo Cadena::capitalizar('álvarez');
