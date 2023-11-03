<?php 

class parXML {

var $urlfile = "";
// Set the run conditions
var $count1 =0;
var $count2 =0;
var $count3 =0;

var $incomment = false;
var $linkout = false;

// Set the tag variable
var $tag = "";
var $attrib = "";
var $ctag = "";

// Set the article variables
var $pmid = "";
var $jtitle = "";
var $volume = "";
var $issue = "";
var $year = "";
var $month = "";
var $pgn = "";
var $atitle = "";
var $abtext = "";
var $author = array();
var $lname = "";
var $iname = "";
var $cname = "";
var $plist = array();
var $ptype = "";
var $mesh = array();
var $descriptor = "";
var $qualifier = "";
var $qarray = "";

var $pinfo;
var $pdate;
var $pt;
var $allmesh;

var $onelabel;
var $onecate;

function parXML() {
$this->count1 =0;
$this->count2 =0;
$this->count3 =0;

$this->urlfile = NULL;
$this->inarticle = false;
$this->inpubdate = false;
$this->incomment = false;

$this->linkout = false;

$this->tag = NULL;
$this->attrib = NULL;
$this->ctag = NULL;

$this->pmid = NULL;

$this->jtitle = NULL;
$this->volume = NULL;
$this->issue = NULL;
$this->year = NULL;
$this->month = NULL;
$this->pgn = NULL;
$this->atitle = NULL;
$this->abtext = NULL;
$this->author = array();
$this->lname = NULL;
$this->iname = NULL;
$this->cname = NULL;
$this->plist = array();
$this->ptype = NULL;
$this->mesh = array();
$this->descriptor = NULL;
$this->qualifier =NULL;
$this->qarray = NULL;
$this->linkout = NULL;
$this->pinfo = NULL;
$this->pdate = NULL;
$this->pt = NULL;
$this->allmesh = NULL;

$this->onelabel = NULL;
$this->onecate = NULL; //NlmCategory
}

// Parsing functions
function startElement ($parser, $tagName, $attrs) {
	switch ($tagName) {
	  case "PUBMEDARTICLE":
		  $this->inarticle = true;
		  break;
		case "PMID":
		  $this->inpmid = true;
		  break;
		case "ARTICLETITLE":
		  $this->intitle = true;
		  break;			
		case "ABSTRACTTEXT":
		  $this->onelabel = '';
			if(array_key_exists('LABEL', $attrs)) {
			  $this->onelabel = $attrs['LABEL'];
			}
			
			$this->onecate = '';			
			if(array_key_exists('NLMCATEGORY', $attrs)) {
			  $this->onecate = $attrs['NLMCATEGORY'];
			}
			
		  $this->inab = true;
		  break;
		case "PUBDATE":
		  $this->inpubdate = true;
			break;
		case "COMMENTSCORRECTIONS":
		  $this->incomment = true;
		  break;
		case "ARTICLEID":
		  if (trim($attrs['IDTYPE']) == "pii" || trim($attrs['IDTYPE']) == "doi") {
			  $this->linkout = true;
			}
			break;
	}
	if ($this->inarticle) {
	  if ($this->incomment) {
		  $this->tag = "";
			$this->ctag = $tagName;
		} else {
		  $this->tag = $tagName;
			$this->attrib = $attrs;
		}
	}
}

function endElement ($parser, $tagName) {
  //global $inarticle, $inpubdate, $incomment, $inmesh, $tag, $attrib, $ctag, $pmid, $jtitle, $volume, $issue,$year, $month, $pgn, $atitle, $abtext, $author, $lname, $iname, $cname, $plist, $ptype, $mesh, $descriptor, $qualifier, $qarray, $linkout;
	switch ($tagName) {
	  case "PUBDATE":
		  $this->inpubdate = false;
			break;
		case "COMMENTSCORRECTIONS":
		  $this->incomment = false;
		  break;
		case "MESHHEADING":
		  $this->mesh[] = trim($this->descriptor).trim($this->qarray);
			$this->descriptor = "";
			$this->qarray = "";
		  break;
		case "AUTHOR":
		  $this->author[] = trim($this->lname)." ".trim($this->iname);
			$this->lname = "";
			$this->iname = "";
			break;
		case "QUALIFIERNAME":
		  if ($this->attrib['MAJORTOPICYN'] == "Y") {
			  $this->qarray .= "/*".trim($this->qualifier);
			} else {
			  $this->qarray .= "/".trim($this->qualifier);
			}
			$this->qualifier = "";
			break;
		case "PUBLICATIONTYPE":
		  $this->plist[] = trim($this->ptype);
		  $this->ptype = "";
			break;
	}
	if ($tagName == "PUBMEDARTICLE") { //end and print everything
	  switch (count($this->author)) {
		  case 0:
		    $this->author = "";
				break;
			case 1:
			  $this->author = reset($this->author);
				if (trim($this->author) == "") {
				  if (trim($this->cname) == "") {
					  $this->author = "";
					} else {
					  $this->author = trim($this->cname);
					}
				}
			  break;
			default:
			  $this->author = join("; ", $this->author);
			  break;
		}
		// Print Everything
		if ($this->pdate) {
			 $this->pdate = trim($this->pdate);
		}
		else {
			 $this->pdate = trim($this->year)." ".trim($this->month);
		}
		$this->pinfo = trim($this->volume)."(".trim($this->issue)."):".trim($this->pgn);

	}// end PUBMEDARTICLE
	
}// end endelement

function characterData ($parser, $data) {
	if ($this->inarticle) {
	  switch ($this->tag) {
		  case "PMID":
				break;
			case "VOLUME":
			  $this->volume .= $data;
				break;
			case "ISSUE":
			  $this->issue .= $data;
				break;
			case "MEDLINEPGN":
			  $this->pgn .= $data;
				break;
			case "MEDLINETA":
			  $this->jtitle .= $data;
				break;
			case "YEAR":
			  if ($this->inpubdate) {
				  $this->year .= $data;
				}
				break;
			case "MONTH":
			  if ($this->inpubdate) {
				  $this->month .= $data;
				}
				break;
			case "MEDLINEDATE":
				if ($this->inpubdate) {
			          $this->pdate .= $data;
				}
				break;
			case "ARTICLETITLE":
			  	 $this->atitle .= $data;
				 break;
			case "ABSTRACTTEXT":
				//if ($this->count2 == 0) {
				  if ($this->onelabel != '') {
					   if (( strtolower($this->onecate) == 'conclusions') && (strtolower($this->onelabel) != 'conclusions')
						 && (strtolower($this->onelabel) != 'conclusion')) {
					     $this->abtext .= "Conclusions: ".$this->onelabel.": ".$data;				 
					   }
					   else {
			  	     $this->abtext .= $this->onelabel.": ".$data;
					   }
					 
					   $this->onelabel = '';
						 $this->onecate = '';
					}
					else {
					  $this->abtext .= $data;
					} 
					 $this->count2 = 1;
				//}
				break;
			case "LASTNAME":
			  $this->lname .= $data;
				break;
			case "INITIALS":
			  $this->iname .= $data;
				break;
			case "COLLECTIVENAME":
			  $this->cname .= $data;
				break;
			case "DESCRIPTORNAME":
			  $this->descriptor .= $data;
				break;
			case "QUALIFIERNAME":
			  $this->qualifier .= $data;
				break;
			case "PUBLICATIONTYPE":
			  $this->ptype .= $data;
				break;	
		}
	}
}

// Create an XML parser
function everything($url) {
  $xml_parser = xml_parser_create();
  //$parserX = new parXML(); 
  // xml_set_object($xml_parser,&$parserX);
  xml_set_object($xml_parser, $this);
  // Set the functions to handle opening and closing tags
  xml_set_element_handler($xml_parser, "startElement", "endElement");

  // Set the function to handle blocks of character data
  xml_set_character_data_handler($xml_parser, "characterData");

  $urlfile = $url;

  // Open the XML file for reading
  $fp = fopen($urlfile, "r")
       or die("Error reading PubMed XML data.");

  // Read the XML file 4KB at a time
  while ($data = fread($fp, 4096))
   // Parse each 4KB chunk with the XML parser created above
   xml_parse($xml_parser, str_replace("</i>", "&lt;/i&gt;", str_replace("<i>", "&lt;i&gt;", $data)), feof($fp))
       // Handle errors in parsing
       or die(sprintf("XML error: %s at line %d",  
           xml_error_string(xml_get_error_code($xml_parser)),  
           xml_get_current_line_number($xml_parser)));
  // Close the XML file
  fclose($fp);

		$this->pt = '';
		$this->allmesh = '';
		for ($i=0; $i<sizeof($this->plist); $i++) {
				if (trim($this->plist[$i]) != '') {
					if ($this->pt != '') {
					  $this->pt = $this->pt."; ".trim($this->plist[$i]);
					}
					else {
					  $this->pt = trim($this->plist[$i]);
					}
				}			
		}
		for ($i=0; $i<sizeof($this->mesh); $i++) {
				if (trim($this->mesh[$i]) != '') {
					if ($this->allmesh != '') {
					  $this->allmesh = $this->allmesh."; ".trim($this->mesh[$i]);
					}
					else {
					  $this->allmesh = trim($this->mesh[$i]);
					}
				}			
		}

		$this->linkout = trim($this->linkout);
		$this->pmid = trim($this->pmid);
		$this->pdate = trim($this->pdate);
		$this->pinfo = trim($this->pinfo);
		$this->atitle = trim($this->atitle);
		
		$this->abtext = str_replace(array("\r","\n","\t"), "", $this->abtext);
		$this->abtext = trim(htmlentities($this->abtext));
		$this->author = trim($this->author);
		$this->cname = trim($this->cname);
		$this->pt = trim($this->pt);
		$this->jtitle = trim($this->jtitle);
		$this->allmesh = trim($this->allmesh);
				
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
  //global $inarticle, $inpubdate, $incomment, $inmesh, $tag, $attrib, $ctag, $pmid, $jtitle, $volume, $issue,$year, $month, $pgn, $atitle, $abtext, $author, $lname, $iname, $cname, $plist, $ptype, $mesh, $descriptor, $qualifier, $qarray, $linkout;
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

} //end class XMLcount
?>
