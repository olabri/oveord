<?php

	$oveord[]="skade";
	$oveord[]="venn";
  $oveord[]="bror";
  $oveord[]="Jeg kan spille piano";
	$oveord[]="I can't speak french";

	file_put_contents('ord.json',json_encode($oveord));
?>
