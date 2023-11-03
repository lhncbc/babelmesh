<?php 

class parXML {
var $i;
var $urlfile = "";
var $final = array();
var $num_arti;

function parXML() {
$this->i = 0;
$this->num_arti = 20;
$this->final= array();
$this->urlfile = NULL;

}
function set_num_arti($num) {
  $this->num_arti = $num;
}
// Parsing functions
function startElement ($parser, $tagName, $attrs) {

  $i= $this->i;
	switch ($tagName) {
	  case "PUBMEDARTICLE":
		  $this->final[$i]["inarticle"] = true;
			
			$this->final[$i]["count1"] =0;
			$this->final[$i]["count2"] =0;
			$this->final[$i]["count3"] =0;
			$this->final[$i]["inpubdate"] = false;
			$this->final[$i]["incomment"] = false;
			$this->final[$i]["linkout"] = false;
			$this->final[$i]["tag"] = NULL;
			$this->final[$i]["attrib"] = NULL;
			$this->final[$i]["ctag"] = NULL;
			$this->final[$i]["pmid"] = NULL;
			$this->final[$i]["jtitle"] = NULL;
			$this->final[$i]["volume"] = NULL;
			$this->final[$i]["issue"] = NULL;
			$this->final[$i]["year"] = NULL;
			$this->final[$i]["month"] = NULL;
			$this->final[$i]["pgn"] = NULL;
			$this->final[$i]["atitle"] = NULL;
			$this->final[$i]["abtext"] = NULL;
			$this->final[$i]["author"] = array();
			$this->final[$i]["lname"] = NULL;
			$this->final[$i]["iname"] = NULL;
			$this->final[$i]["cname"] = NULL;
			$this->final[$i]["plist"] = array();
			$this->final[$i]["ptype"] = NULL;
			$this->final[$i]["mesh"] = array();
			$this->final[$i]["descriptor"] = NULL;
			$this->final[$i]["qualifier"] =NULL;
			$this->final[$i]["qarray"] = NULL;
			$this->final[$i]["linkout"] = NULL;
			$this->final[$i]["pinfo"] = NULL;
			$this->final[$i]["pdate"] = NULL;
			$this->final[$i]["pt"] = NULL;
			$this->final[$i]["allmesh"] = NULL;
			$this->final[$i]["issn"] = NULL;
			$this->final[$i]["vertitle"] = NULL;
			
			$this->final[$i]["onelabel"] = NULL;
			$this->final[$i]["onecate"] = NULL; //NlmCategory
			
		  break;
			
		case "PMID":
		  $this->final[$i]["inpmid"] = true;
		  break;
		case "ARTICLETITLE":
		  $this->final[$i]["intitle"] = true;
		  break;			
		case "ABSTRACTTEXT":
		  $this->final[$i]["onelabel"] = '';
			if(array_key_exists('LABEL', $attrs)) {
			  $this->final[$i]["onelabel"] = $attrs['LABEL'];
			}
			
			$this->final[$i]["onecate"] = '';			
			if(array_key_exists('NLMCATEGORY', $attrs)) {
			  $this->final[$i]["onecate"] = $attrs['NLMCATEGORY'];
			}
			
		  $this->final[$i]["inab"] = true;
		  break;
		case "PUBDATE":
		  $this->final[$i]["inpubdate"] = true;
			break;
		case "COMMENTSCORRECTIONS":
		  $this->final[$i]["incomment"] = true;
		  break;
		case "ARTICLEID":
		  if (trim($attrs['IDTYPE']) == "pii" || trim($attrs['IDTYPE']) == "doi") {
			  $this->final[$i]["linkout"] = true;
			}
			break;
		case "VERNACULARTITLE":
		  $this->final[$i]["invertitle"] = true;
		  break;
	}
	if (array_key_exists($i, $this->final) && is_array($this->final[$i]) && array_key_exists('inarticle', $this->final[$i])) {
	  if ($this->final[$i]["incomment"]) {
		  $this->final[$i]["tag"] = "";
			$this->final[$i]["ctag"] = $tagName;
		} else {
		  $this->final[$i]["tag"] = $tagName;
			$this->final[$i]["attrib"] = $attrs;
		}
	}
}

function endElement ($parser, $tagName) {
  $i= $this->i;
	switch ($tagName) {
	  case "PUBDATE":
		  $this->final[$i]["inpubdate"] = false;
			break;
		case "COMMENTSCORRECTIONS":
		  $this->final[$i]["incomment"] = false;
		  break;
		case "MESHHEADING":
		  $this->final[$i]["mesh"][] = trim($this->final[$i]["descriptor"]).trim($this->final[$i]["qarray"]);
			$this->final[$i]["descriptor"] = "";
			$this->final[$i]["qarray"] = "";
		  break;
		case "AUTHOR":
			$this->final[$i]["lname"] = array_key_exists('lname', $this->final[$i])? $this->final[$i]["lname"]:'';
			$this->final[$i]["iname"] = array_key_exists('iname', $this->final[$i])? $this->final[$i]["iname"]:'';
		  $this->final[$i]["author"][] = trim($this->final[$i]["lname"])." ".trim($this->final[$i]["iname"]);
			$this->final[$i]["lname"] = "";
			$this->final[$i]["iname"] = "";
			break;
		case "QUALIFIERNAME":
		  if ($this->final[$i]["attrib"]['MAJORTOPICYN'] == "Y") {
			  $this->final[$i]["qarray"] .= "/*".trim($this->final[$i]["qualifier"]);
			} else {
			  $this->final[$i]["qarray"] .= "/".trim($this->final[$i]["qualifier"]);
			}
			$this->final[$i]["qualifier"] = "";
			break;
		case "PUBLICATIONTYPE":
		  $this->final[$i]["plist"][] = array_key_exists('ptype', $this->final[$i])? trim($this->final[$i]["ptype"]):'';
		  $this->final[$i]["ptype"] = "";
			break;
		case "VERNACULARTITLE":
			$this->final[$i]["invertitle"] = false;
			break;
	}
	if ($tagName == "PUBMEDARTICLE") { //end and print everything
	  switch (count($this->final[$i]["author"])) {
		  case 0:
		    $this->final[$i]["author"] = "";
				break;
			case 1:
			  $this->final[$i]["author"] = reset($this->final[$i]["author"]);
				if (trim($this->final[$i]["author"]) == "") {
				  if (trim($this->final[$i]["cname"]) == "") {
					  $this->final[$i]["author"] = "";
					} else {
					  $this->final[$i]["author"] = trim($this->final[$i]["cname"]);
					}
				}
			  break;
			default:
			  $this->final[$i]["author"] = join("; ", $this->final[$i]["author"]);
			  break;
		}
		// Print Everything
		if ($this->final[$i]["pdate"]) {
			 $this->final[$i]["pdate"] = trim($this->final[$i]["pdate"]);
		}
		else {
			 $this->final[$i]["pdate"] = trim($this->final[$i]["year"])." ".trim($this->final[$i]["month"]);
		}
		$this->final[$i]["pinfo"] = trim($this->final[$i]["volume"])."(".trim($this->final[$i]["issue"])."):".trim($this->final[$i]["pgn"]);
		$this->final[$i]["issn"] = trim($this->final[$i]["issn"]);
		$this->final[$i]["vertitle"] = trim($this->final[$i]["vertitle"]);
		$this->i ++;

	}// end PUBMEDARTICLE
	
}// end endelement

function characterData ($parser, $data) {
  $i= $this->i;
	if (array_key_exists('inarticle', $this->final[$i])) {
	  switch ($this->final[$i]["tag"]) {
		  case "PMID":
			  	 $this->final[$i]["pmid"] .= $data;
					 $this->final[$i]["count0"] = 1;
				//}
				break;
			case "VOLUME":
			  $this->final[$i]["volume"] .= $data;
				break;
			case "ISSUE":
			  $this->final[$i]["issue"] .= $data;
				break;
			case "MEDLINEPGN":
			  $this->final[$i]["pgn"] .= $data;
				break;
			case "MEDLINETA":
			  $this->final[$i]["jtitle"] .= $data;
				break;
			case "YEAR":
			  if ($this->final[$i]["inpubdate"]) {
				  $this->final[$i]["year"] .= $data;
				}
				break;
			case "MONTH":
			  if ($this->final[$i]["inpubdate"]) {
				  $this->final[$i]["month"] .= $data;
				}
				break;
			case "MEDLINEDATE":
				if ($this->final[$i]["inpubdate"]) {
					 $this->final[$i]["pdate"] .= $data;
				}
				break;
			case "ARTICLETITLE":
				//if ($this->final[$i]["count1"] == 0) {
			  	 $this->final[$i]["atitle"] .= $data;
					 			
					 $this->final[$i]["count1"] = 1;
				//}
				break;
			case "ABSTRACTTEXT":
				//if ($this->count2 == 0) {
				if ($this->final[$i]["onelabel"] != '') {
				   if (( strtolower($this->final[$i]["onecate"]) == 'conclusions') && (strtolower($this->final[$i]["onelabel"]) != 'conclusions')
					 && (strtolower($this->final[$i]["onelabel"]) != 'conclusion')) {
					   $this->final[$i]["abtext"] .= "Conclusions: ".$this->final[$i]["onelabel"].": ".$data;				 
					 }
					 else {
					   $this->final[$i]["abtext"] .= $this->final[$i]["onelabel"].": ".$data;
					 }
					 
					 $this->final[$i]["onecate"] = '';			  	 
					 $this->final[$i]["onelabel"] = '';
					 
					}
				else {
			  	 $this->final[$i]["abtext"] .= $data;
				}
				$this->final[$i]["count2"] = 1;
				
				//}
				break;
			case "LASTNAME":
			  $this->final[$i]["lname"] .= $data;
				break;
			case "INITIALS":
			  $this->final[$i]["iname"] .= $data;
				break;
			case "COLLECTIVENAME":
			  $this->final[$i]["cname"] .= $data;
				break;
			case "DESCRIPTORNAME":
			  $this->final[$i]["descriptor"] .= $data;
				break;
			case "QUALIFIERNAME":
			  $this->final[$i]["qualifier"] .= $data;
				break;
			case "PUBLICATIONTYPE":
			  $this->final[$i]["ptype"] .= $data;
				break;
			case "ISSN":
			  $this->final[$i]["issn"] .= $data;
				break;
			case "VERNACULARTITLE":
				$this->final[$i]["vertitle"] .= $data;
				break;
		}
	}
}

// Create an XML parser
function everything($url) {

$xml_parser = xml_parser_create();
xml_set_object($xml_parser,$this);
// Set the functions to handle opening and closing tags
xml_set_element_handler($xml_parser, "startElement", "endElement");

// Set the function to handle blocks of character data
xml_set_character_data_handler($xml_parser, "characterData");

$urlfile = $url;

// Open the XML file for reading
$fp = fopen($urlfile, "r")
       or die("Error reading PubMed XML data.");

// Read the XML file 4KB at a time
//while ($data = fread($fp, 4096))
while ($data = fread($fp, 8192)) {
   // Parse each 4KB chunk with the XML parser created above
   // Substitute entities for HTML <i> elements.
   xml_parse($xml_parser, str_replace("</i>", "&lt;/i&gt;", str_replace("<i>", "&lt;i&gt;", $data)), feof($fp))
       // Handle errors in parsing
       or die(sprintf("XML error: %s at line %d",  
           xml_error_string(xml_get_error_code($xml_parser)),  
           xml_get_current_line_number($xml_parser)));
}

print $data;

// Close the XML file
fclose($fp);

$numarti = $this->num_arti;
for ($j=0; $j<$numarti; $j++) {
		$this->final[$j]["pt"] = '';
		$this->final[$j]["allmesh"] = '';
		if (array_key_exists('plist', $this->final[$j]) && is_array($this->final[$j]["plist"]) == true) {
		for ($i=0; $i<sizeof($this->final[$j]["plist"]); $i++) {
				if (trim($this->final[$j]["plist"][$i]) != '') {
					if ($this->final[$j]["pt"] != '') {
					  $this->final[$j]["pt"] = $this->final[$j]["pt"]."; ".trim($this->final[$j]["plist"][$i]);
					}
					else {
					  $this->final[$j]["pt"] = trim($this->final[$j]["plist"][$i]);
					}
				}			
		}
		}
		if (array_key_exists('mesh', $this->final[$j]) && is_array($this->final[$j]["mesh"]) == true) {
		for ($i=0; $i<sizeof($this->final[$j]["mesh"]); $i++) {
				if (trim($this->final[$j]["mesh"][$i]) != '') {
					if ($this->final[$j]["allmesh"] != '') {
					  $this->final[$j]["allmesh"] = $this->final[$j]["allmesh"]."; ".trim($this->final[$j]["mesh"][$i]);
					}
					else {
					  $this->final[$j]["allmesh"] = trim($this->final[$j]["mesh"][$i]);
					}
				}			
		}
		}

		$this->final[$j]["linkout"] = array_key_exists('linkout', $this->final[$j])? trim($this->final[$j]["linkout"]):'';
		$this->final[$j]["pmid"] = array_key_exists('pmid', $this->final[$j])? trim($this->final[$j]["pmid"]):'';
		$this->final[$j]["pdate"] = array_key_exists('pdate', $this->final[$j])? trim($this->final[$j]["pdate"]):'';
		$this->final[$j]["pinfo"] = array_key_exists('pinfo', $this->final[$j])? trim($this->final[$j]["pinfo"]):'';
		$this->final[$j]["atitle"] = array_key_exists('atitle', $this->final[$j])? trim($this->final[$j]["atitle"]):'';
		$this->final[$j]["abtext"] = array_key_exists('abtext', $this->final[$j])? str_replace(array("\r","\n","\t"), "", $this->final[$j]["abtext"]):'';
		$this->final[$j]["abtext"] = trim(htmlentities($this->final[$j]["abtext"]));
		$this->final[$j]["author"] = array_key_exists('author', $this->final[$j])? trim($this->final[$j]["author"]):'';
		$this->final[$j]["cname"] = array_key_exists('cname', $this->final[$j])? trim($this->final[$j]["cname"]):'';
		$this->final[$j]["pt"] = array_key_exists('pt', $this->final[$j])? trim($this->final[$j]["pt"]):'';
		$this->final[$j]["jtitle"] = array_key_exists('jtitle', $this->final[$j])? trim($this->final[$j]["jtitle"]):'';
		$this->final[$j]["allmesh"] = array_key_exists('allmesh', $this->final[$j])? trim($this->final[$j]["allmesh"]):'';
		$this->final[$j]["issn"] = array_key_exists('issn', $this->final[$j])? trim($this->final[$j]["issn"]):'';
		$this->final[$j]["vertitle"] = array_key_exists('vertitle', $this->final[$j])? trim($this->final[$j]["vertitle"]):'';
}			

// Free up memory used by the XML parser
xml_parser_free($xml_parser);

}

} //end classparXML

class XMLcount {

  var $urlcount;
	var $webenv;
	var $querykey;
	var $count;
	var $tag;
	var $inresult;
	var $set_count;
	var $id;
	var $IDs;
	
function XMLcount() {
  $this->urlcount = NULL;
	$this->webenv = NULL;
	$this->querykey = NULL;
	$this->count = NULL;
	$this->tag = NULL;
	$this->inresult = NULL;
	$this->set_count = false;
	$this->id = NULL;
	$this->IDs = array();
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
		case "ID":
		  array_push($this->IDs, trim($this->id));
			$this->id = '';
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
			case "ID":
			  $this->id .= $data;
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

} //end class XMLcount


class parXML50 extends parXML {
   function parXML50() {
     $this->i = 0;
		 $this->num_arti = 50;
		 $this->final = array();
		 $this->urlfile = NULL;
   }
}
?>
