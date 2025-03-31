<?php

//require_once __DIR__.'/application.php';

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'awproyecto');
define('BD_USER', 'awproyecto');
define('BD_PASS', 'awproyecto');

/**
 * Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación
 */
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/awproyecto');
define('RUTA_IMGS', RUTA_APP.'/comun/img');
define('RUTA_CSS', RUTA_APP.'/view/styles');
define('RUTA_JS', RUTA_APP.'/view/JS');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');
/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */