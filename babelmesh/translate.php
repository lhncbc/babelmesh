<?php
class translate {
  var $db;
	
  function translate() {
	  $this->db = NULL;
	}
	
	function setDB($in) {
	  $this->db = $in;
	}
	
  function Sfinder($input) {
	  global $db_object;
	  $db = $this->db;
	  $terms = array();
		$a = array();
		$b = array();
		$allterms = array();
		$output = array();
		
	  $terms = explode(" ",trim($input));

		for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		$begin = 0;
		$end = sizeof($allterms);
		$use_later = array();		

		while ($begin <= $end) {
		  $a = array();
			for ($i=$begin; $i<sizeof($allterms); $i++) {
		    if( $allterms[$i] != "" ) {
			    array_push($a, $allterms[$i]);
			  }
			}
			$stopsign = 0;
			//print $begin;
			while (($stopsign == 0) && ($begin <= $end) ) {
		    $test = trim(implode(" ", $a));
			    $query = "SELECT US_DESCRIPTOR FROM spa_tran WHERE SPA_DESCRIPTOR = '".$test."' ORDER BY cui";
	  			$result = mysqli_query($db_object, $query) or die("Query failed : " );
					if (mysqli_affected_rows($db_object) == 0) {
				    $stopsign = 0;
						$later_element = array_pop($a);
						//array_pop($a);
						if (sizeof($a) == 0) {
						  $stopsign = 1;
							$begin = $begin + 1;
							array_push($use_later, trim($later_element));
						}
						//print "a=\n";
					}
					else {
				    $stopsign = 1;
						$begin = $begin + sizeof($a);
						$line= mysqli_fetch_array($result);
						$term = $line["US_DESCRIPTOR"];
						/*
						if ($term =="") {
					    $term = $line["US_DESCRIPTOR"];
						}
						*/
						//print $term."\n";
						array_push($output, $term);
					}

					if ( ($begin == $end) && ($test =='' ) ) {
					 $begin ++;
				  }
			}// end inside while
		}
		
		$no_plural_res = '';
		for ($j=0; $j<sizeof($use_later); $j++) {
		  $no_plural_res = $this->no_plural_S($use_later[$j]);
			if ($no_plural_res !='') {
			  array_push($output, $no_plural_res);
			}
		}
		
	  return $output;
	}
	
	function Ffinder($input) {
		global $db_object;
	  $db = $this->db;
	  $terms = array();
		$a = array();
		$b = array();
		$allterms = array();
		$output = array();
		
	  $terms = explode(" ",trim($input));
		
		for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		$begin = 0;
		$end = sizeof($allterms);
		$use_later = array();		
		while ($begin <= $end) {
		  $a = array();

			for ($i=$begin; $i<sizeof($allterms); $i++) {
		    if( $allterms[$i] != "" ) {
			    array_push($a, $allterms[$i]);
			  }
			}
			$stopsign = 0;

			while (($stopsign == 0) && ($begin <= $end) ) {
		    $test = implode(" ", $a);
				//echo $test."<br>";
				$query = "SELECT US_DESCRIPTOR FROM fre_tran WHERE FRE_DESCRIPTOR = '".$test."' GROUP BY US_DESCRIPTOR";
				//echo $query."<br>";
	  		$result = mysqli_query($db_object, $query) or die("Query failed : ");
				if (mysqli_affected_rows($db_object) == 0) {
			    //$query = "SELECT US_DESCRIPTOR FROM fre_tran WHERE ACCENTUATED_FRE_DESCRIPTOR = '".$test."' GROUP BY US_DESCRIPTOR";
					$query = "SELECT US_DESCRIPTOR FROM fre_tran WHERE SIMPLE_FRE_DESCRIPTOR = '".$test."' ";
	  			$result = mysqli_query($db_object, $query) or die("Query failed : ");
					if (mysqli_affected_rows($db_object) == 0) {
				    $stopsign = 0;
						//array_push($use_later, trim(array_pop($a)));
						$later_element = array_pop($a);
						if (sizeof($a) == 0) {
						  $stopsign = 1;
							$begin = $begin + 1;
							array_push($use_later, trim($later_element));
						}
					}
					else {
				    $stopsign = 1;
						$begin = $begin + sizeof($a);
						$line= mysqli_fetch_array($result);
						$term = $line["US_DESCRIPTOR"];
						array_push($output, $term);
						
					}
				}
				else {
			    $stopsign = 1;
					$begin = $begin + sizeof($a);
					$line= mysqli_fetch_array($result);
					$term = $line["US_DESCRIPTOR"];
					array_push($output, $term);
					
				}
				
				if ( ($begin == $end) && ($test =='' ) ) {
					 $begin ++;
				}
				 
			}// end inside while
		}

		$no_plural_res = '';
		for ($j=0; $j<sizeof($use_later); $j++) {
		  $no_plural_res = $this->no_plural_F($use_later[$j]);
			if ($no_plural_res !='') {
			  array_push($output, $no_plural_res);
			}
		}
	
	  return $output;
	}
	
	function no_plural_F($input) {
		
		global $db_object;
	/*
	  if(substr($input, -2, 2) == "es" || substr($input, -2, 2) == "ES") {
				$new_input = substr($input, 0, -2);
		}
		else
		*/
		if(substr($input, -1, 1) == "s" || substr($input, -1, 1) == "S") {
				$new_input = substr($input, 0, -1);
		}
		if(trim($new_input) != '') {
		  	$query = "SELECT US_DESCRIPTOR FROM fre_tran WHERE FRE_DESCRIPTOR = '".$new_input."' GROUP BY US_DESCRIPTOR";
	  		$result = mysqli_query($db_object, $query) or die("Query failed : " );
				if (mysqli_affected_rows($db_object) == 0) {
			    $query = "SELECT US_DESCRIPTOR FROM fre_tran WHERE ACCENTUATED_FRE_DESCRIPTOR = '".$new_input."' GROUP BY US_DESCRIPTOR";
	  			$result = mysqli_query($db_object, $query) or die("Query failed : ");
				}
				$line= mysqli_fetch_array($result);
				$term = $line["US_DESCRIPTOR"];
				if ($term != '') {
				  $output = $term;		
				}
		}
		return $output;
	}
	
	function no_plural_S($input) {
		global $db_object;

		if(substr($input, -1, 1) == "s" || substr($input, -1, 1) == "S") {
				$new_input = substr($input, 0, -1);
		}
		if(trim($new_input) != '') {
		  	$query = "SELECT US_DESCRIPTOR FROM spa_tran WHERE SPA_DESCRIPTOR = '".$new_input."' GROUP BY US_DESCRIPTOR";
	  		$result = mysqli_query($db_object, $query) or die("Query failed : ");
				$line= mysqli_fetch_array($result);
				$term = $line["US_DESCRIPTOR"];
				if ($term != '') {
				  $output = $term;		
				}
		}
		return $output;
	}
	
	
	
