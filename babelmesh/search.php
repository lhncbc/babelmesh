<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>BabelMeSH</title>
  <link rel="stylesheet" href="https://lhncbc.nlm.nih.gov/assets/uswds-2.4.0/css/uswds.min.css" />
  <link rel="stylesheet" href="https://lhncbc.nlm.nih.gov/assets/stylesheets/LHC_main.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
 <link rel="stylesheet" href="https://lhncbc.nlm.nih.gov/ii/assets/stylesheets/II_main.css"> 
 <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-59GQ6JK');</script>
<!-- End Google Tag Manager -->

<style>
table, tr, td {
    border: none !important; 
    border-collapse: collapse !important;
}
</style>
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-59GQ6JK"
height="0" width="0" style="display:none;visibility:hidden" title="googletagmanager"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

  <div class="usa-overlay"></div>
  <header class="usa-header usa-header--extended insertheader">
  
  <div class="usa-nav-layout grid-row">
     <div class="usa-logo grid-col-10" id="extended-logo">

      <div class="header-logo" style="line-height:1rem;">
        <div class="display-flex flex-row flex-align-center">
            <div>
              <a href="https://www.nih.gov" alt="link to NIH homepage"><img src="https://lhncbc.nlm.nih.gov/assets/images/logo-NIH-block.png" alt="NIH logo chevron"></a>
            </div>    
            <div class="display-flex flex-column">
              <a href="https://www.nlm.nih.gov" alt="link to National Library of Medicine homepage">
                <img src="https://lhncbc.nlm.nih.gov/assets/images/logo-NLM-block.png" alt="portion of logo that reads National Library of Medicine">
              </a>
              <a href="https://lhncbc.nlm.nih.gov/index.html" alt="link to Lister Hill National Center for Biomedical Communications homepage">
                <img src="https://lhncbc.nlm.nih.gov/assets/images/logo-LHC-block.png" alt="portion of logo that reads Lister Hill National Center for Biomedical Communications">
              </a>
            </div>
        </div>

      </div>
    </div>
    <div class="LHC-menu grid-col-2 display-flex flex-row flex-justify-end flex-align-center">
      <button class="usa-menu-btn" aria-label="menu button"><i class="fas fa-bars fa-2x"></i></button>
    </div>
  </div>

  <nav aria-label="Primary navigation" class="usa-nav">
      <div class="usa-nav__inner">
        <button class="usa-nav__close"><img src="https://lhncbc.nlm.nih.gov/assets/images/close.svg" alt="close"></button>
        <div class="nav-container">
          <ul class="usa-nav__primary usa-accordion">

            <li class="usa-nav__primary-item">
              <a class="usa-nav__link" href="../index.html"><span class="subproject-navtitle">PubMed&nbsp;Search&nbsp;Tools&#58;</span></a>
            </li>

            <li class="usa-nav__primary-item">
              <button class="usa-accordion__button usa-nav__link" aria-expanded="false"
                aria-controls="extended-nav-section-one"><span>PubMed&nbsp;for&nbsp;Handhelds</span>
              </button>

              <ul id="extended-nav-section-one" class="usa-nav__submenu" hidden>
                <li class="usa-nav__submenu-item">
                <a class="usa-nav__link" href="../pico/index.php">PICO</a>
                </li>

                <li class="usa-nav__submenu-item">
                <a class="usa-nav__link" href="../ask/index.php">askMEDLINE</a>
                </li>

                <li class="usa-nav__submenu-item">
                <a class="usa-nav__link" href="../pico/consensus.php">Consensus&nbsp;Abstracts</a>
                </li>

                <li class="usa-nav__submenu-item">
                  <a class="usa-nav__link" href="../medline/index.php">MEDLINE/PubMed</a>
                </li>

              </ul>
            </li>

            <li class="usa-nav__primary-item">
              <a class="usa-nav__link" href="../ebm/index.php"><span class="subproject-navtitle">Evidence&nbsp;Based&nbsp;Medicine</span></a>
            </li>

            <li class="usa-nav__primary-item">
              <a class="usa-nav__link" href="../biomarkers/index.php"><span class="subproject-navtitle">Biomarkers</span></a>
            </li>

            <li class="usa-nav__primary-item usa-current">
              <a class="usa-nav__link usa-current" href="../babelmesh/index.php"><span class="subproject-navtitle">BabelMeSH</span></a>
            </li>

          </ul>
        </div>
      </div>
    </nav>
</header>

  <div class="front_page">
    <div class="usa-layout padding-y-4">
      <div class="grid-row grid-gap">
  
        <div class="desktop:grid-col-9">
          <p>BABELMESH</p>
          <h2>Multilanguage Search for MEDLINE/PubMed</h2>
  
            <div class="grid-container pt-2 px-0">
              <div class="grid-row pt-2">

<div>

<?php
	require "../include/header.php";
	require "../include/xmlclass2.php";
	require "../include/stopwords.php";
	
	$homepage = '';
	array_push($stopwords, 'and');
	array_push($stopwords, 'or');
	$hp = '';
  $readdata = $_SERVER["QUERY_STRING"];

	if (get_magic_quotes_gpc()) {
		$readdata = stripslashes($readdata);			 
	}

  parse_str($readdata);	
	$_POST["B1"] = strip_tags($_POST["B1"]);	
	$_POST["checked"] = strip_tags($_POST["checked"]);	
	$_POST["ALL_o"] = strip_tags($_POST["ALL_o"]);
	$_POST["ARA_o"] = strip_tags($_POST["ARA_o"]);
	$_POST["CHN_o"] = strip_tags($_POST["CHN_o"]);
	$_POST["ENG_o"] = strip_tags($_POST["ENG_o"]);
	$_POST["FIN_o"] = strip_tags($_POST["FIN_o"]);
	$_POST["FRE_o"] = strip_tags($_POST["FRE_o"]);
	$_POST["GER_o"] = strip_tags($_POST["GER_o"]);
	$_POST["ITA_o"] = strip_tags($_POST["ITA_o"]);
	$_POST["JPN_o"] = strip_tags($_POST["JPN_o"]);
	$_POST["POR_o"] = strip_tags($_POST["POR_o"]);
	$_POST["RUS_o"] = strip_tags($_POST["RUS_o"]);
	$_POST["SPA_o"] = strip_tags($_POST["SPA_o"]);
	$_POST["KOR_o"] = strip_tags($_POST["KOR_o"]);
	$_POST["SWE_o"] = strip_tags($_POST["SWE_o"]);
	$_POST["DUT_o"] = strip_tags($_POST["DUT_o"]);
	
	$_POST["Oterm"] = strip_tags($_POST["Oterm"]);
	$_POST["terms"] = strip_tags($_POST["terms"]);
	$terms = strip_tags($terms);
	
	$checked = strip_tags($checked);
	$B1 = strip_tags($B1);	
	$page  = strip_tags($page);
	$Oterm  = strip_tags($Oterm);
	$from  = strip_tags($from);
	$id  = strip_tags($id);
	$com = strip_tags($com);
	
	if (get_magic_quotes_gpc()) {
		$term = stripslashes($term);			 
	}
	
	if (($term == '') && ($_POST["terms"]!='') ) {  
			if (get_magic_quotes_gpc()) {
			  $term = stripslashes($_POST["terms"]);			 
			}
			else {
			  $term = $_POST["terms"];
			}
	}

	switch ($from) {
	case 'abb':
    $homepage = "http://askmedline.nlm.nih.gov/sms";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
   	break;
	case 'spa':
		$homepage = "index_spa.php";
		$message1 = "Vaya a la pagina busqueda";
		$message2 = "Previous";
		$message3 = "Siguiente";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
	case 'fre':
		$homepage = "index_fre.php";
		$message1 = "Revenez à la page de recherche";
		$message2 = "Previous";
		$message3 = "Apres";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
	case 'por':
		$homepage = "index_por.php";
		$message1 = "Retorne à busca";
		$message2 = "Previous";
		$message3 = "Seguida";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;

	case 'ita':
		$homepage = "index_ita.php";
		$message1 = "Nuova ricerca";
		$message2 = "Previous";
		$message3 = "Successiva";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
		
	case 'ger':
		$homepage = "index_ger.php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
		
	case 'rus':
		$homepage = "index_rus.php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
		
	case 'jpn':
		$homepage = "index_jpn.php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
		
	case 'mix':
		$homepage = "index_mix.php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
		
	case 'ara':
		$homepage = "index_ara.php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
			
	case 'eng':
		$homepage = "index_eng.php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
		
	case 'chn':
		$homepage = "index_chn.php";
		$message1 = "重新搜索";
		$message2 = "上一页";
		$message3 = "下一页";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
		
	case 'kor':
		$homepage = "index_kor.php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
		
	case 'swe':
		$homepage = "index_swe.php";
		$message1 = "Ny sökning";
		$message2 = "Föregående";
		$message3 = "Nästa";
		$message4 = "Abstract";
		$message5 = "Fulltext";
		$message6 = "Relaterat";
    break;

	case 'dut':
		$homepage = "index_".$from.".php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
	
	case 'fin':
		$homepage = "index_".$from.".php";
		$message1 = "Uusi haku";
		$message2 = "Edellinen";
		$message3 = "Seuraava";
		$message4 = "Tiivistelmä";
		$message5 = "Kokoteksti";
		$message6 = "Liittyvät";
    break;
		
	default:
		$homepage = "index_".$from.".php";
		$message1 = "New Search";
		$message2 = "Previous";
		$message3 = "Next";
		$message4 = "Abstract";
		$message5 = "Full Text";
		$message6 = "Related";
    break;
	}

  if ($page =='') {
	  $page = $_POST['page'];
  }
	
	$lang_out = array();
	
	$lang_all = 1;

			
	if (trim($_POST['ARA_o']) != '') {
	  array_push($lang_out, "Arabic%5Blang%5D"); 
	
	}

	if (trim($_POST['CHN_o']) != '') {
	  array_push($lang_out, "Chinese%5Blang%5D");
	}
	if (trim($_POST['FRE_o']) != '') {
	  array_push($lang_out, "French%5Blang%5D"); 
		//array_push($lo_array, "FRE");
	}
	if (trim($_POST['GER_o']) != '') {
	  array_push($lang_out, "German%5Blang%5D");
		//array_push($lo_array, "GER"); 
	}
	if (trim($_POST['ITA_o']) != '') {
	  array_push($lang_out, "Italian%5Blang%5D");
		//array_push($lo_array, "ITA"); 
	}
	if (trim($_POST['JPN_o']) != '') {
	  array_push($lang_out, "Japanese%5Blang%5D");
		//array_push($lo_array, "JPN"); 
	}
	if (trim($_POST['KOR_o']) != '') {
	  array_push($lang_out, "Korean%5Blang%5D");
	}
	if (trim($_POST['POR_o']) != '') {
	  array_push($lang_out, "Portuguese%5Blang%5D");
		//array_push($lo_array, "POR"); 
	}
	if (trim($_POST['SPA_o']) != '') {
	  array_push($lang_out, "Spanish%5Blang%5D");
		//array_push($lo_array, "SPA"); 
	}
	if (trim($_POST['RUS_o']) != '') {
	  array_push($lang_out, "Russian%5Blang%5D");
		//array_push($lo_array, "RUS"); 
	}
	if (trim($_POST['SWE_o']) != '') {
	  array_push($lang_out, "Swedish%5Blang%5D");
	}
	if (trim($_POST['DUT_o']) != '') {
	  array_push($lang_out, "Dutch%5Blang%5D");
	}
	if (trim($_POST['FIN_o']) != '') {
	  array_push($lang_out, "Finnish%5Blang%5D");
	}	
	if (trim($_POST['ENG_o']) != '') {
	  array_push($lang_out, "English%5Blang%5D");
		//array_push($lo_array, "ENG"); 
	}
	if (sizeof($lang_out) > 0) {
	  $lang_all = 0;
	}	
	if ($_POST['ALL_o'] != '') {
	  $lang_all = 1;
	}
	if ($otype == '') {
	  $otype = $lang_all;
	}
	
  $ip = get_client_ip();
	if (trim($_POST['logyn']) == 1) {
    $db_name = 'crosslan';
    $db_object = db_connect($db_name);
		//$handle = fopen(WHOLEROOT."\logs\crossLan.txt","a");
		$content = $ip." - [".date("j/M/Y: G:i:s")."] ";
		$content .= "$from: (U Choice) ".$_POST["Oterm"]." -- ".$term;
		//fwrite($handle, $content); 
	  //fclose($handle);
    $query = "INSERT INTO log (search) VALUES ('$content')";
    mysqli_query($db_object, $query) or die("Insert query failed : "); 
	} 

function searchQue($query) {

  global $Count, $QueryKey, $WebEnv, $ncbi_key;
 
	$utils = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils";
	
	$esearch = "$utils/esearch.fcgi?" .
                "retmax=1&usehistory=y&db=pubmed&tool=pmhh&api_key=$ncbi_key&email=pubmedhh@nlm.nih.gov".$query;
  $esearch_result = file_get_contents($esearch);
  //echo "<br>".$esearch."<br>";
  preg_match("|<Count>(.*)</Count>|m",$esearch_result,$hcount);
  preg_match("|<QueryKey>(.*)</QueryKey>|m",$esearch_result,$hkey);
  preg_match("|<WebEnv>(.*)</WebEnv>|m",$esearch_result,$hweb);
  
  $Count    = $hcount[1];
  $QueryKey = $hkey[1];
  $WebEnv   = $hweb[1];
}


function display($begin, $otype) { 
	$utils = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils";
  $db    = "pubmed";
  $report = "abstract";

  global $Count, $QueryKey, $WebEnv, $homepage, $message1, $message2, $message3, $message4, $message5, $message6, $from, $stopwords, $com, $outid, $ncbi_key;
  $retstart = 0;
  if (($Count == "")||($Count==0)) {
	  $Count = 0;
		echo "No result!";
		return;
  }

  print "$Count results: <hr>";

  $efetch = "$utils/efetch.fcgi?".
               "rettype=$report&retmode=xml&retstart=$begin&retmax=20&".
               "db=$db&query_key=$QueryKey&WebEnv=$WebEnv&tool=pmhh&api_key=$ncbi_key&email=pubmedhh@nlm.nih.gov";    

  $getxml = new parXML();
  $getxml->everything($efetch);

	for($retstart = 0; $retstart < 20; $retstart++) {
	  $au = $getxml->final[$retstart]["author"];
		$ti = $getxml->final[$retstart]["atitle"];
		if ( ($otype != 1) && ($getxml->final[$retstart]["vertitle"] != NULL) ) {
		  $ti = $getxml->final[$retstart]["vertitle"]."<br>".$ti;
		} 
		$pd = $getxml->final[$retstart]["pdate"];
		$ab = $getxml->final[$retstart]["abtext"];
		$pmid = trim($getxml->final[$retstart]["pmid"]);
		$pinfo = $getxml->final[$retstart]["pinfo"];
		$ta = $getxml->final[$retstart]["jtitle"];
  	$issn = $getxml->final[$retstart]["issn"];
	
  	$index = $begin + $retstart + 1;

  	if (($index == $Count) || ($Count == "0"))
  	{
	    $retstart = 20;
  	}
	
  print "<p>$index. ";
	global $term;
	$termarray = explode(" ", str_replace( array('(', ')', 'OR', 'AND'), "", trim($term)));
  $titemp = $ti;
	$ii=0;
  for ($i=0; $i<sizeof($termarray); $i++) {
	  $testterm = ' '.strtolower($termarray[$i]).' ';
		$newtemp = ' '.trim($titemp).' ';
		if (in_array(strtolower($termarray[$i]), $stopwords) == false) { // begin non-stop word
	  if (($ii%5)==0) {
		  if (trim($termarray[$i]) != '') {
	      $titemp = preg_replace('/'.$testterm.'/i', " <B style=\"color:black;background-color:#ffff66\">".strtolower($termarray[$i])."</B> ", $newtemp);
			}
		}
		elseif (($ii%5)==1) {
			if (trim($termarray[$i]) != '') {
	    	$titemp = preg_replace('/'.$testterm.'/i', " <B style=\"color:black;background-color:#00FF00\">".strtolower($termarray[$i])."</B> ", $newtemp);
			}
	  }
		
		elseif (($ii%5)==2) {
		  if (trim($termarray[$i]) != '') {
	      $titemp = preg_replace('/'.$testterm.'/i', " <B style=\"color:black;background-color:#3399FF\">".strtolower($termarray[$i])."</B> ", $newtemp);
			}	
		}
		elseif (($ii%5)==3){
		  if (trim($termarray[$i]) != '') {
		    $titemp = preg_replace('/'.$testterm.'/i', " <B style=\"color:black;background-color:#CC9900\">".strtolower($termarray[$i])."</B> ", $newtemp);
			}
		}
		else {
		  if (trim($termarray[$i]) != '') {
		    $titemp = preg_replace('/'.$testterm.'/i', " <B style=\"color:black;background-color:#66CCFF\">".strtolower($termarray[$i])."</B> ", $newtemp);
			}
		}
		$ii++;
		} // end non-stop word
		
	}
	print trim($titemp)."<br>";
  if ($au!="") {
    print utf8_encode($au)."<br>";
  }
  print "$ta; ";
  print "$pd; $pinfo. PubMed ID: $pmid<br>";
  if ($ab == "")
  {
	  print "[No Abstract]  &nbsp;&nbsp;";
  }
  else
  { 
		print "[<a href=abstract_tbl.php?id=$pmid&fterm=".urlencode($term)."&outid=$outid target=new>TBL</a>]&nbsp;&nbsp;";
	  print "[<a href=abstract.php?id=$pmid&fterm=".urlencode($term)."&outid=$outid target=new>$message4</a>]&nbsp;&nbsp;";
  }
  print " [<a href=https://www.ncbi.nlm.nih.gov/entrez/eutils/elink.fcgi?cmd=prlinks&dbfrom=pubmed&id=$pmid&retmode=ref target=new>$message5</a>]&nbsp;&nbsp;";
  print " [<a href=".$_SERVER['PHP_SELF']."?id=$pmid&mod=related&page=1&from=$from&com=$com>$message6</a>]&nbsp;&nbsp;";
  print "<br></p>";
  } 
} //end func display


