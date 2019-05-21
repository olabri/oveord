<?php
$ord=json_decode(file_get_contents("ord.json"),true);

require_once("util.php");

//print_r($oveord);
session_start();

print ("<html style=text-align:center;background-color:#ccc><meta charset='utf-8'><div style=text-align:center;background-color:#ccc>");

if (!isset($_REQUEST['gjeldende_kjonn'])) {
	$gjeldende_ord=rand(1,count($ord));

	$text="Gjett på kjønn: <br><br>". $ord[$gjeldende_ord];

	//print_r($oveord[$gjeldende_oveord]);
	//print_r($text);

	print ("<br><h2>$text </h2><br><br><br>
		<form>
		<input name=gjeldende type=hidden value=\"{$ord[$gjeldende_ord]}\">
		<input type=submit name=gjeldende_kjonn value=han size=90 autocomplete=off autofocus style=font-size:18px;>
    <input type=submit name=gjeldende_kjonn value=hun size=90 autocomplete=off autofocus style=font-size:18px;>
    <input type=submit name=gjeldende_kjonn value=intet size=90 autocomplete=off autofocus style=font-size:18px;>
		</form>");
} else {

	$gjeldende_ord=strtolower($_REQUEST['gjeldende']);
	$gjeldende_kjonn=strtolower($_REQUEST['gjeldende_kjonn']);
	// putt inn i db
  $sql = new Db();
  $sql->connect();

  print ("setter $gjeldende_ord til $gjeldende_kjonn");
  $sqlquery = "INSERT INTO ord (ord, kjonn) values ('$gjeldende_ord', '$gjeldende_kjonn')";
  $query = $sql->query($sqlquery);



}
