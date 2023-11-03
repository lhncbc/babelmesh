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

<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
   function onSubmit(token) {
     document.getElementById("query").submit();
   }  
</script>
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
          <h2>  Pesquisa MEDLINE/PubMed em português</h2>
  
            <div class="grid-container pt-2 px-0">
              <div class="grid-row pt-2">

<div>


<?php
	require "../include/header.php";
  require "translate.php";
	require "xmlcount.php";
	
  $checked =$_POST["checked"];
	
	$readdata = strip_tags($_SERVER["QUERY_STRING"]);
	parse_str($readdata);
	$com = strip_tags($com);
  if ($_POST["checked"] == '') {
?>

<font size="2">
Quando se procura informação torna-se muitas vezes mais fácil usar a língua com que estamos mais familiarizados.  A tradução em Português dos termos do  
<a href=http://www.nlm.nih.gov/pubs/factsheets/mesh.html >MeSH</a> 
(“Medical Subject Headings”) pode ajudar quem não esteja tão à vontade com o Inglês.
Assim, procure nas bases de dados  MEDLINE/PubMed usando termos médicos e frases em Português. 
Deve, no entanto, estar preparado/a para o facto de que  todas as citações e abstracts que forem encontrados serão apresentados,  apenas,  em  Inglês.
</font>
<p>
<b>Se preferir, pode dactilografar as palavras com acentos.</b></br>
</p>

<?php
  $readdata = $_SERVER["QUERY_STRING"];
 	parse_str($readdata);
	$com = strip_tags($com);
?>

<form  accept-charset="utf-8" method="POST" name ="por" id="query" action=<?php echo $_SERVER['PHP_SELF']."?com=$com"; ?>>
  <input type="text" name="terms" size="60" autocomplete="off" 
		<?php 
	  if ($in2) {
			echo "value=\"".$in2."\"";
		}
	?>  
	
	>
  <p><p>
  <button class="g-recaptcha" 
        data-sitekey="<?php echo $recaptcha_sitekey ?>"
        data-callback='onSubmit' 
        data-action='submit'>Procure</button>
  <!--<input type="submit" value="Procure" name="B1">-->
	&nbsp;<input type="reset" value="Apague" name="B2"></p>
	
	<font size="2" color="#0000FF">Artigos de revistas publicados em:<br></font>
<font size="2" color="#0000FF">[<span id="s_ara_o">Árabe</span><input type="checkbox" value="ARA" name="ARA_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_chn_o">Chinês</span><input type="checkbox" value="CHN" name="CHN_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_fre_o">Francês</span><input type="checkbox" value="FRE" name="FRE_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_ger_o">Alemão</span><input type="checkbox" value="GER" name="GER_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_ita_o">Italiano</span><input type="checkbox" value="ITA" name="ITA_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_jpn_o">Japonês</span><input type="checkbox" value="JPN" name="JPN_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_kor_o">Coreano</span><input type="checkbox" value="KOR" name="KOR_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_por_o">Português</span><input type="checkbox" value="POR" name="POR_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_rus_o">Russo</span><input type="checkbox" value="RUS" name="RUS_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_spa_o">Espanhol</span><input type="checkbox" value="SPA" name="SPA_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_swe_o">Sueco</span><input type="checkbox" value="SWE" name="SWE_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_eng_o">Inglês</span><input type="checkbox" value="ENG" name="ENG_o">]&nbsp;&nbsp;&nbsp;</font>
<font size="2" color="#0000FF">[<span id="s_all_o">Todas</span><input type="checkbox" value="ALL" name="ALL_o">]</font>

	<input type = "hidden" value="1" name="checked">
</form>

<SCRIPT src="alllatin.js"></SCRIPT>
<SCRIPT>InstallAC(document.por,document.por.terms,document.por.B1,"search","en", "por");</SCRIPT>
<?php
	}
  elseif ($_POST["checked"] == 1){

			$_POST["terms"] = strip_tags($_POST["terms"]);
			
			$_POST["ALL_o"] = strip_tags($_POST["ALL_o"]);
			$_POST["ARA_o"] = strip_tags($_POST["ARA_o"]);
			$_POST["CHN_o"] = strip_tags($_POST["CHN_o"]);
			$_POST["ENG_o"] = strip_tags($_POST["ENG_o"]);
			$_POST["FRE_o"] = strip_tags($_POST["FRE_o"]);
			$_POST["GER_o"] = strip_tags($_POST["GER_o"]);
			$_POST["ITA_o"] = strip_tags($_POST["ITA_o"]);
			$_POST["JPN_o"] = strip_tags($_POST["JPN_o"]);
			$_POST["POR_o"] = strip_tags($_POST["POR_o"]);
			$_POST["RUS_o"] = strip_tags($_POST["RUS_o"]);
			$_POST["SPA_o"] = strip_tags($_POST["SPA_o"]);
			$_POST["KOR_o"] = strip_tags($_POST["KOR_o"]);
			$_POST["SWE_o"] = strip_tags($_POST["SWE_o"]);
			
			if (trim($_POST["terms"]) == '') {
				    echo "Por favor, entre os seus termos de busca!";
						echo "<p><a href=".$_SERVER['PHP_SELF'].">Volte para a página de anterior</a>";
						die();				
			}
			
			$dele= new translate();
			
			$_POST["terms"] = $dele->P_delete(utf8_encode($_POST["terms"]));
			$_POST["terms"] = $dele->clean_por($_POST["terms"]);
			unset($dele);
			
  		$db_name = 'crosslan';
  		$db_object = db_connect($db_name);
			$query = "SELECT US_DESCRIPTOR FROM por_mesh WHERE por_descriptor ='".addslashes($_POST["terms"])."'";

	  	$result = mysqli_query($db_object,$query) or die("Query failed : " );

			if (mysqli_affected_rows($db_object) == 0) {
			    $checked = 2;
			}			
			else {
					$line= mysqli_fetch_array($result);
					$term = $line["US_DESCRIPTOR"];
			}	
			
      $ip = get_client_ip();
	  	if ($checked == 1) {
				 $rterm = $term;
				 $term = str_replace(' ', '+',$term);
				 $content = $ip." - [".date("j/M/Y: G:i:s")."] ";
				 $content .= "Portuguese: ".$_POST["terms"]." -- ".$rterm;
				 $url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=pubmed&retmax=1&api_key=$ncbi_key&term=".$term;
				 $a = new XMLcount();
				 $a->getCount($url);
				 $Count = $a->count;
				 unset($a);
				 $content .= " [Count: ".$Count."]"; 	 
         $query = "INSERT INTO log (search) VALUES ('$content')";
         mysqli_query($db_object, $query) or die("Insert query failed : ");
?>

<form enctype="application/x-www-form-urlencoded" name="query2" action="search.php?from=por&com=<?php echo $com;?>&term=<?php echo $term; ?>" method="POST">
  <input type="hidden" name="Oterm" value="<?php echo $_POST["terms"];?>">
<?php
  pass_lang_out();
?>
</form>
<SCRIPT LANGUAGE="JavaScript">
		  document.query2.submit();
</script>	

<?php
			   exit();
			}
			elseif ($checked == 2) {
				 $content = $ip." - [".date("j/M/Y: G:i:s")."] ";
				 $content .= "Portuguese: ".$_POST["terms"]." -- ???";
         $query = "INSERT INTO log (search) VALUES ('$content')";
         mysqli_query($db_object, $query) or die("Insert query failed : ");
				 
				 $find= new translate();
				 $de_chars = array("?", ".", ",", ";", ":");
				 $result = $find->P_no_order(addslashes(str_replace($de_chars, " ", $_POST["terms"]) ));
				 if ($result == '') {
				   $result = $find->Pfinder(addslashes(str_replace($de_chars, " ", $_POST["terms"]) ));
					 $FINDER = 0;
					 if(sizeof($result) != 0) {
					   $FINDER = 1;
					 } else {
				 	   $query = "SELECT POR_DESCRIPTOR, US_DESCRIPTOR FROM por_mesh WHERE POR_DESCRIPTOR like '%".addslashes($_POST["terms"])."%' GROUP BY US_DESCRIPTOR";
	  		 		 $result = mysqli_query($db_object,$query); //or die("Query failed : ");
				 		 if (mysqli_affected_rows($db_object) == 0) {
							   $result=$find->topP(addslashes($_POST["terms"]));
							 	 if (mysqli_affected_rows($db_object)==0) {
								   
							  	 echo "Desculpe, mas a palavra ou frase usada nao se encontra na nossa base de dados. <br>";
									 echo "<p><form action=search.php?from=por&com=$com method=POST>".$_POST["terms"]." = <input value=\"".$_POST["terms"]."\" size=25 name=terms> ";
									 echo "<input type=submit value=Procure>";
									 echo "<input type = \"hidden\" name=\"Oterm\" value=\"".$_POST["terms"]."\">";
									 echo "</form><p>";
									 //echo "<p>".$_POST["terms"]." <a href=search.php?from=por&term=".urlencode($_POST["terms"]).">Procure</a> ";
									
									 echo "Embora esta palavra ou frase não se encontre na nossa base de dados, pode tentar pesquisar por termos semelhantes em Inglês. ";
									 echo "(Although it's not in our database, you may modify this search by adding or deleting English terms.) <hr>";
									 echo "<p><a href=".$_SERVER['PHP_SELF'].">Volte para a página de Procura</a>";
									 //die();							
                   goto end;
							 	 }			
				 		 }
					 }
				 }
				 // unset($find);
				 if ((strlen(trim($_POST["terms"]))<=3) && (mysqli_affected_rows($db_object) > 100) ) {
				    echo "Por favor, entre os seus termos de busca!!";
						echo "<p><a href=".$_SERVER['PHP_SELF'].">Volte para a página de anterior</a>";
						die();						
				 }
				 
				 echo "Você significa?<p>";
				 echo "<font color=\"#3333CC\">(You may modify this search by adding or deleting English terms):</font><p>";
				 if ($FINDER == 1) {
				   $term = implode(" ", $result);		 
					 echo "<form enctype=\"application/x-www-form-urlencoded\" name=\"query\" action=\"search.php?from=por&com=$com\" method=\"POST\">";	
					 $temp = $find->clean_por($_POST["terms"]);
					 echo "<li>".$temp;
					 echo "&nbsp;=&nbsp;<input name=\"terms\" size=\"25\" value=\"".$term."\">";
					 echo "<input type = \"hidden\" name=\"Oterm\" value=\"".$temp."\">";
					 echo "&nbsp;<input type=\"submit\" value=\"Procure\" name=\"B1\">";
					 pass_lang_out();
					 echo "</form>";
				 }
				 else {
				   while ($line= mysqli_fetch_array($result)) {	
				 	   $term = $line["US_DESCRIPTOR"];
				 	 //$term = str_replace(',', '+',$term);
					 	 $term1 = $term;
						 $term = str_replace(' ', '+',$term);
						 $temp = $line["POR_DESCRIPTOR"];
						 echo "<form enctype=\"application/x-www-form-urlencoded\" name=\"query\" action=\"search.php?from=por&com=$com\" method=\"POST\">";
						 //echo "<br>".$_POST["terms"]."<br>";
					 	 echo "<li>".str_replace(strtolower($_POST["terms"]), "<B style=\"color:black;background-color:#ffff66\">".strtolower($_POST["terms"])."</B>", strtolower($line["POR_DESCRIPTOR"]));
						 echo "&nbsp;=&nbsp;<input name=\"terms\" size=\"25\" value=\"".$term1."\">";
						 echo "<input type = \"hidden\" name=\"Oterm\" value=\"".$temp."\">";
					 	 echo "&nbsp;<input type=\"submit\" value=\"Procure\" name=\"B1\">";
						 pass_lang_out();
						 echo "</form>";
				   }
				 }				 
				 unset($find);
			}
      end:
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