	function no_plural_P($input) {

		global $db_object;
		if(substr($input, -1, 1) == "s" || substr($input, -1, 1) == "S") {
				$new_input = substr($input, 0, -1);
		}
		if(trim($new_input) != '') {
		  	$query = "SELECT US_DESCRIPTOR FROM por_mesh WHERE POR_DESCRIPTOR = '".$new_input."' GROUP BY US_DESCRIPTOR";
	  		$result = mysqli_query($db_object, $query) or die("Query failed : ");
				$line= mysqli_fetch_array($result);
				$term = $line["US_DESCRIPTOR"];
				if ($term != '') {
				  $output = $term;		
				}
		}
		return $output;
	}
	
	
	
	function Pfinder($input) {
		global $db_object;
	  $db = $this->db;
	  $terms = array();
		$a = array();
		$b = array();
		$allterms = array();
		$output = array();
		
	  $terms = explode(" ",trim($input));

		for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		$begin = 0;
		$end = sizeof($allterms);
		$use_later = array();		
		
		while ($begin <= $end) {
		  $a = array();
			for ($i=$begin; $i<sizeof($allterms); $i++) {
		    if( $allterms[$i] != "" ) {
			    array_push($a, $allterms[$i]);
			  }
			}
			$stopsign = 0;
			//print $begin;
			while (($stopsign == 0) && ($begin <= $end) ) {
		    $test = trim(implode(" ", $a));
				$query = "SELECT US_DESCRIPTOR FROM por_mesh WHERE POR_DESCRIPTOR = '".$test."'";
	  		$result = mysqli_query($db_object, $query) or die("Query failed : ");
				if (mysqli_affected_rows($db_object) == 0) {
				    $stopsign = 0;
						//array_pop($a);
						$later_element = array_pop($a);
						if (sizeof($a) == 0) {
						  $stopsign = 1;
							$begin = $begin + 1;
							array_push($use_later, trim($later_element));							
						}
				}
				else {
			    $stopsign = 1;
					$begin = $begin + sizeof($a);
					$line= mysqli_fetch_array($result);
					$term = $line["US_DESCRIPTOR"];
					/*
					if ($term =="") {
				    $term = $line["US_DESCRIPTOR"];
					}
					*/
					//print $term."\n";
					array_push($output, $term);
				} 
				if ( ($begin == $end) && ($test =='' ) ) {
					 $begin ++;
				}
			}// end inside while
		}
		
		$no_plural_res = '';
		for ($j=0; $j<sizeof($use_later); $j++) {
		  $no_plural_res = $this->no_plural_P($use_later[$j]);
			if ($no_plural_res !='') {
			  array_push($output, $no_plural_res);
			}
		}	
			
	  return $output;
	}
	
	function Cfinder($input) {
		global $db_object;
	  $db = $this->db;
	  $terms = array();
		$a = array();
		$b = array();
		$allterms = array();
		$output = array();
		
		$query = "SET character_set_connection = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		$query = "SET character_set_client = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		$query = "SET character_set_server = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		$query = "SET character_set_database = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		$query = "SET character_set_results = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");

		$input2 = trim($input);
	  $terms = explode(" ",trim($input));

		for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		$begin = 0;
		$end = sizeof($allterms);
		
		while ($begin <= $end) {
		  $a = array();
			for ($i=$begin; $i<sizeof($allterms); $i++) {
		    if( $allterms[$i] != "" ) {
			    array_push($a, $allterms[$i]);
			  }
			}
			$stopsign = 0;

			while (($stopsign == 0) && ($begin <= $end) ) {
		    $test = implode(" ", $a);
				$query = "SELECT eng FROM chi_mesh WHERE chi = '".$test."'";
	  		$result = mysqli_query($db_object, $query) or die("Query failed : ");
				if (mysqli_affected_rows($db_object) == 0) {

				    $stopsign = 0;
						array_pop($a);
						if (sizeof($a) == 0) {
						  $stopsign = 1;
							$begin = $begin + 1;
						}

				}
				else {
			    $stopsign = 1;
					$begin = $begin + sizeof($a);
					$line= mysqli_fetch_array($result);
					$term = $line["eng"];
					array_push($output, $term);
					$input2 = str_replace($test,"",$input2);
				} 
			}// end inside while
		}
		
