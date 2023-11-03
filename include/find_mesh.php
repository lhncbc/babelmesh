<?php

$ncbi_key = "1a41ff51fec9ccebd1ad3d6a9d7a9edf370a";

/* to find if is a MeSH*/
function find_mesh($query) {
	
	global $ncbi_key;

	$utils = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils";
	$esearch = "$utils/esearch.fcgi?" .
                "retmax=1&db=pubmed"."&tool=pmhh&api_key=$ncbi_key&email=pubmedhh@nlm.nih.gov&term=".urlencode($query);
								
  $esearch_result = file_get_contents($esearch);

	$string1 = "<From>";
	$string2 = "</From>";
	
	$string7 = "<Translation>";
	$string8 = "</Translation>";

	$array1 = array();

	$len1 = strlen($string1);
	$len2 = strlen($string2);
	
	$len7 = strlen($string7);
	$len8 = strlen($string8);
	
	$pos7 = strpos($esearch_result, $string7);
	$pos8 = strpos($esearch_result, $string8);
	$rest = $esearch_result;
	while (($pos7 !== false) && ($pos8 !== false)){
	  
		$from = substr($rest, $pos7 + $len7, $pos8 - $pos7 - $len7);
		$pos1 = strpos($from, $string1);
		if ($pos1 !== false) {
		  $pos2 = strpos($from, $string2);
			$mesh = substr($from, $pos1+$len1, $pos2-$pos1-$len1);
			array_push($array1, $mesh);
		}
		$rest = substr($rest, $pos8+$len8);
		$pos7 = strpos($rest, $string7);
		$pos8 = strpos($rest, $string8);
	}
	return $array1;
}	
?>
