<?php

/**
 * @package     kjønnsopinion
 * @author      Olav Bringedal (olav@jaggu.org)
 * @copyright   (C) 2019. All rights reserved.
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html
 * @link        http://jaggu.org/gloser
 */

$ord=json_decode(file_get_contents("ord.json"),true);

require_once("util.php");
//print_r($oveord);
session_start();

print ("<html style=text-align:center;background-color:#ccc><meta charset='utf-8'><div style=text-align:center;background-color:#ccc>");

if (!isset($_REQUEST['gjeldende_kjonn'])) {
  $i=0;
  do {
    $gjeldende_ord=rand(0,count($ord)-1);
    if ($i++>=count($ord)) {
      $gjeldende_ord=666;  //magisk tall som nedtemmer at nå er vi ferdige
      break;
    }

  } while ($_SESSION["spurte"][$gjeldende_ord] == true );
  $_SESSION["spurte"][$gjeldende_ord]=true;

  if ($gjeldende_ord==666) {
    print (" ($gjeldende_ord) Alle ord er bestemt!");
    die();



  } else {
    $text=" ($gjeldende_ord) Bestem kjønn: <br><br>". $ord[$gjeldende_ord]. " spurte: ". print_r ($_SESSION["spurte"]);
  }


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
  $sql = new Db("ord.sqlite"); // flytt denne til en annen katalog om du har den kjær!
  $sql->connect();

  print ("setter $gjeldende_ord til $gjeldende_kjonn");
  $sqlquery = "INSERT INTO ord (ord, kjonn) values ('$gjeldende_ord', '$gjeldende_kjonn')";
  $query = $sql->query($sqlquery);

}
