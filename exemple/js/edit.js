
window.addEventListener("load", function(){
	dispgrid = document.getElementsByClassName("dhx_grid_data")[0];
	tabbody = document.getElementsByClassName("dhx_grid-body")[0];
	savebtn = document.getElementById("savetable");
	
	var currenturl = document.location.href;
	currenturl = currenturl.replace(/\/$/, "");
	currentref = currenturl.substring (currenturl.lastIndexOf( "=" )+1 );
	
	var addbtn = document.querySelectorAll("[data-dhx-id = add]")[0];
	
	
	init();
	
	if(typeof(savebtn) != 'undefined' && savebtn != null){
		savebtn.addEventListener("click", function(){delay = setTimeout(function(){sendtable();}, 120);}, false);
	}
	
	dispgrid.addEventListener("mousewheel", function(){delay = setTimeout(function(){ init(); }, 100)}, false);
	tabbody.addEventListener("click", function(){
		console.log(event.target);
		if(!event.target.classList.contains("dhx_string-cell") && !event.target.classList.contains("dhx_grid-comment")){
			delay = setTimeout(function(){ init(); }, 100)
		}
	}, false);
	addbtn.addEventListener("click", function(){delay = setTimeout(function(){ init(); }, 100)}, false);
	
	
	
	
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
					comment[i][j].style.display = "none";
					comment[i][j].addEventListener("click", comedit, false);
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
					console.log(rows[i][j].getBoundingClientRect().left);
					comcontain[i][j].style.left =  (rows[i][j].getBoundingClientRect().left+window.scrollX)+"px";
					comcontain[i][j].style.top =  40*i+5+"px";
					comcontain[i][j].appendChild(phyl[i][j]);
					// console.log(phyl[i][j]);
					// console.log(comcontain[i][j]);
					comcontain[i][j].appendChild(comment[i][j]);
					phyl[i][j].addEventListener('click', comdisp, false);
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
				for(var i=0; i<comment.length; i++){
					for(var j=0; j<comment[i].length; j++){
						if(typeof(results[i]) != "undefined" && typeof(results[i][j]) != "undefined" && results[i][j] != null){
							comment[i][j].innerText = "*"+(i*j)+" //"+results[i][j];
						}
					}
				}
				
			}
		}
		request.open("POST", "inc.php/parts/comment.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);
	}
	
	function comdisp(){
		  const windowHtml = "<form method='post' action=''><textarea style='min-width:380px; min-height:420px;' tabindex='-1'></textarea><input type='submit' value='&#9989;'></form>";
    const dhxwindow = new dhx.Window({
        width: 440,
        height: 520,
        title: "Commentaire",
        html: windowHtml
	});

    dhxwindow.show();
	comwindow = document.getElementsByClassName("dhx_popup--window")[0];
	console.log(comwindow);
    comwindow.addEventListener("focusout", function(){ comwindow.remove(); }, false);
	
		var cell = this.parentElement;
		event.stopPropagation();
		colnb = cell.getAttribute("aria-colindex");
		rownb = cell.parentElement.getAttribute("aria-rowindex")-1;
		console.log(comment[rownb][colnb]);
		console.log(comment[rownb][colnb].style.display);
		if(comment[rownb][colnb].style.display == "block"){
			console.log("disappear");
			comment[rownb][colnb].style.display = "none";
			cell.style.background = "none";
		}else if(comment[rownb][colnb].style.display == "none"){
			console.log("appear");
			comment[rownb][colnb].style.display = "block";
			cell.style.background = "#ededed";
		}
	}
	
	/*Editer un commentaire*/
	
	function comhandler(){
		console.log("edited");
		comedited(event, inptcom);
	}
	
	function comedit(){
		console.log("edit");
		comt = this;
		comtxt = comt.innerText;
		inptcom = document.createElement("input");
		inptcom.setAttribute("type", "text");
		inptcom.setAttribute("value", comtxt);
		comt.parentElement.replaceChild(inptcom, comt);

		inptcom.addEventListener("keypress", comhandler, false);
		document.addEventListener("mousedown", comhandler, false);
	}
	
	function comedited(event, inptcom){
		event.stopImmediatePropagation();
		e = event;
		if (e.key == "Enter"){
			delay = setTimeout(function(){sendcom(e.path[1]);}, 1);
			inptcom.removeEventListener("keypress", comhandler, false);
			document.removeEventListener("mousedown", comhandler, false);
		}else if(e.target.parentElement != inptcom){
			delay = setTimeout(function(){sendcom(inptcom);}, 1);
			inptcom.removeEventListener("keypress", comhandler, false);
			document.removeEventListener("mousedown", comhandler, false);
		}
	}
	
	function sendcom(el){
		clearTimeout(delay);
		newtext = el.innerText;
		// var rowid = ;
		// var colname = ;
		// console.log(el.parentElement);
		// var data = new FormData();
		// data.append("row", rowid);
		// data.append("column", colname);
		// var request = new XMLHttpRequest();
		// request.onreadystatechange = function () {
			// if (request.readyState === 4) {
				// var results = request.responseText;
				// console.log(results);
				// console.log(request.responseText);
				// grid.config.data[rownb][grid.config.columns[colnb].id] = results;
				// if(typeof(config) != "undefined"){
					// if(config.scales.left.max < results*1.2){
						// config.scales.left.max = results*1.2;
						// //window.location.reload();
					// }
				// }
				// init();
			// }
		// }
		// request.open("POST", "inc.php/parts/send_data.inc.php", true);
		// request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		// request.send(data);	
	}

	/*Editer une case*/

	function handler(){
		edited(event, cell);
	}
	
	function edit(){
		console.log("edit");
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
		//graphable = false;
		data.append("row", rowid);
		data.append("column", colname);
		data.append("idcolumn", colid);
		data.append("value", newtext);
		data.append("editplace", currentref);
		console.log(currentref);
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
	
	/*Supprimer une rangée*/
	
	function remrow(){
		rownb = event.target.parentElement.parentElement.parentElement.parentElement.getAttribute("aria-rowindex")-1;
		rowid = grid.config.data[rownb][grid.config.columns[1].id];
		colid = grid.config.columns[1].id;
		console.log(rowid);
		console.log(colid);
		var data = new FormData();
		data.append("row", rowid);
		data.append("idcolumn", colid);
		data.append("editplace", currentref);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				console.log(results);
				console.log(request.responseText);
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
