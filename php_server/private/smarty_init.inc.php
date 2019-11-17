<?php

// make sure errors are displayed
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once $_SERVER["DOCUMENT_ROOT"].'/locFolders.php'; //Hay que dar el valor de directorio de SMARTY desde el origen al que llaman a este script; esto está en locFolders.php en la variable $LOC_SMARTY_INIT

// Localizacion de las carpetas centralizadas en locFolders.php
define("SMARTY_DIR", $LOC_SMARTY_LIBS);
define("PROJECT_DIR", $LOC_SMARTY_INIT);

// init Smarty
require(SMARTY_DIR . "Smarty.class.php");
$smarty = new Smarty();
$smarty->setTemplateDir(PROJECT_DIR . "smarty/templates");
$smarty->setCompileDir(PROJECT_DIR . "smarty/templates_c");
$smarty->setCacheDir(PROJECT_DIR . "smarty/cache");
$smarty->setConfigDir(PROJECT_DIR . "smarty/config");
