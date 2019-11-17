<?php
/**
 * @abstract 
 *  
 * @param &array $array
 *  Array 
 * @param string $key
 *  Cadena de texto que es la key que se quiere comprobar si existe en el array 
 * @param mixed $fallback
 *  valor que obtendrá la $key dentro del array si no existía previamente 
 */
function assureArray(&$array, $key, $fallback) {
  $isset = isset($array[$key]);
  $array[$key] = ($isset) ? $array[$key] : $fallback ;
  return $isset;
}

function getAPIJuntion($url, $data=array()){
  //Create context for using POST
  $arrContextOptions = array(
    'http' =>
      array(
        'method'  => 'GET',
        'header'  => 'x-api-key: jmdSHjy6WPaXwoR75E6mJ1ImhxKPRJb51v6DBS0A',
      ),
    "ssl"=>array(
      "verify_peer"=>true,
      "verify_peer_name"=>true
    )
  ); 
  $raw_data = file_get_contents($url.'?'.http_build_query($data), false, stream_context_create($arrContextOptions));
  $json_data = json_decode($raw_data, true);
  return $json_data;
}