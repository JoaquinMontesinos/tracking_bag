<?php
/**
 * Página principal. Enlace a las demás
*/
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'].'/locFolders.php'; //localización de todo (entre ello las clases)
require_once $LOC_SMARTY_INIT.'smarty_init.inc.php';
require_once $LOC_FUNCTIONS.'dataFunctions.php';

$url = 'https://junction.dev.qoco.fi/api/customers';
$data=array(
  'customerId'=>CUSTOMER_ID
);
$customer = getAPIJuntion($url, $data);
$title = "Home Trackbag";

$smarty->assign('title', $title);
$smarty->assign('customer', $customer['customers']);
$smarty->display('index.tpl');