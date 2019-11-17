<?php
function get_value_post($var, $fallback_value="") {
  return isset($_POST[$var]) ? $_POST[$var] : $fallback_value;
}

function get_value_get($var, $fallback_value="") {
  return isset($_GET[$var]) ? $_GET[$var] : $fallback_value;
}

function get_value_session($var, $fallback_value="") {
  return isset($_SESSION[$var]) ? $_SESSION[$var] : $fallback_value;
}