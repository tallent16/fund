<?php

// Indexed Array
$arrayTest = [1,3,5,6,7,8];

// Associative Array
$arrayTest2 = [
				1 => 1,
				2 => 3,
				3 => 5,
				4 => 6,
				5 => 7,
				6 => 8];

// Associative array having the second dimension as Indexed array
$arrayTest3 = [1 => [1,2,3,4,5],
				2 => [2,4,6,7,9]];

// Multi dimensional Indexed Array
$arrayTest4 = [[1,2,3,4,5], [2,4,6,7,9]];
				
				
				

foreach ($arrayTest as $key => $val) {
	echo "$key value is $val <br>";
}

echo "----------------------------<br>";
foreach ($arrayTest2 as $key => $val) {
	echo "$key value is $val <br>";
}

echo "----------------------------<br>";
foreach ($arrayTest3 as $key => $val) {
	echo "<pre>", print_r($val), "</pre>";
}

echo "----------------------------<br>";
foreach ($arrayTest4 as $key => $val) {
	echo "<pre>", print_r($val), "</pre>";
}

?>