		$input3 = explode(" ", trim($input2));
		for ($i=0; $i<sizeof($input3); $i++) {
		  if(trim($input3[$i]) != '') {
			  array_push($output, trim($input3[$i])); 
			}
		}	
	  return $output;
	}
	
	function Ifinder($input) {
		global $db_object;
	  $db = $this->db;
	  $terms = array();
		$a = array();
		$b = array();
		$allterms = array();
		$output = array();
		
	  $terms = explode(" ",trim($input));

		for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		$begin = 0;
		$end = sizeof($allterms);
		$use_later = array();		
		
		while ($begin <= $end) {
		  $a = array();
			for ($i=$begin; $i<sizeof($allterms); $i++) {
		    if( $allterms[$i] != "" ) {
			    array_push($a, $allterms[$i]);
			  }
			}
			$stopsign = 0;
			//print $begin;
			while (($stopsign == 0) && ($begin <= $end) ) {
		    $test = trim(implode(" ", $a));
				$query = "SELECT US_DESCRIPTOR FROM ita_mesh WHERE ITA_DESCRIPTOR = '".$test."'";
	  		$result = mysqli_query($db_object, $query) or die("Query failed : ");
				if (mysqli_affected_rows($db_object) == 0) {
				    $stopsign = 0;
						//array_pop($a);
						$later_element = array_pop($a);
						if (sizeof($a) == 0) {
						  $stopsign = 1;
							$begin = $begin + 1;
							array_push($use_later, trim($later_element));							
						}
				}
				else {
			    $stopsign = 1;
					$begin = $begin + sizeof($a);
					$line= mysqli_fetch_array($result);
					$term = $line["US_DESCRIPTOR"];
					/*
					if ($term =="") {
				    $term = $line["US_DESCRIPTOR"];
					}
					*/
					//print $term."\n";
					array_push($output, $term);
				}
				if ( ($begin == $end) && ($test =='' ) ) {
					 $begin ++;
				} 
			}// end inside while
		}
		/*
		$no_plural_res = '';
		for ($j=0; $j<sizeof($use_later); $j++) {
		  $no_plural_res = $this->no_plural_P($use_later[$j]);
			if ($no_plural_res !='') {
			  array_push($output, $no_plural_res);
			}
		}	
		*/	
	  return $output;
	}
	
  function topF($input) {
	  global $db_object;
	  $terms = explode(" ", $input);
	  $allterms = array();
	  for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}	
		for ($i=0; $i<sizeof($allterms); $i++) {
		  $allterms[$i] = "(Fre_DESCRIPTOR like '%".$allterms[$i]."%')+(ACCENTUATED_Fre_DESCRIPTOR like '%".$allterms[$i]."%')";
		}
		$query=implode("+",$allterms);
		$query = "select US_DESCRIPTOR, FRE_DESCRIPTOR, $query as a from fre_tran where ($query>0) group by US_DESCRIPTOR order by a desc limit 10";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		return $result;
  }
	
  function topS($input, $mod) {
	  global $db_object;
	  $terms = explode(" ", $input);
	  $allterms = array();
	  for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		for ($i=0; $i<sizeof($allterms); $i++) {
		  $allterms[$i] = "(SPA_DESCRIPTOR like '%".$allterms[$i]."%')";
		}
		$query=implode("+",$allterms);
				
		if ($mod == 1) {
		  $query = "select US_DESCRIPTOR, SPA_DESCRIPTOR, $query as a from spa_tran where ($query>0) group by US_DESCRIPTOR order by a desc limit 5";
		}
		/*
		else {
			$query = "select US_DESCRIPTOR, SPA_DESCRIPTOR, $query as a from spa_mesh where ($query>0) group by US_DESCRIPTOR order by a desc limit 5";
		}
		*/
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		return $result;
  }

	function topP($input) {
		global $db_object;
	  $terms = explode(" ", $input);
	  $allterms = array();
	  for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		for ($i=0; $i<sizeof($allterms); $i++) {
		  $allterms[$i] = "(POR_DESCRIPTOR like '%".$allterms[$i]."%')";
		}
		$query=implode("+",$allterms);
				
		$query = "select US_DESCRIPTOR, POR_DESCRIPTOR, $query as a from por_mesh where ($query>0) group by US_DESCRIPTOR order by a desc limit 5";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		return $result;
  }
	
	function topI($input) {
		global $db_object;
	  $terms = explode(" ", $input);
	  $allterms = array();
	  for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		for ($i=0; $i<sizeof($allterms); $i++) {
		  $allterms[$i] = "(ITA_DESCRIPTOR like '%".$allterms[$i]."%')";
		}
		$query=implode("+",$allterms);
				
		$query = "select US_DESCRIPTOR, ITA_DESCRIPTOR, $query as a from ita_mesh where ($query>0) group by US_DESCRIPTOR order by a desc limit 5";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		return $result;
  }
	
	function F_no_order($input) {
		global $db_object;
		$delete = array(" le ", " la ", " les ", " de ", " du ", " des ", " l'", " d'");
    $column ="fre_descriptor";
		
		$q_term = trim(str_replace($delete, " ", " ".trim($input)));
		$q_terms = explode(" ",$q_term);
		
		$query_h = "SELECT * FROM fre_tran WHERE ";
		$query_b = '';
    for ($i=0; $i<sizeof($q_terms); $i++) {
		  if (trim($q_terms[$i]) != '') {
		    $query_b .= "CONCAT(' ', ".$column.", ' ') like '% ".$q_terms[$i]." %'";
			  if ($i != sizeof($q_terms)-1) {
			    $query_b .= " AND ";
			  }
			}
		}
		$query_b = $query_h."(".$query_b.") GROUP BY FRE_DESCRIPTOR";

		$result_b = mysqli_query($db_object, $query_b) or die("Query failed : ");

		if (mysqli_affected_rows($db_object) != 0) {
		/*
			 $line= mysqli_fetch_array($result_b);
			 $term = $line["US_DESCRIPTOR"];
			 array_push($output, $term);
			 return $output;
		*/
		 return $result_b;
		}
		else {
		 $result_b = '';
		 return $result_b;
		}
  }
	
	function S_no_order($input) {
		global $db_object;
		$delete = array(" la ", " los ", " de ", " del ", " el ", " un ", " las ", " una ", " l'", " d'");
    $column ="spa_descriptor";
		
		$q_term = trim(str_replace($delete, " ", " ".trim($input)));
		$q_terms = explode(" ",$q_term);
		
		$query_h = "SELECT * FROM spa_tran WHERE ";
		$query_b = '';
    for ($i=0; $i<sizeof($q_terms); $i++) {
		  if (trim($q_terms[$i]) != '') {
		    $query_b .= "CONCAT(' ', ".$column.", ' ') like '% ".$q_terms[$i]." %'";
			  if ($i != sizeof($q_terms)-1) {
			    $query_b .= " AND ";
			  }
			}
		}
		$query_b = $query_h."(".$query_b.") GROUP BY US_DESCRIPTOR ORDER BY CUI";

		$result_b = mysqli_query($db_object, $query_b) or die("Query failed : ");

		if (mysqli_affected_rows($db_object) != 0) {
		/*
			 $line= mysqli_fetch_array($result_b);
			 $term = $line["US_DESCRIPTOR"];
			 array_push($output, $term);
			 return $output;
		*/
		 return $result_b;
		}
		else {
		 $result_b = '';
		 return $result_b;
		}
  }
	
	function P_no_order($input) {
		global $db_object;
		$query = "SET character_set_connection = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		$query = "SET character_set_client = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		$query = "SET character_set_server = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		$query = "SET character_set_database = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");
		$query = "SET character_set_results = utf8";
		$result = mysqli_query($db_object, $query) or die("Query failed : ");	
	
	  $column = "por_descriptor";
		$db = "por_mesh";
		$q_term = trim($input);
		$q_terms = explode(" ",$q_term);
		
		$query_h = "SELECT * FROM ".$db." WHERE ";
		$query_b = '';
    for ($i=0; $i<sizeof($q_terms); $i++) {
		  if (trim($q_terms[$i]) != '') {
		    $query_b .= "CONCAT(' ', ".$column.", ' ') like '% ".$q_terms[$i]." %'";
			  if ($i != sizeof($q_terms)-1) {
			    $query_b .= " AND ";
			  }
			}
		}
		$query_b = $query_h."(".$query_b.") GROUP BY US_DESCRIPTOR";

		$result_b = mysqli_query($db_object, $query_b) or die("Query failed : ");

		if (mysqli_affected_rows($db_object) != 0) {
		 return $result_b;
		}
		else {
		 $result_b = '';
		 return $result_b;
		}
  }
	
  function I_no_order($input) {
	  global $db_object;
		$delete = array(" la "); //???
    $column ="ita_descriptor";
		
		$q_term = trim(str_replace($delete, " ", " ".trim($input)));
		$q_terms = explode(" ",$q_term);
		
		$query_h = "SELECT * FROM ita_mesh WHERE ";
		$query_b = '';
    for ($i=0; $i<sizeof($q_terms); $i++) {
		  if (trim($q_terms[$i]) != '') {
		    $query_b .= "CONCAT(' ', ".$column.", ' ') like '% ".$q_terms[$i]." %'";
			  if ($i != sizeof($q_terms)-1) {
			    $query_b .= " AND ";
			  }
			}
		}
		$query_b = $query_h."(".$query_b.") GROUP BY US_DESCRIPTOR";

		$result_b = mysqli_query($db_object, $query_b) or die("Query failed : " );

		if (mysqli_affected_rows($db_object) != 0) {

		 return $result_b;
		}
		else {
		 $result_b = '';
		 return $result_b;
		}
  }
	
	function F_delete($input) {
		global $db_object;

	  $delA = array(utf8_encode("√Ä"), utf8_encode("√Å"), utf8_encode("√Ñ"));
		$dela = array(utf8_encode("√†"), utf8_encode("√¢"), utf8_encode("√§"));
		$delE = array(utf8_encode("√à"), utf8_encode("√â"), utf8_encode("√ä"), utf8_encode("√ã"));
		$dele = array(utf8_encode("√®"), utf8_encode("√©"), utf8_encode("√™"), utf8_encode("√´"));
		$delI = array(utf8_encode("√é"), utf8_encode("√è"));
		$deli = array(utf8_encode("√Æ"), utf8_encode("√Ø"));
		$delO = array(utf8_encode("√î"));
		$delo = array(utf8_encode("√¥"));
		$delU = array(utf8_encode("√ô"), utf8_encode("√õ"), utf8_encode("√ú"));
		$delu = array(utf8_encode("√π"), utf8_encode("√ª"), utf8_encode("√º"));
		$delY = array(utf8_encode("≈∏"));
		$dely = array(utf8_encode("√ø"));
		$delC = array(utf8_encode("√á"));
		$delc = array(utf8_encode("√ß"));

/*
	  $delA = array("¿", "¡", "ƒ");
		$dela = array("‡", "‚", "‰");
		$delE = array("»", "…", " ", "À");
		$dele = array("Ë", "È", "Í", "Î");
		$delI = array("Œ", "œ");
		$deli = array("Ó", "Ô");
		$delO = array("‘");
		$delo = array("Ù");
		$delU = array("Ÿ", "€", "‹");
		$delu = array("˘", "˚", "¸");
		$delY = array("ü");
		$dely = array("ˇ");
		$delC = array("«");
		$delc = array("Á");
	*/			
		$input = str_replace($delA, "A", $input);
		$input = str_replace($dela, "a", $input);
		$input = str_replace($delE, "E", $input);
		$input = str_replace($dele, "e", $input);
		$input = str_replace($delI, "I", $input);
		$input = str_replace($deli, "i", $input);
		$input = str_replace($delO, "O", $input);
		$input = str_replace($delo, "o", $input);
		$input = str_replace($delU, "U", $input);
		$input = str_replace($delu, "u", $input);
		$input = str_replace($delY, "Y", $input);
		$input = str_replace($dely, "y", $input);
		$input = str_replace($delC, "C", $input);
		$input = str_replace($delc, "c", $input);
		
		$output = $input;
		
		return $output;
	}
	
	function S_delete($input) {
		global $db_object;
	  $delA = utf8_encode("√Å");
		$dela = utf8_encode("√°");
		$delE = utf8_encode("√â");
		$dele = utf8_encode("√©");
		$delI = utf8_encode("√ç");
		$deli = utf8_encode("√≠");
		$delO = utf8_encode("√ì");	
		$delo = utf8_encode("√≥");
		$delU = array(utf8_encode("√ö"), utf8_encode("√ú"));
		$delu = array(utf8_encode("√∫"), utf8_encode("√º"));
		$delN = utf8_encode("√ë");
		$deln = utf8_encode("√±");
		
/*
		$delA = "¡";
		$dela = "·";
		$delE = "…";
		$dele = "È";
		$delI = "Õ";
		$deli = "Ì";
		$delO = "”";
		$delo = "Û";
		$delU = array("⁄", "‹");
		$delu = array("˙", "¸");
		$delN = "—";
		$deln = "Ò";
	*/	
	
		$input = str_replace($delA, "A", $input);
		$input = str_replace($dela, "a", $input);
		$input = str_replace($delE, "E", $input);
		$input = str_replace($dele, "e", $input);
		$input = str_replace($delI, "I", $input);
		$input = str_replace($deli, "i", $input);
		$input = str_replace($delO, "O", $input);
		$input = str_replace($delo, "o", $input);
		$input = str_replace($delU, "U", $input);
		$input = str_replace($delu, "u", $input);
		$input = str_replace($delN, "N", $input);
		$input = str_replace($deln, "n", $input);
		
		$output = $input;
		
		return $output;
	}
	
	function P_delete($input) {
		global $db_object;
		$delA = array(utf8_encode("√Ä"),utf8_encode("√Å"), utf8_encode("√Ç"), utf8_encode("√É"));
		$dela = array(utf8_encode("√†"),utf8_encode("√°"), utf8_encode("√¢"),utf8_encode("√£"));
		$delE = array(utf8_encode("√â"), utf8_encode("√ä"));
		$dele = array(utf8_encode("√©"), utf8_encode("√™"));
		$delI = utf8_encode("√ç");
		$deli = utf8_encode("√≠");
		$delO = array(utf8_encode("√ì"), utf8_encode("√î"), utf8_encode("√ï"));	
		$delo = array(utf8_encode("√≥"), utf8_encode("√¥"), utf8_encode("√µ"));
		$delU = array(utf8_encode("√ö"), utf8_encode("√ú"));
		$delu = array(utf8_encode("√∫"), utf8_encode("√º"));
		$delC = utf8_encode("√á");
		$delc = utf8_encode("√ß");
		
		$input = str_replace($delA, "A", $input);
		$input = str_replace($dela, "a", $input);
		$input = str_replace($delE, "E", $input);
		$input = str_replace($dele, "e", $input);
		$input = str_replace($delI, "I", $input);
		$input = str_replace($deli, "i", $input);
		$input = str_replace($delO, "O", $input);
		$input = str_replace($delo, "o", $input);
		$input = str_replace($delU, "U", $input);
		$input = str_replace($delu, "u", $input);
		$input = str_replace($delC, "C", $input);
		$input = str_replace($delc, "c", $input);
		
		$output = $input;
		
		return $output;
	}
	
  function Mix_finder($input) {
	  global $db_object;
	  $db = $this->db;
	  $terms = array();
		$a = array();
		$b = array();
		$allterms = array();
		$output = array();
		$input2 = trim(strtolower($input));
		
	  $terms = explode(" ", trim($input));
		//print_r($terms);
		for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		$begin = 0;
		$end = sizeof($allterms);
		
		while ($begin <= $end) {
		  $a = array();
			for ($i=$begin; $i<sizeof($allterms); $i++) {
		    if( $allterms[$i] != "" ) {
			    array_push($a, $allterms[$i]);
			  }
			}
			$stopsign = 0;
			//print $begin;
			while (($stopsign == 0) && ($begin <= $end) ) {
		    $test = trim(implode(" ", $a));
				$query = "SELECT US_DESCRIPTOR FROM mix_mesh WHERE MIX_DESCRIPTOR = '".$test."'";
				//echo $test."<br>";
	  		$result = mysqli_query($db_object, $query) or die("Query failed : ");
				if (mysqli_affected_rows($db_object) == 0) {
				/*
					$query = "SELECT US_DESCRIPTOR FROM mix_mesh WHERE ACCENTUATED_FRENCH_DESCRIPTOR = '".$test."' GROUP BY US_DESCRIPTOR";
	  			$result = mysqli_query($db_object, $query) or die("Query failed : " . mysqli_error());
					if (mysqli_affected_rows($db_object) == 0) {
				*/
				    $stopsign = 0;
						array_pop($a);
						if (sizeof($a) == 0) {
						  $stopsign = 1;
						  $begin = $begin + 1;
						}
					//}
					/*
					else {
				    $stopsign = 1;
						$begin = $begin + sizeof($a);
						$line= mysqli_fetch_array($result);
						$term = $line["US_DESCRIPTOR"];
						if ($term =="") {
					    $term = $line["US_DESCRIPTOR"];
						}
						//print "here1:".$term."\n";
						array_push($output, $term);
						$input2 = str_replace(strtolower($test),"",$input2);
					}
					*/
				}
				else {
			    $stopsign = 1;
					$begin = $begin + sizeof($a);
					$line= mysqli_fetch_array($result);
					$term = $line["US_DESCRIPTOR"];
					/*
					if ($term =="") {
				    $term = $line["US_DESCRIPTOR"];
					}
					*/
					//print $term."\n";
					array_push($output, $term);
					$input2 = str_replace(strtolower($test),"",$input2);
					
				} 
			}// end inside while
		}
		$Coutput = $this->CFinder($input2);
		//echo "<br>COUTPUT:";
		//print_r($Coutput);
		global $B_post, $A_post;
		//print "<br>BP: ".$B_post."<br>AP: ".$A_post."<br>";
		$BP = explode(" ", $B_post);
		$AP = explode(" ", $A_post);

		//die();
		for ($i=0; $i<sizeof($Coutput); $i++) {
			$temp = trim($Coutput[$i]);
		  if($temp != '') {
			  if (strpos (' '.trim($input2).' ', ' '.$temp.' ' ) !== false) {
				  $j = 0;
					$stop = 0;
					while ($j<sizeof($AP) && $stop != 1) {
					  if ($temp == $AP[$j]) {
						  $stop = 1;
							$newC = trim($newC.' '.$BP[$j]);
						}
						$j++;
					}
				}
				else {
			    array_push($output, trim($temp));
				}
			}
		}
		
		$outnewC = $this->CFinder($newC); 
		/*
		$input3 = explode(" ", trim($input2));
		for ($i=0; $i<sizeof($input3); $i++) {
		  if(trim($input3[$i]) != '') {
			  array_push($output, trim($input3[$i])); 
			}
		}
		*/
		
		for ($i=0; $i<sizeof($outnewC); $i++) {
		  if(trim($outnewC[$i]) != '') {
			  array_push($output, trim($outnewC[$i])); 
			}
		}
	  return $output;
	}
	
	function clean_fre($fre_mes) {
		global $db_object;
	  //$stop_fre = array();
		$fre_mes = $this->simple_fre($fre_mes);
		$stop_fre = " un une environ encore tous tout presque aussi bien que toujour parmi des autres quels etes es sommes sont comme tant a chez etre soient sois soit soyez"; //sujet 
		$stop_fre .= " parce que ete avant etant entre tous les deux mais par peut peuvent pouvons puissent pumes purent put firmes firent fis fit faire fais faisons font fait faites faits";
		$stop_fre .= " du due durant pendant chacun chacune l'un ou l'autre assez surtout etc pour trouva trouvames trouvai trouve trouvee trouvess rouves trouverent des autre";
		$stop_fre .= " a eu a ai aie aient ait as avez avoir avons ayez ont ayant ci deca ici comment toutefois je if si aux dans en est fait ca ils sa kg km compose fait rendre";
		$stop_fre .= " mai pouvez mg peut ml mm faut les la plupart faut presque ni no non obtenu obtenue obtenues obtinmes obtinent de souvent sur notre nos peut-etre tout a fait plutot";
		$stop_fre .= " reellement considerer paraitre parais paraissent paraissez paraissons sembler vu vue vues vus plusiers doit doivent denotent denoter denotez denotons montrent montrer montrez montrons";
		$stop_fre .= " denota denotames denotai denote denotee denotees denotes denotent montra montrames montrai montrerent figure montre montree montrees montres";
		$stop_fre .= " denote montre depuis puique ainsi tellement quelque quelques tel telle cela cet cette que la le les leur leurs eux alors ensuite lors dela la y";
		$stop_fre .= " donc celles-ci ces ceux-ci celles elles ils ca ce ceci cela celle-ci celui-ci cet cette ceux a travers ainsi a pour sur emploi role usage utilisation utilise utilises utilisation"; 
		$stop_fre .= " different differentes differents divers tres etait etais fus fut nous etaient etiez etions futes furent quoi quand lorsque laquel laquelle lequel lequelles lequels quel quelle quelles quels"; 
		$stop_fre .= " qui pendant avec chez dans sans ou plus et que jamas apres cause causent causer causez causons";
		$stop_fre .= " ";
		$fre_terms = array();
		$fre_terms = explode(" ", strtolower($fre_mes));
		$size_mes = sizeof($fre_terms);
		
		for ($i=0; $i<$size_mes; $i++) {
		  if ( !(strpos($stop_fre, " ".trim($fre_terms[$i])." ") === false)) {
			  $fre_terms[$i] = '';
			}
		}
		
		$result = implode(" ", $fre_terms);
		return $result;
	}
	
	function clean_por($por_mes) {
		global $db_object;
	  $stop_por = " a sobre outra vez' tudo quase tambem embora sempre entre outros alguns seja como em seja porque sido antes sendo";
	  $stop_por .= " entre ambos mas por poderia feito fazer feito durante todo qualquer um' basantes especial etc para encontrado de";
	  $stop_por .= " mais adicional' teve tem tenha tendo aqui come entretanto I se em eme ele seu propio apena kg km feito principalmente";
	  $stop_por .= " faca possa mg ml mm a majoria' na maior parte' obrigacao nenhuns quase nao nem obtido de frequentemente em nosso total";
	  $stop_por .= " talvez completamente realmente considerar pareca visto diversos se mostre mostrado mostrado mostras significativamente";
	  $stop_por .= " desde assim alguns tais isso o seu dele eles entao la consequentemente estes eles isto assim a atraves assim a uso usado";
	  $stop_por .= " usar-se vario muito era nos eram que quando qual quando com dentro sem ou mais e do que' sempre em sequida' cause";
	  $stop_por .= " ";
		
		$stop_por2 = " cada um ";
		$por_mes = trim(str_replace($stop_por2, " ", " ".trim($por_mes)." "));
		$por_terms = array();
		$por_terms = explode(" ", strtolower($por_mes));
		$size_mes = sizeof($por_terms);	
		
		for ($i=0; $i<$size_mes; $i++) {
		  if ( !(strpos($stop_por, " ".trim($por_terms[$i])." ") === false)) {
			  $por_terms[$i] = '';
			}
		}
				
		$result = implode(" ", $por_terms);
		return $result;
	}
	
	function clean_spa($spa_mes) {
		global $db_object;
	  $stop_spa = " a la un una acerca sobre otravez todo todos casi tambien aunque siempre entre un otro otros";
	  $stop_spa .= " cualquier cualquiera eres son como a arroba estar ser porque ha sido antes delante siendo entre ambos ambas pero sino";
	  $stop_spa .= " cerca pudo podia podria hacer hacen hecho terminado durante todos o cualquiera bastante bastantes basta bastar sobre todo";
	  $stop_spa .= " for para encontrar hallar localizar hallazgo de desde siguiente habia tiene hay tener tenga tiniendo aqui como sin embargo";
	  $stop_spa .= " yo si es lo el ella su se solo apena noma kg km hecho principalmente hacer haga podor pueda mg ml mm principalmente";
	  $stop_spa .= " deber casi ninguno tampoco no ni obtener de sobre nuestro nuestra sobretodo quiza quizas acaso realmente sino algo";
	  $stop_spa .= " verdaderamente con respecto a' parecer parecen parezcase varios deber mostrat revelar demonstracion ostentar significativamente";
	  $stop_spa .= " desde asi tan algunos alguna algunas tal ese que aquello aquella el la los su su ellos ellas entonces pues ahi alli alla";
	  $stop_spa .= " por eso' estos ellos ellas este esto esta aquellos aquellas esos por mediante asi a hasta sobre usar uso utilizar";
	  $stop_spa .= " usado varios vario mismo muy fue fui nosotros estaban eran que cunado cual que que cuales cual mientras with dentro";
	  //$stop_spa .= " sin o mas y que siempre despues detras tras causa";
		$stop_spa .= " sin o mas y que siempre detras tras causa";
	  $stop_spa .= " ";

		$stop_spa2 = array();		
		$stop_spa2 = array(	" al lado ", " cada uno ", " mas alia ", " mas futuro ", " de cosa ", 
							 	 " lo mas ", " muchas veces ", " a menudo ", " tal vez ", " mas bien ", 
								 " de nuevo ", " una vez mas ", " el cual ", " dentro de ", " alguna vez ");
		$spa_mes = trim(str_replace($stop_spa2, " ", " ".trim($spa_mes)." "));
		$spa_terms = array();
		$spa_terms = explode(" ", strtolower($spa_mes));
		$size_mes = sizeof($spa_terms);
		
		for ($i=0; $i<$size_mes; $i++) {
		  if ( !(strpos($stop_spa, " ".trim($spa_terms[$i])." ") === false)) {
			  $spa_terms[$i] = '';
			}
		}

		$result = implode(" ", $spa_terms);
		return $result;		
  }
	
	function simple_fre($input) {
		
		$delete = array(" le ", " la ", " les ", " de ", " du ", " des ", " l'", " d'", " au ");
		$q_term = trim(str_replace($delete, " ", " ".trim($input))); 
		return $q_term;
	}
	
	function simple_spa($input) {
		
		$delete = array(" la ", " los ", " de ", " del ", " el ", " un ", " las ", " una ", " l'", " d'");
		$q_term = trim(str_replace($delete, " ", " ".trim($input))); 
		return $q_term;
	}
	
