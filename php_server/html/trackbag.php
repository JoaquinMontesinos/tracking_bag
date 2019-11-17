<?php
/**
 * Trackbag, página clave
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
$rsp = getAPIJuntion($url, $data);
$customer = $rsp['customers'];

$url = 'https://junction.dev.qoco.fi/api/baggage';
$rsp = getAPIJuntion($url, $data);
$baggages = $rsp['baggage'];

foreach ($baggages as $key => $data) {
  $url = 'https://junction.dev.qoco.fi/api/events/'.$data['baggageId'];
  $rsp = getAPIJuntion($url, $data);
  $events = $rsp['events'];
  unset($events['baggageId']);
  usort($events, function ($event1, $event2) {
    return $event1['timestamp'] <=> $event2['timestamp'];
  });
  $baggages[$key]['events'] = $events;
}

$title = "Tracking bag";

$smarty->assign('title', $title);
$smarty->assign('customer', $customer);
$smarty->assign('baggages', $baggages);
$smarty->display('trackbag.tpl');