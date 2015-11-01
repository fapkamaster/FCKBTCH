<?php


function encode($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string,$i,1));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
    return $hash;
}

function decode($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function sec2hms($sec, $padHours = false){
	$hms = "";
	$hours = intval(intval($sec) / 3600); 
	$hms .= ($padHours) 
		  ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
		  : $hours. ":";
	$minutes = intval(($sec / 60) % 60); 
	$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
	$seconds = intval($sec % 60); 
	$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	return $hms;
}

function difference($time){
	$diff = time() - $time;
	return sec2hms($diff);
}

function shorten($in){
	$max = 150;
	if(strlen($in) > $max)
		return substr($in, 0, $max)." [...]";
	else
		return $in;
}

function code2char($number, $art){
	$n = (int)$number;
	if($art == "key"){
		switch($n){
			case 8:
				return " &#8592 ";
				break;
			case 9:
				return " [tab] ";
				break;
			case 13:
				return " [enter] ";
				break;
			case 27:
				return " [esc] "; 
				break;
			case 46:
				return " [entf] ";
				break;
			case 37:
				return " [<] ";
				break;
			case 38:
				return " [^] ";
				break;
			case 39:
				return " [>] ";
				break;
			case 40:
				return " [v] ";
				break;
			case 112:
				return " [F1] ";
				break;
			case 113:
				return " [F2] ";
				break;
			case 114:
				return " [F3] ";
				break;
			case 115:
				return " [F4] ";
				break;
			case 116:
				return " [F5] ";
				break;
			case 117:
				return " [F6] ";
				break;
			case 118:
				return " [F7] ";
				break;
			case 119:
				return " [F8] ";
				break;
			case 120:
				return " [F9] ";
				break;
			case 121:
				return " [F10] ";
				break;
			case 122:
				return " [F11] ";
				break;
			case 123:
				return " [F12] ";
				break;
			case 173:
				return " [&#9835; mute] ";
				break;
			case 174:
				return " [&#9835; --] ";
				break;
			case 175:
				return " [&#9835; ++] ";
				break;
			default:
				return chr($n);
				break;
		}
	}
	else if($art = "char"){
		return chr($n);
	}
} 
?>