/***************************************************************/
	/* Here are uniform function for all the languages */
	
/**************************************************************/	

	function lang_finder($input, $lang, $lang_table, $lang_column, $eng_column) {
		global $db_object;
	  $db = $this->db;
	  $terms = array();
		$a = array();
		$b = array();
		$allterms = array();
		$output = array();
		
	  $terms = explode(" ",trim($input));

		for ($i=0; $i<sizeof($terms); $i++) {
		  if( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		$begin = 0;
		$end = sizeof($allterms);
		$use_later = array();		
		
		while ($begin <= $end) {
		  $a = array();
			for ($i=$begin; $i<sizeof($allterms); $i++) {
		    if( $allterms[$i] != "" ) {
			    array_push($a, $allterms[$i]);
			  }
			}
			$stopsign = 0;
			
			while (($stopsign == 0) && ($begin <= $end) ) {
		    $test = trim(implode(" ", $a));
				
				$query = "SELECT ".$eng_column." FROM ".$lang_table." WHERE ".$lang_column." = '".$test."'";
				if ($lang == 'chn') {
				  $query = $query." ORDER BY CUI DESC";
				}
	  		$result = mysqli_query($db_object, $query) or die("Query failed : ");
				if (mysqli_affected_rows($db_object) == 0) {
				    $stopsign = 0;
						//array_pop($a);
						$later_element = array_pop($a);
						if (sizeof($a) == 0) {
						  $stopsign = 1;
							$begin = $begin + 1;
							array_push($use_later, trim($later_element));							
						}
				}
				else {
			    	$stopsign = 1;
						$begin = $begin + sizeof($a);
						$line= mysqli_fetch_array($result);
						$term = $line[$eng_column]; 
						/*
						if ($term =="") {
				      $term = $line[$eng_column];
						}
						*/
					  if ($test != '') {
						  array_push($output, $term);//echo "<br>here!$query<br>";
						}
				}
				
				if ( ($begin == $end) && ($test =='' ) ) {
					 $begin ++;
				}
			}// end inside while
			
		}
		
	  return $output;
	}
	
	function lang_no_order($input, $lang, $lang_table, $lang_column, $eng_column) {
	  global $db_object;
	  $column = $lang_column;
		$db = $lang_table;
		$q_term = trim($input);
		$q_terms = explode(" ",$q_term);
		
		$query_h = "SELECT * FROM ".$db." WHERE ";
		$query_b = '';
    for ($i=0; $i<sizeof($q_terms); $i++) {
		  if (trim($q_terms[$i]) != '') {
		    $query_b .= "CONCAT(' ', ".$column.", ' ') like '% ".$q_terms[$i]." %'";
			  if ($i != sizeof($q_terms)-1) {
			    $query_b .= " AND ";
			  }
			}
		}
		if (trim($query_b) != '') {
		  $query_b = $query_h."(".$query_b.") GROUP BY ".$eng_column;
		 
		  $result_b = mysqli_query($db_object, $query_b) or die("Query failed : ");
		}
		else {
		  $result_b = '';
		}
		if (mysqli_affected_rows($db_object) != 0) {
		 return $result_b;
		 
		}
		else {
		 $result_b = '';
		 return $result_b;
		}
  }
	
	function topLang($input, $lang, $lang_table, $lang_column, $eng_column) {	  
		global $db_object;
		$de_chars = array("?", ".", ",", ";", ":", "-", "+", "_", "(", ")",  "=");
		$input = str_replace($de_chars, " ", $input);
		$terms = explode(" ", $input);
		
	  $allterms = array();
	  for ($i=0; $i<sizeof($terms); $i++) {
		  if( ( trim($terms[$i]) != "" ) && (in_array(trim($terms[$i]), $de_chars) != true) ){
			//if ( trim($terms[$i]) != "" ) {
			  array_push($allterms, $terms[$i]);
			}
		}
		//if (strtolower($lang) != 'ara') {
		  for ($i=0; $i<sizeof($allterms); $i++) {
		    $allterms[$i] = "($lang_column like '%".$allterms[$i]."%')";
			  
		  }
		/*
		}
		else {
		  for ($i=0; $i<sizeof($allterms); $i++) {
			  $allterms[$i] = "(CONCAT(' ', ".$lang_column.", ' ') like '% ".$allterms[$i]." %')";
			}
		}
		*/
		$query=implode("+",$allterms);
		if (trim($query) !='') {		
		  $query = "select $eng_column, $lang_column, $query as a from $lang_table where ($query>0) group by $eng_column order by a desc limit 5";
				
		//echo $query."<br>";
		  $result = mysqli_query($db_object, $query) or die("Query failed 4: ");
		}
		else {
		  $result = '';
		}
		return $result;
  }
	
	function lang_delete($input) {
		global $db_object;
/*
	  $delA = array("¿", "¡", "ƒ", "¬", "√");
		$dela = array("‡", "‚", "‰", "·", "„");
		$delE = array("»", "…", " ", "À");
		$dele = array("Ë", "È", "Í", "Î");
		$delI = array("Œ", "œ", "Õ", "Ã");
		$deli = array("Ó", "Ô", "Ì", "Ï");
		$delO = array("‘", "”", "‘", "’", "“", "÷");
		$delo = array("Ù", "Û", "ı", "Ú", "ˆ");
		$delU = array("Ÿ", "€", "‹", "⁄");
		$delu = array("˘", "˚", "¸", "˙");
		$delY = array("ü");
		$dely = array("ˇ");
		$delC = array("«");
		$delc = array("Á");
		$delN = "—";
		$deln = "Ò";
*/		
		$delA = array(utf8_encode("√Ä"), utf8_encode("√Å"), utf8_encode("√Ñ"), utf8_encode("√Ç"), utf8_encode("√É"), utf8_encode("√Ö"));
		$dela = array(utf8_encode("√†"), utf8_encode("√¢"), utf8_encode("√§"), utf8_encode("√°"), utf8_encode("√£"), utf8_encode("√•"));
		$delE = array(utf8_encode("√à"), utf8_encode("√â"), utf8_encode("√ä"), utf8_encode("√ã"));
		$dele = array(utf8_encode("√®"), utf8_encode("√©"), utf8_encode("√™"), utf8_encode("√´"));
		$delI = array(utf8_encode("√é"), utf8_encode("√è"), utf8_encode("√ç"), utf8_encode("√å"));
		$deli = array(utf8_encode("√Æ"), utf8_encode("√Ø"), utf8_encode("√≠"), utf8_encode("√¨"));
		$delO = array(utf8_encode("√î"), utf8_encode("√ì"), utf8_encode("√î"), utf8_encode("√ï"), utf8_encode("√í"), utf8_encode("√ñ"));
		$delo = array(utf8_encode("√¥"), utf8_encode("√≥"), utf8_encode("√µ"), utf8_encode("√≤"), utf8_encode("√∂"));
		$delU = array(utf8_encode("√ô"), utf8_encode("√õ"), utf8_encode("√ú"), utf8_encode("√ö"));
		$delu = array(utf8_encode("√π"), utf8_encode("√ª"), utf8_encode("√º"), utf8_encode("√∫"));
		$delY = array(utf8_encode("≈∏"));
		$dely = array(utf8_encode("√ø"));
		$delC = array(utf8_encode("√á"));
		$delc = array(utf8_encode("√ß"));
		$delN = utf8_encode("√ë");
		$deln = utf8_encode("√±");
		
		$input = str_replace($delA, "A", $input);
		$input = str_replace($dela, "a", $input);
		$input = str_replace($delE, "E", $input);
		$input = str_replace($dele, "e", $input);
		$input = str_replace($delI, "I", $input);
		$input = str_replace($deli, "i", $input);
		$input = str_replace($delO, "O", $input);
		$input = str_replace($delo, "o", $input);
		$input = str_replace($delU, "U", $input);
		$input = str_replace($delu, "u", $input);
		$input = str_replace($delY, "Y", $input);
		$input = str_replace($dely, "y", $input);
		$input = str_replace($delC, "C", $input);
		$input = str_replace($delc, "c", $input);
		$input = str_replace($delN, "N", $input);
		$input = str_replace($deln, "n", $input);
			
		$output = $input;

		return $output;
	}
	
	/*	
	function cyri_delete($input) {

		$del1 = array(utf8_encode("–∞"));
		$del2 = array(utf8_encode("–±"));
		$del3 = array(utf8_encode("–≤"));
		$del4 = array(utf8_encode("–≥"));
		$del5 = array(utf8_encode("–¥"));
		$del6 = array(utf8_encode("–µ"));
		$del7 = array(utf8_encode("–∂"));
		$del8 = array(utf8_encode("–∑"));
		$del9 = array(utf8_encode("–∏"));
		$del10 = array(utf8_encode("–π"));
		$del11 = array(utf8_encode("–∫"));
		$del12 = array(utf8_encode("–ª"));
		$del13 = array(utf8_encode("–º"));
		$del14 = array(utf8_encode("–Ω"));
		$del15 = array(utf8_encode("–æ"));
		$del16 = array(utf8_encode("–ø"));
		$del17 = array(utf8_encode("—Ä"));
		$del18 = array(utf8_encode("—Å"));
		$del19 = array(utf8_encode("—Ç"));
		$del20 = array(utf8_encode("—É"));
		$del21 = array(utf8_encode("—Ñ"));
		$del22 = array(utf8_encode("—Ö"));
		$del23 = array(utf8_encode("—Ü"));
		$del24 = array(utf8_encode("—á"));
		$del25 = array(utf8_encode("—à"));
		$del26 = array(utf8_encode("—â"));
		$del27 = array(utf8_encode("—ä"));
		$del28 = array(utf8_encode("—ã"));
		$del29 = array(utf8_encode("—å"));
		$del30 = array(utf8_encode("—ç"));
		$del31 = array(utf8_encode("—é"));
		$del32 = array(utf8_encode("—è"));
				
		$input = str_replace($del1, "–ê", $input);
		$input = str_replace($del2, "–ë", $input);
		$input = str_replace($del3, "–í", $input);
		$input = str_replace($del4, "–ì", $input);
		$input = str_replace($del5, "–î", $input);
		$input = str_replace($del6, "–ï", $input);
		$input = str_replace($del7, "–ñ", $input);
		$input = str_replace($del8, "–ó", $input);
		$input = str_replace($del9, "–ò", $input);
		$input = str_replace($del10, "–ô", $input);
		$input = str_replace($del11, "–ö", $input);
		$input = str_replace($del12, "–õ", $input);
		$input = str_replace($del13, "–ú", $input);
		$input = str_replace($del14, "–ù", $input);
		$input = str_replace($del15, "–û", $input);
		$input = str_replace($del16, "–ü", $input);
		$input = str_replace($del17, "–†", $input);
		$input = str_replace($del18, "–°", $input);
		$input = str_replace($del19, "–¢", $input);
		$input = str_replace($del20, "–£", $input);
		$input = str_replace($del21, "–§", $input);
		$input = str_replace($del22, "–•", $input);
		$input = str_replace($del23, "–¶", $input);
		$input = str_replace($del24, "–ß", $input);
		$input = str_replace($del25, "–®", $input);
		$input = str_replace($del26, "–©", $input);
		$input = str_replace($del27, "–™", $input);
		$input = str_replace($del28, "–´", $input);
		$input = str_replace($del29, "–¨", $input);
		$input = str_replace($del30, "–≠", $input);
		$input = str_replace($del31, "–Æ", $input);
		$input = str_replace($del32, "–Ø", $input);
					
		$output = $input;

		return $output;
	}

	function unibin2hex($u) {
       $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
       $k1 = bin2hex(substr($k, 0, 1));
       $k2 = bin2hex(substr($k, 1, 1));
       return $k2.$k1;
  }

	function cyri_upper($input) {
	  $whole_str = '';
	  $char_num = strlen($input)/2;
  	for ($i=0; $i<$char_num; $i++) {
			$machine_hex = $this->unibin2hex($input{$i*2}.$input{$i*2+1});
			$machine_dec =  hexdec($machine_hex);
			if ( ($machine_dec >= 1072) && ($machine_dec <= 1103)) {
			  $upper = dechex ($machine_dec-32);
			}
			else {
			  $upper = $machine_hex;
			}
			
			$upper = "&#x".$upper;
			$whole_str .=$upper;
		}
		return $whole_str;
 	}
*/

} // end class

// other functions not in class

  function pass_lang_out(){
		echo "<input type = \"hidden\" name = \"ARA_o\" value=\"".$_POST["ARA_o"]."\">";
		echo "<input type = \"hidden\" name = \"CHN_o\" value=\"".$_POST["CHN_o"]."\">";
		echo "<input type = \"hidden\" name = \"DUT_o\" value=\"".$_POST["DUT_o"]."\">";
		echo "<input type = \"hidden\" name = \"FIN_o\" value=\"".$_POST["FIN_o"]."\">";
	  echo "<input type = \"hidden\" name = \"FRE_o\" value=\"".$_POST["FRE_o"]."\">";
		echo "<input type = \"hidden\" name = \"GER_o\" value=\"".$_POST["GER_o"]."\">";
		echo "<input type = \"hidden\" name = \"JPN_o\" value=\"".$_POST["JPN_o"]."\">";
		echo "<input type = \"hidden\" name = \"KOR_o\" value=\"".$_POST["KOR_o"]."\">";
		echo "<input type = \"hidden\" name = \"ITA_o\" value=\"".$_POST["ITA_o"]."\">";
		echo "<input type = \"hidden\" name = \"NDC_o\" value=\"".$_POST["NDC_o"]."\">";
		echo "<input type = \"hidden\" name = \"RUS_o\" value=\"".$_POST["RUS_o"]."\">";
		echo "<input type = \"hidden\" name = \"SPA_o\" value=\"".$_POST["SPA_o"]."\">";
		echo "<input type = \"hidden\" name = \"SWE_o\" value=\"".$_POST["SWE_o"]."\">";
		echo "<input type = \"hidden\" name = \"POR_o\" value=\"".$_POST["POR_o"]."\">";
		echo "<input type = \"hidden\" name = \"ENG_o\" value=\"".$_POST["ENG_o"]."\">";
		echo "<input type = \"hidden\" name = \"ALL_o\" value=\"".$_POST["ALL_o"]."\">";
	}	
	
	function fre_process($term) {
	  $term = trim(str_replace(" NOS ", " ", " ".$term." "));
		if ( (!(strpos( $term, " OR " ) === false)) ){
		  //$pos = strpos( $term, " OR " );
			//$term = substr($term, 0, $pos);
			//$term = str_replace("(", "", $term);
			//$term = str_replace(")", "", $term);
			$temp_term = $term;
			
			while ( !(strpos( $temp_term, "(" ) === false) ) {
			  $pos1 = strpos( $term, "(" );
				$pos2 = strpos( $term, ")" );
				if ($pos2 === false) {
				   $pos2 = strlen($term);
				}
				if ($pos2 > $pos1 ) { 
				  $middle = substr($term, $pos1, $pos2-$pos1+1);
					if (!(strpos( $middle, " OR " ) === false ) ){
				    $pos3 = strpos( $middle, " OR " );
						$short_term = substr($middle, 1, $pos3-1);
						$term = str_replace($middle, $short_term, $term); 
					}
				}
				$pos1 = strpos( $temp_term, "(" );
				$temp_term = substr($temp_term, $pos1+1); 
			}
			$term = str_replace("(", "", $term);
			$term = str_replace(")", "", $term);
		}
		return $term;
	}
?>