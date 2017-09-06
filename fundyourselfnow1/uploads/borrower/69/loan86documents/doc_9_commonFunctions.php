<?php
	function test_input($info) {
	  $info = trim($info);
	  $info = stripslashes($info);
	  $info = htmlspecialchars($info);
	  return $info;
	}
	function prnt($postArray,$die=true) {
		echo "<pre>",print_r($postArray),"</pre>";	
		if($die)
		die;
	}
	function validateDate($date){
	    $d = DateTime::createFromFormat('Y-m-d', $date);
	    return $d && $d->format('Y-m-d') == $date;
	}
	function random_string($length){
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));
		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}
		return $key;
	}
	function getAllEmployee($conn) {
	$sql = 'SELECT * FROM new_employee';
	$retval = mysql_query($sql, $conn );
	return $retval;
	}
?>
