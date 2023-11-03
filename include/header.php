<?php
require "conf.php";
require "dbconnect.php";
require "word_modify.php";

$bad_chars = array("P(", "I(", "C(", "O(", "|", "&", ";", "$", "%", "\"",   "\\\"", "<", ">",  "\\",  "(", ")",  "+", '=' ); 
$bad_chars_2 = array("\\'", "'");
$pattern = array('/javascript/i', '/script>/i', '/%3Cjavascript%3E/i', '/script%3E/i', '/xss:/i', '/:expression/i');
$replacement = ' ';
foreach ($_POST as $key => $value) {
  if ( (is_array($key) != true ) && (is_array($value) != true) ) {
		// limit input length to 2000 characters -- added in Mar, 2010
		$value = substr($value, 0, 2000);
		
    $_POST[$key] = strip_tags($value);
		$_POST[$key] = preg_replace($pattern, $replacement, $_POST[$key]);
		$_POST[$key] = str_replace($bad_chars, $replacement, $_POST[$key]);
		$_POST[$key] = str_replace($bad_chars_2, "", $_POST[$key]);
	}
}
foreach ($_GET as $key => $value) {
  if ( (is_array($key) != true ) && (is_array($value) != true) ) {
		$value = substr($value, 0, 2000);
		
    $_GET[$key] = strip_tags($value);
		$_GET[$key] = preg_replace($pattern, $replacement, $_GET[$key]);
		$_GET[$key] = str_replace($bad_chars, $replacement, $_GET[$key]);
		$_GET[$key] = str_replace($bad_chars_2, "", $_GET[$key]);
	}
}
// limit input length to 2000 characters -- added in Mar, 2010
$_SERVER["QUERY_STRING"] = substr($_SERVER["QUERY_STRING"], 0, 2000);
parse_str($_SERVER["QUERY_STRING"], $output);
$parse_out = '';
foreach ($output as $key => $value) {  
    $output[$key] = strip_tags($value);
		$output[$key] = preg_replace($pattern, $replacement, $output[$key]);
		$output[$key] = urlencode(str_replace($bad_chars, $replacement, urldecode($output[$key])));
		$output[$key] = urlencode(str_replace($bad_chars_2, "", urldecode($output[$key])));
		$parse_out .= $key."=".$output[$key]."&";
}
$_SERVER["QUERY_STRING"] = substr($parse_out, 0, strlen($parse_out)-1);

$pos_php = stripos($_SERVER['PHP_SELF'], ".php");
$_SERVER['PHP_SELF'] = substr($_SERVER['PHP_SELF'], 0, ($pos_php+4));
$_SERVER['PHP_SELF'] = htmlspecialchars($_SERVER['PHP_SELF']);
$pos_php = 0;

function get_client_ip()
{
 if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
        return  $_SERVER["HTTP_X_FORWARDED_FOR"];  
 } elseif (array_key_exists('REMOTE_ADDR', $_SERVER)) { 
        return $_SERVER["REMOTE_ADDR"]; 
 } elseif (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER["HTTP_CLIENT_IP"]; 
 } 
}
?>
