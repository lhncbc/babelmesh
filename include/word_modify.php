<?php

$replace_pair = array(array(strtolower("parkinson disease"),strtolower("parkinsons disease")));

for ($i=0; $i<sizeof($replace_pair); $i++) {
  foreach ($_POST as $key => $value) {
	  if ( strpos(" ".strtolower($_POST[$key]), strtolower($replace_pair[$i][0])) == true) {
      $_POST[$key] = str_replace($replace_pair[$i][0], $replace_pair[$i][1], strtolower($_POST[$key]));
		}
  }
  if ( strpos(" ".strtolower($_SERVER["QUERY_STRING"]), strtolower($replace_pair[$i][0])) == true) {
    $_SERVER["QUERY_STRING"] = str_replace($replace_pair[$i][0], $replace_pair[$i][1], strtolower($_SERVER["QUERY_STRING"]) );
	}
}
?>