<?php

   $readdata = $_SERVER["QUERY_STRING"];
   parse_str($readdata);

	 require "../include/header.php";

   $db_name = 'crosslan';
   $db_object = db_connect($db_name);
	 $qu = isset($qu)? trim(urldecode($qu)):'';
	 $query = "SELECT spa_mesh.spa_descriptor as a from spa_mesh where spa_mesh.spa_descriptor like '$qu%' UNION select spa_tran.spa_descriptor as a from spa_tran where spa_tran.spa_descriptor like '$qu%' group by a order by a limit 10";
	 $result = mysqli_query($db_object, $query) or die("Query failed : " . mysqli_error());

	 $make = "sendRPCDone(frameElement, \"".urlencode($qu)."\", new Array(";
	 $make2 = "";
   $i = 1;
	 while ($line= mysqli_fetch_array($result)) {
			if ($i>1) {
		    $make .= ", ";
				$make2 .= ", ";
			}
			if ((isset($newflag) && $newflag == 1) && (mysqli_affected_rows($db_object) != 0)) {
				$make .= "\"".utf8_decode($oldqu.$line["a"])."\"";
			}
			else {
				$make .= "\"".utf8_decode($line["a"])."\"";
			}
			$make2 .="\"\"";
			$i++; 
		}
		$make .= "), new Array(".$make2."), new Array(\"\"));";
		echo $make;
?>
