window.addEventListener("load", function(){	
	var currenturl = document.location.href;
	currenturl = currenturl.replace(/\/$/, "");
	var currentref = currenturl.substring (currenturl.lastIndexOf( "=" )+1 );
	spreadsheet.currentref = currentref;

	function init(){
		console.log("init");
		var delay = setTimeout(function(){ 
			clearTimeout(delay);
			spreadsheet.initData();
		}, 100);
			
	}

	init();
});
