<?php
function find_mesh($esearch_result) {
  $rest = $esearch_result;
  $sbegin = strpos($rest,'<Translation>');
  $index = 0;
  $result = array();
  while (($sbegin !== false)) {	
    $end = strpos($rest,'</Translation>');
    $len = $end - $sbegin - strlen("<Translation>");
    $tm = substr($rest, $sbegin+strlen("<Translation>"), $len);
		//echo "???".$tm."???<br>";
		$from_pos1 = strpos($tm, "<From>");
		$from_pos2 = strpos($tm, "</From>");
		$t_from = substr($tm, $from_pos1+strlen("<From>"), $from_pos2-$from_pos1 - strlen("<From>"));
		
		$to_pos1 = strpos($tm, "<To>");
		$to_pos2 = strpos($tm, "</To>");
		$t_to = substr($tm, $to_pos1 + strlen("<To>"), $to_pos2 - $to_pos1 - strlen("<To>"));
		//echo "???".$t_from."???<br>";
		if (strpos($t_to, "[MeSH Terms]") !== false) {
		  array_push($result, strtolower($t_from));
			
		}
		
    $rest =substr($rest,$end+strlen("</Translation>"));
		//echo $rest."<br>";
    $sbegin = strpos($rest,"<Translation>");
  }
	return $result;
}

 //Find Substance Name
function find_SN($esearch_result) { 
  $rest = $esearch_result;
  $sbegin = strpos($rest,'<Translation>');
  $index = 0;
  $result = array();
  while (($sbegin !== false)) {	
    $end = strpos($rest,'</Translation>');
    $len = $end - $sbegin - strlen("<Translation>");
    $tm = substr($rest, $sbegin+strlen("<Translation>"), $len);
		//echo "???".$tm."???<br>";
		$from_pos1 = strpos($tm, "<From>");
		$from_pos2 = strpos($tm, "</From>");
		$t_from = substr($tm, $from_pos1+strlen("<From>"), $from_pos2-$from_pos1 - strlen("<From>"));
		
		$to_pos1 = strpos($tm, "<To>");
		$to_pos2 = strpos($tm, "</To>");
		$t_to = substr($tm, $to_pos1 + strlen("<To>"), $to_pos2 - $to_pos1 - strlen("<To>"));
		//echo "???".$t_from."???<br>";
		if (strpos($t_to, "[Substance Name]") !== false) {
		  array_push($result, strtolower($t_from));
			
		}
		
    $rest =substr($rest,$end+strlen("</Translation>"));
		//echo $rest."<br>";
    $sbegin = strpos($rest,"<Translation>");
  }
	return $result;
}
?>
