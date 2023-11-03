<?php
$ncbi_key = "1a41ff51fec9ccebd1ad3d6a9d7a9edf370a";

class espell {

  var $query;
	var $cquery;
	var $squery;
	var $original;
	var $replaced;
	var $orig;
	var $repl;
	
function espell() {
  $this->query = NULL;
	$this->cquery = NULL;
	$this->squery = NULL;
	$this->orig = NULL;
	$this->repl = NULL;
	$this->original = array();
	$this->replaced = array();
}

// Parsing functions

function startElement ($parser, $tagName, $attrs) {
	switch ($tagName) {
	  case "ESPELLRESULT":
		  $this->inresult = true;
		  break;
	}
	if ($this->inresult) {
		$this->tag = $tagName;
	}
}

function endElement ($parser, $tagName) {
  	switch ($tagName) {
	  case "ESPELLRESULT":
		  $this->inresult = false;
			break;
		case "ORIGINAL":
		  array_push($this->original, trim($this->orig));
			$this->orig = '';
			break;
		case "REPLACED":
		  array_push($this->replaced, trim($this->repl));
			$this->repl = '';
			break;
	}
		
}// end endelement

function getData ($parser, $data) {
	if ($this->inresult) {
	  switch ($this->tag) {
		  case "CORRECTEDQUERY":
				$this->cquery .= $data;
				break;
			case "SPELLEDQUERY":
			  $this->squery .= $data;
				break;
			case "REPLACED":
			  $this->repl .= $data;
				break;
			case "ORIGINAL":
			  $this->orig .= $data;
				break;
		}
	}
}

// Create an XML parser
function getSpell($query) {

global $ncbi_key;

	$baseurl= "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/espell.fcgi?db=pubmed&api_key=$ncbi_key&term=";
	
  $xml_parser = xml_parser_create();

 	xml_set_object($xml_parser,$this);
// Set the functions to handle opening and closing tags
	xml_set_element_handler($xml_parser, "startElement", "endElement");

// Set the function to handle blocks of character data
	xml_set_character_data_handler($xml_parser, "getData");

	$urlcount = $baseurl.urlencode($query);

// Open the XML file for reading
	$fp = fopen($urlcount, "r");
 
// Read the XML file 4KB at a time
	while ($data = fread($fp, 4096))
   // Parse each 4KB chunk with the XML parser created above
   		xml_parse($xml_parser, $data, feof($fp))
       // Handle errors in parsing
       or die(sprintf("XML error: %s at line %d",  
  xml_error_string(xml_get_error_code($xml_parser)),  
  xml_get_current_line_number($xml_parser)));

	// Close the XML file
	fclose($fp);

	$this->query = trim($query);
	$this->cquery = trim($this->cquery);
	if (strtolower($this->query) == strtolower($this->cquery) ) {
		$this->cquery = '';
	}
				
// Free up memory used by the XML parser
	xml_parser_free($xml_parser);
}

} //end class XMLcount
?>
