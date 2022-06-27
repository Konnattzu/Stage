class Spreadsheet {
    constructor(){
        this.currentref = "";
        this.header = new Array();
        this.identifiers = new Array();
        this.rembtn = new Array();
        this.cells = new Array();
        this.html = "";
        this.savebtn = "";
        this.menuItems = Array();
    }
    
    //Remplissage des données du tableau
    dataFill(dataArray){
        for(var i=0;i<dataArray.header.length;i++){
            this.header[i] = new Header();
            this.header[i].setValue(dataArray.header[i].value);
            this.header[i].setNumb(dataArray.header[i].headnumb);
            this.header[i].setHtml(document.getElementsByClassName("dhx_grid-header-cell")[i]);
        }
        for(var i=0;i<dataArray.identifier.length;i++){
            this.identifiers[i] = new Identifier();
            this.identifiers[i].setValue(dataArray.identifier[i].value);
            this.identifiers[i].setNumb(dataArray.identifier[i].rownumb);
            this.identifiers[i].setHtml(document.getElementsByClassName("dhx_grid-cell")[i+this.header.length]);
        }
        for(var i=0;i<this.header.length;i++){
            this.cells[i] = new Array();
            for(var j=0;j<this.identifiers.length;j++){
                this.cells[i][j] = new Cell();
                this.cells[i][j].setValue(dataArray.cells[i][j].value);
                this.cells[i][j].setType(dataArray.cells[i][j].datatype);
                this.cells[i][j].setLen(dataArray.cells[i][j].datalength);
                this.cells[i][j].setRownumb(dataArray.cells[i][j].rownumb);
                this.cells[i][j].setColnumb(dataArray.cells[i][j].colnumb);
                this.cells[i][j].setRowid(dataArray.cells[i][j].rowid);
                this.cells[i][j].setColid(dataArray.cells[i][j].colid);
                this.cells[i][j].initCom();
            }
        }
    }

    //Définition des éléments html
    initHtml(){
        this.html = document.getElementsByClassName("dhx_grid_data")[0];
        this.savebtn = document.getElementById("savetable");
        if(typeof(this.savebtn) != 'undefined' && this.savebtn != null){
            var that = this;
            this.savebtn.addEventListener("click", function(){that.sendTable();}, false);
        }
        for(var i=1;i<(document.getElementsByClassName("dhx_grid-header-cell").length)/2;i++){
            this.header[i].setHtml(document.getElementsByClassName("dhx_grid-header-cell")[i]);
        }
        for(var i=0;i<this.identifiers.length;i++){
            this.identifiers[i].setHtml(document.getElementsByClassName("dhx_grid-cell")[i+this.header.length]);
        }
        for(var i=0;i<this.identifiers.length;i++){
            var row = this.html.querySelectorAll("[aria-rowindex = '"+(i+1)+"']")[0];
            console.log(row);
            for(var j=0;j<this.header.length;j++){
                console.log(this.cells[j][i].value);
                console.log(row.querySelectorAll("[aria-colindex = '"+(j+2)+"']")[0]);
                this.cells[j][i].setHtml(row.querySelectorAll("[aria-colindex = '"+(j+2)+"']")[0]);
                // console.log(this.cells[j][i].getHtml().getElementsByClassName("dhx_grid-comcell")[0]);
                // this.cells[j][i].comment.setHtml(this.cells[j][i].getHtml().getElementsByClassName("dhx_grid-comcell")[0]);
                this.cells[j][i].initColor();
            }
        }
    }

    //En-têtes du tableau
    setHeader(header, pos){
        if(typeof(this.header[pos]) == "undefined"){
            this.header[pos] = new Header;
        }
        this.header[pos].setValue(header.innerText);
        this.header[pos].setNumb(pos);
        this.header[pos].setHtml(header);
    }
    getHeader(){
        return this.header;
    }

    //Identifiants du tableau
    setId(identifier, pos){
        if(typeof(this.identifiers[pos]) == "undefined"){
            this.identifiers[pos] = new Identifier();
        }
        this.identifiers[pos].setValue(identifier.innerText);
        this.identifiers[pos].setNumb(pos);
        this.identifiers[pos].setHtml(identifier);
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
        var rowid = this.identifiers[row].value;
        var colid = this.header[0].value;
		console.log(rowid);
		console.log(colid);
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
				init();
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
    sendTable(){
        var that = this;
        var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				that.savebtn.innerText = "Sauvegardé";
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
        this.cells[row][col].setValue(cell.innerText);
        this.cells[row][col].setHtml(cell);
        this.cells[row][col].initCom();
    }
    getCell(){
        return this.cells;
    }
}