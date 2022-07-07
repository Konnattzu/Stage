class Spreadsheet {
    constructor(){
        this.currentref = "";
        this.header = new Array();
        this.identifiers = new Array();
        this.rembtn = new Array();
        this.cells = new Array();
        this.html = "";
        this.savebtn = "";
        this.menuItems = new Array();
        this.graph;
    }
    
    //Remplissage des données du tableau
    initData(){
        console.log("init");
        console.log(this);
        var that = this;
        var rows = document.getElementsByClassName("dhx_grid-row");
		var header = document.getElementsByClassName("dhx_grid-header-cell");
		header = Array.from(header);
		header.splice(header.length/2, header.length);
		header.splice(0, 1);
		var cells = Array();
        for(var i=0; i<rows.length; i++){
            cells[i] = Array();
			for(var j=0; j<header.length; j++){
				cells[i][j] = rows[i].getElementsByClassName("dhx_grid-cell")[j];
			}
            that.setRem(cells[i][0], i); 
		}
        for(var i=0;i<header.length;i++){
			that.setHeader(header[i], i);
		}
		for(var i=0;i<rows.length;i++){
			that.setId(cells[i][2], i);
		}
		for(var i=0;i<rows.length;i++){
			for(var j=0;j<header.length;j++){
				that.setCell(cells[i][j+1], i, j);
			}
		}
        var that = this;
        var delay = setTimeout(function(){ clearTimeout(delay); that.initHtml(); }, 100);
    }
    dataFill(dataArray){
        for(var i=0;i<dataArray.header.length;i++){
            this.header[i] = new Header();
            this.header[i].setValue(dataArray.header[i].value);
            this.header[i].setNumb(dataArray.header[i].headnumb);
            this.header[i].setType(dataArray.column[i].datatype);
            this.header[i].setLen(dataArray.column[i].datalength);
        }
        for(var i=0;i<dataArray.identifier.length;i++){
            this.identifiers[i] = new Identifier();
            this.identifiers[i].setValue(dataArray.identifier[i].value);
            this.identifiers[i].setNumb(dataArray.identifier[i].rownumb);
        }
        for(var i=0;i<this.identifiers.length;i++){
            this.cells[i] = new Array();
            for(var j=0;j<this.header.length;j++){
                this.cells[i][j] = new Cell();
                this.cells[i][j].setValue(dataArray.cells[j][i].value);
                this.cells[i][j].setType(this.header[j].getType());
                this.cells[i][j].setLen(this.header[j].getLen());
                this.cells[i][j].setRownumb(dataArray.cells[j][i].rownumb);
                this.cells[i][j].setColnumb(dataArray.cells[j][i].colnumb);
                this.cells[i][j].setRowid(dataArray.cells[j][i].rowid);
                this.cells[i][j].setColid(dataArray.cells[j][i].colid);
                this.cells[i][j].initCom();
            }
        }
        this.graph = new Graph(dataArray.graph);
    }

    //Définition des éléments html
    initHtml(){
        var that = this;
        //Tableau
        this.html = document.getElementsByClassName("dhx_grid_data")[0];
        // var table = that.html.parentElement.parentElement.parentElement;
        // table.addEventListener("click", function(){ var delay = setTimeout(function(){ clearTimeout(delay);	that.initData(); }, 100); }, false);
        // table.addEventListener("mouseup", function(){ var delay = setTimeout(function(){ clearTimeout(delay);	that.initData(); }, 100); }, false);
        // table.addEventListener("scroll", function(){ var delay = setTimeout(function(){ clearTimeout(delay);	that.initData(); }, 100); }, false);
        //Bouton de sauvegarde
        this.savebtn = document.getElementById("savetable");
        // if(typeof(this.savebtn) != 'undefined' && this.savebtn != null){
        //     this.savebtn.addEventListener("click", function(){that.sendTable();}, false);
        // }
        //En-têtes
        for(var i=0;i<(document.getElementsByClassName("dhx_grid-header-cell").length/2);i++){
            this.header[i].setHtml(document.getElementsByClassName("dhx_grid-header-cell")[i+1]);
        }
        //Identifiants
        for(var i=0;i<this.identifiers.length;i++){
            this.identifiers[i].setHtml(this.html.getElementsByClassName("dhx_grid-cell")[(i*(this.header.length)-i)+2]);
        }
        //Cellules
        var delay = setTimeout(function(){
            clearTimeout(delay);
            for(var i=0;i<that.identifiers.length;i++){
                var row = that.html.querySelectorAll('[aria-rowindex = "'+(i+1)+'"]')[0];
                if(typeof(row) != "undefined"){
                    for(var j=0;j<that.header.length;j++){
                        if(typeof(row.querySelectorAll('[aria-colindex = "'+(j+2)+'"]')[0]) != "undefined"){
                            that.cells[i][j].setHtml(row.querySelectorAll('[aria-colindex = "'+(j+2)+'"]')[0]);
                            if(that.cells[i][j].comment.html == ""){
                                that.cells[i][j].comment.initHtml(that.cells[i][j].colnumb);
                            }
                            if(typeof(that.cells[i][j].html) != "undefined"){
                                that.cells[i][j].html.appendChild(that.cells[i][j].comment.html);
                            }
                            that.cells[i][j].initColor();
                        }
                    }
                }
            }
        }, 100);
        //Menu
        var items = document.getElementsByClassName("dhx_nav-menu-button");
        for(var i = 0;i<items.length;i++){
            this.menuItems[i] = new MenuItem(items[i], items[i].getAttribute("data-dhx-id"), 0, this);
        }
		console.log(this);
        if(typeof(scrolling) == "undefined"){
            var scrolling = false;
        }
        var that = this;
        var gridBody = document.getElementsByClassName("dhx_grid-body")[0];
        console.log(gridBody);
        gridBody.addEventListener('scroll', (event) => {
                if(scrolling == false){
                    that.initHtml();
                    scrolling = true;
                    delay = setTimeout(function(){ clearTimeout(delay); scrolling = false; }, 1000);
                }
            }, 
            { passive: true }
        );
    }

    //En-têtes du tableau
    setHeader(header, pos){
        if(typeof(this.header[pos]) == "undefined"){
            this.header[pos] = new Header;
        }
        if(typeof(header) != "undefined"){
            this.header[pos].setValue(header.innerText);
            this.header[pos].setNumb(pos);
            this.header[pos].setHtml(header);
        }
    }
    getHeader(){
        return this.header;
    }

    //Identifiants du tableau
    setId(identifier, pos){
        if(typeof(this.identifiers[pos]) == "undefined"){
            this.identifiers[pos] = new Identifier();
        }
        if(typeof(identifier) != "undefined"){
            console.log(identifier.innerText);
            this.identifiers[pos].setValue(identifier.innerText);
            this.identifiers[pos].setNumb(pos);
            this.identifiers[pos].setHtml(identifier);
        }
    }
    getId(){
        return this.identifiers;
    }

    //Bouton de suppression
    setRem(html, pos){
        var that = this;
        this.rembtn[pos] = html;
        this.rembtn[pos].addEventListener("click", function(){ that.remRow(pos); }, false);
    }
    getRem(){
        return this.rembtn;
    }
    remRow(row){
        var that = this;
        var rowid = this.identifiers[row].value;
        var colid = this.header[1].value;
		var data = new FormData();
		data.append("row", rowid);
		data.append("idcolumn", colid);
		data.append("editplace", this.currentref);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				console.log(results);
				console.log(request.responseText);
                that.initHtml();
            }
		}
		request.open("POST", "inc.php/parts/delete_data.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);
    }

    //Sauvegarde du tableau
    setSave(html){
        this.savebtn = html;
    }
    getSave(){
        return this.savebtn;
    }
    sendTable(savebtn){
        var that = this;
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

    //Cellules du tableau
    setCell(cell, row, col){
        if(typeof(this.cells[row]) == "undefined"){
            this.cells[row] = new Array();
        }
        if(typeof(this.cells[row][col]) == "undefined"){
            this.cells[row][col] = new Cell();
        }
        if(typeof(cell) != "undefined"){
            this.cells[row][col].setValue(cell.innerText);
            this.cells[row][col].setHtml(cell);
            this.cells[row][col].setPlace(this.currentref);
        }
        this.cells[row][col].initCom();
    }
    getCell(){
        return this.cells;
    }

    initGraph(){

    }
    setGraph(graph, type){
        this.graph[type] = graph;
    }
    getGraph(){
        return this.graph;
    }
}