function related($rid) {
  global $homepage, $homepage, $message1, $message2, $message3, $message4, $message5, $message6, $from, $com, $outid, $ncbi_key;

  //$utils = "http://www.ncbi.nlm.nih.gov/entrez/eutils";
	$utils = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils";
  $db     = "pubmed";
  $report = "abstract";

  $elink = "$utils/elink.fcgi?" .
               "dbfrom=$db&id=$rid&cmd=neighbor&tool=pmhh&api_key=$ncbi_key&email=pubmedhh@nlm.nih.gov";
  $elink_result = file_get_contents($elink);

  $rest = $elink_result;
  $sbegin = strpos($rest,'<Id>');
	$end = strpos($rest,'</Id>',5);
	$rest =substr($rest,$end);
	$sbegin = strpos($rest,'<Id>');
  $i = 0;
  global $page;

  while (!($sbegin===false)) {	
	  $end = strpos($rest,'</Id>',5);
	  $len=$end-$sbegin-4;
		$tempID= substr($rest, ($sbegin + 4), $len);
		$IDs[$i] = $tempID;
		$rest =substr($rest,$end);
		$sbegin = strpos($rest,'<Id>');
		$i++;
  }

  $Count = $i-1;
 
  $Tpage=ceil($Count/20);

  if ($page > $Tpage) {
	$page = $Tpage;
  }
  if ($page <=0) {
	$page = 1;
  }

  print $Count." related articles for article (PubMed ID: ".$rid.")";
  print "<hr>";
  $begin = ($page-1)*20;

  for($j=$begin; $j<$begin+20; $j++) {
    $id .= $IDs[$j].",";
	}
    // echo "ID==".$id."<br>";
    $efetch = "$utils/efetch.fcgi?" .
             "db=$db&id=$id&rettype=$report&retmode=xml";
						 
  	$getxml = new parXML();
  	$getxml->everything($efetch);
						 
	for($j=0; $j<20; $j++) {
	  $au = $getxml->final[$j]["author"];
	  $ti = $getxml->final[$j]["atitle"];
	  $pd = $getxml->final[$j]["pdate"];
	  $ab = $getxml->final[$j]["abtext"];
	  $pmid = trim($getxml->final[$j]["pmid"]);
	  $pinfo = $getxml->final[$j]["pinfo"];
	  $ta = $getxml->final[$j]["jtitle"];
		$issn = $getxml->final[$j]["issn"];
		
    $index = $begin + $j+1;

    if (($index == $Count) || ($Count == "0"))
    {
		  $j = $begin+20;
    }

    print "<p>$index. "."$ti<br>";

    if ($au!="") {
      print utf8_encode($au)."<br>";
    }
    print "$ta; ";
    print "$pd; $pinfo. PubMed ID: $pmid<br>";
    if ($ab == "")
    {
	    print "[No Abstract]  &nbsp;&nbsp;";
    }
    else
    {
		  print "[<a href=abstract_tbl.php?id=$pmid&outid=$outid target=new>TBL</a>]&nbsp;&nbsp;";
	    print "[<a href=abstract.php?id=$pmid&outid=$outid target=new>$message4</a>]&nbsp;&nbsp;";
    }
    print "[<a href=https://www.ncbi.nlm.nih.gov/entrez/eutils/elink.fcgi?cmd=prlinks&dbfrom=pubmed&id=$pmid&retmode=ref target=new>$message5</a>]&nbsp;&nbsp;";
    print " [<a href=".$_SERVER['PHP_SELF']."?id=$pmid&mod=related&page=1&from=$from&com=$com>$message6</a>]&nbsp;&nbsp;";
    // print " [<a href=".PATH3."confirm.php?id=".$pmid.">Write a Review</a>]";
    print "<br></p>";

  } 

  print "<hr>";
  print "Page: ";
  $pre=$page-1;
  $next=$page+1;

  if ($page != 1) 
  {
    print "[<a href=".$_SERVER['PHP_SELF']."?id=$rid&mod=related&page=$pre&from=$from&com=$com>".$message2."</a>] ";
    if ($page != $Tpage) {
	print "&nbsp;";
	print " [<a href=".$_SERVER['PHP_SELF']."?id=$rid&mod=related&page=$next&from=$from&otype=$otype&com=$com>".$message3."</a>]";
    }
  }

  if($page == 1)
  {
  	print " [<a href=".$_SERVER['PHP_SELF']."?id=$rid&mod=related&page=$next&from=$from&com=$com>".$message3."</a>]";
  }
  print "&nbsp;&nbsp;&nbsp;&nbsp;[<a href=$homepage?com=$com>".$message1."</a>]";

  print "<FORM ACTION=".$_SERVER['PHP_SELF']."?id=$rid&mod=relpager&from=$from&com=$com METHOD=POST>";
  print "<INPUT type=\"submit\" value=\"page\">\n";
  print "<input type=\"text\" name=\"page\" size=\"5\" value=\"$page\">\n";
  print " of $Tpage.\n";
  print "</form>";
 
} // end func related

