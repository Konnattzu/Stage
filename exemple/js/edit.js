
window.addEventListener("load", function(){
	dispgrid = document.getElementsByClassName("dhx_grid_data")[0];
	savebtn = document.getElementById("savetable");
	
	var currenturl = document.location.href;
	currenturl = currenturl.replace(/\/$/, "");
	currentref = currenturl.substring (currenturl.lastIndexOf( "=" )+1 );
	
	var addbtn = document.querySelectorAll("[data-dhx-id = add]")[0];
	
	
	console.log(addbtn);
	
	init();
	
	if(typeof(savebtn) != 'undefined' && savebtn != null){
		savebtn.addEventListener("click", sendtable, false);
	}
	
	dispgrid.addEventListener("mousewheel", init, false);
	
	addbtn.addEventListener("click", function(){delay = setTimeout(function(){init();}, 100);}, false);
	
	
	
	function init(){
		console.log("init");
		let rows = document.getElementsByClassName("dhx_grid-row");
		let header = document.getElementsByClassName("dhx_grid-header-cell");
		let cells = Array();
		var cell;
		var cross = document.querySelectorAll(".remove-button");
		var rembtn = Array();
		
		for(var i=0; i<rows.length; i++){
			cells = rows[i].getElementsByClassName("dhx_grid-cell");
			for(var j=0; j<cells.length; j++){
				rows[i][j] = cells[j];
			}
		}
			
		for(var i=0; i<rows.length; i++){
			for(var j=0; j<cells.length; j++){
				rows[i][j].addEventListener("dblclick", edit, false);
			}
		}
		
		for(var i=0; i<cross.length;i++){
			rembtn[i] = cross[i].parentElement.parentElement;
			rembtn[i].addEventListener("click", remrow, false);
		}
		console.log(rembtn);
	}


	function edit(){
		cell = this;
		console.log(cell);
		colnb = cell.getAttribute("aria-colindex")-1;
		rownb = cell.parentElement.getAttribute("aria-rowindex")-1;
		rowid = grid.config.data[rownb][grid.config.columns[1].id];
		colname = grid.config.columns[colnb].id;
		colid = grid.config.columns[1].id;
		entry = grid.config.data[rownb][grid.config.columns[colnb].id];
		console.log("colid "+colid);
		console.log("rowid "+rowid);
		console.log("colname "+colname);
		console.log("celltext "+entry);
		console.log(cell);

		cell.addEventListener("keypress", handler, false);
		document.addEventListener("mousedown", handler, false);
		
		cell.removeEventListener("dblclick", edit, false);
	}
	
	function handler(){
		edited(event, cell);
	}
	
	function edited(event, cell){
		event.stopImmediatePropagation();
		e = event;
		if (e.key == "Enter"){
			console.log(e.target.parentElement);
			console.log(cell);
			delay = setTimeout(function(){senddata(e.path[1]);}, 1);
			cell.removeEventListener("keypress", handler, false);
			document.removeEventListener("mousedown", handler, false);
			cell.addEventListener("dblclick", edit, false);
		}else if(e.target.parentElement != cell){
			console.log(e.target.parentElement);
			console.log(cell);
			delay = setTimeout(function(){senddata(cell);}, 1);
			cell.removeEventListener("keypress", handler, false);
			document.removeEventListener("mousedown", handler, false);
			cell.addEventListener("dblclick", edit, false);
		}
	}
	
	function remrow(){
		rownb = event.target.parentElement.parentElement.parentElement.parentElement.getAttribute("aria-rowindex")-1;
		rowid = grid.config.data[rownb][grid.config.columns[1].id];
		colid = grid.config.columns[1].id;
		console.log(rowid);
		console.log(colid);
		var data = new FormData();
		graphable = false;
		data.append("row", rowid);
		data.append("idcolumn", colid);
		data.append("editplace", currentref);
		// for(i=0;i<config.series.length;i++){
			// if(config.series[i].value == colname){
				// graphable = true;
			// }
		// }
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				console.log(results);
				console.log(request.responseText);
				// grid.config.data[rownb][grid.config.columns[colnb].id] = results;
				// if(config.scales.left.max < results*1.2){
					// config.scales.left.max = results*1.2;
					// //window.location.reload();
				// }
				init();
			}
		}
		request.open("POST", "inc.php/parts/delete_data.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);
	}
	
	function senddata(el){
		clearTimeout(delay);
		// console.log(el.innerText);
		newtext = el.innerText;
		// console.log("newtext "+newtext);
		var data = new FormData();
		graphable = false;
		data.append("row", rowid);
		data.append("column", colname);
		data.append("idcolumn", colid);
		data.append("value", newtext);
		data.append("editplace", currentref);
		// for(i=0;i<config.series.length;i++){
			// if(config.series[i].value == colname){
				// graphable = true;
			// }
		// }
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				console.log(results);
				console.log(request.responseText);
				// grid.config.data[rownb][grid.config.columns[colnb].id] = results;
				// if(config.scales.left.max < results*1.2){
					// config.scales.left.max = results*1.2;
					// //window.location.reload();
				// }
				init();
			}
		}
		request.open("POST", "inc.php/parts/send_data.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);	
	}
	
	function sendtable(){
		//get all csv data (not displayed table data)
		console.log(rows);
		console.log(header);
		var data = new FormData();
		graphable = false;
		data.append("header", header);
		data.append("rows", rows);
		// for(i=0;i<config.series.length;i++){
			// if(config.series[i].value == colname){
				// graphable = true;
			// }
		// }
		// var request = new XMLHttpRequest();
		// request.onreadystatechange = function () {
			// if (request.readyState === 4) {
				// var results = request.responseText;
				// console.log(results);
				// console.log(request.responseText);
				// grid.config.data[rownb][grid.config.columns[colnb].id] = results;
				// if(config.scales.left.max < results*1.2){
					// config.scales.left.max = results*1.2;
					// //window.location.reload();
				// }
			// }
		// }
		// request.open("POST", "inc.php/parts/send_data.inc.php", true);
		// request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		// request.send(data);	
	}
});

        //
        // $(document).ready(function(){
            // $('.editline').css("display", "none");
            // $('.editbtn').css("display", "none");
            // $('.savebtn').css("display", "none");
			// var hoverelements = "";
			// var clickelements = "";
			// var editing = false;
			// for(i=0;i<4;i++){
				// hoverelements += '#line'+i+', ';
				// clickelements += '#line'+i+' .editbtn, ';
			// }
			// hoverelements = hoverelements.substring(0,hoverelements.length - 2);
			// clickelements = clickelements.substring(0,clickelements.length - 2);
			// $(hoverelements).hover(function(){
				// if(editing == false){
					// $(this).children('.editbtn').css("display", "");
				// }
			// },function(){
				// if(editing == false){
					// $(this).children('.editbtn').css("display", "none");
				// }
			// });
			// $(clickelements).click(function(){
				// if(editing == false){
					// $(this).css("display", "none");
					// $(this).parent().children('.savebtn').css("display", "");
					// $(this).parent().children('.dataline').css("display", "none");
					// $(this).parent().children('.editline').css("display", "");
					// editing = true;
				// }
			// });
			
        // });