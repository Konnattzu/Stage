
window.addEventListener("load", function(){	
	var currenturl = document.location.href;
	currenturl = currenturl.replace(/\/$/, "");
	currentref = currenturl.substring (currenturl.lastIndexOf( "=" )+1 );
	spreadsheet.currentref = currentref;

	var addbtn = document.querySelectorAll("[data-dhx-id = add]")[0];

	menuItems = document.getElementsByClassName("dhx_nav-menu-button");
	menuItems[2].addEventListener("mouseover", function(){ var item = this; delay = setTimeout(function(){ seekMenu(item); }, 100); }, false);
	
	// dispgrid.addEventListener("mousewheel", function(){delay = setTimeout(function(){ init(); }, 100)}, false);
	// document.addEventListener("click", function(){
	// 	console.log(event.target);
	// 	if(!event.target.classList.contains("dhx_string-cell") && !event.target.classList.contains("dhx_grid-comment")){
	// 		target = event.target;
	// 		console.log(target);
	// 		delay = setTimeout(function(){ init(target); }, 100);
	// 	}
	// }, false);
	//addbtn.addEventListener("click", function(){delay = setTimeout(function(){ init(); }, 100)}, false);
	function init(){
		console.log("init");
		rows = document.getElementsByClassName("dhx_grid-row");
		header = document.getElementsByClassName("dhx_grid-header-cell");
		header = Array.from(header);
		header.splice(header.length/2, header.length);
		header.splice(0, 1);
		cells = Array();
		cross = document.querySelectorAll(".remove-button");
		rembtn = Array();
		comment = Array();
		phyl = Array();
		comcontain = Array();
		cellval = Array();
		for(var i=0; i<rows.length; i++){
			comment[i] = Array();
			phyl[i] = Array();
			comcontain[i] = Array();
			cellval[i] = Array();
		}
		
		console.log(spreadsheet);
		function FindAllMethods(obj) {
			return Object.getOwnPropertyNames(obj).filter(function(property) {
				return typeof obj[property] == "function";
			});
		}
		console.log(FindAllMethods(spreadsheet));

		for(var i=0; i<rows.length; i++){
			cells = rows[i].getElementsByClassName("dhx_grid-cell");
			for(var j=1; j<cells.length; j++){
				rows[i][j-1] = cells[j];
			}
			spreadsheet.setRem(cells[0], i);
		}
		console.log(header);
		refillData();
		spreadsheet.initHtml();
		console.log(spreadsheet);
			
			for(var i=0; i<rows.length; i++){
				for(var j=0; j<header.length; j++){
					phyl[i][j] = document.createElement("div");
					phyl[i][j].innerHTML = '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 841.9 1190.6" style="enable-background:new 0 0 841.9 1190.6;" xml:space="preserve">	<style type="text/css"> .st4{fill:#02b5ce;stroke:#000000;stroke-width:3;stroke-miterlimit:10;}  .st4:hover{ fill:#5bcedb;} .st5{fill:none;stroke:#000000;stroke-width:7;stroke-miterlimit:10;}.st0{fill:#fff;stroke:#000000;stroke-width:3;stroke-miterlimit:10;}</style><g><path class="st4" d="M373.5,455.1l200-1c0,0,56.9,4.7,56.9-34s0-173,0-173s2.2-36-33-36c-35.2,0-405.2-0.7-405.2-0.7s-35.7-3.9-35.8,36.1S156,419.1,156,419.1s-4.8,35.7,30.2,36c3.1,0,12.3,7.2,13.6,8.7c32.8,38.6,70.2,192.3,70.2,192.3L373.5,455.1z"/><polyline class="st0" points="186.2,455.1 206.5,455.1 248.2,577.5     "/></g><line id="LFinal1" class="st5" x1="240.5" y1="264.7" x2="545.7" y2="264.7"/><line id="LFinal2" class="st5" x1="240.5" y1="324.8" x2="545.7" y2="324.8"/><line id="LFinal3" class="st5" x1="240.5" y1="384.9" x2="545.7" y2="384.9"/></svg>';
					comcontain[i][j] = document.createElement("div");
					comcontain[i][j].classList.add("dhx_string-cell");
					comcontain[i][j].classList.add("dhx_grid-comcell");
					comcontain[i][j].setAttribute("data-dhx-col-id", header[j].innerText);
					comcontain[i][j].setAttribute("role", "gridcell");
					comcontain[i][j].setAttribute("aria-colindex", j);
					comcontain[i][j].setAttribute("aria-readonly", "false");
					comcontain[i][j].setAttribute("tabindex", "-1");
					comcontain[i][j].appendChild(phyl[i][j]);
					// console.log(phyl[i][j]);
					// console.log(comcontain[i][j]);
					phyl[i][j].addEventListener('click', function(){ comdisp(spreadsheet, i, j); }, false);
				}
			}
			//console.log(rows);
		for(var i=0; i<rows.length; i++){
			for(var j=0; j<header.length; j++){
				rows[i][j].addEventListener("click", function(){ edit(comcontain); }, false);
				
				//rows[i][j].addEventListener("mousedown", function(){ console.log(comcontain[i][j]); edit(comcontain[i][j]); }, false);
				cellval[i][j] = rows[i][j].childNodes[0];
				// console.log(rows[i][j]);
				// console.log(cellval[i][j]);
				if(typeof(cellval[i][j]) != "undefined" && cellval[i][j].nodeName == "#text"){
					var value = cellval[i][j].textContent;
					var newCellVal = document.createElement("div");
					newCellVal.innerText = value;
					rows[i][j].replaceChild(newCellVal, cellval[i][j]);
				}
				if(rows[i][j].childNodes.length < 2){
					if(typeof(rows[i][j].childNodes[0]) != "undefined"){
						if(!rows[i][j].childNodes[0].classList.contains("dhx_grid-comcell")){
							rows[i][j].appendChild(comcontain[i][j]);
						}
						// console.log(rows[i][j].childNodes);
					}else{
						rows[i][j].appendChild(comcontain[i][j]);
					}
				}
			}
		}
	
	// if(typeof(comwindow) != "undefined"){
	// 	comarea = comwindow.getElementsByTagName("TEXTAREA")[0];
	// 	comrownb = comwindow.getAttribute("rowindex");
	// 	comcolnb = comwindow.getAttribute("colindex");
	// 	console.log(comrownb);
	// 	console.log(comcolnb);
	// 	console.log(comarea);
	// 	console.log(target);
	// 	if(!comarea.hasFocus && target != comarea){
	// 		comwindow.focus();
	// 	}
	// }
	}


	function refresh(){
			
	}

	function refillData(){
		console.log(header);
		for(var i=0;i<header.length;i++){
			spreadsheet.setHeader(header[i], i);
		}
		for(var i=0;i<rows.length;i++){
			spreadsheet.setId(rows[i][0], i);
		}
		for(var i=0;i<header.length;i++){
			for(var j=0;j<rows.length;j++){
				spreadsheet.setCell(rows[j][i], i, j);
			}
		}
	}

	/*Gérer le menu*/
	function seekMenu(item){
		clearTimeout(delay);
		addbtn = document.querySelectorAll("[data-dhx-id = add]")[0];
		if(typeof(addbtn) != "null"){
			addbtn.addEventListener("click", function(){delay = setTimeout(function(){ init(); }, 100)}, false);
		}
	}
	
	/*Commentaire*/
	function comhandler(comwindow, spreadsheet, i, j, cover){
		if(event.target.classList.contains("popup-cover")){
			document.removeEventListener("click", function(){  }, false);
			sendcom(comwindow, spreadsheet, i, j, cover);
		}
	}
	
	function comdisp(spreadsheet, i, j){
		event.stopImmediatePropagation();
		console.log(spreadsheet.getCell());
		comt = spreadsheet.getCell()[2][0].comment.value;
		const windowHtml = "<form method='post' action=''><textarea style='min-width:380px; min-height:420px;' tabindex='-1'>"+comt+"</textarea><input type='submit' value='&#9989;'></form>";
		const dhxwindow = new dhx.Window({
			width: 440,
			height: 520,
			title: "Commentaire",
			html: windowHtml
		});
		dhxwindow.show();
		comwindow = dhxwindow._popup;
		comwindow.style.zIndex = "50";
		cover = document.createElement("div"); 
		if(document.body.getElementsByClassName("popup-cover").length == 0){
			cover.classList.add("popup-cover"); 
			document.body.insertBefore(cover, document.body.children[1]); 
		}
		document.addEventListener("click", function(){ comhandler(comwindow, spreadsheet, i, j, cover); }, false);
	}
	
	function sendcom(comwindow, spreadsheet, i, j, cover){
		console.log(comwindow);
		newval = comwindow.firstChild.childNodes[1].firstChild.firstChild.getElementsByTagName("TEXTAREA")[0].value;
		console.log(comwindow.firstChild.childNodes[1].firstChild.firstChild.getElementsByTagName("TEXTAREA")[0]);
		console.log(i);
		console.log(j);
		console.log(spreadsheet.cells[2][0]);
		var data = new FormData();
		data.append("row", spreadsheet.cells[2][0].rowid);
		data.append("column", spreadsheet.cells[2][0].colid);
		data.append("comt", newval);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				console.log(results);
				console.log(request.responseText);
				//init();
			}
		}
		request.open("POST", "inc.php/parts/send_com.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);	
		cover.remove();
		comwindow.remove();
		window.location.reload();
	}

	/*Editer une case*/

	function handler(cell, com, rowid, colname){
		edited(cell, com, rowid, colname);
	}
	
	function edit(comt){
		console.log("edit");
		event.stopImmediatePropagation();
		cell = event.target;
		console.log(cell);
		console.log(comt);
		for(var i=0; i<rows.length; i++){
			for(var j=0; j<header.length; j++){
				rows[i][j].removeEventListener("click", edit, false);
			}
		}
		console.log(this);
		colnb = cell.getAttribute("aria-colindex")-1;
		rownb = cell.parentElement.getAttribute("aria-rowindex")-1;
		rowid = grid.config.data[rownb][grid.config.columns[1].id];
		colname = grid.config.columns[colnb].id;
		com = comt[colnb][rownb];

		cell.addEventListener("keypress", function(){ edited(cell, com, rowid, colname); }, false);
		document.addEventListener("mousedown", function(){ edited(cell, com, rowid, colname); }, false);
		
		cell.removeEventListener("click", function(){ edit(com); }, false);
	}
	
	function edited(cell, com, rowid, colname){
		event.stopImmediatePropagation();
		e = event;
		if (e.key == "Enter"){
			delay = setTimeout(function(){senddata(cell, rowid, colname);}, 100);
			cell.removeEventListener("keypress", handler, false);
			document.removeEventListener("mousedown", handler, false);
			cell.addEventListener("click", edit, false);
		}else if(e.target.parentElement != cell){
			delay = setTimeout(function(){senddata(cell, rowid, colname);}, 100);
			cell.removeEventListener("keypress", handler, false);
			document.removeEventListener("mousedown", handler, false);
			cell.addEventListener("click", edit, false);
		}
		//cell.appendChild(com);
	}
	
	function senddata(cell, rowid, colname){
		clearTimeout(delay);
		console.log(cell);
		console.log(rowid);
		console.log(colname);
		// console.log(el.innerText);
		for(var i=0;i<cell.childNodes.length;i++){
			console.log(cell.childNodes[i]);
			if(cell.childNodes[i].nodeType == 3){
				newtext = cell.childNodes[i].textContent;
			}else if(colname == "sexe"){
				newtext = "M";
			}
		}
		
		// console.log("newtext "+newtext);
		var data = new FormData();
		//graphable = false;
		data.append("row", rowid);
		data.append("column", colname);
		data.append("value", newtext);
		data.append("editplace", currentref);
		console.log(newtext);
		// for(i=0;i<grid.config.columns;i++){
			// if(grid.config.columns[1].id == colname){
				// graphable = true;
			// }
		// }
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				console.log(results);
				console.log(request.responseText);
				grid.config.data[rownb][grid.config.columns[colnb].id] = results;
				if(typeof(config) != "undefined"){
					if(config.scales.left.max < results*1.2){
						config.scales.left.max = results*1.2;
						//window.location.reload();
					}
				}
				init();
			}
		}
		request.open("POST", "inc.php/parts/send_data.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);	
	}

	init();
});