if (($id != "") && (($mod == "related") || ($mod == "relpager"))) {	
  call_user_func('related',$id);
} else {


if ($submit != "Y") {
  //echo $term;
  $string = "&term=human%5Bmh%5D%20AND%20".urlencode($term);
	
	$ii=0;
	$termarray = explode(" ", str_replace( array('(', ')'), "", trim($term)));
  for ($i=0; $i<sizeof($termarray); $i++) {
	
		if (in_array(strtolower($termarray[$i]), $stopwords) == false) { // begin non-stop word
	  if (($ii%5)==0) {
		  if ( ($termarray[$i] != 'OR') && ($termarray[$i] !='AND') ) {
	      $termarray[$i] = "<B style=\"color:black;background-color:#ffff66\">".$termarray[$i]."</B>";
			}
		}
	  elseif (($ii%5)==1) {
		  if ( ($termarray[$i] != 'OR') && ($termarray[$i] !='AND') ) {
	      $termarray[$i] = "<B style=\"color:black;background-color:#00FF00\">".$termarray[$i]."</B>";
			}
	  }
		elseif (($ii%5)==2) {
		  if ( ($termarray[$i] != 'OR') && ($termarray[$i] !='AND') ) {
	      $termarray[$i] = "<B style=\"color:black;background-color:#3399FF\">".$termarray[$i]."</B>";
			}
		}
		elseif (($ii%5)==3){
		  if ( ($termarray[$i] != 'OR') && ($termarray[$i] !='AND') ) {
		    $termarray[$i] = "<B style=\"color:black;background-color:#CC9900\">".$termarray[$i]."</B>";
			}
		}
		else {
		  if ( ($termarray[$i] != 'OR') && ($termarray[$i] !='AND') ) {
		    $termarray[$i] = "<B style=\"color:black;background-color:#66CCFF\">".$termarray[$i]."</B>";
			}
		}
		$ii++;
		}// end non-stop word
	}
	$termtemp = implode(" ", $termarray);
	//print "Terms: ".mb_convert_encoding($_POST["terms"], "CP1252")." = ".$termtemp."<br>";
	print "Terms: ".mb_convert_encoding($_POST["Oterm"], "CP1252", "auto")." = ".$termtemp."<br>";
	//print "Terms: ".$_POST["Oterm"]." = ".$term."<br>";
	/*
	echo "<a href=\"http://clinicaltrials.gov/ct2/results?term=".str_replace(" ", "+", strip_tags($termtemp))."\" target=new>ClinicalTrial.gov</a><br>";
	*/
	if (($lang_all == 0) && (sizeof($lang_out) !=0 )) {
	  $lang_out_total = "%20AND%20(".implode("%20OR%20", $lang_out).")";
	  $string .= $lang_out_total;
	}
	/*
	if ( ($lang_all ==0) && (sizeof($lo_array) !=0)) {
	  $lo =implode("_", $lo_array);
		$homepage .= "?lo=".$lo;
	} 
	*/
  call_user_func ('searchQue',$string);
  //echo "<br>".$string."<br>";
  $beg = 0;
	
	if ($otype == 1) {
    call_user_func ('display',$beg, 1);
	}
	else {
	  call_user_func ('display',$beg, 0);
	}
  $page = 1;
} // end first search

else {
  if ($submit == "Y") {
     $Tpage=ceil($Count/20);
     if ($page > $Tpage) {
		   $page = $Tpage;
     }
     if ($page <=0) {
		   $page = 1;
     }
     $beg = ($page-1) * 20;
     if ($otype == 1) {
       call_user_func ('display',$beg, 1);
	   }
	   else {
	     call_user_func ('display',$beg, 0);
	   }
  }
} //end else -- more pages

  
print "<hr>";
$pre=$page-1;
$next=$page+1;

$Tpage=ceil($Count/20);

if (($page > 1) && ($page <= $Tpage)){
  print "[<a href=".$_SERVER['PHP_SELF']."?submit=Y&page=$pre&Count=$Count&QueryKey=$QueryKey&WebEnv=$WebEnv&from=$from&otype=$otype&com=$com>".$message2."</a>] ";
  if ($page < $Tpage) {
	print "  &nbsp;";
  	print " [<a href=".$_SERVER['PHP_SELF']."?submit=Y&page=$next&Count=$Count&QueryKey=$QueryKey&WebEnv=$WebEnv&from=$from&otype=$otype&com=$com>".$message3."</a>]";
  }
}

if (($page == 1) && ($page < $Tpage)) {
  print " [<a href=".$_SERVER['PHP_SELF']."?submit=Y&page=$next&Count=$Count&QueryKey=$QueryKey&WebEnv=$WebEnv&from=$from&otype=$otype&com=$com>".$message3."</a>]";
}

print "&nbsp;&nbsp;&nbsp;&nbsp;[<a href=$homepage?com=$com>".$message1."</a>]";

echo "<FORM ACTION=".$_SERVER['PHP_SELF']."?submit=Y&mod=pager&Count=$Count&QueryKey=$QueryKey&WebEnv=$WebEnv&from=$from&otype=$otype&com=$com METHOD=POST>";
print "<INPUT type=\"submit\" value=\"page\">\n";

print "<input type=\"text\" name=\"page\" size=\"5\" value=\"$page\">\n";

print " of $Tpage.\n";
print "</form>";

}
?>

