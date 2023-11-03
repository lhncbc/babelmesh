<?php
  $readdata = $_SERVER["QUERY_STRING"];
  parse_str($readdata);
	
	require "../include/header.php";
  $db_name = 'crosslan';
  $db_object = db_connect($db_name);
	$table = $lang."_mesh";
	$lang = strtoupper($lang);
	$lang_col = $lang."_DESCRIPTOR";
	$eng_col = "US_DESCRIPTOR";
		
	$qu = isset($qu)? trim(urldecode($qu)):'';

	$query = "select ".$lang_col." as a from ".$table." where ".$lang_col." like '$qu%' group by a order by a limit 10";
	$result = mysqli_query($db_object, $query);// or die("Query failed : " . mysqli_error());

	$make = "sendRPCDone(frameElement, \"".urlencode($qu)."\", new Array(";
	$make2 = "";
  $i = 1;
	while ($line= mysqli_fetch_array($result)) {
		if ($i>1) {
	    $make .= ", ";
			$make2 .= ", ";
		}
		if ((isset($newflag) && $newflag == 1) && (mysqli_affected_rows($db_object) != 0)) {
			$make .= "\"".$oldqu.$line["a"]."\"";
		}
		else {
		 $make .= "\"".$line["a"]."\"";
		}
		$make2 .="\"\"";
		$i++; 
	}
	$make .= "), new Array(".$make2."), new Array(\"\"));";
	echo $make;
?>
