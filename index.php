<?php
$oveord=json_decode(file_get_contents("oveord.json"),true);
$ovelse[0]="engelsk";
$ovelse[1]="norsk";

//print_r($oveord);
session_start();
$_SESSION['rett']+=0;
$_SESSION['feil']+=0;

print ("<html style=text-align:center;background-color:#ccc><meta charset='utf-8'><div style=text-align:center;background-color:#ccc>");

print ("<h2> Rette: {$_SESSION['rett']} feil: {$_SESSION['feil']}</h2>");
if (!isset($_REQUEST['oveord'])) {

	$gjeldende_oveord=rand(1,count($oveord));
	if (array_key_exists("url", $oveord[$gjeldende_oveord])) {
		$type="url";
		$text="Norsk øveord<br><br> <img src={$oveord[$gjeldende_oveord][$type]}>";
		
	} else {

		$type=rand(0,1);
		$spraak=$ovelse[$type];
		$text="Oversett glose fra $spraak: <br><br>". $oveord[$gjeldende_oveord][$spraak];
	}
	//print_r($oveord[$gjeldende_oveord]);
	//print_r($text);
	
	print ("<br><h2>$text </h2><br><br><br>
		<form><input type=hidden name=type value={$type}>
		<input name=gjeldende type=hidden value=$gjeldende_oveord>
		<input type=text name=oveord size=90 autocomplete=off autofocus style=font-size:18px;>
		<input type=submit value='sjekk'></form>");
} else {
	$gjeldende_oveord=strtolower($_REQUEST['gjeldende']);
	$type=($_REQUEST['type']+1)%2;
	$input_oveord=strtolower($_REQUEST['oveord']);
	
	if ($input_oveord==strtolower($oveord[$gjeldende_oveord][$ovelse[$type]])) {
		print ("<H1>RETT!!!</H1><br><a href=.>NESTE</a>");
		$_SESSION['rett']++;
	} else {
		$resultat=levenshtein($oveord[$gjeldende_oveord][$ovelse[$type]], $input_oveord);
		print ("<h1>Nesten riktig! $resultat feil tegn<br><h2>Du hadde: <br>$input_oveord</h2><br><h2>Riktig er: <br>{$oveord[$gjeldende_oveord][$ovelse[$type]]}</h2></h1><a href=.>Prøv igjen</a>");
		$_SESSION['feil']++;
	//	print_r($oveord[$gjeldende_oveord]);
	//	print_r($ovelse[$type]);
	}
}

