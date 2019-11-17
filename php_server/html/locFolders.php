<?php

require_once 'customerId.php';

//Localizacion de las distintas clases/imágenes/archivos... 
//a partir del directorio raíz de publicacion (www ó carpeta public_html)
define('DS', DIRECTORY_SEPARATOR);

$_ROOTdir= $_SERVER["DOCUMENT_ROOT"].DS.'..'.DS; //Direccion de arriba de publicacion. Justo arriba de public_html
$PRIVATE=$_ROOTdir.'private'.DS.'';

$LOC_CLASSES		=$PRIVATE.'classes'.DS.'';
$LOC_IMAGENES 	=$_SERVER["DOCUMENT_ROOT"].DS.'assets'.DS.'images'.DS;

$LOC_FUNCTIONS	=$PRIVATE.'helperFunctions'.DS.'';
$LOC_SMARTY_INIT=$PRIVATE;
$LOC_DB_CONFIG	=$PRIVATE;

$LOC_SMARTY_LIBS    =$PRIVATE.'smarty-3.1.32'.DS.'libs'.DS.'';

//Para otros apartados:
define('BASE_WEB_IP', $_SERVER['SERVER_NAME']);
define('BASE_WEB_PORT', $_SERVER['SERVER_PORT']);
define('BASE_HTTP_HOST', $_SERVER['HTTP_HOST']);
define('BASE_WEB_URL', 'https://'.BASE_HTTP_HOST.'/');
