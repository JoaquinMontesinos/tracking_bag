<?php
/**
 * @abstract 
 * 	Webservice para hacer distintas operaciones con la base de datos (En principio está pensando para una sola clase, pero puede extenderse sin mayor dificultad)
*/

require_once $_SERVER['DOCUMENT_ROOT'].'/locFolders.php'; //localización de todo (entre ello las clases)

require_once $LOC_CLASSES.'GeneraldbCommunications.php';
require_once $LOC_FUNCTIONS.'formFunctions.php';
require_once $LOC_FUNCTIONS.'dataFunctions.php';


function sendSMS ($sms) {
  $username = "ue0f837b3e4233b84b8551a74fb4dfcfe";
  $password = "A16AA21013C000A28F5D4E7305CDEA94";
  $context = stream_context_create(array(
    'http' => array(
      'method' => 'POST',
      'header'  => 'Authorization: Basic '.
                  base64_encode($username.':'.$password). "\r\n".
                  "Content-type: application/x-www-form-urlencoded\r\n",
      'content' => http_build_query($sms),
      'timeout' => 10
  )));
  $response = file_get_contents("https://api.46elks.com/a1/sms",
    false, $context);

  if (!strstr($http_response_header[0],"200 OK"))
    return $http_response_header[0];
  return $response;
}

$debug = array();
$data_to_send = array();

$type = get_value_post('type');
$data = get_value_post('data', array());


$todoOK = true;
switch ($type) {

	case 'sendSMS':
		$sms = array(
		  "from" => "TrackingBag",   
		  "to" => "+34630854563",  
		  "message" => json_encode($data),
		);
		$data_to_send = json_decode(sendSMS($sms), true);
		break;

  case 'markAsResolved':
    $specification_array = array( 
      0 => array (
        'column'=> 'id',
        'operator'=> '=',
        'value'=> $data['incidentId']
      )
    );
    $data_array = array(
      'resolved'=>'true'
    );
    $db_object = new dbCommunication();
    $todoOK = $db_object->updateRow($data_array, $specification_array);
    if ($todoOK!==true) {
      $data_to_send = $db_object->errors();
    } else {
      $data_to_send = $todoOK;
    }
    $db_object->close();
    break;

  case 'createIncident':
    $db_object = new dbCommunication();
    $data['event'] = 'MISSING';
    $todoOK = $db_object->setRow($data);
    if ($todoOK!==true) {
      $data_to_send = $db_object->errors();
    } else {
      $data_to_send = $todoOK;
    }
    $db_object->close();
    break;

	default:
		$todoOK = false;
		$debug[] = 'Has elegido mal el tipo de operación';
		break;
}

$unencoded_data = array(
	'todoOK' => $todoOK, 
	'data' => $data_to_send,
	'debug' => $debug,
);

// Indico cabecera como json
header('Content-type: application/json; charset=utf-8'); 
//mando el resultado como un json		
echo json_encode($unencoded_data);


function formatForAutocomplete($dataArray) {
	$search_results = array();
	foreach ($dataArray as $data) {
	  $one_result = array(
	    'shown_string' => $data['guest_name'], //Será lo que aparezca en los resultados de búsqueda; puede ser lo que se quiera, ya que lo que se rellenará viene determinado en las siguientes lineas.
	    'autocomplete_data' => array(
	    	'itself' => $data['guest_name'], //Esto es importante. Será con lo que se autorrellene el propio input desde el que se busca
	    	//Se pueden poner cualquier dato aquí, y se autorellenará un input de nombre 'nombre_input_autorrelleno'. El valor será $data['...']
	      'nombre_input_autorrelleno1' => $data['...1'], 
	      'nombre_input_autorrelleno2' => $data['...2'], 
	    )
	  );
	  array_push($search_results, $one_result);
	}
	return $search_results;
}

?>