</div>

                </div>
              </div>

              
<div class="grid-container padding-top-4"></div>

</div>
          </div>
        </div>
      </div>

  <footer class="bg-primary text-white">
  <div class="container-fluid">
  <div class="container pt-5">
    <div class="row mt-3">
      <div class="col-md-3 col-sm-6 col-6">
        <p class="mb-0"><a href="https://www.nlm.nih.gov/socialmedia/index.html" class="text-white">Connect with NLM</a></p>
        <ul class="list-inline">
            <li class="list-inline-item me-2 social_media"><a title="External link: please review our privacy policy." href="https://www.facebook.com/nationallibraryofmedicine"><img src="//www.nlm.nih.gov/images/facebook.svg" class="img-fluid bg-secondary" alt="Facebook"></a></li>
            <li class="list-inline-item me-2 social_media"><a title="External link: please review our privacy policy." href="https://www.linkedin.com/company/national-library-of-medicine-nlm/"><img src="//www.nlm.nih.gov/images/linkedin.svg" class="img-fluid bg-secondary" alt="LinkedIn"></a></li>
            <li class="list-inline-item me-2 social_media"><a title="External link: please review our privacy policy." href="https://twitter.com/NLM_NIH"><img src="//www.nlm.nih.gov/images/twitter.svg" class="img-fluid bg-secondary"   alt="Twitter"></a></li>
            <li class="list-inline-item me-2 social_media"><a title="External link: please review our privacy policy." href="https://www.youtube.com/user/NLMNIH"><img src="//www.nlm.nih.gov/images/youtube.svg" class="img-fluid bg-secondary" alt="You Tube"></a></li>
            <li class="list-inline-item me-2 social_media"><a title="External link: please review our privacy policy." href="https://public.govdelivery.com/accounts/USNLMOCPL/subscriber/new?preferences=true"><img src="//www.nlm.nih.gov/images/mail.svg" class="img-fluid bg-secondary" alt="Government Delivery"></a></li>
        </ul>
      </div>
      <div class="col-md-3 col-sm-6 col-6">
        <p class="address_footer text-white"> National Library of Medicine <br>
          <a href="https://www.google.com/maps/place/8600+Rockville+Pike,+Bethesda,+MD+20894/@38.9959508,-77.101021,17z/data=!3m1!4b1!4m5!3m4!1s0x89b7c95e25765ddb:0x19156f88b27635b8!8m2!3d38.9959508!4d-77.0988323" class="text-white"> 8600 Rockville Pike <br>
          Bethesda, MD 20894 </a></p>
      </div>
      <div class="col-md-3 col-sm-6 col-6">
        <p><a href="https://www.nlm.nih.gov/web_policies.html" class="text-white"> Web Policies </a><br>
          <a href="https://www.nih.gov/institutes-nih/nih-office-director/office-communications-public-liaison/freedom-information-act-office" class="text-white"> FOIA </a><br><a href="https://www.hhs.gov/vulnerability-disclosure-policy/index.html" class="text-white">HHS Vulnerability Disclosure</a></p>
      </div>
      <div class="col-md-3 col-sm-6 col-6">
        <p><a class="supportLink text-white" href="//support.nlm.nih.gov?from="> NLM Support Center </a> <br>
          <a href="https://www.nlm.nih.gov/accessibility.html" class="text-white"> Accessibility </a><br>
          <a href="https://www.nlm.nih.gov/careers/careers.html" class="text-white"> Careers </a></p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <p class="mt-2 text-center"> <a class="text-white" href="//www.nlm.nih.gov/">NLM</a> | <a class="text-white" href="https://www.nih.gov/">NIH</a> | <a class="text-white" href="https://www.hhs.gov/">HHS</a> | <a class="text-white" href="https://www.usa.gov/">USA.gov</a></p>
      </div>
    </div>
  </div>
  </div>
  </footer>
<script src="https://www.nlm.nih.gov/scripts/jquery/jquery-latest.min.js"></script>
<script src="https://lhncbc.nlm.nih.gov/assets/javascript/popper-1.14.7.min.js"></script>
<script src="https://lhncbc.nlm.nih.gov/assets/uswds-2.4.0/js/uswds.min.js"></script>
<script src="https://lhncbc.nlm.nih.gov/assets/javascript/supportLink.js"></script>
<script src="https://www.nlm.nih.gov/core/nlm-notifyExternal/1.0/nlm-notifyExternal.min.js"></script>
</body>  
</html>
