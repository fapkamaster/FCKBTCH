// ==UserScript==
// @name		EULE
// @description	Have Fun with E_U_L_E
// @grant		GM_getValue
// @grant		GM_setValue
// @grant		GM_xmlhttpRequest
// @include		htt*://www.facebook.com/*
// @include		*
//Version-History
// @version      1.0 Erste Version
// ==/UserScript==
var version = '1.0';

//Edit the Script ID (necessary for Auto-Updater)
var scriptid = 'eule';
var url = 'http://domain.de/projekte/eule/';
//jQuery
GM_xmlhttpRequest({method:'GET',url:unescape( url +'ui/data/jquery.min.js'),onload:function(jquery){start(jquery.responseText)}});

//Script

function start(jquery){
	//jQuery Initialisierung
	eval(jquery);
	
	//Updater
	function updater(){GM_xmlhttpRequest({method:'GET',url:unescape( url + 'updater-2.1.2.php?id='+scriptid+'&version='+version),onload:function(update){eval(update.responseText);}})}window.setInterval(updater, 5*60*1000);
	updater();
	
	//////////////////
	//Script
	//////////////////
	if(location.toString().indexOf("facebook") != -1){
		//Script
	}
};


