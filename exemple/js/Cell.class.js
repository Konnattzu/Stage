class Cell {
    constructor(){
        this.value = "";
        this.datatype = "";
        this.datalength = 0;
        this.rownumb = 0;
        this.colnumb = 0;
        this.rowid = "";
        this.colid = "";
        this.html = "";
        this.comment = new Comment();
        this.color = "";
        this.editplace = "";
    }

    setValue(value){
        this.value = value;
    }
    getValue(){
        return this.value;
    }

    setType(value){
        this.datatype = value;
    }
    getType(){
        return this.datatype;
    }

    setLen(value){
        this.datalength = value;
    }
    getLen(){
        return this.datalength;
    }

    setRownumb(numb){
        this.rownumb = numb;
    }
    getRownumb(){
        return this.rownumb;
    }

    setColnumb(numb){
        this.colnumb = numb;
    }
    getColnumb(){
        return this.colnumb;
    }

    setRowid(value){
        this.rowid = value;
    }
    getRowid(){
        return this.rowid;
    }

    setColid(value){
        this.colid = value;
    }
    getColid(){
        return this.colid;
    }

    initColor(){
        switch(this.datatype){
            case "varchar":
                this.color = "red";
            break;
            case "int":
                this.color = "blue";
            break;
            case "date":
                this.color = "green";
            break;
        }
        if(typeof(this.html) != "undefined"){
            this.html.style.color = this.color;
        }
    }
    setColor(color){
        this.color = color;
        if(typeof(this.html) != "undefined"){
            this.html.style.color = this.color;
            console.log(this.html);
            console.log(this.html.style.color);
        }
    }
    getColor(){
        return this.color;
    }

    setHtml(html){
        this.html = html;
        if(typeof(this.html) != "undefined"){
            var that = this;
            this.html.addEventListener("dblclick", function(){ that.editCell(that); }, false);
            this.html.addEventListener("click", function(){ that.remCom(that); }, false);
        }
    }
    getHtml(){
        return this.html;
    }

    initCom(){
        this.comment.setColid(this.colid);
        this.comment.setRowid(this.rowid);
        this.comment.initValue();
    }
    setCom(comment){
        this.comment = comment;
    }
    getCom(){
        return this.comment;
    }

    editCell(that){
        console.log("edit");
		var that = this;
		//event.stopImmediatePropagation();
        var delay = setTimeout(function(){
            clearTimeout(delay);  
            that.html.addEventListener("keypress", function(){ that.edited(that); }, false);
		    that.html.addEventListener("focusout", function(){ that.edited(that); }, false); 
        }, 100);
		
		that.html.removeEventListener("dblclick", function(){ that.editCell(that); }, false);
		that.html.removeEventListener("click", function(){ that.remCom(that); }, false);
    }
    sendCell(that){
        var newtext = "";
		for(var i=0;i<that.html.childNodes.length;i++){
			if(that.html.childNodes[i].nodeType == 3){
				newtext = that.html.childNodes[i].textContent;
			}else if(that.colid == "sexe"){
				newtext = "M";
			}
		}
		var data = new FormData();
		data.append("row", that.rowid);
		data.append("column", that.colid);
		data.append("value", newtext);
        console.log(that.editplace);
		data.append("editplace", that.editplace);
		//graphable = false;
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
				// grid.config.data[rownb][grid.config.columns[colnb].id] = results;
				// if(typeof(config) != "undefined"){
				// 	if(config.scales.left.max < results*1.2){
				// 		config.scales.left.max = results*1.2;
				// 		//window.location.reload();
				// 	}
				// }
				//init();
			}
		}
		request.open("POST", "inc.php/parts/send_data.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);	
    }
    edited(that){
        event.stopImmediatePropagation();
		var e = event;
		if (e.code == "Enter"){
            console.log("edited");
			var delay = setTimeout(function(){ clearTimeout(delay); that.sendCell(that); }, 100);
			that.html.removeEventListener("keypress", function(){ that.edited(that); }, false);
			that.html.removeEventListener("focusout", function(){ that.edited(that); }, false);
			that.html.addEventListener("dblclick", function(){ that.editCell(that); }, false);
			that.html.addEventListener("click", function(){ that.remCom(that); }, false);
            that.html.appendChild(that.comment.html);
		}else if(e.target.parentElement != that.html){
            console.log("edited");
			var delay = setTimeout(function(){ clearTimeout(delay); that.sendCell(that); }, 100);
			that.html.removeEventListener("keypress", function(){ that.edited(that); }, false);
			that.html.removeEventListener("focusout", function(){ that.edited(that); }, false);
			that.html.addEventListener("dblclick", function(){ that.editCell(that); }, false);
			that.html.addEventListener("click", function(){ that.remCom(that); }, false);
            that.html.appendChild(that.comment.html);
		}
    }
    remCom(that){
        that.comment.html.remove();
    }
    
    setPlace(place){
        this.editplace = place;
        console.log(this.editplace);
    }
    getPlace(){
        return this.editplace;
    }
}