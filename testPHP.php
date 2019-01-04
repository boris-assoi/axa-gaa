<?php
	$Vv = 10000000;
	$An = 18;
	
	for($i = 1; $i <= $An; $i++){
		if ($i == 1) {
			$Vv = ceil($Vv - ($Vv * 25 / 100));
		} elseif ($i == 2) {
			$Vv = ceil($Vv - ($Vv * 20 / 100));
		} elseif ($i > 2 && $i <= 7) {
			$Vv = ceil($Vv - ($Vv * 15 / 100));
		} elseif ($i > 7 && $i <= 19) {
			$Vv = ceil($Vv - ($Vv * 10 / 100));
		}
	}

	if ($Vv < 800000) {
		$Vv = 800000;
	}
	
	echo $Vv;
?>