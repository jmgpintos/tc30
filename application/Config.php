<?php

define('DEBUG', true); //Cambiar en producción

define('VERSION_MAJOR',3);
define('VERSION_MINOR',0);
define('VERSION_PATCH',2);

if (DEBUG) {
    define('BASE_URL', '/tc30/');
    define('SESSION_TIME', 150); //Minutos antes de que caduque la sesión
} else {
    define('BASE_URL', 'http://www.campussantanderemprende.com/tc30/');
    define('SESSION_TIME', 15); //Minutos antes de que caduque la sesión
}

define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_METHOD', 'index');

define('DEFAULT_LAYOUT', 'default');

define('APP_NAME', 'Telecentros 3.0');
define('APP_SLOGAN', 'Administraci&oacute;n de Telecentros');
define('APP_COMPANY', 'Ayuntamiento de Santander');

define('DEFAULT_ROLE', 'usuario');

define('HASH_KEY', '5576f7687dd7e');
define('DEFAULT_PASSWORD', '1234'); //Contraseña por defecto al restablecer
define("SIGNPW", '871679c9a2f16e8db7bb32d215198613abdaac7d'); //VillaFlorida, PW Registro

if (DEBUG) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'prueba');
    define('DB_CHAR', 'utf8');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'moodle_b');
    define('DB_PASS', 'g2XR5A6y$u');
    define('DB_NAME', 'test');
    define('DB_CHAR', 'utf8');
}

define('TABLES_PREFIX', 'tc30_');


define('DEFAULT_POST_IMG', 'default_post.png');
define('DEFAULT_USER_IMG', 'default_user.png');
define('DEFAULT_CENTRO_IMG', 'default_centro.png');
define('MAX_SIZE_IMG', 8192);

define('DEFAULT_HORAS_CURSO', 10);