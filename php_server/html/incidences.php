<?php
/**
 * Incidences
*/
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'].'/locFolders.php'; //localización de todo (entre ello las clases)
require_once $LOC_SMARTY_INIT.'smarty_init.inc.php';
require_once $LOC_FUNCTIONS.'dataFunctions.php';
require_once $LOC_CLASSES.'GeneraldbCommunications.php';

$url = 'https://junction.dev.qoco.fi/api/customers';
$data=array(
  'customerId'=>CUSTOMER_ID
);
$customer = getAPIJuntion($url, $data);
$title = "Incidences";

$specification_array = array( 
  0 => array (
    'column'=> 'customerId',
    'operator'=> '=',
    'value'=> CUSTOMER_ID
  ),
  1 => array (
    'column'=> 'resolved',
    'operator'=> '!=',
    'value'=> 'true'
  )
);
$customerID = CUSTOMER_ID;

$query = "SELECT * FROM `TravelMiss` WHERE `customerId` = '$customerID' AND (`resolved` != 'true' OR `resolved` is null)  ORDER BY `customerId` DESC;";

$db_object = new dbCommunication();
//$events = $db_object->getRows($specification_array);
$events = $db_object->freeQuery($query);
$allOK = $db_object->errors();
$db_object->close();

if ($allOK!=='') {
  var_dump($allOK);
}

$smarty->assign('title', $title);
$smarty->assign('customer', $customer['customers']);
$smarty->assign('events', $events);
$smarty->display('incidences.tpl');
