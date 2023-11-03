<?php
function db_connect($db_name) {
  // NOTE: Provide database authentication credentials.
  $db_host = '';
  $db_user = '';
  $db_pass = '';
  $db_object = @mysqli_connect($db_host, $db_user, $db_pass);
  if (!$db_object) die('Cannot connect to MySQL database: ' . mysqli_connect_error());
  mysqli_select_db($db_object, $db_name) or die("Could not select database: ".mysqli_error());
	return $db_object;
}
?>
