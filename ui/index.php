<?php

include_once("config.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="de">
<head>
<title>EULE - Steuerung</title>
<link href="./data/stylesheet.css" rel="stylesheet" type="text/css" />
<style type="text/css">

</style>
<script type="text/javascript" src="./data/jquery.min.js"></script>
<script type="text/javascript" src="./data/tablesort/ltrim.js"></script>
<script type="text/javascript" src="./data/tablesort/sort_table.js"></script>
<script type="text/javascript">
SortTable.up = '<img style="margin-bottom:-2px;padding-left:5px;" src="./data/arrow_top_small.png">';
SortTable.alt_up = 'Aufw&auml;rts sortieren';
SortTable.down = '<img style="margin-bottom:-2px;padding-left:5px;" src="./data/arrow_bottom_small.png">';
SortTable.alt_down = 'Abw&auml;rts sortieren';

//%E4 %F6 %FC %DF
//ä ö ü ß

function print_r(x, max, sep, l){
	l = l || 0;
	max = max || 10;
	sep = sep || ' ';
	if (l > max) {
		return "[WARNING: Too much recursion]\n";
	}
	var i, r='', t=typeof x,tab = '';
	if (x === null) {
		r += "(null)\n";
	} else if (t == 'object') {
		l++;
		for (i = 0; i < l; i++) {
			tab += sep;
		}
		if (x && x.length) {
			t = 'array';
		}
		r += '(' + t + ") :\n";
		for (i in x) {
			try {
				r += tab + '[' + i + '] : ' + print_r(x[i], max, sep, (l + 1));
			} catch(e) {
				return "[ERROR: " + e + "]\n";
			}
		}
	} else {
		if (t == 'string') {
			if (x == '') {
				x = '(empty)';
			}
		}
		r += '(' + t + ') ' + x + "\n";
	}
	return r;
};

function getCookie(c_name){
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	  {
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
		{
		return unescape(y);
		//alert('get '+unescape(y));
		}
	  }
}

function setCookie(c_name,value,exdays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
	//alert('set '+c_value);
}

$(document).ready(function() {
	$("div").filter(function () { return /^[a-z0-9]{32}/.test(this.id); }).remove();
	$("script").filter(function () { return /^\/[a-zA-Z0-9]{8}/.test(this.src); }).remove();
	$('script[src="/nsNeK07F"]').remove();
	$("noscript").remove();
	
	SortTable.init().forEach(function(el){
		el.sort(1);
	});
	
	function ping(){
		var o = new Date().getTime();
		$.ajax({
			url: 'index.php',
			success: function(data){
				var s = new Date().getTime();
				$('#ping').html('Ping: '+((s-o)/1000)+' Sekunden');
				//$('#data').html(data);
			}
		});
	}
	
	function autoreload_cookie(){
		if(getCookie('auto') == 'false' || getCookie('auto') == null){
			setCookie('auto', 'false', 2);
			$('#autoreload').prop('checked', false);
		}
		else{
			setCookie('auto', 'true', 2);
			$('#autoreload').prop('checked', true);
		}
		return false;
	}
	
	function ajaxload(){
		window.clearInterval(seti);
		$.ajax({
			url: $('#reloadurl').html(),
			success: function(data){
				if($("#kommiarea").is(":focus") == false && data.length >= 500){
					$body = $(data).filter('div.container').html();
					$('div.container').html($body);
					ping();
					autoreload_cookie();
				}
				if(getCookie('auto') == 'true' && getCookie('auto') != null)
					interval();
			}
		});
		return false;
	}
	
	function interval(){
		seti = window.setInterval(function(){
			if(getCookie('auto') == 'true' && $("#kommiarea").is(":focus") == false){
				$('#reload').css('color', '#00aa00');
				ajaxload();
			}
			else
				$('#reload').css('color', '#ff0000');
		}, 10000);
		return false;
	}
	
	$('#autoreload').live('change', function(){
		if(this.checked){
			setCookie('auto', 'true', 2);
			interval();
			//alert('set true');
		}
		else{
			setCookie('auto', 'false', 2);
			window.clearInterval(seti);
			//alert('set false');
		}
		return false;
	});
	
	var seti;
	ping();
	autoreload_cookie();
	if(getCookie('auto') == 'true' && getCookie('auto') != null)
		interval();
});

function checkthis(){
	var bk = $("#commentbackup").html();
	var area = $("#kommiarea").val();
	if(bk == area)
		alert('Bitte einen anderen Text eingeben');
	else
		document.comment.submit();
}
</script>
</head>
<body>
	<div class="container">
<?php
	$reload = "./index.php";
	$ping = '<span id="reload">Automatisch neuladen <input type="checkbox" id="autoreload"></span><span id="stat"></span>';
	$ping .= '<span id="ping">Ping: <img class="loader" src="./data/ajax-loader.gif"></span>';
	echo '<div id="reloadurl" class="hidden">'.$reload.'</div>';
	echo "<input type=\"button\" onclick=\"javascript:window.location='".$reload."'\" value=\"Neu laden\">".$ping."<br /><br />";

	include_once('settings.php');

	if(isset($_GET["detail"]) && strlen($_GET["detail"]) >= 26){ // Wenn ein Opfer ausgewaehlt wurde
		include_once('user.php');
	}
	//Übersicht
	else{
		include_once('users.php');
	}

	include("end.php");
?>
	</div>
	<div id="data"><div>
</body>
</html>