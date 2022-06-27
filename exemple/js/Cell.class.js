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
            console.log(this.html);
            console.log(this.html.style.color);
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
    }
    getHtml(){
        return this.html;
    }

    initCom(){
        this.comment.setColid(this.colid);
        this.comment.setRowid(this.rowid);
        this.comment.initValue();
        this.comment.setHtml(document.getElementsByClassName("dhx_grid-comcell")[this.rownumb*this.colnumb]);
    }
    setCom(comment){
        this.comment = comment;
    }
    getCom(){
        return this.comment;
    }
}