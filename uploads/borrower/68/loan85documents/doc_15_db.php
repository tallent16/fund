
<html>
	<body>
		<?php
			$saleArray = $_REQUEST['sales'];
			$nameArray		= $_REQUEST['name'];
	//echo "<pre>", print_r($nameArray), "</pre>";
	//echo "<pre>", print_r($saleArray), "</pre>";
				echo "<table>";
				echo "<th>Salesman Name</th>";
				echo "<th>Total Sales</th>";
				echo "<th>Highest Sales</th>";
				echo "<th>Average Sales</th>";
				echo "<tr>";
				for($i=0 ; $i<count($nameArray) ; $i++){
					echo "<td>" . $nameArray[$i] . "</td>";
					echo "<td>" . totalSales($saleArray[$i]) . "</td>";				
					echo "<td>" . highest($saleArray[$i]) . "</td>";				
					echo "<td>" . getAvg($saleArray[$i]) . "</td></tr>";				
					}
				
				
					
					function totalSales($monthArray){
						$count=0;
						$sum=0;
							foreach($monthArray as $saleNumber){
								$count++;
								$sum=$sum+$saleNumber;
							}
							return $sum;
					}
			
				
					function highest($monthArray) {
					$highest=0;
						for($index = 1; $index <= count($monthArray); $index++) {
							if ($highest < $monthArray[$index]) {
								$highest = $monthArray[$index];
							}
						}
					return $highest;
					}
						function getAvg($monthArray) {
						$count = 0;
						$sum = 0;
							foreach ($monthArray as $saleNumber) {
								$count++;
								$sum = $sum + $saleNumber;
							}
						$avg = $sum / $count;
						return $avg;
						}
				echo "</table>";
		?>
	</body>
</html>

