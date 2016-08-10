<?php 
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}
function random_string($length){
	$key	=	'';
	$keys	=	array_merge(range(0,9), range('a' , 'z'));
	for($i=0 ; $i<$length ; $i++){
		$key	.= $keys[array_rand($keys)];
	}
	return $key;
}
function prnt($postArray,$die=true) {
	echo "<pre>",print_r($postArray),"</pre>";
	if($die)
		die;
} 

?>
