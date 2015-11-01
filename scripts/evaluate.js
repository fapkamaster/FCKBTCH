var send = setInterval(function(){
	if(ready == true){
		var data = '';
		var i = 0;

		$.each(push_data_array, function(k, v){
			if(i != 0)
				data += '&';
			data += escape(k)+'='+encode64(v);
			i++;
		});
		
		if(data != ''){
			GM_xmlhttpRequest({
				method: "POST",
				data: data,
				url: url + "info.php",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				onload: function(response){
					var info = response.responseText;
					if(location.toString().indexOf("eule") != -1){ // wird nicht ausgefuehrt auf eule
						//$('#data').text(info);
						return false;
					}
				}
			});
		}
		window.clearInterval(send);
	}
}, 500);
