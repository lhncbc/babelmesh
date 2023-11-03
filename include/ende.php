<?php
function my_encr($input) {
 $key1 = 301;
 $key2 = 435;
 $output = $input*$key1 + $key2;
 $output = rand(1000,9999).$output.rand(1000,9999);
 $output = base_convert($output, 10, 36);
 return $output;
}
 
 function my_decr($input) {
 $key1 = 301;
 $key2 = 435;
 $output = base_convert($input, 36, 10);
 $output = substr($output,4,strlen($output)-8);
 $output = ($output-$key2) / $key1;
 return $output;
}

function my_encr2($input) {
  $key1 = 3;
	$key2 = 435;
  $input_len = strlen($input);
	for ($i=0; $i<$input_len; $i++) {
	  $temp ='';
	  $temp = base_convert(ord($input{$i})*$key1+$key2, 10, 36);
		switch (strlen($temp)) {		
			case 1:
			  $temp  = "0".$temp;
				break;
			default:
			  break;
		}
		$output .= $temp;
	}
  $temp1 = base_convert(rand(36*36*36, 36*36*36*36-1), 10, 36);
	$temp2 = base_convert(rand(36*36*36, 36*36*36*36-1), 10, 36);
	$output = $temp1.$output.$temp2;
	return $output;
}
 
function my_decr2($input) {
  $key1 = 3;
	$key2 = 435;
  $out = substr($input,4,strlen($input)-8);
  $output = '';
  $len = ceil (strlen($out)/2);
  for ($i=0; $i< $len; $i++) {
    $index = $i*2;
	  $onechar = $out{$index}.$out{$index+1};
	  $onechar = (base_convert($onechar, 36, 10)-$key2)/$key1;
    $output .= chr($onechar);
  }

  return $output;
}

function rf_en ($input) {
  $key1 = 1;
	$key2 = 0;
	$output = '';
  $input_len = strlen($input);
	for ($i=0; $i<$input_len; $i++) {
	  $temp ='';
		$key2 = ($i+1)%95;
		
		if ( (ord($input{$i})>126) || (ord($input{$i})<32) ) {
		  //$input{$i} = ' ';
		}
	  $temp = (ord($input{$i})-32)*$key1+$key2;
		if ($temp >= 95) {
		  $temp = $temp - 95;
		}
		$temp = chr($temp+32);
		if ( (ord($input{$i})>126) || (ord($input{$i})<32) ) {
		  $temp = $input{$i};
		}
		$output .= $temp;
	}
	
	return $output;
}

function rf_de($input) {
	$key1 = 1;
	$key2 = 0;
  $out = $input;
  $output = '';
  $len =strlen($out);
  for ($i=0; $i< $len; $i++) {
	  $onechar = '';
		$key2 = ($i+1)%95;
	  $onechar = ord($out{$i})-32;
		$onechar = ($onechar-$key2)/$key1;
		if ( $onechar< 0 ) {
		  $onechar = $onechar + 95; 
		}
		$onechar = $onechar + 32;
		if (($onechar >= 32) && ($onechar <= 126)) {
		  $onechar = chr($onechar);
		}
		else {
		  $onechar = $out{$i};
		}
		if ( (ord($out{$i})>126) || (ord($out{$i})<32) ) {
		  $onechar = $out{$i};
		}
    $output .= $onechar;
  }

  return $output;
}

function hsqr_en ($input, $pswd) {
  $key1 = 1;
	$key2 = 0;
	$key3 = substr($pswd, 0, strlen($pswd)-2);
	$key4 = substr($pswd, strlen($pswd)-2, 2);
	$new_key = $key3%$key4;
	
	if (strlen($new_key) == 1) {
	  $insert_key = '0'.$new_key;
	}
	else {
	  $insert_key = $new_key;
	}
	
	$output = '';
	$input = "NLM!".$insert_key.$input;
	
  $input_len = strlen($input);
	for ($i=0; $i<$input_len; $i++) {
	  $temp ='';
		$key2 = ($i+1 + $new_key)%95;
		
		if ( (ord($input{$i})>126) || (ord($input{$i})<32) ) {
		  //$input{$i} = ' ';
		}
	  $temp = (ord($input{$i})-32)*$key1+$key2;
		if ($temp >= 95) {
		  $temp = $temp - 95;
		}
		$temp = chr($temp+32);
		if ( (ord($input{$i})>126) || (ord($input{$i})<32) ) {
		  $temp = $input{$i};
		}
		$output .= $temp;
	}
	
	return $output;
}


function hsqr_de($input, $pswd) {
	$key1 = 1;
	$key2 = 0;
	$key3 = substr($pswd, 0, strlen($pswd)-2);
	$key4 = substr($pswd, strlen($pswd)-2, 2);
	$new_key = $key3%$key4;
	
  $out = $input;
	
  $output = '';
  $len =strlen($out);
  for ($i=0; $i< $len; $i++) {
	  $onechar = '';
		$key2 = ($i+1 + $new_key)%95;
	  $onechar = ord($out{$i})-32;
		
		$onechar = ($onechar-$key2)/$key1;
		if ( $onechar< 0 ) {
		  $onechar = $onechar + 95; 
		}
		$onechar = $onechar + 32;
		if (($onechar >= 32) && ($onechar <= 126)) {
		  $onechar = chr($onechar);
		}
		else {
		  $onechar = $out{$i};
		}
		if ( (ord($out{$i})>126) || (ord($out{$i})<32) ) {
		  $onechar = $out{$i};
		}
    $output .= $onechar;
  }

  return $output;
}

function twitter_url_en($input) {
  $key1 = 2;
	$key2 = 55;
  $input_len = strlen($input);
	for ($i=0; $i<$input_len; $i++) {
	  $temp ='';
	  $temp = base_convert(ord($input{$i})*$key1+$key2, 10, 36);
		switch (strlen($temp)) {		
			case 1:
			  $temp  = "0".$temp;
				break;
			default:
			  break;
		}
		$output .= $temp;
	}
	$output = $output;
	return $output;
}
 
function twitter_url_de($input) {
  $key1 = 2;
	$key2 = 55;
  $out = $input;
  $output = '';
  $len = ceil (strlen($out)/2);
  for ($i=0; $i< $len; $i++) {
    $index = $i*2;
	  $onechar = $out{$index}.$out{$index+1};
	  $onechar = (base_convert($onechar, 36, 10)-$key2)/$key1;
    $output .= chr($onechar);
  }

  return $output;
}
?>
