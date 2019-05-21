<?php
	$i=0;
	$oveord[++$i]['norsk']="skade";
	$oveord[$i]['engelsk']="hurt";
	
	$oveord[++$i]['norsk']="venn";
        $oveord[$i]['engelsk']="friend";

	$oveord[++$i]['norsk']="bror";
        $oveord[$i]['engelsk']="brother";

	$oveord[++$i]['norsk']="Jeg kan spille piano";
        $oveord[$i]['engelsk']="I can play the piano";

	$oveord[++$i]['engelsk']="I can't speak french";
        $oveord[$i]['norsk']="Jeg kan ikke snakke fransk";
	file_put_contents('oveord.json',json_encode($oveord));
?>
