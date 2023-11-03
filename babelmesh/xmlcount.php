<?php 

class XMLcount {

  var $urlcount;
	var $webenv;
	var $querykey;
	var $count;
	var $tag;
	var $inresult;
	var $set_count;
	
function XMLcount() {
  $this->urlcount = NULL;
	$this->webenv = NULL;
	$this->querykey = NULL;
	$this->count = NULL;
	$this->tag = NULL;
	$this->inresult = NULL;
	$this->set_count = false;
}

// Parsing functions

function startElement ($parser, $tagName, $attrs) {
	switch ($tagName) {
	  case "ESEARCHRESULT":
		  $this->inresult = true;
		  break;
	}
	if ($this->inresult) {
		$this->tag = $tagName;
	}
}

function endElement ($parser, $tagName) {
	switch ($tagName) {
	  case "ESEARCHRESULT":
		  $this->inresult = false;
			$this->set_count = false;
			break;
	}
		
}// end endelement

function getData ($parser, $data) {
	if ($this->inresult) {
	  switch ($this->tag) {
		  case "COUNT":
			  if (!($this->set_count)) {
			    $this->count .= $data;
					$this->set_count = true;
				}
				break;
			case "WEBENV":
			  $this->webenv .= $data;
				break;
			case "QUERYKEY":
			  $this->querykey .= $data;
				break;
		}
	}
}

// Create an XML parser
function getCount($url) {

  $xml_parser = xml_parser_create();

 	xml_set_object($xml_parser,$this);
// Set the functions to handle opening and closing tags
	xml_set_element_handler($xml_parser, "startElement", "endElement");

// Set the function to handle blocks of character data
	xml_set_character_data_handler($xml_parser, "getData");

	$urlcount = $url;

// Open the XML file for reading
	$fp = fopen($urlcount, "r")
       or die("Error reading PubMed XML data.");
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

	$this->count = trim($this->count);
	$this->webenv = trim($this->webenv);
	$this->querykey = trim($this->querykey);
				
// Free up memory used by the XML parser
	xml_parser_free($xml_parser);
}

} //end class

?>
