<?php

function is_valid_dni_nie($string) {
    if (strlen($string) != 9 ||
        preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', $string, $matches) !== 1) {
        return false;
    }

    $map = 'TRWAGMYFPDXBNJZSQVHLCKE';
    

    list(, $number, $letter) = $matches;

    return strtoupper($letter) === $map[((int) $number) % 23];
}
$dni='X6599869L';
echo is_valid_dni_nie($dni);
