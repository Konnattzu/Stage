
window.addEventListener("load", function(){
	dispgrid = document.getElementsByClassName("dhx_grid_data")[0];
	tabbody = document.getElementsByClassName("dhx_grid-body")[0];
	savebtn = document.getElementById("savetable");
	
	var currenturl = document.location.href;
	currenturl = currenturl.replace(/\/$/, "");
	currentref = currenturl.substring (currenturl.lastIndexOf( "=" )+1 );
	
	var editbtn = document.querySelectorAll("[data-dhx-id = edit]")[0];
	
	
	
	console.log(editbtn);
	
	init();
	
	if(typeof(savebtn) != 'undefined' && savebtn != null){
		savebtn.addEventListener("click", function(){delay = setTimeout(function(){sendtable();}, 120);}, false);
	}
	
	dispgrid.addEventListener("mousewheel", function(){delay = setTimeout(function(){ init(); }, 100)}, false);
	tabbody.addEventListener("click", function(){delay = setTimeout(function(){ init(); }, 100)}, false);
	if(typeof(editbtn) != 'undefined' && editbtn != null){
		editbtn.addEventListener("mouseenter", function(){delay = setTimeout(function(){
			var addbtn = document.querySelectorAll("[data-dhx-id = add]")[0];
			console.log('add');
			addbtn.addEventListener("click", newrow, false);
		}, 100);}, false);
	}
		
	// editbtn.addEventListener("mouseleave", function(){
		// var addbtn = document.querySelectorAll("[data-dhx-id = add]")[0];
		// console.log('rem');
		// addbtn.removeEventListener("click", newrow, false);
		// }, false);
	
	function newrow(){
		delay = setTimeout(function(){init();}, 100); 
		addbtn.removeEventListener("click", newrow, false);
		console.log("oui");
	}
	
	
	
	
	function init(){
		if(typeof(delay) != 'undefined' && delay != null){
			clearTimeout(delay);
		}
		
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
		for(var i=0; i<rows.length; i++){
			comment[i] = Array();
			phyl[i] = Array();
			comcontain[i] = Array();
		}
		
		for(var i=0; i<rows.length; i++){
			cells = rows[i].getElementsByClassName("dhx_grid-cell");
			for(var j=1; j<cells.length; j++){
				rows[i][j-1] = cells[j];
			}
		}
			
			for(var i=0; i<rows.length; i++){
				for(var j=0; j<header.length; j++){
					comment[i][j] = document.createElement("div");
					comment[i][j].innerText =  "*"+(i*header.length+j);
					comment[i][j].classList.add("dhx_grid-comment");
					phyl[i][j] = document.createElement("img");
					phyl[i][j].setAttribute("src", "images/bulle.svg");
					phyl[i][j].setAttribute("alt", "o");
					comcontain[i][j] = document.createElement("div");
					comcontain[i][j].classList.add("dhx_string-cell");
					comcontain[i][j].classList.add("dhx_grid-comcell");
					comcontain[i][j].setAttribute("data-dhx-col-id", header[j].innerText);
					comcontain[i][j].setAttribute("role", "gridcell");
					comcontain[i][j].setAttribute("aria-colindex", j);
					comcontain[i][j].setAttribute("aria-readonly", "false");
					comcontain[i][j].setAttribute("tabindex", "-1");
					comcontain[i][j].style.left =  80*(j+1)+40+"px";
					comcontain[i][j].style.top =  40*i+5+"px";
					comcontain[i][j].appendChild(phyl[i][j]);
					comcontain[i][j].appendChild(comment[i][j]);
					comcontain[i][j].addEventListener('click', comdisp, false);
				}
			}
				
		for(var i=0; i<rows.length; i++){
			for(var j=0; j<header.length; j++){
				rows[i][j].addEventListener("click", edit, false);
			}
		}
		oldChild = Array();
		for(var i=0; i<rows.length; i++){
			oldChild[i] = Array();
			for(var j=0; j<header.length; j++){
				oldChild[i][j] = rows[i][j].parentElement.childNodes[header.length+j+1];
			}
		}
		for(var i=0; i<rows.length; i++){
			for(var j=0; j<header.length; j++){
				rows[i][j].parentElement.appendChild(comcontain[i][j]);
				if(typeof(oldChild[i][j]) != "undefined" && oldChild[i][j] != null){
					if(oldChild[i][j].classList.contains("dhx_grid-comcell")){
						rows[i][j].parentElement.removeChild(oldChild[i][j]);
					}
				}
			}
		}
					
	
		
		for(var i=0; i<cross.length;i++){
			rembtn[i] = cross[i].parentElement.parentElement;
			rembtn[i].addEventListener("click", remrow, false);
		}
		
		comments(header, rows);
		
		if(rows.length>0){
			colortype(rows);
		}
	}
	
	/*Afficher les commentaires*/
	
	function comments(header, rows){
		headval = Array();
		rowval = Array();
		for(var i=0;i<header.length;i++){
			headval[i] = header[i].innerText;
		}
		for(var j=0;j<rows.length;j++){
		rowval[j] = Array();
			for(var i=0;i<header.length;i++){
				rowval[j][i] = rows[j][i].innerText;
			}	
		}
		
		var data = new FormData();
		data.append("header", JSON.stringify(headval));
		data.append("rows", JSON.stringify(rowval));
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = JSON.parse(request.responseText);
				console.log(results);
				for(var i=0; i<comment.length; i++){
					for(var j=0; j<comment[i].length; j++){
						note = document.getElementById(i+'_'+j);
						if(typeof(results[i]) != "undefined" && typeof(results[i][j]) != "undefined" && results[i][j] != null){
							comment[i][j].innerText = "*"+(i*j)+" //"+results[i][j];
						}
						note.style.color = "grey";
					}
				}
				
			}
		}
		request.open("POST", "inc.php/parts/comment.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);
	}
	
	function comdisp(){
		cell = this;
		console.log(cell.parentElement);
		event.stopPropagation();
		colnb = cell.getAttribute("aria-colindex");
		rownb = cell.parentElement.getAttribute("aria-rowindex")-1;
		console.log(rownb);
		console.log(colnb);
		comment[rownb][colnb].style = "display: inline;";
		console.log(comment);
		console.log(comcontain[colnb][rownb]);
		console.log(comment[colnb][rownb]);
	}

	/*Editer une case*/

	function handler(){
		edited(event, cell);
	}
	
	function edit(){
		cell = this;
		for(var i=0; i<rows.length; i++){
			for(var j=0; j<header.length; j++){
				rows[i][j].removeEventListener("click", edit, false);
			}
		}
		colnb = cell.getAttribute("aria-colindex")-1;
		rownb = cell.parentElement.getAttribute("aria-rowindex")-1;
		rowid = grid.config.data[rownb][grid.config.columns[1].id];
		colname = grid.config.columns[colnb].id;
		colid = grid.config.columns[1].id;

		cell.addEventListener("keypress", handler, false);
		document.addEventListener("mousedown", handler, false);
		
		cell.removeEventListener("click", edit, false);
	}
	
	function edited(event, cell){
		event.stopImmediatePropagation();
		e = event;
		if (e.key == "Enter"){
			delay = setTimeout(function(){senddata(e.path[1]);}, 1);
			cell.removeEventListener("keypress", handler, false);
			document.removeEventListener("mousedown", handler, false);
			cell.addEventListener("click", edit, false);
		}else if(e.target.parentElement != cell){
			delay = setTimeout(function(){senddata(cell);}, 1);
			cell.removeEventListener("keypress", handler, false);
			document.removeEventListener("mousedown", handler, false);
			cell.addEventListener("click", edit, false);
		}
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
		console.log(currentref);
		for(i=0;i<grid.config.columns;i++){
			if(grid.config.columns[1].id == colname){
				graphable = true;
			}
		}
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
	
	/*Supprimer une rangée*/
	
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
	
	/*Sauvegarder le tableur*/
	
	function sendtable(){
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				savebtn.innerText = "Sauvegardé";
				console.log(results);
			}
		}
		request.open("POST", "inc.php/parts/send_table.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send();	
	}
});
