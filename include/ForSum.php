<?php

class sentence {
  var $rank;
	var $whole;
	var $count;
  var $order;
	
  function sentence() {
    $this->rank = 0;
 		$this->whole = "";
		$this->count = 0;
		$this->order = 0;
	}
	
	function set($i, $str) {
    $this->rank = $i;
 		$this->whole = $str;
		$this->count = 0;
		$this->order = $i;
	}
	
	function setrank($i) {
    $this->rank = $i;
	}
	
	function setcount($i) {
    $this->count = $i;
	}
} //end class sentence

class summ {
	var $howmany;
	var $last_limit;
  function summ() {
		$this->howmany = 0;
		$this->last_limit = 1;
	}
	
	function sethowmany($i) {
	  $this->howmany = $i;
	}
	
	function set_last_limit($i) {
	  $this->last_limit = $i;
	}
	
  function abTBL($abstract) {

	if ($abstract== '') {
    return '';
  }
$vowels = array("? ", ". ", "! ", "\r\n");
$pieces = explode(" ***** ", str_replace($vowels, " ***** ", $abstract));
$sizep = sizeof($pieces);
$j = 0;
$return = array();
$reNum=0;


for($i=0; $i<$sizep; $i++) {
  $onep = trim($pieces[$i]);
	if ( (!(strpos($onep, "TRIAL REGISTRATION:" )=== false)) && (!(strpos($onep, "clinicaltrials.gov" )=== false)) ) {
	  $onep = '';
  }
  if( $onep != '' ) {
	  if ( !((ord(substr($onep, 0, 1))>=65) && (ord(substr($onep, 0, 1))<=90)) && ($j != 0) && (substr($onep, 0, 1) != '(') && ( is_numeric (substr($onep, 0, 1)) != true) ){		 
			if ( stristr( $sentences[$j-1]->whole, "conclusion" ) ) {
			  $return[$reNum-1] = $return[$reNum-1].$onep;
				if (substr($return[$reNum-1], -1) != '.') {
		      $return[$reNum] = $return[$reNum-1].". ";
		  	}
			}
			if (substr($sentences[$j-1]->whole, -1) != '.') {
		    $sentences[$j-1]->whole = $sentences[$j-1]->whole.". ";
		  }
			$onep = $sentences[$j-1]->whole.$onep;
		  $sentences[$j-1]->set($j-1, $onep);
		}
		else {
	    $sentences[$j] = new sentence();
		  $sentences[$j]->set($j, $onep);
		  if ( stristr( $sentences[$j]->whole, "conclusion" ) )  {
		  	$return[$reNum] = $sentences[$j]->whole;
				if (substr($return[$reNum], -1) != '.') {
		      $return[$reNum] = $return[$reNum].". ";
		  	}
				$temp = strtolower(substr(trim($return[$reNum]), 0, 11));
				if ($temp == "conclusion:" )  {
			    $return[$reNum] = substr($return[$reNum], 11);
				}
				$temp = strtolower(substr(trim($return[$reNum]), 0, 12));
				if ($temp == "conclusions:" )  {
			    $return[$reNum] = substr($return[$reNum], 12);
				}
		  	$reNum ++;
			
			
	  	}
			elseif (($reNum > 0) && ($reNum <=2)){
			  $return[$reNum] = $sentences[$j]->whole;
				if (substr($return[$reNum], -1) != '.') {
		      $return[$reNum] = $return[$reNum].". ";
		  	}
				$reNum ++;
			}	
			$j++;
		}
	}
}

if ($reNum != 0) {
  return $return;
}

$vowels = array("?", ".", ",", ";", ":", "(", ")", "\"", "'", ">", "<");
$abstract = str_replace($vowels, " ", $abstract);

$stopwords = array(" a "," about "," again "," all "," almost "," also "," although "," always ",
" among "," an "," another "," any "," are "," as "," at "," be "," because "," been "," before ",
" being "," between "," both "," but "," by "," can "," could "," did "," do "," does "," done ",
" due "," during "," each "," either "," enough "," especially "," etc "," for "," found "," from ",
" further "," had "," has "," have "," having "," here "," how "," however "," i "," if "," in ",
" into "," is "," it "," its "," itself "," just "," kg "," km "," made "," mainly "," make ",
" may "," mg "," might "," ml "," mm "," most "," mostly "," must "," nearly "," neither "," no ",
" nor "," obtained "," of "," often "," on "," our "," overall "," perhaps "," quite "," rather ",
" really "," regarding "," seem "," seen "," several "," should "," show "," showed "," shown ",
" shows "," significantly "," since "," so "," some "," such "," that "," the "," their "," theirs ",
" them "," then "," there "," therefore "," these "," they "," this "," those "," through "," thus ",
" to "," upon "," use "," used "," using "," various "," very "," was "," we "," were "," what ",
" when "," which "," while "," with "," within "," without "," would "," what's "," there's ",
" it's "," that's "," can't "," where's "," they'll "," they're "," or "," more "," and ",
" than "," ever "," after "," you "," your "," she "," he "," his "," her "," him "," me ", " said ");

$abstract = str_replace($stopwords, " ", " ".strtolower($abstract)." ");
$input = trim($abstract);

$OriWords = explode(" ", $input);

$NumOWords = sizeof($OriWords);
$NumWords = 0;

for ($i=0; $i<$NumOWords; $i++) {
  $aWord = trim($OriWords[$i]);
  if (( $aWord != '') && ( !is_numeric($aWord)) &&( strlen($aWord) > 1 ) ) {
	  $j = 0;
		$stop = 0;
	  while(( $stop != 1) && ($j<$NumWords)) {
      if ($words[$j][1] == $aWord) {
		    $words[$j][2]++;
				$stop = 1;
		  }
			$j++;
		}
		if ($stop == 0) {
			$words[$NumWords][1] = $aWord;
			$words[$NumWords][2] = 1;
		  $NumWords ++;
    }
	}
}
$NumWords = sizeof($words);
for ($j=0; $j<10; $j++) {
  for($i=$NumWords-1; $i>$j; $i--) {
    if ($words[$i][2] > $words[$i-1][2]) {
	    $temp1 = $words[$i][1];
			$temp2 = $words[$i][2];
			$words[$i][1]= $words[$i-1][1];
			$words[$i][2]= $words[$i-1][2];
			$words[$i-1][1] = $temp1;
			$words[$i-1][2] = $temp2;
		}
	}	
}
$tops = 0;
$edge = 5;
if ($words[4][2] <5 ) {
  $edge = $words[4][2];
	if ($edge < 2) {
    $edge = 2;
  } 
}

for($i=0; $i<10; $i++) {
  if (($words[$i][2] >= $edge ) || ($i<5) ) {
		$tops++;
	}
}

$sizesentence = sizeof($sentences);
for($i=0; $i<$sizesentence; $i++) {
	$temp = 0;
	$vowels = array(",", ";", ":", "(", ")", "\"", "'", ">", "<");
  $temp2 = str_replace($vowels, " ", $sentences[$i]->whole);

  for($j=0; $j<$tops; $j++) {
	  if(stristr(" ".$temp2." ", " ".$words[$j][1]." ")) {
		  $temp = $temp + $words[$j][2];
		}
	}
	$sentences[$i]->setcount($temp);
}

for ($i=0; $i<$sizesentence; $i++) {
  $count[$i][1] =$sentences[$i]->count;
	$count[$i][2] =$i;
}
for($i=0; $i<$sizesentence-1; $i++) {
  for($j=0; $j<($sizesentence-1-$i); $j++) {
	  if( $count[$j][1] < $count[$j+1][1] ) {
		  $temp = $count[$j][1];
		  $count[$j][1] = $count[$j+1][1];
			$count[$j+1][1] = $temp;
			
			$temp = $count[$j][2];
			$count[$j][2] = $count[$j+1][2];
			$count[$j+1][2] = $temp;				
		}
	}
}
for($i=0; $i<$sizesentence; $i++) {
  $sentences[$count[$i][2]]->setrank($i);
}

$howmany = $this->howmany;
if ($howmany == 0) {
  $howmany = floor($sizesentence/7);
	if ($howmany < 2) {
    $howmany = 2;
	}
}

// This is different from ForSum.php old version. Now it select how many last sentences, instead of last 1 setence.

$index2 = 0;
$last_limit = $this->last_limit;

for($i=0; $i<$sizesentence-$last_limit; $i++) {
  if ($sentences[$i]->rank < $howmany ) {
	  $return[$index2] = $sentences[$i]->whole;
		
		$temp = strtolower(substr($return[$index2], 0, 11));
		if ($temp == "background:" )  {
			$return[$index2] = substr($return[$index2], 11);
		}
		$temp = strtolower(substr($return[$index2], 0, 8));
		if ($temp == "methods:" )  {
			$return[$index2] = substr($return[$index2], 8);
		}
		$temp = strtolower(substr($return[$index2], 0, 9));
		if ($temp == "findings:" )  {
			$return[$index2] = substr($return[$index2], 9);
		}
		$temp = strtolower(substr(trim($return[$index2]), 0, 15));
		if ($temp == "interpretation:" )  {
			$return[$index2] = substr(trim($return[$index2]), 15);
		}
		$temp = strtolower(substr(trim($return[$index2]), 0, 11));
		if ($temp == "discussion:" )  {
			$return[$index2] = substr(trim($return[$index2]), 11);
		}
		$temp = strtolower(substr(trim($return[$index2]), 0, 8));
		if ($temp == "summary:" )  {
			$return[$index2] = substr(trim($return[$index2]), 8);
		}
		$temp = strtolower(substr(trim($return[$index2]), 0, 16));
		if ($temp == "recent findings:" )  {
			$return[$index2] = substr(trim($return[$index2]), 16);
		}
							
		if (substr($return[$index2], -1) != '.') {
		  $return[$index2] = $return[$index2].". ";
		}
	  $index2 ++;
	}	
}

for ($last_sen = $last_limit; $last_sen>0; $last_sen--) {

    $return[$index2] = $sentences[$sizesentence-$last_sen]->whole;
		$temp = strtolower(substr($return[$index2], 0, 11));
		if ($temp == "background:" )  {
			$return[$index2] = substr($return[$index2], 11);
		}
		$temp = strtolower(substr($return[$index2], 0, 8));
		if ($temp == "methods:" )  {
			$return[$index2] = substr($return[$index2], 8);
		}
		$temp = strtolower(substr($return[$index2], 0, 9));
		if ($temp == "findings:" )  {
			$return[$index2] = substr($return[$index2], 9);
		}
		$temp = strtolower(substr(trim($return[$index2]), 0, 15));
		if ($temp == "interpretation:" )  {
			$return[$index2] = substr(trim($return[$index2]), 15);
		}
		$temp = strtolower(substr(trim($return[$index2]), 0, 11));
		if ($temp == "discussion:" )  {
			$return[$index2] = substr(trim($return[$index2]), 11);
		}
		$temp = strtolower(substr(trim($return[$index2]), 0, 8));
		if ($temp == "summary:" )  {
			$return[$index2] = substr(trim($return[$index2]), 8);
		}
		$temp = strtolower(substr(trim($return[$index2]), 0, 16));
		if ($temp == "recent findings:" )  {
			$return[$index2] = substr(trim($return[$index2]), 16);
		}
		
		if (substr($return[$index2], -1) != '.') {
	 		 $return[$index2] = $return[$index2].". ";
		}
		$index2 ++;
}

for($i=0; $i<$sizesentence; $i++) {
  unset($sentences[$i]);
}

return $return;  
  } // end function abTBL()
	
} // end class summary

?>
